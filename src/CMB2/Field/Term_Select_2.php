<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Field;

use CMB2_Field;
use CMB2_Types;
use Lipe\Lib\Traits\Singleton;

/**
 * Select 2 Field for Terms.
 *
 * @example $field = new Field( self::DISPLAYED_TAG, 'Displayed Tags' );
 *          $field->type = Term_Select_2::NAME;
 *          $field->taxonomy = Post_Tag::NAME;
 *          $field->multiple = false; //to make this only allow one item (defaults to 'multiple' which means allow many)
 *          $box->add_field( $field );
 *
 * @notice  You must call init() on this class to make it available
 */
class Term_Select_2 {
	use Singleton;

	public const NAME = 'lipe/lib/cmb2/field-types/term-select-2';

	public const GET_TERMS        = 'lipe/lib/cmb2/field-types/term-select-2/ajax';
	public const CREATE_NEW_TERMS = 'create_terms';


	/**
	 * Called via self::init_once() from various entry points
	 *
	 * @return void
	 */
	protected function hook(): void {
		add_action( 'cmb2_render_' . self::NAME, [ $this, 'render' ], 10, 5 );
		add_filter( 'cmb2_sanitize_' . self::NAME, [ $this, 'assign_terms_during_save' ], 10, 4 );
		add_filter( 'cmb2_types_esc_' . self::NAME, [ $this, 'esc_repeater_values' ], 10, 3 );

		// Remove subtle conflict with acf.
		add_filter( 'acf/settings/select2_version', fn() => 4 );

		add_action( 'wp_ajax_' . self::GET_TERMS, [ $this, 'ajax_get_terms' ] );
	}


	/**
	 * Get available terms via AJAX.
	 *
	 * @return void
	 */
	public function ajax_get_terms(): void {
		//phpcs:disable
		$search = sanitize_text_field( $_POST['q'] ?? '' );
		$terms = get_terms( [
			'number'     => 10,
			'taxonomy'   => sanitize_text_field( $_REQUEST['taxonomy'] ?? '' ),
			'search'     => $search,
			'fields'     => 'id=>name',
			'hide_empty' => false,
		] );

		$create_new = sanitize_text_field( $_REQUEST[ self::CREATE_NEW_TERMS ] ?? '' );
		if ( \is_array( $terms ) && '' !== $create_new ) {
			// Add a newly entered term as an option.
			$terms[ $search ] = $search;
		}

		\wp_send_json( $terms );
		//phpcs:enable
	}


	/**
	 * Enqueue select2 scripts and styles.
	 *
	 * @return void
	 */
	public function js(): void {
		wp_enqueue_style( 'select2-css', 'https://unpkg.com/select2@4.0.5/dist/css/select2.min.css', [], null ); //phpcs:ignore
		wp_enqueue_script( 'select2', 'https://unpkg.com/select2@4.0.5/dist/js/select2.min.js', [], null ); //phpcs:ignore
	}


	/**
	 * Render the Field.
	 *
	 * @param CMB2_Field                $field             This field object.
	 * @param array<string>|string|null $value             The value of this field escaped.
	 * @param int|string                $object_id         The current post ID or user ID being edited.
	 * @param string                    $object_type       The type of object being edited.
	 * @param CMB2_Types                $field_type_object The field type object.
	 *
	 * @return void
	 */
	public function render( CMB2_Field $field, array|string|null $value, int|string $object_id, string $object_type, CMB2_Types $field_type_object ): void {
		$this->js();

		$field_type_object->type = new \CMB2_Type_Select( $field_type_object );

		$a = [
			'multiple'         => false === $field->args( 'multiple' ) ? 'multiple' : $field->args( 'multiple' ),
			'data-js'          => $field->id(), // for js.
			'name'             => $field_type_object->_name() . '[]',
			'id'               => $field_type_object->_id(),
			'desc'             => $field_type_object->_desc( true ),
			'options'          => $this->get_multi_select_options( $field_type_object, (array) $value ),
			'class'            => 'regular-text',
			'data-placeholder' => $field->args( 'attributes', 'placeholder' ) ?? $field->args( 'description' ),
		];

		$attrs = $field_type_object->concat_attrs( $a, [ 'desc', 'options' ] );
		echo \sprintf( '<select%s>%s</select>%s', $attrs, $a['options'], $a['desc'] ); //phpcs:ignore
		$this->js_inline( $field );
	}


	/**
	 * UGH! super hacky.
	 * I know this sucks. One day I would like to figure this out properly.
	 * The main issue is repeaters.
	 *
	 * @param \CMB2_Field $field This field object.
	 *
	 * @return void
	 */
	protected function js_inline( CMB2_Field $field ): void {
		static $rendered = [];
		if ( isset( $rendered[ $field->id() ] ) ) {
			return;
		}
		$rendered[ $field->id() ] = 1;

		$url_args = [
			'action'               => self::GET_TERMS,
			'taxonomy'             => $this->get_taxonomy( $field->args ),
			self::CREATE_NEW_TERMS => $field->args( self::CREATE_NEW_TERMS ),
		];
		$url = \add_query_arg( $url_args, admin_url( 'admin-ajax.php' ) );
		$no_results_text = $field->args( 'text' )['no_terms_text'] ?? get_taxonomy( $url_args['taxonomy'] )->labels->not_found ?? '';

		$id = $field->id();

		?>
		<script>
			( function ( $ ) {
				var el = {};

				function load_selects( $last ) {
					if ( $last ) {
						el = $( 'div:not(.empty-row) > div > [data-js="<?= esc_js( $id ); ?>"]' ).last();
					} else {
						el = $( 'div:not(.empty-row) > div > [data-js="<?= esc_js( $id ); ?>"]' );
					}
					el.select2( {
						ajax: {
							url: '<?= $url; //phpcs:disable?>',
							dataType: 'json',
							type: 'POST',
							cache: true,
							minimumInputLength: 3,
							delay: 250,
							processResults: function ( data ) {
								var options = [];
								if ( data ) {
									$.each( data, function ( index, text ) {
										options.push( {
											id: index,
											text: text,
										} );
									} );
								}
								return {
									results: options,
								};
							},
						},
						cache: true,
						'language': {
							'noResults': function () {
								return "<?= esc_js( $no_results_text ) ?>";
							},
						},
					} );
				}

				$( function () {
					load_selects( false );
					$( '.cmb-add-row-button' ).on( 'click', function () {
						setTimeout( function () {
							load_selects( true );
						}, 0 );
					} );
				} );

			} )( jQuery );
		</script>

		<?php
	}


