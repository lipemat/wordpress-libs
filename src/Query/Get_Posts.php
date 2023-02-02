<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query;

/**
 * A fluent interface for calling `get_posts`.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @see get_posts()
 *
 * @link https://developer.wordpress.org/reference/functions/get_posts/
 */
class Get_Posts extends Args {
	/**
	 * Total number of posts to retrieve. Is an alias of `$posts_per_page` in `WP_Query`.
	 *
	 * Accepts -1 for all.
	 *
	 * Default 5.
	 *
	 * @phpstan-var positive-int|-1
	 *
	 * @var int
	 */
	public int $numberposts;

	/**
	 * Category ID or comma-separated list of IDs (this or any children). Is an alias of `$cat` in `WP_Query`.
	 *
	 * Default 0.
	 *
	 * @var int|string
	 */
	public $category;

	/**
	 * An array of post IDs to retrieve, sticky posts will be included. Is an alias of `$post__in` in `WP_Query`.
	 *
	 * Default empty array.
	 *
	 * @var array<int, int>
	 */
	public array $include;

	/**
	 * An array of post IDs not to retrieve.
	 *
	 * Default empty array.
	 *
	 * @var array<int, int>
	 */
	public array $exclude;

	/**
	 * Whether to suppress filters.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $suppress_filters;
}
