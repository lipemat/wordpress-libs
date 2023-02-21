<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;

/**
 * Theme resource utilities.
 *
 * Replaces the legacy `Styles` class.
 *
 * @since  3.12.0
 */
class Resources {
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
	 * You will find a 'post-commit' script in the /dev
	 * folder, which may be added to your .git/hooks directory to automatically generate
	 * this `.revision` file locally on each commit.
	 *
	 * 1. Flushes browser cache for the file on every release.
	 * 2. Provides an easy reference to the commit revision during browser debugging.
	 * 3. Lighter than `get_content_hash`.
	 *
	 * Preferred method if using `shortCssClasses`, or releases frequently include changes
	 * to this resource or update the file modified time of this resource.
	 *
	 * @see Resources::get_content_hash()
	 * @see Resources::get_file_modified_time()
	 *
	 * @return null|string
	 */
	public function get_revision() : ?string {
		return $this->once( function() {
			$file = apply_filters( 'lipe/lib/theme/resources/revision-path', $this->get_site_root() . '.revision' );
			if ( ! \is_readable( $file ) ) {
				// Not available in root, so we try the wp-content directory.
				$file = trailingslashit( WP_CONTENT_DIR ) . '.revision';
			}
			if ( \is_readable( $file ) ) {
				$version = \file_get_contents( $file ); //phpcs:ignore
			}
			if ( empty( $version ) ) {
				return null;
			}
			return \trim( $version );
		}, __METHOD__ );
	}


	/**
	 * Get the hash of the contents within a script/style based on its url.
	 *
	 * Used to pass a version to browsers to tell them if a file has
	 * changed based on the content within a file.
	 *
	 * Keeps a file in browser cache longer if the revision changes
	 * frequently, but the file content does not.
	 *
	 * 1. Keeps file in browser cache forever until the content within the file changes.
	 * 2. Slower than `get_revision`.
	 * 3. Pointless if `shortCssClasses` are enabled because resource files
	 *    change on every release.
	 *
	 * Preferred method if not using `shortCssClasses` and releases occur
	 * much more frequently, or the file is touched more frequently than the content of this resource changes.
	 *
	 * @see Resources::get_revision()
	 * @see Resources::get_file_modified_time()
	 *
	 * @param string $url - URL to a local script or style.
	 *
	 * @return string|null
	 */
	public function get_content_hash( string $url ) : ?string {
		$path = wp_parse_url( $url, PHP_URL_PATH );
		if ( ! $path ) {
			return null;
		}

		if ( \is_readable( $this->get_site_root() . $path ) ) {
			return \md5_file( $this->get_site_root() . $path ) ?: null;
		}
		return null;
	}


	/**
	 * Get the modified time of a script/style based on its url.
	 *
	 * Used to pass a version to browsers to tell them if a file has
	 * changed based on last time a file was modified.
	 *
	 * Keeps a file in browser cache longer if a file revision changes
	 * frequently, but a file is not modified often by the deployment
	 * process nor content changes.
	 *
	 * 1. Keeps file in browser cache forever until it changes.
	 * 2. 16x faster than `Resources::get_content_hash`.
	 * 3. If a file is touched often without modified the content,
	 *    `get_content_hash` is preferred.
	 * 4. Pointless if `shortCssClasses` are enabled because resource files
	 *    change on every release.
	 *
	 * Preferred method if not using `shortCssClasses` and releases occur
	 * much more frequently than this file is touched by release or
	 * other processes.
	 *
	 * @see Resources::get_revision()
	 * @see Resources::get_content_hash()
	 *
	 * @since 3.14.0
	 *
	 * @param string $url - URL to a local script or style.
	 *
	 * @return int|null
	 */
	public function get_file_modified_time( string $url ) : ?int {
		$path = wp_parse_url( $url, PHP_URL_PATH );
		if ( ! $path ) {
			return null;
		}

		if ( \is_readable( $this->get_site_root() . $path ) ) {
			return \filemtime( $this->get_site_root() . $path ) ?: null;
		}
		return null;
	}


	/**
	 * Installs may be using a submodule like `wp` which changes
	 * the path available in `ABSPATH`, so we don't have a reliable
	 * constant to determine the actual root.
	 *
	 * We return on level above `WP_CONTENT_DIR`. Not perfect, but the most
	 * reliable reference we have.
	 *
	 * @return string
	 */
	public function get_site_root() : string {
		if ( \defined( 'WP_CONTENT_DIR' ) ) {
			return trailingslashit( \dirname( \WP_CONTENT_DIR ) );
		}
		return ABSPATH;
	}


