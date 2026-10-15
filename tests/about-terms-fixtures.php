<?php
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Isolated local site only.');
$root=dirname(__DIR__);$file=$root.'/runtime/about-terms/private.json';$mode=getenv('PPT_TERMS_MODE')?:'prepare';
if($mode==='prepare'){
 if(file_exists($file))WP_CLI::error('Previous fixture needs cleanup.');
 if(!has_filter('pre_wp_mail')||!file_exists(WPMU_PLUGIN_DIR.'/qa-no-mail.php'))WP_CLI::error('Mail interception required.');
 $options=array();foreach(array('ppt_terms_acceptance','woocommerce_terms_page_id')as $key)$options[$key]=get_option($key,null);
 wp_set_current_user(1);$token=WP_Session_Tokens::get_instance(1)->create(time()+3*HOUR_IN_SECONDS);
 $policy=wp_insert_post(array('post_type'=>'page','post_status'=>'publish','post_title'=>'Local checkout acceptance test policy','post_name'=>'local-terms-acceptance-fixture','post_content'=>'<!-- wp:paragraph --><p>Local QA policy only. Version QA-2026-10-15. No real purchase, payment or legal approval is represented by this fixture.</p><!-- /wp:paragraph -->'));
 $config=array('enabled'=>true,'approved'=>true,'page_id'=>$policy,'version'=>'QA-2026-10-15','sha256'=>hash('sha256',get_post_field('post_content',$policy)));
 update_option('woocommerce_terms_page_id',$policy);update_option('ppt_terms_acceptance',$config);
 $data=array('email'=>'terms-'.time().'@example.test','token'=>$token,'policy'=>$policy,'options'=>$options,'config'=>$config,'field'=>ppt_terms_approval()['field_id']);
 $data['cookie']=array('name'=>LOGGED_IN_COOKIE,'value'=>wp_generate_auth_cookie(1,time()+3*HOUR_IN_SECONDS,'logged_in',$token),'domain'=>'127.0.0.1','path'=>'/','httpOnly'=>true,'secure'=>false,'sameSite'=>'Lax');
 $data['admin_cookie']=array_merge($data['cookie'],array('name'=>AUTH_COOKIE,'value'=>wp_generate_auth_cookie(1,time()+3*HOUR_IN_SECONDS,'auth',$token)));
 file_put_contents($file,wp_json_encode($data));WP_CLI::success('Local policy, private session and offline test fixture prepared.');
}elseif(in_array($mode,array('invalidate','restore'),true)){
 $data=json_decode(file_get_contents($file),true);$config=$data['config'];if($mode==='invalidate')$config['sha256']=str_repeat('0',64);update_option('ppt_terms_acceptance',$config);WP_CLI::success('Local policy approval '.$mode.'.');
}elseif($mode==='cleanup'){
 $data=json_decode(file_get_contents($file),true);$results=array();foreach(wc_get_orders(array('billing_email'=>$data['email'],'limit'=>-1))as $o){$results[]=array('status'=>$o->get_status(),'total'=>$o->get_total(),'acceptance'=>$o->get_meta('_ppt_terms_acceptance',true),'native_value'=>$o->get_meta('_wc_other/'.$data['field'],true),'downloads_permitted'=>$o->is_download_permitted());wc_increase_stock_levels($o->get_id());$o->delete(true);}
 file_put_contents($root.'/runtime/about-terms/orders.json',wp_json_encode($results,JSON_PRETTY_PRINT));
 foreach($data['options']as $key=>$value){if($value===null)delete_option($key);else update_option($key,$value);}
 wp_delete_post($data['policy'],true);WP_Session_Tokens::get_instance(1)->destroy($data['token']);unlink($file);WP_CLI::success('Fixture orders/policy/session removed; prior checkout settings restored.');
}
