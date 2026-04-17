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
	// Section — Theme Colours (central brand palette)
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_colors', [
		'title'       => __( 'Theme Colours', 'bearlane' ),
		'description' => __( 'Central brand colours used across the entire site. Changing these will update buttons, links, headings, and all component defaults.', 'bearlane' ),
		'panel'       => 'bearlane_panel',
		'priority'    => 10,
	] );

	$color_settings = [
		'primary_color'     => [ __( 'Primary Colour (Navy)', 'bearlane' ),      '#1B2D42' ],
		'primary_hover'     => [ __( 'Primary Hover', 'bearlane' ),              '#263D56' ],
		'secondary_color'   => [ __( 'Secondary Colour (Green)', 'bearlane' ),   '#3D8B37' ],
		'secondary_hover'   => [ __( 'Secondary Hover', 'bearlane' ),            '#2D6B29' ],
		'accent_color'      => [ __( 'Accent Colour (Gold)', 'bearlane' ),       '#c9a84c' ],
		'accent_hover'      => [ __( 'Accent Hover', 'bearlane' ),               '#a07828' ],
		'accent_light'      => [ __( 'Accent Light', 'bearlane' ),               '#f0e0a8' ],
		'heading_color'     => [ __( 'Heading Colour', 'bearlane' ),             '#1B2D42' ],
		'text_primary'      => [ __( 'Primary Text', 'bearlane' ),               '#1B2D42' ],
		'text_secondary'    => [ __( 'Secondary Text', 'bearlane' ),             '#5e6a75' ],
		'bg_color'          => [ __( 'Background Colour', 'bearlane' ),          '#F2F4F5' ],
		'surface_color'     => [ __( 'Surface Colour', 'bearlane' ),             '#ffffff' ],
		'surface_2_color'   => [ __( 'Surface 2 Colour', 'bearlane' ),           '#E8EEF1' ],
		'border_color'      => [ __( 'Border Colour', 'bearlane' ),              '#d5dde2' ],
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
	// Section — Header Navigation Styling
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_header_nav_styles', [
		'title'       => __( 'Header Navigation Colours', 'bearlane' ),
		'description' => __( 'Control colours for the primary desktop navigation links in the header.', 'bearlane' ),
		'panel'       => 'bearlane_panel',
		'priority'    => 31,
	] );

	$header_nav_colors = [
		'header_nav_text'          => [ __( 'Text Colour', 'bearlane' ),           '#1B2D42' ],
		'header_nav_bg'            => [ __( 'Background Colour', 'bearlane' ),     '' ],
		'header_nav_border'        => [ __( 'Border Colour', 'bearlane' ),         '' ],
		'header_nav_hover_text'    => [ __( 'Hover Text Colour', 'bearlane' ),     '#3D8B37' ],
		'header_nav_hover_bg'      => [ __( 'Hover Background', 'bearlane' ),      '#E8EEF1' ],
		'header_nav_hover_border'  => [ __( 'Hover Border Colour', 'bearlane' ),   '' ],
		'header_nav_active_text'   => [ __( 'Active/Current Text', 'bearlane' ),   '#3D8B37' ],
		'header_nav_active_bg'     => [ __( 'Active/Current Background', 'bearlane' ), '#E8EEF1' ],
		'header_nav_active_border' => [ __( 'Active/Current Border', 'bearlane' ), '' ],
	];

	foreach ( $header_nav_colors as $id => [ $label, $default ] ) {
		$wp_customize->add_setting( 'bearlane_' . $id, [
			'default'           => $default,
			'sanitize_callback' => 'bearlane_sanitize_color_or_empty',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'bearlane_' . $id, [
			'label'   => $label,
			'section' => 'bearlane_header_nav_styles',
		] ) );
	}

	// -----------------------------------------------------------------------
	// Section — Header Action Icons Styling
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_header_action_styles', [
		'title'       => __( 'Header Action Icon Colours', 'bearlane' ),
		'description' => __( 'Control colours for search, cart, account, and dark mode toggle buttons.', 'bearlane' ),
		'panel'       => 'bearlane_panel',
		'priority'    => 32,
	] );

	$header_action_colors = [
		'header_action_text'          => [ __( 'Icon Colour', 'bearlane' ),             '#1B2D42' ],
		'header_action_bg'            => [ __( 'Background', 'bearlane' ),              '' ],
		'header_action_border'        => [ __( 'Border Colour', 'bearlane' ),           '' ],
		'header_action_hover_text'    => [ __( 'Hover Icon Colour', 'bearlane' ),       '#3D8B37' ],
		'header_action_hover_bg'      => [ __( 'Hover Background', 'bearlane' ),        '#E8EEF1' ],
		'header_action_hover_border'  => [ __( 'Hover Border Colour', 'bearlane' ),     '' ],
		'header_action_active_text'   => [ __( 'Active Icon Colour', 'bearlane' ),      '#3D8B37' ],
		'header_action_active_bg'     => [ __( 'Active Background', 'bearlane' ),       '#E8EEF1' ],
		'header_action_active_border' => [ __( 'Active Border Colour', 'bearlane' ),    '' ],
	];

	foreach ( $header_action_colors as $id => [ $label, $default ] ) {
		$wp_customize->add_setting( 'bearlane_' . $id, [
			'default'           => $default,
			'sanitize_callback' => 'bearlane_sanitize_color_or_empty',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'bearlane_' . $id, [
			'label'   => $label,
			'section' => 'bearlane_header_action_styles',
		] ) );
	}

	// -----------------------------------------------------------------------
	// Section — Header CTA Button Styling
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_header_cta_styles', [
		'title'       => __( 'Header CTA Button Colours', 'bearlane' ),
		'description' => __( 'Colours for any CTA / call-to-action buttons placed in the header menu.', 'bearlane' ),
		'panel'       => 'bearlane_panel',
		'priority'    => 33,
	] );

	$header_cta_colors = [
		'header_cta_text'         => [ __( 'Text Colour', 'bearlane' ),         '#ffffff' ],
		'header_cta_bg'           => [ __( 'Background', 'bearlane' ),          '#3D8B37' ],
		'header_cta_border'       => [ __( 'Border Colour', 'bearlane' ),       '#3D8B37' ],
		'header_cta_hover_text'   => [ __( 'Hover Text Colour', 'bearlane' ),   '#ffffff' ],
		'header_cta_hover_bg'     => [ __( 'Hover Background', 'bearlane' ),    '#2D6B29' ],
		'header_cta_hover_border' => [ __( 'Hover Border Colour', 'bearlane' ), '#2D6B29' ],
	];

	foreach ( $header_cta_colors as $id => [ $label, $default ] ) {
		$wp_customize->add_setting( 'bearlane_' . $id, [
			'default'           => $default,
			'sanitize_callback' => 'bearlane_sanitize_color_or_empty',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'bearlane_' . $id, [
			'label'   => $label,
			'section' => 'bearlane_header_cta_styles',
		] ) );
	}

	// -----------------------------------------------------------------------
	// Section — Mobile Navigation Styling
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_mobile_nav_styles', [
		'title'       => __( 'Mobile Navigation Colours', 'bearlane' ),
		'description' => __( 'Control colours for the off-canvas mobile navigation menu.', 'bearlane' ),
		'panel'       => 'bearlane_panel',
		'priority'    => 34,
	] );

	$mobile_nav_colors = [
		'mobile_nav_text'          => [ __( 'Text Colour', 'bearlane' ),            '#1B2D42' ],
		'mobile_nav_bg'            => [ __( 'Background', 'bearlane' ),             '' ],
		'mobile_nav_border'        => [ __( 'Border Colour', 'bearlane' ),          '' ],
		'mobile_nav_hover_text'    => [ __( 'Hover Text Colour', 'bearlane' ),      '#3D8B37' ],
		'mobile_nav_hover_bg'      => [ __( 'Hover Background', 'bearlane' ),       '#E8EEF1' ],
		'mobile_nav_hover_border'  => [ __( 'Hover Border Colour', 'bearlane' ),    '' ],
		'mobile_nav_active_text'   => [ __( 'Active/Current Text', 'bearlane' ),    '#3D8B37' ],
		'mobile_nav_active_bg'     => [ __( 'Active/Current Background', 'bearlane' ), '#E8EEF1' ],
		'mobile_nav_active_border' => [ __( 'Active/Current Border', 'bearlane' ),  '' ],
	];

	foreach ( $mobile_nav_colors as $id => [ $label, $default ] ) {
		$wp_customize->add_setting( 'bearlane_' . $id, [
			'default'           => $default,
			'sanitize_callback' => 'bearlane_sanitize_color_or_empty',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'bearlane_' . $id, [
			'label'   => $label,
			'section' => 'bearlane_mobile_nav_styles',
		] ) );
	}

	// -----------------------------------------------------------------------
	// Section — WooCommerce Header Links
	// -----------------------------------------------------------------------

	$wp_customize->add_section( 'bearlane_woo_header_links', [
		'title'       => __( 'Cart & Account Links', 'bearlane' ),
		'description' => __( 'Fallback page assignments for the header cart and account icons. WooCommerce pages are used automatically when available.', 'bearlane' ),
		'panel'       => 'bearlane_panel',
		'priority'    => 35,
	] );

	$wp_customize->add_setting( 'bearlane_cart_fallback_page', [
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'bearlane_cart_fallback_page', [
		'label'       => __( 'Cart Fallback Page', 'bearlane' ),
		'description' => __( 'Used only when WooCommerce cart page is unavailable.', 'bearlane' ),
		'section'     => 'bearlane_woo_header_links',
		'type'        => 'dropdown-pages',
	] );

	$wp_customize->add_setting( 'bearlane_account_fallback_page', [
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'bearlane_account_fallback_page', [
		'label'       => __( 'Account Fallback Page', 'bearlane' ),
		'description' => __( 'Used only when WooCommerce My Account page is unavailable.', 'bearlane' ),
		'section'     => 'bearlane_woo_header_links',
		'type'        => 'dropdown-pages',
	] );

	// -----------------------------------------------------------------------
	// Section — Homepage Hero (legacy)
	// -----------------------------------------------------------------------
	//
	// As of the sections refactor, the homepage hero is managed from
	// Appearance → Homepage Sections (inc/sections.php + inc/admin-sections.php).
	// These Customizer controls are kept only so existing saved values
	// continue to flow through the one-time seed migration in
	// bearlane_sections_maybe_seed(). They can be safely removed after
	// users have migrated.

	$wp_customize->add_section( 'bearlane_hero', [
		'title'       => __( 'Homepage Hero (legacy)', 'bearlane' ),
		'description' => __( 'Deprecated — edit the homepage hero from Appearance → Homepage Sections instead.', 'bearlane' ),
		'panel'       => 'bearlane_panel',
		'priority'    => 40,
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

	$footer_colors = [
		'footer_bg'         => [ __( 'Footer Background', 'bearlane' ),        '' ],
		'footer_bg_accent'  => [ __( 'Footer Background Accent', 'bearlane' ), '' ],
		'footer_text'       => [ __( 'Footer Text Colour', 'bearlane' ),       '#ffffff' ],
		'footer_accent'     => [ __( 'Footer Accent Colour', 'bearlane' ),     '' ],
	];

	foreach ( $footer_colors as $id => [ $label, $default ] ) {
		$wp_customize->add_setting( 'bearlane_' . $id, [
			'default'           => $default,
			'sanitize_callback' => 'bearlane_sanitize_color_or_empty',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'bearlane_' . $id, [
			'label'       => $label,
			'description' => __( 'Leave empty to inherit from theme colours.', 'bearlane' ),
			'section'     => 'bearlane_footer',
		] ) );
	}

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
 * Sanitize a hex colour or allow empty string (transparent).
 *
 * @param string $value Input value.
 * @return string Sanitized hex colour or empty string.
 */
function bearlane_sanitize_color_or_empty( string $value ): string {
	if ( '' === $value ) {
		return '';
	}
	$color = sanitize_hex_color( $value );
	return $color ? $color : '';
}

/**
 * Convert a 3- or 6-digit hex colour to a "R, G, B" triplet for use inside
 * rgb()/rgba() CSS functions (e.g. "201, 168, 76" for #c9a84c).
 */
function bearlane_hex_to_rgb_triplet( string $hex ): string {
	$hex = ltrim( (string) $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( 6 !== strlen( $hex ) || ! ctype_xdigit( $hex ) ) {
		return '201, 168, 76';
	}
	return hexdec( substr( $hex, 0, 2 ) ) . ', ' . hexdec( substr( $hex, 2, 2 ) ) . ', ' . hexdec( substr( $hex, 4, 2 ) );
}

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
	$primary    = get_theme_mod( 'bearlane_primary_color',   '#1B2D42' );
	$pri_hover  = get_theme_mod( 'bearlane_primary_hover',   '#263D56' );
	$secondary  = get_theme_mod( 'bearlane_secondary_color', '#3D8B37' );
	$sec_hover  = get_theme_mod( 'bearlane_secondary_hover', '#2D6B29' );
	$surface_2  = get_theme_mod( 'bearlane_surface_2_color', '#E8EEF1' );
	$gold       = get_theme_mod( 'bearlane_accent_color',    '#c9a84c' );
	$gold_dark  = get_theme_mod( 'bearlane_accent_hover',    '#a07828' );
	$gold_light = get_theme_mod( 'bearlane_accent_light',    '#f0e0a8' );

	$footer_bg        = get_theme_mod( 'bearlane_footer_bg',        '' ) ?: $primary;
	$footer_bg_accent = get_theme_mod( 'bearlane_footer_bg_accent', '' ) ?: $pri_hover;
	$footer_text      = get_theme_mod( 'bearlane_footer_text',      '#ffffff' );
	$footer_accent    = get_theme_mod( 'bearlane_footer_accent',    '' ) ?: $gold;

	$vars = [
		'--color-primary'         => $primary,
		'--color-primary-hover'   => $pri_hover,
		'--color-secondary'       => $secondary,
		'--color-secondary-hover' => $sec_hover,
		'--color-accent'          => $secondary,
		'--color-accent-hover'    => $sec_hover,
		'--color-gold'             => $gold,
		'--color-gold-dark'        => $gold_dark,
		'--color-gold-light'       => $gold_light,
		'--color-gold-rgb'         => bearlane_hex_to_rgb_triplet( $gold ),
		'--color-dark-bg'          => $primary,
		'--color-dark-surface'     => $pri_hover,
		'--color-footer-bg'        => $footer_bg,
		'--color-footer-bg-accent' => $footer_bg_accent,
		'--color-footer-text'      => $footer_text,
		'--color-footer-text-rgb'  => bearlane_hex_to_rgb_triplet( $footer_text ),
		'--color-footer-accent'    => $footer_accent,
		'--color-footer-accent-rgb' => bearlane_hex_to_rgb_triplet( $footer_accent ),
		'--color-heading'         => get_theme_mod( 'bearlane_heading_color',   '#1B2D42' ),
		'--color-text'            => get_theme_mod( 'bearlane_text_primary',    '#1B2D42' ),
		'--color-text-muted'      => get_theme_mod( 'bearlane_text_secondary',  '#5e6a75' ),
		'--color-bg'              => get_theme_mod( 'bearlane_bg_color',        '#F2F4F5' ),
		'--color-surface'         => get_theme_mod( 'bearlane_surface_color',   '#ffffff' ),
		'--color-surface-2'       => $surface_2,
		'--color-border'          => get_theme_mod( 'bearlane_border_color',    '#d5dde2' ),
		'--font-size-base'        => get_theme_mod( 'bearlane_font_size_base',  '16' ) . 'px',
	];

	// Header navigation tokens — always output with brand-aware defaults
	// so they never depend on var(--color-text) resolution (which may be
	// overridden by stale theme_mods or Elementor global styles).
	$header_tokens = [
		'--header-nav-text'              => [ 'bearlane_header_nav_text',          $primary ],
		'--header-nav-bg'                => [ 'bearlane_header_nav_bg',            'transparent' ],
		'--header-nav-border'            => [ 'bearlane_header_nav_border',        'transparent' ],
		'--header-nav-hover-text'        => [ 'bearlane_header_nav_hover_text',    $secondary ],
		'--header-nav-hover-bg'          => [ 'bearlane_header_nav_hover_bg',      $surface_2 ],
		'--header-nav-hover-border'      => [ 'bearlane_header_nav_hover_border',  'transparent' ],
		'--header-nav-active-text'       => [ 'bearlane_header_nav_active_text',   $secondary ],
		'--header-nav-active-bg'         => [ 'bearlane_header_nav_active_bg',     $surface_2 ],
		'--header-nav-active-border'     => [ 'bearlane_header_nav_active_border', 'transparent' ],
		'--header-action-text'           => [ 'bearlane_header_action_text',          $primary ],
		'--header-action-bg'             => [ 'bearlane_header_action_bg',            'transparent' ],
		'--header-action-border'         => [ 'bearlane_header_action_border',        'transparent' ],
		'--header-action-hover-text'     => [ 'bearlane_header_action_hover_text',    $secondary ],
		'--header-action-hover-bg'       => [ 'bearlane_header_action_hover_bg',      $surface_2 ],
		'--header-action-hover-border'   => [ 'bearlane_header_action_hover_border',  'transparent' ],
		'--header-action-active-text'    => [ 'bearlane_header_action_active_text',   $secondary ],
		'--header-action-active-bg'      => [ 'bearlane_header_action_active_bg',     $surface_2 ],
		'--header-action-active-border'  => [ 'bearlane_header_action_active_border', 'transparent' ],
		'--header-cta-text'              => [ 'bearlane_header_cta_text',          '#ffffff' ],
		'--header-cta-bg'                => [ 'bearlane_header_cta_bg',            $secondary ],
		'--header-cta-border'            => [ 'bearlane_header_cta_border',        $secondary ],
		'--header-cta-hover-text'        => [ 'bearlane_header_cta_hover_text',    '#ffffff' ],
		'--header-cta-hover-bg'          => [ 'bearlane_header_cta_hover_bg',      $sec_hover ],
		'--header-cta-hover-border'      => [ 'bearlane_header_cta_hover_border',  $sec_hover ],
		'--mobile-nav-text'              => [ 'bearlane_mobile_nav_text',          $primary ],
		'--mobile-nav-bg'                => [ 'bearlane_mobile_nav_bg',            'transparent' ],
		'--mobile-nav-border'            => [ 'bearlane_mobile_nav_border',        'transparent' ],
		'--mobile-nav-hover-text'        => [ 'bearlane_mobile_nav_hover_text',    $secondary ],
		'--mobile-nav-hover-bg'          => [ 'bearlane_mobile_nav_hover_bg',      $surface_2 ],
		'--mobile-nav-hover-border'      => [ 'bearlane_mobile_nav_hover_border',  'transparent' ],
		'--mobile-nav-active-text'       => [ 'bearlane_mobile_nav_active_text',   $secondary ],
		'--mobile-nav-active-bg'         => [ 'bearlane_mobile_nav_active_bg',     $surface_2 ],
		'--mobile-nav-active-border'     => [ 'bearlane_mobile_nav_active_border', 'transparent' ],
	];

	foreach ( $header_tokens as $css_prop => [ $mod_id, $default ] ) {
		$value = get_theme_mod( $mod_id, '' );
		$vars[ $css_prop ] = $value ? $value : $default;
	}

	$props = '';
	foreach ( $vars as $prop => $value ) {
		$safe_prop  = sanitize_text_field( $prop );
		$safe_value = sanitize_text_field( $value );
		if ( '' !== $safe_value ) {
			$props .= $safe_prop . ':' . $safe_value . ';';
		}
	}

	return ':root{' . $props . '}';
}

/**
 * Flush the CSS cache when Customizer settings are saved.
 */
add_action( 'customize_save_after', fn() => delete_transient( 'bearlane_customizer_css' ) );
