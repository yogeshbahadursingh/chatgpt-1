<?php
/**
 * Pattern: Scholarly — Article Metadata
 *
 * @package PeoplePlanetThrive
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small","padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}},"border":{"bottom":{"color":"#C69A45","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-bottom-color:#C69A45;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium)">
	<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left"},"style":{"spacing":{"blockGap":"var:preset|spacing|medium"},"typography":{"fontSize":"var:preset|font-size|small"}}} -->
	<div class="wp-block-group" style="font-size:var(--wp--preset--font-size--small)">
		<!-- wp:paragraph {"style":{"color":{"text":"#101820"}}} -->
		<p class="has-text-color" style="color:#101820"><strong>Published:</strong> [Date]</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"style":{"color":{"text":"#101820"}}} -->
		<p class="has-text-color" style="color:#101820"><strong>DOI:</strong> [DOI]</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"style":{"color":{"text":"#101820"}}} -->
		<p class="has-text-color" style="color:#101820"><strong>Journal:</strong> [Journal Name]</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|small"},"color":{"text":"#101820"}}} -->
	<p class="has-text-color" style="color:#101820;font-size:var(--wp--preset--font-size--small)"><strong>Keywords:</strong> [Keywords]</p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
