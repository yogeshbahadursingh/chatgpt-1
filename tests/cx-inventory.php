<?php
/** Read-only source/data and override inventory; full overrides remain local. */
if ( 'local' !== wp_get_environment_type() ) { WP_CLI::error('Run only in the isolated local environment.'); }
$dir=dirname(ABSPATH,3).'/runtime/cx'; wp_mkdir_p($dir);
$overrides=get_posts(array('post_type'=>array('wp_template','wp_template_part','wp_global_styles','wp_navigation'),'post_status'=>'any','numberposts'=>-1));
file_put_contents($dir.'/overrides-before.json',wp_json_encode($overrides,JSON_PRETTY_PRINT));
$seed=require PPT_CORE_PATH.'includes/page-content.php';
$data=array('wordpress'=>get_bloginfo('version'),'theme'=>wp_get_theme()->get('Version'),'plugin'=>PPT_CORE_VERSION,'woocommerce'=>defined('WC_VERSION')?WC_VERSION:null,'environment'=>wp_get_environment_type(),'options'=>array(),'overrides'=>array(),'content'=>array(),'legacy_work_hash'=>hash('sha256',str_replace(home_url(),'{{home}}',$seed['work-with-us'][1])));
foreach(array('blog_public','show_on_front','page_on_front','page_for_posts','woocommerce_coming_soon','woocommerce_store_pages_only','woocommerce_enable_guest_checkout','woocommerce_file_download_method','ppt_enquiries_enabled')as $key)$data['options'][$key]=get_option($key);
foreach($overrides as $p)$data['overrides'][]=array('id'=>$p->ID,'type'=>$p->post_type,'slug'=>$p->post_name,'sha256'=>hash('sha256',$p->post_content));
foreach(get_posts(array('post_type'=>array_merge(array('page'),ppt_content_types()),'post_status'=>array('publish','draft'),'numberposts'=>-1))as $p)$data['content'][]=array('id'=>$p->ID,'type'=>$p->post_type,'status'=>$p->post_status,'title'=>$p->post_title,'url'=>get_permalink($p),'demo'=>(bool)get_post_meta($p->ID,'_ppt_demo_content',true));
file_put_contents($dir.'/inventory-before.json',wp_json_encode($data,JSON_PRETTY_PRINT));
echo wp_json_encode(array('versions'=>array_slice($data,0,5),'overrides'=>$data['overrides'],'records'=>count($data['content']),'legacy_work_hash'=>$data['legacy_work_hash']));
