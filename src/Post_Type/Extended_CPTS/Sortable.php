<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

use Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Sortable
 *
 * Extended CPTs provides a mechanism for registering values for the public orderby query var,
 * which allows users to sort your post type archives by various fields.
 * This also works in WP_Query, which makes ordering custom post type listings very powerful and dead easy.
 *
 * Think of these as the front-end equivalent of sortable columns in the admin area, minus the UI.
 *
 * The array keys in the site_sortables array are used for the orderby value
 *
 * @link    https://github.com/johnbillion/extended-cpts/wiki/Query-vars-for-sorting#example
 *
 * @example
 * new WP_Query( array(
 * 'post_type' => 'article',
 * 'orderby'   => $sort_key,
 * 'order'     => 'DESC',
 * ) );
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Extended_CPTS
 */
class Sortable {
	protected $CPTS;

	/**
	 *
	 * @see \Lipe\Lib\Post_Type\Extended_CPTS\Sortable::set()
	 * @var string
	 */
	protected $sortables_array_key;


	/**
	 * Sortable constructor.
	 *
	 * @param \Lipe\Lib\Post_Type\Extended_CPTS $CPTS
	 */
	public function __construct( Extended_CPTS $CPTS ) {
		$this->CPTS = $CPTS;
	}


	/**
	 * Store args to cpt object
	 * This must be called from every method that is saving args
	 *
	 * or they will go nowhere
	 *
	 * @internal
	 *
	 * @param [] $args
	 *
	 * @return void
	 */
	public function set( array $args ) {
		if( !isset( $this->CPTS->site_sortables[ $this->sortables_array_key ] ) ){
			$this->sortables_array_key = $args[ 'sort_key' ];
			$this->CPTS->site_sortables[ $this->sortables_array_key ] = [];
			unset( $args[ 'sort_key' ] );
		}

		$existing = $this->CPTS->site_sortables[ $this->sortables_array_key ];

		$existing = array_merge( $existing, $args );
		$this->CPTS->site_sortables[ $this->sortables_array_key ] = $existing;
	}

	/**
	 * Store args to cpt object
	 * Then return the Sortable_Shared class
	 *
	 * @param array $args
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Sortable_Shared
	 */
	protected function return( array $args ){
		$this->set( $args );
		return new Sortable_Shared( $this, $args );
	}


	/**
	 * Sort posts by their meta value by using the meta_key parameter:
	 *
	 * @param string $sort_key
	 * @param string $meta_key
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Sortable_Shared
	 */
	public function meta( $sort_key, $meta_key ) {
		$_args = [
			'sort_key' => $sort_key,
			'meta_key' => $meta_key,
		];

		return $this->return( $_args );
	}


	/**
	 * Sort posts by their taxonomy term(s) by using the taxonomy parameter:
	 *
	 * @param string $sort_key
	 * @param string $taxonomy
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Sortable_Shared
	 */
	public function taxonomy( $sort_key, $taxonomy ) {
		$_args = [
			'sort_key' => $sort_key,
			'taxonomy' => $taxonomy,
		];

		return $this->return( $_args );

	}


	/**
	 * Sort posts by any available post field by using the post_field parameter:
	 *
	 * @param string $sort_key
	 * @param string $post_field
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Sortable_Shared
	 */
	public function post_field( $sort_key, $post_field ) {
		$_args = [
			'sort_key'   => $sort_key,
			'post_field' => $post_field,
		];

		return $this->return( $_args );

	}

}