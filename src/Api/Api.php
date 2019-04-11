<?php

namespace Lipe\Lib\Api;

use Lipe\Lib\Traits\Singleton;

/**
 * Simple api endpoint.
 *
 * @example Api::init();
 * @example add_action( Api::in()->get_actions( %action% ), %callable% )
 *          Then go to %site_root%/api/%action% to use the action
 *
 */
class Api {
	use Singleton;

	protected const NAME = 'lipe/lib/api/api';

	protected const VERSION = 2;

	/**
	 * Are we currently handling an api request?
	 * @var bool
	 */
	protected $doing_api = false;


	public function hook() : void {
		add_action( 'init', function() {
			$this->add_endpoint();
		});
		add_action( 'parse_request', function( \WP $wp ) {
			$this->handle_request( $wp );
		});
	}


	/**
	 * Get the name of the action to register with `add_action()`.
	 *
	 * @param string $action
	 *
	 * @return string
	 */
	public function get_action( string $action ) : string {
		return "lipe/lib/api/api/{$action}";
	}


	/**
	 * Check if we are currently running a api request.
	 *
	 * @return bool
	 */
	public function is_doing_api() : bool {
		return $this->doing_api;
	}


	/**
	 * Get the url used to hit the api endpoint.
	 *
	 * @param string  $action
	 * @param   array $data - params to be added to url
	 *
	 * @example get_api_url( 'load_more', [ 'page', 2 ] );
	 *
	 * @return string
	 */
	public function get_api_url( ?string $action = null, array $data = [] ) : string {
		$url = trailingslashit( trailingslashit( get_home_url() ) . 'api/' . $action );
		foreach ( $data as $_param ) {
			$url .= $_param . '/';
		}

		return $url;
	}


	/**
	 * Register the 'api' endpoint on the root of the site.
	 *
	 * @action init 10 1
	 *
	 * @return void
	 */
	protected function add_endpoint() : void {
		add_rewrite_endpoint( 'api', EP_ROOT, self::NAME );

		if ( version_compare( get_option( self::NAME, '0.0.1' ), self::VERSION ) === - 1 ) {
			flush_rewrite_rules();
			update_option( self::NAME, self::VERSION );
		}
	}


	/**
	 * Catch incoming requests to the 'api' endpoint and
	 * call the corresponding actions.
	 *
	 * @action parse_request 10 1
	 *
	 * @param \WP $wp
	 *
	 * @return void
	 */
	protected function handle_request( \WP $wp ) : void {
		if ( empty( $wp->query_vars[ self::NAME ] ) ) {
			return;
		}

		$this->doing_api = true;

		$args     = explode( '/', $wp->query_vars[ self::NAME ] );
		$endpoint = array_shift( $args );

		do_action( $this->get_action( $endpoint ), $args );

		if ( has_action( "lipe/lib/util/api_{$endpoint}" ) ) {
			\_deprecated_hook( esc_html( "lipe/lib/util/api_{$endpoint}" ), '2.1.1', esc_html( $this->get_action( $endpoint ) ) );
			do_action( "lipe/lib/util/api_{$endpoint}", $args );
		}
	}

}
