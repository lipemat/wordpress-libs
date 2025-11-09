<?php
//phpcs:disable Universal.Classes.DisallowFinalClass, LipePlugin.CodeAnalysis.PrivateInClass
declare( strict_types=1 );

namespace Lipe\Lib\Libs;

/**
 * Container for holding instances of various classes.
 *
 * Used to reset during unit tests consistently instead
 * of relying on internal $instance values.
 *
 * @author Mat Lipe
 * @since  5.6.0
 */
final class Container {
	/**
	 * The singleton instance of the container.
	 *
	 * @var ?self
	 */
	private static ?Container $instance = null;

	/**
	 * List of services available in the container.
	 *
	 * @var array<class-string, mixed>
	 */
	private array $services = [];

	/**
	 * List of factories for services available in the container.
	 *
	 * @var array<class-string, \Closure>
	 */
	private array $factories = [];

	/**
	 * Track services that have been initialized.
	 *
	 * @see Hooks::init()
	 *
	 * @var array<class-string, bool>
	 */
	private array $intialized = [];


	/**
	 * Get key from container
	 *
	 * @template T of object
	 * @phpstan-param class-string<T> $id
	 *
	 * @formatter:off
	 *
	 * @param string $id - The identifier for the service.
	 *
	 * @formatter:on
	 *
	 * @phpstan-return T|null
	 */
	public function get_service( string $id ): ?object {
		return $this->services[ $id ] ?? null;
	}


	/**
	 * Set a service in the container.
	 *
	 * @template T of object
	 * @phpstan-param class-string<T> $id
	 * @phpstan-param T               $class_instance
	 *
	 * @formatter:off
	 * @param string $id             - The identifier for the service to set.
	 * @param object $class_instance - The value to set for the service.
	 * @formatter:on
	 *
	 * @return void
	 */
	public function set_service( string $id, object $class_instance ): void {
		$this->services[ $id ] = $class_instance;
	}


	/**
	 * Set a factory for a service in the container.
	 *
	 * @template T of object
	 * @phpstan-param class-string<T>       $id
	 * @phpstan-param \Closure(mixed...): T $factory
	 *
	 * @formatter:off
	 * @param string $id        - The identifier for the service to set.
	 * @param \Closure $factory - The factory to use to create the service.
	 * @formatter:on
	 *
	 * @return void
	 */
	public function set_factory( string $id, \Closure $factory ): void {
		$this->factories[ $id ] = $factory;
	}


	/**
	 * Get a factory for a service in the container.
	 *
	 * @template T of object
	 * @phpstan-param class-string<T> $id
	 *
	 * @formatter:off
	 * @param string $id The identifier for the factory to get.
	 * @formatter:on
	 *
	 * @phpstan-return (\Closure(mixed...): T)|null
	 * @return ?\Closure
	 */
	public function get_factory( string $id ): ?\Closure {
		return $this->factories[ $id ] ?? null;
	}


	/**
	 * Mark a service as initialized.
	 *
	 * @phpstan-param class-string $id
	 *
	 * @param string               $id - The identifier for the service to mark as initialized.
	 *
	 * @return void
	 */
	public function set_initialized( string $id ): void {
		$this->intialized[ $id ] = true;
	}


	/**
	 * Check if a service has been initialized.
	 *
	 * @phpstan-param class-string $id
	 *
	 * @param string               $id - The identifier for the service to check.
	 *
	 * @return bool - True if the service is initialized, false otherwise.
	 */
	public function is_initialized( string $id ): bool {
		return isset( $this->intialized[ $id ] ) && $this->intialized[ $id ];
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
