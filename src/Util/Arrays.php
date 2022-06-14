<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Array helpers.
 *
 */
class Arrays {
	use Singleton;

	/**
	 * Turn a numeric array of values into an associative array with
	 * the odd values being keys for the even values.
	 *
	 * @param array $array
	 *
	 * @example ['page', 3, 'category', 6 ] becomes ['page' => 3, 'category' => 6]
	 *
	 * @return array
	 */
	public function chunk_to_associative( array $array ) : array {
		$assoc = [];
		foreach ( \array_chunk( $array, 2 ) as $pair ) {
			if ( 2 === \count( $pair ) ) {
				[ $key, $value ] = $pair;
				$assoc[ $key ] = $value;
			} else {
				$assoc[] = \array_shift( $pair );
			}
		}

		return $assoc;
	}


	/**
	 * Return an array with the following removed:
	 * 1. Duplicates.
	 * 2. Empty items.
	 * 3. Extra whitespace around values.
	 *
	 * Keys are preserved.
	 *
	 * @param array $array - Array to clean, numeric or associative.
	 * @param bool $preserve_keys (optional) - Preserve the original array keys.
	 *
	 * @return array
	 */
	public function clean( array $array, bool $preserve_keys = true ) : array {
		$clean = \array_unique( \array_filter( \array_map( function( $value ) {
			if ( \is_string( $value ) ) {
				return \trim( $value );
			}
			return $value;
		}, $array ) ) );
		if ( ! $preserve_keys ) {
			return \array_values( $clean );
		}
		return $clean;
	}


	/**
	 * Apply a callback to all elements of an array recursively.
	 *
	 * Like `array_walk_recursive` except returns the result as
	 * a new array instead of requiring you pass the array element by reference
	 * and alter it directly.
	 *
	 * @param callable $callback
	 * @param array    $array
	 *
	 * @return array
	 */
	public function map_recursive( callable $callback, array $array ) : array {
		$output = [];
		foreach ( $array as $key => $data ) {
			if ( \is_array( $data ) ) {
				$output[ $key ] = $this->map_recursive( $callback, $data );
			} else {
				$output[ $key ] = $callback( $data );
			}
		}

		return $output;
	}


	/**
	 * Works the same as `array_merge_recursive` except instead of turning
	 * duplicate array keys into arrays, this will favor the $args over
	 * the $defaults and clobber identical $default keys.
	 *
	 * @param array $args
	 * @param array $defaults
	 *
	 * @return array
	 */
	public function merge_recursive( array $args, array $defaults ) : array {
		foreach ( $args as $key => $val ) {
			if ( \is_array( $val ) && isset( $defaults[ $key ] ) && \is_array( $defaults[ $key ] ) ) {
				$defaults[ $key ] = $this->merge_recursive( $val, $defaults[ $key ] );
			} else {
				$defaults[ $key ] = $val;
			}
		}

		return $defaults;
	}


	/**
	 * Works the same as `array_map` except the array key is passed as the
	 * second argument to the callback and original keys are preserved.
	 *
	 * @param callable $callback
	 * @param array    $array
	 *
	 * @return array
	 */
	public function map_assoc( callable $callback, array $array ) : array {
		return \array_combine( \array_keys( $array ), \array_map( $callback, $array, \array_keys( $array ) ) );
	}


	/**
	 * Removes a key from an array recursively.
	 *
	 * @param string $key   - Key to remove.
	 * @param array  $array - Array to recursively remove keys from.
	 *
	 * @return array
	 */
	public function recursive_unset( string $key, array $array ) : array {
		unset( $array[ $key ] );
		foreach ( $array as $_key => $_values ) {
			if ( \is_array( $_values ) ) {
				$array[ $_key ] = $this->recursive_unset( $key, $_values );
			}
		}
		return $array;
	}


	/**
	 * Combine the results of a callback which returns `[ key => value ]` for
	 * each element into a single associative array. Used to convert an array
	 * of any structure into a finished `key => value` array.
	 *
	 * Supports both numeric and associate keys.
	 *
	 * @example `Arrays::in()->array_create_assoc(
	 *              fn( $a ) => [ $a->ID => $a->post_name ],
	 *          [ get_post( 1 ), get_post( 2 ) ] );
	 *          // [ 1 => 'Hello World', 2 => 'Sample Page' ]
	 *          `
	 *
	 * @param callable $callback
	 * @param array    $array
	 *
	 * @return array
	 */
	public function flatten_assoc( callable $callback, array $array ) : array {
		$pairs = array_map( $callback, $array );
		$array = [];
		foreach ( $pairs as $pair ) {
			$array[ key( $pair ) ] = reset( $pair );
		}
		return $array;
	}


	/**
	 * Pluck a list of key from an array of objects or arrays.
	 *
	 * Works the same as `wp_list_pluck` except it supports multiple keys
	 * and will return an array of arrays instead of a single array.
	 *
	 * @param array<array|object> $list - List of objects or arrays.
	 * @param array               $keys - List of keys to return.
	 *
	 * @since 3.5.0
	 *
	 * @return array
	 */
	public function list_pluck( array $list, array $keys ) : array {
		return \array_map( function ( $item ) use ( $keys ) {
			return $this->map_assoc( function ( $i, $key ) use ( $item ) {
				if ( \is_object( $item ) ) {
					return $item->{$key};
				}

				return $item[ $key ];
			}, \array_flip( $keys ) );
		}, $list );
	}


	/**
	 * @deprecated
	 */
	public function array_map_recursive( callable $callback, array $array ) : array {
		_deprecated_function( __METHOD__, '3.6.0', 'map_recursive' );
		return $this->map_recursive( $callback, $array );
	}


	/**
	 * @deprecated
	 */
	public function array_chunk_to_associative( array $array ) : array {
		_deprecated_function( __METHOD__, '3.6.0', 'chunk_to_associative' );
		return $this->chunk_to_associative( $array );
	}


	/**
	 * @deprecated
	 */
	public function array_merge_recursive( array $args, array $defaults ) : array {
		_deprecated_function( __METHOD__, '3.6.0', 'merge_recursive' );
		return $this->merge_recursive( $args, $defaults );
	}


	/**
	 * @deprecated
	 */
	public function array_map_assoc( callable $callback, array $array ) : array {
		_deprecated_function( __METHOD__, '3.6.0', 'map_assoc' );
		return $this->map_assoc( $callback, $array );
	}


	/**
	 * @deprecated
	 */
	public function array_recursive_unset( string $key, array $array ) : array {
		_deprecated_function( __METHOD__, '3.6.0', 'recursive_unset' );
		return $this->recursive_unset( $key, $array );
	}


	/**
	 * @deprecated
	 */
	public function array_flatten_assoc( callable $callback, array $array ) : array {
		_deprecated_function( __METHOD__, '3.6.0', 'flatten_assoc' );
		return $this->flatten_assoc( $callback, $array );
	}

}
