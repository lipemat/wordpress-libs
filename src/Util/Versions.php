<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Versions
 *
 * Allow for running things only once and keeping track of the db version
 *
 * @example Versions::init();
 * @example Versions::instance()->add_update( %version%, %function% );
 *
 * @uses    You must add updates during the init hook, because this will run them at the end of the init hook
 * @uses    may retrieve current version via Versions::instance()->get_version()
 *
 *
 *
 */
class Versions {
	use Singleton;

	protected const OPTION = 'lipe/lib/util/versions_version';
	protected const ONCE = 'lipe/lib/util/versions/once';

	/**
	 * Keeps track of version in db
	 *
	 * @static
	 *
	 * @var string
	 */
	protected static $version;

	/**
	 * Which once items have been run before
	 *
	 * @static
	 *
	 * @var array
	 */
	protected static $once_run_before;

	/**
	 * Keeps track of the updates to run
	 *
	 * @static
	 *
	 * @var array
	 */
	protected static $updates = [];

	/**
	 * Items registered to run only once
	 *
	 * @static
	 *
	 * @var callable[]
	 */
	protected static $once = [];


	protected function __construct() {
		self::$version = (string) get_option( self::OPTION, '0.1' );
		self::$once_run_before = get_option( self::ONCE, [] );

		$this->hook();
	}


	protected function hook() : void {
		add_action( 'init', [ $this, 'run_updates' ], 99999 );
	}


	/**
	 * Get Version
	 *
	 * Returns current version in db to know where to set updates
	 *
	 *
	 * @return string
	 */
	public function get_version() : string {
		return self::$version;

	}


	/**
	 * Run a function one time only
	 *
	 * @param callable $callable
	 * @param string   $key - unique identifier
	 * @param mixed    $args
	 *
	 * @return void
	 */
	public function once( string $key, callable $callable, $args = null ) : void {
		if( !isset( self::$once_run_before[ $key ] ) ){
			self::$once[ $key ] = [ 'callable' => $callable, 'args' => $args ];
		}
	}


	/**
	 * Add Update
	 *
	 * Adds a method to be run if the version says to
	 *
	 * @param string|float $version  - the version to check against
	 * @param mixed        $callable - method or function to run if the version checks out
	 * @param mixed        $args     - args to pass to the function
	 *
	 * @uses self::$updates
	 *
	 * @return void
	 *
	 */
	public function add_update( $version, callable $callable, $args = null ) : void {
		//if the version is higher than one in db, add to updates
		if( version_compare( self::$version, (string) $version, '<' ) ){
			self::$updates[] = [ 'version' => (string) $version, 'callable' => $callable, 'args' => $args ];
		}

	}


	/**
	 * Run any versioned updates as well as once items
	 *
	 * @action init
	 *
	 * @return void
	 */
	public function run_updates() : void {
		if( !empty( self::$once ) ){
			foreach( self::$once as $_key => $_item ){
				if( !isset( $run_before[ $_key ] ) ){
					self::$once_run_before[ $_key ] = 1;
					\call_user_func( $_item[ 'callable' ], $_item[ 'args' ] );
				}
			}
			\update_option( self::ONCE, self::$once_run_before );
		}

		if( !empty( self::$updates ) ){
			\usort( self::$updates, [ $this, 'sort_by_version' ] );

			foreach( self::$updates as $func ){
				self::$version = $func[ 'version' ];

				\call_user_func( $func[ 'callable' ], $func[ 'args' ] );

			}
			\update_option( self::OPTION, self::$version );
		}

	}


	/**
	 * Sort By Version
	 *
	 * Make sure the updates run in order by version
	 *
	 * @param array $a
	 * @param array $b
	 *
	 * @return bool
	 *
	 */
	public function sort_by_version( $a, $b ) : bool {
		return version_compare( $a[ 'version' ], $b[ 'version' ], '>' );
	}
}
