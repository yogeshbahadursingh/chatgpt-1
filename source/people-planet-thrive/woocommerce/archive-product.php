<?php defined('ABSPATH') || exit; get_header(); ?>
<main class="site-main ppt-section"><div class="alignwide">
<h1><?php woocommerce_page_title(); ?></h1>
<?php do_action('woocommerce_archive_description');
if(woocommerce_product_loop()){
 do_action('woocommerce_before_shop_loop');
 echo '<div class="ppt-directory">';
 while(have_posts()){the_post();wc_get_template_part('content','product');}
 echo '</div>';do_action('woocommerce_after_shop_loop');
}else{do_action('woocommerce_no_products_found');}
?>
</div></main><?php get_footer(); ?>
