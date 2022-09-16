<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Singleton;

/**
 * CSS Modules handling in PHP templates.
 *
 * @example $styles = CSS_Modules()->instance()->styles( 'home/header' );
 *          <div class="<?= $styles['wrap'] ?>" />
 *
 */
class CSS_Modules {
	use Singleton;

	/**
	 * path
	 *
	 * @var string
	 */
	protected $path;


	public function set_path( string $path ) : void {
		$this->path = $path;
	}


	public function styles( string $file ) : array {
		$json = file_get_contents( trailingslashit( $this->path ) . "{$file}.pcss.json" ); //phpcs:ignore
		$classes = json_decode( $json, true );

		return (array) $classes;
	}

}
