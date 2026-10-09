<?php
/** Template Name: Contact
 * Legacy template name retained for saved page assignments.
 * Editorial copy comes from the page, using the approved block page layout.
 */
defined('ABSPATH') || exit;
get_header();
?><main class="wp-block-group site-main" style="max-width:var(--wp--style--global--content-size);margin:auto;padding:3rem 1rem"><?php
while(have_posts()){the_post();the_title('<h1>','</h1>');the_content();}
?></main><?php get_footer();
