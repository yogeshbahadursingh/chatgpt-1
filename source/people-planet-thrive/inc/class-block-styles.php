<?php
/**
 * Block Styles Registration
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Block_Styles
 *
 * Registers custom block styles for the block editor.
 */
class PPT_Block_Styles {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_block_styles' ) );
	}

	/**
	 * Register custom block styles.
	 */
	public function register_block_styles() {
		// Separator styles.
		register_block_style(
			'core/separator',
			array(
				'name'  => 'gold-thin',
				'label' => esc_html__( 'Gold Thin', 'people-planet-thrive' ),
			)
		);

		register_block_style(
			'core/separator',
			array(
				'name'  => 'gold-dotted',
				'label' => esc_html__( 'Gold Dotted', 'people-planet-thrive' ),
			)
		);

		// Group/Section styles.
		register_block_style(
			'core/group',
			array(
				'name'  => 'section-ivory',
				'label' => esc_html__( 'Ivory Section', 'people-planet-thrive' ),
			)
		);

		register_block_style(
			'core/group',
			array(
				'name'  => 'section-forest',
				'label' => esc_html__( 'Forest Section', 'people-planet-thrive' ),
			)
		);

		register_block_style(
			'core/group',
			array(
				'name'  => 'section-teal',
				'label' => esc_html__( 'Teal Section', 'people-planet-thrive' ),
			)
		);

		// Column styles.
		register_block_style(
			'core/columns',
			array(
				'name'  => 'card-grid',
				'label' => esc_html__( 'Card Grid', 'people-planet-thrive' ),
			)
		);

		// Image styles.
		register_block_style(
			'core/image',
			array(
				'name'  => 'framed',
				'label' => esc_html__( 'Framed', 'people-planet-thrive' ),
			)
		);

		// Heading styles.
		register_block_style(
			'core/heading',
			array(
				'name'  => 'section-label',
				'label' => esc_html__( 'Section Label', 'people-planet-thrive' ),
			)
		);

		// Quote styles.
		register_block_style(
			'core/quote',
			array(
				'name'  => 'gold-border',
				'label' => esc_html__( 'Gold Border', 'people-planet-thrive' ),
			)
		);

		// Button styles.
		register_block_style(
			'core/button',
			array(
				'name'  => 'outline-gold',
				'label' => esc_html__( 'Outline Gold', 'people-planet-thrive' ),
			)
		);

		register_block_style(
			'core/button',
			array(
				'name'  => 'outline-white',
				'label' => esc_html__( 'Outline White', 'people-planet-thrive' ),
			)
		);
	}
}
