<?php
/**
 * Template Part — Homepage Hero
 *
 * Premium full-viewport hero with dual CTA and social proof strip.
 *
 * @package BearLane
 */

$hero_image_id  = get_theme_mod( 'bearlane_hero_image', 0 );
$hero_image_url = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'bearlane-hero' ) : '';
$heading        = get_theme_mod( 'bearlane_hero_heading',    __( 'Your Logo. Stitched to Last.', 'bearlane' ) );
$subheading     = get_theme_mod( 'bearlane_hero_subheading', __( 'Premium embroidered shirts for individuals, teams, and businesses. Custom orders in 10&ndash;14 business days.', 'bearlane' ) );
$cta_label      = get_theme_mod( 'bearlane_hero_cta_label',  __( 'Shop Custom Shirts', 'bearlane' ) );
$cta_url        = get_theme_mod( 'bearlane_hero_cta_url',    '/shop' );

$stats = [
	[
		'number' => '5,000+',
		'label'  => __( 'Custom Orders', 'bearlane' ),
	],
	[
		'number' => '30+',
		'label'  => __( 'Thread Colors', 'bearlane' ),
	],
	[
		'number' => '10–14',
		'label'  => __( 'Day Production', 'bearlane' ),
	],
	[
		'number' => '100%',
		'label'  => __( 'Satisfaction', 'bearlane' ),
	],
];
?>

<section class="hero hero--embroidery<?php echo $hero_image_url ? ' hero--has-image' : ''; ?>"
	<?php if ( $hero_image_url ) : ?>
	style="--hero-image: url('<?php echo esc_url( $hero_image_url ); ?>')"
	<?php endif; ?>
	aria-label="<?php esc_attr_e( 'Homepage Hero', 'bearlane' ); ?>">

	<div class="hero__backdrop" aria-hidden="true"></div>

	<div class="container hero__container">
		<div class="hero__content">

			<div class="hero__eyebrow">
				<span class="hero__badge">
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17 5.8 21.3l2.4-7.4L2 9.4h7.6z"/></svg>
					<?php esc_html_e( 'Premium Embroidery', 'bearlane' ); ?>
				</span>
			</div>

			<h1 class="hero__heading"><?php echo wp_kses_post( $heading ); ?></h1>

			<?php if ( $subheading ) : ?>
			<p class="hero__subheading"><?php echo wp_kses_post( $subheading ); ?></p>
			<?php endif; ?>

			<?php if ( $cta_label && $cta_url ) : ?>
			<div class="hero__cta-group">
				<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn--primary btn--large hero__cta-primary">
					<?php echo esc_html( $cta_label ); ?>
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
				</a>
				<a href="<?php echo esc_url( home_url( '/bulk-orders' ) ); ?>" class="btn btn--outline btn--large hero__cta-secondary">
					<?php esc_html_e( 'Get a Bulk Quote', 'bearlane' ); ?>
				</a>
			</div>
			<?php endif; ?>

			<div class="hero__trust-strip" aria-label="<?php esc_attr_e( 'Trust indicators', 'bearlane' ); ?>">
				<span class="hero__trust-item">
					<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
					<?php esc_html_e( 'Free shipping $75+', 'bearlane' ); ?>
				</span>
				<span class="hero__trust-sep" aria-hidden="true">·</span>
				<span class="hero__trust-item">
					<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					<?php esc_html_e( 'Satisfaction guarantee', 'bearlane' ); ?>
				</span>
				<span class="hero__trust-sep" aria-hidden="true">·</span>
				<span class="hero__trust-item">
					<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
					<?php esc_html_e( '10–14 day production', 'bearlane' ); ?>
				</span>
			</div>

		</div>
	</div>

	<!-- Social proof stats bar -->
	<div class="hero__stats" aria-label="<?php esc_attr_e( 'Key statistics', 'bearlane' ); ?>">
		<div class="container">
			<div class="hero__stats-grid">
				<?php foreach ( $stats as $stat ) : ?>
				<div class="hero__stat">
					<span class="hero__stat-number"><?php echo esc_html( $stat['number'] ); ?></span>
					<span class="hero__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Decorative scroll indicator -->
	<div class="hero__scroll" aria-hidden="true">
		<span class="hero__scroll-line"></span>
	</div>

</section>
