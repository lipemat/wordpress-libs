<?php

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Meta\Meta_Repo;

/**
 * Post_Object_Trait
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Lib\Post_Type
 */
trait Post_Object_Trait {

	protected $post_id;

	/**
	 * post
	 *
	 * @var \WP_Post
	 */
	protected $post;


	public function __construct( $post_id ) {
		$this->post_id = $post_id;
	}


	/**
	 * Get the WP post from current context
	 *
	 * @return null|\WP_Post
	 */
	public function get_post() {
		if( empty( $this->post ) ){
			$this->post = get_post( $this->post_id );
		}

		return $this->post;
	}


	public function get_id() {
		return $this->post_id;
	}


	public function get_meta( $key ) {
		return Meta_Repo::instance()->get_meta( $this->post_id, $key );
	}


	/********* static *******************/

	/**
	 *
	 * @param int $post_id
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $post_id ) {
		return new static( $post_id );
	}

}