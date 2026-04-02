<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use Lipe\Lib\Traits\Singleton;

/**
 * Utility functions for working with manifest driven resources.
 *
 * @since    5.1.0
 */
class Util {
	use Singleton;

	/**
	 * Is webpack currently running on this environment?
	 *
	 * - If SCRIPT_DEBUG is false, we always return false.
	 * - Not on a local environment is always false.
	 * - Check for the `.running` Webpack Dev file.
	 *
	 * @requires js-boilerplate:v9.2.0+
	 *
	 * @param ResourceHandles $handle - The handles to check.
	 *
	 * @return bool
	 */
	public function is_webpack_running( ResourceHandles $handle ): bool {
		if ( ! SCRIPT_DEBUG || 'local' !== wp_get_environment_type() ) {
			return false;
		}
		return file_exists( $handle->dist_path() . '.running' );
	}


	/**
	 * Detect if we're working with a javascript resource.
	 *
	 * - Supports URL containing or not containing separate file names.
	 * - Supports URL containing or not a query string.
	 *
	 * @since 5.10.0
	 *
	 * @param ResourceHandles $handle - Handle to check.
	 *
	 * @return bool
	 */
	public function is_javascript_resource( ResourceHandles $handle ): bool {
		$file = $handle->file();
		if ( '' === $file ) {
			$file = $handle->dist_url();
		}
		$part = \strtok( $file, '?' );
		if ( false === $part ) {
			return false;
		}
		return \str_ends_with( $part, '.js' );
	}
}
