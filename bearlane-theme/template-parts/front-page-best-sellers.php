<?php
/**
 * Template Part — Best Sellers / New Arrivals Tabbed Section
 *
 * Tabbed product showcase: Best Sellers · New Arrivals · Staff Picks
 *
 * @package BearLane
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$tabs = [
	'best-sellers' => [
		'label'    => __( 'Best Sellers', 'bearlane' ),
		'products' => wc_get_products( [
			'limit'   => 4,
			'status'  => 'publish',
			'orderby' => 'popularity',
			'order'   => 'DESC',
		] ),
	],
	'new-arrivals' => [
		'label'    => __( 'New Arrivals', 'bearlane' ),
		'products' => wc_get_products( [
			'limit'   => 4,
			'status'  => 'publish',
			'orderby' => 'date',
			'order'   => 'DESC',
		] ),
	],
	'featured' => [
		'label'    => __( 'Staff Picks', 'bearlane' ),
		'products' => wc_get_products( [
			'limit'    => 4,
			'status'   => 'publish',
			'featured' => true,
			'orderby'  => 'date',
			'order'    => 'DESC',
		] ),
	],
];

// Remove empty tabs.
foreach ( $tabs as $key => $tab ) {
	if ( empty( $tab['products'] ) ) {
		unset( $tabs[ $key ] );
	}
}

if ( empty( $tabs ) ) {
	return;
}

$tab_keys = array_keys( $tabs );
$first    = $tab_keys[0];
?>

<section class="section best-sellers-section" aria-label="<?php esc_attr_e( 'Shop Our Collection', 'bearlane' ); ?>">
	<div class="container">

		<div class="best-sellers-header">
			<div class="best-sellers-header__text">
				<div class="section__eyebrow"><?php esc_html_e( 'Shop the Collection', 'bearlane' ); ?></div>
				<h2 class="section__title"><?php esc_html_e( 'Shirts Worth Embroidering', 'bearlane' ); ?></h2>
			</div>

			<!-- Tabs nav -->
			<nav class="product-tabs" aria-label="<?php esc_attr_e( 'Product categories', 'bearlane' ); ?>" role="tablist">
				<?php foreach ( $tabs as $key => $tab ) : ?>
				<button class="product-tab<?php echo $key === $first ? ' is-active' : ''; ?>"
					role="tab"
					id="tab-<?php echo esc_attr( $key ); ?>"
					aria-controls="tabpanel-<?php echo esc_attr( $key ); ?>"
					aria-selected="<?php echo $key === $first ? 'true' : 'false'; ?>"
					data-tab="<?php echo esc_attr( $key ); ?>">
					<?php echo esc_html( $tab['label'] ); ?>
				</button>
				<?php endforeach; ?>
			</nav>
		</div>

		<!-- Tab panels -->
		<?php foreach ( $tabs as $key => $tab ) : ?>
		<div class="product-tab-panel<?php echo $key === $first ? ' is-active' : ''; ?>"
			id="tabpanel-<?php echo esc_attr( $key ); ?>"
			role="tabpanel"
			aria-labelledby="tab-<?php echo esc_attr( $key ); ?>"
			<?php echo $key !== $first ? 'hidden' : ''; ?>>
			<div class="product-grid product-grid--4col">
				<?php foreach ( $tab['products'] as $product ) : ?>
				<?php bearlane_part( 'template-parts/product', 'card', [ 'product' => $product ] ); ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endforeach; ?>

		<div class="best-sellers-footer">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--outline">
				<?php esc_html_e( 'View All Products', 'bearlane' ); ?>
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
			</a>
		</div>

	</div>
</section>
