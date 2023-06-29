<?php

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
	protected function hook() : void {
		add_action( Api::in()->get_action( static::ACTION ), [ $this, 'handle_request' ] );
	}


	/**
	 * Calculate the paths and file names and initiate everything
	 * Called when the endpoint is hit.
	 *
	 * @return void
	 */
	public function handle_request() : void {
		$this->validate_request();

		//phpcs:disable WordPress.Security.NonceVerification.Missing
		if ( empty( $_POST[ static::NAME ] ) ) {
			$name = null;
		} else {
			$name = sanitize_text_field( wp_unslash( $_POST[ static::NAME ] ) );
		}

		if ( isset( $_POST[ static::URLS ] ) ) {
			$this->build_zip( array_map( 'esc_url_raw', (array) wp_unslash( $_POST[ static::URLS ] ) ), $name );
		}
		//phpcs:enable WordPress.Security.NonceVerification.Missing
	}


	/**
	 * Set all the paths we are going to work with.
	 *
	 * @param array       $files    - urls of files to add.
	 * @param string|null $zip_name - optional name for the zip folder.
	 *
	 * @return void
	 */
	protected function set_paths( array $files, ?string $zip_name = null ) : void {
		$this->file_name = \md5( implode( '|', $files ) );
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
	 * @param array       $files    - urls of files to add.
	 * @param string|null $zip_name - optional name for the zip folder.
	 *
	 * @return void
	 */
	public function build_zip( array $files, ?string $zip_name = null ) : void {
		$this->set_paths( $files, $zip_name );
		$this->serve_existing_file();

		if ( ! is_dir( $this->file_path ) && ! mkdir( $this->file_path ) && ! is_dir( $this->file_path ) ) {
			die( 'Unable to create zip file' );
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
			$parts = pathinfo( $parts['path'] );
			$temp = $this->file_path . '/' . $parts['basename'];

			if ( copy( $file, $temp ) ) {
				if ( $zip->addFile( $temp, $parts['basename'] ) ) {
					$success[] = $temp;
				}
			} else {
				echo esc_html( "Failed to copy $file...\n" );
			}
		}

		$zip->close();

		foreach ( $success as $file ) {
			unlink( $file );
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
	protected function validate_request() : void {
		//phpcs:disable WordPress.Security.NonceVerification.Missing
		if ( empty( $_POST[ static::KEY ] ) || ( static::get_key() !== $_POST[ static::KEY ] ) ) {
			die( 'Incorrect key sent.' );
		}

		if ( empty( $_POST[ static::URLS ] ) ) {
			die( 'No URL specified.' );
		}
		//phpcs:enable WordPress.Security.NonceVerification.Missing
	}


	/**
	 * If the file exists, serve it, and kill the script.
	 *
	 * @todo Convert to `WP_Filesystem` calls.
	 *
	 * @return void
	 */
	protected function serve_existing_file() : void {
		if ( \is_readable( $this->zip_path ) ) {
			header( 'Pragma: public' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
			header( 'Cache-Control: private', false );
			header( 'Content-Type: application/zip' );
			header( 'Content-disposition: attachment; filename="' . $this->zip_name . '.zip";' );
			header( 'Content-Length: ' . filesize( $this->zip_path ) );
			readfile( $this->zip_path ); //phpcs:ignore

			die();
		}
	}


	/**
	 * Get the key to check the request against.
	 *
	 * @static
	 *
	 * @return string
	 */
	public static function get_key() : string {
		return crypt( \AUTH_KEY, \AUTH_SALT );
	}


	/**
	 * Get an array of data to send to this zip service to render a zip file
	 *
	 * @param array       $urls - array of urls to be added to the zip file.
	 * @param string|null $name - name of the zip when downloaded.
	 *
	 * @return array
	 * @static
	 */
	public static function get_post_data_to_send( array $urls, ?string $name = null ) : array {
		return [
			static::KEY  => static::get_key(),
			static::NAME => $name,
			static::URLS => $urls,
		];
	}


	/**
	 * Retrieve the url to send the $_POST requests to
	 *
	 * @static
	 *
	 * @return string
	 */
	public static function get_url_for_endpoint() : string {
		return Api::in()->get_url( static::ACTION );
	}


	/**
	 * We need to load the api if we are loading this class
	 *
	 * @static
	 *
	 * @return void
	 */
	public static function init() : void {
		Api::init_once();
		static::singleton_init();
	}
}
