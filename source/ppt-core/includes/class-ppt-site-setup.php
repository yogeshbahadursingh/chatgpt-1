<?php
 defined('ABSPATH') || exit;
class PPT_Site_Setup {
 public function __construct(){ add_action('admin_menu',array($this,'menu')); add_action('admin_post_ppt_repair_site',array($this,'repair')); }
 public function menu(){ add_management_page('PPT Site Setup','PPT Site Setup','manage_options','ppt-site-setup',array($this,'screen')); }
 public function screen(){
  if(!current_user_can('manage_options')) return;
  echo '<div class="wrap"><h1>PPT Site Setup</h1><p>Create missing pages and navigation. Existing content is preserved. Run again after activating WooCommerce to create its system pages.</p>';
  if(isset($_GET['ppt_repaired'])) echo '<div class="notice notice-success"><p>Setup completed.</p></div>';
  echo '<form method="post" action="'.esc_url(admin_url('admin-post.php')).'">'; wp_nonce_field('ppt_repair_site');
  echo '<input type="hidden" name="action" value="ppt_repair_site">'; submit_button('Create / Repair Site');
  echo '</form><p><a href="'.esc_url(admin_url('tools.php?page=ppt-demo-importer')).'">Import or remove demo content</a></p><p>Edit pages in Pages, shared navigation and footer in Appearance → Editor, and contact settings in Settings → PPT Platform.</p></div>';
 }
 public function repair(){
  if(!current_user_can('manage_options')) wp_die('Permission denied.','',array('response'=>403));
  check_admin_referer('ppt_repair_site'); $result=self::run();
  if(is_wp_error($result)) wp_die(esc_html($result->get_error_message()));
  wp_safe_redirect(add_query_arg('ppt_repaired','1',admin_url('tools.php?page=ppt-site-setup'))); exit;
 }
 public static function run(){
  if(!current_user_can('manage_options')) return new WP_Error('forbidden','Administrator access required.');
  $pages=require PPT_CORE_PATH.'includes/page-content.php'; $ids=array();
  foreach($pages as $slug=>$data){
   $existing=get_page_by_path($slug,OBJECT,'page');
   if($existing){
    // WordPress itself seeds a draft privacy template on fresh installations.
    if($slug==='privacy-policy' && $existing->post_status==='draft' && $existing->post_date===$existing->post_modified){
     require_once ABSPATH.'wp-admin/includes/class-wp-privacy-policy-content.php';
     if($existing->post_content===WP_Privacy_Policy_Content::get_default_content()) wp_update_post(array('ID'=>$existing->ID,'post_status'=>'publish','post_content'=>$data[1],'meta_input'=>array('_ppt_setup_page'=>1)));
    }
    $ids[$slug]=$existing->ID; continue;
   }
   $id=wp_insert_post(array('post_type'=>'page','post_status'=>'publish','post_name'=>$slug,'post_title'=>$data[0],'post_content'=>$data[1],'meta_input'=>array('_ppt_setup_page'=>1)),true);
   if(is_wp_error($id)) return $id; $ids[$slug]=$id;
  }
  if(!get_option('page_on_front')){ update_option('show_on_front','page'); update_option('page_on_front',$ids['home']); }
  if(!get_option('page_for_posts')) update_option('page_for_posts',$ids['insights']);
  if(!get_option('permalink_structure')) { global $wp_rewrite; $wp_rewrite->set_permalink_structure('/%postname%/'); }
  // Only exact, unedited English core defaults are moved to Draft, never deleted.
  $defaults=array(1=>array('Hello world!','01a4f5d1bb06f7b58aa738268df2413b42b0aac6c5acf483268836d388d7ebdc'),2=>array('Sample Page','e3d942e7c47632bab32f7c0611d35b73e68a28e9e2a835611f1b9dc996ffca3e'));
  foreach($defaults as $id=>$expected){
   $candidate=get_post($id);
   if($candidate && $candidate->post_status==='publish' && $candidate->post_title===$expected[0] && $candidate->post_date===$candidate->post_modified && !wp_get_post_revisions($id) && hash_equals($expected[1],hash('sha256',str_replace(admin_url(),'{{admin_url}}',$candidate->post_content)))) wp_update_post(array('ID'=>$id,'post_status'=>'draft'));
  }
  $links=array('Home'=>array('page',$ids['home']),'Journals'=>array('archive','ppt_journal'),'Publications'=>array('archive','ppt_publication'),'Research'=>array('page',$ids['research']),'Training'=>array('archive','ppt_training'),'Insights'=>array('page',$ids['insights']),'About'=>array('page',$ids['about']));
  $blocks='';
  foreach($links as $label=>$link){
   $attrs=array('label'=>$label,'url'=>$link[0]==='page'?get_permalink($link[1]):get_post_type_archive_link($link[1]),'kind'=>$link[0]==='page'?'post-type':'post-type-archive','type'=>$link[0]==='page'?'page':$link[1]);
   if($link[0]==='page') $attrs['id']=$link[1];
   $blocks.='<!-- wp:navigation-link '.wp_json_encode($attrs).' /-->';
  }
  $nav=(int)get_option('ppt_primary_navigation');
  if(!$nav || !get_post($nav)){
   $nav=wp_insert_post(array('post_type'=>'wp_navigation','post_status'=>'publish','post_title'=>'PPT Primary','post_content'=>$blocks),true);
   if(is_wp_error($nav)) return $nav; update_option('ppt_primary_navigation',$nav);
  }
  // Seed a real editable template part once; never overwrite a user's Site Editor copy.
  if(get_stylesheet()==='people-planet-thrive'){
   $header=get_block_template(get_stylesheet().'//header','wp_template_part');
   if(!$header || $header->source!=='custom'){
    $file=get_theme_file_path('parts/header.html');
    if(is_readable($file)){
     $content=preg_replace('/<!-- wp:navigation \{.*?<!-- \/wp:navigation -->/s','<!-- wp:navigation '.wp_json_encode(array('ref'=>$nav,'overlayMenu'=>'mobile','className'=>'ppt-main-nav','layout'=>array('type'=>'flex','justifyContent'=>'right'))).' /-->',file_get_contents($file));
     $part=wp_insert_post(array('post_type'=>'wp_template_part','post_name'=>'header','post_title'=>'Header','post_status'=>'publish','post_content'=>$content),true);
     if(is_wp_error($part)) return $part;
     wp_set_object_terms($part,get_stylesheet(),'wp_theme');
     wp_set_object_terms($part,'header','wp_template_part_area');
    }
   }
  }
  if(class_exists('WC_Install')) WC_Install::create_pages();
  flush_rewrite_rules(false); update_option('ppt_setup_version','2.3.0'); return $ids;
 }
}
new PPT_Site_Setup();
