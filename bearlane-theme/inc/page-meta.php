<?php
/**
 * BearLane Design — Per-Page Meta (Hero Banner + Layout)
 *
 * Adds a "BearLane Page Options" meta box to every Page in wp-admin.
 * Controls:
 *   - Banner style: default banner / full-width hero / hidden
 *   - Banner title override
 *   - Banner subtitle
 *   - Banner image (overrides the post's featured image for the banner)
 *   - Layout: full width / contained / contained with sidebar
 *
 * This is the non-homepage counterpart to Phase 1's section registry:
 * editors control subpage layout entirely from the page editor without
 * touching templates or code.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =============================================================
 * META KEYS (kept as constants for easy reuse in templates)
 * ============================================================= */

const BEARLANE_PAGE_META_BANNER_STYLE = '_bearlane_banner_style';
const BEARLANE_PAGE_META_BANNER_TITLE = '_bearlane_banner_title';
const BEARLANE_PAGE_META_BANNER_SUB   = '_bearlane_banner_subtitle';
const BEARLANE_PAGE_META_BANNER_IMAGE = '_bearlane_banner_image';
const BEARLANE_PAGE_META_LAYOUT       = '_bearlane_layout';

/* =============================================================
 * REGISTER META BOX
 * ============================================================= */

function bearlane_page_meta_add_box(): void {
	add_meta_box(
		'bearlane-page-options',
		__( 'BearLane Page Options', 'bearlane' ),
		'bearlane_page_meta_render_box',
		'page',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'bearlane_page_meta_add_box' );

/* =============================================================
 * META BOX UI
 * ============================================================= */

function bearlane_page_meta_render_box( \WP_Post $post ): void {
	wp_nonce_field( 'bearlane_page_meta_save', 'bearlane_page_meta_nonce' );

	$banner_style = get_post_meta( $post->ID, BEARLANE_PAGE_META_BANNER_STYLE, true ) ?: 'default';
	$banner_title = get_post_meta( $post->ID, BEARLANE_PAGE_META_BANNER_TITLE, true );
	$banner_sub   = get_post_meta( $post->ID, BEARLANE_PAGE_META_BANNER_SUB,   true );
	$banner_image = (int) get_post_meta( $post->ID, BEARLANE_PAGE_META_BANNER_IMAGE, true );
	$layout       = get_post_meta( $post->ID, BEARLANE_PAGE_META_LAYOUT, true ) ?: 'contained';

	$banner_image_url = $banner_image ? wp_get_attachment_image_url( $banner_image, 'medium' ) : '';
	?>
	<p>
		<label for="bearlane-banner-style"><strong><?php esc_html_e( 'Banner Style', 'bearlane' ); ?></strong></label><br>
		<select id="bearlane-banner-style" name="bearlane_banner_style" class="widefat">
			<option value="default"   <?php selected( $banner_style, 'default' ); ?>><?php esc_html_e( 'Default banner', 'bearlane' ); ?></option>
			<option value="hero"      <?php selected( $banner_style, 'hero' ); ?>><?php esc_html_e( 'Full-width hero banner', 'bearlane' ); ?></option>
			<option value="hidden"    <?php selected( $banner_style, 'hidden' ); ?>><?php esc_html_e( 'No banner', 'bearlane' ); ?></option>
		</select>
	</p>

	<p>
		<label for="bearlane-banner-title"><strong><?php esc_html_e( 'Banner Title', 'bearlane' ); ?></strong></label><br>
		<input type="text" id="bearlane-banner-title" name="bearlane_banner_title" value="<?php echo esc_attr( (string) $banner_title ); ?>" class="widefat" placeholder="<?php echo esc_attr( get_the_title( $post ) ); ?>">
		<span class="description"><?php esc_html_e( 'Leave blank to use the page title.', 'bearlane' ); ?></span>
	</p>

	<p>
		<label for="bearlane-banner-sub"><strong><?php esc_html_e( 'Banner Subtitle', 'bearlane' ); ?></strong></label><br>
		<textarea id="bearlane-banner-sub" name="bearlane_banner_subtitle" rows="2" class="widefat"><?php echo esc_textarea( (string) $banner_sub ); ?></textarea>
	</p>

	<p>
		<strong><?php esc_html_e( 'Banner Image', 'bearlane' ); ?></strong><br>
		<span class="description"><?php esc_html_e( 'Optional. Overrides the featured image for the banner only.', 'bearlane' ); ?></span>
	</p>
	<div class="bearlane-page-meta-image">
		<div class="bearlane-page-meta-image__preview">
			<?php if ( $banner_image_url ) : ?>
				<img src="<?php echo esc_url( $banner_image_url ); ?>" alt="" style="max-width:100%;height:auto;display:block;">
			<?php endif; ?>
		</div>
		<input type="hidden" id="bearlane-banner-image" name="bearlane_banner_image" value="<?php echo esc_attr( (string) $banner_image ); ?>">
		<p>
			<button type="button" class="button bearlane-page-meta-image__choose"><?php esc_html_e( 'Choose image', 'bearlane' ); ?></button>
			<button type="button" class="button-link bearlane-page-meta-image__remove"<?php echo $banner_image ? '' : ' style="display:none;"'; ?>><?php esc_html_e( 'Remove', 'bearlane' ); ?></button>
		</p>
	</div>

	<hr>

	<p>
		<label for="bearlane-layout"><strong><?php esc_html_e( 'Layout', 'bearlane' ); ?></strong></label><br>
		<select id="bearlane-layout" name="bearlane_layout" class="widefat">
			<option value="contained"         <?php selected( $layout, 'contained' ); ?>><?php esc_html_e( 'Contained (default)', 'bearlane' ); ?></option>
			<option value="contained-sidebar" <?php selected( $layout, 'contained-sidebar' ); ?>><?php esc_html_e( 'Contained with sidebar', 'bearlane' ); ?></option>
			<option value="full-width"        <?php selected( $layout, 'full-width' ); ?>><?php esc_html_e( 'Full width', 'bearlane' ); ?></option>
		</select>
	</p>

	<script>
	( function () {
		if ( typeof wp === 'undefined' || ! wp.media ) return;
		var $ = jQuery;
		var frame;
		$( document ).on( 'click', '.bearlane-page-meta-image__choose', function ( e ) {
			e.preventDefault();
			frame = wp.media( { title: '<?php echo esc_js( __( 'Choose banner image', 'bearlane' ) ); ?>', multiple: false, library: { type: 'image' } } );
			frame.on( 'select', function () {
				var att = frame.state().get( 'selection' ).first().toJSON();
				$( '#bearlane-banner-image' ).val( att.id );
				var url = ( att.sizes && att.sizes.medium ) ? att.sizes.medium.url : att.url;
				$( '.bearlane-page-meta-image__preview' ).html( '<img src="' + url + '" alt="" style="max-width:100%;height:auto;display:block;">' );
				$( '.bearlane-page-meta-image__remove' ).show();
			} );
			frame.open();
		} );
		$( document ).on( 'click', '.bearlane-page-meta-image__remove', function ( e ) {
			e.preventDefault();
			$( '#bearlane-banner-image' ).val( '' );
			$( '.bearlane-page-meta-image__preview' ).empty();
			$( this ).hide();
		} );
	} )();
	</script>
	<?php
}

/* =============================================================
 * SAVE HANDLER
 * ============================================================= */

function bearlane_page_meta_save( int $post_id ): void {
	if ( ! isset( $_POST['bearlane_page_meta_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bearlane_page_meta_nonce'] ) ), 'bearlane_page_meta_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'page' !== get_post_type( $post_id ) ) {
		return;
	}

	// Banner style.
	$style = isset( $_POST['bearlane_banner_style'] ) ? sanitize_key( (string) $_POST['bearlane_banner_style'] ) : 'default';
	if ( ! in_array( $style, [ 'default', 'hero', 'hidden' ], true ) ) {
		$style = 'default';
	}
	update_post_meta( $post_id, BEARLANE_PAGE_META_BANNER_STYLE, $style );

	// Title.
	$title = isset( $_POST['bearlane_banner_title'] ) ? sanitize_text_field( wp_unslash( (string) $_POST['bearlane_banner_title'] ) ) : '';
	update_post_meta( $post_id, BEARLANE_PAGE_META_BANNER_TITLE, $title );

	// Subtitle.
	$sub = isset( $_POST['bearlane_banner_subtitle'] ) ? sanitize_textarea_field( wp_unslash( (string) $_POST['bearlane_banner_subtitle'] ) ) : '';
	update_post_meta( $post_id, BEARLANE_PAGE_META_BANNER_SUB, $sub );

	// Image.
	$img = isset( $_POST['bearlane_banner_image'] ) ? (int) $_POST['bearlane_banner_image'] : 0;
	update_post_meta( $post_id, BEARLANE_PAGE_META_BANNER_IMAGE, $img );

	// Layout.
	$layout = isset( $_POST['bearlane_layout'] ) ? sanitize_key( (string) $_POST['bearlane_layout'] ) : 'contained';
	if ( ! in_array( $layout, [ 'contained', 'contained-sidebar', 'full-width' ], true ) ) {
		$layout = 'contained';
	}
	update_post_meta( $post_id, BEARLANE_PAGE_META_LAYOUT, $layout );
}
add_action( 'save_post_page', 'bearlane_page_meta_save' );

