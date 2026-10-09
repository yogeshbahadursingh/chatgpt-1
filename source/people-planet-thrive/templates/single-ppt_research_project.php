<?php
/**
 * Template: Single Research Project
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

// Get all meta fields
$status        = get_post_meta( get_the_ID(), '_ppt_project_status', true );
$start_date    = get_post_meta( get_the_ID(), '_ppt_project_start_date', true );
$end_date      = get_post_meta( get_the_ID(), '_ppt_project_end_date', true );
$lead_id       = get_post_meta( get_the_ID(), '_ppt_project_lead_id', true );
$team_ids      = get_post_meta( get_the_ID(), '_ppt_project_team', true );
$collaborators = get_post_meta( get_the_ID(), '_ppt_project_collaborators', true );
$funding       = get_post_meta( get_the_ID(), '_ppt_project_funding', true );
$methodology   = get_post_meta( get_the_ID(), '_ppt_project_methodology', true );
$timeline      = get_post_meta( get_the_ID(), '_ppt_project_timeline', true );
$area_id       = get_post_meta( get_the_ID(), '_ppt_project_area_id', true );
$outputs       = get_post_meta( get_the_ID(), '_ppt_project_outputs', true );
$reports       = get_post_meta( get_the_ID(), '_ppt_project_reports', true );

// Get related data
$area_title = '';
$area_url = '';
if ( $area_id ) {
	$area_title = get_the_title( $area_id );
	$area_url = get_permalink( $area_id );
}

$lead_name = '';
$lead_url = '';
if ( $lead_id ) {
	$lead_name = get_the_title( $lead_id );
	$lead_url = get_permalink( $lead_id );
}

// Get team members
$team = array();
if ( $team_ids ) {
	$team_id_array = array_map( 'intval', explode( ',', $team_ids ) );
	$team = get_posts( array(
		'post_type' => 'ppt_researcher',
		'post__in' => $team_id_array,
		'orderby' => 'post__in',
		'posts_per_page' => -1,
	) );
}

// Status badge color
$status_colors = array(
	'active'    => '#126B52',
	'completed' => '#6B7280',
	'planning'  => '#C69A45',
	'on-hold'   => '#B91C1C',
);
$status_color = isset( $status_colors[ $status ] ) ? $status_colors[ $status ] : '#6B7280';

// Format dates
$formatted_start = $start_date ? date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ) : '';
$formatted_end = $end_date ? date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ) : '';
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( home_url( '/research-areas' ) ); ?>"><?php esc_html_e( 'Research', 'people-planet-thrive' ); ?></a>
				<?php if ( $area_id ) : ?>
					/ <a href="<?php echo esc_url( $area_url ); ?>"><?php echo esc_html( $area_title ); ?></a>
				<?php endif; ?>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Project Header -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<!-- Status Badge -->
		<?php if ( $status ) : ?>
			<span style="display:inline-block;padding:0.4em 1em;background-color:<?php echo esc_attr( $status_color ); ?>;color:white;border-radius:20px;font-size:var(--wp--preset--font-size--14);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--20)">
				<?php echo esc_html( ucfirst( $status ) ); ?>
			</span>
		<?php endif; ?>

		<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

		<!-- Project Metadata -->
		<div class="wp-block-group" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,200px),1fr));gap:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--30);padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
			
			<?php if ( $area_title ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Research Area', 'people-planet-thrive' ); ?></strong>
					<a href="<?php echo esc_url( $area_url ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary)"><?php echo esc_html( $area_title ); ?></a>
				</div>
			<?php endif; ?>

			<?php if ( $lead_name ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Project Lead', 'people-planet-thrive' ); ?></strong>
					<a href="<?php echo esc_url( $lead_url ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary)"><?php echo esc_html( $lead_name ); ?></a>
				</div>
			<?php endif; ?>

			<?php if ( $formatted_start ) : ?>
				<div>
					<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Timeline', 'people-planet-thrive' ); ?></strong>
					<span style="font-size:var(--wp--preset--font-size--16)">
						<?php echo esc_html( $formatted_start ); ?>
						<?php if ( $formatted_end ) : ?>
							– <?php echo esc_html( $formatted_end ); ?>
						<?php else : ?>
							– <?php esc_html_e( 'Present', 'people-planet-thrive' ); ?>
						<?php endif; ?>
					</span>
				</div>
			<?php endif; ?>

		</div>

		<!-- Excerpt -->
		<?php if ( has_excerpt() ) : ?>
			<div style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-bottom:var(--wp--preset--spacing--30);color:var(--wp--preset--color--text-light)">
				<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
			</div>
		<?php endif; ?>

	</div>

	<!-- Project Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
		<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
			<?php the_content(); ?>
		</div>
	</div>

	<!-- Team Members -->
	<?php if ( ! empty( $team ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Research Team', 'people-planet-thrive' ); ?></h2>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,250px),1fr));gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $team as $member ) : 
					$member_role = get_post_meta( $member->ID, '_ppt_researcher_role', true );
					?>
					<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);padding:var(--wp--preset--spacing--20);border-radius:4px;text-align:center">
						<?php if ( has_post_thumbnail( $member->ID ) ) : ?>
							<?php echo get_the_post_thumbnail( $member->ID, 'thumbnail', array( 'style' => 'width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto var(--wp--preset--spacing--10)' ) ); ?>
						<?php endif; ?>
						<h3 style="font-size:var(--wp--preset--font-size--18);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php echo esc_url( get_permalink( $member->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $member->post_title ); ?></a>
						</h3>
						<?php if ( $member_role ) : ?>
							<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)"><?php echo esc_html( $member_role ); ?></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Methodology -->
	<?php if ( $methodology ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Methodology', 'people-planet-thrive' ); ?></h2>
			<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php echo wp_kses_post( wpautop( $methodology ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Timeline -->
	<?php if ( $timeline ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Project Timeline', 'people-planet-thrive' ); ?></h2>
			<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php echo wp_kses_post( wpautop( $timeline ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Funding -->
	<?php if ( $funding ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Funding', 'people-planet-thrive' ); ?></h2>
			<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php echo wp_kses_post( wpautop( $funding ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Collaborators -->
	<?php if ( $collaborators ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Collaborators', 'people-planet-thrive' ); ?></h2>
			<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php echo wp_kses_post( wpautop( $collaborators ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Outputs -->
	<?php if ( $outputs ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Project Outputs', 'people-planet-thrive' ); ?></h2>
			<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php echo wp_kses_post( wpautop( $outputs ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Reports -->
	<?php if ( $reports ) : 
		$report_urls = array_filter( array_map( 'trim', explode( "\n", $reports ) ) );
		if ( ! empty( $report_urls ) ) :
			?>
			<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
				<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Reports & Downloads', 'people-planet-thrive' ); ?></h2>
				<div style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--10)">
					<?php foreach ( $report_urls as $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:var(--wp--preset--spacing--10);padding:var(--wp--preset--spacing--15);background-color:var(--wp--preset--color--surface-alt);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--primary);font-size:var(--wp--preset--font-size--16)">
							<span>📄</span>
							<span><?php echo esc_html( basename( $url ) ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>

</main>

<?php
get_footer();
