<?php
declare( strict_types=1 );

namespace Lipe\Lib\Libs\Container;

/**
 * Trait Instance
 *
 * Provides static methods to get an instance of the class from the container.
 *
 * Matches signature of the `Singleton` trait to prevent errors on existing projects
 * as/if classes are updated to use the container.
 *
 * @author Mat Lipe
 * @since  5.6.0
 *
 * @template T
 */
trait Instance {

	/**
	 * Whether the class has been initialized.
	 *
	 * @var bool
	 */
	protected static bool $initialized = false;


	/**
	 * Create the instance of the class.
	 *
	 * @return void
	 */
	public static function init(): void {
		// @phpstan-ignore-next-line -- Some contexts will always return true/false.
		if ( \method_exists( static::instance(), 'hook' ) ) {
			static::instance()->hook();
		}
		static::$initialized = true;
	}


	/**
	 * Call this method as many times as needed, and the
	 * class will only init() one time.
	 *
	 * @return void
	 */
	public static function init_once(): void {
		if ( ! static::$initialized ) {
			static::init();
		}
	}


	/**
	 * Get the instance of the class from the container.
	 *
	 * @phpstan-return T
	 */
	public static function instance() {
		return self::in();
	}
}
