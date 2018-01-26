<?php

namespace Lipe\Lib\Meta;

/**
 * Meta_Class_Abstract
 *
 * @author  Mat Lipe
 * @since   1.0.0
 *
 * @package Lipe\Lib\Meta
 */
abstract class Meta_Class_Abstract {

	/**
	 * All meta keys used by this class must be returned here.
	 * Used to map keys back to the proper class when retrieving meta values
	 *
	 * @return array
	 */
	abstract public function get_keys() : array;


	/**
	 * Should be called via the Meta_Repo
	 *
	 * Not recommended to call directly via the call which extends this
	 * abstract, although technically it will work.
	 *
	 *
	 * @param int    $object_id
	 * @param string $key
	 * @param string $meta_type - user, term, post
	 *
	 * @see Meta_Repo::get_meta()
	 *
	 * @internal
	 *
	 * @return mixed
	 */
	abstract public function get_meta( $object_id, string $key, string $meta_type );


	public function __construct() {
		$this->register_with_repo();
	}


	protected function register_with_repo() : void {
		Meta_Repo::instance()->register_keys( $this, $this->get_keys() );
	}
}
