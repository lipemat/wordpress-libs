<?php

declare( strict_types=1 );

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;

/**
 * CSS Modules handling in PHP templates.
 *
 * @example $styles = CSS_Modules()->instance()->styles( 'home/header' );
 *          <div class="<?= $styles['wrap'] ?>" />
 */
class CSS_Modules {
	use Memoize;
	use Singleton;

	/**
	 * Root path of the CSS module JSON files.
	 *
	 * @var string
	 */
	protected string $path;

	/**
	 * Prepend a string to the path of the file when retrieving
	 * the CSS classnames.
	 *
	 * Uses to shorten the passed file names if they share a common directory.
	 *
	 * @example 'template-parts'
	 *
	 * @var string
	 */
	protected string $prepend = '';


	/**
	 * Name of JSON file when using a combined JSON file.
	 *
	 * @var string
	 */
	protected string $combined_filename = '';


	/**
	 * Set the path to the CSS module JSON files with an
	 * optional file prepend.
	 *
	 * @param string $path         - Path to CSS modules JSON file(s).
	 * @param string $file_prepend - Prepend a path to the $file during lookup.
	 *
	 * @return void
	 */
	public function set_path( string $path, string $file_prepend = '' ) : void {
		$this->path = $path;
		$this->prepend = $file_prepend;
	}


	/**
	 * Do we want to use the combined `modules.json` file?
	 *
	 * @note This functionality is opt-in in version 4 but will likely
	 *       become the default in version 5.
	 *
	 * @param string $filename - Name of the combined JSON file.
	 *
	 * @return void
	 */
	public function use_combined_file( string $filename ) : void {
		$this->combined_filename = $filename;
	}


	/**
	 * CSS class names for a single CSS module.
	 *
	 * @param string $file - File with the path from CSS module JSON directory.
	 *
	 * @return array
	 */
	public function styles( string $file ) : array {
		$file_with_prefix = $this->prepend . $file . '.pcss';
		if ( '' !== $this->combined_filename ) {
			if ( \substr( $file, 0, 3 ) === '../' ) {
				$file_with_prefix = \substr( $file, 3 ) . '.pcss';
			}
			return $this->get_combined_css_classes()[ $file_with_prefix ] ?? [];
		}

		try {
			//phpcs:ignore -- Reading local file.
			$classes = json_decode( file_get_contents( trailingslashit( $this->path ) . "{$file_with_prefix}.json" ), true, 3, JSON_THROW_ON_ERROR );
		} catch ( \JsonException $exception ) {
			return [];
		}
		return (array) $classes;
	}


	/**
	 * Retrieve the CSS module classes from the `combined.json` file.
	 *
	 * @return array
	 */
	protected function get_combined_css_classes() : array {
		return $this->once( function() {
			try {
				//phpcs:ignore -- Reading local file.
				$classes = \json_decode( \file_get_contents( trailingslashit( $this->path ) . $this->combined_filename ), true, 3, JSON_THROW_ON_ERROR );
			} catch ( \JsonException $exception ) {
				return [];
			}
			return (array) $classes;
		}, __METHOD__ );
	}

}
