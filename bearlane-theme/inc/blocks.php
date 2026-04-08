<?php
/**
 * BearLane Design — Gutenberg Block Registration
 *
 * Registers reusable custom block styles so editors can apply BearLane
 * design tokens directly inside the block editor without custom plugins.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register block styles for core blocks.
 */
function bearlane_register_block_styles(): void {

	// Button styles.
	register_block_style( 'core/button', [
		'name'  => 'bearlane-outline',
		'label' => __( 'Outline', 'bearlane' ),
	] );

	// Image styles.
	register_block_style( 'core/image', [
		'name'  => 'bearlane-rounded',
		'label' => __( 'Rounded', 'bearlane' ),
	] );

	// Group block styles.
	register_block_style( 'core/group', [
		'name'  => 'bearlane-card',
		'label' => __( 'Card', 'bearlane' ),
	] );

	// Heading accent line.
	register_block_style( 'core/heading', [
		'name'  => 'bearlane-accent',
		'label' => __( 'Accent Line', 'bearlane' ),
	] );

	// Quote highlight.
	register_block_style( 'core/quote', [
		'name'  => 'bearlane-highlight',
		'label' => __( 'Highlight', 'bearlane' ),
	] );
}
add_action( 'init', 'bearlane_register_block_styles' );

/**
 * Enqueue block editor styles.
 */
function bearlane_editor_styles(): void {
	add_editor_style( [ 'assets/css/editor.css', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap' ] );
}
add_action( 'after_setup_theme', 'bearlane_editor_styles' );

/**
 * Add theme.json colour palette to keep editor aligned with front-end tokens.
 */
function bearlane_block_editor_settings( array $settings ): array {
	$settings['__experimentalFeatures']['color']['palette']['theme'] = [
		[ 'slug' => 'accent',  'color' => get_theme_mod( 'bearlane_accent_color', '#111827' ), 'name' => __( 'Accent', 'bearlane' ) ],
		[ 'slug' => 'text',    'color' => get_theme_mod( 'bearlane_text_primary', '#111827' ), 'name' => __( 'Text', 'bearlane' ) ],
		[ 'slug' => 'surface', 'color' => get_theme_mod( 'bearlane_surface_color', '#ffffff' ), 'name' => __( 'Surface', 'bearlane' ) ],
	];
	return $settings;
}
add_filter( 'block_editor_settings_all', 'bearlane_block_editor_settings' );
