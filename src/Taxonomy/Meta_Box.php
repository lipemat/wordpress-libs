<?php

declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

/**
 * Custom output for various meta box styles.
 *
 * Inspired by 'johnbillion/extended-cpts' but simplified and adjusted
 * to prevent conflicts with Genesis themes.
 *
 * @author Mat Lipe
 * @since  4.0.0
 */
class Meta_Box {
	/**
	 * The taxonomy slug.
	 *
	 * @var string
	 */
	protected string $taxonomy;

	/**
	 * The type meta box.
	 *
	 * @phpstan-var 'radio'|'dropdown'|'simple'|'checklist'
	 *
	 * @var string
	 */
	protected string $type;

	/**
	 * Move checked items to top.
	 *
	 * @var bool
	 */
	protected bool $checked_ontop;


	/**
	 * Meta_Box constructor.
	 *
	 * @phpstan-param 'radio'|'dropdown'|'simple' $type
	 *
	 * @param string                              $taxonomy      - The taxonomy slug.
	 * @param string                              $type          - The type of meta box.
	 * @param bool                                $checked_ontop - Move checked items to top.
	 */
	public function __construct( string $taxonomy, string $type, bool $checked_ontop ) {
		$this->taxonomy = $taxonomy;
		$this->type = $type;

		$this->checked_ontop = $checked_ontop;

		add_action( 'add_meta_boxes', [ $this, 'replace_default_meta_box' ], 10, 2 );
	}


	/**
	 * Removes the default meta box from the post editing screen and adds our custom meta box.
	 *
	 * @param string $post_type - The post type when on a post edit screen.
	 * @param mixed  $post      - Post object when on a post edit screen.
	 */
	public function replace_default_meta_box( string $post_type, $post ): void {
		if ( ! $post instanceof \WP_Post ) {
			return;
		}

		$taxos = get_post_taxonomies( $post );
		if ( ! \in_array( $this->taxonomy, $taxos, true ) ) {
			return;
		}
		$object = get_taxonomy( $this->taxonomy );
		if ( ! current_user_can( $object->cap->assign_terms ) ) {
			return;
		}

		// Remove default meta box from classic editor.
		if ( $object->hierarchical ) {
			remove_meta_box( "{$this->taxonomy}div", $post_type, 'side' );
		} else {
			remove_meta_box( "tagsdiv-{$this->taxonomy}", $post_type, 'side' );
		}

		// Remove default meta box from block editor.
		wp_add_inline_script(
			'wp-edit-post',
			sprintf(
				'wp.data.dispatch( "core/edit-post" ).removeEditorPanel( "taxonomy-panel-%s" );',
				$this->taxonomy
			)
		);

		$label = 'simple' === $this->type ? $object->labels->name : $object->labels->singular_name;
		add_meta_box( "{$this->taxonomy}div", $label, [ $this, 'do_meta_box' ], $post_type, 'side' );
	}


	/**
	 * Displays the custom meta box on the post editing screen.
	 *
	 * @param \WP_Post            $post     The post object.
	 */
	public function do_meta_box( \WP_Post $post ): void {
		$object = get_taxonomy( $this->taxonomy );
		$selected = wp_get_object_terms( $post->ID, $this->taxonomy, [
			'fields' => 'ids',
		] );
		$walker = $this->get_walker();
		if ( ! isset( $object->labels->no_item ) || '' === $object->labels->no_item ) {
			$object->labels->no_item = esc_html__( 'Not specified', 'lipe' );
		}

		?>
		<div id="taxonomy-<?= esc_attr( $this->taxonomy ) ?>" class="categorydiv lipe-libs-terms-box">
			<?php
			if ( 'dropdown' === $this->type ) {
				printf(
					'<label for="%1$s" class="screen-reader-text">%2$s</label>',
					esc_attr( "{$this->taxonomy}dropdown" ),
					esc_html( $object->labels->singular_name )
				);

				$dropdown_args = [
					'option_none_value' => ( is_taxonomy_hierarchical( $this->taxonomy ) ? '-1' : '' ),
					'show_option_none'  => $object->labels->no_item,
					'hide_empty'        => false,
					'hierarchical'      => true,
					'show_count'        => false,
					'orderby'           => 'name',
					'selected'          => \count( $selected ) < 1 ? 0 : \reset( $selected ),
					'id'                => "{$this->taxonomy}dropdown",
					'name'              => is_taxonomy_hierarchical( $this->taxonomy ) ? "tax_input[{$this->taxonomy}][]" : "tax_input[{$this->taxonomy}]",
					'taxonomy'          => $this->taxonomy,
				];

				wp_dropdown_categories( $dropdown_args );
			} else {
				?>
					<style>
						/* Style for the 'none' item: */
						#<?= esc_attr( $this->taxonomy ) ?>-0 {
							color: #888;
							border-top: 1px solid #eee;
							margin-top: 5px;
							padding-top: 5px;
						}

						/* Remove Genesis "Select / Deselect All" button. */
						.lipe-libs-terms-box #genesis-category-checklist-toggle {
							display: none;
						}
					</style>

