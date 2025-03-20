<?php
/** @noinspection ClassMethodNameMatchesFieldNameInspection */
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Args\ArgsRules;

/**
 * A property shape for an argument in the schema.
 *
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#argument-schema
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Argument_Prop implements ArgsRules, PropRules {
	use Prop;

	/**
	 * Default value of the property.
	 *
	 * @var mixed
	 */
	public mixed $default;

	/**
	 * @phpstan-var callable( mixed $value, \WP_REST_Request<array<string, mixed>> $request, string $param ): (mixed|\WP_Error)
	 *
	 * @var callable
	 */
	public $sanitize_callback;

	/**
	 * @phpstan-var callable( mixed $value, \WP_REST_Request<array<string, mixed>> $request, string $param ): (true|\WP_Error)
	 * @var callable
	 */
	public $validate_callback;


	/**
	 * Default value of the property.
	 *
	 * @param mixed $default_value - Default value.
	 *
	 * @return Argument_Prop
	 */
	public function default( mixed $default_value ): Argument_Prop {
		$this->default = $default_value;
		return $this;
	}


	/**
	 * Validate the value of the argument before passing it to the main callback.
	 *
	 * @link           https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#arguments
	 *
	 * @phpstan-param callable( mixed $value, \WP_REST_Request<array<string, mixed>> $request, string $param ): (true|\WP_Error) $callback
	 *
	 * @formatter:off
	 * @param callable $callback - Callback to validate the value.
	 * @formatter      :on
	 *
	 * @return Argument_Prop
	 */
	public function validate_callback( callable $callback ): Argument_Prop {
		$this->validate_callback = $callback;
		return $this;
	}


	/**
	 * Sanitize the value of the argument before passing it to the main callback.
	 *
	 * @link     https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#arguments
	 *
	 * @phpstan-param callable( mixed $value, \WP_REST_Request<array<string, mixed>> $request, string $param ): (mixed|\WP_Error) $callback
	 *
	 * @formatter:off
	 * @param callable $callback - Callback to sanitize the value.
	 * @formatter:on
	 *
	 * @return Argument_Prop
	 */
	public function sanitize_callback( callable $callback ): Argument_Prop {
		$this->sanitize_callback = $callback;
		return $this;
	}
}
