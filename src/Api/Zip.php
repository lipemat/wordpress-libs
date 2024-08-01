<?php
//phpcs:disable WordPress.Security.NonceVerification -- Zip service has permanent URL.
declare( strict_types=1 );

namespace Lipe\Lib\Api;

use Lipe\Lib\Traits\Singleton;
use Lipe\Lib\Util\Files;
use Lipe\Lib\Util\Testing;

/**
 * Zip Service.
 *
 * May be used directly with PHP:
 * `Zip::in()->build_zip([$file_url, $file_url], $zip_name);`
 * To serve a file to the browser.
 *
 * Or via AJAX
 * ```
 * Zip::init_once();
 * $js_endpoint = Zip::in()->get_url_for_endpoint()
 * $js_config = Zip::in()->get_post_data_to_send(array $urls);
 * $.post($js_endpoint, $js_config);
 * ```
 */
class Zip {
	use Singleton {
		init as protected singleton_init;
	}

	public const ACTION = 'zip';

	public const KEY  = 'lipe/lib/util/zip/key';
	public const NAME = 'lipe/lib/util/zip/name';
	public const URLS = 'lipe/lib/util/zip/urls';


	/**
	 * Actions and filters.
	 *
	 * @return void
	 */
	protected function hook(): void {
		add_action( Api::in()->get_action( self::ACTION ), [ $this, 'handle_request' ] );
	}


	/**
	 * Calculate the paths and file names and initiate everything
	 * Called when the endpoint is hit.
	 *
	 * @return void
	 */
	public function handle_request(): void {
		$urls = [];
		if ( isset( $_POST[ self::URLS ] ) ) {
			$urls = \array_map( 'esc_url_raw', (array) wp_unslash( $_POST[ self::URLS ] ) );
		} else {
			wp_die( 'No URL specified.' );
		}

		if ( isset( $_POST[ self::NAME ] ) ) {
			$name = sanitize_text_field( wp_unslash( $_POST[ self::NAME ] ) );
		} else {
			$name = null;
		}

		if ( ! isset( $_POST[ self::KEY ] ) || ( $this->get_key( $urls ) !== $_POST[ self::KEY ] ) ) {
			wp_die( 'Incorrect key sent.' );
		} else {
			$this->build_zip( $urls, $name );
		}
	}


	/**
	 * Set all the paths we are going to work with.
	 *
	 * @param string[] $file_urls - Urls of files to add.
	 * @param ?string  $zip_name  - Optional name for the zip folder.
	 *
	 * @return object{
	 *     file_name: string,
	 *     file_path: string,
	 *     zip_path: string,
	 *     zip_name: string
	 * }
	 */
	protected function get_paths( array $file_urls, ?string $zip_name = null ): object {
		$path = sys_get_temp_dir();
		$name = \hash( 'murmur3f', \implode( '|', $file_urls ) );

		return (object) [
			'file_name' => $name,
			'file_path' => $path,
			'zip_path'  => $path . '/' . $name,
			'zip_name'  => $zip_name ?? $name,
		];
	}


