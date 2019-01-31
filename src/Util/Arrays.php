<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * @author Mat Lipe
 * @since  December, 2018
 *
 */
class Arrays {
	use Singleton;


	/**
	 * Apply a callback to all elements of an array recursively.
	 *
	 * Similar to `array_walk_recursive` except the returns the result as
	 * a new array instead of altering the provided array.
	 *
	 * @since 2.5.0
	 *
	 * @param callable $callback
	 * @param array    $array
	 *
	 * @return array
	 */
	public function array_map_recursive( callable $callback, array $array ) : array {
		$output = [];
		foreach ( $array as $key => $data ) {
			if ( \is_array( $data ) ) {
				$output[ $key ] = $this->array_map_recursive( $callback, $data );
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
	 * @since 2.1.0
	 *
	 * @return array
	 */
	public function array_merge_recursive( array $args, array $defaults ) : array {
		foreach ( $args as $key => $val ) {
			if ( \is_array( $val ) && isset( $defaults[ $key ] ) && \is_array( $defaults[ $key ] ) ) {
				$defaults[ $key ] = $this->array_merge_recursive( $val, $defaults[ $key ] );
			} else {
				$defaults[ $key ] = $val;
			}
		}

		return $defaults;
	}
}
