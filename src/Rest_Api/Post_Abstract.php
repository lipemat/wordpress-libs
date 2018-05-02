<?php

namespace Lipe\Lib\Rest_Api;

/**
 * Post_Abstract
 *
 * Extend into any post type class
 * Call the hook method to register actions
 *
 * @example A few examples in the Examples folder
 *
 * @see     the protected properties which may be overridden
 *
 */
abstract class Post_Abstract {

	/**
	 * which taxonomies will show in object
	 *
	 * @var array
	 */
	protected $taxonomies = [];

	/**
	 * Which keys may be queried against
	 *
	 * @var array
	 */
	protected $allowed_meta_keys = [];

	/**
	 * Which connection types may be queried against
	 *
	 * @var array
	 */
	protected $related = [];


	public function hook() : void {
		add_action( 'rest_api_init', [ $this, 'add_fields' ] );
		add_filter( 'rest_prepare_' . static::POST_TYPE, [ $this, 'add_stripped_content' ], 10, 3 );
		add_filter( 'rest_prepare_' . static::POST_TYPE, [ $this, 'add_stripped_content' ], 10, 3 );

		add_filter( 'rest_' . static::POST_TYPE . '_query', [ $this, 'allow_meta_queries' ], 10, 2 );
		add_filter( 'rest_' . static::POST_TYPE . '_query', [ $this, 'allow_related_queries' ], 10, 2 );
	}


	public function add_fields() : void {
		register_rest_field( static::POST_TYPE, 'thumbnail', [
			'get_callback' => [ $this, 'render_thumbnail' ],
		] );

		register_rest_field( static::POST_TYPE, 'meta', [
			'get_callback' => [ $this, 'render_meta' ],
		] );

		register_rest_field( static::POST_TYPE, 'terms', [
			'get_callback' => [ $this, 'render_terms' ],
		] );
	}


	public function add_stripped_content( $response, $post, $request ) {
		$content = $post->post_content;
		$content = str_replace( [ PHP_EOL, '  ' ], ' ', $content );

		$response->data['content']['stripped'] = wp_strip_all_tags( $content );

		return $response;
	}


	public function render_thumbnail( $object, $field_name, $request ) {
		return get_the_post_thumbnail_url( $object['id'] );
	}


	public function render_terms( $object, $field_name, $request ) {
		return wp_get_post_terms( $object['id'], $this->taxonomies );
	}


	public function render_meta( $object, $field_name, $request ) {
		$meta = get_post_meta( $object['id'] );
		ksort( $meta );
		foreach ( (array) $meta as $_key => $_item ) {
			if ( is_protected_meta( $_key, 'post' ) ) {
				unset( $meta[ $_key ] );
			} else {
				if ( \is_array( $meta[ $_key ] ) && \count( $meta[ $_key ] ) === 1 ) {
					$meta[ $_key ] = maybe_unserialize( array_shift( $meta[ $_key ] ) );
				}
			}
		}

		return $meta;
	}


	public function allow_meta_queries( $query_args, $request ) {
		foreach ( $this->allowed_meta_keys as $_key ) {
			if ( isset( $request[ $_key ] ) ) {
				$meta_query = [
					'key'   => $_key,
					'value' => $request[ $_key ],
				];
				//It's possible the key does not exist yet so a check for false
				//should also check if not exists using a sub meta query
				if ( false === (bool) $request[ $_key ] ) {
					$meta_query = [
						'relation' => 'OR',
						$meta_query,
						[
							'key'     => $_key,
							'value'   => $request[ $_key ],
							'compare' => 'NOT EXISTS',
						],
					];
				}

				$query_args['meta_query'][] = $meta_query;
			}
		}

		return $query_args;
	}


	public function allow_related_queries( $query_args, $request ) {
		foreach ( $this->related as $_connection ) {
			if ( isset( $request[ $_connection ] ) ) {
				$query_args['connected_type']   = $_connection;
				$query_args['connected_items']  = $request[ $_connection ];
				$query_args['suppress_filters'] = false;
			}
		}

		return $query_args;
	}

}
