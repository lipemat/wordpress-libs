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
	 * Add an filter which will only fire one time no matter how many times
	 * apply_filters( <filter> ) is called.
	 *
	 * @since 1.8.0
	 *
	 * @param string   $filter
	 * @param callable $callable
	 * @param int      $priority
	 * @param int      $accepted_args
	 *
	 * @return void
	 */
	public function add_single_filter( string $filter, callable $callable, int $priority = 10, int $accepted_args = 1 ) : void {
		\add_filter( $filter, $callable, $priority, $accepted_args );
		\add_filter( $filter, function ( $value ) use ( $filter, $callable, $priority ) {
			\remove_filter( $filter, $callable, $priority );

			return $value;
		}, $priority );
	}


	/**
	 * Add an action which will only fire one time no matter how many times
	 * do_action( <action> ) is called.
	 *
	 * @since 1.8.0
	 *
	 *
	 * @param string   $action
	 * @param callable $callable
	 * @param int      $priority
	 * @param int      $accepted_args
	 *
	 * @return void
	 */
	public function add_single_action( string $action, callable $callable, int $priority = 10, int $accepted_args = 1 ) : void {
		\add_action( $action, $callable, $priority, $accepted_args );
		\add_action( $action, function () use ( $action, $callable, $priority ) {
			\remove_action( $action, $callable, $priority );
		}, $priority );
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
		}, 0 );
	}


	/**
	 * Remove a filter no matter where in the stack it is.
	 * This may be called before or after the add_filter() is
	 * called which is being removed.
	 *
	 * @see \remove_filter();
	 *
	 * @param string   $filter
	 * @param callable $callable
	 * @param int      $priority
	 *
	 * @return void
	 */
	public function remove_filter_always( string $filter, callable $callable, int $priority = 10 ) : void {
		\add_filter( $filter, function ( $value ) use ( $filter, $callable, $priority ) {
			\remove_filter( $filter, $callable, $priority );

			return $value;
		}, 0 );
	}

}
