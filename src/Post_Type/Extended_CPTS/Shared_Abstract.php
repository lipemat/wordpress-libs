<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Shared_Abstract
 *
 * @author  Mat Lipe
 * @since   7/30/2017
 *
 * @package Lipe\Lib\Post_Type\Extended_CPTS
 */
abstract class Shared_Abstract {
	/**
	 *
	 * @param array $args
	 *
	 * @return static
	 */
	abstract protected function return( array $args );
}