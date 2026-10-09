<?php
defined('ABSPATH') || exit;
get_header(); ?>
<main class="site-main ppt-section"><div class="alignwide"><p class="ppt-kicker">PEOPLE &amp; PLANET THRIVE</p><h1>Publications</h1><p class="ppt-big-copy">Books, e-books and practical knowledge resources connecting research with action.</p>
<?php
$sections=array('Featured Publication'=>array('featured'=>true),'New Releases'=>array('limit'=>3),'Books'=>array('term'=>'Books'),'E-books'=>array('term'=>'E-books'),'Research Reports'=>array('term'=>'Research Reports'),'Policy Briefs'=>array('term'=>'Policy Briefs'),'Free Resources'=>array('term'=>'Free Resources'));
foreach($sections as $title=>$config){
 echo '<section><h2>'.esc_html($title).'</h2>';
 if(function_exists('wc_get_products')){
  $args=array('post_type'=>'product','post_status'=>'publish','posts_per_page'=>$title==='Featured Publication'?1:3,'orderby'=>'date','order'=>'DESC');
  if(isset($config['term']))$args['tax_query']=array(array('taxonomy'=>'ppt_publication_type','field'=>'name','terms'=>$config['term']));
  if(isset($config['featured']))$args['tax_query']=array(array('taxonomy'=>'product_visibility','field'=>'name','terms'=>'featured'));
  $items=get_posts($args);if(!$items && isset($config['featured'])){unset($args['tax_query']);$items=get_posts($args);}
  if($items){echo '<div class="ppt-directory">';foreach($items as $item){$product=wc_get_product($item->ID);if(!$product)continue;echo '<article class="ppt-pub-card"><a href="'.esc_url(get_permalink($item)).'">'.$product->get_image('medium').'<h3>'.esc_html($item->post_title).'</h3></a><p>'.esc_html(wp_trim_words(get_the_excerpt($item),22)).'</p>'.$product->get_price_html().'</article>';}echo '</div>';}
  else echo '<p>Our publishing programme is currently being developed.</p>';
 }else echo function_exists('ppt_directory')?ppt_directory(array('type'=>'ppt_publication','limit'=>3)):'';
 echo '</section>';
}
echo '<h2>Browse by Topic</h2>'; $terms=get_terms(array('taxonomy'=>'ppt_subject_area','hide_empty'=>true)); if(!is_wp_error($terms))foreach($terms as $term)echo '<p><a href="'.esc_url(get_term_link($term)).'">'.esc_html($term->name).'</a></p>';
echo '<h2>Browse by Author</h2>';echo function_exists('ppt_directory')?ppt_directory(array('type'=>'ppt_author','limit'=>6)):'';
echo '<h2>Latest Publications</h2>';echo function_exists('ppt_directory')?ppt_directory(array('type'=>'ppt_publication','limit'=>12)):'';
?>
</div></main><?php get_footer(); ?>
