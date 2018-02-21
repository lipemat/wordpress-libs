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
