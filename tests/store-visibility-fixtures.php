<?php
/** Uniquely owned disposable local fixtures; this file is never shipped in the plugin. */
$token = getenv( 'PPT_QA_STORE_TOKEN' );
$mode = getenv( 'PPT_QA_STORE_MODE' );
if ( ! preg_match( '/^[a-f0-9]{24}$/', (string) $token ) || 0 !== strpos( DB_NAME, 'ppt_' ) || 'http://127.0.0.1:8877' !== untrailingslashit( home_url() ) ) { WP_CLI::error( 'Isolated local QA only.' ); }
$key = '_ppt_qa_store_run';
$slug = 'ppt-qa-store-' . $token;
$settings = static function () { return array( 'coming_soon' => get_option( 'woocommerce_coming_soon' ), 'store_pages_only' => get_option( 'woocommerce_store_pages_only' ), 'private_link' => get_option( 'woocommerce_private_link' ) ); };
$cleanup = static function () use ( $key, $token, $slug, $settings ) {
	$owned = get_posts( array( 'post_type' => array( 'ppt_publication', 'product' ), 'post_status' => 'any', 'numberposts' => -1, 'meta_key' => $key, 'meta_value' => $token ) );
	$deleted = array();
	foreach ( $owned as $post ) {
		if ( $token !== get_post_meta( $post->ID, $key, true ) || 0 !== strpos( $post->post_name, $slug . '-' ) ) { continue; }
		if ( 'product' === $post->post_type ) { wc_get_product( $post->ID )->delete( true ); }
		else { wp_delete_post( $post->ID, true ); }
		$deleted[] = $post->ID;
	}
	$terms_removed = true;
	foreach ( array( 'ppt_subject_area', 'ppt_publication_type' ) as $taxonomy ) {
		$term = get_term_by( 'slug', $slug, $taxonomy );
		if ( $term && $term->slug === $slug ) { wp_delete_term( $term->term_id, $taxonomy ); }
		$terms_removed = $terms_removed && ! get_term_by( 'slug', $slug, $taxonomy );
	}
	$remaining = get_posts( array( 'post_type' => array( 'ppt_publication', 'product' ), 'post_status' => 'any', 'numberposts' => -1, 'meta_key' => $key, 'meta_value' => $token, 'fields' => 'ids' ) );
	return array( 'deleted' => $deleted, 'remaining' => $remaining, 'terms_removed' => $terms_removed, 'settings' => $settings() );
};
if ( 'cleanup' === $mode ) { echo wp_json_encode( $cleanup() ); return; }
if ( 'create' !== $mode || ! class_exists( 'WC_Product_Simple' ) ) { WP_CLI::error( 'Fixture creation requires WooCommerce.' ); }
foreach ( array( 'ppt_subject_area', 'ppt_publication_type' ) as $taxonomy ) { if ( get_term_by( 'slug', $slug, $taxonomy ) ) { WP_CLI::error( 'Fixture token already exists.' ); } }
try {
	$terms = array();
	foreach ( array( 'ppt_subject_area', 'ppt_publication_type' ) as $taxonomy ) {
		$term = wp_insert_term( 'QA store ' . $token, $taxonomy, array( 'slug' => $slug ) );
		if ( is_wp_error( $term ) ) { throw new RuntimeException( $term->get_error_message() ); }
		$terms[ $taxonomy ] = (int) $term['term_id'];
	}
	$editorial = array();
	for ( $i = 1; $i <= 14; $i++ ) {
		$id = wp_insert_post( array( 'post_type' => 'ppt_publication', 'post_status' => 'publish', 'post_title' => sprintf( 'QA editorial %02d', $i ), 'post_name' => $slug . '-editorial-' . $i, 'post_content' => 'Temporary editorial visibility fixture.', 'meta_input' => array( $key => $token ) ), true );
		if ( is_wp_error( $id ) ) { throw new RuntimeException( $id->get_error_message() ); }
		foreach ( $terms as $taxonomy => $term_id ) { wp_set_object_terms( $id, array( $term_id ), $taxonomy ); }
		$editorial[] = get_permalink( $id );
	}
	$products = array();
	foreach ( array( 'visible', 'hidden' ) as $visibility ) {
		$product = new WC_Product_Simple();
		$product->set_name( 'QA product ' . $visibility );
		$product->set_slug( $slug . '-product-' . $visibility );
		$product->set_status( 'publish' );
		$product->set_regular_price( '1' );
		$product->set_virtual( true );
		$product->set_catalog_visibility( $visibility );
		$product->update_meta_data( $key, $token );
		$id = $product->save();
		if ( ! $id ) { throw new RuntimeException( 'Product save failed.' ); }
		foreach ( $terms as $taxonomy => $term_id ) { wp_set_object_terms( $id, array( $term_id ), $taxonomy ); }
		$products[ $visibility ] = get_permalink( $id );
	}
	$urls = array();
	foreach ( $terms as $taxonomy => $term_id ) { $urls[ $taxonomy ] = get_term_link( $term_id, $taxonomy ); }
	echo wp_json_encode( array( 'editorial' => $editorial, 'products' => $products, 'terms' => $urls, 'shop' => wc_get_page_permalink( 'shop' ), 'publications' => get_post_type_archive_link( 'ppt_publication' ), 'home' => home_url( '/' ), 'settings' => $settings() ) );
} catch ( Throwable $error ) { $cleanup(); WP_CLI::error( $error->getMessage() ); }
