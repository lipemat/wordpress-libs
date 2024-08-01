<?php
declare( strict_types=1 );

namespace Lipe\Lib\Args;

/**
 * Interface for sub-clauses added to Args classes.
 *
 * @author Mat Lipe
 * @since  November 2023
 *
 * @template CLAUSE of ClauseRules
 */
interface ClauseRules {
	/**
	 * Prevent different construct definitions from causing errors.
	 */
	public function __construct();


	/**
	 * Set the parent clause when constructing a child clause.
	 *
	 * @phpstan-param CLAUSE $parent_clause
	 *
	 * @param ClauseRules    $parent_clause - Clause to put the next clause under.
	 *
	 * @return void
	 */
	public function set_parent_clause( ClauseRules $parent_clause ): void;


	/**
	 * Flatten the finished clauses into a query argument property.
	 *
	 * @interal
	 *
	 * @param ArgsRules $args_class - Args class, which supports properties this method will assign.
	 *
	 * @return void
	 */
	public function flatten( $args_class ): void;


	/**
	 * Set the relation of the clauses.
	 *
	 * Defaults to 'AND'.
	 *
	 * @phpstan-param 'AND'|'OR' $relation
	 *
	 * @param string             $relation - 'AND' or 'OR'.
	 *
	 * @return static
	 */
	public function relation( string $relation = 'AND' ): ClauseRules;


	/**
	 * Generate a sub level query for nested queries.
	 *
	 * @phpstan-param 'AND'|'OR' $relation
	 *
	 * @param string             $relation - 'AND' or 'OR'.
	 *
	 * @phpstan-return CLAUSE
	 * @return static
	 */
	public function nested_clause( string $relation = 'AND' ): ClauseRules;


	/**
	 * Switch out of a nested clause back to the original parent.
	 *
	 * @throws \LogicException - If we are not in a nested class.
	 *
	 * @phpstan-return CLAUSE
	 * @return ClauseRules<CLAUSE>
	 */
	public function parent_clause(): ClauseRules;
}
