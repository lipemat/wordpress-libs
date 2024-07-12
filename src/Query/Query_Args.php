<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query;

use Lipe\Lib\Query\Clause\Date_Query_Interface;
use Lipe\Lib\Query\Clause\Date_Query_Trait;
use Lipe\Lib\Query\Clause\Meta_Query_Interface;
use Lipe\Lib\Query\Clause\Meta_Query_Trait;
use Lipe\Lib\Query\Clause\Tax_Query_Interface;
use Lipe\Lib\Query\Clause\Tax_Query_Trait;

/**
 * A fluent interface for constructing a `\WP_Query`.
 *
 * Inspired by 'johnbillion/args', but done in our usual chained way.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @see    \WP_Query
 *
 * @link   https://developer.wordpress.org/reference/classes/wp_query/
 * @link   https://developer.wordpress.org/reference/classes/WP_Query/parse_query/
 */
class Query_Args implements Meta_Query_Interface, Date_Query_Interface, Args_Interface, Tax_Query_Interface {
	/**
	 * @use Args_Trait<array<string, mixed>>
	 */
	use Args_Trait;
	use Date_Query_Trait;
	use Meta_Query_Trait;
	use Tax_Query_Trait;

	public const FIELDS_IDS       = 'ids';
	public const FIELDS_ID_PARENT = 'id=>parent';
	public const FIELDS_COMPLETE  = '';

	public const ORDER_ASC  = 'ASC';
	public const ORDER_DESC = 'DESC';

	public const ORDERBY_NONE          = 'none';
	public const ORDERBY_NAME          = 'name';
	public const ORDERBY_AUTHOR        = 'author';
	public const ORDERBY_DATE          = 'date';
	public const ORDERBY_TITLE         = 'title';
	public const ORDERBY_MODIFIED      = 'modified';
	public const ORDERBY_MENU_ORDER    = 'menu_order';
	public const ORDERBY_PARENT        = 'parent';
	public const ORDERBY_ID            = 'ID';
	public const ORDERBY_RAND          = 'rand';
	public const ORDERBY_RELEVANCE     = 'relevance';
	public const ORDERBY_COMMENT_COUNT = 'comment_count';
	public const ORDERBY_META_VALUE    = 'meta_value';
	public const ORDERBY_POST_IN       = 'post__in';
	public const ORDERBY_NAME_IN       = 'post_name__in';
	public const ORDERBY_PARENT_IN     = 'post_parent__in';

	public const STATUS_ANY        = 'any';
	public const STATUS_AUTO_DRAFT = 'auto-draft';
	public const STATUS_DRAFT      = 'draft';
	public const STATUS_FUTURE     = 'future';
	public const STATUS_INHERIT    = 'inherit';
	public const STATUS_PENDING    = 'pending';
	public const STATUS_PRIVATE    = 'private';
	public const STATUS_PUBLISH    = 'publish';
	public const STATUS_TRASH      = 'trash';

	/**
	 * Attachment post ID. Used for 'attachment' post_type.
	 *
	 * @var int
	 */
	public int $attachment_id;

	/**
	 * Author ID, or comma-separated list of IDs.
	 *
	 * @var int|string
	 */
	public $author;

	/**
	 * User 'user_nicename'.
	 *
	 * @var string
	 */
	public string $author_name;

	/**
	 * An array of author IDs to query from.
	 *
	 * @var array<int, int>
	 */
	public array $author__in;

	/**
	 * An array of author IDs not to query from.
	 *
	 * @var array<int, int>
	 */
	public array $author__not_in;

	/**
	 * Whether to cache post information.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $cache_results;

	/**
	 * Filter results by comment count.
	 *
	 * Provide an integer to match comment count exactly. Provide an array with integer 'value' and 'compare' operator
	 * ('=', '!=', '>', '>=', '<', '<=' ) to compare against comment_count in a specific way.
	 *
	 * @phpstan-var array{
	 *     value: int,
	 *     'compare':'='|'!='|'>'|'>='|'<'|'<=',
	 * }|int
	 *
	 * @var array<string,(int|string)>|int
	 */
	public $comment_count;

