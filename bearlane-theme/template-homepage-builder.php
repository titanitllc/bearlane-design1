<?php
/**
 * Template Name: Homepage Builder
 *
 * Assign this template to any Page to render the managed Homepage
 * Sections (from Appearance → Homepage Sections) followed by the page's
 * own block editor / Elementor content.
 *
 * Use this template when:
 *   - You want the homepage on a page OTHER than the default
 *     `static front page`.
 *   - You want to combine managed sections with Gutenberg blocks
 *     below them.
 *   - You want Elementor to override the full page: open the page
 *     in Elementor and its canvas will replace everything here.
 *
 * Precedence (same as front-page.php):
 *   1. Elementor canvas override (via bearlane_front_page_builder_takeover)
 *   2. Managed section loop
 *   3. Page post_content (blocks / Elementor inline)
 *
 * @package BearLane
 */

get_header();

$builder_takeover = apply_filters( 'bearlane_front_page_builder_takeover', false );
?>

<main id="site-content" class="front-page front-page--builder">

	<?php if ( $builder_takeover ) : ?>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>

	<?php else : ?>

		<?php
		$active_ids = bearlane_sections_active_ids();
		foreach ( $active_ids as $section_id ) {
			bearlane_render_section( $section_id );
		}
		?>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				if ( get_the_content() ) :
					?>
					<section class="front-page__content container">
						<?php the_content(); ?>
					</section>
					<?php
				endif;
			endwhile;
		endif;
		?>

	<?php endif; ?>

</main>

<?php get_footer(); ?>
