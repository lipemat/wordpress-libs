<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;
use WP_Object_Cache;

/**
 * Ability to use arrays or objects as cache keys
 * and simplifies the flushing of groups.
 *
 * @example Cache::init(); To optionally generate the clear cache button.
 * @example Cache::set($key, $value);
 *
 * @phpstan-type CACHE_KEY object|array<mixed>|int|string
 */
class Cache {
	use Singleton;

	public const    DEFAULT_GROUP            = 'lipe/lib/util/cache/group';
	public const    FLUSH_ON_SAVE_POST_GROUP = 'posts';

	protected const QUERY_ARG = 'lipe/lib/util/cache/cache';


	/**
	 * Actions and filters.
	 *
	 * @return void
	 */
	public function hook(): void {
		add_action( 'init', $this->maybe_clear_cache( ... ), 9, 0 );

		if ( current_user_can( 'manage_options' ) ) {
			add_action( 'admin_bar_menu', [ $this, 'add_admin_bar_button' ], 100 );
		}
	}


	/**
	 * Set a value in the cache.
	 *
	 * @phpstan-param CACHE_KEY       $key
	 *
	 * @param object|array|int|string $key               - Cache key. Array, string or object.
	 * @param mixed                   $value             - Value to store in the cache.
	 * @param string                  $group             - The group to store the cache in.
	 * @param int                     $expire_in_seconds - How long to store the cache for.
	 *
	 * @return bool
	 */
	public function set( object|array|int|string $key, mixed $value, string $group = self::DEFAULT_GROUP, int $expire_in_seconds = 0 ): bool {
		$group = $this->get_group_key( $group );

		if ( null === $value ) {
			// Store an empty value that memcache can handle.
			$value = '';
		}

		return wp_cache_set( $this->filter_key( $key ), $value, $group, $expire_in_seconds );
	}


	/**
	 * Get an item from the cache.
	 *
	 * @phpstan-param CACHE_KEY       $key
	 *
	 * @param object|array|int|string $key   - Cache key. Array, string or object.
	 * @param string                  $group - The group to store the cache in.
	 *
	 * @return false|mixed - false on failure to retrieve contents, or the cache contents on success.
	 */
	public function get( object|array|int|string $key, string $group = self::DEFAULT_GROUP ): mixed {
		$group = $this->get_group_key( $group );

		return wp_cache_get( $this->filter_key( $key ), $group );
	}


	/**
	 * Delete an item from the cache.
	 *
	 * Returns true if the item was deleted, false otherwise.
	 *
	 * @phpstan-param CACHE_KEY       $key
	 *
	 * @param object|array|int|string $key   - Cache key. Array, string or object.
	 * @param string                  $group - The group to store the cache in.
	 *
	 * @return bool
	 */
	public function delete( object|array|int|string $key, string $group = self::DEFAULT_GROUP ): bool {
		$group = $this->get_group_key( $group );

		return wp_cache_delete( $this->filter_key( $key ), $group );
	}


	/**
	 * Flush a group by changing the "last_changed" key.
	 *
	 * @param string $group - The group to flush.
	 *
	 * @return void
	 */
	public function flush_group( string $group = self::DEFAULT_GROUP ): void {
		wp_cache_set_last_changed( $group );
	}


	/**
	 * Free memory by flushing the runtime cache.
	 *
	 * 1. Clear the saved queries from the `wpdb` object.
	 * 2. Calls `wp_cache_flush_runtime()` if available.
	 * 3. Clear the runtime caches from the `WP_Object_Cache` object.
	 *
	 * - More verbose than `wp_cache_flush_runtime()` because it also clears the stats.
	 * - Works on projects which do not have `wp_cache_flush_runtime()` available.
	 *
	 * @return void
	 */
	public function flush_runtime_cache(): void {
		global $wpdb, $wp_object_cache;
		if ( $wpdb instanceof \wpdb ) {
			$wpdb->queries = [];
		}

		if ( wp_cache_supports( 'flush_runtime' ) ) {
			wp_cache_flush_runtime();
		}

		if ( $wp_object_cache instanceof \WP_Object_Cache ) {
			foreach ( [ 'group_ops', 'stat_operations', 'memcache_debug', 'cache' ] as $prop ) {
				if ( \property_exists( $wp_object_cache, $prop ) ) {
					$wp_object_cache->{$prop} = [];
				}
			}
			if ( \property_exists( $wp_object_cache, 'stats' ) ) {
				$wp_object_cache->stats = \array_fill_keys( \array_keys( $wp_object_cache->stats ), 0 );
			}

			if ( \is_callable( [ $wp_object_cache, '__remoteset' ] ) ) {
				$wp_object_cache->__remoteset();
			}
		}
	}


	/**
	 * Clear the entire cache using the "Clear Cache" button in the admin bar.
	 *
	 * @return void
	 */
	protected function maybe_clear_cache(): void {
		if ( ! isset( $_REQUEST[ static::QUERY_ARG ], $_REQUEST['_wpnonce'] ) || false === wp_verify_nonce( sanitize_text_field( \wp_unslash( $_REQUEST['_wpnonce'] ) ), static::QUERY_ARG ) ) {
			return;
		}
		wp_cache_flush();
		do_action( 'lipe/lib/util/cache/flush' );
		wp_safe_redirect( remove_query_arg( [ static::QUERY_ARG, '_wpnonce' ] ) );
		die();
	}


	/**
	 * Add the "Clear Cache" button to the admin bar.
	 * Only available to users with the "manage_options" capability.
	 *
	 * @param \WP_Admin_Bar $admin_bar - The admin bar object.
	 *
	 * @return void
	 */
	public function add_admin_bar_button( \WP_Admin_Bar $admin_bar ): void {
		$admin_bar->add_menu( [
			'parent' => '',
			'id'     => static::QUERY_ARG,
			'title'  => __( 'Clear Cache', 'lipe' ),
			'meta'   => [ 'title' => __( 'Clear the cache for this site', 'lipe' ) ],
			'href'   => wp_nonce_url( add_query_arg( [ static::QUERY_ARG => 1 ] ), static::QUERY_ARG ),
		] );
	}


	/**
	 * Group key with a custom "last_change" appended to it to handle
	 * flushing an entire group by changing a "last_changed" cache key.
	 *
	 * @param string $group - The cache group.
	 *
	 * @return string
	 */
	protected function get_group_key( string $group ): string {
		return $group . ':' . wp_cache_get_last_changed( $group );
	}


	/**
	 * Process the cache key so that any unique data may serve as a key,
	 * even if it's an object or array.
	 *
	 * @phpstan-param CACHE_KEY       $key
	 *
	 * @param object|array|int|string $key - Data to convert to a string cache key.
	 *
	 * @return int|string
	 */
	protected function filter_key( object|array|int|string $key ): int|string {
		if ( ! \is_scalar( $key ) ) {
			return \hash( 'murmur3f', (string) wp_json_encode( $key ) );
		}

		return $key;
	}
}
