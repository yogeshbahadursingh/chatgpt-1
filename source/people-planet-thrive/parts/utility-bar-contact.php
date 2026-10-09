<?php
/**
 * Template Part: Utility Bar Contact Info
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
<div class="utility-bar__contact">
	<?php if ( $email ) : ?>
		<a href="mailto:<?php echo esc_attr( $email ); ?>" class="utility-bar__contact-item utility-bar__contact-item--email">
			<span class="screen-reader-text"><?php esc_html_e( 'Email:', 'people-planet-thrive' ); ?></span>
			<?php echo esc_html( $email ); ?>
		</a>
	<?php endif; ?>

	<?php if ( $phone ) : ?>
		<span class="utility-bar__contact-separator" aria-hidden="true">|</span>
		<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="utility-bar__contact-item utility-bar__contact-item--phone">
			<span class="screen-reader-text"><?php esc_html_e( 'Phone:', 'people-planet-thrive' ); ?></span>
			<?php echo esc_html( $phone ); ?>
		</a>
	<?php endif; ?>
</div>
