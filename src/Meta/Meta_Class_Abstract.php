<?php

namespace Lipe\Lib\Meta;

/**
 * Meta_Class_Abstract
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Lib\Meta
 */
abstract class Meta_Class_Abstract {

	abstract function get_keys();

	abstract function get_value( $id, $key );

	public function __construct() {
		$this->register_with_repo();
	}

	protected function register_with_repo(){
		Meta_Repo::instance()->register_keys( $this, $this->get_keys() );
	}

}