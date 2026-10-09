<?php
/**
 * Theme Setup
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Theme_Setup
 *
 * Handles theme initialisation and WordPress feature support.
 */
class PPT_Theme_Setup {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'setup' ), 10 );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_filter( 'body_class', array( $this, 'add_body_classes' ) );
		add_action( 'customize_register', array( $this, 'customize_register' ) );
	}

	/**
	 * Set up theme defaults and register supported WordPress features.
	 */
	public function setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set default thumbnail size.
		set_post_thumbnail_size( 1200, 800, true );

		// Add custom image sizes.
		add_image_size( 'ppt-card', 600, 400, true );
		add_image_size( 'ppt-hero', 1920, 800, true );
		add_image_size( 'ppt-article-thumb', 400, 300, true );

		// Switch default core markup to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height.
		add_theme_support( 'custom-line-height' );

		// Add support for custom spacing.
		add_theme_support( 'custom-spacing' );

		// Add support for link colors (deprecated in 5.9 but kept for compatibility).
		add_theme_support( 'editor-styles' );

		// Add support for appearance tools.
		add_theme_support( 'appearance-tools' );

		// Add support for WP block styles.
		add_theme_support( 'wp-block-styles' );

		// Register navigation menus.
		register_nav_menus(
			array(
				'primary'      => esc_html__( 'Primary Navigation', 'people-planet-thrive' ),
				'utility'      => esc_html__( 'Utility Bar Navigation', 'people-planet-thrive' ),
				'footer-main'  => esc_html__( 'Footer Main Navigation', 'people-planet-thrive' ),
				'footer-resources' => esc_html__( 'Footer Resources Navigation', 'people-planet-thrive' ),
				'footer-legal' => esc_html__( 'Footer Legal Navigation', 'people-planet-thrive' ),
				'social'       => esc_html__( 'Social Links', 'people-planet-thrive' ),
			)
		);
	}

	/**
	 * Register widget areas.
	 */
	public function register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar', 'people-planet-thrive' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Main sidebar widget area.', 'people-planet-thrive' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widgets', 'people-planet-thrive' ),
				'id'            => 'footer-widgets',
				'description'   => esc_html__( 'Footer widget area.', 'people-planet-thrive' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/**
	 * Add custom body classes.
	 *
	 * @param array $classes Body classes.
	 * @return array Modified body classes.
	 */
	public function add_body_classes( $classes ) {
		// Add class for block theme.
		$classes[] = 'ppt-block-theme';

		// Add class if plugin is active.
		if ( defined( 'PPT_CORE_VERSION' ) ) {
			$classes[] = 'ppt-core-active';
		}

		// Add class for singular CPT types.
		if ( is_singular() ) {
			$post_type = get_post_type();
			if ( 0 === strpos( $post_type, 'ppt_' ) ) {
				$classes[] = 'ppt-singular';
				$classes[] = 'ppt-singular-' . sanitize_html_class( $post_type );
			}
		}

		return $classes;
	}

	/**
	 * Register Customizer settings for contact info and CTA.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		// Contact Info Section.
		$wp_customize->add_section(
			'ppt_contact_info',
			array(
				'title'    => esc_html__( 'Contact Information', 'people-planet-thrive' ),
				'priority' => 30,
			)
		);

		// Contact Email.
		$wp_customize->add_setting(
			'ppt_contact_email',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_email',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_contact_email',
			array(
				'label'   => esc_html__( 'Contact Email', 'people-planet-thrive' ),
				'section' => 'ppt_contact_info',
				'type'    => 'email',
			)
		);

		// Contact Phone.
		$wp_customize->add_setting(
			'ppt_contact_phone',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_contact_phone',
			array(
				'label'   => esc_html__( 'Contact Phone', 'people-planet-thrive' ),
				'section' => 'ppt_contact_info',
				'type'    => 'text',
			)
		);

		// CTA Button Section.
		$wp_customize->add_section(
			'ppt_cta_button',
			array(
				'title'    => esc_html__( 'CTA Button', 'people-planet-thrive' ),
				'priority' => 35,
			)
		);

		// CTA Button Text.
		$wp_customize->add_setting(
			'ppt_cta_text',
			array(
				'default'           => esc_html__( 'Submit Manuscript', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_cta_text',
			array(
				'label'   => esc_html__( 'CTA Button Text', 'people-planet-thrive' ),
				'section' => 'ppt_cta_button',
				'type'    => 'text',
			)
		);

		// CTA Button URL.
		$wp_customize->add_setting(
			'ppt_cta_url',
			array(
				'default'           => home_url( '/submit-manuscript' ),
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_cta_url',
			array(
				'label'   => esc_html__( 'CTA Button URL', 'people-planet-thrive' ),
				'section' => 'ppt_cta_button',
				'type'    => 'url',
			)
		);

		// Footer Content Section.
		$wp_customize->add_section(
			'ppt_footer_content',
			array(
				'title'    => esc_html__( 'Footer Content', 'people-planet-thrive' ),
				'priority' => 40,
			)
		);

		// Footer Tagline.
		$wp_customize->add_setting(
			'ppt_footer_tagline',
			array(
				'default'           => esc_html__( 'Knowledge for People. Progress for Planet.', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_footer_tagline',
			array(
				'label'   => esc_html__( 'Footer Tagline', 'people-planet-thrive' ),
				'section' => 'ppt_footer_content',
				'type'    => 'text',
			)
		);

		// Footer Description.
		$wp_customize->add_setting(
			'ppt_footer_description',
			array(
				'default'           => esc_html__( 'Advancing research, publishing, and education for a thriving world.', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_textarea_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_footer_description',
			array(
				'label'   => esc_html__( 'Footer Description', 'people-planet-thrive' ),
				'section' => 'ppt_footer_content',
				'type'    => 'textarea',
			)
		);

		// Footer Explore Heading.
		$wp_customize->add_setting(
			'ppt_footer_explore_heading',
			array(
				'default'           => esc_html__( 'Explore', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_footer_explore_heading',
			array(
				'label'   => esc_html__( 'Explore Section Heading', 'people-planet-thrive' ),
				'section' => 'ppt_footer_content',
				'type'    => 'text',
			)
		);

		// Footer Resources Heading.
		$wp_customize->add_setting(
			'ppt_footer_resources_heading',
			array(
				'default'           => esc_html__( 'Resources', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_footer_resources_heading',
			array(
				'label'   => esc_html__( 'Resources Section Heading', 'people-planet-thrive' ),
				'section' => 'ppt_footer_content',
				'type'    => 'text',
			)
		);

		// Footer Contact Heading.
		$wp_customize->add_setting(
			'ppt_footer_contact_heading',
			array(
				'default'           => esc_html__( 'Contact', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_footer_contact_heading',
			array(
				'label'   => esc_html__( 'Contact Section Heading', 'people-planet-thrive' ),
				'section' => 'ppt_footer_content',
				'type'    => 'text',
			)
		);

		// Footer Newsletter Heading.
		$wp_customize->add_setting(
			'ppt_footer_newsletter_heading',
			array(
				'default'           => esc_html__( 'Stay Informed', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_footer_newsletter_heading',
			array(
				'label'   => esc_html__( 'Newsletter Section Heading', 'people-planet-thrive' ),
				'section' => 'ppt_footer_content',
				'type'    => 'text',
			)
		);

		// Footer Newsletter Description.
		$wp_customize->add_setting(
			'ppt_footer_newsletter_description',
			array(
				'default'           => esc_html__( 'Subscribe to our newsletter for the latest research and publications.', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_textarea_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_footer_newsletter_description',
			array(
				'label'   => esc_html__( 'Newsletter Description', 'people-planet-thrive' ),
				'section' => 'ppt_footer_content',
				'type'    => 'textarea',
			)
		);

		// Copyright Organization Name.
		$wp_customize->add_setting(
			'ppt_copyright_org_name',
			array(
				'default'           => esc_html__( 'People & Planet Thrive', 'people-planet-thrive' ),
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ppt_copyright_org_name',
			array(
				'label'   => esc_html__( 'Copyright Organization Name', 'people-planet-thrive' ),
				'section' => 'ppt_footer_content',
				'type'    => 'text',
			)
		);
	}
}
