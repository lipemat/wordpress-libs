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
 */
class Attributes implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * @var array<string, Prop>
	 */
	protected array $props = [];


	/**
	 * Define a new property for block attributes.
	 *
	 * @param string $name - Name of the attribute.
	 *
	 * @return Prop
	 */
	public function prop( string $name ): Prop {
		$this->props[ $name ] = new Prop( [] );
		return $this->props[ $name ];
	}


	/**
	 * @phpstan-return array<string, array<string, mixed>>
	 */
	public function get_args(): array {
		return \array_map( fn( $prop ) => $prop->get_args(), $this->props );
	}
}
