<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util\Logger;

use Lipe\Lib\Util;

/**
 * Error_Log class for logging messages to the PHP error log.
 *
 * @author Mat Lipe
 * @since  5.6.0
 *
 */
class Error_Log implements Handle {
	/**
	 * Context for the last log message.
	 *
	 * @var array<string, mixed>
	 */
	protected array $context = [];


	/**
	 * Add a context array to the log messages.
	 *
	 * @notice Not passed to the error log.
	 *         Override this class if you want to use this.
	 *
	 * @param array<string, mixed> $context - Context to provide.
	 */
	public function provide_context( array $context ): void {
		$this->context = $context;
	}


	/**
	 * Log a message to the error log.
	 *
	 * @param string $id      The identifier for the log entry.
	 * @param Level  $level   The log level.
	 * @param string $message The message to log.
	 *
	 * @return void
	 */
	public function log( string $id, Level $level, string $message ): void {
		$prefix = match ( $level ) {
			Level::Debug   => '[DEBUG] ',
			Level::Notice  => '[NOTICE] ',
			Level::Warning => '[WARNING] ',
			Level::Error   => '[ERROR] ',
		};

		Util\Testing::in()->error_log( $prefix . $id . ': ' . $message );
	}
}
