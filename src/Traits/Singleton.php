<?php

namespace Lipe\Lib\Traits;

trait Singleton {

	/**
	 * Instance of this class for use as singleton
	 */
	protected static $instance;


	/**
	 * Create the instance of the class
	 *
	 * @static
	 * @return void
	 */
	public static function init() {
		static::$instance = static::instance();
		if( method_exists( static::$instance, 'hook' ) ){
			static::$instance->hook();
		}
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