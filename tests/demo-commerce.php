<?php
/**
 * Run with WP-CLI eval-file on the isolated local QA database only.
 * Argument: blocked (default), or allowed for an explicitly opted-in QA process.
 * To test environment combinations, define the two constants before WP loads
 * using a temporary --require bootstrap. Never put that bootstrap in a package.
 */
if ( ! defined( 'WP_CLI' ) || ! WP_CLI || ! in_array( wp_parse_url( home_url(), PHP_URL_HOST ), array( '127.0.0.1', 'localhost' ), true ) ) {
	throw new RuntimeException( 'This mutating test is restricted to local WP-CLI QA.' );
}
$expected_allowed = isset( $args[0] ) && 'allowed' === $args[0];
$checks = array();
$products = array();
$orders = array();
$assert = function( $name, $pass, $detail = '' ) use ( &$checks ) {
	$checks[] = array( 'test' => $name, 'status' => $pass ? 'PASS' : 'FAIL', 'detail' => $detail );
};
$old_cart = WC()->cart;
$old_session = WC()->session;
$old_customer = WC()->customer;
WC()->session = new WC_Session_Handler();
WC()->customer = new WC_Customer( 0 );
WC()->cart = new WC_Cart();
$make = function( $class, $demo = false, $parent = 0 ) use ( &$products ) {
	$p = new $class();
	$p->set_name( 'PPT temporary guard QA ' . wp_generate_uuid4() );
	$p->set_status( 'publish' );
	$p->set_regular_price( '10' );
	$p->set_virtual( true );
	if ( $parent ) {
		$p->set_parent_id( $parent );
	}
	if ( $demo ) {
		$p->update_meta_data( '_ppt_demo_content', '1' );
	}
	$p->save();
	$products[] = $p;
	return $p;
};
$throws = function( $callback ) {
	try {
		$callback();
		return false;
	} catch ( Exception $e ) {
		return true;
	}
};
try {
	$assert( 'Configured environment has expected demo policy', ppt_demo_purchases_allowed() === $expected_allowed, wp_get_environment_type() );
	$genuine = $make( 'WC_Product_Simple' );
	$demo = $make( 'WC_Product_Simple', true );
	$free = $make( 'WC_Product_Simple', true );
	$free->set_regular_price( '0' );
	$free->save();
	$parent = $make( 'WC_Product_Variable', true );
	$variation = $make( 'WC_Product_Variation', false, $parent->get_id() );
	$real_parent = $make( 'WC_Product_Variable' );
	$real_variation = $make( 'WC_Product_Variation', false, $real_parent->get_id() );
	$marked_variation = $make( 'WC_Product_Variation', true, $real_parent->get_id() );
	$assert( 'Genuine simple product remains purchasable', $genuine->is_purchasable() );
	$assert( 'Genuine variation remains purchasable', $real_variation->is_purchasable() );
	$assert( 'Paid demo follows policy', $demo->is_purchasable() === $expected_allowed );
	$assert( 'Free demo follows policy', $free->is_purchasable() === $expected_allowed );
	$assert( 'Demo parent protects its unmarked variation', $variation->is_purchasable() === $expected_allowed );
	$assert( 'Individually marked variation follows policy', $marked_variation->is_purchasable() === $expected_allowed );
	$assert( 'Guard preserves native false values', false === apply_filters( 'woocommerce_is_purchasable', false, $genuine ) );
	$assert( 'Classic add-to-cart validation follows policy', apply_filters( 'woocommerce_add_to_cart_validation', true, $demo->get_id(), 1 ) === $expected_allowed );
	wc_clear_notices();
	$assert( 'Native cart rejects or accepts demo as configured', (bool) WC()->cart->add_to_cart( $demo->get_id(), 1 ) === $expected_allowed );
	$assert( 'Native cart still accepts genuine products', (bool) WC()->cart->add_to_cart( $genuine->get_id(), 1 ) );
	wc_clear_notices();

	$controller = new \Automattic\WooCommerce\StoreApi\Utilities\CartController();
	$request = array( 'quantity' => 1, 'variation' => array(), 'cart_item_data' => array() );
	$assert( 'Store API rejects or accepts demo add-to-cart', $throws( function() use ( $controller, $demo, $request ) { $controller->validate_add_to_cart( $demo, $request ); } ) === ! $expected_allowed );
	$assert( 'Store API accepts genuine add-to-cart', ! $throws( function() use ( $controller, $genuine, $request ) { $controller->validate_add_to_cart( $genuine, $request ); } ) );
	$item = array( 'key' => 'ppt-guard-qa', 'data' => $demo, 'product_id' => $demo->get_id(), 'variation_id' => 0, 'quantity' => 1, 'variation' => array() );
	// Simulate a basket restored from staging without bypassing product validation.
	WC()->cart->cart_contents = array( 'ppt-guard-qa' => $item );
	$assert( 'Store API revalidates persisted demo basket', $throws( function() use ( $controller, $item ) { $controller->validate_cart_item( $item ); } ) === ! $expected_allowed );
	$errors = new WP_Error();
	do_action( 'woocommerce_after_checkout_validation', array(), $errors );
	$assert( 'Classic checkout rejects persisted demo basket', $errors->has_errors() === ! $expected_allowed );
	$errors = new WP_Error();
	do_action( 'woocommerce_store_api_cart_errors', $errors, WC()->cart );
	$assert( 'Store API basket error is explicit', (bool) $errors->get_error_message( 'ppt_demo_product' ) === ! $expected_allowed );
	wc_clear_notices();
	do_action( 'woocommerce_check_cart_items' );
	$assert( 'Classic basket has a demo-specific error', wc_has_notice( ppt_demo_purchase_message(), 'error' ) === ! $expected_allowed );
	wc_clear_notices();

	$order = wc_create_order();
	$orders[] = $order;
	$order->add_product( $demo, 1 );
	$order->calculate_totals();
	$order->save();
	$order_items = $order->get_items();
	$first_item = reset( $order_items );
	$assert( 'Test order line retains demo identity', '1' === $first_item->get_meta( '_ppt_demo_content', true ) );
	$assert( 'Classic order creation blocks demo transaction', $throws( function() use ( $order ) { do_action( 'woocommerce_checkout_create_order', $order, array() ); } ) === ! $expected_allowed );
	do_action( 'woocommerce_before_pay_action', $order );
	$assert( 'Existing demo order-pay receives payment-blocking notice', wc_notice_count( 'error' ) > 0 === ! $expected_allowed );
	wc_clear_notices();
	$assert( 'Store API existing order-pay blocks before payment', $throws( function() use ( $order ) { do_action( 'woocommerce_store_api_checkout_order_processed', $order ); } ) === ! $expected_allowed );
	delete_post_meta( $demo->get_id(), '_ppt_demo_content' );
	$assert( 'Saved demo order cannot become genuine by editing its product', ppt_order_contains_demo_product( wc_get_order( $order->get_id() ) ) );

	$real_order = wc_create_order();
	$orders[] = $real_order;
	$real_order->add_product( $genuine, 1 );
	$real_order->calculate_totals();
	$real_order->save();
	$assert( 'Genuine order is not marked as demo', ! ppt_order_contains_demo_product( $real_order ) );
	$assert( 'Genuine Store API order-pay remains available', ! $throws( function() use ( $real_order ) { do_action( 'woocommerce_store_api_checkout_order_processed', $real_order ); } ) );
	do_action( 'woocommerce_before_pay_action', $real_order );
	$assert( 'Genuine classic order-pay has no guard error', 0 === wc_notice_count( 'error' ) );
	$real_order->set_status( 'completed' );
	$assert( 'Genuine completed order download access remains unchanged', $real_order->is_download_permitted() );
	$assert( 'Genuine pending order download access remains unchanged', (function() use ( $real_order ) { $real_order->set_status( 'pending' ); return ! $real_order->is_download_permitted(); })() );
} finally {
	foreach ( $orders as $order ) {
		$order->delete( true );
	}
	foreach ( array_reverse( $products ) as $product ) {
		$product->delete( true );
	}
	WC()->cart = $old_cart;
	WC()->session = $old_session;
	WC()->customer = $old_customer;
}
$report = array( 'environment' => wp_get_environment_type(), 'opt_in' => defined( 'PPT_ALLOW_DEMO_PURCHASES' ) && true === PPT_ALLOW_DEMO_PURCHASES, 'checks' => $checks );
$destination = dirname( ABSPATH, 3 ) . '/runtime/demo-commerce-' . wp_get_environment_type() . '-' . ( $report['opt_in'] ? 'opt-in' : 'default' ) . '.json';
file_put_contents( $destination, wp_json_encode( $report, JSON_PRETTY_PRINT ) );
echo wp_json_encode( $report, JSON_PRETTY_PRINT );
if ( array_filter( $checks, function( $check ) { return 'FAIL' === $check['status']; } ) ) {
	WP_CLI::halt( 1 );
}
