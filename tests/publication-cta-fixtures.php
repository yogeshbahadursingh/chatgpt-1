<?php
/** Temporary local-only records used by publication-cta.cjs. */
if ( ! defined( 'WP_CLI' ) || ! WP_CLI || ! in_array( wp_parse_url( home_url(), PHP_URL_HOST ), array( '127.0.0.1', 'localhost' ), true ) ) {
	throw new RuntimeException( 'This test is restricted to the isolated local QA site.' );
}
$file = dirname( ABSPATH, 3 ) . '/runtime/publication-cta-fixtures.json';
if ( isset( $args[0] ) && 'cleanup' === $args[0] ) {
	if ( file_exists( $file ) ) {
		$data = json_decode( file_get_contents( $file ), true );
		foreach ( array_reverse( $data['ids'] ) as $id ) {
			if ( $data['token'] === get_post_meta( $id, '_ppt_qa_publication_cta', true ) ) {
				wp_delete_post( $id, true );
			}
		}
		unlink( $file );
	}
	echo 'Owned publication CTA fixtures removed.';
	return;
}
if ( file_exists( $file ) ) {
	throw new RuntimeException( 'Clean up previous owned fixtures before starting.' );
}
$data = array( 'token' => wp_generate_uuid4(), 'ids' => array(), 'cases' => array() );
$save_manifest = function() use ( &$data, $file ) {
	file_put_contents( $file, wp_json_encode( $data, JSON_PRETTY_PRINT ) );
};
$make = function( $name, $settings ) use ( &$data, $save_manifest ) {
	$p = new WC_Product_Simple();
	$p->set_name( 'QA temporary ' . $name );
	$p->set_status( $settings['status'] ?? 'publish' );
	$p->set_virtual( true );
	$p->set_regular_price( $settings['price'] ?? '12' );
	if ( isset( $settings['sale'] ) ) $p->set_sale_price( $settings['sale'] );
	if ( isset( $settings['visibility'] ) ) $p->set_catalog_visibility( $settings['visibility'] );
	if ( isset( $settings['stock'] ) ) $p->set_stock_status( $settings['stock'] );
	if ( ! empty( $settings['demo'] ) ) $p->update_meta_data( '_ppt_demo_content', '1' );
	$p->update_meta_data( '_ppt_qa_publication_cta', $data['token'] );
	$p->save();
	$data['ids'][] = $p->get_id();
	$save_manifest();
	return $p;
};
$cases = array(
	'paid' => array( 'sale' => '9' ),
	'free' => array( 'price' => '0' ),
	'demo' => array( 'demo' => true ),
	'private' => array( 'status' => 'private' ),
	'hidden' => array( 'visibility' => 'hidden' ),
	'unavailable' => array( 'stock' => 'outofstock' ),
	'missing' => null,
);
foreach ( $cases as $name => $settings ) {
	$product = null === $settings ? false : $make( $name, $settings );
	$id = wp_insert_post( array(
		'post_type' => 'ppt_publication', 'post_status' => 'publish', 'post_title' => 'QA temporary publication ' . $name,
		'post_content' => '<p>Temporary local QA fixture.</p>',
		'meta_input' => array( '_ppt_qa_publication_cta' => $data['token'], '_ppt_publication_product_id' => $product ? $product->get_id() : 2147483000, '_ppt_publication_price' => '999', '_ppt_publication_is_free' => '0' ),
	), true );
	if ( is_wp_error( $id ) ) throw new RuntimeException( $id->get_error_message() );
	$data['ids'][] = $id;
	$data['cases'][$name] = array( 'url' => get_permalink( $id ), 'product_url' => $product ? $product->get_permalink() : '', 'price_html' => $product ? $product->get_price_html() : '' );
	$save_manifest();
}
echo wp_json_encode( array( 'cases' => count( $data['cases'] ), 'records' => count( $data['ids'] ) ) );
