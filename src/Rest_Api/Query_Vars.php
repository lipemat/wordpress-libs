<?php

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Traits\Singleton;

/**
 * Allow using any public query_var as a rest api param.
 *
 * Will also bring back the deprecated "filter" rest api param, which
 * is not necessary because you can use the arguments directly without wrapping
 * them in filter, however this fixes backward compatibility for projects using the
 * filter param.
 *
 * @example  Run init() on this class before the rest_api_init hook fires.
 *
 * @example /wp-json/wp/v2/posts?cat=4
 * @example /wp-json/wp/v2/posts?filter[cat]=4
 */
class Query_Vars {
	use Singleton;

	public function __construct() {
		_doing_it_wrong( __CLASS__, 'This class is deprecated and will be removed in version 4.', '3.15.0' );
	}


	protected function hook() : void {
		add_action( 'rest_api_init', [ $this, 'add_filters' ] );
	}


	/**
	 * Add the necessary filter to each post type
	 **/
	public function add_filters() : void {
		foreach ( get_post_types( [ 'show_in_rest' => true ], 'objects' ) as $post_type ) {
			add_filter( 'rest_' . $post_type->name . '_query', [ $this, 'add_query_args' ], 10, 2 );
		}
	}


	/**
	 * Add any public query args which exist in the current request.
	 *
	 *
	 * @param  array            $args    The query arguments.
	 * @param  \WP_REST_Request $request Full details about the request.
	 *
	 * @return array
	 **/
	public function add_query_args( $args, $request ) : array {
		global $wp;
		$vars = apply_filters( 'query_vars', $wp->public_query_vars );

		foreach ( $vars as $var ) {
			if ( isset( $request['filter'][ $var ] ) ) {
				$args[ $var ] = $request['filter'][ $var ];
			} elseif ( isset( $request[ $var ] ) ) {
				$args[ $var ] = $request[ $var ];
			}
		}

		// Limit to 100 no matter what.
		if ( isset( $args['posts_per_page'] ) && (int) $args['posts_per_page'] > 100 ) {
			$args['posts_per_page'] = 100;
		}

		return $args;
	}
}
