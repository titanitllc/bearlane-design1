<?php
/**
 * Template Part — Frequently Asked Questions
 *
 * Accordion FAQ for embroidery customization questions.
 *
 * @package BearLane
 */

$faqs = [
	[
		'question' => __( 'What file format should I upload for my logo?', 'bearlane' ),
		'answer'   => __( 'We accept PNG, JPG, PDF, AI, EPS, and SVG files. For the cleanest result, vector files (AI, EPS, or SVG) are ideal. If you only have a PNG or JPG, our digitizing team will trace it — just make sure it\'s at least 300 DPI and has a transparent or white background.', 'bearlane' ),
	],
	[
		'question' => __( 'How long does a custom embroidery order take?', 'bearlane' ),
		'answer'   => __( 'Standard production is 10–14 business days from proof approval. Rush options (5–7 business days) are available at checkout for an additional fee. Shipping time is additional and depends on your selected method.', 'bearlane' ),
	],
	[
		'question' => __( 'Where can embroidery be placed on the shirt?', 'bearlane' ),
		'answer'   => __( 'We offer left chest, right chest, full back, upper back, left sleeve, right sleeve, and cuff placements. You can combine placements on a single garment — just select them at checkout or mention it in your personalization notes.', 'bearlane' ),
	],
	[
		'question' => __( 'Can I order different sizes in the same design run?', 'bearlane' ),
		'answer'   => __( 'Yes — you can mix any sizes (XS through 5XL) within a single order. There\'s no minimum per size. Just add each size to your cart with the same design details and we\'ll process them all together.', 'bearlane' ),
	],
	[
		'question' => __( 'What is the minimum order quantity?', 'bearlane' ),
		'answer'   => __( 'There is no minimum for standard orders — you can order a single custom shirt. Bulk pricing discounts begin at 12 units and increase at 24, 50, 100, and 250+ unit tiers.', 'bearlane' ),
	],
	[
		'question' => __( 'Can I see a proof before you start embroidering?', 'bearlane' ),
		'answer'   => __( 'Absolutely — every order includes a digital stitch proof emailed within 24 business hours. We don\'t run any machines until you\'ve reviewed and approved the proof. You can request adjustments to colors, sizing, or placement before final approval.', 'bearlane' ),
	],
	[
		'question' => __( 'How do I care for an embroidered shirt?', 'bearlane' ),
		'answer'   => __( 'Machine wash cold on a gentle cycle, inside-out. Tumble dry low or hang to dry. Do not iron directly on the embroidery — if pressing is needed, place a cloth over the design. Our Madeira threads are colorfast and rated for 100+ washes when cared for correctly.', 'bearlane' ),
	],
	[
		'question' => __( 'What if I\'m not happy with the finished product?', 'bearlane' ),
		'answer'   => __( 'We stand behind every stitch. If the embroidery doesn\'t match the approved proof, we\'ll re-do it at no charge. If we can\'t make it right, you\'ll get a full refund. Contact us within 14 days of delivery and we\'ll resolve it immediately.', 'bearlane' ),
	],
];
?>

<section class="section faq-section" aria-label="<?php esc_attr_e( 'Frequently Asked Questions', 'bearlane' ); ?>">
	<div class="container">

		<header class="section__header">
			<div class="section__eyebrow"><?php esc_html_e( 'Questions &amp; Answers', 'bearlane' ); ?></div>
			<h2 class="section__title"><?php esc_html_e( 'Everything You Want to Know', 'bearlane' ); ?></h2>
			<p class="section__subtitle"><?php esc_html_e( 'Common questions about custom embroidery, ordering, and production.', 'bearlane' ); ?></p>
		</header>

		<div class="faq-accordion" role="list">
			<?php foreach ( $faqs as $i => $faq ) :
				$id = 'faq-' . $i;
			?>
			<div class="faq-item" role="listitem">
				<button class="faq-item__trigger js-faq-trigger"
					aria-expanded="false"
					aria-controls="<?php echo esc_attr( $id ); ?>"
					id="<?php echo esc_attr( $id . '-btn' ); ?>">
					<span class="faq-item__question"><?php echo esc_html( $faq['question'] ); ?></span>
					<span class="faq-item__icon" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
					</span>
				</button>
				<div class="faq-item__body"
					id="<?php echo esc_attr( $id ); ?>"
					role="region"
					aria-labelledby="<?php echo esc_attr( $id . '-btn' ); ?>"
					hidden>
					<p class="faq-item__answer"><?php echo esc_html( $faq['answer'] ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="faq-footer">
			<p class="faq-footer__text">
				<?php esc_html_e( 'Still have questions?', 'bearlane' ); ?>
			</p>
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn--outline">
				<?php esc_html_e( 'Contact Us', 'bearlane' ); ?>
			</a>
		</div>

	</div>
</section>
