<?php
/** Explicit, local-only content preparation. Never run on production. */
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Isolated local site required.');
$root=dirname(__DIR__);$backup=$root.'/checkpoint/pre-about-terms-20261015';
if(file_exists($backup.'/pages.json'))WP_CLI::error('Checkpoint exists; do not overwrite or rerun the migration.');
wp_mkdir_p($backup);wp_mkdir_p($root.'/runtime/about-terms');
$pages=array();foreach(array('about','terms','privacy-policy','checkout')as $slug){$p=get_page_by_path($slug);if(!$p)WP_CLI::error('Missing existing page '.$slug);$pages[$slug]=array('post'=>$p->to_array(),'meta'=>get_post_meta($p->ID));wp_save_post_revision($p->ID);}
$options=array();foreach(array('woocommerce_terms_page_id','wp_page_for_privacy_policy','woocommerce_checkout_page_id','woocommerce_currency','ppt_terms_acceptance')as $key)$options[$key]=get_option($key);
file_put_contents($backup.'/pages.json',wp_json_encode(array('pages'=>$pages,'options'=>$options),JSON_PRETTY_PRINT));
$id=wp_update_post(array('ID'=>$pages['about']['post']['ID'],'post_title'=>'About People & Planet Thrive','post_content'=>file_get_contents($root.'/content/about-terms/about.html')),true);if(is_wp_error($id))WP_CLI::error($id->get_error_message());
$draft=wp_insert_post(array('post_type'=>'page','post_status'=>'draft','post_name'=>'terms-review','post_title'=>'Terms and Conditions','post_content'=>file_get_contents($root.'/content/about-terms/terms.html')),true);if(is_wp_error($draft))WP_CLI::error($draft->get_error_message());
update_post_meta($draft,'_ppt_terms_review_target',$pages['terms']['post']['ID']);update_post_meta($draft,'_ppt_review_required','Owner/source notes, operational details and Nepal-qualified legal approval are outstanding.');
$result=array('about'=>$id,'terms_draft'=>$draft,'terms_target'=>$pages['terms']['post']['ID'],'checkout'=>$pages['checkout']['post']['ID'],'about_url'=>get_permalink($id),'terms_preview'=>get_preview_post_link($draft),'checkpoint'=>$backup);
file_put_contents($root.'/runtime/about-terms/pages.json',wp_json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));WP_CLI::line(wp_json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
