<?php
declare( strict_types=1 );

namespace Lipe\Lib\Comment;

use Lipe\Lib\Container\Factory;
use Lipe\Lib\Meta\MetaType;
use Lipe\Lib\Meta\Mutator_Trait;

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
 *
 * @template OPTIONS of array<string, mixed>
 */
trait Comment_Trait {
	/**
	 * @use \Lipe\Lib\Container\Factory<array{int|\WP_Comment}>
	 */
	use Factory;

	/**
	 * @use Mutator_Trait<OPTIONS>
	 */
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
	 * @var ?\WP_Comment
	 */
	protected ?\WP_Comment $comment;


	/**
	 * Comment_Trait constructor.
	 *
	 * @param int|\WP_Comment $comment - Comment ID or object.
	 */
	final public function __construct( int|\WP_Comment $comment ) {
		if ( $comment instanceof \WP_Comment ) {
			$this->comment = $comment;
			$this->comment_id = (int) $this->comment->comment_ID;
		} else {
			$this->comment_id = $comment;
		}
	}


	/**
	 * Return the comment object.
	 *
	 * @return \WP_Comment|null
	 */
	public function get_object(): ?\WP_Comment {
		if ( ! isset( $this->comment ) && 0 !== $this->comment_id ) {
			$comment = get_comment( $this->comment_id );
			if ( $comment instanceof \WP_Comment ) {
				$this->comment = $comment;
			} else {
				$this->comment = null;
			}
		}

		return $this->comment ?? null;
	}


	/**
	 * Get the comment id.
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->comment_id;
	}


	/**
	 * Used to determine the type of meta to retrieve or update.
	 *
	 * @return MetaType
	 */
	public function get_meta_type(): MetaType {
		return MetaType::COMMENT;
	}


	/**
	 * Return the post this comment is assigned to.
	 *
	 * If the post is not assigned or does not exist
	 * this will return null.
	 *
	 * @return \WP_Post|null
	 */
	public function get_comment_post(): ?\WP_Post {
		if ( null === $this->get_object() ) {
			return null;
		}
		return get_post( (int) $this->get_object()->comment_post_ID );
	}


	/**
	 * Does this comment exist in the database?
	 *
	 * @return bool
	 */
	public function exists(): bool {
		return null !== $this->get_object();
	}


	/**
	 * Create a new instance of this class.
	 *
	 * @param int|\WP_Comment $comment - Comment ID or object.
	 *
	 * @return static
	 */
	public static function factory( int|\WP_Comment $comment ): static {
		return static::factorize( $comment );
	}
}
