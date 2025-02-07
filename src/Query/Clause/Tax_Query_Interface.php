<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

/**
 * Interface for arguments supporting taxonomy queries.
 *
 * @since  4.5.0
 *
 * @property array<mixed> $tax_query
 */
interface Tax_Query_Interface {
	/**
	 * Generate the `tax_query` clauses.
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
	 *
	 * @return Tax_Query
	 */
	public function tax_query(): Tax_Query;
}
