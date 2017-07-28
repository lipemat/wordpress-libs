<?php

namespace Lipe\Lib\CMB2;

use WP_CLI\Iterators\Exception;

/**
 * Group
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Lib\CMB2
 */
class Group extends Field {
	/**
	 * ONLY APPLIES TO GROUPS
	 *
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @var callable|string
	 */
	public $before_group;

	/**
	 * ONLY APPLIES TO GROUPS
	 *
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @var callable|string
	 */
	public $after_group;

	/**
	 * ONLY APPLIES TO GROUPS
	 *
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @var callable|string
	 */
	public $before_group_row;

	/**
	 * ONLY APPLIES TO GROUPS
	 *
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @var callable|string
	 */
	public $after_group_row;

	/**
	 * box
	 *
	 * @var \Lipe\Lib\CMB2\Box
	 */
	protected $box;


	/**
	 * Group constructor.
	 *
	 * @param string             $id
	 * @param string             $name
	 * @param \Lipe\Lib\CMB2\Box $box
	 * @param string             $desc
	 */
	public function __construct( $id, $name, Box $box, $desc = '' ) {
		$this->box = $box;

		parent::__construct( $id, $name, Field_Type::types()->group, $desc );
	}


	/**
	 *
	 * @param \Lipe\Lib\CMB2\Field $field
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function add_field( Field $field ) {
		if( !isset( $this->box->cmb ) ){
			throw new \Exception( 'You must add the group to the box before you add fields to the group' );
		}
		$box = $this->box->get_box();
		$box->add_group_field( $this->id, $field->get_field_args() );
	}


	public function get_field_args() {
		$args = parent::get_field_args();
		unset( $args[ 'box' ] );

		return $args;
	}

}