	/**
	 * Create and serve zip file from the specified urls.
	 *
	 * This might appear like a security hole, but it will only serve
	 * files accessible via http request, which technically would already
	 * be available publicly.
	 *
	 * @param string[] $files    - Urls of files to add.
	 * @param ?string  $zip_name - Optional name for the zip folder.
	 *
	 * @return void
	 */
	public function build_zip( array $files, ?string $zip_name = null ): void {
		$paths = $this->get_paths( $files, $zip_name );
		$this->maybe_serve_existing_file( $paths->zip_name, $paths->zip_path );

		if ( ! is_dir( $paths->file_path ) ) {
			Files::in()->get_wp_filesystem()->mkdir( $paths->file_path );
			if ( ! is_dir( $paths->file_path ) ) {
				wp_die( 'Unable to create zip file' );
			}
		}

		$success = [];
		$zip = new \ZipArchive();
		$zip->open( $paths->zip_path, \ZipArchive::CREATE );

		// Allow downloading files from other domains on this server.
		add_filter( 'http_request_host_is_external', '__return_true' );
		foreach ( $files as $file ) {
			if ( ! \str_starts_with( $file, 'http' ) ) {
				if ( is_ssl() ) {
					$file = 'https:' . $file;
				} else {
					$file = 'http:' . $file;
				}
			}

			$parts = wp_parse_url( $file );
			$extension = \pathinfo( $file )['extension'] ?? '';
			if ( false === $parts || ! isset( $parts['path'] ) ) {
				wp_die( esc_html( "Failed to copy $file...\n" ) );
			} elseif ( 'php' === $extension ) {
				wp_die( esc_html( "PHP files are not allowed. $file...\n" ) );
			} else {
				$parts = \pathinfo( $parts['path'] );

				$temp = download_url( $file );
				if ( is_wp_error( $temp ) ) {
					wp_die( esc_html( $temp->get_error_message() . ' ' . $file ) );
				} elseif ( $zip->addFile( $temp, $parts['basename'] ) ) {
					$success[] = $temp;
				}
			}
		}
		remove_filter( 'http_request_host_is_external', '__return_true' );

		// If at least one file made it.
		if ( \count( $success ) > 0 ) {
			$zip->close();
			foreach ( $success as $file ) {
				Files::in()->get_wp_filesystem()->delete( $file );
			}
			$this->maybe_serve_existing_file( $paths->zip_name, $paths->zip_path );
		}

		wp_die( 'Failed creating zip file.' );
	}


	/**
	 * Check to make sure the request is valid and kill the script if not.
	 *
	 * @return void
	 */
	protected function validate_request(): void {
	}


	/**
	 * If the file exists, serve it, and kill the script.
	 *
	 * @noinspection PhpUnhandledExceptionInspection
	 *
	 * @param string $name - Name of the zip file.
	 * @param string $path - Path to the zip file.
	 *
	 * @return void
	 */
	protected function maybe_serve_existing_file( string $name, string $path ): void {
		if ( ! Files::in()->get_wp_filesystem()->is_readable( $path ) ) {
			return;
		}
		if ( headers_sent() ) {
			Testing::in()->exit();
		}
		\header( 'Pragma: public' );
		\header( 'Expires: 0' );
		\header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		\header( 'Cache-Control: private', false );
		\header( 'Content-Type: application/zip' );
		\header( 'Content-disposition: attachment; filename="' . $name . '.zip";' );
		\header( 'Content-Length: ' . \filesize( $path ) );
		$zip_contents = Files::in()->get_wp_filesystem()->get_contents( $path );
		if ( false !== $zip_contents ) {
			// phpcs:ignore WordPress.Security.EscapeOutput
			echo $zip_contents;
		}
		Testing::in()->exit();
	}


	/**
	 * Get the key to check the request against.
	 *
	 * @param string[] $urls - URLs included in the zip file.
	 *
	 * @return string
	 */
	protected function get_key( array $urls ): string {
		return \hash( 'murmur3f', (string) wp_json_encode( $urls ) );
	}


	/**
	 * Get an array of data to send to this zip service to render a zip file
	 *
	 * @param array<string> $urls - Array of urls to be added to the zip file.
	 * @param string|null   $name - Name of the zip when downloaded.
	 *
	 * @return array{
	 *     "lipe/lib/util/zip/key": string,
	 *     "lipe/lib/util/zip/name": string|null,
	 *     "lipe/lib/util/zip/urls": array<string>
	 * }
	 */
	public function get_post_data_to_send( array $urls, ?string $name = null ): array {
		return [
			self::KEY  => $this->get_key( $urls ),
			self::NAME => $name,
			self::URLS => $urls,
		];
	}


	/**
	 * Retrieve the url to send the $_POST requests to
	 *
	 * @return string
	 */
	public function get_url_for_endpoint(): string {
		return Api::in()->get_url( self::ACTION );
	}


	/**
	 * We need to load the api if we are loading this class
	 *
	 * @return void
	 */
	public static function init(): void {
		Api::init_once();
		static::singleton_init();
	}
}
