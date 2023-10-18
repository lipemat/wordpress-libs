<?php

namespace Lipe\Lib\Query\Clause;

/**
 * Interface for arguments supporting meta queries.
 *
 * @property array $meta_query
 */
interface Meta_Query_Interface {
	/**
	 * Create and get a new Meta_Query instance.
	 *
	 * @return Meta_Query
	 */
	public function meta_query(): Meta_Query;
}
