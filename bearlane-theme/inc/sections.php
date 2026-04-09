<?php
/**
 * BearLane Design — Homepage Sections Registry
 *
 * Central, UI-driven registry for all homepage sections. Every section
 * declares its metadata (id, label, icon, default enable, default order)
 * and a schema of editable fields. Values are persisted in a single
 * WordPress option (`bearlane_sections`) so non-technical users can fully
 * manage the homepage from wp-admin — no template edits required.
 *
 * This file contains ONLY the foundation (registry + getter API +
 * sanitization). Defaults/content for each section live in:
 *   /inc/section-defaults/*.php
 *
 * The admin UI that reads this schema lives in /inc/admin-sections.php.
 * The front-end renderer lives in front-page.php + the template parts.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Option key under which all homepage section data is stored.
 *
 * Shape:
 *   [
 *     'order'    => [ 'hero', 'best_sellers', ... ],
 *     'enabled'  => [ 'hero' => true, ... ],
 *     'content'  => [ 'hero' => [ 'heading' => '...', ... ], ... ],
 *   ]
 */
const BEARLANE_SECTIONS_OPTION = 'bearlane_sections';

/**
 * Supported field types for section schemas. The admin UI knows how
 * to render each of these and the sanitiser knows how to clean them.
 */
const BEARLANE_FIELD_TYPES = [
	'text',       // single-line text
	'textarea',   // multi-line text (plain)
	'richtext',   // multi-line text (wp_kses_post allowed)
	'url',        // URL
	'number',     // integer
	'image',      // attachment ID
	'select',     // single choice from options
	'checkbox',   // boolean
	'color',      // hex colour
	'svg',        // inline SVG markup
	'repeater',   // array of rows with sub-fields
	'product_ids',// csv/array of WC product IDs
	'category_ids', // csv/array of WC product_cat term IDs
];

/* =============================================================
 * REGISTRY
 * ============================================================= */

/**
 * Register / retrieve the full section registry.
 *
 * Each section entry is the merged result of its default schema
 * (from /inc/section-defaults/*.php) plus any filters applied via
 * `bearlane_section_schema_{id}` or `bearlane_sections_registry`.
 *
 * @return array<string,array> Map of section_id => schema
 */
function bearlane_sections_registry(): array {
	static $cache = null;

	if ( null !== $cache ) {
		return $cache;
	}

	$registry = [];

	/**
	 * Section definitions are loaded from individual files for
	 * maintainability — one file per section.
	 */
	$definitions_dir = BEARLANE_DIR . '/inc/section-defaults';

	$definition_files = [
		'hero.php',
		'best-sellers.php',
		'how-it-works.php',
		'categories.php',
		'featured-products.php',
		'embroidery-showcase.php',
		'usp.php',
		'testimonials.php',
		'bulk-order.php',
		'faq.php',
		'email-capture.php',
	];

	foreach ( $definition_files as $file ) {
		$path = $definitions_dir . '/' . $file;
		if ( ! file_exists( $path ) ) {
			continue;
		}
		$definition = require $path;
		if ( ! is_array( $definition ) || empty( $definition['id'] ) ) {
			continue;
		}

		/**
		 * Filter an individual section's schema before it enters the registry.
		 *
		 * @param array  $definition Section schema.
		 */
		$definition = apply_filters( "bearlane_section_schema_{$definition['id']}", $definition );

		$registry[ $definition['id'] ] = $definition;
	}

	/**
	 * Filter the full registry so third parties can add / remove sections.
	 *
	 * @param array $registry
	 */
	$registry = apply_filters( 'bearlane_sections_registry', $registry );

	$cache = $registry;
	return $cache;
}

/**
 * Return the list of section IDs in their default order (as declared
 * by the registry's `priority` field).
 *
 * @return string[]
 */
function bearlane_sections_default_order(): array {
	$registry = bearlane_sections_registry();
	uasort( $registry, static function ( $a, $b ) {
		return (int) ( $a['priority'] ?? 100 ) <=> (int) ( $b['priority'] ?? 100 );
	} );
	return array_keys( $registry );
}

/**
 * Return the default content payload for a single section (the
 * `defaults` value of every field in its schema).
 *
 * @param string $section_id
 * @return array
 */
