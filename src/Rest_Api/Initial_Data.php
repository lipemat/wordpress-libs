<?php
/** @noinspection PhpUnhandledExceptionInspection */
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;
use Lipe\Lib\Util\Arrays;

/**
 * Generate JSON data, which mimics the return of wp-json API.
 *
 * Use most commonly to get the json data without making a request to the API.
 * Thus preventing an antipattern when using React etc.
 */
class Initial_Data {
	use Singleton;
	use Memoize;

	/**
	 * Are we currently retrieving initial data?
	 *
	 * @var bool
	 */
	protected bool $retrieving = false;


	/**
	 * Are we currently retrieving initial data?
	 *
	 * Used within conditions, which need apply to only initial data.
	 *
	 * @return bool
	 */
	public function is_retrieving(): bool {
		return $this->retrieving;
	}


	/**
	 * Turn an array of comments into their matching data format
	 * provided by the JSON API Server.
	 *
	 * @param \WP_Comment[] $comments   - Array of comment objects.
	 * @param bool          $with_links - To include links inside the response.
	 * @param bool|string[] $embed      - Whether to embed all links, a filtered list of link relations, or no links.
	 *
	 * @return array<array<mixed>>
	 */
	public function get_comments_data( array $comments, bool $with_links = false, array|bool $embed = false ): array {
		$controller = new \WP_REST_Comments_Controller();
		return \array_map( function( $comment ) use ( $controller, $with_links, $embed ) {
			return $this->get_response( $controller, $comment, $with_links, $embed );
		}, $comments );
	}


	/**
	 * Gets global posts data from the JSON API server
	 * Alternatively an array of posts may be passed to be converted to json data
	 *
	 * @param \WP_Post[]|null $posts      - Array of post objects (defaults to global WP_Query->posts).
	 * @param bool            $with_links - To include links inside the response.
	 * @param bool|string[]   $embed      - Whether to embed all links, a filtered list of link relations, or no links.
	 *
	 * @return array<array<mixed>>
	 */
	public function get_post_data( ?array $posts = null, bool $with_links = false, array|bool $embed = false ): array {
		if ( null === $posts && ! is_404() ) {
			$posts = $GLOBALS['wp_query']->posts;
		}

		return \array_map( function( $post ) use ( $with_links, $embed ) {
			$controller = new \WP_REST_Posts_Controller( $post->post_type );
			return $this->get_response( $controller, $post, $with_links, $embed );
		}, $posts );
	}


	/**
	 * Turn an array of users into their matching data format
	 * provided by the JSON API Server.
	 *
	 * @since 3.4.0
	 *
	 * @param \WP_User[]    $users      - Array of user objects.
	 * @param bool          $with_links - To include links inside the response.
	 * @param bool|string[] $embed      - Whether to embed all links, a filtered list of link relations,
	 *                                  or no links.
	 *
	 * @return array<array<mixed>>
	 */
	public function get_user_data( array $users, bool $with_links = false, array|bool $embed = false ): array {
		$controller = new \WP_REST_Users_Controller();
		return \array_map( function( $user ) use ( $controller, $with_links, $embed ) {
			return $this->get_response( $controller, $user, $with_links, $embed );
		}, $users );
	}


	/**
	 * Turn an array of terms into their matching data format
	 * provided by the JSON API Server.
	 *
	 * @since 3.4.0
	 *
	 * @param \WP_Term[]    $terms                    - Array of term objects.
	 * @param bool          $with_links               - To include links inside the response.
	 * @param bool|string[] $embed                    - Whether to embed all links, a filtered list of link relations,
	 *                                                or no links.
	 *
	 * @return array<array<mixed>>
	 */
	public function get_term_data( array $terms, bool $with_links = false, array|bool $embed = false ): array {
		return \array_map( function( $term ) use ( $with_links, $embed ) {
			$controller = new \WP_REST_Terms_Controller( $term->taxonomy );
			return $this->get_response( $controller, $term, $with_links, $embed );
		}, $terms );
	}


	/**
	 * Turn an array of attachments into their matching data format
	 * provided by the JSON API Server.
	 *
	 * @param \WP_Post[]    $attachments - Array of attachment objects.
	 * @param bool          $with_links  - To include links inside the response.
	 * @param bool|string[] $embed       - Whether to embed all links, a filtered list of link relations, or no links.
	 *
	 * @return array<array<mixed>>
	 */
	public function get_attachments_data( array $attachments, bool $with_links = false, array|bool $embed = false ): array {
		$controller = new \WP_REST_Attachments_Controller( 'attachment' );
		return \array_map( function( $attachment ) use ( $controller, $with_links, $embed ) {
			return $this->get_response( $controller, $attachment, $with_links, $embed );
		}, $attachments );
	}


	/**
	 * Mimic response from the REST server for the provided controller.
	 *
	 * @link  https://developer.wordpress.org/rest-api/using-the-rest-api/global-parameters/#_embed
	 * @link  https://developer.wordpress.org/rest-api/using-the-rest-api/linking-and-embedding/#embedding
	 *
	 * @throws \RuntimeException -- If response was a WP_Error.
	 *
	 * @param \WP_REST_Controller $controller - REST controller instance.
	 * @param object              $item       - Object to mimic response for.
	 * @param bool                $with_links - To include links inside the response.
	 * @param bool|string[]       $embed      - Whether to embed all links, a filtered list of link relations, or no links.
	 *
	 * @return array<mixed>
	 */
	protected function get_response( \WP_REST_Controller $controller, object $item, bool $with_links = false, array|bool $embed = false ): array {
		$this->retrieving = true;
		// Call before get_fields to allow `rest_api_init` to fire.
		$server = rest_get_server();
		$request = $this->get_request();

		$fields = $controller->get_fields_for_response( $request );
		if ( ! $with_links ) {
			$key = \array_search( '_links', $fields, true );
			if ( false !== $key ) {
				unset( $fields[ $key ] );
			}
			$request->set_param( '_fields', \array_unique( $fields ) );
		}

		$response = $controller->prepare_item_for_response( $item, $request );
		if ( ! is_wp_error( $response ) ) {
			$data = $server->response_to_data( $response, $embed );
			$this->retrieving = false;
			return $data;
		}

		throw new \RuntimeException( esc_html( $response->get_error_message() ) );
	}


	/**
	 * Get an instance of the WP_REST_Request setup with
	 * the 'view' context.
	 *
	 * @return \WP_REST_Request<array<mixed>>
	 */
	protected function get_request(): \WP_REST_Request {
		$request = new \WP_REST_Request();
		$request->set_param( 'context', 'view' );

		return $request;
	}
}
