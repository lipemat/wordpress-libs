<?php

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Meta\Meta_Repo;


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
	public function get_post() : ?\WP_Post {
		if( null === $this->post ){
			$this->post = get_post( $this->post_id );
		}

		return $this->post;
	}


	public function get_id() {
		return $this->post_id;
	}


	/**
	 *
	 * @param string $key
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key ) {
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
