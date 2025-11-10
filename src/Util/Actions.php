<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Container\Instance;
use Lipe\Lib\Traits\Memoize;

/**
 * Action and filter helpers.
 */
class Actions {
	use Instance;
	use Memoize;

	/**
	 * Add a filter but always return the original value.
	 * Useful for cases where we want to treat an
	 * `apply_filters` as an `do_actions` and call a function
	 * without actually changing the original value.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_filter_as_action( string $filter, callable $callback, int $priority = 10 ): void {
		add_filter( $filter, function( ...$args ) use ( $callback ) {
			$callback( ...$args );

			return reset( $args );
		}, $priority, 10 );
	}


	/**
	 * Add a callable to multiple actions at once
	 *
	 * @param string[] $actions  - Actions to register.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_action_all( array $actions, callable $callback, int $priority = 10 ): void {
		\array_walk( $actions, function( $action ) use ( $callback, $priority ) {
			add_action( $action, $callback, $priority, 10 );
		} );
	}


	/**
	 * Add a callable to multiple filters at once
	 *
	 * @param string[] $filters  - Filters to register.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_filter_all( array $filters, callable $callback, int $priority = 10 ): void {
		\array_walk( $filters, function( $action ) use ( $callback, $priority ) {
			add_filter( $action, $callback, $priority, 10 );
		} );
	}


	/**
	 * Add a filter which will only fire one time no matter how many times
	 * apply_filters(<filter>) is called.
	 *
	 * If you call this method multiple times with the same $action, $callback, $priority
	 * the filter will also fire only once.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_single_filter( string $filter, callable $callback, int $priority = 10 ): void {
		$function = function( ...$args ) use ( $filter, $callback, $priority, &$function ) {
			remove_filter( $filter, $function, $priority );
			return $callback( ...$args );
		};
		$this->memoize( function( $filter, $callback, $priority ) use ( $function ) {
			add_filter( $filter, $function, $priority, 10 );
		}, __METHOD__, $filter, $callback, $priority );
	}


	/**
	 * Add an action which will only fire one time no matter how many times
	 * do_action( <action> ) is called.
	 *
	 * If you call this method multiple times with the same $action, $callback, $priority
	 * the action will also fire only once.
	 *
	 * @param string   $action   - Action we are adding.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_single_action( string $action, callable $callback, int $priority = 10 ): void {
		$function = function( ...$args ) use ( $action, $callback, $priority, &$function ) {
			remove_action( $action, $function, $priority );
			$callback( ...$args );
		};
		$this->memoize( function( $action, $callback, $priority ) use ( $function ) {
			add_action( $action, $function, $priority, 10 );
		}, __METHOD__, $action, $callback, $priority );
	}


	/**
	 * Remove an action no matter where in the stack it is.
	 * This may be called before or after the add_action() is
	 * called on the action being removed.
	 *
	 * @param string   $action   - Action we are adding.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function remove_action_always( string $action, callable $callback, int $priority = 10 ): void {
		add_action( $action, function() use ( $action, $callback, $priority ) {
			remove_action( $action, $callback, $priority );
		}, - 1 );
	}


	/**
	 * Remove a filter no matter where in the stack it is.
	 * This may be called before or after the add_filter() is
	 * called on the action being removed.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function remove_filter_always( string $filter, callable $callback, int $priority = 10 ): void {
		add_filter( $filter, function( $value ) use ( $filter, $callback, $priority ) {
			remove_filter( $filter, $callback, $priority );

			return $value;
		}, - 1 );
	}


	/**
	 * Add a filter to run between a specified start action and stop
	 * at a specified end action.
	 *
	 * Used to filter only during a specific stack or section of code.
	 * Useful for things like a widget or a template but may
	 * be used when any starting and endpoint point is available via actions.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callback - Callback.
	 * @param string   $start    - Action which starts the filter.
	 * @param string   $end      - Action which removes the filter.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_filter_during( string $filter, callable $callback, string $start, string $end, int $priority = 10 ): void {
		add_action( $start, function() use ( $filter, $callback, $priority ) {
			add_filter( $filter, $callback, $priority, 10 );
		}, - 1 );

		add_action( $end, function() use ( $filter, $callback, $priority ) {
			remove_filter( $filter, $callback, $priority );
		}, - 1 );
	}


	/**
	 * Adds an action which removes itself right before the callback
	 *  runs, then adds itself back in after the callback has finished.
	 *
	 * For actions which would otherwise cause infinite loops.
	 *
	 * @param string   $action   - Action we are adding.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the action we are adding.
	 */
	public function add_looping_action( string $action, callable $callback, int $priority = 10 ): void {
		$function = function( ...$args ) use ( $action, $callback, $priority, &$function ) {
			remove_action( $action, $function, $priority );
			$callback( ...$args );
			add_action( $action, $function, $priority, 10 );
		};
		add_action( $action, $function, $priority, 10 );
	}


	/**
	 * Adds a filter which removes itself right before the callback
	 *  runs, then adds itself back in after the callback has finished.
	 *
	 * For filters which would otherwise cause infinite loops.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callback - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 */
	public function add_looping_filter( string $filter, callable $callback, int $priority = 10 ): void {
		$function = function( ...$args ) use ( $filter, $callback, $priority, &$function ) {
			remove_filter( $filter, $function, $priority );
			$result = $callback( ...$args );
			add_filter( $filter, $function, $priority, 10 );

			return $result;
		};
		add_filter( $filter, $function, $priority, 10 );
	}
}
