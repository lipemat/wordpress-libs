<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util\Logger;

use Lipe\Lib\Container\Instance;

/**
 * Registered handles for the Logger.
 *
 * @author Mat Lipe
 * @since  5.6.0
 *
 */
class Handles {
	use Instance;

	/**
	 * The array of registered handles.
	 *
	 * @var array<string, Handle>
	 */
	protected array $handles = [];


	/**
	 * Initializes the default handles and registers the Testing handle
	 * if in a testing environment.
	 */
	final public function __construct() {
		$this->handles = [
			'query-monitor' => new Query_Monitor(),
			'error-log'     => new Error_Log(),
		];

		// Register the Testing handle if in a testing environment.
		if ( \defined( 'WP_TESTS_DIR' ) ) {
			$this->register_handle( 'testing', new Testing() );
		}
	}


	/**
	 * Get the registered handles.
	 *
	 * @return array<string, Handle> The array of registered handles.
	 */
	public function get_handles(): array {
		return $this->handles;
	}


	/**
	 * Register a new handle.
	 *
	 * @param string $name   The name of the handle.
	 * @param Handle $handle The handle instance.
	 *
	 * @return void
	 */
	public function register_handle( string $name, Handle $handle ): void {
		$this->handles[ $name ] = $handle;
	}


	/**
	 * Unregister a handle.
	 *
	 * @param string $name The name of the handle to unregister.
	 *
	 * @return void
	 */
	public function unregister_handle( string $name ): void {
		if ( isset( $this->handles[ $name ] ) ) {
			unset( $this->handles[ $name ] );
		}
	}
}
