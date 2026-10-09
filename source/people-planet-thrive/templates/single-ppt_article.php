<?php
/**
 * Template: Single Article
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

$doi = get_post_meta( get_the_ID(), '_ppt_doi', true );
$abstract = get_post_meta( get_the_ID(), '_ppt_abstract', true );
$keywords = get_post_meta( get_the_ID(), '_ppt_keywords', true );
$volume = get_post_meta( get_the_ID(), '_ppt_volume', true );
$issue_number = get_post_meta( get_the_ID(), '_ppt_issue_number', true );
$page_start = get_post_meta( get_the_ID(), '_ppt_page_start', true );
$page_end = get_post_meta( get_the_ID(), '_ppt_page_end', true );
$published_date = get_post_meta( get_the_ID(), '_ppt_published_date', true );
$journal_id = get_post_meta( get_the_ID(), '_ppt_journal_id', true );
$issue_id = get_post_meta( get_the_ID(), '_ppt_issue_id', true );
$author_ids = get_post_meta( get_the_ID(), '_ppt_authors', true );
$pdf_url = get_post_meta( get_the_ID(), '_ppt_pdf_url', true );
$fulltext_url = get_post_meta( get_the_ID(), '_ppt_fulltext_url', true );
$references = get_post_meta( get_the_ID(), '_ppt_references', true );
$supplementary = get_post_meta( get_the_ID(), '_ppt_supplementary', true );

// Get journal info
$journal_title = '';
$journal_url = '';
if ( $journal_id ) {
	$journal_title = get_the_title( $journal_id );
	$journal_url = get_permalink( $journal_id );
}

// Get authors
$authors = array();
if ( $author_ids ) {
	$author_id_array = array_map( 'intval', explode( ',', $author_ids ) );
	$authors = get_posts( array(
		'post_type' => 'ppt_author',
		'post__in' => $author_id_array,
		'orderby' => 'post__in',
		'posts_per_page' => -1,
	) );
}

// Format pages
$ppt_display_pages = '';
if ( $page_start && $page_end ) {
	$ppt_display_pages = $page_start . '–' . $page_end;
} elseif ( $page_start ) {
	$ppt_display_pages = $page_start;
}

// Format date
$formatted_date = '';
if ( $published_date ) {
	$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $published_date ) );
}
?>

<main class="wp-block-group site-main ppt-article-single">
	
	<!-- Article Header -->
	<div class="wp-block-group has-background" style="background-color:var(--wp--preset--color--surface-alt);padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--40)">
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding-left:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30)">
			
			<!-- Breadcrumb -->
			<div class="wp-block-group ppt-breadcrumb" style="margin-bottom:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--14)">
				<p>
					<a href="<?php echo esc_url( home_url( '/journals' ) ); ?>"><?php esc_html_e( 'Journals', 'people-planet-thrive' ); ?></a>
					<?php if ( $journal_id ) : ?>
						/ <a href="<?php echo esc_url( $journal_url ); ?>"><?php echo esc_html( $journal_title ); ?></a>
					<?php endif; ?>
					/ <span class="ppt-current"><?php the_title(); ?></span>
				</p>
			</div>

			<!-- Article Type Badge -->
			<div class="wp-block-group ppt-article-type-badge">
				<?php
				$article_types = get_the_terms( get_the_ID(), 'ppt_article_type' );
				if ( $article_types && ! is_wp_error( $article_types ) ) :
					foreach ( $article_types as $type ) :
						?>
						<span style="font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em"><?php echo esc_html( $type->name ); ?></span>
						<?php
					endforeach;
				endif;
				?>
			</div>

			<!-- Article Title -->
			<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--30)"><?php the_title(); ?></h1>

			<!-- Authors -->
			<?php if ( ! empty( $authors ) ) : ?>
				<div class="wp-block-group ppt-article-authors" style="margin-bottom:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--16)">
					<?php
						$author_links = array();
						foreach ( $authors as $author ) {
							$author_links[] = '<a href="' . esc_url( get_permalink( $author->ID ) ) . '">' . esc_html( $author->post_title ) . '</a>';
						}
						echo implode( ', ', $author_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All elements are already escaped above					?>
				</div>
			<?php endif; ?>

			<!-- Article Metadata -->
			<div class="wp-block-group ppt-article-meta" style="margin-bottom:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--14)">
				<?php if ( $doi ) : ?>
					<p><strong><?php esc_html_e( 'DOI:', 'people-planet-thrive' ); ?></strong> <a href="https://doi.org/<?php echo esc_attr( $doi ); ?>" class="ppt-doi-link"><?php echo esc_html( $doi ); ?></a></p>
				<?php endif; ?>
				
				<?php if ( $formatted_date ) : ?>
					<p><strong><?php esc_html_e( 'Published:', 'people-planet-thrive' ); ?></strong> <span class="ppt-published-date"><?php echo esc_html( $formatted_date ); ?></span></p>
				<?php endif; ?>
				
				<?php if ( $volume || $issue_number || $ppt_display_pages ) : ?>
					<p>
						<?php if ( $volume ) : ?>
							<strong><?php esc_html_e( 'Volume:', 'people-planet-thrive' ); ?></strong> <span class="ppt-volume"><?php echo esc_html( $volume ); ?></span>
						<?php endif; ?>
						<?php if ( $issue_number ) : ?>
							| <strong><?php esc_html_e( 'Issue:', 'people-planet-thrive' ); ?></strong> <span class="ppt-issue"><?php echo esc_html( $issue_number ); ?></span>
						<?php endif; ?>
						<?php if ( $ppt_display_pages ) : ?>
							| <strong><?php esc_html_e( 'Pages:', 'people-planet-thrive' ); ?></strong> <span class="ppt-pages"><?php echo esc_html( $ppt_display_pages ); ?></span>
						<?php endif; ?>
					</p>
				<?php endif; ?>
			</div>

			<!-- Action Buttons -->
			<div class="wp-block-group ppt-article-actions" style="margin-top:var(--wp--preset--spacing--30)">
				<?php if ( $pdf_url ) : ?>
					<div class="wp-block-button"><a class="wp-block-button__link wp-element-button ppt-pdf-download" href="<?php echo esc_url( $pdf_url ); ?>"><?php esc_html_e( 'Download PDF', 'people-planet-thrive' ); ?></a></div>
				<?php endif; ?>
				
				<?php if ( $fulltext_url ) : ?>
					<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button ppt-fulltext-link" href="<?php echo esc_url( $fulltext_url ); ?>"><?php esc_html_e( 'Full Text', 'people-planet-thrive' ); ?></a></div>
				<?php endif; ?>
				
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#cite"><?php esc_html_e( 'Cite', 'people-planet-thrive' ); ?></a></div>
			</div>

		</div>
	</div>

	<!-- Article Content - Optimized Reading Experience -->
	<div class="wp-block-group ppt-article-content" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--60);max-width:720px;margin-left:auto;margin-right:auto;padding-left:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30)">
		
		<!-- Abstract -->
		<?php if ( $abstract ) : ?>
			<div class="wp-block-group ppt-abstract" style="border-left:3px solid var(--wp--preset--color--primary);margin-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--30)">
				<h2 style="font-size:var(--wp--preset--font-size--20);font-weight:600;letter-spacing:0.05em;text-transform:uppercase"><?php esc_html_e( 'Abstract', 'people-planet-thrive' ); ?></h2>
				<div class="wp-block-group ppt-abstract-content">
					<?php echo wp_kses_post( wpautop( $abstract ) ); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Keywords -->
		<?php
		$subject_areas = get_the_terms( get_the_ID(), 'ppt_subject_area' );
		if ( $subject_areas && ! is_wp_error( $subject_areas ) ) :
			?>
			<div class="wp-block-group ppt-keywords" style="margin-bottom:var(--wp--preset--spacing--40)">
				<h3 style="font-size:var(--wp--preset--font-size--16);font-weight:600"><?php esc_html_e( 'Keywords', 'people-planet-thrive' ); ?></h3>
				<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10)">
					<?php foreach ( $subject_areas as $area ) : ?>
						<a href="<?php echo esc_url( get_term_link( $area ) ); ?>" style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text);text-decoration:none"><?php echo esc_html( $area->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Main Article Content -->
		<div class="entry-content">
			<?php the_content(); ?>
		</div>

		<!-- References -->
		<?php if ( $references ) : ?>
			<div class="wp-block-group ppt-references" style="margin-top:var(--wp--preset--spacing--50)">
				<h2 style="font-size:var(--wp--preset--font-size--24);font-weight:600"><?php esc_html_e( 'References', 'people-planet-thrive' ); ?></h2>
				<div class="wp-block-group ppt-references-content">
					<?php echo wp_kses_post( wpautop( $references ) ); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Supplementary Material -->
		<?php if ( $supplementary ) : ?>
			<div class="wp-block-group ppt-supplementary" style="margin-top:var(--wp--preset--spacing--40)">
				<h2 style="font-size:var(--wp--preset--font-size--24);font-weight:600"><?php esc_html_e( 'Supplementary Material', 'people-planet-thrive' ); ?></h2>
				<div class="wp-block-group ppt-supplementary-content">
					<?php echo wp_kses_post( wpautop( $supplementary ) ); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Citation -->
		<div class="wp-block-group ppt-citation" id="cite" style="border-top:1px solid var(--wp--preset--color--border);margin-top:var(--wp--preset--spacing--50);padding-top:var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--20);font-weight:600"><?php esc_html_e( 'Cite This Article', 'people-planet-thrive' ); ?></h2>
			<div class="wp-block-group ppt-citation-content" style="font-size:var(--wp--preset--font-size--14);line-height:1.6;background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--20);border-radius:4px">
				<?php
				// Generate citation
				$author_names = array();
				foreach ( $authors as $author ) {
					$author_names[] = esc_html( $author->post_title );
				}
				$author_string = implode( ', ', $author_names );
				
				$citation_parts = array();
				if ( $author_string ) {
					$citation_parts[] = $author_string;
				}
				$citation_parts[] = '(' . esc_html( get_the_date( 'Y' ) ) . ').';
				$citation_parts[] = '&quot;' . esc_html( get_the_title() ) . '.&quot;';
				if ( $journal_title ) {
					$citation_parts[] = '<em>' . esc_html( $journal_title ) . '</em>';
				}
				if ( $volume ) {
					$citation_parts[] = esc_html( $volume );
				}
				if ( $issue_number ) {
					$citation_parts[] = '(' . esc_html( $issue_number ) . ')';
				}
				if ( $ppt_display_pages ) {
					$citation_parts[] = esc_html( $ppt_display_pages );
				}
				if ( $doi ) {
					$citation_parts[] = 'https://doi.org/' . esc_html( $doi );
				}
				
				echo implode( ' ', $citation_parts ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All parts are already escaped above
				?>
			</div>
		</div>

	</div>

</main>

<?php
get_footer();
