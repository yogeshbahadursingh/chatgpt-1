<?php
/** Bind existing specialist PHP layouts to the block theme without replacing its homepage. */
defined('ABSPATH') || exit;
add_filter('template_include',function($template){
 $name='';
 if(function_exists('is_product') && is_product()) return PPT_THEME_DIR.'/woocommerce/single-product.php';
 if(function_exists('is_shop') && (is_shop() || is_product_taxonomy())) return PPT_THEME_DIR.'/woocommerce/archive-product.php';
 if(is_singular() && strpos(get_post_type(),'ppt_')===0) $name='single-'.get_post_type();
 elseif(is_post_type_archive()) { $type=get_query_var('post_type'); if(is_string($type) && strpos($type,'ppt_')===0) $name='archive-'.$type; }
 elseif(is_singular('post')) $name='single';
 elseif(is_home()) $name='archive';
 if($name && file_exists(PPT_THEME_DIR.'/templates/'.$name.'.php')) return PPT_THEME_DIR.'/templates/'.$name.'.php';
 return $template;
},99);
add_filter('render_block_data',function($block){
 if($block['blockName']==='core/navigation' && empty($block['attrs']['ref']) && strpos($block['attrs']['className']??'','ppt-main-nav')!==false){
  $ref=(int)get_option('ppt_primary_navigation');
  if($ref && get_post_status($ref)==='publish'){ $block['attrs']['ref']=$ref; $block['innerBlocks']=array(); $block['innerContent']=array(); }
 }
 if($block['blockName']==='core/navigation-link'){
  $a=&$block['attrs'];
  if(($a['kind']??'')==='post-type' && !empty($a['id'])) $a['url']=get_permalink($a['id']);
  elseif(($a['kind']??'')==='post-type-archive' && !empty($a['type'])) $a['url']=get_post_type_archive_link($a['type']);
 }
 return $block;
});
add_action('init',function(){ add_shortcode('ppt_home','ppt_home_section'); add_shortcode('ppt_footer_connect',function(){
 $html='<p>'.esc_html(get_option('ppt_contact_address','')).'</p><p><a href="'.esc_url(home_url('/work-with-us/')).'">Work With Us</a><br><a href="'.esc_url(home_url('/careers/')).'">Careers</a><br><a href="'.esc_url(home_url('/contact/')).'">Contact</a></p>';
 foreach(array('ppt_newsletter_url'=>'Newsletter','ppt_social_url'=>'Follow our updates') as $key=>$label) if(get_option($key)) $html.='<p><a href="'.esc_url(get_option($key)).'">'.esc_html($label).'</a></p>';
 return $html;
 }); });
