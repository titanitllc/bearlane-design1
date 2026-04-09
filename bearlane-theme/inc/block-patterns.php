<?php
/**
 * BearLane Design — Block Patterns
 *
 * Registers one Gutenberg block pattern per homepage section so users
 * can drop a section into ANY page (not just the homepage) and still
 * keep the BearLane look.
 *
 * Each pattern renders a [bearlane_section id="..."] shortcode, which
 * in turn calls bearlane_render_section(). That means:
 *   - patterns honour the user's content from Appearance → Homepage
 *     Sections (single source of truth, no duplication)
 *   - patterns work identically inside Gutenberg AND Elementor
 *     (Elementor's Shortcode widget will happily render them)
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the [bearlane_section] shortcode used by every pattern.
 */
function bearlane_section_shortcode( $atts ): string {
	$atts = shortcode_atts( [ 'id' => '' ], $atts, 'bearlane_section' );

	$id = sanitize_key( (string) $atts['id'] );
	if ( ! $id ) {
		return '';
	}

	ob_start();
	bearlane_render_section( $id );
	return (string) ob_get_clean();
}
add_shortcode( 'bearlane_section', 'bearlane_section_shortcode' );

/**
 * Register the BearLane pattern category + one pattern per section.
 */
function bearlane_register_block_patterns(): void {

	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	// Category.
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category( 'bearlane', [
			'label' => __( 'BearLane Sections', 'bearlane' ),
		] );
	}

	$registry = function_exists( 'bearlane_sections_registry' ) ? bearlane_sections_registry() : [];

	foreach ( $registry as $section_id => $schema ) {

		$label       = (string) ( $schema['label'] ?? $section_id );
		$description = (string) ( $schema['description'] ?? '' );

		// Build a shortcode block. Gutenberg renders this via its core
		// shortcode block, which in turn calls our shortcode handler
		// and outputs the full section HTML on the front end.
		$content = sprintf(
			'<!-- wp:shortcode -->[bearlane_section id="%s"]<!-- /wp:shortcode -->',
			esc_attr( $section_id )
		);

		register_block_pattern(
			'bearlane/section-' . str_replace( '_', '-', $section_id ),
			[
				'title'       => sprintf( /* translators: %s: section label */ __( 'BearLane — %s', 'bearlane' ), $label ),
				'description' => $description,
				'categories'  => [ 'bearlane' ],
				'keywords'    => [ 'bearlane', $section_id ],
				'content'     => $content,
			]
		);
	}
}
add_action( 'init', 'bearlane_register_block_patterns', 20 );
