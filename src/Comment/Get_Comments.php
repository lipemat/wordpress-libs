<?php
declare( strict_types=1 );

namespace Lipe\Lib\Comment;

use Lipe\Lib\Query\Args_Interface;
use Lipe\Lib\Query\Args_Trait;
use Lipe\Lib\Query\Clause\Date_Query_Interface;
use Lipe\Lib\Query\Clause\Date_Query_Trait;
use Lipe\Lib\Query\Clause\Meta_Query_Interface;
use Lipe\Lib\Query\Clause\Meta_Query_Trait;

/**
 * A fluent interface for the `get_comments` function in WordPress.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @link   https://developer.wordpress.org/reference/classes/wp_comment_query/__construct/
 */
class Get_Comments implements Meta_Query_Interface, Date_Query_Interface, Args_Interface {
	use Args_Trait;
	use Date_Query_Trait;
	use Meta_Query_Trait;

	public const ORDERBY_AGENT        = 'comment_agent';
	public const ORDERBY_APPROVED     = 'comment_approved';
	public const ORDERBY_AUTHOR       = 'comment_author';
	public const ORDERBY_AUTHOR_EMAIL = 'comment_author_email';
	public const ORDERBY_AUTHOR_IP    = 'comment_author_IP';
	public const ORDERBY_AUTHOR_URL   = 'comment_author_url';
	public const ORDERBY_CONTENT      = 'comment_content';
	public const ORDERBY_DATE         = 'comment_date';
	public const ORDERBY_DATE_GMT     = 'comment_date_gmt';
	public const ORDERBY_ID           = 'comment_ID';
	public const ORDERBY_KARMA        = 'comment_karma';
	public const ORDERBY_PARENT       = 'comment_parent';
	public const ORDERBY_POST_ID      = 'comment_post_ID';
	public const ORDERBY_COMMENT_TYPE = 'comment_type';
	public const ORDERBY_USER_ID      = 'user_id';
	public const ORDERBY_COMMENT_IN   = 'comment__in';
	public const ORDERBY_META_VALUE   = 'meta_value';

	/**
	 * Comment author email address.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $author_email;

	/**
	 * Comment author URL.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $author_url;

	/**
	 * Array of author IDs to include comments for.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $author__in;

	/**
	 * Array of author IDs to exclude comments for.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $author__not_in;

	/**
	 * Array of comment IDs to include.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $comment__in;

	/**
	 * Array of comment IDs to exclude.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $comment__not_in;

	/**
	 * Whether to return a comment count (true) or array of comment objects (false).
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $count;

	/**
	 * Comment fields to return. Accepts 'ids' for comment IDs only or empty for all fields.
	 *
	 * Default empty.
	 *
	 * @phpstan-var 'ids' | ''
	 *
	 * @var string
	 */
	public string $fields;

	/**
	 * Array of IDs or email addresses of users whose unapproved comments will be returned by the query regardless of
	 * `$status`.
	 *
	 * Default empty.
	 *
	 * @var array<int,(int|string)>
	 */
	public array $include_unapproved;

	/**
	 * Karma score to retrieve matching comments for.
	 *
	 * Default empty.
	 *
	 * @var int
	 */
	public int $karma;

	/**
	 * Maximum number of comments to retrieve.
	 *
	 * Default empty (no limit).
	 *
	 * @var int
	 */
	public int $number;

	/**
	 * When used with `$number`, defines the page of results to return. When used with `$offset`, `$offset` takes
	 * precedence.
	 *
	 * Default 1.
	 *
	 * @var int
	 */
	public int $paged;

	/**
	 * Number of comments to offset the query. Used to build `LIMIT` clause.
	 *
	 * Default 0.
	 *
	 * @var int
	 */
	public int $offset;

	/**
	 * Whether to disable the `SQL_CALC_FOUND_ROWS` query.
	 *
	 * Default: true.
	 *
	 * @var bool
	 */
	public bool $no_found_rows;

