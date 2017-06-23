<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Api
 *
 * Simple api endpoint
 *
 * @example Api::init();
 * @example add_action( 'lipe/lib/util/api_{$endpoint}', %function )
 *          Then go to %site_root%/api/%endpoint% to use the action
 *
 */
class Api {
	use Singleton;

	const DB_VERSION = 1;
	const DB_KEY = 'lipe/lib/util/api-version';

	private $doing_api = false;


	public function hook() {
		add_action( 'init', [ $this, 'add_endpoint' ], 10, 0 );
		add_action( 'parse_request', [ $this, 'handle_request' ], 10, 1 );
	}


	public function add_endpoint() {
		add_rewrite_endpoint( 'api', EP_ROOT );

		if( version_compare( get_option( self::DB_KEY, '0.0.1' ), self::DB_VERSION ) == - 1 ){
			flush_rewrite_rules();
			update_option( self::DB_KEY, self::DB_VERSION );
		}
	}


	/**
	 * @param \WP_Query $wp
	 *
	 * @return void
	 */
	public function handle_request( $wp ) {
		if( empty( $wp->query_vars[ 'api' ] ) ){
			return;
		}

		$this->doing_api = true;

		$args = explode( '/', $wp->query_vars[ 'api' ] );
		$endpoint = array_shift( $args );

		do_action( "lipe/lib/util/api_{$endpoint}", $args );
	}


	/**
	 * Check if we are currently running a api request
	 *
	 * @return bool
	 */
	public function is_doing_api() {
		return $this->doing_api;
	}


	/**
	 * Get the url used to hit the api endpoint
	 *
	 * @param string $action
	 * @param   [] $data - params to be added to url
	 *
	 * @example get_api_url( 'load_more', [ 'page', 2 ] );
	 *
	 * @return string
	 */
	public function get_api_url( $action = null, $data = [] ) {
		$url = trailingslashit( trailingslashit( get_home_url() ) . 'api/' . $action );
		foreach( $data as $_param ){
			$url .= $_param . '/';
		}

		return $url;
	}

}