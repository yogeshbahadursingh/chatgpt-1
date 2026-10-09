<?php
defined('ABSPATH') || exit;
// Render block chrome before wp_head so block styles and navigation assets enqueue.
$ppt_header=do_blocks('<!-- wp:template-part {"slug":"header","tagName":"header"} /-->');
$GLOBALS['ppt_rendered_footer']=do_blocks('<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->');
?><!doctype html><html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head><body <?php body_class(); ?>><?php wp_body_open(); ?><div class="wp-site-blocks"><a class="skip-link screen-reader-text" href="#ppt-main">Skip to content</a><?php echo $ppt_header; ?><div id="ppt-main" tabindex="-1">
