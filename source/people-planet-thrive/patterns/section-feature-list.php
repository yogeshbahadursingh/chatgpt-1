<?php
/**
 * Pattern: Feature List Section
 *
 * @package PeoplePlanetThrive
 */

?>
<!-- wp:group {"align":"full","className":"ppt-feature-list","style":{"spacing":{"padding":{"top":"var:preset|spacing|5x-large","bottom":"var:preset|spacing|5x-large"}},"color":{"background":"var:ppt-surface)"}}} -->
<div class="wp-block-group alignfull ppt-feature-list has-background" style="background-color:var(--ppt-surface);padding-top:var(--wp--preset--spacing--5x-large);padding-bottom:var(--wp--preset--spacing--5x-large)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|5x-large"}}}} -->
		<div class="wp-block-columns are-vertically-aligned-center">
			<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|small"}},"textColor":"emerald"} -->
					<p class="has-emerald-color has-text-color" style="font-size:var(--wp--preset--font-size--small);letter-spacing:0.1em;text-transform:uppercase">Section Label</p>
					<!-- /wp:paragraph -->

					<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"var:preset|font-size|4x-large","lineHeight":"1.15"}}} -->
					<h2 class="wp-block-heading" style="font-size:var(--wp--preset--font-size--4x-large);line-height:1.15">Compelling Headline</h2>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|base","lineHeight":"1.7"}}} -->
					<p style="font-size:var(--wp--preset--font-size--base);line-height:1.7">This is where you describe the feature or benefit. Keep it clear and focused on the value proposition.</p>
					<!-- /wp:paragraph -->

					<!-- wp:list {"style":{"spacing":{"margin":{"top":"var:preset|spacing|medium"}},"typography":{"fontSize":"var:preset|font-size|base"}}} -->
					<ul style="margin-top:var(--wp--preset--spacing--medium);font-size:var(--wp--preset--font-size--base)">
						<!-- wp:list-item -->
						<li>First key benefit or feature point</li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li>Second key benefit or feature point</li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li>Third key benefit or feature point</li>
						<!-- /wp:list-item -->
					</ul>
					<!-- /wp:list -->

					<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|medium"}}}} -->
					<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--medium)">
						<!-- wp:button -->
						<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">Learn More</a></div>
						<!-- /wp:button -->
					</div>
					<!-- /wp:buttons -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
				<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
				<figure class="wp-block-image size-large"><img src="" alt=""/></figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
