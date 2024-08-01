<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Libs\Scripts\ScriptHandles;
use Lipe\Lib\Libs\Scripts\StyleHandles;
use Lipe\Lib\Taxonomy\Meta_Box\Gutenberg_Box;
use Lipe\Lib\Taxonomy\Meta_Box\Radio_Walker;

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
	public const TYPE_RADIO    = 'radio';
	public const TYPE_DROPDOWN = 'dropdown';
	public const TYPE_SIMPLE   = 'simple';

	/**
	 * The taxonomy slug.
	 *
	 * @var string
	 */
	public readonly string $taxonomy;

	/**
	 * The type meta box.
	 *
	 * @phpstan-var self::TYPE_*
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
	 * @phpstan-param self::TYPE_* $type
	 *
	 * @param string               $taxonomy      - The taxonomy slug.
	 * @param string               $type          - The type of meta box.
	 * @param bool                 $checked_ontop - Move checked items to top.
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
	 * The meta box `tax_input` fields are seen as string which will create
	 * new terms using the id as the name for non-hierarchical taxonomies.
	 *
	 * Translating the string term ids to int will save the terms correctly.
	 *
	 * @see Taxonomy::meta_box
	 *
	 * @param string          $taxonomy - Same taxonomy which was used to create the meta box.
	 * @param string[]|string $terms    - The term ids as strings.
	 *
	 * @return int[]
	 */
	public function translate_string_term_ids_to_int( string $taxonomy, array|string $terms ): array {
		return \array_map( '\intval', (array) $terms );
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

				$args = new Wp_Dropdown_Categories( [] );
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
				Scripts::in()->enqueue_script( ScriptHandles::ADMIN );
				Scripts::in()->enqueue_style( StyleHandles::META_BOXES );
				?>
				<input type="hidden" name="tax_input[<?= esc_attr( $this->taxonomy ) ?>][]" value="0" />

				<ul
					id="<?= esc_attr( $this->taxonomy ) ?>checklist"
					class="list:<?= esc_attr( $this->taxonomy ) ?> categorychecklist form-no-clear"
					data-js="lipe/lib/taxonomy/terms-checklist"
				>
					<?php
					$walker = $this->get_walker();

					$args = new Wp_Terms_Checklist( [] );
					$args->taxonomy = $this->taxonomy;
					$args->selected_cats = $selected;
					$args->checked_ontop = $this->checked_ontop;
					$args->walker = $walker;

					// Output the terms.
					wp_terms_checklist( $post->ID, $args->get_args() );

					// Output the 'none' item.
					$output = '';
					$o = new \WP_Term( (object) [
						'term_id' => 0,
						'name'    => $object->labels->no_item,
						'slug'    => 'none',
					] );
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
	 * @return \Walker_Category_Checklist|Radio_Walker
	 */
	protected function get_walker(): \Walker_Category_Checklist|Radio_Walker {
		if ( 'radio' === $this->type ) {
			return new Radio_Walker();
		}

		return new \Walker_Category_Checklist();
	}
}
