<?php
/**
 * Template: Policy Page
 *
 * Template Name: Policy
 *
 * Generic template for policy pages with placeholder content
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

	<!-- Policy Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<!-- Last Updated -->
		<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--20);border-bottom:1px solid var(--wp--preset--color--border)">
			<?php esc_html_e( 'Last updated:', 'people-planet-thrive' ); ?> 
			<time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date() ); ?></time>
		</div>

		<!-- Page Content -->
		<div class="entry-content ppt-policy-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
			<?php the_content(); ?>
		</div>

	</div>

	<!-- Related Policies -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--40) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
			<h2 style="font-size:var(--wp--preset--font-size--24);font-weight:600;margin-bottom:var(--wp--preset--spacing--20);text-align:center"><?php esc_html_e( 'Related Policies', 'people-planet-thrive' ); ?></h2>
			<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,200px),1fr));gap:var(--wp--preset--spacing--20)">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'publication-ethics' ) ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center">
					<h3 style="font-size:var(--wp--preset--font-size--16);font-weight:600"><?php esc_html_e( 'Publication Ethics', 'people-planet-thrive' ); ?></h3>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'peer-review-policy' ) ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center">
					<h3 style="font-size:var(--wp--preset--font-size--16);font-weight:600"><?php esc_html_e( 'Peer Review Policy', 'people-planet-thrive' ); ?></h3>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'open-access-policy' ) ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center">
					<h3 style="font-size:var(--wp--preset--font-size--16);font-weight:600"><?php esc_html_e( 'Open Access Policy', 'people-planet-thrive' ); ?></h3>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'privacy-policy' ) ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center">
					<h3 style="font-size:var(--wp--preset--font-size--16);font-weight:600"><?php esc_html_e( 'Privacy Policy', 'people-planet-thrive' ); ?></h3>
				</a>
			</div>
		</div>
	</div>

</main>

<?php
get_footer();
