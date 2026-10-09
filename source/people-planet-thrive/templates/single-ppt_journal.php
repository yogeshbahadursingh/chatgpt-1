<?php
/**
 * Template: Single Journal
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

$issn = get_post_meta( get_the_ID(), '_ppt_issn', true );
$eissn = get_post_meta( get_the_ID(), '_ppt_eissn', true );
$frequency = get_post_meta( get_the_ID(), '_ppt_frequency', true );
$editor_name = get_post_meta( get_the_ID(), '_ppt_editor_name', true );
$aims_scope = get_post_meta( get_the_ID(), '_ppt_aims_scope', true );
$editorial_board = get_post_meta( get_the_ID(), '_ppt_editorial_board', true );
$author_guidelines = get_post_meta( get_the_ID(), '_ppt_author_guidelines', true );
$current_issue_id = get_post_meta( get_the_ID(), '_ppt_current_issue_id', true );

// Get current issue
$current_issue = null;
if ( $current_issue_id ) {
	$current_issue = get_post( $current_issue_id );
}

// Get all issues for this journal
$issues = get_posts( array(
	'post_type' => 'ppt_journal_issue',
	'meta_key' => '_ppt_journal_id',
	'meta_value' => get_the_ID(),
	'orderby' => 'date',
	'order' => 'DESC',
	'posts_per_page' => -1,
) );
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( home_url( '/journals' ) ); ?>"><?php esc_html_e( 'Journals', 'people-planet-thrive' ); ?></a>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Journal Header -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--50)">
			
			<!-- Cover Image -->
			<div class="wp-block-column" style="flex-basis:33.33%">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:4px' ) ); ?>
				<?php endif; ?>
			</div>

			<!-- Journal Info -->
			<div class="wp-block-column" style="flex-basis:66.66%">
				<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

				<!-- Metadata -->
				<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--16)">
					<?php if ( $issn ) : ?>
						<p><strong><?php esc_html_e( 'ISSN:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $issn ); ?></p>
					<?php endif; ?>
					
					<?php if ( $eissn ) : ?>
						<p><strong><?php esc_html_e( 'eISSN:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $eissn ); ?></p>
					<?php endif; ?>
					
					<?php if ( $frequency ) : ?>
						<p><strong><?php esc_html_e( 'Frequency:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $frequency ); ?></p>
					<?php endif; ?>
					
					<?php if ( $editor_name ) : ?>
						<p><strong><?php esc_html_e( 'Editor-in-Chief:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $editor_name ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Excerpt -->
				<?php if ( has_excerpt() ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.6;margin-bottom:var(--wp--preset--spacing--30)">
						<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
					</div>
				<?php endif; ?>

				<!-- Action Buttons -->
				<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--30)">
					<?php if ( $current_issue ) : ?>
						<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( get_permalink( $current_issue->ID ) ); ?>"><?php esc_html_e( 'Current Issue', 'people-planet-thrive' ); ?></a></div>
					<?php endif; ?>
					<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(add_query_arg('enquiry','Publishing',home_url('/submit-manuscript/'))); ?>"><?php esc_html_e( 'Submit Manuscript', 'people-planet-thrive' ); ?></a></div>
				</div>
			</div>

		</div>
	</div>

	<!-- Journal Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</div>

	<!-- Aims & Scope -->
	<?php if ( $aims_scope ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Aims & Scope', 'people-planet-thrive' ); ?></h2>
			<div class="wp-block-group ppt-aims-scope">
				<?php echo wp_kses_post( wpautop( $aims_scope ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Current Issue -->
	<?php if ( $current_issue ) : ?>
		<div class="wp-block-group ppt-current-issue" id="current-issue" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Current Issue', 'people-planet-thrive' ); ?></h2>
			<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--30);border-radius:4px">
				<h3 style="font-size:var(--wp--preset--font-size--24);margin-bottom:var(--wp--preset--spacing--10)">
					<a href="<?php echo esc_url( get_permalink( $current_issue->ID ) ); ?>"><?php echo esc_html( $current_issue->post_title ); ?></a>
				</h3>
				<?php
				$issue_volume = get_post_meta( $current_issue->ID, '_ppt_volume', true );
				$issue_number = get_post_meta( $current_issue->ID, '_ppt_issue_number', true );
				$issue_date = get_post_meta( $current_issue->ID, '_ppt_publication_date', true );
				?>
				<?php if ( $issue_volume || $issue_number ) : ?>
					<p style="font-size:var(--wp--preset--font-size--16);margin-bottom:var(--wp--preset--spacing--10)">
						<?php if ( $issue_volume ) : ?>
							<strong><?php esc_html_e( 'Volume:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $issue_volume ); ?>
						<?php endif; ?>
						<?php if ( $issue_number ) : ?>
							| <strong><?php esc_html_e( 'Issue:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $issue_number ); ?>
						<?php endif; ?>
					</p>
				<?php endif; ?>
				<?php if ( $issue_date ) : ?>
					<p style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
						<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $issue_date ) ) ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Issue Archive -->
	<?php if ( ! empty( $issues ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'All Issues', 'people-planet-thrive' ); ?></h2>
			<div class="wp-block-group" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,250px),1fr));gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $issues as $issue ) : 
					$issue_volume = get_post_meta( $issue->ID, '_ppt_volume', true );
					$issue_number = get_post_meta( $issue->ID, '_ppt_issue_number', true );
					$issue_date = get_post_meta( $issue->ID, '_ppt_publication_date', true );
					?>
					<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);padding:var(--wp--preset--spacing--20);border-radius:4px">
						<h3 style="font-size:var(--wp--preset--font-size--18);margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php echo esc_url( get_permalink( $issue->ID ) ); ?>"><?php echo esc_html( $issue->post_title ); ?></a>
						</h3>
						<?php if ( $issue_volume || $issue_number ) : ?>
							<p style="font-size:var(--wp--preset--font-size--14);margin-bottom:var(--wp--preset--spacing--10)">
								<?php if ( $issue_volume ) : ?>
									Vol. <?php echo esc_html( $issue_volume ); ?>
								<?php endif; ?>
								<?php if ( $issue_number ) : ?>
									, Issue <?php echo esc_html( $issue_number ); ?>
								<?php endif; ?>
							</p>
						<?php endif; ?>
						<?php if ( $issue_date ) : ?>
							<p style="font-size:var(--wp--preset--font-size--12);color:var(--wp--preset--color--text-light)">
								<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $issue_date ) ) ); ?>
							</p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Editorial Board -->
	<?php if ( $editorial_board ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Editorial Board', 'people-planet-thrive' ); ?></h2>
			<div class="wp-block-group ppt-editorial-board">
				<?php echo wp_kses_post( wpautop( $editorial_board ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Author Guidelines -->
	<?php if ( $author_guidelines ) : ?>
		<div class="wp-block-group ppt-author-guidelines" id="submit" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Author Guidelines', 'people-planet-thrive' ); ?></h2>
			<div class="wp-block-group">
				<?php echo wp_kses_post( wpautop( $author_guidelines ) ); ?>
			</div>
		</div>
	<?php endif; ?>

<?php $ppt_policies=get_post_meta(get_the_ID(),'_ppt_policies',true); if($ppt_policies): ?>
<section class="ppt-journal-policies" style="max-width:var(--wp--style--global--wide-size);margin:auto;padding:3rem 2rem"><h2>Journal policies</h2><?php echo wp_kses_post(wpautop($ppt_policies)); ?></section>
<?php endif; ?>
<p style="max-width:var(--wp--style--global--wide-size);margin:2rem auto;padding:0 2rem"><a href="<?php echo esc_url(home_url('/for-authors/')); ?>">For Authors</a> · <a href="<?php echo esc_url(home_url('/editorial-policies/')); ?>">Editorial Policies</a> · <a href="<?php echo esc_url(add_query_arg('enquiry','Publishing',home_url('/contact/'))); ?>">Publishing enquiry</a></p>
</main>

<?php
get_footer();
