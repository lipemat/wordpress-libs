<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;
use Lipe\Lib\Util\Actions;

class Styles {
	use Singleton;
	use Memoize;

	protected static $async = [];

	protected static $body_class = [];

	protected static $deffer = [];

	protected static $integrity = [];


	/**
	 * Beanstalk adds a .revision file to deployments. This grabs that
	 * revision and returns it.
	 *
	 * You will find a 'post-commit' script in the /dev
	 * folder which may be added to your .git/hooks directory to automatically generate
	 * this .revision file locally on each commit.
	 *
	 * If neither the constant nor the .revision is available this will
	 * return null which false back to the WP version when queuing scripts
	 * and styles.
	 *
	 * You can set the revision manually in the wp-config or some dynamic way
	 * define( 'SCRIPTS_VERSION', '9999' );
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
			add_action( 'wp_enqueue_scripts', static function () {
				wp_enqueue_script( 'livereload', 'http://localhost:35729/livereload.js', [], (string) \time(), true );
			} );
			if ( $admin_also ) {
				add_action( 'admin_enqueue_scripts', static function () {
					wp_enqueue_script( 'livereload', 'http://localhost:35729/livereload.js', [], (string) \time(), true );
				} );
			}
			$this->async_javascript( 'livereload' );
		}
	}


	/**
	 * Add a google font the head of the page in the front end and admin
	 *
	 * @link    https://github.com/typekit/webfontloader
	 *
	 * @notice  This method is for google fonts only
	 * @notice  Must called before the `wp_enqueue_scripts` hook completes.
	 *
	 * @param string|array $families - the family to include
	 *
	 * @example 'Droid Serif,Oswald'
	 * @example [ 'Oswald','Source+Sans+Pro' ]
	 */
	public function add_font( $families ) : void {
		if ( ! \is_array( $families ) ) {
			$families = \explode( ',', $families );
		}

		Actions::in()->add_action_all( [
			'wp_enqueue_scripts',
			'admin_enqueue_scripts',
		], static function () use ( $families ) {
			\wp_enqueue_script( 'google-webfonts', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js' ); //phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			\wp_add_inline_script( 'google-webfonts', 'WebFont.load({
				google: {
					families:' . json_encode( $families ) . '
				}
			})' );
		} );
	}


	/**
	 * Add a class to the body.
	 *
	 * Must be called before `get_body_class` which is most likely called
	 * in the theme's "header.php".
	 *
	 * @param string $class
	 *
	 */
	public function add_body_class( string $class ) : void {
		static::$body_class[] = $class;
		$this->once( static function () {
			add_filter( 'body_class', static function ( $classes ) {
				return array_unique( array_merge( static::$body_class, $classes ) );
			}, 11 );
		}, __METHOD__ );
	}


	/**
	 * Async an enqueued script by handle.
	 *
	 * May be called before or after `wp_enqueue_script` but must be called
	 * before either `wp_print_scripts()` or `wp_print_footer_scripts() depending
	 * on if enqueued for footer of header.
	 *
	 * Downloads the file during HTML execution and executes it only after HTML parsing is completed.
	 * Will not block the browser during download.
	 * Good replacement for any script which uses a `jQuery(document).ready` or window.onload.
	 * Defer scripts are also guaranteed to execute in the order they appear in the document
	 * but after any non defer script.
	 *
	 * A positive effect of this attribute is that the DOM will be available for your script.
	 *
	 * @param string $handle - The handle used to enqueued this script.
	 *
	 * @return void
	 */
	public function defer_javascript( string $handle ) : void {
		static::$deffer[] = $handle;
		$this->once( static function () {
			add_filter( 'script_loader_tag', static function ( $tag, $handle ) {
				if ( \in_array( $handle, static::$deffer, true ) ) {
					return str_replace( '<script', '<script defer="defer"', $tag );
				}
				return $tag;
			}, 11, 2 );
		}, __METHOD__ );
	}


	/**
	 * Defer an enqueued script by handle.
	 *
	 * May be called before or after `wp_enqueue_script` but must be called
	 * before either `wp_print_scripts()` or `wp_print_footer_scripts() depending
	 * on if enqueued for footer of header.
	 *
	 * Downloads the file during HTML execution and executes it when finished downloading.
	 * Will not block the browser during download.
	 * Executes at an unpredictable time so must be self contained.
	 * Good for scripts such as Google Analytics.
	 *
	 * @param string $handle - The handle used to enqueued this script.
	 *
	 * @return void
	 */
	public function async_javascript( string $handle ) : void {
		static::$async[] = $handle;
		$this->once( static function () {
			add_filter( 'script_loader_tag', static function ( $tag, $handle ) {
				if ( \in_array( $handle, static::$async, true ) ) {
					return str_replace( '<script', '<script async="async"', $tag );
				}
				return $tag;
			}, 11, 2 );
		}, __METHOD__ );
	}


	/**
	 * Add script integrity to an enqueued script by handle.
	 *
	 * May be called before or after `wp_enqueue_script` but must be called
	 * before either `wp_print_scripts()` or `wp_print_footer_scripts() depending
	 * on if enqueued for footer of header.
	 *
	 * @param string $handle    - The handle used to enqueued this script.
	 *
	 * @param string $integrity - Integrity hash to add
	 *
	 * @return void
	 */
	public function integrity_javascript( string $handle, string $integrity ) : void {
		static::$integrity[ $handle ] = $integrity;
		$this->once( static function () {
			add_filter( 'script_loader_tag', static function ( $tag, $handle ) {
				if ( isset( static::$integrity[ $handle ] ) ) {
					return str_replace( '<script', '<script integrity="' . static::$integrity[ $handle ] . '" crossorigin="anonymous"', $tag );
				}
				return $tag;
			}, 11, 2 );
		}, __METHOD__ );
	}
}
