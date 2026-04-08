<?php
/**
 * Template Part — Homepage USP (Unique Selling Points)
 *
 * @package BearLane
 */

$usps = [
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>',
		'title' => __( 'Free Shipping', 'bearlane' ),
		'desc'  => __( 'On all orders over $75. International rates apply.', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>',
		'title' => __( '30-Day Returns', 'bearlane' ),
		'desc'  => __( 'No questions asked. Full refund or exchange.', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
		'title' => __( 'Secure Checkout', 'bearlane' ),
		'desc'  => __( 'SSL encrypted. Your data is always safe.', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
		'title' => __( 'Premium Quality', 'bearlane' ),
		'desc'  => __( 'Curated products with uncompromising standards.', 'bearlane' ),
	],
];
?>

<section class="section usp-section" aria-label="<?php esc_attr_e( 'Why BearLane', 'bearlane' ); ?>">
	<div class="container">
		<div class="usp-grid">
			<?php foreach ( $usps as $usp ) : ?>
			<div class="usp-item">
				<div class="usp-item__icon" aria-hidden="true">
					<?php echo $usp['icon']; // phpcs:ignore ?>
				</div>
				<h3 class="usp-item__title"><?php echo esc_html( $usp['title'] ); ?></h3>
				<p class="usp-item__desc"><?php echo esc_html( $usp['desc'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
