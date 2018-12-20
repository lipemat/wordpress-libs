<?php

namespace Lipe\Lib\Settings;

use Lipe\Lib\Meta\Repo;

/**
 * CMB2 registered settings pages
 *
 * @author Mat Lipe
 * @since  2.0.0
 *
 */
trait Settings_Trait {

	/**
	 * Use a static to get actual option so we can have a get_option
	 * in the child class and still use this classes methods
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public function get_option( $key, $default = null ) {
		$value = Repo::in()->get_value( static::NAME, $key, 'option' );
		if ( null !== $default && null === $value ) {
			return $default;
		}

		return $value;
	}


	/**
	 * Update an option
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function update_option( string $key, $value ) : void {
		$values         = get_option( static::NAME, [] );
		$values[ $key ] = $value;
		update_option( static::NAME, $values );
	}
}
