<?php

namespace Lipe\Lib\Query;

/**
 * Generate a `tax_query` argument for a `WP_Query.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @internal
 *
 * @template Field of 'term_id'|'slug'|'name'|'term_taxonomy_id'|''
 *
 */
class Tax_Query {
	/**
	 * Main WP_Query args class.
	 *
	 * @var Args
	 */
	protected Args $args;

	/**
	 * Track the key in the clause array for sub queries.
	 *
	 * @var int|null
	 */
	protected ?int $clause_key;


	/**
	 * @param Args     $args - The Main WP_Query args class.
	 * @param int|null $clause_key - Used internally to track the level of query.
	 */
	final public function __construct( Args $args, ?int $clause_key = null ) {
		$this->clause_key = $clause_key;
		$this->args = $args;
	}


	/**
	 * Set the relation of the term query.
	 *
	 * Defaults to 'AND'.
	 *
	 * @note Do not use with a single taxonomy array.
	 *
	 * @phpstan-param 'AND'|'OR' $relation
	 *
	 * @param string $relation
	 *
	 * @return Tax_Query
	 */
	public function relation( string $relation = 'AND' ) : Tax_Query {
		if ( null !== $this->clause_key ) {
			$this->args->tax_query[ $this->clause_key ]['relation'] = $relation;
		} else {
			$this->args->tax_query['relation'] = $relation;
		}

		return $this;
	}


	/**
	 * Create an 'AND' clause.
	 *
	 * @phpstan-param Field     $field
	 *
	 * @param array<int|string> $value
	 * @param string            $taxonomy
	 * @param string            $field
	 *
	 * @return Tax_Query
	 */
	public function and( array $value, string $taxonomy, string $field = 'term_id' ) : Tax_Query {
		$this->add_clause( $value, $taxonomy, $field, 'AND' );
		return $this;
	}


	/**
	 * Create an 'IN' clause.
	 *
	 * @phpstan-param Field     $field
	 *
	 * @param array<int|string> $value
	 * @param string            $taxonomy
	 * @param string            $field
	 *
	 * @return Tax_Query
	 */
	public function in( array $value, string $taxonomy, string $field = 'term_id' ) : Tax_Query {
		$this->add_clause( $value, $taxonomy, $field, 'IN' );
		return $this;
	}


	/**
	 * Create a 'NOT IN' clause.
	 *
	 * @phpstan-param Field     $field
	 *
	 * @param array<int|string> $value
	 * @param string            $taxonomy
	 * @param string            $field
	 *
	 * @return Tax_Query
	 */
	public function not_in( array $value, string $taxonomy, string $field = 'term_id' ) : Tax_Query {
		$this->add_clause( $value, $taxonomy, $field, 'NOT IN' );
		return $this;
	}


	/**
	 * Create an 'EXISTS' clause.
	 *
	 * @param string $taxonomy
	 *
	 * @return Tax_Query
	 */
	public function exists( string $taxonomy ) : Tax_Query {
		$this->add_clause( '', $taxonomy, '', 'EXISTS' );
		return $this;
	}


	/**
	 * Create a 'NOT EXISTS' clause.
	 *
	 * @param string $taxonomy
	 *
	 * @return Tax_Query
	 */
	public function not_exists( string $taxonomy ) : Tax_Query {
		$this->add_clause( '', $taxonomy, '', 'NOT EXISTS' );
		return $this;
	}


	/**
	 * Generate a sub level query for nested queries.
	 *
	 * @see ArgsTest::test_tax_query() for example of the resulting array.
	 *
	 * @notice Do not use with a single taxonomy array.
	 *
	 * @return Tax_Query
	 */
	public function sub_query() : Tax_Query {
		if ( ! isset( $this->args->tax_query['relation'] ) ) {
			$this->relation();
		}
		$this->args->tax_query[] = [];
		$sub = new static( $this->args, \array_key_last( $this->args->tax_query ) );
		$sub->relation();

		return $sub;
	}


	/**
	 * Generate a clause for the term query.
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
	 *
	 *
	 * @phpstan-param 'AND'|'IN'|'NOT IN'|'EXISTS'|'NOT EXISTS' $operator
	 * @phpstan-param Field                    $field
	 *
	 * @param string|int|array<int,string|int> $value
	 * @param string                           $taxonomy
	 * @param string                           $field
	 * @param string                           $operator
	 *
	 * @return void
	 */
	protected function add_clause( $value, string $taxonomy, string $field, string $operator ) : void {
		$clause = \array_filter( [
			'taxonomy' => $taxonomy,
			'field'    => $field,
			'terms'    => $value,
			'operator' => $operator,
		] );

		if ( null !== $this->clause_key ) {
			$this->args->tax_query[ $this->clause_key ][] = $clause;
		} else {
			$this->args->tax_query[] = $clause;
		}
	}
}
