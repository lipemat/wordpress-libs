<?php
declare( strict_types=1 );

namespace Lipe\Lib\Blocks;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Blocks\Args\Prop;

/**
 * A fluent interface for registering block attributes.
 *
 * @author Mat Lipe
 * @since  5.4.0
 *
 * @see    Register_Block
 *
 * @link   https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/
 *
 * @phpstan-import-type ATTR_SHAPE from Register_Block
 * @template ATTR_NAMES of string
 *
 * @implements ArgsRules<array<ATTR_NAMES, ATTR_SHAPE>>
 */
class Attributes implements ArgsRules {
	/**
	 * @use Args<array<ATTR_NAMES, ATTR_SHAPE>>
	 */
	use Args;

	/**
	 * @var array<string, Prop>
	 * @phpstan-var array<ATTR_NAMES, Prop>
	 */
	protected array $props = [];


	/**
	 * Optionally pass existing arguments to preload this class.
	 *
	 * @phpstan-param array<ATTR_NAMES, ATTR_SHAPE> $existing
	 *
	 * @param array<string, mixed>                  $existing - Existing arguments to preload.
	 */
	public function __construct( array $existing ) {
		$this->load_array_into_properties( $existing );
	}


	/**
	 * Define a new property for block attributes.
	 *
	 * @phpstan-param ATTR_NAMES $name
	 *
	 * @param string             $name - Name of the attribute.
	 *
	 * @return Prop
	 */
	public function prop( string $name ): Prop {
		$this->props[ $name ] = new Prop( [] );
		return $this->props[ $name ];
	}


	/**
	 * @phpstan-return array<ATTR_NAMES, ATTR_SHAPE>
	 */
	public function get_args(): array {
		return \array_map( fn( $prop ) => $prop->get_args(), $this->props );
	}
}
