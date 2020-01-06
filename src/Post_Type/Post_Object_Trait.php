<?php

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * @property string comment_count
 * @property string comment_status
 * @property string filter
 * @property string guid
 * @property int ID
 * @property int menu_order
 * @property string ping_status
 * @property string pinged
 * @property string post_author
 * @property string post_content
 * @property string post_content_filtered
 * @property string post_date
 * @property string post_date_gmt
 * @property string post_excerpt
 * @property string post_mime_type
 * @property string post_modified
 * @property string post_modified_gmt
 * @property string post_name
 * @property int post_parent
 * @property string post_password
 * @property string post_status
 * @property string post_title
 * @property string post_type
 * @property string to_ping
 */
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
	 * @deprecated In favor of $this->get_object()
	 */
	public function get_post() : ?\WP_Post {
		return $this->get_object();
	}

	public function get_object() : ?\WP_Post {
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
