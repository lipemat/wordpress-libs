<?php

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Box\Tabs;
use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Util\Arrays;

/**
 * Field
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Lib\CMB2
 */
class Field {
	/**
	 * The data key. If using for posts, will be the post-meta key.
	 * If using for an option's page, will be the array key.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#id
	 *
	 * @required
	 *
	 * @example 'yourprefix_first_name',
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 * Id of meta box this field is assigned to.
	 *
	 * @internal
	 *
	 * @since 2.15.0
	 *
	 * @var string
	 */
	public $box_id;

	/**
	 * The field label
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Custom callback to return the label for the field
	 *
	 * Part of cmb2 core but undocumented
	 *
	 * @var callable
	 */
	public $label_cb;

	/**
	 * The type of field
	 * Calling Field::type() will return the Field_Type object which
	 * will auto complete any type.
	 *
	 * link https://github.com/CMB2/CMB2/wiki/Field-Parameters#type
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @see  \Lipe\Lib\CMB2\Field_Type;
	 * @see  \Lipe\Lib\CMB2\Field::type();
	 *
	 * @var string;
	 */
	protected $type;

	/**
	 * Used by the Repo to determine the data type of this field.
	 *
	 * @interal
	 *
	 * @var string {
	 *      @type Repo::DEFAULT
	 *      @type Repo::CHECKBOX
	 *      @type Repo::FILE
	 *      @type Repo::GROUP
	 *      @type Repo::TAXONOMY
	 * }
	 */
	public $data_type = Repo::DEFAULT;

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
	 *
	 * @var     array
	 */
	public $attributes = [];

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
	 * Enable a character/word counter for a 'textarea', 'wysiwyg', or 'text' type field.
	 *
	 * @var bool|string - true | 'words'
	 */
	public $char_counter;

	/**
	 * Used in conjunction with `char_counter` to count character/words remaining.
	 *
	 * @var int
	 */
	public $char_max;

	/**
	 * Used in conjunction with `char_max` to enforce length when counting characters.
	 *
	 * @var bool
	 */
	public $char_max_enforce;

	/**
	 * This property allows you to optionally add classes to the CMB2 wrapper.
	 * This property can take a string, or array.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#classes
	 *
	 * @example 'additional-class'
	 * @example array( 'additional-class', 'another-class' ),
	 *
	 * @var mixed
	 */
	public $classes;

	/**
	 * Set to true to display a object list column.
	 * Use this classes method for more refined control.
	 * Columns work for post (all post-types), comment, user, and term object types.
	 *
	 * @see  \Lipe\Lib\CMB2\Field::column()
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
	 *
	 * @var array|bool
	 */
	public $column;

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
	 * @var
	 */
	public $date_format;

	/**
	 * Specify a default value for the field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#default
	 *
	 * @var string
	 */
	public $default;

	/**
	 * Field description. Usually under or adjacent to the field input.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#desc
	 *
	 * @var string
	 */
	public $desc = '';

	/**
	 * To be used in conjunction with $this->column or $this->column().
	 * Callback function to display the output of the column in the
	 * object-lists
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
	 * @since CMB2 2.7.0
	 *
	 * @todo Add link to docs once they exist.
	 *
	 * @var \CMB2_Field_Display
	 */
	public $display_class;

	/**
	 * Bypass the CMB escaping (escapes before display) methods with your own callback.
	 * Set to false if you do not want any escaping (not recommended).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#escape_cb
	 *
	 * @see Field::escape_cb()
	 *
	 * @var callable|false
	 *
	 */
	public $escape_cb;

	/**
	 * If this field is part of a group this may be used to retrieve
	 * the group id.
	 *
	 * @internal
	 *
	 * @since 2.9.0
	 *
	 * @var string|null
	 */
	public $group;

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
	public $on_front;

	/**
	 * For fields that take an options array.
	 * These include select, radio, multicheck, wysiwyg and group.
	 * Should be a an array where the keys are the option value,
	 * and the values are the option text.
	 * If you are doing any kind of database querying or logic/conditional checking,
	 * you're almost always better off using the options_cb parameter.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#options
	 *
	 * @var  []
	 */
	public $options;

	/**
	 * A callback to provide field options.
	 * Callback function should return an options array.
	 * The callback function gets passed the $field object.
	 * It is recommended to use this parameter over the options parameter
	 * if you are doing anything complex to generate your options array,
	 * as the '*_cb' parameters are run at the moment the field is generated,
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
	 * @default 0
	 *
	 * @var int
	 */
	public $position = 0;

