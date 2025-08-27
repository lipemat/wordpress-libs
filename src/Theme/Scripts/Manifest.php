<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

/**
 * Rules for a manifest file.
 *
 * @since    5.1.0
 */
interface Manifest {
	/**
	 * Instantiate the manifest.
	 *
	 * @param ResourceHandles $handle - Current handle from within the boilerplate.
	 */
	public function __construct( ResourceHandles $handle );


	/**
	 * Get a version of the resource from the manifest file.
	 *
	 * If the hash does not exist, fallback to the root
	 * .revision file.
	 *
	 * @return string
	 */
	public function get_version(): string;


	/**
	 * Get the integrity hash for the resource from the manifest file.
	 *
	 * If the hash does not exist, return an empty string.
	 *
	 * @return string
	 */
	public function get_integrity(): string;


	/**
	 * Get the URL of this resource.
	 *
	 * @return string
	 */
	public function get_url(): string;
}