	/**
	 * Field(s) to order comments by. To use 'meta_value' or 'meta_value_num', `$meta_key`
	 * must also be defined.
	 *
	 * To sort by a specific `$meta_query` clause, use that clause's array key.
	 *
	 * Accepts:
	 *
	 *   - 'comment_agent'
	 *   - 'comment_approved'
	 *   - 'comment_author'
	 *   - 'comment_author_email'
	 *   - 'comment_author_IP'
	 *   - 'comment_author_url'
	 *   - 'comment_content'
	 *   - 'comment_date'
	 *   - 'comment_date_gmt'
	 *   - 'comment_ID'
	 *   - 'comment_karma'
	 *   - 'comment_parent'
	 *   - 'comment_post_ID'
	 *   - 'comment_type'
	 *   - 'user_id'
	 *   - 'comment__in'
	 *   - 'meta_value'
	 *   - 'meta_value_num'
	 *   - the value of `$meta_key`
	 *   - the array keys of `$meta_query`
	 *   - an empty array or 'none' to disable `ORDER BY` clause.
	 *
	 * Default: 'comment_date_gmt'.
	 *
	 * @phpstan-var self::ORDERBY*|array<self::ORDERBY*>|string
	 *
	 * @var string|array<int,string>
	 */
	public $orderby;

	/**
	 * How to order retrieved comments. Accepts 'ASC', 'DESC'.
	 *
	 * Default: 'DESC'.
	 *
	 * @phpstan-var 'ASC'|'DESC'
	 *
	 * @var string
	 */
	public string $order;

	/**
	 * Parent ID of comment to retrieve children of.
	 *
	 * Default empty.
	 *
	 * @var int
	 */
	public int $parent;

	/**
	 * Array of parent IDs of comments to retrieve children for.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $parent__in;

	/**
	 * Array of parent IDs of comments *not* to retrieve children for.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $parent__not_in;

	/**
	 * Array of author IDs to retrieve comments for.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $post_author__in;

	/**
	 * Array of author IDs *not* to retrieve comments for.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $post_author__not_in;

	/**
	 * Limit results to those affiliated with a given post ID.
	 *
	 * Default 0.
	 *
	 * @var int
	 */
	public int $post_id;

	/**
	 * Array of post IDs to include affiliated comments for.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $post__in;

	/**
	 * Array of post IDs to exclude affiliated comments for.
	 *
	 * Default empty.
	 *
	 * @var array<int,int>
	 */
	public array $post__not_in;

	/**
	 * Post author ID to limit results by.
	 *
	 * Default empty.
	 *
	 * @var int
	 */
	public int $post_author;

	/**
	 * Post status or array of post statuses to retrieve affiliated comments for. Pass 'any' to match any value.
	 *
	 * Default empty.
	 *
	 * @var string|array<int,string>
	 */
	public $post_status;

	/**
	 * Post type or array of post types to retrieve affiliated comments for. Pass 'any' to match any value.
	 *
	 * Default empty.
	 *
	 * @var string|array<int,string>
	 */
	public $post_type;

	/**
	 * Post name to retrieve affiliated comments for.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $post_name;

	/**
	 * Post parent ID to retrieve affiliated comments for.
	 *
	 * Default empty.
	 *
	 * @var int
	 */
	public int $post_parent;

	/**
	 * Search term(s) to retrieve matching comments for.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $search;

	/**
	 * Comment statuses to limit results by. Accepts an array or space/comma-separated list of:
	 *
	 *   - 'hold' (`comment_status=0`)
	 *   - 'approve' (`comment_status=1`)
	 *   - 'all'
	 *   - a custom comment status
	 *
	 * Default 'all'.
	 *
	 * @var string|array<int,string>
	 */
	public $status;

	/**
	 * Include comments of a given type, or array of types. Accepts:
	 *
	 *   - 'comment'
	 *   - 'pings' (includes 'pingback' and 'trackback')
	 *   - any custom type string
	 *
	 * Default empty.
	 *
	 * @var string|array<int,string>
	 */
	public $type;

	/**
	 * Include comments from a given array of comment types.
	 *
	 * Default empty.
	 *
	 * @var array<int,string>
	 */
	public array $type__in;

	/**
	 * Exclude comments from a given array of comment types.
	 *
	 * Default empty.
	 *
	 * @var array<int,string>
	 */
	public array $type__not_in;

