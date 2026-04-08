<?php
/**
 * Template Part — Homepage Category Showcase
 *
 * Displays top-level product categories in a clean grid.
 *
 * @package BearLane
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$categories = get_terms( [
	'taxonomy'   => 'product_cat',
	'orderby'    => 'count',
	'order'      => 'DESC',
	'number'     => 6,
	'hide_empty' => true,
	'parent'     => 0,
	'exclude'    => [ get_option( 'default_product_cat', 0 ) ],
] );

if ( is_wp_error( $categories ) || empty( $categories ) ) {
	return;
}
?>

<section class="section categories-section" aria-label="<?php esc_attr_e( 'Shop by Category', 'bearlane' ); ?>">
	<div class="container">

		<header class="section__header">
			<h2 class="section__title"><?php esc_html_e( 'Shop by Category', 'bearlane' ); ?></h2>
			<p class="section__subtitle"><?php esc_html_e( 'Explore our curated collections.', 'bearlane' ); ?></p>
		</header>

		<div class="category-grid">
			<?php foreach ( $categories as $category ) : ?>
			<?php
			$thumbnail_id  = get_term_meta( $category->term_id, 'thumbnail_id', true );
			$thumbnail_url = $thumbnail_id
				? wp_get_attachment_image_url( $thumbnail_id, 'bearlane-card' )
				: wc_placeholder_img_src( 'bearlane-card' );
			$category_url  = get_term_link( $category );
			?>
			<a href="<?php echo esc_url( $category_url ); ?>" class="category-card">
				<div class="category-card__image-wrap">
					<img src="<?php echo esc_url( $thumbnail_url ); ?>"
						alt="<?php echo esc_attr( $category->name ); ?>"
						class="category-card__image"
						loading="lazy"
						width="600"
						height="600">
				</div>
				<div class="category-card__body">
					<h3 class="category-card__title"><?php echo esc_html( $category->name ); ?></h3>
					<span class="category-card__count">
						<?php
						echo esc_html( sprintf(
							/* translators: %d: product count */
							_n( '%d product', '%d products', $category->count, 'bearlane' ),
							$category->count
						) );
						?>
					</span>
				</div>
				<span class="category-card__arrow" aria-hidden="true">→</span>
			</a>
			<?php endforeach; ?>
		</div><!-- .category-grid -->

	</div><!-- .container -->
</section>
