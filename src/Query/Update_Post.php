<?php

declare( strict_types=1 );

namespace Lipe\Lib\Query;

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
 */
class Update_Post implements Args_Interface {
	use Args_Trait;

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
	 * @phpstan-var 'open'|'closed'
	 *
	 * @var string
	 */
	public string $comment_status;

	/**
	 * Whether the post can accept pings. Accepts 'open' or 'closed'.
	 *
	 * Default is the value of 'default_ping_status' option.
	 *
	 * @phpstan-var 'open'|'closed'
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
