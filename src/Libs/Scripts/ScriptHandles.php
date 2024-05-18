<?php
declare( strict_types=1 );

namespace Lipe\Lib\Libs\Scripts;

/**
 * Holder of script handles and their configurations.
 *
 * @author Mat Lipe
 * @since  4.10.0
 */
enum ScriptHandles: string {
	case META_BOXES = 'lipe/lib/scripts/meta-boxes';


	/**
	 * Get the dependencies for this script.
	 *
	 * @return list<string>
	 */
	public function dependencies(): array {
		return match ( $this ) {
			self::META_BOXES => [
				'react',
				'wp-components',
				'wp-core-data',
				'wp-data',
				'wp-edit-post',
				'wp-i18n',
				'wp-plugins',
			],
		};
	}


	/**
	 * Get the file name for this script.
	 *
	 * @return string
	 */
	public function file(): string {
		return match ( $this ) {
			self::META_BOXES => 'meta-boxes'
		};
	}
}
