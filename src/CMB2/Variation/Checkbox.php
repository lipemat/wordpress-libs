<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

use Lipe\Lib\CMB2\Field;

/**
 * @author Mat Lipe
 * @since  5.0.0
 *
 */
class Checkbox extends Field {
	/**
	 * Specify a function to return the default value fo rthe field
	 *
	 * @notice  Checkboxes are tricky.
	 * @see     https://github.com/CMB2/CMB2/wiki/Tips-&-Tricks#setting-a-default-value-for-a-checkbox
	 *
	 * @example
	 * ```
	 * function prefix_set_test_default($field_args, \CMB2_Field $field) {
	 *      return isset($_GET['post']) ? '' : true;
	 * }
	 * ```
	 *
	 * @param callable|string|array<mixed> $default_value - Only a callback is supported for checkboxes.
	 *
	 * @throws \LogicException - If a standard default value is passed.
	 * @return static
	 */
	public function default( callable|string|array $default_value ): static {
		if ( ! \is_callable( $default_value ) ) {
			/* translators: {field id} */
			throw new \LogicException( \sprintf( esc_html__( 'Checkboxes do not support standard default values. %s', 'lipe' ), esc_html( $this->id ) ) . '. See https://github.com/CMB2/CMB2/wiki/Tips-&-Tricks#setting-a-default-value-for-a-checkbox' );
		}
		return parent::default( $default_value );
	}
}
