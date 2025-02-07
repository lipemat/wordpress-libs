<?php
/** @noinspection ClassMethodNameMatchesFieldNameInspection */
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Box\Tabs;
use Lipe\Lib\CMB2\Field\Type;
use Lipe\Lib\Meta\DataType;
use Lipe\Lib\Meta\Registered;
use Lipe\Lib\Util\Arrays;

/**
 * A fluent interface for a CMB2 field.
 *
 * @phpstan-import-type DELETE_CB from Event_Callbacks
 * @phpstan-import-type CHANGE_CB from Event_Callbacks
 * @phpstan-import-type ESC_CB from Registered
 */
class Field {
	use Display;

	/**
	 * Used by the Repo to determine the data type of this field.
	 *
	 * @var DataType
	 */
	protected DataType $data_type = DataType::DEFAULT;

	/**
	 * Specify a default value for the field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#default
	 *
	 * @internal
	 *
	 * @var string|false|array<mixed>
	 */
	protected string|array|false $default;

	/**
	 * Bypass the CMB escaping (escapes before display) methods with your own callback.
	 * Set to false if you do not want any escaping (not recommended).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#escape_cb
	 *
	 * @see  Field::escape_cb()
	 *
	 * @phpstan-var ESC_CB
	 * @var callable
	 */
	protected $escape_cb;

	/**
	 * Bypass the CMB sanitization (sanitizes before saving) methods with your own callback.
	 * Set to false if you do not want any sanitization (not recommended).
	 *
	 * Only used when a field's data type cannot be registered with `register_meta`.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#sanitization_cb
	 *
	 * @see     Field::sanitization_cb()
	 * @see     Field::$meta_sanitizer
	 *
	 * @example sanitize_function( $value, $field_args, $field ){ return string }
	 *
	 * @phpstan-var ESC_CB
	 * @var callable
	 */
	protected $sanitization_cb;

	/**
	 * Used internally to store the CMB sanitization callback used
	 * with `register_meta`.
	 *
	 * If we register the `sanitization_cb` with `register_meta` it will be doubled
	 * up every time CMB2 saves the field. Instead, we set this property when a field
	 * may be registered with `register_meta`.
	 *
	 * @see Field::$sanitization_cb
	 *
	 * @phpstan-var ESC_CB
	 * @var callable
	 */
	protected $meta_sanitizer;

	/**
	 * To override the box's `show_in_rest` for this field.
	 *
	 * Only individual fields that are explicitly set to WP_REST_Server::ALLMETHODS will
	 * be included in default WP `meta` response even if the box is set to true
	 * and all fields are in the /cmb2 response.
	 *
	 * CMB2 honors the WP_REST_SERVER methods of transport
	 * for including fields in the /cmb2 endpoint.
	 * WP does not so, this field will either be included
	 * or not to default WP `meta` response based on WP_REST_Server::ALLMETHODS.
	 *
	 * @example \WP_REST_Server::CREATABLE
	 *
	 * @internal
	 *
	 * @phpstan-var \WP_REST_Server::*|bool
	 *
	 * @var string|bool
	 */
	protected string|bool $show_in_rest;

	/**
	 * Used to configure some strings for thinks like taxonomy and repeater fields.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#repeatable
	 *
	 * @example array(
	 *          'add_row_text' => 'Add Another Special Row',
	 *          'no_terms_text' => 'Sorry, no terms could be found.'
	 * )
	 *
	 * @interal
	 *
	 * @var  array<string, string>
	 */
	protected array $text = [];

	/**
	 * Enable revision support for 'post' objects.
	 *
	 * @since WP 6.4.
	 *
	 * @see   register_meta()
	 *
	 * @var bool
	 */
	protected bool $revisions_enabled;

	/**
	 * Will modify default attributes (class, input type, rows, etc),
	 * or add your own (placeholder, data attributes)
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#attributes
	 *
	 * @see     Field::attributes()
	 *
	 * @example [
	 *          'placeholder' => 'A small amount of text',
	 *          'rows'        => 3,
	 *          'required'    => 'required',
	 *          'type' => 'number',
	 * 'min'  => '101',
	 *          ]
	 *
	 * @internal
	 *
	 * @var     array<string, string>
	 */
	protected array $attributes = [];

	/**
	 * Columns work for post (all post-types), comment, user and term object types.
	 *
	 * @see  Field::column
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
	 *
	 * @var array{disable_sortable: bool, name: string, position: int|bool}|bool
	 */
	protected array|bool $column;

