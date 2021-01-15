<?php

namespace Lipe\Lib\Api;

use Lipe\Lib\Traits\Singleton;
use Lipe\Lib\Traits\Version;
use Lipe\Lib\Util\Arrays;

/**
 * Simple api endpoint.
 *
 * While you could reverse engineer this class for some really creative implementations,
 * in PHP you really only need to use the 2 helper methods.
 * 1. `get_action`
 * 2. `get_url`
 *
 *
 * @example Api::init();
 *          add_action( Api::in()->get_action( 'space' ), 'print_r' )
 *          Api::in()->get_url( 'space', [ 'first' => 'FY', 'second' => 'TY'] );
 *
 */
class Api {
	use Singleton;
	use Version;

	public const NAME = 'lipe/lib/api/api';

	public const ENDPOINT     = 'api';
	public const FORMAT       = '_format';
	public const FORMAT_ASSOC = 'assoc';

	protected const VERSION = '2.1.0';

	/**
	 * Are we currently handling an api request?
	 *
	 * @var bool
	 */
	protected $doing_api = false;


	public function hook() : void {
		add_action( 'init', function () {
			$this->add_endpoint();
		} );
		add_action( 'parse_request', function ( \WP $wp ) {
			$this->handle_request( $wp );
		} );
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
	 * Get the name of the action to register with `add_action()`.
	 *
	 * @param string $endpoint - Same action provided to the `get_url` method of this class.
	 *                         Should be a url friendly slug which is unique to this API system.
	 *
	 * @return string
	 */
	public function get_action( string $endpoint ) : string {
		return "lipe/lib/api/api/{$endpoint}";
	}


	/**
	 * Get the url used to hit the api endpoint.
	 *
	 * @param string|null $endpoint - Same action provided to the `get_action` method
	 *                              of this class when calling `add_action()`.
	 *                              Should be a url friendly slug which is unique to
	 *                              this API system.
	 *
	 * @param array       $data     - Data passed via the url separated by '/'.
	 *                              Numeric arrays will have values spread in order.
	 *                              Associative arrays will resolve to an
	 *                              array of key values, just as provided.
	 *
	 * @example get_api_url( 'load_more', [ 'page => 2 ] );
	 *
	 * @example get_api_url( 'load_more', [ 'page', 2 ] );
	 *
	 * @return string
	 */
	public function get_url( ?string $endpoint = null, array $data = [] ) : string {
		$url = trailingslashit( $this->get_root_url() . $endpoint );

		if ( empty( $data ) ) {
			return $url;
		}

		if ( \array_values( $data ) === $data ) {
			$url .= trailingslashit( implode( '/', $data ) );
		} else {
			\array_walk_recursive( $data, function ( $value, $param ) use ( &$url ) {
				$url .= "{$param}/{$value}/";
			} );
			$url = add_query_arg( [ static::FORMAT => static::FORMAT_ASSOC ], $url );
		}

		return $url;
	}


	/**
	 * Get the url to root endpoint of this api (not route specific).
	 *
	 * Could be used independently to pass to a JS APP if you have a lot
	 * of endpoints and don't want provided a full URL From `get_url`.
	 *
	 * @return string
	 */
	public function get_root_url() : string {
		return trailingslashit( trailingslashit( get_home_url() ) . static::ENDPOINT );
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

		$this->run_for_version( 'flush_rewrite_rules', static::VERSION );
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

		$args = \array_filter( \explode( '/', $wp->query_vars[ self::NAME ] ) );
		$endpoint = \array_shift( $args );

		if ( ! empty( $_REQUEST[ static::FORMAT ] ) && static::FORMAT_ASSOC === $_REQUEST[ static::FORMAT ] ) {
			$args = Arrays::in()->array_chunk_to_associative( $args );
		}

		do_action( $this->get_action( $endpoint ), $args );
	}
}
