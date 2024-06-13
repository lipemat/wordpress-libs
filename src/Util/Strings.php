<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * String utilities.
 *
 * @author Mat Lipe
 * @since  5.0.0
 *
 */
class Strings {
	use Singleton;

	/**
	 * Pluralize a word.
	 *
	 * Handles most common cases. Additional cases can be added
	 * to the unit test.
	 *
	 * @param string $word - Non-pluralized word.
	 *
	 * @return string
	 */
	public function pluralize( string $word ): string {
		$last_letter = \strtolower( substr( $word, - 1 ) );
		$second_to_last_letter = \strtolower( $word[ \strlen( $word ) - 2 ] );
		if ( 'ss' === $second_to_last_letter . $last_letter ) {
			return $word . 'es';
		}
		if ( 'y' === $last_letter ) {
			if ( 1 === preg_match( '/[aeiou]/', $second_to_last_letter ) ) {
				return $word . 's';
			}
			return \substr( $word, 0, - 1 ) . 'ies';
		}
		if ( 's' === $last_letter ) {
			if ( 'e' === $second_to_last_letter ) {
				return $word;
			}
			return $word . 'es';
		}
		if ( 'x' === $last_letter || 'z' === $last_letter || ( 'h' === $last_letter && 'c' === $second_to_last_letter ) ) {
			return $word . 'es';
		}
		return $word . 's';
	}
}
