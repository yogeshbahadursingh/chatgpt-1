<?php
/**
 * Template: Leadership Page
 *
 * Template Name: Leadership
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
				/ <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>"><?php esc_html_e( 'About', 'people-planet-thrive' ); ?></a>
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

	<!-- Leadership Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<!-- Page Content -->
		<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7;margin-bottom:var(--wp--preset--spacing--40)">
			<?php the_content(); ?>
		</div>

		<!-- Leadership Team Grid -->
		<?php
		$leaders = new WP_Query( array(
			'post_type'      => 'ppt_team_member',
			'posts_per_page' => -1,
			'meta_key'       => '_ppt_team_is_leadership',
			'meta_value'     => '1',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		) );

		if ( $leaders->have_posts() ) :
			?>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,320px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php while ( $leaders->have_posts() ) : $leaders->the_post();
					$role = get_post_meta( get_the_ID(), '_ppt_team_role', true );
					$department = get_post_meta( get_the_ID(), '_ppt_team_department', true );
					$email = get_post_meta( get_the_ID(), '_ppt_team_email', true );
					$linkedin = get_post_meta( get_the_ID(), '_ppt_team_linkedin', true );
					?>
					<div class="wp-block-group ppt-leadership-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;overflow:hidden;background-color:var(--wp--preset--color--white);transition:transform 0.2s ease,box-shadow 0.2s ease">
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div style="width:100%;height:320px;overflow:hidden">
								<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:100%;object-fit:cover' ) ); ?>
							</div>
						<?php endif; ?>

						<div style="padding:var(--wp--preset--spacing--25)">
							<h3 style="font-size:var(--wp--preset--font-size--24);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
								<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
							</h3>

							<?php if ( $role ) : ?>
								<div style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--primary);margin-bottom:var(--wp--preset--spacing--10);font-weight:500">
									<?php echo esc_html( $role ); ?>
								</div>
							<?php endif; ?>

							<?php if ( $department ) : ?>
								<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
									<?php echo esc_html( $department ); ?>
								</div>
							<?php endif; ?>

							<?php if ( has_excerpt() ) : ?>
								<div style="font-size:var(--wp--preset--font-size--14);line-height:1.6;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
									<?php echo esc_html( wp_trim_words( get_the_excerpt(), 30 ) ); ?>
								</div>
							<?php endif; ?>

							<div style="display:flex;gap:var(--wp--preset--spacing--10)">
								<?php if ( $email ) : ?>
									<a href="mailto:<?php echo esc_attr( $email ); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;text-decoration:none;color:var(--wp--preset--color--text)" title="<?php esc_attr_e( 'Email', 'people-planet-thrive' ); ?>">
										<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
									</a>
								<?php endif; ?>
								<?php if ( $linkedin ) : ?>
									<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;text-decoration:none;color:var(--wp--preset--color--text)" title="<?php esc_attr_e( 'LinkedIn', 'people-planet-thrive' ); ?>">
										<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
									</a>
								<?php endif; ?>
							</div>
						</div>

					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		<?php else : ?>
			<div style="text-align:center;padding:var(--wp--preset--spacing--60) 0">
				<p style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--text-light)"><?php esc_html_e( 'Leadership profiles will appear here once added.', 'people-planet-thrive' ); ?></p>
			</div>
		<?php endif; ?>

	</div>

</main>

<?php
get_footer();
