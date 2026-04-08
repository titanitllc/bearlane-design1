<?php
/**
 * BearLane Design — Theme Customizer
 *
 * Adds a "BearLane Design" panel to the WordPress Customizer for
 * managing brand colours, typography, and layout options without
 * touching code.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer sections, settings, and controls.
 *
 * @param \WP_Customize_Manager $wp_customize Customizer instance.
 */
function bearlane_customizer_register( \WP_Customize_Manager $wp_customize ): void {

	// -----------------------------------------------------------------------
	// Panel — BearLane Design
	// -----------------------------------------------------------------------

	$wp_customize->add_panel( 'bearlane_panel', [
		'title'       => __( 'BearLane Design', 'bearlane' ),
		'description' => __( 'Theme-specific settings for colours, typography, and layout.', 'bearlane' ),
		'priority'    => 30,
	] );

	// -----------------------------------------------------------------------
	// Section — Colours
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_colors', [
		'title'    => __( 'Colours', 'bearlane' ),
		'panel'    => 'bearlane_panel',
		'priority' => 10,
	] );

	$color_settings = [
		'accent_color'    => [ __( 'Accent Colour', 'bearlane' ),    '#111827' ],
		'accent_hover'    => [ __( 'Accent Hover', 'bearlane' ),     '#374151' ],
		'text_primary'    => [ __( 'Primary Text', 'bearlane' ),     '#111827' ],
		'text_secondary'  => [ __( 'Secondary Text', 'bearlane' ),   '#6b7280' ],
		'bg_color'        => [ __( 'Background Colour', 'bearlane' ), '#fafafa' ],
		'surface_color'   => [ __( 'Surface Colour', 'bearlane' ),   '#ffffff' ],
		'border_color'    => [ __( 'Border Colour', 'bearlane' ),    '#e5e7eb' ],
	];

	foreach ( $color_settings as $id => [ $label, $default ] ) {
		$wp_customize->add_setting( 'bearlane_' . $id, [
			'default'           => $default,
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'bearlane_' . $id, [
			'label'   => $label,
			'section' => 'bearlane_colors',
		] ) );
	}

	// -----------------------------------------------------------------------
	// Section — Typography
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_typography', [
		'title'    => __( 'Typography', 'bearlane' ),
		'panel'    => 'bearlane_panel',
		'priority' => 20,
	] );

	// Base font size.
	$wp_customize->add_setting( 'bearlane_font_size_base', [
		'default'           => '16',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( 'bearlane_font_size_base', [
		'label'       => __( 'Base Font Size (px)', 'bearlane' ),
		'section'     => 'bearlane_typography',
		'type'        => 'range',
		'input_attrs' => [ 'min' => 14, 'max' => 20, 'step' => 1 ],
	] );

	// -----------------------------------------------------------------------
	// Section — Header
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_header', [
		'title'    => __( 'Header', 'bearlane' ),
		'panel'    => 'bearlane_panel',
		'priority' => 30,
	] );

	$wp_customize->add_setting( 'bearlane_sticky_header', [
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'bearlane_sticky_header', [
		'label'   => __( 'Sticky Header', 'bearlane' ),
		'section' => 'bearlane_header',
		'type'    => 'checkbox',
	] );

	$wp_customize->add_setting( 'bearlane_header_announcement', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( 'bearlane_header_announcement', [
		'label'       => __( 'Announcement Bar Text', 'bearlane' ),
		'description' => __( 'Leave blank to hide the announcement bar.', 'bearlane' ),
		'section'     => 'bearlane_header',
		'type'        => 'text',
	] );

	// -----------------------------------------------------------------------
	// Section — Homepage Hero
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_hero', [
		'title'    => __( 'Homepage Hero', 'bearlane' ),
		'panel'    => 'bearlane_panel',
		'priority' => 40,
	] );

	$hero_settings = [
		'hero_heading'    => [ __( 'Hero Heading', 'bearlane' ),    'sanitize_text_field',         __( 'Crafted for the Bold.', 'bearlane' ) ],
		'hero_subheading' => [ __( 'Hero Subheading', 'bearlane' ), 'sanitize_text_field',         __( 'Premium products, minimal design.', 'bearlane' ) ],
		'hero_cta_label'  => [ __( 'CTA Button Label', 'bearlane' ),'sanitize_text_field',         __( 'Shop Now', 'bearlane' ) ],
		'hero_cta_url'    => [ __( 'CTA Button URL', 'bearlane' ),  'esc_url_raw',                 '/shop' ],
	];

	foreach ( $hero_settings as $id => [ $label, $sanitize, $default ] ) {
		$wp_customize->add_setting( 'bearlane_' . $id, [
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( 'bearlane_' . $id, [
			'label'   => $label,
			'section' => 'bearlane_hero',
			'type'    => 'text',
		] );
	}

	// Hero background image.
	$wp_customize->add_setting( 'bearlane_hero_image', [
		'default'           => '',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( new \WP_Customize_Media_Control( $wp_customize, 'bearlane_hero_image', [
		'label'     => __( 'Hero Background Image', 'bearlane' ),
		'section'   => 'bearlane_hero',
		'mime_type' => 'image',
	] ) );

	// -----------------------------------------------------------------------
	// Section — Footer
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_footer', [
		'title'    => __( 'Footer', 'bearlane' ),
		'panel'    => 'bearlane_panel',
		'priority' => 50,
	] );

	$wp_customize->add_setting( 'bearlane_footer_copyright', [
		'default'           => sprintf( '&copy; %d BearLane Design. All rights reserved.', gmdate( 'Y' ) ),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( 'bearlane_footer_copyright', [
		'label'   => __( 'Copyright Text', 'bearlane' ),
		'section' => 'bearlane_footer',
		'type'    => 'textarea',
	] );

	// -----------------------------------------------------------------------
	// Section — Dark Mode
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_dark_mode', [
		'title'    => __( 'Dark Mode', 'bearlane' ),
		'panel'    => 'bearlane_panel',
		'priority' => 60,
	] );

	$wp_customize->add_setting( 'bearlane_dark_mode_toggle', [
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'bearlane_dark_mode_toggle', [
		'label'       => __( 'Show Dark Mode Toggle', 'bearlane' ),
		'description' => __( 'Display a toggle button in the header for switching between light and dark mode.', 'bearlane' ),
		'section'     => 'bearlane_dark_mode',
		'type'        => 'checkbox',
	] );
}
add_action( 'customize_register', 'bearlane_customizer_register' );

/**
 * Output dynamic CSS custom properties driven by Customizer settings.
 * This runs on every page load; values are cached in a transient.
 */
function bearlane_customizer_css(): void {
	$css = bearlane_get_customizer_css();
	if ( $css ) {
		echo '<style id="bearlane-customizer-css">' . $css . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'bearlane_customizer_css', 99 );

/**
 * Build the customizer CSS string.
 *
 * @return string
 */
function bearlane_get_customizer_css(): string {
	$vars = [
		'--color-accent'     => get_theme_mod( 'bearlane_accent_color',   '#111827' ),
		'--color-accent-hover' => get_theme_mod( 'bearlane_accent_hover', '#374151' ),
		'--color-text'       => get_theme_mod( 'bearlane_text_primary',   '#111827' ),
		'--color-text-muted' => get_theme_mod( 'bearlane_text_secondary', '#6b7280' ),
		'--color-bg'         => get_theme_mod( 'bearlane_bg_color',       '#fafafa' ),
		'--color-surface'    => get_theme_mod( 'bearlane_surface_color',  '#ffffff' ),
		'--color-border'     => get_theme_mod( 'bearlane_border_color',   '#e5e7eb' ),
		'--font-size-base'   => get_theme_mod( 'bearlane_font_size_base', '16' ) . 'px',
	];

	$props = '';
	foreach ( $vars as $prop => $value ) {
		$props .= sanitize_text_field( $prop ) . ':' . sanitize_text_field( $value ) . ';';
	}

	return ':root{' . $props . '}';
}

/**
 * Flush the CSS cache when Customizer settings are saved.
 */
add_action( 'customize_save_after', fn() => delete_transient( 'bearlane_customizer_css' ) );
