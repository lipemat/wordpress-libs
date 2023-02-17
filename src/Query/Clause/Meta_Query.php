<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

//phpcs:disable Squiz.Commenting.FunctionComment.SpacingAfterParamType

/**
 * Generate a `meta_query` argument for various WP queries.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @internal
 */
class Meta_Query extends Clause_Abstract {
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
	 * @phpstan-param TYPE $type
	 *
	 * @param string       $key
	 * @param int|string   $value
	 * @param string       $type
	 *
	 * @return Meta_Query
	 */
	public function equals( string $key, $value, string $type = '' ) : Meta_Query {
		$this->add_clause( $value, $key, '=', $type );
		return $this;
	}


	/**
	 * Create an '!=' clause.
	 *
	 * @phpstan-param TYPE $type
	 *
	 * @param string       $key
	 * @param int|string   $value
	 * @param string       $type
	 *
	 * @return Meta_Query
	 */
	public function not_equals( string $key, $value, string $type = '' ) : Meta_Query {
		$this->add_clause( $value, $key, '!=', $type );
		return $this;
	}


	/**
	 * Create an '>' clause.
	 *
	 * @phpstan-param TYPE $type
	 *
	 * @param string       $key
	 * @param int|string   $value
	 * @param string       $type
	 *
	 * @return Meta_Query
	 */
	public function greater_than( string $key, $value, string $type = '' ) : Meta_Query {
		$this->add_clause( $value, $key, '>', $type );
		return $this;
	}


	/**
	 * Create an '>=' clause.
	 *
	 * @phpstan-param TYPE $type
	 *
	 * @param string       $key
	 * @param int|string   $value
	 * @param string       $type
	 *
	 * @return Meta_Query
	 */
	public function greater_than_or_equal( string $key, $value, string $type = '' ) : Meta_Query {
		$this->add_clause( $value, $key, '>=', $type );
		return $this;
	}


	/**
	 * Create an '<' clause.
	 *
	 * @phpstan-param TYPE $type
	 *
	 * @param string       $key
	 * @param int|string   $value
	 * @param string       $type
	 *
	 * @return Meta_Query
	 */
	public function less_than( string $key, $value, string $type = '' ) : Meta_Query {
		$this->add_clause( $value, $key, '<', $type );
		return $this;
	}


	/**
	 * Create an '<=' clause.
	 *
	 * @phpstan-param TYPE $type
	 *
	 * @param string       $key
	 * @param int|string   $value
	 * @param string       $type
	 *
	 * @return Meta_Query
	 */
	public function less_than_or_equal( string $key, $value, string $type = '' ) : Meta_Query {
		$this->add_clause( $value, $key, '<=', $type );
		return $this;
	}


	/**
	 * Create a 'LIKE' clause.
	 *
	 * @phpstan-param TYPE $type
	 *
	 * @param string       $key
	 * @param int|string   $value
	 * @param string       $type
	 *
	 * @return Meta_Query
	 */
	public function like( string $key, $value, string $type = '' ) : Meta_Query {
		$this->add_clause( $value, $key, 'LIKE', $type );
		return $this;
	}


	/**
	 * Create a 'NOT LIKE' clause.
	 *
	 * @phpstan-param TYPE $type
	 *
	 * @param string       $key
	 * @param int|string   $value
	 * @param string       $type
	 *
	 * @return Meta_Query
	 */
	public function not_like( string $key, $value, string $type = '' ) : Meta_Query {
		$this->add_clause( $value, $key, 'NOT LIKE', $type );
		return $this;
	}


	/**
	 * Create an 'IN' clause.
	 *
	 * @phpstan-param TYPE      $type
	 *
	 * @param string            $key
	 * @param array<int|string> $values
	 * @param string            $type
	 *
	 * @return Meta_Query
	 */
	public function in( string $key, array $values, string $type = '' ) : Meta_Query {
		$this->add_clause( $values, $key, 'IN', $type );
		return $this;
	}


	/**
	 * Create a 'NOT IN' clause.
	 *
	 * @phpstan-param TYPE      $type
	 *
	 * @param string            $key
	 * @param array<int|string> $values
	 * @param string            $type
	 *
	 * @return Meta_Query
	 */
	public function not_in( string $key, array $values, string $type = '' ) : Meta_Query {
		$this->add_clause( $values, $key, 'NOT IN', $type );
		return $this;
	}


	/**
	 * Create a 'BETWEEN' clause.
	 *
	 * @phpstan-param TYPE      $type
	 *
	 * @param string            $key
	 * @param array<int|string> $values
	 * @param string            $type
	 *
	 * @return Meta_Query
	 */
	public function between( string $key, array $values, string $type = '' ) : Meta_Query {
		$this->add_clause( $values, $key, 'BETWEEN', $type );
		return $this;
	}


	/**
	 * Create a 'BETWEEN' clause.
	 *
	 * @phpstan-param TYPE      $type
	 *
	 * @param string            $key
	 * @param array<int|string> $values
	 * @param string            $type
	 *
	 * @return Meta_Query
	 */
	public function not_between( string $key, array $values, string $type = '' ) : Meta_Query {
		$this->add_clause( $values, $key, 'NOT BETWEEN', $type );
		return $this;
	}


	/**
	 * Create an 'EXISTS' clause.
	 *
	 * @param string $key
	 *
	 * @return Meta_Query
	 */
	public function exists( string $key ) : Meta_Query {
		$this->add_clause( '', $key, 'EXISTS', '' );
		return $this;
	}


	/**
	 * Create a 'NOT EXISTS' clause.
	 *
	 * @param string $key
	 *
	 * @return Meta_Query
	 */
	public function not_exists( string $key ) : Meta_Query {
		$this->add_clause( '', $key, 'NOT EXISTS', '' );
		return $this;
	}


	/**
	 * Flatten the finished clauses into the meta_query.
	 *
	 * @interal
	 *
	 * @param Meta_Query_Interface $args_class
	 *
	 * @return void
	 */
	public function flatten( $args_class ) : void {
		$this->extract_nested( $this->clauses, $this );
		$args_class->meta_query = $this->clauses;
	}


	/**
	 * Generate a clause for the meta query.
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_query/#custom-field-post-meta-parameters
	 *
	 *
	 * @phpstan-param COMPARE_OPERATOR|COMPARE_WORD|COMPARE_REGEX $compare
	 * @phpstan-param TYPE                                        $type
	 *
	 * @param string|int|array<int,string|int>                    $value
	 * @param string                                              $key
	 * @param string                                              $compare
	 * @param string                                              $type
	 *
	 * @return void
	 */
	protected function add_clause( $value, string $key, string $compare, string $type ) : void {
		$clause = \array_filter( \compact( 'key', 'value', 'compare', 'type' ) );
		$this->clauses[] = $clause;
	}
}
