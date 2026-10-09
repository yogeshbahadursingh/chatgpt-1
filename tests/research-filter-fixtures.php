<?php
/** Read-only reference data for the browser research-filter regression test. */
$projects = get_posts( array( 'post_type' => 'ppt_research_project', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => array( 'date' => 'DESC', 'ID' => 'DESC' ) ) );
$data = array( 'base' => get_post_type_archive_link( 'ppt_research_project' ), 'projects' => array() );
foreach ( $projects as $project ) {
	$data['projects'][] = array(
		'id'     => $project->ID,
		'url'    => get_permalink( $project ),
		'status' => get_post_meta( $project->ID, '_ppt_project_status', true ),
		'topics' => wp_get_object_terms( $project->ID, 'ppt_subject_area', array( 'fields' => 'ids' ) ),
	);
}
echo wp_json_encode( $data );
