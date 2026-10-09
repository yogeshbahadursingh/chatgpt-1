<?php
/**
 * Pattern: Hero with Image Background
 *
 * @package PeoplePlanetThrive
 */

?>
<!-- wp:group {"align":"full","className":"ppt-hero-image","style":{"spacing":{"padding":{"top":"var:preset|spacing|6x-large","bottom":"var:preset|spacing|6x-large"}},"color":{"background":"var:ppt-surface-dark)"}}} -->
<div class="wp-block-group alignfull ppt-hero-image has-background" style="background-color:var(--ppt-surface-dark);padding-top:var(--wp--preset--spacing--6x-large);padding-bottom:var(--wp--preset--spacing--6x-large)">
	<!-- wp:cover {"url":"","dimRatio":50,"overlayColor":"deep-forest","isUserOverlayColor":true,"minHeight":500,"align":"full","layout":{"type":"constrained"}} -->
	<div class="wp-block-cover alignfull" style="min-height:500px">
		<span aria-hidden="true" class="wp-block-cover__background has-deep-forest-background-color has-background-dim-50 has-background-dim"></span>
		<div class="wp-block-cover__inner-container">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"align":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|small"}},"textColor":"soft-gold"} -->
				<p class="has-text-align-center has-soft-gold-color has-text-color" style="font-size:var(--wp--preset--font-size--small);letter-spacing:0.1em;text-transform:uppercase">Section Label</p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"var:preset|font-size|5x-large","lineHeight":"1.1"}},"textColor":"paper-white"} -->
				<h1 class="wp-block-heading has-text-align-center has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--5x-large);line-height:1.1">Main Headline Goes Here</h1>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"var:preset|font-size|large","lineHeight":"1.6","maxWidth":"720px"}},"textColor":"paper-white"} -->
				<p class="has-text-align-center has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--large);line-height:1.6;max-width:720px">Supporting text that provides context and encourages action. Keep it concise and compelling.</p>
				<!-- /wp:paragraph -->

				<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|large"}}}} -->
				<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--large)">
					<!-- wp:button {"className":"is-style-primary"} -->
					<div class="wp-block-button is-style-primary"><a class="wp-block-button__link wp-element-button" href="#">Primary Action</a></div>
					<!-- /wp:button -->

					<!-- wp:button {"className":"is-style-outline-white"} -->
					<div class="wp-block-button is-style-outline-white"><a class="wp-block-button__link wp-element-button" href="#">Secondary Action</a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->
		</div>
	</div>
	<!-- /wp:cover -->
</div>
<!-- /wp:group -->
