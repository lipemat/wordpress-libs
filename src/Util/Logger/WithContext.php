<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util\Logger;

/**
 * A temporary interface to allow log handles to support context
 * information without breaking backwards compatibility.
 *
 * @author Mat Lipe
 * @since  5.9.0
 *
 * @todo   Remove in 6.0.0 in favor of adding context to the Handle interface.
 *
 */
interface WithContext {
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
