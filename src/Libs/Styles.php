<?php
declare( strict_types=1 );

namespace Lipe\Lib\Libs;

use Lipe\Lib\Traits\Singleton;

/**
 * Internal class for managing styles for wordpress-libs
 *
 * @author Mat Lipe
 * @since  4.9.0
 *
 * @internal
 */
final class Styles {
	use Singleton;

	public const CHECKBOX = 'checkbox';


	/**
	 * Enqueue an internal CSS file.
	 *
	 * @phpstan-param self::* $file
	 *
	 * @param string          $file - Name of the file to enqueue.
	 *
	 * @return void
	 */
	public function enqueue( string $file ): void {
		$dir = trailingslashit( plugin_dir_url( \dirname( __DIR__ ) ) ) . 'css/';
		\wp_enqueue_style( 'lipe/lib/libs/styles/' . $file, $dir . $file . '.css', [], $this->get_version() );
	}


	/**
	 * Get the version of wordpress-libs.
	 *
	 * @return string
	 */
	private function get_version(): string {
		return file_get_contents( \dirname( __DIR__, 2 ) . '/VERSION' );
	}
}
