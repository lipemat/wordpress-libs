<?php

namespace Lipe\Lib\Comment;

use Lipe\Lib\Meta\Mutator_Trait;
use Lipe\Lib\Meta\Repo;

/**
 * Shared methods for interacting with the WordPress comment object.
 *
 * @property string $comment_agent
 * @property string $comment_approved
 * @property string $comment_author
 * @property string $comment_author_email
 * @property string $comment_author_IP
 * @property string $comment_author_url
 * @property string $comment_content
 * @property string $comment_date
 * @property string $comment_date_gmt
 * @property string $comment_ID
 * @property string $comment_karma
 * @property string $comment_parent
 * @property string $comment_post_ID
 * @property string $comment_type
 * @property string $user_id
 */
trait Comment_Trait {
	use Mutator_Trait;

	/**
	 * Comment ID
	 *
	 * @var int
	 */
	protected int $comment_id;

	/**
	 * Comment object
	 *
	 * @var \WP_Comment
	 */
	protected $comment;


	/**
	 * Comment_Trait constructor.
	 *
	 * @param int|\WP_Comment $comment - Comment ID or object.
	 */
	public function __construct( $comment ) {
		if ( is_a( $comment, \WP_Comment::class ) ) {
			$this->comment = $comment;
			$this->comment_id = (int) $this->comment->comment_ID;
		} else {
			$this->comment_id = (int) $comment;
		}
	}


	/**
	 * Return the comment object.
	 *
	 * @return \WP_Comment|null
	 */
	public function get_object() : ?\WP_Comment {
		if ( null === $this->comment ) {
			$this->comment = get_comment( $this->comment_id );
		}

		return $this->comment;
	}


	/**
	 * Get the comment id.
	 *
	 * @return int
	 */
	public function get_id() : int {
		return $this->comment_id;
	}


	/**
	 * Return the post this comment is assigned to.
	 *
	 * If the post is not assigned or does not exist
	 * this will return null.
	 *
	 * @return \WP_Post|null
	 */
	public function get_comment_post() : ?\WP_Post {
		return get_post( (int) $this->get_object()->comment_post_ID );
	}


	/**
	 * Used to determine the type of meta to retrieve or update.
	 *
	 * @return string
	 */
	public function get_meta_type() : string {
		return Repo::META_COMMENT;
	}


	/**
	 * Create a new instance of this class.
	 *
	 * @param int|\WP_Comment $comment - Comment ID or object.
	 *
	 * @return static
	 */
	public static function factory( $comment ) {
		return new static( $comment );
	}

}
