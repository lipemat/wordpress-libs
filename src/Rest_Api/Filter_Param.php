<?php

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Traits\Singleton;

/**
 * Allows using any public wp_query argument to be added to the url
 * via a filter[<var>]=<value> param
 *
 * @uses    Run init() on this class before the rest_api_init hook fires.
 * @example /wp-json/wp/v2/posts?filter[cat]=4
 *
 * @author  Mat Lipe
 * @since   1.7.0
 *
 * @package Lipe\Project\Rest_Api
 */
class Filter_Param {
	use Singleton;


	protected function hook() : void {
		add_action( 'rest_api_init', [ $this, 'add_filters' ] );
	}


	/**
	 * Add the necessary filter to each post type
	 **/
	public function add_filters() : void {
		foreach ( get_post_types( [ 'show_in_rest' => true ], 'objects' ) as $post_type ) {
			add_filter( 'rest_' . $post_type->name . '_query', [ $this, 'add_filter_param' ], 10, 2 );
		}
	}


	/**
	 * Add the filter parameter
	 *
	 * @param  array            $args    The query arguments.
	 * @param  \WP_REST_Request $request Full details about the request.
	 *
	 * @return array $args.
	 **/
	public function add_filter_param( $args, $request ) : array {
		global $wp;
		$vars = apply_filters( 'query_vars', $wp->public_query_vars );

		foreach ( $vars as $var ) {
			if ( isset( $request['filter'][ $var ] ) ) {
				$args[ $var ] = $request['filter'][ $var ];
			} elseif ( isset( $_REQUEST[ $var ] ) ) {
				$args[ $var ] = $_REQUEST[ $var ];
			}
		}

		//limit to 100 no matter what
		if ( isset( $args['posts_per_page'] ) && (int) $args['posts_per_page'] > 100 ) {
			$args['posts_per_page'] = 100;
		}

		return $args;
	}
}