<?php
/** @noinspection ClassMethodNameMatchesFieldNameInspection */
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Box\Tabs;
use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Query\Get_Posts;
use Lipe\Lib\Taxonomy\Get_Terms;
use Lipe\Lib\Util\Arrays;

/**
 * A fluent interface for a CMB2 field.
 *
 * @phpstan-type DELETE_CB callable( int $object_id, string $key, mixed $previous, Box::TYPE_* $type ): void
 * @phpstan-type CHANGE_CB callable( int $object_id, mixed $value, string $key, mixed $previous, Box::TYPE_* $type): void
 * @phpstan-type ESC_CB callable( mixed $value, array<string, mixed>, \CMB2_Field ): mixed
 */
class Field {
	/**
	 * ID of meta box this field is assigned to.
	 *
	 * @internal
	 *
	 * @var string
	 */
	public string $box_id;

	/**
	 * A custom callback to return the label for the field
	 *
	 * Part of cmb2 core but undocumented
	 *
	 * @var callable
	 */
	public $label_cb;

	/**
	 * Used by the Repo to determine the data type of this field.
	 *
	 * @interal
	 *
	 * @phpstan-var Repo::TYPE_*
	 *
	 * @var string
	 */
	public string $data_type = Repo::TYPE_DEFAULT;

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
	public array $attributes = [];

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before-after-before_row-after_row-before_field-after_field
	 *
	 * @var callable|string
	 */
	public $before;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before-after-before_row-after_row-before_field-after_field
	 *
	 * @var callable|string
	 */
	public $after;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before-after-before_row-after_row-before_field-after_field
	 *
	 * @var callable|string
	 */
	public $before_row;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before-after-before_row-after_row-before_field-after_field
	 *
	 * @var callable|string
	 */
	public $after_row;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before-after-before_row-after_row-before_field-after_field
	 *
	 * @var callable|string
	 */
	public $before_field;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before-after-before_row-after_row-before_field-after_field
	 *
	 * @var callable|string
	 */
	public $after_field;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_display_wrap-before_display-after_display-after_display_wrap
	 *
	 * @var callable|string
	 */
	public $before_display_wrap;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_display_wrap-before_display-after_display-after_display_wrap
	 *
	 * @var callable|string
	 */
	public $before_display;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_display_wrap-before_display-after_display-after_display_wrap
	 *
	 * @var callable|string
	 */
	public $after_display;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_display_wrap-before_display-after_display-after_display_wrap
	 *
	 * @var callable|string
	 */
	public $after_display_wrap;

	/**
	 * Used with `char_counter` to count character/words remaining.
	 *
	 * @var int
	 */
	public int $char_max;

	/**
	 * Used with `char_max` to enforce length when counting characters.
	 *
	 * @var bool
	 */
	public bool $char_max_enforce;

	/**
	 * This property allows you to optionally add classes to the CMB2 wrapper.
	 * This property can take a string, or array.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#classes
	 *
	 * @example 'additional-class'
	 * @example array( 'additional-class', 'another-class' ),
	 *
	 * @var array<string>|string
	 */
	public array|string $classes;

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
	 * Like the classes property, allows adding classes to the CMB2 wrapper,
	 * but takes a callback.
	 * That callback should return an array of classes.
	 * The callback gets passed the CMB2 $properties array as the first argument,
	 * and the CMB2 $cmb object as the second argument.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#classes_cb
	 *
	 * @example: 'yourprefix_function_to_add_classes',
	 *
	 * @var callable
	 */
	public $classes_cb;

	/**
	 * Field parameter used in the date field types which allows specifying
	 * the php date format for your field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#date_format
	 * @link php.net/manual/en/function.date.php.
	 *
	 * @var string
	 */
	public string $date_format;

	/**
	 * Specify a default value for the field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#default
	 *
	 * @internal
	 *
	 * @var string|array<mixed>
	 */
	public string|array $default;

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
	public $display_cb;

	/**
	 * Entirely replace the class to used to display the field (in admin columns, etc)
	 *
	 * @var \CMB2_Field_Display
	 */
	public \CMB2_Field_Display $display_class;

