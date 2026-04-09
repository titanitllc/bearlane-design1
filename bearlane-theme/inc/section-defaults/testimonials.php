<?php
/**
 * Section Definition — Testimonials
 *
 * @package BearLane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	'id'              => 'testimonials',
	'label'           => __( 'Testimonials', 'bearlane' ),
	'description'     => __( 'Repeatable customer reviews with name, context, and rating.', 'bearlane' ),
	'icon'            => 'dashicons-format-quote',
	'priority'        => 80,
	'default_enabled' => true,
	'template'        => 'template-parts/front-page-testimonials.php',
	'fields'          => [

		'eyebrow' => [
			'type'    => 'text',
			'label'   => __( 'Eyebrow', 'bearlane' ),
			'default' => __( 'Real Customers', 'bearlane' ),
		],

		'heading' => [
			'type'    => 'richtext',
			'label'   => __( 'Heading', 'bearlane' ),
			'default' => __( 'Loved by Teams &amp; Individuals', 'bearlane' ),
		],

		'subheading' => [
			'type'    => 'textarea',
			'label'   => __( 'Subheading', 'bearlane' ),
			'default' => __( 'From solo custom orders to 500-piece corporate runs — here\'s what our customers say.', 'bearlane' ),
		],

		'items' => [
			'type'       => 'repeater',
			'label'      => __( 'Testimonials', 'bearlane' ),
			'add_label'  => __( 'Add testimonial', 'bearlane' ),
			'sub_fields' => [
				'quote'    => [
					'type'    => 'textarea',
					'label'   => __( 'Quote', 'bearlane' ),
					'default' => '',
				],
				'name'     => [
					'type'    => 'text',
					'label'   => __( 'Name', 'bearlane' ),
					'default' => '',
				],
				'context'  => [
					'type'    => 'text',
					'label'   => __( 'Context / Subtitle', 'bearlane' ),
					'default' => '',
				],
				'rating'   => [
					'type'    => 'number',
					'label'   => __( 'Rating (1–5)', 'bearlane' ),
					'default' => 5,
				],
				'initials' => [
					'type'    => 'text',
					'label'   => __( 'Avatar Initials', 'bearlane' ),
					'default' => '',
				],
				'image'    => [
					'type'    => 'image',
					'label'   => __( 'Avatar Image (optional)', 'bearlane' ),
					'default' => 0,
				],
			],
			'default'    => [
				[
					'quote'    => __( 'We ordered 50 custom polo shirts for our company retreat and every single one came out perfect. The embroidery was crisp, the thread colors matched our brand guide exactly, and they arrived 2 days ahead of schedule.', 'bearlane' ),
					'name'     => 'Marcus T.',
					'context'  => __( 'Team of 50 · Company retreat order', 'bearlane' ),
					'rating'   => 5,
					'initials' => 'MT',
					'image'    => 0,
				],
				[
					'quote'    => __( 'The stitch quality is genuinely impressive — way better than the screen prints we used to order. You can feel the difference. We\'ve made BearLane our go-to for all staff uniforms and branded apparel.', 'bearlane' ),
					'name'     => 'Jess R.',
					'context'  => __( 'Repeat customer · Branded uniforms', 'bearlane' ),
					'rating'   => 5,
					'initials' => 'JR',
					'image'    => 0,
				],
				[
					'quote'    => __( 'I uploaded my logo as a PNG and they sent a digital proof within 24 hours. The final shirts looked exactly like the proof. So easy, and my clients are constantly asking where I got them.', 'bearlane' ),
					'name'     => 'Priya L.',
					'context'  => __( 'Individual order · Left chest logo', 'bearlane' ),
					'rating'   => 5,
					'initials' => 'PL',
					'image'    => 0,
				],
				[
					'quote'    => __( 'Ordered custom shirts for our youth soccer league — 30 kids, different sizes, all with the club crest embroidered on the chest. Every piece was spot-on and the kids are obsessed with them.', 'bearlane' ),
					'name'     => 'Coach A. Williams',
					'context'  => __( 'Club order · 30 units · Youth sizes', 'bearlane' ),
					'rating'   => 5,
					'initials' => 'AW',
					'image'    => 0,
				],
			],
		],

		'footer_text' => [
			'type'    => 'text',
			'label'   => __( 'Footer Summary Text', 'bearlane' ),
			'default' => __( 'Rated 4.9 / 5 from 800+ verified orders', 'bearlane' ),
		],

		'cta_label' => [
			'type'    => 'text',
			'label'   => __( 'CTA Button Label', 'bearlane' ),
			'default' => __( 'Start Your Custom Order', 'bearlane' ),
		],

		'cta_url' => [
			'type'    => 'url',
			'label'   => __( 'CTA Button URL (blank = Shop)', 'bearlane' ),
			'default' => '',
		],

	],
];
