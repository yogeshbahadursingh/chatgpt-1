<?php
/** Progressive presentation for the editable WordPress navigation. */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'ppt-navigation-premium', PPT_THEME_URI . '/assets/css/navigation-premium.css', array( 'ppt-completion' ), PPT_THEME_VERSION );
	wp_enqueue_script( 'ppt-navigation-premium', PPT_THEME_URI . '/assets/js/navigation-premium.js', array(), PPT_THEME_VERSION, true );
}, 40 );
