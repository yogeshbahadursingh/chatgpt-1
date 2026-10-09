<?php
/**
 * Template Helper Functions
 *
 * Provides dynamic content output for template parts.
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get contact email.
 *
 * @return string Contact email address.
 */
function ppt_get_contact_email() {
	return get_theme_mod( 'ppt_contact_email', '' );
}

/**
 * Get contact phone.
 *
 * @return string Contact phone number.
 */
function ppt_get_contact_phone() {
	return get_theme_mod( 'ppt_contact_phone', '' );
}

/**
 * Get CTA button text.
 *
 * @return string CTA button text.
 */
function ppt_get_cta_text() {
	return get_theme_mod( 'ppt_cta_text', esc_html__( 'Submit Manuscript', 'people-planet-thrive' ) );
}

/**
 * Get CTA button URL.
 *
 * @return string CTA button URL.
 */
function ppt_get_cta_url() {
	return get_theme_mod( 'ppt_cta_url', home_url( '/submit-manuscript' ) );
}

/**
 * Get footer tagline.
 *
 * @return string Footer tagline.
 */
function ppt_get_footer_tagline() {
	return get_theme_mod( 'ppt_footer_tagline', esc_html__( 'Knowledge for People. Progress for Planet.', 'people-planet-thrive' ) );
}

/**
 * Get footer description.
 *
 * @return string Footer description.
 */
function ppt_get_footer_description() {
	return get_theme_mod( 'ppt_footer_description', esc_html__( 'Advancing research, publishing, and education for a thriving world.', 'people-planet-thrive' ) );
}

/**
 * Get footer explore heading.
 *
 * @return string Footer explore heading.
 */
function ppt_get_footer_explore_heading() {
	return get_theme_mod( 'ppt_footer_explore_heading', esc_html__( 'Explore', 'people-planet-thrive' ) );
}

/**
 * Get footer resources heading.
 *
 * @return string Footer resources heading.
 */
function ppt_get_footer_resources_heading() {
	return get_theme_mod( 'ppt_footer_resources_heading', esc_html__( 'Resources', 'people-planet-thrive' ) );
}

/**
 * Get footer contact heading.
 *
 * @return string Footer contact heading.
 */
function ppt_get_footer_contact_heading() {
	return get_theme_mod( 'ppt_footer_contact_heading', esc_html__( 'Contact', 'people-planet-thrive' ) );
}

/**
 * Get footer newsletter heading.
 *
 * @return string Footer newsletter heading.
 */
function ppt_get_footer_newsletter_heading() {
	return get_theme_mod( 'ppt_footer_newsletter_heading', esc_html__( 'Stay Informed', 'people-planet-thrive' ) );
}

/**
 * Get footer newsletter description.
 *
 * @return string Footer newsletter description.
 */
function ppt_get_footer_newsletter_description() {
	return get_theme_mod( 'ppt_footer_newsletter_description', esc_html__( 'Subscribe to our newsletter for the latest research and publications.', 'people-planet-thrive' ) );
}

/**
 * Get copyright organization name.
 *
 * @return string Copyright organization name.
 */
function ppt_get_copyright_org_name() {
	return get_theme_mod( 'ppt_copyright_org_name', esc_html__( 'People & Planet Thrive Initiative Pvt. Ltd.', 'people-planet-thrive' ) );
}

/**
 * Output contact info block pattern.
 *
 * @param string $layout Layout type: 'horizontal' or 'vertical'.
 */
function ppt_output_contact_info( $layout = 'horizontal' ) {
	$email = ppt_get_contact_email();
	$phone = ppt_get_contact_phone();

	if ( 'horizontal' === $layout ) {
		?>
		<div class="ppt-contact-info ppt-contact-info--horizontal">
			<?php if ( $email ) : ?>
				<a href="mailto:<?php echo esc_attr( $email ); ?>" class="ppt-contact-info__item">
					<?php echo esc_html( $email ); ?>
				</a>
			<?php endif; ?>

			<?php if ( $phone ) : ?>
				<span class="ppt-contact-info__separator" aria-hidden="true">|</span>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="ppt-contact-info__item">
					<?php echo esc_html( $phone ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	} else {
		?>
		<div class="ppt-contact-info ppt-contact-info--vertical">
			<?php if ( $email ) : ?>
				<a href="mailto:<?php echo esc_attr( $email ); ?>" class="ppt-contact-info__item">
					<?php echo esc_html( $email ); ?>
				</a>
			<?php endif; ?>

			<?php if ( $phone ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="ppt-contact-info__item">
					<?php echo esc_html( $phone ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}

/**
 * Output CTA button.
 *
 * @param string $class Additional CSS classes.
 */
function ppt_output_cta_button( $class = '' ) {
	$text = ppt_get_cta_text();
	$url  = ppt_get_cta_url();

	if ( ! $text || ! $url ) {
		return;
	}
	?>
	<a href="<?php echo esc_url( $url ); ?>" class="ppt-btn ppt-btn--primary <?php echo esc_attr( $class ); ?>">
		<?php echo esc_html( $text ); ?>
	</a>
	<?php
}
