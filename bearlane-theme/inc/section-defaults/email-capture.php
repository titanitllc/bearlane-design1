<?php
/**
 * Section Definition — Email Capture
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	'id'              => 'email_capture',
	'label'           => __( 'Email Capture', 'bearlane' ),
	'description'     => __( 'Newsletter / lead capture block with benefits list.', 'bearlane' ),
	'icon'            => 'dashicons-email-alt',
	'priority'        => 110,
	'default_enabled' => true,
	'template'        => 'template-parts/front-page-email-capture.php',
	'fields'          => [

		'eyebrow' => [
			'type'    => 'text',
			'label'   => __( 'Eyebrow', 'bearlane' ),
			'default' => __( 'Exclusive Offer', 'bearlane' ),
		],

		'heading' => [
			'type'    => 'text',
			'label'   => __( 'Heading', 'bearlane' ),
			'default' => __( 'Get 10% Off Your First Custom Order', 'bearlane' ),
		],

		'description' => [
			'type'    => 'textarea',
			'label'   => __( 'Description', 'bearlane' ),
			'default' => __( 'Sign up and we\'ll send you a promo code, plus early access to new styles, seasonal sales, and embroidery design inspiration.', 'bearlane' ),
		],

		'benefits' => [
			'type'       => 'repeater',
			'label'      => __( 'Benefit Bullets', 'bearlane' ),
			'add_label'  => __( 'Add benefit', 'bearlane' ),
			'sub_fields' => [
				'label' => [
					'type'    => 'text',
					'label'   => __( 'Label', 'bearlane' ),
					'default' => '',
				],
			],
			'default'    => [
				[ 'label' => __( '10% off your first order', 'bearlane' ) ],
				[ 'label' => __( 'New arrivals before anyone else', 'bearlane' ) ],
				[ 'label' => __( 'Bulk order tips and design ideas', 'bearlane' ) ],
			],
		],

		'name_placeholder' => [
			'type'    => 'text',
			'label'   => __( 'Name Field Placeholder', 'bearlane' ),
			'default' => __( 'First name', 'bearlane' ),
		],

		'email_placeholder' => [
			'type'    => 'text',
			'label'   => __( 'Email Field Placeholder', 'bearlane' ),
			'default' => __( 'Email address', 'bearlane' ),
		],

		'submit_label' => [
			'type'    => 'text',
			'label'   => __( 'Submit Button Label', 'bearlane' ),
			'default' => __( 'Claim My 10% Discount', 'bearlane' ),
		],

		'privacy_note' => [
			'type'    => 'text',
			'label'   => __( 'Privacy Note', 'bearlane' ),
			'default' => __( 'No spam, ever. Unsubscribe any time.', 'bearlane' ),
		],

	],
];
