<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query;

/**
 * Do not use this class. It will be removed in version 5.
 *
 * @deprecated In favor of `Args_Class`.
 */
abstract class Args_Abstract implements Args_Interface {
	use Args_Trait;
}
