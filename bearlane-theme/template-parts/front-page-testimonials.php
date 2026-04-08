<?php
/**
 * Template Part — Homepage Testimonials
 *
 * Embroidery-specific verified customer reviews with product context.
 *
 * @package BearLane
 */

$testimonials = [
	[
		'quote'   => __( 'We ordered 50 custom polo shirts for our company retreat and every single one came out perfect. The embroidery was crisp, the thread colors matched our brand guide exactly, and they arrived 2 days ahead of schedule.', 'bearlane' ),
		'name'    => 'Marcus T.',
		'context' => __( 'Team of 50 · Company retreat order', 'bearlane' ),
		'rating'  => 5,
		'initials'=> 'MT',
	],
	[
		'quote'   => __( 'The stitch quality is genuinely impressive — way better than the screen prints we used to order. You can feel the difference. We\'ve made BearLane our go-to for all staff uniforms and branded apparel.', 'bearlane' ),
		'name'    => 'Jess R.',
		'context' => __( 'Repeat customer · Branded uniforms', 'bearlane' ),
		'rating'  => 5,
		'initials'=> 'JR',
	],
	[
		'quote'   => __( 'I uploaded my logo as a PNG and they sent a digital proof within 24 hours. The final shirts looked exactly like the proof. So easy, and my clients are constantly asking where I got them.', 'bearlane' ),
		'name'    => 'Priya L.',
		'context' => __( 'Individual order · Left chest logo', 'bearlane' ),
		'rating'  => 5,
		'initials'=> 'PL',
	],
	[
		'quote'   => __( 'Ordered custom shirts for our youth soccer league — 30 kids, different sizes, all with the club crest embroidered on the chest. Every piece was spot-on and the kids are obsessed with them.', 'bearlane' ),
		'name'    => 'Coach A. Williams',
		'context' => __( 'Club order · 30 units · Youth sizes', 'bearlane' ),
		'rating'  => 5,
		'initials'=> 'AW',
	],
];
?>

<section class="section testimonials-section" aria-label="<?php esc_attr_e( 'Customer Reviews', 'bearlane' ); ?>">
	<div class="container">

		<header class="section__header">
			<div class="section__eyebrow"><?php esc_html_e( 'Real Customers', 'bearlane' ); ?></div>
			<h2 class="section__title"><?php esc_html_e( 'Loved by Teams &amp; Individuals', 'bearlane' ); ?></h2>
			<p class="section__subtitle"><?php esc_html_e( 'From solo custom orders to 500-piece corporate runs — here\'s what our customers say.', 'bearlane' ); ?></p>
		</header>

		<div class="testimonials-grid">
			<?php foreach ( $testimonials as $t ) : ?>
			<blockquote class="testimonial-card">

				<div class="testimonial-card__stars" aria-label="<?php echo esc_attr( sprintf( __( 'Rating: %d out of 5', 'bearlane' ), $t['rating'] ) ); ?>">
					<?php for ( $i = 0; $i < 5; $i++ ) : ?>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
						fill="<?php echo $i < $t['rating'] ? 'currentColor' : 'none'; ?>"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						aria-hidden="true"
						class="star<?php echo $i < $t['rating'] ? ' star--filled' : ''; ?>">
						<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
					</svg>
					<?php endfor; ?>
				</div>

				<p class="testimonial-card__quote">&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</p>

				<footer class="testimonial-card__footer">
					<div class="testimonial-card__avatar" aria-hidden="true"><?php echo esc_html( $t['initials'] ); ?></div>
					<div class="testimonial-card__meta">
						<cite class="testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></cite>
						<span class="testimonial-card__context"><?php echo esc_html( $t['context'] ); ?></span>
					</div>
					<div class="testimonial-card__verified" aria-label="<?php esc_attr_e( 'Verified purchase', 'bearlane' ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
						<?php esc_html_e( 'Verified', 'bearlane' ); ?>
					</div>
				</footer>

			</blockquote>
			<?php endforeach; ?>
		</div>

		<div class="testimonials-cta">
			<p class="testimonials-cta__text">
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<?php esc_html_e( 'Rated 4.9 / 5 from 800+ verified orders', 'bearlane' ); ?>
			</p>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--outline">
				<?php esc_html_e( 'Start Your Custom Order', 'bearlane' ); ?>
			</a>
			<?php endif; ?>
		</div>

	</div>
</section>
