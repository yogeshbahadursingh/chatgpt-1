<?php
/** Disposable owned fixtures for collection/search visibility integration tests. */
$token = getenv( 'PPT_QA_COLLECTION_TOKEN' );
if ( ! preg_match( '/^[a-f0-9]{24}$/', (string) $token ) || 0 !== strpos( DB_NAME, 'ppt_' ) || 'http://127.0.0.1:8877' !== untrailingslashit( home_url() ) ) { WP_CLI::error( 'Isolated local QA only.' ); }
$key = '_ppt_qa_collection_run'; $slug = 'ppt-qa-collection-' . $token; $search = 'PPTQA' . $token;
$settings = static function () { return array( get_option( 'woocommerce_coming_soon' ), get_option( 'woocommerce_store_pages_only' ), get_option( 'woocommerce_hide_out_of_stock_items' ) ); };
$cleanup = static function () use ( $key, $token, $slug, $settings ) {
	$deleted = array();
	foreach ( get_posts( array( 'post_type' => array( 'post', 'product' ), 'post_status' => 'any', 'numberposts' => -1, 'meta_key' => $key, 'meta_value' => $token ) ) as $post ) {
		if ( $token !== get_post_meta( $post->ID, $key, true ) || 0 !== strpos( $post->post_name, $slug . '-' ) ) { continue; }
		if ( 'product' === $post->post_type ) { wc_get_product( $post->ID )->delete( true ); } else { wp_delete_post( $post->ID, true ); }
		$deleted[] = $post->ID;
	}
	$term = get_term_by( 'slug', $slug, 'ppt_subject_area' ); if ( $term && $term->slug === $slug ) { wp_delete_term( $term->term_id, 'ppt_subject_area' ); }
	$remaining = get_posts( array( 'post_type' => array( 'post', 'product' ), 'post_status' => 'any', 'numberposts' => -1, 'meta_key' => $key, 'meta_value' => $token, 'fields' => 'ids' ) );
	return array( 'deleted' => count( $deleted ), 'remaining' => count( $remaining ), 'term_removed' => ! get_term_by( 'slug', $slug, 'ppt_subject_area' ), 'settings' => $settings() );
};
if ( 'cleanup' === getenv( 'PPT_QA_COLLECTION_MODE' ) ) { echo wp_json_encode( $cleanup() ); return; }
if ( 'create' !== getenv( 'PPT_QA_COLLECTION_MODE' ) || get_term_by( 'slug', $slug, 'ppt_subject_area' ) ) { WP_CLI::error( 'Invalid fixture request.' ); }
try {
	$term = wp_insert_term( 'QA collection ' . $token, 'ppt_subject_area', array( 'slug' => $slug ) ); if ( is_wp_error( $term ) ) { throw new RuntimeException( $term->get_error_message() ); }
	$topic = (int) $term['term_id']; $posts = array();
	foreach ( array( 'auto', 'explicit' ) as $kind ) {
		$id = wp_insert_post( array( 'post_type' => 'post', 'post_status' => 'publish', 'post_title' => $search . ' editorial ' . $kind, 'post_name' => $slug . '-' . $kind, 'post_content' => 'Temporary local editorial fixture.', 'meta_input' => array( $key => $token ) ), true );
		if ( is_wp_error( $id ) ) { throw new RuntimeException( $id->get_error_message() ); }
		wp_set_object_terms( $id, array( $topic ), 'ppt_subject_area' ); $posts[ $kind ] = array( 'id' => $id, 'url' => get_permalink( $id ) );
	}
	$products = array();
	foreach ( array( 'visible', 'catalog', 'search', 'hidden', 'outofstock' ) as $kind ) {
		$product = new WC_Product_Simple(); $product->set_name( $search . ' product ' . $kind ); $product->set_slug( $slug . '-' . $kind ); $product->set_status( 'publish' ); $product->set_regular_price( '1' ); $product->set_virtual( true );
		$product->set_catalog_visibility( 'outofstock' === $kind ? 'visible' : $kind ); $product->set_stock_status( 'outofstock' === $kind ? 'outofstock' : 'instock' ); $product->update_meta_data( $key, $token );
		$id = $product->save(); if ( ! $id ) { throw new RuntimeException( 'Product save failed.' ); }
		wp_set_object_terms( $id, array( $topic ), 'ppt_subject_area' ); $products[ $kind ] = array( 'id' => $id, 'url' => get_permalink( $id ) );
	}
	update_post_meta( $posts['explicit']['id'], '_ppt_related', implode( ',', array_merge( array( $posts['auto']['id'] ), wp_list_pluck( $products, 'id' ) ) ) );
	echo wp_json_encode( array( 'topic' => $topic, 'posts' => $posts, 'products' => $products, 'search' => $search, 'home' => home_url( '/' ), 'settings' => $settings() ) );
} catch ( Throwable $error ) { $cleanup(); WP_CLI::error( $error->getMessage() ); }
