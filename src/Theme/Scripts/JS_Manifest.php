<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use Lipe\Lib\Theme\Resources;

/**
 * Manifest handling for files from the js-boilerplate.
 *
 * @requires js-boilerplate:v9.2.0+
 *
 * @since    5.1.0
 */
class JS_Manifest implements Manifest {
	public const HANDLE = 'lipe/project/theme/scripts/js-manifest';

	/**
	 * Cache of the manifest file.
	 *
	 * @var array<string,string>
	 */
	protected static $manifest = [];


	/**
	 * Instantiate the JS manifest.
	 *
	 * @param ResourceHandles $handle - Current handle from within the JS boilerplate.
	 */
	public function __construct(
		protected readonly ResourceHandles $handle
	) {
	}


	/**
	 * Get a version of the resource from the `hash` in
	 * the manifest file.
	 *
	 * If the hash does not exist, fallback to the root
	 * .revision file.
	 *
	 * @throws \RuntimeException -- If the manifest file is not available.
	 *
	 * @return string
	 */
	public function get_version(): string {
		$manifest = $this->get_json();
		if ( \array_key_exists( $this->handle->file(), $manifest ) ) {
			return $manifest[ $this->handle->file() ]['hash'];
		}
		return (string) Resources::in()->get_revision();
	}


	/**
	 * The integrity of the resource from the `integrity` in
	 * the manifest file.
	 *
	 * @throws \RuntimeException -- If the manifest file is not available.
	 * @return string
	 */
	public function get_integrity(): string {
		$manifest = $this->get_json();
		if ( \array_key_exists( $this->handle->file(), $manifest ) ) {
			return $manifest[ $this->handle->file() ]['integrity'];
		}
		return '';
	}


	/**
	 * @throws \RuntimeException -- If the manifest file is not available.
	 * @return array<string,array{hash:string, integrity:string}>
	 */
	protected function get_json(): array {
		if ( [] === static::$manifest ) {
			$enum = $this->handle::from( self::HANDLE );
			try {
				static::$manifest = (array) \json_decode( (string) \file_get_contents( $enum->dist_path() . $enum->file() ), true, 512, JSON_THROW_ON_ERROR );
			} catch ( \JsonException ) {
				throw new \RuntimeException( 'The JS manifest.json file is not available. You probably need to run `yarn dist`!' );
			}
		}
		return static::$manifest;
	}
}
