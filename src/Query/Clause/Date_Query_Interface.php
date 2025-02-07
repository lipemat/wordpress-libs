<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

/**
 * Interface for arguments supporting date queries.
 *
 * @property array<string, mixed>|array<int, array<string, mixed>> $date_query
 */
interface Date_Query_Interface {
	/**
	 * Create and get a new Date_Query instance.
	 *
	 * @return Date_Query
	 */
	public function date_query(): Date_Query;
}
