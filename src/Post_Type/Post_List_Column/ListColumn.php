<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type\Post_List_Column;

/**
 * Include the interface to enable a post list column.
 *
 * @author Mat Lipe
 * @since  4.10.0
 */
interface ListColumn {
	/**
	 * Get the post types to add the column to.
	 *
	 * @return string[]
	 */
	public function get_post_types(): array;


	/**
	 * Get the position of the column.
	 *
	 * @return int
	 */
	public function get_column_position(): int;


	/**
	 * Get the column label.
	 *
	 * @return string
	 */
	public function get_column_label(): string;


	/**
	 * Render the column in the post list table.
	 *
	 * @param int $post_id - The post ID.
	 *
	 * @return void
	 */
	public function render( int $post_id ): void;
}
