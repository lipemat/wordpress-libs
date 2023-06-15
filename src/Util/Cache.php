<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Ability to use arrays or objects as cache keys
 * and simplifies the flushing of groups.
 *
 * @example Cache::init(); To optionally generate the clear cache button.
 * @example Cache::set( $key, $value );
 *
 */
class Cache {
	use Singleton;

	protected const QUERY_ARG = 'lipe/lib/util/cache/cache';
	public const DEFAULT_GROUP = 'lipe/lib/util/cache/group';

	public const FLUSH_ON_SAVE_POST_GROUP = 'posts';


	public function hook() : void {
		add_action( 'init', [ $this, 'maybe_clear_cache' ], 9, 0 );

		if ( current_user_can( 'manage_options' ) ) {
			add_action( 'admin_bar_menu', [ $this, 'add_admin_bar_button' ], 100, 1 );
		}
	}


	/**
	 * @param array|string|object $key
	 * @param mixed               $value
	 * @param string              $group
	 * @param int                 $expire_in_seconds
	 *
	 * @return bool
	 */
	public function set( $key, $value, string $group = self::DEFAULT_GROUP, int $expire_in_seconds = 0 ) : bool {
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
	 * @param array|string|object $key
	 * @param string              $group
	 *
	 * @return false|mixed
	 */
	public function get( $key, string $group = self::DEFAULT_GROUP ) {
		$group = $this->get_group_key( $group );

		return wp_cache_get( $this->filter_key( $key ), $group );
	}


	/**
	 * @param array|string|object $key
	 * @param string              $group
	 *
	 * @return bool
	 */
	public function delete( $key, string $group = self::DEFAULT_GROUP ) : bool {
		$group = $this->get_group_key( $group );

		return wp_cache_delete( $this->filter_key( $key ), $group );
	}


	/**
	 * Flush a group by changing the "last_changed" key.
	 *
	 * @param string $group
	 *
	 * @return void
	 */
	public function flush_group( $group = self::DEFAULT_GROUP ) : void {
		wp_cache_set( 'last_changed', microtime(), $group );
	}


	public function maybe_clear_cache() : void {
		if ( empty( $_REQUEST[ static::QUERY_ARG ] ) || empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], static::QUERY_ARG ) ) {
			return;
		}
		wp_cache_flush();
		do_action( 'lipe/lib/util/cache/flush' );
		wp_safe_redirect( remove_query_arg( [ static::QUERY_ARG, '_wpnonce' ] ) );
		die();
	}


	public function add_admin_bar_button( \WP_Admin_Bar $admin_bar ) : void {
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
	 * @param string $group
	 *
	 * @return string
	 */
	protected function get_group_key( string $group ) : string {
		return $group . ':' . wp_cache_get_last_changed( $group );
	}


	/**
	 * Process the cache key so that any unique data may serve as a key,
	 * even if it's an object or array.
	 *
	 * @param array|string|object $key
	 *
	 * @return bool|string
	 */
	protected function filter_key( $key ) {
		if ( empty( $key ) ) {
			return false;
		}
		return ( \is_array( $key ) || \is_object( $key ) ) ? md5( wp_json_encode( $key ) ) : $key;
	}

}
