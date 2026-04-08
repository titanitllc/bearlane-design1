<?php
/**
 * Template Part — Product Card
 *
 * Used on homepage featured products and anywhere a single product card is needed.
 * Accepts $args['product'] as a WC_Product object.
 *
 * @package BearLane
 *
 * @var array $args Template arguments.
 */

/** @var \WC_Product $product */
$product = $args['product'] ?? null;
if ( ! $product instanceof \WC_Product ) {
	return;
}

$product_id    = $product->get_id();
$product_url   = get_permalink( $product_id );
$thumbnail_url = get_the_post_thumbnail_url( $product_id, 'bearlane-card' ) ?: wc_placeholder_img_src( 'bearlane-card' );
$product_name  = $product->get_name();
?>

<article class="product-card" data-product-id="<?php echo esc_attr( $product_id ); ?>">

	<div class="product-card__image-wrap">
		<a href="<?php echo esc_url( $product_url ); ?>" class="product-card__image-link" aria-label="<?php echo esc_attr( $product_name ); ?>" tabindex="-1">
			<img src="<?php echo esc_url( $thumbnail_url ); ?>"
				alt="<?php echo esc_attr( $product_name ); ?>"
				class="product-card__image"
				loading="lazy"
				width="600"
				height="600">
		</a>

		<!-- Badges -->
		<?php echo bearlane_product_badge( $product ); // phpcs:ignore ?>

		<!-- Quick View -->
		<button class="btn btn--ghost quick-view-trigger product-card__quick-view"
			data-product-id="<?php echo esc_attr( $product_id ); ?>"
			aria-label="<?php esc_attr_e( 'Quick view', 'bearlane' ); ?>">
			<?php esc_html_e( 'Quick View', 'bearlane' ); ?>
		</button>
	</div>

	<div class="product-card__body">
		<h3 class="product-card__title">
			<a href="<?php echo esc_url( $product_url ); ?>"><?php echo esc_html( $product_name ); ?></a>
		</h3>

		<?php echo bearlane_star_rating( $product ); // phpcs:ignore ?>

		<div class="product-card__price">
			<?php echo $product->get_price_html(); // phpcs:ignore ?>
		</div>
	</div>

	<div class="product-card__footer">
		<?php
		if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) :
			woocommerce_template_loop_add_to_cart( [ 'class' => 'btn btn--primary product-card__add' ] );
		else :
		?>
		<a href="<?php echo esc_url( $product_url ); ?>" class="btn btn--outline">
			<?php esc_html_e( 'View Product', 'bearlane' ); ?>
		</a>
		<?php endif; ?>
	</div>

</article>
