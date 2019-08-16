<?php

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;

/**
 * Generate JSON data which mimics the return of wp-json api.
 *
 * Use most commonly to get the json data without making a request to the api
 * Thus preventing an anti-pattern when using React etc.
 *
 * @since June, 2017
 * @since 2.12.0 (greatly revamped and added comment support)
 *
 */
class Initial_Data {
	use Singleton;
	use Memoize;


	/**
	 * Turn an array of Comments into there matching data format
	 * provided by the JSON API Server.
	 *
	 * @param \WP_Comment[] $comments
	 * @param bool          $embed_links - To embed the links inside the response (default to false);
	 *
	 * @since 2.12.0
	 *
	 * @return array
	 *
	 */
	public function get_comments_data( array $comments, bool $embed_links = false ) : array {
		$controller = new \WP_REST_Comments_Controller();

		return array_map( function ( $comment ) use ( $controller, $embed_links ) {
			return $this->get_response( $controller, $comment, $embed_links );
		}, $comments );
	}


	/**
	 * Gets global posts data from the JSON API server
	 * Alternatively an array of posts may be passed to be converted to json data
	 *
	 * @param \WP_Post[]|null $posts       - Array of post objects
	 *                                     (defaults to global WP_Query->posts)
	 *
	 * @param bool            $embed_links - To embed the links inside the response (default to true);
	 *
	 * @return array
	 */
	public function get_post_data( ?array $posts = null, bool $embed_links = true ) : array {
		if ( null === $posts && ! is_404() ) {
			$posts = $GLOBALS['wp_query']->posts;
		}

		return array_map( function ( $post ) use ( $embed_links ) {
			$controller = new \WP_REST_Posts_Controller( $post->post_type );

			return $this->get_response( $controller, $post, $embed_links );
		}, $posts );
	}


	/**
	 * @param \WP_REST_Controller  $controller
	 * @param \WP_Post|\WP_Comment $item
	 * @param bool                 $embed_links
	 *
	 * @link  https://developer.wordpress.org/rest-api/using-the-rest-api/linking-and-embedding/#embedding
	 *
	 * @since 2.12.0
	 *
	 * @return array
	 *
	 */
	protected function get_response( \WP_REST_Controller $controller, $item, bool $embed_links = true ) : array {
		return $this->get_server()->response_to_data( $controller->prepare_item_for_response( $item, $this->get_request() ), $embed_links );
	}


	/**
	 * @since 2.12.0
	 * @return \WP_REST_Request
	 */
	protected function get_request() : \WP_REST_Request {
		return $this->once( function () {
			$request            = new \WP_REST_Request();
			$request['context'] = 'view';

			return $request;
		}, __METHOD__ );
	}


	/**
	 * @since 2.12.0
	 * @return \WP_REST_Server
	 */
	protected function get_server() : \WP_REST_Server {
		global $wp_rest_server;
		if ( null === $wp_rest_server ) {
			$wp_rest_server_class = apply_filters( 'wp_rest_server_class', 'WP_REST_Server' );
			$wp_rest_server       = new $wp_rest_server_class();
			do_action( 'rest_api_init' );
		}

		return $wp_rest_server;
	}
}
