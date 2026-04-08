<?php
/**
 * Template Part — Homepage Featured Products
 *
 * Displays a grid of featured WooCommerce products.
 *
 * @package BearLane
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$products = wc_get_products( [
	'limit'    => 8,
	'status'   => 'publish',
	'featured' => true,
	'orderby'  => 'date',
	'order'    => 'DESC',
] );

// Fallback to recent products if no featured ones exist.
if ( empty( $products ) ) {
	$products = wc_get_products( [
		'limit'   => 8,
		'status'  => 'publish',
		'orderby' => 'date',
		'order'   => 'DESC',
	] );
}

if ( empty( $products ) ) {
	return;
}
?>

<section class="section featured-products-section" aria-label="<?php esc_attr_e( 'Featured Products', 'bearlane' ); ?>">
	<div class="container">

		<header class="section__header">
			<h2 class="section__title"><?php esc_html_e( 'Featured Products', 'bearlane' ); ?></h2>
			<p class="section__subtitle"><?php esc_html_e( 'Handpicked for you.', 'bearlane' ); ?></p>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="section__link">
				<?php esc_html_e( 'View all products', 'bearlane' ); ?> →
			</a>
			<?php endif; ?>
		</header>

		<div class="product-grid product-grid--4col">
			<?php foreach ( $products as $product ) : ?>
			<?php bearlane_part( 'template-parts/product', 'card', [ 'product' => $product ] ); ?>
			<?php endforeach; ?>
		</div>

	</div>
</section>
