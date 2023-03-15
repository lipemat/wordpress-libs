<?php

namespace Lipe\Lib\Traits;

use Lipe\Lib\Util\Cache;

/**
 * Support simple memoization for class methods, which respond
 * with different caches based on the arguments provided.
 *
 * @example public function heavy( $text ) {
 *              return $this->memoize( function ( $text ) {
 *                   echo 'called' . "\n";
 *                    return $text;
 *                }, __METHOD__, $text );
 *            }
 *          $test->heavy( 'as can be'. "\n" ); //called
 *          $test->heavy( 'as can be x2' . "\n"); //called
 *          $test->heavy( 'as can be X3'. "\n" ); // called
 *          $test->heavy( 'as can be x2' . "\n"); //Not called
 */
trait Memoize {
	/**
	 * The local cache to store the results of memoized calls.
	 *
	 * @var array
	 */
	protected array $memoize_cache = [];


	/**
	 * Pass me a callback, a method identifier, and some arguments and
	 * I will return the same result every time the arguments are the same.
	 *
	 * If the arguments change, I will return a result matching the change.
	 * I will only call the callback one time for the same set of arguments.
	 * If the result already exists in the cache, the callback will not be called.
	 *
	 * @param callable $callback
	 * @param string   $identifier - Something unique to identify the method being used
	 *                             so we can determine the difference in the cache.
	 *                             `__METHOD__` works nicely here.
	 * @param int      $expire     - Expire in seconds (defaults to never).
	 * @param mixed    ...$args    - Arguments will be passed to the callback.
	 *
	 * @return mixed
	 */
	public function persistent( callable $callback, string $identifier, $expire = 0, ...$args ) {
		$data = Cache::in()->get( [ $identifier, $args ], __CLASS__ );
		if ( false === $data ) {
			$data = $callback( ...$args );
			Cache::in()->set( [ $identifier, $args ], $data, __CLASS__, $expire );
		}
		return $data;
	}


	/**
	 * Pass me a callback, a method identifier, and some optional arguments and
	 * and I will return the same result every time.
	 *
	 * The passed function will only be called once no matter where it called from
	 * and what the arguments are.
	 * I will always return the value received from the callback on its first run.
	 *
	 * @param callable $callback
	 * @param string   $identifier - Something unique to identify the method being used
	 *                             so we can determine the difference in the cache.
	 *                             `__METHOD__` works nicely here.
	 * @param mixed    ...$args    - Arguments will be passed to the callback..
	 *
	 * @return mixed
	 */
	public function once( callable $callback, string $identifier, ...$args ) {
		$key = "{$identifier}::once";
		if ( ! \array_key_exists( $key, $this->memoize_cache ) ) {
			$this->memoize_cache[ $key ] = $callback( ...$args );
		}

		return $this->memoize_cache[ $key ];
	}


	/**
	 * Pass me a callback, a method identifier, and some arguments and
	 * I will return the same result every time the arguments are the same.
	 *
	 * If the arguments change, I will return a result matching the change.
	 * I will only call the callback one time for the same set of arguments.
	 *
	 * @param callable $callback
	 * @param string   $identifier - Something unique to identify the method being used
	 *                             so we can determine the difference in the cache.
	 *                             `__METHOD__` works nicely here.
	 * @param mixed    ...$args    - Arguments will be passed to the callback as well as determine
	 *                             if we can reuse a result.
	 *
	 * @return mixed
	 */
	public function memoize( callable $callback, string $identifier, ...$args ) {
		$key = \md5( wp_json_encode( [ $args, $identifier ] ) );
		if ( ! \array_key_exists( $key, $this->memoize_cache ) ) {
			$this->memoize_cache[ $key ] = $callback( ...$args );
		}

		return $this->memoize_cache[ $key ];
	}


	/**
	 * Delete a single item from the caches without clearing
	 * the entire class and cache group.
	 *
	 * @see Memoize::clear_memoize_cache()
	 *
	 * @param string $identifier
	 * @param array  ...$args
	 *
	 * @return bool
	 */
	public function clear_single_item( string $identifier, ...$args ) : bool {
		$keys = [
			\md5( wp_json_encode( [ $args, $identifier ] ) ), // memoize.
			"{$identifier}::once", // once.
		];
		\array_walk( $keys, function( $key ) {
			unset( $this->memoize_cache[ $key ] );
		} );
		return Cache::in()->delete( [ $identifier, $args ], __CLASS__ );
	}


	/**
	 * Clear all caches on this class.
	 * Typically, used during unit testing.
	 *
	 * @see Memoize::clear_single_item()
	 *
	 */
	public function clear_memoize_cache() : void {
		$this->memoize_cache = [];
		Cache::in()->flush_group( __CLASS__ );
	}
}
