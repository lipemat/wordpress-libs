<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use Lipe\Lib\Theme\Resources;

/**
 * Manifest handling for files from the postcss-boilerplate.
 *
 * @since    5.1.0
 *
 * @requires postcss-boilerplate:v4.3.0+
 */
class PCSS_Manifest implements Manifest {
	public const HANDLE = 'lipe/project/theme/scripts/pcss-manifest';

	/**
	 * Cache of the manifest file.
	 *
	 * @var array<string,string>
	 */
	protected static array $manifest = [];


	/**
	 * Instantiate the PCSS manifest.
	 *
	 * @param ResourceHandles $handle - Current handle from within the pcss boilerplate.
	 */
	public function __construct(
		protected readonly ResourceHandles $handle
	) {
	}


	/**
	 * Get a version of the resource from the manifest file.
	 *
	 * If the hash does not exist, fallback to the root
	 * .revision file.
	 *
	 * @throws \RuntimeException -- If the manifest file is not available.
	 * @return string
	 */
	public function get_version(): string {
		$manifest = $this->get_json();
		$file = Enqueue::factory( $this->handle )->file_name;
		return $manifest[ $file ] ?? (string) Resources::in()->get_revision();
	}


	/**
	 * CSS files don't have integrity.
	 *
	 * @throws \LogicException -- Should never be called.
	 *
	 * @phpstan-return never
	 */
	public function get_integrity(): string {
		throw new \LogicException( 'CSS files do not have integrity.' );
	}


	/**
	 * Get the URL of this .css file based on SCRIPT_DEBUG.
	 *
	 * @return string
	 */
	public function get_url(): string {
		if ( ! SCRIPT_DEBUG ) {
			return $this->handle->dist_url() . \str_replace( '.css', '.min.css', $this->handle->file() );
		}
		return $this->handle->dist_url() . $this->handle->file();
	}


	/**
	 * @throws \RuntimeException -- If the manifest file is not available.
	 * @return array<string,string>
	 */
	protected function get_json(): array {
		if ( [] === static::$manifest ) {
			$enum = $this->handle::from( self::HANDLE );
			try {
				static::$manifest = (array) \json_decode( (string) \file_get_contents( $enum->dist_path() . $enum->file() ), true, 512, JSON_THROW_ON_ERROR );
			} catch ( \JsonException ) {
				throw new \RuntimeException( 'The PCSS manifest.json file is not available. You probably need to run `yarn dist`!' );
			}
		}
		return static::$manifest;
	}
}
