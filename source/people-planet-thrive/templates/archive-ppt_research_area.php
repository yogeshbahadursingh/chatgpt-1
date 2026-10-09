<?php
/**
 * Template: Archive Research Areas
 *
 * @package PeoplePlanetThrive
 */

get_header();
?>

<main class="wp-block-group site-main">
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		
		<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700"><?php esc_html_e( 'Research Areas', 'people-planet-thrive' ); ?></h1>
		
		<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Explore our research domains and fields of inquiry.', 'people-planet-thrive' ); ?></p>

		<hr style="margin:var(--wp--preset--spacing--50) 0;border:none;border-top:1px solid var(--wp--preset--color--border)">

		<?php if ( have_posts() ) : ?>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,350px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php while ( have_posts() ) : the_post();
					$description = get_post_meta( get_the_ID(), '_ppt_area_description', true );
					$keywords = get_post_meta( get_the_ID(), '_ppt_area_keywords', true );
					
					// Count projects in this area
					$project_count_query = new WP_Query( array(
						'post_type' => 'ppt_research_project',
						'meta_key' => '_ppt_project_area_id',
						'meta_value' => get_the_ID(),
						'posts_per_page' => 1,
						'fields' => 'ids',
						'no_found_rows' => false,
					) );
					$project_count = $project_count_query->found_posts;
					wp_reset_postdata();
					?>
					<div class="wp-block-group ppt-research-area-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--white);transition:transform 0.2s ease,box-shadow 0.2s ease">
						
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:200px;object-fit:cover;border-radius:4px;margin-bottom:var(--wp--preset--spacing--20)' ) ); ?>
							</a>
						<?php endif; ?>

						<h2 style="font-size:var(--wp--preset--font-size--24);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
						</h2>

						<?php if ( $description ) : ?>
							<div style="font-size:var(--wp--preset--font-size--16);line-height:1.6;margin-bottom:var(--wp--preset--spacing--15);color:var(--wp--preset--color--text-light)">
								<?php echo esc_html( wp_trim_words( $description, 30 ) ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $keywords ) : ?>
							<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10);margin-bottom:var(--wp--preset--spacing--15)">
								<?php
								$keyword_array = array_map( 'trim', explode( ',', $keywords ) );
								foreach ( array_slice( $keyword_array, 0, 5 ) as $keyword ) :
									?>
									<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12)"><?php echo esc_html( $keyword ); ?></span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
							<strong><?php echo esc_html( $project_count ); ?></strong> <?php esc_html_e( 'projects', 'people-planet-thrive' ); ?>
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