function ppt_home_section($attrs){
 $section=$attrs['section']??'';
 $types=array('research'=>'ppt_research_project','publications'=>'ppt_publication','training'=>'ppt_training');
 if(!isset($types[$section])) return '';
 $args=array('post_type'=>$types[$section],'post_status'=>'publish','posts_per_page'=>$section==='research'?1:3,'meta_key'=>'_ppt_featured','meta_value'=>'1');
 $posts=get_posts($args); if(!$posts){unset($args['meta_key'],$args['meta_value']);$posts=get_posts($args);}
 if(!$posts) return '<p class="ppt-big-copy">'.esc_html($section==='training'?'Upcoming learning opportunities will appear here.':'New work is being prepared for this programme.').'</p>';
 $html='';
 foreach($posts as $i=>$p){
  if($section==='research') $html.='<h2 class="wp-block-heading ppt-section-display"><a href="'.esc_url(get_permalink($p)).'">'.esc_html($p->post_title).'</a></h2><p class="ppt-big-copy">'.esc_html(get_the_excerpt($p)).'</p><p class="ppt-text-link"><a href="'.esc_url(get_permalink($p)).'">Explore this research →</a></p>';
  elseif($section==='training') $html.='<p><span>'.esc_html(sprintf('%02d',$i+1)).'</span><strong><a href="'.esc_url(get_permalink($p)).'">'.esc_html($p->post_title).'</a></strong><br>'.esc_html(wp_trim_words(get_the_excerpt($p),18)).'</p>';
  else $html.='<article class="ppt-pub-card"><a href="'.esc_url(get_permalink($p)).'">'.(has_post_thumbnail($p)?get_the_post_thumbnail($p,'medium',array('loading'=>'lazy')):'<span class="ppt-cover ppt-cover-'.($i===0?'one':'two').'">'.esc_html($p->post_title).'</span>').'</a><p class="ppt-kicker">'.esc_html(get_post_meta($p->ID,'_ppt_publication_format',true)).'</p><h3><a href="'.esc_url(get_permalink($p)).'">'.esc_html($p->post_title).'</a></h3><p>'.esc_html(wp_trim_words(get_the_excerpt($p),24)).'</p></article>';
 }
 return $html;
}
add_action('wp_enqueue_scripts',function(){wp_enqueue_style('ppt-completion',PPT_THEME_URI.'/assets/css/completion.css',array('ppt-rescue'),PPT_THEME_VERSION);},30);
// Semantic labels in block search results.
add_filter('render_block_core/post-title',function($html,$block){
 if(is_search() && get_post_type()) $html='<p class="ppt-kicker">'.esc_html(get_post_type_object(get_post_type())->labels->singular_name).'</p>'.$html;
 return $html;
},10,2);
// Additional homepage collections reuse the supplied section and card styles.
add_action('init',function(){add_shortcode('ppt_home_collections',function(){
 if(!function_exists('ppt_directory')) return '';
 $html='';
 foreach(array('Latest Journal Articles'=>'ppt_article','Research Areas'=>'ppt_research_area') as $title=>$type) $html.='<section class="ppt-section"><div class="alignwide"><h2 class="ppt-section-display">'.esc_html($title).'</h2>'.ppt_directory(array('type'=>$type,'limit'=>3)).'</div></section>';
 $events=get_posts(array('post_type'=>'ppt_event','posts_per_page'=>3,'meta_key'=>'_ppt_event_start_date','orderby'=>'meta_value','order'=>'ASC','meta_query'=>array(array('key'=>'_ppt_event_start_date','value'=>current_time('Y-m-d'),'compare'=>'>=','type'=>'DATE'))));
 $html.='<section class="ppt-section"><div class="alignwide"><h2 class="ppt-section-display">Upcoming Events</h2>';
 if($events){$html.='<div class="ppt-directory">';foreach($events as $event)$html.='<article><p class="ppt-kicker">'.esc_html(get_post_meta($event->ID,'_ppt_event_start_date',true)).'</p><h3><a href="'.esc_url(get_permalink($event)).'">'.esc_html($event->post_title).'</a></h3><p>'.esc_html(get_the_excerpt($event)).'</p></article>';$html.='</div>';}else $html.='<p>Upcoming learning opportunities will appear here.</p>';
 $html.='</div></section>';
 if(get_posts(array('post_type'=>'ppt_partner','posts_per_page'=>1)))$html.='<section class="ppt-section"><div class="alignwide"><h2 class="ppt-section-display">Partners</h2>'.ppt_directory(array('type'=>'ppt_partner','limit'=>6)).'</div></section>';
 return $html;
});});
// Resolve saved navigation objects at render time, including after domain migration.
add_filter('render_block_core/navigation-link',function($html,$block){
 $a=$block['attrs'];$url='';
 if(($a['kind']??'')==='post-type' && !empty($a['id']))$url=get_permalink((int)$a['id']);
 elseif(($a['kind']??'')==='post-type-archive' && !empty($a['type']))$url=get_post_type_archive_link($a['type']);
 if($url){$tags=new WP_HTML_Tag_Processor($html);if($tags->next_tag('a')){$tags->set_attribute('href',$url);return $tags->get_updated_html();}}
 return $html;
},20,2);
// These routes deliberately render PHP Woo templates; block-hook substitution would remove their native summary callbacks while rendering our block header.
add_filter('woocommerce_disable_compatibility_layer',function($disabled){
 return $disabled || (function_exists('is_product') && (is_product() || is_shop() || is_product_taxonomy()));
});
