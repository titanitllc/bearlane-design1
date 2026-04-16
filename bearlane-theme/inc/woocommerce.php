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
// Embroidery — Admin: per-product toggle
// ---------------------------------------------------------------------------

add_filter( 'woocommerce_product_data_tabs', 'bearlane_embroidery_product_tab' );

function bearlane_embroidery_product_tab( array $tabs ): array {
	$tabs['bearlane_embroidery'] = [
		'label'    => __( 'Embroidery', 'bearlane' ),
		'target'   => 'bearlane_embroidery_panel',
		'class'    => [ 'show_if_simple', 'show_if_variable' ],
		'priority' => 75,
	];
	return $tabs;
}

add_action( 'woocommerce_product_data_panels', 'bearlane_embroidery_product_panel' );

function bearlane_embroidery_product_panel(): void {
	echo '<div id="bearlane_embroidery_panel" class="panel woocommerce_options_panel">';
	woocommerce_wp_checkbox( [
		'id'          => '_bearlane_enable_embroidery',
		'label'       => __( 'Enable embroidery', 'bearlane' ),
		'description' => __( 'Show the embroidery customization options on this product page.', 'bearlane' ),
	] );
	echo '</div>';
}

add_action( 'woocommerce_process_product_meta', 'bearlane_save_embroidery_toggle' );

