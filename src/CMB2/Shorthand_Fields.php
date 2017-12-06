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
	 * Add a field to this box.
	 * For shorthand calls where no special setting is necessary.
	 *
	 * @example $box->field( $id, $name )->checkbox();
	 *
	 * @notice  This will currently not work on the front end of the site
	 *         due to using the admin only init.
	 *         For boxes that are needed on the front end use the
	 *         long hand version of registering fields
	 *
	 * @param $id
	 * @param $name
	 *
	 * @return \Lipe\Lib\CMB2\Field_Type
	 */
	public function field( $id, $name ) : Field_Type {
		if( !has_action( 'cmb2_admin_init', [ $this, 'register_shorthand_fields' ] ) ){
			add_action( 'cmb2_admin_init', [ $this, 'register_shorthand_fields' ], 11 );
		}

		$this->fields[ $id ] = new Field( $id, $name );

		return $this->fields[ $id ]->type();
	}


	/**
	 * Registers any fields which were adding using $this->field()
	 * when the cmb2_init action fires.
	 * This allows for storing/appending a fields properties beyond
	 * a basic return pattern
	 *
	 * @return void
	 */
	public function register_shorthand_fields() : void {
		foreach( $this->get_shorthand_fields() as $_field ){
			$this->add_field( $_field );
		}
	}


	protected function get_shorthand_fields() : array {
		return $this->fields;
	}

}