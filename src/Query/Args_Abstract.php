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

	/**
	 * Optionally pass existing arguments to preload this class.
	 *
	 * @param array $existing - Existing arguments to preload.
	 *
	 * @phpstan-ignore-next-line -- Using default `$existing` value for backwards compatibility.
	 */
	public function __construct( array $existing = [] ) {
		_deprecated_class( __CLASS__, '4.10.0', Args_Trait::class );
	}
}