function bearlane_section_default_content( string $section_id ): array {
	$registry = bearlane_sections_registry();
	if ( empty( $registry[ $section_id ] ) ) {
		return [];
	}

	$defaults = [];
	foreach ( (array) ( $registry[ $section_id ]['fields'] ?? [] ) as $field_id => $field ) {
		$defaults[ $field_id ] = $field['default'] ?? '';
	}
	return $defaults;
}

/* =============================================================
 * DATA LAYER — read
 * ============================================================= */

/**
 * Return the entire persisted section data, falling back to defaults
 * for anything missing.
 *
 * @return array{order:string[],enabled:array<string,bool>,content:array<string,array>}
 */
function bearlane_sections_data(): array {
	$saved = get_option( BEARLANE_SECTIONS_OPTION, [] );
	if ( ! is_array( $saved ) ) {
		$saved = [];
	}

	$registry      = bearlane_sections_registry();
	$default_order = bearlane_sections_default_order();

	// --- order: saved order first, then any new sections appended.
	$saved_order = isset( $saved['order'] ) && is_array( $saved['order'] ) ? $saved['order'] : [];
	$saved_order = array_values( array_filter( $saved_order, static fn( $id ) => isset( $registry[ $id ] ) ) );
	foreach ( $default_order as $id ) {
		if ( ! in_array( $id, $saved_order, true ) ) {
			$saved_order[] = $id;
		}
	}

	// --- enabled: missing = default from registry.
	$enabled = [];
	foreach ( $saved_order as $id ) {
		if ( isset( $saved['enabled'][ $id ] ) ) {
			$enabled[ $id ] = (bool) $saved['enabled'][ $id ];
		} else {
			$enabled[ $id ] = ! empty( $registry[ $id ]['default_enabled'] );
		}
	}

	// --- content: merge saved over defaults per field.
	$content = [];
	foreach ( $saved_order as $id ) {
		$defaults              = bearlane_section_default_content( $id );
		$saved_section         = isset( $saved['content'][ $id ] ) && is_array( $saved['content'][ $id ] ) ? $saved['content'][ $id ] : [];
		$content[ $id ]        = array_replace_recursive( $defaults, $saved_section );
	}

	return [
		'order'   => $saved_order,
		'enabled' => $enabled,
		'content' => $content,
	];
}

/**
 * Get a single field value for a section (merged with defaults).
 *
 * @param string $section_id
 * @param string $field_id
 * @param mixed  $fallback
 * @return mixed
 */
function bearlane_section_field( string $section_id, string $field_id, $fallback = '' ) {
	$data = bearlane_sections_data();
	if ( ! isset( $data['content'][ $section_id ] ) ) {
		return $fallback;
	}
	$value = $data['content'][ $section_id ][ $field_id ] ?? $fallback;
	return '' === $value && $fallback !== '' ? $fallback : $value;
}

/**
 * Get all fields for a section as an array, already merged with
 * defaults. Use inside template parts.
 *
 * @param string $section_id
 * @return array
 */
function bearlane_section_content( string $section_id ): array {
	$data = bearlane_sections_data();
	return $data['content'][ $section_id ] ?? bearlane_section_default_content( $section_id );
}

/**
 * Whether the given section is enabled (visible on the homepage).
 *
 * @param string $section_id
 * @return bool
 */
function bearlane_section_is_enabled( string $section_id ): bool {
	$data = bearlane_sections_data();
	return ! empty( $data['enabled'][ $section_id ] );
}

/**
 * Return the ordered list of enabled section IDs — used by the
 * front-page renderer.
 *
 * @return string[]
 */
function bearlane_sections_active_ids(): array {
	$data = bearlane_sections_data();
	return array_values( array_filter( $data['order'], static fn( $id ) => ! empty( $data['enabled'][ $id ] ) ) );
}

/* =============================================================
 * DATA LAYER — write / sanitize
 * ============================================================= */

/**
 * Sanitize a value against a field schema.
 *
 * @param array $field Field schema.
 * @param mixed $value Raw input.
 * @return mixed Cleaned value.
 */
