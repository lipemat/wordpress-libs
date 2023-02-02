<?php

namespace Lipe\Lib\Query\Clause;

/**
 * @property array $meta_query
 */
interface Meta_Query_Interface {
	public function meta_query() : Meta_Query;
}
