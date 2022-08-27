<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Util\Actions;

/**
 * @depecated
 */
class Styles extends Resources {
	public function __construct() {
		if ( \get_class( $this ) === __CLASS__ ) {
			_deprecated_file( __CLASS__, '3.12.0', esc_html( Resources::class ) );
		}
	}


	/**
	 * @deprecated In favor of `Resources::get_version`.
	 */
	public function get_version() : ?string {
		_deprecated_function( __METHOD__, '3.12.0', 'Resources::get_version' );
		return parent::get_version();
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
		], static function() use ( $families ) {
			\wp_enqueue_script( 'google-webfonts', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js' ); //phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			\wp_add_inline_script( 'google-webfonts', 'WebFont.load({
				google: {
					families:' . json_encode( $families ) . '
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
}
