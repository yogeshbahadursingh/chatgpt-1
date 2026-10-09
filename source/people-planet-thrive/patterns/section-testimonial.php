<?php
/**
 * Pattern: Testimonial/Quote Section
 *
 * @package PeoplePlanetThrive
 */

?>
<!-- wp:group {"align":"full","className":"ppt-testimonial-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|5x-large","bottom":"var:preset|spacing|5x-large"}},"color":{"background":"var:ppt-surface-dark)"}}} -->
<div class="wp-block-group alignfull ppt-testimonial-section has-background" style="background-color:var(--ppt-surface-dark);padding-top:var(--wp--preset--spacing--5x-large);padding-bottom:var(--wp--preset--spacing--5x-large)">
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"800px"}} -->
	<div class="wp-block-group">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group">
			<!-- wp:quote {"className":"is-style-large","style":{"typography":{"fontSize":"var:preset|font-size|3x-large","lineHeight":"1.4","fontStyle":"italic"}},"textColor":"paper-white"} -->
			<blockquote class="wp-block-quote is-style-large has-paper-white-color has-text-color" style="font-size:var(--wp--preset--font-size--3x-large);font-style:italic;line-height:1.4">
				<p>"This is a powerful testimonial or quote that highlights the impact of our work. It should be inspiring and memorable."</p>
				<cite style="font-size:var(--wp--preset--font-size|base);font-style:normal;color:var(--wp--preset--color--soft-gold)">— Person Name, Title or Organization</cite>
			</blockquote>
			<!-- /wp:quote -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
