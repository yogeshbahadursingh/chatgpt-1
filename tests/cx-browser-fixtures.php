<?php
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Isolated local installation required.');
$file=dirname(ABSPATH,3).'/runtime/cx/browser-private.json';$mode=getenv('PPT_CX_MODE')?:'prepare';
if($mode==='prepare'){
 if(file_exists($file))WP_CLI::error('Clean up the previous fixture first.');
 wp_set_current_user(1);$token=WP_Session_Tokens::get_instance(1)->create(time()+HOUR_IN_SECONDS);$email='cx-browser-'.time().'@example.test';
 $id=wp_insert_post(array('post_type'=>'page','post_title'=>'CX native editor verification','post_name'=>'cx-native-editor-verification','post_status'=>'publish','post_content'=>ppt_collaboration_content()),true);if(is_wp_error($id))WP_CLI::error($id->get_error_message());
 $data=array('email'=>$email,'page'=>$id,'page_url'=>get_permalink($id),'token'=>$token,'cookie'=>array('name'=>LOGGED_IN_COOKIE,'value'=>wp_generate_auth_cookie(1,time()+HOUR_IN_SECONDS,'logged_in',$token),'domain'=>'127.0.0.1','path'=>'/','httpOnly'=>true,'secure'=>false,'sameSite'=>'Lax'));
 $data['admin_cookie']=array_merge($data['cookie'],array('name'=>AUTH_COOKIE,'value'=>wp_generate_auth_cookie(1,time()+HOUR_IN_SECONDS,'auth',$token)));
 file_put_contents($file,wp_json_encode($data));WP_CLI::success('Owned local page and private session prepared.');
}elseif($mode==='auth'){
 $data=json_decode(file_get_contents($file),true);$data['admin_cookie']=array_merge($data['cookie'],array('name'=>AUTH_COOKIE,'value'=>wp_generate_auth_cookie(1,time()+HOUR_IN_SECONDS,'auth',$data['token'])));file_put_contents($file,wp_json_encode($data));WP_CLI::success('Private local admin cookie prepared.');
}else{
 $data=json_decode(file_get_contents($file),true);$posts=get_posts(array('post_type'=>'ppt_enquiry_record','post_status'=>array('private','trash'),'numberposts'=>-1,'meta_key'=>'_ppt_email','meta_value'=>$data['email']));
 $records=array();foreach($posts as $p)$records[]=array('id'=>$p->ID,'category'=>get_post_meta($p->ID,'_ppt_category',true),'status'=>$p->post_status,'notification'=>get_post_meta($p->ID,'_ppt_notification',true));
 $orders=wc_get_orders(array('billing_email'=>$data['email'],'limit'=>-1));$order_results=array();foreach($orders as $o)$order_results[]=array('id'=>$o->get_id(),'status'=>$o->get_status(),'total'=>$o->get_total(),'download_permitted'=>$o->is_download_permitted());
 if($records||$order_results)file_put_contents(dirname(ABSPATH,3).'/runtime/cx/'.sanitize_file_name(getenv('PPT_CX_REPORT')?:'browser-backend').'.json',wp_json_encode(array('enquiries'=>$records,'orders'=>$order_results),JSON_PRETTY_PRINT));
 foreach($posts as $p)wp_delete_post($p->ID,true);foreach($orders as $o){wc_increase_stock_levels($o->get_id());$o->delete(true);}wp_delete_post($data['page'],true);WP_Session_Tokens::get_instance(1)->destroy($data['token']);
 delete_transient('ppt_enq_rate_'.hash_hmac('sha256','127.0.0.1',wp_salt()));unlink($file);WP_CLI::success('Backend results saved; owned page, enquiries, orders and session removed.');
}
