<?php

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Group\Layout;
use Lipe\Lib\Meta\Repo;

/**
 * Group field type which implement much of the
 * logic of a Box and also a Field.
 *
 * @author  Mat Lipe
 *
 * @package Lipe\Lib\CMB2
 */
class Group extends Field {
	use Box_Trait;

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
	 * Display format for the group
	 *
	 * block (default), row, table
	 *
	 * @var string
	 */
	protected $layout = 'block';


	/**
	 * Group constructor.
	 *
	 * @param string        $id
	 * @param string        $title
	 * @param Box|Box_Trait $box
	 * @param string|null   $group_title           - include a {#} to have replaced with number
	 * @param string|null   $add_button_text
	 * @param string|null   $remove_button_text
	 * @param bool          $sortable
	 * @param bool          $closed
	 * @param string|null   $remove_confirm        - @since 2.7.0 -
	 *                                             A message to display when a user attempts
	 *                                             to delete a group.
	 *                                             (Defaults to null/false for no confirmation)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#group
	 */
	public function __construct( $id, $title, Box $box, $group_title = null, $add_button_text = null, $remove_button_text = null, $sortable = true, $closed = false, ?string $remove_confirm = null ) {
		$this->type()->group( $group_title, $add_button_text, $remove_button_text, $sortable, $closed, $remove_confirm );

		parent::__construct( $id, $title, $box );
	}


	/**
	 * Display format for the group.
	 *
	 * block (default), row, table
	 *
	 * @param string $layout
	 *
	 * @return Group
	 */
	public function layout( string $layout ) : Group {
		if ( 'block' === $layout ) {
			return $this;
		}
		Layout::init_once();
		if ( $this->tab ) {
			$this->tab_content_cb = [ Layout::in(), 'render_group_callback' ];
		} else {
			$this->render_row_cb( [ Layout::in(), 'render_group_callback' ] );
		}

		$this->layout = $layout;

		return $this;
	}


	/**
	 * Assign a field to a group, then register it.
	 *
	 * @param Field $field
	 *
	 * @since 2.19.0
	 *
	 * @throws \LogicException
	 * @return void
	 */
	protected function add_field_to_group( Field $field ) : void {
		if ( null === $this->box->cmb ) {
			throw new \LogicException( 'You must add the group to the box before you add fields to the group.' );
		}

		$field->group = $this->get_id();
		$box = $this->box->get_box();
		$box->add_group_field( $this->id, $field->get_field_args(), $field->position );

		Repo::in()->register_field( $field );
	}


	/**
	 * Retrieve this field's arguments to be registered
	 * with CMB2.
	 *
	 * @see Box::add_field_to_box()
	 *
	 * @throws \LogicException
	 *
	 * @return array
	 */
	public function get_field_args() : array {
		$args = parent::get_field_args();
		unset( $args['box'], $args['fields'] );

		return $args;
	}


	/**
	 * Registers any fields which were adding using $this->field()
	 * when the `cmb2_init` action fires.
	 *
	 * Allows for storing/appending a fields properties beyond
	 * a basic return pattern.
	 *
	 * @since 2.19.0
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function register_fields() : void {
		$this->register_meta();
		array_map( function ( Field $field ) {
			$this->add_field_to_group( $field );
		}, $this->get_fields() );
	}


	/**
	 * Register the meta field with WP core for things like
	 * `show_in_rest` and `default.
	 *
	 * @requires WP 5.5+ for default values.
	 *
	 * @since    2.19.0
	 */
	protected function register_meta() : void {
		$config = [
			'single' => true,
			'type'   => 'array',
		];
		if ( $this->show_in_rest && $this->is_public_rest_data( $this ) ) {
			$properties = [];
			foreach ( $this->get_fields() as $field ) {
				if ( $this->show_in_rest ) {
					$properties[ $field->get_id() ] = [
						'type' => 'string',
					];
					if ( $field->is_using_array_data() ) {
						$properties[ $field->get_id() ] = [
							'type'  => 'array',
							'items' => [
								'type' => 'string',
							],
						];
					}
					if ( Repo::FILE === $field->data_type ) {
						$properties[ $field->get_id() . '_id' ] = [
							'type' => 'number',
						];
					}
				}
			}
			$config['show_in_rest'] = [
				'schema' => [
					'items' => [
						'type'       => 'object',
						'properties' => $properties,
					],
				],
			];
		}

		$this->box->register_meta_on_all_types( $this, $config );
	}


	/**
	 * Get the full list of object types this box
	 * is registered to.
	 *
	 * @since 2.19.0
	 *
	 * @return array
	 */
	public function get_object_types() : array {
		return $this->box->get_object_types();
	}


	/**
	 * @override
	 *
	 * @throws \LogicException
	 */
	public function group() : void {
		throw new \LogicException( 'You cannot add a group to another group.' );
	}
}
