<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util\Logger;

/**
 * Query_Monitor class for logging messages to the Query Monitor plugin.
 *
 * @author Mat Lipe
 * @since  5.6.0
 *
 * @see    \QM_Collector_Logger::set_up
 *
 */
class Query_Monitor implements Handle {

	/**
	 * Log a message to Query Monitor.
	 *
	 * @param string $id      The identifier for the log entry.
	 * @param Level  $level   The log level.
	 * @param string $message The message to log.
	 *
	 * @return void
	 */
	public function log( string $id, Level $level, string $message ): void {
		if ( ! \class_exists( \QM::class ) ) {
			return;
		}

		if ( 0 === did_action( 'plugins_loaded' ) ) {
			add_action( 'plugins_loaded', function() use ( $id, $level, $message ) {
				$this->log( $id, $level, $message );
			}, 100 );
			return;
		}

		$message = \sprintf( '%s: %s', $id, $message );

		match ( $level ) {
			Level::Debug   => \QM::debug( $message ),
			Level::Error   => \QM::error( $message ),
			Level::Notice  => \QM::notice( $message ),
			Level::Warning => \QM::warning( $message ),
		};
	}
}
