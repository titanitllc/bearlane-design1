<?php
/**
 * BearLane Design — 404 Not Found
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="error-404-page">
	<div class="container">
		<div class="error-404__inner">

			<div class="error-404__graphic" aria-hidden="true">
				<span class="error-404__code">404</span>
			</div>

			<h1 class="error-404__title"><?php esc_html_e( 'Page Not Found', 'bearlane' ); ?></h1>
			<p class="error-404__desc">
				<?php esc_html_e( 'The page you\'re looking for doesn\'t exist or has been moved.', 'bearlane' ); ?>
			</p>

			<div class="error-404__actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">
					<?php esc_html_e( 'Back to Home', 'bearlane' ); ?>
				</a>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--outline">
					<?php esc_html_e( 'Visit the Shop', 'bearlane' ); ?>
				</a>
				<?php endif; ?>
			</div>

			<div class="error-404__search">
				<p><?php esc_html_e( 'Or try searching:', 'bearlane' ); ?></p>
				<?php get_search_form(); ?>
			</div>

		</div>
	</div>
</main>

<?php get_footer(); ?>
