<?php
/**
 * Section Definition — Embroidery Quality Showcase
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$check_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>';

return [
	'id'              => 'embroidery_showcase',
	'label'           => __( 'Quality Showcase', 'bearlane' ),
	'description'     => __( 'Two-column feature section with image + quality bullet points.', 'bearlane' ),
	'icon'            => 'dashicons-awards',
	'priority'        => 60,
	'default_enabled' => true,
	'template'        => 'template-parts/front-page-embroidery-showcase.php',
	'fields'          => [

		'image' => [
			'type'    => 'image',
			'label'   => __( 'Feature Image', 'bearlane' ),
			'default' => 0,
		],

		'badge_label' => [
			'type'    => 'text',
			'label'   => __( 'Badge Label', 'bearlane' ),
			'default' => __( 'Master Stitch Certified', 'bearlane' ),
		],

		'eyebrow' => [
			'type'    => 'text',
			'label'   => __( 'Eyebrow', 'bearlane' ),
			'default' => __( 'The Detail Makes the Difference', 'bearlane' ),
		],

		'heading' => [
			'type'    => 'text',
			'label'   => __( 'Heading', 'bearlane' ),
			'default' => __( 'Embroidery You Can Feel the Difference In', 'bearlane' ),
		],

		'intro' => [
			'type'    => 'textarea',
			'label'   => __( 'Intro Paragraph', 'bearlane' ),
			'default' => __( 'Not all embroidery is equal. Cheap digitizing, wrong backing, and cut-rate threads produce puckered, faded logos that embarrass your brand. We do it right.', 'bearlane' ),
		],

		'points' => [
			'type'       => 'repeater',
			'label'      => __( 'Quality Points', 'bearlane' ),
			'add_label'  => __( 'Add point', 'bearlane' ),
			'sub_fields' => [
				'icon'  => [
					'type'    => 'svg',
					'label'   => __( 'Icon SVG', 'bearlane' ),
					'default' => $check_icon,
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
				[ 'icon' => $check_icon, 'title' => __( 'Hand-digitized artwork', 'bearlane' ), 'desc' => __( 'Every design is digitized by an expert, not auto-converted — ensuring clean lines and proper stitch direction.', 'bearlane' ) ],
				[ 'icon' => $check_icon, 'title' => __( 'Industrial-grade machines', 'bearlane' ), 'desc' => __( 'Multi-head Tajima embroidery machines for consistent density, tension, and stitch registration across every garment.', 'bearlane' ) ],
				[ 'icon' => $check_icon, 'title' => __( 'Colorfast Madeira threads', 'bearlane' ), 'desc' => __( 'Premium polyester threads rated for 100+ washes. Colors stay vivid; no fading, no bleeding, no compromise.', 'bearlane' ) ],
				[ 'icon' => $check_icon, 'title' => __( 'Backing and stabilization', 'bearlane' ), 'desc' => __( 'Cut-away or tear-away backing on every piece for a flat, professional finish that doesn\'t pucker or distort.', 'bearlane' ) ],
				[ 'icon' => $check_icon, 'title' => __( 'QC before every shipment', 'bearlane' ), 'desc' => __( 'Each garment is inspected for loose threads, alignment, and color accuracy before packaging.', 'bearlane' ) ],
			],
		],

		'cta_primary_label' => [
			'type'    => 'text',
			'label'   => __( 'Primary Button Label', 'bearlane' ),
			'default' => __( 'See Our Shirts', 'bearlane' ),
		],

		'cta_primary_url' => [
			'type'    => 'url',
			'label'   => __( 'Primary Button URL (blank = Shop)', 'bearlane' ),
			'default' => '',
		],

		'cta_secondary_label' => [
			'type'    => 'text',
			'label'   => __( 'Secondary Button Label', 'bearlane' ),
			'default' => __( 'Our Story', 'bearlane' ),
		],

		'cta_secondary_url' => [
			'type'    => 'url',
			'label'   => __( 'Secondary Button URL', 'bearlane' ),
			'default' => '/about',
		],

	],
];
