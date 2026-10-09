<!-- wp:group {"layout":{"type":"constrained"},"className":"utility-bar","style":{"color":{"background":"#062E2B"},"spacing":{"padding":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}},"typography":{"fontSize":"var:preset|font-size|small"}}} -->
<div class="wp-block-group utility-bar has-background" style="background-color:#062E2B;padding-top:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--x-small);font-size:var(--wp--preset--font-size--small)">
	<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group">
		<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"},"className":"utility-bar__left"} -->
		<div class="wp-block-group utility-bar__left">
			<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#E2BF73"}}}},"textColor":"soft-gold"} -->
			<p class="has-soft-gold-color has-text-color">
				<a href="mailto:<?php echo esc_attr( ppt_get_contact_email() ); ?>" class="utility-bar__contact-item utility-bar__contact-item--email"><?php echo esc_html( ppt_get_contact_email() ); ?></a>
			</p>
			<!-- /wp:paragraph -->
			<!-- wp:separator {"orientation":"vertical","style":{"color":{"background":"#4F8A52"},"layout":{"selfStretch":"fixed","flexSize":"1px"}}} -->
			<hr class="wp-block-separator has-text-color has-background" style="background-color:#4F8A52;color:#4F8A52"/>
			<!-- /wp:separator -->
			<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#E2BF73"}}}},"textColor":"soft-gold"} -->
			<p class="has-soft-gold-color has-text-color">
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', ppt_get_contact_phone() ) ); ?>" class="utility-bar__contact-item utility-bar__contact-item--phone"><?php echo esc_html( ppt_get_contact_phone() ); ?></a>
			</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"},"className":"utility-bar__right"} -->
		<div class="wp-block-group utility-bar__right">
			<!-- wp:navigation {"overlayMenu":"never","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"className":"utility-nav","layout":{"type":"flex","justifyContent":"right"}} /-->
			<!-- wp:social-links {"iconColor":"soft-gold","iconColorValue":"#E2BF73","size":"has-small-icon-size","className":"utility-social","style":{"spacing":{"blockGap":"var:preset|spacing|small"}}} -->
			<ul class="wp-block-social-links has-small-icon-size has-icon-color utility-social"></ul>
			<!-- /wp:social-links -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
