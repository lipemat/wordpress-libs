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
	 * Contexts for the logged messages.
	 *
	 * @var list<array<string, mixed>>
	 */
	protected array $context = [];


	/**
	 * Get the logged messages.
	 *
	 * @param bool $with_context (optional) Whether to include the context array with each message (default: false).
	 *
	 * @phpstan-return ($with_context is true ? list<array{ id: string, level: Level, message: string, context: array<string, mixed> }> :
	 *                 list<array{ id: string, level: Level, message: string }>)
	 *
	 * @return list<array{ id: string, level: Level, message: string }>
	 */
	public function get_messages( bool $with_context = false ): array {
		if ( $with_context ) {
			return \array_map( function( array $message, int $i ) {
				$message['context'] = $this->context[ $i ];
				return $message;
			}, $this->messages, \array_keys( $this->context ) );
		}
		return $this->messages;
	}


	/**
	 * Add a context array to the log messages.
	 *
	 * @param array<string, mixed> $context - Context to provide.
	 */
	public function provide_context( array $context ): void {
		$this->context[] = $context;
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
