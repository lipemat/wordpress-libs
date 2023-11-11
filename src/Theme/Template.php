<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Singleton;

/**
 * Template helpers for the theme.
 */
class Template {
	use Singleton;

	/**
	 * Render of an array of attributes to be used in HTML markup.
	 *
	 * @param array $attributes - Array of attributes to sanitize, implode and return.
	 *
	 * @return    string
	 */
	public function esc_attr( array $attributes ): string {
		$e = [];
		foreach ( $attributes as $k => $v ) {
			if ( \is_array( $v ) || \is_object( $v ) ) {
				$v = wp_json_encode( $v );
			} elseif ( \is_bool( $v ) ) {
				$v = $v ? 1 : 0;
			} elseif ( \is_string( $v ) ) {
				$v = trim( $v );
			}
			$e[] = $k . '="' . \esc_attr( $v ) . '"';
		}

		return \implode( ' ', $e );
	}


	/**
	 * Render a template part and return its contents.
	 *
	 * Same as `get_template_part` but instead of echoing, it returns.
	 *
	 * @param string      $slug The slug name for the generic template.
	 * @param string|null $name The name of the specialised template.
	 * @param mixed       $args Optional. Additional arguments passed to the template.
	 *                          Default empty array.
	 *
	 * @since 3.7.0
	 *
	 * @return string
	 */
	public function get_template_contents( string $slug, ?string $name = null, $args = [] ): string {
		\ob_start();
		get_template_part( $slug, $name, $args );
		return (string) \ob_get_clean();
	}


	/**
	 * Like WP core's `sanitize_html_class` with the following differences.
	 * 1. Prefix with `_` when leading digits exist.
	 * 2. Prefix with `_` when leading hyphens exist.
	 * 3. Unicode's characters are supported.
	 *
	 * We prefix instead of remove in case of a CSS class like '-1-234'
	 * would become ''.
	 *
	 * @link  https://www.w3.org/TR/CSS21/syndata.html#characters
	 * @link  https://core.trac.wordpress.org/ticket/33924
	 *
	 * @since 3.11.0
	 *
	 * @param string $css_class - Unsanitized CSS class.
	 *
	 * @return string
	 */
	public function sanitize_html_class( string $css_class ): string {
		// Strip out any %-encoded octets.
		$sanitized = preg_replace( '/%[a-fA-F\d]{2}/', '', $css_class );
		if ( null === $sanitized ) {
			return '';
		}
		// Prefix any leading digits or hyphens with '_'.
		return (string) \preg_replace( '/^([\d-])/', '_$1', $sanitized );
	}
}
