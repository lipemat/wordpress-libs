<?php

namespace Lipe\Lib\Traits;

/**
 * Allow running things specific to a class one time
 * based on its internal version. Each class gets its
 * own unique identifier and all uses of `run_for_version` will
 * use the same identifier and previous version.
 *
 * For global version tracking.
 *
 * @see    \Lipe\Lib\Util\Versions
 */
trait Version {
	/**
	 * Option stored in the database to track versions.
	 *
	 * @var string
	 */
	protected string $option = 'lipe/lib/traits/versions';

	/**
	 * Version requested to run an action for.
	 *
	 * @var string
	 */
	protected string $version = '0.0.1';


	/**
	 * Run a function one time for a particular version.
	 *
	 * @param callable $func     - The function to call if it has not yet been called for this version.
	 * @param string   $version  - The version to verify against.
	 * @param mixed    ...$extra - Any number of arguments to pass to the called function.
	 *
	 * @return mixed
	 */
	protected function run_for_version( callable $func, string $version, ...$extra ) {
		$this->version = $version;
		if ( $this->update_required() ) {
			$this->update_version();

			return $func( ...$extra );
		}

		return null;
	}


	/**
	 * Update the version in the database.
	 *
	 * This is called automatically by run_for_version.
	 *
	 * @internal
	 */
	protected function update_version(): void {
		$versions = $this->get_versions();
		$versions[ $this->get_version_identifier() ] = $this->version;

		update_option( $this->option, $versions );
	}


	/**
	 * Check if an update is required.
	 *
	 * @internal
	 *
	 * @return bool
	 */
	protected function update_required(): bool {
		$versions = $this->get_versions();

		return empty( $versions[ $this->get_version_identifier() ] ) || version_compare( $versions[ $this->get_version_identifier() ], $this->version, '<' );
	}


	/**
	 * Get the versions from the database.
	 *
	 * @internal
	 *
	 * @return array
	 */
	protected function get_versions(): array {
		return get_option( $this->option, [] );
	}


	/**
	 * Get the identifier for the class.
	 *
	 * This is used to track the version in the database.
	 *
	 * @notice Anonymous classes do not have identifiers and may not be used.
	 *
	 * @throws \BadMethodCallException - Will throw if using an anonymous class.
	 *
	 * @return string
	 */
	protected function get_version_identifier(): string {
		if ( ( new \ReflectionClass( $this ) )->isAnonymous() ) {
			throw new \BadMethodCallException( esc_html__( 'You may not use the Version Trait with anonymous classes, you will have to implement what you need within your anonymous class.', 'lipe' ) );
		}

		return \get_class( $this );
	}
}
