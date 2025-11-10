<?php
//phpcs:disable WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
declare( strict_types=1 );

namespace Lipe\Lib\Libs\Container;

use Lipe\Lib\Libs\Container;

/**
 * Provides static methods to get an instance of the class
 * from the container using a factory.
 *
 * @author Mat Lipe
 * @since  5.8.0
 *
 * @template CONSTRUCT_PARAMS
 */
trait Factory {
	/**
	 * Get an instance of the class from the container
	 * using a factory.
	 *
	 * @phpstan-param CONSTRUCT_PARAMS ...$construct_args
	 *
	 * @formatter:off
	 *
	 * @param mixed  ...$construct_args - Constructor arguments.
	 *
	 * @formatter:on
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
