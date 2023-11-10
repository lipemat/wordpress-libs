<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

/**
 * Shared methods and interface for various query clauses.
 *
 * @author   Mat Lipe
 * @since    4.0.0
 *
 * @template CLAUSE of Clause_Interface
 */
trait Clause_Trait {
	/**
	 * Meta query clauses.
	 *
	 * @var array
	 */
	protected array $clauses = [];

	/**
	 * Nested clauses.
	 *
	 * @var CLAUSE[]
	 */
	protected array $nested = [];

	/**
	 * Parent clause if within a nested clause.
	 *
	 * @var CLAUSE|null
	 */
	protected ?Clause_Interface $parent_clause = null;


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
	 * @phpstan-param CLAUSE   $parent_clause
	 *
	 * @param Clause_Interface $parent_clause - Clause to put the next clause under.
	 *
	 * @return void
	 */
	public function set_parent_clause( Clause_Interface $parent_clause ): void {
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
	public function relation( string $relation = 'AND' ): Clause_Interface {
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
	 * @phpstan-return CLAUSE
	 * @return static
	 */
	public function nested_clause( string $relation = 'AND' ): Clause_Interface {
		if ( empty( $this->clauses['relation'] ) ) {
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
	 * @phpstan-return CLAUSE
	 * @return Clause_Interface
	 */
	public function parent_clause(): Clause_Interface {
		if ( null === $this->parent_clause ) {
			throw new \LogicException( esc_html__( 'You cannot switch to a parent clause if you are not already nested.', 'lipe' ) );
		}
		return $this->parent_clause;
	}


	/**
	 * Loop through the nested clauses and append them to
	 * the clause array at the correct level.
	 *
	 * @phpstan-param CLAUSE   $level
	 *
	 * @param array            $clauses - The clauses array to append to.
	 * @param Clause_Interface $level   - The clause to determine the level of nesting.
	 *
	 * @return void
	 */
	protected function extract_nested( array &$clauses, Clause_Interface $level ): void {
		if ( ! empty( $level->nested ) ) {
			foreach ( $level->nested as $nested ) {
				$clauses[] = $nested->clauses;
				$this->extract_nested( $clauses[ \array_key_last( $clauses ) ], $nested );
			}
		}
	}
}
