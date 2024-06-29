<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Group\Layout;
use Lipe\Lib\Meta\DataType;
use Lipe\Lib\Meta\MetaType;
use Lipe\Lib\Meta\Registered;
use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Util\Arrays;

/**
 * Group field type, which implement much of the
 * logic of a Box and a Field.
 *
 * A fluent interface for CMB2 group properties.
 */
class Group extends Field {
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
	protected string $layout = 'block';

	/**
	 * All fields registered to this box.
	 *
	 * @var Field[]
	 */
	protected array $fields = [];

	/**
	 * Repeatable group options.
	 *
	 * @var array<'add_button'|'closed'|'remove_button'|'remove_confirm'|'sortable',bool|string>
	 */
	protected array $options = [];


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
	protected function hook(): void {
		add_action( 'cmb2_init', function() {
			$this->register_fields();
		}, 12 );
	}


	/**
	 * Add a field to this Group
	 *
	 * @example $group->field( $id, $name )->checkbox();
	 *
	 * @param string $id   - Field ID.
	 * @param string $name - Field name.
	 *
	 * @return Field_Type
	 */
	public function field( string $id, string $name ): Field_Type {
		$field = $this->add_field( Field::factory( $id, $name, $this->box, $this ) );
		return Field_Type::factory( $field, $this->box );
	}


	/**
	 * Display format for the group.
	 *
	 * Options: block (default), row, table
	 *
	 * @phpstan-param Layout::* $layout
	 *
	 * @param string            $layout - Layout type.
	 *
	 * @return Group
	 */
	public function layout( string $layout ): Group {
		if ( Layout::BLOCK === $layout ) {
			return $this;
		}
		Layout::init_once();
		if ( isset( $this->tab ) ) {
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
	 * @param bool    $repeatable      - Enable/disable repeatable support for this group.
	 * @param ?string $add_row_text    - Text used for the add group button.
	 * @param ?string $remove_row_text - Text used for the remove group button.
	 * @param ?string $remove_confirm  - Text used for the remove group confirmation.
	 *
	 * @return Group
	 */
	public function repeatable( bool $repeatable = true, ?string $add_row_text = null, ?string $remove_row_text = null, ?string $remove_confirm = null ): Group {
		$this->repeatable = $repeatable;

		$options = [];
		if ( null !== $add_row_text ) {
			$options['add_button'] = $add_row_text;
		}
		if ( null !== $remove_row_text ) {
			$options['remove_button'] = $remove_row_text;
		}
		if ( null !== $remove_confirm ) {
			$options['remove_confirm'] = $remove_confirm;
		}
		if ( ! isset( $this->options['sortable'] ) ) {
			$options['sortable'] = $repeatable;
		}
		$this->options = \array_merge( $this->options, $options );

		return $this;
	}


	/**
	 * Set the group to be sortable.
	 *
	 * @param bool $sortable - Enable/disable sortable support for this group.
	 *
	 * @return Group
	 */
	public function sortable( bool $sortable = true ): Group {
		$this->options = \array_merge( $this->options, [ 'sortable' => $sortable ] );

		return $this;
	}


	/**
	 * Set the group to be closed by default.
	 *
	 * @param bool $closed - Enable/disable closed by default for this group.
	 *
	 * @return Group
	 */
	public function closed( bool $closed = true ): Group {
		$this->options = \array_merge( $this->options, [ 'closed' => $closed ] );

		return $this;
	}


	/**
	 * Retrieve this field's arguments to be registered
	 * with CMB2.
	 *
	 * @see Box::add_field_to_box()
	 *
	 * @return array<string, mixed>
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
		$registered = Registered::factory( $field );
		if ( Registered::factory( $this )->is_repeatable() && Repo::in()->supports_taxonomy_relationships( MetaType::tryFrom( $this->box->get_object_type() ), $registered ) ) {
			/* translators: {field type} */
			throw new \LogicException( \sprintf( esc_html__( 'Taxonomy fields are not supported by repeating groups. %s', 'lipe' ), esc_html( $field->id ) ) );
		}

		$args = $field->get_field_args();
		$args['group'] = $this->id;
		$this->box->get_cmb2_box()->add_group_field( $this->id, $args, $registered->get_position() );

		Repo::in()->register_field( $field );
	}


	/**
	 * Registers any fields which were adding using $this->field()
	 * when the `cmb2_init` action fires.
	 *
	 * Allows for storing/appending a fields properties beyond
	 * a basic return pattern.
	 *
	 * @return void
	 */
	protected function register_fields(): void {
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
		$group = Registered::factory( $this );
		if ( $group->is_public_rest_data() ) {
			$properties = [];
			foreach ( $this->get_fields() as $field ) {
				$registered = Registered::factory( $field );
				$field_id = $this->translate_sub_field_rest_key( $registered );
				$properties[ $field_id ] = [
					'type' => 'string',
				];
				if ( $registered->is_using_array_data() ) {
					$properties[ $field_id ] = [
						'type'  => 'array',
						'items' => [
							'type' => 'string',
						],
					];
				} elseif ( $registered->is_using_object_data() ) {
					$properties[ $field_id ] = [
						'type'                 => 'object',
						'additionalProperties' => [
							'type' => 'string',
						],
					];
				}

				if ( DataType::FILE === $registered->get_data_type() ) {
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

		$this->box->register_meta_on_all_types( $group, $config );
	}


	/**
	 * Get all fields registered to this box.
	 *
	 * @return Field[]|Group[]
	 */
	protected function get_fields(): array {
		return $this->fields;
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
	 * @param array<string, mixed> $group_values - Group values before being sent to the REST API.
	 *
	 * @return array<string, mixed>
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
				$group[ $this->translate_sub_field_rest_key( Registered::factory( $field ) ) ] = $value;
			}
			return $group;
		}, $group_values );
	}


	/**
	 * Map this groups fields back to their original keys when updating
	 * the metadata via the REST API.
	 *
	 * @param array<string, mixed> $group_values - Group values sent to the REST API.
	 *
	 * @return array<string, mixed>
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
			return [ $this->translate_sub_field_rest_key( Registered::factory( $field ) ) => $field ];
		}, $this->get_fields() );

		return \array_map( function( $group ) use ( $map ) {
			foreach ( $group as $key => $value ) {
				if ( ! isset( $map[ $key ] ) ) {
					continue;
				}
				unset( $group[ $key ] );
				$group[ $map[ $key ]->id ] = $value;
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
	 * @param Registered $field - Field to translate.
	 *
	 * @return string
	 */
	protected function translate_sub_field_rest_key( Registered $field ): string {
		if ( ! $field->has_rest_short_name() ) {
			return $field->get_id();
		}

		return $field->get_rest_short_name();
	}


	/**
	 * Add a field to this Group.
	 *
	 * May be used to add or replace fields.
	 *
	 * @param Field $field - Field object.
	 *
	 * @return Field
	 */
	public function add_field( Field $field ): Field {
		$this->fields[ $field->id ] = $field;
		return $field;
	}
}
