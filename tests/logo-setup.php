<?php
/** Isolated local integration checks; restores exact logo state and removes owned fixtures. */
if ( 0 !== strpos( DB_NAME, 'ppt_' ) || 'http://127.0.0.1:8877' !== untrailingslashit( home_url() ) || ! function_exists( 'ppt_install_brand_logo' ) ) { WP_CLI::error( 'Requires the isolated local PPT branding installation.' ); }
$checks = array(); $owned = array(); $uploaded = array(); $filters = array(); $token = wp_generate_uuid4();
$check = static function ( $name, $pass, $detail = '' ) use ( &$checks ) { $checks[] = array( 'test' => $name, 'status' => $pass ? 'PASS' : 'FAIL', 'detail' => $detail ); };
$add = static function ( $hook, $callback, $priority = 10, $args = 1 ) use ( &$filters ) { add_filter( $hook, $callback, $priority, $args ); $filters[] = array( $hook, $callback, $priority ); };
$original_user = get_current_user_id(); $theme_option = 'theme_mods_' . get_stylesheet();
$original = array(); foreach ( array( $theme_option, 'site_logo', 'ppt_logo_setup_warning', 'ppt_setup_version' ) as $option ) { $original[ $option ] = get_option( $option, null ); }
$original_logo = get_theme_mod( 'custom_logo' );
$source = PPT_THEME_DIR . '/assets/images/people-planet-thrive-logo.png'; $source_hash = hash_file( 'sha256', $source );
$record_attachment = static function ( $id ) use ( &$owned, $token ) { $owned[] = $id; update_post_meta( $id, '_ppt_qa_logo_run', $token ); };
$record_upload = static function ( $upload ) use ( &$uploaded ) { if ( empty( $upload['error'] ) && ! empty( $upload['file'] ) ) { $uploaded[] = $upload['file']; } return $upload; };
$skip_reuse = static function ( $posts, $query ) { return '_ppt_brand_asset_hash' === $query->get( 'meta_key' ) ? array() : $posts; };
$upload_error = static function () { return 'QA upload <error> & failure'; };
$insertion_error = static function ( $empty, $post ) { return 'attachment' === ( $post['post_type'] ?? '' ) ? true : $empty; };
$clear_logo = static function () { remove_theme_mod( 'custom_logo' ); delete_option( 'site_logo' ); };
$exception = null;
try {
	$add( 'add_attachment', $record_attachment ); $add( 'wp_handle_upload', $record_upload );
	wp_set_current_user( 0 ); $denied = ppt_install_brand_logo();
	$check( 'Anonymous logo setup is denied without mutation', is_wp_error( $denied ) && 'ppt_logo_permission' === $denied->get_error_code() && get_theme_mod( 'custom_logo' ) === $original_logo && ! $owned );
	wp_set_current_user( 1 );
	$deny_upload = static function ( $caps ) { $caps['upload_files'] = false; return $caps; };
	$add( 'user_has_cap', $deny_upload ); $denied = ppt_install_brand_logo(); remove_filter( 'user_has_cap', $deny_upload );
	$check( 'Upload capability is required', is_wp_error( $denied ) && 'ppt_logo_permission' === $denied->get_error_code() && ! $owned );
	$clear_logo(); $add( 'posts_pre_query', $skip_reuse, 10, 2 ); $first = ppt_install_brand_logo(); remove_filter( 'posts_pre_query', $skip_reuse );
	if ( is_wp_error( $first ) ) { throw new RuntimeException( $first->get_error_message() ); }
	$check( 'Initial setup creates a native image attachment', in_array( $first, $owned, true ) && wp_attachment_is_image( $first ) );
	$check( 'Uploaded original artwork is byte-identical', is_readable( wp_get_original_image_path( $first ) ) && hash_equals( $source_hash, hash_file( 'sha256', wp_get_original_image_path( $first ) ) ) );
	$check( 'Asset hash and native alternate text are stored', get_post_meta( $first, '_ppt_brand_asset_hash', true ) === $source_hash && 'People & Planet Thrive' === get_post_meta( $first, '_wp_attachment_image_alt', true ) );
	$check( 'Native site_logo is synchronized', (int) get_option( 'site_logo' ) === $first && (int) get_theme_mod( 'custom_logo' ) === $first );
	$html = do_blocks( '<!-- wp:site-logo {"width":156} /-->' ); $tags = new WP_HTML_Tag_Processor( $html );
	$check( 'Native Site Logo block renders image and alt', $tags->next_tag( 'img' ) && 'People & Planet Thrive' === $tags->get_attribute( 'alt' ) && $tags->get_attribute( 'src' ) );
	$count = count( $owned ); $again = ppt_install_brand_logo();
	$check( 'Repeated setup preserves ID with no new upload', $again === $first && count( $owned ) === $count );
	$clear_logo(); $reused = ppt_install_brand_logo();
	$check( 'Cleared setting reuses hashed media without duplicate', ! is_wp_error( $reused ) && get_post_meta( $reused, '_ppt_brand_asset_hash', true ) === $source_hash && count( $owned ) === $count );
	$fixture = wp_upload_bits( 'ppt-logo-qa-' . $token . '.png', null, file_get_contents( $source ) );
	if ( $fixture['error'] ) { throw new RuntimeException( $fixture['error'] ); }
	$other = wp_insert_attachment( array( 'post_title' => 'QA existing chosen logo', 'post_mime_type' => 'image/png', 'post_status' => 'inherit' ), $fixture['file'], 0, true );
	if ( is_wp_error( $other ) ) { throw new RuntimeException( $other->get_error_message() ); }
	require_once ABSPATH . 'wp-admin/includes/image.php'; wp_update_attachment_metadata( $other, wp_generate_attachment_metadata( $other, $fixture['file'] ) );
	update_option( 'site_logo', $other ); $count = count( $owned ); $preserved = ppt_install_brand_logo();
	$check( 'Existing Site Editor logo wins and remains untouched', $preserved === $other && (int) get_option( 'site_logo' ) === $other && count( $owned ) === $count );
	set_theme_mod( 'custom_logo', $first );
	$check( 'Theme logo selection synchronizes the native site option', (int) get_option( 'site_logo' ) === $first );
	$clear_logo(); $add( 'posts_pre_query', $skip_reuse, 10, 2 ); $add( 'wp_upload_bits', $upload_error ); $count = count( $owned );
	$failed = ppt_install_brand_logo();
	$check( 'Upload error is returned without a logo or attachment', is_wp_error( $failed ) && 'ppt_logo_upload' === $failed->get_error_code() && ! get_theme_mod( 'custom_logo' ) && count( $owned ) === $count );
	$woo_pages = 0; $rewrites = 0;
	$woo_called = static function ( $pages ) use ( &$woo_pages ) { $woo_pages++; return $pages; };
	$rewrite_called = static function () use ( &$rewrites ) { $rewrites++; };
	$add( 'woocommerce_create_pages', $woo_called ); $add( 'generate_rewrite_rules', $rewrite_called );
	update_option( 'ppt_setup_version', 'qa-before-logo-error' ); $setup = PPT_Site_Setup::run();
	$check( 'Logo failure does not block site/commerce/rewrite setup', ! is_wp_error( $setup ) && count( $setup ) >= 21 && $woo_pages > 0 && $rewrites > 0 && '2.3.3' === get_option( 'ppt_setup_version' ) );
	$check( 'Optional logo failure is recorded for administrator review', 'QA upload <error> & failure' === get_option( 'ppt_logo_setup_warning' ) );
	ob_start(); ( new PPT_Site_Setup() )->screen(); $notice = ob_get_clean();
	$check( 'Setup screen surfaces an escaped warning', false !== strpos( $notice, 'logo needs attention' ) && false !== strpos( $notice, 'QA upload &lt;error&gt; &amp; failure' ) && false === strpos( $notice, 'QA upload <error>' ) );
	remove_filter( 'wp_upload_bits', $upload_error ); $add( 'wp_insert_post_empty_content', $insertion_error, 10, 2 ); $before_files = count( $uploaded ); $failed = ppt_install_brand_logo();
	$last_file = count( $uploaded ) > $before_files ? end( $uploaded ) : '';
	$check( 'Attachment insertion failure removes its newly uploaded file', is_wp_error( $failed ) && 'empty_content' === $failed->get_error_code() && $last_file && ! file_exists( $last_file ) && count( $owned ) === $count );
	remove_filter( 'wp_insert_post_empty_content', $insertion_error ); remove_filter( 'posts_pre_query', $skip_reuse );
	$recovered = PPT_Site_Setup::run();
	$check( 'Successful repeat clears the prior optional warning', ! is_wp_error( $recovered ) && false === get_option( 'ppt_logo_setup_warning' ) && wp_attachment_is_image( get_theme_mod( 'custom_logo' ) ) );
} catch ( Throwable $error ) { $exception = $error->getMessage(); $check( 'Unexpected test exception', false, $exception ); }
finally {
	foreach ( array_reverse( $filters ) as $filter ) { remove_filter( $filter[0], $filter[1], $filter[2] ); }
	wp_set_current_user( 1 );
	// Restore raw theme state first, then the global Site Logo that can override it.
	foreach ( $original as $option => $value ) { if ( null === $value ) { delete_option( $option ); } else { update_option( $option, $value ); } }
	foreach ( $owned as $id ) { if ( $token === get_post_meta( $id, '_ppt_qa_logo_run', true ) ) { wp_delete_attachment( $id, true ); } }
	$upload_root = trailingslashit( wp_normalize_path( wp_upload_dir()['basedir'] ) );
	foreach ( $uploaded as $file ) { if ( is_file( $file ) && 0 === strpos( wp_normalize_path( $file ), $upload_root ) ) { wp_delete_file( $file ); } }
	$restored = true; foreach ( $original as $option => $value ) { $restored = $restored && get_option( $option, null ) === $value; }
	$check( 'Original logo and setup warning/version options restored', $restored && get_theme_mod( 'custom_logo' ) === $original_logo );
	$check( 'Owned attachment records and files removed', ! array_filter( $owned, 'get_post' ) && ! array_filter( $uploaded, 'file_exists' ) );
	wp_set_current_user( $original_user );
	file_put_contents( dirname( ABSPATH, 3 ) . '/runtime/logo-setup-results.json', wp_json_encode( $checks, JSON_PRETTY_PRINT ) );
}
echo wp_json_encode( $checks, JSON_PRETTY_PRINT );
if ( array_filter( $checks, static function ( $row ) { return 'FAIL' === $row['status']; } ) ) { WP_CLI::error( 'Logo setup checks failed.' ); }
