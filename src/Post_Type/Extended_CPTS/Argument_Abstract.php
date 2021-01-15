<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Base class for a Extended CPT argument.
 */
abstract class Argument_Abstract {
	abstract public function set( array $args );


	/**
	 *
	 * @param array $args
	 *
	 * @return Shared_Abstract
	 */
	abstract protected function return ( array $args );
}
