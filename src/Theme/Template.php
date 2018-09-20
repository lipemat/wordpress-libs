<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Singleton;

class Template {
	use Singleton;

	/**
	 * Render of an array of attributes to be used in markup
	 *
	 * @param array $atts
	 *
	 * @return    string
	 */
	public function esc_attr( array $atts ) : string {
		$e = [];
		foreach ( $atts as $k => $v ) {
			if ( \ is_array( $v ) || \is_object( $v ) ) {
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

}