function bearlane_sanitize_field( array $field, $value ) {
	$type = $field['type'] ?? 'text';

	switch ( $type ) {
		case 'text':
			return sanitize_text_field( (string) $value );

		case 'textarea':
			return sanitize_textarea_field( (string) $value );

		case 'richtext':
			return wp_kses_post( (string) $value );

		case 'url':
			return esc_url_raw( (string) $value );

		case 'number':
			return (int) $value;

		case 'image':
			return (int) $value;

		case 'select':
			$allowed = array_keys( (array) ( $field['options'] ?? [] ) );
			return in_array( (string) $value, $allowed, true ) ? (string) $value : ( $field['default'] ?? '' );

		case 'checkbox':
			return (bool) $value;

		case 'color':
			$color = sanitize_hex_color( (string) $value );
			return $color ?: ( $field['default'] ?? '' );

		case 'svg':
			return bearlane_sanitize_inline_svg( (string) $value );

		case 'product_ids':
		case 'category_ids':
			if ( is_string( $value ) ) {
				$value = preg_split( '/[\s,]+/', $value, -1, PREG_SPLIT_NO_EMPTY );
			}
			if ( ! is_array( $value ) ) {
				return [];
			}
			return array_values( array_unique( array_map( 'absint', $value ) ) );

		case 'repeater':
			if ( ! is_array( $value ) ) {
				return [];
			}
			$sub_fields = (array) ( $field['sub_fields'] ?? [] );
			$clean      = [];
			foreach ( $value as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$row_clean = [];
				foreach ( $sub_fields as $sub_id => $sub_field ) {
					$row_clean[ $sub_id ] = bearlane_sanitize_field( $sub_field, $row[ $sub_id ] ?? ( $sub_field['default'] ?? '' ) );
				}
				$clean[] = $row_clean;
			}
			return $clean;

		default:
			return sanitize_text_field( (string) $value );
	}
}

/**
 * Allow a constrained set of inline SVG markup for icon fields.
 *
 * @param string $svg
 * @return string
 */
