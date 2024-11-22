<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Post_Type\Post_List_Column\Filter;

/**
 * Register a post list column filter.
 *
 * For registering a filter without registering the column for cases
 * where the column is ommitted or already handled by CMB2.
 *
 * @author Mat Lipe
 * @since  5.3.0
 *
 * @see    Post_List_Column for also registering the column
 *
 */
class Post_List_Filter {
	protected const NONCE = 'lipe/lib/post-type/post-list-filter/nonce';


	/**
	 * Register a custom post list filter for a list of post types.
	 *
	 * @param Filter $filter_column - Filter to register for post list column.
	 * @param string $column_slug   - The slug of the column to filter.
	 */
	public function __construct(
		protected Filter $filter_column,
		protected string $column_slug
	) {
		$this->hook();
	}


	/**
	 * Hook the filter into the WordPress admin.
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

		add_action( 'load-edit.php', function() {
			add_action( 'restrict_manage_posts', [ $this, 'render_filter' ] );
			add_action( 'parse_query', [ $this, 'maybe_filter_query' ] );
		} );
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
		if ( ! \in_array( $post_type, $this->filter_column->get_post_types(), true ) ) {
			return;
		}
		wp_nonce_field( self::NONCE, self::NONCE );

		?>
		<select
			name="<?= esc_attr( $this->column_slug ) ?>"
			id="<?= esc_attr( $this->column_slug ) ?>-select"
			class="postform"
			title="<?= esc_attr( $this->filter_column->get_show_all_label() ) ?>"
		>
			<option value="0" selected="selected">
				<?= esc_html( $this->filter_column->get_show_all_label() ) ?>
			</option>
			<?php
			$selected = $this->get_selected_filter();
			foreach ( $this->filter_column->get_options() as $value => $label ) {
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
		if ( ! isset( $query->query_vars['post_type'] ) ) {
			return;
		}

		$filter = $this->get_selected_filter();
		if ( '' !== $filter && \in_array( $query->query_vars['post_type'], $this->filter_column->get_post_types(), true ) ) {
			$this->filter_column->filter_query( $filter, $query );
		}
	}


	/**
	 * Get the selected value from the filter drop-down select.
	 *
	 * @return string
	 */
	protected function get_selected_filter(): string {
		if ( ! isset( $_REQUEST[ self::NONCE ] ) || false === wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST[ self::NONCE ] ) ), self::NONCE ) ) {
			return '';
		}
		if ( isset( $_REQUEST[ $this->column_slug ] ) && '' !== $_REQUEST[ $this->column_slug ] ) {
			return sanitize_text_field( wp_unslash( $_REQUEST[ $this->column_slug ] ) );
		}
		return '';
	}
}
