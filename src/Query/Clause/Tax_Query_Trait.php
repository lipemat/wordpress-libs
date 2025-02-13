<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

/**
 * Shared properties and methods for working with taxonomy queries.
 *
 * @since 4.5.0
 */
trait Tax_Query_Trait {
	/**
	 * Category ID or comma-separated list of IDs (this or any children).
	 *
	 * @var int|string
	 */
	public string|int $cat;

	/**
	 * An array of category IDs (AND in).
	 *
	 * @var array<int, int>
	 */
	public array $category__and;

	/**
	 * An array of category IDs (OR in, no children).
	 *
	 * @var array<int, int>
	 */
	public array $category__in;

	/**
	 * An array of category IDs (NOT in).
	 *
	 * @var array<int, int>
	 */
	public array $category__not_in;

	/**
	 * Use category slug (not name, this or any children).
	 *
	 * @var string
	 */
	public string $category_name;

	/**
	 * Tag slug. Comma-separated (either), Plus-separated (all).
	 *
	 * @var string
	 */
	public string $tag;

	/**
	 * An array of tag IDs (AND in).
	 *
	 * @var array<int, int>
	 */
	public array $tag__and;

	/**
	 * An array of tag IDs (OR in).
	 *
	 * @var array<int, int>
	 */
	public array $tag__in;

	/**
	 * An array of tag IDs (NOT in).
	 *
	 * @var array<int, int>
	 */
	public array $tag__not_in;

	/**
	 * Tag id or comma-separated list of IDs.
	 *
	 * @var int
	 */
	public int $tag_id;

	/**
	 * An array of tag slugs (AND in).
	 *
	 * @var array<int, string>
	 */
	public array $tag_slug__and;

	/**
	 * An array of tag slugs (OR in). unless 'ignore_sticky_posts' is true.
	 *
	 * @var array<int, string>
	 */
	public array $tag_slug__in;

	/**
	 * Term query generated by `term_query()`.
	 *
	 * @see Query_Args::tax_query()
	 *
	 * @internal
	 *
	 * @var array<mixed>
	 */
	public array $tax_query;


	/**
	 * Generate the `tax_query` clauses.
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
	 *
	 * @note A stub override is required to provide the correct return type.
	 * @see  dev/stubs/query-clauses.php
	 *
	 * @return Tax_Query
	 */
	public function tax_query(): Tax_Query {
		$query = new Tax_Query();
		$this->clauses[] = $query;
		return $query;
	}
}
