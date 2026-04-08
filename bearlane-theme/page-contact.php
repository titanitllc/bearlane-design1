<?php
/**
 * BearLane Design — Contact Page Template
 *
 * Template Name: Contact
 *
 * @package BearLane
 */

get_header();

// Handle form submission.
$form_sent    = false;
$form_errors  = [];

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['bearlane_contact_nonce'] ) ) {
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bearlane_contact_nonce'] ) ), 'bearlane_contact_form' ) ) {
		$form_errors[] = __( 'Security check failed. Please try again.', 'bearlane' );
	} else {
		$name    = sanitize_text_field( wp_unslash( $_POST['contact_name'] ?? '' ) );
		$email   = sanitize_email( wp_unslash( $_POST['contact_email'] ?? '' ) );
		$subject = sanitize_text_field( wp_unslash( $_POST['contact_subject'] ?? '' ) );
		$message = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );

		if ( ! $name )    $form_errors[] = __( 'Please enter your name.', 'bearlane' );
		if ( ! is_email( $email ) ) $form_errors[] = __( 'Please enter a valid email address.', 'bearlane' );
		if ( ! $message ) $form_errors[] = __( 'Please enter your message.', 'bearlane' );

		if ( empty( $form_errors ) ) {
			$to      = get_option( 'admin_email' );
			$subject = $subject ?: sprintf( __( 'Contact form message from %s', 'bearlane' ), $name );
			$body    = sprintf(
				"Name: %s\nEmail: %s\n\n%s",
				$name,
				$email,
				$message
			);
			$headers = [
				'Content-Type: text/plain; charset=UTF-8',
				'Reply-To: ' . $email,
			];

			if ( wp_mail( $to, $subject, $body, $headers ) ) {
				$form_sent = true;
			} else {
				$form_errors[] = __( 'Unable to send your message. Please try again later.', 'bearlane' );
			}
		}
	}
}
?>

<main id="site-content" class="contact-page">

	<div class="page-banner">
		<div class="container">
			<?php bearlane_breadcrumbs(); ?>
			<h1 class="page-banner__title"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="container contact-layout">

		<!-- Contact Info -->
		<aside class="contact-info">
			<h2 class="contact-info__title"><?php esc_html_e( 'Get In Touch', 'bearlane' ); ?></h2>
			<p><?php esc_html_e( 'Have a question or want to collaborate? We\'d love to hear from you.', 'bearlane' ); ?></p>

			<ul class="contact-info__list">
				<li class="contact-info__item">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
					<a href="mailto:<?php echo esc_attr( get_option( 'admin_email' ) ); ?>"><?php echo esc_html( get_option( 'admin_email' ) ); ?></a>
				</li>
				<li class="contact-info__item">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
					<?php esc_html_e( 'Global — Ships worldwide', 'bearlane' ); ?>
				</li>
			</ul>

			<div class="contact-info__hours">
				<h3><?php esc_html_e( 'Support Hours', 'bearlane' ); ?></h3>
				<p><?php esc_html_e( 'Monday – Friday: 9am – 5pm', 'bearlane' ); ?></p>
				<p><?php esc_html_e( 'We aim to respond within 24 hours.', 'bearlane' ); ?></p>
			</div>
		</aside>

		<!-- Contact Form -->
		<div class="contact-form-wrap">

			<?php if ( $form_sent ) : ?>
			<div class="alert alert--success" role="alert">
				<?php esc_html_e( 'Thank you! Your message has been sent. We\'ll be in touch soon.', 'bearlane' ); ?>
			</div>
			<?php endif; ?>

			<?php if ( $form_errors ) : ?>
			<div class="alert alert--error" role="alert">
				<ul>
					<?php foreach ( $form_errors as $error ) : ?>
					<li><?php echo esc_html( $error ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<?php if ( ! $form_sent ) : ?>
			<form class="contact-form" method="post" action="" novalidate>
				<?php wp_nonce_field( 'bearlane_contact_form', 'bearlane_contact_nonce' ); ?>

				<div class="form-row form-row--2col">
					<div class="form-group">
						<label for="contact-name" class="form-label"><?php esc_html_e( 'Your Name', 'bearlane' ); ?> <span aria-hidden="true">*</span></label>
						<input type="text" id="contact-name" name="contact_name" class="form-input"
							value="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_POST['contact_name'] ?? '' ) ) ); ?>"
							required autocomplete="name" placeholder="<?php esc_attr_e( 'Jane Smith', 'bearlane' ); ?>">
					</div>
					<div class="form-group">
						<label for="contact-email" class="form-label"><?php esc_html_e( 'Email Address', 'bearlane' ); ?> <span aria-hidden="true">*</span></label>
						<input type="email" id="contact-email" name="contact_email" class="form-input"
							value="<?php echo esc_attr( sanitize_email( wp_unslash( $_POST['contact_email'] ?? '' ) ) ); ?>"
							required autocomplete="email" placeholder="<?php esc_attr_e( 'jane@example.com', 'bearlane' ); ?>">
					</div>
				</div>

				<div class="form-group">
					<label for="contact-subject" class="form-label"><?php esc_html_e( 'Subject', 'bearlane' ); ?></label>
					<input type="text" id="contact-subject" name="contact_subject" class="form-input"
						value="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_POST['contact_subject'] ?? '' ) ) ); ?>"
						placeholder="<?php esc_attr_e( 'How can we help?', 'bearlane' ); ?>">
				</div>

				<div class="form-group">
					<label for="contact-message" class="form-label"><?php esc_html_e( 'Message', 'bearlane' ); ?> <span aria-hidden="true">*</span></label>
					<textarea id="contact-message" name="contact_message" class="form-textarea"
						rows="6" required placeholder="<?php esc_attr_e( 'Your message…', 'bearlane' ); ?>"><?php echo esc_textarea( sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) ) ); ?></textarea>
				</div>

				<button type="submit" class="btn btn--primary btn--large"><?php esc_html_e( 'Send Message', 'bearlane' ); ?></button>
			</form>
			<?php endif; ?>

		</div><!-- .contact-form-wrap -->

	</div><!-- .contact-layout -->

</main>

<?php get_footer(); ?>
