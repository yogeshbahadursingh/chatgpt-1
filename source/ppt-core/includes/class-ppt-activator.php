<?php
/**
 * Plugin Activator
 *
 * @package PPTCore
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Activator
 *
 * Fired during plugin activation.
 */
class PPT_Activator {

	/**
	 * Activate the plugin.
	 *
	 * Performs setup tasks on activation:
	 * - Checks minimum requirements
	 * - Sets default options
	 * - Flushes rewrite rules
	 */
	public static function activate(): void {
		self::check_requirements();
		self::set_default_options();
		self::flush_rewrite_rules();
	}

	/**
	 * Check minimum requirements.
	 *
	 * @throws \RuntimeException If requirements are not met.
	 */
	private static function check_requirements(): void {
		// Check PHP version.
		if ( version_compare( PHP_VERSION, '8.0', '<' ) ) {
			deactivate_plugins( PPT_CORE_BASENAME );
			wp_die(
				esc_html(
					sprintf(
						/* translators: %s: required PHP version */
						__( 'PPT Core requires PHP %s or higher. Your current version is %s.', 'ppt-core' ),
						'8.0',
						PHP_VERSION
					)
				)
			);
		}

		// Check WordPress version.
		global $wp_version;
		if ( version_compare( $wp_version, '6.4', '<' ) ) {
			deactivate_plugins( PPT_CORE_BASENAME );
			wp_die(
				esc_html(
					sprintf(
						/* translators: %s: required WordPress version */
						__( 'PPT Core requires WordPress %s or higher.', 'ppt-core' ),
						'6.4'
					)
				)
			);
		}
	}

	/**
	 * Set default plugin options.
	 */
	private static function set_default_options(): void {
		add_option( 'ppt_core_version', PPT_CORE_VERSION );
		add_option( 'ppt_core_activation_date', current_time( 'mysql' ) );
		add_option( 'ppt_core_flush_rewrite', 1 );
	}

	/**
	 * Flush rewrite rules after activation.
	 *
	 * Uses a flag to ensure CPTs are registered before flushing.
	 */
	private static function flush_rewrite_rules(): void {
		// Flag is checked on init to flush after CPTs are registered.
		set_transient( 'ppt_core_flush_rewrite_rules', true, 30 );
	}
}
