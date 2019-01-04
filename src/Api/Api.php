<?php

namespace Lipe\Lib\Api;

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

	protected const NAME    = 'lipe/lib/api/api';
	protected const VERSION = 1;

	private $doing_api = false;


	public function hook() : void {
		add_action( 'init', [ $this, 'add_endpoint' ], 10, 0 );
		add_action( 'parse_request', [ $this, 'handle_request' ], 10, 1 );
	}


	public function add_endpoint() : void {
		add_rewrite_endpoint( 'api', EP_ROOT );

		if ( version_compare( get_option( self::NAME, '0.0.1' ), self::VERSION ) === - 1 ) {
			flush_rewrite_rules();
			update_option( self::NAME, self::VERSION );
		}
	}


	/**
	 * @param \WP_Query $wp_query
	 *
	 * @return void
	 */
	public function handle_request( $wp_query ) : void {
		if ( empty( $wp_query->query_vars['api'] ) ) {
			return;
		}

		$this->doing_api = true;

		$args     = explode( '/', $wp_query->query_vars['api'] );
		$endpoint = array_shift( $args );

		do_action( "lipe/lib/api/api/{$endpoint}", $args );

		//deprecated
		if ( has_action( "lipe/lib/util/api_{$endpoint}" ) ) {
			\_deprecated_hook( "lipe/lib/util/api_{$endpoint}", '2.1.1', "lipe/lib/api/api/{$endpoint}" ); // phpcs:ignore
			do_action( "lipe/lib/util/api_{$endpoint}", $args );
		}
	}


	/**
	 * Check if we are currently running a api request
	 *
	 * @return bool
	 */
	public function is_doing_api() : bool {
		return $this->doing_api;
	}


	/**
	 * Get the url used to hit the api endpoint
	 *
	 * @param string  $action
	 * @param   array $data - params to be added to url
	 *
	 * @example get_api_url( 'load_more', [ 'page', 2 ] );
	 *
	 * @return string
	 */
	public function get_api_url( $action = null, $data = [] ) : string {
		$url = trailingslashit( trailingslashit( get_home_url() ) . 'api/' . $action );
		foreach ( $data as $_param ) {
			$url .= $_param . '/';
		}

		return $url;
	}

}
