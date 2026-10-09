<?php
/**
 * Fallback template for People & Planet Thrive theme.
 *
 * This file is required by WordPress for block themes but is not used
 * when block templates are available.
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Block themes use HTML templates. This file exists as a fallback.
// If this file is being loaded, something is wrong with the block template setup.
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e( 'Skip to content', 'people-planet-thrive' ); ?>
	</a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</h1>
		</div>
	</header>

	<main id="primary" class="site-main" role="main">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
					</header>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			endwhile;
			the_posts_navigation();
		else :
			?>
			<p><?php esc_html_e( 'No content found.', 'people-planet-thrive' ); ?></p>
			<?php
		endif;
		?>
	</main>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Knowledge for People. Progress for Planet.', 'people-planet-thrive' ); ?></p>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
