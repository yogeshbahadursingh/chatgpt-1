<?php
/**
 * Template: Archive Training
 *
 * @package PeoplePlanetThrive
 */

get_header();
?>

<main class="wp-block-group site-main">
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		
		<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700"><?php esc_html_e( 'Training & Learning', 'people-planet-thrive' ); ?></h1>
		
		<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Build your capacity with our courses, workshops, and training programs.', 'people-planet-thrive' ); ?></p>

		<!-- Filters -->
		<div class="wp-block-group" style="border-top:1px solid var(--wp--preset--color--border);border-bottom:1px solid var(--wp--preset--color--border);margin-top:var(--wp--preset--spacing--30);margin-bottom:var(--wp--preset--spacing--40);padding:var(--wp--preset--spacing--20) 0">
			<p style="font-size:var(--wp--preset--font-size--14);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Filter by type:', 'people-planet-thrive' ); ?></p>
			<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
				<?php
				$training_types = get_terms( array(
					'taxonomy'   => 'ppt_training_type',
					'hide_empty' => true,
				) );
				?>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_training' ) ); ?>" style="font-size:var(--wp--preset--font-size--14)"><?php esc_html_e( 'All', 'people-planet-thrive' ); ?></a>
				<?php if ( ! empty( $training_types ) && ! is_wp_error( $training_types ) ) : ?>
					<?php foreach ( $training_types as $type ) : ?>
						<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $type->name ); ?></a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,320px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php while ( have_posts() ) : the_post();
					$instructor    = get_post_meta( get_the_ID(), '_ppt_training_instructor', true );
					$level         = get_post_meta( get_the_ID(), '_ppt_training_level', true );
					$duration      = get_post_meta( get_the_ID(), '_ppt_training_duration', true );
					$delivery_mode = get_post_meta( get_the_ID(), '_ppt_training_delivery_mode', true );
					$start_date    = get_post_meta( get_the_ID(), '_ppt_training_start_date', true );
					$price         = get_post_meta( get_the_ID(), '_ppt_training_price', true );
					$is_free       = get_post_meta( get_the_ID(), '_ppt_training_is_free', true );
					
					// Format date
					$formatted_date = '';
					if ( $start_date ) {
						$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $start_date ) );
					}
					?>
					<div class="wp-block-group ppt-training-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;overflow:hidden;background-color:var(--wp--preset--color--white);transition:transform 0.2s ease,box-shadow 0.2s ease">
						
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:200px;object-fit:cover' ) ); ?>
							</a>
						<?php else : ?>
							<div style="width:100%;height:200px;background-color:var(--wp--preset--color--surface-alt);display:flex;align-items:center;justify-content:center">
								<span style="font-size:var(--wp--preset--font-size--48);color:var(--wp--preset--color--text-light)">🎓</span>
							</div>
						<?php endif; ?>

						<div style="padding:var(--wp--preset--spacing--20)">
							
							<?php if ( $delivery_mode ) : ?>
								<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
									<?php echo esc_html( ucfirst( str_replace( '-', ' ', $delivery_mode ) ) ); ?>
								</span>
							<?php endif; ?>

							<h2 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
								<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
							</h2>

							<?php if ( $instructor ) : ?>
								<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
									<strong><?php esc_html_e( 'Instructor:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $instructor ); ?>
								</div>
							<?php endif; ?>

							<?php if ( has_excerpt() ) : ?>
								<div style="font-size:var(--wp--preset--font-size--14);line-height:1.5;margin-bottom:var(--wp--preset--spacing--15);color:var(--wp--preset--color--text-light)">
									<?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
								</div>
							<?php endif; ?>

							<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10);font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
								<?php if ( $level ) : ?>
									<span><?php echo esc_html( ucfirst( $level ) ); ?></span>
								<?php endif; ?>
								<?php if ( $duration ) : ?>
									<span>· <?php echo esc_html( $duration ); ?></span>
								<?php endif; ?>
								<?php if ( $formatted_date ) : ?>
									<span>· <?php echo esc_html( $formatted_date ); ?></span>
								<?php endif; ?>
							</div>

							<div style="font-size:var(--wp--preset--font-size--16);font-weight:600">
								<?php if ( $is_free === '1' ) : ?>
									<span style="color:var(--wp--preset--color--success)"><?php esc_html_e( 'Free', 'people-planet-thrive' ); ?></span>
								<?php elseif ( $price ) : ?>
									<span style="color:var(--wp--preset--color--primary)">$<?php echo esc_html( $price ); ?></span>
								<?php endif; ?>
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
