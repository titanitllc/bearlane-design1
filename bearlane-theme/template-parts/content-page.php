<?php
/**
 * Template Part — Generic Page Content
 *
 * Renders the page body in a layout-aware wrapper. The banner is
 * handled by bearlane_render_page_banner() in page.php, so this file
 * only outputs the block editor / Elementor content. Featured image
 * rendering is suppressed here because the banner already covers it.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();

	$layout = get_post_meta( get_the_ID(), BEARLANE_PAGE_META_LAYOUT, true ) ?: 'contained';
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content page-content--' . sanitize_html_class( $layout ) ); ?>>

		<?php if ( 'full-width' === $layout ) : ?>

			<div class="page-content__body page-content__body--full">
				<?php
				the_content();
				wp_link_pages( [
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bearlane' ),
					'after'  => '</div>',
				] );
				?>
			</div>

		<?php else : ?>

			<div class="container">
				<div class="page-content__inner">
					<div class="page-content__body">
						<?php
						the_content();
						wp_link_pages( [
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bearlane' ),
							'after'  => '</div>',
						] );
						?>
					</div>
				</div>
			</div>

		<?php endif; ?>

	</article>

	<?php
endwhile;
