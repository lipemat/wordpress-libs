<?php

namespace Lipe\Lib\CMB2\Field;

use Lipe\Lib\CMB2\Field_Type;
use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Traits\Singleton;

/**
 * Overrides for the checkbox field
 *
 * @see    Field_Type::checkbox()
 */
class Checkbox {
	use Singleton;
	use Memoize;


	/**
	 * Displays the checkbox in a more compact form.
	 * Useful for checkboxes in side meta boxes.
	 *
	 * Copied mostly from CMB2_Field::render_field_callback()
	 *
	 * @param  array       $args  Array of field arguments for the group field parent.
	 * @param  \CMB2_Field $field The CMB2_Field group object.
	 *
	 * @see Field_Type::checkbox()
	 * @example $box->field()->checkbox('compact')
	 *
	 * @return \CMB2_Field|null
	 */
	public function render_field_callback( array $args, \CMB2_Field $field ) : ?\CMB2_Field {
		if ( ! $field->should_show() || ( ! is_admin() && ! (bool) $field->args( 'on_front' ) ) ) {
			return null;
		}
		// default layout, nothing to do here.
		if ( 'block' === $field->args( 'layout' ) ) {
			return $field->render_field_callback();
		}

		$field->peform_param_callback( 'before_row' );

		printf( "<div class=\"cmb-row checkbox-compact %s\" data-fieldtype=\"%s\">\n", esc_attr( $field->row_classes() ), esc_attr( $field->type() ) );

		$field->peform_param_callback( 'before' );

		$_field = clone $field;
		$_field->args['description'] = '';
		$types = new \CMB2_Types( $_field );
		$types->render();

		if ( (bool) $field->args( 'show_names' ) ) {
			if ( (bool) $field->get_param_callback_result( 'label_cb' ) ) {
				$field->peform_param_callback( 'label_cb' );
			}
			echo '<br />';
		} else {
			$field->peform_param_callback( 'label_cb' );
			echo '<br />';
		}

		$_field->args['description'] = $field->args['description'];
		$types->_desc( false, true );

		$field->peform_param_callback( 'after' );

		echo "\n\t</div>";

		$this->styles();

		$field->peform_param_callback( 'after_row' );

		// For chaining.
		return $field;
	}


	/**
	 * Add styles for the checkbox field.
	 *
	 * @return void
	 */
	protected function styles() : void {
		$this->once( function() {
			?>
			<style>
				.checkbox-compact {
					padding: 0 0 1em !important;
				}

				.checkbox-compact label {
					display: inline-block !important;
				}
			</style>
			<?php
		}, __METHOD__, [] );
	}
}
