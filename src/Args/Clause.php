<?php
declare( strict_types=1 );

namespace Lipe\Lib\Args;

/**
 * Shared methods and interface for various query clauses.
 *
 * @author   Mat Lipe
 * @since    4.0.0
 *
 * @template QUERY of ClauseRules
 */
trait Clause {
	/**
	 * Query clause classes.
	 *
	 * @var array<string, mixed>|array<int, array<string, mixed>>
	 */
	protected array $clauses = [];

	/**
	 * Nested clauses.
	 *
	 * @var QUERY[]
	 */
	protected array $nested = [];

	/**
	 * Parent clause if within a nested clause.
	 *
	 * @phpstan-var QUERY|null
	 * @var ?ClauseRules
	 */
	protected ?ClauseRules $parent_clause = null;


	/**
	 * Prevent different construct definitions from causing errors.
	 *
	 * @noop
	 */
	public function __construct() {
	}


	/**
	 * Set the parent clause when constructing a child clause.
	 *
	 * @phpstan-param QUERY $parent_clause
	 *
	 * @param ClauseRules   $parent_clause - Clause to put the next clause under.
	 *
	 * @return void
	 */
	public function set_parent_clause( ClauseRules $parent_clause ): void {
		$this->parent_clause = $parent_clause;
	}


	/**
	 * Set the relation of the clauses.
	 *
	 * Defaults to 'AND'.
	 *
	 * @noinspection PhpDocSignatureInspection
	 *
	 * @phpstan-param 'AND'|'OR' $relation
	 *
	 * @param string             $relation - 'AND' or 'OR'.
	 *
	 * @return static
	 */
	public function relation( string $relation = 'AND' ): ClauseRules {
		$this->clauses['relation'] = $relation;

		return $this;
	}


	/**
	 * Generate a sub level query for nested queries.
	 *
	 * @noinspection PhpDocSignatureInspection
	 *
	 * @phpstan-param 'AND'|'OR' $relation
	 *
	 * @param string             $relation - 'AND' or 'OR'.
	 *
	 * @phpstan-return QUERY
	 * @return static
	 */
	public function nested_clause( string $relation = 'AND' ): ClauseRules {
		if ( ! isset( $this->clauses['relation'] ) ) {
			$this->relation();
		}
		$sub = new static();
		$sub->set_parent_clause( $this );
		$this->nested[] = $sub;
		$sub->relation( $relation );

		return $sub;
	}


	/**
	 * Switch out of a nested clause back to the original parent.
	 *
	 * @throws \LogicException - If we are not in a nested class.
	 *
	 * @phpstan-return QUERY
	 * @return ClauseRules
	 */
	public function parent_clause(): ClauseRules {
		if ( null === $this->parent_clause ) {
			throw new \LogicException( esc_html__( 'You cannot switch to a parent clause if you are not already nested.', 'lipe' ) );
		}
		return $this->parent_clause;
	}


	/**
	 * Loop through the nested clauses and append them to
	 * the clause array at the correct level.
	 *
	 * @phpstan-param QUERY        $level
	 *
	 * @param array<string, mixed> $clauses - The clauses array to append to.
	 * @param ClauseRules          $level   - The clause to determine the level of nesting.
	 *
	 * @return void
	 */
	protected function extract_nested( array &$clauses, ClauseRules $level ): void {
		if ( [] !== $level->nested ) {
			foreach ( $level->nested as $nested ) {
				$clauses[] = $nested->clauses;
				$this->extract_nested( $clauses[ \array_key_last( $clauses ) ], $nested );
			}
		}
	}
}
