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

	const OPTION = 'lipe/lib/util/versions_version';

	/**
	 * Version
	 *
	 * Keeps track of version in db
	 *
	 * @static
	 *
	 * @var float
	 */
	public static $version;

	/**
	 * Updates
	 *
	 * Keeps track of the updates to run
	 *
	 * @static
	 *
	 * @var array
	 */
	public static $updates = [];


	public function __construct() {
		$version = get_option( self::OPTION, "0.1" );
		if( is_float( $version ) ){
			$version = "$version";
		}
		self::$version = $version;
	}


	public function hook() {
		add_action( 'init', [ $this, 'run_updates' ], 99999 );

	}


	/**
	 * Get Version
	 *
	 * Returns current version in db to know where to set updates
	 *
	 *
	 * @return float
	 */
	public function get_version() {
		return self::$version;

	}


	/**
	 * Add Update
	 *
	 * Adds a method to be run if the version says to
	 *
	 * @param float $version         - the version to check against
	 * @param mixed $function_to_run - method or function to run if the version checks out
	 * @param mixed $args            - args to pass to the function
	 *
	 * @uses self::$updates
	 *
	 * @return void
	 *
	 */
	public function add_update( $version, $function_to_run, $args = null ) {
		if( is_float( $version ) ){
			$version = "$version";
		}

		//if the version is higher than one in db, add to updates
		if( version_compare( self::$version, $version ) == - 1 ){
			self::$updates[] = [ 'version' => $version, 'function' => $function_to_run, 'args' => $args ];
		}

	}


	/**
	 * Run Updates
	 *
	 * Run any updates with a newer version and update class and db to match newest
	 *
	 * @uses added to the wp hook by $this->hooks()
	 *
	 * @return void
	 */
	public function run_updates() {
		if( empty( self::$updates ) ){
			return;
		}

		usort( self::$updates, [ $this, 'sort_by_version' ] );

		foreach( self::$updates as $func ){
			self::$version = $func[ 'version' ];

			call_user_func( $func[ 'function' ], $func[ 'args' ] );

		}

		update_option( self::OPTION, self::$version );

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
	public function sort_by_version( $a, $b ) {

		return version_compare( $a[ 'version' ], $b[ 'version' ], '>' );

	}
}
	