	/**
	 * Bypass the CMB escaping (escapes before display) methods with your own callback.
	 * Set to false if you do not want any escaping (not recommended).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#escape_cb
	 *
	 * @see  Field::escape_cb()
	 *
	 * @internal
	 *
	 * @phpstan-var ESC_CB
	 * @var callable
	 */
	public $escape_cb;

	/**
	 * If this field is part of a group this may be used to retrieve
	 * the group id.
	 *
	 * @internal
	 *
	 * @var string|null
	 */
	public ?string $group = null;

	/**
	 * If you're planning on using your metabox fields on the front-end as well (user-facing),
	 * then you can specify that certain fields do not get displayed there
	 * by setting this parameter to false.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#on_front
	 *
	 * @default true
	 *
	 * @var bool
	 */
	public bool $on_front;

	/**
	 * For fields that take an options array.
	 *
	 * These include select, radio, multicheck, wysiwyg and group.
	 * Should be an array where the keys are the option value,
	 * and the values are the option text.
	 *
	 * If you are doing any kind of database querying or logic/conditional checking,
	 * you're almost always better off using the options_cb parameter.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#options
	 *
	 * @var  array<string, string|bool>
	 */
	public array $options = [];

	/**
	 * A callback to provide field options.
	 * Callback function should return an options array.
	 * The callback function gets passed the $field object.
	 * It is recommended to use this parameter over the options parameter
	 * if you are doing anything complex to generate your options array,
	 * as the '*_cb' parameters are run when the field is generated,
	 * instead of on every page load (admin or otherwise).
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#options_cb
	 *
	 * @example my_get_options_function( $field ){ return [ value => label ] }
	 *
	 * @var callable
	 */
	public $options_cb;

	/**
	 * Order the field will display in.
	 *
	 * @internal
	 *
	 * @var int
	 */
	public int $position = 0;

	/**
	 * For use with the file fields only to control the preview size
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 *
	 * @var string
	 */
	public string $preview_size;

	/**
	 * Allows overriding the default CMB2_Type_Base class
	 * that is used when rendering the field.
	 * This provides interesting object-oriented ways to override default CMB2 behavior
	 * by subclassing the default class and overriding methods.
	 * For best results, your class should extend the class it is overriding.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_class
	 *
	 * @var string
	 */
	public string $render_class;

	/**
	 * Bypass the CMB row rendering.
	 * You will be completely responsible for outputting that row's html.
	 * The callback function gets passed the field $args array, and the $field object.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_row_cb
	 * @link https://github.com/WebDevStudios/CMB2/issues/596#issuecomment-187941343
	 *
	 * @var callable|null
	 */
	public $render_row_cb;

	/**
	 * New field parameter for taxonomy fields, 'remove_default'
	 * which allows disabling the default taxonomy metabox.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#remove_default
	 *
	 * @example true
	 * @default false
	 *
	 * @var bool
	 */
	public bool $remove_default;

	/**
	 * Bypass the CMB sanitization (sanitizes before saving) methods with your own callback.
	 * Set to false if you do not want any sanitization (not recommended).
	 *
	 * Only used when a field's data type cannot be registered with `register_meta`.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#sanitization_cb
	 *
	 * @see     Field::sanitization_cb()
	 * @see     Field::$sanitize_callback
	 *
	 * @example sanitize_function( $value, $field_args, $field ){ return string }
	 *
	 * @internal
	 *
	 * @phpstan-var ESC_CB
	 * @var callable
	 */
	public $sanitization_cb;

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
	 * @internal
	 * @phpstan-var ESC_CB
	 * @var callable
	 */
	public $sanitize_callback;

	/**
	 * Whether to show select all button for items
	 * with multi select like multicheck
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 *
	 * @default true
	 * @example false
	 *
	 * @var bool
	 */
	public bool $select_all_button;

	/**
	 * Whether to show labels for the fields
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_names
	 *
	 * Default  true
	 *
	 * @var bool
	 */
	public bool $show_names;

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
	public $show_in_rest;

