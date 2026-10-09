<?php
/**
 * Pattern: Home Latest Articles
 *
 * @package PeoplePlanetThrive
 */

?>
<!-- wp:group {"align":"full","className":"ppt-home-latest-articles","style":{"spacing":{"padding":{"top":"var:preset|spacing|5x-large","bottom":"var:preset|spacing|5x-large"}},"color":{"background":"var:ppt-surface-alt"}}} -->
<div class="wp-block-group alignfull ppt-home-latest-articles has-background" style="background-color:var(--ppt-surface-alt);padding-top:var(--wp--preset--spacing--5x-large);padding-bottom:var(--wp--preset--spacing--5x-large)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		
		<!-- Section Header -->
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small","margin":{"bottom":"var:preset|spacing|3x-large"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--3x-large)">
			<!-- wp:paragraph {"align":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|small"}},"textColor":"emerald"} -->
			<p class="has-text-align-center has-emerald-color has-text-color" style="font-size:var(--wp--preset--font-size--small);letter-spacing:0.1em;text-transform:uppercase">Latest Journal Articles</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"var:preset|font-size|4x-large"}}} -->
			<h2 class="wp-block-heading has-text-align-center" style="font-size:var(--wp--preset--font-size--4x-large)">Recent Scholarship</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- Dynamic Query for Articles -->
		<!-- wp:query {"queryId":2,"query":{"perPage":4,"pages":0,"offset":0,"postType":"ppt_article","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
		<div class="wp-block-query">
			<!-- wp:post-template {"layout":{"type":"grid","columnCount":4}} -->
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"className":"ppt-article-card"} -->
				<div class="wp-block-group ppt-article-card">
					<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","style":{"border":{"radius":"4px"}}} /-->
					<!-- wp:post-title {"level":3,"isLink":true,"style":{"typography":{"fontSize":"var:preset|font-size|base","lineHeight":"1.4"}}} /-->
					<!-- wp:post-date {"style":{"typography":{"fontSize":"var:preset|font-size|small"}}} /-->
				</div>
				<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|3x-large","bottom":"var:preset|spacing|3x-large"}}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--3x-large);padding-bottom:var(--wp--preset--spacing--3x-large)">
					<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"var:preset|font-size|medium"}},"textColor":"ink-muted"} -->
					<p class="has-text-align-center has-ink-muted-color has-text-color" style="font-size:var(--wp--preset--font-size--medium)">Journal articles will appear here as they are published.</p>
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
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/articles">Browse All Articles</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
