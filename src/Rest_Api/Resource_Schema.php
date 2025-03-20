<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Schema\Resource_Prop;
use Lipe\Lib\Rest_Api\Schema\Type;

/**
 * A fluent interface for generating a REST schema.
 *
 * Used for the `schema` key when calling `register_rest_route`.
 *
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#resource-schema
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Resource_Schema implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args {
		get_args as parent_get_args;
	}

	public const TYPE_STRING  = 'string';
	public const TYPE_NUMBER  = 'number';
	public const TYPE_INTEGER = 'integer';
	public const TYPE_BOOLEAN = 'boolean';
	public const TYPE_OBJECT  = 'object';
	public const TYPE_ARRAY   = 'array';
	public const TYPE_NULL    = 'null';

	public const CONTEXT_VIEW  = 'view';
	public const CONTEXT_EDIT  = 'edit';
	public const CONTEXT_EMBED = 'embed';

	/**
	 * The schema version. WP only offically supports version 4.
	 *
	 * @var string
	 */
	public string $schema = 'http://json-schema.org/draft-04/schema#';

	/**
	 * Title of the resource.
	 *
	 * @var string
	 */
	public string $title;

	/**
	 * Data type of the resource. Most commonly `object`.
	 *
	 * @var Type
	 */
	protected Type $type;


	/**
	 * Mark the identity of the resource.
	 *
	 * @param string $title - Title of the resource.
	 *
	 * @return static
	 */
	public function title( string $title ): static {
		$this->title = $title;

		return $this;
	}


	/**
	 * Define the type of the resource.
	 *
	 * @return Type
	 */
	public function type(): Type {
		$this->type = new Type();
		return $this->type;
	}


	/**
	 * Get the arguments for the schema.
	 *
	 * @return array<string, mixed>
	 */
	public function get_args(): array {
		$args = $this->parent_get_args();
		if ( isset( $args['schema'] ) ) {
			$args['$schema'] = $args['schema'];
			unset( $args['schema'] );
		}
		return \array_merge( $args, $this->type->get_args() );
	}
}
