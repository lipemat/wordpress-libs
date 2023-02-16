<?php
declare( strict_types=1 );

namespace Lipe\Lib\Comment;

use Lipe\Lib\Query\Args_Abstract;

/**
 * A fluent interface for calling `wp_insert_comment` and `wp_update_comment` comments.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @see    wp_insert_comment()
 * @see    wp_update_comment()
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_insert_comment/
 */
class Update_Comment extends Args_Abstract {
	/**
	 * ID of the comment to update.
	 *
	 * Not used via `wp_insert_comment`.
	 *
	 * @var int
	 */
	public int $comment_ID;

	/**
	 * The HTTP user agent of the `$comment_author` when
	 * the comment was submitted. Default empty.
	 *
	 * @var string
	 */
	public string $comment_agent;

	/**
	 * Whether the comment has been approved.
	 * Default 1.
	 *
	 * @var int|string
	 */
	public $comment_approved;

	/**
	 * The name of the author of the comment.
	 *
	 * Default empty
	 *
	 * @var string
	 */
	public string $comment_author;

	/**
	 * The email address of the `$comment_author`.
	 *
	 * Default empty
	 *
	 * @var string
	 */
	public string $comment_author_email;

	/**
	 * The IP address of the `$comment_author`.
	 *
	 * Default empty
	 *
	 * @var string
	 */
	public string $comment_author_IP;

	/**
	 * The URL address of the `$comment_author`.
	 *
	 * Default empty
	 *
	 * @var string
	 */
	public string $comment_author_url;

	/**
	 * The content of the comment.
	 *
	 * Default empty
	 *
	 * @var string
	 */
	public string $comment_content;

	/**
	 * The date the comment was submitted.
	 *
	 * To set the date manually, `$comment_date_gmt` must also be specified.
	 *
	 * Default is the current time.
	 *
	 * @var string
	 */
	public string $comment_date;

	/**
	 * The date the comment was submitted in the GMT timezone.
	 *
	 * Default is `$comment_date` in the site's GMT timezone.
	 *
	 * @var string
	 */
	public string $comment_date_gmt;

	/**
	 * The karma of the comment.
	 *
	 * Default 0
	 *
	 * @var int
	 */
	public int $comment_karma;

	/**
	 * ID of this comment's parent, if any.
	 *
	 * Default 0
	 *
	 * @var int
	 */
	public int $comment_parent;

	/**
	 * ID of the post that relates to the comment, if any.
	 *
	 * Default 0
	 *
	 * @var int
	 */
	public int $comment_post_ID;

	/**
	 * Comment type.
	 *
	 * Default 'comment'.
	 *
	 * @var string
	 */
	public string $comment_type;

	/**
	 * Array of key/value pairs to be stored in `commentmeta`
	 * for the new comment.
	 *
	 * @var array
	 */
	public array $comment_meta;

	/**
	 * ID of the user who submitted the comment.
	 *
	 * Default 0
	 *
	 * @var int
	 */
	public int $user_id;
}
