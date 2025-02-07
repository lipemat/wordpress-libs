<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Args\Clause;
use Lipe\Lib\Args\ClauseRules;

/**
 * Generate a `meta_query` argument for various WP queries.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @link   https://developer.wordpress.org/reference/classes/wp_query/#custom-field-post-meta-parameters
 *
 * @implements  ClauseRules<Meta_Query>
 *
 * @internal
 */
class Meta_Query implements ClauseRules {
	/**
	 * Pass generic to trait.
	 *
	 * @use Clause<Meta_Query>
	 */
	use Clause;

	/**
	 * Compare in meta clauses.
	 */
	public const COMPARE_BETWEEN                = 'BETWEEN';
	public const COMPARE_EQUALS                 = '=';
	public const COMPARE_EXISTS                 = 'EXISTS';
	public const COMPARE_GREATER_THAN           = '>';
	public const COMPARE_GREATER_THAN_OR_EQUALS = '>=';
	public const COMPARE_IN                     = 'IN';
	public const COMPARE_LESS_THAN              = '<';
	public const COMPARE_LESS_THAN_OR_EQUALS    = '<=';
	public const COMPARE_LIKE                   = 'LIKE';
	public const COMPARE_NONE                   = '';
	public const COMPARE_NOT_BETWEEN            = 'NOT BETWEEN';
	public const COMPARE_NOT_EQUALS             = '!=';
	public const COMPARE_NOT_EXISTS             = 'NOT EXISTS';
	public const COMPARE_NOT_IN                 = 'NOT IN';
	public const COMPARE_NOT_LIKE               = 'NOT LIKE';
	public const COMPARE_NOT_REGEXP             = 'NOT REGEXP';
	public const COMPARE_REGEXP                 = 'REGEXP';
	public const COMPARE_RLIKE                  = 'RLIKE';

	/**
	 * `compare_key` is used to compare meta keys in advanced ways
	 * such as `meta_key LIKE %product%`.
	 *
	 * Default is 'IN' when `meta_key` is an array, '=' otherwise.
	 *
	 * @see \WP_Meta_Query::__construct
	 */
	public const KEY_EQUALS     = '=';
	public const KEY_EXISTS     = 'EXISTS';
	public const KEY_IN         = 'IN';
	public const KEY_LIKE       = 'LIKE';
	public const KEY_NONE       = '';
	public const KEY_NOT_EQUALS = '!=';
	public const KEY_NOT_EXISTS = 'NOT EXISTS';
	public const KEY_NOT_IN     = 'NOT IN';
	public const KEY_NOT_LIKE   = 'NOT LIKE';
	public const KEY_NOT_REGEXP = 'NOT REGEXP';
	public const KEY_REGEXP     = 'REGEXP';
	public const KEY_RLIKE      = 'RLIKE';

	/**
	 * Data types.
	 */
	public const TYPE_BINARY   = 'BINARY';
	public const TYPE_CHAR     = 'CHAR';
	public const TYPE_DATE     = 'DATE';
	public const TYPE_DATETIME = 'DATETIME';
	public const TYPE_DECIMAL  = 'DECIMAL';
	public const TYPE_NONE     = '';
	public const TYPE_NUMERIC  = 'NUMERIC';
	public const TYPE_SIGNED   = 'SIGNED';
	public const TYPE_TIME     = 'TIME';
	public const TYPE_UNSIGNED = 'UNSIGNED';


	/**
	 * Create an '=' clause.
	 *
	 * @param string|string[] $key   - Meta key(s) to query.
	 * @param string          $value - Meta value to query.
	 *
	 * @return Meta_Query
	 */
	public function equals( $key, string $value ): Meta_Query {
		$this->add_clause( $value, $key, '=' );
		return $this;
	}


