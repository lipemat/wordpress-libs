<?php

namespace Lipe\Lib\Comment;

use Lipe\Lib\Meta\Meta_Repo;

/**
 * Trait Comment_Trait
 *
 * @since   1.5.0
 *
 * @package Lipe\Lib\Comment
 */
trait Comment_Trait {

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


	/**
	 * Get the WP comment from current context
	 *
	 * @return null|\WP_Comment
	 */
	public function get_comment() : ?\WP_Comment {
		if ( null === $this->comment ) {
			$this->comment = get_comment( $this->comment_id );
		}

		return $this->comment;
	}


	public function get_id() {
		return $this->comment_id;
	}


	/**
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key, $default = null ) {
		$value = Meta_Repo::instance()->get_meta( $this->comment_id, $key, 'comment' );
		if ( null !== $default && empty( $value ) ) {
			return $default;
		}

		return $value;
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
