<?php

namespace Lipe\Lib\CMB2\Field;

use CMB2_Field;
use CMB2_Types;
use Lipe\Lib\Theme\Styles;
use Lipe\Lib\Traits\Singleton;

/**
 * Select 2 Field for Terms.
 *
 *
 * @example $field = new Field( self::DISPLAYED_TAG, 'Displayed Tags' );
 *          $field->type = Term_Select_2::NAME;
 *          $field->taxonomy = Post_Tag::NAME;
 *          $field->multiple = false; //to make this only allow one item (defaults to 'multiple' which means allow many)
 *          $box->add_field( $field );
 *
 * @notice  You must call init() on this class to make it available
 *
 * @package Lipe\Lib\CMB2\Field_Types
 */
class Term_Select_2 {
	use Singleton;

	public const NAME = 'lipe/lib/cmb2/field-types/term-select-2';

	public const GET_TERMS        = 'lipe/lib/cmb2/field-types/term-select-2/ajax';
	public const SAVE_AS_TERMS    = 'save_as_terms';
	public const CREATE_NEW_TERMS = 'create_terms';


	/**
	 * Called via self::init_once() from various entry points
	 *
	 * @return void
	 */
	protected function hook() : void {
		add_action( 'cmb2_render_' . self::NAME, [ $this, 'render' ], 10, 5 );
		add_filter( 'cmb2_sanitize_' . self::NAME, [ $this, 'assign_terms_during_save' ], 10, 4 );
		add_filter( 'cmb2_types_esc_' . self::NAME, [ $this, 'esc_repeater_values' ], 10, 4 );

		add_action( 'admin_enqueue_scripts', [ $this, 'js' ] );
		//remove subtle conflict with acf
		add_filter( 'acf/settings/select2_version', function () {
			return 4;
		} );

		add_action( 'wp_ajax_' . self::GET_TERMS, [ $this, 'ajax_get_terms' ] );
	}


	public function ajax_get_terms() : void {
		//phpcs:disable
		$search = sanitize_text_field( $_POST['q'] ?? '' );
		$terms = get_terms( [
			'number'     => 10,
			'taxonomy'   => sanitize_text_field( $_REQUEST['taxonomy'] ?? '' ),
			'search'     => $search,
			'fields'     => 'id=>name',
			'hide_empty' => false,
		] );
		if ( \is_array( $terms ) && sanitize_text_field( $_REQUEST[ self::CREATE_NEW_TERMS ] ?? '' ) ) {
			// Add a newly entered term as an option.
			$terms[ $search ] = $search;
		}

		\wp_send_json( $terms );
		//phpcs:enable
	}


	public function js() : void {
		\wp_enqueue_style( 'select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css', [], Styles::in()->get_version() );
		\wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js', [], Styles::in()->get_version() );
	}


	public function render( CMB2_Field $field, $value, $object_id, string $object_type, CMB2_Types $field_type_object ) : void {
		if ( empty( $value ) ) {
			$value = null;
		}

		$field_type_object->type = new \CMB2_Type_Select( $field_type_object );

		$a = [
			'multiple'         => empty( $field->args( 'multiple' ) ) ? 'multiple' : $field->args( 'multiple' ),
			'data-js'          => $field->id(), //for js
			'name'             => $field_type_object->_name() . '[]',
			'id'               => $field_type_object->_id(),
			'desc'             => $field_type_object->_desc( true ),
			'options'          => $this->get_multi_select_options( $field_type_object, (array) $value ),
			'class'            => 'regular-text',
			'data-placeholder' => $field->args( 'attributes', 'placeholder' ) ?? $field->args( 'description' ),
		];

		$attrs = $field_type_object->concat_attrs( $a, [ 'desc', 'options' ] );
		echo \sprintf( '<select%s>%s</select>%s', $attrs, $a['options'], $a['desc'] ); //phpcs:ignore
		$this->js_inline( $field, $field_type_object );
	}


