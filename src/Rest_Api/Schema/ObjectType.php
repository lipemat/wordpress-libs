<?php
//phpcs:disable WordPress.NamingConventions.ValidVariableName
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * Object type for the REST API schema.
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#objects
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class ObjectType implements ArgsRules, TypeRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args {
		get_args as parent_get_args;
	}

	/**
	 * Data type for the schema.
	 *
	 * @phpstan-var 'object'
	 * @var string
	 */
	public string $type = Resource_Schema::TYPE_OBJECT;

	/**
	 * Disable or shape unknown property names.
	 *
	 * @var bool|Resource_Prop
	 */
	public bool|Resource_Prop $additionalProperties;

	/**
	 * Pattern properties for the object.
	 *
	 * @var array<string, Resource_Prop>
	 */
	public array $patternProperties = [];

	/**
	 * The minium number of properties required allowing using additional properties.
	 *
	 * @var int
	 */
	public int $minProperties;

	/**
	 * The maximum number of properties required allowing using additional properties.
	 *
	 * @var int
	 */
	public int $maxProperties;

	/**
	 * Properties for the object.
	 *
	 * @var array<string, Resource_Prop>
	 */
	protected array $properties = [];


	/**
	 * Define a property for the object.
	 *
	 * @param string $key - The key for the property.
	 *
	 * @return Resource_Prop
	 */
	public function prop( string $key ): Resource_Prop {
		$this->properties[ $key ] = new Resource_Prop( [] );
		return $this->properties[ $key ];
	}


	/**
	 * Disable or shape additional properties with unknown keys.
	 *
	 * @param bool     $enabled - `false` to not allow additional properties.
	 *                          - `true` to enable any additional properties.
	 *                          - `null` to define additional properties.
	 * @param int|null $max     - The maximum number of additional properties.
	 * @param int|null $min     - The minimum number of additional properties.
	 *
	 * @return ?Resource_Prop
	 */
	public function additional_properties( ?bool $enabled = null, ?int $max = null, ?int $min = null ): ?Resource_Prop {
		if ( \is_int( $max ) ) {
			$this->minProperties = $min ?? 0;
		}
		if ( \is_int( $min ) ) {
			$this->maxProperties = $max ?? 100;
		}
		if ( \is_bool( $enabled ) ) {
			$this->additionalProperties = $enabled;
			return null;
		}

		$this->additionalProperties = new Resource_Prop( [] );
		return $this->additionalProperties;
	}


	/**
	 * Like object properties but keys match a regex pattern.
	 *
	 * @param string $regex_key - The regex pattern to match keys.
	 *
	 * @return Resource_Prop
	 */
	public function pattern_properties( string $regex_key ): Resource_Prop {
		$this->patternProperties[ $regex_key ] = new Resource_Prop( [] );
		return $this->patternProperties[ $regex_key ];
	}


	/**
	 * Get the arguments for the object.
	 *
	 * @return array<string, mixed>
	 */
	public function get_args(): array {
		$args = $this->parent_get_args();
		$args['properties'] = [];
		foreach ( $this->properties as $key => $prop ) {
			$args['properties'][ $key ] = $prop->get_args();
		}
		if ( [] !== $this->patternProperties ) {
			$args['patternProperties'] = [];
			foreach ( $this->patternProperties as $key => $prop ) {
				$args['patternProperties'][ $key ] = $prop->get_args();
			}
		} else {
			unset( $args['patternProperties'] );
		}
		return $args;
	}
}
