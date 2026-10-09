<?php
/**
 * Template: Single Researcher
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

// Get all meta fields
$orcid         = get_post_meta( get_the_ID(), '_ppt_researcher_orcid', true );
$role          = get_post_meta( get_the_ID(), '_ppt_researcher_role', true );
$expertise     = get_post_meta( get_the_ID(), '_ppt_researcher_expertise', true );
$bio           = get_post_meta( get_the_ID(), '_ppt_researcher_bio', true );
$selected_work = get_post_meta( get_the_ID(), '_ppt_researcher_selected_work', true );
$project_ids   = get_post_meta( get_the_ID(), '_ppt_researcher_projects', true );

// Get related projects
$projects = array();
if ( $project_ids ) {
	$project_id_array = array_map( 'intval', explode( ',', $project_ids ) );
	$projects = get_posts( array(
		'post_type' => 'ppt_research_project',
		'post__in' => $project_id_array,
		'orderby' => 'post__in',
		'posts_per_page' => -1,
	) );
} else {
	// Also check if this researcher is a lead or team member in any projects
	$projects = get_posts( array(
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
		'posts_per_page' => -1,
	) );
}
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( home_url( '/researchers' ) ); ?>"><?php esc_html_e( 'Researchers', 'people-planet-thrive' ); ?></a>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Researcher Profile Header -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--50)">
			
			<!-- Profile Image -->
			<div class="wp-block-column" style="flex-basis:33.33%">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:8px' ) ); ?>
				<?php endif; ?>
			</div>

			<!-- Researcher Info -->
			<div class="wp-block-column" style="flex-basis:66.66%">
				<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

				<?php if ( $role ) : ?>
					<div style="font-size:var(--wp--preset--font-size--20);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--20)">
						<?php echo esc_html( $role ); ?>
					</div>
				<?php endif; ?>

				<!-- Researcher Details -->
				<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--16)">
					<?php if ( $orcid ) : ?>
						<p><strong><?php esc_html_e( 'ORCID:', 'people-planet-thrive' ); ?></strong> <a href="https://orcid.org/<?php echo esc_attr( $orcid ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $orcid ); ?></a></p>
					<?php endif; ?>
					
					<?php if ( $expertise ) : ?>
						<p><strong><?php esc_html_e( 'Expertise:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $expertise ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Bio -->
				<?php if ( $bio ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7;margin-bottom:var(--wp--preset--spacing--30)">
						<?php echo wp_kses_post( wpautop( $bio ) ); ?>
					</div>
				<?php elseif ( has_excerpt() ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.6;margin-bottom:var(--wp--preset--spacing--30)">
						<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
					</div>
				<?php endif; ?>

			</div>

		</div>
	</div>

	<!-- Full Bio Content -->
	<?php if ( get_the_content() ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
			<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Selected Work -->
	<?php if ( $selected_work ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Selected Work', 'people-planet-thrive' ); ?></h2>
			<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php echo wp_kses_post( wpautop( $selected_work ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Research Projects -->
	<?php if ( ! empty( $projects ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Research Projects', 'people-planet-thrive' ); ?></h2>
			
			<div style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $projects as $project ) : 
					$project_status = get_post_meta( $project->ID, '_ppt_project_status', true );
					$project_area_id = get_post_meta( $project->ID, '_ppt_project_area_id', true );
					$project_start = get_post_meta( $project->ID, '_ppt_project_start_date', true );
					$project_end = get_post_meta( $project->ID, '_ppt_project_end_date', true );
					
					// Get area title
					$project_area_title = '';
					if ( $project_area_id ) {
						$project_area_title = get_the_title( $project_area_id );
					}
					
					// Status badge color
					$status_colors = array(
						'active'    => '#126B52',
						'completed' => '#6B7280',
						'planning'  => '#C69A45',
						'on-hold'   => '#B91C1C',
					);
					$status_color = isset( $status_colors[ $project_status ] ) ? $status_colors[ $project_status ] : '#6B7280';
					?>
					<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);padding:var(--wp--preset--spacing--20);border-radius:4px">
						
						<?php if ( $project_status ) : ?>
							<span style="display:inline-block;padding:0.2em 0.6em;background-color:<?php echo esc_attr( $status_color ); ?>;color:white;border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
								<?php echo esc_html( ucfirst( $project_status ) ); ?>
							</span>
						<?php endif; ?>

						<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php echo esc_url( get_permalink( $project->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $project->post_title ); ?></a>
						</h3>

						<?php if ( $project->post_excerpt ) : ?>
							<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
								<?php echo esc_html( wp_trim_words( $project->post_excerpt, 20 ) ); ?>
							</div>
						<?php endif; ?>

						<div style="font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light)">
							<?php if ( $project_area_title ) : ?>
								<strong><?php esc_html_e( 'Area:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $project_area_title ); ?>
							<?php endif; ?>
							<?php if ( $project_start ) : ?>
								| <strong><?php esc_html_e( 'Timeline:', 'people-planet-thrive' ); ?></strong>
								<?php echo esc_html( date_i18n( 'M Y', strtotime( $project_start ) ) ); ?>
								<?php if ( $project_end ) : ?>
									– <?php echo esc_html( date_i18n( 'M Y', strtotime( $project_end ) ) ); ?>
								<?php else : ?>
									– <?php esc_html_e( 'Present', 'people-planet-thrive' ); ?>
								<?php endif; ?>
							<?php endif; ?>
						</div>

					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
