<?php

namespace Lipe\Lib\Settings;

use Lipe\Lib\Meta\Mutator_Trait;
use Lipe\Lib\Meta\Repo;

/**
 * CMB2 registered settings pages.
 *
 */
trait Settings_Trait {
	use Mutator_Trait;


	public function get_id() : string {
		return static::NAME;
	}


	public function get_meta_type() : string {
		return Repo::META_OPTION;
	}


	/**
	 * Get an option from the Meta repo.
	 *
	 * @param string $key
	 * @param mixed  $default_value
	 *
	 * @return mixed
	 */
	public function get_option( string $key, $default_value = null ) {
		return $this->get_meta( $key, $default_value );
	}


	/**
	 * Update an option.
	 *
	 * @param string         $key
	 * @param mixed|callable ...$value - If a callable is passed it will be called with the
	 *                                 previous value as the only argument.
	 *                                 If a callable is passed with an additional argument,
	 *                                 it will be used as the default value for `$this->get_meta()`.
	 *
	 * @return void
	 */
	public function update_option( string $key, ...$value ) : void {
		$this->update_meta( $key, ...$value );
	}
}
