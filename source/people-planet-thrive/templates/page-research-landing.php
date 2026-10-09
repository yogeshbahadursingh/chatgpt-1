<?php
/**
 * Template: Research Landing Page
 *
 * Template Name: Research Landing
 *
 * @package PeoplePlanetThrive
 */

get_header();

// Get research areas
$research_areas = get_posts( array(
	'post_type'      => 'ppt_research_area',
	'posts_per_page' => 6,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );

// Get active projects
$active_projects = get_posts( array(
	'post_type'      => 'ppt_research_project',
	'posts_per_page' => 3,
	'meta_key'       => '_ppt_project_status',
	'meta_value'     => 'active',
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

// Get researchers
$researchers = get_posts( array(
	'post_type'      => 'ppt_researcher',
	'posts_per_page' => 6,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );
?>

<main class="wp-block-group site-main">
	
	<!-- Hero Section -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--deep-forest);color:white;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;text-align:center">
			<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Research', 'people-planet-thrive' ); ?></h1>
			<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;max-width:720px;margin:0 auto;opacity:0.9">
				<?php esc_html_e( 'Advancing knowledge through rigorous inquiry, interdisciplinary collaboration, and commitment to meaningful impact.', 'people-planet-thrive' ); ?>
			</p>
		</div>
	</div>

	<!-- Research Areas -->
	<?php if ( ! empty( $research_areas ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
			<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--wp--preset--spacing--30)">
				<h2 style="font-size:var(--wp--preset--font-size--40);font-weight:700;margin:0"><?php esc_html_e( 'Research Areas', 'people-planet-thrive' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_research_area' ) ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none">
					<?php esc_html_e( 'View All →', 'people-planet-thrive' ); ?>
				</a>
			</div>
			
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,350px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php foreach ( $research_areas as $area ) : 
					$description = get_post_meta( $area->ID, '_ppt_area_description', true );
					$keywords = get_post_meta( $area->ID, '_ppt_area_keywords', true );
					
					// Count projects
					$project_count_query = new WP_Query( array(
						'post_type' => 'ppt_research_project',
						'meta_key' => '_ppt_project_area_id',
						'meta_value' => $area->ID,
						'posts_per_page' => 1,
						'fields' => 'ids',
						'no_found_rows' => false,
					) );
					$project_count = $project_count_query->found_posts;
					wp_reset_postdata();
					?>
					<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--white)">
						
						<?php if ( has_post_thumbnail( $area->ID ) ) : ?>
							<a href="<?php echo esc_url( get_permalink( $area->ID ) ); ?>">
								<?php echo get_the_post_thumbnail( $area->ID, 'medium', array( 'style' => 'width:100%;height:200px;object-fit:cover;border-radius:4px;margin-bottom:var(--wp--preset--spacing--20)' ) ); ?>
							</a>
						<?php endif; ?>

						<h3 style="font-size:var(--wp--preset--font-size--24);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php echo esc_url( get_permalink( $area->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $area->post_title ); ?></a>
						</h3>

						<?php if ( $description ) : ?>
							<div style="font-size:var(--wp--preset--font-size--16);line-height:1.6;margin-bottom:var(--wp--preset--spacing--15);color:var(--wp--preset--color--text-light)">
								<?php echo esc_html( wp_trim_words( $description, 25 ) ); ?>
							</div>
						<?php endif; ?>

						<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
							<strong><?php echo esc_html( $project_count ); ?></strong> <?php esc_html_e( 'projects', 'people-planet-thrive' ); ?>
						</div>

					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Active Projects -->
	<?php if ( ! empty( $active_projects ) ) : ?>
		<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
			<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
				<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--wp--preset--spacing--30)">
					<h2 style="font-size:var(--wp--preset--font-size--40);font-weight:700;margin:0"><?php esc_html_e( 'Active Projects', 'people-planet-thrive' ); ?></h2>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_research_project' ) ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none">
						<?php esc_html_e( 'View All →', 'people-planet-thrive' ); ?>
					</a>
				</div>
				
				<div style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--20)">
					<?php foreach ( $active_projects as $project ) : 
						$area_id = get_post_meta( $project->ID, '_ppt_project_area_id', true );
						$lead_id = get_post_meta( $project->ID, '_ppt_project_lead_id', true );
						
						$area_title = $area_id ? get_the_title( $area_id ) : '';
						$lead_name = $lead_id ? get_the_title( $lead_id ) : '';
						?>
						<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);padding:var(--wp--preset--spacing--30);border-radius:4px;background-color:var(--wp--preset--color--white)">
							
							<span style="display:inline-block;padding:0.3em 0.8em;background-color:#126B52;color:white;border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
								<?php esc_html_e( 'Active', 'people-planet-thrive' ); ?>
							</span>

							<h3 style="font-size:var(--wp--preset--font-size--24);line-height:1.3;font-weight:600;margin-top:var(--wp--preset--spacing--10);margin-bottom:var(--wp--preset--spacing--10)">
								<a href="<?php echo esc_url( get_permalink( $project->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $project->post_title ); ?></a>
							</h3>

							<?php if ( $project->post_excerpt ) : ?>
								<div style="font-size:var(--wp--preset--font-size--16);line-height:1.6;margin-bottom:var(--wp--preset--spacing--15);color:var(--wp--preset--color--text-light)">
									<?php echo esc_html( wp_trim_words( $project->post_excerpt, 30 ) ); ?>
								</div>
							<?php endif; ?>

							<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
								<?php if ( $area_title ) : ?>
									<div><strong><?php esc_html_e( 'Area:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $area_title ); ?></div>
								<?php endif; ?>
								
								<?php if ( $lead_name ) : ?>
									<div><strong><?php esc_html_e( 'Lead:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $lead_name ); ?></div>
								<?php endif; ?>
							</div>

						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<!-- Researchers -->
	<?php if ( ! empty( $researchers ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
			<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--wp--preset--spacing--30)">
				<h2 style="font-size:var(--wp--preset--font-size--40);font-weight:700;margin:0"><?php esc_html_e( 'Our Researchers', 'people-planet-thrive' ); ?></h2>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_researcher' ) ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none">
					<?php esc_html_e( 'View All →', 'people-planet-thrive' ); ?>
				</a>
			</div>
			
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,250px),1fr));gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $researchers as $researcher ) : 
					$role = get_post_meta( $researcher->ID, '_ppt_researcher_role', true );
					?>
					<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);padding:var(--wp--preset--spacing--20);border-radius:4px;text-align:center;background-color:var(--wp--preset--color--white)">
						
						<?php if ( has_post_thumbnail( $researcher->ID ) ) : ?>
							<?php echo get_the_post_thumbnail( $researcher->ID, 'thumbnail', array( 'style' => 'width:100px;height:100px;border-radius:50%;object-fit:cover;margin:0 auto var(--wp--preset--spacing--10);border:3px solid var(--wp--preset--color--border)' ) ); ?>
						<?php endif; ?>

						<h3 style="font-size:var(--wp--preset--font-size--18);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php echo esc_url( get_permalink( $researcher->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $researcher->post_title ); ?></a>
						</h3>

						<?php if ( $role ) : ?>
							<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
								<?php echo esc_html( $role ); ?>
							</div>
						<?php endif; ?>

					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Page Content -->
	<?php if ( have_posts() ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
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
