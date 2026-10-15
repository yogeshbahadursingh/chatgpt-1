<?php
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Local only.');
$out=array('environment'=>wp_get_environment_type(),'pages'=>array(),'options'=>array(),'overrides'=>array());
foreach(array('about','terms','privacy-policy','contact','work-with-us','checkout') as $slug){$p=get_page_by_path($slug);if($p)$out['pages'][$slug]=array('id'=>$p->ID,'url'=>get_permalink($p),'status'=>$p->post_status,'title'=>$p->post_title,'content'=>$p->post_content,'template'=>get_page_template_slug($p),'revisions'=>count(wp_get_post_revisions($p->ID)));}
foreach(array('woocommerce_terms_page_id','wp_page_for_privacy_policy','woocommerce_checkout_page_id','woocommerce_currency','ppt_platform') as $key){if($key==='ppt_platform')continue;$out['options'][$key]=get_option($key);}
foreach(get_posts(array('post_type'=>array('wp_navigation','wp_template_part','wp_template'),'post_status'=>'publish','numberposts'=>-1))as $p)$out['overrides'][]=array('id'=>$p->ID,'type'=>$p->post_type,'slug'=>$p->post_name,'hash'=>hash('sha256',$p->post_content));
WP_CLI::line(wp_json_encode($out,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
