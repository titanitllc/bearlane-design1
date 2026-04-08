<?php
/**
 * Template Part — Bulk / Business Order Callout
 *
 * Prominent CTA for teams, companies, schools, and events.
 *
 * @package BearLane
 */

$use_cases = [
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
		'label' => __( 'Teams &amp; Staff', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>',
		'label' => __( 'Businesses', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>',
		'label' => __( 'Schools &amp; Clubs', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
		'label' => __( 'Events', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
		'label' => __( 'Sports Teams', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
		'label' => __( 'Non-profits', 'bearlane' ),
	],
];

$perks = [
	__( 'Volume discounts starting at 12 units', 'bearlane' ),
	__( 'Dedicated account manager', 'bearlane' ),
	__( 'Mixed sizes per design, no minimums per size', 'bearlane' ),
	__( 'Free digitizing on orders of 24+', 'bearlane' ),
	__( 'Net-30 invoicing for qualified accounts', 'bearlane' ),
	__( 'Priority production on urgent deadlines', 'bearlane' ),
];
?>

<section class="section bulk-order-section" aria-label="<?php esc_attr_e( 'Bulk and Business Orders', 'bearlane' ); ?>">
	<div class="container">
		<div class="bulk-order-inner">

			<div class="bulk-order__content">
				<div class="section__eyebrow section__eyebrow--light"><?php esc_html_e( 'Bulk &amp; Business', 'bearlane' ); ?></div>
				<h2 class="bulk-order__title"><?php esc_html_e( 'Ordering for a Team, Business, or Event?', 'bearlane' ); ?></h2>
				<p class="bulk-order__intro">
					<?php esc_html_e( 'We handle runs of 12 to 5,000+ units with the same quality and attention to detail as a single piece. Better pricing, faster turnaround, and a dedicated account manager.', 'bearlane' ); ?>
				</p>

				<ul class="bulk-order-perks" role="list">
					<?php foreach ( $perks as $perk ) : ?>
					<li class="bulk-order-perk">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						<?php echo esc_html( $perk ); ?>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="bulk-order__actions">
					<a href="<?php echo esc_url( home_url( '/bulk-orders' ) ); ?>" class="btn btn--primary btn--large">
						<?php esc_html_e( 'Get a Bulk Quote', 'bearlane' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn--ghost btn--large">
						<?php esc_html_e( 'Talk to Our Team', 'bearlane' ); ?>
					</a>
				</div>
			</div>

			<div class="bulk-order__use-cases">
				<p class="bulk-order__use-cases-label"><?php esc_html_e( 'Perfect for:', 'bearlane' ); ?></p>
				<div class="bulk-use-cases-grid">
					<?php foreach ( $use_cases as $case ) : ?>
					<div class="bulk-use-case">
						<span class="bulk-use-case__icon" aria-hidden="true">
							<?php echo $case['icon']; // phpcs:ignore ?>
						</span>
						<span class="bulk-use-case__label"><?php echo wp_kses_post( $case['label'] ); ?></span>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="bulk-order__minimum-note">
					<?php esc_html_e( 'No per-design minimum. Mix sizes freely. Same stitch quality on every piece.', 'bearlane' ); ?>
				</div>
			</div>

		</div>
	</div>
</section>
