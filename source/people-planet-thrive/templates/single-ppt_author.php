<?php
/**
 * Template: Single Author
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

$orcid = get_post_meta( get_the_ID(), '_ppt_orcid', true );
$affiliation = get_post_meta( get_the_ID(), '_ppt_affiliation', true );
$position = get_post_meta( get_the_ID(), '_ppt_position', true );
$website = get_post_meta( get_the_ID(), '_ppt_website', true );
$google_scholar = get_post_meta( get_the_ID(), '_ppt_google_scholar', true );
$research_gate = get_post_meta( get_the_ID(), '_ppt_research_gate', true );

// Get articles by this author
$articles = get_posts( array(
	'post_type' => 'ppt_article',
	'meta_query' => array(
		array(
			'key' => '_ppt_authors',
			'value' => '(^|,)[[:space:]]*'.get_the_ID().'[[:space:]]*(,|$)',
			'compare' => 'REGEXP',
		),
	),
	'orderby' => 'date',
	'order' => 'DESC',
	'posts_per_page' => -1,
) );

// Filter articles to ensure this author is actually in the list
$filtered_articles = array();
foreach ( $articles as $article ) {
	$author_ids = get_post_meta( $article->ID, '_ppt_authors', true );
	if ( $author_ids ) {
		$author_id_array = array_map( 'intval', explode( ',', $author_ids ) );
		if ( in_array( get_the_ID(), $author_id_array, true ) ) {
			$filtered_articles[] = $article;
		}
	}
}
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( home_url( '/authors' ) ); ?>"><?php esc_html_e( 'Authors', 'people-planet-thrive' ); ?></a>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Author Profile Header -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--50)">
			
			<!-- Profile Image -->
			<div class="wp-block-column" style="flex-basis:33.33%">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:50%' ) ); ?>
				<?php endif; ?>
			</div>

			<!-- Author Info -->
			<div class="wp-block-column" style="flex-basis:66.66%">
				<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

				<!-- Author Details -->
				<div class="wp-block-group ppt-author-details" style="margin-bottom:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--16)">
					<?php if ( $position ) : ?>
						<p><strong><?php esc_html_e( 'Position:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $position ); ?></p>
					<?php endif; ?>
					
					<?php if ( $affiliation ) : ?>
						<p><strong><?php esc_html_e( 'Affiliation:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $affiliation ); ?></p>
					<?php endif; ?>
					
					<?php if ( $orcid ) : ?>
						<p><strong><?php esc_html_e( 'ORCID:', 'people-planet-thrive' ); ?></strong> <a href="https://orcid.org/<?php echo esc_attr( $orcid ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $orcid ); ?></a></p>
					<?php endif; ?>
				</div>

				<!-- Bio -->
				<?php if ( has_excerpt() ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.6;margin-bottom:var(--wp--preset--spacing--20)">
						<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
					</div>
				<?php endif; ?>

				<!-- Social Links -->
				<?php if ( $website || $google_scholar || $research_gate ) : ?>
					<div class="wp-block-group ppt-author-social-links" style="margin-top:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--14)">
						<?php if ( $website ) : ?>
							<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Website', 'people-planet-thrive' ); ?></a>
						<?php endif; ?>
						<?php if ( $website && ( $google_scholar || $research_gate ) ) : ?>
							| 
						<?php endif; ?>
						<?php if ( $google_scholar ) : ?>
							<a href="<?php echo esc_url( $google_scholar ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Google Scholar', 'people-planet-thrive' ); ?></a>
						<?php endif; ?>
						<?php if ( $google_scholar && $research_gate ) : ?>
							| 
						<?php endif; ?>
						<?php if ( $research_gate ) : ?>
							<a href="<?php echo esc_url( $research_gate ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'ResearchGate', 'people-planet-thrive' ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>

	<!-- Author Bio Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</div>

	<!-- Author's Publications -->
	<?php if ( ! empty( $filtered_articles ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:600;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Publications', 'people-planet-thrive' ); ?></h2>
			
			<div class="wp-block-group" style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $filtered_articles as $article ) : 
					$article_doi = get_post_meta( $article->ID, '_ppt_doi', true );
					$article_date = get_the_date( '', $article->ID );
					?>
					<div class="wp-block-group ppt-author-publication-item" style="border-bottom:1px solid var(--wp--preset--color--border);padding-bottom:var(--wp--preset--spacing--20)">
						<h3 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php echo esc_url( get_permalink( $article->ID ) ); ?>"><?php echo esc_html( $article->post_title ); ?></a>
						</h3>
						
						<div class="wp-block-group" style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
							<span class="ppt-date"><?php echo esc_html( $article_date ); ?></span>
							<?php if ( $article_doi ) : ?>
								| <strong><?php esc_html_e( 'DOI:', 'people-planet-thrive' ); ?></strong> <a href="https://doi.org/<?php echo esc_attr( $article_doi ); ?>" class="ppt-doi-link"><?php echo esc_html( $article_doi ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php else : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<p style="font-size:var(--wp--preset--font-size--16);text-align:center;padding:var(--wp--preset--spacing--30) 0"><?php esc_html_e( 'No publications by this author yet.', 'people-planet-thrive' ); ?></p>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
