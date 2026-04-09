<?php
/**
 * Section Definition — USP / Trust Grid
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$default_usp_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';

return [
	'id'              => 'usp',
	'label'           => __( 'USPs / Trust Grid', 'bearlane' ),
	'description'     => __( 'Repeatable selling-point grid with icons, titles, and descriptions.', 'bearlane' ),
	'icon'            => 'dashicons-shield',
	'priority'        => 70,
	'default_enabled' => true,
	'template'        => 'template-parts/front-page-usp.php',
	'fields'          => [

		'heading' => [
			'type'    => 'text',
			'label'   => __( 'Heading', 'bearlane' ),
			'default' => __( 'Why Choose BearLane?', 'bearlane' ),
		],

		'subheading' => [
			'type'    => 'textarea',
			'label'   => __( 'Subheading', 'bearlane' ),
			'default' => __( 'Premium embroidery backed by quality you can feel.', 'bearlane' ),
		],

		'items' => [
			'type'       => 'repeater',
			'label'      => __( 'USP Items', 'bearlane' ),
			'add_label'  => __( 'Add USP', 'bearlane' ),
			'sub_fields' => [
				'icon'  => [
					'type'    => 'svg',
					'label'   => __( 'Icon SVG', 'bearlane' ),
					'default' => $default_usp_icon,
				],
				'title' => [
					'type'    => 'text',
					'label'   => __( 'Title', 'bearlane' ),
					'default' => '',
				],
				'desc'  => [
					'type'    => 'textarea',
					'label'   => __( 'Description', 'bearlane' ),
					'default' => '',
				],
			],
			'default'    => [
				[
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
					'title' => __( 'Stitch-Perfect Quality', 'bearlane' ),
					'desc'  => __( 'Every design is digitized by hand and embroidered with industrial precision — no puckering, no loose threads, no shortcuts.', 'bearlane' ),
				],
				[
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
					'title' => __( '10–14 Day Production', 'bearlane' ),
					'desc'  => __( 'Custom embroidery completed and shipped within 10–14 business days. Rush options available at checkout for urgent orders.', 'bearlane' ),
				],
				[
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
					'title' => __( '30+ Thread Colors', 'bearlane' ),
					'desc'  => __( 'Choose from our full Madeira thread palette — over 30 premium colors that stay vibrant wash after wash, guaranteed colorfast.', 'bearlane' ),
				],
				[
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
					'title' => __( 'Secure & Easy Ordering', 'bearlane' ),
					'desc'  => __( 'Upload your logo or choose from our design library. SSL-encrypted checkout and a full approval step before we stitch anything.', 'bearlane' ),
				],
				[
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>',
					'title' => __( 'Free Shipping $75+', 'bearlane' ),
					'desc'  => __( 'Free standard shipping on all orders over $75. Flat-rate bulk shipping available for teams, businesses, and events.', 'bearlane' ),
				],
				[
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>',
					'title' => __( 'Satisfaction Guarantee', 'bearlane' ),
					'desc'  => __( 'Not happy with the embroidery? We\'ll re-do it or refund you, no questions asked. Your satisfaction is stitched into every order.', 'bearlane' ),
				],
			],
		],

	],
];
