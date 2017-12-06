<?php

namespace Lipe\Lib\CMB2;

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
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_group-after_group-before_group_row-after_group_row
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
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_group-after_group-before_group_row-after_group_row
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
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_group-after_group-before_group_row-after_group_row
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
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_group-after_group-before_group_row-after_group_row
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
	 * @param string             $title
	 * @param \Lipe\Lib\CMB2\Box $box
	 * @param string             $group_title - include a {#} to have replace with number
	 * @param string             $add_button_text
	 * @param string             $remove_button_text
	 * @param bool               $sortable
	 * @param bool               $closed
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#group
	 */
	public function __construct( $id, $title, Box $box, $group_title = null, $add_button_text = null, $remove_button_text = null, $sortable = true, $closed = false ) {
		$this->box = $box;

		$this->type()->group( $group_title, $add_button_text, $remove_button_text, $sortable, $closed );

		parent::__construct( $id, $title );
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