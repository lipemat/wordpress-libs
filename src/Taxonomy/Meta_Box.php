<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Taxonomy\Meta_Box\Gutenberg_Box;

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
	public readonly string $taxonomy;

	/**
	 * The type meta box.
	 *
	 * @phpstan-var Gutenberg_Box::TYPE_*
	 *
	 * @var string
	 */
	public readonly string $type;

	/**
	 * Move checked items to top.
	 *
	 * @var bool
	 */
	public readonly bool $checked_ontop;


	/**
	 * Constructs a custom meta box for a taxonomy to replace
	 * the default meta box with a new UI.
	 *
	 * @phpstan-param Gutenberg_Box::TYPE_* $type
	 *
	 * @param string                        $taxonomy      - The taxonomy slug.
	 * @param string                        $type          - The type of meta box.
	 * @param bool                          $checked_ontop - Move checked items to top.
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
		if ( false === $object || ! current_user_can( $object->cap->assign_terms ) ) {
			return;
		}

		// Remove default meta box from classic editor.
		if ( $object->hierarchical ) {
			remove_meta_box( "{$this->taxonomy}div", $post_type, 'side' );
		} else {
			remove_meta_box( "tagsdiv-{$this->taxonomy}", $post_type, 'side' );
		}

		$label = 'simple' === $this->type ? $object->labels->name : $object->labels->singular_name;

		$tax = get_taxonomy( $this->taxonomy );
		if ( false !== $tax && $tax->show_in_rest && Scripts::in()->is_block_editor() ) {
			Gutenberg_Box::factory( $this );
		} else {
			add_meta_box( "{$this->taxonomy}div", $label, [ $this, 'do_meta_box' ], $post_type, 'side' );

			// Remove default meta box from block editor. @see `removeDefaultMetaBox` for how we do this when using a gutenberg box.
			wp_add_inline_script(
				'wp-edit-post',
				\sprintf(
				// @todo Remove `core/edit-post` fallback when minimum WP version is 6.5.
					'if( "function" === typeof wp.data.dispatch("core/editor").removeEditorPanel ) {typeof wp.data.dispatch("core/editor").removeEditorPanel( "taxonomy-panel-%1$s" ) } else { wp.data.dispatch( "core/edit-post" ).removeEditorPanel( "taxonomy-panel-%1$s" ) }',
					$this->taxonomy
				)
			);
		}
	}


	/**
	 * Displays the custom meta box on the post editing screen.
	 *
	 * @param \WP_Post $post The post object.
	 */
	public function do_meta_box( \WP_Post $post ): void {
		$object = get_taxonomy( $this->taxonomy );
		if ( false === $object ) {
			return;
		}
		$selected = wp_get_object_terms( $post->ID, $this->taxonomy, [
			'fields' => 'ids',
		] );
		if ( is_wp_error( $selected ) ) {
			return;
		}
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

				$args = new WP_Dropdown_Categories();
				$args->option_none_value = ( is_taxonomy_hierarchical( $this->taxonomy ) ? '-1' : '' );
				$args->show_option_none = $object->labels->no_item;
				$args->hide_empty = false;
				$args->hierarchical = true;
				$args->orderby = 'name';
				$args->selected = \count( $selected ) < 1 ? 0 : \reset( $selected );
				$args->id = "{$this->taxonomy}dropdown";
				$args->name = is_taxonomy_hierarchical( $this->taxonomy ) ? "tax_input[{$this->taxonomy}][]" : "tax_input[{$this->taxonomy}]";
				$args->taxonomy = $this->taxonomy;

				wp_dropdown_categories( $args->get_args() );
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
					class="list:<?= esc_attr( $this->taxonomy ) ?> categorychecklist form-no-clear"
				>
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
				 * @param string   $output            Passed by reference. Used to append additional content.
				 * @param \WP_Term $data_object       The current item's term data object.
				 * @param int      $depth             Depth of the current item.
				 * @param array    $args              An array of arguments.
				 * @param int      $current_object_id ID of the current item.
				 *
				 * @return void
				 */
				public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 ): void { //phpcs:ignore -- Signature must match parent.
					$tax = get_taxonomy( $args['taxonomy'] );
					if ( false === $tax ) {
						return;
					}

					$value = $tax->hierarchical ? $data_object->term_id : $data_object->name;
					if ( empty( $data_object->term_id ) && ! $tax->hierarchical ) {
						$value = '';
					}
					$checked = \in_array( $data_object->term_id, $args['selected_cats'], true );

					ob_start();
					?>
					<li id="<?= esc_attr( $args['taxonomy'] ) . '-' . esc_attr( (string) $data_object->term_id ) ?>">
						<label>
							<input
								value="<?= esc_attr( (string) $value ) ?>"
								type="radio"
								name="tax_input[<?= esc_attr( $args['taxonomy'] ) ?>][]"
								id="in-<?= esc_attr( $args['taxonomy'] ) . '-' . esc_attr( (string) $data_object->term_id ) ?>"
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
			};
		}

		return new \Walker_Category_Checklist();
	}
}
