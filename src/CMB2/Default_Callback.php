<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\Meta\Registered;
use Lipe\Lib\Util\Actions;

/**
 * Custom handling for default values using a callback.
 *
 * @author Mat Lipe
 * @since  5.0.0
 *
 * @phpstan-type DEFAULT_CB callable( array<string, mixed>, \CMB2_Field ): mixed
 */
class Default_Callback {
	/**
	 * Build an instance for handling default values on this field.
	 *
	 * @phpstan-param DEFAULT_CB $callback
	 *
	 * @param Registered         $field    - Field instance.
	 * @param Box                $box      - Box instance.
	 * @param callable           $callback - Callback to use for default value.
	 */
	final protected function __construct(
		protected readonly Registered $field,
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
		if ( BoxType::OPTIONS === $this->box->get_box_type() ) {
			Actions::in()->add_looping_filter( "cmb2_default_option_{$this->box->get_id()}_{$this->field->get_id()}", [
				$this,
				'default_option_callback',
			], 11 );
		} else {
			Actions::in()->add_looping_filter( "default_{$this->box->get_box_type()->value}_metadata", [
				$this,
				'default_meta_callback',
			], 11 );
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

		$cmb2_field = $this->field->get_cmb2_field();
		if ( null === $cmb2_field ) {
			return false;
		}
		$cmb2_field->object_id( $object_id );
		return \call_user_func( $this->callback, $cmb2_field->properties, $cmb2_field );
	}


	/**
	 * Support default options using a callback.
	 *
	 * CMB2 takes care of rendering default values on the
	 * options pages, this takes care of returning default
	 * values when retrieving options.
	 *
	 * CMB2 stores options data a one big blob, so we
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


	/**
	 * Create an instance of the default callback handler.
	 *
	 * @phpstan-param DEFAULT_CB $callback
	 *
	 * @param Field              $field    - Field instance.
	 * @param Box                $box      - Box instance.
	 * @param callable           $callback - Callback to use for default value.
	 *
	 * @return Default_Callback
	 */
	public static function factory( Field $field, Box $box, callable $callback ): Default_Callback {
		return new static( Registered::factory( $field ), $box, $callback );
	}
}
