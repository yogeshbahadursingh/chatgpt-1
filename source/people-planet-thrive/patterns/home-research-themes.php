<?php
/**
 * Pattern: Home Research Themes
 *
 * @package PeoplePlanetThrive
 */

?>
<!-- wp:group {"align":"full","className":"ppt-home-research-themes","style":{"spacing":{"padding":{"top":"var:preset|spacing|5x-large","bottom":"var:preset|spacing|5x-large"}},"color":{"background":"var:ppt-surface-dark"}}} -->
<div class="wp-block-group alignfull ppt-home-research-themes has-background" style="background-color:var(--ppt-surface-dark);padding-top:var(--wp--preset--spacing--5x-large);padding-bottom:var(--wp--preset--spacing--5x-large)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		
		<!-- Section Header -->
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small","margin":{"bottom":"var:preset|spacing|3x-large"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--3x-large)">
			<!-- wp:paragraph {"align":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|small"}},"textColor":"soft-gold"} -->
			<p class="has-text-align-center has-soft-gold-color has-text-color" style="font-size:var(--wp--preset--font-size--small);letter-spacing:0.1em;text-transform:uppercase">Research Themes</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"var:preset|font-size|4x-large"}},"textColor":"paper-white"} -->
			<h2 class="wp-block-heading has-text-align-center has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--4x-large)">Areas of Focus</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- Dynamic Query for Research Areas -->
		<!-- wp:query {"queryId":4,"query":{"perPage":6,"pages":0,"offset":0,"postType":"ppt_research_area","order":"desc","orderBy":"title","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
		<div class="wp-block-query">
			<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small","padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}},"border":{"top":{"color":"var:ppt-accent","width":"2px"}}},"backgroundColor":"surface-dark-alt","className":"ppt-theme-card"} -->
				<div class="wp-block-group ppt-theme-card has-surface-dark-alt-background-color has-background" style="border-top-color:var(--ppt-accent);border-top-width:2px;padding-top:var(--wp--preset--spacing--large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--large);padding-left:var(--wp--preset--spacing--medium)">
					<!-- wp:post-title {"level":3,"isLink":true,"style":{"typography":{"fontSize":"var:preset|font-size|x-large","lineHeight":"1.3"}},"textColor":"paper-white"} /-->
					<!-- wp:post-excerpt {"excerptLength":20,"style":{"typography":{"fontSize":"var:preset|font-size|small"}},"textColor":"paper-white"} /-->
				</div>
				<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|3x-large","bottom":"var:preset|spacing|3x-large"}}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--3x-large);padding-bottom:var(--wp--preset--spacing--3x-large)">
					<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"var:preset|font-size|medium"}},"textColor":"paper-white"} -->
					<p class="has-text-align-center has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--medium)">Research themes will be displayed here as they are defined.</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->

		<!-- View All CTA -->
		<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|3x-large"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--3x-large)">
			<!-- wp:button {"className":"is-style-outline-white"} -->
			<div class="wp-block-button is-style-outline-white"><a class="wp-block-button__link wp-element-button" href="/research-areas">Explore All Themes</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
