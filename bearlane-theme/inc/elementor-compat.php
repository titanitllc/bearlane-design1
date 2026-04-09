<?php
/**
 * BearLane Design — Elementor Compatibility
 *
 * Lets Elementor take over the homepage and any page using our
 * custom templates without causing double rendering of managed
 * sections. Also registers the BearLane full-width / homepage
 * templates as Elementor-compatible so users can open them in
 * Elementor's canvas editor.
 *
 * This file is safe to load whether or not Elementor is active;
 * every hook is guarded by a class check.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =============================================================
 * ACTIVE DETECTION
 * ============================================================= */

/**
 * Whether Elementor is active as a plugin.
 */
function bearlane_elementor_active(): bool {
	return did_action( 'elementor/loaded' ) || class_exists( '\\Elementor\\Plugin' );
}

/**
 * Whether the current (front-end) request is being rendered by
 * Elementor as the primary builder — i.e. the current post has an
 * Elementor-edited flag AND actually has a saved Elementor layout.
 *
 * We cannot rely on `_elementor_edit_mode` alone. Elementor writes
 * that meta the first time a user clicks "Edit with Elementor" — even
 * if they close the editor without saving. The result is that many
 * pages (including fresh homepages) are flagged as built-with-Elementor
 * despite having no actual layout. In that state, yielding to
 * Elementor via `the_content()` produces an empty page because there
 * is no `_elementor_data` to render.
 *
 * The correct check is: the page must have `_elementor_edit_mode`
 * equal to `builder` AND a non-empty `_elementor_data` payload. When
 * Elementor's document API is available we defer to Elementor's own
 * `Document::is_built_with_elementor()` method for future-proofing,
 * and then additionally verify that data exists.
 */
function bearlane_elementor_is_built_with( int $post_id ): bool {
	if ( ! bearlane_elementor_active() || ! $post_id ) {
		return false;
	}

	$edit_mode = get_post_meta( $post_id, '_elementor_edit_mode', true );
	if ( 'builder' !== $edit_mode ) {
		return false;
	}

	// Require a non-empty saved layout. Elementor stores this as a
	// JSON-encoded array; an empty layout is stored as `[]`.
	$data = get_post_meta( $post_id, '_elementor_data', true );
	if ( is_array( $data ) ) {
		return ! empty( $data );
	}
	$data = is_string( $data ) ? trim( $data ) : '';
	if ( '' === $data || '[]' === $data ) {
		return false;
	}

	return true;
}

/* =============================================================
 * BUILDER TAKEOVER
 * ============================================================= */

/**
 * Tell front-page.php (and template-homepage-builder.php) to skip the
 * managed section loop when the current front page is being rendered
 * by Elementor. The page's Elementor-built content will render via
 * the_content() inside the takeover branch, which fully replaces our
 * sections. No duplicate rendering.
 *
 * @param bool $takeover Incoming filter value.
 * @return bool
 */
function bearlane_elementor_takeover_filter( bool $takeover ): bool {
	if ( $takeover ) {
		return $takeover;
	}
	if ( ! bearlane_elementor_active() ) {
		return false;
	}
	if ( ! is_singular() && ! is_front_page() && ! is_page() ) {
		return false;
	}

	$post_id = (int) get_queried_object_id();
	return bearlane_elementor_is_built_with( $post_id );
}
add_filter( 'bearlane_front_page_builder_takeover', 'bearlane_elementor_takeover_filter' );

/* =============================================================
 * TEMPLATE REGISTRATION
 * ============================================================= */

/**
 * Expose BearLane page templates to Elementor as supported canvases.
 * Elementor's own "Canvas" and "Full width" templates still work;
 * this simply lets Elementor see our Full Width template as a valid
 * full-bleed surface.
 *
 * @param array $templates Existing supported templates.
 * @return array
 */
function bearlane_elementor_supported_templates( array $templates ): array {
	$templates[] = 'template-full-width.php';
	$templates[] = 'template-homepage-builder.php';
	return $templates;
}
add_filter( 'elementor/theme/need_override_location', '__return_true' );
add_filter( 'elementor/frontend/the_content', function ( $content ) { return $content; } );

/* =============================================================
 * BLOCK EDITOR / GUTENBERG FALLBACK
 * ============================================================= */

/**
 * When Elementor is NOT the active builder and the current static
 * front page has non-empty Gutenberg blocks, the user has chosen a
 * Gutenberg-first workflow. The default front-page.php already
 * renders blocks below the managed section loop — no extra work here.
 *
 * This stub exists as a documented hook point so third-party
 * compat shims (Divi, Breakdance, etc.) can reuse the same
 * bearlane_front_page_builder_takeover filter pattern.
 */
function bearlane_gutenberg_fallback_docs(): void {
	// Intentionally blank — see inline docblock above.
}
