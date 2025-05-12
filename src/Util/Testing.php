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
	 * An array to store error messages.
	 *
	 * @var array<string>
	 */
	public array $errors = [];


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


	/**
	 * Log an error message while storing it in a variable in test context.
	 *
	 * @param string $message The message to log.
	 */
	public function error_log( string $message ): void {
		if ( \defined( 'WP_UNIT_DIR' ) ) {
			$this->errors[] = $message;
			return;
		}
		\error_log( $message ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	}
}
