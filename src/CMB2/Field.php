<?php

namespace Lipe\Lib\CMB2;

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
	 * The field label
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Field description. Usually under or adjacent to the field input.
	 *
	 * @var string
	 */
	protected $desc = '';

	/**
	 * The data key. If using for posts, will be the post-meta key.
	 * If using for an options page, will be the array key.
	 *
	 * @required
	 *
	 * @example 'yourprefix_first_name',
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types
	 *
	 * @see \Lipe\Lib\CMB2\Field_Type;
	 *
	 * @var string;
	 */
	protected $type;

	/**
	 * Will modify default attributes (class, input type, rows, etc),
	 * or add your own (placeholder, data attributes)
	 *
	 * @example [
	 *          'placeholder' => 'A small amount of text',
	 *          'rows'        => 3,
	 *          'required'    => 'required',
	 *          'type' => 'number',
	 * 'min'  => '101',
	 *          ]
	 *
	 * @var     []
	 */
	public $attributes;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
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
	 * @var callable|string
	 */
	public $after;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
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
	 * @var callable|string
	 */
	public $after_row;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
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
	 * @var callable|string
	 */
	public $after_field;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
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
	 * @var callable|string
	 */
	public $before_display;

	/**
	 * These allow you to add arbitrary text/markup at different points in the field markup.
	 * These also accept a callback.
	 * The callback will receive $field_args as the first argument,
	 * and the CMB2_Field $field object as the second argument
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
	 * @var callable|string
	 */
	public $after_display_wrap;

	/**
	 * This property allows you to optionally add classes to the CMB2 wrapper.
	 * This property can take a string, or array.
	 *
	 * @example 'additional-class'
	 * @example array( 'additional-class', 'another-class' ),
	 *
	 * @var mixed
	 */
	public $classes;

	/**
	 * you can now set admin post-listing columns with an extra field parameter, 'column' => true,.
	 * If you want to dictate what position the column is,
	 * use 'column' => array( 'position' => 2 ),.
	 * If you want to dictate the column title (instead of using the field 'name' value),
	 * use 'column' => array( 'name' => 'My Column' ),.
	 * If you need to specify the column display callback,
	 * set the 'display_cb' parameter to a callback function.
	 *
	 * Columns work for post (all post-types), comment, user, and term object types.
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
	 * @example: 'yourprefix_function_to_add_classes',
	 *
	 * @var callable
	 */
	public $classes_cb;

	/**
	 * Field parameter used in the date field types which allows specifying
	 * the php date format for your field.
	 *
	 * @link php.net/manual/en/function.date.php.
	 *
	 * @var
	 */
	public $date_format;

	/**
	 * Specify a default value for the field.
	 *
	 * @var string
	 */
	public $default;

	/**
	 * With the addition of optional columns display output in 2.2.2,
	 * You can now set the field's 'display_cb' to dictate
	 * how that field value should be displayed.
	 *
	 * @example 'my_callback_function_to_display_output'
	 *
	 * @var callable
	 */
	public $display_cb;

	/**
	 * Bypass the CMB escaping (escapes before display) methods with your own callback.
	 * Set to false if you do not want any escaping (not recommended).
	 *
	 */
	public $escape_cb;

	/**
	 * If you're planning on using your metabox fields on the front-end as well (user-facing),
	 * then you can specify that certain fields do not get displayed there
	 * by setting this parameter to false.
	 *
	 * Default is true.
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
	 * @var []
	 */
	public $options;

	/**
	 * A callback to provide field options.
	 * Callback function should return an options array.
	 * The callback function gets passed the $field object.
	 * It is recommended to use this parameter over the options parameter
	 * if you are doing anything complex to generate your options array,
	 * as the '*_cb' parameters are run at the moment the field is generated,
	 * instead of on every page load (admin or otherwise). Example:
	 *
	 * @var callable
	 */
	public $options_cb;

	/**
	 * Allows overriding the default CMB2_Type_Base class
	 * that is used when rendering the field.
	 * This provides interesting object-oriented ways to override default CMB2 behavior
	 * by subclassing the default class and overriding methods.
	 * For best results, your class should extend the class it is overriding.
	 *
	 *
	 * @var string
	 */
	public $render_class;

	/**
	 * Bypass the CMB row rendering.
	 * You will be completely responsible for outputting that row's html.
	 * The callback function gets passed the field $args array, and the $field object.
	 *
	 * @link https://github.com/WebDevStudios/CMB2/issues/596#issuecomment-187941343
	 *
	 * @var callable
	 */
	public $render_row_cb;

	/**
	 * Supported by most field types, and will make the individual field a repeatable one.
	 *
	 * In order to customize Add Row button label, add to your Field's config array:
	 *
	 * @link    https://github.com/WebDevStudios/CMB2/wiki/Field-Types#types
	 *
	 * @default is false.
	 * @example true
	 *
	 * @var bool
	 */
	public $repeatable;

	/**
	 * New field parameter for taxonomy fields, 'remove_default'
	 * which allows disabling the default taxonomy metabox.
	 *
	 * @var bool
	 */
	public $remove_default;

	/**
	 * Bypass the CMB sanitization (sanitizes before saving) methods with your own callback.
	 * Set to false if you do not want any sanitization (not recommended).
	 *
	 */
	public $sanitization_cb;

	/**
	 * Whether to show labels for the fields
	 *
	 * @var bool
	 */
	public $show_names;

	/**
	 * To show or not based on the result
	 * of a function.
	 * Pass a function name here
	 *
	 * @var bool
	 */
	public $show_on_cb;

	/**
	 * Used for date/time fields
	 *
	 * Optionally make this field honor the timezone selected
	 * in the select_timezone field specified above.
	 *
	 * @var string
	 */
	public $timezone_meta_key;

	/**
	 * Used to configure some strings for things like
	 *
	 * 'add_row_text' for repeaters
	 *
	 * @example array(
	 * 'add_row_text' => 'Add Another Special Row',
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
	 * @var
	 */
	public $query_args;


	/**
	 * Field constructor.
	 *
	 * @see \Lipe\Lib\CMB2\Field_Type
	 *
	 * @example $field = new Field( self::FEATURED_TAG, __( 'Featured Tag', 'tribe' ), Field_Type::types()->checkbox );
	 *
	 * @param string $id
	 * @param string $name
	 * @param string $type
	 * @param string $desc
	 */
	public function __construct( $id, $name, $type, $desc = '' ) {
		$this->id = $id;
		$this->name = $name;
		$this->type = $type;
		$this->desc = $desc;
	}



	public function get_field_args() {
		$args = [];
		foreach( get_object_vars( $this ) as $_var => $_value ){
			if( !isset( $this->{$_var} ) ){
				continue;
			}
			switch ( $_var ){
				default:
					$args[ $_var ] = $this->{$_var};
					break;
			}
		}

		return $args;
	}
}