	/**
	 * Return the list of options, with selected options at the top preserving their order. This also handles the
	 * removal of selected options which no longer exist in the options array.
	 *
	 * @param CMB2_Types $types_object
	 * @param string[]   $value
	 *
	 * @return string
	 */
	protected function get_multi_select_options( CMB2_Types $types_object, array $value ): string {
		$options = (array) $types_object->field->options();
		if ( [] === $options ) {
			$options = \get_terms( [
				'fields'     => 'id=>name',
				'taxonomy'   => $types_object->field->args['taxonomy'] ?? 'category',
				'hide_empty' => false,
			] );
		}
		if ( is_wp_error( $options ) ) {
			return '';
		}
		$options = $this->put_selected_options_first( $options, $value );
		$selected_items = '';
		$other_items = '';

		$select = new \CMB2_Type_Select( $types_object );

		foreach ( $options as $option_value => $option_label ) {
			$option = [
				'value' => $option_value,
				'label' => $option_label,
			];

			// Split options into those, which are selected and the rest.
			if ( \in_array( (string) $option_value, $value, true ) ) {
				$option['checked'] = true;
				$selected_items .= $select->select_option( $option );
			} else {
				$other_items .= $select->select_option( $option );
			}
		}

		return $selected_items . $other_items;
	}


	/**
	 * Sort the options array by adding selected items first
	 *
	 * @param string[] $all_options
	 * @param string[] $selected_options
	 *
	 * @return string[]
	 */
	protected function put_selected_options_first( array $all_options, array $selected_options ): array {
		$ordered = [];
		foreach ( $selected_options as $key ) {
			if ( \array_key_exists( $key, $all_options ) ) {
				$ordered[ $key ] = $all_options[ $key ];
				unset( $all_options[ $key ] );
			}
		}

		return $ordered + $all_options;
	}


	/**
	 * Based on the passed options.
	 * - Add new terms to the db.
	 * - Assign terms to the object.
	 *
	 * @param mixed                $check
	 * @param mixed                $meta_value
	 * @param int|string           $id - Post id on post screens, field key on settings screens.
	 *
	 * @param array<string, mixed> $field_args
	 *
	 * @return array<string, string>|null
	 */
	public function assign_terms_during_save( mixed $check, mixed $meta_value, int|string $id, array $field_args ): ?array {
		if ( ! \is_array( $meta_value ) || [] === $meta_value ) {
			return $check;
		}
		$create_terms = (bool) ( $field_args['term_select_2_create_terms'] ?? false );
		if ( $create_terms ) {
			if ( isset( $field_args['repeatable'] ) && false !== $field_args['repeatable'] ) {
				foreach ( $meta_value as $k => $terms ) {
					$meta_value[ $k ] = $this->create_terms( $terms, $this->get_taxonomy( $field_args ) );
				}
			} else {
				$meta_value = $this->create_terms( $meta_value, $this->get_taxonomy( $field_args ) );
			}
		}

		$save_terms = (bool) ( $field_args['term_select_2_save_as_terms'] ?? false );
		if ( ( '' !== $id && 0 !== $id ) && $save_terms ) {
			//	if ( Repo::in()->supports_taxonomy_relationships( $this->box_type, Repo ) ) {
			\wp_set_object_terms( (int) $id, \array_map( '\intval', $meta_value ), $this->get_taxonomy( $field_args ) );
			//}
		}

		return $meta_value;
	}


	/**
	 * Create terms if they don't exist
	 *
	 * @param array<string, string> $terms
	 * @param string                $taxonomy
	 *
	 * @return array<string, string>
	 */
	private function create_terms( array $terms, string $taxonomy ): array {
		foreach ( $terms as $key => $val ) {
			if ( ! \is_numeric( $val ) ) {
				$term = wp_create_term( $val, $taxonomy );
				if ( ! is_wp_error( $term ) ) {
					$terms[ $key ] = (string) $term['term_id'];
				}
			}
		}

		return $terms;
	}


	/**
	 * Handle repeatable data escaping
	 *
	 * @param ?array<string, string[]>              $checked
	 * @param null|array<string, string[]>|string[] $values
	 * @param array<string, mixed>                  $field_args
	 *
	 * @return null|array<string, string[]>|string[]
	 */
	public function esc_repeater_values( ?array $checked, null|array $values, array $field_args ): ?array {
		if ( ! \is_array( $values ) || ! isset( $field_args['repeatable'] ) || false === $field_args['repeatable'] ) {
			return $checked;
		}

		foreach ( $values as $key => $val ) {
			if ( ! \is_array( $val ) ) {
				continue;
			}
			$values[ $key ] = \array_map( 'esc_attr', $val );
		}

		return $values;
	}


	/**
	 * Get the set taxonomy or fallback to 'category'
	 *
	 * @param array<string, mixed> $field_args
	 *
	 * @return string
	 */
	private function get_taxonomy( array $field_args ): string {
		return $field_args['taxonomy'] ?? 'category';
	}
}
