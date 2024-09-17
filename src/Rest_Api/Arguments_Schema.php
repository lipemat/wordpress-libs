<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Schema\Argument_Prop;

/**
 * A fluent iterface for generating the REST arguments.
 *
 * Used for the `args' key of the `register_rest_route` function.
 *
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#argument-schema
 *
 * @author Mat Lipe
 * @since  5.2.0
 */
class Arguments_Schema implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * @var array<string, Argument_Prop>
	 */
	protected array $args_props = [];


	/**
	 * Define a new property for query arguments.
	 *
	 * @param string $key - The key for the argument.
	 *
	 * @return Argument_Prop
	 */
	public function prop( string $key ): Argument_Prop {
		$this->args_props[ $key ] = new Argument_Prop( [] );
		return $this->args_props[ $key ];
	}


	/**
	 * @phpstan-return array<string, array<string, mixed>>
	 */
	public function get_args(): array {
		$args = [];
		foreach ( $this->args_props as $key => $prop ) {
			$args[ $key ] = $prop->get_args();
		}
		return $args;
	}
}
