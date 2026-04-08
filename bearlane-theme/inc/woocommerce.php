<?php
/**
 * BearLane Design — WooCommerce Integration
 *
 * Removes / replaces default WooCommerce markup to match the theme's design
 * system, adds AJAX filtering, quick-view, mini-cart, and other UX enhancements.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// ---------------------------------------------------------------------------
// Layout / Wrappers
// ---------------------------------------------------------------------------

/**
 * Remove default WooCommerce wrappers and replace with our own.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'bearlane_woo_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content',  'bearlane_woo_wrapper_end',   10 );

function bearlane_woo_wrapper_start(): void {
	echo '<main id="site-content" class="woo-content">';
}

function bearlane_woo_wrapper_end(): void {
	echo '</main>';
}

// ---------------------------------------------------------------------------
// Sidebar
// ---------------------------------------------------------------------------

/**
 * Remove the default WC sidebar and let our archive template handle it.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// ---------------------------------------------------------------------------
// Product loop adjustments
// ---------------------------------------------------------------------------

/**
 * Default to 3 columns on archive pages.
 */
add_filter( 'loop_shop_columns', fn() => 3 );

/**
 * Reorder loop actions: image → title → rating → price → add-to-cart.
 */
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action( 'woocommerce_shop_loop_item_title',      'bearlane_loop_product_title',  10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'bearlane_loop_product_rating', 5 );

function bearlane_loop_product_title(): void {
	echo '<h2 class="product-card__title">' . esc_html( get_the_title() ) . '</h2>';
}

function bearlane_loop_product_rating(): void {
	global $product;
	if ( $product instanceof \WC_Product ) {
		echo bearlane_star_rating( $product ); // phpcs:ignore
	}
}

/**
 * Add quick-view button to the product loop.
 */
add_action( 'woocommerce_after_shop_loop_item', 'bearlane_quick_view_button', 15 );

function bearlane_quick_view_button(): void {
	global $product;
	if ( ! $product instanceof \WC_Product ) {
		return;
	}
	printf(
		'<button class="btn btn--ghost quick-view-trigger" data-product-id="%d" aria-label="%s">%s</button>',
		(int) $product->get_id(),
		esc_attr__( 'Quick view', 'bearlane' ),
		esc_html__( 'Quick View', 'bearlane' )
	);
}

// ---------------------------------------------------------------------------
// AJAX — Quick View
// ---------------------------------------------------------------------------

add_action( 'wp_ajax_bearlane_quick_view',        'bearlane_ajax_quick_view' );
add_action( 'wp_ajax_nopriv_bearlane_quick_view', 'bearlane_ajax_quick_view' );

function bearlane_ajax_quick_view(): void {
	check_ajax_referer( 'bearlane_nonce', 'nonce' );

	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$product    = wc_get_product( $product_id );

	if ( ! $product ) {
		wp_send_json_error( [ 'message' => __( 'Product not found.', 'bearlane' ) ], 404 );
	}

	ob_start();
	?>
	<div class="quick-view__inner">
		<div class="quick-view__image">
			<?php echo $product->get_image( 'woocommerce_single' ); // phpcs:ignore ?>
		</div>
		<div class="quick-view__details">
			<h2 class="quick-view__title"><?php echo esc_html( $product->get_name() ); ?></h2>
			<div class="quick-view__price"><?php echo $product->get_price_html(); // phpcs:ignore ?></div>
			<?php echo bearlane_star_rating( $product ); // phpcs:ignore ?>
			<div class="quick-view__description"><?php echo wp_kses_post( $product->get_short_description() ); ?></div>
			<?php woocommerce_template_single_add_to_cart(); ?>
			<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="btn btn--link quick-view__full-link">
				<?php esc_html_e( 'View full details', 'bearlane' ); ?>
			</a>
		</div>
	</div>
	<?php
	wp_send_json_success( [ 'html' => ob_get_clean() ] );
}

// ---------------------------------------------------------------------------
// AJAX — Mini Cart Fragment
// ---------------------------------------------------------------------------

add_filter( 'woocommerce_add_to_cart_fragments', 'bearlane_cart_fragment' );

function bearlane_cart_fragment( array $fragments ): array {
	ob_start();
	?>
	<span class="cart-count" aria-live="polite">
		<?php echo WC()->cart->get_cart_contents_count(); ?>
	</span>
	<?php
	$fragments['.cart-count'] = ob_get_clean();
	return $fragments;
}

// ---------------------------------------------------------------------------
// AJAX — Product Filtering
// ---------------------------------------------------------------------------

add_action( 'wp_ajax_bearlane_filter_products',        'bearlane_ajax_filter_products' );
add_action( 'wp_ajax_nopriv_bearlane_filter_products', 'bearlane_ajax_filter_products' );

