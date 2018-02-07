<?php
/**
 * Shorthand_Fields.php
 *
 * @author  mat
 * @since   12/6/2017
 *
 * @package Lipe\Lib\CMB2 *
 */

namespace Lipe\Lib\CMB2;

trait Shorthand_Fields {

	/**
	 * For shorthand fields that don't call $this->add_field
	 *
	 * @see \Lipe\Lib\CMB2\Box::register_shorthand_fields();
	 * @see \Lipe\Lib\CMB2\Box::field();
	 *
	 * @var \Lipe\Lib\CMB2\Field[]|\Lipe\Lib\CMB2\Group[]
	 */
	protected $fields = [];


	/**
	 * Hook into cmb2_init to register all the shorthand fields
	 * We use cmb2_init instead of cmb2_admin_init so this may be used in the admin
	 * or on the front end.
	 * If the core plugin is registering fields via cmb2_admin_init only this will
	 * never get called anyway, so we can control if we need front end fields from there.
	 *
	 * @return void
	 */
	protected function hook() : void {
		if( !has_action( 'cmb2_init', [ $this, 'register_shorthand_fields' ] ) ){
			//be sure to run register_shorthand fields on groups after the box
			if( self::class === Group::class ){
				add_action( 'cmb2_init', [ $this, 'register_shorthand_fields' ], 12 );
			} else {
				add_action( 'cmb2_init', [ $this, 'register_shorthand_fields' ], 11 );
			}
		}
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
	 * @return \Lipe\Lib\CMB2\Field_Type
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
	 *
	 *
	 * @return \Lipe\Lib\CMB2\Group
	 */
	public function group( $id, $title, $group_title = null, $add_button_text = null, $remove_button_text = null, $sortable = true, $closed = false ) : Group {
		$this->hook();
		$this->fields[ $id ] = new Group( $id, $title, $this, $group_title, $add_button_text, $remove_button_text, $sortable, $closed );

		return $this->fields[ $id ];
	}


	/**
	 * Registers any fields which were adding using $this->field()
	 * when the cmb2_init action fires.
	 * This allows for storing/appending a fields properties beyond
	 * a basic return pattern
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function register_shorthand_fields() : void {
		foreach( $this->get_shorthand_fields() as $_field ){
			$this->add_field( $_field );
		}
	}


	/**
	 * Get all fields registered in a shorthand way
	 *
	 * @return \Lipe\Lib\CMB2\Field[]|\Lipe\Lib\CMB2\Group[]
	 */
	protected function get_shorthand_fields() : array {
		return $this->fields;
	}

}
