<?php
declare( strict_types=1 );

namespace Lipe\Lib\User;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Query\Clause\Meta_Query_Interface;
use Lipe\Lib\Query\Clause\Meta_Query_Trait;

/**
 * A fluent interface for the `get_users` function in WordPress.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @link   https://developer.wordpress.org/reference/classes/wp_user_query/prepare_query/
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Get_Users implements Meta_Query_Interface, ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;
	use Meta_Query_Trait;

	public const FIELD_ID           = 'ID';
	public const FIELD_DISPLAY_NAME = 'display_name';
	public const FIELD_LOGIN        = 'user_login';
	public const FIELD_NICENAME     = 'user_nicename';
	public const FIELD_EMAIL        = 'user_email';
	public const FIELD_URL          = 'user_url';
	public const FIELD_REGISTERED   = 'user_registered';

	public const ORDERBY_ID           = 'ID';
	public const ORDERBY_DISPLAY_NAME = 'display_name';
	public const ORDERBY_INCLUDE      = 'include';
	public const ORDERBY_LOGIN        = 'user_login';
	public const ORDERBY_LOGIN_IN     = 'login__in';
	public const ORDERBY_NICENAME     = 'user_nicename';
	public const ORDERBY_NICENAME_IN  = 'nicename__in';
	public const ORDERBY_EMAIL        = 'user_email';
	public const ORDERBY_URL          = 'user_url';
	public const ORDERBY_REGISTERED   = 'user_registered';
	public const ORDERBY_POST_COUNT   = 'post_count';
	public const ORDERBY_META_VALUE   = 'meta_value';

	/**
	 * The site ID.
	 *
	 * Default is the current site.
	 *
	 * @var int
	 */
	public int $blog_id;

	/**
	 * An array or a comma-separated list of role names that users must match to be included in results. Note that this
	 * is an inclusive list: users must match *each* role.
	 *
	 * Default empty.
	 *
	 * @var string|array<int,string>
	 */
	public $role;

	/**
	 * An array of role names. Matched users must have at least one of these roles.
	 *
	 * Default empty array.
	 *
	 * @var array<int,string>
	 */
	public array $role__in;

	/**
	 * An array of role names to exclude. Users matching one or more of these roles will not be included in results.
	 *
	 * Default empty array.
	 *
	 * @var array<int,string>
	 */
	public array $role__not_in;

	/**
	 * An array of user IDs to include.
	 *
	 * Default empty array.
	 *
	 * @var array<int,int>
	 */
	public array $include;

	/**
	 * An array of user IDs to exclude.
	 *
	 * Default empty array.
	 *
	 * @var array<int,int>
	 */
	public array $exclude;

	/**
	 * Search keyword. Searches for possible string matches on columns.
	 *
	 * When `$search_columns` is left empty, it tries to determine, which
	 * column to search in based on search string.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $search;

	/**
	 * Array of column names to be searched.
	 *
	 * Accepts: 'ID', 'user_login', 'user_email', 'user_url', 'user_nicename','display_name'.
	 *
	 * Default empty array.
	 *
	 * @phpstan-var array<int,static::FIELD*>
	 *
	 * @var array<int,string>
	 */
	public array $search_columns;

	/**
	 * Field(s) to sort the retrieved users by.
	 *
	 * A single value, an array of values, or a multidimensional
	 * array with fields as keys and orders ('ASC' or 'DESC') as values.
	 *
	 * Accepted values are:
	 *
	 *   - 'ID'
	 *   - 'display_name' (or 'name')
	 *   - 'include'
	 *   - 'user_login' (or 'login')
	 *   - 'login__in'
	 *   - 'user_nicename' (or 'nicename')
	 *   - 'nicename__in'
	 *   - 'user_email (or 'email')
	 *   - 'user_url' (or 'url')
	 *   - 'user_registered' (or 'registered')
	 *   - 'post_count'
	 *   - 'meta_value'
	 *   - 'meta_value_num'
	 *   - the value of `$meta_key`
	 *   - or an array key of `$meta_query`.
	 *
	 * To use 'meta_value' or 'meta_value_num', `$meta_key` must be also be defined.
	 *
	 * Default 'user_login'.
	 *
	 * @phpstan-var static::ORDERBY*|string
	 *
	 * @var string|array
	 */
	public $orderby;

	/**
	 * Designates ascending or descending order of users. Order values passed as part of an `$orderby` array take
	 * precedence over this parameter. Accepts 'ASC', 'DESC'.
	 *
	 * Default 'ASC'.
	 *
	 * @phpstan-var 'ASC'|'DESC'
	 *
	 * @var string
	 */
	public string $order;

	/**
	 * Amount users to offset in retrieved results.
	 *
	 * Can be used with pagination.
	 *
	 * Default 0.
	 *
	 * @var int
	 */
	public int $offset;

	/**
	 * Amount users to limit the query for.
	 *
	 * Can be used with pagination. Value -1 (all) is supported,
	 * but should be used with caution on larger sites.
	 *
	 * Default -1 (all users).
	 *
	 * @phpstan-var positive-int | -1
	 *
	 * @var int
	 */
	public int $number;

	/**
	 * When used with number, defines the page of results to return.
	 *
	 * Default 1.
	 *
	 * @phpstan-var positive-int
	 *
	 * @var int
	 */
	public int $paged;

	/**
	 * Whether to count the total number of users found. If pagination is not needed, setting this to false can improve
	 * performance.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $count_total;

	/**
	 * Which fields to return. Single or all fields (string), or array of fields.
	 *
	 * Accepts:
	 *
	 *   - 'ID'
	 *   - 'display_name'
	 *   - 'user_login'
	 *   - 'user_nicename'
	 *   - 'user_email'
	 *   - 'user_url'
	 *   - 'user_registered'
	 *
	 * Use 'all' for all fields and 'all_with_meta' to include meta fields.
	 *
	 * Default 'all'.
	 *
	 * @phpstan-var (static::FIELD*|'all'|'all_with_meta')|array<int,static::FIELD*>
	 *
	 * @var string|array<int, string>
	 */
	public $fields;

	/**
	 * User type to query. Accepts 'authors'.
	 *
	 * Default empty (all users).
	 *
	 * @phpstan-var 'authors'|''
	 *
	 * @var string
	 */
	public string $who;

	/**
	 * Pass an array of post types to filter results to users who have published posts in those post types.
	 *
	 * `true` is an alias for all public post types.
	 *
	 * @var true|array<int,string>
	 */
	public $has_published_posts;

	/**
	 * The user nicename.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $nicename;

	/**
	 * An array of nicenames to include.
	 *
	 * Users matching one of these nicenames will be included in results.
	 *
	 * Default empty array.
	 *
	 * @var array<int,string>
	 */
	public array $nicename__in;

	/**
	 * An array of nicenames to exclude.
	 *
	 * Users matching one of these nicenames will not be included in results.
	 *
	 * Default empty array.
	 *
	 * @var array<int,string>
	 */
	public array $nicename__not_in;

	/**
	 * The user login.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $login;

	/**
	 * An array of logins to include. Users matching one of these logins will be included in results.
	 *
	 * Default empty array.
	 *
	 * @var array<int,string>
	 */
	public array $login__in;

	/**
	 * An array of logins to exclude. Users matching one of these logins will not be included in results.
	 *
	 * Default empty array.
	 *
	 * @var array<int,string>
	 */
	public array $login__not_in;

	/**
	 * Whether to cache user information.
	 *
	 * Default `true`.
	 *
	 * @var bool
	 */
	public bool $cache_results;

	/**
	 * An array or a comma-separated list of capability names that users must match to be included in results.
	 *
	 * Note that this is an inclusive list: users must match *each* capability.
	 *
	 * Does NOT work for capabilities not in the database or filtered via {@see 'map_meta_cap'}.
	 *
	 * @var string|array<int,string>
	 */
	public $capability;

	/**
	 * An array of capability names. Matched users must have at least one of these capabilities.
	 *
	 * Does NOT work for capabilities not in the database or filtered via {@see 'map_meta_cap'}.
	 *
	 * @var array<int,string>
	 */
	public array $capability__in;

	/**
	 * An array of capability names to exclude. Users matching one or more of these capabilities will not be included
	 * in results.
	 *
	 * Does NOT work for capabilities not in the database or filtered via {@see 'map_meta_cap'}.
	 *
	 * @var array<int,string>
	 */
	public array $capability__not_in;


	/**
	 * Orderby a basic field.
	 *
	 * For more advanced fields, use the property directly.
	 *
	 * Accepted values are:
	 *
	 *   - 'ID'
	 *   - 'display_name'
	 *   - 'include'
	 *   - 'user_login'
	 *   - 'login__in'
	 *   - 'user_nicename'
	 *   - 'nicename__in'
	 *   - 'user_email
	 *   - 'user_url'
	 *   - 'user_registered'
	 *   - 'post_count'
	 *   - 'meta_value'
	 *
	 * @phpstan-param static::ORDERBY* $orderby
	 *
	 * @param string                   $orderby - User field to order by.
	 *
	 * @return void
	 */
	public function orderby( string $orderby ): void {
		$this->orderby = $orderby;
	}


	/**
	 * Merge the arguments in this class with an existing
	 * `\WP_User_Query` class.
	 *
	 * For usage with `pre_get_users` and similar.
	 *
	 * @param \WP_User_Query $query - The existing query to merge with.
	 *
	 * @return void
	 */
	public function merge_query( \WP_User_Query $query ): void {
		foreach ( $query->query_vars as $arg => $value ) {
			if ( '' !== $value && \property_exists( $this, $arg ) && ! isset( $this->{$arg} ) ) {
				$this->{$arg} = $value;
			}
		}
		$query->query_vars = \array_merge( $query->query_vars, $this->get_args() );
	}
}
