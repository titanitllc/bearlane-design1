<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e( 'Skip to content', 'bearlane' ); ?></a>

<?php
// Announcement bar.
$announcement = get_theme_mod( 'bearlane_header_announcement', '' );
if ( $announcement ) :
?>
<div class="announcement-bar" role="banner">
	<div class="container">
		<p><?php echo wp_kses_post( $announcement ); ?></p>
	</div>
</div>
<?php endif; ?>

<header id="site-header" class="site-header<?php echo get_theme_mod( 'bearlane_sticky_header', true ) ? ' site-header--sticky' : ''; ?>" role="banner">
	<div class="container site-header__inner">

		<!-- Logo / Site Title -->
		<div class="site-header__brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__site-name" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<!-- Primary Navigation -->
		<nav id="site-navigation" class="primary-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'bearlane' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location'  => 'primary',
				'menu_id'         => 'primary-menu',
				'menu_class'      => 'primary-nav__menu',
				'container'       => false,
				'fallback_cb'     => 'bearlane_nav_fallback',
				'walker'          => class_exists( 'Bearlane_Walker_Nav_Menu' ) ? new Bearlane_Walker_Nav_Menu() : null,
			] );
			?>
		</nav>

		<!-- Header Actions -->
		<div class="site-header__actions">

			<!-- Search toggle -->
			<button class="header-action header-action--search js-search-toggle"
				aria-label="<?php esc_attr_e( 'Toggle search', 'bearlane' ); ?>"
				aria-expanded="false"
				aria-controls="site-search">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
			</button>

			<!-- Dark mode toggle -->
			<?php if ( get_theme_mod( 'bearlane_dark_mode_toggle', true ) ) : ?>
			<button class="header-action header-action--dark-mode js-dark-mode-toggle"
				aria-label="<?php esc_attr_e( 'Toggle dark mode', 'bearlane' ); ?>"
				aria-pressed="false">
				<svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
				<svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
			</button>
			<?php endif; ?>

			<?php
			// --- Account Icon ---
			$bearlane_account_url = '';
			if ( class_exists( 'WooCommerce' ) ) {
				$bearlane_account_page_id = wc_get_page_id( 'myaccount' );
				if ( $bearlane_account_page_id > 0 ) {
					$bearlane_account_url = get_permalink( $bearlane_account_page_id );
				}
			}
			if ( ! $bearlane_account_url ) {
				$bearlane_account_fallback = (int) get_theme_mod( 'bearlane_account_fallback_page', 0 );
				if ( $bearlane_account_fallback > 0 ) {
					$bearlane_account_url = get_permalink( $bearlane_account_fallback );
				}
			}
			if ( $bearlane_account_url ) : ?>
			<!-- Account -->
			<a href="<?php echo esc_url( $bearlane_account_url ); ?>"
				class="header-action header-action--account"
				aria-label="<?php esc_attr_e( 'My account', 'bearlane' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
			</a>
			<?php endif; ?>

			<?php
			// --- Cart Icon ---
			$bearlane_cart_url = '';
			if ( class_exists( 'WooCommerce' ) ) {
				$bearlane_cart_page_id = wc_get_page_id( 'cart' );
				if ( $bearlane_cart_page_id > 0 ) {
					$bearlane_cart_url = get_permalink( $bearlane_cart_page_id );
				}
			}
			if ( ! $bearlane_cart_url ) {
				$bearlane_cart_fallback = (int) get_theme_mod( 'bearlane_cart_fallback_page', 0 );
				if ( $bearlane_cart_fallback > 0 ) {
					$bearlane_cart_url = get_permalink( $bearlane_cart_fallback );
				}
			}
			?>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<!-- Mini cart toggle (opens drawer, links to cart page on middle-click) -->
			<a href="<?php echo esc_url( $bearlane_cart_url ? $bearlane_cart_url : '#mini-cart' ); ?>"
				class="header-action header-action--cart js-cart-toggle"
				aria-label="<?php esc_attr_e( 'Shopping cart', 'bearlane' ); ?>"
				aria-expanded="false"
				aria-controls="mini-cart"
				role="button">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
				<span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			</a>
			<?php elseif ( $bearlane_cart_url ) : ?>
			<!-- Cart link (WooCommerce inactive, fallback page set) -->
			<a href="<?php echo esc_url( $bearlane_cart_url ); ?>"
				class="header-action header-action--cart"
				aria-label="<?php esc_attr_e( 'Shopping cart', 'bearlane' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
			</a>
			<?php endif; ?>

			<!-- Mobile menu toggle -->
			<button class="header-action header-action--hamburger js-nav-toggle"
				aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'bearlane' ); ?>"
				aria-expanded="false"
				aria-controls="site-navigation">
				<span class="hamburger__bar"></span>
				<span class="hamburger__bar"></span>
				<span class="hamburger__bar"></span>
			</button>
		</div><!-- .site-header__actions -->
	</div><!-- .site-header__inner -->

	<!-- Search Panel -->
	<div id="site-search" class="search-panel" role="search" aria-hidden="true">
		<div class="container">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
				<label for="header-search-input" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'bearlane' ); ?></label>
				<input type="search"
					id="header-search-input"
					class="search-form__input"
					placeholder="<?php esc_attr_e( 'Search products…', 'bearlane' ); ?>"
					value="<?php echo esc_attr( get_search_query() ); ?>"
					name="s"
					autocomplete="off">
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<input type="hidden" name="post_type" value="product">
				<?php endif; ?>
				<button type="submit" class="btn btn--primary">
					<?php esc_html_e( 'Search', 'bearlane' ); ?>
				</button>
				<button type="button" class="search-panel__close js-search-close" aria-label="<?php esc_attr_e( 'Close search', 'bearlane' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
			</form>
		</div>
	</div><!-- #site-search -->

</header><!-- #site-header -->

<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<!-- Mini Cart Drawer (outside header to avoid backdrop-filter containing block) -->
<div id="mini-cart" class="mini-cart" role="dialog" aria-label="<?php esc_attr_e( 'Shopping cart', 'bearlane' ); ?>" aria-hidden="true">
	<div class="mini-cart__header">
		<h2 class="mini-cart__title"><?php esc_html_e( 'Your Cart', 'bearlane' ); ?></h2>
		<button class="mini-cart__close js-cart-close" aria-label="<?php esc_attr_e( 'Close cart', 'bearlane' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>
	<div class="mini-cart__body">
		<?php woocommerce_mini_cart(); ?>
	</div>
</div>
<div class="mini-cart__overlay js-cart-close" aria-hidden="true"></div>
<?php endif; ?>

<!-- Quick View Modal -->
<div id="quick-view-modal" class="modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Product Quick View', 'bearlane' ); ?>" aria-hidden="true">
	<div class="modal__overlay js-modal-close"></div>
	<div class="modal__content">
		<button class="modal__close js-modal-close" aria-label="<?php esc_attr_e( 'Close', 'bearlane' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
		<div class="modal__body quick-view__body">
			<div class="loading-spinner" aria-hidden="true"></div>
		</div>
	</div>
</div>