	/**
	 * To show this field or not based on the result of a function.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_on_cb
	 * @example should_i_show( $field ){ return bool}
	 *
	 * @see     Field::show_on_cb
	 *
	 * @interal
	 *
	 * @var callable
	 */
	public $show_on_cb;

	/**
	 * When using a field of a select type this defines whether we should
	 * show a " no option" option and what the value of said option will be.
	 *
	 * @var bool|string
	 */
	public $show_option_none;

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
	 * Used for date/timestamp fields.
	 *
	 * Optional to specify a timezone to use when
	 * calculating the timestamp offset.
	 *
	 * Defaults to timezone stored in WP options.
	 *
	 * @var string;
	 */
	public string $timezone;

	/**
	 * Used for date/time fields
	 *
	 * Optionally make this field honor the timezone selected
	 * in the select_timezone field specified above in the form.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#text_date
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#select_timezone
	 *
	 * @example 'key_of_select_timezone_field'
	 *
	 * @var string
	 */
	public string $timezone_meta_key;

	/**
	 * Used for taxonomy fields
	 *
	 * Set to the taxonomy slug
	 *
	 * @notice these fields will save terms not meta
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_select
	 *
	 * @var string
	 */
	public string $taxonomy;

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
	public array $text = [];

	/**
	 * Field parameter, which can be used by the 'taxonomy_*', and the 'file_*' field types.
	 * For the 'taxonomy_*' types, provides ability
	 * to override the arguments passed to get_terms(), and for the 'file_*' field types,
	 * allows overriding the media library query arguments.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @interal
	 *
	 * @var  array<string, mixed>
	 */
	public array $query_args;

	/**
	 * Internal property to hold a callback function when
	 * a meta key is deleted.
	 *
	 * @internal
	 *
	 * @phpstan-var DELETE_CB
	 *
	 * @var callable
	 */
	public $delete_cb;

	/**
	 * Internal property to hold a callback function when
	 * a meta key is updated.
	 *
	 * @internal
	 *
	 * @phpstan-var CHANGE_CB
	 *
	 * @var callable
	 */
	public $change_cb;

	/**
	 * Enable revision support for 'post' objects.
	 *
	 * @since WP 6.4.
	 *
	 * @see   register_meta()
	 *
	 * @internal
	 *
	 * @var bool
	 */
	public bool $revisions_enabled;

	/**
	 * Used by the term_select_2 field type to append the terms to the object
	 * as well as storing them in meta.
	 *
	 * @see \Lipe\Lib\CMB2\Field\Term_Select_2::assign_terms_during_save
	 *
	 * @interal
	 *
	 * @var bool
	 */
	public bool $term_select_2_save_as_terms = false;

	/**
	 * Used by the term_select_2 field type to allow creating new terms.
	 *
	 * @see \Lipe\Lib\CMB2\Field\Term_Select_2::assign_terms_during_save
	 *
	 * @interal
	 *
	 * @var bool
	 */
	public bool $term_select_2_create_terms = false;

	/**
	 * Used by the `text_url` field type to specify the protocols allowed.
	 *
	 * @var ?string[]
	 */
	public ?array $protocols = null;

	/**
	 * Shorten a group's child field keys when displayed in REST API.
	 *
	 * @var string|bool
	 */
	public string|bool $rest_group_short;

	/**
	 * The type of field
	 * Calling Field::type() will return the Field_Type object, which
	 * will auto complete any type.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#type
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @see  Field_Type;
	 * @see  Field::type;
	 *
	 * @var string;
	 */
	protected string $type;

	/**
	 * Enable a character/word counter for a 'textarea', 'wysiwyg', or 'text' type field.
	 *
	 * @phpstan-var true|'words'
	 *
	 * @var bool|string
	 */
	protected string|bool $char_counter;

