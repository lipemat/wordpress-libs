<?php
//phpcs:disable WordPress.NamingConventions.ValidVariableName
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * Array type for the REST API schema.
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#arrays
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class ArrayType implements ArgsRules, TypeRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args {
		get_args as parent_get_args;
	}

	/**
	 * Data type for the schema.
	 *
	 * @phpstan-var 'array'
	 * @var string
	 */
	public string $type = Resource_Schema::TYPE_ARRAY;

	/**
	 * The schema for the items in the array.
	 *
	 * @var Type
	 */
	public Type $items;

	/**
	 * The minimum number of items in the array.
	 *
	 * @var int
	 */
	public int $minItems;

	/**
	 * The maximum number of items in the array.
	 *
	 * @var int
	 */
	public int $maxItems;

	/**
	 * Whether the items in the array must be unique.
	 *
	 * @var bool
	 */
	public bool $uniqueItems;


	/**
	 * Set the schema for the items in the array.
	 *
	 * @return Type
	 */
	public function items(): Type {
		$this->items = new Type();
		return $this->items;
	}


	/**
	 * Set the minimum number of items in the array.
	 *
	 * @param int $min The minimum number of items in the array.
	 *
	 * @return static
	 */
	public function min_items( int $min ): static {
		$this->minItems = $min;
		return $this;
	}


	/**
	 * Set the maximum number of items in the array.
	 *
	 * @param int $max The maximum number of items in the array.
	 *
	 * @return static
	 */
	public function max_items( int $max ): static {
		$this->maxItems = $max;
		return $this;
	}


	/**
	 * Set whether the items in the array must be unique.
	 *
	 * @param bool $is_unique Whether the items in the array must be unique.
	 *
	 * @return static
	 */
	public function unique_items( bool $is_unique = true ): static {
		$this->uniqueItems = $is_unique;
		return $this;
	}


	/**
	 * @return array<string, mixed>
	 */
	public function get_args(): array {
		$args = $this->parent_get_args();
		if ( ! isset( $this->items ) ) {
			return $args;
		}
		$args['items'] = $this->items->get_args();
		return $args;
	}
}
