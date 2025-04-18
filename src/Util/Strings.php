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


	/**
	 * CMB2 formats the value of a money field using the current locale.
	 *
	 * - Strip the money symbols.
	 * - Translate the value back to a float.
	 * - If already a float or int, return it as a float.
	 *
	 * @see \CMB2_Sanitize::text_money
	 *
	 * @param string|int|float $value - The value with money symbols to unformat.
	 *
	 * @return float
	 */
	public function unformat_money_value( string|int|float $value ): float {
		if ( ! \is_string( $value ) ) {
			return (float) $value;
		}

		$wp_locale = $this->get_wp_locale();
		$search = [
			$wp_locale->number_format['thousands_sep'],
			$wp_locale->number_format['decimal_point'],
		];
		$replace = [ '', '.' ];

		return (float) \str_replace( $search, $replace, $value );
	}


	/**
	 * Get instance of the `\WP_Locale` class in a way which
	 * may be verified.
	 *
	 * @return \WP_Locale
	 */
	protected function get_wp_locale(): \WP_Locale {
		global $wp_locale;
		return $wp_locale instanceof \WP_Locale ? $wp_locale : new \WP_Locale();
	}
}