	/**
	 * Comment status.
	 *
	 * @phpstan-var 'open'|'closed'
	 *
	 * @var string
	 */
	public string $comment_status;

	/**
	 * The number of comments to return per page.
	 *
	 * Default 'comments_per_page' option.
	 *
	 * @var int
	 */
	public int $comments_per_page;

	/**
	 * Day of the month.
	 *
	 * Default empty. Accepts numbers 1-31.
	 *
	 * @phpstan-var int<1, 31>
	 *
	 * @var int
	 */
	public int $day;

	/**
	 * Whether to search by an exact keyword.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $exact;

	/**
	 * Post fields to query for.
	 *
	 * Accepts:
	 *
	 *   - '' Returns an array of complete post objects (`WP_Post[]`).
	 *   - 'ids' Returns an array of post IDs (`int[]`).
	 *   - 'id=>parent' Returns an associative array of parent post IDs, keyed by post ID (`int[]`).
	 *
	 * Default ''.
	 *
	 * @phpstan-var static::FIELDS_*
	 *
	 * @var string
	 */
	public string $fields;

	/**
	 * Hour of the day.
	 *
	 * Default empty. Accepts numbers 0-23.
	 *
	 * @phpstan-var int<0, 23>
	 *
	 * @var int
	 */
	public int $hour;

	/**
	 * Whether to ignore sticky posts or not. Setting this to false excludes stickies from 'post__in'.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $ignore_sticky_posts;

	/**
	 * Combination YearMonth. Accepts any four-digit year and month numbers 1-12.
	 *
	 * Default empty.
	 *
	 * @var int
	 */
	public int $m;

	/**
	 * The menu order of the posts.
	 *
	 * @var int
	 */
	public int $menu_order;

	/**
	 * Second of the minute.
	 *
	 * Default empty. Accepts numbers 0-59.
	 *
	 * @phpstan-var int<0, 59>
	 *
	 * @var int
	 */
	public int $minute;

	/**
	 * The two-digit month.
	 *
	 * Default empty. Accepts numbers 1-12.
	 *
	 * @phpstan-var int<1, 12>
	 *
	 * @var int
	 */
	public int $monthnum;

	/**
	 * Post slug.
	 *
	 * @var string
	 */
	public string $name;

	/**
	 * Show all posts (true) or paginate (false).
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $nopaging;

	/**
	 * Whether to skip counting the total rows found. Enabling can improve performance.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $no_found_rows;

	/**
	 * The number of posts to offset before retrieval.
	 *
	 * @var int
	 */
	public int $offset;

	/**
	 * Designates ascending or descending order of posts.
	 *
	 * Default 'DESC'. Accepts 'ASC', 'DESC'.
	 *
	 * @phpstan-var self::ORDER_*
	 *
	 * @var string
	 */
	public string $order;

	/**
	 * Sort retrieved posts by a parameter. One or more options may be passed.
	 *
	 * To use 'meta_value', or 'meta_value_num', 'meta_key=keyname' must be also be defined. To sort by a specific
	 * `$meta_query` clause, use that clause's array key.
	 *
	 * Accepts:
	 *
	 *   - 'none'
	 *   - 'name'
	 *   - 'author'
	 *   - 'date'
	 *   - 'title'
	 *   - 'modified'
	 *   - 'menu_order'
	 *   - 'parent'
	 *   - 'ID'
	 *   - 'rand'
	 *   - 'relevance'
	 *   - 'RAND(x)' (where 'x' is an integer seed value)
	 *   - 'comment_count'
	 *   - 'meta_value'
	 *   - 'meta_value_num'
	 *   - 'post__in'
	 *   - 'post_name__in'
	 *   - 'post_parent__in'
	 *   - The array keys of `$meta_query`
	 *
	 * Default is 'date', except when a search is being performed, when the default is 'relevance'.
	 *
	 * @phpstan-var static::ORDERBY*|array<int, static::ORDERBY*>|string|array<int,string>
	 *
	 * @var string|array<int,string>
	 */
	public $orderby;

