<?php
/**
 * Template: Partners Page
 *
 * Template Name: Partners
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

	<!-- Partners Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<!-- Page Content -->
		<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7;margin-bottom:var(--wp--preset--spacing--40)">
			<?php the_content(); ?>
		</div>

		<!-- Partners Grid -->
		<?php
		$partners = new WP_Query( array(
			'post_type'      => 'ppt_partner',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		) );

		if ( $partners->have_posts() ) :
			?>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,280px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php while ( $partners->have_posts() ) : $partners->the_post();
					$partner_type = get_post_meta( get_the_ID(), '_ppt_partner_type', true );
					$website = get_post_meta( get_the_ID(), '_ppt_partner_website', true );
					?>
					<div class="wp-block-group ppt-partner-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--white);transition:transform 0.2s ease,box-shadow 0.2s ease">
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div style="margin-bottom:var(--wp--preset--spacing--20);text-align:center">
								<?php the_post_thumbnail( 'medium', array( 'style' => 'max-width:200px;height:auto;margin:0 auto' ) ); ?>
							</div>
						<?php endif; ?>

						<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--10);text-align:center">
							<?php if ( $website ) : ?>
								<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
							<?php else : ?>
								<?php the_title(); ?>
							<?php endif; ?>
						</h3>

						<?php if ( $partner_type ) : ?>
							<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--primary);margin-bottom:var(--wp--preset--spacing--15);text-align:center;font-weight:500">
								<?php echo esc_html( $partner_type ); ?>
							</div>
						<?php endif; ?>

						<?php if ( has_excerpt() ) : ?>
							<div style="font-size:var(--wp--preset--font-size--14);line-height:1.6;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
								<?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $website ) : ?>
							<div style="text-align:center">
								<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener" style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--primary);text-decoration:none">
									<?php esc_html_e( 'Visit Website →', 'people-planet-thrive' ); ?>
								</a>
							</div>
						<?php endif; ?>

					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		<?php else : ?>
			<div style="text-align:center;padding:var(--wp--preset--spacing--60) 0">
				<p style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--text-light)"><?php esc_html_e( 'Partner information will appear here once added.', 'people-planet-thrive' ); ?></p>
			</div>
		<?php endif; ?>

	</div>

</main>

<?php
get_footer();