/* =============================================================
 * RENDERING HELPERS
 * ============================================================= */

/**
 * Get the effective banner settings for a given page ID.
 *
 * @param int $post_id
 * @return array{style:string,title:string,subtitle:string,image_url:string,layout:string}
 */
function bearlane_page_banner_data( int $post_id ): array {
	$style    = get_post_meta( $post_id, BEARLANE_PAGE_META_BANNER_STYLE, true ) ?: 'default';
	$title    = get_post_meta( $post_id, BEARLANE_PAGE_META_BANNER_TITLE, true );
	$subtitle = get_post_meta( $post_id, BEARLANE_PAGE_META_BANNER_SUB,   true );
	$image_id = (int) get_post_meta( $post_id, BEARLANE_PAGE_META_BANNER_IMAGE, true );
	$layout   = get_post_meta( $post_id, BEARLANE_PAGE_META_LAYOUT, true ) ?: 'contained';

	// Fall back to the post's featured image if no dedicated banner image.
	if ( ! $image_id ) {
		$image_id = (int) get_post_thumbnail_id( $post_id );
	}
	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'bearlane-hero' ) : '';

	return [
		'style'     => (string) $style,
		'title'     => $title ?: get_the_title( $post_id ),
		'subtitle'  => (string) $subtitle,
		'image_url' => (string) $image_url,
		'layout'    => (string) $layout,
	];
}