	/**
	 * UGH! super hacky.
	 * I know this sucks. One day I would like to figure this out properly.
	 * The main issue is repeaters.
	 *
	 * @param \CMB2_Field $field
	 * @param \CMB2_Types $field_type_object
	 *
	 * @return void
	 */
	private function js_inline( CMB2_Field $field, CMB2_Types $field_type_object ) : void {
		static $rendered = [];
		if ( isset( $rendered[ (string) $field->id() ] ) ) {
			return;
		}
		$rendered[ (string) $field->id() ] = 1;

		$url_args = [
			'action'               => self::GET_TERMS,
			'taxonomy'             => $this->get_taxonomy( $field->args ),
			self::CREATE_NEW_TERMS => $field->args( self::CREATE_NEW_TERMS ),
		];
		$url = \add_query_arg( $url_args, admin_url( 'admin-ajax.php' ) );
		$no_results_text = $field->args( 'text' )['no_terms_text'] ?? get_taxonomy( $url_args['taxonomy'] )->labels->not_found;

		$id = $field->id();

		?>
		<script>
			( function( $ ) {
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
							processResults: function( data ) {
								var options = [];
								if ( data ) {
									$.each( data, function( index, text ) {
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
							'noResults': function() {
								return "<?= esc_js( $no_results_text ) ?>";
							},
						},
					} );
				}

				$( function() {
					load_selects( false );
					$( '.cmb-add-row-button' ).on( 'click', function() {
						setTimeout( function() {
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
	 * @param array|null $field_escaped_value
	 *
	 * @return string
	 */
	protected function get_multi_select_options( CMB2_Types $types_object, ?array $field_escaped_value = [] ) : string {
		$options = (array) $types_object->field->options();

		// If we have selected items, we need to preserve their order
		if ( ! empty( $field_escaped_value ) ) {
			if ( ! empty( $options ) ) {
				$options = $this->put_selected_options_first( $options, $field_escaped_value );
			} else {
				$options = \get_terms( [
					'include'    => array_map( '\intval', $field_escaped_value ),
					'fields'     => 'id=>name',
					'taxonomy'   => $types_object->field->args['taxonomy'] ?? 'category',
					'hide_empty' => false,
				] );
			}
		}

		$selected_items = '';
		$other_items = '';

		$select = new \CMB2_Type_Select( $types_object );

		foreach ( $options as $option_value => $option_label ) {
			// Clone args & modify for just this item
			$option = [
				'value' => $option_value,
				'label' => $option_label,
			];

			// Split options into those, which are selected and the rest.
			if ( empty( $option_value ) || \in_array( $option_value, $field_escaped_value, false ) ) {
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
	 * @param array $all_options
	 * @param array $selected_options
	 *
	 * @return array
	 */
	protected function put_selected_options_first( array $all_options, array $selected_options ) : array {
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
	 * Add new terms to the db and the object
	 * If either option is set to do so
	 *
	 * Also needed for repeater fields
	 *
	 * @param mixed      $check
	 * @param mixed      $meta_value
	 * @param int|string $id - Post id on post screens, field key on settings screens.
	 *
	 * @param array      $field_args
	 *
	 * @return array|null
	 */
	public function assign_terms_during_save( $check, $meta_value, $id, array $field_args ) : ?array {
		if ( ! \is_array( $meta_value ) || empty( $meta_value ) ) {
			return $check;
		}

		if ( $field_args[ self::CREATE_NEW_TERMS ] ) {
			if ( $field_args['repeatable'] ) {
				foreach ( $meta_value as $k => $terms ) {
					$meta_value[ $k ] = $this->create_terms( $terms, $this->get_taxonomy( $field_args ) );
				}
			} else {
				$meta_value = $this->create_terms( $meta_value, $this->get_taxonomy( $field_args ) );
			}
		}

		if ( ! empty( $id ) && $field_args[ self::SAVE_AS_TERMS ] ) {
			wp_add_object_terms( $id, \array_map( '\intval', $meta_value ), $this->get_taxonomy( $field_args ) );
		}

		return $meta_value;
	}


	private function create_terms( array $terms, string $taxonomy ) : array {
		foreach ( $terms as $key => $val ) {
			if ( ! \is_numeric( $val ) ) {
				$term = wp_create_term( $val, $taxonomy );
				if ( ! is_wp_error( $term ) ) {
					$terms [ $key ] = (string) $term['term_id'];
				}
			}
		}

		return $terms;
	}


	/**
	 * Handle repeatable data escaping
	 *
	 * @param ?array   $checked
	 * @param array|string $values
	 * @param array        $field_args
	 *
	 * @return array|null
	 */
	public function esc_repeater_values( ?array $checked, $values, array $field_args ) : ?array {
		if ( ! \is_array( $values ) || ! $field_args['repeatable'] ) {
			return $checked;
		}

		foreach ( $values as $key => $val ) {
			$values[ $key ] = \array_map( 'esc_attr', $val );
		}

		return $values;
	}


	/**
	 * Get the set taxonomy or fallback to 'category'
	 *
	 * @param array $field_args
	 *
	 * @return string
	 */
	private function get_taxonomy( array $field_args ) : string {
		return $field_args['taxonomy'] ?? 'category';
	}
}
