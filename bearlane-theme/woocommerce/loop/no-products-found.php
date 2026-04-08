<?php
/**
 * BearLane — WooCommerce "No Products Found"
 *
 * Overrides: woocommerce/loop/no-products-found.php
 *
 * @package BearLane
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="content-none">
	<div class="content-none__inner">
		<div class="content-none__icon" aria-hidden="true">
			<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
		</div>
		<h2 class="content-none__title"><?php esc_html_e( 'No products found', 'bearlane' ); ?></h2>
		<p class="content-none__desc"><?php esc_html_e( 'Try adjusting your search or filter to find what you\'re looking for.', 'bearlane' ); ?></p>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary">
			<?php esc_html_e( 'Back to Shop', 'bearlane' ); ?>
		</a>
	</div>
</div>
