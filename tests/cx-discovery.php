<?php
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Local QA required.');
$out=array();$check=function($name,$pass)use(&$out){$out[]=array('test'=>$name,'pass'=>(bool)$pass);};$old=get_option('ppt_exclude_demo_indexing',null);$created=array();
try{
 foreach(array('real'=>null,'zero'=>'0','demo'=>'1')as $kind=>$flag){$id=wp_insert_post(array('post_type'=>'ppt_publication','post_status'=>'publish','post_title'=>'Local CX indexing '.$kind));$created[$kind]=$id;if($flag!==null)update_post_meta($id,'_ppt_demo_content',$flag);}
 update_option('ppt_exclude_demo_indexing',1);$query=apply_filters('wp_sitemaps_posts_query_args',array('post_type'=>'ppt_publication','post_status'=>'publish','posts_per_page'=>-1,'fields'=>'ids'),'ppt_publication');$ids=get_posts($query);$check('Opt-in sitemap exclusion removes marked demos only',in_array($created['real'],$ids)&&in_array($created['zero'],$ids)&&!in_array($created['demo'],$ids));
 update_option('ppt_exclude_demo_indexing',0);$query=apply_filters('wp_sitemaps_posts_query_args',array('post_type'=>'ppt_publication','post_status'=>'publish','posts_per_page'=>-1,'fields'=>'ids'),'ppt_publication');$check('Without approval demo sitemap membership is unchanged',in_array($created['demo'],get_posts($query)));
 $check('Staging is excluded from indexing',get_option('blog_public')==='0');
 $before=json_decode(file_get_contents(dirname(ABSPATH,3).'/runtime/cx/inventory-before.json'),true);foreach($before['overrides']as $override){$post=get_post($override['id']);$check('Saved '.$override['type'].' '.$override['id'].' preserved',$post&&hash('sha256',$post->post_content)===$override['sha256']);}
 $check('Private enquiries are not a search content type',!in_array('ppt_enquiry_record',ppt_content_types(),true));
 $check('Enquiry file uploads are not accepted',strpos(ppt_enquiry(),'type="file"')===false);
}finally{foreach($created as $id)wp_delete_post($id,true);if($old===null)delete_option('ppt_exclude_demo_indexing');else update_option('ppt_exclude_demo_indexing',$old);}
file_put_contents(dirname(ABSPATH,3).'/runtime/cx/discovery.json',wp_json_encode($out,JSON_PRETTY_PRINT));echo wp_json_encode($out);
