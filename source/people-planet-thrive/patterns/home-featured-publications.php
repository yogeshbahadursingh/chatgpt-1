<?php
/**
 * Pattern: Home Featured Publications
 *
 * @package PeoplePlanetThrive
 */

?>
<!-- wp:group {"align":"full","className":"ppt-home-featured-publications","style":{"spacing":{"padding":{"top":"var:preset|spacing|5x-large","bottom":"var:preset|spacing|5x-large"}},"color":{"background":"var:ppt-surface"}}} -->
<div class="wp-block-group alignfull ppt-home-featured-publications has-background" style="background-color:var(--ppt-surface);padding-top:var(--wp--preset--spacing--5x-large);padding-bottom:var(--wp--preset--spacing--5x-large)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		
		<!-- Section Header -->
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small","margin":{"bottom":"var:preset|spacing|3x-large"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--3x-large)">
			<!-- wp:paragraph {"align":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|small"}},"textColor":"emerald"} -->
			<p class="has-text-align-center has-emerald-color has-text-color" style="font-size:var(--wp--preset--font-size--small);letter-spacing:0.1em;text-transform:uppercase">Featured Publications</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"var:preset|font-size|4x-large"}}} -->
			<h2 class="wp-block-heading has-text-align-center" style="font-size:var(--wp--preset--font-size--4x-large)">Books &amp; Reports</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- Dynamic Query for Publications -->
		<!-- wp:query {"queryId":3,"query":{"perPage":3,"pages":0,"offset":0,"postType":"ppt_publication","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
		<div class="wp-block-query">
			<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"className":"ppt-publication-card"} -->
				<div class="wp-block-group ppt-publication-card">
					<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/4","style":{"border":{"radius":"4px"}}} /-->
					<!-- wp:post-title {"level":3,"isLink":true,"style":{"typography":{"fontSize":"var:preset|font-size|large","lineHeight":"1.3"}}} /-->
					<!-- wp:post-excerpt {"excerptLength":15,"style":{"typography":{"fontSize":"var:preset|font-size|small"}}} /-->
				</div>
				<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|3x-large","bottom":"var:preset|spacing|3x-large"}}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--3x-large);padding-bottom:var(--wp--preset--spacing--3x-large)">
					<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"var:preset|font-size|medium"}},"textColor":"ink-muted"} -->
					<p class="has-text-align-center has-ink-muted-color has-text-color" style="font-size:var(--wp--preset--font-size--medium)">Publications will be showcased here as they are added.</p>
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
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/publications">View All Publications</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
