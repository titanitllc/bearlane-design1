<?php
/**
 * BearLane Design — Single Product Template
 *
 * Wraps WooCommerce's single-product hooks in our layout.
 *
 * @package BearLane
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="site-content" class="single-product-page">

	<div class="page-banner page-banner--slim">
		<div class="container">
			<?php bearlane_breadcrumbs(); ?>
		</div>
	</div>

	<div class="container">
		<?php woocommerce_content(); ?>
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
			<h2 class="section__title"><?php esc_html_e( 'You Might Also Like', 'bearlane' ); ?></h2>
			<div class="product-grid product-grid--4col">
				<?php foreach ( $related_products as $related_product ) : ?>
				<?php bearlane_part( 'template-parts/product', 'card', [ 'product' => $related_product ] ); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>

<?php
endwhile;

get_footer();
