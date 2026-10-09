<?php
/**
 * Hook/Filter Loader
 *
 * @package PPTCore
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Loader
 *
 * Maintains and registers all hooks for the plugin.
 * Provides a clean interface for adding actions and filters.
 */
class PPT_Loader {

	/**
	 * Actions collection.
	 *
	 * @var array<int, array{hook: string, component: object, callback: string, priority: int, accepted_args: int}>
	 */
	private array $actions = array();

	/**
	 * Filters collection.
	 *
	 * @var array<int, array{hook: string, component: object, callback: string, priority: int, accepted_args: int}>
	 */
	private array $filters = array();

	/**
	 * Add a new action to the collection.
	 *
	 * @param string $hook          Hook name.
	 * @param object $component     Component instance containing the callback.
	 * @param string $callback      Method name on the component.
	 * @param int    $priority      Optional. Priority. Default 10.
	 * @param int    $accepted_args Optional. Number of arguments. Default 1.
	 */
	public function add_action( string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1 ): void {
		$this->actions[] = compact( 'hook', 'component', 'callback', 'priority', 'accepted_args' );
	}

	/**
	 * Add a new filter to the collection.
	 *
	 * @param string $hook          Hook name.
	 * @param object $component     Component instance containing the callback.
	 * @param string $callback      Method name on the component.
	 * @param int    $priority      Optional. Priority. Default 10.
	 * @param int    $accepted_args Optional. Number of arguments. Default 1.
	 */
	public function add_filter( string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1 ): void {
		$this->filters[] = compact( 'hook', 'component', 'callback', 'priority', 'accepted_args' );
	}

	/**
	 * Register all hooks with WordPress.
	 */
	public function run(): void {
		foreach ( $this->filters as $hook ) {
			add_filter(
				$hook['hook'],
				array( $hook['component'], $hook['callback'] ),
				$hook['priority'],
				$hook['accepted_args']
			);
		}

		foreach ( $this->actions as $hook ) {
			add_action(
				$hook['hook'],
				array( $hook['component'], $hook['callback'] ),
				$hook['priority'],
				$hook['accepted_args']
			);
		}

		// Handle deferred rewrite flush.
		if ( get_transient( 'ppt_core_flush_rewrite_rules' ) ) {
			add_action(
				'init',
				static function (): void {
					flush_rewrite_rules();
					delete_transient( 'ppt_core_flush_rewrite_rules' );
				},
				99
			);
		}
	}
}
