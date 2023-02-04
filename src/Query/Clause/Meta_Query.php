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
 *
 * @phpstan-type TYPE 'NUMERIC'|'BINARY'|'CHAR'|'DATE'|'DATETIME'|'DECIMAL'|'SIGNED'|'TIME'|'UNSIGNED'|''
 * @phpstan-type COMPARE_OPERATOR '='|'!='|'>'|'>='|'<'|'<='
 * @phpstan-type COMPARE_WORD 'LIKE'|'NOT LIKE'|'IN'|'NOT IN'|'BETWEEN'|'NOT BETWEEN'|'EXISTS'|'NOT EXISTS'|''
 * @phpstan-type COMPARE_REGEX 'REGEXP'|'NOT REGEXP'|'RLIKE'
 * @phpstan-type CLAUSE array{
 *          key: string,
 *          value: string|int|array<int,string|int>,
 *          compare: COMPARE_OPERATOR|COMPARE_WORD|COMPARE_REGEX,
 *          type: TYPE
 *          }
 *
 */
class Meta_Query extends Clause_Abstract {
	/**
	 * Set the relation of the meta query.
	 *
	 * Defaults to 'AND'.
	 *
	 * @note Do not use with a single taxonomy array.
	 *
	 * @phpstan-param 'AND'|'OR' $relation
	 *
	 * @param string $relation
	 *
	 * @return Meta_Query
	 */
	public function relation( string $relation = 'AND' ) : Meta_Query {
		$this->clauses['relation'] = $relation;

		return $this;
	}


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
