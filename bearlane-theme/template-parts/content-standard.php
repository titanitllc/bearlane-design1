<?php
/**
 * Template Part — Standard Post Content
 *
 * @package BearLane
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
	<a href="<?php the_permalink(); ?>" class="post-card__image-link" aria-label="<?php the_title_attribute(); ?>">
		<?php the_post_thumbnail( 'bearlane-wide', [ 'class' => 'post-card__image' ] ); ?>
	</a>
	<?php endif; ?>

	<div class="post-card__body">
		<h2 class="post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<p class="post-card__meta">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</p>
		<p class="post-card__excerpt"><?php the_excerpt(); ?></p>
		<a href="<?php the_permalink(); ?>" class="btn btn--outline"><?php esc_html_e( 'Read more', 'bearlane' ); ?></a>
	</div>

</article>
