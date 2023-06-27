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
 */
class Versions {
	use Singleton;

	protected const OPTION = 'lipe/lib/util/versions_version';
	protected const ONCE   = 'lipe/lib/util/versions/once';

	/**
	 * Keeps track of version in the database.
	 *
	 * @var string
	 */
	protected static $version;

	/**
	 * Which once items have been run before
	 *
	 * @static
	 *
	 * @var array<string, 1>
	 */
	protected static array $once_run_before;

	/**
	 * Keeps track of the updates to run
	 *
	 * @static
	 *
	 * @var array<array{version:string, callable:callable, args:array}>>
	 */
	protected static array $updates = [];

	/**
	 * Items registered to run only once
	 *
	 * @static
	 *
	 * @var array<array{callable:callable, args:array}>>
	 */
	protected static array $once = [];


	/**
	 * Construct the versions class.
	 */
	protected function __construct() {
		static::$version = (string) get_option( static::OPTION, '0.1' );
		static::$once_run_before = get_option( static::ONCE, [] );

		$this->hook();
	}


	/**
	 * Actions and filters.
	 *
	 * @return void
	 */
	protected function hook() : void {
		add_action( 'init', [ $this, 'run_updates' ], 99999 );
	}


	/**
	 * Returns the current version in the database.
	 *
	 * @return string
	 */
	public function get_version() : string {
		return static::$version;
	}


	/**
	 * Run a function one time only.
	 *
	 * To be used for items with no pre-requisites, which just need to be run once.
	 *
	 * @param string   $key      - Unique identifier.
	 * @param callable $callback - Callback to be run only once.
	 * @param mixed    $args     - Arguments to be passed to the callback.
	 *
	 * @return void
	 */
	public function once( string $key, callable $callback, $args = null ) : void {
		if ( ! isset( static::$once_run_before[ $key ] ) ) {
			static::$once[ $key ] = [
				'callable' => $callback,
				'args'     => $args,
			];
		}
	}


	/**
	 * Adds a callable to be run if the version is higher than the highest
	 * item, which was previously run.
	 * Multiple items will always be sorted and run in order of their version.
	 *
	 * To be used when items have pre-requisites that must be run in a particular order.
	 *
	 * @param string|float $version  - The version to check against.
	 * @param callable     $callback - Method or function to run if the version checks out.
	 * @param mixed        $args     - Args to pass to the function.
	 *
	 * @uses self::$updates
	 *
	 * @return void
	 */
	public function add_update( $version, callable $callback, $args = null ) : void {
		if ( version_compare( static::$version, (string) $version, '<' ) ) {
			static::$updates[] = [
				'version'  => (string) $version,
				'callable' => $callback,
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
		if ( ! empty( static::$once ) ) {
			foreach ( static::$once as $_key => $_item ) {
				if ( ! isset( static::$once_run_before[ $_key ] ) ) {
					static::$once_run_before[ $_key ] = 1;
					\call_user_func( $_item['callable'], $_item['args'] );
					unset( static::$once[ $_key ] );
				}
			}
			update_option( static::ONCE, static::$once_run_before );
		}

		if ( ! empty( static::$updates ) ) {
			\usort( static::$updates, function ( $a, $b ) {
				return version_compare( $a['version'], $b['version'] );
			} );

			foreach ( static::$updates as $i => $func ) {
				static::$version = $func['version'];
				\call_user_func( $func['callable'], $func['args'] );
				unset( static::$updates[ $i ] );
			}
			update_option( static::OPTION, static::$version );
		}
	}
}
