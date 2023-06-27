<?php

namespace Lipe\Lib\Schema;

//phpcs:disable WordPress.Security.NonceVerification.Recommended

/**
 * Add a custom column to the posts list table.
 */
abstract class Post_List_Column {
	/**
	 * The column label.
	 *
	 * @var string
	 */
	protected string $column_label;

	/**
	 * The column slug.
	 *
	 * @var string
	 */
	protected string $column_slug;

	/**
	 * The column position.
	 *
	 * @var int
	 */
	protected int $column_position;

	/**
	 * The post types to add the column to.
	 *
	 * @var array|string[]
	 */
	protected array $post_types = [];

	/**
	 * The column filters.
	 *
	 * @var array
	 */
	protected array $filters = [];


	/**
	 * Renders the output of the column in each row
	 * of the posts list
	 *
	 * @param string $column  - The column key.
	 * @param int    $post_id - The post ID.
	 *
	 * @return void
	 */
	abstract protected function render_column( string $column, int $post_id );


	/**
	 * Post_List_Column constructor.
	 *
	 * @param string $column_label - The column label.
	 * @param array  $post_types   - The post types to add the column to.
	 */
	public function __construct( string $column_label, $post_types = [ 'post' ] ) {
		$this->column_label = $column_label;
		$this->column_slug = sanitize_title_with_dashes( $this->column_label );
		$this->post_types = $post_types;
		$this->hook();
	}


	/**
	 * Actions and filters
	 *
	 * @return void
	 */
	public function hook() : void {
		global $pagenow;
		if ( 'edit.php' === $pagenow && is_admin() ) {
			add_action( 'restrict_manage_posts', [ $this, 'render_filter' ] );
			add_action( 'parse_query', [ $this, 'maybe_filter_query' ] );
			foreach ( $this->post_types as $post_type ) {
				add_filter( "manage_{$post_type}_posts_columns", [ $this, 'add_column' ] );
				add_action( "manage_{$post_type}_posts_custom_column", [ $this, 'maybe_render_column' ], 10, 2 );
			}
		}
	}


	/**
	 * Put the column in a specific position in the table.
	 *
	 * @param int $position - The position to place the column.
	 *
	 * @return void
	 */
	public function set_column_position( int $position ) : void {
		$this->column_position = ( $position - 1 );
	}


	/**
	 * Calls $this->render_column() for the current column only
	 *
	 * @param string $column  - The column key.
	 * @param int    $post_id - The post ID.
	 *
	 * @return void
	 */
	public function maybe_render_column( string $column, int $post_id ) : void {
		if ( $column === $this->column_slug ) {
			$this->render_column( $column, $post_id );
		}
	}


	/**
	 * Add Columns to the Post List
	 *
	 * @internal
	 *
	 * @param array $columns - Colmuns to add to the post list.
	 *
	 * @return array
	 */
	public function add_column( array $columns ) : array {
		if ( ! empty( $this->column_position ) ) {
			$before = \array_slice( $columns, 0, $this->column_position );
			$after = \array_slice( $columns, $this->column_position );
			$before[ $this->column_slug ] = $this->column_label;
			$columns = \array_merge( $before, $after );
		} else {
			$columns[ $this->column_slug ] = $this->column_label;
		}

		return $columns;
	}


	/**
	 * If a value is selected from this drop-down
	 * Call $this->filter_query to adjust the query as needed
	 *
	 * @notice Only called if we are using $this->set_filters() to handle rendering
	 *
	 * @see    $this->set_filters();
	 *
	 * @internal
	 *
	 * @param \WP_Query $query - The query object.
	 *
	 * @return void
	 */
	public function maybe_filter_query( \WP_Query $query ) : void {
		if ( empty( $query->query_vars['post_type'] ) || ! \in_array( $query->query_vars['post_type'], $this->post_types, true ) ) {
			return;
		}

		if ( ! empty( $this->filters['name'] ) ) {
			$selected = empty( $_REQUEST[ $this->filters['name'] ] ) ? false : sanitize_text_field( wp_unslash( $_REQUEST[ $this->filters['name'] ] ) );
			if ( ! empty( $selected ) ) {
				$this->filter_query( $selected, $query );
			}
		}
	}


	/**
	 * Override to filter the query being used in the posts list
	 * Will provide the selected value, and the query
	 * to filter.
	 *
	 * @notice This method must be overridden if using filters.
	 *
	 * @param string    $value - The selected value.
	 * @param \WP_Query $query - The query object.
	 *
	 * @throws \RuntimeException - If not overridden.
	 */
	public function filter_query( $value, \WP_Query $query ) : \WP_Query {
		throw new \RuntimeException( __( 'You must override the Post_List_Column::filter_query() method if you are using Post_List_Column::set_filters()', 'lipe' ) );
	}


	/**
	 * Outputs the drop-down select above the posts list
	 * Automatically selects the current one.
	 *
	 * @notice Will not output if self::set_filters() is not called previously
	 * @see    self::set_filters()
	 *
	 * @return void
	 */
	public function render_filter() : void {
		global $typenow;

		if ( empty( $this->filters ) || ! \in_array( $typenow, $this->post_types, true ) ) {
			return;
		}

		$args = $this->filters;
		$selected = empty( $_REQUEST[ $args['name'] ] ) ? false : sanitize_text_field( wp_unslash( $_REQUEST[ $args['name'] ] ) );

		?>
		<select
			name="<?= esc_attr( $args['name'] ) ?>"
			id="<?= esc_attr( $args['name'] ) ?>-select"
			class="postform"
			title="<?= esc_attr( $args['show_all'] ) ?>"
		>
			<?php
			if ( ! empty( $args['show_all'] ) ) {
				?>
				<option value="0" selected="selected">
					<?= esc_html( $args['show_all'] ) ?>
				</option>
				<?php
			}
			foreach ( $args['items'] as $value => $_label ) {
				?>
				<option class="level-0" value="<?= esc_attr( $value ) ?>" <?php selected( $selected, $value ); ?>>
					<?= esc_html( $_label ) ?>
				</option>
				<?php
			}

			?>
		</select>

		<?php
	}


	/**
	 * Setup filters to be used as a drop-down select in the posts list.
	 * Using this method will cause $this->filter_query to
	 * be called when rendering the post list.
	 *
	 * @param array{name?: string, items: array, show_all?: string} $args     - The arguments for the filter.
	 *
	 * @type string                                                 $name     => %name of input%
	 *
	 * @type array                                                  $items    => array { %value% => %label% }
	 * @type string                                                 $show_all ' => %All Label%
	 *
	 * @return void
	 */
	public function set_filters( array $args ) : void {
		$defaults = [
			'show_all' => false,
			'name'     => __CLASS__,
			'items'    => [],
		];

		$this->filters = wp_parse_args( $args, $defaults );
	}

}
