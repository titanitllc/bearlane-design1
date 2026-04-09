<?php
/**
 * Section Definition — Hero
 *
 * Preserves the exact content previously hardcoded in
 * template-parts/front-page-hero.php. Non-technical users edit every
 * value from Appearance → Homepage Sections.
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	'id'              => 'hero',
	'label'           => __( 'Hero', 'bearlane' ),
	'description'     => __( 'Full-viewport hero with headline, dual CTA, trust strip, and stats bar.', 'bearlane' ),
	'icon'            => 'dashicons-cover-image',
	'priority'        => 10,
	'default_enabled' => true,
	'template'        => 'template-parts/front-page-hero.php',
	'fields'          => [

		'eyebrow_label' => [
			'type'    => 'text',
			'label'   => __( 'Eyebrow Badge Label', 'bearlane' ),
			'default' => __( 'Premium Embroidery', 'bearlane' ),
		],

		'heading' => [
			'type'    => 'richtext',
			'label'   => __( 'Headline', 'bearlane' ),
			'default' => __( 'Your Logo. Stitched to Last.', 'bearlane' ),
		],

		'subheading' => [
			'type'    => 'richtext',
			'label'   => __( 'Subheading', 'bearlane' ),
			'default' => __( 'Premium embroidered shirts for individuals, teams, and businesses. Custom orders in 10–14 business days.', 'bearlane' ),
		],

		'cta_primary_label' => [
			'type'    => 'text',
			'label'   => __( 'Primary Button Label', 'bearlane' ),
			'default' => __( 'Shop Custom Shirts', 'bearlane' ),
		],

		'cta_primary_url' => [
			'type'    => 'url',
			'label'   => __( 'Primary Button URL', 'bearlane' ),
			'default' => '/shop',
		],

		'cta_secondary_label' => [
			'type'    => 'text',
			'label'   => __( 'Secondary Button Label', 'bearlane' ),
			'default' => __( 'Get a Bulk Quote', 'bearlane' ),
		],

		'cta_secondary_url' => [
			'type'    => 'url',
			'label'   => __( 'Secondary Button URL', 'bearlane' ),
			'default' => '/bulk-orders',
		],

		'background_image' => [
			'type'    => 'image',
			'label'   => __( 'Background Image', 'bearlane' ),
			'default' => 0,
		],

		'trust_items' => [
			'type'       => 'repeater',
			'label'      => __( 'Trust Strip Items', 'bearlane' ),
			'add_label'  => __( 'Add trust item', 'bearlane' ),
			'sub_fields' => [
				'label' => [
					'type'    => 'text',
					'label'   => __( 'Label', 'bearlane' ),
					'default' => '',
				],
			],
			'default'    => [
				[ 'label' => __( 'Free shipping $75+', 'bearlane' ) ],
				[ 'label' => __( 'Satisfaction guarantee', 'bearlane' ) ],
				[ 'label' => __( '10–14 day production', 'bearlane' ) ],
			],
		],

		'stats' => [
			'type'       => 'repeater',
			'label'      => __( 'Stats Bar', 'bearlane' ),
			'add_label'  => __( 'Add stat', 'bearlane' ),
			'sub_fields' => [
				'number' => [
					'type'    => 'text',
					'label'   => __( 'Number', 'bearlane' ),
					'default' => '',
				],
				'label'  => [
					'type'    => 'text',
					'label'   => __( 'Label', 'bearlane' ),
					'default' => '',
				],
			],
			'default'    => [
				[ 'number' => '5,000+', 'label' => __( 'Custom Orders', 'bearlane' ) ],
				[ 'number' => '30+',    'label' => __( 'Thread Colors', 'bearlane' ) ],
				[ 'number' => '10–14',  'label' => __( 'Day Production', 'bearlane' ) ],
				[ 'number' => '100%',   'label' => __( 'Satisfaction', 'bearlane' ) ],
			],
		],

	],
];
