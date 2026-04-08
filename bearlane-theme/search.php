<?php
/**
 * BearLane Design — Search Results Template
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="search-results-page">

	<div class="page-banner">
		<div class="container">
			<?php bearlane_breadcrumbs(); ?>
			<h1 class="page-banner__title">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search results for: %s', 'bearlane' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
		</div>
	</div>

	<div class="container">
		<?php if ( have_posts() ) : ?>

		<div class="post-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" class="post-card__image-link">
						<?php the_post_thumbnail( 'bearlane-card', [ 'class' => 'post-card__image' ] ); ?>
					</a>
					<?php endif; ?>
					<div class="post-card__body">
						<h2 class="post-card__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<p class="post-card__excerpt"><?php the_excerpt(); ?></p>
						<a href="<?php the_permalink(); ?>" class="btn btn--outline"><?php esc_html_e( 'Read more', 'bearlane' ); ?></a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<?php
		the_posts_pagination( [
			'prev_text' => '&larr; ' . __( 'Older', 'bearlane' ),
			'next_text' => __( 'Newer', 'bearlane' ) . ' &rarr;',
			'class'     => 'pagination',
		] );
		?>

		<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>

</main>

<?php get_footer(); ?>
