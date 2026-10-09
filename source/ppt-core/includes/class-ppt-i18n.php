<?php
/**
 * Internationalisation
 *
 * @package PPTCore
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_i18n
 *
 * Handles plugin internationalisation.
 */
class PPT_i18n {

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain(): void {
		load_plugin_textdomain(
			'ppt-core',
			false,
			dirname( PPT_CORE_BASENAME ) . '/languages/'
		);
	}
}
