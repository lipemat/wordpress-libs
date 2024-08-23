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

	public const RUNNING_HANDLE = 'lipe/project/theme/running';


	/**
	 * Is webpack currently running on this environment?
	 *
	 * - If SCRIPT_DEBUG is false, we always return false.
	 * - Not on a local environment is always false.
	 * - Check for the `.running` Webpack Dev file.
	 *
	 * @requires js-boilerplate:v9.2.0+
	 *
	 * @param ResourceHandles $handles - The handles to check.
	 *
	 * @return bool
	 */
	public function is_webpack_running( ResourceHandles $handles ): bool {
		if ( ! SCRIPT_DEBUG || 'local' !== wp_get_environment_type() ) {
			return false;
		}
		$enum = $handles::from( self::RUNNING_HANDLE );
		return file_exists( $enum->dist_path() . $enum->file() );
	}
}
