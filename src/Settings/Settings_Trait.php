<?php

namespace Lipe\Lib\Settings;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * CMB2 registered settings pages
 *
 * @author Mat Lipe
 * @since  2.0.0
 *
 */
trait Settings_Trait {
	use Mutator_Trait;


	public function get_id() : string {
		return static::NAME;
	}


	public function get_meta_type() : string {
		return 'option';
	}


	/**
	 * Get an option from the Meta repo.
	 *
	 * @param string $key
	 * @param null   $default
	 *
	 * @return mixed
	 */
	public function get_option( $key, $default = null ) {
		return $this->get_meta( $key, $default );
	}


	/**
	 * Update an option.
	 *
	 * @param string $key
	 * @param mixed|callable $value - If a callable is passed it will be called with the
	 *                              previous value as the only argument.
	 * @param mixed                 If a callable is passed with an additional argument,
	 *                              it be be used as the default value for `$this->get_meta()`.
	 *
	 * @since 2.17.0 (Support passing a callback as the second argument)
	 *
	 * @return void
	 */
	public function update_option( string $key, ...$value ) : void {
		$this->update_meta( $key, $value );
	}
}
