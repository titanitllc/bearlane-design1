<?php
/**
 * BearLane Design — Generic Page Template
 *
 * Fully UI-driven: the banner, hero image, subtitle, and layout
 * are all controlled from the "BearLane Page Options" meta box in
 * the page editor. Zero hardcoded content.
 *
 * @package BearLane
 */

get_header();

$post_id = get_the_ID();
?>

<main id="site-content" class="<?php echo esc_attr( bearlane_page_layout_class( $post_id ) ); ?>">

	<?php if ( ! is_front_page() ) : ?>
		<?php bearlane_render_page_banner( $post_id ); ?>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/content', 'page' ); ?>

	<?php if ( 'contained-sidebar' === ( get_post_meta( $post_id, BEARLANE_PAGE_META_LAYOUT, true ) ?: 'contained' ) ) : ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>

</main>

<?php get_footer(); ?>
