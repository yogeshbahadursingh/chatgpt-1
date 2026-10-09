<?php
/**
 * Template: Archive Research Projects
 *
 * @package PeoplePlanetThrive
 */

get_header();
$status_filter = function_exists( 'ppt_research_status_filter' ) ? ppt_research_status_filter() : '';
$filter_url = get_post_type_archive_link( 'ppt_research_project' );
if ( ! empty( $_GET['ppt_topic'] ) && is_scalar( $_GET['ppt_topic'] ) ) {
	$filter_url = add_query_arg( 'ppt_topic', absint( $_GET['ppt_topic'] ), $filter_url );
}
?>

<main class="wp-block-group site-main">
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		
		<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700"><?php esc_html_e( 'Research Projects', 'people-planet-thrive' ); ?></h1>
		
		<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Explore our active and completed research initiatives.', 'people-planet-thrive' ); ?></p>

		<!-- Filters -->
		<div class="wp-block-group" style="border-top:1px solid var(--wp--preset--color--border);border-bottom:1px solid var(--wp--preset--color--border);margin-top:var(--wp--preset--spacing--30);margin-bottom:var(--wp--preset--spacing--40);padding:var(--wp--preset--spacing--20) 0">
			<p style="font-size:var(--wp--preset--font-size--14);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Filter by status:', 'people-planet-thrive' ); ?></p>
			<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
				<?php foreach ( array( '' => __( 'All', 'people-planet-thrive' ), 'active' => __( 'Active', 'people-planet-thrive' ), 'completed' => __( 'Completed', 'people-planet-thrive' ), 'planning' => __( 'Planning', 'people-planet-thrive' ), 'on-hold' => __( 'On hold', 'people-planet-thrive' ) ) as $value => $label ) : ?>
					<a href="<?php echo esc_url( $value ? add_query_arg( 'status', $value, $filter_url ) : $filter_url ); ?>"<?php if ( $status_filter === $value ) { echo ' aria-current="page"'; } ?> style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $label ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--30)">
				<?php while ( have_posts() ) : the_post();
					$status = get_post_meta( get_the_ID(), '_ppt_project_status', true );
					if ( 'planned' === $status ) { $status = 'planning'; }
					$area_id = get_post_meta( get_the_ID(), '_ppt_project_area_id', true );
					$lead_id = get_post_meta( get_the_ID(), '_ppt_project_lead_id', true );
					$start_date = get_post_meta( get_the_ID(), '_ppt_project_start_date', true );
					$end_date = get_post_meta( get_the_ID(), '_ppt_project_end_date', true );
					
					// Get area title
					$area_title = '';
					if ( $area_id ) {
						$area_title = get_the_title( $area_id );
					}
					
					// Get lead name
					$lead_name = '';
					if ( $lead_id ) {
						$lead_name = get_the_title( $lead_id );
					}
					
					// Status badge color
					$status_colors = array(
						'active'    => '#126B52',
						'completed' => '#6B7280',
						'planning'  => '#C69A45',
						'on-hold'   => '#B91C1C',
					);
					$status_color = isset( $status_colors[ $status ] ) ? $status_colors[ $status ] : '#6B7280';
					?>
					<div class="wp-block-group ppt-project-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--white)">
						
						<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--30)">
							<div class="wp-block-column" style="flex-basis:70%">
								
								<!-- Status Badge -->
								<?php if ( $status ) : ?>
									<span style="display:inline-block;padding:0.3em 0.8em;background-color:<?php echo esc_attr( $status_color ); ?>;color:white;border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
										<?php echo esc_html( ucfirst( $status ) ); ?>
									</span>
								<?php endif; ?>

								<!-- Title -->
								<h2 style="font-size:var(--wp--preset--font-size--28);line-height:1.3;font-weight:600;margin-top:var(--wp--preset--spacing--10);margin-bottom:var(--wp--preset--spacing--10)">
									<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
								</h2>

								<!-- Excerpt -->
								<?php if ( has_excerpt() ) : ?>
									<div style="font-size:var(--wp--preset--font-size--16);line-height:1.6;margin-bottom:var(--wp--preset--spacing--15)">
										<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
									</div>
								<?php endif; ?>

								<!-- Metadata -->
								<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
									<?php if ( $area_title ) : ?>
										<div><strong><?php esc_html_e( 'Area:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $area_title ); ?></div>
									<?php endif; ?>
									
									<?php if ( $lead_name ) : ?>
										<div><strong><?php esc_html_e( 'Lead:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $lead_name ); ?></div>
									<?php endif; ?>
									
									<?php if ( $start_date ) : ?>
										<div>
											<strong><?php esc_html_e( 'Timeline:', 'people-planet-thrive' ); ?></strong>
											<?php echo esc_html( date_i18n( 'M Y', strtotime( $start_date ) ) ); ?>
											<?php if ( $end_date ) : ?>
												– <?php echo esc_html( date_i18n( 'M Y', strtotime( $end_date ) ) ); ?>
											<?php else : ?>
												– <?php esc_html_e( 'Present', 'people-planet-thrive' ); ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>

							</div>

							<div class="wp-block-column" style="flex-basis:30%">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:auto;aspect-ratio:16/9;object-fit:cover;border-radius:4px' ) ); ?>
									</a>
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
