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
 */
class Cache {
	use Singleton;

	const DEFAULT_GROUP = 'lipe/lib/util/group';
	const FLUSH_ON_SAVE_POST_GROUP = 'lipe/lib/util/cache_flush_save_post';
	const QUERY_ARG = 'lipe/lib/util/clear-cache';


	public function hook() : void {
		add_action( 'init', [ $this, 'maybe_clear_cache' ], 9, 0 );

		if( current_user_can( 'manage_options' ) ){
			add_action( 'admin_bar_menu', [ $this, 'add_admin_bar_button' ], 100, 1 );
		}
	}


	public static function set( $key, $value, $group = self::DEFAULT_GROUP, $expire_in_seconds = 0 ) : bool {
		$group = self::get_group_key( $group );

		if( null === $value ){
			//store an empty value that memcache can handle
			$value = '';
		}

		return wp_cache_set( self::filter_key( $key ), $value, $group, $expire_in_seconds );
	}


	private static function get_group_key( $group ) : string {
		//tap into the existing last_changed for posts group
		if( self::FLUSH_ON_SAVE_POST_GROUP === $group ){
			$last_changed = wp_cache_get_last_changed( 'posts' );
		} else {
			$last_changed = wp_cache_get_last_changed( $group );
		}

		return $group . ':' . $last_changed;
	}


	/**
	 * Process the cache key so that any unique data may serve as a key,
	 * even if it's an object or array.
	 *
	 * @param array|string|object $key
	 *
	 * @return bool|string
	 */
	private static function filter_key( $key ) {
		if( empty( $key ) ){
			return false;
		}
		$key = ( \is_array( $key ) || \is_object( $key ) ) ? md5( serialize( $key ) ) : $key;

		return $key;
	}


	public static function get( $key, $group = self::DEFAULT_GROUP ) {
		$group = self::get_group_key( $group );

		return wp_cache_get( self::filter_key( $key ), $group );

	}


	public static function delete( $key, $group = self::DEFAULT_GROUP ) : bool {
		$group = self::get_group_key( $group );

		return wp_cache_delete( self::filter_key( $key ), $group );
	}


	public static function flush_all_sites() : void {
		global $wp_object_cache;
		if( null !== $wp_object_cache->mc ){
			foreach( array_keys( $wp_object_cache->mc ) as $group ){
				$wp_object_cache->mc[ $group ]->flush();
			}
		}
	}


	public function clear_save_post_group() : void {
		self::flush_group( self::FLUSH_ON_SAVE_POST_GROUP );
	}


	public static function flush_group( $group = self::DEFAULT_GROUP ) : void {
		wp_cache_set( 'last_changed', microtime(), $group );
	}


	public function maybe_clear_cache() : void {
		if( empty( $_REQUEST[ self::QUERY_ARG ] ) || empty( $_REQUEST[ '_wpnonce' ] ) || !wp_verify_nonce( $_REQUEST[ '_wpnonce' ], self::QUERY_ARG ) ){
			return;
		}
		wp_cache_flush();
		wp_redirect( remove_query_arg( [ self::QUERY_ARG, '_wpnonce' ] ) );
		die();
	}


	public function add_admin_bar_button( \WP_Admin_Bar $admin_bar ) : void {
		$admin_bar->add_menu( [
			'parent' => '',
			'id'     => self::QUERY_ARG,
			'title'  => __( 'Clear Cache', 'lipe' ),
			'meta'   => [ 'title' => __( 'Clear the cache for this site', 'lipe' ) ],
			'href'   => wp_nonce_url( add_query_arg( [ self::QUERY_ARG => 1 ] ), self::QUERY_ARG ),
		] );
	}

}
