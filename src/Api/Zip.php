<?php
//phpcs:disable WordPress.Security.NonceVerification -- No nonce for zip service.
declare( strict_types=1 );

namespace Lipe\Lib\Api;

use Lipe\Lib\Traits\Singleton;

/**
 * Zip Service.
 *
 * May be used directly with PHP via
 * Zip::in()->build_zip( [ $url, $url ], $zip_name );
 * To serve a file to the browser.
 *
 * Or via Ajax
 * Zip::init_once();
 * $js_endpoint = Zip::in()->get_url_for_endpoint()
 * $js_config = Zip::in()->get_post_data_to_send( array $urls );
 * $.post( $js_endpoint, $js_config);
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
	 * Name of the zip file.
	 *
	 * @var string
	 */
	protected string $file_name;

	/**
	 * Path to the zip file.
	 *
	 * @var string
	 */
	protected string $file_path;

	/**
	 * Name of the zip file.
	 *
	 * @var string
	 */
	protected string $zip_name;

	/**
	 * Path to the zip file.
	 *
	 * @var string
	 */
	protected string $zip_path;


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
		$this->validate_request();

		if ( isset( $_POST[ self::NAME ] ) ) {
			$name = sanitize_text_field( wp_unslash( $_POST[ self::NAME ] ) );
		} else {
			$name = null;
		}

		if ( isset( $_POST[ self::URLS ] ) ) {
			$this->build_zip( \array_map( 'esc_url_raw', (array) wp_unslash( $_POST[ self::URLS ] ) ), $name );
		}
	}


	/**
	 * Set all the paths we are going to work with.
	 *
	 * @param array<string> $files    - urls of files to add.
	 * @param string|null   $zip_name - optional name for the zip folder.
	 *
	 * @return void
	 */
	protected function set_paths( array $files, ?string $zip_name = null ): void {
		$this->file_name = \md5( \implode( '|', $files ) );
		$this->file_path = sys_get_temp_dir() . '/' . $this->file_name;
		$this->zip_path = $this->file_path . '/' . $this->file_name;

		$this->zip_name = $zip_name ?? $this->file_name;
	}


	/**
	 * Create and serve zip file from the specified urls.
	 *
	 * This might appear like a security hole, but
	 * it will only serve files accessible via http request, which
	 * technically would already be available publicly.
	 *
	 * @param array<string> $files    - urls of files to add.
	 * @param string|null   $zip_name - optional name for the zip folder.
	 *
	 * @return void
	 */
	public function build_zip( array $files, ?string $zip_name = null ): void {
		$this->set_paths( $files, $zip_name );
		$this->serve_existing_file();

		if ( ! is_dir( $this->file_path ) ) {
			$this->get_wp_filesystem()->mkdir( $this->file_path );
			if ( ! is_dir( $this->file_path ) ) {
				die( 'Unable to create zip file' );
			}
		}

		$success = [];

		$zip = new \ZipArchive();
		$zip->open( $this->zip_path, \ZipArchive::CREATE );

		foreach ( $files as $file ) {
			if ( 0 !== strncmp( $file, 'http', 4 ) ) {
				if ( is_ssl() ) {
					$file = 'https:' . $file;
				} else {
					$file = 'http:' . $file;
				}
			}

			$parts = wp_parse_url( $file );
			if ( false === $parts || ! isset( $parts['path'] ) ) {
				echo esc_html( "Failed to copy $file...\n" );
				continue;
			}
			$parts = \pathinfo( $parts['path'] );
			$temp = $this->file_path . '/' . $parts['basename'];

			if ( \copy( $file, $temp ) ) {
				if ( $zip->addFile( $temp, $parts['basename'] ) ) {
					$success[] = $temp;
				}
			} else {
				echo esc_html( "Failed to copy $file...\n" );
			}
		}

		$zip->close();

		foreach ( $success as $file ) {
			wp_delete_file( $file );
		}

		// if at least one file made it.
		if ( \count( $success ) > 0 ) {
			$this->serve_existing_file();
		}

		die( 'Failed creating zip file.' );
	}


	/**
	 * Check to make sure the request is valid and kill the script if not.
	 *
	 * @return void
	 */
	protected function validate_request(): void {
		if ( ! isset( $_POST[ self::KEY ] ) || ( static::get_key() !== $_POST[ self::KEY ] ) ) {
			die( 'Incorrect key sent.' );
		}

		if ( ! isset( $_POST[ self::URLS ] ) || ! \is_array( $_POST[ self::URLS ] ) ) {
			die( 'No URL specified.' );
		}
	}


	/**
	 * If the file exists, serve it, and kill the script.
	 *
	 * @return void
	 */
	protected function serve_existing_file(): void {
		if ( \is_readable( $this->zip_path ) ) {
			\header( 'Pragma: public' );
			\header( 'Expires: 0' );
			\header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
			\header( 'Cache-Control: private', false );
			\header( 'Content-Type: application/zip' );
			\header( 'Content-disposition: attachment; filename="' . $this->zip_name . '.zip";' );
			\header( 'Content-Length: ' . \filesize( $this->zip_path ) );
			$zip_contents = $this->get_wp_filesystem()->get_contents( $this->zip_path );
			if ( false !== $zip_contents ) {
				// phpcs:ignore WordPress.Security.EscapeOutput
				echo $zip_contents;
			}
			die();
		}
	}


	/**
	 * Get the WP Filesystem object.
	 *
	 * @return \WP_Filesystem_Base
	 */
	protected function get_wp_filesystem(): \WP_Filesystem_Base {
		global $wp_filesystem;
		if ( ! $wp_filesystem ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		return $wp_filesystem;
	}


	/**
	 * Get the key to check the request against.
	 *
	 * @return string
	 */
	public static function get_key(): string {
		return \crypt( AUTH_KEY, AUTH_SALT );
	}


	/**
	 * Get an array of data to send to this zip service to render a zip file
	 *
	 * @param array<string> $urls - array of urls to be added to the zip file.
	 * @param string|null   $name - name of the zip when downloaded.
	 *
	 * @return array{
	 *     "lipe/lib/util/zip/key": string,
	 *     "lipe/lib/util/zip/name": string|null,
	 *     "lipe/lib/util/zip/urls": array<string>
	 * }
	 */
	public static function get_post_data_to_send( array $urls, ?string $name = null ): array {
		return [
			self::KEY  => static::get_key(),
			self::NAME => $name,
			self::URLS => $urls,
		];
	}


	/**
	 * Retrieve the url to send the $_POST requests to
	 *
	 * @return string
	 */
	public static function get_url_for_endpoint(): string {
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
