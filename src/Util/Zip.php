<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Zip
 *
 * @author  Mat Lipe
 * @since   1.7.0
 *
 * @package Lipe\Lib\Util
 */
class Zip {
	use Singleton;

	public const ACTION = 'zip';
	public const POST_KEY = 'lipe/project/util/zip/key';
	public const POST_URLS = 'lipe/project/util/zip/urls';

	private $file_name;
	private $file_path;
	private $zip_name;
	private $zip_path;


	protected function hook() : void {
		Api::init_once();

		add_action( 'lipe/lib/util/api_' . self::ACTION, [ $this, 'handle_request' ], 10, 0 );
	}


	/**
	 * Calculate the paths and file names and initiate everything
	 * Called when the endpoint is hit
	 *
	 *
	 * @return void
	 */
	public function handle_request() : void {
		$this->validate_request();
		$this->build_zip( (array) $_POST[ self::POST_URLS ] );
	}


	/**
	 * Set all the paths we are going to work with
	 *
	 * @param array $files
	 * @param string $zip_name - optional name for the zip folder
	 *
	 * @return void
	 */
	protected function set_paths( array $files, ?string $zip_name = null ) : void {
		$this->file_name = md5( implode( '|', $files ) );
		$this->file_path = sys_get_temp_dir() . '/' . $this->file_name;
		$this->zip_path  = $this->file_path . '/' . $this->file_name;

		$this->zip_name = $zip_name ?? $this->file_name;
	}


	/**
	 * Create a zip file from the specified urls
	 * Serve the file if everything is good
	 *
	 * @param array  $files    - urls of files to add
	 * @param string $zip_name - optional name for the zip folder
	 *
	 * @return void
	 */
	public function build_zip( array $files, ?string $zip_name = null ) : void {
		$this->set_paths( $files, $zip_name );
		$this->serve_existing_file();

		if ( ! @mkdir( $this->file_path ) && ! is_dir( $this->file_path ) ) {
			die( 'Unable to create zip file' );
		}

		$success = [];

		$zip = new \ZipArchive;
		$zip->open( $this->zip_path, \ZipArchive::CREATE );

		foreach ( $files as $file ) {
			if ( strpos( $file, 'http' ) !== 0 ) {
				if ( is_ssl() ) {
					$file = 'https:' . $file;
				} else {
					$file = 'http:' . $file;
				}
			}

			$parts = parse_url( $file );
			$parts = pathinfo( $parts['path'] );
			$temp  = $this->file_path . '/' . $parts['basename'];

			if ( copy( $file, $temp ) ) {
				if ( $zip->addFile( $temp, $parts['basename'] ) ) {
					$success[] = $temp;
				}
			} else {
				echo "failed to copy $file...\n";
			}
		}

		$zip->close();

		foreach ( $success as $file ) {
			unlink( $file );
		}

		//if at least one file made it.
		if ( $success ) {
			$this->serve_existing_file();
		}

		die( 'Failed to create zip file' );

	}


	/**
	 * Check to make sure the request is valid and kill the script if not
	 *
	 * @return void
	 */
	private function validate_request() : void {
		if ( empty( $_POST[ self::POST_KEY ] ) || ( self::get_key() !== $_POST[ self::POST_KEY ] ) ) {
			die( 'Incorrect Key Sent' );
		}

		if ( empty( $_POST[ self::POST_URLS ] ) ) {
			die( 'No Urls Specified' );
		}
	}


	/**
	 * If the file exists, serve it, and kill the script
	 *
	 * @return void
	 */
	private function serve_existing_file() : void {
		if ( file_exists( $this->zip_path ) ) {
			header( 'Pragma: public' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
			header( 'Cache-Control: private', false );
			header( 'Content-Type: application/zip' );
			header( "Content-disposition: attachment; filename='{$this->zip_name}.zip'" );
			header( 'Content-Length: ' . filesize( $this->zip_path ) );
			readfile( $this->zip_path );

			die();
		}

	}


	/**
	 * Get the key to check the request against
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
	 * @param array $urls - array of urls to be added to the zip file
	 *
	 * @static
	 *
	 * @return array
	 */
	public static function get_post_data_to_send( array $urls ) : array {
		return [
			self::POST_KEY  => self::get_key(),
			self::POST_URLS => $urls,
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
		return Api::in()->get_api_url( self::ACTION );
	}

}
