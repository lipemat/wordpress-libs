<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

use Lipe\Lib\Theme\Scripts\Manifest;
use Lipe\Lib\Theme\Scripts\ResourceHandles;

/**
 * @author  Mat Lipe
 * @since   August 2025
 *
 * @phpstan-type MANIFEST_ENTRY array{
 *     hash:string,
 *     integrity:string,
 *     file:string,
 *     name:string,
 *     src:string,
 *     isEntry?:bool,
 *     isDynamicEntry?:bool,
 *     css?:array<string>
 * }
 */
class Svelte_Manifest implements Manifest {
	/**
	 * Cache of the manifest file.
	 *
	 * @var array<string, MANIFEST_ENTRY>
	 */
	protected static array $manifest = [];


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
	 * Get the URL of the resource.
	 *
	 * @return string
	 */
	public function get_url(): string {
		if ( SCRIPT_DEBUG && $this->is_vite_running() ) {
			$host = \trim( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) ) );
			$url = set_url_scheme( \str_replace( $host, $host . ':5173', $this->handle->dist_url() ) );
			return \str_replace( '.js', '.ts', $url . $this->handle->file() );
		}

		// Used the hashed file name from the manifest.
		$file = $this->get_json()[ $this->handle->file() ]['file'];
		return $this->handle->dist_url() . $file;
	}


	/**
	 * Enqueue the svelte script with WP_Scripts as a module.
	 *
	 * @param bool $in_footer - Does not apply to JS modules.
	 *
	 * @return void
	 */
	public function enqueue( bool $in_footer = true ): void {
		wp_enqueue_script_module( (string) $this->handle->value, $this->get_url(), [], null );
		if ( ! SCRIPT_DEBUG ) {
			Resources::in()->integrity_javascript( (string) $this->handle->value, $this->get_integrity() );
		}
	}


	/**
	 * Return the path of the file relative to the theme.
	 *
	 * @param bool $full_path - Include a full path to the file.
	 *
	 * @return string
	 */
	public function get_file( bool $full_path = false ): string {
		if ( $full_path ) {
			return $this->handle->dist_path() . $this->handle->file();
		}

		$path = \str_replace( trailingslashit( get_stylesheet_directory() ), '', $this->handle->dist_path() );
		return "{$path}{$this->handle->file()}";
	}


	/**
	 * Is the Vite dev server running?
	 *
	 * @return bool
	 */
	protected function is_vite_running(): bool {
		if ( ! SCRIPT_DEBUG || 'local' !== wp_get_environment_type() ) {
			return false;
		}
		return file_exists( $this->handle->dist_path() . '.running' );
	}


	/**
	 * @return array<string, MANIFEST_ENTRY>
	 */
	protected function get_json(): array {
		if ( [] !== static::$manifest ) {
			return static::$manifest;
		}
		try {
			static::$manifest = (array) \json_decode( (string) \file_get_contents( $this->handle->dist_path() . 'manifest.json' ), true, 512, JSON_THROW_ON_ERROR );
		} catch ( \JsonException ) {
			wp_die( 'The manifest file is not available. Please run `yarn build`.' );
		}
		return static::$manifest;
	}
}
