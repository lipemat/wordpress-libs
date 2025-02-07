<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Meta\MetaType;
use Lipe\Lib\Meta\Mutator_Trait;

/**
 * Shared methods for interacting with the WordPress post object.
 *
 * @note `@mixin` does not work in PHPStan with Traits.
 *
 * @property string $comment_count
 * @property string $comment_status
 * @property string $filter
 * @property string $guid
 * @property int    $ID
 * @property int    $menu_order
 * @property string $ping_status
 * @property string $pinged
 * @property string $post_author
 * @property string $post_content
 * @property string $post_content_filtered
 * @property string $post_date
 * @property string $post_date_gmt
 * @property string $post_excerpt
 * @property string $post_mime_type
 * @property string $post_modified
 * @property string $post_modified_gmt
 * @property string $post_name
 * @property int    $post_parent
 * @property string $post_password
 * @property string $post_status
 * @property string $post_title
 * @property string $post_type
 * @property string $to_ping
 *
 * @template OPTIONS of array<string, mixed>
 */
trait Post_Object_Trait {
	/**
	 * @use Mutator_Trait<OPTIONS>
	 */
	use Mutator_Trait;

	/**
	 * ID of this post.
	 *
	 * @var int
	 */
	protected int $post_id = 0;

	/**
	 * Object of this post.
	 *
	 * @var \WP_Post|null
	 */
	protected ?\WP_Post $post = null;


	/**
	 * Construct this class with either the provided post
	 * of the current global post.
	 *
	 * @param int|\WP_Post|null $post - Post ID, WP_Post object, or null for global post.
	 */
	final public function __construct( int|\WP_Post|null $post = null ) {
		if ( null === $post ) {
			$post = get_post();
		}
		if ( $post instanceof \WP_Post ) {
			$this->post = $post;
			$this->post_id = $this->post->ID;
		} else {
			$this->post_id = (int) $post;
		}
	}


	/**
	 * Get the WP Post object.
	 *
	 * @return \WP_Post|null
	 */
	public function get_object(): ?\WP_Post {
		if ( null === $this->post ) {
			$this->post = get_post( $this->post_id );
		}

		return $this->post;
	}


	/**
	 * Get the database ID of this wp post.
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->post_id;
	}


	/**
	 * Used by the Mutator_Trait to determine the type
	 * of meta to retrieve or update.
	 *
	 * @return MetaType
	 */
	public function get_meta_type(): MetaType {
		return MetaType::POST;
	}


	/**
	 * Get an instance of this class.
	 *
	 * @param int|\WP_Post|null $post - Post ID, WP_Post object, or null for the current post.
	 *
	 * @return static
	 */
	public static function factory( int|\WP_Post|null $post = null ): static {
		return new static( $post );
	}
}
