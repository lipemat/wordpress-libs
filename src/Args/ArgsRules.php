<?php
declare( strict_types=1 );

namespace Lipe\Lib\Args;

/**
 * Sister implementation to the `Args_Class` trait.
 *
 * Defines the rules an "Args" class must follow for public consumption.
 *
 * @author Mat Lipe
 * @since  4.5.0
 *
 * @template SHAPE of array<string, mixed>
 */
interface ArgsRules {
	/**
	 * Optionally pass existing arguments to preload this class.
	 *
	 * @param array<string, mixed> $existing - Existing arguments to preload.
	 */
	public function __construct( array $existing );


	/**
	 * Get the finished arguments as an array.
	 *
	 * @phpstan-return SHAPE
	 * @return array<string, mixed>
	 */
	public function get_args(): array;


	/**
	 * Merge the arguments from another Args_Interface object into this one.
	 *
	 * @phpstan-param ArgsRules<SHAPE> $overrides
	 *
	 * @param ArgsRules                $overrides - Args to override the current ones.
	 *
	 * @return void
	 */
	public function merge( ArgsRules $overrides ): void;
}
