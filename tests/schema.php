<?php
/** Run with WP-CLI eval-file against the isolated QA WordPress installation. */
global $ppt_schema_checks, $ppt_schema_instance;
$ppt_schema_checks = array();
$ppt_schema_instance = new PPT_Schema();
function ppt_schema_check( $test, $pass, $detail = '' ) {
	global $ppt_schema_checks;
	$ppt_schema_checks[] = array( 'test' => $test, 'pass' => (bool) $pass, 'detail' => $detail );
}
function ppt_schema_capture( $query_args ) {
	global $wp_query, $post, $ppt_schema_instance;
	$wp_query = new WP_Query( $query_args );
	$post = $wp_query->post;
	if ( $post ) setup_postdata( $post );
	ob_start();
	$ppt_schema_instance->output_schema();
	$html = ob_get_clean();
	preg_match_all( '~<script type="application/ld\+json">(.*?)</script>~s', $html, $matches );
	return array( $html, array_map( function( $json ) { return json_decode( $json, true ); }, $matches[1] ) );
}
function ppt_schema_type( $schemas, $type ) {
	foreach ( $schemas as $schema ) if ( ( $schema['@type'] ?? '' ) === $type ) return $schema;
	return array();
}
// Filters emulate editor configuration for this process only; no site settings are changed.
$without_logo = function() { return 0; };
add_filter( 'theme_mod_custom_logo', $without_logo );
list( , $schemas ) = ppt_schema_capture( array( 'post_type' => 'ppt_publication' ) );
ppt_schema_check( 'Unconfigured organization omits nonexistent logo', ! isset( ppt_schema_type( $schemas, 'Organization' )['logo'] ) );
remove_filter( 'theme_mod_custom_logo', $without_logo );
$attachment = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'post_mime_type' => 'image', 'posts_per_page' => 1 ) );
if ( $attachment ) {
	$logo_id = $attachment[0]->ID;
	$with_logo = function() use ( $logo_id ) { return $logo_id; };
	add_filter( 'theme_mod_custom_logo', $with_logo );
	list( , $schemas ) = ppt_schema_capture( array( 'post_type' => 'ppt_publication' ) );
	$organization = ppt_schema_type( $schemas, 'Organization' );
	ppt_schema_check( 'Configured logo uses actual attachment URL', ( $organization['logo']['url'] ?? '' ) === wp_get_attachment_image_url( $logo_id, 'full' ) );
	remove_filter( 'theme_mod_custom_logo', $with_logo );
} else {
	ppt_schema_check( 'Configured logo uses actual attachment URL', false, 'QA image attachment fixture is missing.' );
}
foreach ( array( 'ppt_subject_area', 'ppt_publication_type', 'category' ) as $taxonomy ) {
	$terms = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => true, 'number' => 1 ) );
	if ( is_wp_error( $terms ) || ! $terms ) { ppt_schema_check( $taxonomy . ' term breadcrumb', false, 'Missing QA term.' ); continue; }
	$term = $terms[0];
	list( , $schemas ) = ppt_schema_capture( array( 'taxonomy' => $taxonomy, 'term' => $term->slug ) );
	$crumbs = ppt_schema_type( $schemas, 'BreadcrumbList' )['itemListElement'] ?? array();
	$current = end( $crumbs );
	ppt_schema_check( $taxonomy . ' term breadcrumb uses term name and canonical URL', count( $crumbs ) === 2 && $current['name'] === $term->name && $current['item'] === get_term_link( $term ) );
}
foreach ( array( 'ppt_publication', 'ppt_journal', 'ppt_research_project' ) as $post_type ) {
	list( , $schemas ) = ppt_schema_capture( array( 'post_type' => $post_type ) );
	$crumbs = ppt_schema_type( $schemas, 'BreadcrumbList' )['itemListElement'] ?? array();
	$current = end( $crumbs );
	ppt_schema_check( $post_type . ' archive breadcrumb has name and URL', count( $crumbs ) === 2 && $current['name'] === get_post_type_object( $post_type )->labels->name && $current['item'] === get_post_type_archive_link( $post_type ) );
}
list( , $schemas ) = ppt_schema_capture( array( 'page_id' => (int) get_option( 'page_for_posts' ) ) );
$crumbs = ppt_schema_type( $schemas, 'BreadcrumbList' )['itemListElement'] ?? array();
ppt_schema_check( 'Insights posts page breadcrumb uses configured page', count( $crumbs ) === 2 && end( $crumbs )['item'] === get_permalink( get_option( 'page_for_posts' ) ) );
list( , $schemas ) = ppt_schema_capture( array( 's' => 'climate' ) );
$crumbs = ppt_schema_type( $schemas, 'BreadcrumbList' )['itemListElement'] ?? array();
ppt_schema_check( 'Search breadcrumb has descriptive label and URL', count( $crumbs ) === 2 && strpos( end( $crumbs )['name'], 'climate' ) !== false && end( $crumbs )['item'] === get_search_link( 'climate' ) );
foreach ( array( 'books' => 'Book', 'e-books' => 'Book', 'research-reports' => 'Report', 'policy-briefs' => 'CreativeWork', 'free-resources' => 'CreativeWork' ) as $slug => $expected ) {
	$publications = get_posts( array( 'post_type' => 'ppt_publication', 'posts_per_page' => 1, 'tax_query' => array( array( 'taxonomy' => 'ppt_publication_type', 'field' => 'slug', 'terms' => $slug ) ) ) );
	if ( ! $publications ) { ppt_schema_check( $slug . ' schema type', false, 'Missing QA publication.' ); continue; }
	list( , $schemas ) = ppt_schema_capture( array( 'post_type' => 'ppt_publication', 'p' => $publications[0]->ID ) );
	ppt_schema_check( $slug . ' publication emits ' . $expected, ! empty( ppt_schema_type( $schemas, $expected ) ) && ( 'Book' === $expected || empty( ppt_schema_type( $schemas, 'Book' ) ) ) );
}
$article = get_posts( array( 'post_type' => 'ppt_article', 'posts_per_page' => 1 ) )[0];
list( , $schemas ) = ppt_schema_capture( array( 'author' => (int) $article->post_author ) );
$crumbs = ppt_schema_type( $schemas, 'BreadcrumbList' )['itemListElement'] ?? array();
ppt_schema_check( 'Author archive breadcrumb has display name and canonical URL', count( $crumbs ) === 2 && end( $crumbs )['name'] === get_the_author_meta( 'display_name', $article->post_author ) && end( $crumbs )['item'] === get_author_posts_url( $article->post_author ) );
$year = (int) substr( $article->post_date, 0, 4 );
list( , $schemas ) = ppt_schema_capture( array( 'year' => $year, 'post_type' => 'ppt_article' ) );
$crumbs = ppt_schema_type( $schemas, 'BreadcrumbList' )['itemListElement'] ?? array();
ppt_schema_check( 'Year archive breadcrumb has date label and canonical URL', count( $crumbs ) === 2 && strpos( end( $crumbs )['name'], (string) $year ) !== false && end( $crumbs )['item'] === get_year_link( $year ) );
list( , $schemas ) = ppt_schema_capture( array( 'm' => substr( str_replace( '-', '', $article->post_date ), 0, 6 ), 'post_type' => 'ppt_article' ) );
$crumbs = ppt_schema_type( $schemas, 'BreadcrumbList' )['itemListElement'] ?? array();
ppt_schema_check( 'Compact date archive resolves the correct month URL', count( $crumbs ) === 2 && end( $crumbs )['item'] === get_month_link( $year, (int) substr( $article->post_date, 5, 2 ) ) );
$book = get_posts( array( 'post_type' => 'ppt_publication', 'posts_per_page' => 1, 'tax_query' => array( array( 'taxonomy' => 'ppt_publication_type', 'field' => 'slug', 'terms' => 'books' ) ) ) )[0];
$isbn_filter = function( $value, $object_id, $key ) use ( $book ) {
	return $object_id === $book->ID && '_ppt_publication_isbn' === $key ? 'QA-FIELD-SENTINEL' : $value;
};
add_filter( 'get_post_metadata', $isbn_filter, 10, 3 );
list( , $schemas ) = ppt_schema_capture( array( 'post_type' => 'ppt_publication', 'p' => $book->ID ) );
ppt_schema_check( 'Book ISBN reads the publication editor field', ( ppt_schema_type( $schemas, 'Book' )['isbn'] ?? '' ) === 'QA-FIELD-SENTINEL' );
remove_filter( 'get_post_metadata', $isbn_filter, 10 );
add_filter( 'ppt_standard_schema_owned_by_seo', '__return_true' );
list( , $schemas ) = ppt_schema_capture( array( 'post_type' => 'ppt_article', 'p' => $article->ID ) );
ppt_schema_check( 'External SEO owner suppresses only standard theme schema', count( $schemas ) === 1 && ! empty( ppt_schema_type( $schemas, 'ScholarlyArticle' ) ) );
remove_filter( 'ppt_standard_schema_owned_by_seo', '__return_true' );
list( , $schemas ) = ppt_schema_capture( array( 'post_type' => 'ppt_article', 'p' => $article->ID ) );
ppt_schema_check( 'ScholarlyArticle and standard output remain when theme owns schema', count( $schemas ) === 3 && ! empty( ppt_schema_type( $schemas, 'ScholarlyArticle' ) ) );
$payload = '</script><script>alert("QA")</script>';
$escape_filter = function() use ( $payload ) { return array( array( '@type' => 'CreativeWork', 'name' => $payload ) ); };
add_filter( 'ppt_schema_output', $escape_filter );
list( $html, $schemas ) = ppt_schema_capture( array( 'post_type' => 'ppt_article', 'p' => $article->ID ) );
ppt_schema_check( 'JSON-LD escapes script delimiters and preserves decoded value', substr_count( $html, '</script>' ) === 1 && count( $schemas ) === 1 && $schemas[0]['name'] === $payload && strpos( $html, '\\u003C' ) !== false );
remove_filter( 'ppt_schema_output', $escape_filter );
$http_fixtures = array();
foreach ( array( 'books' => 'Book', 'e-books' => 'Book', 'research-reports' => 'Report', 'policy-briefs' => 'CreativeWork', 'free-resources' => 'CreativeWork' ) as $slug => $type ) {
	$fixture = get_posts( array( 'post_type' => 'ppt_publication', 'posts_per_page' => 1, 'tax_query' => array( array( 'taxonomy' => 'ppt_publication_type', 'field' => 'slug', 'terms' => $slug ) ) ) );
	if ( $fixture ) $http_fixtures[] = array( 'route' => get_permalink( $fixture[0] ), 'type' => $type, 'label' => $slug );
}
foreach ( array( 'ppt_subject_area', 'ppt_publication_type', 'category' ) as $taxonomy ) {
	$terms = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => true, 'number' => 1 ) );
	if ( ! is_wp_error( $terms ) && $terms ) $http_fixtures[] = array( 'route' => get_term_link( $terms[0] ), 'type' => 'BreadcrumbList', 'label' => $terms[0]->name );
}
$http_fixtures[] = array( 'route' => get_permalink( $article ), 'type' => 'ScholarlyArticle', 'label' => 'Article' );
$journal = get_posts( array( 'post_type' => 'ppt_journal', 'posts_per_page' => 1 ) )[0];
$http_fixtures[] = array( 'route' => get_permalink( $journal ), 'type' => 'Periodical', 'label' => 'Journal' );
file_put_contents( dirname( ABSPATH, 3 ) . '/runtime/schema-http-fixtures.json', wp_json_encode( $http_fixtures, JSON_PRETTY_PRINT ) );
file_put_contents( dirname( ABSPATH, 3 ) . '/runtime/schema-results.json', wp_json_encode( $ppt_schema_checks, JSON_PRETTY_PRINT ) );
echo wp_json_encode( $ppt_schema_checks, JSON_PRETTY_PRINT );
if ( array_filter( $ppt_schema_checks, function( $check ) { return ! $check['pass']; } ) ) WP_CLI::halt( 1 );