	/**
	 * For use with the file fields only to control the preview size
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 *
	 * @var string
	 */
	public $preview_size;

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
	public $render_class;

	/**
	 * Bypass the CMB row rendering.
	 * You will be completely responsible for outputting that row's html.
	 * The callback function gets passed the field $args array, and the $field object.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_row_cb
	 * @link https://github.com/WebDevStudios/CMB2/issues/596#issuecomment-187941343
	 *
	 * @var callable
	 */
	public $render_row_cb;

	/**
	 * Supported by most field types, and will make the individual field a repeatable one.
	 *
	 * In order to customize Add Row button label, set
	 * $this->text[ 'add_row_text' ] = 'Add Row':
	 *
	 * @see     Field::repeatable()
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#repeatable
	 * @link    https://github.com/WebDevStudios/CMB2/wiki/Field-Types#types
	 *
	 * @default false.
	 * @example true
	 *
	 * @var bool
	 */
	public $repeatable;

	/**
	 * Filter the value which is returned in the rest api responses
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#rest_value_cb
	 * @link https://github.com/CMB2/CMB2/wiki/REST-API#overriding-a-returned-value-for-a-individual-field
	 *
	 * @see Field::rest_value_cb()
	 *
	 * @example 'intval'
	 *
	 * @var callable
	 */
	public $rest_value_cb;

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
	public $remove_default;

	/**
	 * Bypass the CMB sanitization (sanitizes before saving) methods with your own callback.
	 * Set to false if you do not want any sanitization (not recommended).
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#sanitization_cb
	 *
	 * @see Field::sanitization_cb()
	 *
	 * @example sanitize_function( $value, $field_args, $field ){ return string }
	 *
	 * @var callable|false
	 *
	 */
	public $sanitization_cb;

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
	public $select_all_button;

	/**
	 * Whether to show labels for the fields
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_names
	 * @default true
	 * @example false
	 *
	 * @var bool
	 */
	public $show_names;

	/**
	 * To override the box's `show_in_rest` for this field.
	 *
	 * Only individual fields that are explicitly set to truthy will
	 * be included in default WP response even if the box is set to true
	 * and all fields are in the /cmb2 response.
	 *
	 * CMB2 honors the WP_REST_SERVER methods of transport
	 * for including fields in the /cmb2 endpoint.
	 * WP does not so, this field will either be included
	 * or not to default WP response based on truthy.
	 *
	 * @example WP_REST_Server::READABLE
	 * @example WP_REST_Server::ALLMETHODS
	 * @example WP_REST_Server::EDITABLE
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
	 * @see     \Lipe\Lib\CMB2\Field::show_on_cb()
	 *
	 * @var callable
	 */
	public $show_on_cb;

	/**
	 * Id of boxes tab which this field should display in.
	 * The tab must be first registered with the box
	 *
	 * @see \Lipe\Lib\CMB2\Field::tab();
	 * @see \Lipe\Lib\CMB2\Box::add_tab()
	 *
	 * @var string
	 */
	protected $tab;

	/**
	 * A render row cb to use inside a tab.
	 * Stored here so we can set the `render_row_cb` to the tab's
	 * method an keep outside `render_row_cb` intact.
	 *
	 * @since 2.10.0
	 *
	 * @var callable
	 */
	protected $tab_content_cb;

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
	public $timezone_meta_key;

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
	public $taxonomy;

	/**
	 * Used to configure some strings for thinks like taxonomy and repeater fields
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#repeatable
	 *
	 * @example array(
	 *          'add_row_text' => 'Add Another Special Row',
	 *          'no_terms_text' => 'Sorry, no terms could be found.'
	 * )
	 *
	 *
	 * @var     []
	 */
	public $text;

	/**
	 * Field parameter which can be used by the 'taxonomy_*' and the 'file_*' field types.
	 * For the 'taxonomy_*' types, provides ability
	 * to override the arguments passed to get_terms(), and for the 'file_*' field types,
	 * allows overriding the media library query arguments.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @var  array
	 */
	public $query_args;

	/**
	 * Parent class calling this Field.
	 * For any conditional logic where we need to know
	 * which class is currently using this.
	 *
	 * @since 2.19.0
	 *
	 * @var Box_Trait|null
	 */
	protected $box;


