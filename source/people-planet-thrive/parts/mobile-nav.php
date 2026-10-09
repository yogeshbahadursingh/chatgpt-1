<!-- wp:group {"tagName":"div","layout":{"type":"constrained"},"className":"mobile-nav-panel","style":{"display":"none"},"id":"mobile-nav-panel"} -->
<div class="wp-block-group mobile-nav-panel" id="mobile-nav-panel" style="display:none" role="dialog" aria-label="Mobile navigation">
	
	<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between"},"className":"mobile-nav-header","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}}} -->
	<div class="wp-block-group mobile-nav-header" style="padding-top:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium)">
		<!-- wp:site-title {"level":0} /-->
		<button class="mobile-nav-close" aria-label="Close menu">
			<span class="screen-reader-text">Close</span>
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
				<line x1="18" y1="6" x2="6" y2="18"></line>
				<line x1="6" y1="6" x2="18" y2="18"></line>
			</svg>
		</button>
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"layout":{"type":"constrained"},"className":"mobile-nav-content","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|large"}}}} -->
	<div class="wp-block-group mobile-nav-content" style="padding-top:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--large)">
		<!-- wp:navigation {"overlayMenu":"never","className":"mobile-nav-menu","style":{"spacing":{"blockGap":"0"}}} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"layout":{"type":"constrained"},"className":"mobile-nav-footer","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}},"border":{"top":{"color":"#E5E1D8","width":"1px"}}}} -->
	<div class="wp-block-group mobile-nav-footer" style="padding-top:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);border-top-color:#E5E1D8;border-top-width:1px">
		<!-- wp:search {"label":"Search","buttonText":"Search","className":"mobile-nav-search"} /-->
		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|medium"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--medium)">
		<!-- wp:button {"width":100} -->
		<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button mobile-nav__cta-button" href="<?php echo esc_url( ppt_get_cta_url() ); ?>"><?php echo esc_html( ppt_get_cta_text() ); ?></a></div>
		<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