	/**
	 * Include comments for a specific user ID.
	 *
	 * Default empty.
	 *
	 * @var int
	 */
	public int $user_id;

	/**
	 * Whether to include comment descendants in the results.
	 *
	 *   - 'threaded' returns a tree, with each comment's children stored in a `children` property on the `WP_Comment`
	 *   object.
	 *   - 'flat' returns a flat array of found comments plus their children.
	 *   - Boolean `false` leaves out descendants.
	 *
	 * The parameter is ignored (forced to `false`) when `$fields` is 'ids' or 'counts'.
	 *
	 * Default: false.
	 *
	 * @phpstan-var false|'threaded'|'flat'
	 *
	 * @var false|string
	 */
	public $hierarchical;

	/**
	 * Unique cache key to be produced when this query is stored in an object cache.
	 *
	 * Default is 'core'.
	 *
	 * @var string
	 */
	public string $cache_domain;

	/**
	 * Whether to prime the metadata cache for found comments.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $update_comment_meta_cache;

	/**
	 * Whether to prime the cache for comment posts.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $update_comment_post_cache;


	/**
	 * Orderby a basic field.
	 *
	 * For more advanced fields, use the property directly.
	 *
	 * Accepted values are:
	 *   - 'comment_agent'
	 *   - 'comment_approved'
	 *   - 'comment_author'
	 *   - 'comment_author_email'
	 *   - 'comment_author_IP'
	 *   - 'comment_author_url'
	 *   - 'comment_content'
	 *   - 'comment_date'
	 *   - 'comment_date_gmt'
	 *   - 'comment_ID'
	 *   - 'comment_karma'
	 *   - 'comment_parent'
	 *   - 'comment_post_ID'
	 *   - 'comment_type'
	 *   - 'user_id'
	 *   - 'comment__in'
	 *   - 'meta_value'
	 *
	 * @phpstan-param self::ORDERBY*|array<int,self::ORDERBY*> $orderby
	 * @phpstan-param 'ASC'|'DESC'|''                          $order
	 *
	 * @param string|array                                     $orderby - Comment field to order by.
	 * @param string                                           $order   - Optional order of the order by.
	 *
	 * @throws \LogicException - If orderby has prerequisites not met.
	 *
	 * @return void
	 */
	public function orderby( $orderby, string $order = '' ): void {
		if ( \in_array( static::ORDERBY_COMMENT_IN, (array) $orderby, true ) ) {
			if ( empty( $this->comment__in ) ) {
				throw new \LogicException( esc_html__( 'You cannot order by `comment__in` unless you specify the comment ins.', 'lipe' ) );
			}
		} elseif ( \in_array( static::ORDERBY_META_VALUE, (array) $orderby, true ) ) {
			if ( empty( $this->meta_key ) ) {
				throw new \LogicException( esc_html__( 'You cannot order by `meta_value` unless you specify the `meta_key`.', 'lipe' ) );
			}
		}
		$this->orderby = $orderby;

		if ( '' !== $order ) {
			$this->order = $order;
		}
	}


	/**
	 * Merge the arguments in this class with an existing
	 * `\WP_Comment_Query` class.
	 *
	 * For usage with `pre_get_comments` and similar.
	 *
	 * @param \WP_Comment_Query $query - The existing query to merge with.
	 *
	 * @return void
	 */
	public function merge_query( \WP_Comment_Query $query ): void {
		foreach ( $query->query_vars as $arg => $value ) {
			if ( null === $value || '' === $value ) {
				continue;
			}
			if ( \property_exists( $this, $arg ) && ! isset( $this->{$arg} ) ) {
				if ( 'parent' === $arg ) {
					$value = (int) $value;
				}
				$this->{$arg} = $value;
			}
		}
		$query->query_vars = \array_merge( $query->query_vars, $this->get_args() );
	}


	/**
	 * Get the lightest possible version of the `get_comments` args.
	 *
	 * @return array
	 */
	public function get_light_args(): array {
		return \array_merge( [
			'update_comment_post_cache' => false,
			'update_comment_meta_cache' => false,
		], $this->get_args() );
	}
}
