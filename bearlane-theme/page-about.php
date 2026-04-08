<?php
/**
 * BearLane Design — About Page Template
 *
 * Template Name: About / Brand Story
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="about-page">

	<div class="page-banner">
		<div class="container">
			<?php bearlane_breadcrumbs(); ?>
			<h1 class="page-banner__title"><?php the_title(); ?></h1>
		</div>
	</div>

	<!-- Brand Story Hero -->
	<section class="about-hero section">
		<div class="container about-hero__container">
			<div class="about-hero__content">
				<?php the_content(); ?>
				<?php if ( ! get_the_content() ) : ?>
				<h2><?php esc_html_e( 'Our Story', 'bearlane' ); ?></h2>
				<p><?php esc_html_e( 'BearLane Design was founded with a simple belief: that great design should be accessible, beautiful, and built to last. We curate and create premium products that elevate everyday life.', 'bearlane' ); ?></p>
				<p><?php esc_html_e( 'Every product in our collection is chosen for its craftsmanship, aesthetic integrity, and purpose. We believe in doing fewer things, better.', 'bearlane' ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
			<div class="about-hero__image">
				<?php the_post_thumbnail( 'bearlane-wide', [ 'class' => 'about-hero__img' ] ); ?>
			</div>
			<?php endif; ?>
		</div>
	</section>

	<!-- Values Section -->
	<section class="section values-section">
		<div class="container">
			<header class="section__header">
				<h2 class="section__title"><?php esc_html_e( 'What We Stand For', 'bearlane' ); ?></h2>
			</header>
			<div class="values-grid">
				<?php
				$values = [
					[ __( 'Quality First', 'bearlane' ),      __( 'We never compromise on materials or craftsmanship. Every detail matters.', 'bearlane' ) ],
					[ __( 'Minimal by Design', 'bearlane' ),  __( 'Less clutter. More intention. Clean design that speaks for itself.', 'bearlane' ) ],
					[ __( 'Customer Centric', 'bearlane' ),   __( 'Your experience matters at every touchpoint — before and after purchase.', 'bearlane' ) ],
					[ __( 'Sustainability', 'bearlane' ),     __( 'Responsible sourcing and packaging are part of how we operate.', 'bearlane' ) ],
				];
				foreach ( $values as [ $title, $desc ] ) :
				?>
				<div class="value-card">
					<h3 class="value-card__title"><?php echo esc_html( $title ); ?></h3>
					<p class="value-card__desc"><?php echo esc_html( $desc ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section cta-section">
		<div class="container">
			<div class="cta-block">
				<h2 class="cta-block__title"><?php esc_html_e( 'Ready to explore?', 'bearlane' ); ?></h2>
				<p class="cta-block__desc"><?php esc_html_e( 'Browse our collection of premium products.', 'bearlane' ); ?></p>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary btn--large">
					<?php esc_html_e( 'Shop the Collection', 'bearlane' ); ?>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