	/**
	 * Quick adding of the livereload grunt watch script.
	 *
	 * Call before the `wp_enqueue_scripts` hook fires.
	 *
	 * @see https://github.com/gruntjs/grunt-contrib-watch#user-content-optionslivereload
	 *
	 * @param string|null $domain     - If specified, will load via https using the provided domain.
	 * @param bool        $admin_also - Enqueue for the admin as well (defaults to only front end).
	 *
	 * @return void
	 */
	public function live_reload( ?string $domain = null, bool $admin_also = false ) : void {
		if ( \defined( 'SCRIPT_DEBUG' ) && \SCRIPT_DEBUG ) {
			$enqueue = function() use ( $domain ) {
				$url = 'http://localhost:35729/livereload.js';
				if ( null !== $domain ) {
					$url = "https://{$domain}:35729/livereload.js";
				}
				wp_enqueue_script( 'livereload', $url, [], (string) \time(), true );
			};
			add_action( 'wp_enqueue_scripts', $enqueue );
			if ( $admin_also ) {
				add_action( 'admin_enqueue_scripts', $enqueue );
			}
			$this->async_javascript( 'livereload' );
		}
	}


	/**
	 * Add a class to the body.
	 *
	 * Must be called before `get_body_class`. Most likely called
	 * in the theme's "header.php".
	 *
	 * @param string $css_class - Class to append.
	 */
	public function add_body_class( string $css_class ) : void {
		static::$body_class[] = $css_class;
		$this->once( function() {
			add_filter( 'body_class', function( $classes ) {
				return \array_unique( \array_merge( static::$body_class, $classes ) );
			}, 11 );
		}, __METHOD__ );
	}


	/**
	 * Defer an enqueued script by its handle.
	 *
	 * May be called before or after `wp_enqueue_script` but must be called
	 * before either `wp_print_scripts()` or `wp_print_footer_scripts() depending
	 * on if enqueued for the footer or header.
	 *
	 * 1. Downloads the file during HTML execution and executes it only after HTML parsing is completed.
	 * 2. Will not block the browser during download.
	 * 3. Good replacement for any script, which uses a `jQuery(document).ready` or window.onload.
	 * 4. Defer scripts are also guaranteed to execute in the order they appear
	 * in the document but after any non `defer` script.
	 * 5. The DOM is guaranteed to be available for the script.
	 *
	 * @param string $handle - The handle used to enqueued this script.
	 *
	 * @return void
	 */
	public function defer_javascript( string $handle ) : void {
		static::$deffer[] = $handle;
		$this->once( function() {
			add_filter( 'script_loader_tag', function( $tag, $handle ) {
				if ( \in_array( $handle, static::$deffer, true ) ) {
					return \str_replace( '<script', '<script defer', $tag );
				}
				return $tag;
			}, 11, 2 );
		}, __METHOD__ );
	}


	/**
	 * Async an enqueued script by its handle.
	 *
	 * May be called before or after `wp_enqueue_script` but must be called
	 * before either `wp_print_scripts()` or `wp_print_footer_scripts() depending
	 * on if enqueued for the footer or header.
	 *
	 * 1. Downloads the file during HTML execution and executes it when finished downloading.
	 * 2. Will not block the browser during download.
	 * 3. Executes at an unpredictable time so must be self-contained.
	 * 4. Good for scripts such as Google Analytics.
	 *
	 * @param string $handle - The handle used to enqueued this script.
	 *
	 * @return void
	 */
	public function async_javascript( string $handle ) : void {
		static::$async[] = $handle;
		$this->once( function() {
			add_filter( 'script_loader_tag', function( $tag, $handle ) {
				if ( \in_array( $handle, static::$async, true ) ) {
					return str_replace( '<script', '<script async', $tag );
				}
				return $tag;
			}, 11, 2 );
		}, __METHOD__ );
	}


