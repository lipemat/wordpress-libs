<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * @author Mat Lipe
 * @since  5.0.0
 *
 */
class Files {
	use Singleton;

	/**
	 * Get the WP Filesystem object.
	 *
	 * @return \WP_Filesystem_Base
	 */
	public function get_wp_filesystem(): \WP_Filesystem_Base {
		global $wp_filesystem;
		if ( ! $wp_filesystem ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		return $wp_filesystem;
	}
}
