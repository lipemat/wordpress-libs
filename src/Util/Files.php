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
	 * Copy a directory recursively.
	 *
	 * @param string $source      - The directory to copy.
	 * @param string $destination - The directory to copy to.
	 *
	 * @return bool - `false` if any file fails to copy.
	 */
	public function copy_directory( string $source, string $destination ): bool {
		$filesystem = $this->get_wp_filesystem();
		if ( ! $filesystem->is_dir( $destination ) ) {
			$filesystem->mkdir( $destination );
		}

		$directory = new \RecursiveDirectoryIterator( $source, \RecursiveDirectoryIterator::SKIP_DOTS );
		/** @var \RecursiveDirectoryIterator $iterator */
		$iterator = new \RecursiveIteratorIterator( $directory, \RecursiveIteratorIterator::SELF_FIRST );

		foreach ( $iterator as $item ) {
			if ( ! $item instanceof \SplFileInfo ) {
				continue;
			}
			$path = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathname();
			if ( $item->isDir() ) {
				$filesystem->mkdir( $path );
			} else {
				$copied = $filesystem->copy( $item->getRealPath(), $path, true );
				if ( ! $copied ) {
					$filesystem->rmdir( $destination, true );
					return false;
				}
			}
		}
		return true;
	}


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