	/**
	 * Field constructor.
	 *
	 * @param string         $id
	 * @param string|null    $name
	 * @param Box_Trait|null $box - Parent class using this Field.
	 *
	 * @see     \Lipe\Lib\CMB2\Field_Type
	 *
	 * @example $field = new Field( self::FEATURED_TAG, __( 'Featured Tag', 'tribe' ), Field_Type::types()->checkbox );
	 */
	public function __construct( string $id, ?string $name, $box = null ) {
		$this->id   = $id;
		$this->name = $name;
		$this->box = $box;
	}


	/**
	 * The data key. If using for posts, will be the post-meta key.
	 * If using for an options page, will be the array key.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#id
	 *
	 * @required
	 *
	 * @example 'lipe/project/meta/category-fields',
	 *
	 * @return string
	 */
	public function get_id() : string {
		return $this->id;
	}


	/**
	 * The field label
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#name
	 *
	 * @return string
	 */
	public function get_name() : string {
		return $this->name;
	}


	/**
	 * Enable a character/word counter for a 'textarea', 'wysiwyg', or 'text' type field.
	 *
	 * @param bool $count_words - Count words instead of characters.
	 * @param null|int  $max - Show remaining character/words based on provided limit.
	 * @param bool  $enforce - Enforce max length using `maxlength` attribute when
	 *                       characters are counted.
	 * @param array $labels  - Override the default text strings associated with these
	 *                       parameters {
	 *                          'words_left_text' - Default: "Words left"
	 *                          'words_text' - Default: "Words"
	 *                          'characters_left_text' - Default: "Characters left"
	 *                          'characters_text' - Default: "Characters"
	 *                          'characters_truncated_text' - Default: "Your text may be truncated."
	 *                       }
	 *
	 * @notice Does not work with wysiwyg which are repeatable.
	 *
	 * @since CMB2 2.7.0
	 *
	 * @return Field
	 */
	public function char_counter( $count_words = false, $max = null, $enforce = false, $labels = [] ) : Field {
		$this->char_counter = $count_words ? 'words' : true;

		if ( $max ) {
			$this->char_max = $max;
			if ( $enforce ) {
				if ( 'words' === $this->char_counter ) {
					\_doing_it_wrong( 'char_counter', esc_html__( 'You cannot enforce max length when counting words', 'lipe' ), '2.17.0' );
				}
				$this->char_max_enforce = true;
			}
		}

		if ( ! empty( $labels ) ) {
			$this->text = array_merge( (array) $this->text, \array_intersect_key( $labels, array_flip( [
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
	 * posts, comments, users, terms
	 *
	 * @param int|null      $position
	 * @param string|null   $name       - defaults to field name
	 * @param callable|null $display_cb - optional display callback
	 * @param bool|null $disable_sorting - Set to true to prevent this column from being
	 *                                  sortable in post list.
	 *
	 * @return Field
	 */
	public function column( int $position = null, string $name = null, $display_cb = null, $disable_sorting = null ) : Field {
		$this->column = [
			'disable_sortable' => $disable_sorting ?? false,
			'name'             => $name ?? $this->name,
			'position'         => $position,
		];
		if ( null === $position && null === $name && null === $disable_sorting ) {
			$this->column = true;
		}
		if ( null !== $display_cb ) {
			$this->display_cb = $display_cb;
		}

		return $this;
	}


	/**
	 * Will modify default attributes (class, input type, rows, etc),
	 * or add your own (placeholder, data attributes)
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
	 * @param array $attributes
	 *
	 * @return Field
	 */
	public function attributes( array $attributes ) : Field {
		$this->attributes = Arrays::in()->array_merge_recursive( $this->attributes, $attributes );

		return $this;
	}


	/**
	 * Specify a default value for the field, or a
	 * function which will return a default value.
	 *
	 * @notice  The default will only be used when rendering form and not on retrieving value.
	 *
	 * @param string|callable $default_value
	 *
	 * @example = 'John'
	 * @example function prefix_set_test_default( $field_args, $field ) {
	 *                      return 'Post ID: '. $field->object_id
	 *                  }
	 *
	 * @notice  checkboxes are tricky
	 *          https://github.com/CMB2/CMB2/wiki/Tips-&-Tricks#setting-a-default-value-for-a-checkbox
	 *
	 * @return Field
	 */
	public function default( $default_value ) : Field {
		$this->default = $default_value;

		return $this;
	}


	/**
	 * Field description. Usually under or adjacent to the field input.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#desc
	 *
	 * @param string $description
	 *
	 * @return Field
	 */
	public function description( string $description ) : Field {
		$this->desc = $description;

		return $this;
	}


	/**
	 * Mark this field as 'disabled'
	 *
	 * @since 1.18.0
	 *
	 * @return Field
	 */
	public function disabled() : Field {
		$this->attributes( [ 'disabled' => 'disabled' ] );

		return $this;
	}

	/**
	 * Bypass the CMB escaping (escapes before display) methods with your own callback.
	 * Set to false if you do not want any escaping (not recommended).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#escape_cb
	 *
	 * @param callable $callback
	 *
	 * @return Field
	 */
	public function escape_cb( callable $callback ) : Field {
		$this->escape_cb = $callback;
		return $this;
	}


	/**
	 * Supported by most field types, and will make the individual field a repeatable one.
	 *
	 * @param bool   $repeatable
	 * @param string $add_row_text
	 *
	 * @default true
	 *
	 * @return $this
	 */
	public function repeatable( bool $repeatable = true, ?string $add_row_text = null ) : Field {
		// Ugh! Hack so I can use a method from that class
		$mock = new class() extends \CMB2_Field {
			public function __construct() {}

			public function allowed( $type ) : bool {
				if ( parent::repeatable_exception( $type ) ) {
					return false;
				}
				// Cases not covered by CMB2
				return 'file_list' !== $type;
			}
		};
		if ( ! $mock->allowed( $this->get_type() ) ) {
			trigger_error( esc_html( "Fields of `{$this->get_type()}` type do not support repeating" ) );
		}
		$this->repeatable           = $repeatable;
		$this->text['add_row_text'] = $add_row_text;

		return $this;
	}

	/**
	 * Callback to filter the return value for this field in
	 * the rest api responses.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#rest_value_cb
	 * @link https://github.com/CMB2/CMB2/wiki/REST-API#overriding-a-returned-value-for-a-individual-field
	 *
	 * @param callable $callback
	 *
	 * @example 'intval'
	 *
	 * @return Field
	 */
	public function rest_value_cb( callable $callback ) : Field {
		$this->rest_value_cb = $callback;
		return $this;
	}

	/**
	 * Set the position of the field in the meta box
	 *
	 * @param int $position
	 *
	 * @default 1
	 *
	 * @return $this
	 */
	public function position( int $position = 1 ) {
		$this->position = $position;

		return $this;
	}


	/**
	 * Mark this field as 'readonly'
	 *
	 * @since 1.18.0
	 *
	 * @return Field
	 */
	public function readonly() : Field {
		$disable_only = [
			'select',
			'select_timezone',
			'text_date',
			'text_date_timestamp',
			'text_datetime_timestamp',
			'text_datetime_timestamp_timezone',
			'taxonomy_select',
		];

		// These html inputs do not work as readonly and must be disabled
		if ( in_array( $this->type, $disable_only, true ) ) {
			$this->disabled();
		}

		$this->attributes( [ 'readonly' => 'readonly' ] );

		return $this;
	}


	/**
	 * Mark this field as 'required'
	 *
	 * @notice As of WP 5.1.1 this has not effect on meta box fields with
	 *         Gutenberg enabled. Possibly will be changed in a future version
	 *         of WP?
	 *
	 * @since 2.7.2
	 *
	 * @return Field
	 */
	public function required() : Field {
		// The only way a file field may be required is if the text field is showing.
		if ( 'file' === $this->type ) {
			$this->options['url'] = true;
		}
		$this->attributes( [ 'required' => 'required' ] );
		return $this;
	}


	/**
	 * Override the box's `show_in_rest` value for this field.
	 *
	 * If the box's `show_in_rest` is false, and a non `false` parameter
	 * is passed, the box's `show_in_rest` will be set to true and all
	 * fields which do not have a `show_in_rest` specified will be set false.
	 *
	 * Only individual fields that are explicitly set to truthy will
	 * be included in default WP response even if the box is set to true
	 * and all fields are in the /cmb2 response.
	 *
	 * CMB2 honors the WP_REST_SERVER methods of transport
	 * for including fields in the /cmb2 endpoint.
	 * WP does not so, this field will either be included
	 * or not to default WP response based on truthy.
	 *
	 *
	 * @param string|bool $methods
	 *
	 * @see Box_Trait::selectively_show_in_rest()
	 *
	 * @example WP_REST_Server::READABLE // Same as `true`
	 * @example WP_REST_Server::ALLMETHODS
	 * @example WP_REST_Server::EDITABLE
	 *
	 * @since 2.15.0
	 *
	 * @return Field
	 */
	public function show_in_rest( $methods = \WP_REST_Server::READABLE ) : Field {
		if ( null !== $this->box && $this->box->is_group() ) {
			\_doing_it_wrong( __METHOD__, "Show in rest may only be added to whole group. Not a group's field .", '2.19.0' );
		}
		$this->show_in_rest = $methods;
		return $this;

	}

	/**
	 * To show this field or not based on the result of a function.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_on_cb
	 * @example should_i_show( $field ){ return bool}
	 *
	 * @param callable $func
	 *
	 * @return $this
	 */
	public function show_on_cb( callable $func ) : Field {
		$this->show_on_cb = $func;

		return $this;
	}


	/**
	 * Field parameter which can be used by the 'taxonomy_*' and the 'file_*' field types.
	 * For the 'taxonomy_*' types, provides ability
	 * to override the arguments passed to get_terms(), and for the 'file_*' field types,
	 * allows overriding the media library query arguments.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @var array $args ;
	 *
	 * @since 1.7.0
	 *
	 * @return $this
	 */
	public function query_args( array $args ) : Field {
		$this->query_args = $args;

		return $this;
	}


	/**
	 * Add this field to a tab.
	 * The tab must be first registered with the box.
	 *
	 * @see \Lipe\Lib\CMB2\Box::add_tab()
	 * @see Tabs::render_field()
	 *
	 * @param string $id
	 *
	 * @return $this
	 */
	public function tab( string $id ) : Field {
		Tabs::init_once();

		$this->tab           = $id;
		if ( $this->render_row_cb ) {
			$this->tab_content_cb = $this->render_row_cb;
		}
		$this->render_row_cb( [ Tabs::in(), 'render_field' ] );

		return $this;
	}


	/**
	 * Set the type programmatically
	 * Using the Field_Type class which
	 * maps all special keys for every
	 * available field
	 *
	 * This is much preferred over setting $this->type
	 * directly which has room for error
	 *
	 * @return Field_Type
	 */
	public function type() : Field_Type {
		return new Field_Type( $this );
	}

	/**
	 * The type of field
	 *
	 * link https://github.com/CMB2/CMB2/wiki/Field-Parameters#type
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @see  \Lipe\Lib\CMB2\Field_Type;
	 * @see  \Lipe\Lib\CMB2\Field::type();
	 *
	 * @return string
	 */
	public function get_type() : string {
		return $this->type;
	}


	/**
	 *
	 * @param callable $callback
	 *
	 * @since 2.10.0
	 *
	 * @return Field
	 */
	public function render_row_cb( callable $callback ) : Field {

		$this->render_row_cb = $callback;

		return $this;

	}


	/**
	 * Set a Fields Type and register the type with Meta\Repo
	 *
	 * @param string $type - CMB2 field type.
	 * @param string $data_type {
	 *      // Type of data to return from the repo.
	 *      @type Repo::DEFAULT
	 *      @type Repo::CHECKBOX
	 *      @type Repo::FILE
	 *      @type Repo::GROUP
	 *      @type Repo::TAXONOMY
	 * }
	 *
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @since 2.0.0
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function set_type( string $type, string $data_type ) : void {
		$this->type = $type;
		$this->data_type = $data_type;
	}


	/**
	 * Does this field return a value of array type.
	 *
	 * @since 2.19.0
	 *
	 * @internal
	 *
	 * @return bool
	 */
	public function is_using_array_data() : bool {
		return $this->repeatable || 'multicheck' === $this->get_type() || 'multicheck_inline' === $this->get_type();
	}


	/**
	 * Bypass the CMB sanitization (sanitizes before saving) methods with your own callback.
	 * Set to false if you do not want any sanitization (not recommended).
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#sanitization_cb
	 *
	 * @param callable $callback
	 *
	 * @return Field
	 */
	public function sanitization_cb( callable $callback ) : Field {
		$this->sanitization_cb = $callback;
		return $this;
	}


	/**
	 * Retrieve an array of this fields args to be
	 * submitted to CMB2 by way of
	 *
	 * @see Box::add_field_to_box()
	 *
	 * @throws \LogicException
	 *
	 * @return array
	 */
	public function get_field_args() : array {
		if ( empty( $this->type ) ) {
			throw new \LogicException( __( 'You must specify a field type (use $field->type() ).', 'lipe' ) );
		}
		$args = [];
		foreach ( get_object_vars( $this ) as $_var => $_value ) {
			if ( ! isset( $this->{$_var} ) ) {
				continue;
			}
			$args[ $_var ] = $this->{$_var};
		}

		return $args;
	}
}