	/**
	 * Post ID.
	 *
	 * @var int
	 */
	public int $p;

	/**
	 * Show the number of posts that would show up on page X of a static front page.
	 *
	 * @var int
	 */
	public int $page;

	/**
	 * The number of the current page.
	 *
	 * @var int
	 */
	public int $paged;

	/**
	 * Page ID.
	 *
	 * @var int
	 */
	public int $page_id;

	/**
	 * Page slug.
	 *
	 * @var string;
	 */
	public string $pagename;

	/**
	 * Show posts if user has the appropriate capability.
	 *
	 * @phpstan-var 'readable'|'editable'
	 *
	 * @var string
	 */
	public string $perm;

	/**
	 * Ping status.
	 *
	 * @phpstan-var 'open'|'closed'
	 *
	 * @var string
	 */
	public string $ping_status;

	/**
	 * An array of post IDs to retrieve, sticky posts will be included.
	 *
	 * @var array<int, int>
	 */
	public array $post__in;

	/**
	 * An array of post IDs not to retrieve.
	 *
	 * @var array<int, int>
	 */
	public array $post__not_in;

	/**
	 * The mime type of the post. Used for 'attachment' post_type.
	 *
	 * @var string
	 */
	public string $post_mime_type;

	/**
	 * An array of post slugs that results must match.
	 *
	 * @var array<int, string>
	 */
	public array $post_name__in;

	/**
	 * Page ID to retrieve child pages for. Use 0 to only retrieve top-level pages.
	 *
	 * @var int
	 */
	public int $post_parent;

	/**
	 * An array containing parent page IDs to query child pages from.
	 *
	 * @var array<int, int>
	 */
	public array $post_parent__in;

	/**
	 * An array containing parent page IDs not to query child pages from.
	 *
	 * @var array<int, int>
	 */
	public array $post_parent__not_in;

	/**
	 * A post type slug (string) or array of post type slugs.
	 *
	 * Default 'any' if using 'tax_query'.
	 *
	 * @var string|array<int, string>
	 */
	public $post_type;

	/**
	 * A post status (string) or array of post statuses.
	 *
	 * @phpstan-var static::STATUS_*|array<int, static::STATUS_*>
	 *
	 * @var string|array<int, string>
	 */
	public $post_status;

	/**
	 * The number of posts to query for. Use -1 to request all posts.
	 *
	 * @phpstan-var positive-int | -1
	 *
	 * @var int
	 */
	public int $posts_per_page;

	/**
	 * The number of posts to query for by archive page. Overrides 'posts_per_page' when is_archive(), or is_search()
	 * are true.
	 *
	 * @phpstan-var positive-int | -1
	 *
	 * @var int
	 */
	public int $posts_per_archive_page;

	/**
	 * Search keyword(s).
	 *
	 * Prepending a term with a hyphen will exclude posts matching that term. Eg, 'pillow -sofa' will return posts
	 * containing 'pillow' but not 'sofa'.
	 *
	 * The character used for exclusion can be modified using the the 'wp_query_search_exclusion_prefix' filter.
	 *
	 * @var string
	 */
	public string $s;

	/**
	 * Second of the minute.
	 *
	 * Default empty. Accepts numbers 0-59.
	 *
	 * @phpstan-var int<0, 59>
	 *
	 * @var int
	 */
	public int $second;

	/**
	 * Whether to search by a phrase.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $sentence;

	/**
	 * Whether to suppress filters.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $suppress_filters;

	/**
	 * Post title.
	 *
	 * @var string
	 */
	public string $title;

