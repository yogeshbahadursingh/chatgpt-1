<?php
/**
 * Template: Careers Page
 *
 * Template Name: Careers
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

	<!-- Careers Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<!-- Page Content -->
		<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7;margin-bottom:var(--wp--preset--spacing--40)">
			<?php the_content(); ?>
		</div>

		<!-- Current Openings -->
		<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--25)"><?php esc_html_e( 'Current Openings', 'people-planet-thrive' ); ?></h2>
		
		<!-- Job Listings Placeholder -->
		<div style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--40);border-radius:4px;text-align:center">
			<p style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--20)">
				<?php esc_html_e( 'Job listings will appear here when positions are available.', 'people-planet-thrive' ); ?>
			</p>
			<p style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--text-light)">
				<?php esc_html_e( 'For general inquiries about career opportunities, please contact us at:', 'people-planet-thrive' ); ?>
				<a href="mailto:<?php echo esc_attr( get_theme_mod( 'ppt_contact_email', 'info@ppthrive.com' ) ); ?>" style="color:var(--wp--preset--color--primary);text-decoration:none">
					<?php echo esc_html( get_theme_mod( 'ppt_contact_email', 'info@ppthrive.com' ) ); ?>
				</a>
			</p>
		</div>

		<!-- Why Work With Us -->
		<div style="margin-top:var(--wp--preset--spacing--50)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--25)"><?php esc_html_e( 'Why Work With Us', 'people-planet-thrive' ); ?></h2>
			<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,280px),1fr));gap:var(--wp--preset--spacing--30)">
				<div style="padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
					<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--15)"><?php esc_html_e( 'Mission-Driven Work', 'people-planet-thrive' ); ?></h3>
					<p style="font-size:var(--wp--preset--font-size--16);line-height:1.6;color:var(--wp--preset--color--text-light)"><?php esc_html_e( 'Join a team dedicated to advancing knowledge for people and planet.', 'people-planet-thrive' ); ?></p>
				</div>
				<div style="padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
					<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--15)"><?php esc_html_e( 'Global Impact', 'people-planet-thrive' ); ?></h3>
					<p style="font-size:var(--wp--preset--font-size--16);line-height:1.6;color:var(--wp--preset--color--text-light)"><?php esc_html_e( 'Contribute to research and publishing that makes a difference worldwide.', 'people-planet-thrive' ); ?></p>
				</div>
				<div style="padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
					<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--15)"><?php esc_html_e( 'Professional Growth', 'people-planet-thrive' ); ?></h3>
					<p style="font-size:var(--wp--preset--font-size--16);line-height:1.6;color:var(--wp--preset--color--text-light)"><?php esc_html_e( 'Develop your skills in a supportive, collaborative environment.', 'people-planet-thrive' ); ?></p>
				</div>
			</div>
		</div>

	</div>

</main>

<?php
get_footer();
