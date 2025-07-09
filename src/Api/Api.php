<?php
//phpcs:disable WordPress.Security.NonceVerification -- URL intended to be public or nonce per use.
declare( strict_types=1 );

namespace Lipe\Lib\Api;

use Lipe\Lib\Libs\Container\Hooks;
use Lipe\Lib\Libs\Container\Instance;
use Lipe\Lib\Traits\Version;
use Lipe\Lib\Util\Arrays;

/**
 * Simple API endpoint.
 *
 * While you could reversely engineer this class for some really creative implementations,
 * in PHP you really only need to use the 2 helper methods.
 * 1. `get_action`
 * 2. `get_url`
 *
 * @example Api::init_once();
 *          add_action(Api::in()->get_action('space'), 'print_r')
 *          Api::in()->get_url('space', ['first' => 'FY', 'second' => 'TY']);
 */
class Api {
	use Instance;
	use Hooks;
	use Version;

	public const NAME = 'lipe/lib/api/api';

	public const ENDPOINT     = 'api';
	public const FORMAT       = '_format';
	public const FORMAT_ASSOC = 'assoc';

	protected const VERSION = '2.2.0';

	/**
	 * Are we currently handling an api request?
	 *
	 * @var bool
	 */
	protected bool $doing_api = false;


	/**
	 * Actions and filters
	 *
	 * @return void
	 */
	public function hook(): void {
		add_action( 'init', function() {
			$this->add_endpoint();
		} );
		add_action( 'parse_request', function( \WP $wp ) {
			$this->handle_request( $wp );
		} );
		add_action( 'wp_loaded', function() {
			$this->run_for_version( 'flush_rewrite_rules', self::VERSION );
		}, PHP_INT_MAX );
	}


	/**
	 * Check if we are currently running an API request.
	 *
	 * @return bool
	 */
	public function is_doing_api(): bool {
		return $this->doing_api;
	}


	/**
	 * Get the name of the action to register with `add_action()`.
	 *
	 * @param string $endpoint - Same action provided to the `get_url` method of this class.
	 *                         Should be an url friendly slug unique to this API system.
	 *
	 * @return string
	 */
	public function get_action( string $endpoint ): string {
		return "lipe/lib/api/api/{$endpoint}";
	}


	/**
	 * Get the url used to hit the api endpoint.
	 *
	 * @example get_api_url( 'load_more', [ 'page => 2 ] );
	 *
	 * @example get_api_url( 'load_more', [ 'page', 2 ] );
	 *
	 * @param ?string                   $endpoint - Same action provided to the `get_action` method
	 *                                            of this class when calling `add_action()`.
	 *                                            Should be a URL friendly slug unique to
	 *                                            this API system.
	 *
	 * @param array<int|string, string> $data     - Data passed via the url separated by '/'.
	 *                                            Numeric arrays will have values spread in order.
	 *                                            Associative arrays will resolve to an
	 *                                            array of key values, just as provided.
	 *
	 * @return string
	 */
	public function get_url( ?string $endpoint = null, array $data = [] ): string {
		$url = trailingslashit( $this->get_root_url() . $endpoint );
		if ( [] === $data ) {
			return $url;
		}

		if ( \array_values( $data ) === $data ) {
			$url .= trailingslashit( implode( '/', $data ) );
		} else {
			\array_walk_recursive( $data, function( $value, $param ) use ( &$url ) {
				$url .= "{$param}/{$value}/";
			} );
			$url = add_query_arg( [ self::FORMAT => self::FORMAT_ASSOC ], $url );
		}

		return $url;
	}


	/**
	 * Get the url to the root endpoint of this api (not route-specific).
	 *
	 * Could be used independently to pass to a JS APP if you have a lot
	 * of endpoints and don't want to provide a full URL From `get_url`.
	 *
	 * @return string
	 */
	public function get_root_url(): string {
		return trailingslashit( trailingslashit( get_home_url() ) . self::ENDPOINT );
	}


	/**
	 * Register the 'api' endpoint on the root of the site.
	 *
	 * @action init 10 1
	 *
	 * @return void
	 */
	protected function add_endpoint(): void {
		add_rewrite_endpoint( 'api', EP_ROOT, self::NAME );
	}


	/**
	 * Catch incoming requests to the 'api' endpoint and
	 * call the corresponding actions.
	 *
	 * @action parse_request 10 1
	 *
	 * @param \WP $wp - The global WP object.
	 *
	 * @return void
	 */
	protected function handle_request( \WP $wp ): void {
		if ( ! isset( $wp->query_vars[ self::NAME ] ) || '' === $wp->query_vars[ self::NAME ] ) {
			return;
		}

		$this->doing_api = true;
		$args = \array_filter( \explode( '/', $wp->query_vars[ self::NAME ] ), fn( $value ) => '' !== $value );
		$endpoint = \array_shift( $args );
		if ( null === $endpoint ) {
			return;
		}

		if ( isset( $_REQUEST[ self::FORMAT ] ) && self::FORMAT_ASSOC === $_REQUEST[ self::FORMAT ] ) {
			$args = Arrays::in()->chunk_to_associative( $args );
		}

		//phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals -- Dynamic action.
		do_action( $this->get_action( $endpoint ), $args );
	}
}
