<?php
/**
 * Pattern: Home Hero
 *
 * @package PeoplePlanetThrive
 */

?>
<!-- wp:group {"align":"full","className":"ppt-home-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|6x-large","bottom":"var:preset|spacing|6x-large"}},"color":{"background":"var:ppt-surface-dark"}}} -->
<div class="wp-block-group alignfull ppt-home-hero has-background" style="background-color:var(--ppt-surface-dark);padding-top:var(--wp--preset--spacing--6x-large);padding-bottom:var(--wp--preset--spacing--6x-large)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group">
			
			<!-- Eyebrow -->
			<!-- wp:paragraph {"align":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|small"}},"textColor":"soft-gold","className":"ppt-home-hero__eyebrow"} -->
			<p class="has-text-align-center has-soft-gold-color has-text-color ppt-home-hero__eyebrow" style="font-size:var(--wp--preset--font-size--small);letter-spacing:0.1em;text-transform:uppercase">People &amp; Planet Thrive</p>
			<!-- /wp:paragraph -->

			<!-- Headline -->
			<!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"var:preset|font-size|5x-large","lineHeight":"1.1"}},"textColor":"paper-white","className":"ppt-home-hero__headline"} -->
			<h1 class="wp-block-heading has-text-align-center has-paper-white-color has-text-color ppt-home-hero__headline" style="font-size:var(--wp--preset--font-size--5x-large);line-height:1.1">Knowledge for People.<br>Progress for Planet.</h1>
			<!-- /wp:heading -->

			<!-- Supporting Copy -->
			<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"var:preset|font-size|large","lineHeight":"1.6","maxWidth":"720px"}},"textColor":"paper-white","className":"ppt-home-hero__copy"} -->
			<p class="has-text-align-center has-paper-white-color has-text-color ppt-home-hero__copy" style="font-size:var(--wp--preset--font-size--large);line-height:1.6;max-width:720px">People &amp; Planet Thrive advances research, publishing, learning and practical knowledge that help people and communities flourish while supporting a sustainable future.</p>
			<!-- /wp:paragraph -->

			<!-- CTAs -->
			<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|large"}}},"className":"ppt-home-hero__ctas"} -->
			<div class="wp-block-buttons ppt-home-hero__ctas" style="margin-top:var(--wp--preset--spacing--large)">
				<!-- wp:button {"className":"is-style-primary","style":{"spacing":{"padding":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|large","right":"var:preset|spacing|large"}}}} -->
				<div class="wp-block-button is-style-primary"><a class="wp-block-button__link wp-element-button" href="/about" style="padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--large)">Explore Our Work</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"className":"is-style-outline-white","style":{"spacing":{"padding":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|large","right":"var:preset|spacing|large"}}}} -->
				<div class="wp-block-button is-style-outline-white"><a class="wp-block-button__link wp-element-button" href="/about" style="padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--large)">About Our Initiative</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
