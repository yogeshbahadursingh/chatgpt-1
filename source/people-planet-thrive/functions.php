<?php
/**
 * People & Planet Thrive Theme functions and definitions
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme constants.
 */
define( 'PPT_THEME_VERSION', '2.3.3' );
define( 'PPT_THEME_DIR', get_template_directory() );
define( 'PPT_THEME_URI', get_template_directory_uri() );

/**
 * Load theme includes.
 */
$ppt_includes = array(
	'inc/class-theme-setup.php',
	'inc/class-enqueue.php',
	'inc/class-block-styles.php',
	'inc/class-patterns.php',
	'inc/class-accessibility.php',
	'inc/class-editor.php',
	'inc/template-helpers.php',
);

foreach ( $ppt_includes as $ppt_include ) {
	$ppt_file = PPT_THEME_DIR . '/' . $ppt_include;
	if ( file_exists( $ppt_file ) ) {
		require_once $ppt_file;
	}
}

/**
 * Load WooCommerce compatibility if WooCommerce is active.
 */
if ( class_exists( 'WooCommerce' ) ) {
	$ppt_woo_file = PPT_THEME_DIR . '/inc/class-woocommerce.php';
	if ( file_exists( $ppt_woo_file ) ) {
		require_once $ppt_woo_file;
	}
}

/**
 * Load schema output.
 */
$ppt_schema_file = PPT_THEME_DIR . '/inc/class-schema.php';
if ( file_exists( $ppt_schema_file ) ) {
	require_once $ppt_schema_file;
}

/**
 * Initialize theme.
 */
function ppt_theme_init() {
	// Initialize theme setup.
	if ( class_exists( 'PPT_Theme_Setup' ) ) {
		new PPT_Theme_Setup();
	}

	// Initialize asset enqueuing.
	if ( class_exists( 'PPT_Enqueue' ) ) {
		new PPT_Enqueue();
	}

	// Initialize block styles.
	if ( class_exists( 'PPT_Block_Styles' ) ) {
		new PPT_Block_Styles();
	}

	// Initialize patterns.
	if ( class_exists( 'PPT_Patterns' ) ) {
		new PPT_Patterns();
	}

	// Initialize accessibility.
	if ( class_exists( 'PPT_Accessibility' ) ) {
		new PPT_Accessibility();
	}

	// Initialize WooCommerce compatibility.
	if ( class_exists( 'WooCommerce' ) && class_exists( 'PPT_WooCommerce' ) ) {
		new PPT_WooCommerce();
	}

	// Initialize schema output.
	if ( class_exists( 'PPT_Schema' ) ) {
		new PPT_Schema();
	}
}
add_action( 'after_setup_theme', 'ppt_theme_init', 5 );

/**
 * Cinematic brand intro — front page, once per browser session.
 */
function ppt_brand_intro_head_state() {
	if ( ! is_front_page() ) {
		return;
	}
	?>
	<script id="ppt-brand-intro-state">(function(){try{if(sessionStorage.getItem('pptBrandIntroSeen')==='1'){document.documentElement.classList.add('ppt-intro-seen');}else{document.documentElement.classList.add('ppt-intro-first');}}catch(e){document.documentElement.classList.add('ppt-intro-first');}}());</script>
	<?php
}
add_action( 'wp_head', 'ppt_brand_intro_head_state', 1 );

function ppt_render_brand_intro() {
	if ( ! is_front_page() ) {
		return;
	}
	?>
	<div class="ppt-brand-intro" id="ppt-brand-intro" aria-hidden="true">
		<div class="ppt-intro-stage">
			<div class="ppt-intro-mark" aria-hidden="true">
				<span class="ppt-intro-core"></span>
				<span class="ppt-intro-ring ppt-intro-ring-a"></span>
				<span class="ppt-intro-ring ppt-intro-ring-b"></span>
				<span class="ppt-intro-dot"></span>
			</div>
			<div class="ppt-intro-wordmark">
				<span class="ppt-intro-people">People</span>
				<span class="ppt-intro-amp">&amp;</span>
				<span class="ppt-intro-planet">Planet</span>
				<strong>Thrive</strong>
			</div>
			<p>Knowledge for People. Progress for Planet.</p>
		</div>
	</div>
	<?php
}
add_action( 'wp_body_open', 'ppt_render_brand_intro', 2 );

/**
 * Make root-relative links in block templates portable to WordPress installs
 * hosted in a subdirectory (for example http://localhost/ppthrive/).
 * This preserves normal root URLs on production installs at the domain root.
 */
function ppt_portable_block_links( $block_content, $block ) {
	if ( is_admin() || empty( $block_content ) ) {
		return $block_content;
	}
	$home_path = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	$home_path = trailingslashit( $home_path ? $home_path : '/' );
	if ( '/' === $home_path ) {
		return $block_content;
	}
	return preg_replace_callback(
		'/href=("|\')\/(?!\/|wp-admin|wp-content|wp-includes)([^"\']*)\1/i',
		static function ( $m ) use ( $home_path ) {
			return 'href=' . $m[1] . esc_url( $home_path . ltrim( $m[2], '/' ) ) . $m[1];
		},
		$block_content
	);
}
add_filter( 'render_block', 'ppt_portable_block_links', 20, 2 );
require_once PPT_THEME_DIR . '/inc/completion.php';
require_once PPT_THEME_DIR . '/inc/navigation-premium.php';
require_once PPT_THEME_DIR . '/inc/branding.php';
