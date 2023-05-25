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
	 * @param bool $with_query - Include any URL query in the URL.
	 *
	 * @return string
	 */
	public function get_current_url( bool $with_query = true ) : string {
		$prefix = is_ssl() ? 'https://' : 'http://';
		$uri = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) );
		if ( ! $with_query && '' !== $uri ) {
			$parts = wp_parse_url( $uri );
			$uri = $parts['path'] ?? '';
		}

		return esc_url_raw( $prefix . wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) . $uri );
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
}