	/**
	 * Whether to update the post meta cache.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $update_post_meta_cache;

	/**
	 * Whether to update the post term cache.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $update_post_term_cache;

	/**
	 * Whether to update the menu item cache.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $update_menu_item_cache;

	/**
	 * Whether to lazy-load term meta. Setting to false will disable cache priming for term meta, so that each
	 * get_term_meta() call will hit the database.
	 *
	 * Defaults to the value of `$update_post_term_cache`.
	 *
	 * @var bool
	 */
	public bool $lazy_load_term_meta;

	/**
	 * The week number of the year.
	 *
	 * Default empty. Accepts numbers 0-53.
	 *
	 * @phpstan-var int<0, 53>
	 *
	 * @var int
	 */
	public int $w;

	/**
	 * The four-digit year.
	 *
	 * Default empty. Accepts any four-digit year.
	 *
	 * @var int
	 */
	public int $year;


	/**
	 * Orderby a basic field.
	 *
	 * For more advanced fields, use the property directly.
	 *
	 * Accepted values are:
	 *
	 *   - 'none'
	 *   - 'name'
	 *   - 'author'
	 *   - 'date'
	 *   - 'title'
	 *   - 'modified'
	 *   - 'menu_order'
	 *   - 'parent'
	 *   - 'ID'
	 *   - 'rand'
	 *   - 'relevance'
	 *   - 'comment_count'
	 *   - 'meta_value'
	 *   - 'post__in'
	 *   - 'post_name__in'
	 *   - 'post_parent__in'
	 *
	 * @phpstan-param self::ORDERBY*|array<int,self::ORDERBY*> $orderby
	 * @phpstan-param self::ORDER_*|''                         $order
	 *
	 * @param array|string                                     $orderby - Post field to order by.
	 * @param string                                           $order   - Optional order of the order by.
	 *
	 * @throws \LogicException - If field ordering by is not available.
	 *
	 * @return void
	 */
	public function orderby( array|string $orderby, string $order = '' ): void {
		if ( \in_array( static::ORDERBY_POST_IN, (array) $orderby, true ) ) {
			if ( ! isset( $this->post__in ) || [] === $this->post__in ) {
				throw new \LogicException( esc_html__( 'You cannot order by `post__in` unless you specify the post ins.', 'lipe' ) );
			}
		} elseif ( \in_array( static::ORDERBY_NAME_IN, (array) $orderby, true ) ) {
			if ( ! isset( $this->post__name__in ) || [] === $this->post__name__in ) {
				throw new \LogicException( esc_html__( 'You cannot order by `post__name__in` unless you specify the post name ins.', 'lipe' ) );
			}
		} elseif ( \in_array( static::ORDERBY_PARENT_IN, (array) $orderby, true ) ) {
			if ( ! isset( $this->post_parent__in ) || [] === $this->post_parent__in ) {
				throw new \LogicException( esc_html__( 'You cannot order by `post_parent__in` unless you specify the post parent ins.', 'lipe' ) );
			}
		}

		$this->orderby = $orderby;
		if ( '' !== $order ) {
			$this->order = $order;
		}
	}


	/**
	 * Merge the arguments in this class with an existing
	 * `\WP_Query` class.
	 *
	 * For usage with `pre_get_posts` and similar.
	 *
	 * @param \WP_Query $query - The existing query to merge with.
	 *
	 * @return void
	 */
	public function merge_query( \WP_Query $query ): void {
		foreach ( $query->query as $arg => $value ) {
			if ( '' !== $value && \property_exists( $this, $arg ) && ! isset( $this->{$arg} ) ) {
				$this->{$arg} = $value;
			}
		}
		$local_args = $this->get_args();
		$query->query = \array_merge( $query->query, $local_args );
		$query->query_vars = \array_merge( $query->query_vars, $local_args );
	}


	/**
	 * Get the lightest possible version of the Query args.
	 *
	 * @see Utils::get_light_query_args()
	 *
	 * @return array<string, mixed>
	 */
	public function get_light_args(): array {
		return Utils::in()->get_light_query_args( $this->get_args() );
	}
}
