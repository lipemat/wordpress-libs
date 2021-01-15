<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Base class for an Extended CPT shared.
 *
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
