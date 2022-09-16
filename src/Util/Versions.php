<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Run callable based on a version or simply run an item only once.
 * Use add_update() for items, which may depend on previously run items or to run
 * items in order.
 * Use once() for items with no prerequisites and just need to be run once.
 *
 * For tracking for a single class
 *
 * @see     \Lipe\Lib\Traits\Version
 *
 * @example Versions::in()->add_update( $version, function(){}, [ data ] );
 * @example Versions::in()->once( $key, function(){}, [ data ] );
 *
 */
class Versions {
	use Singleton;

	protected const OPTION = 'lipe/lib/util/versions_version';
	protected const ONCE   = 'lipe/lib/util/versions/once';

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
	 * @var array<array{version:string, callable:callable, args:array}>>
	 */
	protected static $updates = [];

	/**
	 * Items registered to run only once
	 *
	 * @static
	 *
	 * @var array<array{callable:callable, args:array}>>
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
	 *
	 * Returns current version in db to know which version to supply
	 *
	 * @return string
	 */
	public function get_version() : string {
		return self::$version;
	}


	/**
	 * Run a function one time only
	 * To be use for items with no pre-requisites, which just need to be run once.
	 *
	 * @param callable $callable
	 * @param string   $key - unique identifier
	 * @param mixed    $args
	 *
	 * @return void
	 */
	public function once( string $key, callable $callable, $args = null ) : void {
		if ( ! isset( self::$once_run_before[ $key ] ) ) {
			self::$once[ $key ] = [
				'callable' => $callable,
				'args'     => $args,
			];
		}
	}


	/**
	 * Adds a callable to be run if the version is higher than the highest
	 * item which was previously run.
	 * Multiple items will always be sorted and run in order of their version.
	 *
	 * To be used when items have pre-requisites that must be run in a particular order.
	 *
	 * @param string|float $version  - the version to check against
	 * @param callable     $callable - method or function to run if the version checks out
	 * @param mixed        $args     - args to pass to the function
	 *
	 * @uses self::$updates
	 *
	 * @return void
	 *
	 */
	public function add_update( $version, callable $callable, $args = null ) : void {
		//if the version is higher than one in db, add to updates
		if ( version_compare( self::$version, (string) $version, '<' ) ) {
			self::$updates[] = [
				'version'  => (string) $version,
				'callable' => $callable,
				'args'     => $args,
			];
		}
	}


	/**
	 * Run any versioned updates as well as once items.
	 *
	 * When complete, the stored version will be the highest version supplied.
	 * Any future items needed to run via Versions::in()->run_updates() must have a
	 * higher version than the previously supplied versions.
	 *
	 * @action init
	 *
	 * @return void
	 */
	public function run_updates() : void {
		if ( ! empty( self::$once ) ) {
			foreach ( self::$once as $_key => $_item ) {
				if ( ! isset( self::$once_run_before[ $_key ] ) ) {
					self::$once_run_before[ $_key ] = 1;
					\call_user_func( $_item['callable'], $_item['args'] );
					unset( self::$once[ $_key ] );
				}
			}
			update_option( self::ONCE, self::$once_run_before );
		}

		if ( ! empty( self::$updates ) ) {
			\usort( self::$updates, function ( $a, $b ) {
				return version_compare( $a['version'], $b['version'] );
			} );

			foreach ( self::$updates as $i => $func ) {
				self::$version = $func['version'];
				\call_user_func( $func['callable'], $func['args'] );
				unset( self::$updates[ $i ] );
			}
			update_option( self::OPTION, self::$version );
		}
	}
}
