<?php

namespace Lipe\Lib\Comment;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * @property string $comment_agent
 * @property string $comment_approved
 * @property string $comment_author
 * @property string $comment_author_email
 * @property string $comment_author_IP
 * @property string $comment_author_url
 * @property string $comment_content
 * @property string $comment_date
 * @property string $comment_date_gmt
 * @property int $comment_ID
 * @property int $comment_karma
 * @property int $comment_parent
 * @property int $comment_post_ID
 * @property string $comment_type
 * @property int $user_id
 */
trait Comment_Trait {
	use Mutator_Trait;

	protected $comment_id;

	/**
	 * comment
	 *
	 * @var \WP_Comment
	 */
	protected $comment;


	/**
	 * @param int|\WP_Comment $comment
	 */
	public function __construct( $comment ) {
		if ( is_a( $comment, \WP_Comment::class ) ) {
			$this->comment    = $comment;
			$this->comment_id = $this->comment->comment_ID;
		} else {
			$this->comment_id = $comment;
		}
	}


	public function get_object() : ?\WP_Comment {
		if ( null === $this->comment ) {
			$this->comment = get_comment( $this->comment_id );
		}

		return $this->comment;
	}


	public function get_id() : int {
		return (int) $this->comment_id;
	}


	public function get_meta_type() : string {
		return 'comment';
	}



	/********* static *******************/

	/**
	 *
	 * @param int|\WP_Comment $comment
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $comment ) {
		return new static( $comment );
	}

}
