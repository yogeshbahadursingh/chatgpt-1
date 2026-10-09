<?php
/** User-supplied brand artwork, managed through WordPress's native Site Logo. */
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	add_theme_support( 'custom-logo', array( 'width' => 240, 'height' => 160, 'flex-width' => true, 'flex-height' => true ) );
} );

/** Install the bundled artwork once during an explicit administrator setup action. */
function ppt_install_brand_logo() {
	if ( ! current_user_can( 'edit_theme_options' ) || ! current_user_can( 'upload_files' ) ) {
		return new WP_Error( 'ppt_logo_permission', 'Administrator permission is required to configure the logo.' );
	}
	$current = (int) get_theme_mod( 'custom_logo' );
	if ( $current && wp_attachment_is_image( $current ) ) { return $current; }
	$source = PPT_THEME_DIR . '/assets/images/people-planet-thrive-logo.png';
	if ( ! is_readable( $source ) ) { return new WP_Error( 'ppt_logo_missing', 'The supplied logo file is missing from the theme.' ); }
	$hash = hash_file( 'sha256', $source );
	$existing = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => 1, 'fields' => 'ids', 'meta_key' => '_ppt_brand_asset_hash', 'meta_value' => $hash ) );
	$id = $existing ? (int) $existing[0] : 0;
	if ( ! $id || ! is_readable( get_attached_file( $id ) ) ) {
		$upload = wp_upload_bits( 'people-planet-thrive-logo.png', null, file_get_contents( $source ) );
		if ( ! empty( $upload['error'] ) ) { return new WP_Error( 'ppt_logo_upload', $upload['error'] ); }
		$id = wp_insert_attachment( array( 'post_title' => 'People & Planet Thrive logo', 'post_mime_type' => 'image/png', 'post_status' => 'inherit' ), $upload['file'], 0, true );
		if ( is_wp_error( $id ) ) { wp_delete_file( $upload['file'] ); return $id; }
		require_once ABSPATH . 'wp-admin/includes/image.php';
		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
		update_post_meta( $id, '_wp_attachment_image_alt', 'People & Planet Thrive' );
		update_post_meta( $id, '_ppt_brand_asset_hash', $hash );
	}
	set_theme_mod( 'custom_logo', $id );
	return $id;
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'ppt-branding', PPT_THEME_URI . '/assets/css/branding.css', array( 'ppt-navigation-premium' ), PPT_THEME_VERSION );
}, 45 );
