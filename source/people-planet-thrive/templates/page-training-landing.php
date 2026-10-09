<?php
/**
 * Template: Training Landing Page
 *
 * Template Name: Training Landing
 *
 * @package PeoplePlanetThrive
 */

get_header();

// Get upcoming training (future start dates)
$upcoming_training = get_posts( array(
	'post_type'      => 'ppt_training',
	'posts_per_page' => 6,
	'meta_key'       => '_ppt_training_start_date',
	'orderby'        => 'meta_value',
	'order'          => 'ASC',
	'meta_query'     => array(
		array(
			'key'     => '_ppt_training_start_date',
			'value'   => current_time( 'Y-m-d' ),
			'compare' => '>=',
		),
	),
) );

// Get training types
$training_types = get_terms( array(
	'taxonomy'   => 'ppt_training_type',
	'hide_empty' => true,
	'number'     => 6,
) );
?>

<main class="wp-block-group site-main">
	
	<!-- Hero Section -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--deep-forest);color:white;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;text-align:center">
			<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Training & Learning', 'people-planet-thrive' ); ?></h1>
			<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;max-width:720px;margin:0 auto;opacity:0.9">
				<?php esc_html_e( 'Build your capacity with our courses, workshops, and training programs designed for researchers, practitioners, and changemakers.', 'people-planet-thrive' ); ?>
			</p>
		</div>
	</div>

	<!-- Training Types -->
	<?php if ( ! empty( $training_types ) && ! is_wp_error( $training_types ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Browse by Type', 'people-planet-thrive' ); ?></h2>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,200px),1fr));gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $training_types as $type ) : ?>
					<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--surface-alt);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center;transition:transform 0.2s ease,box-shadow 0.2s ease">
						<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php echo esc_html( $type->name ); ?></h3>
						<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
							<?php echo esc_html( $type->count ); ?> <?php esc_html_e( 'programs', 'people-planet-thrive' ); ?>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Upcoming Training -->
	<?php if ( ! empty( $upcoming_training ) ) : ?>
		<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
				<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--wp--preset--spacing--30)">
					<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin:0"><?php esc_html_e( 'Upcoming Training', 'people-planet-thrive' ); ?></h2>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_training' ) ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none">
						<?php esc_html_e( 'View All →', 'people-planet-thrive' ); ?>
					</a>
				</div>
				
				<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,320px),1fr));gap:var(--wp--preset--spacing--30)">
					<?php foreach ( $upcoming_training as $training ) : 
						$training_instructor = get_post_meta( $training->ID, '_ppt_training_instructor', true );
						$training_level = get_post_meta( $training->ID, '_ppt_training_level', true );
						$training_duration = get_post_meta( $training->ID, '_ppt_training_duration', true );
						$training_delivery = get_post_meta( $training->ID, '_ppt_training_delivery_mode', true );
						$training_start = get_post_meta( $training->ID, '_ppt_training_start_date', true );
						$training_price = get_post_meta( $training->ID, '_ppt_training_price', true );
						$training_is_free = get_post_meta( $training->ID, '_ppt_training_is_free', true );
						
						$formatted_start = $training_start ? date_i18n( get_option( 'date_format' ), strtotime( $training_start ) ) : '';
						?>
						<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;overflow:hidden;background-color:var(--wp--preset--color--white)">
							
							<?php if ( has_post_thumbnail( $training->ID ) ) : ?>
								<a href="<?php echo esc_url( get_permalink( $training->ID ) ); ?>">
									<?php echo get_the_post_thumbnail( $training->ID, 'medium', array( 'style' => 'width:100%;height:200px;object-fit:cover' ) ); ?>
								</a>
							<?php else : ?>
								<div style="width:100%;height:200px;background-color:var(--wp--preset--color--surface-alt);display:flex;align-items:center;justify-content:center">
									<span style="font-size:var(--wp--preset--font-size--48);color:var(--wp--preset--color--text-light)">🎓</span>
								</div>
							<?php endif; ?>

							<div style="padding:var(--wp--preset--spacing--20)">
								
								<?php if ( $training_delivery ) : ?>
									<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
										<?php echo esc_html( ucfirst( str_replace( '-', ' ', $training_delivery ) ) ); ?>
									</span>
								<?php endif; ?>

								<h3 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
									<a href="<?php echo esc_url( get_permalink( $training->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $training->post_title ); ?></a>
								</h3>

								<?php if ( $training_instructor ) : ?>
									<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
										<strong><?php esc_html_e( 'Instructor:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $training_instructor ); ?>
									</div>
								<?php endif; ?>

								<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10);font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
									<?php if ( $training_level ) : ?>
										<span><?php echo esc_html( ucfirst( $training_level ) ); ?></span>
									<?php endif; ?>
									<?php if ( $training_duration ) : ?>
										<span>· <?php echo esc_html( $training_duration ); ?></span>
									<?php endif; ?>
									<?php if ( $formatted_start ) : ?>
										<span>· <?php echo esc_html( $formatted_start ); ?></span>
									<?php endif; ?>
								</div>

								<div style="font-size:var(--wp--preset--font-size--16);font-weight:600">
									<?php if ( $training_is_free === '1' ) : ?>
										<span style="color:var(--wp--preset--color--success)"><?php esc_html_e( 'Free', 'people-planet-thrive' ); ?></span>
									<?php elseif ( $training_price ) : ?>
										<span style="color:var(--wp--preset--color--primary)">$<?php echo esc_html( $training_price ); ?></span>
									<?php endif; ?>
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
