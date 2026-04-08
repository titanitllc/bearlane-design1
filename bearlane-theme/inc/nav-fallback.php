<?php
/**
 * Navigation fallback — displayed when no menu is assigned to "Primary".
 *
 * @param array $args wp_nav_menu() arguments.
 */
function bearlane_nav_fallback( array $args ): void {
	if ( current_user_can( 'edit_theme_options' ) ) {
		echo '<p class="primary-nav__fallback"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Assign a menu', 'bearlane' ) . '</a></p>';
	}
}
