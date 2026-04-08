<?php
/**
 * BearLane Design — Sidebar Template
 *
 * @package BearLane
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}
?>

<aside class="sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'bearlane' ); ?>">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside>
