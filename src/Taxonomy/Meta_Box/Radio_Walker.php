<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy\Meta_Box;

use Lipe\Lib\Theme\Class_Names;

/**
 * Radio walker for a taxonomy meta boxes.
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @phpstan-type ARGS array{
 *     descendants_and_self?: int,
 *     selected_cats?: array<int>,
 *     popular_cats?: array<int>,
 *     walker?: \Walker,
 *     taxonomy?: string,
 *     checked_ontop?:bool,
 *     echo?: bool
 * }
 */
class Radio_Walker extends \Walker_Category_Checklist {
	/**
	 * Starts the element output.
	 *
	 * @phpstan-param ARGS $args
	 *
	 *
	 * @param string       $output            Passed by reference. Used to append additional content.
	 * @param \WP_Term     $data_object       The current item's term data object.
	 * @param int          $depth             Depth of the current item.
	 * @param array        $args              An array of arguments.
	 * @param int          $current_object_id ID of the current item.
	 *
	 * @return void
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 ): void {
		$tax = get_taxonomy( $args['taxonomy'] ?? '' );
		if ( ! $tax instanceof \WP_Taxonomy ) {
			return;
		}

		$checked = \in_array( $data_object->term_id, $args['selected_cats'] ?? [], true );

		ob_start();
		?>
		<li
			id="<?= esc_attr( $tax->name ) . '-' . esc_attr( (string) $data_object->term_id ) ?>"
			class="<?= esc_attr( (string) new Class_Names( [ 'none-term' => 0 === $data_object->term_id ] ) ) ?>"
		>
			<label>
				<input
					value="<?= esc_attr( (string) $data_object->term_id ) ?>"
					type="radio"
					name="tax_input[<?= esc_attr( $tax->name ) ?>][]"
					id="in-<?= esc_attr( $tax->name ) . '-' . esc_attr( (string) $data_object->term_id ) ?>"
					<?= checked( $checked, true, false ) ?>
				/>
				<?php
				// phpcs:ignore WordPress.NamingConventions -- Using WP core filter.
				echo esc_html( apply_filters( 'the_category', $data_object->name ) );
				?>
			</label>
		</li>
		<?php
		$output .= ob_get_clean();
	}


	/**
	 * Ends the element output, if needed.
	 *
	 * @phpstan-param ARGS $args
	 *
	 * @param string       $output      Used to append additional content.
	 * @param \WP_Term     $data_object The current item's term data object.
	 * @param int          $depth       Depth of the item in reference to parents.
	 * @param array        $args        An array of arguments.
	 *
	 * @return void
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = [] ): void {
		$output .= "</li>\n";
	}
}