/**
 * Render the banner for the current page (used by page.php).
 */
function bearlane_render_page_banner( int $post_id ): void {
	$data = bearlane_page_banner_data( $post_id );
	if ( 'hidden' === $data['style'] ) {
		return;
	}

	if ( 'hero' === $data['style'] && $data['image_url'] ) :
		?>
		<div class="page-hero" style="--page-hero-image: url('<?php echo esc_url( $data['image_url'] ); ?>')">
			<div class="page-hero__backdrop" aria-hidden="true"></div>
			<div class="container page-hero__inner">
				<?php bearlane_breadcrumbs(); ?>
				<h1 class="page-hero__title"><?php echo esc_html( $data['title'] ); ?></h1>
				<?php if ( $data['subtitle'] ) : ?>
				<p class="page-hero__subtitle"><?php echo esc_html( $data['subtitle'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
		return;
	endif;

	// Default banner.
	?>
	<div class="page-banner">
		<div class="container">
			<?php bearlane_breadcrumbs(); ?>
			<h1 class="page-banner__title"><?php echo esc_html( $data['title'] ); ?></h1>
			<?php if ( $data['subtitle'] ) : ?>
			<p class="page-banner__subtitle"><?php echo esc_html( $data['subtitle'] ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Return the layout class for the current page wrapper.
 */
function bearlane_page_layout_class( int $post_id ): string {
	$layout = get_post_meta( $post_id, BEARLANE_PAGE_META_LAYOUT, true ) ?: 'contained';
	return 'single-page single-page--' . sanitize_html_class( $layout );
}
