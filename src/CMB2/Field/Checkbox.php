<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Field;

use Lipe\Lib\CMB2\Field_Type;
use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Libs\Scripts\StyleHandles;
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

	public const LAYOUT_BLOCK   = 'block';
	public const LAYOUT_COMPACT = 'compact';


	/**
	 * Displays the checkbox in a more compact form.
	 * Useful for checkboxes in side meta boxes.
	 *
	 * @see     CMB2_Field::render_field_callback()
	 * @see     Field_Type::checkbox()
	 * @example $box->field()->checkbox('compact')
	 *
	 * @param array<string, mixed> $args  Array of field arguments for the group field parent.
	 * @param \CMB2_Field          $field The CMB2_Field group object.
	 *
	 * @return \CMB2_Field|void
	 */
	public function render_field_callback( array $args, \CMB2_Field $field ) {
		if ( ! $field->should_show() || ( ! is_admin() && ! (bool) $field->args( 'on_front' ) ) ) {
			return;
		}
		// Default layout, nothing to do here.
		if ( self::LAYOUT_BLOCK === $field->args( 'layout' ) ) {
			$field->render_field_callback();
			return;
		}

		Scripts::in()->enqueue_style( StyleHandles::CHECKBOX );

		$field->peform_param_callback( 'before_row' );

		\printf( "<div class=\"cmb-row checkbox-compact %s\" data-fieldtype=\"%s\">\n", esc_attr( $field->row_classes() ), esc_attr( $field->type() ) );

		$field->peform_param_callback( 'before' );

		$_field = clone $field;
		$_field->args['description'] = '';
		$types = new \CMB2_Types( $_field );
		$types->render();

		if ( (bool) $field->args( 'show_names' ) ) {
			if ( (bool) $field->get_param_callback_result( 'label_cb' ) ) {
				$field->peform_param_callback( 'label_cb' );
			}
		} else {
			$field->peform_param_callback( 'label_cb' );
		}
		echo '<br />';

		$_field->args['description'] = $field->args['description'];
		$types->_desc( false, true );

		$field->peform_param_callback( 'after' );

		echo "\n\t</div>";

		$field->peform_param_callback( 'after_row' );

		// For chaining.
		return $field;
	}
}
