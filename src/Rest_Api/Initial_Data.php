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
 */
class Initial_Data {
	use Singleton;
	use Memoize;

	/**
	 * Turn an array of Comments into there matching data format
	 * provided by the JSON API Server.
	 *
	 * @param \WP_Comment[] $comments
	 * @param bool          $with_links - To include links inside the response.
	 * @param bool          $embed      - To embed the links inside the response.
	 *
	 * @since 2.12.0
	 * @since 2.19.0 - Support excluding the entire '_links' data.
	 *
	 * @return array
	 *
	 */
	public function get_comments_data( array $comments, bool $with_links = false, bool $embed = false ) : array {
		$controller = new \WP_REST_Comments_Controller();

		return array_map( function ( $comment ) use ( $controller, $with_links, $embed ) {
			return $this->get_response( $controller, $comment, $with_links, $embed );
		}, $comments );
	}


	/**
	 * Gets global posts data from the JSON API server
	 * Alternatively an array of posts may be passed to be converted to json data
	 *
	 * @param \WP_Post[]|null $posts      - Array of post objects (defaults to global WP_Query->posts)
	 * @param bool            $with_links - To include links inside the response.
	 * @param bool            $embed      - To embed the links inside the response.
	 *
	 * @since 2.19.0 - Support excluding the entire '_links' data.
	 *
	 * @return array
	 */
	public function get_post_data( ?array $posts = null, bool $with_links = false, bool $embed = false ) : array {
		if ( null === $posts && ! is_404() ) {
			$posts = $GLOBALS['wp_query']->posts;
		}

		return array_map( function ( $post ) use ( $with_links, $embed ) {
			$controller = new \WP_REST_Posts_Controller( $post->post_type );

			return $this->get_response( $controller, $post, $with_links, $embed );
		}, $posts );
	}


	/**
	 * Mimic response from the REST server for the provided controller.
	 *
	 * @param \WP_REST_Controller  $controller
	 * @param \WP_Post|\WP_Comment $item
	 * @param bool                 $with_links - To include links inside the response.
	 * @param bool                 $embed      - To embed the links inside the response.
	 *
	 * @link  https://developer.wordpress.org/rest-api/using-the-rest-api/linking-and-embedding/#embedding
	 *
	 * @since 2.12.0
	 * @since 2.19.0 - Support excluding the entire '_links' data.
	 *
	 * @return array
	 *
	 */
	protected function get_response( \WP_REST_Controller $controller, $item, bool $with_links = false, bool $embed = false ) : array {
		$data = rest_get_server()->response_to_data(
			$controller->prepare_item_for_response( $item, $this->get_request() ),
			$embed
		);
		if ( ! $with_links ) {
			unset( $data['_links'] );
		}
		return $data;
	}


	/**
	 * Get an instance of the WP_REST_Request setup with
	 * the 'view' context.
	 *
	 * @since 2.12.0
	 * @return \WP_REST_Request
	 */
	protected function get_request() : \WP_REST_Request {
		return $this->once( function () {
			$request = new \WP_REST_Request();
			$request['context'] = 'view';

			return $request;
		}, __METHOD__ );
	}


	/**
	 * @deprecated 2.19.0
	 */
	protected function get_server() : \WP_REST_Server {
		\_deprecated_function( __METHOD__, '2.19.0', '\rest_get_server' );
		return rest_get_server();
	}
}
