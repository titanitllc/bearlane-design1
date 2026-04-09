<?php
/**
 * BearLane Design — About / Brand Story Page Template
 *
 * Template Name: About / Brand Story
 *
 * This template is a UI-driven shell for About-style pages. ALL
 * content comes from the block editor (or Elementor). There is no
 * hardcoded story, values list, or CTA — editors compose those with
 * blocks / Elementor widgets or the "BearLane — USPs" block pattern
 * (registered by inc/block-patterns.php).
 *
 * Per-page banner, hero image, subtitle, and layout are all
 * controlled from "BearLane Page Options" in the page sidebar.
 *
 * @package BearLane
 */

get_header();

$post_id = get_the_ID();
?>

<main id="site-content" class="<?php echo esc_attr( bearlane_page_layout_class( $post_id ) ); ?> about-page">

	<?php bearlane_render_page_banner( $post_id ); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content about-page__content' ); ?>>

		<?php if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<div class="container">
					<div class="page-content__inner">
						<div class="page-content__body">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<?php
			endwhile;
		endif; ?>

	</article>

</main>

<?php get_footer(); ?>
