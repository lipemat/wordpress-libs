<?php

namespace Lipe\Lib\Util;

/**
 * Url
 *
 * @author  Mat Lipe
 * @since   0.0.1
 *
 * @package Lipe\Lib\Util
 */
class Url {

	/**
	 * Get Current Url
	 *
	 * Returns the url of the page you are currently on
	 *
	 * @return string
	 */
	public function get_current_url() {
		$prefix = is_ssl() ? "https://" : "http://";
		$current_url = $prefix . $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

		return $current_url;
	}
}