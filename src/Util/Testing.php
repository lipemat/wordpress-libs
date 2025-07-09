<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Libs\Container\Instance;

/**
 * Utility class for testing purposes.
 *
 * @author Mat Lipe
 * @since  5.0.0
 */
class Testing {
	use Instance;

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
	 * Are we running in WP_DEBUG mode?
	 *
	 * @var bool
	 */
	public bool $is_wp_debug = WP_DEBUG;


	/**
	 * Do a clean exit while throwing an exception within a test context.
	 *
	 * Like `wp_die()` but does not output any content.
	 *
	 * @throws \OutOfBoundsException -- If called within a test context.
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
	 * Log an error message while storing it in a variable within a test context.
	 *
	 * @noinspection ForgottenDebugOutputInspection
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


	/**
	 * Check if WP_DEBUG is enabled in a way that may be overridden
	 * during unit tests.
	 *
	 * @return bool
	 */
	public function is_wp_debug(): bool {
		return $this->is_wp_debug;
	}
}
