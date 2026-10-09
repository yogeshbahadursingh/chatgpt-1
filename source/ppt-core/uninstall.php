<?php
/**
 * Uninstall handler for PPT Core.
 *
 * Fired when the plugin is uninstalled.
 *
 * @package PPTCore
 */

// Exit if not called by WordPress uninstall.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Remove plugin options.
delete_option( 'ppt_core_version' );
delete_option( 'ppt_core_activation_date' );
delete_option( 'ppt_core_flush_rewrite' );

// Remove transients.
delete_transient( 'ppt_core_flush_rewrite_rules' );

// Clean up any remaining transients with our prefix.
global $wpdb;
$wpdb->query(
	$wpdb->prepare(
		"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
		'_transient_ppt_core_%',
		'_transient_timeout_ppt_core_%'
	)
);

/**
 * IMPORTANT: Custom post type content is NOT deleted on uninstall.
 *
 * This is intentional — user data should be preserved.
 * If complete removal is required, it must be done manually via:
 * - wp shell: $wpdb->query("DELETE FROM wp_posts WHERE post_type IN ('ppt_journal','ppt_article')");
 * - Or a dedicated cleanup tool.
 *
 * Registered meta fields are automatically cleaned by WordPress
 * when the post type is no longer registered.
 */
