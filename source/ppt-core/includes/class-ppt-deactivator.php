<?php
/**
 * Plugin Deactivator
 *
 * @package PPTCore
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Deactivator
 *
 * Fired during plugin deactivation.
 */
class PPT_Deactivator {

	/**
	 * Deactivate the plugin.
	 *
	 * Performs cleanup tasks on deactivation:
	 * - Flushes rewrite rules
	 * - Clears transients
	 */
	public static function deactivate(): void {
		self::flush_rewrite_rules();
		self::clear_transients();
	}

	/**
	 * Flush rewrite rules.
	 */
	private static function flush_rewrite_rules(): void {
		flush_rewrite_rules();
		delete_transient( 'ppt_core_flush_rewrite_rules' );
	}

	/**
	 * Clear plugin transients.
	 */
	private static function clear_transients(): void {
		delete_transient( 'ppt_core_flush_rewrite_rules' );
	}
}
