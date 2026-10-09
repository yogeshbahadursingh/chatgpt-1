<?php
/** Disposable fixtures for the isolated pagination test; never run on production. */
$token = getenv( 'PPT_QA_ARCHIVE_TOKEN' );
$mode = getenv( 'PPT_QA_ARCHIVE_MODE' );
if ( ! preg_match( '/^[a-f0-9]{24}$/', (string) $token ) || 0 !== strpos( DB_NAME, 'ppt_' ) || 'http://127.0.0.1:8877' !== untrailingslashit( home_url() ) ) {
	WP_CLI::error( 'This harness requires a ppt_ isolated local database, the exact QA URL and a unique run token.' );
}
$key = '_ppt_qa_archive_run';
$slug = 'ppt-qa-pagination-' . $token;
$cleanup = static function () use ( $token, $key, $slug ) {
	$posts = get_posts( array( 'post_type' => 'ppt_research_project', 'post_status' => 'any', 'numberposts' => -1, 'meta_key' => $key, 'meta_value' => $token ) );
	$deleted = array();
	foreach ( $posts as $post ) {
		if ( $token === get_post_meta( $post->ID, $key, true ) && 0 === strpos( $post->post_name, $slug . '-' ) ) {
			wp_delete_post( $post->ID, true );
			$deleted[] = $post->ID;
		}
	}
	$term = get_term_by( 'slug', $slug, 'ppt_subject_area' );
	if ( $term && $term->slug === $slug ) { wp_delete_term( $term->term_id, 'ppt_subject_area' ); }
	$remaining = get_posts( array( 'post_type' => 'ppt_research_project', 'post_status' => 'any', 'numberposts' => -1, 'meta_key' => $key, 'meta_value' => $token, 'fields' => 'ids' ) );
	return array( 'deleted' => $deleted, 'remaining' => $remaining, 'term_removed' => ! get_term_by( 'slug', $slug, 'ppt_subject_area' ) );
};
if ( 'cleanup' === $mode ) {
	echo wp_json_encode( $cleanup() );
	return;
}
if ( 'create' !== $mode || get_term_by( 'slug', $slug, 'ppt_subject_area' ) ) { WP_CLI::error( 'Invalid mode or existing fixture token.' ); }
try {
	$created_term = wp_insert_term( 'QA pagination ' . $token, 'ppt_subject_area', array( 'slug' => $slug ) );
	if ( is_wp_error( $created_term ) ) { throw new RuntimeException( $created_term->get_error_message() ); }
	$term_id = $created_term['term_id'];
	$projects = array();
	for ( $i = 1; $i <= 20; $i++ ) {
		$status = $i <= 16 ? ( $i % 2 ? 'planned' : 'planning' ) : 'active';
		$id = wp_insert_post( array( 'post_type' => 'ppt_research_project', 'post_status' => 'publish', 'post_title' => 'QA pagination fixture ' . $i, 'post_name' => $slug . '-' . $i, 'post_content' => 'Temporary local pagination test.', 'post_excerpt' => 'Temporary local pagination test.', 'meta_input' => array( $key => $token, '_ppt_project_status' => $status ) ), true );
		if ( is_wp_error( $id ) ) { throw new RuntimeException( $id->get_error_message() ); }
		$assigned = wp_set_object_terms( $id, array( $term_id ), 'ppt_subject_area' );
		if ( is_wp_error( $assigned ) ) { throw new RuntimeException( $assigned->get_error_message() ); }
		$projects[] = array( 'id' => $id, 'url' => get_permalink( $id ), 'status' => $status, 'date' => get_post_field( 'post_date', $id ) );
	}
	usort( $projects, static function ( $a, $b ) { $dates = strcmp( $b['date'], $a['date'] ); return $dates ? $dates : $b['id'] <=> $a['id']; } );
	$publications = array();
	foreach ( get_posts( array( 'post_type' => 'ppt_publication', 'post_status' => 'publish', 'numberposts' => -1 ) ) as $publication ) {
		$publications[] = array( 'url' => get_permalink( $publication ), 'types' => wp_get_object_terms( $publication->ID, 'ppt_publication_type', array( 'fields' => 'names' ) ) );
	}
	echo wp_json_encode( array( 'topic' => $term_id, 'base' => get_post_type_archive_link( 'ppt_research_project' ), 'projects' => $projects, 'publications_url' => get_post_type_archive_link( 'ppt_publication' ), 'publications' => $publications ) );
} catch ( Throwable $error ) {
	$cleanup();
	WP_CLI::error( $error->getMessage() );
}
