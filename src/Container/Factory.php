<?php
declare( strict_types=1 );

namespace Lipe\Lib\Container;

/**
 * Provides static methods to get an instance of the class
 * from the container using a factory.
 *
 * @author Mat Lipe
 * @since  5.8.0
 */
trait Factory {
	/**
	 * Get an instance of the class from the container
	 * using a factory.
	 *
	 * @param mixed ...$construct_args - Constructor arguments.
	 *
	 * @return static
	 */
	protected static function factorize( ...$construct_args ): static {
		$factory = Container::instance()->get_factory( static::class );
		if ( ! $factory instanceof \Closure ) {
			Container::instance()->set_factory( static::class, $factory = fn( ...$construct_args ) => new static( ...$construct_args ) );
		}
		return $factory( ...$construct_args );
	}
}
