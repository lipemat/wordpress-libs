<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;
use Lipe\Lib\Util\Actions;

class Styles {
	use Singleton;
	use Memoize;

	public const INTEGRITY = 'lipe/lib/theme/styles/integrity';

	/**
	 * @var string[]
	 */
	protected static $async = [];

	/**
	 * @var string[]
	 */
	protected static $body_class = [];

	/**
	 * @var array<null|string>
	 */
	protected static $crossorigin = [];

	/**
	 * @var string[]
	 */
	protected static $deffer = [];

	/**
	 * @var string[]
	 */
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
		return $this->once( function () {
			if ( \defined( 'SCRIPTS_VERSION' ) ) {
				return SCRIPTS_VERSION;
			}

			// Beanstalk style .version file.
			$path = isset( $_SERVER['DOCUMENT_ROOT'] ) ? \sanitize_text_field( \wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) ) : '';
			if ( \file_exists( $path . '/.revision' ) ) {
				return \trim( \file_get_contents( $path . '/.revision' ) );
			}
			return null;
		}, __METHOD__ );
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
		$this->once( function () {
			add_filter( 'script_loader_tag', static function ( $tag, $handle ) {
				if ( \in_array( $handle, static::$deffer, true ) ) {
					return str_replace( '<script', '<script defer', $tag );
				}
				return $tag;
			}, 11, 2 );
		}, __METHOD__ );
	}


	/**
	 * Async an enqueued script by handle.
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
		$this->once( function () {
			add_filter( 'script_loader_tag', function ( $tag, $handle ) {
				if ( \in_array( $handle, static::$async, true ) ) {
					return str_replace( '<script', '<script async', $tag );
				}
				return $tag;
			}, 11, 2 );
		}, __METHOD__ );
	}


	/**
	 * Crossorigin an enqueued script by handle.
	 *
	 * Adds a "crossorigin" attribute to a script tag.
	 *
	 * May be called before or after `wp_enqueue_script` but must be called
	 * before either `wp_print_scripts()` or `wp_print_footer_scripts() depending
	 * on if enqueued for footer of header.
	 *
	 * @param string      $handle - The handle used to enqueued this script.
	 *
	 * @param string|null $value  - Optional value of the attribute.
	 *
	 * @return void
	 */
	public function crossorigin_javascript( string $handle, ?string $value = null ) : void {
		static::$crossorigin[ $handle ] = $value;
		$this->once( function () {
			add_filter( 'script_loader_tag', function ( $tag, $handle ) {
				if ( \array_key_exists( $handle, static::$crossorigin ) ) {
					if ( null === static::$crossorigin[ $handle ] ) {
						return \str_replace( '<script', '<script crossorigin', $tag );
					}
					return \str_replace( '<script', '<script crossorigin="' . static::$crossorigin[ $handle ] . '"', $tag );
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
		$this->crossorigin_javascript( $handle, 'anonymous' );
		$this->once( function () {
			add_filter( 'script_loader_tag', function ( $tag, $handle ) {
				if ( isset( static::$integrity[ $handle ] ) ) {
					return str_replace( '<script', '<script integrity="' . static::$integrity[ $handle ] . '"', $tag );
				}
				return $tag;
			}, 11, 2 );
		}, __METHOD__ );
	}


	/**
	 * Use a CDN for known resources instead of the bundle version in WP Core.
	 *
	 * The CDN is faster and more likely to already exist in the
	 * users browser cache.
	 *
	 * Script integrity and crossorigin are automatically retrieved and
	 * added to `<script>` tags.
	 *
	 * @notice We exclude the `version=` from the URL to match other
	 *         site's URL for browser caching purposes.
	 *
	 * @param array<'jquery-core' | 'react' | 'react-dom' | 'lodash'> $handles - Resource handles to include.
	 *
	 * @since  3.2.0
	 */
	public function use_cdn_for_resources( array $handles ) : void {
		// The admin will throw errors when calling `wp_deregister_script` in other actions.
		if ( is_admin() && 'admin_enqueue_scripts' !== current_filter() ) {
			return;
		}

		$cdn = [
			// WP Core uses `jquery-core` as a dependency of blank `jquery`.
			'jquery-core' => [
				'dev'    => 'https://unpkg.com/jquery@' . wp_scripts()->query( 'jquery' )->ver . '/dist/jquery.js',
				'min'    => 'https://unpkg.com/jquery@' . wp_scripts()->query( 'jquery' )->ver . '/dist/jquery.min.js',
				'footer' => false,
			],
			'lodash'      => [
				'dev'    => 'https://unpkg.com/lodash@' . wp_scripts()->query( 'lodash' )->ver . '/lodash.js',
				'min'    => 'https://unpkg.com/lodash@' . wp_scripts()->query( 'lodash' )->ver . '/lodash.min.js',
				'footer' => true,
				'inline' => 'window.lodash = _.noConflict();',
			],
			'react'       => [
				'dev'    => 'https://unpkg.com/react@' . wp_scripts()->query( 'react' )->ver . '/umd/react.development.js',
				'min'    => 'https://unpkg.com/react@' . wp_scripts()->query( 'react' )->ver . '/umd/react.production.min.js',
				'footer' => true,
			],
			'react-dom'   => [
				'dev'    => 'https://unpkg.com/react-dom@' . wp_scripts()->query( 'react-dom' )->ver . '/umd/react-dom.development.js',
				'min'    => 'https://unpkg.com/react-dom@' . wp_scripts()->query( 'react-dom' )->ver . '/umd/react-dom.production.min.js',
				'footer' => true,
			],
		];

		foreach ( $handles as $handle ) {
			wp_deregister_script( $handle );
			$url = SCRIPT_DEBUG ? $cdn[ $handle ]['dev'] : $cdn[ $handle ]['min'];

			//phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			wp_register_script( $handle, $url, [], null, $cdn[ $handle ]['footer'] );

			if ( ! empty( $cdn[ $handle ]['inline'] ) ) {
				wp_add_inline_script( $handle, $cdn[ $handle ]['inline'] );
			}

			// Add `crossorigin` to `<script>` tag.
			$this->crossorigin_javascript( $handle );

			// Add `integrity="<hash>"` to `<script>` tag.
			$this->unpkg_integrity( $handle, $url );
		}

		// Adds `<link rel="dns-prefetch" href="//unpkg.com" />` to `<head>`.
		add_filter( 'wp_resource_hints', function ( array $urls, $type ) {
			if ( 'dns-prefetch' === $type ) {
				$urls[] = 'unpkg.com';
			}
			return $urls;
		}, 10, 2 );
	}


	/**
	 * Given an "unpkg.com" URL, this will retrieve the integrity hash
	 * and add it to the provided handle.
	 *
	 * The resulting integrity is cached in a network option as a script's
	 * integrity will never change unless it's version changes.
     * As versions of the script change, this will retrieve and
	 * store new integrity hashes automatically.
	 *
	 * @param string $handle - Script handle.
	 * @param string $url - Full unpkg.com URL. (required as versions change).
	 *
	 * @return bool
	 */
	public function unpkg_integrity( string $handle, string $url ) : bool {
		$cached = get_network_option( 0, self::INTEGRITY, [] );

		// Add `integrity="<hash>"` to `<script>` tag.
		$integrity = null;
		if ( \array_key_exists( $url, $cached ) ) {
			if ( ! empty( $cached[ $url ] ) ) {
				$integrity = $cached[ $url ];
			}
		} else {
			try {
				$meta = json_decode( wp_safe_remote_get( "{$url}?meta" )['body'], true, 512, JSON_THROW_ON_ERROR );
				$integrity = $meta['integrity'] ?? null;
			} catch ( \JsonException $e ) {}

			$cached[ $url ] = $integrity;
			update_network_option( 0, self::INTEGRITY, $cached );
		}

		if ( null !== $integrity ) {
			$this->integrity_javascript( $handle, $integrity );
			return true;
		}
		return false;
	}
}
