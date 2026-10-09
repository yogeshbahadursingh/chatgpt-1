<?php
/**
 * The Template for displaying all single products
 *
 * @package PeoplePlanetThrive
 */

get_header();
?>

<main class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
