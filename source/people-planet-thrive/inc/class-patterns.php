<?php
/**
 * Block Patterns Registration
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Patterns
 *
 * Registers custom block patterns for the block editor.
 */
class PPT_Patterns {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_pattern_categories' ) );
		add_action( 'init', array( $this, 'register_patterns' ) );
	}

	/**
	 * Register pattern categories.
	 */
	public function register_pattern_categories() {
		register_block_pattern_category(
			'ppt-hero',
			array(
				'label' => esc_html__( 'PPT Hero Sections', 'people-planet-thrive' ),
			)
		);

		register_block_pattern_category(
			'ppt-sections',
			array(
				'label' => esc_html__( 'PPT Content Sections', 'people-planet-thrive' ),
			)
		);

		register_block_pattern_category(
			'ppt-cards',
			array(
				'label' => esc_html__( 'PPT Card Layouts', 'people-planet-thrive' ),
			)
		);

		register_block_pattern_category(
			'ppt-cta',
			array(
				'label' => esc_html__( 'PPT Calls to Action', 'people-planet-thrive' ),
			)
		);

		register_block_pattern_category(
			'ppt-scholarly',
			array(
				'label' => esc_html__( 'PPT Scholarly', 'people-planet-thrive' ),
			)
		);

		register_block_pattern_category(
			'ppt-homepage',
			array(
				'label' => esc_html__( 'PPT Homepage', 'people-planet-thrive' ),
			)
		);
	}

	/**
	 * Register block patterns.
	 */
	public function register_patterns() {
		// Hero — Default.
		register_block_pattern(
			'ppt/hero-default',
			array(
				'title'       => esc_html__( 'Hero — Default', 'people-planet-thrive' ),
				'description' => esc_html__( 'A full-width hero section with heading, description, and call to action.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-hero' ),
				'content'     => $this->get_pattern_content( 'hero-default.php' ),
			)
		);

		// Section — Content with Image.
		register_block_pattern(
			'ppt/section-content-image',
			array(
				'title'       => esc_html__( 'Section — Content with Image', 'people-planet-thrive' ),
				'description' => esc_html__( 'Two-column section with text content and image.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-sections' ),
				'content'     => $this->get_pattern_content( 'section-content-image.php' ),
			)
		);

		// CTA — Newsletter.
		register_block_pattern(
			'ppt/cta-newsletter',
			array(
				'title'       => esc_html__( 'CTA — Newsletter', 'people-planet-thrive' ),
				'description' => esc_html__( 'Newsletter signup call to action.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-cta' ),
				'content'     => $this->get_pattern_content( 'cta-newsletter.php' ),
			)
		);

		// Cards — Three Column.
		register_block_pattern(
			'ppt/cards-three-column',
			array(
				'title'       => esc_html__( 'Cards — Three Column', 'people-planet-thrive' ),
				'description' => esc_html__( 'Three-column card layout for features or highlights.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-cards' ),
				'content'     => $this->get_pattern_content( 'cards-three-column.php' ),
			)
		);

		// Hero — Image Background.
		register_block_pattern(
			'ppt/hero-image-background',
			array(
				'title'       => esc_html__( 'Hero — Image Background', 'people-planet-thrive' ),
				'description' => esc_html__( 'Hero section with background image and overlay.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-hero' ),
				'content'     => $this->get_pattern_content( 'hero-image-background.php' ),
			)
		);

		// Section — Stats.
		register_block_pattern(
			'ppt/section-stats',
			array(
				'title'       => esc_html__( 'Section — Statistics', 'people-planet-thrive' ),
				'description' => esc_html__( 'Statistics and impact metrics section.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-sections' ),
				'content'     => $this->get_pattern_content( 'section-stats.php' ),
			)
		);

		// Section — Testimonial.
		register_block_pattern(
			'ppt/section-testimonial',
			array(
				'title'       => esc_html__( 'Section — Testimonial', 'people-planet-thrive' ),
				'description' => esc_html__( 'Testimonial or quote section.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-sections' ),
				'content'     => $this->get_pattern_content( 'section-testimonial.php' ),
			)
		);

		// Section — Feature List.
		register_block_pattern(
			'ppt/section-feature-list',
			array(
				'title'       => esc_html__( 'Section — Feature List', 'people-planet-thrive' ),
				'description' => esc_html__( 'Feature list with heading, description, and bullet points.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-sections' ),
				'content'     => $this->get_pattern_content( 'section-feature-list.php' ),
			)
		);

		// Scholarly — Article Meta.
		register_block_pattern(
			'ppt/scholarly-article-meta',
			array(
				'title'       => esc_html__( 'Scholarly — Article Metadata', 'people-planet-thrive' ),
				'description' => esc_html__( 'Metadata display for scholarly articles.', 'people-planet-thrive' ),
				'categories'  => array( 'ppt-scholarly' ),
				'content'     => $this->get_pattern_content( 'scholarly-article-meta.php' ),
			)
		);

		// Homepage Patterns
		$homepage_patterns = array(
			'home-hero'                 => 'Homepage Hero',
			'home-introduction'         => 'Homepage Introduction',
			'home-what-we-do'           => 'Homepage What We Do',
			'home-featured-research'    => 'Homepage Featured Research',
			'home-latest-articles'      => 'Homepage Latest Articles',
			'home-featured-publications' => 'Homepage Featured Publications',
			'home-research-themes'      => 'Homepage Research Themes',
			'home-training'             => 'Homepage Training',
			'home-impact'               => 'Homepage Impact',
			'home-latest-insights'      => 'Homepage Latest Insights',
			'home-upcoming-events'      => 'Homepage Upcoming Events',
			'home-partners'             => 'Homepage Partners',
			'home-newsletter'           => 'Homepage Newsletter',
			'home-final-cta'            => 'Homepage Final CTA',
		);

		foreach ( $homepage_patterns as $slug => $title ) {
			register_block_pattern(
				'ppt/' . $slug,
				array(
					'title'       => esc_html( $title ),
					'description' => esc_html( $title . ' section for homepage.' ),
					'categories'  => array( 'ppt-homepage' ),
					'content'     => $this->get_pattern_content( $slug . '.php' ),
				)
			);
		}
	}

	/**
	 * Get pattern content from file.
	 *
	 * @param string $filename Pattern file name.
	 * @return string Pattern content.
	 */
	private function get_pattern_content( $filename ) {
		$file = PPT_THEME_DIR . '/patterns/' . $filename;
		if ( file_exists( $file ) ) {
			ob_start();
			include $file;
			return ob_get_clean();
		}
		return '';
	}
}
