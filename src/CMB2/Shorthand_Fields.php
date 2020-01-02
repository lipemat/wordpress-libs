<?php
namespace Lipe\Lib\CMB2;

use Lipe\Lib\Traits\Memoize;

trait Shorthand_Fields {
	use Memoize;

	/**
	 * For shorthand fields that don't call $this->add_field
	 *
	 * @see \Lipe\Lib\CMB2\Box::register_shorthand_fields();
	 * @see \Lipe\Lib\CMB2\Box::field();
	 *
	 * @var Field[]|Group[]
	 */
	protected $fields = [];


	/**
	 * Hook into `cmb2_init` to register all the shorthand fields.
	 *
	 * We use `cmb2_init` instead of `cmb2_admin_init` so this may be used in the admin
	 * or on the front end.
	 *
	 * If the core plugin is registering fields via `cmb2_admin_init` only, this will
	 * never get called anyway, so we can control if we need front end fields from there.
	 *
	 * @return void
	 */
	protected function hook() : void {
		$this->once( function () {
			// Be sure to run register_shorthand fields on groups after the box.
			if ( self::class === Group::class ) {
				add_action( 'cmb2_init', [ $this, 'register_shorthand_fields' ], 12 );
			} else {
				add_action( 'cmb2_init', [ $this, 'register_shorthand_fields' ], 11 );
			}
		}, __METHOD__ );
	}


	/**
	 * Add a field to this box.
	 * For shorthand calls where no special setting is necessary.
	 *
	 * @example $box->field( $id, $name )->checkbox();
	 *
	 * @param $id
	 * @param $name
	 *
	 * @return Field_Type
	 */
	public function field( $id, $name ) : Field_Type {
		$this->hook();
		$this->fields[ $id ] = new Field( $id, $name );

		return $this->fields[ $id ]->type();
	}


	/**
	 * Add a group to this box
	 * For shorthand calls where no special setting is necessary
	 *
	 * @example $group = $box->group( $id, $name );
	 *
	 * @see \Lipe\Lib\CMB2\Shorthand_Fields
	 *
	 *
	 * @param string $id
	 * @param string $title
	 * @param string $group_title - include a {#} to have replace with number
	 * @param string $add_button_text
	 * @param string $remove_button_text
	 * @param bool   $sortable
	 * @param bool   $closed
	 * @param string             $remove_confirm - @since 2.7.0 -
	 *                                           A message to display when a user attempts
	 *                                           to delete a group.
	 *                                           (Defaults to null/false for no confirmation)
	 *
	 *
	 * @return Group
	 */
	public function group( $id, $title, $group_title = null, $add_button_text = null, $remove_button_text = null, $sortable = true, $closed = false, ?string $remove_confirm = null ) : Group {
		$this->hook();
		$this->fields[ $id ] = new Group( $id, $title, $this, $group_title, $add_button_text, $remove_button_text, $sortable, $closed, $remove_confirm );

		return $this->fields[ $id ];
	}


	/**
	 * Registers any fields which were adding using $this->field()
	 * when the `cmb2_init` action fires.
	 *
	 * Allows for storing/appending a fields properties beyond
	 * a basic return pattern.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function register_shorthand_fields() : void {
		if ( empty( $this->show_in_rest ) ) {
			array_map( [ $this, 'selectively_show_in_rest' ], $this->get_shorthand_fields() );
		}

		array_map( [ $this, 'add_field' ], $this->get_shorthand_fields() );
	}


	/**
	 * If we have marked particular fields `show_in_rest` without marking the box,
	 * this marks the box "true" which marking any non specified fields to "false".
	 *
	 * Makes selectively adding fields to rest much simpler.
	 *
	 * @internal
	 *
	 * @since 2.15.0
	 *
	 * @param Field $field
	 */
	private function selectively_show_in_rest( Field $field ) : void {
		if ( ! empty( $field->show_in_rest ) ) {
			$this->show_in_rest = true;
		} else {
			$field->show_in_rest = false;
		}
	}


	/**
	 * Get all fields registered in a shorthand way
	 *
	 * @return Field[]|Group[]
	 */
	protected function get_shorthand_fields() : array {
		return $this->fields;
	}

}
