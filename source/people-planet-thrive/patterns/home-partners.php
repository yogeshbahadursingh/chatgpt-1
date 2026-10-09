<?php
/**
 * Pattern: Home Partners
 *
 * @package PeoplePlanetThrive
 */

?>
<!-- wp:group {"align":"full","className":"ppt-home-partners","style":{"spacing":{"padding":{"top":"var:preset|spacing|5x-large","bottom":"var:preset|spacing|5x-large"}},"color":{"background":"var:ppt-surface"}}} -->
<div class="wp-block-group alignfull ppt-home-partners has-background" style="background-color:var(--ppt-surface);padding-top:var(--wp--preset--spacing--5x-large);padding-bottom:var(--wp--preset--spacing--5x-large)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		
		<!-- Section Header -->
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small","margin":{"bottom":"var:preset|spacing|3x-large"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--3x-large)">
			<!-- wp:paragraph {"align":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|small"}},"textColor":"emerald"} -->
			<p class="has-text-align-center has-emerald-color has-text-color" style="font-size:var(--wp--preset--font-size--small);letter-spacing:0.1em;text-transform:uppercase">Partners &amp; Collaborators</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"var:preset|font-size|4x-large"}}} -->
			<h2 class="wp-block-heading has-text-align-center" style="font-size:var(--wp--preset--font-size--4x-large)">Working Together</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- Dynamic Query for Partners -->
		<!-- wp:query {"queryId":8,"query":{"perPage":6,"pages":0,"offset":0,"postType":"ppt_partner","order":"desc","orderBy":"title","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
		<div class="wp-block-query">
			<!-- wp:post-template {"layout":{"type":"grid","columnCount":6}} -->
				<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}}},"backgroundColor":"paper-white","className":"ppt-partner-logo"} -->
				<div class="wp-block-group ppt-partner-logo has-paper-white-background-color has-background" style="padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)">
					<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","sizeSlug":"medium","style":{"border":{"radius":"0"}}} /-->
				</div>
				<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|3x-large","bottom":"var:preset|spacing|3x-large"}}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--3x-large);padding-bottom:var(--wp--preset--spacing--3x-large)">
					<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"var:preset|font-size|medium"}},"textColor":"ink-muted"} -->
					<p class="has-text-align-center has-ink-muted-color has-text-color" style="font-size:var(--wp--preset--font-size--medium)">Partner organizations will be displayed here as partnerships are established.</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->

		<!-- View All CTA -->
		<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|3x-large"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--3x-large)">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/partners">View All Partners</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
