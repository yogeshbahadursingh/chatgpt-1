<?php
/**
 * Template: Archive Events
 *
 * @package PeoplePlanetThrive
 */

get_header();
?>

<main class="wp-block-group site-main">
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		
		<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700"><?php esc_html_e( 'Events', 'people-planet-thrive' ); ?></h1>
		
		<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Join us at conferences, workshops, webinars, and networking events.', 'people-planet-thrive' ); ?></p>

		<!-- Filters -->
		<div class="wp-block-group" style="border-top:1px solid var(--wp--preset--color--border);border-bottom:1px solid var(--wp--preset--color--border);margin-top:var(--wp--preset--spacing--30);margin-bottom:var(--wp--preset--spacing--40);padding:var(--wp--preset--spacing--20) 0">
			<p style="font-size:var(--wp--preset--font-size--14);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Filter by type:', 'people-planet-thrive' ); ?></p>
			<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
				<?php
				$event_types = get_terms( array(
					'taxonomy'   => 'ppt_event_type',
					'hide_empty' => true,
				) );
				?>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_event' ) ); ?>" style="font-size:var(--wp--preset--font-size--14)"><?php esc_html_e( 'All', 'people-planet-thrive' ); ?></a>
				<?php if ( ! empty( $event_types ) && ! is_wp_error( $event_types ) ) : ?>
					<?php foreach ( $event_types as $type ) : ?>
						<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $type->name ); ?></a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--30)">
				<?php while ( have_posts() ) : the_post();
					$organizer   = get_post_meta( get_the_ID(), '_ppt_event_organizer', true );
					$start_date  = get_post_meta( get_the_ID(), '_ppt_event_start_date', true );
					$end_date    = get_post_meta( get_the_ID(), '_ppt_event_end_date', true );
					$start_time  = get_post_meta( get_the_ID(), '_ppt_event_start_time', true );
					$location    = get_post_meta( get_the_ID(), '_ppt_event_location', true );
					$is_virtual  = get_post_meta( get_the_ID(), '_ppt_event_is_virtual', true );
					$price       = get_post_meta( get_the_ID(), '_ppt_event_price', true );
					$is_free     = get_post_meta( get_the_ID(), '_ppt_event_is_free', true );
					
					// Format dates
					$formatted_start = $start_date ? date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ) : '';
					$formatted_end = $end_date ? date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ) : '';
					
					// Format time
					$formatted_time = '';
					if ( $start_time ) {
						$formatted_time = date_i18n( get_option( 'time_format' ), strtotime( $start_time ) );
					}
					?>
					<div class="wp-block-group ppt-event-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--white);transition:box-shadow 0.2s ease">
						
						<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--30)">
							<div class="wp-block-column" style="flex-basis:70%">
								
								<!-- Event Type Badge -->
								<?php
								$event_type_terms = get_the_terms( get_the_ID(), 'ppt_event_type' );
								if ( $event_type_terms && ! is_wp_error( $event_type_terms ) ) :
									foreach ( $event_type_terms as $type ) :
										?>
										<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
											<?php echo esc_html( $type->name ); ?>
										</span>
									<?php endforeach; ?>
								<?php endif; ?>

								<?php if ( $is_virtual === '1' ) : ?>
									<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--info-light);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10);margin-left:var(--wp--preset--spacing--10)">
										<?php esc_html_e( 'Virtual', 'people-planet-thrive' ); ?>
									</span>
								<?php endif; ?>

								<!-- Title -->
								<h2 style="font-size:var(--wp--preset--font-size--28);line-height:1.3;font-weight:600;margin-top:var(--wp--preset--spacing--10);margin-bottom:var(--wp--preset--spacing--10)">
									<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
								</h2>

								<?php if ( $organizer ) : ?>
									<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
										<strong><?php esc_html_e( 'Organized by:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $organizer ); ?>
									</div>
								<?php endif; ?>

								<!-- Excerpt -->
								<?php if ( has_excerpt() ) : ?>
									<div style="font-size:var(--wp--preset--font-size--16);line-height:1.6;margin-bottom:var(--wp--preset--spacing--15)">
										<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
									</div>
								<?php endif; ?>

								<!-- Metadata -->
								<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
									<?php if ( $formatted_start ) : ?>
										<div>
											<strong><?php esc_html_e( 'Date:', 'people-planet-thrive' ); ?></strong>
											<?php echo esc_html( $formatted_start ); ?>
											<?php if ( $formatted_time ) : ?>
												<?php echo esc_html( ' at ' . $formatted_time ); ?>
											<?php endif; ?>
											<?php if ( $formatted_end && $formatted_end !== $formatted_start ) : ?>
												<?php echo esc_html( ' – ' . $formatted_end ); ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									
									<?php if ( $location ) : ?>
										<div><strong><?php esc_html_e( 'Location:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $location ); ?></div>
									<?php endif; ?>
								</div>

							</div>

							<div class="wp-block-column" style="flex-basis:30%">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:auto;aspect-ratio:16/9;object-fit:cover;border-radius:4px' ) ); ?>
									</a>
								<?php endif; ?>

								<div style="margin-top:var(--wp--preset--spacing--15);font-size:var(--wp--preset--font-size--16);font-weight:600;text-align:center">
									<?php if ( $is_free === '1' ) : ?>
										<span style="color:var(--wp--preset--color--success)"><?php esc_html_e( 'Free', 'people-planet-thrive' ); ?></span>
									<?php elseif ( $price ) : ?>
										<span style="color:var(--wp--preset--color--primary)">$<?php echo esc_html( $price ); ?></span>
									<?php endif; ?>
								</div>
							</div>
						</div>

					</div>
				<?php endwhile; ?>
			</div>

			<!-- Pagination -->
			<div style="margin-top:var(--wp--preset--spacing--50)">
				<?php
				the_posts_pagination( array(
					'mid_size' => 2,
					'prev_text' => __( '← Previous', 'people-planet-thrive' ),
					'next_text' => __( 'Next →', 'people-planet-thrive' ),
				) );
				?>
			</div>

		<?php else : ?>
			<p style="font-size:var(--wp--preset--font-size--18);text-align:center;padding:var(--wp--preset--spacing--50) 0"><?php esc_html_e( 'New work is being prepared for this programme.', 'people-planet-thrive' ); ?></p>
		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
