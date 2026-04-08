<?php
/**
 * BearLane — WooCommerce Product Loop Item
 *
 * Overrides: woocommerce/content-product.php
 * Renders a single product card inside the product loop.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package BearLane
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure product is valid and visible.
if ( ! $product instanceof WC_Product || empty( $product ) ) {
	return;
}
if ( ! $product->is_visible() ) {
	return;
}

$product_id  = $product->get_id();
$product_url = get_permalink( $product_id );
$name        = $product->get_name();
$image_url   = get_the_post_thumbnail_url( $product_id, 'bearlane-card' ) ?: wc_placeholder_img_src( 'bearlane-card' );
?>

<li <?php wc_product_class( 'product-card', $product ); ?> data-product-id="<?php echo esc_attr( $product_id ); ?>">

	<div class="product-card__image-wrap">
		<a href="<?php echo esc_url( $product_url ); ?>" class="product-card__image-link" aria-label="<?php echo esc_attr( $name ); ?>">
			<img src="<?php echo esc_url( $image_url ); ?>"
				alt="<?php echo esc_attr( $name ); ?>"
				class="product-card__image"
				loading="lazy"
				width="600"
				height="600">
		</a>

		<?php echo bearlane_product_badge( $product ); // phpcs:ignore ?>

		<button class="btn btn--ghost quick-view-trigger product-card__quick-view"
			data-product-id="<?php echo esc_attr( $product_id ); ?>"
			aria-label="<?php esc_attr_e( 'Quick view', 'bearlane' ); ?>">
			<?php esc_html_e( 'Quick View', 'bearlane' ); ?>
		</button>
	</div>

	<div class="product-card__body">
		<h2 class="product-card__title">
			<a href="<?php echo esc_url( $product_url ); ?>"><?php echo esc_html( $name ); ?></a>
		</h2>

		<?php echo bearlane_star_rating( $product ); // phpcs:ignore ?>

		<div class="product-card__price">
			<?php echo $product->get_price_html(); // phpcs:ignore ?>
		</div>
	</div>

	<div class="product-card__footer">
		<?php woocommerce_template_loop_add_to_cart( [ 'class' => 'btn btn--primary product-card__add btn--full' ] ); ?>
	</div>

</li>
