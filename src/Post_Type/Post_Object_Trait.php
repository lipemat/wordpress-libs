<?php

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Meta\Mutator_Trait;

trait Post_Object_Trait {
	use Mutator_Trait;

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
			$this->post    = $post;
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


	public function get_id() : int {
		return (int) $this->post_id;
	}


	public function get_meta_type() : string {
		return 'post';
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
