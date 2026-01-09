<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Util\Logger\WithContext;

/**
 * Utility class for logging messages.
 *
 * @author Mat Lipe
 * @since  5.6.0
 *
 */
class Logger {

	/**
	 * Constructs a new Logger instance for sending log messages
	 * to the appropriate handles.
	 *
	 * @param string $id The identifier for the logger instance.
	 */
	final protected function __construct(
		protected string $id,
	) {
	}


	/**
	 * Log a message at the warning level.
	 *
	 * @param string               $message - The message to log.
	 * @param array<string, mixed> $context - Optional contextual information.
	 *
	 * @return void
	 */
	public function warn( string $message, array $context = [] ): void {
		$this->log( Logger\Level::Warning, $message, $context );
	}


	/**
	 * Log a message at the error level.
	 *
	 * @param string               $message - The message to log.
	 * @param array<string, mixed> $context - Optional contextual information.
	 *
	 * @return void
	 */
	public function error( string $message, array $context = [] ): void {
		$this->log( Logger\Level::Error, $message, $context );
	}


	/**
	 * Log a message at the notice level.
	 *
	 * @param string               $message - The message to log.
	 * @param array<string, mixed> $context - Optional contextual information.
	 *
	 * @return void
	 */
	public function notice( string $message, array $context = [] ): void {
		$this->log( Logger\Level::Notice, $message, $context );
	}


	/**
	 * Log a message at the debug level.
	 *
	 * @param string               $message - The message to log.
	 * @param array<string, mixed> $context - Optional contextual information.
	 *
	 * @return void
	 */
	public function debug( string $message, array $context = [] ): void {
		if ( ! Testing::in()->is_wp_debug() ) {
			return;
		}
		$this->log( Logger\Level::Debug, $message, $context );
	}


	/**
	 * Log a message at the given level.
	 *
	 * @since  5.9.0 - Added context support.
	 *
	 * @param Logger\Level         $level   The log level.
	 * @param string               $message The message to log.
	 * @param array<string, mixed> $context Optional contextual information.
	 */
	protected function log( Logger\Level $level, string $message, array $context = [] ): void {
		$handles = Logger\Handles::in()->get_handles();
		foreach ( $handles as $handle ) {
			if ( $handle instanceof WithContext ) {
				$handle->provide_context( $context );
			}

			$handle->log( $this->id, $level, $message );
		}
	}


	/**
	 * Create a new Logger instance.
	 *
	 * @param string $id The identifier for the logger instance.
	 *
	 * @return Logger
	 */
	public static function factory( string $id ): Logger {
		return new static( $id );
	}
}
