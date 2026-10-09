<?php
/** Read-only check that the editor recognizes legacy planned status metadata. */
$posts = get_posts( array( 'post_type' => 'ppt_research_project', 'post_status' => 'publish', 'numberposts' => -1 ) );
$box = new PPT_Meta_Boxes();
$checks = array();
foreach ( $posts as $post ) {
	$before = get_post_meta( $post->ID, '_ppt_project_status', true );
	if ( ! in_array( $before, array( 'planned', 'planning' ), true ) ) { continue; }
	ob_start();
	$box->render_research_project_meta_box( $post );
	$html = ob_get_clean();
	preg_match( '/<option value="planning"([^>]*)>/', $html, $option );
	$checks[] = array( 'id' => $post->ID, 'status' => ! empty( $option[1] ) && strpos( $option[1], 'selected' ) !== false && get_post_meta( $post->ID, '_ppt_project_status', true ) === $before ? 'PASS' : 'FAIL', 'stored_status' => $before );
}
file_put_contents( dirname( ABSPATH, 3 ) . '/runtime/research-editor-results.json', wp_json_encode( $checks, JSON_PRETTY_PRINT ) );
echo wp_json_encode( $checks );
if ( count( array_filter( $checks, static function ( $check ) { return 'FAIL' === $check['status']; } ) ) ) { WP_CLI::error( 'Research editor status check failed.' ); }
