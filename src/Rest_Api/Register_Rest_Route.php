<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Register_Rest_Route\Method;

/**
 * A fluent interface for registering a REST route via the
 * `register_rest_route` function.
 *
 * @link   https://developer.wordpress.org/reference/functions/register_rest_route/
 *
 * @author Mat Lipe
 * @since  5.8.0
 *
 * @phpstan-import-type METHOD_ARGS from Method
 *
 * @phpstan-type ROUTE_ARGS array{
 *     schema?: (\Closure(): array<string, mixed>),
 *     ...<METHOD_ARGS>,
 * }
 * @implements ArgsRules<ROUTE_ARGS>
 */
class Register_Rest_Route implements ArgsRules {
	/**
	 * @use Args<ROUTE_ARGS>
	 */
	use Args {
		get_args as parent_get_args;
	}

	/**
	 * HTTP methods which the route supports.
	 *
	 * @var list<Method>
	 */
	public array $methods;

	/**
	 * An optional public schema for the resource.
	 * Not used by WP core for any validation.
	 *
	 * @var Resource_Schema
	 */
	public Resource_Schema $schema;


	/**
	 * Overriden to prevent throwing an exception.
	 *
	 * @param array<string, mixed> $do_not_use - Not supported by this class.
	 *
	 */
	public function __construct( array $do_not_use ) {
		if ( [] !== $do_not_use ) {
			_doing_it_wrong( __METHOD__, 'Rest routes cannot be loaded from an array.', '5.8.0' );
		}
	}


	/**
	 * HTTP methods which the route supports.
	 *
	 * @phpstan-param \WP_REST_Server::* $methods
	 *
	 * @param string                     $methods - HTTP method.
	 */
	public function method( string $methods ): Method {
		$method = new Method( [] );
		$method->methods( $methods );
		$this->methods[] = $method;
		return $method;
	}


	/**
	 * An optional public schema for the resource.
	 * Not used by WP core for any validation.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/
	 *
	 * @param Resource_Schema $schema - The schema.
	 *
	 * @return static
	 */
	public function schema( Resource_Schema $schema ): static {
		$this->schema = $schema;
		return $this;
	}


	/**
	 * Loading from an array is not supported due to the combined
	 * array shape of the `register_rest_route` function.
	 *
	 * @param array<string, mixed> $do_not_use - Not used.
	 *
	 * @throws \LogicException - Always.
	 * @phpstan-return never
	 */
	protected function load_array_into_properties( array $do_not_use ): void {
		throw new \LogicException( 'Rest routes cannot be loaded from an array.' );
	}


	/**
	 * Get the arguments for the `register_rest_route` function.
	 */
	public function get_args(): array {
		$args = [];
		if ( isset( $this->methods ) ) {
			foreach ( $this->methods as $method ) {
				$args[] = $method->get_args();
			}
		}
		if ( isset( $this->schema ) ) {
			$args['schema'] = fn() => $this->schema->get_args();
		}
		return $args;
	}
}
