<?php
/**
 * BearLane Design — Shop / Product Archive
 *
 * This template is used for the WooCommerce shop page and product category archives.
 * It wraps the WooCommerce loop in our design system.
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="woo-archive">

	<!-- Page Banner -->
	<div class="page-banner">
		<div class="container">
			<?php bearlane_breadcrumbs(); ?>
			<h1 class="page-banner__title">
				<?php
				if ( is_shop() ) :
					echo esc_html( get_the_title( wc_get_page_id( 'shop' ) ) );
				elseif ( is_product_category() ) :
					single_cat_title();
				elseif ( is_product_tag() ) :
					/* translators: %s: tag name */
					printf( esc_html__( 'Products tagged: %s', 'bearlane' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				else :
					the_archive_title();
				endif;
				?>
			</h1>
			<?php if ( is_product_category() ) : ?>
				<?php the_archive_description( '<p class="page-banner__desc">', '</p>' ); ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="container archive-layout">

		<!-- Sidebar / Filters -->
		<aside class="archive-sidebar" aria-label="<?php esc_attr_e( 'Shop filters', 'bearlane' ); ?>">

			<!-- Filter toggle (mobile) -->
			<button class="archive-sidebar__toggle js-filter-toggle" aria-expanded="false" aria-controls="filter-panel">
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
				<?php esc_html_e( 'Filters', 'bearlane' ); ?>
			</button>

			<div id="filter-panel" class="archive-sidebar__panel">
				<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
					<?php dynamic_sidebar( 'shop-sidebar' ); ?>
				<?php else : ?>
					<!-- Default WC filter widgets if sidebar is empty -->
					<?php
					if ( function_exists( 'wc_get_template' ) ) {
						// Show category list.
						the_widget(
							'WC_Widget_Product_Categories',
							[ 'title' => __( 'Categories', 'bearlane' ) ],
							[ 'before_widget' => '<div class="widget">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget__title">', 'after_title' => '</h3>' ]
						);
					}
					?>
				<?php endif; ?>
			</div>

		</aside><!-- .archive-sidebar -->

		<!-- Product Loop -->
		<div class="archive-main">

			<!-- Sort / Results Bar -->
			<div class="archive-toolbar">
				<?php woocommerce_result_count(); ?>
				<div class="archive-toolbar__right">
					<?php woocommerce_catalog_ordering(); ?>
					<div class="view-toggle" aria-label="<?php esc_attr_e( 'Toggle grid layout', 'bearlane' ); ?>">
						<button class="view-toggle__btn js-view-grid is-active" data-view="grid" aria-label="<?php esc_attr_e( 'Grid view', 'bearlane' ); ?>" aria-pressed="true">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
						</button>
						<button class="view-toggle__btn js-view-list" data-view="list" aria-label="<?php esc_attr_e( 'List view', 'bearlane' ); ?>" aria-pressed="false">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
						</button>
					</div>
				</div>
			</div>

			<!-- AJAX Product Container -->
			<div id="products-container" class="products-ajax-wrapper">
				<?php woocommerce_product_loop_start(); ?>
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						wc_get_template_part( 'content', 'product' );
					endwhile;
				else :
					do_action( 'woocommerce_no_products_found' );
				endif;
				?>
				<?php woocommerce_product_loop_end(); ?>
			</div>

			<?php
			woocommerce_pagination();
			?>

		</div><!-- .archive-main -->

	</div><!-- .container.archive-layout -->

</main>

<?php get_footer(); ?>
