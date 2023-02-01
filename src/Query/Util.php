<?php

namespace Lipe\Lib\Query;

use Lipe\Lib\Traits\Singleton;

/**
 * WP_Query utilities
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 */
class Util {
	use Singleton;

	/**
	 * Get the lightest WP_Query arguments possible by turning off
	 * updating of term caches, found rows, and limiting
	 * post status to "publish".
	 *
	 * Any arguments may be overridden but keeps things dry
	 * by assuring the intended optimizations are included
	 * by default.
	 *
	 * @param array $args - WP_Query arguments.
	 *
	 * @see \WP_Query::parse_query()
	 *
	 * @return array
	 */
	public function get_light_query_args( array $args ) : array {
		return \array_merge( [
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'suppress_filters'       => false,
			'update_menu_item_cache' => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		], $args );
	}
}
