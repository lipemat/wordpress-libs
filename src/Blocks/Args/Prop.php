<?php
declare( strict_types=1 );

namespace Lipe\Lib\Blocks\Args;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Blocks\Register_Block;

/**
 * Property shape for a block attribute.
 *
 * @author Mat Lipe
 * @since  5.4.0
 *
 * @phpstan-import-type ATTR_SHAPE from Register_Block
 * @phpstan-import-type QUERY from Register_Block
 *
 * @implements ArgsRules<ATTR_SHAPE>
 */
class Prop implements ArgsRules {
	/**
	 * @use Args<ATTR_SHAPE>
	 */
	use Args;

	public const TYPE_STRING  = 'string';
	public const TYPE_ARRAY   = 'array';
	public const TYPE_OBJECT  = 'object';
	public const TYPE_BOOLEAN = 'boolean';
	public const TYPE_NUMBER  = 'number';
	public const TYPE_INTEGER = 'integer';
	public const TYPE_NULL    = 'null';

	/**
	 * Data type of the property.
	 *
	 * @phpstan-var self::TYPE_*
	 * @var string
	 */
	public string $type;

	/**
	 * List of possible values for the property.
	 *
	 * @var list<string|int|bool>
	 */
	public array $enum;

	/**
	 * Default value for this attribute.
	 *
	 * @var mixed
	 */
	public mixed $default;

	/**
	 * Selector used to get the value.
	 *
	 * Any DOM selector supported by `querySelector`.
	 * - HTML tag
	 * - CSS class
	 * - CSS ID
	 *
	 * @link    https://developer.mozilla.org/en-US/docs/Web/API/Document/querySelector
	 *
	 * @example img
	 * @example .img-class
	 * @example #img-id
	 *
	 * @var string
	 */
	public string $selector;

	/**
	 * The type of source.
	 *
	 * @phpstan-var Source::SOURCE_*
	 * @var string
	 */
	public string $source;

	/**
	 * The HTML attribute to get.
	 *
	 * @example src
	 * @example href
	 *
	 * @var string
	 */
	public string $attribute;

	/**
	 * List of props to query for out of the HTML markup.
	 *
	 * @phpstan-var QUERY
	 * @var array<string, array<string, string>>
	 */
	public array $query;

	/**
	 * Meta key to use for the attribute.
	 *
	 * @deprecated
	 * @var string
	 */
	public string $meta;


	/**
	 * Define the type of the property.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#type-validation
	 *
	 * @phpstan-param self::TYPE_* $type
	 *
	 * @param string               $type - Data type of the property.
	 *
	 * @return static
	 */
	public function type( string $type ): static {
		$this->type = $type;
		return $this;
	}


	/**
	 * Define the list of possible values for the property.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#enum-validation
	 *
	 * @throws \InvalidArgumentException -- If enum value types do not match the attribute type.
	 *
	 * @param list<string|int|bool> $values - List of possible values for this attribute.
	 *
	 * @return static
	 */
	public function enum( array $values ): static {
		$predicate = self::TYPE_STRING === $this->type ? \is_string( ... ) : \is_int( ... );
		if ( ! \array_reduce( $values, fn( $carry, $item ) => $carry && $predicate( $item ), true ) ) {
			// translators: %s is the type of the attribute.
			throw new \InvalidArgumentException( esc_html( \sprintf( __( 'Enum values must be of type %s.', 'lipe' ), $this->type ) ) );
		}

		$this->enum = $values;
		return $this;
	}


	/**
	 * Default value for this attribute.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#default-value
	 *
	 * @throws \InvalidArgumentException -- If default value type does not match the attribute type.
	 *
	 * @param mixed $value - Default value for this attribute.
	 *
	 * @return static
	 */
	public function default( mixed $value ): static {
		$is_correct_type = match ( $this->type ) {
			self::TYPE_STRING                     => \is_string( $value ),
			self::TYPE_NUMBER, self::TYPE_INTEGER => \is_int( $value ),
			self::TYPE_BOOLEAN                    => \is_bool( $value ),
			self::TYPE_ARRAY, self::TYPE_OBJECT   => \is_array( $value ),
			default                               => false,
		};

		if ( ! $is_correct_type ) {
			// translators: %s is the type of the attribute.
			throw new \InvalidArgumentException( esc_html( \sprintf( __( 'The default value must be of type %s.', 'lipe' ), $this->type ) ) );
		}

		$this->default = $value;
		return $this;
	}


	/**
	 * Source of the value.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#value-source
	 *
	 * @return Source
	 */
	public function source(): Source {
		return new Source( $this );
	}
}
