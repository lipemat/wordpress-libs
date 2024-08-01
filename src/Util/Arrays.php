<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Array helpers.
 */
class Arrays {
	use Singleton;

	/**
	 * Turn a numeric array of values into an associative array with
	 * the odd values being keys for the even values.
	 *
	 * @example ['page', 3, 'category', 6 ] becomes ['page' => 3, 'category' => 6]
	 *
	 * @param array<int, mixed> $input_array - Array to convert.
	 *
	 * @return array<string, mixed>
	 */
	public function chunk_to_associative( array $input_array ): array {
		$assoc = [];
		foreach ( \array_chunk( $input_array, 2 ) as $pair ) {
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
	 * @phpstan-template T of array<mixed>
	 * @phpstan-param T $input_array
	 *
	 * @param array     $input_array   - Array to clean, numeric or associative.
	 * @param bool      $preserve_keys (optional) - Preserve the original array keys.
	 *
	 * @phpstan-return ($preserve_keys is true ? T : list<value-of<T>>)
	 * @return array
	 */
	public function clean( array $input_array, bool $preserve_keys = true ): array {
		$clean = \array_unique( \array_filter( \array_map( function( $value ) {
			if ( \is_string( $value ) ) {
				return \trim( $value );
			}
			return $value;
		}, $input_array ) ) );
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
	 * @phpstan-template T
	 * @phpstan-template R
	 *
	 * @param callable( T ): R  $callback    - Callback to apply to each element.
	 * @param array<array<T>|T> $input_array - Array to apply the callback to.
	 *
	 * @return array<mixed>
	 */
	public function map_recursive( callable $callback, array $input_array ): array {
		$output = [];
		foreach ( $input_array as $key => $data ) {
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
	 * @param array<string, mixed> $args     - Array to merge into the defaults.
	 * @param array<string, mixed> $defaults - Array to merge into.
	 *
	 * @return array<string, mixed>
	 */
	public function merge_recursive( array $args, array $defaults ): array {
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
	 * @phpstan-template TKey of array-key
	 * @phpstan-template T
	 * @phpstan-template R
	 *
	 * @param callable( T, TKey ): R $callback    - Callback to apply to each element.
	 * @param array<TKey, T>         $input_array - Array to apply the callback to.
	 *
	 * @return array<TKey, R>
	 */
	public function map_assoc( callable $callback, array $input_array ): array {
		return \array_combine( \array_keys( $input_array ), \array_map( $callback, $input_array, \array_keys( $input_array ) ) );
	}


	/**
	 * Removes a key from an array recursively.
	 *
	 * @param string               $key         - Key to remove.
	 * @param array<string, mixed> $input_array - Array to recursively remove keys from.
	 *
	 * @return array<string, mixed>
	 */
	public function recursive_unset( string $key, array $input_array ): array {
		unset( $input_array[ $key ] );
		foreach ( $input_array as $_key => $_values ) {
			if ( \is_array( $_values ) ) {
				$input_array[ $_key ] = $this->recursive_unset( $key, $_values );
			}
		}
		return $input_array;
	}


	/**
	 * Mimics the Javascript `.find` array prototype to allow a user
	 * defined predicate and return the array item of the first `true` response.
	 *
	 * @link https://wiki.php.net/rfc/array_find
	 * @todo Once minimum PHP version is 8.4, update to use native `array_find`.
	 *
	 * @template TKey of array-key
	 * @template T
	 *
	 * @param array<TKey, T>           $items    - List of items to look through.
	 * @param callable( T, TKey ):bool $callback - Callback to make comparisons and
	 *                                           return true for a match.
	 *
	 * @phpstan-return T|null
	 *
	 * @return ?mixed
	 */
	public function find( array $items, callable $callback ) {
		$index = $this->find_index( $items, $callback );
		if ( null !== $index && isset( $items[ $index ] ) ) {
			return $items[ $index ];
		}
		return null;
	}


	/**
	 * Mimics the Javascript `.findIndex` array prototype to allow a user
	 * defined predicate and return the array key of the first `true` response.
	 *
	 * @link https://wiki.php.net/rfc/array_find
	 * @todo Once minimum PHP version is 8.4, update to use native `array_find_key`.
	 *
	 * @template TKey of array-key
	 * @template T
	 *
	 * @param array<TKey, T>           $items    - List of items to look through.
	 * @param callable( T, TKey ):bool $callback - Callback to make comparisons and
	 *                                           return true for a match.
	 *
	 * @phpstan-return TKey|null
	 *
	 * @return int|null|string
	 */
	public function find_index( array $items, callable $callback ) {
		foreach ( $items as $k => $item ) {
			if ( true === $callback( $item, $k ) ) {
				return $k;
			}
		}

		return null;
	}


	/**
	 * Combine the results of a callback which returns `[ key => value ]` for
	 * each element into a single associative array. Used to convert an array
	 * of any structure into a finished `key => value` array.
	 *
	 * Supports both numeric and associate keys.
	 *
	 * @example `Arrays::in()->array_create_assoc(
	 *              fn($a) => [$a->ID => $a->post_name ],
	 *          [get_post(1), get_post(2)];
	 *          // [1 => 'Hello World', 2 => 'Sample Page' ]
	 *          `
	 * @phpstan-template T of mixed
	 * @phpstan-template K of array-key
	 * @phpstan-template R of mixed
	 *
	 * @phpstan-param callable( T ): array<K, R> $callback
	 *
	 * @param callable                           $callback    - Callback to apply to each element.
	 * @param array<int|string, T>               $input_array - Array to apply the callback to.
	 *
	 * @phpstan-return array<K, R>
	 * @return array
	 */
	public function flatten_assoc( callable $callback, array $input_array ): array {
		$pairs = \array_map( $callback, $input_array );
		$input_array = [];
		foreach ( $pairs as $pair ) {
			foreach ( $pair as $key => $value ) {
				$input_array[ $key ] = $value;
			}
		}
		return $input_array;
	}


	/**
	 * Pluck a list of key from an array of objects or arrays.
	 *
	 * Works the same as `wp_list_pluck` except it supports multiple keys
	 * and will return an array of arrays instead of a single array.
	 *
	 * @since 3.5.0
	 *
	 * @template T of array<string, mixed>|object
	 * @template K of string
	 *
	 * @param array<T> $input_array - List of objects or arrays.
	 * @param array<K> $keys        - List of keys to return.
	 *
	 * @phpstan-return array<array<K, T[K]>>
	 * @return array
	 */
	public function list_pluck( array $input_array, array $keys ): array {
		return \array_map( function( $item ) use ( $keys ) {
			return $this->map_assoc( function( $i, $key ) use ( $item ) {
				if ( \is_object( $item ) ) {
					return $item->{$key} ?? '';
				}
				return $item[ $key ] ?? '';
			}, \array_flip( $keys ) );
		}, $input_array );
	}
}
