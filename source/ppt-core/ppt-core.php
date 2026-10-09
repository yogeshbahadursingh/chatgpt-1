<?php
/**
 * Plugin Name:       PPT Core
 * Plugin URI:        https://ppthrive.com
 * Description:       Core functionality for People & Planet Thrive — custom post types, taxonomies, meta fields, and organisation-specific data models for scholarly publishing, research, training, and events.
 * Version:           2.3.0
 * Author:            People & Planet Thrive Initiative Pvt. Ltd.
 * Author URI:        https://ppthrive.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ppt-core
 * Domain Path:       /languages
 * Requires at least: 6.4
 * Requires PHP:      8.0
 *
 * @package PPTCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin constants.
 */
define( 'PPT_CORE_VERSION', '2.3.0' );
define( 'PPT_CORE_FILE', __FILE__ );
define( 'PPT_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'PPT_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'PPT_CORE_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Load dependencies.
 */
$ppt_dependencies = array(
	'includes/class-ppt-loader.php',
	'includes/class-ppt-i18n.php',
	'includes/class-ppt-activator.php',
	'includes/class-ppt-deactivator.php',
	'includes/class-ppt-core.php',
	'includes/class-ppt-meta-boxes.php',
);

// Load demo importer in admin
if ( is_admin() || ( defined('WP_CLI') && WP_CLI ) ) {
	$ppt_dependencies[] = 'includes/class-ppt-demo-importer.php';
	$ppt_dependencies[] = 'includes/class-ppt-site-setup.php';
}

foreach ( $ppt_dependencies as $ppt_dependency ) {
	$ppt_file = PPT_CORE_PATH . $ppt_dependency;
	if ( file_exists( $ppt_file ) ) {
		require_once $ppt_file;
	} else {
		error_log( sprintf( 'PPT Core: Missing dependency file: %s', $ppt_file ) );
	}
}

/**
 * Plugin activation hook.
 */
function ppt_core_activate() {
	PPT_Activator::activate();
}
register_activation_hook( __FILE__, 'ppt_core_activate' );

/**
 * Plugin deactivation hook.
 */
function ppt_core_deactivate() {
	PPT_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'ppt_core_deactivate' );

/**
 * Initialize plugin.
 *
 * @return PPT_Core
 */
function ppt_core() {
	return PPT_Core::get_instance();
}

// Start the plugin.
ppt_core();
require_once PPT_CORE_PATH . 'includes/platform.php';
