<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

/**
 * Custom handling for default values using a callback.
 *
 * @author Mat Lipe
 * @since  5.0.0
 */
class Default_Callback {
	/**
	 * Build an instance for handling default values on this field.
	 *
	 * @param Field                                 $field    - Field instance.
	 * @param Box                                   $box      - Box instance.
	 * @param callable( object, \CMB2_Field): mixed $callback - Callback to use for default value.
	 */
	public function __construct(
		protected readonly Field $field,
		protected readonly Box $box,
		protected $callback,
	) {
		$this->hook();
	}


	/**
	 * Hook into the appropriate filters to support default values.
	 *
	 * @return void
	 */
	protected function hook(): void {
		if ( 'options-page' === $this->box->get_object_type() ) {
			add_filter( "cmb2_default_option_{$this->box->get_id()}_{$this->field->get_id()}", [
				$this,
				'default_option_callback',
			], 11 );
		} else {
			add_filter( "default_{$this->box->get_object_type()}_metadata", [
				$this,
				'default_meta_callback',
			], 11, 3 );
		}
	}


	/**
	 * Support default meta using a callback.
	 *
	 * Register meta only support static values to be used as default,
	 * although we may pass a callback when registering the CMB2 field.
	 * CMB2 only support defaults in the meta box, not when retrieving
	 * data, so we tap into core WP default a meta filter to support
	 * the callback.
	 *
	 * @filter default_{$meta_type}_metadata 11, 3
	 *
	 * @param mixed      $value     - Empty, or a value set by another filter.
	 * @param int|string $object_id - Current post/term/user id.
	 * @param string     $meta_key  - Meta key being filtered.
	 *
	 * @return mixed
	 */
	public function default_meta_callback( mixed $value, int|string $object_id, string $meta_key ): mixed {
		if ( $this->field->get_id() !== $meta_key ) {
			return $value;
		}

		// Will create an infinite loop if filter is intact.
		remove_filter( "default_{$this->box->get_object_type()}_metadata", [ $this, 'default_meta_callback' ], 11 );
		$cmb2_field = $this->field->get_cmb2_field( $object_id );
		if ( null !== $cmb2_field ) {
			add_filter( "default_{$this->box->get_object_type()}_metadata", [ $this, 'default_meta_callback' ], 11, 3 );
			return \call_user_func( $this->callback, $cmb2_field->properties, $cmb2_field );
		}

		return false;
	}


	/**
	 * Support default options using a callback.
	 *
	 * CMB2 takes care of rendering default values on the
	 * options pages, this takes care of returning default
	 * values when retrieving options.
	 *
	 * CMB2 stores options data a one big blog, so we
	 * can't tap into WP core default option filters.
	 * Instead, we tap into the custom filters added to
	 * lipemat/cmb2.
	 *
	 * @filter cmb2_default_option_{$this->key}_{$field_id} 11 0
	 *
	 * @return mixed
	 */
	public function default_option_callback(): mixed {
		$cmb2_field = $this->field->get_cmb2_field();
		if ( null === $cmb2_field ) {
			return false;
		}
		$cmb2_field->object_id( $this->box->get_id() );
		return \call_user_func( $this->callback, $cmb2_field->properties, $cmb2_field );
	}
}
