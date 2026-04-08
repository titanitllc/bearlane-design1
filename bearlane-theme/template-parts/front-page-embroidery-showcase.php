<?php
/**
 * Template Part — Embroidery Quality Showcase
 *
 * Close-up quality section highlighting embroidery craftsmanship.
 *
 * @package BearLane
 */

$showcase_image_id  = get_theme_mod( 'bearlane_showcase_image', 0 );
$showcase_image_url = $showcase_image_id
	? wp_get_attachment_image_url( $showcase_image_id, 'large' )
	: '';

$quality_points = [
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
		'title' => __( 'Hand-digitized artwork', 'bearlane' ),
		'desc'  => __( 'Every design is digitized by an expert, not auto-converted — ensuring clean lines and proper stitch direction.', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
		'title' => __( 'Industrial-grade machines', 'bearlane' ),
		'desc'  => __( 'Multi-head Tajima embroidery machines for consistent density, tension, and stitch registration across every garment.', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
		'title' => __( 'Colorfast Madeira threads', 'bearlane' ),
		'desc'  => __( 'Premium polyester threads rated for 100+ washes. Colors stay vivid; no fading, no bleeding, no compromise.', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
		'title' => __( 'Backing and stabilization', 'bearlane' ),
		'desc'  => __( 'Cut-away or tear-away backing on every piece for a flat, professional finish that doesn\'t pucker or distort.', 'bearlane' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
		'title' => __( 'QC before every shipment', 'bearlane' ),
		'desc'  => __( 'Each garment is inspected for loose threads, alignment, and color accuracy before packaging.', 'bearlane' ),
	],
];
?>

<section class="section embroidery-showcase-section" aria-label="<?php esc_attr_e( 'Embroidery Quality', 'bearlane' ); ?>">
	<div class="container">
		<div class="embroidery-showcase">

			<!-- Image side -->
			<div class="embroidery-showcase__visual">
				<?php if ( $showcase_image_url ) : ?>
				<img src="<?php echo esc_url( $showcase_image_url ); ?>"
					alt="<?php esc_attr_e( 'Close-up of embroidery stitch detail on a BearLane shirt', 'bearlane' ); ?>"
					class="embroidery-showcase__image"
					loading="lazy"
					width="600"
					height="700">
				<?php else : ?>
				<div class="embroidery-showcase__placeholder" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					<p><?php esc_html_e( 'Add a close-up embroidery photo via Customizer', 'bearlane' ); ?></p>
				</div>
				<?php endif; ?>

				<div class="embroidery-showcase__badge" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17 5.8 21.3l2.4-7.4L2 9.4h7.6z"/></svg>
					<span><?php esc_html_e( 'Master Stitch Certified', 'bearlane' ); ?></span>
				</div>
			</div>

			<!-- Content side -->
			<div class="embroidery-showcase__content">
				<div class="section__eyebrow"><?php esc_html_e( 'The Detail Makes the Difference', 'bearlane' ); ?></div>
				<h2 class="embroidery-showcase__title"><?php esc_html_e( 'Embroidery You Can Feel the Difference In', 'bearlane' ); ?></h2>
				<p class="embroidery-showcase__intro">
					<?php esc_html_e( 'Not all embroidery is equal. Cheap digitizing, wrong backing, and cut-rate threads produce puckered, faded logos that embarrass your brand. We do it right.', 'bearlane' ); ?>
				</p>

				<ul class="embroidery-quality-list" role="list">
					<?php foreach ( $quality_points as $point ) : ?>
					<li class="embroidery-quality-item">
						<span class="embroidery-quality-item__icon" aria-hidden="true">
							<?php echo $point['icon']; // phpcs:ignore ?>
						</span>
						<div class="embroidery-quality-item__text">
							<strong class="embroidery-quality-item__title"><?php echo esc_html( $point['title'] ); ?></strong>
							<span class="embroidery-quality-item__desc"><?php echo esc_html( $point['desc'] ); ?></span>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="embroidery-showcase__actions">
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary">
						<?php esc_html_e( 'See Our Shirts', 'bearlane' ); ?>
					</a>
					<?php endif; ?>
					<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="btn btn--outline">
						<?php esc_html_e( 'Our Story', 'bearlane' ); ?>
					</a>
				</div>
			</div>

		</div>
	</div>
</section>
