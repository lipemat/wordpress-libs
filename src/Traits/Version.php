<?php

namespace Lipe\Lib\Traits;

/**
 * Allow running things specific to a class one time
 * based on it's internal version. Each class gets it's
 * own unique identifier and all uses of `run_for_version` will
 * use the same identifier and previous version.
 *
 * For global version tracking.
 *
 * @see    \Lipe\Lib\Util\Versions
 *
 */
trait Version {
	private $_option = 'lipe/lib/traits/versions';

	private $_version = '0.0.1';


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
		$this->_version = $version;
		if ( $this->update_required() ) {
			$this->update_version();

			return $func( ...$extra );
		}

		return null;
	}


	/**
	 * @internal
	 *
	 */
	private function update_version() : void {
		$versions                                    = $this->get_versions();
		$versions[ $this->get_version_identifier() ] = $this->_version;

		update_option( $this->_option, $versions );
	}


	/**
	 * @internal
	 *
	 * @return bool
	 */
	protected function update_required() : bool {
		$versions = $this->get_versions();

		return empty( $versions[ $this->get_version_identifier() ] ) || version_compare( $versions[ $this->get_version_identifier() ], $this->_version, '<' );
	}


	/**
	 * @internal
	 *
	 * @return array
	 */
	private function get_versions() : array {
		return get_option( $this->_option, [] );
	}


	/**
	 * @notice Anonymous classes do not have identifiers and may not be used.
	 *
	 * @return string
	 */
	private function get_version_identifier() : string {
		if ( ( new \ReflectionClass( $this ) )->isAnonymous() ) {
			throw new \BadMethodCallException( 'You may not use the Version Trait with anonymous classes, you will have to implement what you need within your anonymous class.' );
		}

		return \get_class( $this );
	}
}
