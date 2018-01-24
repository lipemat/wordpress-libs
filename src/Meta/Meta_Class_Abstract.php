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

	abstract public function get_keys();


	/**
	 *
	 * @param int    $object_id
	 * @param string $key
	 * @param string $meta_type - user, term, post (defaults to 'post')
	 *
	 * @return mixed
	 */
	abstract public function get_meta( $object_id, string $key, string $meta_type = 'post' );


	public function __construct() {
		$this->register_with_repo();
	}


	protected function register_with_repo() : void {
		Meta_Repo::instance()->register_keys( $this, $this->get_keys() );
	}


	/**
	 *
	 * @param int    $object_id
	 * @param string $key
	 * @param string $meta_type - user, term, post (defaults to 'post')
	 *
	 * @static
	 *
	 * @return mixed
	 */
	public static function meta( $object_id, string $key, string $meta_type = 'post' ) {
		return static::instance()->get_meta( $object_id, $key, $meta_type );
	}

}
