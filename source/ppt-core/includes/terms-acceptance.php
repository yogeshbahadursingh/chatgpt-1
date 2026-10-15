<?php
/** Opt-in acceptance of an explicitly approved policy using WooCommerce's Blocks API. */
defined('ABSPATH') || exit;

function ppt_terms_approval() {
 $config=get_option('ppt_terms_acceptance',array());
 if(!is_array($config)||empty($config['enabled']))return null;
 $page=get_post(absint($config['page_id']??0));
 if(!$page||$page->post_type!=='page'||$page->post_status!=='publish'||$page->post_password||empty($config['approved'])||empty($config['version'])||empty($config['sha256'])||preg_match('/\{\{.*?\}\}/s',$page->post_content)||get_post_meta($page->ID,'_ppt_review_required',true)||absint(get_option('woocommerce_terms_page_id'))!==$page->ID)return false;
 $hash=hash('sha256',$page->post_content);
 if(!hash_equals($hash,(string)$config['sha256']))return false;
 $config['field_id']='ppt/terms-'.substr(hash('sha256',$hash.'|'.$config['version']),0,16);
 return $config;
}

add_action('woocommerce_init',function(){
 $approval=ppt_terms_approval();
 if(!$approval||!function_exists('woocommerce_register_additional_checkout_field'))return;
 woocommerce_register_additional_checkout_field(array(
  'id'=>$approval['field_id'],'label'=>sprintf('I accept the Terms and Conditions (version %s).',$approval['version']),
  'location'=>'order','type'=>'checkbox','required'=>true,
  'error_message'=>'Please read and accept the Terms and Conditions for this order.',
  // Woo's field validator receives wc_clean() output; the raw Store API check below stays boolean.
  'validate_callback'=>function($value){if(!in_array($value,array(true,1,'1'),true))return new WP_Error('ppt_terms_required','Please read and accept the Terms and Conditions for this order.');},
  'show_in_order_confirmation'=>true,
 ));
});

// These hooks run on the Store API path, including requests that bypass browser validation.
add_action('woocommerce_store_api_checkout_update_order_from_request',function($order,$request){
 $approval=ppt_terms_approval();
 if($approval===null)return;
 if(!$approval||!function_exists('woocommerce_register_additional_checkout_field'))throw new \Automattic\WooCommerce\StoreApi\Exceptions\RouteException('ppt_terms_unavailable','Checkout is unavailable while the purchase terms are reviewed.',400);
 if($request->get_method()!=='POST')return;
 $fields=$request->get_param('additional_fields');
 if(!is_array($fields)||($fields[$approval['field_id']]??false)!==true)throw new \Automattic\WooCommerce\StoreApi\Exceptions\RouteException('ppt_terms_required','Please read and accept the current Terms and Conditions for this order.',400);
},10,2);

add_action('woocommerce_store_api_checkout_order_processed',function($order){
 $approval=ppt_terms_approval();if(!$approval)return;
 if(!$order->get_meta('_wc_other/'.$approval['field_id'],true))return;
 // Keep the first accepted version for an order; a payment retry must not rewrite its history.
 if($order->get_meta('_ppt_terms_acceptance',true))return;
 $order->update_meta_data('_ppt_terms_acceptance',array('accepted'=>true,'version'=>$approval['version'],'page_id'=>(int)$approval['page_id'],'url'=>get_permalink($approval['page_id']),'content_sha256'=>$approval['sha256'],'accepted_at_utc'=>gmdate('c'),'source'=>'woocommerce-store-api'));
 $order->save();
});

// This candidate supports the actual block checkout, not a silently different shortcode flow.
add_action('woocommerce_after_checkout_validation',function($data,$errors){if(ppt_terms_approval()!==null)$errors->add('ppt_terms_checkout_type','This checkout configuration requires the approved block checkout.');},10,2);

// A review draft cannot accidentally become a public page through the editor or REST API.
add_filter('wp_insert_post_data',function($data,$postarr){
 if(!empty($postarr['ID'])&&get_post_meta($postarr['ID'],'_ppt_review_required',true)&&in_array($data['post_status'],array('publish','future'),true))$data['post_status']='draft';
 return $data;
},10,2);