	/**
	 * Specify a callback to retrieve default value for the field.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#default_cb
	 *
	 * @notice Not currently support for retrieval of group sub-fields but
	 *         works to populate defaults in the admin.
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
	 * $this->text[ 'add_row_text' ] = 'Add Row':
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
	 * Save terms assigned to users as meta instead of the default
	 * object terms system.
	 *
	 * Prevent conflicts with User ID and Post ID in the same
	 * `term_relationship` table.
	 *
	 * @notice Required lipemat version of CMB2 to support this argument.
	 *
	 * @see    \CMB2_Type_Taxonomy_Base::get_object_terms
	 *
	 * @var bool
	 */
	protected bool $store_user_terms_in_meta = true;

	/**
	 * A render row cb to use inside a tab.
	 * Stored here, so we can set the `render_row_cb` to the tab's
	 * method an keep outside `render_row_cb` intact.
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
	 * @param string    $id   - ID of the field.
	 * @param string    $name - Field label.
	 * @param Box|Group $box  - Parent class using this Field.
	 */
	public function __construct(
		protected readonly string $id,
		protected readonly string $name,
		protected readonly Box|Group $box
	) {
	}


	/**
	 * The data key. If using for posts, will be the post-meta key.
	 * If using for an options page, will be the array key.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#id
	 *
	 * @required
	 *
	 * @example 'lipe/project/meta/category-fields/caption',
	 *
	 * @return string
	 */
	public function get_id(): string {
		return $this->id;
	}


	/**
	 * The field label
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#name
	 *
	 * @return string
	 */
	public function get_name(): string {
		return $this->name;
	}


	/**
	 * Get the box this field is assigned to.
	 *
	 * @return ?Box
	 */
	public function get_box(): ?Box {
		if ( $this->box instanceof Group ) {
			return $this->box->get_box();
		}
		return $this->box;
	}


	/**
	 * Get the group this field is assigned to.
	 *
	 * @return ?Group
	 */
	public function get_group(): ?Group {
		if ( $this->box instanceof Group ) {
			return $this->box;
		}
		return null;
	}


