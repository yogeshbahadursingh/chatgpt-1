<?php
/**
 * WooCommerce Compatibility
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_WooCommerce
 *
 * Handles WooCommerce integration and template overrides.
 */
class PPT_WooCommerce {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Remove default WooCommerce wrappers.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Add theme wrappers.
		add_action( 'woocommerce_before_main_content', array( $this, 'wrapper_start' ), 10 );
		add_action( 'woocommerce_after_main_content', array( $this, 'wrapper_end' ), 10 );

		// Declare theme support.
		add_action( 'after_setup_theme', array( $this, 'declare_support' ) );

		// Custom product gallery.
		add_filter( 'woocommerce_product_gallery_columns', array( $this, 'gallery_columns' ) );
	}

	/**
	 * Declare WooCommerce support.
	 */
	public function declare_support() {
		add_theme_support( 'woocommerce', array(
			'single_image_width'            => 800,
			'thumbnail_image_width'         => 400,
			'gallery_thumbnail_image_width' => 200,
		) );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Content wrapper start.
	 */
	public function wrapper_start() {
		echo '<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding-left:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-top:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--xx-large)">';
	}

	/**
	 * Content wrapper end.
	 */
	public function wrapper_end() {
		echo '</div>';
	}

	/**
	 * Gallery columns.
	 *
	 * @return int Number of columns.
	 */
	public function gallery_columns() {
		return 4;
	}
}
