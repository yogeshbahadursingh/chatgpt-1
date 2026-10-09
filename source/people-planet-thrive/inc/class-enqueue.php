<?php
/**
 * Asset Enqueuing
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Enqueue
 *
 * Handles loading of CSS and JavaScript assets.
 */
class PPT_Enqueue {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
	}

	/**
	 * Enqueue frontend scripts and styles.
	 */
	public function enqueue_frontend_assets() {
		// Main theme stylesheet is loaded by WordPress from style.css.

		// Design system — core component library.
		$design_system_css = PPT_THEME_DIR . '/assets/css/design-system.css';
		if ( file_exists( $design_system_css ) ) {
			wp_enqueue_style(
				'ppt-design-system',
				PPT_THEME_URI . '/assets/css/design-system.css',
				array(),
				filemtime( $design_system_css )
			);
		}

		// Chrome styles (header, footer, utility bar, navigation).
		$chrome_css = PPT_THEME_DIR . '/assets/css/chrome.css';
		if ( file_exists( $chrome_css ) ) {
			wp_enqueue_style(
				'ppt-chrome',
				PPT_THEME_URI . '/assets/css/chrome.css',
				array( 'ppt-design-system' ),
				filemtime( $chrome_css )
			);
		}

		// Homepage styles (only on front page).
		if ( is_front_page() ) {
			$homepage_css = PPT_THEME_DIR . '/assets/css/homepage.css';
			if ( file_exists( $homepage_css ) ) {
				wp_enqueue_style(
					'ppt-homepage',
					PPT_THEME_URI . '/assets/css/homepage.css',
					array( 'ppt-design-system' ),
					filemtime( $homepage_css )
				);
			}
		}

		// Scholarly reading experience styles (only on article pages).
		if ( is_singular( 'ppt_article' ) || is_post_type_archive( 'ppt_article' ) ) {
			$scholarly_css = PPT_THEME_DIR . '/assets/css/scholarly.css';
			if ( file_exists( $scholarly_css ) ) {
				wp_enqueue_style(
					'ppt-scholarly',
					PPT_THEME_URI . '/assets/css/scholarly.css',
					array( 'ppt-design-system' ),
					filemtime( $scholarly_css )
				);
			}
		}

		// Research platform styles (only on research pages).
		if ( is_singular( array( 'ppt_research_area', 'ppt_research_project', 'ppt_researcher' ) ) || 
		     is_post_type_archive( array( 'ppt_research_area', 'ppt_research_project', 'ppt_researcher' ) ) ||
		     is_page_template( 'page-research-landing.php' ) ) {
			$research_css = PPT_THEME_DIR . '/assets/css/research.css';
			if ( file_exists( $research_css ) ) {
				wp_enqueue_style(
					'ppt-research',
					PPT_THEME_URI . '/assets/css/research.css',
					array( 'ppt-design-system' ),
					filemtime( $research_css )
				);
			}
		}

		// Publications and commerce styles (only on publication and WooCommerce pages).
		if ( is_singular( 'ppt_publication' ) || 
		     is_post_type_archive( 'ppt_publication' ) ||
		     is_page_template( 'page-publications-landing.php' ) ||
		     ( function_exists( 'is_shop' ) && ( is_shop() || is_product() || is_product_category() || is_product_tag() || is_cart() || is_checkout() || is_account_page() ) ) ) {
			$publications_css = PPT_THEME_DIR . '/assets/css/publications.css';
			if ( file_exists( $publications_css ) ) {
				wp_enqueue_style(
					'ppt-publications',
					PPT_THEME_URI . '/assets/css/publications.css',
					array( 'ppt-design-system' ),
					filemtime( $publications_css )
				);
			}
		}

		// Training and events styles (only on training and event pages).
		if ( is_singular( array( 'ppt_training', 'ppt_event' ) ) || 
		     is_post_type_archive( array( 'ppt_training', 'ppt_event' ) ) ||
		     is_page_template( array( 'page-training-landing.php', 'page-events-landing.php' ) ) ) {
			$training_events_css = PPT_THEME_DIR . '/assets/css/training-events.css';
			if ( file_exists( $training_events_css ) ) {
				wp_enqueue_style(
					'ppt-training-events',
					PPT_THEME_URI . '/assets/css/training-events.css',
					array( 'ppt-design-system' ),
					filemtime( $training_events_css )
				);
			}
		}

		// Editorial styles (only on post/article pages).
		if ( is_singular( 'post' ) || is_home() || is_archive() || is_category() || is_tag() || is_author() || is_page_template( 'page-insights-landing.php' ) ) {
			$editorial_css = PPT_THEME_DIR . '/assets/css/editorial.css';
			if ( file_exists( $editorial_css ) ) {
				wp_enqueue_style(
					'ppt-editorial',
					PPT_THEME_URI . '/assets/css/editorial.css',
					array( 'ppt-design-system' ),
					filemtime( $editorial_css )
				);
			}

			// Table of Contents script (only on single posts).
			if ( is_singular( 'post' ) ) {
				$toc_js = PPT_THEME_DIR . '/assets/js/table-of-contents.js';
				if ( file_exists( $toc_js ) ) {
					wp_enqueue_script(
						'ppt-toc',
						PPT_THEME_URI . '/assets/js/table-of-contents.js',
						array(),
						filemtime( $toc_js ),
						true
					);
				}
			}
		}

		// Institutional styles (only on institutional pages).
		if ( is_page_template( array(
			'page-about.php',
			'page-mission-vision.php',
			'page-our-approach.php',
			'page-leadership.php',
			'page-team.php',
			'page-partners.php',
			'page-careers.php',
			'page-contact.php',
			'page-policy.php',
		) ) ) {
			$institutional_css = PPT_THEME_DIR . '/assets/css/institutional.css';
			if ( file_exists( $institutional_css ) ) {
				wp_enqueue_style(
					'ppt-institutional',
					PPT_THEME_URI . '/assets/css/institutional.css',
					array( 'ppt-design-system' ),
					filemtime( $institutional_css )
				);
			}
		}

		// Submission rescue stylesheet — final visual layer.
		$rescue_css = PPT_THEME_DIR . '/assets/css/rescue.css';
		if ( file_exists( $rescue_css ) ) {
			wp_enqueue_style(
				'ppt-rescue',
				PPT_THEME_URI . '/assets/css/rescue.css',
				array( 'ppt-design-system', 'ppt-chrome' ),
				filemtime( $rescue_css )
			);
		}

		// Additional CSS for custom blocks.
		$custom_blocks_css = PPT_THEME_DIR . '/assets/css/custom-blocks.css';
		if ( file_exists( $custom_blocks_css ) ) {
			wp_enqueue_style(
				'ppt-custom-blocks',
				PPT_THEME_URI . '/assets/css/custom-blocks.css',
				array( 'ppt-design-system' ),
				filemtime( $custom_blocks_css )
			);
		}

		// Header interactions script.
		$header_js = PPT_THEME_DIR . '/assets/js/header.js';
		if ( file_exists( $header_js ) ) {
			wp_enqueue_script(
				'ppt-header',
				PPT_THEME_URI . '/assets/js/header.js',
				array(),
				filemtime( $header_js ),
				true
			);

			// Pass Customizer values to JavaScript.
			wp_localize_script(
				'ppt-header',
				'pptThemeData',
				array(
					'contactEmail' => ppt_get_contact_email(),
					'contactPhone' => ppt_get_contact_phone(),
					'ctaText'      => ppt_get_cta_text(),
					'ctaUrl'       => ppt_get_cta_url(),
				)
			);
		}

		// Premium hero orb motion (front page only).
		if ( is_front_page() ) {
			$hero_orb_js = PPT_THEME_DIR . '/assets/js/hero-orb.js';
			if ( file_exists( $hero_orb_js ) ) {
				wp_enqueue_script(
					'ppt-hero-orb',
					PPT_THEME_URI . '/assets/js/hero-orb.js',
					array(),
					filemtime( $hero_orb_js ),
					true
				);
			}
		}

		// Cinematic brand intro (front page only, once per session).
		if ( is_front_page() ) {
			$brand_intro_js = PPT_THEME_DIR . '/assets/js/brand-intro.js';
			if ( file_exists( $brand_intro_js ) ) {
				wp_enqueue_script(
					'ppt-brand-intro',
					PPT_THEME_URI . '/assets/js/brand-intro.js',
					array(),
					filemtime( $brand_intro_js ),
					true
				);
			}
		}

		// Navigation script.
		$navigation_js = PPT_THEME_DIR . '/assets/js/navigation.js';
		if ( file_exists( $navigation_js ) ) {
			wp_enqueue_script(
				'ppt-navigation',
				PPT_THEME_URI . '/assets/js/navigation.js',
				array(),
				filemtime( $navigation_js ),
				true
			);
		}

		// Skip link focus fix.
		$skip_link_js = PPT_THEME_DIR . '/assets/js/skip-link.js';
		if ( file_exists( $skip_link_js ) ) {
			wp_enqueue_script(
				'ppt-skip-link',
				PPT_THEME_URI . '/assets/js/skip-link.js',
				array(),
				filemtime( $skip_link_js ),
				true
			);
		}

		// Comment reply script.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Enqueue editor assets.
	 */
	public function enqueue_editor_assets() {
		$editor_css = PPT_THEME_DIR . '/assets/css/editor.css';
		if ( file_exists( $editor_css ) ) {
			wp_enqueue_style(
				'ppt-editor-styles',
				PPT_THEME_URI . '/assets/css/editor.css',
				array(),
				filemtime( $editor_css )
			);
		}
	}
}
