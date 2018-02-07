<?php

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Field_Types\Tab;

/**
 * Box
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Lib\CMB2
 */
class Box {
	use Shorthand_Fields;

	/**
	 * The id of metabox
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Box-Properties#id
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * The context within the screen where the boxes should display.
	 * Available contexts vary from screen to screen.
	 *
	 * @example 'normal', 'side', 'advanced' 'form_top',
	 *          'before_permalink', 'after_title', 'after_editor'
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#context
	 * @see     \Lipe\Lib\CMB2\Box::$remove_box_wrap
	 *
	 * @var string
	 */
	protected $context;

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
	 * Title display in the admin metabox.
	 *
	 * To keep from registering an actual post-screen metabox,
	 * omit the 'title' property from the metabox registration array.
	 * (WordPress will not display metaboxes without titles anyway)
	 * This is a good solution if you want to handle outputting your
	 * metaboxes/fields elsewhere in the post-screen.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Box-Properties#title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * Priority of the metabox in its context.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#priority
	 *
	 * @example 'high' || 'low' || 'default'
	 * @default 'high'
	 *
	 *
	 * @var string
	 */
	public $priority = 'high';

	/**
	 * This property allows you to optionally add classes to the CMB2 wrapper.
	 * This property can take a string, or array.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#classes
	 *
	 * @example 'additional-class'
	 * @example array( 'additional-class', 'another-class' ),
	 *
	 * @var mixed
	 */
	public $classes;

	/**
	 * Like the classes property, allows adding classes to the CMB2 wrapper,
	 * but takes a callback.
	 * That callback should return an array of classes.
	 * The callback gets passed the CMB2 $properties array as the first argument,
	 * and the CMB2 $cmb object as the second argument.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Box-Properties#classes_cb
	 *
	 * @example: 'yourprefix_function_to_add_classes( $properties, $cmb ){ return [] }',
	 *
	 * @var callable
	 */
	public $classes_cb;

	/**
	 * Set to true to default metabox being closed
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#closed
	 *
	 * @example true
	 * @default false
	 *
	 * @var bool
	 */
	public $closed;

	/**
	 * Whether to enqeue CMB2 stylesheet
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#cmb_styles
	 *
	 * @example false
	 * @default true
	 *
	 * @var bool
	 */
	public $cmb_styles;

	/**
	 * Whether to enqeue CMB2 Javascript files.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#enqueue_js
	 *
	 * @example false
	 * @default true
	 *
	 * @var bool
	 */
	public $enqueue_js;

	/**
	 * Handles hooking CMB2 forms/metaboxes into the post/attachment/user screens,
	 * and handles hooking in and saving those fields.
	 * Set to false if you plan on handling the form/field output/saving
	 * (via something like cmb2_metabox_form()).
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#hookup
	 *
	 * @default true
	 *
	 * @var bool
	 */
	public $hookup;

	/**
	 * This parameter is for post alternate-context metaboxes only.
	 * To output the fields 'naked' (without a postbox wrapper/style)
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#context
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#remove_box_wrap
	 *
	 * @see     \Lipe\Lib\CMB2\Box::$context
	 *
	 * @example true
	 * @default false
	 *
	 * @var bool
	 */
	public $remove_box_wrap;

	/**
	 * If false, will not save during hookup
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#save_fields
	 *
	 * @see     \Lipe\Lib\CMB2\Box::$hookup
	 *
	 * @example false
	 * @default true
	 *
	 * @var bool
	 */
	public $save_fields;

	/**
	 * Determines if/how fields/metabox are available in the REST API.
	 *
	 * @link    https://github.com/WebDevStudios/CMB2/wiki/REST-API
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#show_in_rest
	 *
	 * @example WP_REST_Server::READABLE, // or
	 * @example WP_REST_Server::ALLMETHODS/WP_REST_Server::EDITABLE
	 *
	 * @default false
	 *
	 * @var string
	 */
	public $show_in_rest;

	/**
	 * Whether to show labels for the fields
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#show_names
	 * @default true
	 * @example false
	 *
	 * @var bool
	 */
	public $show_names;

	/**
	 * Post IDs or page templates to display this metabox.
	 * Overrides 'show_on_cb'.
	 * More info:
	 *
	 * @link    https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-show_on-filters
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#show_on
	 *
	 * @example array( 'key' => 'page-template', 'value' => 'template-contact.php' )
	 * @example array( 'key' => 'id', 'value' => array( 50, 24 ) )
	 *
	 * @var     []
	 */
	public $show_on;

	/**
	 * To show or not based on the result
	 * of a function.
	 * Pass a function name here
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#show_on_cb
	 *
	 * @example should_show_meta_box( $cmb ){ return bool; }
	 *
	 * @var callable
	 */
	public $show_on_cb;

	/**
	 * Tabs for this box
	 *
	 * @see \Lipe\Lib\CMB2\Box::add_tab()
	 * @since   1.2.0
	 *
	 * @var array
	 */
	public $tabs = [];

	/**
	 * Tabs to display either vertical or horizontal
	 *
	 * @see Box::tabs_style()
	 * @since   1.2.0
	 *
	 * @var string
	 */
	protected $tab_style;

	/**
	 * cmb
	 *
	 * @var \CMB2
	 */
	public $cmb;


	/**
	 * Box constructor.
	 *
	 * @param        $id
	 * @param array  $object_types - [post type slugs], or 'user', 'term',
	 *                             'comment', or 'options-page'
	 * @param        $title
	 * @param string $context      - 'normal', 'side', 'advanced', 'form_top',
	 *                             'before_permalink', 'after_title',
	 *                             'after_editor'
	 */
	public function __construct( $id, array $object_types, $title, $context = 'normal' ) {
		$this->id = $id;
		$this->object_types = $object_types;
		$this->title = $title;
		$this->context = $context;
	}


	/**
	 * Add a tab to this box which can later be assigned to fields via
	 * Field::tab( $id );
	 *
	 * @see \Lipe\Lib\CMB2\Field::tab();
	 *
	 * @param string $id
	 * @param string $label
	 *
	 * @since   1.2.0
	 *
	 * @return void
	 */
	public function add_tab( string $id, string $label ) : void {
		$this->tabs[ $id ] = $label;
		Tab::init_once();
	}


	/**
	 * Should the tabs display vertical or horizontal?
	 * Default is vertical when not calling this.
	 *
	 * @param string $layout - vertical, horizontal (default to horizontal)
	 *
	 * @since   1.2.0
	 *
	 * @return void
	 */
	public function tabs_style( string $layout ) : void {
		$this->tab_style = $layout ? 'classic' : 'default';
	}

	/**
	 *
	 *
	 * @return \CMB2
	 */
	public function get_box() : \CMB2 {
		if( null !== $this->cmb ){
			return $this->cmb;
		}

		$args = $this->get_args();
		$this->cmb = new_cmb2_box( $args );

		return $this->cmb;

	}


	protected function get_args() : array {
		$args = [];
		foreach( get_object_vars( $this ) as $_var => $_value ){
			if( $_var === 'cmb' || !isset( $this->{$_var} ) || 'fields' === $_var ){
				continue;
			}
			$args[ $_var ] = $this->{$_var};
		}

		return $args;
	}


	public function add_field( Field $field ) : void {
		$box = $this->get_box();
		$box->add_field( $field->get_field_args(), $field->position );
	}

}