	/**
	 * Enable a character/word counter for a 'textarea', 'wysiwyg', or 'text' type field.
	 *
	 * @notice Does not work with repeatable wysiwyg.
	 *
	 * @phpstan-param array{
	 *     words_left_text?: string,
	 *     words_text?: string,
	 *     characters_left_text?: string,
	 *     characters_text?: string,
	 *     characters_truncated_text?: string
	 * }            $labels
	 *
	 *
	 * @param bool  $count_words   - Count words instead of characters.
	 * @param ?int  $max           - Show remaining character/words based on provided limit.
	 * @param bool  $enforce       - Enforce max length using `maxlength` attribute when
	 *                             characters are counted.
	 * @param array $labels        - Override the default text strings associated with these.
	 *                             'words_left_text' - Default: "Words left"
	 *                             'words_text' - Default: "Words"
	 *                             'characters_left_text' - Default: "Characters left"
	 *                             'characters_text' - Default: "Characters"
	 *                             'characters_truncated_text' - Default: "Your text may be truncated.".
	 *
	 * @return Field
	 */
	public function char_counter( bool $count_words = false, ?int $max = null, bool $enforce = false, array $labels = [] ): Field {
		$this->char_counter = $count_words ? 'words' : true;

		if ( null !== $max ) {
			$this->char_max = $max;
			if ( $enforce ) {
				if ( 'words' === $this->char_counter ) {
					\_doing_it_wrong( 'char_counter', esc_html__( 'You cannot enforce max length when counting words', 'lipe' ), '2.17.0' );
				}
				$this->char_max_enforce = true;
			}
		}

		if ( [] !== $labels ) {
			$this->text = \array_merge( $this->text, \array_intersect_key( $labels, \array_flip( [
				'words_left_text',
				'words_text',
				'characters_left_text',
				'characters_text',
				'characters_truncated_text',
			] ) ) );
		}

		return $this;
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
	 * @return Field
	 */
	public function column( bool|int $position = false, string $name = '', ?callable $display_cb = null, bool $disable_sorting = false ): Field {
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
	 * @param array<string, string> $attributes - An array of attributes to add or modify.
	 *
	 * @return Field
	 */
	public function attributes( array $attributes ): Field {
		$this->attributes = Arrays::in()->merge_recursive( $attributes, $this->attributes );

		return $this;
	}


	/**
	 * Specify a default value for the field, or a
	 * function which will return a default value.
	 *
	 * @example = 'John'
	 * @example function prefix_set_test_default( $field_args, \CMB2_Field $field ) {
	 *                      return 'Post ID: '. $field->object_id
	 *                  }
	 *
	 * @notice  checkboxes are tricky
	 *          https://github.com/CMB2/CMB2/wiki/Tips-&-Tricks#setting-a-default-value-for-a-checkbox
	 *
	 * @notice  A callback is not currently supported for retrieval of a group
	 *          sub-field, but works in the admin to populate fields.
	 *
	 * @param callable|string|array<mixed> $default_value - A default value, or a function which will return a value.
	 *
	 * @return Field
	 */
	public function default( callable|string|array $default_value ): Field {
		if ( \is_callable( $default_value ) ) {
			$this->default_cb = $default_value;
			if ( 'options-page' === $this->box->get_object_type() ) {
				add_filter( "cmb2_default_option_{$this->box->get_id()}_{$this->get_id()}", [
					$this,
					'default_option_callback',
				], 11 );
			} else {
				add_filter( "default_{$this->box->get_object_type()}_metadata", [
					$this,
					'default_meta_callback',
				], 11, 3 );
			}
		} else {
			$this->default = $default_value;
			if ( 'options-page' === $this->box->get_object_type() ) {
				add_filter( "cmb2_default_option_{$this->box->get_id()}_{$this->get_id()}", function() {
					return $this->default;
				} );
			}
		}
		return $this;
	}


	/**
	 * Field description. Usually under or adjacent to the field input.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#desc
	 *
	 * @param string $description - The field description.
	 *
	 * @return Field
	 */
	public function description( string $description ): Field {
		$this->desc = $description;

		return $this;
	}


	/**
	 * Mark this field as 'disabled'.
	 *
	 * @return Field
	 */
	public function disabled(): Field {
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
	 * @return Field
	 */
	public function escape_cb( callable $callback ): Field {
		$this->escape_cb = $callback;
		return $this;
	}


	/**
	 * Supported by most field types, and will make the individual field a repeatable one.
	 *
	 * @param bool    $repeatable   - Whether the field should be repeatable.
	 * @param ?string $add_row_text - Optional text to display on the 'Add' button.
	 *
	 * @throws \LogicException - If trying to repeat an unsupported field type.
	 *
	 * @return Field
	 */
	public function repeatable( bool $repeatable = true, ?string $add_row_text = null ): Field {
		if ( method_exists( \CMB2_Utils::class, 'does_not_support_repeating' ) && \CMB2_Utils::does_not_support_repeating( $this->get_type() ) ) {
			/* translators: {field type} */
			throw new \LogicException( \sprintf( esc_html__( 'Fields of `%s` type do not support repeating.', 'lipe' ), esc_html( $this->get_type() ) ) );
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
	 * @return Field
	 */
	public function rest_value_cb( callable $callback ): Field {
		$this->rest_value_cb = $callback;
		return $this;
	}


	/**
	 * Set the position of the field in the meta box
	 *
	 * @param int $position - The position of the field.
	 *
	 * @default 1
	 *
	 * @return $this
	 */
	public function position( int $position = 1 ): Field {
		$this->position = $position;

		return $this;
	}


	/**
	 * Mark this field as 'readonly'.
	 *
	 * @return Field
	 */
	public function readonly(): Field {
		$disable_only = [
			'select',
			'select_timezone',
			'text_date',
			'text_date_timestamp',
			'text_datetime_timestamp',
			'text_datetime_timestamp_timezone',
			'taxonomy_select',
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
	 * @return Field
	 */
	public function required(): Field {
		// The only way a file field may be required is if the text field is showing.
		if ( 'file' === $this->type ) {
			$this->options['url'] = true;
		}
		$this->attributes( [ 'required' => 'required' ] );
		return $this;
	}


	/**
	 * Enable revision support for this meta_key.
	 * Can only be used when the object type is 'post'.
	 *
	 * @param bool $enable - Enable revisions on this field.
	 *
	 * @return $this
	 */
	public function revisions_enabled( bool $enable = true ): Field {
		$box = $this->get_box();
		if ( null === $box ) {
			_doing_it_wrong( __METHOD__, 'The box is not available for enabling revisions.', '4.5.0' );
			return $this;
		}
		if ( $box->is_group() ) {
			_doing_it_wrong( __METHOD__, "Revision may only be enabled on a group. Not a group's field .", '4.5.0' );
			return $this;
		}
		if ( 'post' !== $box->get_object_type() ) {
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
	 * @see     Box_Trait::selectively_show_in_rest()
	 *
	 * @example WP_REST_Server::READABLE // Same as `true`.
	 * @example WP_REST_Server::ALLMETHODS // All Methods must be used for the field
	 *          show up under `meta`, otherwise will just show up under `cmb2`.
	 * @example WP_REST_Server::EDITABLE
	 *
	 * @phpstan-param \WP_REST_Server::*|bool $methods
	 *
	 * @param string|bool                     $methods - The methods to show this field in.
	 *
	 * @return Field
	 */
	public function show_in_rest( $methods = \WP_REST_Server::ALLMETHODS ): Field {
		if ( $this->box->is_group() ) {
			_doing_it_wrong( __METHOD__, wp_kses_post( "Show in rest may only be added to whole group. Not a group's field. `{$this->get_id()}` is not applicable." ), '2.19.0' );
		}
		$this->show_in_rest = $methods;
		return $this;
	}


	/**
	 * Historically, the full field keys were used for group child fields.
	 *
	 * Opt-in to shorten the field keys like we do for top level fields.
	 *
	 * @since 4.10.0
	 *
	 * @param bool|string $short - `true` to use shortened keys. A string to specify a custom key.
	 *
	 * @return Field
	 */
	public function rest_group_short( bool|string $short = true ): Field {
		if ( ! $this->box->is_group() ) {
			_doing_it_wrong( __METHOD__, wp_kses_post( "Group short fields only apply to a group's child field. `{$this->get_id()}` is not applicable." ), '4.10.0' );
		}
		$this->rest_group_short = $short;
		return $this;
	}


	/**
	 * To show this field or not based on the result of a function.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_on_cb
	 * @example should_i_show( $field ){ return bool}
	 *
	 * @param callable $func - The function to use for determining if the field should show.
	 *
	 * @return $this
	 */
	public function show_on_cb( callable $func ): Field {
		$this->show_on_cb = $func;

		return $this;
	}


	/**
	 * Save terms assigned to users as meta instead of the default
	 * object terms system.
	 *
	 * Prevent conflicts with User ID and Post ID in the same
	 * `term_relationship` table.
	 *
	 * @note   The meta repo has never supported using object terms so setting
	 *         this to false will not change the behavior of the meta repo.
	 *
	 * @notice The default value is `true` so this need only be called with `false`.
	 *
	 * @param bool $use_meta - Whether to use meta or not.
	 *
	 * @return Field
	 */
	public function store_user_terms_in_meta( bool $use_meta = true ): Field {
		$box = $this->get_box();
		if ( null !== $box && ( ! \in_array( $this->data_type, [ Repo::TYPE_TAXONOMY, Repo::TYPE_TAXONOMY_SINGULAR ], true ) || ! \in_array( 'user', $box->get_object_types(), true ) ) ) {
			_doing_it_wrong( __METHOD__, 'Storing user terms in meta only applies to taxonomy fields registered on users.', '3.14.0' );
		}
		$this->store_user_terms_in_meta = $use_meta;

		return $this;
	}


	/**
	 * Field parameter, which can be used by the  'file_*' field types.
	 * allows overriding the media library query arguments.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @param Get_Posts $args - The arguments to pass to get_posts().
	 *
	 * @return Field
	 */
	public function file_query_args( Get_Posts $args ): Field {
		if ( Repo::TYPE_FILE !== $this->data_type ) {
			_doing_it_wrong( __METHOD__, 'File query args are only supported for file fields.', '5.0.0' );
		}

		$this->query_args = $args->get_args();
		return $this;
	}


	/**
	 * Field parameter, which can be used by the  'taxonomy_*' field types.
	 * allows overriding the media library query arguments.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @param Get_Terms $args - The arguments to pass to get_terms().
	 *
	 * @return Field
	 */
	public function term_query_args( Get_Terms $args ): Field {
		if ( ! \in_array( $this->data_type, [ Repo::TYPE_TAXONOMY, Repo::TYPE_TAXONOMY_SINGULAR ], true ) ) {
			_doing_it_wrong( __METHOD__, 'Term query args are only supported for taxonomy fields.', '5.0.0' );
		}

		$this->query_args = $args->get_args();
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
	 * @return $this
	 */
	public function tab( string $id ): Field {
		Tabs::init_once();

		$this->tab = $id;
		if ( null !== $this->render_row_cb ) {
			$this->tab_content_cb = $this->render_row_cb;
		}
		$this->render_row_cb( [ Tabs::in(), 'render_field' ] );

		return $this;
	}


	/**
	 * Set the type programmatically
	 * Using the Field_Type class, which
	 * maps all special keys for every
	 * available field
	 *
	 * This is much preferred over setting $this->type
	 * directly, which has room for error
	 *
	 * @return Field_Type
	 */
	public function type(): Field_Type {
		return new Field_Type( $this );
	}


	/**
	 * The type of field
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#type
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @see  Field_Type;
	 * @see  Field::type;
	 *
	 * @return string
	 */
	public function get_type(): string {
		return $this->type;
	}


	/**
	 * Set a Fields Type and register the type with Meta\Repo
	 *
	 * @phpstan-param REPO::TYPE_* $type
	 * @phpstan-param REPO::TYPE_* $data_type
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @internal
	 *
	 * @param string               $type      - CMB2 field type.
	 * @param string               $data_type - Field data structure type.
	 *
	 * @return void
	 */
	public function set_type( string $type, string $data_type ): void {
		$this->type = $type;
		$this->data_type = $data_type;
	}


	/**
	 * Callback to render the field's row.
	 *
	 * @param callable $callback - The callback to render the field's row.
	 *
	 * @return Field
	 */
	public function render_row_cb( callable $callback ): Field {
		$this->render_row_cb = $callback;

		return $this;
	}


	/**
	 * Is this field repeatable?
	 *
	 * @interal
	 *
	 * @return bool
	 */
	public function is_repeatable(): bool {
		return $this->repeatable;
	}


	/**
	 * Does this field return a value of array type?
	 *
	 * @internal
	 *
	 * @return bool
	 */
	public function is_using_array_data(): bool {
		return $this->repeatable || 'multicheck' === $this->get_type() || 'multicheck_inline' === $this->get_type();
	}


	/**
	 * Does this field return a value of object type?
	 *
	 * @internal
	 *
	 * @return bool
	 */
	public function is_using_object_data(): bool {
		return ! $this->repeatable && 'file_list' === $this->get_type();
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
	 * @return Field
	 */
	public function delete_cb( callable $callback ): Field {
		$this->delete_cb = $callback;
		$this->event_callbacks[] = new Event_Callbacks( $this, Event_Callbacks::TYPE_DELETE );
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
	 * @return Field
	 */
	public function change_cb( callable $callback ): Field {
		$this->change_cb = $callback;
		$this->event_callbacks[] = new Event_Callbacks( $this, Event_Callbacks::TYPE_CHANGE );

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
	 * @return Field
	 */
	public function sanitization_cb( callable $callback ): Field {
		if ( [ 'options-page' ] !== $this->box->get_object_types() && $this->box->is_allowed_to_register_meta( $this ) ) {
			$this->sanitize_callback = $callback;
		} else {
			$this->sanitization_cb = $callback;
		}
		return $this;
	}


	/**
	 * Support default meta using a callback.
	 *
	 * Register meta only support static values to be used as default,
	 * although we may pass a callback when registering the CMB2 field.
	 * CMB2 only support defaults in the meta box, not when retrieving
	 * data, so we tap into core WP default a meta filter to support
	 * the callback.
	 *
	 * @filter default_{$meta_type}_metadata 11, 3
	 *
	 * @internal
	 *
	 * @param mixed      $value     - Empty, or a value set by another filter.
	 * @param int|string $object_id - Current post/term/user id.
	 * @param string     $meta_key  - Meta key being filtered.
	 *
	 * @return mixed
	 */
	public function default_meta_callback( mixed $value, int|string $object_id, string $meta_key ): mixed {
		if ( $this->get_id() !== $meta_key ) {
			return $value;
		}

		// Will create an infinite loop if filter is intact.
		remove_filter( "default_{$this->box->get_object_type()}_metadata", [ $this, 'default_meta_callback' ], 11 );
		$cmb2_field = $this->get_cmb2_field( $object_id );
		if ( null !== $cmb2_field ) {
			add_filter( "default_{$this->box->get_object_type()}_metadata", [ $this, 'default_meta_callback' ], 11, 3 );
			return \call_user_func( $this->default_cb, $cmb2_field->properties, $cmb2_field );
		}

		return false;
	}


	/**
	 * Support default options using a callback.
	 *
	 * CMB2 takes care of rendering default values on the
	 * options pages, this takes care of returning default
	 * values when retrieving options.
	 *
	 * CMB2 stores options data a one big blog, so we
	 * can't tap into WP core default option filters.
	 * Instead, we tap into the custom filters added to
	 * lipemat/cmb2.
	 *
	 * @filter cmb2_default_option_{$this->key}_{$field_id} 11 0
	 *
	 * @internal
	 *
	 * @return mixed
	 */
	public function default_option_callback() {
		$cmb2_field = $this->get_cmb2_field();
		if ( null === $cmb2_field ) {
			return false;
		}
		// @phpstan-ignore-next-line -- The object id must accept a string for options.
		$cmb2_field->object_id( $this->box->get_id() );
		return \call_user_func( $this->default_cb, $cmb2_field->properties, $cmb2_field );
	}


	/**
	 * Retrieve the CMB2 version of this field.
	 *
	 * @since 2.22.1
	 *
	 * @param int|string $object_id - The object id to pass on to CMB2.
	 *
	 * @return ?\CMB2_Field
	 */
	public function get_cmb2_field( int|string $object_id = 0 ): ?\CMB2_Field {
		return cmb2_get_field( $this->box->get_id(), $this->get_id(), $object_id );
	}


	/**
	 * Retrieve an array of these fields args to be
	 * submitted to CMB2 by way of
	 *
	 * @see Box::add_field_to_box()
	 *
	 * @throws \LogicException - If a field has not been specified.
	 *
	 * @return array<string, mixed>
	 */
	public function get_field_args(): array {
		if ( ! isset( $this->type ) ) {
			throw new \LogicException( esc_html__( 'You must specify a field type (use $field->type() ).', 'lipe' ) );
		}
		$args = [];
		foreach ( \get_object_vars( $this ) as $_var => $_value ) {
			if ( ! isset( $this->{$_var} ) ) {
				continue;
			}
			$args[ $_var ] = $this->{$_var};
		}

		return $args;
	}


	/**
	 * Get the short name of a field for use in the REST API.
	 *
	 * @return string
	 */
	public function get_rest_short_name(): string {
		$name = \explode( '/', $this->get_id() );
		return \end( $name );
	}


	/**
	 * Override to allow static scans when using tools like PHPStan.
	 *
	 * @internal
	 *
	 * @param string $id   - The field id.
	 * @param string $name - The field name.
	 *
	 * @throws \LogicException - When trying to add a field to another field.
	 */
	public function field( string $id, string $name ): Field_Type { //phpcs:ignore -- Signature must match parent.
		throw new \LogicException( esc_html__( 'You cannot add a field to another field.', 'lipe' ) );
	}
}
