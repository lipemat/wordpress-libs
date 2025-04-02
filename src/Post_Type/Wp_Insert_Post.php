<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for calling `wp_insert_post' or `wp_update_post'.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @see    wp_insert_post()
 * @see    wp_update_post()
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_insert_post/
 *
 *
 * @phpstan-type INSERT_POST array{
 *      ID?: int,
 *      post_author: int,
 *      post_date: string,
 *      post_date_gmt: string,
 *      post_content: string,
 *      post_content_filtered: string,
 *      post_title: string,
 *      post_excerpt: string,
 *      post_status: Wp_Insert_Post::STATUS_*,
 *      post_type: string,
 *      comment_status: Wp_Insert_Post::PING_*,
 *      ping_status: Wp_Insert_Post::PING_*,
 *      post_password: string,
 *      post_name: string,
 *      to_ping: string,
 *      pinged: string,
 *      post_modified: string,
 *      post_modified_gmt: string,
 *      post_parent: int,
 *      menu_order: int,
 *      post_mime_type: string,
 *      guid: string
 * }
 *
 * @implements ArgsRules<\Partial<INSERT_POST>>
 */
class Wp_Insert_Post implements ArgsRules {
	/**
	 * @use Args<\Partial<INSERT_POST>>
	 */
	use Args;

	public const PING_OPEN   = 'open';
	public const PING_CLOSED = 'closed';

	public const STATUS_DRAFT   = 'draft';
	public const STATUS_FUTURE  = 'future';
	public const STATUS_INHERIT = 'inherit';
	public const STATUS_PENDING = 'pending';
	public const STATUS_PRIVATE = 'private';
	public const STATUS_PUBLISH = 'publish';
	public const STATUS_TRASH   = 'trash';

	/**
	 * The post ID. If equal to something other than 0, the post with that ID will be updated.
	 *
	 * Default 0.
	 *
	 * @var int
	 */
	public int $ID;

	/**
	 * The ID of the user who added the post.
	 *
	 * Default is the current user ID.
	 *
	 * @var int
	 */
	public int $post_author;

	/**
	 * The date of the post.
	 *
	 * Default is the current time.
	 *
	 * @var string
	 */
	public string $post_date;

	/**
	 * The date of the post in the GMT timezone.
	 *
	 * Default is the value of `$post_date`.
	 *
	 * @var string
	 */
	public string $post_date_gmt;

	/**
	 * The post content.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $post_content;

	/**
	 * The filtered post content.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $post_content_filtered;

	/**
	 * The post title.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $post_title;

	/**
	 * The post excerpt.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $post_excerpt;

	/**
	 * The post status.
	 *
	 * Default 'draft'.
	 *
	 * @phpstan-var self::STATUS_*
	 * @var string
	 */
	public string $post_status;

	/**
	 * The post type.
	 *
	 * Default 'post'.
	 *
	 * @var string
	 */
	public string $post_type;

	/**
	 * Whether the post can accept comments. Accepts 'open' or 'closed'.
	 *
	 * Default is the value of 'default_comment_status' option.
	 *
	 * @phpstan-var self::PING_*
	 *
	 * @var string
	 */
	public string $comment_status;

	/**
	 * Whether the post can accept pings. Accepts 'open' or 'closed'.
	 *
	 * Default is the value of 'default_PING' option.
	 *
	 * @phpstan-var self::PING_*
	 *
	 * @var string
	 */
	public string $ping_status;

	/**
	 * The password to access the post.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $post_password;

	/**
	 * The post name.
	 *
	 * Default is the sanitized post title when creating a new post.
	 *
	 * @var string
	 */
	public string $post_name;

	/**
	 * Space or carriage return-separated list of URLs to ping.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $to_ping;

	/**
	 * Space or carriage return-separated list of URLs that have been pinged.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $pinged;

	/**
	 * The date when the post was last modified.
	 *
	 * Default is the current time.
	 *
	 * @var string
	 */
	public string $post_modified;

	/**
	 * The date when the post was last modified in the GMT timezone.
	 *
	 * Default is the current time.
	 *
	 * @var string
	 */
	public string $post_modified_gmt;

	/**
	 * Set this for the post it belongs to, if any.
	 *
	 * Default 0.
	 *
	 * @var int
	 */
	public int $post_parent;

	/**
	 * The order the post should be displayed in.
	 *
	 * Default 0.
	 *
	 * @var int
	 */
	public int $menu_order;

	/**
	 * The mime type of the post.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $post_mime_type;

	/**
	 * Global Unique ID for referencing the post.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $guid;

	/**
	 * Page template to use.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $page_template;

	/**
	 * Array of category IDs.
	 *
	 * Defaults to value of the 'default_category' option.
	 *
	 * @var array<int,int>
	 */
	public array $post_category;

	/**
	 * Array of tag names, slugs, or IDs.
	 *
	 * Default empty.
	 *
	 * @var array<int,(int|string)>
	 */
	public array $tags_input;

	/**
	 * Array of taxonomy terms keyed by their taxonomy name.
	 *
	 * Default empty.
	 *
	 * @var array<string,mixed>
	 */
	public array $tax_input;

	/**
	 * Array of post meta values keyed by their post meta key.
	 *
	 * Default empty.
	 *
	 * @var array<string,mixed>
	 */
	public array $meta_input;

	/**
	 *  The post ID to be used when inserting a new post. If specified, must not match any existing post ID.
	 *
	 * Default 0.
	 *
	 * @var int
	 */
	public int $import_id;
}
