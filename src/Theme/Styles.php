<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Singleton;
use Lipe\Lib\Util\Actions;

class Styles {
	use Singleton;


	/**
	 * You can set it in the wp-config or some dynamic way using grunt like so
	 * define( 'SCRIPTS_VERSION', '9999' );
	 *
	 * OR
	 *
	 * Beanstalk adds a .revision file to deployments. This grabs that
	 * revision and returns it.
	 * You will find a 'post-commit' script in the /dev
	 * folder which may be added to your .git/hooks directory to automatically generate
	 * this .revision file locally on each commit. In which case you will likely want to
	 * git ignore it.
	 *
	 * If neither the constant nor the .revision is available this will
	 * return null which false back to the WP version when queuing scripts
	 * and styles
	 *
	 * @return null|string
	 */
	public function get_version() : ?string {
		static $version = null;
		if ( null !== $version ) {
			return $version;
		}

		if ( \defined( 'SCRIPTS_VERSION' ) ) {
			$version = SCRIPTS_VERSION;
		} else {
			//beanstalk style
			$path = isset( $_SERVER['DOCUMENT_ROOT'] ) ? \sanitize_text_field( \wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) ) : '';
			if ( \file_exists( $path . '/.revision' ) ) {
				$version = \trim( \file_get_contents( $path . '/.revision' ) );
			}
		}

		return $version;
	}


	/**
	 * Quick adding of the livereload grunt watch script
	 * Call before wp_enqueue_scripts fires
	 *
	 * @see https://github.com/gruntjs/grunt-contrib-watch#user-content-optionslivereload
	 *
	 * @param bool $admin_also - cue for admin as well (defaults to only FE)
	 *
	 * @return void
	 */
	public function live_reload( bool $admin_also = false ) : void {
		if ( \defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			\add_action( 'wp_enqueue_scripts', function () {
				\wp_enqueue_script( 'livereload', 'http://localhost:35729/livereload.js', [], \time(), true );
			} );
			if ( $admin_also ) {
				\add_action( 'admin_enqueue_scripts', function () {
					\wp_enqueue_script( 'livereload', 'http://localhost:35729/livereload.js', [], \time(), true );
				} );
			}
		}
	}


	/**
	 * Add a google font the head of the page in the front end and admin
	 * To use other providers such as typekit see @link and create custom
	 * This method is for google fonts only
	 *
	 * @link    https://github.com/typekit/webfontloader
	 *
	 * @param string|array $families - the family to include
	 *
	 * @example 'Droid Serif,Oswald'
	 * @example [ 'Oswald','Source+Sans+Pro' ]
	 *
	 * @notice Must called before the `wp_enqueue_scripts` hook completes.
	 */
	public function add_font( $families ) : void {
		if ( ! \is_array( $families ) ) {
			$families = \explode( ',', $families );
		}

		Actions::in()->add_action_all( [
			'wp_enqueue_scripts',
			'admin_enqueue_scripts',
		], function () use ( $families ) {
			\wp_enqueue_script( 'google-webfonts', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js' ); //phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			\wp_add_inline_script( 'google-webfonts', 'WebFont.load({
				google: {
					families:' . json_encode( $families ) . '
				}
			})' );
		} );

	}
}
