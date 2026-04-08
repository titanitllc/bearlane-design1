<?php
/**
 * Template Part — Homepage Testimonials
 *
 * @package BearLane
 */

$testimonials = [
	[
		'quote'  => __( 'Absolutely love the quality. Arrived fast and looks even better in person!', 'bearlane' ),
		'name'   => 'Sarah M.',
		'rating' => 5,
	],
	[
		'quote'  => __( 'BearLane is my go-to store. The aesthetic is exactly what I was looking for.', 'bearlane' ),
		'name'   => 'James K.',
		'rating' => 5,
	],
	[
		'quote'  => __( 'Fast shipping, beautiful packaging, and a perfect product. 10/10 would recommend.', 'bearlane' ),
		'name'   => 'Priya L.',
		'rating' => 5,
	],
];
?>

<section class="section testimonials-section" aria-label="<?php esc_attr_e( 'Customer Reviews', 'bearlane' ); ?>">
	<div class="container">

		<header class="section__header">
			<h2 class="section__title"><?php esc_html_e( 'What Our Customers Say', 'bearlane' ); ?></h2>
		</header>

		<div class="testimonials-grid">
			<?php foreach ( $testimonials as $t ) : ?>
			<blockquote class="testimonial-card">
				<div class="testimonial-card__stars" aria-label="<?php echo esc_attr( sprintf( __( 'Rating: %d out of 5', 'bearlane' ), $t['rating'] ) ); ?>">
					<?php for ( $i = 0; $i < 5; $i++ ) : ?>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $i < $t['rating'] ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="star<?php echo $i < $t['rating'] ? ' star--filled' : ''; ?>"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
					<?php endfor; ?>
				</div>
				<p class="testimonial-card__quote">&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</p>
				<footer class="testimonial-card__footer">
					<cite class="testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></cite>
				</footer>
			</blockquote>
			<?php endforeach; ?>
		</div>

	</div>
</section>
