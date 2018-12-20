<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Singleton;

/**
 * CSS_Modules
 *
 * @author  Mat Lipe
 *
 * @package Lipe\Lib\Util
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
		$json = file_get_contents( trailingslashit( $this->path ) . "{$file}.pcss.json" );
		$classes = json_decode( $json );

		return (array) $classes;
	}

}
