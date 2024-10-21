<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for
 * - `register_meta`
 * - `register_post_meta`
 * - `register_term_meta`
 *
 * @link   https://developer.wordpress.org/reference/functions/register_meta/
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @phpstan-type EXISTING array{
 *     object_subtype: string,
 *     type: self::TYPE_*,
 *     description: string,
 *     label: string,
 *     single: bool,
 *     default: mixed,
 *     sanitize_callback: callable,
 *     auth_callback: callable,
 *     show_in_rest: bool|array{
 *          schema: array<string,mixed>,
 *          prepare_callback: callable(mixed,\WP_REST_Request<array<string, mixed>>): mixed
 *     }
 * }
 */
class Register_Meta implements ArgsRules {
	/**
	 * @use Args<\Partial<EXISTING>>
	 */
	use Args;

	public const TYPE_ARRAY   = 'array';
	public const TYPE_BOOLEAN = 'boolean';
	public const TYPE_INTEGER = 'integer';
	public const TYPE_NUMBER  = 'number';
	public const TYPE_OBJECT  = 'object';
	public const TYPE_STRING  = 'string';

	/**
	 * A subtype; e.g., if the object type is "post", the post type.
	 *
	 * If left empty, the meta key will be registered on the entire object type.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $object_subtype;

	/**
	 * The type of data associated with this meta key.
	 *
	 * Valid values are 'string', 'boolean', 'integer', 'number', 'array', and 'object'.
	 *
	 * @phpstan-var self::TYPE_*
	 * @var string
	 */
	public string $type;

	/**
	 * A description of the data attached to this meta key.
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * A human-readable label of the data attached to this meta key.
	 *
	 * @var string
	 */
	public string $label;

	/**
	 * Whether the meta key has one value per an object, or an array of values per an object.
	 *
	 * Default `true` because we rarely use multiple values even though WP
	 * core defaults to `false`.
	 *
	 * @var bool
	 */
	public bool $single = true;

	/**
	 * The default value returned from `get_metadata()` if no value has been set yet.
	 *
	 * When using a non-single meta key, the default value is for the first entry. In other words, when calling `get_metadata()` with
	 * `$single` set to `false`, the default value given here will be wrapped in an array.
	 *
	 * @var mixed
	 */
	public $default;

	/**
	 * A function or method to call when sanitizing the meta value.
	 *
	 * The callback is called via one of:
	 *
	 * - The https://developer.wordpress.org/reference/hooks/sanitize_object_type_meta_meta_key_for_object_subtype/ filter.
	 * - The https://developer.wordpress.org/reference/hooks/sanitize_object_type_meta_meta_key/ filter.
	 *
	 * @var callable
	 * @phpstan-var callable(mixed,string,string,string=): mixed
	 */
	public $sanitize_callback;

	/**
	 * A function or method to call when performing `edit_post_meta`, `add_post_meta`, and `delete_post_meta` capability checks.
	 *
	 * The callback is called via one of:
	 *
	 * - The https://developer.wordpress.org/reference/hooks/auth_object_type_meta_meta_key_for_object_subtype/ filter.
	 * - The https://developer.wordpress.org/reference/hooks/auth_object_type_meta_meta_key/ filter.
	 *
	 * @var callable
	 * @phpstan-var callable(bool,string,string,string=): mixed
	 */
	public $auth_callback;

	/**
	 * Whether data associated with this meta key can be considered public and should be accessible via the REST API.
	 *
	 * A custom post type must also declare support for custom fields for registered meta to be accessible via REST. When registering
	 * complex meta values this argument may optionally be an array with 'schema' or 'prepare_callback' keys instead of a boolean.
	 *
	 * If this value is an array with a prepare_callback key, the callback is called here:
	 * https://github.com/WordPress/wordpress-develop/blob/6.6.0/src/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php#L127
	 *
	 * @see \Lipe\Lib\Rest_Api\Resource_Schema for construction the schema array.
	 *
	 * @var bool|array<string, mixed>
	 * @phpstan-var bool|array{
	 *     schema: array<string,mixed>,
	 *     prepare_callback: callable(mixed,\WP_REST_Request<array<string,mixed>>,array<string,mixed>): mixed,
	 * }
	 */
	public bool|array $show_in_rest;

	/**
	 * Whether to enable revisions support for this meta_key.
	 *
	 * Can only be used when the object type is 'post'.
	 *
	 * @var bool
	 */
	public bool $revisions_enabled;
}
