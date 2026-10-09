<?php
/**
 * Template: Single Event
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

// Get all meta fields
$organizer        = get_post_meta( get_the_ID(), '_ppt_event_organizer', true );
$start_date       = get_post_meta( get_the_ID(), '_ppt_event_start_date', true );
$end_date         = get_post_meta( get_the_ID(), '_ppt_event_end_date', true );
$start_time       = get_post_meta( get_the_ID(), '_ppt_event_start_time', true );
$end_time         = get_post_meta( get_the_ID(), '_ppt_event_end_time', true );
$location         = get_post_meta( get_the_ID(), '_ppt_event_location', true );
$is_virtual       = get_post_meta( get_the_ID(), '_ppt_event_is_virtual', true );
$virtual_url      = get_post_meta( get_the_ID(), '_ppt_event_virtual_url', true );
$capacity         = get_post_meta( get_the_ID(), '_ppt_event_capacity', true );
$price            = get_post_meta( get_the_ID(), '_ppt_event_price', true );
$is_free          = get_post_meta( get_the_ID(), '_ppt_event_is_free', true );
$registration_url = get_post_meta( get_the_ID(), '_ppt_event_registration_url', true );
$product_id       = get_post_meta( get_the_ID(), '_ppt_event_product_id', true );

// Format dates
$formatted_start = $start_date ? date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ) : '';
$formatted_end = $end_date ? date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ) : '';

// Format times
$formatted_start_time = $start_time ? date_i18n( get_option( 'time_format' ), strtotime( $start_time ) ) : '';
$formatted_end_time = $end_time ? date_i18n( get_option( 'time_format' ), strtotime( $end_time ) ) : '';

// Get event type terms
$event_types = get_the_terms( get_the_ID(), 'ppt_event_type' );
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_event' ) ); ?>"><?php esc_html_e( 'Events', 'people-planet-thrive' ); ?></a>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Event Header -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<!-- Event Type Badge -->
		<?php if ( ! empty( $event_types ) && ! is_wp_error( $event_types ) ) : ?>
			<?php foreach ( $event_types as $type ) : ?>
				<span style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
					<?php echo esc_html( $type->name ); ?>
				</span>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if ( $is_virtual === '1' ) : ?>
			<span style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--info-light);border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10);margin-left:var(--wp--preset--spacing--10)">
				<?php esc_html_e( 'Virtual Event', 'people-planet-thrive' ); ?>
			</span>
		<?php endif; ?>

		<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

		<?php if ( $organizer ) : ?>
			<div style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--20)">
				<strong><?php esc_html_e( 'Organized by:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $organizer ); ?>
			</div>
		<?php endif; ?>

		<!-- Event Metadata -->
		<div class="wp-block-group" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,200px),1fr));gap:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--30);padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
			
			<?php if ( $formatted_start ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Date', 'people-planet-thrive' ); ?></strong>
					<span style="font-size:var(--wp--preset--font-size--16)">
						<?php echo esc_html( $formatted_start ); ?>
						<?php if ( $formatted_start_time ) : ?>
							<?php echo esc_html( ' at ' . $formatted_start_time ); ?>
						<?php endif; ?>
					</span>
					<?php if ( $formatted_end && $formatted_end !== $formatted_start ) : ?>
						<br><span style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
							<?php echo esc_html( 'to ' . $formatted_end ); ?>
							<?php if ( $formatted_end_time ) : ?>
								<?php echo esc_html( ' at ' . $formatted_end_time ); ?>
							<?php endif; ?>
						</span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $location ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Location', 'people-planet-thrive' ); ?></strong>
					<span style="font-size:var(--wp--preset--font-size--16)"><?php echo esc_html( $location ); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( $is_virtual === '1' && $virtual_url ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Virtual Platform', 'people-planet-thrive' ); ?></strong>
					<a href="<?php echo esc_url( $virtual_url ); ?>" target="_blank" rel="noopener" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary)"><?php esc_html_e( 'Join Online', 'people-planet-thrive' ); ?></a>
				</div>
			<?php endif; ?>

			<?php if ( $capacity ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Capacity', 'people-planet-thrive' ); ?></strong>
					<span style="font-size:var(--wp--preset--font-size--16)"><?php echo esc_html( $capacity ); ?> <?php esc_html_e( 'attendees', 'people-planet-thrive' ); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( $is_free === '1' ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Price', 'people-planet-thrive' ); ?></strong>
					<span style="font-size:var(--wp--preset--font-size--16);font-weight:600;color:var(--wp--preset--color--success)"><?php esc_html_e( 'Free', 'people-planet-thrive' ); ?></span>
				</div>
			<?php elseif ( $price ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Price', 'people-planet-thrive' ); ?></strong>
					<span style="font-size:var(--wp--preset--font-size--16);font-weight:600;color:var(--wp--preset--color--primary)">$<?php echo esc_html( $price ); ?></span>
				</div>
			<?php endif; ?>

		</div>

		<!-- Excerpt -->
		<?php if ( has_excerpt() ) : ?>
			<div style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-bottom:var(--wp--preset--spacing--30);color:var(--wp--preset--color--text-light)">
				<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
			</div>
		<?php endif; ?>

		<!-- Action Buttons -->
		<div class="wp-block-group" style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--15)">
			<?php if ( $registration_url ) : ?>
				<a href="<?php echo esc_url( $registration_url ); ?>" class="wp-block-button__link wp-element-button" target="_blank" rel="noopener"><?php esc_html_e( 'Register Now', 'people-planet-thrive' ); ?></a>
			<?php elseif ( $product_id && class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Register Now', 'people-planet-thrive' ); ?></a>
			<?php endif; ?>
		</div>

	</div>

	<!-- Event Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
		<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
			<?php the_content(); ?>
		</div>
	</div>

	<!-- Event Types -->
	<?php if ( ! empty( $event_types ) && ! is_wp_error( $event_types ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--40) var(--wp--preset--spacing--30)">
			<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10)">
				<?php foreach ( $event_types as $type ) : ?>
					<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text);text-decoration:none">
						<?php echo esc_html( $type->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
