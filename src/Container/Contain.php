<?php
declare( strict_types=1 );

namespace Lipe\Lib\Container;

/**
 * Interface for dependency injection containers.
 *
 * @author Mat Lipe
 * @since  5.8.0
 */
interface Contain {
	/**
	 * Here to protect the `instance` call from incorrect signatures.
	 */
	public function __construct();


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
	public function get_service( string $id ): ?object;


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
	public function set_service( string $id, object $class_instance ): void;


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
	public function set_factory( string $id, \Closure $factory ): void;


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
	public function get_factory( string $id ): ?\Closure;


	/**
	 * Mark a service as initialized.
	 *
	 * @phpstan-param class-string $id
	 *
	 * @param string               $id - The identifier for the service to mark as initialized.
	 *
	 * @return void
	 */
	public function set_initialized( string $id ): void;


	/**
	 * Check if a service has been initialized.
	 *
	 * @phpstan-param class-string $id
	 *
	 * @param string               $id - The identifier for the service to check.
	 *
	 * @return bool - True if the service is initialized, false otherwise.
	 */
	public function is_initialized( string $id ): bool;


	/**
	 * Reset the container instance.
	 *
	 * To be used in unit tests to ensure a clean state.
	 *
	 * @return void
	 */
	public static function reset(): void;


	/**
	 * Get the singleton instance of the container.
	 *
	 * @return static
	 */
	public static function instance(): static;
}
