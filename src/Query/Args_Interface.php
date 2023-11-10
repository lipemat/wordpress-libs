<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query;

/**
 * Sister implementation to the `Args_Class` trait.
 *
 * Defines the rules an "Args" class must follow for public consumption.
 *
 * @author Mat Lipe
 * @since  4.5.0
 */
interface Args_Interface {
	/**
	 * Optionally pass existing arguments to preload this class.
	 *
	 * @param array $existing - Existing arguments to preload.
	 */
	public function __construct( array $existing = [] );

	/**
	 * Get the finished arguments as an array.
	 *
	 * @return array
	 */
	public function get_args(): array;
}
