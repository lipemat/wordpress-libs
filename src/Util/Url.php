<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Url helpers.
 */
class Url {
	use Singleton;

	/**
	 * Returns the url of the page you are currently on
	 *
	 * @return string
	 */
	public function get_current_url() : string {
		$prefix = is_ssl() ? 'https://' : 'http://';

		return esc_url_raw( $prefix . wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) . wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) );
	}


	/**
	 * Retrieve the value of a query argument from a URL string.
	 *
	 * @param string $url - URL to retrieve from.
	 * @param string $key - Name of URL key to retrieve.
	 *
	 * @return string|array|null
	 */
	public function get_query_arg( string $url, string $key ) {
		$query_str = wp_parse_url( $url, PHP_URL_QUERY );
		wp_parse_str( $query_str, $query_vars );
		return $query_vars[ $key ] ?? null;
	}


	/**
	 * Get the link to the blog page with the page number
	 * added to it from anywhere on the site.
	 *
	 * Similar to `get_pagenum_link` expect it works when you
	 * are not already on the blog page.
	 *
	 * Falls back to `get_pagenum_link` if no blog page is set
	 * in Reading options.
	 *
	 * @since 3.15.0
	 *
	 * @param int $pagenum - Page number for the link.
	 *
	 * @return string
	 */
	public function get_blog_pagenum_link( int $pagenum = 1 ) : string {
		global $wp_rewrite;

		$blog_page = get_option( 'page_for_posts' );
		$base = get_permalink( $blog_page );
		if ( empty( $blog_page ) || empty( $base ) ) {
			return get_pagenum_link( $pagenum );
		}

		if ( $pagenum < 2 ) {
			return $base;
		}

		if ( ! $wp_rewrite->using_permalinks() || is_admin() ) {
			return add_query_arg( [ 'paged' => $pagenum ], $base );
		}

		return trailingslashit( $base ) . user_trailingslashit( $wp_rewrite->pagination_base . '/' . $pagenum, 'paged' );
	}

}
