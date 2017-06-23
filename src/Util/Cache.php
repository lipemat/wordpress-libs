<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Cache
 *
 * Ability to manage cache a little easier for groups etc
 *
 * @example Cache::init(); To setup the clear cache button and save post actions
 * @example Cache::set( $key, $value );
 *
 * @todo General cleanup of code and PHP docs
 * @todo More testing required before recommending use
 *
 */
class Cache {
	use Singleton;

	const OPTION_GROUP_KEYS = 'lipe/lib/util/cache_group_keys';
	const DEFAULT_GROUP = 'lipe/lib/util/group';
	const FLUSH_ON_SAVE_POST_GROUP = 'lipe/lib/util/cache_flush_save_post';
	const QUERY_ARG = 'lipe/lib/util/clear-cache';



	public function hook() {
		add_action( 'init', [ $this, 'maybe_clear_cache' ], 9, 0 );

		if( current_user_can( 'manage_options' ) ){
			add_action( 'admin_bar_menu', [ $this, 'add_admin_bar_button' ], 100, 1 );
		}

		add_action( 'save_post', [ $this, 'clear_save_post_group' ], 1, 0 );
		add_action( 'delete_post', [ $this, 'clear_save_post_group' ], 1, 0 );
	}


	public static function set( $key, $value, $group = self::DEFAULT_GROUP, $expire = 0 ) {
		$group = self::get_group_key( $group );

		return wp_cache_set( self::filter_key( $key ), $value, $group, $expire );
	}


	/**
	 * Memcache will return false if we store null or false etc.
	 * This makes it impossible to know if we already tried to retrieve some data
	 * if our result was false or null.
	 * Using this method will store a '' in place of any empty value so we can check for
	 * === false and know if we have previously tried to store something
	 *
	 * @static
	 *
	 * @return bool
	 */
	public static function set_store_empty( $key, $value, $group = self::DEFAULT_GROUP, $expire = 0 ) {
		if( empty( $value ) ){
			$value = '';
		}

		return self::set( $key, $value, $group, $expire );
	}





	private static function get_group_key( $group ) {
		$keys = self::get_group_keys();
		if( isset( $keys[ $group ] ) ){
			return $keys[ $group ];
		}
		// make a new key
		$group = self::update_group_key( $group );

		return $group;
	}


	private static function get_group_keys() {
		$keys = get_option( self::OPTION_GROUP_KEYS, [] );
		if( empty( $keys ) || !is_array( $keys ) ){
			$keys = [];
		};

		return $keys;
	}


	private static function update_group_key( $group ) {
		$keys = self::get_group_keys();
		$new = $group . time();
		$keys[ $group ] = $new;
		self::set_group_keys( $keys );

		return $new;
	}


	private static function set_group_keys( array $keys ) {
		update_option( self::OPTION_GROUP_KEYS, $keys );
	}


	/**
	 * Process the cache key so that any unique data may serve as a key, even if it's an object or array.
	 *
	 * @param array|object|string $key
	 *
	 * @return bool|string
	 */
	private static function filter_key( $key ) {
		if( empty( $key ) ){
			return false;
		}
		$key = ( is_array( $key ) ) ? md5( serialize( $key ) ) : $key;

		return $key;
	}


	public static function get( $key, $group = self::DEFAULT_GROUP ) {
		$group = self::get_group_key( $group );
		$results = wp_cache_get( self::filter_key( $key ), $group );

		return $results;
	}


	public static function delete( $key, $group = self::DEFAULT_GROUP ) {
		$group = self::get_group_key( $group );
		$results = wp_cache_delete( self::filter_key( $key ), $group );

		return $results;
	}


	/**
	 * Clear the cache on all blogs
	 */
	public static function flush_all_sites() {
		global $wp_object_cache;
		if( isset( $wp_object_cache->mc ) ){
			foreach( array_keys( $wp_object_cache->mc ) as $group ){
				$wp_object_cache->mc[ $group ]->flush();
			}
		}
	}


	public function clear_save_post_group() {
		self::flush_group( self::FLUSH_ON_SAVE_POST_GROUP );
	}


	public static function flush_group( $group = self::DEFAULT_GROUP ) {
		self::update_group_key( $group );
	}


	public function maybe_clear_cache() {
		if( empty( $_REQUEST[ self::QUERY_ARG ] ) || empty( $_REQUEST[ '_wpnonce' ] ) || !wp_verify_nonce( $_REQUEST[ '_wpnonce' ], self::QUERY_ARG ) ){
			return;
		}
		self::flush_all();
		wp_redirect( remove_query_arg( [ self::QUERY_ARG, '_wpnonce' ] ) );
		die();
	}


	/**
	 * Change the key for everything we've tracked,
	 * thereby flushing the cache for a blog
	 */
	public static function flush_all() {
		$keys = self::get_group_keys();
		$time = time();
		foreach( $keys as $key => &$value ){
			$value = $key . $time;
		}
		self::set_group_keys( $keys );

		wp_cache_flush();
	}


	public function add_admin_bar_button( \WP_Admin_Bar $admin_bar ) {
		$admin_bar->add_menu( [
			'parent' => '',
			'id'     => self::QUERY_ARG,
			'title'  => __( 'Clear Cache', 'lipe' ),
			'meta'   => [ 'title' => __( 'Clear the cache for this site', 'lipe' ) ],
			'href'   => wp_nonce_url( add_query_arg( [ self::QUERY_ARG => 1 ] ), self::QUERY_ARG ),
		] );
	}

}
