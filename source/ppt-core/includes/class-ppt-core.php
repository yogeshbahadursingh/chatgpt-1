<?php
/**
 * Main Plugin Class
 *
 * @package PPTCore
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Core
 *
 * Core plugin class. Singleton pattern.
 * Manages plugin lifecycle, hooks, and component initialisation.
 */
final class PPT_Core {

	/**
	 * Singleton instance.
	 *
	 * @var PPT_Core|null
	 */
	private static ?PPT_Core $instance = null;

	/**
	 * Hook loader.
	 *
	 * @var PPT_Loader
	 */
	private PPT_Loader $loader;

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	private string $version;

	/**
	 * Get singleton instance.
	 *
	 * @return PPT_Core
	 */
	public static function get_instance(): PPT_Core {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Private constructor — use get_instance().
	 */
	private function __construct() {
		$this->version = PPT_CORE_VERSION;
		$this->loader  = new PPT_Loader();

		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_content_hooks();

		$this->loader->run();
	}

	/**
	 * Get the loader.
	 *
	 * @return PPT_Loader
	 */
	public function get_loader(): PPT_Loader {
		return $this->loader;
	}

	/**
	 * Get plugin version.
	 *
	 * @return string
	 */
	public function get_version(): string {
		return $this->version;
	}

	/**
	 * Set plugin internationalisation.
	 */
	private function set_locale(): void {
		$i18n = new PPT_i18n();
		$this->loader->add_action( 'plugins_loaded', $i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register admin-specific hooks.
	 */
	private function define_admin_hooks(): void {
		if ( ! is_admin() ) {
			return;
		}

		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_admin_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_admin_scripts' );
		$this->loader->add_action( 'admin_menu', $this, 'register_admin_menu' );
	}

	/**
	 * Register public-facing hooks.
	 */
	private function define_public_hooks(): void {
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_public_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_public_scripts' );
	}

	/**
	 * Register content model hooks (CPTs, taxonomies, meta).
	 */
	private function define_content_hooks(): void {
		$this->loader->add_action( 'init', $this, 'register_post_types' );
		$this->loader->add_action( 'init', $this, 'register_taxonomies' );
		$this->loader->add_action( 'init', $this, 'register_meta_fields' );
		$this->loader->add_action( 'rest_api_init', $this, 'register_rest_fields' );
	}

	/**
	 * Register custom post types.
	 *
	 * Foundation phase: register a minimal set to establish the pattern.
	 * Additional CPTs will be added in subsequent phases.
	 */
	public function register_post_types(): void {
		// Journal — scholarly journal publication.
		register_post_type(
			'ppt_journal',
			array(
				'labels'       => array(
					'name'               => esc_html__( 'Journals', 'ppt-core' ),
					'singular_name'      => esc_html__( 'Journal', 'ppt-core' ),
					'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
					'add_new_item'       => esc_html__( 'Add New Journal', 'ppt-core' ),
					'edit_item'          => esc_html__( 'Edit Journal', 'ppt-core' ),
					'new_item'           => esc_html__( 'New Journal', 'ppt-core' ),
					'view_item'          => esc_html__( 'View Journal', 'ppt-core' ),
					'search_items'       => esc_html__( 'Search Journals', 'ppt-core' ),
					'not_found'          => esc_html__( 'No journals found.', 'ppt-core' ),
					'not_found_in_trash' => esc_html__( 'No journals found in Trash.', 'ppt-core' ),
					'all_items'          => esc_html__( 'All Journals', 'ppt-core' ),
					'menu_name'          => esc_html__( 'Journals', 'ppt-core' ),
					'name_admin_bar'     => esc_html__( 'Journal', 'ppt-core' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite' => array( 'slug' => 'journals', 'with_front' => false ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
				'menu_icon'    => 'dashicons-book-alt',
				'menu_position' => 5,
				'capability_type' => 'post',
				'map_meta_cap'    => true,
			)
		);

		// Journal Issue — individual journal issue/volume.
		register_post_type(
			'ppt_journal_issue',
			array(
				'labels'       => array(
					'name'               => esc_html__( 'Journal Issues', 'ppt-core' ),
					'singular_name'      => esc_html__( 'Journal Issue', 'ppt-core' ),
					'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
					'add_new_item'       => esc_html__( 'Add New Issue', 'ppt-core' ),
					'edit_item'          => esc_html__( 'Edit Issue', 'ppt-core' ),
					'new_item'           => esc_html__( 'New Issue', 'ppt-core' ),
					'view_item'          => esc_html__( 'View Issue', 'ppt-core' ),
					'search_items'       => esc_html__( 'Search Issues', 'ppt-core' ),
					'not_found'          => esc_html__( 'No issues found.', 'ppt-core' ),
					'not_found_in_trash' => esc_html__( 'No issues found in Trash.', 'ppt-core' ),
					'all_items'          => esc_html__( 'All Issues', 'ppt-core' ),
					'menu_name'          => esc_html__( 'Issues', 'ppt-core' ),
					'name_admin_bar'     => esc_html__( 'Issue', 'ppt-core' ),
				),
				'public'       => true,
				'has_archive'  => false,
				'rewrite' => array( 'slug' => 'journal-issue', 'with_front' => false ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
				'hierarchical' => false,
				'menu_icon'    => 'dashicons-media-default',
				'show_in_menu' => 'edit.php?post_type=ppt_journal',
				'capability_type' => 'post',
				'map_meta_cap'    => true,
			)
		);

		// Article — scholarly article.
		register_post_type(
			'ppt_article',
			array(
				'labels'       => array(
					'name'               => esc_html__( 'Articles', 'ppt-core' ),
					'singular_name'      => esc_html__( 'Article', 'ppt-core' ),
					'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
					'add_new_item'       => esc_html__( 'Add New Article', 'ppt-core' ),
					'edit_item'          => esc_html__( 'Edit Article', 'ppt-core' ),
					'new_item'           => esc_html__( 'New Article', 'ppt-core' ),
					'view_item'          => esc_html__( 'View Article', 'ppt-core' ),
					'search_items'       => esc_html__( 'Search Articles', 'ppt-core' ),
					'not_found'          => esc_html__( 'No articles found.', 'ppt-core' ),
					'not_found_in_trash' => esc_html__( 'No articles found in Trash.', 'ppt-core' ),
					'all_items'          => esc_html__( 'All Articles', 'ppt-core' ),
					'menu_name'          => esc_html__( 'Articles', 'ppt-core' ),
					'name_admin_bar'     => esc_html__( 'Article', 'ppt-core' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite' => array( 'slug' => 'articles', 'with_front' => false ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'author' ),
				'menu_icon'    => 'dashicons-media-document',
				'menu_position' => 6,
				'capability_type' => 'post',
				'map_meta_cap'    => true,
			)
		);

		// Author — scholarly author/contributor.
		register_post_type(
			'ppt_author',
			array(
				'labels'       => array(
					'name'               => esc_html__( 'Authors', 'ppt-core' ),
					'singular_name'      => esc_html__( 'Author', 'ppt-core' ),
					'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
					'add_new_item'       => esc_html__( 'Add New Author', 'ppt-core' ),
					'edit_item'          => esc_html__( 'Edit Author', 'ppt-core' ),
					'new_item'           => esc_html__( 'New Author', 'ppt-core' ),
					'view_item'          => esc_html__( 'View Author', 'ppt-core' ),
					'search_items'       => esc_html__( 'Search Authors', 'ppt-core' ),
					'not_found'          => esc_html__( 'No authors found.', 'ppt-core' ),
					'not_found_in_trash' => esc_html__( 'No authors found in Trash.', 'ppt-core' ),
					'all_items'          => esc_html__( 'All Authors', 'ppt-core' ),
					'menu_name'          => esc_html__( 'Authors', 'ppt-core' ),
					'name_admin_bar'     => esc_html__( 'Author', 'ppt-core' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite' => array( 'slug' => 'authors', 'with_front' => false ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
				'menu_icon'    => 'dashicons-groups',
				'menu_position' => 7,
				'capability_type' => 'post',
				'map_meta_cap'    => true,
			)
		);

		// Research Area — research domains and fields.
		register_post_type(
			'ppt_research_area',
			array(
				'labels'       => array(
					'name'               => esc_html__( 'Research Areas', 'ppt-core' ),
					'singular_name'      => esc_html__( 'Research Area', 'ppt-core' ),
					'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
					'add_new_item'       => esc_html__( 'Add New Research Area', 'ppt-core' ),
					'edit_item'          => esc_html__( 'Edit Research Area', 'ppt-core' ),
					'new_item'           => esc_html__( 'New Research Area', 'ppt-core' ),
					'view_item'          => esc_html__( 'View Research Area', 'ppt-core' ),
					'search_items'       => esc_html__( 'Search Research Areas', 'ppt-core' ),
					'not_found'          => esc_html__( 'No research areas found.', 'ppt-core' ),
					'not_found_in_trash' => esc_html__( 'No research areas found in Trash.', 'ppt-core' ),
					'all_items'          => esc_html__( 'All Research Areas', 'ppt-core' ),
					'menu_name'          => esc_html__( 'Research', 'ppt-core' ),
					'name_admin_bar'     => esc_html__( 'Research Area', 'ppt-core' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite' => array( 'slug' => 'research-areas', 'with_front' => false ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
				'menu_icon'    => 'dashicons-lightbulb',
				'menu_position' => 8,
				'capability_type' => 'post',
				'map_meta_cap'    => true,
			)
		);

		// Research Project — individual research projects.
		register_post_type(
			'ppt_research_project',
			array(
				'labels'       => array(
					'name'               => esc_html__( 'Research Projects', 'ppt-core' ),
					'singular_name'      => esc_html__( 'Research Project', 'ppt-core' ),
					'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
					'add_new_item'       => esc_html__( 'Add New Project', 'ppt-core' ),
					'edit_item'          => esc_html__( 'Edit Project', 'ppt-core' ),
					'new_item'           => esc_html__( 'New Project', 'ppt-core' ),
					'view_item'          => esc_html__( 'View Project', 'ppt-core' ),
					'search_items'       => esc_html__( 'Search Projects', 'ppt-core' ),
					'not_found'          => esc_html__( 'No projects found.', 'ppt-core' ),
					'not_found_in_trash' => esc_html__( 'No projects found in Trash.', 'ppt-core' ),
					'all_items'          => esc_html__( 'All Projects', 'ppt-core' ),
					'menu_name'          => esc_html__( 'Projects', 'ppt-core' ),
					'name_admin_bar'     => esc_html__( 'Project', 'ppt-core' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite' => array( 'slug' => 'research-projects', 'with_front' => false ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
				'menu_icon'    => 'dashicons-clipboard',
				'show_in_menu' => 'edit.php?post_type=ppt_research_area',
				'capability_type' => 'post',
				'map_meta_cap'    => true,
			)
		);

		// Researcher — researchers and team members.
		register_post_type(
			'ppt_researcher',
			array(
				'labels'       => array(
					'name'               => esc_html__( 'Researchers', 'ppt-core' ),
					'singular_name'      => esc_html__( 'Researcher', 'ppt-core' ),
					'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
					'add_new_item'       => esc_html__( 'Add New Researcher', 'ppt-core' ),
					'edit_item'          => esc_html__( 'Edit Researcher', 'ppt-core' ),
					'new_item'           => esc_html__( 'New Researcher', 'ppt-core' ),
					'view_item'          => esc_html__( 'View Researcher', 'ppt-core' ),
					'search_items'       => esc_html__( 'Search Researchers', 'ppt-core' ),
					'not_found'          => esc_html__( 'No researchers found.', 'ppt-core' ),
					'not_found_in_trash' => esc_html__( 'No researchers found in Trash.', 'ppt-core' ),
					'all_items'          => esc_html__( 'All Researchers', 'ppt-core' ),
					'menu_name'          => esc_html__( 'Researchers', 'ppt-core' ),
					'name_admin_bar'     => esc_html__( 'Researcher', 'ppt-core' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite' => array( 'slug' => 'researchers', 'with_front' => false ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
			'menu_icon'    => 'dashicons-id',
			'show_in_menu' => 'edit.php?post_type=ppt_research_area',
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		)
	);

	// Publication — books, reports, e-books, etc.
	register_post_type(
		'ppt_publication',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Publications', 'ppt-core' ),
				'singular_name'      => esc_html__( 'Publication', 'ppt-core' ),
				'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
				'add_new_item'       => esc_html__( 'Add New Publication', 'ppt-core' ),
				'edit_item'          => esc_html__( 'Edit Publication', 'ppt-core' ),
				'new_item'           => esc_html__( 'New Publication', 'ppt-core' ),
				'view_item'          => esc_html__( 'View Publication', 'ppt-core' ),
				'search_items'       => esc_html__( 'Search Publications', 'ppt-core' ),
				'not_found'          => esc_html__( 'No publications found.', 'ppt-core' ),
				'not_found_in_trash' => esc_html__( 'No publications found in Trash.', 'ppt-core' ),
				'all_items'          => esc_html__( 'All Publications', 'ppt-core' ),
				'menu_name'          => esc_html__( 'Publications', 'ppt-core' ),
				'name_admin_bar'     => esc_html__( 'Publication', 'ppt-core' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite' => array( 'slug' => 'publications', 'with_front' => false ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
			'menu_icon'    => 'dashicons-book',
			'menu_position' => 9,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		)
	);

	// Training — courses, workshops, webinars, etc.
	register_post_type(
		'ppt_training',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Training', 'ppt-core' ),
				'singular_name'      => esc_html__( 'Training', 'ppt-core' ),
				'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
				'add_new_item'       => esc_html__( 'Add New Training', 'ppt-core' ),
				'edit_item'          => esc_html__( 'Edit Training', 'ppt-core' ),
				'new_item'           => esc_html__( 'New Training', 'ppt-core' ),
				'view_item'          => esc_html__( 'View Training', 'ppt-core' ),
				'search_items'       => esc_html__( 'Search Training', 'ppt-core' ),
				'not_found'          => esc_html__( 'No training found.', 'ppt-core' ),
				'not_found_in_trash' => esc_html__( 'No training found in Trash.', 'ppt-core' ),
				'all_items'          => esc_html__( 'All Training', 'ppt-core' ),
				'menu_name'          => esc_html__( 'Training', 'ppt-core' ),
				'name_admin_bar'     => esc_html__( 'Training', 'ppt-core' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite' => array( 'slug' => 'training', 'with_front' => false ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
			'menu_icon'    => 'dashicons-welcome-learn-more',
			'menu_position' => 10,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		)
	);

	// Event — conferences, seminars, webinars, etc.
	register_post_type(
		'ppt_event',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Events', 'ppt-core' ),
				'singular_name'      => esc_html__( 'Event', 'ppt-core' ),
				'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
				'add_new_item'       => esc_html__( 'Add New Event', 'ppt-core' ),
				'edit_item'          => esc_html__( 'Edit Event', 'ppt-core' ),
				'new_item'           => esc_html__( 'New Event', 'ppt-core' ),
				'view_item'          => esc_html__( 'View Event', 'ppt-core' ),
				'search_items'       => esc_html__( 'Search Events', 'ppt-core' ),
				'not_found'          => esc_html__( 'No events found.', 'ppt-core' ),
				'not_found_in_trash' => esc_html__( 'No events found in Trash.', 'ppt-core' ),
				'all_items'          => esc_html__( 'All Events', 'ppt-core' ),
				'menu_name'          => esc_html__( 'Events', 'ppt-core' ),
				'name_admin_bar'     => esc_html__( 'Event', 'ppt-core' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite' => array( 'slug' => 'events', 'with_front' => false ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
			'menu_icon'    => 'dashicons-calendar-alt',
			'menu_position' => 11,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		)
	);

	// Team Member — staff and leadership profiles
	register_post_type(
		'ppt_team_member',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Team Members', 'ppt-core' ),
				'singular_name'      => esc_html__( 'Team Member', 'ppt-core' ),
				'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
				'add_new_item'       => esc_html__( 'Add New Team Member', 'ppt-core' ),
				'edit_item'          => esc_html__( 'Edit Team Member', 'ppt-core' ),
				'new_item'           => esc_html__( 'New Team Member', 'ppt-core' ),
				'view_item'          => esc_html__( 'View Team Member', 'ppt-core' ),
				'search_items'       => esc_html__( 'Search Team Members', 'ppt-core' ),
				'not_found'          => esc_html__( 'No team members found.', 'ppt-core' ),
				'not_found_in_trash' => esc_html__( 'No team members found in Trash.', 'ppt-core' ),
				'all_items'          => esc_html__( 'All Team Members', 'ppt-core' ),
				'menu_name'          => esc_html__( 'Team', 'ppt-core' ),
				'name_admin_bar'     => esc_html__( 'Team Member', 'ppt-core' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite' => array( 'slug' => 'team', 'with_front' => false ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
			'menu_icon'    => 'dashicons-groups',
			'menu_position' => 12,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		)
	);

	// Partner — partner organizations
	register_post_type(
		'ppt_partner',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Partners', 'ppt-core' ),
				'singular_name'      => esc_html__( 'Partner', 'ppt-core' ),
				'add_new'            => esc_html__( 'Add New', 'ppt-core' ),
				'add_new_item'       => esc_html__( 'Add New Partner', 'ppt-core' ),
				'edit_item'          => esc_html__( 'Edit Partner', 'ppt-core' ),
				'new_item'           => esc_html__( 'New Partner', 'ppt-core' ),
				'view_item'          => esc_html__( 'View Partner', 'ppt-core' ),
				'search_items'       => esc_html__( 'Search Partners', 'ppt-core' ),
				'not_found'          => esc_html__( 'No partners found.', 'ppt-core' ),
				'not_found_in_trash' => esc_html__( 'No partners found in Trash.', 'ppt-core' ),
				'all_items'          => esc_html__( 'All Partners', 'ppt-core' ),
				'menu_name'          => esc_html__( 'Partners', 'ppt-core' ),
				'name_admin_bar'     => esc_html__( 'Partner', 'ppt-core' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite' => array( 'slug' => 'partners', 'with_front' => false ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
			'menu_icon'    => 'dashicons-networking',
			'menu_position' => 13,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		)
	);
}

/**
 * Register taxonomies.	 *
	 * Foundation phase: register a minimal set.
	 */
	public function register_taxonomies(): void {
		// Journal Category — applies to journals, issues, and articles.
		register_taxonomy(
			'ppt_journal_category',
			array( 'ppt_journal', 'ppt_article' ),
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Journal Categories', 'ppt-core' ),
					'singular_name' => esc_html__( 'Journal Category', 'ppt-core' ),
					'search_items'  => esc_html__( 'Search Categories', 'ppt-core' ),
					'all_items'     => esc_html__( 'All Categories', 'ppt-core' ),
					'edit_item'     => esc_html__( 'Edit Category', 'ppt-core' ),
					'update_item'   => esc_html__( 'Update Category', 'ppt-core' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'ppt-core' ),
					'new_item_name' => esc_html__( 'New Category Name', 'ppt-core' ),
					'menu_name'     => esc_html__( 'Categories', 'ppt-core' ),
				),
				'hierarchical' => true,
				'public'       => true,
				'show_in_rest' => true,
				'show_admin_column' => true,
				'rewrite' => array( 'slug' => 'journal-category', 'with_front' => false ),
			)
		);

		// Article Type — applies to articles.
		register_taxonomy(
			'ppt_article_type',
			'ppt_article',
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Article Types', 'ppt-core' ),
					'singular_name' => esc_html__( 'Article Type', 'ppt-core' ),
					'search_items'  => esc_html__( 'Search Types', 'ppt-core' ),
					'all_items'     => esc_html__( 'All Types', 'ppt-core' ),
					'edit_item'     => esc_html__( 'Edit Type', 'ppt-core' ),
					'update_item'   => esc_html__( 'Update Type', 'ppt-core' ),
					'add_new_item'  => esc_html__( 'Add New Type', 'ppt-core' ),
					'new_item_name' => esc_html__( 'New Type Name', 'ppt-core' ),
					'menu_name'     => esc_html__( 'Article Types', 'ppt-core' ),
				),
				'hierarchical' => false,
				'public'       => true,
				'show_in_rest' => true,
				'show_admin_column' => true,
				'rewrite' => array( 'slug' => 'article-type', 'with_front' => false ),
			)
		);

		// Subject Area — hierarchical taxonomy for research domains.
		register_taxonomy(
			'ppt_subject_area',
			array( 'ppt_article', 'ppt_journal' ),
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Subject Areas', 'ppt-core' ),
					'singular_name' => esc_html__( 'Subject Area', 'ppt-core' ),
					'search_items'  => esc_html__( 'Search Subject Areas', 'ppt-core' ),
					'all_items'     => esc_html__( 'All Subject Areas', 'ppt-core' ),
					'parent_item'   => esc_html__( 'Parent Subject Area', 'ppt-core' ),
					'parent_item_colon' => esc_html__( 'Parent Subject Area:', 'ppt-core' ),
					'edit_item'     => esc_html__( 'Edit Subject Area', 'ppt-core' ),
					'update_item'   => esc_html__( 'Update Subject Area', 'ppt-core' ),
					'add_new_item'  => esc_html__( 'Add New Subject Area', 'ppt-core' ),
					'new_item_name' => esc_html__( 'New Subject Area Name', 'ppt-core' ),
					'menu_name'     => esc_html__( 'Subject Areas', 'ppt-core' ),
				),
			'hierarchical' => true,
			'public'       => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite' => array( 'slug' => 'subject-area', 'with_front' => false ),
		)
	);

	// Publication Type — applies to publications.
	register_taxonomy(
		'ppt_publication_type',
		'ppt_publication',
		array(
			'labels'       => array(
				'name'          => esc_html__( 'Publication Types', 'ppt-core' ),
				'singular_name' => esc_html__( 'Publication Type', 'ppt-core' ),
				'search_items'  => esc_html__( 'Search Types', 'ppt-core' ),
				'all_items'     => esc_html__( 'All Types', 'ppt-core' ),
				'edit_item'     => esc_html__( 'Edit Type', 'ppt-core' ),
				'update_item'   => esc_html__( 'Update Type', 'ppt-core' ),
				'add_new_item'  => esc_html__( 'Add New Type', 'ppt-core' ),
				'new_item_name' => esc_html__( 'New Type Name', 'ppt-core' ),
				'menu_name'     => esc_html__( 'Publication Types', 'ppt-core' ),
			),
			'hierarchical' => false,
			'public'       => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite' => array( 'slug' => 'publication-type', 'with_front' => false ),
		)
	);

	// Training Type — applies to training.
	register_taxonomy(
		'ppt_training_type',
		'ppt_training',
		array(
			'labels'       => array(
				'name'          => esc_html__( 'Training Types', 'ppt-core' ),
				'singular_name' => esc_html__( 'Training Type', 'ppt-core' ),
				'search_items'  => esc_html__( 'Search Types', 'ppt-core' ),
				'all_items'     => esc_html__( 'All Types', 'ppt-core' ),
				'edit_item'     => esc_html__( 'Edit Type', 'ppt-core' ),
				'update_item'   => esc_html__( 'Update Type', 'ppt-core' ),
				'add_new_item'  => esc_html__( 'Add New Type', 'ppt-core' ),
				'new_item_name' => esc_html__( 'New Type Name', 'ppt-core' ),
				'menu_name'     => esc_html__( 'Training Types', 'ppt-core' ),
			),
			'hierarchical' => false,
			'public'       => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite' => array( 'slug' => 'training-type', 'with_front' => false ),
		)
	);

	// Event Type — applies to events.
	register_taxonomy(
		'ppt_event_type',
		'ppt_event',
		array(
			'labels'       => array(
				'name'          => esc_html__( 'Event Types', 'ppt-core' ),
				'singular_name' => esc_html__( 'Event Type', 'ppt-core' ),
				'search_items'  => esc_html__( 'Search Types', 'ppt-core' ),
				'all_items'     => esc_html__( 'All Types', 'ppt-core' ),
				'edit_item'     => esc_html__( 'Edit Type', 'ppt-core' ),
				'update_item'   => esc_html__( 'Update Type', 'ppt-core' ),
				'add_new_item'  => esc_html__( 'Add New Type', 'ppt-core' ),
				'new_item_name' => esc_html__( 'New Type Name', 'ppt-core' ),
				'menu_name'     => esc_html__( 'Event Types', 'ppt-core' ),
			),
			'hierarchical' => false,
			'public'       => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite' => array( 'slug' => 'event-type', 'with_front' => false ),
		)
	);
}

/**
 * Register meta fields for REST API.	 *
	 * Foundation phase: register meta for the two example CPTs.
	 */
	public function register_meta_fields(): void {
		// Journal meta fields.
		$journal_meta = array(
			'_ppt_issn'             => 'string',
			'_ppt_eissn'            => 'string',
			'_ppt_frequency'        => 'string',
			'_ppt_editor_name'      => 'string',
			'_ppt_aims_scope'       => 'string',
			'_ppt_editorial_board'  => 'string',
			'_ppt_policies'         => 'string',
			'_ppt_author_guidelines' => 'string',
			'_ppt_submission_info'  => 'string',
			'_ppt_current_issue_id' => 'integer',
		);

		foreach ( $journal_meta as $key => $type ) {
			register_post_meta(
				'ppt_journal',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Journal Issue meta fields.
		$issue_meta = array(
			'_ppt_volume'         => 'string',
			'_ppt_issue_number'   => 'string',
			'_ppt_publication_date' => 'string',
			'_ppt_journal_id'     => 'integer',
		);

		foreach ( $issue_meta as $key => $type ) {
			register_post_meta(
				'ppt_journal_issue',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Article meta fields — comprehensive scholarly metadata.
		$article_meta = array(
			'_ppt_doi'              => 'string',
			'_ppt_abstract'         => 'string',
			'_ppt_keywords'         => 'string',
			'_ppt_pdf_url'          => 'string',
			'_ppt_fulltext_url'     => 'string',
			'_ppt_volume'           => 'string',
			'_ppt_issue_number'     => 'string',
			'_ppt_page_start'       => 'string',
			'_ppt_page_end'         => 'string',
			'_ppt_received_date'    => 'string',
			'_ppt_accepted_date'    => 'string',
			'_ppt_published_date'   => 'string',
			'_ppt_journal_id'       => 'integer',
			'_ppt_issue_id'         => 'integer',
			'_ppt_authors'          => 'string', // Comma-separated author IDs
			'_ppt_references'       => 'string',
			'_ppt_supplementary'    => 'string',
			'_ppt_citation_format'  => 'string',
		);

		foreach ( $article_meta as $key => $type ) {
			register_post_meta(
				'ppt_article',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Author meta fields.
		$author_meta = array(
			'_ppt_orcid'        => 'string',
			'_ppt_affiliation'  => 'string',
			'_ppt_position'     => 'string',
			'_ppt_google_scholar' => 'string',
			'_ppt_research_gate'  => 'string',
			'_ppt_website'      => 'string',
		);

		foreach ( $author_meta as $key => $type ) {
			register_post_meta(
				'ppt_author',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Research Area meta fields.
		$research_area_meta = array(
			'_ppt_area_description' => 'string',
			'_ppt_area_keywords'    => 'string',
		);

		foreach ( $research_area_meta as $key => $type ) {
			register_post_meta(
				'ppt_research_area',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Research Project meta fields.
		$project_meta = array(
			'_ppt_project_status'        => 'string',
			'_ppt_project_start_date'    => 'string',
			'_ppt_project_end_date'      => 'string',
			'_ppt_project_lead_id'       => 'integer',
			'_ppt_project_team'          => 'string', // Comma-separated researcher IDs
			'_ppt_project_collaborators' => 'string',
			'_ppt_project_funding'       => 'string',
			'_ppt_project_methodology'   => 'string',
			'_ppt_project_timeline'      => 'string',
			'_ppt_project_area_id'       => 'integer',
			'_ppt_project_outputs'       => 'string',
			'_ppt_project_reports'       => 'string',
		);

		foreach ( $project_meta as $key => $type ) {
			register_post_meta(
				'ppt_research_project',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Researcher meta fields.
		$researcher_meta = array(
			'_ppt_researcher_orcid'      => 'string',
			'_ppt_researcher_role'       => 'string',
			'_ppt_researcher_expertise'  => 'string',
			'_ppt_researcher_bio'        => 'string',
			'_ppt_researcher_selected_work' => 'string',
			'_ppt_researcher_projects'   => 'string', // Comma-separated project IDs
		);

		foreach ( $researcher_meta as $key => $type ) {
			register_post_meta(
				'ppt_researcher',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Publication meta fields.
		$publication_meta = array(
			'_ppt_publication_isbn'       => 'string',
			'_ppt_publication_format'     => 'string', // book, ebook, report, policy brief, monograph, journal issue
			'_ppt_publication_pages'      => 'integer',
			'_ppt_publication_date'       => 'string',
			'_ppt_publication_publisher'  => 'string',
			'_ppt_publication_editors'    => 'string', // Comma-separated author/editor names
			'_ppt_publication_price'      => 'string',
			'_ppt_publication_is_free'    => 'boolean',
			'_ppt_publication_file_url'   => 'string', // URL to downloadable file
			'_ppt_publication_product_id' => 'integer', // Linked WooCommerce product ID
		);

		foreach ( $publication_meta as $key => $type ) {
			register_post_meta(
				'ppt_publication',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Training meta fields.
		$training_meta = array(
			'_ppt_training_instructor'      => 'string',
			'_ppt_training_learning_outcomes' => 'string',
			'_ppt_training_audience'        => 'string',
			'_ppt_training_level'           => 'string', // beginner, intermediate, advanced
			'_ppt_training_duration'        => 'string',
			'_ppt_training_delivery_mode'   => 'string', // online, in-person, hybrid
			'_ppt_training_start_date'      => 'string',
			'_ppt_training_end_date'        => 'string',
			'_ppt_training_location'        => 'string',
			'_ppt_training_capacity'        => 'integer',
			'_ppt_training_price'           => 'string',
			'_ppt_training_is_free'         => 'boolean',
			'_ppt_training_registration_url' => 'string',
			'_ppt_training_product_id'      => 'integer', // Linked WooCommerce product ID
		);

		foreach ( $training_meta as $key => $type ) {
			register_post_meta(
				'ppt_training',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Event meta fields.
		$event_meta = array(
			'_ppt_event_organizer'          => 'string',
			'_ppt_event_start_date'         => 'string',
			'_ppt_event_end_date'           => 'string',
			'_ppt_event_start_time'         => 'string',
			'_ppt_event_end_time'           => 'string',
			'_ppt_event_location'           => 'string',
			'_ppt_event_is_virtual'         => 'boolean',
			'_ppt_event_virtual_url'        => 'string',
			'_ppt_event_capacity'           => 'integer',
			'_ppt_event_price'              => 'string',
			'_ppt_event_is_free'            => 'boolean',
			'_ppt_event_registration_url'   => 'string',
			'_ppt_event_product_id'         => 'integer', // Linked WooCommerce product ID
		);

		foreach ( $event_meta as $key => $type ) {
			register_post_meta(
				'ppt_event',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Team Member meta fields.
		$team_meta = array(
			'_ppt_team_role'         => 'string',
			'_ppt_team_department'   => 'string',
			'_ppt_team_email'        => 'string',
			'_ppt_team_linkedin'     => 'string',
			'_ppt_team_is_leadership' => 'boolean',
		);

		foreach ( $team_meta as $key => $type ) {
			register_post_meta(
				'ppt_team_member',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}

		// Partner meta fields.
		$partner_meta = array(
			'_ppt_partner_type'    => 'string',
			'_ppt_partner_website' => 'string',
		);

		foreach ( $partner_meta as $key => $type ) {
			register_post_meta(
				'ppt_partner',
				$key,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function ( $allowed, $key, $id ) { return current_user_can( 'edit_post', $id ); },
				)
			);
		}
	}

	/**
	 * Register REST API additional fields.
	 */
	public function register_rest_fields(): void {
		// Article REST fields.
		register_rest_field(
			'ppt_article',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'doi'              => get_post_meta( $post['id'], '_ppt_doi', true ),
						'abstract'         => get_post_meta( $post['id'], '_ppt_abstract', true ),
						'keywords'         => get_post_meta( $post['id'], '_ppt_keywords', true ),
						'pdf_url'          => get_post_meta( $post['id'], '_ppt_pdf_url', true ),
						'fulltext_url'     => get_post_meta( $post['id'], '_ppt_fulltext_url', true ),
						'volume'           => get_post_meta( $post['id'], '_ppt_volume', true ),
						'issue_number'     => get_post_meta( $post['id'], '_ppt_issue_number', true ),
						'page_start'       => get_post_meta( $post['id'], '_ppt_page_start', true ),
						'page_end'         => get_post_meta( $post['id'], '_ppt_page_end', true ),
						'received_date'    => get_post_meta( $post['id'], '_ppt_received_date', true ),
						'accepted_date'    => get_post_meta( $post['id'], '_ppt_accepted_date', true ),
						'published_date'   => get_post_meta( $post['id'], '_ppt_published_date', true ),
						'journal_id'       => get_post_meta( $post['id'], '_ppt_journal_id', true ),
						'issue_id'         => get_post_meta( $post['id'], '_ppt_issue_id', true ),
						'authors'          => get_post_meta( $post['id'], '_ppt_authors', true ),
						'references'       => get_post_meta( $post['id'], '_ppt_references', true ),
						'supplementary'    => get_post_meta( $post['id'], '_ppt_supplementary', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Article scholarly metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Journal REST fields.
		register_rest_field(
			'ppt_journal',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'issn'              => get_post_meta( $post['id'], '_ppt_issn', true ),
						'eissn'             => get_post_meta( $post['id'], '_ppt_eissn', true ),
						'frequency'         => get_post_meta( $post['id'], '_ppt_frequency', true ),
						'editor_name'       => get_post_meta( $post['id'], '_ppt_editor_name', true ),
						'aims_scope'        => get_post_meta( $post['id'], '_ppt_aims_scope', true ),
						'editorial_board'   => get_post_meta( $post['id'], '_ppt_editorial_board', true ),
						'policies'          => get_post_meta( $post['id'], '_ppt_policies', true ),
						'author_guidelines' => get_post_meta( $post['id'], '_ppt_author_guidelines', true ),
						'submission_info'   => get_post_meta( $post['id'], '_ppt_submission_info', true ),
						'current_issue_id'  => get_post_meta( $post['id'], '_ppt_current_issue_id', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Journal metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Journal Issue REST fields.
		register_rest_field(
			'ppt_journal_issue',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'volume'           => get_post_meta( $post['id'], '_ppt_volume', true ),
						'issue_number'     => get_post_meta( $post['id'], '_ppt_issue_number', true ),
						'publication_date' => get_post_meta( $post['id'], '_ppt_publication_date', true ),
						'journal_id'       => get_post_meta( $post['id'], '_ppt_journal_id', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Journal issue metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Author REST fields.
		register_rest_field(
			'ppt_author',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'orcid'          => get_post_meta( $post['id'], '_ppt_orcid', true ),
						'affiliation'    => get_post_meta( $post['id'], '_ppt_affiliation', true ),
						'position'       => get_post_meta( $post['id'], '_ppt_position', true ),
						'google_scholar' => get_post_meta( $post['id'], '_ppt_google_scholar', true ),
						'research_gate'  => get_post_meta( $post['id'], '_ppt_research_gate', true ),
						'website'        => get_post_meta( $post['id'], '_ppt_website', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Author metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Research Area REST fields.
		register_rest_field(
			'ppt_research_area',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'description' => get_post_meta( $post['id'], '_ppt_area_description', true ),
						'keywords'    => get_post_meta( $post['id'], '_ppt_area_keywords', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Research area metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Research Project REST fields.
		register_rest_field(
			'ppt_research_project',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'status'        => get_post_meta( $post['id'], '_ppt_project_status', true ),
						'start_date'    => get_post_meta( $post['id'], '_ppt_project_start_date', true ),
						'end_date'      => get_post_meta( $post['id'], '_ppt_project_end_date', true ),
						'lead_id'       => get_post_meta( $post['id'], '_ppt_project_lead_id', true ),
						'team'          => get_post_meta( $post['id'], '_ppt_project_team', true ),
						'collaborators' => get_post_meta( $post['id'], '_ppt_project_collaborators', true ),
						'funding'       => get_post_meta( $post['id'], '_ppt_project_funding', true ),
						'methodology'   => get_post_meta( $post['id'], '_ppt_project_methodology', true ),
						'timeline'      => get_post_meta( $post['id'], '_ppt_project_timeline', true ),
						'area_id'       => get_post_meta( $post['id'], '_ppt_project_area_id', true ),
						'outputs'       => get_post_meta( $post['id'], '_ppt_project_outputs', true ),
						'reports'       => get_post_meta( $post['id'], '_ppt_project_reports', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Research project metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Researcher REST fields.
		register_rest_field(
			'ppt_researcher',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'orcid'         => get_post_meta( $post['id'], '_ppt_researcher_orcid', true ),
						'role'          => get_post_meta( $post['id'], '_ppt_researcher_role', true ),
						'expertise'     => get_post_meta( $post['id'], '_ppt_researcher_expertise', true ),
						'bio'           => get_post_meta( $post['id'], '_ppt_researcher_bio', true ),
						'selected_work' => get_post_meta( $post['id'], '_ppt_researcher_selected_work', true ),
						'projects'      => get_post_meta( $post['id'], '_ppt_researcher_projects', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Researcher metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Publication REST fields.
		register_rest_field(
			'ppt_publication',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'isbn'        => get_post_meta( $post['id'], '_ppt_publication_isbn', true ),
						'format'      => get_post_meta( $post['id'], '_ppt_publication_format', true ),
						'pages'       => get_post_meta( $post['id'], '_ppt_publication_pages', true ),
						'date'        => get_post_meta( $post['id'], '_ppt_publication_date', true ),
						'publisher'   => get_post_meta( $post['id'], '_ppt_publication_publisher', true ),
						'editors'     => get_post_meta( $post['id'], '_ppt_publication_editors', true ),
						'price'       => get_post_meta( $post['id'], '_ppt_publication_price', true ),
						'is_free'     => get_post_meta( $post['id'], '_ppt_publication_is_free', true ),
						'file_url'    => get_post_meta( $post['id'], '_ppt_publication_file_url', true ),
						'product_id'  => get_post_meta( $post['id'], '_ppt_publication_product_id', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Publication metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Training REST fields.
		register_rest_field(
			'ppt_training',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'instructor'        => get_post_meta( $post['id'], '_ppt_training_instructor', true ),
						'learning_outcomes' => get_post_meta( $post['id'], '_ppt_training_learning_outcomes', true ),
						'audience'          => get_post_meta( $post['id'], '_ppt_training_audience', true ),
						'level'             => get_post_meta( $post['id'], '_ppt_training_level', true ),
						'duration'          => get_post_meta( $post['id'], '_ppt_training_duration', true ),
						'delivery_mode'     => get_post_meta( $post['id'], '_ppt_training_delivery_mode', true ),
						'start_date'        => get_post_meta( $post['id'], '_ppt_training_start_date', true ),
						'end_date'          => get_post_meta( $post['id'], '_ppt_training_end_date', true ),
						'location'          => get_post_meta( $post['id'], '_ppt_training_location', true ),
						'capacity'          => get_post_meta( $post['id'], '_ppt_training_capacity', true ),
						'price'             => get_post_meta( $post['id'], '_ppt_training_price', true ),
						'is_free'           => get_post_meta( $post['id'], '_ppt_training_is_free', true ),
						'registration_url'  => get_post_meta( $post['id'], '_ppt_training_registration_url', true ),
						'product_id'        => get_post_meta( $post['id'], '_ppt_training_product_id', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Training metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Event REST fields.
		register_rest_field(
			'ppt_event',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'organizer'         => get_post_meta( $post['id'], '_ppt_event_organizer', true ),
						'start_date'        => get_post_meta( $post['id'], '_ppt_event_start_date', true ),
						'end_date'          => get_post_meta( $post['id'], '_ppt_event_end_date', true ),
						'start_time'        => get_post_meta( $post['id'], '_ppt_event_start_time', true ),
						'end_time'          => get_post_meta( $post['id'], '_ppt_event_end_time', true ),
						'location'          => get_post_meta( $post['id'], '_ppt_event_location', true ),
						'is_virtual'        => get_post_meta( $post['id'], '_ppt_event_is_virtual', true ),
						'virtual_url'       => get_post_meta( $post['id'], '_ppt_event_virtual_url', true ),
						'capacity'          => get_post_meta( $post['id'], '_ppt_event_capacity', true ),
						'price'             => get_post_meta( $post['id'], '_ppt_event_price', true ),
						'is_free'           => get_post_meta( $post['id'], '_ppt_event_is_free', true ),
						'registration_url'  => get_post_meta( $post['id'], '_ppt_event_registration_url', true ),
						'product_id'        => get_post_meta( $post['id'], '_ppt_event_product_id', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Event metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Team Member REST fields.
		register_rest_field(
			'ppt_team_member',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'role'          => get_post_meta( $post['id'], '_ppt_team_role', true ),
						'department'    => get_post_meta( $post['id'], '_ppt_team_department', true ),
						'email'         => get_post_meta( $post['id'], '_ppt_team_email', true ),
						'linkedin'      => get_post_meta( $post['id'], '_ppt_team_linkedin', true ),
						'is_leadership' => get_post_meta( $post['id'], '_ppt_team_is_leadership', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Team member metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);

		// Partner REST fields.
		register_rest_field(
			'ppt_partner',
			'ppt_meta',
			array(
				'get_callback' => static function ( array $post ): array {
					return array(
						'type'    => get_post_meta( $post['id'], '_ppt_partner_type', true ),
						'website' => get_post_meta( $post['id'], '_ppt_partner_website', true ),
					);
				},
				'schema'       => array(
					'description' => esc_html__( 'Partner metadata.', 'ppt-core' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook_suffix Current admin page.
	 */
	public function enqueue_admin_styles( string $hook_suffix ): void {
		$css_file = PPT_CORE_PATH . 'assets/css/admin.css';
		if ( ! file_exists( $css_file ) ) {
			return;
		}

		wp_enqueue_style(
			'ppt-core-admin',
			PPT_CORE_URL . 'assets/css/admin.css',
			array(),
			$this->version
		);
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param string $hook_suffix Current admin page.
	 */
	public function enqueue_admin_scripts( string $hook_suffix ): void {
		$js_file = PPT_CORE_PATH . 'assets/js/admin.js';
		if ( ! file_exists( $js_file ) ) {
			return;
		}

		wp_enqueue_script(
			'ppt-core-admin',
			PPT_CORE_URL . 'assets/js/admin.js',
			array(),
			$this->version,
			true
		);
	}

	/**
	 * Enqueue public styles.
	 */
	public function enqueue_public_styles(): void {
		$css_file = PPT_CORE_PATH . 'assets/css/public.css';
		if ( ! file_exists( $css_file ) ) {
			return;
		}

		wp_enqueue_style(
			'ppt-core-public',
			PPT_CORE_URL . 'assets/css/public.css',
			array(),
			$this->version
		);
	}

	/**
	 * Enqueue public scripts.
	 */
	public function enqueue_public_scripts(): void {
		$js_file = PPT_CORE_PATH . 'assets/js/public.js';
		if ( ! file_exists( $js_file ) ) {
			return;
		}

		wp_enqueue_script(
			'ppt-core-public',
			PPT_CORE_URL . 'assets/js/public.js',
			array(),
			$this->version,
			true
		);
	}

	/**
	 * Register admin menu page.
	 */
	public function register_admin_menu(): void {
		add_menu_page(
			esc_html__( 'PPT Dashboard', 'ppt-core' ),
			esc_html__( 'PPT', 'ppt-core' ),
			'manage_options',
			'ppt-dashboard',
			array( $this, 'render_dashboard_page' ),
			'dashicons-universal-access-alt',
			3
		);
	}

	/**
	 * Render the admin dashboard page.
	 */
	public function render_dashboard_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'ppt-core' ) );
		}
		?>
		<div class="wrap ppt-dashboard">
			<h1><?php esc_html_e( 'People & Planet Thrive', 'ppt-core' ); ?></h1>
			<p><?php esc_html_e( 'Knowledge for People. Progress for Planet.', 'ppt-core' ); ?></p>
			<div class="ppt-dashboard-widgets">
				<div class="ppt-dashboard-widget">
					<h2><?php esc_html_e( 'Scholarly Publishing', 'ppt-core' ); ?></h2>
					<ul>
						<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ppt_journal' ) ); ?>"><?php esc_html_e( 'Journals', 'ppt-core' ); ?></a></li>
						<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ppt_journal_issue' ) ); ?>"><?php esc_html_e( 'Journal Issues', 'ppt-core' ); ?></a></li>
						<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ppt_article' ) ); ?>"><?php esc_html_e( 'Articles', 'ppt-core' ); ?></a></li>
						<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ppt_author' ) ); ?>"><?php esc_html_e( 'Authors', 'ppt-core' ); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}
}
