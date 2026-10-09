<?php
/**
 * Template Part: Footer Contact Info
 *
 * Outputs dynamic contact information from Customizer.
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$email = ppt_get_contact_email();
$phone = ppt_get_contact_phone();
?>
<div class="footer__contact">
	<?php if ( $email ) : ?>
		<div class="footer__contact-item">
			<span class="footer__contact-label"><?php esc_html_e( 'Email:', 'people-planet-thrive' ); ?></span>
			<a href="mailto:<?php echo esc_attr( $email ); ?>" class="footer__contact-link">
				<?php echo esc_html( $email ); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( $phone ) : ?>
		<div class="footer__contact-item">
			<span class="footer__contact-label"><?php esc_html_e( 'Phone:', 'people-planet-thrive' ); ?></span>
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="footer__contact-link">
				<?php echo esc_html( $phone ); ?>
			</a>
		</div>
	<?php endif; ?>
</div>
