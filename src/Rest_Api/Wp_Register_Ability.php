<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for the `wp_register_ability` function.
 *
 * @link   https://developer.wordpress.org/apis/abilities-api/php-reference/#registering-abilities-wp_register_ability
 *
 * @author Mat Lipe
 * @since  6.0.0
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Wp_Register_Ability implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	public const string ANNOTATION_READONLY    = 'readonly';
	public const string ANNOTATION_DESTRUCTIVE = 'destructive';
	public const string ANNOTATION_IDEMPOTENT  = 'idempotent';

	/**
	 * The human-readable label for the ability.
	 *
	 * @required
	 *
	 * @var string
	 */
	public string $label;

	/**
	 * A detailed description of what the ability does.
	 *
	 * @required
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * The ability category slug this ability belongs to.
	 *
	 * @var string
	 */
	public string $category;

	/**
	 * A callback function to execute when the ability is invoked.
	 *
	 * Receives optional mixed input and returns mixed result or WP_Error.
	 *
	 * @phpstan-var \Closure(mixed=): (mixed|\WP_Error)
	 * @var \Closure
	 */
	public \Closure $execute_callback;

	/**
	 * A callback function to check permissions before execution.
	 *
	 * Receives optional mixed input and returns bool or WP_Error.
	 *
	 * @required
	 *
	 * @phpstan-var \Closure(mixed=): (bool|\WP_Error)
	 * @var \Closure
	 */
	public \Closure $permission_callback;

	/**
	 * JSON Schema definition for the ability's input.
	 *
	 * @var Resource_Schema|array<string, mixed>
	 */
	public Resource_Schema|array $input_schema;

	/**
	 * JSON Schema definition for the ability's output.
	 *
	 * @var array<string, mixed>
	 */
	public Resource_Schema|array $output_schema;

	/**
	 * Additional configuration for the ability.
	 *
	 * @phpstan-var array{
	 *     annotations?: array<self::ANNOTATION_*, bool>,
	 *     show_in_rest?: bool,
	 * }
	 * @var array<string, mixed>
	 */
	public array $meta;

	/**
	 * Custom class to instantiate instead of WP_Ability.
	 *
	 * @phpstan-var class-string<\WP_Ability>
	 *
	 * @var string
	 */
	public string $ability_class;


	/**
	 * Optional. JSON Schema definition for validating the ability's input.
	 *
	 * Must be a valid JSON Schema object defining the structure and constraints for input data.
	 *
	 * Used for automatic validation and API documentation.
	 *
	 * @return Resource_Schema
	 */
	public function input_schema(): Resource_Schema {
		$this->input_schema = new Resource_Schema( [] );
		return $this->input_schema;
	}


	/**
	 * JSON Schema definition for the ability's output.
	 *                                                      Describes the structure of successful return values from
	 * `execute_callback`.
	 *
	 * Used for documentation and validation.
	 *
	 * @return Resource_Schema Returns the output schema for the resource.
	 */
	public function output_schema(): Resource_Schema {
		$this->output_schema = new Resource_Schema( [] );
		return $this->output_schema;
	}
}
