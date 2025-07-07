<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util\Logger;

/**
 * Storing log messages during unit tests.
 *
 * @author Mat Lipe
 * @since  5.6.0
 *
 */
class Testing implements Handle {
	/**
	 * The array of log messages.
	 *
	 * @var list<array{ id: string, level: Level, message: string }>
	 */
	protected array $messages = [];


	/**
	 * Get the logged messages.
	 *
	 * @return list<array{ id: string, level: Level, message: string }>
	 */
	public function get_messages(): array {
		return $this->messages;
	}


	/**
	 * Log a message to this class's internal storage.
	 *
	 * @param string $id      The identifier for the log entry.
	 * @param Level  $level   The log level.
	 * @param string $message The message to log.
	 *
	 * @return void
	 */
	public function log( string $id, Level $level, string $message ): void {
		$this->messages[] = [
			'id'      => $id,
			'level'   => $level,
			'message' => $message,
		];
	}
}
