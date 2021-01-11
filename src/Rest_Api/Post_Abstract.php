<?php

namespace Lipe\Lib\Rest_Api;

/**
 *
 * @deprecated The majority of this class is deprecated and anything remaining could be created
 *             on a case by case basis and does not make to exist here any longer.
 *
 */
abstract class Post_Abstract {

	public const POST_TYPE = 'post';

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
		\_deprecated_file( __FILE__, '2.11.0', null, 'The ' . __CLASS__ . ' has been deprecated as the majority of it\'s functionality is no longer needed. If you still need something from here, port it into your parent class as this file will be removed in version 3' );

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


	/**
	 * @deprecated in favor of sending _embed to the endpoint
	 *             https://developer.wordpress.org/rest-api/using-the-rest-api/global-parameters/#_embed
	 */
	public function render_thumbnail( $object, $field_name, $request ) {
		return get_the_post_thumbnail_url( $object['id'] );
	}

	/**
	 * @deprecated in favor of sending `_embed` to the endpoint
	 *             https://developer.wordpress.org/rest-api/using-the-rest-api/global-parameters/#_embed
	 */
	public function render_terms( $object, $field_name, $request ) {
		return wp_get_post_terms( $object['id'], $this->taxonomies );
	}


	/**
	 * @deprecated in favor of using `register_meta` to define which keys show up.
	 *             https://codex.wordpress.org/Function_Reference/register_meta
	 */
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
