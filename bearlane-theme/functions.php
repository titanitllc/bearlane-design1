<?php
/**
 * BearLane Design — functions.php
 *
 * Loads all theme modules from /inc/ and nothing else.
 * Keep this file clean; add functionality in the relevant inc file.
 *
 * @package BearLane
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme version constant — bump when releasing updates.
define( 'BEARLANE_VERSION', '1.0.0' );
define( 'BEARLANE_DIR', get_template_directory() );
define( 'BEARLANE_URI', get_template_directory_uri() );

/**
 * Load theme modules.
 */
$bearlane_modules = [
	'/inc/theme-setup.php',
	'/inc/enqueue.php',
	'/inc/helpers.php',
	'/inc/woocommerce.php',
	'/inc/customizer.php',
	'/inc/blocks.php',
	'/inc/nav-fallback.php',
	// Homepage sections engine — UI-driven registry, getters,
	// sanitization, and seed migration from legacy Customizer values.
	'/inc/sections.php',
];

foreach ( $bearlane_modules as $module ) {
	require_once BEARLANE_DIR . $module;
}
