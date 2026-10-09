<?php
/**
 * Template Part: Header CTA Button
 *
 * Outputs dynamic CTA button from Customizer.
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$text = ppt_get_cta_text();
$url  = ppt_get_cta_url();

if ( ! $text || ! $url ) {
	return;
}
?>
<div class="header__cta">
	<a href="<?php echo esc_url( $url ); ?>" class="ppt-btn ppt-btn--primary header__cta-button">
		<?php echo esc_html( $text ); ?>
	</a>
</div>
