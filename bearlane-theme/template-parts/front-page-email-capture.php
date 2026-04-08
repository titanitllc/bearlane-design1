<?php
/**
 * Template Part — Email Capture Section
 *
 * Offer-driven newsletter/lead capture for custom orders and promos.
 *
 * @package BearLane
 */
?>

<section class="section email-capture-section" aria-label="<?php esc_attr_e( 'Sign up for offers', 'bearlane' ); ?>">
	<div class="container">
		<div class="email-capture-inner">

			<div class="email-capture__text">
				<div class="section__eyebrow section__eyebrow--accent"><?php esc_html_e( 'Exclusive Offer', 'bearlane' ); ?></div>
				<h2 class="email-capture__title"><?php esc_html_e( 'Get 10% Off Your First Custom Order', 'bearlane' ); ?></h2>
				<p class="email-capture__desc">
					<?php esc_html_e( 'Sign up and we\'ll send you a promo code, plus early access to new styles, seasonal sales, and embroidery design inspiration.', 'bearlane' ); ?>
				</p>
				<ul class="email-capture__benefits" role="list">
					<li>
						<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						<?php esc_html_e( '10% off your first order', 'bearlane' ); ?>
					</li>
					<li>
						<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						<?php esc_html_e( 'New arrivals before anyone else', 'bearlane' ); ?>
					</li>
					<li>
						<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						<?php esc_html_e( 'Bulk order tips and design ideas', 'bearlane' ); ?>
					</li>
				</ul>
			</div>

			<div class="email-capture__form-wrap">
				<form class="email-capture-form newsletter-form" method="post" novalidate
					aria-label="<?php esc_attr_e( 'Email signup form', 'bearlane' ); ?>">

					<div class="email-capture-form__row">
						<div class="email-capture-form__field">
							<label for="email-capture-name" class="screen-reader-text">
								<?php esc_html_e( 'Your first name', 'bearlane' ); ?>
							</label>
							<input type="text"
								id="email-capture-name"
								name="first_name"
								class="email-capture-form__input"
								placeholder="<?php esc_attr_e( 'First name', 'bearlane' ); ?>"
								autocomplete="given-name">
						</div>
						<div class="email-capture-form__field">
							<label for="email-capture-email" class="screen-reader-text">
								<?php esc_html_e( 'Your email address', 'bearlane' ); ?>
							</label>
							<input type="email"
								id="email-capture-email"
								name="email"
								class="email-capture-form__input newsletter-form__input"
								placeholder="<?php esc_attr_e( 'Email address', 'bearlane' ); ?>"
								required
								autocomplete="email">
						</div>
					</div>

					<button type="submit" class="btn btn--primary btn--full newsletter-form__btn">
						<?php esc_html_e( 'Claim My 10% Discount', 'bearlane' ); ?>
					</button>

					<p class="email-capture-form__privacy">
						<?php esc_html_e( 'No spam, ever. Unsubscribe any time.', 'bearlane' ); ?>
					</p>

				</form>
			</div>

		</div>
	</div>
</section>
