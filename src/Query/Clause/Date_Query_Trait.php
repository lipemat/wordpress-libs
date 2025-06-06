<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

/**
 * Shared properties and methods for working with `date_query`.
 *
 * @since 4.0.0
 */
trait Date_Query_Trait {
	/**
	 * Meta query generated by `date_query()`.
	 *
	 * @see Query_Args::date_query()
	 *
	 * @internal
	 *
	 * @var array<string, mixed>|array<int, array<string, mixed>>
	 */
	public array $date_query;


	/**
	 * Generate the `date_query` clauses.
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_query/#date-parameters
	 *
	 * @note A stub override is required to provide the correct return type.
	 * @see  dev/stubs/query-clauses.php
	 *
	 * @return Date_Query
	 */
	public function date_query(): Date_Query {
		$query = new Date_Query();
		$this->clauses[] = $query;
		return $query;
	}
}
