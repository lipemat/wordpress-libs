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


	/**
	 * @param int|\WP_Post $post
	 */
	public function __construct( $post ) {
		if ( is_a( $post, \WP_Post::class ) ) {
			$this->post = $post;
			$this->post_id = $this->post->ID;
		} else {
			$this->post_id = $post;
		}
	}

	/**
	 * Get the WP post from current context
	 *
	 * @return null|\WP_Post
	 */
	public function get_post() : ?\WP_Post {
		if ( null === $this->post ) {
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
	 * @param mixed $default
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key, $default = null ) {
		$value = Meta_Repo::instance()->get_meta( $this->post_id, $key );
		if ( null !== $default && empty( $value ) ) {
			return $default;
		}
		return $value;
	}


	/********* static *******************/

	/**
	 *
	 * @param int|\WP_Post $post
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $post ) {
		return new static( $post );
	}

}
