<footer id="site-footer" class="site-footer" role="contentinfo">

	<div class="site-footer__main">
		<div class="container">
			<div class="footer-grid">

				<!-- Brand Column -->
				<div class="footer-col footer-col--brand">
					<?php if ( has_custom_logo() ) : ?>
						<div class="footer-logo"><?php the_custom_logo(); ?></div>
					<?php else : ?>
						<span class="footer-logo footer-logo--text"><?php bloginfo( 'name' ); ?></span>
					<?php endif; ?>
					<p class="footer-tagline"><?php bloginfo( 'description' ); ?></p>

					<!-- Social Links -->
					<div class="footer-social" aria-label="<?php esc_attr_e( 'Social media links', 'bearlane' ); ?>">
						<?php
						$socials = [
							'instagram' => [ 'https://instagram.com', 'Instagram', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>' ],
							'twitter'   => [ 'https://twitter.com', 'X / Twitter', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>' ],
							'facebook'  => [ 'https://facebook.com', 'Facebook', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>' ],
						];
						foreach ( $socials as $key => [ $url, $label, $icon ] ) {
							$mod_url = get_theme_mod( 'bearlane_social_' . $key, $url );
							if ( $mod_url ) :
								echo '<a href="' . esc_url( $mod_url ) . '" class="footer-social__link" aria-label="' . esc_attr( $label ) . '" rel="noopener noreferrer" target="_blank">' . $icon . '</a>'; // phpcs:ignore
							endif;
						}
						?>
					</div>
				</div>

				<!-- Nav Column 1 -->
				<?php if ( has_nav_menu( 'footer-1' ) ) : ?>
				<div class="footer-col">
					<?php
					wp_nav_menu( [
						'theme_location' => 'footer-1',
						'menu_class'     => 'footer-nav',
						'container'      => false,
						'depth'          => 1,
						'before_widget'  => '',
						'after_widget'   => '',
					] );
					?>
				</div>
				<?php endif; ?>

				<!-- Nav Column 2 -->
				<?php if ( has_nav_menu( 'footer-2' ) ) : ?>
				<div class="footer-col">
					<?php
					wp_nav_menu( [
						'theme_location' => 'footer-2',
						'menu_class'     => 'footer-nav',
						'container'      => false,
						'depth'          => 1,
					] );
					?>
				</div>
				<?php endif; ?>

				<!-- Nav Column 3 / Newsletter -->
				<div class="footer-col footer-col--newsletter">
					<h3 class="footer-col__title"><?php esc_html_e( 'Stay Updated', 'bearlane' ); ?></h3>
					<p><?php esc_html_e( 'Subscribe for new arrivals and exclusive offers.', 'bearlane' ); ?></p>
					<form class="newsletter-form" action="#" method="post" aria-label="<?php esc_attr_e( 'Newsletter sign-up', 'bearlane' ); ?>">
						<?php wp_nonce_field( 'bearlane_newsletter', 'bearlane_newsletter_nonce' ); ?>
						<label for="newsletter-email" class="screen-reader-text"><?php esc_html_e( 'Email address', 'bearlane' ); ?></label>
						<div class="newsletter-form__group">
							<input type="email" id="newsletter-email" name="email" class="newsletter-form__input"
								placeholder="<?php esc_attr_e( 'your@email.com', 'bearlane' ); ?>"
								required
								autocomplete="email">
							<button type="submit" class="btn btn--primary newsletter-form__btn"><?php esc_html_e( 'Subscribe', 'bearlane' ); ?></button>
						</div>
					</form>
				</div>

			</div><!-- .footer-grid -->
		</div><!-- .container -->
	</div><!-- .site-footer__main -->

	<div class="site-footer__bottom">
		<div class="container site-footer__bottom-inner">
			<p class="footer-copyright">
				<?php echo wp_kses_post( get_theme_mod( 'bearlane_footer_copyright', sprintf( '&copy; %d BearLane Design. All rights reserved.', gmdate( 'Y' ) ) ) ); ?>
			</p>
			<nav class="footer-legal" aria-label="<?php esc_attr_e( 'Legal links', 'bearlane' ); ?>">
				<?php if ( has_nav_menu( 'footer-3' ) ) : ?>
					<?php wp_nav_menu( [ 'theme_location' => 'footer-3', 'menu_class' => 'footer-legal__menu', 'container' => false, 'depth' => 1 ] ); ?>
				<?php else : ?>
					<ul class="footer-legal__menu">
						<li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'bearlane' ); ?></a></li>
					</ul>
				<?php endif; ?>
			</nav>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<div class="footer-payments" aria-label="<?php esc_attr_e( 'Accepted payment methods', 'bearlane' ); ?>">
				<span class="footer-payments__label"><?php esc_html_e( 'Secure payments:', 'bearlane' ); ?></span>
				<span class="footer-payments__icons">Visa · Mastercard · PayPal · Apple Pay</span>
			</div>
			<?php endif; ?>
		</div>
	</div><!-- .site-footer__bottom -->

</footer><!-- #site-footer -->

<?php wp_footer(); ?>
</body>
</html>
