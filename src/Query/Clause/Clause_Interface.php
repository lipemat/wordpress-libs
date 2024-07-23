<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

use Lipe\Lib\Args\ArgsRules;

/**
 * Interface for sub-clauses added to Args classes.
 *
 * @author Mat Lipe
 * @since  November 2023
 *
 * @template CLAUSE of Clause_Interface
 */
interface Clause_Interface {
	/**
	 * Prevent different construct definitions from causing errors.
	 */
	public function __construct();


	/**
	 * Set the parent clause when constructing a child clause.
	 *
	 * @phpstan-param CLAUSE   $parent_clause
	 *
	 * @param Clause_Interface $parent_clause - Clause to put the next clause under.
	 *
	 * @return void
	 */
	public function set_parent_clause( Clause_Interface $parent_clause ): void;


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
	public function relation( string $relation = 'AND' ): Clause_Interface;


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
	public function nested_clause( string $relation = 'AND' ): Clause_Interface;


	/**
	 * Switch out of a nested clause back to the original parent.
	 *
	 * @throws \LogicException - If we are not in a nested class.
	 *
	 * @phpstan-return CLAUSE
	 * @return Clause_Interface<CLAUSE>
	 */
	public function parent_clause(): Clause_Interface;
}
