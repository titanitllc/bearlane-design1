<?php
/**
 * BearLane Design — Generic Page Template
 *
 * @package BearLane
 */

get_header();
?>

<main id="site-content" class="single-page">

	<?php if ( ! is_front_page() ) : ?>
	<div class="page-banner">
		<div class="container">
			<?php bearlane_breadcrumbs(); ?>
			<h1 class="page-banner__title"><?php the_title(); ?></h1>
		</div>
	</div>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/content', 'page' ); ?>

</main>

<?php get_footer(); ?>
