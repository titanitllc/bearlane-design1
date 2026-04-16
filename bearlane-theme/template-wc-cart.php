<?php
/**
 * Template Name: WooCommerce — Cart
 *
 * Dedicated layout for the WooCommerce cart page.
 * Assign this template to the page set as your Cart page
 * under WooCommerce → Settings → Advanced → Page Setup.
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="woo-page woo-page--cart">
	<div class="container">

		<header class="woo-page__header">
			<?php bearlane_breadcrumbs(); ?>
			<h1 class="woo-page__title"><?php the_title(); ?></h1>
		</header>

		<div class="woo-page__body">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>

	</div>
</main>

<?php
get_footer();
