<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Argument_Abstract
 *
 * @author  Mat Lipe
 * @since   7/30/2017
 *
 * @package Lipe\Lib\Post_Type\Extended_CPTS
 */
abstract class Argument_Abstract {
	abstract public function set( array $args );


	/**
	 *
	 * @param array $args
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Shared_Abstract
	 */
	abstract protected function return ( array $args );
}