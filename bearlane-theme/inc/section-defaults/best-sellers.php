<?php
/**
 * Section Definition — Best Sellers / Tabbed Product Showcase
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	'id'              => 'best_sellers',
	'label'           => __( 'Best Sellers (Tabbed Products)', 'bearlane' ),
	'description'     => __( 'Tabbed product showcase: Best Sellers · New Arrivals · Staff Picks.', 'bearlane' ),
	'icon'            => 'dashicons-products',
	'priority'        => 20,
	'default_enabled' => true,
	'template'        => 'template-parts/front-page-best-sellers.php',
	'fields'          => [

		'eyebrow' => [
			'type'    => 'text',
			'label'   => __( 'Eyebrow', 'bearlane' ),
			'default' => __( 'Shop the Collection', 'bearlane' ),
		],

		'heading' => [
			'type'    => 'text',
			'label'   => __( 'Heading', 'bearlane' ),
			'default' => __( 'Shirts Worth Embroidering', 'bearlane' ),
		],

		'products_per_tab' => [
			'type'    => 'number',
			'label'   => __( 'Products Per Tab', 'bearlane' ),
			'default' => 4,
		],

		'show_best_sellers' => [
			'type'    => 'checkbox',
			'label'   => __( 'Show "Best Sellers" tab', 'bearlane' ),
			'default' => true,
		],

		'best_sellers_label' => [
			'type'    => 'text',
			'label'   => __( 'Best Sellers Tab Label', 'bearlane' ),
			'default' => __( 'Best Sellers', 'bearlane' ),
		],

		'show_new_arrivals' => [
			'type'    => 'checkbox',
			'label'   => __( 'Show "New Arrivals" tab', 'bearlane' ),
			'default' => true,
		],

		'new_arrivals_label' => [
			'type'    => 'text',
			'label'   => __( 'New Arrivals Tab Label', 'bearlane' ),
			'default' => __( 'New Arrivals', 'bearlane' ),
		],

		'show_staff_picks' => [
			'type'    => 'checkbox',
			'label'   => __( 'Show "Staff Picks" tab', 'bearlane' ),
			'default' => true,
		],

		'staff_picks_label' => [
			'type'    => 'text',
			'label'   => __( 'Staff Picks Tab Label', 'bearlane' ),
			'default' => __( 'Staff Picks', 'bearlane' ),
		],

		'footer_button_label' => [
			'type'    => 'text',
			'label'   => __( 'Footer Button Label', 'bearlane' ),
			'default' => __( 'View All Products', 'bearlane' ),
		],

		'footer_button_url' => [
			'type'    => 'url',
			'label'   => __( 'Footer Button URL (leave blank to link to Shop)', 'bearlane' ),
			'default' => '',
		],

	],
];
