<?php
/**
 * BearLane Design — Asset Enqueuing
 *
 * Enqueues styles and scripts following WordPress best practices.
 * All assets are versioned to allow easy cache-busting.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end styles.
 */
function bearlane_enqueue_styles(): void {

	// Main theme stylesheet.
	wp_enqueue_style(
		'bearlane-main',
		BEARLANE_URI . '/assets/css/main.css',
		[],
		BEARLANE_VERSION
	);

	// WooCommerce-specific overrides (only when WooCommerce is active).
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'bearlane-woocommerce',
			BEARLANE_URI . '/assets/css/woocommerce.css',
			[ 'bearlane-main', 'woocommerce-general' ],
			BEARLANE_VERSION
		);
	}

	// Google Fonts — Montserrat + Open Sans.
	wp_enqueue_style(
		'bearlane-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap',
		[],
		null // Google manages its own versioning.
	);
}
add_action( 'wp_enqueue_scripts', 'bearlane_enqueue_styles' );

/**
 * Enqueue front-end scripts.
 */
function bearlane_enqueue_scripts(): void {

	// Main theme JS (deferred — non-blocking).
	wp_enqueue_script(
		'bearlane-main',
		BEARLANE_URI . '/assets/js/main.js',
		[],
		BEARLANE_VERSION,
		[ 'strategy' => 'defer', 'in_footer' => true ]
	);

	// WooCommerce JS (depends on jQuery via WC).
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_script(
			'bearlane-woocommerce',
			BEARLANE_URI . '/assets/js/woocommerce.js',
			[ 'jquery', 'wc-add-to-cart' ],
			BEARLANE_VERSION,
			[ 'strategy' => 'defer', 'in_footer' => true ]
		);
	}

	// Comment reply script (only on singular posts with comments open).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Pass localised data to JS.
	wp_localize_script( 'bearlane-main', 'bearLane', [
		'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
		'nonce'     => wp_create_nonce( 'bearlane_nonce' ),
		'currency'  => get_woocommerce_currency_symbol(),
		'cartUrl'   => class_exists( 'WooCommerce' ) ? wc_get_cart_url() : '',
		'strings'   => [
			'addToCart'     => __( 'Add to Cart', 'bearlane' ),
			'addedToCart'   => __( 'Added!', 'bearlane' ),
			'quickView'     => __( 'Quick View', 'bearlane' ),
			'close'         => __( 'Close', 'bearlane' ),
			'loading'       => __( 'Loading…', 'bearlane' ),
		],
	] );
}
add_action( 'wp_enqueue_scripts', 'bearlane_enqueue_scripts' );

/**
 * Preload critical fonts to improve LCP.
 */
function bearlane_preload_fonts(): void {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'bearlane_preload_fonts', 1 );

/**
 * Remove the WooCommerce default stylesheet (we ship our own overrides).
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add defer / async attributes to non-critical scripts.
 */
function bearlane_script_attributes( string $tag, string $handle ): string {
	$defer_scripts = [ 'bearlane-main', 'bearlane-woocommerce' ];
	if ( in_array( $handle, $defer_scripts, true ) ) {
		return str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'bearlane_script_attributes', 10, 2 );
