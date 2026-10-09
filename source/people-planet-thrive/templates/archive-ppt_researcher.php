<?php
/**
 * Template: Archive Researchers
 *
 * @package PeoplePlanetThrive
 */

get_header();
?>

<main class="wp-block-group site-main">
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		
		<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700"><?php esc_html_e( 'Researchers', 'people-planet-thrive' ); ?></h1>
		
		<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Meet our research team and collaborators.', 'people-planet-thrive' ); ?></p>

		<hr style="margin:var(--wp--preset--spacing--50) 0;border:none;border-top:1px solid var(--wp--preset--color--border)">

		<?php if ( have_posts() ) : ?>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,280px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php while ( have_posts() ) : the_post();
					$role = get_post_meta( get_the_ID(), '_ppt_researcher_role', true );
					$expertise = get_post_meta( get_the_ID(), '_ppt_researcher_expertise', true );
					$orcid = get_post_meta( get_the_ID(), '_ppt_researcher_orcid', true );
					
					// Count projects
					$project_count_query = new WP_Query( array(
						'post_type' => 'ppt_research_project',
						'meta_query' => array(
							'relation' => 'OR',
							array(
								'key'   => '_ppt_project_lead_id',
								'value' => get_the_ID(),
							),
							array(
								'key'     => '_ppt_project_team',
								'value'   => '(^|,)[[:space:]]*'.get_the_ID().'[[:space:]]*(,|$)',
								'compare' => 'REGEXP',
							),
						),
						'posts_per_page' => 1,
						'fields' => 'ids',
						'no_found_rows' => false,
					) );
					$project_count = $project_count_query->found_posts;
					wp_reset_postdata();
					?>
					<div class="wp-block-group ppt-researcher-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--white);text-align:center;transition:transform 0.2s ease,box-shadow 0.2s ease">
						
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium', array( 'style' => 'width:120px;height:120px;border-radius:50%;object-fit:cover;margin:0 auto var(--wp--preset--spacing--20);border:3px solid var(--wp--preset--color--border)' ) ); ?>
							</a>
						<?php endif; ?>

						<h2 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
						</h2>

						<?php if ( $role ) : ?>
							<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
								<?php echo esc_html( $role ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $expertise ) : ?>
							<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10);justify-content:center;margin-bottom:var(--wp--preset--spacing--15)">
								<?php
								$expertise_array = array_map( 'trim', explode( ',', $expertise ) );
								foreach ( array_slice( $expertise_array, 0, 3 ) as $area ) :
									?>
									<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12)"><?php echo esc_html( $area ); ?></span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<?php if ( $orcid ) : ?>
							<div style="font-size:var(--wp--preset--font-size--12);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
								ORCID: <?php echo esc_html( $orcid ); ?>
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
