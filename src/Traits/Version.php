<?php

namespace Lipe\Lib\Traits;

/**
 * Allow running things specific to a class one time
 * based on it's internal version.
 *
 * For global version tracking
 *
 * @author Mat Lipe
 * @since  2.10.0
 *
 * @see    \Lipe\Lib\Util\Versions
 *
 */
trait Version {
	private $option = 'lipe/lib/traits/versions';


	protected function run_for_version( callable $func, float $version, ...$extra ) : void {
		if ( $this->update_required( $version ) ) {
			$func( ...$extra );

			$this->update_version( $version );
		}
	}


	private function update_version( float $version ) : void {
		$versions                               = get_option( $this->option, [] );
		$versions[ \get_parent_class( $this ) ] = $version;

		update_option( $this->option, $versions );
	}


	private function update_required( float $version ) : bool {
		$versions = get_option( $this->option, [] );

		return empty( $versions[ \get_parent_class( $this ) ] ) || version_compare( $versions[ \get_parent_class( $this ) ], $version, '<' );
	}

}