function bearlane_ajax_filter_products(): void {
	check_ajax_referer( 'bearlane_nonce', 'nonce' );

	$args = [
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'paged'          => max( 1, absint( $_POST['page'] ?? 1 ) ),
		'tax_query'      => [ 'relation' => 'AND' ], // phpcs:ignore WordPress.DB.SlowDBQuery
		'meta_query'     => [], // phpcs:ignore WordPress.DB.SlowDBQuery
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	];

	// Category filter.
	if ( ! empty( $_POST['category'] ) ) {
		$args['tax_query'][] = [
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array_map( 'sanitize_text_field', (array) $_POST['category'] ),
		];
	}

	// Orderby filter.
	$orderby = sanitize_text_field( $_POST['orderby'] ?? '' );
	switch ( $orderby ) {
		case 'price':
			$args['meta_key'] = '_price'; // phpcs:ignore WordPress.DB.SlowDBQuery
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'ASC';
			break;
		case 'price-desc':
			$args['meta_key'] = '_price'; // phpcs:ignore WordPress.DB.SlowDBQuery
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'rating':
			$args['meta_key'] = '_wc_average_rating'; // phpcs:ignore WordPress.DB.SlowDBQuery
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'date':
			$args['orderby'] = 'date';
			$args['order']   = 'DESC';
			break;
	}

	// Price range filter.
	$min_price = isset( $_POST['min_price'] ) ? floatval( $_POST['min_price'] ) : null;
	$max_price = isset( $_POST['max_price'] ) ? floatval( $_POST['max_price'] ) : null;
	if ( null !== $min_price || null !== $max_price ) {
		$price_meta = [ 'key' => '_price', 'type' => 'NUMERIC' ];
		if ( null !== $min_price ) {
			$price_meta['value']   = $min_price;
			$price_meta['compare'] = '>=';
		}
		if ( null !== $max_price ) {
			$price_meta = [ 'relation' => 'AND',
				[ 'key' => '_price', 'value' => $min_price ?? 0, 'type' => 'NUMERIC', 'compare' => '>=' ],
				[ 'key' => '_price', 'value' => $max_price, 'type' => 'NUMERIC', 'compare' => '<=' ],
			];
		}
		$args['meta_query'][] = $price_meta;
	}

	$query = new WP_Query( $args );
	ob_start();

	if ( $query->have_posts() ) {
		woocommerce_product_loop_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		woocommerce_product_loop_end();
	} else {
		echo '<p class="no-products">' . esc_html__( 'No products found.', 'bearlane' ) . '</p>';
	}

	wp_reset_postdata();

	wp_send_json_success( [
		'html'       => ob_get_clean(),
		'found'      => $query->found_posts,
		'max_pages'  => $query->max_num_pages,
	] );
}

// ---------------------------------------------------------------------------
// Checkout UX
// ---------------------------------------------------------------------------

/**
 * Remove coupon field from checkout (keep it on cart).
 */
add_filter( 'woocommerce_checkout_coupon_message', '__return_false' );

/**
 * Optimise checkout field order for better UX.
 */
add_filter( 'woocommerce_checkout_fields', 'bearlane_checkout_fields' );

function bearlane_checkout_fields( array $fields ): array {
	// Move company field after last name.
	if ( isset( $fields['billing']['billing_company'] ) ) {
		$fields['billing']['billing_company']['priority'] = 35;
	}
	return $fields;
}

// ---------------------------------------------------------------------------
// My Account
// ---------------------------------------------------------------------------

/**
 * Customise the My Account navigation endpoints.
 */
add_filter( 'woocommerce_account_menu_items', 'bearlane_account_menu_items' );

function bearlane_account_menu_items( array $items ): array {
	$items['dashboard']       = __( 'Overview', 'bearlane' );
	$items['orders']          = __( 'My Orders', 'bearlane' );
	$items['edit-address']    = __( 'Addresses', 'bearlane' );
	$items['edit-account']    = __( 'Account Details', 'bearlane' );
	$items['customer-logout'] = __( 'Log Out', 'bearlane' );
	return $items;
}

// ---------------------------------------------------------------------------
// Product Schema (structured data)
// ---------------------------------------------------------------------------

add_action( 'woocommerce_single_product_summary', 'bearlane_product_schema', 1 );

function bearlane_product_schema(): void {
	global $product;
	if ( ! $product instanceof \WC_Product ) {
		return;
	}

	$schema = [
		'@context' => 'https://schema.org/',
		'@type'    => 'Product',
		'name'     => $product->get_name(),
		'image'    => wp_get_attachment_image_url( $product->get_image_id(), 'full' ),
		'sku'      => $product->get_sku(),
		'offers'   => [
			'@type'         => 'Offer',
			'url'           => get_permalink(),
			'priceCurrency' => get_woocommerce_currency(),
			'price'         => $product->get_price(),
			'availability'  => $product->is_in_stock()
				? 'https://schema.org/InStock'
				: 'https://schema.org/OutOfStock',
		],
	];

	if ( $product->get_rating_count() ) {
		$schema['aggregateRating'] = [
			'@type'       => 'AggregateRating',
			'ratingValue' => $product->get_average_rating(),
			'reviewCount' => $product->get_rating_count(),
		];
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
