<?php
declare( strict_types=1 );

namespace Lipe\Lib\Traits;

use Lipe\Lib\Util\Arrays;
use Lipe\Lib\Util\Cache;

/**
 * Support simple memoization for class methods, which respond
 * with different caches based on the arguments provided.
 *
 * @example public function heavy ($text) {
 *              return $this->memoize(function ($text) {
 *                   echo 'called' . "\n";
 *                    return $text;
 *                }, __METHOD__, $text);
 *            }
 *          $test->heavy('as can be'. "\n"); //called
 *          $test->heavy('as can be x2' . "\n"); //called
 *          $test->heavy('as can be X3'. "\n"); // called
 *          $test->heavy('as can be x2' . "\n"); //Not called
 */
trait Memoize {
	/**
	 * The static cache to store the results of static calls.
	 *
	 * @var array<string, mixed>
	 */
	protected static array $static_cache = [];

	/**
	 * The local cache to store the results of memoized calls.
	 *
	 * @var array<string, mixed>
	 */
	protected array $memoize_cache = [];


	/**
	 * Pass me a callback, a method identifier, and some arguments, and
	 * I will return the same result every time the arguments are the same.
	 *
	 * If the arguments change, I will return a result matching the change.
	 * I will only call the callback one time for the same set of arguments.
	 * If the result already exists in the cache, the callback will not be called.
	 *
	 * @param callable $callback   - Callback, which returns the value to store and return.
	 * @param string   $identifier - Something unique to identify the method being used
	 *                             so we can determine the difference in the cache.
	 *                             `__METHOD__` works nicely here.
	 * @param int      $expire     - Expire in seconds (defaults to never).
	 * @param mixed    ...$args    - Arguments will be passed to the callback.
	 *
	 * @return mixed
	 */
	public function persistent( callable $callback, string $identifier, $expire = 0, ...$args ): mixed {
		$cache_key = $this->get_cache_key( $identifier, $args );
		$data = Cache::in()->get( $cache_key, __CLASS__ );
		if ( false === $data ) {
			$data = $callback( ...$args );
			Cache::in()->set( $cache_key, $data, __CLASS__, $expire );
		}
		return $data;
	}


	/**
	 * Pass me a callback, a method identifier, and some optional arguments and
	 * I will return the same result every time.
	 *
	 * The passed function will only be called once no matter where it called from
	 * and what the arguments are.
	 * I will always return the value received from the callback on its first run.
	 *
	 * @param callable $callback   - Callback, which returns the value to store and return.
	 * @param string   $identifier - Something unique to identify the method being used
	 *                             so we can determine the difference in the cache.
	 *                             `__METHOD__` works nicely here.
	 * @param mixed    ...$args    - Arguments will be passed to the callback..
	 *
	 * @return mixed
	 */
	public function once( callable $callback, string $identifier, ...$args ): mixed {
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
	 * @param callable $callback   - Callback, which returns the value to store and return.
	 * @param string   $identifier - Something unique to identify the method being used
	 *                             so we can determine the difference in the cache.
	 *                             `__METHOD__` works nicely here.
	 * @param mixed    ...$args    - Arguments will be passed to the callback as well as determine
	 *                             if we can reuse a result.
	 *
	 * @return mixed
	 */
	public function memoize( callable $callback, string $identifier, ...$args ): mixed {
		// Closure uses their object id to differentiate.
		$cache_args = Arrays::in()->map_recursive( fn( $arg ) => $arg instanceof \Closure ? 'closure-' . \spl_object_id( $arg ) : $arg, $args );

		$key = $this->get_cache_key( $identifier, $cache_args );
		if ( ! \array_key_exists( $key, $this->memoize_cache ) ) {
			$this->memoize_cache[ $key ] = $callback( ...$args );
		}

		return $this->memoize_cache[ $key ];
	}


	/**
	 * Pass me a callback, a method identifier, and some optional arguments and
	 * I will return the same result every time I'm called for the same
	 * class and identifier, regardless of how many times a class is instantiated.
	 *
	 * Used when something should only be called once per class even when a class
	 * is constructed multiple times.
	 *
	 * Think if it like using a static variable within a method as a flag to only run once.
	 *
	 * @since 5.0.0
	 *
	 * @param callable $callback     - Callback, which returns the value to store and return.
	 * @param string   $identifier   - Something unique to identify the method being used
	 *                               so we can determine the difference in the cache.
	 *                               `__METHOD__` works nicely here.
	 * @param mixed    ...$args      - Arguments will be passed to the callback.
	 *
	 * @return mixed
	 */
	public function static_once( callable $callback, string $identifier, ...$args ): mixed {
		$key = \get_class( $this ) . '::' . $identifier;
		if ( ! \array_key_exists( $key, static::$static_cache ) ) {
			static::$static_cache[ $key ] = $callback( ...$args );
		}

		return static::$static_cache[ $key ];
	}


	/**
	 * Delete a single item from the caches without clearing
	 * the entire class and cache group.
	 *
	 * @see Memoize::clear_memoize_cache()
	 *
	 * @param string       $identifier - Identifier used with the original method to store value.
	 * @param array<mixed> ...$args    - Arguments passed to the original method when storing value.
	 *
	 * @return bool - Result of deleting the cache from an external object cache.
	 */
	public function clear_single_item( string $identifier, ...$args ): bool {
		$cache_key = $this->get_cache_key( $identifier, $args );
		$nonce_key = "{$identifier}::once";
		unset(
			$this->memoize_cache[ $cache_key ],
			$this->memoize_cache[ $nonce_key ]
		);
		return Cache::in()->delete( $cache_key, __CLASS__ );
	}


	/**
	 * Clear all caches on this class.
	 * Typically, used during unit testing.
	 *
	 * @see Memoize::clear_single_item()
	 */
	public function clear_memoize_cache(): void {
		$this->memoize_cache = [];
		static::$static_cache = [];
		Cache::in()->flush_group( __CLASS__ );
	}


	/**
	 * Return a key use for the various caches.
	 *
	 * - If `$args` is empty, return the `$identifier` as is.
	 * - If not, return a combination of the `$identifier` and `$args` as a hash.
	 *
	 * @since 4.2.0
	 *
	 * @param string       $identifier - Unique key to hold the cache.
	 * @param array<mixed> $args       - Arguments passed to the original method.
	 *
	 * @return string
	 */
	protected function get_cache_key( string $identifier, array $args ): string {
		if ( \count( $args ) < 1 ) {
			return $identifier;
		}

		// Return `$identifier` on empty multidimensional array.
		if ( 1 === \count( $args ) && \is_array( $args[0] ) && \count( $args[0] ) < 1 ) {
			return $identifier;
		}

		return \hash( 'murmur3f', (string) wp_json_encode( [ $args, $identifier ] ) );
	}
}
