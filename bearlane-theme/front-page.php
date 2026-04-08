<?php
/**
 * BearLane Design — Front Page
 *
 * Shown when the Reading Settings are set to a static front page.
 * Compose the homepage from focused template-parts.
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="front-page">

	<?php bearlane_part( 'template-parts/front-page', 'hero' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'categories' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'featured-products' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'usp' ); ?>

	<?php bearlane_part( 'template-parts/front-page', 'testimonials' ); ?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<section class="front-page__content container">
				<?php the_content(); ?>
			</section>
		<?php endwhile; ?>
	<?php endif; ?>

</main>

<?php get_footer(); ?>