function bearlane_sanitize_inline_svg( string $svg ): string {
	$allowed = [
		'svg'      => [ 'xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'aria-hidden' => true, 'class' => true ],
		'g'        => [ 'fill' => true, 'stroke' => true ],
		'path'     => [ 'd' => true, 'fill' => true, 'stroke' => true ],
		'circle'   => [ 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true ],
		'rect'     => [ 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true ],
		'line'     => [ 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ],
		'polyline' => [ 'points' => true ],
		'polygon'  => [ 'points' => true ],
	];
	return wp_kses( $svg, $allowed );
}

/**
 * Sanitize the full option payload coming from the admin form.
 *
 * @param array $raw Raw $_POST['bearlane_sections'] data.
 * @return array
 */
function bearlane_sanitize_sections_option( $raw ): array {
	if ( ! is_array( $raw ) ) {
		return [];
	}

	$registry = bearlane_sections_registry();
	$clean    = [
		'order'   => [],
		'enabled' => [],
		'content' => [],
	];

	// Order.
	$order = isset( $raw['order'] ) && is_array( $raw['order'] ) ? $raw['order'] : [];
	foreach ( $order as $id ) {
		$id = sanitize_key( (string) $id );
		if ( isset( $registry[ $id ] ) && ! in_array( $id, $clean['order'], true ) ) {
			$clean['order'][] = $id;
		}
	}
	// Append any registry section missing from order.
	foreach ( array_keys( $registry ) as $id ) {
		if ( ! in_array( $id, $clean['order'], true ) ) {
			$clean['order'][] = $id;
		}
	}

	// Enabled.
	foreach ( $clean['order'] as $id ) {
		$clean['enabled'][ $id ] = ! empty( $raw['enabled'][ $id ] );
	}

	// Content — per section, per field.
	foreach ( $clean['order'] as $id ) {
		$schema_fields = (array) ( $registry[ $id ]['fields'] ?? [] );
		$raw_content   = isset( $raw['content'][ $id ] ) && is_array( $raw['content'][ $id ] ) ? $raw['content'][ $id ] : [];
		$clean_section = [];

		foreach ( $schema_fields as $field_id => $field ) {
			$raw_value                 = $raw_content[ $field_id ] ?? ( $field['default'] ?? '' );
			$clean_section[ $field_id ] = bearlane_sanitize_field( $field, $raw_value );
		}

		$clean['content'][ $id ] = $clean_section;
	}

	return $clean;
}

/* =============================================================
 * RENDERER
 * ============================================================= */

/**
 * Render a single section by ID.
 *
 * Each section schema declares its own `template` (a path relative
 * to the theme directory). The template file reads its content via
 * bearlane_section_content(); this dispatcher just loads it.
 *
 * Third parties can swap / extend output with:
 *   - filter `bearlane_section_template_{id}` — replace the template path
 *   - action `bearlane_before_section_{id}`    — echo before the template
 *   - action `bearlane_after_section_{id}`     — echo after the template
 *   - filter `bearlane_section_skip_{id}`      — return true to skip
 *
 * @param string $section_id Section ID.
 */
function bearlane_render_section( string $section_id ): void {
	$registry = bearlane_sections_registry();
	if ( empty( $registry[ $section_id ] ) ) {
		return;
	}

	if ( apply_filters( "bearlane_section_skip_{$section_id}", false ) ) {
		return;
	}

	$template = $registry[ $section_id ]['template'] ?? '';
	$template = apply_filters( "bearlane_section_template_{$section_id}", $template );
	if ( ! $template ) {
		return;
	}

	$full_path = BEARLANE_DIR . '/' . ltrim( $template, '/' );
	if ( ! file_exists( $full_path ) ) {
		return;
	}

	/**
	 * Expose the section ID to the template via a global so
	 * template parts can call bearlane_section_content() without
	 * needing to know their own ID.
	 */
	$GLOBALS['bearlane_current_section_id'] = $section_id;

	do_action( "bearlane_before_section_{$section_id}" );
	include $full_path;
	do_action( "bearlane_after_section_{$section_id}" );

	unset( $GLOBALS['bearlane_current_section_id'] );
}

/**
 * Helper template parts use this to grab their own content array
 * without hardcoding the section ID.
 *
 * @param string $fallback_id Used when called outside the section loop.
 * @return array
 */
function bearlane_current_section_content( string $fallback_id = '' ): array {
	$id = $GLOBALS['bearlane_current_section_id'] ?? $fallback_id;
	if ( ! $id ) {
		return [];
	}
	return bearlane_section_content( $id );
}

/* =============================================================
 * MIGRATION
 * ============================================================= */

/**
 * One-time migration — if the option doesn't exist yet, seed it with
 * the registry defaults so the homepage renders identically to the
 * previous hardcoded version. Zero content loss.
 */
function bearlane_sections_maybe_seed(): void {
	if ( false !== get_option( BEARLANE_SECTIONS_OPTION, false ) ) {
		return;
	}

	$registry = bearlane_sections_registry();
	$seed     = [
		'order'   => bearlane_sections_default_order(),
		'enabled' => [],
		'content' => [],
	];

	foreach ( $seed['order'] as $id ) {
		$seed['enabled'][ $id ] = ! empty( $registry[ $id ]['default_enabled'] );
		$seed['content'][ $id ] = bearlane_section_default_content( $id );
	}

	// Carry over legacy Customizer hero values if they exist.
	$legacy_hero_image = get_theme_mod( 'bearlane_hero_image', 0 );
	if ( $legacy_hero_image ) {
		$seed['content']['hero']['background_image'] = (int) $legacy_hero_image;
	}
	$legacy_hero_heading = get_theme_mod( 'bearlane_hero_heading', '' );
	if ( $legacy_hero_heading ) {
		$seed['content']['hero']['heading'] = wp_kses_post( $legacy_hero_heading );
	}
	$legacy_hero_sub = get_theme_mod( 'bearlane_hero_subheading', '' );
	if ( $legacy_hero_sub ) {
		$seed['content']['hero']['subheading'] = wp_kses_post( $legacy_hero_sub );
	}
	$legacy_hero_cta_label = get_theme_mod( 'bearlane_hero_cta_label', '' );
	if ( $legacy_hero_cta_label ) {
		$seed['content']['hero']['cta_primary_label'] = sanitize_text_field( $legacy_hero_cta_label );
	}
	$legacy_hero_cta_url = get_theme_mod( 'bearlane_hero_cta_url', '' );
	if ( $legacy_hero_cta_url ) {
		$seed['content']['hero']['cta_primary_url'] = esc_url_raw( $legacy_hero_cta_url );
	}
	$legacy_showcase_image = get_theme_mod( 'bearlane_showcase_image', 0 );
	if ( $legacy_showcase_image ) {
		$seed['content']['embroidery_showcase']['image'] = (int) $legacy_showcase_image;
	}

	update_option( BEARLANE_SECTIONS_OPTION, $seed, false );
}
add_action( 'after_setup_theme', 'bearlane_sections_maybe_seed', 20 );
