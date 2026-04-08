<?php
/**
 * BearLane Design — Front Page
 *
 * Shown when the Reading Settings are set to a static front page.
 * Embroidery storefront homepage composed of focused template parts.
 *
 * Section order (conversion-optimised for custom embroidered shirt sales):
 *   1. Hero           — Big visual statement + dual CTA + social proof strip
 *   2. Best Sellers   — Tabbed product showcase (best sellers / new arrivals / staff picks)
 *   3. How It Works   — 4-step custom order flow
 *   4. Categories     — Shop by style / collection
 *   5. Embroidery     — Quality showcase + craftsmanship detail
 *   6. USP            — 6-point trust grid
 *   7. Testimonials   — Verified customer reviews
 *   8. Bulk Order     — Business / team / event callout
 *   9. FAQ            — Common embroidery questions accordion
 *  10. Email Capture  — Lead gen with 10% offer
 *  11. Page Content   — Optional Gutenberg blocks (editor use)
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="front-page">

	<?php bearlane_part( 'template-parts/front-page', 'hero' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'best-sellers' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'how-it-works' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'categories' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'embroidery-showcase' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'usp' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'testimonials' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'bulk-order' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'faq' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'email-capture' ); ?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( get_the_content() ) : ?>
			<section class="front-page__content container">
				<?php the_content(); ?>
			</section>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>

</main>

<?php get_footer(); ?>
