<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Action and filter helpers.
 *
 */
class Actions {
	use Singleton;


	/**
	 * Add a filter but always return the original value.
	 * Useful for cases where we want to treat an
	 * `apply_filters` as an `do_actions` and call a function
	 * without actually changing the original value.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_filter_as_action( string $filter, callable $callable, int $priority = 10 ) : void {
		add_filter( $filter, function ( ...$args ) use ( $callable ) {
			$callable( ...$args );

			return reset( $args );
		}, $priority, 10 );
	}


	/**
	 * Add a callable to multiple actions at once
	 *
	 * @param array    $actions - Actions to register.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_action_all( array $actions, callable $callable, int $priority = 10 ) : void {
		array_walk( $actions, function ( $action ) use ( $callable, $priority ) {
			add_action( $action, $callable, $priority, 10 );
		} );
	}


	/**
	 * Add a callable to multiple filters at once
	 *
	 * @param array    $filters - Filters to register.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_filter_all( array $filters, callable $callable, int $priority = 10 ) : void {
		array_walk(  $filters, function ( $action ) use ( $callable, $priority ) {
			add_filter( $action, $callable, $priority, 10 );
		} );
	}


	/**
	 * Add a filter which will only fire one time no matter how many times
	 * apply_filters( <filter> ) is called.
	 *
	 * If you call this method multiple times with the same $action, $callable, $priority
	 * the filter will also fire only once.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_single_filter( string $filter, callable $callable, int $priority = 10 ) : void {
		$function = function ( ...$args ) use ( $filter, $callable, $priority, &$function ) {
			remove_filter( $filter, $function, $priority );

			return $callable( ...$args );

		};
		add_filter( $filter, $function, $priority, 10 );
	}


	/**
	 * Add an action which will only fire one time no matter how many times
	 * do_action( <action> ) is called.
	 *
	 * If you call this method multiple times with the same $action, $callable, $priority
	 * the action will also fire only once.
	 *
	 * @param string   $action - Action we are adding.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_single_action( string $action, callable $callable, int $priority = 10 ) : void {
		$function = function ( ...$args ) use ( $action, $callable, $priority, &$function ) {
			remove_action( $action, $function, $priority );
			$callable( ...$args );
		};
		add_action( $action, $function, $priority, 10 );
	}


	/**
	 * Remove an action no matter where in the stack it is.
	 * This may be called before or after the add_action() is
	 * called which is being removed.
	 *
	 * @param string   $action   - Action we are adding.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function remove_action_always( string $action, callable $callable, int $priority = 10 ) : void {
		add_action( $action, function () use ( $action, $callable, $priority ) {
			remove_action( $action, $callable, $priority );
		}, -1 );
	}


	/**
	 * Remove a filter no matter where in the stack it is.
	 * This may be called before or after the add_filter() is
	 * called which is being removed.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function remove_filter_always( string $filter, callable $callable, int $priority = 10 ) : void {
		add_filter( $filter, function ( $value ) use ( $filter, $callable, $priority ) {
			remove_filter( $filter, $callable, $priority );

			return $value;
		}, -1 );
	}


	/**
	 * Add a filter to run between a specified start action and stop
	 * at a specified end action.
	 *
	 * Used to filter only during a specific stack or section of code.
	 * Useful for targeting things like a widget or a template but may
	 * be use when any starting and endpoint point is avialble via actions.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callable - Callback.
	 * @param string   $start    - Action which starts the filter.
	 * @param string   $end      - Action which removes the filter.
	 * @param int      $priority - Priority of the filter we are adding.
	 *
	 * @return void
	 */
	public function add_filter_during( string $filter, callable $callable, string $start, string $end, int $priority = 10 ) : void {
		add_action( $start, function () use ( $filter, $callable, $priority ) {
			add_filter( $filter, $callable, $priority, 10 );
		}, - 1 );

		add_action( $end, function () use ( $filter, $callable, $priority ) {
			remove_filter( $filter, $callable, $priority );
		}, - 1 );
	}


	/**
	 * Add an action which removes itself right before the callback
	 * runs then adds itself back in after the callback has finished.
	 *
	 * Add an action which would otherwise cause infinite loops.
	 *
	 * @param string   $action - Action we are adding.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the action we are adding.
	 */
	public function add_looping_action( string $action, callable $callable, int $priority = 10 ) : void {
		$function = function ( ...$args ) use ( $action, $callable, $priority, &$function ) {
			remove_action( $action, $function, $priority );
			$callable( ...$args );
			add_action( $action, $function, $priority, 10 );
		};
		add_action( $action, $function, $priority, 10 );
	}


	/**
	 * Add an filter which removes itself right before the callback
	 * runs then adds itself back in after the callback has finished.
	 *
	 * Add an filter which would otherwise cause infinite loops.
	 *
	 * @param string   $filter   - Filter we are adding.
	 * @param callable $callable - Callback.
	 * @param int      $priority - Priority of the filter we are adding.
	 */
	public function add_looping_filter( string $filter, callable $callable, int $priority = 10 ) : void {
		$function = function ( ...$args ) use ( $filter, $callable, $priority, &$function ) {
			remove_filter( $filter, $function, $priority );
			$result = $callable( ...$args );
			add_filter( $filter, $function, $priority, 10 );

			return $result;
		};
		add_filter( $filter, $function, $priority, 10 );
	}
}