function bearlane_save_embroidery_toggle( int $post_id ): void {
	$enabled = isset( $_POST['_bearlane_enable_embroidery'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_bearlane_enable_embroidery', $enabled );
}

// ---------------------------------------------------------------------------
// Embroidery Customization Fields on Product Page
// ---------------------------------------------------------------------------

/**
 * Output embroidery customization options below the short description.
 * Only shown when the per-product "Enable embroidery" toggle is checked.
 */
add_action( 'woocommerce_before_add_to_cart_button', 'bearlane_embroidery_options', 5 );

function bearlane_embroidery_options(): void {
	global $product;
	if ( ! $product instanceof \WC_Product ) {
		return;
	}

	if ( 'yes' !== get_post_meta( $product->get_id(), '_bearlane_enable_embroidery', true ) ) {
		return;
	}

	$placements   = [
		''              => __( '— Select placement —', 'bearlane' ),
		'left-chest'    => __( 'Left Chest', 'bearlane' ),
		'right-chest'   => __( 'Right Chest', 'bearlane' ),
		'full-back'     => __( 'Full Back (Large)', 'bearlane' ),
		'upper-back'    => __( 'Upper Back (Small)', 'bearlane' ),
		'left-sleeve'   => __( 'Left Sleeve', 'bearlane' ),
		'right-sleeve'  => __( 'Right Sleeve', 'bearlane' ),
		'cuff'          => __( 'Cuff', 'bearlane' ),
		'collar'        => __( 'Collar', 'bearlane' ),
	];

	$thread_colors = [
		[ 'name' => 'Black',        'hex' => '#000000' ],
		[ 'name' => 'White',        'hex' => '#FFFFFF' ],
		[ 'name' => 'Navy',         'hex' => '#1B2A4A' ],
		[ 'name' => 'Royal Blue',   'hex' => '#2055B5' ],
		[ 'name' => 'Red',          'hex' => '#CC2228' ],
		[ 'name' => 'Burgundy',     'hex' => '#7B1A2E' ],
		[ 'name' => 'Forest Green', 'hex' => '#1A5C2A' ],
		[ 'name' => 'Kelly Green',  'hex' => '#27A845' ],
		[ 'name' => 'Gold',         'hex' => '#C9A84C' ],
		[ 'name' => 'Yellow',       'hex' => '#F5C518' ],
		[ 'name' => 'Orange',       'hex' => '#E8650A' ],
		[ 'name' => 'Purple',       'hex' => '#5B2D8E' ],
		[ 'name' => 'Pink',         'hex' => '#E87A9E' ],
		[ 'name' => 'Brown',        'hex' => '#7B4B2A' ],
		[ 'name' => 'Silver',       'hex' => '#B0B0B0' ],
		[ 'name' => 'Charcoal',     'hex' => '#444444' ],
	];
	?>

	<!-- Embroidery Options Panel -->
	<div class="wc-embroidery-options" id="embroidery-options">
		<h3 class="wc-embroidery-options__title">
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
			<?php esc_html_e( 'Embroidery Customization', 'bearlane' ); ?>
		</h3>

		<!-- Placement -->
		<div class="wc-embroidery-field">
			<label class="wc-embroidery-field__label" for="embroidery_placement">
				<?php esc_html_e( 'Embroidery Placement', 'bearlane' ); ?>
				<span class="wc-embroidery-field__hint"><?php esc_html_e( 'Where on the shirt?', 'bearlane' ); ?></span>
			</label>
			<select name="embroidery_placement" id="embroidery_placement" class="wc-embroidery-select">
				<?php foreach ( $placements as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<!-- Thread Color -->
		<div class="wc-embroidery-field">
			<label class="wc-embroidery-field__label">
				<?php esc_html_e( 'Thread Color', 'bearlane' ); ?>
				<span class="wc-embroidery-field__hint"><?php esc_html_e( '30+ Madeira colors', 'bearlane' ); ?></span>
			</label>
			<div class="thread-color-swatches" role="group" aria-label="<?php esc_attr_e( 'Select thread color', 'bearlane' ); ?>">
				<?php foreach ( $thread_colors as $color ) : ?>
				<button type="button"
					class="thread-swatch"
					style="background-color: <?php echo esc_attr( $color['hex'] ); ?>; <?php echo $color['name'] === 'White' ? 'border-color: #e5e7eb;' : ''; ?>"
					title="<?php echo esc_attr( $color['name'] ); ?>"
					aria-label="<?php echo esc_attr( $color['name'] ); ?>"
					data-color="<?php echo esc_attr( $color['name'] ); ?>">
				</button>
				<?php endforeach; ?>
			</div>
			<input type="hidden" name="embroidery_thread_color" id="embroidery_thread_color" value="">
		</div>

		<!-- Personalization Text -->
		<div class="wc-embroidery-field">
			<label class="wc-embroidery-field__label" for="embroidery_text">
				<?php esc_html_e( 'Personalization Text', 'bearlane' ); ?>
				<span class="wc-embroidery-field__hint"><?php esc_html_e( 'Optional — name, monogram, motto', 'bearlane' ); ?></span>
			</label>
			<input type="text"
				name="embroidery_text"
				id="embroidery_text"
				maxlength="50"
				placeholder="<?php esc_attr_e( 'e.g. J. Smith, EST. 2019', 'bearlane' ); ?>">
		</div>

		<!-- Special instructions -->
		<div class="wc-embroidery-field">
			<label class="wc-embroidery-field__label" for="embroidery_notes">
				<?php esc_html_e( 'Special Instructions', 'bearlane' ); ?>
				<span class="wc-embroidery-field__hint"><?php esc_html_e( 'Optional', 'bearlane' ); ?></span>
			</label>
			<textarea name="embroidery_notes" id="embroidery_notes"
				placeholder="<?php esc_attr_e( 'Any special sizing, color matching, or design notes for our team…', 'bearlane' ); ?>"
				rows="3"></textarea>
		</div>

		<!-- Artwork note -->
		<div class="embroidery-note">
			<h4 class="embroidery-note__title">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
				<?php esc_html_e( 'Uploading your logo?', 'bearlane' ); ?>
			</h4>
			<ul class="embroidery-note__list">
				<li>
					<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
					<?php esc_html_e( 'Email your artwork to hello@bearlane.com after checkout', 'bearlane' ); ?>
				</li>
				<li>
					<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
					<?php esc_html_e( 'Accepted: AI, EPS, SVG, PDF, PNG (300 DPI+), JPG', 'bearlane' ); ?>
				</li>
				<li>
					<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
					<?php esc_html_e( 'We\'ll email your digital stitch proof within 24 hours', 'bearlane' ); ?>
				</li>
			</ul>
		</div>

	</div><!-- .wc-embroidery-options -->

	<?php
}

/**
 * Save embroidery customization data to the cart item.
 */
add_filter( 'woocommerce_add_cart_item_data', 'bearlane_save_embroidery_data', 10, 2 );

function bearlane_save_embroidery_data( array $cart_item_data, int $product_id ): array {
	$fields = [
		'embroidery_placement'    => 'sanitize_text_field',
		'embroidery_thread_color' => 'sanitize_text_field',
		'embroidery_text'         => 'sanitize_text_field',
		'embroidery_notes'        => 'sanitize_textarea_field',
	];

	foreach ( $fields as $key => $sanitizer ) {
		if ( ! empty( $_POST[ $key ] ) ) {
			$cart_item_data[ $key ] = call_user_func( $sanitizer, wp_unslash( $_POST[ $key ] ) );
		}
	}

	if ( ! empty( array_intersect_key( $cart_item_data, array_flip( array_keys( $fields ) ) ) ) ) {
		$cart_item_data['unique_key'] = md5( microtime() . rand() );
	}

	return $cart_item_data;
}

/**
 * Display embroidery customization data in the cart and checkout.
 */
add_filter( 'woocommerce_get_item_data', 'bearlane_display_embroidery_data', 10, 2 );

function bearlane_display_embroidery_data( array $item_data, array $cart_item ): array {
	$labels = [
		'embroidery_placement'    => __( 'Embroidery Placement', 'bearlane' ),
		'embroidery_thread_color' => __( 'Thread Color', 'bearlane' ),
		'embroidery_text'         => __( 'Personalization', 'bearlane' ),
		'embroidery_notes'        => __( 'Special Instructions', 'bearlane' ),
	];

	foreach ( $labels as $key => $label ) {
		if ( ! empty( $cart_item[ $key ] ) ) {
			$item_data[] = [
				'key'   => $label,
				'value' => wc_clean( $cart_item[ $key ] ),
			];
		}
	}

	return $item_data;
}

/**
 * Persist embroidery data to order item meta.
 */
add_action( 'woocommerce_checkout_create_order_line_item', 'bearlane_add_embroidery_to_order', 10, 4 );

function bearlane_add_embroidery_to_order( \WC_Order_Item_Product $item, string $cart_item_key, array $values, \WC_Order $order ): void {
	$fields = [
		'embroidery_placement'    => __( 'Embroidery Placement', 'bearlane' ),
		'embroidery_thread_color' => __( 'Thread Color', 'bearlane' ),
		'embroidery_text'         => __( 'Personalization', 'bearlane' ),
		'embroidery_notes'        => __( 'Special Instructions', 'bearlane' ),
	];

	foreach ( $fields as $key => $label ) {
		if ( ! empty( $values[ $key ] ) ) {
			$item->add_meta_data( $label, wc_clean( $values[ $key ] ), true );
		}
	}
}

/**
 * Production time notice on single product pages.
 */
add_action( 'woocommerce_before_add_to_cart_button', 'bearlane_production_notice', 1 );

function bearlane_production_notice(): void {
	global $product;
	if ( ! $product instanceof \WC_Product ) {
		return;
	}

	if ( 'yes' !== get_post_meta( $product->get_id(), '_bearlane_enable_embroidery', true ) ) {
		return;
	}

	$days = (string) get_post_meta( $product->get_id(), '_production_days', true );
	$label = $days ? sprintf(
		/* translators: %s: number of business days */
		__( '%s business days', 'bearlane' ),
		esc_html( $days )
	) : __( '10–14 business days', 'bearlane' );
	?>
	<div class="production-notice" role="note">
		<span class="production-notice__icon" aria-hidden="true">
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
		</span>
		<span>
			<strong><?php esc_html_e( 'Production time:', 'bearlane' ); ?></strong>
			<?php echo esc_html( $label ); ?>.
			<?php esc_html_e( 'We\'ll email your digital stitch proof within 24 hours of ordering.', 'bearlane' ); ?>
		</span>
	</div>
	<?php
}

/**
 * Product trust strip below add-to-cart.
 */
add_action( 'woocommerce_after_add_to_cart_button', 'bearlane_product_trust_strip' );

function bearlane_product_trust_strip(): void {
	?>
	<div class="product-trust-strip">
		<div class="product-trust-item">
			<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
			<?php esc_html_e( 'Proof approval before production', 'bearlane' ); ?>
		</div>
		<div class="product-trust-item">
			<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
			<?php esc_html_e( 'Satisfaction guarantee', 'bearlane' ); ?>
		</div>
		<div class="product-trust-item">
			<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
			<?php esc_html_e( 'SSL-encrypted checkout', 'bearlane' ); ?>
		</div>
	</div>
	<?php
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
