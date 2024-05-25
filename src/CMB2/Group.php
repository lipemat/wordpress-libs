<?php

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Group\Layout;
use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Util\Arrays;

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
	 * @link                     https://github.com/CMB2/CMB2/wiki/Field-Types#group
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
	 *
	 * @phpstan-ignore-next-line -- Too many default arguments to account for.
	 */
	public function __construct( string $id, ?string $title, Box $box, ?string $group_title = null, ?string $add_button_text = null, ?string $remove_button_text = null, ?bool $sortable = null, bool $closed = false, ?string $remove_confirm = null ) {
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
	 * Set the group to be repeatable.
	 *
	 * Will enable sortable if not already specified as false when `\Lipe\Lib\CMB2\Field_Type::group` is called.
	 *
	 * @param bool    $repeatable   - Enable/disable repeatable support for this group.
	 * @param ?string $add_row_text - Unused in group context. @deprecated.
	 *
	 * @return Field
	 */
	public function repeatable( bool $repeatable = true, ?string $add_row_text = null ): Field {
		$this->repeatable = $repeatable;

		if ( ! isset( $this->options['sortable'] ) ) {
			$this->options = \array_merge( $this->options, [ 'sortable' => $repeatable ] );
		}

		return $this;
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
	 * Assign a field to a group, then register it.
	 *
	 * @param Field $field - Field object.
	 *
	 * @throws \LogicException - If no box is available.
	 *
	 * @return void
	 */
	protected function add_field_to_group( Field $field ): void {
		if ( null === $this->box || ! property_exists( $this->box, 'cmb' ) || null === $this->box->cmb ) {
			throw new \LogicException( esc_html__( 'You must add the group to the box before you add fields to the group.', 'lipe' ) );
		}

		if ( $this->is_repeatable() && Repo::in()->supports_taxonomy_relationships( $this->box->get_object_type(), $field ) ) {
			/* translators: {field type} */
			throw new \LogicException( \sprintf( esc_html__( 'Taxonomy fields are not supported by repeating groups. %s', 'lipe' ), esc_html( $field->get_id() ) ) );
		}

		$field->group = $this->get_id();
		$field->box_id = $this->box_id;
		$box = $this->box->get_box();
		if ( $box instanceof \CMB2 ) {
			$box->add_group_field( $this->id, $field->get_field_args(), $field->position );
		}

		Repo::in()->register_field( $field );
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
		\array_map( function( Field $field ) {
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
		if ( (bool) $this->show_in_rest && $this->is_public_rest_data( $this ) ) {
			$properties = [];
			foreach ( $this->get_fields() as $field ) {
				$field_id = $this->translate_sub_field_rest_key( $field );
				$properties[ $field_id ] = [
					'type' => 'string',
				];
				if ( $field->is_using_array_data() ) {
					$properties[ $field_id ] = [
						'type'  => 'array',
						'items' => [
							'type' => 'string',
						],
					];
				}
				if ( $field->is_using_object_data() ) {
					$properties[ $field_id ] = [
						'type'                 => 'object',
						'additionalProperties' => [
							'type' => 'string',
						],
					];
				}

				if ( Repo::TYPE_FILE === $field->data_type ) {
					$properties[ $field_id . '_id' ] = [
						'type' => 'number',
					];
				}
			}
			$config['show_in_rest'] = [
				'prepare_callback' => [ $this, 'translate_sub_field_rest_keys' ],
				'schema'           => [
					'items' => [
						'type'       => 'object',
						'properties' => $properties,
					],
				],
			];
			$config['sanitize_callback'] = [ $this, 'untranslate_sub_field_rest_keys' ];
		}

		if ( $this->box instanceof Box ) {
			$this->box->register_meta_on_all_types( $this, $config );
		}
	}


	/**
	 * Get the full list of object types this box
	 * is registered to.
	 *
	 * @return array
	 */
	public function get_object_types(): array {
		if ( $this->box instanceof Box ) {
			return $this->box->get_object_types();
		}
		return [];
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


	/**
	 * Use the shortened version of the field id in the REST API.
	 *
	 * Same thing we do for top level fields, but is opt-in for individual
	 * group fields for backwards compatibility.
	 *
	 * @example 'meta/food-data/calories' becomes 'calories'
	 *
	 * @interal
	 *
	 * @param array $group_values - Group values before being sent to the REST API.
	 *
	 * @return array
	 */
	public function translate_sub_field_rest_keys( array $group_values ): array {
		$fields = $this->get_fields();
		return \array_map( function( $group ) use ( $fields ) {
			foreach ( $group as $key => $value ) {
				if ( ! isset( $fields[ $key ] ) ) {
					continue;
				}
				$field = $fields[ $key ];
				unset( $group[ $key ] );
				$group[ $this->translate_sub_field_rest_key( $field ) ] = $value;
			}
			return $group;
		}, $group_values );
	}


	/**
	 * Map this groups fields back to their original keys when updating
	 * the metadata via the REST API.
	 *
	 * @param array $group_values - Group values sent to the REST API.
	 *
	 * @return array
	 */
	public function untranslate_sub_field_rest_keys( array $group_values ): array {
		if ( \function_exists( 'wp_is_rest_endpoint' ) ) {
			if ( ! wp_is_rest_endpoint() ) {
				return $group_values;
			}
		} elseif ( ! \defined( 'REST_REQUEST' ) || ! REST_REQUEST ) {
			return $group_values;
		}

		$map = Arrays::in()->flatten_assoc( function( Field $field ) {
			return [ $this->translate_sub_field_rest_key( $field ) => $field ];
		}, $this->get_fields() );

		return \array_map( function( $group ) use ( $map ) {
			foreach ( $group as $key => $value ) {
				if ( ! isset( $map[ $key ] ) ) {
					continue;
				}
				unset( $group[ $key ] );
				$group[ $map[ $key ]->get_id() ] = $value;
			}
			return $group;
		}, $group_values );
	}


	/**
	 * Translate the group field key for the REST API.
	 *
	 * If the field has a `rest_group_short` property, either shorten
	 * the key like we do with top level fields, or use the value of
	 * `rest_group_short` if it is a string.
	 *
	 * @param Field $field - Field to translate.
	 *
	 * @return string
	 */
	protected function translate_sub_field_rest_key( Field $field ): string {
		if ( ! isset( $field->rest_group_short ) || false === $field->rest_group_short ) {
			return $field->get_id();
		}
		if ( \is_string( $field->rest_group_short ) ) {
			return $field->rest_group_short;
		}

		return $field->get_rest_short_name();
	}
}
