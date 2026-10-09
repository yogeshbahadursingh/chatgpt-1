<?php
/**
 * Template: About Page
 *
 * Template Name: About
 *
 * @package PeoplePlanetThrive
 */

get_header();
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'people-planet-thrive' ); ?></a>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Page Header -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
			<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<div style="font-size:var(--wp--preset--font-size--20);line-height:1.6;color:var(--wp--preset--color--text-light);max-width:720px">
					<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Page Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
			<?php the_content(); ?>
		</div>
	</div>

	<!-- Institutional Navigation -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--40) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
			<h2 style="font-size:var(--wp--preset--font-size--24);font-weight:600;margin-bottom:var(--wp--preset--spacing--20);text-align:center"><?php esc_html_e( 'Learn More', 'people-planet-thrive' ); ?></h2>
			<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,200px),1fr));gap:var(--wp--preset--spacing--20)">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'mission-vision' ) ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center">
					<h3 style="font-size:var(--wp--preset--font-size--18);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Mission & Vision', 'people-planet-thrive' ); ?></h3>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'our-approach' ) ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center">
					<h3 style="font-size:var(--wp--preset--font-size--18);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Our Approach', 'people-planet-thrive' ); ?></h3>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'leadership' ) ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center">
					<h3 style="font-size:var(--wp--preset--font-size--18);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Leadership', 'people-planet-thrive' ); ?></h3>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'team' ) ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center">
					<h3 style="font-size:var(--wp--preset--font-size--18);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Team', 'people-planet-thrive' ); ?></h3>
				</a>
			</div>
		</div>
	</div>

</main>

<?php
get_footer();