	/**
	 * To be used with $this->column or $this->column().
	 * Callback function to display the output of the column in the
	 * object-lists.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#display_cb
	 * @see     link for markup example
	 *
	 * @example my_callback_function_to_display_output( $field_args, $field )
	 *
	 * @var callable
	 */
	protected $display_cb;

	/**
	 * ID of boxes tab, which this field should display in.
	 * The tab must be first registered with the box.
	 *
	 * @see Field::tab
	 * @see Box::add_tab
	 *
	 * @var string
	 */
	protected string $tab;

	/**
	 * Shorten a group's child field keys when displayed in REST API.
	 *
	 * @var string|bool
	 */
	protected string|bool $rest_short_name;

	/**
	 * The type of field
	 * Calling Field::type() will return the Field_Type object, which
	 * will auto complete any type.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#type
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @see  Field_Type
	 *
	 * @var Type
	 */
	protected Type $type;

	/**
	 * Specify a callback to retrieve default value for the field.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#default_cb
	 *
	 * @var callable
	 */
	protected $default_cb;

	/**
	 * Field description. Usually under or adjacent to the field input.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#desc
	 *
	 * @var string
	 */
	protected string $desc = '';

	/**
	 * Supported by most field types, and will make the individual field a repeatable one.
	 *
	 * To customize Add Row button label, set
	 * $this->text['add_row_text'] = 'Add Row':
	 *
	 * @see     Field::repeatable()
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#repeatable
	 * @link    https://github.com/WebDevStudios/CMB2/wiki/Field-Types#types
	 *
	 * @internal
	 *
	 * @var bool
	 */
	protected bool $repeatable = false;

	/**
	 * Filter the value returned in the REST API responses
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#rest_value_cb
	 * @link    https://github.com/CMB2/CMB2/wiki/REST-API#overriding-a-returned-value-for-a-individual-field
	 *
	 * @see     Field::rest_value_cb()
	 *
	 * @example 'intval'
	 *
	 * @var callable
	 */
	protected $rest_value_cb;

	/**
	 * A render row cb to use inside a tab.
	 * Stored here, so we can set the `render_row_cb` to the tab's
	 * method to keep outside `render_row_cb` intact.
	 *
	 * @phpstan-var callable( array<string, mixed>, \CMB2_Field ): void
	 *
	 * @var callable
	 */
	protected $tab_content_cb;

	/**
	 * Callback Event handlers registered with this field.
	 *
	 * @var Event_Callbacks[]
	 */
	protected array $event_callbacks = [];


	/**
	 * Field constructor.
	 *
	 * @interal
	 *
	 * @see Field_Type
	 *
	 * @param string $id    - ID of the field.
	 * @param string $name  - Field label.
	 * @param Box    $box   - Parent class using this Field.
	 * @param ?Group $group - Group this field is assigned to.
	 */
	final protected function __construct(
		public readonly string $id,
		public readonly string $name,
		public readonly Box $box,
		public readonly ?Group $group,
	) {
		if ( method_exists( $this, 'hook' ) ) {
			$this->hook();
		}
	}


	/**
	 * Add this field as a post list column on the attached
	 * posts, comments, users, terms.
	 *
	 * @param bool|int      $position         - The column position.
	 * @param string        $name             - defaults to field name.
	 * @param callable|null $display_cb       - optional display callback.
	 * @param bool          $disable_sorting  - Set to true to prevent this column from being
	 *                                        sortable in post list.
	 *
	 * @return static
	 */
	public function column( bool|int $position = false, string $name = '', ?callable $display_cb = null, bool $disable_sorting = false ): static {
		$this->column = [
			'disable_sortable' => $disable_sorting,
			'name'             => '' === $name ? $this->name : $name,
			'position'         => $position,
		];
		if ( false === $position && '' === $name && false === $disable_sorting ) {
			$this->column = true;
		}
		if ( null !== $display_cb ) {
			$this->display_cb = $display_cb;
		}

		return $this;
	}


	/**
	 * Will modify default attributes (class, input type, rows, etc.),
	 * or add your own (placeholder, data attributes).
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#attributes
	 *
	 * @example [
	 *          'placeholder' => 'A small amount of text',
	 *          'rows'        => 3,
	 *          'required'    => 'required',
	 *          'type' => 'number',
	 * 'min'  => '101',
	 *          ]
	 *
	 * @param array<string, string|float|int> $attributes - An array of attributes to add or modify.
	 *
	 * @return static
	 */
	public function attributes( array $attributes ): static {
		$this->attributes = Arrays::in()->merge_recursive( $attributes, $this->attributes );

		return $this;
	}


