<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Args\Clause;
use Lipe\Lib\Args\ClauseRules;

/**
 * Generate a `tax_query` argument for a `WP_Query.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @link   https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
 *
 * @implements ClauseRules<Tax_Query>
 *
 * @internal
 *
 */
class Tax_Query implements ClauseRules {
	/**
	 * Pass generic to trait.
	 *
	 * @use Clause<Tax_Query>
	 */
	use Clause;

	public const FIELD_ID          = 'term_id';
	public const FIELD_NAME        = 'name';
	public const FIELD_NONE        = '';
	public const FIELD_SLUG        = 'slug';
	public const FIELD_TERM_TAX_ID = 'term_taxonomy_id';


	/**
	 * Create an 'AND' clause.
	 *
	 * @phpstan-param static::FIELD_* $field
	 *
	 * @param array<int|string>       $terms    - The terms to include in results.
	 * @param string                  $taxonomy - The taxonomy to query.
	 * @param bool                    $children - Include children for hierarchical taxonomies.
	 * @param string                  $field    - The field to query against.
	 *
	 * @return Tax_Query
	 */
	public function and( array $terms, string $taxonomy, bool $children = true, string $field = 'term_id' ): Tax_Query {
		$this->add_clause( $terms, $taxonomy, $field, 'AND', $children );
		return $this;
	}


	/**
	 * Create an 'IN' clause.
	 *
	 * @phpstan-param static::FIELD_* $field
	 *
	 * @param array<int|string>       $terms    - The terms to include in results.
	 * @param string                  $taxonomy - The taxonomy to query.
	 * @param bool                    $children - Include children for hierarchical taxonomies.
	 * @param string                  $field    - The field to query against.
	 *
	 * @return Tax_Query
	 */
	public function in( array $terms, string $taxonomy, bool $children = true, string $field = 'term_id' ): Tax_Query {
		$this->add_clause( $terms, $taxonomy, $field, 'IN', $children );
		return $this;
	}


	/**
	 * Create a 'NOT IN' clause.
	 *
	 * @phpstan-param static::FIELD_* $field
	 *
	 * @param array<int|string>       $terms    - The terms to exclude results from.
	 * @param string                  $taxonomy - The taxonomy to query.
	 * @param bool                    $children - Include children for hierarchical taxonomies.
	 * @param string                  $field    - The field to query against.
	 *
	 * @return Tax_Query
	 */
	public function not_in( array $terms, string $taxonomy, bool $children = true, string $field = 'term_id' ): Tax_Query {
		$this->add_clause( $terms, $taxonomy, $field, 'NOT IN', $children );
		return $this;
	}


	/**
	 * Create an 'EXISTS' clause.
	 *
	 * @param string $taxonomy - The taxonomy to query.
	 *
	 * @return Tax_Query
	 */
	public function exists( string $taxonomy ): Tax_Query {
		$this->add_clause( '', $taxonomy, '', 'EXISTS' );
		return $this;
	}


	/**
	 * Create a 'NOT EXISTS' clause.
	 *
	 * @param string $taxonomy - The taxonomy to query.
	 *
	 * @return Tax_Query
	 */
	public function not_exists( string $taxonomy ): Tax_Query {
		$this->add_clause( '', $taxonomy, '', 'NOT EXISTS' );
		return $this;
	}


	/**
	 * Flatten the finished clauses into the tax_query.
	 *
	 * @internal
	 *
	 * @phpstan-param ArgsRules<array<string, mixed>> $args_class
	 *
	 * @formatter:off
	 * @param ArgsRules $args_class - Args class, which supports properties this method will assign.
	 * @formatter:on
	 *
	 * @throws \LogicException - If the `tax_query` property is not defined on the args class.
	 *
	 * @return void
	 */
	public function flatten( ArgsRules $args_class ): void {
		$this->extract_nested( $this->clauses, $this );
		if ( ! property_exists( $args_class, 'tax_query' ) ) {
			throw new \LogicException( 'The `tax_query` property is required on the class using the `Tax_Query` trait.' );
		}
		$args_class->tax_query = \array_merge( $args_class->tax_query ?? [], $this->clauses );
	}


	/**
	 * Generate a clause for the term query.
	 *
	 * @link          https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
	 *
	 * @phpstan-param 'AND'|'IN'|'NOT IN'|'EXISTS'|'NOT EXISTS' $operator
	 * @phpstan-param static::FIELD_*                           $field
	 *
	 * @param int|string|array<int,string|int>                  $terms    - Term(s) to query.
	 * @param string                                            $taxonomy - Taxonomy to query.
	 * @param string                                            $field    - Field to query against.
	 * @param string                                            $operator - MySQL operator to use.
	 * @param bool                                              $children - Include children for hierarchical taxonomies.
	 *
	 * @return void
	 */
	protected function add_clause( array|int|string $terms, string $taxonomy, string $field, string $operator, bool $children = true ): void {
		$clause = \array_filter( [
			'taxonomy' => $taxonomy,
			'field'    => $field,
			'terms'    => $terms,
			'operator' => $operator,
		], fn( $value ) => ! \in_array( $value, [ [], 0, '0', '' ], true ) );

		if ( false === $children ) {
			$clause['include_children'] = false;
		}

		$this->clauses[] = $clause;
	}
}
