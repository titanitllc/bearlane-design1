<?php
/**
 * BearLane Design — Helper Functions
 *
 * Reusable utility functions for templates and template-parts.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return or echo an SVG icon from /assets/images/icons/.
 *
 * @param string $name   Icon file name without extension.
 * @param bool   $echo   Echo or return.
 * @return string|void
 */
function bearlane_icon( string $name, bool $echo = true ) {
	$path = BEARLANE_DIR . '/assets/images/icons/' . sanitize_file_name( $name ) . '.svg';
	$svg  = file_exists( $path ) ? file_get_contents( $path ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( $echo ) {
		echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $svg;
	}
}

/**
 * Get the breadcrumb trail for the current page.
 * Uses WooCommerce's breadcrumb when available, else a simple fallback.
 *
 * @return void
 */
function bearlane_breadcrumbs(): void {
	if ( function_exists( 'woocommerce_breadcrumb' ) && ( is_woocommerce() || is_cart() || is_checkout() ) ) {
		woocommerce_breadcrumb( [
			'delimiter'   => '<span class="breadcrumb__sep" aria-hidden="true">/</span>',
			'wrap_before' => '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'bearlane' ) . '"><ol>',
			'wrap_after'  => '</ol></nav>',
			'before'      => '<li>',
			'after'       => '</li>',
			'home'        => _x( 'Home', 'breadcrumb', 'bearlane' ),
		] );
		return;
	}

	// Simple WordPress breadcrumb fallback.
	$crumbs = [ sprintf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/' ) ), __( 'Home', 'bearlane' ) ) ];

	if ( is_singular() ) {
		if ( $cat = get_the_category() ) {
			$crumbs[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( get_category_link( $cat[0]->term_id ) ), esc_html( $cat[0]->name ) );
		}
		$crumbs[] = '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';
	} elseif ( is_category() ) {
		$crumbs[] = '<li aria-current="page">' . esc_html( single_cat_title( '', false ) ) . '</li>';
	} elseif ( is_search() ) {
		$crumbs[] = '<li aria-current="page">' . sprintf( __( 'Search: %s', 'bearlane' ), esc_html( get_search_query() ) ) . '</li>';
	} elseif ( is_404() ) {
		$crumbs[] = '<li aria-current="page">' . __( '404 Not Found', 'bearlane' ) . '</li>';
	}

	echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'bearlane' ) . '"><ol>' . implode( '', $crumbs ) . '</ol></nav>';
}

/**
 * Return whether we are on any WooCommerce page.
 *
 * @return bool
 */
function bearlane_is_woo_page(): bool {
	return class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() );
}

/**
 * Return the formatted price for a product.
 *
 * @param \WC_Product $product
 * @return string
 */
function bearlane_product_price( \WC_Product $product ): string {
	if ( $product->is_on_sale() ) {
		return sprintf(
			'<span class="price__regular price__regular--sale">%s</span><span class="price__sale">%s</span>',
			wc_price( (float) $product->get_regular_price() ),
			wc_price( (float) $product->get_sale_price() )
		);
	}
	return '<span class="price__regular">' . $product->get_price_html() . '</span>';
}

/**
 * Get a WooCommerce product badge (sale / new / featured).
 *
 * @param \WC_Product $product
 * @return string HTML badge markup.
 */
function bearlane_product_badge( \WC_Product $product ): string {
	$badges = [];
	if ( $product->is_on_sale() ) {
		$badges[] = '<span class="badge badge--sale">' . esc_html__( 'Sale', 'bearlane' ) . '</span>';
	}
	if ( $product->is_featured() ) {
		$badges[] = '<span class="badge badge--featured">' . esc_html__( 'Featured', 'bearlane' ) . '</span>';
	}
	if ( ! $badges ) {
		return '';
	}
	return '<div class="badge-group">' . implode( '', $badges ) . '</div>';
}

/**
 * Return the star rating HTML for a product.
 *
 * @param \WC_Product $product
 * @return string
 */
function bearlane_star_rating( \WC_Product $product ): string {
	$rating = $product->get_average_rating();
	$count  = $product->get_rating_count();
	if ( ! $count ) {
		return '';
	}
	return sprintf(
		'<div class="star-rating" aria-label="%s">%s<span class="star-rating__count">(%d)</span></div>',
		esc_attr( sprintf( __( 'Rated %s out of 5', 'bearlane' ), $rating ) ),
		wc_get_rating_html( $rating, $count ),
		$count
	);
}

/**
 * Sanitise a CSS class string.
 *
 * @param string $classes Space-separated list of classes.
 * @return string
 */
function bearlane_classes( string $classes ): string {
	return implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $classes ) ) );
}

/**
 * Echo a template part with named args.
 *
 * Thin wrapper around get_template_part() that passes $args cleanly.
 *
 * @param string $slug Template slug.
 * @param string $name Optional template name.
 * @param array  $args Optional template args.
 */
function bearlane_part( string $slug, string $name = '', array $args = [] ): void {
	get_template_part( $slug, $name ?: null, $args );
}
