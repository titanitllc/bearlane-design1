<?php
/**
 * BearLane Design — Theme Setup
 *
 * Registers theme supports, nav menus, and widget areas.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup hook — runs after WordPress initialises the theme.
 */
function bearlane_theme_setup(): void {

	// Make theme available for translation.
	load_theme_textdomain( 'bearlane', BEARLANE_DIR . '/languages' );

	// Let WordPress manage the <title> tag.
	add_theme_support( 'title-tag' );

	// Enable post thumbnails / featured images.
	add_theme_support( 'post-thumbnails' );

	// Register custom image sizes.
	add_image_size( 'bearlane-hero',    1920, 800, true );
	add_image_size( 'bearlane-card',    600,  600, true );
	add_image_size( 'bearlane-thumb',   300,  300, true );
	add_image_size( 'bearlane-wide',    1200, 600, true );

	// Switch default core markup to valid HTML5.
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	] );

	// RSS feed links in <head>.
	add_theme_support( 'automatic-feed-links' );

	// Selective refresh for Customizer widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Custom logo.
	add_theme_support( 'custom-logo', [
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => [ 'site-title', 'site-description' ],
	] );

	// Custom background.
	add_theme_support( 'custom-background' );

	// WooCommerce support.
	add_theme_support( 'woocommerce', [
		'thumbnail_image_width' => 600,
		'single_image_width'    => 900,
		'product_grid'          => [
			'default_rows'    => 3,
			'min_rows'        => 1,
			'max_rows'        => 10,
			'default_columns' => 3,
			'min_columns'     => 2,
			'max_columns'     => 4,
		],
	] );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Register navigation menus.
	register_nav_menus( [
		'primary'   => __( 'Primary Navigation', 'bearlane' ),
		'footer-1'  => __( 'Footer Column 1', 'bearlane' ),
		'footer-2'  => __( 'Footer Column 2', 'bearlane' ),
		'footer-3'  => __( 'Footer Column 3', 'bearlane' ),
	] );

	// Core block patterns / styles opt-out (we ship our own).
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'bearlane_theme_setup' );

/**
 * Register widget areas (sidebars).
 */
function bearlane_register_sidebars(): void {

	$shared_args = [
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget__title">',
		'after_title'   => '</h3>',
	];

	register_sidebar( array_merge( $shared_args, [
		'name'        => __( 'Shop Sidebar', 'bearlane' ),
		'id'          => 'shop-sidebar',
		'description' => __( 'Widgets displayed on shop / category pages.', 'bearlane' ),
	] ) );

	register_sidebar( array_merge( $shared_args, [
		'name'        => __( 'Blog Sidebar', 'bearlane' ),
		'id'          => 'blog-sidebar',
		'description' => __( 'Widgets displayed on blog and single post pages.', 'bearlane' ),
	] ) );

	register_sidebar( array_merge( $shared_args, [
		'name'        => __( 'Footer Widget Area', 'bearlane' ),
		'id'          => 'footer-widgets',
		'description' => __( 'Widgets displayed in the site footer.', 'bearlane' ),
	] ) );
}
add_action( 'widgets_init', 'bearlane_register_sidebars' );

/**
 * Set the content width in pixels, fallback for embeds / oEmbeds.
 */
function bearlane_content_width(): void {
	$GLOBALS['content_width'] = apply_filters( 'bearlane_content_width', 1200 );
}
add_action( 'after_setup_theme', 'bearlane_content_width', 0 );

/**
 * Add schema.org Organisation markup to the <head>.
 */
function bearlane_schema_org(): void {
	$schema = [
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
		'logo'     => [
			'@type' => 'ImageObject',
			'url'   => ( has_custom_logo() )
				? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' )
				: '',
		],
	];
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bearlane_schema_org' );

/**
 * Output Open Graph meta tags for better social sharing.
 */
function bearlane_open_graph(): void {
	if ( is_singular() ) {
		global $post;
		$description = has_excerpt( $post )
			? get_the_excerpt( $post )
			: wp_trim_words( get_the_content( null, false, $post ), 30 );
		$image_url   = get_the_post_thumbnail_url( $post, 'large' ) ?: '';
	} else {
		$description = get_bloginfo( 'description' );
		$image_url   = '';
	}
	?>
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
	<meta property="og:type"      content="website" />
	<meta property="og:title"     content="<?php echo esc_attr( wp_get_document_title() ); ?>" />
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>" />
	<?php if ( $image_url ) : ?>
	<meta property="og:image"     content="<?php echo esc_url( $image_url ); ?>" />
	<?php endif; ?>
	<?php
}
add_action( 'wp_head', 'bearlane_open_graph' );
