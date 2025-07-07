<?php
//phpcs:disable Universal.Classes.DisallowFinalClass, LipePlugin.CodeAnalysis.PrivateInClass
declare( strict_types=1 );

namespace Lipe\Lib\Libs;

use Lipe\Lib\Util;
use Lipe\Lib\Util\Logger;

/**
 * Container for holding instances of various classes.
 *
 * Used to reset during unit tests consistently instead
 * of relying on internal $instance values.
 *
 * @author Mat Lipe
 * @since  5.6.0
 *
 * @phpstan-type SERVICES array{
 *     "Lipe\Lib\Util\Logger\Handles": Logger\Handles,
 *     "Lipe\Lib\Util\Testing": Util\Testing,
 * }
 *
 */
final class Container {
	/**
	 * The singleton instance of the container.
	 *
	 * @var self|null
	 */
	private static ?Container $instance = null;

	/**
	 * List of services available in the container.
	 *
	 * @var array
	 * @phpstan-var array<key-of<SERVICES>, \Closure(): SERVICES[key-of<SERVICES>]| SERVICES[key-of<SERVICES>]>
	 */
	private array $services;


	/**
	 * Constructor to load services.
	 */
	private function __construct() {
		$this->services[ Logger\Handles::class ] = fn() => new Logger\Handles();
		$this->services[ Util\Testing::class ] = fn() => new Util\Testing();
	}


	/**
	 * Get key from container
	 *
	 * @template TKey of key-of<SERVICES>
	 * @phpstan-param TKey $id
	 *
	 * @param string       $id The identifier for the service.
	 *
	 * @phpstan-return SERVICES[TKey]
	 */
	public function get( string $id ): mixed {
		if ( $this->services[ $id ] instanceof \Closure ) {
			$this->services[ $id ] = $this->services[ $id ]();
		}
		return $this->services[ $id ];
	}


	/**
	 * Reset the container instance.
	 *
	 * To be used in unit tests to ensure a clean state.
	 *
	 * @return void
	 */
	public static function reset(): void {
		self::$instance = null;
	}


	/**
	 * Get the singleton instance of the container.
	 *
	 * @return self
	 */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
