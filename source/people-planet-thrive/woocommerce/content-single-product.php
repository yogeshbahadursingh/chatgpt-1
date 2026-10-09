<?php
/** Preserve editorial two-column composition and WooCommerce extension hooks. */
defined('ABSPATH') || exit;
global $product;
do_action('woocommerce_before_single_product');
if(post_password_required()){echo get_the_password_form();return;}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('ppt-book-product',$product); ?>>
<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--50)">
<div class="wp-block-column" style="flex-basis:40%">
<?php do_action('woocommerce_before_single_product_summary'); ?>
</div><div class="wp-block-column" style="flex-basis:60%"><div class="summary entry-summary">
<?php do_action('woocommerce_single_product_summary'); ?>
</div></div></div>
<?php do_action('woocommerce_after_single_product_summary'); ?>
</div>
<?php do_action('woocommerce_after_single_product'); ?>
