<?php
/**
 * Template: Contact Page
 *
 * Template Name: Contact
 *
 * @package PeoplePlanetThrive
 */

get_header();

// Get contact information from Customizer
$contact_email = get_theme_mod( 'ppt_contact_email', 'info@ppthrive.com' );
$contact_phone = get_theme_mod( 'ppt_contact_phone', '+1 (234) 567-890' );
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

	<!-- Contact Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--wp--preset--spacing--50)">
			
			<!-- Contact Information -->
			<div>
				<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--25)"><?php esc_html_e( 'Get in Touch', 'people-planet-thrive' ); ?></h2>
				
				<!-- Page Content -->
				<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7;margin-bottom:var(--wp--preset--spacing--30)">
					<?php the_content(); ?>
				</div>

				<!-- Contact Details -->
				<div style="margin-bottom:var(--wp--preset--spacing--30)">
					<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Contact Information', 'people-planet-thrive' ); ?></h3>
					
					<div style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--15)">
						<?php if ( $contact_email ) : ?>
							<div style="display:flex;align-items:center;gap:var(--wp--preset--spacing--15)">
								<div style="width:40px;height:40px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;display:flex;align-items:center;justify-content:center">
									<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" style="color:var(--wp--preset--color--primary)"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
								</div>
								<div>
									<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--5)"><?php esc_html_e( 'Email', 'people-planet-thrive' ); ?></div>
									<a href="mailto:<?php echo esc_attr( $contact_email ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none"><?php echo esc_html( $contact_email ); ?></a>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $contact_phone ) : ?>
							<div style="display:flex;align-items:center;gap:var(--wp--preset--spacing--15)">
								<div style="width:40px;height:40px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;display:flex;align-items:center;justify-content:center">
									<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" style="color:var(--wp--preset--color--primary)"><path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/></svg>
								</div>
								<div>
									<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--5)"><?php esc_html_e( 'Phone', 'people-planet-thrive' ); ?></div>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none"><?php echo esc_html( $contact_phone ); ?></a>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<!-- Social Links -->
				<div>
					<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Follow Us', 'people-planet-thrive' ); ?></h3>
					<div style="display:flex;gap:var(--wp--preset--spacing--15)">
						<a href="#" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;text-decoration:none;color:var(--wp--preset--color--text);transition:background-color 0.2s ease" title="<?php esc_attr_e( 'Twitter', 'people-planet-thrive' ); ?>">
							<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
						</a>
						<a href="#" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;text-decoration:none;color:var(--wp--preset--color--text);transition:background-color 0.2s ease" title="<?php esc_attr_e( 'LinkedIn', 'people-planet-thrive' ); ?>">
							<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
						</a>
					</div>
				</div>
			</div>

			<!-- Contact Form -->
			<div>
				<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--25)"><?php esc_html_e( 'Send us a Message', 'people-planet-thrive' ); ?></h2>
				
				<!-- Contact Form Placeholder -->
				<div style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--30);border-radius:4px;text-align:center">
					<p style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--20)">
						<?php esc_html_e( 'Contact form integration placeholder. Add your preferred contact form plugin (e.g., Contact Form 7, WPForms, Gravity Forms) here.', 'people-planet-thrive' ); ?>
					</p>
					<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);font-style:italic">
						<?php esc_html_e( 'Use shortcode or block to insert contact form', 'people-planet-thrive' ); ?>
					</div>
				</div>
			</div>

		</div>

	</div>

</main>

<?php
get_footer();
