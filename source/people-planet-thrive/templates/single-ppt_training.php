<?php
/**
 * Template: Single Training
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

// Get all meta fields
$instructor        = get_post_meta( get_the_ID(), '_ppt_training_instructor', true );
$learning_outcomes = get_post_meta( get_the_ID(), '_ppt_training_learning_outcomes', true );
$audience          = get_post_meta( get_the_ID(), '_ppt_training_audience', true );
$level             = get_post_meta( get_the_ID(), '_ppt_training_level', true );
$duration          = get_post_meta( get_the_ID(), '_ppt_training_duration', true );
$delivery_mode     = get_post_meta( get_the_ID(), '_ppt_training_delivery_mode', true );
$start_date        = get_post_meta( get_the_ID(), '_ppt_training_start_date', true );
$end_date          = get_post_meta( get_the_ID(), '_ppt_training_end_date', true );
$location          = get_post_meta( get_the_ID(), '_ppt_training_location', true );
$capacity          = get_post_meta( get_the_ID(), '_ppt_training_capacity', true );
$price             = get_post_meta( get_the_ID(), '_ppt_training_price', true );
$is_free           = get_post_meta( get_the_ID(), '_ppt_training_is_free', true );
$registration_url  = get_post_meta( get_the_ID(), '_ppt_training_registration_url', true );
$product_id        = get_post_meta( get_the_ID(), '_ppt_training_product_id', true );

// Format dates
$formatted_start = $start_date ? date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ) : '';
$formatted_end = $end_date ? date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ) : '';

// Get training type terms
$training_types = get_the_terms( get_the_ID(), 'ppt_training_type' );
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_training' ) ); ?>"><?php esc_html_e( 'Training', 'people-planet-thrive' ); ?></a>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Training Header -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--50)">
			
			<!-- Training Image -->
			<div class="wp-block-column" style="flex-basis:40%">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:4px;box-shadow:0 4px 12px rgba(0,0,0,0.1)' ) ); ?>
				<?php else : ?>
					<div style="width:100%;aspect-ratio:16/9;background-color:var(--wp--preset--color--surface-alt);border-radius:4px;display:flex;align-items:center;justify-content:center">
						<span style="font-size:var(--wp--preset--font-size--60);color:var(--wp--preset--color--text-light)">🎓</span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Training Info -->
			<div class="wp-block-column" style="flex-basis:60%">
				
				<?php if ( $delivery_mode ) : ?>
					<span style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
						<?php echo esc_html( ucfirst( str_replace( '-', ' ', $delivery_mode ) ) ); ?>
					</span>
				<?php endif; ?>

				<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

				<?php if ( $instructor ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--20)">
						<strong><?php esc_html_e( 'Instructor:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $instructor ); ?>
					</div>
				<?php endif; ?>

				<!-- Metadata Grid -->
				<div class="wp-block-group" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,150px),1fr));gap:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--30);padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
					
					<?php if ( $level ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Level', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( ucfirst( $level ) ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $duration ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Duration', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $duration ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $formatted_start ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Start Date', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $formatted_start ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $formatted_end ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'End Date', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $formatted_end ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $location ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Location', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $location ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $capacity ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Capacity', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $capacity ); ?> <?php esc_html_e( 'participants', 'people-planet-thrive' ); ?></span>
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
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7;margin-bottom:var(--wp--preset--spacing--30);color:var(--wp--preset--color--text-light)">
						<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
					</div>
				<?php endif; ?>

				<!-- Action Buttons -->
				<div class="wp-block-group" style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--15)">
					<?php if ( $registration_url ) : ?>
						<a href="<?php echo esc_url( $registration_url ); ?>" class="wp-block-button__link wp-element-button" target="_blank" rel="noopener"><?php esc_html_e( 'Register Now', 'people-planet-thrive' ); ?></a>
					<?php elseif ( $product_id && class_exists( 'WooCommerce' ) ) : ?>
						<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Enroll Now', 'people-planet-thrive' ); ?></a>
					<?php endif; ?>
				</div>

			</div>

		</div>
	</div>

	<!-- Training Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
		<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
			<?php the_content(); ?>
		</div>
	</div>

	<!-- Learning Outcomes -->
	<?php if ( $learning_outcomes ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Learning Outcomes', 'people-planet-thrive' ); ?></h2>
			<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php echo wp_kses_post( wpautop( $learning_outcomes ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Target Audience -->
	<?php if ( $audience ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Target Audience', 'people-planet-thrive' ); ?></h2>
			<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php echo wp_kses_post( wpautop( $audience ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Training Types -->
	<?php if ( ! empty( $training_types ) && ! is_wp_error( $training_types ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--40) var(--wp--preset--spacing--30)">
			<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10)">
				<?php foreach ( $training_types as $type ) : ?>
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