					<input type="hidden" name="tax_input[<?php echo esc_attr( $this->taxonomy ); ?>][]" value="0" />

					<ul
						id="<?= esc_attr( $this->taxonomy ) ?>checklist"
						class="list:<?= esc_attr( $this->taxonomy ) ?> categorychecklist form-no-clear">
						<?php

						// Output the terms.
						wp_terms_checklist(
							$post->ID,
							[
								'taxonomy'      => $this->taxonomy,
								'walker'        => $walker,
								'selected_cats' => $selected,
								'checked_ontop' => $this->checked_ontop,
							]
						);

						// Output the 'none' item.
						$output = '';
						$o = (object) [
							'term_id' => 0,
							'name'    => $object->labels->no_item,
							'slug'    => 'none',
						];
						$args = [
							'taxonomy'      => $this->taxonomy,
							'selected_cats' => \count( $selected ) < 1 ? [ 0 ] : $selected,
							'disabled'      => false,
						];
						$walker->start_el( $output, $o, 1, $args );
						$walker->end_el( $output, $o, 1, $args );

						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $output;
						?>
					</ul>
					<?php
			}
			?>
		</div>
		<?php
	}


	/**
	 * Get the appropriate walker based on the field type.
	 *
	 * @return \Walker
	 */
	protected function get_walker(): \Walker {
		if ( 'radio' === $this->type ) {
			// @phpstan-ignore-next-line
			return new class() extends \Walker_Category_Checklist {
				/**
				 * Starts the element output.
				 *
				 * @param string $output            Passed by reference. Used to append additional content.
				 * @param object $data_object       The current item's term data object.
				 * @param int    $depth             Depth of the current item.
				 * @param array  $args              An array of arguments.
				 * @param int    $current_object_id ID of the current item.
				 *
				 * @return void
				 */
				public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 ): void { //phpcs:ignore -- Signature must match parent.
					$tax = get_taxonomy( $args['taxonomy'] );
					if ( ! $tax ) {
						return;
					}

					$value = $tax->hierarchical ? $data_object->term_id : $data_object->name;
					if ( empty( $data_object->term_id ) && ! $tax->hierarchical ) {
						$value = '';
					}
					$checked = \in_array( $data_object->term_id, $args['selected_cats'], true );

					// @todo Next time working on this, clean it up with `ob_start()`.
					$output .= "\n<li id='{$args['taxonomy']}-{$data_object->term_id}'>" .
								'<label class="selectit">' .
								'<input value="' . esc_attr( $value ) . '" type="radio" name="tax_input[' . esc_attr( $args['taxonomy'] ) . '][]" ' .
								'id="in-' . esc_attr( $args['taxonomy'] ) . '-' . esc_attr( (string) $data_object->term_id ) . '"' .
								checked( $checked, true, false ) .
								' /> ' .
					           //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
								esc_html( apply_filters( 'the_category', $data_object->name ) ) .
								'</label>';
				}
			};
		}

		return new \Walker_Category_Checklist();
	}
}
