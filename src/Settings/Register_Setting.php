<?php
declare( strict_types=1 );

namespace Lipe\Lib\Settings;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A Fluent interface for registering a setting.
 *
 * @link   https://developer.wordpress.org/reference/functions/register_setting/
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 */
class Register_Setting implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	public const GROUP_DISCUSSION = 'discussion';
	public const GROUP_GENERAL    = 'general';
	public const GROUP_MEDIA      = 'media';
	public const GROUP_OPTIONS    = 'options';
	public const GROUP_READING    = 'reading';
	public const GROUP_WRITING    = 'writing';

	public const TYPE_ARRAY   = 'array';
	public const TYPE_BOOLEAN = 'boolean';
	public const TYPE_INTEGER = 'integer';
	public const TYPE_NUMBER  = 'number';
	public const TYPE_OBJECT  = 'object';
	public const TYPE_STRING  = 'string';

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
	 * When registering complex settings, this argument may optionally be an array with a 'schema' key.
	 *
	 * @phpstan-var bool|array{
	 *     schema: array<string, mixed>
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
}
