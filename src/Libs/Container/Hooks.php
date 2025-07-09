<?php
declare( strict_types=1 );

namespace Lipe\Lib\Libs\Container;

use Lipe\Lib\Libs\Container;

/**
 * Trait Hooks
 *
 * Provides static methods to initialize a class and ensure it is only initialized once.
 *
 * @author Mat Lipe
 * @since  5.6.0
 */
trait Hooks {
	/**
	 * Initialize the class and hook it into WordPress.
	 *
	 * @return void
	 */
	public static function init(): void {
		static::instance()->hook();
		Container::instance()->set_initialized( static::class );
	}


	/**
	 * Call this method as many times as needed, and the
	 * class will only `init()` one time.
	 *
	 * @return void
	 */
	public static function init_once(): void {
		if ( ! Container::instance()->is_initialized( static::class ) ) {
			static::init();
		}
	}
}
