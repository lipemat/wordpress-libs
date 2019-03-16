<?php

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Traits\Singleton;

/**
 * Initial_Data
 *
 * Use most commonly to get the json data without making a request to the api
 * Thus preventing an anti-pattern when using React and Such
 *
 *
 */
class Initial_Data {
	use Singleton;


	/**
	 * Gets global posts data from the JSON API server
	 * Alternatively an array of posts may be passed to be converted to json data
	 *
	 * @param null|[] $posts
	 *
	 * @return array
	 */
	public function get_post_data( $posts = null ) : array {
		if ( null === $posts && ! is_404() ) {
			$posts = $GLOBALS['wp_query']->posts;
		}
		global $wp_rest_server;
		if ( null === $wp_rest_server ) {
			$wp_rest_server_class = apply_filters( 'wp_rest_server_class', 'WP_REST_Server' );
			$wp_rest_server       = new $wp_rest_server_class();
			do_action( 'rest_api_init' );
		}
		$data               = [];
		$request            = new \WP_REST_Request();
		$request['context'] = 'view';
		foreach ( (array) $posts as $post ) {
			$controller = new \WP_REST_Posts_Controller( $post->post_type );
			$data[]     = $wp_rest_server->response_to_data( $controller->prepare_item_for_response( $post, $request ), true );
		}

		return $data;
	}
}
