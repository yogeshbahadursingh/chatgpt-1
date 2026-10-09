<?php
/** Keep demonstration catalogue records out of real customer transactions. */
defined( 'ABSPATH' ) || exit;

/**
 * Opt-in is deliberately configuration-only and cannot enable sales in production.
 * Define both WP_ENVIRONMENT_TYPE and PPT_ALLOW_DEMO_PURCHASES in a private QA
 * installation's wp-config.php; do not copy that configuration to production.
 */
function ppt_demo_purchases_allowed() {
	return defined( 'PPT_ALLOW_DEMO_PURCHASES' ) && true === PPT_ALLOW_DEMO_PURCHASES
		&& in_array( wp_get_environment_type(), array( 'local', 'development', 'staging' ), true );
}

/** A variation also inherits its parent's demonstration designation. */
function ppt_is_demo_product( $product ) {
	if ( is_numeric( $product ) ) {
		$product = function_exists( 'wc_get_product' ) ? wc_get_product( $product ) : false;
	}
	if ( ! $product instanceof WC_Product ) {
		return false;
	}
	return (bool) get_post_meta( $product->get_id(), '_ppt_demo_content', true )
		|| ( $product->get_parent_id() && (bool) get_post_meta( $product->get_parent_id(), '_ppt_demo_content', true ) );
}

function ppt_demo_purchase_message() {
	return __( 'Demonstration products are for preview only and cannot be purchased. Remove them from your basket to continue.', 'ppt-core' );
}

function ppt_demo_is_purchasable( $purchasable, $product ) {
	return ! ppt_demo_purchases_allowed() && ppt_is_demo_product( $product ) ? false : $purchasable;
}
// These are used by classic forms, AJAX, Store API and native variation controls.
add_filter( 'woocommerce_is_purchasable', 'ppt_demo_is_purchasable', 100, 2 );
add_filter( 'woocommerce_variation_is_purchasable', 'ppt_demo_is_purchasable', 100, 2 );

function ppt_demo_purchase_notice() {
	$message = ppt_demo_purchase_message();
	if ( ! wc_has_notice( $message, 'error' ) ) {
		wc_add_notice( $message, 'error' );
	}
}

add_filter( 'woocommerce_add_to_cart_validation', function( $valid, $product_id, $quantity, $variation_id = 0 ) {
	if ( ! ppt_demo_purchases_allowed() && ( ppt_is_demo_product( $product_id ) || ( $variation_id && ppt_is_demo_product( $variation_id ) ) ) ) {
		ppt_demo_purchase_notice();
		return false;
	}
	return $valid;
}, 100, 4 );

function ppt_cart_contains_demo_product( $cart ) {
	if ( ! $cart ) {
		return false;
	}
	foreach ( $cart->get_cart() as $item ) {
		if ( ppt_is_demo_product( $item['data'] ?? ( ! empty( $item['variation_id'] ) ? $item['variation_id'] : ( $item['product_id'] ?? 0 ) ) ) ) {
			return true;
		}
	}
	return false;
}

// Revalidate persisted baskets after a staging migration or a product edit.
add_action( 'woocommerce_check_cart_items', function() {
	if ( ! ppt_demo_purchases_allowed() && ppt_cart_contains_demo_product( WC()->cart ) ) {
		ppt_demo_purchase_notice();
	}
}, 100 );
add_action( 'woocommerce_after_checkout_validation', function( $data, $errors ) {
	if ( ! ppt_demo_purchases_allowed() && ppt_cart_contains_demo_product( WC()->cart ) ) {
		$errors->add( 'ppt_demo_product', ppt_demo_purchase_message() );
	}
}, 100, 2 );
add_action( 'woocommerce_store_api_cart_errors', function( $errors, $cart ) {
	if ( ! ppt_demo_purchases_allowed() && ppt_cart_contains_demo_product( $cart ) ) {
		$errors->add( 'ppt_demo_product', ppt_demo_purchase_message() );
	}
}, 100, 2 );

/** Keep the demo designation on test order lines, even if the product changes. */
add_action( 'woocommerce_before_order_item_object_save', function( $item ) {
	if ( $item instanceof WC_Order_Item_Product && ppt_is_demo_product( $item->get_product() ) ) {
		$item->update_meta_data( '_ppt_demo_content', '1' );
	}
} );

function ppt_order_contains_demo_product( $order ) {
	if ( ! $order instanceof WC_Order ) {
		return false;
	}
	foreach ( $order->get_items() as $item ) {
		if ( $item->get_meta( '_ppt_demo_content', true ) || ppt_is_demo_product( $item->get_product() ) ) {
			return true;
		}
	}
	return false;
}

// Classic checkout catches this exception before saving/processing a new order.
add_action( 'woocommerce_checkout_create_order', function( $order ) {
	if ( ! ppt_demo_purchases_allowed() && ppt_order_contains_demo_product( $order ) ) {
		throw new Exception( ppt_demo_purchase_message() );
	}
}, 100 );

// Order-pay can operate without a cart. An error notice stops native payment.
add_action( 'woocommerce_before_pay_action', function( $order ) {
	if ( ! ppt_demo_purchases_allowed() && ppt_order_contains_demo_product( $order ) ) {
		ppt_demo_purchase_notice();
	}
}, 100 );

// Blocks and Store API order-pay run this before any payment handler, even for
// zero-price products. Use its native exception so the API returns a clear error.
add_action( 'woocommerce_store_api_checkout_order_processed', function( $order ) {
	if ( ! ppt_demo_purchases_allowed() && ppt_order_contains_demo_product( $order ) ) {
		throw new \Automattic\WooCommerce\StoreApi\Exceptions\RouteException( 'ppt_demo_product', ppt_demo_purchase_message(), 400 );
	}
}, 100 );
