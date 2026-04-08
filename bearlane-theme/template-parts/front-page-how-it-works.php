<?php
/**
 * Template Part — How It Works
 *
 * 4-step custom embroidery order flow for homepage.
 *
 * @package BearLane
 */

$steps = [
	[
		'number' => '01',
		'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
		'title'  => __( 'Choose Your Shirt', 'bearlane' ),
		'desc'   => __( 'Browse our range of premium shirts — polo, oxford, t-shirt, or fleece. Select your color, size, and fabric weight to match your brand.', 'bearlane' ),
	],
	[
		'number' => '02',
		'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
		'title'  => __( 'Upload Your Design', 'bearlane' ),
		'desc'   => __( 'Upload your logo or artwork in any format. Choose your embroidery placement — left chest, back, sleeve, or cuff — and pick your thread colors.', 'bearlane' ),
	],
	[
		'number' => '03',
		'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
		'title'  => __( 'Approve Your Proof', 'bearlane' ),
		'desc'   => __( 'We\'ll email you a digital stitch preview within 24 hours. Once you approve, we begin production. No surprises, no wasted shirts.', 'bearlane' ),
	],
	[
		'number' => '04',
		'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
		'title'  => __( 'We Ship to You', 'bearlane' ),
		'desc'   => __( 'Your embroidered shirts are carefully inspected, packaged, and shipped within 10–14 business days. Track your order every step of the way.', 'bearlane' ),
	],
];
?>

<section class="section how-it-works-section" aria-label="<?php esc_attr_e( 'How It Works', 'bearlane' ); ?>">
	<div class="container">

		<header class="section__header">
			<div class="section__eyebrow"><?php esc_html_e( 'The Process', 'bearlane' ); ?></div>
			<h2 class="section__title"><?php esc_html_e( 'Custom Embroidery Made Simple', 'bearlane' ); ?></h2>
			<p class="section__subtitle"><?php esc_html_e( 'Four easy steps from blank shirt to branded perfection.', 'bearlane' ); ?></p>
		</header>

		<div class="how-it-works-grid">
			<?php foreach ( $steps as $i => $step ) : ?>
			<div class="how-it-works-step">
				<div class="how-it-works-step__header">
					<div class="how-it-works-step__icon" aria-hidden="true">
						<?php echo $step['icon']; // phpcs:ignore ?>
					</div>
					<span class="how-it-works-step__number" aria-hidden="true"><?php echo esc_html( $step['number'] ); ?></span>
				</div>
				<h3 class="how-it-works-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
				<p class="how-it-works-step__desc"><?php echo esc_html( $step['desc'] ); ?></p>
				<?php if ( $i < count( $steps ) - 1 ) : ?>
				<div class="how-it-works-step__connector" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="how-it-works-cta">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary btn--large">
				<?php esc_html_e( 'Start Designing', 'bearlane' ); ?>
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
			</a>
			<?php endif; ?>
			<p class="how-it-works-cta__note">
				<?php esc_html_e( 'No design experience needed. Our team guides you every step.', 'bearlane' ); ?>
			</p>
		</div>

	</div>
</section>
