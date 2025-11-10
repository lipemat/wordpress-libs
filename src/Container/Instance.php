<?php
declare( strict_types=1 );

namespace Lipe\Lib\Container;

/**
 * Provides static methods to get an instance of the class from the container.
 *
 * Matches signature of the `Singleton` trait to prevent errors on existing projects
 * as classes are updated to use the container.
 *
 * @author Mat Lipe
 * @since  5.6.0
 */
trait Instance {
	/**
	 * Get the instance of the class from the container.
	 *
	 * @return static
	 */
	public static function instance(): static {
		$instance = Container::instance()->get_service( static::class );
		if ( ! $instance instanceof static ) {
			// @phpstan-ignore new.static (No way to enforce an optional constructor in a trait.)
			Container::instance()->set_service( static::class, $instance = new static() );
		}
		return $instance;
	}


	/**
	 * Return the instance of this class.
	 *
	 * @return static
	 */
	public static function in(): static {
		return static::instance();
	}
}
