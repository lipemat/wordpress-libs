<?php

namespace Lipe\Lib\CMB2\Field_Types;

use CMB2_Field;
use CMB2_Type_Select;
use CMB2_Types;
use Lipe\Lib\Traits\Singleton;

/**
 * Select 2 Field for Terms
 *
 * @author  Mat Lipe
 * @since   1.2.0
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

	public const GET_TERMS = 'lipe/lib/cmb2/field-types/term-select-2/ajax';


	protected function hook() : void {
		\add_action( 'cmb2_render_' . self::NAME, [ $this, 'render' ], 10, 5 );
		\add_filter( 'cmb2_sanitize_' . self::NAME, [ $this, 'sanitize_value' ], 10, 4 );
		\add_filter( 'cmb2_types_esc_' . self::NAME, [ $this, 'escaped_value' ], 10, 3 );

		\add_action( 'admin_enqueue_scripts', [ $this, 'js' ] );
		//remove subtle conflict with acf
		\add_filter( 'acf/settings/select2_version', function () {
			return 4;
		} );

		\add_action( 'wp_ajax_' . self::GET_TERMS, [ $this, 'ajax_get_terms' ] );
	}


	public function ajax_get_terms() : void {
		$terms = get_terms( [
			'number'   => 10,
			'taxonomy' => $_REQUEST[ 'taxonomy' ],
			'search'   => sanitize_text_field( $_POST[ 'q' ] ?? '' ),
			'fields'   => 'id=>name',
		] );
		\wp_send_json( $terms );
	}


	public function js() : void {
		\wp_enqueue_style( 'select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' );
		\wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js' );
	}


	public function render( CMB2_Field $field, $value, $object_id, string $object_type, CMB2_Types $field_type_object ) : void {
		if( empty( $value ) ){
			$value = null;
		}
		$url_args = [
			'action'   => self::GET_TERMS,
			'taxonomy' => $field->args( 'taxonomy' ) ?? 'category',
		];
		$url = \add_query_arg( $url_args, admin_url( 'admin-ajax.php' ) );

		?>
		<script>
			(function( $ ){
				$( document ).ready( function(){
					$( '#<?= esc_js( $field_type_object->_id() ); ?>' ).select2( {
						ajax : {
							url : '<?= $url; ?>',
							dataType : 'json',
							type : "POST",
							cache : true,
							minimumInputLength : 3,
							delay : 250,
							processResults : function( data ){
								var options = [];
								if( data ){
									$.each( data, function( index, text ){
										options.push( {
											id : index,
											text : text
										} );
									} );
								}
								return {
									results : options
								};
							},
						},
						cache : true
					} );
				} );
			})( jQuery );
		</script>
		<?php

		$field_type_object->type = new CMB2_Type_Select( $field_type_object );

		$a = [
			'multiple'         => empty( $field->args( 'multiple' ) ) ? 'multiple' : $field->args( 'multiple' ),
			'style'            => 'width: 99%',
			'name'             => $field_type_object->_name() . '[]',
			'id'               => $field_type_object->_id(),
			'desc'             => $field_type_object->_desc( true ),
			'options'          => $this->get_multiselect_options( $value, $field_type_object ),
			'data-placeholder' => $field->args( 'attributes', 'placeholder' ) ?? $field->args( 'description' ),
		];

		$attrs = $field_type_object->concat_attrs( $a, [ 'desc', 'options' ] );
		echo \sprintf( '<select%s>%s</select>%s', $attrs, $a[ 'options' ], $a[ 'desc' ] );
	}


	/**
	 * Return the list of options, with selected options at the top preserving their order. This also handles the
	 * removal of selected options which no longer exist in the options array.
	 *
	 * @param array      $field_escaped_value
	 * @param CMB2_Types $field_type_object
	 *
	 * @return string
	 */
	public function get_multiselect_options( ?array $field_escaped_value = [], CMB2_Types $field_type_object ) : string {
		$options = (array) $field_type_object->field->options();

		// If we have selected items, we need to preserve their order
		if( !empty( $field_escaped_value ) ){
			if( !empty( $options ) ){
				$options = $this->sort_array_by_array( $options, $field_escaped_value );
			} else {
				$options = \get_terms( [
					'include' => $field_escaped_value,
					'fields'  => 'id=>name',
				] );
			}
		}

		$selected_items = '';
		$other_items = '';

		foreach( $options as $option_value => $option_label ){

			// Clone args & modify for just this item
			$option = [
				'value' => $option_value,
				'label' => $option_label,
			];

			// Split options into those which are selected and the rest
			if( empty( $options ) || \in_array( $option_value, $field_escaped_value, false ) ){
				$option[ 'checked' ] = true;
				$selected_items .= $field_type_object->select_option( $option );
			} else {
				$other_items .= $field_type_object->select_option( $option );
			}
		}

		return $selected_items . $other_items;
	}


	/**
	 * Sort an array by the keys of another array
	 *
	 * @param array $array
	 * @param array $order_array
	 *
	 * @return array
	 */
	public function sort_array_by_array( array $array, array $order_array ) : array {
		$ordered = [];

		foreach( $order_array as $key ){
			if( \array_key_exists( $key, $array ) ){
				$ordered[ $key ] = $array[ $key ];
				unset( $array[ $key ] );
			}
		}

		return $ordered + $array;
	}


	/**
	 * Handle sanitization for repeatable fields
	 *
	 * @param mixed $check
	 * @param mixed $meta_value
	 * @param array $field_args
	 * @param int   $object_id
	 *
	 * @return mixed
	 *
	 */
	public function sanitize_value( $check, $meta_value, $object_id, array $field_args ) : ?array {
		if( !\is_array( $meta_value ) || !$field_args[ 'repeatable' ] ){
			return $check;
		}

		foreach( $meta_value as $key => $val ){
			$meta_value[ $key ] = array_map( 'sanitize_text_field', $val );
		}

		return $meta_value;
	}


	/**
	 * Handle escaping for repeatable fields
	 *
	 * @param mixed $check
	 * @param mixed $meta_value
	 * @param array $field_args
	 *
	 * @return mixed
	 */
	public function escaped_value( $check, $meta_value, array $field_args ) : ?array {
		if( !\is_array( $meta_value ) || !$field_args[ 'repeatable' ] ){
			return $check;
		}

		foreach( $meta_value as $key => $val ){
			$meta_value[ $key ] = \array_map( 'esc_attr', $val );
		}

		return $meta_value;
	}
}
