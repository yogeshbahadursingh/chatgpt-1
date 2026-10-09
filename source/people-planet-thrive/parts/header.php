<!-- wp:group {"tagName":"header","layout":{"type":"constrained"},"className":"site-header","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
<header class="wp-block-group site-header">
	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e( 'Skip to content', 'people-planet-thrive' ); ?>
	</a>
	<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"},"className":"header-inner","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}}} -->
	<div class="wp-block-group header-inner" style="padding-top:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium)">
		
		<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"},"className":"header-left"} -->
		<div class="wp-block-group header-left">
			<!-- wp:site-title {"level":0,"className":"site-logo"} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"},"className":"header-right"} -->
		<div class="wp-block-group header-right">
			
			<!-- wp:navigation {"layout":{"type":"flex","justifyContent":"right"},"className":"main-navigation","overlayMenu":"never","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"openSubmenusOnClick":false} /-->

			<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"},"className":"header-actions"} -->
			<div class="wp-block-group header-actions">
				
				<!-- wp:search {"label":"Search","buttonText":"Search","buttonUseIcon":true,"showLabel":false,"width":100,"className":"header-search"} /-->

				<!-- wp:buttons {"layout":{"type":"flex"}} -->
				<div class="wp-block-buttons">
				<!-- wp:button {"className":"header-cta"} -->
				<div class="wp-block-button header-cta"><a class="wp-block-button__link wp-element-button header__cta-button" href="<?php echo esc_url( ppt_get_cta_url() ); ?>"><?php echo esc_html( ppt_get_cta_text() ); ?></a></div>
				<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->

			</div>
			<!-- /wp:group -->

			<!-- wp:group {"layout":{"type":"flex"},"className":"mobile-menu-toggle"} -->
			<div class="wp-block-group mobile-menu-toggle">
				<button class="mobile-menu-button" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-nav-panel">
					<span class="screen-reader-text">Menu</span>
					<span class="mobile-menu-icon" aria-hidden="true"></span>
				</button>
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

	<!-- wp:template-part {"slug":"mobile-nav","area":"uncategorized"} /-->

</header>
<!-- /wp:group -->
