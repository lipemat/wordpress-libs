<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Register_Rest_Route;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Arguments_Schema;

/**
 * @author Mat Lipe
 * @since  5.8.0
 * @phpstan-type CALLBACK \Closure( \WP_REST_Request $request ): (\WP_REST_Response|\WP_Error)
 *
 * @phpstan-type METHOD_ARGS array{
 *     args?: array<string, array<string, mixed>>|Arguments_Schema,
 *     callback?: CALLBACK,
 *     methods?: \WP_REST_Server::*,
 *     permission_callback?: \Closure( \WP_REST_Request $request ): bool
 * }
 *
 * @implements ArgsRules<METHOD_ARGS>
 */
class Method implements ArgsRules {
	/**
	 * @use Args<METHOD_ARGS>
	 */
	use Args;

	/**
	 * POST information required for update requests.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#arguments
	 *
	 * @var Arguments_Schema|array<string, array<string, mixed>>
	 */
	public Arguments_Schema|array $args;

	/**
	 * HTTP methods allowed for this route.
	 *
	 * @phpstan-var \WP_REST_Server::*
	 * @var string
	 */
	public string $methods;

	/**
	 * Callback function to respond to the request.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#return-value
	 *
	 * @phpstan-var CALLBACK
	 * @var \Closure
	 */
	public \Closure $callback;

	/**
	 * Permission callback to verify if the user has access to the route.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#permissions-callback
	 *
	 * @phpstan-var \Closure( \WP_REST_Request $request ): bool
	 * @var \Closure
	 */
	public \Closure $permission_callback;


	/**
	 * POST information required for update requests.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#arguments
	 *
	 * @param Arguments_Schema $args - REST arguments.
	 *
	 * @return static
	 */
	public function args( Arguments_Schema $args ): static {
		$this->args = $args;
		return $this;
	}


	/**
	 * Callback function to respond to the request.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#return-value
	 *
	 * @phpstan-param CALLBACK $callback
	 *
	 * @param \Closure         $callback - function to respond to the request.
	 */
	public function callback( \Closure $callback ): static {
		$this->callback = $callback;
		return $this;
	}


	/**
	 * Permission callback to verify if the user has access to the route.
	 *
	 * @link     https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#permissions-callback
	 *
	 * @phpstan-param \Closure( \WP_REST_Request $request ): bool $callback
	 *
	 * @formatter:off
	 * @param \Closure $callback - Verification function.
	 * @formatter:on
	 */
	public function permission_callback( \Closure $callback ): static {
		$this->permission_callback = $callback;
		return $this;
	}


	/**
	 * HTTP methods allowed for this route.
	 *
	 * @phpstan-param \WP_REST_Server::* $methods
	 *
	 * @param string                     $methods - HTTP method.
	 */
	public function methods( string $methods ): static {
		$this->methods = $methods;
		return $this;
	}
}
