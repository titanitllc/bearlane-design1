<?php
/**
 * Template Part — Content None
 *
 * Shown when no posts are found.
 *
 * @package BearLane
 */
?>

<section class="content-none">
	<div class="container">
		<div class="content-none__inner">
			<div class="content-none__icon" aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			</div>
			<?php if ( is_search() ) : ?>
				<h2 class="content-none__title">
					<?php
					printf(
						/* translators: %s: search query */
						esc_html__( 'No results for &ldquo;%s&rdquo;', 'bearlane' ),
						'<span>' . esc_html( get_search_query() ) . '</span>'
					);
					?>
				</h2>
				<p class="content-none__desc"><?php esc_html_e( 'Try different keywords or browse the shop.', 'bearlane' ); ?></p>
				<?php get_search_form(); ?>
			<?php else : ?>
				<h2 class="content-none__title"><?php esc_html_e( 'Nothing found', 'bearlane' ); ?></h2>
				<p class="content-none__desc"><?php esc_html_e( 'It looks like nothing was found at this location.', 'bearlane' ); ?></p>
			<?php endif; ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Back to Home', 'bearlane' ); ?></a>
		</div>
	</div>
</section>
