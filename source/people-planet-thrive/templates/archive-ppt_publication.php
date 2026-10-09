<?php
defined('ABSPATH') || exit;
get_header(); ?>
<main class="site-main ppt-section"><div class="alignwide"><p class="ppt-kicker">PEOPLE &amp; PLANET THRIVE</p><h1>Publications</h1><p class="ppt-big-copy">Books, e-books and practical knowledge resources connecting research with action.</p>
<?php
$sections=array('Featured Publication'=>array('featured'=>true),'New Releases'=>array('limit'=>3),'Books'=>array('term'=>'Books'),'E-books'=>array('term'=>'E-books'),'Research Reports'=>array('term'=>'Research Reports'),'Policy Briefs'=>array('term'=>'Policy Briefs'),'Free Resources'=>array('term'=>'Free Resources'));
foreach($sections as $title=>$config){
 echo '<section><h2>'.esc_html($title).'</h2>';
 $commerce=function_exists('wc_get_products') && !(function_exists('ppt_store_prelaunch_for_visitor') && ppt_store_prelaunch_for_visitor());
 $args=array('post_type'=>$commerce?'product':'ppt_publication','post_status'=>'publish','posts_per_page'=>isset($config['featured'])?1:3,'orderby'=>'date','order'=>'DESC');
 $base_tax=array();
 if($commerce)$base_tax[]=array('taxonomy'=>'product_visibility','field'=>'name','terms'=>array('exclude-from-catalog'),'operator'=>'NOT IN');
 if(isset($config['term']))$base_tax[]=array('taxonomy'=>'ppt_publication_type','field'=>'name','terms'=>$config['term']);
 $args['tax_query']=$base_tax;
 if(isset($config['featured'])){if($commerce)$args['tax_query'][]=array('taxonomy'=>'product_visibility','field'=>'name','terms'=>'featured');else{$args['meta_key']='_ppt_featured';$args['meta_value']='1';}}
 $items=get_posts(function_exists('ppt_visible_content_query_args')?ppt_visible_content_query_args($args):$args);
 if(!$items && isset($config['featured'])){$args['tax_query']=$base_tax;unset($args['meta_key'],$args['meta_value']);$items=get_posts(function_exists('ppt_visible_content_query_args')?ppt_visible_content_query_args($args):$args);}
 if($items){
  echo '<div class="ppt-directory">';
  foreach($items as $item){
   $product=$commerce?wc_get_product($item->ID):null;
   if($commerce && (!$product || !$product->is_visible()))continue;
   $cover=$product?$product->get_image('medium'):(has_post_thumbnail($item)?get_the_post_thumbnail($item,'medium',array('loading'=>'lazy')):'<span class="ppt-cover ppt-cover-one">'.esc_html($item->post_title).'</span>');
   echo '<article class="ppt-pub-card"><a href="'.esc_url(get_permalink($item)).'">'.$cover.'<h3>'.esc_html($item->post_title).'</h3></a><p>'.esc_html(wp_trim_words(get_the_excerpt($item),22)).'</p>'.($product?$product->get_price_html():'').'</article>';
  }
  echo '</div>';
 }else echo '<p>Our publishing programme is currently being developed.</p>';
 if(isset($config['term'])){$term=get_term_by('name',$config['term'],'ppt_publication_type');if($term)echo '<p><a href="'.esc_url(get_term_link($term)).'">Browse all '.esc_html($config['term']).' →</a></p>';}
 echo '</section>';
}
echo '<h2>Browse by Topic</h2>'; $terms=get_terms(array('taxonomy'=>'ppt_subject_area','hide_empty'=>true)); if(!is_wp_error($terms))foreach($terms as $term)echo '<p><a href="'.esc_url(get_term_link($term)).'">'.esc_html($term->name).'</a></p>';
echo '<h2>Browse by Author</h2>';echo function_exists('ppt_directory')?ppt_directory(array('type'=>'ppt_author','limit'=>6)):'';
echo '<h2>Latest Publications</h2>';echo function_exists('ppt_directory')?ppt_directory(array('type'=>'ppt_publication','limit'=>12)):'';
?>
</div></main><?php get_footer(); ?>
