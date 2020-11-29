<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Url
 *
 * @author  Mat Lipe
 * @since   0.0.1
 *
 * @package Lipe\Lib\Util
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

		return $prefix .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //phpcs:ignore
	}


	/**
	 * Retrieve the value of a query argument from a URL string.
	 *
	 * @param string $url - URL to retrieve from.
	 * @param string $key - Name of URL key to retrieve.
	 *
	 * @since 2.20.0
	 *
	 * @return string|array|null
	 */
	public function get_query_arg( string $url, string $key ) {
		$query_str = wp_parse_url( $url, PHP_URL_QUERY );
		wp_parse_str( $query_str, $query_vars );
		return $query_vars[ $key ] ?? null;
	}
}
