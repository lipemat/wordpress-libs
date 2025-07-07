<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

/**
 * Utility class for logging messages.
 *
 * @author Mat Lipe
 * @since  5.6.0
 *
 */
class Logger {

	/**
	 * Constructor.
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
	 * @param string $message - The message to log.
	 *
	 * @return void
	 */
	public function warn( string $message ): void {
		$this->log( Logger\Level::Warning, $message );
	}


	/**
	 * Log a message at the error level.
	 *
	 * @param string $message - The message to log.
	 *
	 * @return void
	 */
	public function error( string $message ): void {
		$this->log( Logger\Level::Error, $message );
	}


	/**
	 * Log a message at the notice level.
	 *
	 * @param string $message - The message to log.
	 *
	 * @return void
	 */
	public function notice( string $message ): void {
		$this->log( Logger\Level::Notice, $message );
	}


	/**
	 * Log a message at the debug level.
	 *
	 * @param string $message - The message to log.
	 *
	 * @return void
	 */
	public function debug( string $message ): void {
		if ( ! Testing::in()->is_wp_debug() ) {
			return;
		}
		$this->log( Logger\Level::Debug, $message );
	}


	/**
	 * Log a message at the given level.
	 *
	 * @param Logger\Level $level   The log level.
	 * @param string       $message The message to log.
	 */
	protected function log( Logger\Level $level, string $message ): void {
		$handles = Logger\Handles::in()->get_handles();
		foreach ( $handles as $handle ) {
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