	/**
	 * Create an '!=' clause.
	 *
	 * @param string|string[] $key   - Meta key(s) to query.
	 * @param string          $value - Meta value to exclude results from.
	 *
	 * @return Meta_Query
	 */
	public function not_equals( $key, string $value ): Meta_Query {
		$this->add_clause( $value, $key, '!=' );
		return $this;
	}


	/**
	 * Create an '>' clause.
	 *
	 * @param string|string[] $key   - Meta key(s) to query.
	 * @param string          $value - Meta value to query.
	 *
	 * @return Meta_Query
	 */
	public function greater_than( $key, string $value ): Meta_Query {
		$this->add_clause( $value, $key, '>' );
		return $this;
	}


	/**
	 * Create an '>=' clause.
	 *
	 * @param string|string[] $key   - Meta key(s) to query.
	 * @param string          $value - Meta value to query.
	 *
	 * @return Meta_Query
	 */
	public function greater_than_or_equal( $key, string $value ): Meta_Query {
		$this->add_clause( $value, $key, '>=' );
		return $this;
	}


	/**
	 * Create an '<' clause.
	 *
	 * @param string|string[] $key   - Meta key(s) to query.
	 * @param string          $value - Meta value to query.
	 *
	 * @return Meta_Query
	 */
	public function less_than( $key, string $value ): Meta_Query {
		$this->add_clause( $value, $key, '<' );
		return $this;
	}


	/**
	 * Create an '<=' clause.
	 *
	 * @param string|string[] $key   - Meta key(s) to query.
	 * @param string          $value - Meta value to query.
	 *
	 * @return Meta_Query
	 */
	public function less_than_or_equal( $key, string $value ): Meta_Query {
		$this->add_clause( $value, $key, '<=' );
		return $this;
	}


	/**
	 * Create a 'LIKE' clause.
	 *
	 * @param string|string[] $key   - Meta key(s) to query.
	 * @param string          $value - Meta value to query.
	 *
	 * @return Meta_Query
	 */
	public function like( $key, string $value ): Meta_Query {
		$this->add_clause( $value, $key, 'LIKE' );
		return $this;
	}


	/**
	 * Create a 'NOT LIKE' clause.
	 *
	 * @param string|string[] $key   - Meta key(s) to query.
	 * @param string          $value - Meta value to exculde results from.
	 *
	 * @return Meta_Query
	 */
	public function not_like( $key, string $value ): Meta_Query {
		$this->add_clause( $value, $key, 'NOT LIKE' );
		return $this;
	}


	/**
	 * Create an 'IN' clause.
	 *
	 * @param string|string[]   $key    - Meta key(s) to query.
	 * @param array<int,string> $values - Meta values to query.
	 *
	 * @return Meta_Query
	 */
	public function in( $key, array $values ): Meta_Query {
		$this->add_clause( $values, $key, 'IN' );
		return $this;
	}


	/**
	 * Create a 'NOT IN' clause.
	 *
	 * @param string|string[]   $key    - Meta key(s) to query.
	 * @param array<int,string> $values - Meta values to exclude results from.
	 *
	 * @return Meta_Query
	 */
	public function not_in( $key, array $values ): Meta_Query {
		$this->add_clause( $values, $key, 'NOT IN' );
		return $this;
	}


	/**
	 * Create a 'BETWEEN' clause.
	 *
	 * @param string|string[]   $key    - Meta key(s) to query.
	 * @param array<int,string> $values - Meta values to query.
	 *
	 * @return Meta_Query
	 */
	public function between( $key, array $values ): Meta_Query {
		$this->add_clause( $values, $key, 'BETWEEN' );
		return $this;
	}


	/**
	 * Create a 'BETWEEN' clause.
	 *
	 * @param string|string[]   $key    - Meta key(s) to query.
	 * @param array<int,string> $values - Meta values to exclude results from.
	 *
	 * @return Meta_Query
	 */
	public function not_between( $key, array $values ): Meta_Query {
		$this->add_clause( $values, $key, 'NOT BETWEEN' );
		return $this;
	}


