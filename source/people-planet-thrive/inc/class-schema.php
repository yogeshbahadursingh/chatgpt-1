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

		// Keep specialist schema independent of ownership of standard site schema.
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
	 * Check known SEO integrations, with an explicit standard-schema owner override.
	 *
	 * An external SEO integration can suppress the theme Organization/BreadcrumbList
	 * with add_filter( 'ppt_standard_schema_owned_by_seo', '__return_true' ).
	 * This does not suppress ScholarlyArticle, Periodical or publication output.
	 * Detection cannot establish whether every plugin configuration emits schema;
	 * administrators must verify the resulting page and choose one standard owner.
	 *
	 * @return bool True when standard site schema belongs to another integration.
	 */
	private function is_seo_plugin_active() {
		$detected = defined( 'RANK_MATH_FILE' ) || defined( 'WPSEO_VERSION' )
			|| class_exists( 'All_in_One_SEO_Pack' ) || function_exists( 'aioseo' )
			|| defined( 'SEOPRESS_VERSION' );
		return (bool) apply_filters( 'ppt_standard_schema_owned_by_seo', $detected );
	}

	/**
	 * Get Organization schema.
	 *
	 * @return array Organization schema data.
	 */
	private function get_organization_schema() {
		$schema = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Organization',
			'name'        => get_bloginfo( 'name' ),
			'description' => get_bloginfo( 'description' ),
			'url'         => home_url( '/' ),
			'sameAs'      => $this->get_social_urls(),
		);
		$logo_id  = (int) get_theme_mod( 'custom_logo' );
		$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : false;
		if ( $logo_url ) {
			$schema['logo'] = array( '@type' => 'ImageObject', 'url' => $logo_url );
		}
		return $schema;
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

		// Use the queried object, rather than a loop changed by a header block.
		$name = '';
		$url  = '';
		if ( is_singular() ) {
			$name = get_the_title( get_queried_object_id() );
			$url  = get_permalink( get_queried_object_id() );
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			if ( $term instanceof WP_Term ) {
				$name = $term->name;
				$url  = get_term_link( $term );
			}
		} elseif ( is_post_type_archive() && ! is_author() && ! is_date() ) {
			$type = get_queried_object();
			if ( $type instanceof WP_Post_Type ) {
				$name = $type->labels->name;
				$url  = get_post_type_archive_link( $type->name );
			}
		} elseif ( is_author() ) {
			$name = get_the_author_meta( 'display_name', get_queried_object_id() );
			$url  = get_author_posts_url( get_queried_object_id() );
		} elseif ( is_date() ) {
			$name = wp_strip_all_tags( get_the_archive_title() );
			$year = (int) get_query_var( 'year' );
			$month = (int) get_query_var( 'monthnum' );
			$day = (int) get_query_var( 'day' );
			$compact_date = (string) get_query_var( 'm' );
			if ( $compact_date ) {
				$year = (int) substr( $compact_date, 0, 4 );
				$month = (int) substr( $compact_date, 4, 2 );
				$day = (int) substr( $compact_date, 6, 2 );
			}
			if ( is_day() ) {
				$url = get_day_link( $year, $month, $day );
			} elseif ( is_month() ) {
				$url = get_month_link( $year, $month );
			} else {
				$url = get_year_link( $year );
			}
		} elseif ( is_home() ) {
			$posts_page = (int) get_option( 'page_for_posts' );
			$name = $posts_page ? get_the_title( $posts_page ) : __( 'Insights', 'people-planet-thrive' );
			$url = $posts_page ? get_permalink( $posts_page ) : home_url( '/' );
		} elseif ( is_search() ) {
			$name = sprintf( __( 'Search results for: %s', 'people-planet-thrive' ), get_search_query( false ) );
			$url = get_search_link();
		}
		if ( $name && $url && ! is_wp_error( $url ) ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => wp_strip_all_tags( $name ),
				'item'     => $url,
			);
		}
		// Do not emit an incomplete one-item breadcrumb on errors/unknown routes.
		if ( count( $items ) < 2 ) {
			return array();
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
	 * Get publication schema, using the editor's classification.
	 *
	 * @return array Book schema data.
	 */
	private function get_book_schema() {
		$post_id = get_the_ID();
		$terms = wp_get_object_terms( $post_id, 'ppt_publication_type', array( 'fields' => 'slugs' ) );
		$terms = is_wp_error( $terms ) ? array() : $terms;
		$type = 'CreativeWork';
		if ( array_intersect( array( 'books', 'e-books' ), $terms ) ) {
			$type = 'Book';
		} elseif ( in_array( 'research-reports', $terms, true ) ) {
			$type = 'Report';
		} elseif ( empty( $terms ) ) {
			// Older content may have a format but no publication-type term.
			$format = get_post_meta( $post_id, '_ppt_publication_format', true );
			if ( in_array( $format, array( 'book', 'ebook', 'monograph', 'paperback', 'hardback' ), true ) ) {
				$type = 'Book';
			} elseif ( 'report' === $format ) {
				$type = 'Report';
			}
		}

		$schema = array(
			'@context'  => 'https://schema.org',
			'@type'     => $type,
			'name'      => get_the_title(),
			'description' => get_the_excerpt(),
			'url'       => get_permalink(),
			'publisher' => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
			),
		);

		// ISBN belongs to Books, using the same field as the publication editor.
		$isbn = get_post_meta( $post_id, '_ppt_publication_isbn', true );
		if ( 'Book' === $type && $isbn ) {
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