	/**
	 * Crossorigin an enqueued script by its handle.
	 *
	 * Adds a "crossorigin" attribute to a script tag.
	 *
	 * May be called before or after `wp_enqueue_script` but must be called
	 * before either `wp_print_scripts()` or `wp_print_footer_scripts() depending
	 * on if enqueued for the footer or header.
	 *
	 * @param string      $handle - The handle used to enqueued this script.
	 *
	 * @param string|null $value  - Optional value of the attribute.
	 *
	 * @return void
	 */
	public function crossorigin_javascript( string $handle, ?string $value = null ) : void {
		static::$crossorigin[ $handle ] = $value;
		$this->once( function() {
			add_filter( 'script_loader_tag', function( $tag, $handle ) {
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
	 * Add script integrity to an enqueued script by its handle.
	 *
	 * May be called before or after `wp_enqueue_script` but must be called
	 * before either `wp_print_scripts()` or `wp_print_footer_scripts() depending
	 * on if enqueued for the footer of header.
	 *
	 * @param string $handle    - The handle used to enqueued this script.
	 *
	 * @param string $integrity - Integrity hash to add.
	 *
	 * @return void
	 */
	public function integrity_javascript( string $handle, string $integrity ) : void {
		static::$integrity[ $handle ] = $integrity;
		$this->crossorigin_javascript( $handle, 'anonymous' );
		$this->once( function() {
			add_filter( 'script_loader_tag', function( $tag, $handle ) {
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
	 * user's browser cache.
	 *
	 * Script integrity and crossorigin are automatically retrieved and
	 * added to `<script>` tags.
	 *
	 * @notice We exclude the `version=` from the URL to match external
	 *         site's URL for browser caching purposes.
	 *
	 * @param array<'jquery' | 'react' | 'react-dom' | 'lodash'> $handles - Resource handles to include.
	 *
	 * @since  3.2.0
	 */
	public function use_cdn_for_resources( array $handles ) : void {
		// The admin will throw errors when calling `wp_deregister_script` in other actions.
		if ( is_admin() && 'admin_enqueue_scripts' !== current_filter() ) {
			return;
		}

		// WP Core uses `jquery-core` as a dependency of a blank `jquery`.
		$jquery = \array_search( 'jquery', $handles, true );
		if ( false !== $jquery ) {
			$handles[] = 'jquery-core';
			$handles[] = 'jquery-migrate';
			unset( $handles[ $jquery ] );
		}

		$cdn = [
			'jquery-core'    => [
				'dev'    => 'https://unpkg.com/jquery@' . wp_scripts()->query( 'jquery' )->ver . '/dist/jquery.js',
				'min'    => 'https://unpkg.com/jquery@' . wp_scripts()->query( 'jquery' )->ver . '/dist/jquery.min.js',
				'footer' => false,
			],
			'jquery-migrate' => [
				'dev'    => 'https://unpkg.com/jquery-migrate@' . wp_scripts()->query( 'jquery-migrate' )->ver . '/dist/jquery-migrate.js',
				'min'    => 'https://unpkg.com/jquery-migrate@' . wp_scripts()->query( 'jquery-migrate' )->ver . '/dist/jquery-migrate.min.js',
				'footer' => false,
			],
			'lodash'         => [
				'dev'    => 'https://unpkg.com/lodash@' . wp_scripts()->query( 'lodash' )->ver . '/lodash.js',
				'min'    => 'https://unpkg.com/lodash@' . wp_scripts()->query( 'lodash' )->ver . '/lodash.min.js',
				'footer' => true,
				'inline' => 'window.lodash = _.noConflict();',
			],
			'react'          => [
				'dev'    => 'https://unpkg.com/react@' . wp_scripts()->query( 'react' )->ver . '/umd/react.development.js',
				'min'    => 'https://unpkg.com/react@' . wp_scripts()->query( 'react' )->ver . '/umd/react.production.min.js',
				'footer' => true,
			],
			'react-dom'      => [
				'dev'    => 'https://unpkg.com/react-dom@' . wp_scripts()->query( 'react-dom' )->ver . '/umd/react-dom.development.js',
				'min'    => 'https://unpkg.com/react-dom@' . wp_scripts()->query( 'react-dom' )->ver . '/umd/react-dom.production.min.js',
				'footer' => true,
			],
		];

		foreach ( $handles as $handle ) {
			wp_deregister_script( $handle );
			$url = ( \defined( 'SCRIPT_DEBUG' ) && \SCRIPT_DEBUG ) ? $cdn[ $handle ]['dev'] : $cdn[ $handle ]['min'];

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
		add_filter( 'wp_resource_hints', function( array $urls, $type ) {
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
	 * @param string $url    - Full unpkg.com URL. (required as versions change).
	 *
	 * @return bool
	 */
	public function unpkg_integrity( string $handle, string $url ) : bool {
		$cached = get_network_option( 0, static::INTEGRITY, [] );

		// Add `integrity="<hash>"` to `<script>` tag.
		$integrity = null;
		if ( \array_key_exists( $url, $cached ) ) {
			if ( ! empty( $cached[ $url ] ) ) {
				$integrity = $cached[ $url ];
			}
		} else {
			$response = wp_safe_remote_get( "{$url}?meta" );
			if ( is_wp_error( $response ) ) {
				return false;
			}
			try {
				$meta = json_decode( $response['body'], true, 512, JSON_THROW_ON_ERROR );
			} catch ( \JsonException $e ) {
				return false;
			}
			$integrity = $meta['integrity'] ?? null;
			$cached[ $url ] = $integrity;
			update_network_option( 0, static::INTEGRITY, $cached );
		}

		if ( ! empty( $integrity ) ) {
			$this->integrity_javascript( $handle, $integrity );
			return true;
		}
		return false;
	}
}
