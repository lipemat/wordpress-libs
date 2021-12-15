<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Singleton;

class Template {
	use Singleton;

	/**
	 * Render of an array of attributes to be used in markup
	 *
	 * @param array $attributes
	 *
	 * @return    string
	 */
	public function esc_attr( array $attributes ) : string {
		$e = [];
		foreach ( $attributes as $k => $v ) {
			if ( \is_array( $v ) || \is_object( $v ) ) {
				$v = \json_encode( $v );
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
	 *
	 */
	public function get_template_contents( string $slug, ?string $name = null, $args = [] ) : string {
		ob_start();
		get_template_part( $slug, $name, $args );
		return ob_get_clean();
	}
}