	/**
	 * Create an 'EXISTS' clause.
	 *
	 * @param string|string[] $key - Meta key(s) to query.
	 *
	 * @return Meta_Query
	 */
	public function exists( $key ): Meta_Query {
		$this->add_clause( '', $key, 'EXISTS' );
		return $this;
	}


	/**
	 * Create a 'NOT EXISTS' clause.
	 *
	 * @param string|string[] $key - Meta key(s) to exclude results from.
	 *
	 * @return Meta_Query
	 */
	public function not_exists( $key ): Meta_Query {
		$this->add_clause( '', $key, 'NOT EXISTS' );
		return $this;
	}


	/**
	 * Advanced configuration for the current clause.
	 *
	 * `type` - the MySQL data type, which the provided value will be cast to.
	 *
	 * `compare_key` - allows for advanced compares against the meta key such as
	 * `meta_key LIKE %product_%`.
	 * Defaults to `IN` if the key is an array, otherwise `=`.
	 *
	 * `type_key` - MySQL data type the meta key CAST to for comparison.
	 * Accepts 'BINARY' for case-sensitive regular expression comparisons.
	 *
	 * @phpstan-param static::TYPE_*         $type
	 * @phpstan-param static::KEY_*          $compare_key
	 * @phpstan-param ''|static::TYPE_BINARY $type_key
	 *
	 * @param string                         $type        - Type of data.
	 * @param string                         $compare_key - How to compare the meta_key.
	 * @param string                         $type_key    - Support `BINARY` meta key types.
	 *
	 * @throws \LogicException - If called before a clause is available.
	 *
	 * @return Meta_Query
	 */
	public function advanced( string $type = '', string $compare_key = '', string $type_key = '' ): Meta_Query {
		$current = \array_key_last( $this->clauses );
		if ( ! is_numeric( $current ) ) {
			throw new \LogicException( esc_html__( 'You must create a meta clause before you add advanced parameters to it!', 'lipe' ) );
		}
		$this->clauses[ $current ] = \array_merge(
			$this->clauses[ $current ],
			\array_filter( [
				'type'        => $type,
				'compare_key' => $compare_key,
				'type_key'    => $type_key,
			] )
		);
		return $this;
	}


	/**
	 * Flatten the finished clauses into the meta_query.
	 *
	 * @interal
	 *
	 * @param ArgsRules $args_class - The class to add the meta_query to.
	 *
	 * @throws \LogicException - If called with access to the `meta_query` property.
	 *
	 * @return void
	 */
	public function flatten( $args_class ): void {
		$this->extract_nested( $this->clauses, $this );
		if ( ! property_exists( $args_class, 'meta_query' ) ) {
			throw new \LogicException( esc_html__( 'The provided class does not support meta queries. Did you use the `Meta_Query_Trait`?', 'lipe' ) );
		}
		if ( ! isset( $args_class->meta_query ) ) {
			$args_class->meta_query = [];
		}
		$args_class->meta_query = \array_merge( $args_class->meta_query, $this->clauses );
	}


	/**
	 * Generate a clause for the meta query.
	 *
	 * @link          https://developer.wordpress.org/reference/classes/wp_query/#custom-field-post-meta-parameters
	 *
	 * @phpstan-param static::COMPARE_*        $compare
	 *
	 * @param string|int|array<int,string|int> $value   - Meta value(s) to query.
	 * @param string|string[]                  $key     - Meta key(s) to query.
	 * @param string                           $compare - Comparison operator.
	 *
	 * @return void
	 */
	protected function add_clause( string|int|array $value, string|array $key, string $compare ): void {
		$this->clauses[] = \array_filter( [
			'key'     => $key,
			'value'   => $value,
			'compare' => $compare,
		], fn( $value ) => ! \in_array( $value, [ [], '', 0, '0' ], true ) );
	}
}
