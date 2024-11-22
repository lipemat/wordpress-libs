<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type\Post_List_Column;

/**
 * Include the interface to enable a post list filter for a column.
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 */
interface Filter {
	/**
	 * Get the post types to add the column to.
	 *
	 * @return string[]
	 */
	public function get_post_types(): array;


	/**
	 * Get the label for the filter drop-down.
	 *
	 * @return string
	 */
	public function get_show_all_label(): string;


	/**
	 * Get the options to add to filter drop-down select.
	 *
	 * array{value: label}
	 *
	 * @return array<string, string>
	 */
	public function get_options(): array;


	/**
	 * Filter the posts list query if this filter is used.
	 *
	 * @param string    $value - The value of the filter.
	 * @param \WP_Query $query - The query for the posts list.
	 *
	 * @return void
	 */
	public function filter_query( string $value, \WP_Query $query ): void;
}
