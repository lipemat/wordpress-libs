<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Actions
 *
 * @author  Mat Lipe
 * @since   1.3.0
 *
 * @package Lipe\Lib\Util
 */
class Actions {
	use Singleton;


	/**
	 * Add a filter but always return the original value.
	 * Useful for cases where we want to treat an
	 * `apply_filters` as an `do_actions` and call a function
	 * without actually changing the original value.
	 *
	 * @param string   $filter
	 * @param callable $callable
	 * @param int      $priority
	 * @param int      $accepted_args
	 *
	 * @since 1.12.0
	 *
	 * @return void
	 */
	public function add_filter_as_action( string $filter, callable $callable, int $priority = 10, int $accepted_args = 1 ) : void {
		\add_filter( $filter, function ( ...$args ) use ( $callable ) {
			$callable( ...$args );

			return reset( $args );
		}, $priority, $accepted_args );
	}


	/**
	 * Add a callable to multiple actions at once
	 *
	 * @param array    $actions
	 * @param callable $callable
	 * @param int      $priority
	 * @param int      $accepted_args
	 *
	 * @since 1.9.0
	 *
	 * @return void
	 */
	public function add_action_all( array $actions, callable $callable, int $priority = 10, int $accepted_args = 1 ) : void {
		array_map( function ( $action ) use ( $callable, $priority, $accepted_args ) {
			add_action( $action, $callable, $priority, $accepted_args );
		}, $actions );
	}


	/**
	 * Add a callable to multiple filters at once
	 *
	 * @param array    $filters
	 * @param callable $callable
	 * @param int      $priority
	 * @param int      $accepted_args
	 *
	 * @since 1.9.0
	 *
	 * @return void
	 */
	public function add_filter_all( array $filters, callable $callable, int $priority = 10, int $accepted_args = 1 ) : void {
		array_map( function ( $action ) use ( $callable, $priority, $accepted_args ) {
			add_filter( $action, $callable, $priority, $accepted_args );
		}, $filters );
	}


	/**
	 * Add a filter which will only fire one time no matter how many times
	 * apply_filters( <filter> ) is called.
	 *
	 * If you call this method multiple times with the same $action, $callable, $priority
	 * the filter will also fire only once.
	 *
	 * @param string   $filter
	 * @param callable $callable
	 * @param int      $priority
	 * @param int      $accepted_args
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	public function add_single_filter( string $filter, callable $callable, int $priority = 10, int $accepted_args = 1 ) : void {
		$function = function ( ...$args ) use ( $filter, $callable, $priority, &$function ) {
			\remove_filter( $filter, $function, $priority );

			return $callable( ...$args );

		};
		\add_filter( $filter, $function, $priority, $accepted_args );
	}


	/**
	 * Add an action which will only fire one time no matter how many times
	 * do_action( <action> ) is called.
	 *
	 * If you call this method multiple times with the same $action, $callable, $priority
	 * the action will also fire only once.
	 *
	 * @param string   $action
	 * @param callable $callable
	 * @param int      $priority
	 * @param int      $accepted_args
	 *
	 * @since 1.8.0
	 *
	 *
	 * @return void
	 */
	public function add_single_action( string $action, callable $callable, int $priority = 10, int $accepted_args = 1 ) : void {
		$function = function ( ...$args ) use ( $action, $callable, $priority, &$function ) {
			\remove_action( $action, $function, $priority );
			$callable( ...$args );
		};
		\add_action( $action, $function, $priority, $accepted_args );
	}


	/**
	 * Remove an action no matter where in the stack it is.
	 * This may be called before or after the add_action() is
	 * called which is being removed.
	 *
	 * @param string   $action
	 * @param callable $callable
	 * @param int      $priority
	 *
	 * @return void
	 */
	public function remove_action_always( string $action, callable $callable, int $priority = 10 ) : void {
		\add_action( $action, function () use ( $action, $callable, $priority ) {
			\remove_action( $action, $callable, $priority );
		}, -1 );
	}


	/**
	 * Remove a filter no matter where in the stack it is.
	 * This may be called before or after the add_filter() is
	 * called which is being removed.
	 *
	 * @param string   $filter
	 * @param callable $callable
	 * @param int      $priority
	 *
	 * @see \remove_filter();
	 *
	 * @return void
	 */
	public function remove_filter_always( string $filter, callable $callable, int $priority = 10 ) : void {
		\add_filter( $filter, function ( $value ) use ( $filter, $callable, $priority ) {
			\remove_filter( $filter, $callable, $priority );

			return $value;
		}, -1 );
	}

}
