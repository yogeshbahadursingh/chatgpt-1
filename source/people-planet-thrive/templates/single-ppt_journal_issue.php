<?php
/**
 * Template: Single Journal Issue
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

$volume = get_post_meta( get_the_ID(), '_ppt_volume', true );
$issue_number = get_post_meta( get_the_ID(), '_ppt_issue_number', true );
$publication_date = get_post_meta( get_the_ID(), '_ppt_publication_date', true );
$journal_id = get_post_meta( get_the_ID(), '_ppt_journal_id', true );

// Get journal info
$journal_title = '';
$journal_url = '';
if ( $journal_id ) {
	$journal_title = get_the_title( $journal_id );
	$journal_url = get_permalink( $journal_id );
}

// Get articles in this issue
$articles = get_posts( array(
	'post_type' => 'ppt_article',
	'meta_key' => '_ppt_issue_id',
	'meta_value' => get_the_ID(),
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'posts_per_page' => -1,
	'update_post_meta_cache' => true,
	'update_post_term_cache' => false,
) );

// Pre-fetch all authors for articles to avoid N+1 queries
$all_author_ids = array();
foreach ( $articles as $article ) {
	$article_author_ids = get_post_meta( $article->ID, '_ppt_authors', true );
	if ( $article_author_ids ) {
		$author_id_array = array_map( 'intval', explode( ',', $article_author_ids ) );
		$all_author_ids = array_merge( $all_author_ids, $author_id_array );
	}
}
$all_author_ids = array_unique( $all_author_ids );
$all_authors = array();
if ( ! empty( $all_author_ids ) ) {
	$all_authors = get_posts( array(
		'post_type' => 'ppt_author',
		'post__in' => $all_author_ids,
		'posts_per_page' => -1,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	) );
	// Index by ID for quick lookup
	$all_authors_indexed = array();
	foreach ( $all_authors as $author ) {
		$all_authors_indexed[ $author->ID ] = $author;
	}
}

// Format date
$formatted_date = '';
if ( $publication_date ) {
	$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $publication_date ) );
}
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( home_url( '/journals' ) ); ?>"><?php esc_html_e( 'Journals', 'people-planet-thrive' ); ?></a>
				<?php if ( $journal_id ) : ?>
					/ <a href="<?php echo esc_url( $journal_url ); ?>"><?php echo esc_html( $journal_title ); ?></a>
				<?php endif; ?>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Issue Header -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--50)">
			
			<!-- Cover Image -->
			<div class="wp-block-column" style="flex-basis:33.33%">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:4px' ) ); ?>
				<?php endif; ?>
			</div>

			<!-- Issue Info -->
			<div class="wp-block-column" style="flex-basis:66.66%">
				<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

				<!-- Metadata -->
				<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--18)">
					<?php if ( $volume ) : ?>
						<p><strong><?php esc_html_e( 'Volume:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $volume ); ?></p>
					<?php endif; ?>
					
					<?php if ( $issue_number ) : ?>
						<p><strong><?php esc_html_e( 'Issue:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $issue_number ); ?></p>
					<?php endif; ?>
					
					<?php if ( $formatted_date ) : ?>
						<p><strong><?php esc_html_e( 'Published:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $formatted_date ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Excerpt -->
				<?php if ( has_excerpt() ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.6">
						<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>

	<!-- Issue Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</div>

	<!-- Articles in This Issue -->
	<?php if ( ! empty( $articles ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Articles in This Issue', 'people-planet-thrive' ); ?></h2>
			
			<div class="wp-block-group" style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $articles as $article ) : 
					$article_doi = get_post_meta( $article->ID, '_ppt_doi', true );
					$article_pages_start = get_post_meta( $article->ID, '_ppt_page_start', true );
					$article_pages_end = get_post_meta( $article->ID, '_ppt_page_end', true );
					$article_author_ids = get_post_meta( $article->ID, '_ppt_authors', true );
					
					// Get authors from pre-fetched cache
					$article_authors = array();
					if ( $article_author_ids && isset( $all_authors_indexed ) ) {
						$author_id_array = array_map( 'intval', explode( ',', $article_author_ids ) );
						foreach ( $author_id_array as $author_id ) {
							if ( isset( $all_authors_indexed[ $author_id ] ) ) {
								$article_authors[] = $all_authors_indexed[ $author_id ];
							}
						}
					}
					
					// Format pages
					$article_pages = '';
					if ( $article_pages_start && $article_pages_end ) {
						$article_pages = $article_pages_start . '–' . $article_pages_end;
					} elseif ( $article_pages_start ) {
						$article_pages = $article_pages_start;
					}
					?>
					<div class="wp-block-group ppt-issue-article-item" style="border-bottom:1px solid var(--wp--preset--color--border);padding-bottom:var(--wp--preset--spacing--20)">
						<h3 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php echo esc_url( get_permalink( $article->ID ) ); ?>"><?php echo esc_html( $article->post_title ); ?></a>
						</h3>
						
						<?php if ( ! empty( $article_authors ) ) : ?>
							<div class="wp-block-group ppt-article-authors-list" style="font-size:var(--wp--preset--font-size--14);margin-bottom:var(--wp--preset--spacing--10)">
								<?php
								$author_names = array();
								foreach ( $article_authors as $author ) {
									$author_names[] = '<a href="' . esc_url( get_permalink( $author->ID ) ) . '">' . esc_html( $author->post_title ) . '</a>';
								}
								echo implode( ', ', $author_names ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All elements are already escaped above
								?>
							</div>
						<?php endif; ?>
						
						<div class="wp-block-group" style="font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light)">
							<?php if ( $article_pages ) : ?>
								<strong><?php esc_html_e( 'Pages:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $article_pages ); ?>
							<?php endif; ?>
							<?php if ( $article_doi ) : ?>
								| <strong><?php esc_html_e( 'DOI:', 'people-planet-thrive' ); ?></strong> <a href="https://doi.org/<?php echo esc_attr( $article_doi ); ?>"><?php echo esc_html( $article_doi ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php else : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<p style="font-size:var(--wp--preset--font-size--16);text-align:center;padding:var(--wp--preset--spacing--30) 0"><?php esc_html_e( 'No articles in this issue yet.', 'people-planet-thrive' ); ?></p>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
