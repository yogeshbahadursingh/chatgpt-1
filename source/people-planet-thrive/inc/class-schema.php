<?php
/**
 * Schema.org Output
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Schema
 *
 * Handles Schema.org structured data output on the frontend.
 * Coordinates with SEO plugins to avoid duplicate schema.
 */
class PPT_Schema {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'output_schema' ), 99 );
	}

	/**
	 * Output Schema.org JSON-LD.
	 */
	public function output_schema() {
		// Check if an SEO plugin is handling standard schema.
		$seo_plugin_active = $this->is_seo_plugin_active();

		$schema = array();

		// Organization schema (only if no SEO plugin).
		if ( ! $seo_plugin_active ) {
			$schema[] = $this->get_organization_schema();
		}

		// Breadcrumb schema (only if no SEO plugin).
		if ( ! $seo_plugin_active && ! is_front_page() ) {
			$schema[] = $this->get_breadcrumb_schema();
		}

		// Custom scholarly schema (always output — SEO plugins don't handle these).
		if ( is_singular( 'ppt_article' ) ) {
			$schema[] = $this->get_scholarly_article_schema();
		}

		if ( is_singular( 'ppt_journal' ) ) {
			$schema[] = $this->get_journal_schema();
		}

		if ( is_singular( 'ppt_publication' ) ) {
			$schema[] = $this->get_book_schema();
		}

		// Filter to allow modification.
		$schema = apply_filters( 'ppt_schema_output', $schema );

		if ( empty( $schema ) ) {
			return;
		}

		// Output each schema as JSON-LD.
		foreach ( $schema as $item ) {
			if ( ! empty( $item ) ) {
				printf(
					'<script type="application/ld+json">%s</script>' . "\n",
					wp_json_encode( $item, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE )
				);
			}
		}
	}

	/**
	 * Check if an SEO plugin is active.
	 *
	 * @return bool True if SEO plugin is detected.
	 */
	private function is_seo_plugin_active() {
		// Check for common SEO plugins.
		if ( defined( 'RANK_MATH_FILE' ) ) {
			return true;
		}
		if ( defined( 'WPSEO_VERSION' ) ) {
			return true;
		}
		if ( class_exists( 'All_in_One_SEO_Pack' ) ) {
			return true;
		}
		if ( defined( 'SEOPRESS_VERSION' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Get Organization schema.
	 *
	 * @return array Organization schema data.
	 */
	private function get_organization_schema() {
		return array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Organization',
			'name'        => get_bloginfo( 'name' ),
			'description' => get_bloginfo( 'description' ),
			'url'         => home_url( '/' ),
			'logo'        => array(
				'@type'  => 'ImageObject',
				'url'    => PPT_THEME_URI . '/assets/images/logo.png',
			),
			'sameAs'      => $this->get_social_urls(),
		);
	}

	/**
	 * Get BreadcrumbList schema.
	 *
	 * @return array Breadcrumb schema data.
	 */
	private function get_breadcrumb_schema() {
		$items    = array();
		$position = 1;

		// Home.
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'name'     => esc_html__( 'Home', 'people-planet-thrive' ),
			'item'     => home_url( '/' ),
		);

		// Current page.
		if ( is_singular() ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			);
		} elseif ( is_archive() ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => post_type_archive_title( '', false ),
			);
		}

		return array(
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		);
	}

	/**
	 * Get ScholarlyArticle schema.
	 *
	 * @return array ScholarlyArticle schema data.
	 */
	private function get_scholarly_article_schema() {
		$post_id = get_the_ID();

		$schema = array(
			'@context'      => 'https://schema.org',
			'@type'         => 'ScholarlyArticle',
			'headline'      => get_the_title(),
			'description'   => get_post_meta( $post_id, '_ppt_abstract', true ) ?: wp_trim_words( get_the_content(), 50 ),
			'datePublished' => get_the_date( 'c' ),
			'dateModified'  => get_the_modified_date( 'c' ),
			'url'           => get_permalink(),
			'publisher'     => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
			),
		);

		// Add DOI if available.
		$doi = get_post_meta( $post_id, '_ppt_doi', true );
		if ( $doi ) {
			$schema['identifier'] = array(
				'@type'        => 'PropertyValue',
				'propertyID'   => 'DOI',
				'value'        => $doi,
			);
		}

		// Add keywords.
		$keywords = get_post_meta( $post_id, '_ppt_keywords', true );
		if ( $keywords ) {
			$schema['keywords'] = $keywords;
		}

		return apply_filters( 'ppt_schema_scholarly_article', $schema, $post_id );
	}

	/**
	 * Get Journal schema.
	 *
	 * @return array Journal schema data.
	 */
	private function get_journal_schema() {
		$post_id = get_the_ID();

		$schema = array(
			'@context'  => 'https://schema.org',
			'@type'     => 'Periodical',
			'name'      => get_the_title(),
			'description' => get_the_excerpt(),
			'url'       => get_permalink(),
			'publisher' => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
			),
		);

		// Add ISSN if available.
		$issn = get_post_meta( $post_id, '_ppt_issn', true );
		if ( $issn ) {
			$schema['issn'] = $issn;
		}

		return apply_filters( 'ppt_schema_journal', $schema, $post_id );
	}

	/**
	 * Get Book schema.
	 *
	 * @return array Book schema data.
	 */
	private function get_book_schema() {
		$post_id = get_the_ID();

		$schema = array(
			'@context'  => 'https://schema.org',
			'@type'     => 'Book',
			'name'      => get_the_title(),
			'description' => get_the_excerpt(),
			'url'       => get_permalink(),
			'publisher' => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
			),
		);

		// Add ISBN if available.
		$isbn = get_post_meta( $post_id, '_ppt_isbn', true );
		if ( $isbn ) {
			$schema['isbn'] = $isbn;
		}

		return apply_filters( 'ppt_schema_book', $schema, $post_id );
	}

	/**
	 * Get social media URLs for sameAs.
	 *
	 * @return array Social media URLs.
	 */
	private function get_social_urls() {
		$urls = array();
		// These would be populated from theme options or plugin settings.
		$urls = apply_filters( 'ppt_schema_social_urls', $urls );
		return $urls;
	}
}
