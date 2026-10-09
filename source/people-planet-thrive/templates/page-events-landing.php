<?php
/**
 * Template: Events Landing Page
 *
 * Template Name: Events Landing
 *
 * @package PeoplePlanetThrive
 */

get_header();

// Get upcoming events (future start dates)
$upcoming_events = get_posts( array(
	'post_type'      => 'ppt_event',
	'posts_per_page' => 6,
	'meta_key'       => '_ppt_event_start_date',
	'orderby'        => 'meta_value',
	'order'          => 'ASC',
	'meta_query'     => array(
		array(
			'key'     => '_ppt_event_start_date',
			'value'   => current_time( 'Y-m-d' ),
			'compare' => '>=',
		),
	),
) );

// Get event types
$event_types = get_terms( array(
	'taxonomy'   => 'ppt_event_type',
	'hide_empty' => true,
	'number'     => 6,
) );
?>

<main class="wp-block-group site-main">
	
	<!-- Hero Section -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--deep-forest);color:white;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;text-align:center">
			<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Events', 'people-planet-thrive' ); ?></h1>
			<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;max-width:720px;margin:0 auto;opacity:0.9">
				<?php esc_html_e( 'Join us at conferences, workshops, webinars, and networking events connecting researchers, practitioners, and changemakers.', 'people-planet-thrive' ); ?>
			</p>
		</div>
	</div>

	<!-- Event Types -->
	<?php if ( ! empty( $event_types ) && ! is_wp_error( $event_types ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Browse by Type', 'people-planet-thrive' ); ?></h2>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,200px),1fr));gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $event_types as $type ) : ?>
					<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--surface-alt);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center;transition:transform 0.2s ease,box-shadow 0.2s ease">
						<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php echo esc_html( $type->name ); ?></h3>
						<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
							<?php echo esc_html( $type->count ); ?> <?php esc_html_e( 'events', 'people-planet-thrive' ); ?>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Upcoming Events -->
	<?php if ( ! empty( $upcoming_events ) ) : ?>
		<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
				<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--wp--preset--spacing--30)">
					<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin:0"><?php esc_html_e( 'Upcoming Events', 'people-planet-thrive' ); ?></h2>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_event' ) ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none">
						<?php esc_html_e( 'View All →', 'people-planet-thrive' ); ?>
					</a>
				</div>
				
				<div style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--20)">
					<?php foreach ( $upcoming_events as $event ) : 
						$event_organizer = get_post_meta( $event->ID, '_ppt_event_organizer', true );
						$event_start = get_post_meta( $event->ID, '_ppt_event_start_date', true );
						$event_start_time = get_post_meta( $event->ID, '_ppt_event_start_time', true );
						$event_location = get_post_meta( $event->ID, '_ppt_event_location', true );
						$event_is_virtual = get_post_meta( $event->ID, '_ppt_event_is_virtual', true );
						$event_price = get_post_meta( $event->ID, '_ppt_event_price', true );
						$event_is_free = get_post_meta( $event->ID, '_ppt_event_is_free', true );
						
						$formatted_start = $event_start ? date_i18n( get_option( 'date_format' ), strtotime( $event_start ) ) : '';
						$formatted_time = $event_start_time ? date_i18n( get_option( 'time_format' ), strtotime( $event_start_time ) ) : '';
						?>
						<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);padding:var(--wp--preset--spacing--30);border-radius:4px;background-color:var(--wp--preset--color--white)">
							
							<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--30)">
								<div class="wp-block-column" style="flex-basis:70%">
									
									<!-- Event Type Badge -->
									<?php
									$event_type_terms = get_the_terms( $event->ID, 'ppt_event_type' );
									if ( $event_type_terms && ! is_wp_error( $event_type_terms ) ) :
										foreach ( $event_type_terms as $type ) :
											?>
											<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
												<?php echo esc_html( $type->name ); ?>
											</span>
										<?php endforeach; ?>
									<?php endif; ?>

									<?php if ( $event_is_virtual === '1' ) : ?>
										<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--info-light);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10);margin-left:var(--wp--preset--spacing--10)">
											<?php esc_html_e( 'Virtual', 'people-planet-thrive' ); ?>
										</span>
									<?php endif; ?>

									<!-- Title -->
									<h3 style="font-size:var(--wp--preset--font-size--24);line-height:1.3;font-weight:600;margin-top:var(--wp--preset--spacing--10);margin-bottom:var(--wp--preset--spacing--10)">
										<a href="<?php echo esc_url( get_permalink( $event->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $event->post_title ); ?></a>
									</h3>

									<?php if ( $event_organizer ) : ?>
										<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
											<strong><?php esc_html_e( 'Organized by:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $event_organizer ); ?>
										</div>
									<?php endif; ?>

									<!-- Excerpt -->
									<?php if ( $event->post_excerpt ) : ?>
										<div style="font-size:var(--wp--preset--font-size--16);line-height:1.6;margin-bottom:var(--wp--preset--spacing--15);color:var(--wp--preset--color--text-light)">
											<?php echo esc_html( wp_trim_words( $event->post_excerpt, 25 ) ); ?>
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
											</div>
										<?php endif; ?>
										
										<?php if ( $event_location ) : ?>
											<div><strong><?php esc_html_e( 'Location:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $event_location ); ?></div>
										<?php endif; ?>
									</div>

								</div>

								<div class="wp-block-column" style="flex-basis:30%">
									<?php if ( has_post_thumbnail( $event->ID ) ) : ?>
										<a href="<?php echo esc_url( get_permalink( $event->ID ) ); ?>">
											<?php echo get_the_post_thumbnail( $event->ID, 'medium', array( 'style' => 'width:100%;height:auto;aspect-ratio:16/9;object-fit:cover;border-radius:4px' ) ); ?>
										</a>
									<?php endif; ?>

									<div style="margin-top:var(--wp--preset--spacing--15);font-size:var(--wp--preset--font-size--16);font-weight:600;text-align:center">
										<?php if ( $event_is_free === '1' ) : ?>
											<span style="color:var(--wp--preset--color--success)"><?php esc_html_e( 'Free', 'people-planet-thrive' ); ?></span>
										<?php elseif ( $event_price ) : ?>
											<span style="color:var(--wp--preset--color--primary)">$<?php echo esc_html( $event_price ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>

						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<!-- Page Content -->
	<?php if ( have_posts() ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
