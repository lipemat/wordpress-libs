<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Utility class for testing purposes.
 *
 * @author Mat Lipe
 * @since  5.0.0
 */
class Testing {
	use Singleton;

	/**
	 * Has the exit method been called?
	 *
	 * @var bool
	 */
	public bool $did_exit = false;


	/**
	 * Do a clean exit while throwing an exception in test context.
	 *
	 * Like `wp_die()` but does not output any content.
	 *
	 * @throws \OutOfBoundsException -- If called in test context.
	 * @phpstan-return  never
	 */
	public function exit(): void {
		if ( \defined( 'WP_UNIT_DIR' ) ) {
			$this->did_exit = true;
			throw new \OutOfBoundsException( 'Exit called in test context.' );
		}
		exit;
	}
}