	/**
	 * Specify a default value for the field.
	 *
	 * @see     Checkbox::default() -- checkboxes are tricky.
	 *
	 * @param callable|string|array<mixed> $default_value - A default value, or a function which will return a value.
	 *
	 * @return static
	 */
	public function default( callable|string|array $default_value ): static {
		if ( \is_callable( $default_value ) ) {
			_doing_it_wrong( __METHOD__, 'Callbacks should use `default_cb` instead of `default`', '3.2.1' );
			$this->default_cb( $default_value );
		} else {
			$this->default = $default_value;
			if ( BoxType::OPTIONS === $this->box->get_box_type() ) {
				add_filter( "cmb2_default_option_{$this->box->get_id()}_{$this->id}", function() {
					return $this->default;
				} );
			}
		}
		return $this;
	}


	/**
	 * Specify a callback which will return the default value for this field.
	 *
	 * @link     https://github.com/CMB2/CMB2/wiki/Field-Parameters#default_cb
	 *
	 * @since    5.2.1
	 *
	 * @phpstan-param callable( array<string, mixed>, \CMB2_Field ): mixed $callback
	 *
	 * @formatter:off
	 *
	 * @param callable $callback - Callback to retrieve the default value.
	 *
	 * @formatter:on
	 *
	 * @return static
	 */
	public function default_cb( callable $callback ): static {
		Default_Callback::factory( $this, $this->box, $callback );
		$this->default_cb = $callback;
		return $this;
	}


	/**
	 * Field description. Usually under or adjacent to the field input.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#desc
	 *
	 * @param string $description - The field description.
	 *
	 * @return static
	 */
	public function description( string $description ): static {
		$this->desc = $description;

		return $this;
	}


	/**
	 * Mark this field as 'disabled'.
	 *
	 * @return static
	 */
	public function disabled(): static {
		$this->attributes( [ 'disabled' => 'disabled' ] );

		return $this;
	}


	/**
	 * Bypass the CMB escaping (escapes before display) methods with your own callback.
	 * Set to false if you do not want any escaping (not recommended).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#escape_cb
	 *
	 * @phpstan-param ESC_CB $callback
	 *
	 * @param callable       $callback - The callback to use for escaping.
	 *
	 * @return static
	 */
	public function escape_cb( callable $callback ): static {
		$this->escape_cb = $callback;
		return $this;
	}


	/**
	 * Supported by most field types, and will make the individual field a repeatable one.
	 *
	 * @param bool    $repeatable   - Whether the field should be repeatable.
	 * @param ?string $add_row_text - Optional text to display on the 'Add' button.
	 *
	 * @return static
	 */
	public function repeatable( bool $repeatable = true, ?string $add_row_text = null ): static {
		if ( \CMB2_Utils::does_not_support_repeating( $this->type->value ) ) {
			/* translators: {field type} */
			_doing_it_wrong( __METHOD__, \sprintf( esc_html__( 'Fields of `%s` type do not support repeating.', 'lipe' ), esc_html( $this->type->value ) ), '5.0.0' );
		}

		$this->repeatable = $repeatable;
		if ( null !== $add_row_text ) {
			$this->text['add_row_text'] = $add_row_text;
		}
		return $this;
	}


	/**
	 * Callback to filter the return value for this field in
	 * the rest api responses.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#rest_value_cb
	 * @link    https://github.com/CMB2/CMB2/wiki/REST-API#overriding-a-returned-value-for-a-individual-field
	 *
	 * @param callable $callback - The callback to use for filtering.
	 *
	 * @example 'intval'
	 *
	 * @return static
	 */
	public function rest_value_cb( callable $callback ): static {
		$this->rest_value_cb = $callback;
		return $this;
	}


	/**
	 * Mark this field as 'readonly'.
	 *
	 * @return static
	 */
	public function readonly(): static {
		$disable_only = [
			Type::SELECT,
			Type::SELECT_TIMEZONE,
			Type::TEXT_DATE,
			Type::TEXT_DATE_TIMESTAMP,
			Type::TEXT_DATETIME_TIMESTAMP,
			Type::TEXT_DATETIME_TIMESTAMP_TZ,
			Type::TAXONOMY_SELECT,
		];

		// These HTML inputs do not work as readonly and must be disabled.
		// @notice Any saved values will be cleared from these fields on save.
		if ( \in_array( $this->type, $disable_only, true ) ) {
			$this->disabled();
		}

		$this->attributes( [ 'readonly' => 'readonly' ] );

		return $this;
	}


