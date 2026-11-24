<?php
declare( strict_types=1 );

namespace Lipe\Lib\Settings;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * A Fluent interface for registering a setting.
 *
 * @link   https://developer.wordpress.org/reference/functions/register_setting/
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Register_Setting implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	public const string GROUP_DISCUSSION = 'discussion';
	public const string GROUP_GENERAL    = 'general';
	public const string GROUP_MEDIA      = 'media';
	public const string GROUP_OPTIONS    = 'options';
	public const string GROUP_READING    = 'reading';
	public const string GROUP_WRITING    = 'writing';

	public const string TYPE_ARRAY   = 'array';
	public const string TYPE_BOOLEAN = 'boolean';
	public const string TYPE_INTEGER = 'integer';
	public const string TYPE_NUMBER  = 'number';
	public const string TYPE_OBJECT  = 'object';
	public const string TYPE_STRING  = 'string';

	/**
	 * The type of data associated with this setting.
	 *
	 * @phpstan-var self::TYPE_*
	 * @var string
	 */
	public string $type;

	/**
	 * A description of the data attached to this setting.
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * The label will be displayed to users when editing core or custom settings
	 * via block editors.
	 *
	 * @since WP 6.6.
	 *
	 * @var string
	 */
	public string $label;

	/**
	 * A callback function that sanitizes the option’s value.
	 *
	 * @var callable( mixed $value ): mixed
	 */
	public $sanitize_callback;

	/**
	 * Whether the setting should be registered for the REST API.
	 *
	 * @see self::show_in_rest() for a more advanced usage.
	 *
	 * @phpstan-var bool|array{
	 *     name?: string,
	 *     schema?: array<string,mixed>,
	 * }
	 *
	 * @var bool|array
	 */
	public bool|array $show_in_rest;

	/**
	 * The default value for the setting.
	 *
	 * @var mixed
	 */
	public mixed $default;

	/**
	 * Whether to include the setting in the abilities endpoint.
	 *
	 * @see      self::show_in_abilities() for a more advanced usage.
	 *
	 * @requires WP 7.2+
	 *
	 * @phpstan-var bool|array{
	 *     name?: string,
	 *     schema?: array<string,mixed>,
	 * }
	 *
	 * @var bool|array
	 */
	public bool|array $show_in_abilities;


	/**
	 * Include in the REST API with a custom name and schema.
	 *
	 * @see      self::$show_in_rest for simple boolean usage.
	 *
	 * @param string          $name   - The name to use for the setting in the REST API.
	 * @param Resource_Schema $schema - The schema to use for the setting in the REST API.
	 */
	public function show_in_rest( string $name, Resource_Schema $schema ): static {
		$this->show_in_rest = [
			'name'   => $name,
			'schema' => [
				'items' => $schema->get_args(),
			],
		];
		return $this;
	}


	/**
	 * Include in the abilities endpoint with a custom name and schema.
	 *
	 * @see      self::$show_in_abilities for simple boolean usage.
	 *
	 * @requires WP 7.2+
	 *
	 * @param string          $name   - The name to use for the setting in the abilities endpoint.
	 * @param Resource_Schema $schema - The schema to use for the setting in the abilities endpoint.
	 */
	public function show_in_abilities( string $name, Resource_Schema $schema ): static {
		$this->show_in_abilities = [
			'name'   => $name,
			'schema' => [
				'items' => $schema->get_args(),
			],
		];
		return $this;
	}
}
