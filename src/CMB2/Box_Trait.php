<?php

namespace Lipe\Lib\CMB2;

use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Traits\Memoize;

trait Box_Trait {
	use Memoize;

	/**
	 * All fields registered to this box.
	 *
	 * @var Field[]|Group[]
	 */
	protected $fields = [];

	/**
	 * An array containing post type slugs, or 'user', 'term', 'comment', or 'options-page'.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#object_types
	 * @example [ 'page', 'post' ]
	 *
	 * @var array
	 */
	protected $object_types = [];


	/**
	 * Hook into `cmb2_init` to register all the fields.
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
			if ( $this->is_group() ) {
				add_action( 'cmb2_init', [ $this, 'register_fields' ], 12 );
			} else {
				add_action( 'cmb2_init', [ $this, 'register_fields' ], 11 );
			}
		}, __METHOD__ );
	}


	/**
	 * Add a field to this box.
	 * For shorthand calls where no special setting is necessary.
	 *
	 * @param $id
	 * @param $name
	 *
	 * @example $box->field( $id, $name )->checkbox();
	 *
	 * @return Field_Type
	 */
	public function field( $id, $name ) : Field_Type {
		$this->hook();
		$this->fields[ $id ] = new Field( $id, $name, $this );

		return $this->fields[ $id ]->type();
	}


	/**
	 * Add a group to this box
	 * For shorthand calls where no special setting is necessary.
	 *
	 * @param string      $id
	 * @param string      $title
	 * @param string|null $group_title           - include a {#} to have replaced with number
	 * @param string|null $add_button_text
	 * @param string|null $remove_button_text
	 * @param bool        $sortable
	 * @param bool        $closed
	 * @param string|null $remove_confirm        - @since 2.7.0 -
	 *                                           A message to display when a user attempts
	 *                                           to delete a group.
	 *                                           (Defaults to null/false for no confirmation)
	 *
	 *
	 * @example $group = $box->group( $id, $name );
	 *
	 * @return Group
	 */
	public function group( $id, $title, $group_title = null, $add_button_text = null, $remove_button_text = null, $sortable = true, $closed = false, ?string $remove_confirm = null ) : Group {
		$this->hook();
		$this->fields[ $id ] =
			new Group( $id, $title, $this, $group_title, $add_button_text, $remove_button_text, $sortable, $closed, $remove_confirm );

		return $this->fields[ $id ];
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
		array_map( function ( Field $field ) {
			$this->register_meta( $field );
			if ( empty( $this->show_in_rest ) ) {
				$this->selectively_show_in_rest( $field );
			}
			$this->add_field_to_box( $field );
		}, $this->get_fields() );
	}


	/**
	 * Register the meta field with WP core for things like
	 * `show_in_rest` and `default.
	 *
	 * Only supports simple data types.
	 *
	 * @requires WP 5.5+ for default values.
	 *
	 * @param Field $field
	 *
	 * @since    2.19.0
	 *
	 */
	protected function register_meta( Field $field ) : void {
		if ( ! $this->is_allowed_to_register_meta( $field ) ) {
			return;
		}
		$config = [
			'single' => true,
			'type'   => 'string',
		];
		if ( $field->is_using_array_data() ) {
			$config['type'] = 'array';
		}
		if ( $field->show_in_rest ) {
			$config['show_in_rest'] = $field->show_in_rest;
			if ( $field->is_using_array_data() ) {
				$config['show_in_rest'] = [
					'schema' => [
						'items' => [
							'type' => 'string',
						],
					],
				];
			}
		}

		$this->register_meta_on_all_types( $field, $config );
	}


	/**
	 * If we have marked particular fields `show_in_rest` without marking the box,
	 * this marks the box "true" which marking any non specified fields to "false".
	 *
	 * Makes selectively adding fields to rest much simpler.
	 *
	 * @param Field $field
	 *
	 * @since 2.15.0
	 *
	 * @internal
	 *
	 */
	protected function selectively_show_in_rest( Field $field ) : void {
		if ( ! empty( $field->show_in_rest ) ) {
			$this->show_in_rest = true;
		} else {
			$field->show_in_rest = false;
		}
	}


	/**
	 * Is this field allowed to be registered with meta?
	 *
	 * @param Field $field
	 *
	 * @since 2.19.0
	 *
	 * @return bool
	 */
	protected function is_allowed_to_register_meta( Field $field ) : bool {
		return \in_array( $field->data_type, [ Repo::CHECKBOX, Repo::DEFAULT, Repo::FILE ], true );
	}


	/**
	 * Get all fields registered to this box.
	 *
	 * @since 2.19.0
	 *
	 * @return Field[]|Group[]
	 */
	protected function get_fields() : array {
		return $this->fields;
	}


	/**
	 * Are we currently working with a Group?
	 *
	 * @since 2.19.0
	 *
	 * @return bool
	 */
	public function is_group() : bool {
		return self::class === Group::class;
	}


	/**
	 * Get the type of object this box is registered to.
	 *
	 * @since 2.19.0
	 *
	 * @return string
	 */
	public function get_object_type() : string {
		switch ( $this->object_types[0] ) {
			case 'comment':
			case 'options-page':
			case 'user':
			case 'term':
				return $this->object_types[0];
			default:
				return 'post';
		}
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
		return $this->object_types;
	}
}