	/**
	 * Mark this field as 'required'
	 *
	 * @notice As of WP 5.1.1 this has no effect on meta box fields with
	 *         Gutenberg enabled. Possibly will be changed in a future version
	 *         of WP?
	 *
	 * @return static
	 */
	public function required(): static {
		$this->attributes( [ 'required' => 'required' ] );
		return $this;
	}


	/**
	 * Enable revision support for this meta_key.
	 * Can only be used when the object type is 'post'.
	 *
	 * @param bool $enable - Enable revisions on this field.
	 *
	 * @return static
	 */
	public function revisions_enabled( bool $enable = true ): static {
		if ( null !== $this->group ) {
			_doing_it_wrong( __METHOD__, "Revision may only be enabled on a group. Not a group's field .", '4.5.0' );
			return $this;
		}
		if ( BoxType::POST !== $this->box->get_box_type() ) {
			_doing_it_wrong( __METHOD__, "Revisions are only supported on 'post' objects.", '4.5.0' );
			return $this;
		}
		$this->revisions_enabled = $enable;
		return $this;
	}


	/**
	 * Override the box's `show_in_rest` value for this field.
	 *
	 * If the box's `show_in_rest` is false, and a non `false` parameter
	 * is passed, the box's `show_in_rest` will be set to true and all
	 * fields, which do not have a `show_in_rest` specified will be set false.
	 *
	 * Only individual fields that are explicitly set to WP_REST_Server::ALLMETHODS will
	 * be included in default WP `meta` response even if the box is set to true
	 * and all fields are in the /cmb2 response.
	 *
	 * CMB2 honors the WP_REST_SERVER methods of transport
	 * for including fields in the /cmb2 endpoint.
	 * WP does not so, this field will either be included
	 * or not to default WP `meta` response based on WP_REST_Server::ALLMETHODS.
	 *
	 * @see     Box::selectively_show_in_rest()
	 *
	 * @example WP_REST_Server::READABLE // Same as `true`.
	 * @example WP_REST_Server::ALLMETHODS // All Methods must be used for the field
	 *          show up under `meta`, otherwise will just show up under `cmb2`.
	 * @example WP_REST_Server::EDITABLE
	 *
	 * @phpstan-param \WP_REST_Server::*|bool $methods
	 *
	 * @param bool|string                     $methods - The methods to show this field in.
	 *
	 * @return static
	 */
	public function show_in_rest( bool|string $methods = \WP_REST_Server::ALLMETHODS ): static {
		if ( null !== $this->group ) {
			_doing_it_wrong( __METHOD__, wp_kses_post( "Show in rest may only be added to whole group. Not a group's field. `{$this->id}` is not applicable." ), '2.19.0' );
		}
		$this->show_in_rest = $methods;
		return $this;
	}


	/**
	 * Historically, the full field keys were used for group child fields.
	 *
	 * - Opt-in to shorten the field keys like we do for top level fields.
	 * - Also may be used to specify a custom top level key.
	 *
	 * @since 4.10.0
	 *
	 * @param bool|string $short - `true` to use shortened keys. A string to specify a custom key.
	 *
	 * @return static
	 */
	public function rest_short_name( bool|string $short = true ): static {
		$this->rest_short_name = $short;
		return $this;
	}


	/**
	 * Add this field to a tab.
	 * The tab must be first registered with the box.
	 *
	 * @see Tabs::render_field()
	 *
	 * @see Box::add_tab
	 *
	 * @param string $id - The tab id.
	 *
	 * @return static
	 */
	public function tab( string $id ): static {
		Tabs::init_once();

		$this->tab = $id;
		if ( null !== $this->render_row_cb ) {
			$this->tab_content_cb = $this->render_row_cb;
		}
		$this->render_row_cb( [ Tabs::in(), 'render_field' ] );

		return $this;
	}


	/**
	 * Set a Fields Type and register the type with Meta\Repo
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @internal
	 *
	 * @param Type                        $type      - CMB2 field type.
	 * @param array<key-of<Field>, mixed> $args      - [$key => $value].
	 * @param DataType                    $data_type - Field data structure type.
	 *
	 * @return static
	 */
	public function set_args( Type $type, array $args, DataType $data_type ): static {
		$this->type = $type;
		$this->data_type = $data_type;

		foreach ( $args as $_key => $_value ) {
			$this->{$_key} = $_value;
		}
		$this->box->add_field( $this );
		return $this;
	}


