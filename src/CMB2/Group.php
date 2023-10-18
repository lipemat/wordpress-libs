<?php

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Group\Layout;
use Lipe\Lib\Meta\Repo;

/**
 * Group field type, which implement much of the
 * logic of a Box and a Field.
 *
 * A fluent interface for CMB2 group properties.
 */
class Group extends Field {
	use Box_Trait;

	/**
	 * ONLY APPLIES TO GROUPS
	 *
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument.
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
	 * and the CMB2_Field $field object as the second argument.
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
	 * and the CMB2_Field $field object as the second argument.
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
	 * and the CMB2_Field $field object as the second argument.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_group-after_group-before_group_row-after_group_row
	 *
	 * @var callable|string
	 */
	public $after_group_row;

	/**
	 * Display format for the group
	 *
	 * Options: block (default), row, table.
	 *
	 * @phpstan-var 'block'|'row'|'table'
	 *
	 * @var string
	 */
	protected $layout = 'block';


	/**
	 * Group constructor.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#group
	 * @internal
	 *
	 * @param string      $id                      - Field ID.
	 * @param string|null $title                   - Group title.
	 * @param Box         $box                     - Box object.
	 * @param string|null $group_title             - include a {#} to have replaced with number.
	 * @param string|null $add_button_text         - Defaults to 'Add Another'.
	 * @param string|null $remove_button_text      - Defaults to 'Remove'.
	 * @param bool        $sortable                - Whether the group is sortable.
	 * @param bool        $closed                  - Whether the group is closed by default.
	 * @param string|null $remove_confirm          - A message to display when a user attempts
	 *                                             to delete a group.
	 *                                             (Defaults to null/false for no confirmation).
	 */
	public function __construct( string $id, ?string $title, Box $box, ?string $group_title = null, ?string $add_button_text = null, ?string $remove_button_text = null, bool $sortable = true, bool $closed = false, ?string $remove_confirm = null ) {
		$this->type()->group( $group_title, $add_button_text, $remove_button_text, $sortable, $closed, $remove_confirm );

		parent::__construct( $id, $title, $box );
	}


	/**
	 * Display format for the group.
	 *
	 * Options: block (default), row, table
	 *
	 * @phpstan-param 'block'|'row'|'table' $layout
	 *
	 * @param string                        $layout - Layout type.
	 *
	 * @return Group
	 */
	public function layout( string $layout ): Group {
		if ( 'block' === $layout ) {
			return $this;
		}
		Layout::init_once();
		if ( ! empty( $this->tab ) ) {
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
	 * @param Field $field - Field object.
	 *
	 * @throws \LogicException - If no box is available.
	 *
	 * @return void
	 */
	protected function add_field_to_group( Field $field ): void {
		if ( null === $this->box->cmb ) {
			throw new \LogicException( esc_html__( 'You must add the group to the box before you add fields to the group.', 'lipe' ) );
		}

		$field->group = $this->get_id();
		$field->box_id = $this->box_id;
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
	 * @return array
	 */
	public function get_field_args(): array {
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
	 * @internal
	 *
	 * @return void
	 */
	public function register_fields(): void {
		$this->register_meta();
		array_map( function( Field $field ) {
			$this->add_field_to_group( $field );
		}, $this->get_fields() );
	}


	/**
	 * Register the meta field with WP core for things like
	 * `show_in_rest` and `default.
	 */
	protected function register_meta(): void {
		$config = [
			'single' => true,
			'type'   => 'array',
		];
		if ( $this->show_in_rest && $this->is_public_rest_data( $this ) ) {
			$properties = [];
			foreach ( $this->get_fields() as $field ) {
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
				if ( $field->is_using_object_data() ) {
					$properties[ $field->get_id() ] = [
						'type'                 => 'object',
						'additionalProperties' => [
							'type' => 'string',
						],
					];
				}

				if ( Repo::TYPE_FILE === $field->data_type ) {
					$properties[ $field->get_id() . '_id' ] = [
						'type' => 'number',
					];
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
	 * @return array
	 */
	public function get_object_types(): array {
		return $this->box->get_object_types();
	}


	/**
	 * Are we currently working with a Group?
	 *
	 * @return bool
	 */
	public function is_group(): bool {
		return true;
	}


	/**
	 * Add a group to a box.
	 *
	 * This is a no-op for groups.
	 *
	 * @throws \LogicException - If trying to add to another group.
	 */
	public function group(): void {
		throw new \LogicException( esc_html__( 'You cannot add a group to another group.', 'lipe' ) );
	}
}
