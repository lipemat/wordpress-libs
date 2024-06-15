<?php
declare( strict_types=1 );

namespace Lipe\Lib\Traits;

/**
 * Use a class as a singleton.
 */
trait Singleton {

	/**
	 * Instance of this class for use as singleton
	 *
	 * @var static
	 */
	protected static $instance;

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
		static::$instance = static::instance();
		// @phpstan-ignore-next-line -- Some contexts will always return true/false.
		if ( method_exists( static::$instance, 'hook' ) ) {
			static::$instance->hook();
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
	 * Return the instance of this class.
	 *
	 * @return static
	 */
	public static function in(): static {
		return static::instance();
	}


	/**
	 * Return the instance of this class.
	 *
	 * @return static
	 */
	public static function instance(): static {
		if ( ! \is_a( static::$instance, __CLASS__ ) ) {
			// @phpstan-ignore-next-line -- No way to enforce an optional constructor in a trait.
			static::$instance = new static();
		}

		return static::$instance;
	}
}
