<?php
/**
 * Template Part — Generic Page Content
 *
 * @package BearLane
 */

while ( have_posts() ) :
	the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="page-content__hero-image">
		<?php the_post_thumbnail( 'bearlane-wide', [ 'class' => 'page-content__featured-image' ] ); ?>
	</div>
	<?php endif; ?>

	<div class="container">
		<div class="page-content__inner">
			<h1 class="page-content__title"><?php the_title(); ?></h1>
			<div class="page-content__body">
				<?php
				the_content();
				wp_link_pages( [
					'before' => '<div class="page-links">' . __( 'Pages:', 'bearlane' ),
					'after'  => '</div>',
				] );
				?>
			</div>
		</div>
	</div>

</article>

<?php
endwhile;
