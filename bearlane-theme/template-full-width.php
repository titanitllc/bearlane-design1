<?php
/**
 * Template Name: Full Width (Elementor / Blocks)
 *
 * Minimal full-width page template — header + main + footer only.
 * No container, no page banner, no sidebar. Ideal for Elementor
 * full-width sections, landing pages, and block-editor layouts that
 * need edge-to-edge control.
 *
 * Elementor detects this template and renders its content inside
 * <main>, so you can build the entire page visually.
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="single-page single-page--full-width">

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
			wp_link_pages( [
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bearlane' ),
				'after'  => '</div>',
			] );
		endwhile;
	endif;
	?>

</main>

<?php get_footer(); ?>
