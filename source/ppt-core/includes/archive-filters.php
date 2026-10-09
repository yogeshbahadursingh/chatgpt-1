<?php
/** Keep research filtering, counts and pagination on WordPress's main query. */
defined( 'ABSPATH' ) || exit;

/** Whether this visitor must not see a store that has not launched yet. */
function ppt_store_prelaunch_for_visitor() {
	if ( ! class_exists( 'WooCommerce' ) || 'yes' !== get_option( 'woocommerce_coming_soon' ) || current_user_can( 'manage_woocommerce' ) ) {
		return false;
	}
	// Honor the same explicit private-preview mechanism as WooCommerce.
	if ( 'yes' === get_option( 'woocommerce_private_link' ) ) {
		$key = get_option( 'woocommerce_share_key' );
		if ( is_string( $key ) && '' !== $key ) {
			foreach ( array( $_GET['woo-share'] ?? null, $_COOKIE['woo-share'] ?? null ) as $candidate ) {
				if ( is_string( $candidate ) && hash_equals( $key, $candidate ) ) { return false; }
			}
		}
	}
	return true;
}

/** Apply Woo visibility before querying mixed collections, preserving counts and limits. */
function ppt_visible_content_query_args( $args, $context = 'catalog' ) {
	$types = $args['post_type'] ?? 'post';
	if ( 'any' === $types ) { $types = get_post_types( array( 'public' => true ), 'names' ); }
	$types = (array) $types;
	if ( ! in_array( 'product', $types, true ) ) { return $args; }
	if ( ppt_store_prelaunch_for_visitor() ) {
		$types = array_values( array_diff( $types, array( 'product' ) ) );
		$args['post_type'] = $types ? $types : 'post';
		if ( ! $types ) { $args['post__in'] = array( 0 ); }
	}
	if ( function_exists( 'wc_get_product_visibility_term_ids' ) ) {
		$visibility = wc_get_product_visibility_term_ids();
		$excluded = array( $visibility[ 'search' === $context ? 'exclude-from-search' : 'exclude-from-catalog' ] ?? 0 );
		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) { $excluded[] = $visibility['outofstock'] ?? 0; }
		$excluded = array_values( array_filter( $excluded ) );
		if ( $excluded ) {
			$condition = array( 'taxonomy' => 'product_visibility', 'field' => 'term_taxonomy_id', 'terms' => $excluded, 'operator' => 'NOT IN' );
			$existing = $args['tax_query'] ?? array();
			$args['tax_query'] = $existing ? array( 'relation' => 'AND', $existing, $condition ) : array( $condition );
		}
	}
	return $args;
}

// Shared subjects and publication types are editorial destinations as well as store terms.
// Preserve the operator's whole-site gate; only store-only mode gets this exception.
add_filter( 'woocommerce_coming_soon_exclude', function ( $excluded ) {
	return $excluded || ( 'yes' === get_option( 'woocommerce_coming_soon' ) && 'yes' === get_option( 'woocommerce_store_pages_only' ) && is_tax( array( 'ppt_subject_area', 'ppt_publication_type' ) ) );
} );

add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_tax( array( 'ppt_subject_area', 'ppt_publication_type' ) ) ) { return; }
	$taxonomy = get_taxonomy( $query->is_tax( 'ppt_subject_area' ) ? 'ppt_subject_area' : 'ppt_publication_type' );
	$types = $query->get( 'post_type' );
	if ( ! $types || 'any' === $types ) { $types = $taxonomy->object_type; }
	$args = ppt_visible_content_query_args( array( 'post_type' => $types, 'tax_query' => $query->get( 'tax_query' ), 'post__in' => $query->get( 'post__in' ) ) );
	foreach ( $args as $key => $value ) { $query->set( $key, $value ); }
}, 30 );

add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) { return; }
	$args = ppt_visible_content_query_args( array( 'post_type' => $query->get( 'post_type' ), 'tax_query' => $query->get( 'tax_query' ), 'post__in' => $query->get( 'post__in' ) ), 'search' );
	foreach ( $args as $key => $value ) { $query->set( $key, $value ); }
}, 30 );

function ppt_research_status_filter() {
	$value = isset( $_GET['status'] ) && is_string( $_GET['status'] ) ? sanitize_key( wp_unslash( $_GET['status'] ) ) : '';
	// Earlier demonstration imports stored this synonym. Do not rewrite existing content.
	if ( 'planned' === $value ) {
		$value = 'planning';
	}
	return in_array( $value, array( 'planning', 'active', 'completed', 'on-hold' ), true ) ? $value : '';
}

add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'ppt_research_project' ) ) {
		return;
	}
	$query->set( 'posts_per_page', 12 );
	// Imports can share timestamps; a stable tie-breaker prevents page overlap.
	$query->set( 'orderby', array( 'date' => 'DESC', 'ID' => 'DESC' ) );
	$status = ppt_research_status_filter();
	if ( ! $status ) {
		return;
	}
	$condition = array(
		'key'     => '_ppt_project_status',
		'value'   => 'planning' === $status ? array( 'planning', 'planned' ) : $status,
		'compare' => 'planning' === $status ? 'IN' : '=',
	);
	$existing = $query->get( 'meta_query' );
	$query->set( 'meta_query', $existing ? array( 'relation' => 'AND', $existing, $condition ) : array( $condition ) );
}, 20 );
