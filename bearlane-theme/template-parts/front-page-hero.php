<?php
/**
 * Template Part — Homepage Hero
 *
 * @package BearLane
 */

$hero_image_id  = get_theme_mod( 'bearlane_hero_image', 0 );
$hero_image_url = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'bearlane-hero' ) : '';
$heading        = get_theme_mod( 'bearlane_hero_heading',    __( 'Crafted for the Bold.', 'bearlane' ) );
$subheading     = get_theme_mod( 'bearlane_hero_subheading', __( 'Premium products, minimal design.', 'bearlane' ) );
$cta_label      = get_theme_mod( 'bearlane_hero_cta_label',  __( 'Shop Now', 'bearlane' ) );
$cta_url        = get_theme_mod( 'bearlane_hero_cta_url',    '/shop' );
?>

<section class="hero<?php echo $hero_image_url ? ' hero--has-image' : ''; ?>"
	<?php if ( $hero_image_url ) : ?>
	style="--hero-image: url('<?php echo esc_url( $hero_image_url ); ?>')"
	<?php endif; ?>
	aria-label="<?php esc_attr_e( 'Hero', 'bearlane' ); ?>">

	<div class="container hero__container">
		<div class="hero__content">
			<h1 class="hero__heading"><?php echo esc_html( $heading ); ?></h1>
			<?php if ( $subheading ) : ?>
			<p class="hero__subheading"><?php echo esc_html( $subheading ); ?></p>
			<?php endif; ?>
			<?php if ( $cta_label && $cta_url ) : ?>
			<div class="hero__cta-group">
				<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn--primary btn--large">
					<?php echo esc_html( $cta_label ); ?>
				</a>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--outline btn--large">
					<?php esc_html_e( 'Browse All', 'bearlane' ); ?>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Decorative scroll indicator -->
	<div class="hero__scroll" aria-hidden="true">
		<span class="hero__scroll-line"></span>
	</div>

</section>
