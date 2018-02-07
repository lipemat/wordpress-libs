<?php

namespace Lipe\Lib\Traits;

trait Singleton {

	/**
	 * Instance of this class for use as singleton
	 */
	protected static $instance;

	protected static $inited = false;


	/**
	 * Create the instance of the class
	 *
	 * @static
	 * @return void
	 */
	public static function init() : void {
		static::$instance = static::instance();
		if( method_exists( static::$instance, 'hook' ) ){
			static::$instance->hook();
		}
		static::$inited = true;
	}


	/**
	 * Call this method as many times as needed and the
	 * class will only init() one time.
	 *
	 * @static
	 *
	 * @return void
	 */
	public static function init_once() : void {
		if( !static::$inited ){
			static::init();
			static::$inited = true;
		}
	}


	/**
	 *
	 * @static
	 *
	 * @return $this
	 */
	public static function in() {
		return self::instance();
	}


	/**
	 *
	 * @static
	 *
	 * @return $this
	 */
	public static function instance() {
		if( !is_a( static::$instance, __CLASS__ ) ){
			static::$instance = new static();
		}

		return static::$instance;
	}
}
