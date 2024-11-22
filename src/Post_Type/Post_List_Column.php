<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Post_Type\Post_List_Column\Filter;
use Lipe\Lib\Post_Type\Post_List_Column\ListColumn;

/**
 * Register a custom post list column for a list of post types.
 *
 * - A basic column requires the `ListColumn` interface.
 * - A filterable column also requires the `Filter` interface.
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @see    Post_List_Filter for registering a filter without a column.
 *
 */
class Post_List_Column {
	/**
	 * The column slug auto generated from the column label.
	 *
	 * @var string
	 */
	protected readonly string $column_slug;

	/**
	 * The filter for the column if the column also
	 * implements the `Filter` interface.
	 *
	 * @var ?Post_List_Filter
	 */
	protected readonly ?Post_List_Filter $filter;


	/**
	 * Register a custom post list column for a list of post types.
	 *
	 * - A basic column requires the `ListColumn` interface.
	 * - A filterable column also requires the `Filter` interface.
	 *
	 * @param ListColumn $column - Column to register.
	 */
	public function __construct(
		protected ListColumn $column,
	) {
		$this->column_slug = sanitize_title_with_dashes( $column->get_column_label() );
		if ( $this->column instanceof Filter ) {
			$this->filter = new Post_List_Filter( $this->column, $this->column_slug );
		} else {
			$this->filter = null;
		}

		$this->hook();
	}


	/**
	 * Hook the column into the WordPress admin.
	 *
	 * - Does nothing if not within the admin.
	 * - Will not filter anything if not in `load-edit.php` context.
	 *
	 * @return void
	 */
	protected function hook(): void {
		if ( ! is_admin() ) {
			return;
		}
		foreach ( $this->column->get_post_types() as $post_type ) {
			add_filter( "manage_{$post_type}_posts_columns", [ $this, 'add_column' ] );
			add_action( "manage_{$post_type}_posts_custom_column", [ $this, 'maybe_render_column' ], 10, 2 );
		}
	}


	/**
	 * Call the columns `render` method for the current column only.
	 *
	 * @interal
	 *
	 * @param string $column  - Possible column key.
	 * @param int    $post_id - The post ID.
	 *
	 * @return void
	 */
	public function maybe_render_column( string $column, int $post_id ): void {
		if ( $this->column_slug === $column ) {
			$this->column->render( $post_id );
		}
	}


	/**
	 * Add Columns to the Post List
	 *
	 * @internal
	 *
	 * @param array<string, string> $columns - Columns to add to the post list.
	 *
	 * @return array<string, string>
	 */
	public function add_column( array $columns ): array {
		$position = $this->column->get_column_position() - 1;
		$before = \array_slice( $columns, 0, $position );
		$after = \array_slice( $columns, $position );
		$before[ $this->column_slug ] = $this->column->get_column_label();
		return \array_merge( $before, $after );
	}
}
