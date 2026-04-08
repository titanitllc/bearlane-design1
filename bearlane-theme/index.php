<?php
/**
 * BearLane Design — Fallback Index Template
 *
 * Used for blog archive and as a fallback when no more specific template matches.
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="archive-page">
	<div class="container archive-page__container">

		<header class="archive-page__header">
			<?php
			if ( is_home() && ! is_front_page() ) :
				single_post_title( '<h1 class="archive-title">', '</h1>' );
			elseif ( is_category() || is_tag() || is_tax() ) :
				the_archive_title( '<h1 class="archive-title">', '</h1>' );
				the_archive_description( '<div class="archive-desc">', '</div>' );
			else :
				echo '<h1 class="archive-title">' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
			endif;
			?>
		</header>

		<?php if ( have_posts() ) : ?>
		<div class="post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_format() ?: 'standard' );
			endwhile;
			?>
		</div>

		<?php
		the_posts_pagination( [
			'prev_text' => __( '&larr; Older', 'bearlane' ),
			'next_text' => __( 'Newer &rarr;', 'bearlane' ),
			'class'     => 'pagination',
		] );
		?>

		<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- .container -->
</main>

<?php get_footer(); ?>
