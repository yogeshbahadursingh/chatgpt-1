<!-- wp:group {"tagName":"footer","layout":{"type":"constrained"},"className":"site-footer","style":{"color":{"background":"#062E2B"},"spacing":{"padding":{"top":"var:preset|spacing|4x-large","bottom":"var:preset|spacing|x-large"}}}} -->
<footer class="wp-block-group site-footer has-background" style="background-color:#062E2B;padding-top:var(--wp--preset--spacing--4x-large);padding-bottom:var(--wp--preset--spacing--x-large)">
	
	<!-- wp:columns {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|3x-large"}}}} -->
	<div class="wp-block-columns" style="margin-bottom:var(--wp--preset--spacing--3x-large)">
		
		<!-- wp:column {"width":"30%","className":"footer-brand"} -->
		<div class="wp-block-column footer-brand" style="flex-basis:30%">
			<!-- wp:site-title {"level":0,"style":{"elements":{"link":{"color":{"text":"#FFFFFF"}}}},"className":"footer-logo"} /-->
			<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#E2BF73"}}},"typography":{"fontStyle":"italic","fontSize":"var:preset|font-size|small"}},"textColor":"soft-gold"} -->
			<p class="has-soft-gold-color has-text-color" style="font-size:var(--wp--preset--font-size--small);font-style:italic"><?php echo esc_html( ppt_get_footer_tagline() ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#FFFFFF"}}},"typography":{"fontSize":"var:preset|font-size|small","lineHeight":"1.6"}},"textColor":"paper-white"} -->
			<p class="has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--small);line-height:1.6"><?php echo esc_html( ppt_get_footer_description() ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:social-links {"iconColor":"soft-gold","iconColorValue":"#E2BF73","size":"has-normal-icon-size","className":"footer-social","style":{"spacing":{"blockGap":"var:preset|spacing|small","margin":{"top":"var:preset|spacing|medium"}}}} -->
			<ul class="wp-block-social-links has-normal-icon-size has-icon-color footer-social" style="margin-top:var(--wp--preset--spacing--medium)"></ul>
			<!-- /wp:social-links -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"17.5%","className":"footer-nav-col"} -->
		<div class="wp-block-column footer-nav-col">
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|tiny","textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"600"},"elements":{"link":{"color":{"text":"#C69A45"}}}},"textColor":"heritage-gold","className":"footer-heading"} -->
			<h3 class="footer-heading has-heritage-gold-color has-text-color" style="font-size:var(--wp--preset--font-size--tiny);letter-spacing:0.1em;text-transform:uppercase;font-weight:600"><?php echo esc_html( ppt_get_footer_explore_heading() ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:navigation {"overlayMenu":"never","className":"footer-nav","style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}}} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"17.5%","className":"footer-nav-col"} -->
		<div class="wp-block-column footer-nav-col">
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|tiny","textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"600"},"elements":{"link":{"color":{"text":"#C69A45"}}}},"textColor":"heritage-gold","className":"footer-heading"} -->
			<h3 class="footer-heading has-heritage-gold-color has-text-color" style="font-size:var(--wp--preset--font-size--tiny);letter-spacing:0.1em;text-transform:uppercase;font-weight:600"><?php echo esc_html( ppt_get_footer_resources_heading() ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:navigation {"overlayMenu":"never","className":"footer-nav","style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}}} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"17.5%","className":"footer-contact"} -->
		<div class="wp-block-column footer-contact">
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|tiny","textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"600"},"elements":{"link":{"color":{"text":"#C69A45"}}}},"textColor":"heritage-gold","className":"footer-heading"} -->
			<h3 class="footer-heading has-heritage-gold-color has-text-color" style="font-size:var(--wp--preset--font-size--tiny);letter-spacing:0.1em;text-transform:uppercase;font-weight:600"><?php echo esc_html( ppt_get_footer_contact_heading() ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}},"className":"footer-contact-info"} -->
			<div class="wp-block-group footer-contact-info">
				<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#FFFFFF"}}},"typography":{"fontSize":"var:preset|font-size|small"}},"textColor":"paper-white"} -->
				<p class="has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--small)"><a href="mailto:<?php echo esc_attr( ppt_get_contact_email() ); ?>" class="footer__contact-link"><?php echo esc_html( ppt_get_contact_email() ); ?></a></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#FFFFFF"}}},"typography":{"fontSize":"var:preset|font-size|small"}},"textColor":"paper-white"} -->
				<p class="has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--small)"><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', ppt_get_contact_phone() ) ); ?>" class="footer__contact-link"><?php echo esc_html( ppt_get_contact_phone() ); ?></a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"17.5%","className":"footer-newsletter"} -->
		<div class="wp-block-column footer-newsletter">
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|tiny","textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"600"},"elements":{"link":{"color":{"text":"#C69A45"}}}},"textColor":"heritage-gold","className":"footer-heading"} -->
			<h3 class="footer-heading has-heritage-gold-color has-text-color" style="font-size:var(--wp--preset--font-size--tiny);letter-spacing:0.1em;text-transform:uppercase;font-weight:600"><?php echo esc_html( ppt_get_footer_newsletter_heading() ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#FFFFFF"}}},"typography":{"fontSize":"var:preset|font-size|small","lineHeight":"1.5"}},"textColor":"paper-white"} -->
			<p class="has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--small);line-height:1.5"><?php echo esc_html( ppt_get_footer_newsletter_description() ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"},"className":"newsletter-form"} -->
			<div class="wp-block-group newsletter-form">
			<!-- wp:html -->
			<form class="ppt-newsletter-form" action="#" method="post">
				<label for="newsletter-email" class="screen-reader-text"><?php esc_html_e( 'Email address', 'people-planet-thrive' ); ?></label>
				<input type="email" id="newsletter-email" name="email" placeholder="<?php esc_attr_e( 'Your email', 'people-planet-thrive' ); ?>" required class="ppt-input newsletter-input">
				<button type="submit" class="ppt-btn ppt-btn--accent newsletter-btn"><?php esc_html_e( 'Subscribe', 'people-planet-thrive' ); ?></button>
			</form>
			<!-- /wp:html -->			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

	<!-- wp:separator {"style":{"color":{"background":"#C69A45"}},"className":"is-style-wide"} -->
	<hr class="wp-block-separator has-text-color has-background is-style-wide" style="background-color:#C69A45;color:#C69A45"/>
	<!-- /wp:separator -->

	<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"},"className":"footer-legal","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium"}}}} -->
	<div class="wp-block-group footer-legal" style="padding-top:var(--wp--preset--spacing--medium)">
		<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#FFFFFF"}}},"typography":{"fontSize":"var:preset|font-size|small"}},"textColor":"paper-white"} -->
		<p class="has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--small)">&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php echo esc_html( ppt_get_copyright_org_name() ); ?>. <?php esc_html_e( 'All rights reserved.', 'people-planet-thrive' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:navigation {"overlayMenu":"never","className":"legal-nav","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}}} /-->
	</div>
	<!-- /wp:group -->

</footer>
<!-- /wp:group -->
