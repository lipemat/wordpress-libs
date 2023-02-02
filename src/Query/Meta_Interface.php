<?php

namespace Lipe\Lib\Query;

/**
 * @property array $meta_query
 */
interface Meta_Interface {
	public function meta_query() : Meta_Query;
}
