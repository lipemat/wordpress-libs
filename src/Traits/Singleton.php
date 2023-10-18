<?php

namespace Lipe\Lib\Traits;

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
	protected static $inited = false;


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
		static::$inited = true;
	}


	/**
	 * Call this method as many times as needed, and the
	 * class will only init() one time.
	 *
	 * @static
	 *
	 * @return void
	 */
	public static function init_once(): void {
		if ( ! static::$inited ) {
			static::init();
		}
	}


	/**
	 * Return the instance of this class.
	 *
	 * @return static
	 */
	public static function in() {
		return static::instance();
	}


	/**
	 * Return the instance of this class.
	 *
	 * @return static
	 */
	public static function instance() {
		if ( ! is_a( static::$instance, __CLASS__ ) ) {
			static::$instance = new static(); // @phpstan-ignore-line
		}

		return static::$instance; // @phpstan-ignore-line
	}
}
