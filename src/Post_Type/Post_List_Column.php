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
 * @see    ListColumn
 * @see    Filter
 *
 */
class Post_List_Column {
	/**
	 * The column slug auto generated from the column label.
	 *
	 * @var string
	 */
	protected string $column_slug;


	final protected function __construct(
		protected ListColumn $column,
	) {
		$this->column_slug = sanitize_title_with_dashes( $column->get_column_label() );
		$this->hook();
	}


	protected function hook(): void {
		if ( ! is_admin() ) {
			return;
		}
		foreach ( $this->column->get_post_types() as $post_type ) {
			add_filter( "manage_{$post_type}_posts_columns", [ $this, 'add_column' ] );
			add_action( "manage_{$post_type}_posts_custom_column", [ $this, 'maybe_render_column' ], 10, 2 );
		}

		if ( $this->column instanceof Filter ) {
			add_action( 'load-edit.php', function() {
				add_action( 'restrict_manage_posts', [ $this, 'render_filter' ] );
				add_action( 'parse_query', [ $this, 'maybe_filter_query' ] );
			} );
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


	/**
	 * Outputs the drop-down select above the posts list
	 * Automatically selects the current one.
	 *
	 * @see    Filter::get_options()
	 *
	 * @internal
	 *
	 * @param string $post_type - The current post type.
	 *
	 * @return void
	 */
	public function render_filter( string $post_type ): void {
		if ( ! $this->column instanceof Filter || ! \in_array( $post_type, $this->column->get_post_types(), true ) ) {
			return;
		}
		$selected = $this->get_selected_filter();
		?>
		<select
			name="<?= esc_attr( $this->column_slug ) ?>"
			id="<?= esc_attr( $this->column_slug ) ?>-select"
			class="postform"
			title="<?= esc_attr( $this->column->get_show_all_label() ) ?>"
		>
			<option value="0" selected="selected">
				<?= esc_html( $this->column->get_show_all_label() ) ?>
			</option>
			<?php
			foreach ( $this->column->get_options() as $value => $label ) {
				?>
				<option class="level-0" value="<?= esc_attr( $value ) ?>" <?php selected( $selected, $value ); ?>>
					<?= esc_html( $label ) ?>
				</option>
				<?php
			}
			?>
		</select>
		<?php
	}


	/**
	 * If a value is selected from this drop-down select
	 * call `filter_query` to adjust the query as needed.
	 *
	 * @see Filter::filter_query()
	 *
	 * @internal
	 *
	 * @param \WP_Query $query - The query object.
	 *
	 * @return void
	 */
	public function maybe_filter_query( \WP_Query $query ): void {
		if ( ! $this->column instanceof Filter || ! isset( $query->query_vars['post_type'] ) ) {
			return;
		}
		$filter = $this->get_selected_filter();
		if ( '' !== $filter && \in_array( $query->query_vars['post_type'], $this->column->get_post_types(), true ) ) {
			$this->column->filter_query( sanitize_text_field( wp_unslash( $_REQUEST[ $this->column_slug ] ) ), $query );
		}
	}


	/**
	 * Get the selected value from the filter drop-down select.
	 *
	 * @return string
	 */
	protected function get_selected_filter(): string {
		if ( isset( $_REQUEST[ $this->column_slug ] ) && '' !== $_REQUEST[ $this->column_slug ] ) {
			return sanitize_text_field( wp_unslash( $_REQUEST[ $this->column_slug ] ) );
		}
		return '';
	}


	public static function factory( ListColumn $column ): Post_List_Column {
		return new static( $column );
	}
}
