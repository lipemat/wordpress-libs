<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Util\Actions;

/**
 * @depecated
 */
class Styles extends Resources {
	final public function __construct() {
		if ( \get_class( $this ) === __CLASS__ ) {
			_deprecated_file( __CLASS__, '3.12.0', esc_html( Resources::class ) );
		}
	}


	/**
	 * @deprecated In favor of `Resources::get_revision`.
	 */
	public function get_version() : ?string {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::get_revision' );

		if ( \defined( 'SCRIPTS_VERSION' ) ) {
			_deprecated_hook( 'SCRIPTS_VERSION', '3.12.0', '', 'SCRIPTS_VERSION is not supported by Resources.' );
			return SCRIPTS_VERSION;
		}

		$path = isset( $_SERVER['DOCUMENT_ROOT'] ) ? \sanitize_text_field( \wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) ) : '';
		if ( \file_exists( $path . '/.revision' ) ) {
			return \trim( \file_get_contents( $path . '/.revision' ) ); //phpcs:ignore
		}
		return null;
	}


	/**
	 * @deprecated In favor of `Resources::live_reload`.
	 */
	public function live_reload( bool $admin_also = false, ?string $domain = null ) : void {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::live_reload' );
		parent::live_reload( $admin_also, $domain );
	}


	/**
	 * @deprecated In favor of calling `wp_enqueue_style` directly.
	 */
	public function add_font( $families ) : void {
		_deprecated_function( __METHOD__, '3.8.0' );

		if ( ! \is_array( $families ) ) {
			$families = \explode( ',', $families );
		}

		Actions::in()->add_action_all( [
			'wp_enqueue_scripts',
			'admin_enqueue_scripts',
		], function() use ( $families ) {
			wp_enqueue_script( 'google-webfonts', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js' ); //phpcs:ignore
			wp_add_inline_script( 'google-webfonts', 'WebFont.load({
				google: {
					families:' . wp_json_encode( $families ) . '
				}
			})' );
		} );
	}


	/**
	 * @deprecated In favor of `Resources::add_body_class`.
	 */
	public function add_body_class( string $class ) : void {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::add_body_class' );
		parent::add_body_class( $class );
	}


	/**
	 * @deprecated In favor of `Resources::defer_javascript`.
	 */
	public function defer_javascript( string $handle ) : void {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::defer_javascript' );
		parent::defer_javascript( $handle );
	}


	/**
	 * @deprecated In favor of `Resources::async_javascript`.
	 */
	public function async_javascript( string $handle ) : void {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::async_javascript' );
		parent::async_javascript( $handle );
	}


	/**
	 * @deprecated In favor of `Resources::crossorigin_javascript`.
	 */
	public function crossorigin_javascript( string $handle, ?string $value = null ) : void {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::crossorigin_javascript' );
		parent::crossorigin_javascript( $handle, $value );
	}


	/**
	 * @deprecated In favor of `Resources::integrity_javascript`.
	 */
	public function integrity_javascript( string $handle, string $integrity ) : void {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::integrity_javascript' );
		parent::integrity_javascript( $handle, $integrity );
	}


	/**
	 * @deprecated In favor of `Resources::use_cdn_for_resources`.
	 */
	public function use_cdn_for_resources( array $handles ) : void {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::use_cdn_for_resources' );
		parent::use_cdn_for_resources( $handles );
	}


	/**
	 * @deprecated In favor of `Resources::unpkg_integrity`.
	 */
	public function unpkg_integrity( string $handle, string $url ) : bool {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::unpkg_integrity' );
		return parent::unpkg_integrity( $handle, $url );
	}


	/**
	 * @depecated
	 */
	public static function in() {
		return static::instance();
	}


	/**
	 * @depecated
	 */
	public static function instance() {
		static $instance;
		if ( ! is_a( $instance, __CLASS__ ) ) {
			$instance = new static();
		}

		return $instance; // @phpstan-ignore-line
	}
}