	/**
	 * Callback to be fired when a meta item is deleted.
	 *
	 * Fired when:
	 * 1. A meta key is deleted using the repo.
	 * 2. An empty meta value is passed when CMB2 is saving a post.
	 * 3. A meta key is deleted using the WP meta API.
	 *
	 * @note `change_cb` will also receive pretty much all the calls
	 *       that `delete_cb` does, so you'll only want to use `delete_cb` if you want to subscribe to "delete" only calls.
	 *
	 * Receives arguments:
	 * 0. object id.
	 * 1. meta key.
	 * 2. previous value.
	 * 3. meta key.
	 *
	 * @phpstan-param DELETE_CB $callback
	 *
	 * @param callable          $callback - The callback to be fired when a meta item is deleted.
	 *
	 * @return static
	 */
	public function delete_cb( callable $callback ): static {
		$this->event_callbacks[] = Event_Callbacks::factory( $this, $callback, Event_Callbacks::TYPE_DELETE );
		return $this;
	}


	/**
	 * Callback to be fired when an items data is updated.
	 *
	 * Fired when:
	 * 1. A meta field is updated using the repo.
	 * 2. A meta field is updated when CMB2 is saving a post.
	 * 3. A meta field is updated using the WP meta API.
	 * 4. A value, which previously existed is deleted.
	 *
	 * @note This callback will also receive pretty much all the calls
	 *       that `delete_cb` does, so you likely won't need to use both.
	 *
	 * Receives arguments:
	 * 0. object id.
	 * 1. new value.
	 * 2. meta key.
	 * 3. previous value.
	 * 4. meta key.
	 *
	 * @phpstan-param CHANGE_CB $callback
	 *
	 * @param callable          $callback - The callback to be fired when an items data is updated.
	 *
	 * @return static
	 */
	public function change_cb( callable $callback ): static {
		$this->event_callbacks[] = Event_Callbacks::factory( $this, $callback, Event_Callbacks::TYPE_CHANGE );

		return $this;
	}


	/**
	 * If this field supports using `register_meta` to do sanitization we
	 * set the `sanitize_callback` property. If not, we use the CMB2
	 * `sanitize_cb` property to allow CMB2 and/or meta repo to handle sanitization.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#sanitization_cb
	 * @link https://developer.wordpress.org/reference/functions/register_meta/
	 *
	 * @phpstan-param ESC_CB $callback
	 *
	 * @param callable       $callback - The callback to be used for sanitization.
	 *
	 * @return static
	 */
	public function sanitization_cb( callable $callback ): static {
		$registered = Registered::factory( $this );
		if ( [ BoxType::OPTIONS->value ] !== $this->box->get_object_types() && $registered->is_allowed_to_register_meta() ) {
			$this->meta_sanitizer = $callback;
		} else {
			$this->sanitization_cb = $callback;
		}
		return $this;
	}


	/**
	 * Retrieve an array of these fields args to be
	 * submitted to CMB2 by way of \CMB2::add_field().
	 *
	 * @see Box::add_field_to_box()
	 *
	 * @return array<string, mixed>
	 */
	public function get_field_args(): array {
		if ( ! isset( $this->type ) ) {
			_doing_it_wrong( __METHOD__, esc_html__( 'You must specify a field type (use $field->type() ).', 'lipe' ), '5.0.0' );
		}
		$args = [];
		foreach ( \get_object_vars( $this ) as $_var => $_value ) {
			if ( ! isset( $this->{$_var} ) ) {
				continue;
			}
			$args[ $_var ] = $this->{$_var};
		}
		$args['type'] = $this->type->value;
		return $args;
	}


	/**
	 * Translate a field into a more specific field Variation.
	 *
	 * @param Field $field - The field to translate.
	 * @param Box   $box   - The box this field is assigned to.
	 *
	 * @return static
	 */
	public static function from( Field $field, Box $box ): static {
		$field = new static( $field->id, $field->name, $field->box, $field->group );
		$box->add_field( $field );
		return $field;
	}


	/**
	 * Create a new field.
	 *
	 * @param string $id    - ID of the field.
	 * @param string $name  - Field label.
	 * @param Box    $box   - Parent class using this Field.
	 * @param ?Group $group - Group this field is assigned to.
	 *
	 * @return static
	 */
	public static function factory( string $id, string $name, Box $box, ?Group $group = null ): static {
		return new static( $id, $name, $box, $group );
	}
}
