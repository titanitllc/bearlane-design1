<?php
/**
 * BearLane Design — Homepage Sections Admin UI
 *
 * Provides "Appearance → Homepage Sections" — a single-page interface
 * where non-technical users can drag-reorder, enable/disable, and edit
 * every homepage section registered via inc/sections.php.
 *
 * Intentionally zero-dependency: uses only WordPress core, jQuery,
 * jQuery UI Sortable (both bundled), and the media uploader. No
 * external JS libraries, no build step.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =============================================================
 * MENU + ASSETS
 * ============================================================= */

/**
 * Register the top-level admin page under Appearance.
 */
function bearlane_sections_admin_menu(): void {
	add_theme_page(
		__( 'Homepage Sections', 'bearlane' ),
		__( 'Homepage Sections', 'bearlane' ),
		'edit_theme_options',
		'bearlane-sections',
		'bearlane_sections_admin_render'
	);
}
add_action( 'admin_menu', 'bearlane_sections_admin_menu' );

/**
 * Enqueue admin assets for the Homepage Sections page only.
 *
 * @param string $hook Current admin page hook.
 */
function bearlane_sections_admin_enqueue( string $hook ): void {
	if ( 'appearance_page_bearlane-sections' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-sortable' );

	wp_enqueue_style(
		'bearlane-sections-admin',
		BEARLANE_URI . '/assets/css/admin-sections.css',
		[],
		BEARLANE_VERSION
	);

	wp_enqueue_script(
		'bearlane-sections-admin',
		BEARLANE_URI . '/assets/js/admin-sections.js',
		[ 'jquery', 'jquery-ui-sortable' ],
		BEARLANE_VERSION,
		true
	);

	wp_localize_script( 'bearlane-sections-admin', 'bearlaneSectionsAdmin', [
		'i18n' => [
			'chooseImage' => __( 'Choose image', 'bearlane' ),
			'useImage'    => __( 'Use this image', 'bearlane' ),
			'remove'      => __( 'Remove', 'bearlane' ),
			'confirmDelete' => __( 'Remove this item?', 'bearlane' ),
		],
	] );
}
add_action( 'admin_enqueue_scripts', 'bearlane_sections_admin_enqueue' );

/* =============================================================
 * SAVE HANDLER
 * ============================================================= */

/**
 * Handle form submission before the page renders.
 * Uses admin-post.php pattern via a manual check for POST data on
 * the page hook so we get classic admin notices and redirects.
 */
function bearlane_sections_admin_handle_save(): void {
	if ( ! isset( $_POST['bearlane_sections_save'] ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to edit theme options.', 'bearlane' ) );
	}
	check_admin_referer( 'bearlane_sections_save', 'bearlane_sections_nonce' );

	$raw   = isset( $_POST['bearlane_sections'] ) ? wp_unslash( $_POST['bearlane_sections'] ) : []; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$clean = bearlane_sanitize_sections_option( $raw );

	update_option( BEARLANE_SECTIONS_OPTION, $clean, false );

	add_settings_error(
		'bearlane_sections',
		'bearlane_sections_saved',
		__( 'Homepage sections updated.', 'bearlane' ),
		'updated'
	);
}
add_action( 'load-appearance_page_bearlane-sections', 'bearlane_sections_admin_handle_save' );

/* =============================================================
 * PAGE RENDERER
 * ============================================================= */

/**
 * Render the admin page.
 */
function bearlane_sections_admin_render(): void {
	$registry = bearlane_sections_registry();
	$data     = bearlane_sections_data();
	?>
	<div class="wrap bearlane-sections-admin">
		<h1><?php esc_html_e( 'Homepage Sections', 'bearlane' ); ?></h1>

		<p class="description">
			<?php esc_html_e( 'Drag sections to reorder them on the homepage. Toggle any section off to hide it. Click a section to expand and edit its content.', 'bearlane' ); ?>
		</p>

		<?php settings_errors( 'bearlane_sections' ); ?>

		<form method="post" action="" enctype="multipart/form-data" class="bearlane-sections-form">
			<?php wp_nonce_field( 'bearlane_sections_save', 'bearlane_sections_nonce' ); ?>

			<div class="bearlane-sections-toolbar">
				<button type="submit" name="bearlane_sections_save" class="button button-primary button-large">
					<?php esc_html_e( 'Save All Sections', 'bearlane' ); ?>
				</button>
				<span class="bearlane-sections-toolbar__hint">
					<?php esc_html_e( 'Tip: changes are only saved when you click "Save All Sections".', 'bearlane' ); ?>
				</span>
			</div>

			<ul class="bearlane-sections-list" id="bearlane-sections-list">
				<?php foreach ( $data['order'] as $section_id ) : ?>
					<?php if ( ! isset( $registry[ $section_id ] ) ) { continue; } ?>
					<?php bearlane_sections_admin_render_section_row( $section_id, $registry[ $section_id ], $data ); ?>
				<?php endforeach; ?>
			</ul>

			<div class="bearlane-sections-toolbar bearlane-sections-toolbar--bottom">
				<button type="submit" name="bearlane_sections_save" class="button button-primary button-large">
					<?php esc_html_e( 'Save All Sections', 'bearlane' ); ?>
				</button>
			</div>
		</form>
	</div>
	<?php
}

/**
 * Render one section row in the sortable list.
 *
 * @param string $section_id Section ID.
 * @param array  $schema     Section schema from registry.
 * @param array  $data       Full sections data.
 */
function bearlane_sections_admin_render_section_row( string $section_id, array $schema, array $data ): void {
	$is_enabled = ! empty( $data['enabled'][ $section_id ] );
	$content    = $data['content'][ $section_id ] ?? [];
	$icon       = $schema['icon'] ?? 'dashicons-admin-generic';
	?>
	<li class="bearlane-section-row" data-section-id="<?php echo esc_attr( $section_id ); ?>">

		<input type="hidden" name="bearlane_sections[order][]" value="<?php echo esc_attr( $section_id ); ?>" class="bearlane-section-order">

		<header class="bearlane-section-row__header">

			<span class="bearlane-section-row__handle" aria-label="<?php esc_attr_e( 'Drag to reorder', 'bearlane' ); ?>">
				<span class="dashicons dashicons-menu"></span>
			</span>

			<span class="bearlane-section-row__icon">
				<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>
			</span>

			<div class="bearlane-section-row__titles">
				<h2 class="bearlane-section-row__title"><?php echo esc_html( $schema['label'] ); ?></h2>
				<?php if ( ! empty( $schema['description'] ) ) : ?>
				<p class="bearlane-section-row__desc"><?php echo esc_html( $schema['description'] ); ?></p>
				<?php endif; ?>
			</div>

			<label class="bearlane-section-row__toggle">
				<input type="hidden"    name="bearlane_sections[enabled][<?php echo esc_attr( $section_id ); ?>]" value="0">
				<input type="checkbox"  name="bearlane_sections[enabled][<?php echo esc_attr( $section_id ); ?>]" value="1" <?php checked( $is_enabled ); ?>>
				<span class="bearlane-section-row__toggle-label"><?php esc_html_e( 'Show on homepage', 'bearlane' ); ?></span>
			</label>

			<button type="button" class="button bearlane-section-row__expand" aria-expanded="false">
				<?php esc_html_e( 'Edit', 'bearlane' ); ?>
				<span class="dashicons dashicons-arrow-down-alt2"></span>
			</button>
		</header>

		<div class="bearlane-section-row__body" hidden>
			<?php foreach ( (array) $schema['fields'] as $field_id => $field ) : ?>
				<?php
				$value = $content[ $field_id ] ?? ( $field['default'] ?? '' );
				$name  = "bearlane_sections[content][{$section_id}][{$field_id}]";
				bearlane_sections_admin_render_field( $name, $field, $value );
				?>
			<?php endforeach; ?>
		</div>

	</li>
	<?php
}

/* =============================================================
 * FIELD RENDERERS
 * ============================================================= */

/**
 * Render a single field row.
 *
 * @param string $name  HTML input name attribute.
 * @param array  $field Field schema entry.
 * @param mixed  $value Current value.
 */
function bearlane_sections_admin_render_field( string $name, array $field, $value ): void {
	$type   = $field['type'] ?? 'text';
	$label  = $field['label'] ?? '';
	$help   = $field['help'] ?? '';
	$fid    = 'f_' . md5( $name );

	echo '<div class="bearlane-field bearlane-field--' . esc_attr( $type ) . '">';

	if ( 'checkbox' !== $type ) {
		echo '<label class="bearlane-field__label" for="' . esc_attr( $fid ) . '">' . esc_html( $label ) . '</label>';
	}

	switch ( $type ) {

		case 'text':
		case 'url':
			printf(
				'<input type="%s" id="%s" name="%s" value="%s" class="regular-text bearlane-field__input">',
				'url' === $type ? 'url' : 'text',
				esc_attr( $fid ),
				esc_attr( $name ),
				esc_attr( (string) $value )
			);
			break;

		case 'number':
			printf(
				'<input type="number" id="%s" name="%s" value="%s" class="small-text bearlane-field__input">',
				esc_attr( $fid ),
				esc_attr( $name ),
				esc_attr( (string) $value )
			);
			break;

		case 'textarea':
			printf(
				'<textarea id="%s" name="%s" rows="3" class="large-text bearlane-field__input">%s</textarea>',
				esc_attr( $fid ),
				esc_attr( $name ),
				esc_textarea( (string) $value )
			);
			break;

		case 'richtext':
			printf(
				'<textarea id="%s" name="%s" rows="4" class="large-text bearlane-field__input">%s</textarea>',
				esc_attr( $fid ),
				esc_attr( $name ),
				esc_textarea( (string) $value )
			);
			echo '<p class="bearlane-field__hint">' . esc_html__( 'Basic HTML allowed (e.g. <br>, <strong>, <em>).', 'bearlane' ) . '</p>';
			break;

		case 'select':
			echo '<select id="' . esc_attr( $fid ) . '" name="' . esc_attr( $name ) . '" class="bearlane-field__input">';
			foreach ( (array) ( $field['options'] ?? [] ) as $opt_value => $opt_label ) {
				printf(
					'<option value="%s" %s>%s</option>',
					esc_attr( (string) $opt_value ),
					selected( (string) $value, (string) $opt_value, false ),
					esc_html( (string) $opt_label )
				);
			}
			echo '</select>';
			break;

		case 'checkbox':
			echo '<label class="bearlane-field__checkbox-label">';
			printf(
				'<input type="hidden" name="%s" value="0">',
				esc_attr( $name )
			);
			printf(
				'<input type="checkbox" id="%s" name="%s" value="1" %s>',
				esc_attr( $fid ),
				esc_attr( $name ),
				checked( (bool) $value, true, false )
			);
			echo ' ' . esc_html( $label );
			echo '</label>';
			break;

		case 'color':
			printf(
				'<input type="text" id="%s" name="%s" value="%s" class="bearlane-field__input regular-text" placeholder="#000000">',
				esc_attr( $fid ),
				esc_attr( $name ),
				esc_attr( (string) $value )
			);
			break;

		case 'image':
			bearlane_sections_admin_render_image_field( $name, (int) $value, $fid );
			break;

		case 'svg':
			printf(
				'<textarea id="%s" name="%s" rows="3" class="code bearlane-field__input bearlane-field__svg">%s</textarea>',
				esc_attr( $fid ),
				esc_attr( $name ),
				esc_textarea( (string) $value )
			);
			echo '<div class="bearlane-field__svg-preview" aria-hidden="true">' . bearlane_sanitize_inline_svg( (string) $value ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<p class="bearlane-field__hint">' . esc_html__( 'Paste an inline SVG. Only svg/path/rect/circle/line/polyline/polygon/g tags are allowed.', 'bearlane' ) . '</p>';
			break;

		case 'product_ids':
			bearlane_sections_admin_render_product_field( $name, (array) $value, $fid );
			break;

		case 'category_ids':
			bearlane_sections_admin_render_category_field( $name, (array) $value, $fid );
			break;

		case 'repeater':
			bearlane_sections_admin_render_repeater( $name, $field, (array) $value );
			break;

		default:
			printf(
				'<input type="text" id="%s" name="%s" value="%s" class="regular-text">',
				esc_attr( $fid ),
				esc_attr( $name ),
				esc_attr( (string) $value )
			);
	}

	if ( $help ) {
		echo '<p class="bearlane-field__help description">' . esc_html( $help ) . '</p>';
	}

	echo '</div>';
}

/**
 * Image picker — hidden attachment ID input + WP media modal trigger.
 *
 * @param string $name     Input name.
 * @param int    $value    Attachment ID.
 * @param string $field_id DOM id.
 */
function bearlane_sections_admin_render_image_field( string $name, int $value, string $field_id ): void {
	$preview_url = $value ? wp_get_attachment_image_url( $value, 'medium' ) : '';
	?>
	<div class="bearlane-image-field" data-field>
		<div class="bearlane-image-field__preview">
			<?php if ( $preview_url ) : ?>
				<img src="<?php echo esc_url( $preview_url ); ?>" alt="">
			<?php endif; ?>
		</div>
		<input type="hidden" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( (string) $value ); ?>" class="bearlane-image-field__id">
		<button type="button" class="button bearlane-image-field__choose"><?php esc_html_e( 'Choose image', 'bearlane' ); ?></button>
		<button type="button" class="button-link bearlane-image-field__remove"<?php echo $value ? '' : ' hidden'; ?>><?php esc_html_e( 'Remove', 'bearlane' ); ?></button>
	</div>
	<?php
}

/**
 * Product multi-picker — uses a simple <select multiple> populated with
 * published products (capped). Works without any plugin.
 *
 * @param string $name     Input name (without []).
 * @param array  $selected IDs.
 * @param string $field_id DOM id.
 */
function bearlane_sections_admin_render_product_field( string $name, array $selected, string $field_id ): void {
	if ( ! class_exists( 'WooCommerce' ) ) {
		echo '<p class="bearlane-field__hint">' . esc_html__( 'WooCommerce is not active.', 'bearlane' ) . '</p>';
		return;
	}
	$products = wc_get_products( [ 'limit' => 200, 'status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ] );
	?>
	<select id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $name ); ?>[]" multiple size="8" class="bearlane-field__input bearlane-field__multiselect">
		<?php foreach ( $products as $product ) : ?>
			<option value="<?php echo esc_attr( (string) $product->get_id() ); ?>" <?php selected( in_array( $product->get_id(), $selected, true ), true ); ?>>
				<?php echo esc_html( $product->get_name() ); ?> (#<?php echo esc_html( (string) $product->get_id() ); ?>)
			</option>
		<?php endforeach; ?>
	</select>
	<p class="bearlane-field__hint"><?php esc_html_e( 'Hold Cmd / Ctrl to select multiple products.', 'bearlane' ); ?></p>
	<?php
}

/**
 * Product-category multi-picker.
 *
 * @param string $name     Input name.
 * @param array  $selected Term IDs.
 * @param string $field_id DOM id.
 */
function bearlane_sections_admin_render_category_field( string $name, array $selected, string $field_id ): void {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		echo '<p class="bearlane-field__hint">' . esc_html__( 'WooCommerce is not active.', 'bearlane' ) . '</p>';
		return;
	}
	$terms = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => false, 'number' => 200, 'orderby' => 'name' ] );
	if ( is_wp_error( $terms ) ) {
		return;
	}
	?>
	<select id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $name ); ?>[]" multiple size="8" class="bearlane-field__input bearlane-field__multiselect">
		<?php foreach ( $terms as $term ) : ?>
			<option value="<?php echo esc_attr( (string) $term->term_id ); ?>" <?php selected( in_array( (int) $term->term_id, array_map( 'intval', $selected ), true ), true ); ?>>
				<?php echo esc_html( $term->name ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<p class="bearlane-field__hint"><?php esc_html_e( 'Hold Cmd / Ctrl to select multiple categories.', 'bearlane' ); ?></p>
	<?php
}

/**
 * Repeater renderer. Each row is a fieldset with its sub-fields
 * rendered recursively. The JS handles add / remove / reorder.
 *
 * @param string $name  Base input name.
 * @param array  $field Repeater field schema.
 * @param array  $rows  Current rows.
 */
function bearlane_sections_admin_render_repeater( string $name, array $field, array $rows ): void {
	$sub_fields = (array) ( $field['sub_fields'] ?? [] );
	$add_label  = $field['add_label'] ?? __( 'Add item', 'bearlane' );
	?>
	<div class="bearlane-repeater" data-name="<?php echo esc_attr( $name ); ?>">

		<div class="bearlane-repeater__rows">
			<?php foreach ( $rows as $index => $row ) : ?>
				<?php bearlane_sections_admin_render_repeater_row( $name, $sub_fields, (int) $index, (array) $row ); ?>
			<?php endforeach; ?>
		</div>

		<button type="button" class="button bearlane-repeater__add">
			<span class="dashicons dashicons-plus-alt2"></span>
			<?php echo esc_html( $add_label ); ?>
		</button>

		<template class="bearlane-repeater__template">
			<?php bearlane_sections_admin_render_repeater_row( $name, $sub_fields, -1, [] ); ?>
		</template>

	</div>
	<?php
}

/**
 * Render one repeater row.
 *
 * @param string $base_name  Parent input name.
 * @param array  $sub_fields Repeater sub-field schemas.
 * @param int    $index      Row index (use -1 for template row).
 * @param array  $row_values Values for this row.
 */
function bearlane_sections_admin_render_repeater_row( string $base_name, array $sub_fields, int $index, array $row_values ): void {
	$index_token = $index < 0 ? '__INDEX__' : (string) $index;
	?>
	<div class="bearlane-repeater__row" data-index="<?php echo esc_attr( $index_token ); ?>">
		<header class="bearlane-repeater__row-header">
			<span class="bearlane-repeater__row-handle" aria-label="<?php esc_attr_e( 'Drag to reorder', 'bearlane' ); ?>">
				<span class="dashicons dashicons-menu"></span>
			</span>
			<span class="bearlane-repeater__row-index">#<span class="bearlane-repeater__row-num"><?php echo $index < 0 ? '' : esc_html( (string) ( $index + 1 ) ); ?></span></span>
			<button type="button" class="button-link bearlane-repeater__row-remove">
				<span class="dashicons dashicons-trash"></span>
				<?php esc_html_e( 'Remove', 'bearlane' ); ?>
			</button>
		</header>

		<div class="bearlane-repeater__row-body">
			<?php foreach ( $sub_fields as $sub_id => $sub_field ) : ?>
				<?php
				$sub_name  = $base_name . '[' . $index_token . '][' . $sub_id . ']';
				$sub_value = $row_values[ $sub_id ] ?? ( $sub_field['default'] ?? '' );
				bearlane_sections_admin_render_field( $sub_name, $sub_field, $sub_value );
				?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}
