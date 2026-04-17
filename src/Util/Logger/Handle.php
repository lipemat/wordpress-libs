<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util\Logger;

interface Handle {
	/**
	 * Log a message with the specified identifier and level.
	 *
	 * @param string $id      The identifier for the log entry.
	 * @param Level  $level   The log level.
	 * @param string $message The message to log.
	 *
	 * @return void
	 */
	public function log( string $id, Level $level, string $message ): void;


	/**
	 * Provide context for the log entry to handles which support it.
	 *
	 * @see \QM_Collector_Logger::interpolate
	 *
	 * @param array<string, mixed> $context - Context to provide.
	 *
	 * @return void
	 */
	public function provide_context( array $context ): void;
}
