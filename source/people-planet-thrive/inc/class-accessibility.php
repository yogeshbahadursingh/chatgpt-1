<?php
/**
 * Accessibility Enhancements
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Accessibility
 *
 * Handles accessibility features and enhancements.
 */
class PPT_Accessibility {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'nav_menu_link_attributes', array( $this, 'add_menu_aria' ), 10, 4 );
		add_filter( 'wp_list_categories', array( $this, 'add_category_aria' ) );
		add_action( 'wp_head', array( $this, 'add_skip_link_styles' ) );
	}

	/**
	 * Add ARIA attributes to navigation menu links.
	 *
	 * @param array    $atts   Link attributes.
	 * @param WP_Post  $item   Menu item.
	 * @param stdClass $args   Menu arguments.
	 * @param int      $depth  Depth.
	 * @return array Modified attributes.
	 */
	public function add_menu_aria( $atts, $item, $args, $depth ) {
		// Add aria-current for current page.
		if ( in_array( 'current-menu-item', $item->classes, true ) ) {
			$atts['aria-current'] = 'page';
		}

		return $atts;
	}

	/**
	 * Add ARIA attributes to category lists.
	 *
	 * @param string $output Category list HTML.
	 * @return string Modified HTML.
	 */
	public function add_category_aria( $output ) {
		return str_replace( '<ul', '<ul role="list"', $output );
	}

	/**
	 * Output skip link styles in the head.
	 * These ensure the skip link is visible when focused.
	 */
	public function add_skip_link_styles() {
		?>
		<style id="ppt-skip-link-styles">
			.skip-link {
				position: absolute;
				left: -9999px;
				top: auto;
				width: 1px;
				height: 1px;
				overflow: hidden;
				z-index: -999;
			}
			.skip-link:focus {
				position: fixed;
				left: 1rem;
				top: 1rem;
				width: auto;
				height: auto;
				padding: 0.75rem 1.25rem;
				background: #062E2B;
				color: #FFFFFF;
				font-size: 0.875rem;
				font-weight: 600;
				text-decoration: none;
				z-index: 100000;
				outline: 2px solid #C69A45;
				outline-offset: 2px;
			}
			@media (prefers-reduced-motion: reduce) {
				*, *::before, *::after {
					animation-duration: 0.01ms !important;
					animation-iteration-count: 1 !important;
					transition-duration: 0.01ms !important;
					scroll-behavior: auto !important;
				}
			}
		</style>
		<?php
	}
}
