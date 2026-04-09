<?php
/**
 * BearLane Design — Single Product Template
 *
 * Wraps WooCommerce's single-product hooks in our layout.
 * Embroidery-specific enhancements:
 *   - Production time notice (injected via woocommerce.php hook)
 *   - Embroidery options panel (injected via woocommerce.php hook)
 *   - Trust strip below add-to-cart (injected via woocommerce.php hook)
 *   - Sticky mobile add-to-cart bar
 *   - Care instructions reminder in product tabs (WC native tab)
 *   - Related products grid
 *
 * @package BearLane
 */

get_header();

while ( have_posts() ) :
	the_post();

	global $product;
	$product_title = $product instanceof \WC_Product ? $product->get_name() : get_the_title();
	$product_price = $product instanceof \WC_Product ? $product->get_price_html() : '';
?>

<main id="site-content" class="single-product-page">

	<div class="page-banner page-banner--slim">
		<div class="container">
			<?php bearlane_breadcrumbs(); ?>
		</div>
	</div>

	<!-- Anchor for sticky add-to-cart observer -->
	<span id="product-add-to-cart-anchor" aria-hidden="true"></span>

	<div class="container">
		<?php
		/*
		 * We are already inside a have_posts() / the_post() loop, so we must
		 * render the single-product content template directly. Calling
		 * woocommerce_content() here would trigger its own inner have_posts()
		 * loop, which in turn calls rewind_posts() once the current post is
		 * exhausted — resetting the outer loop's pointer and causing an
		 * infinite loop (fatal: max execution time / memory exhausted).
		 */
		wc_get_template_part( 'content', 'single-product' );
		?>
	</div>

	<?php
	// Related products section.
	$related = wc_get_related_products( get_the_ID(), 4 );
	if ( $related ) :
		$related_products = array_map( 'wc_get_product', $related );
		$related_products = array_filter( $related_products );
	?>
	<section class="section related-products" aria-label="<?php esc_attr_e( 'Related Products', 'bearlane' ); ?>">
		<div class="container">
			<header class="section__header">
				<h2 class="section__title"><?php esc_html_e( 'You Might Also Like', 'bearlane' ); ?></h2>
				<p class="section__subtitle"><?php esc_html_e( 'More shirts ready for your custom embroidery.', 'bearlane' ); ?></p>
			</header>
			<div class="product-grid product-grid--4col">
				<?php foreach ( $related_products as $related_product ) : ?>
				<?php bearlane_part( 'template-parts/product', 'card', [ 'product' => $related_product ] ); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>

<!-- Sticky Add-to-Cart bar (mobile only — shown when the main form scrolls out of view) -->
<div class="sticky-atc" role="complementary" aria-label="<?php esc_attr_e( 'Quick add to cart', 'bearlane' ); ?>">
	<div class="sticky-atc__info">
		<div class="sticky-atc__title"><?php echo esc_html( $product_title ); ?></div>
		<?php if ( $product_price ) : ?>
		<div class="sticky-atc__price"><?php echo $product_price; // phpcs:ignore ?></div>
		<?php endif; ?>
	</div>
	<button class="btn btn--primary sticky-atc__btn">
		<?php esc_html_e( 'Add to Cart', 'bearlane' ); ?>
	</button>
</div>

<?php
endwhile;

get_footer();
