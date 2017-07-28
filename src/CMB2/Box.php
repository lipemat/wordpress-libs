<?php

namespace Lipe\Lib\CMB2;

/**
 * Box
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Lib\CMB2
 */
class Box {

	protected $id;

	/**
	 *  'normal', 'side', 'advanced'
	 *  'form_top', 'before_permalink', 'after_title', 'after_editor'
	 *
	 * @field 'form_top'
	 *
	 * @var string
	 */
	protected $context;

	/**
	 * An array containing post type slugs, or 'user', 'term', 'comment', or 'options-page'.
	 *
	 * @var array
	 */
	protected $object_types = [];

	protected $title = '';

	/**
	 * 'high', 'low', 'default'
	 *
	 * @var string
	 */
	public $priority = 'high';

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
	 * keep the meta box closed by default
	 *
	 * @var bool
	 */
	public $closed;

	/**
	 * Whether to enqeue CMB2 stylesheet. Default is
	 *
	 * @var bool
	 */
	public $cmb_styles;

	/**
	 * Whether to enqeue CMB2 Javascript files
	 *
	 * @var bool
	 */
	public $enqueue_js;

	/**
	 * Handles hooking CMB2 forms/metaboxes into the post/attachement/user screens,
	 * and handles hooking in and saving those fields.
	 * Set to false if you plan on handling the form/field output/saving
	 * (via something like cmb2_metabox_form()).
	 *
	 * @default true
	 *
	 * @var bool
	 */
	public $hookup;

	/**
	 * if object_types is set to 'term', and set to false,
	 * will remove the fields from the new-term screen.
	 *
	 * @default is true.
	 *
	 *
	 * @var string
	 */
	public $new_term_section;

	/**
	 * if object_types is set to 'user',
	 * will determine where fields are output in the new-user screen.
	 * Options are 'add-existing-user' and 'add-new-user'.
	 *
	 * @default is 'add-new-user'
	 *
	 * @var string
	 */
	public $new_user_section;

	/**
	 * This parameter is for post alternate-context metaboxes only.
	 *
	 * To output the fields 'naked' (without a postbox wrapper/style):
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Box-Properties#context
	 *
	 * @var bool
	 */
	public $remove_box_wrap;

	/**
	 * If false, will not save during hookup
	 *
	 * @see $this->hookup
	 *
	 * @var bool
	 */
	public $save_fields;

	/**
	 * Determines if/how fields/metabox are available in the REST API.
	 *
	 * Default is false.
	 *
	 * @link    https://github.com/WebDevStudios/CMB2/wiki/REST-API
	 *
	 * @example WP_REST_Server::READABLE, // or
	 * @example WP_REST_Server::ALLMETHODS/WP_REST_Server::EDITABLE
	 *
	 * @var string
	 */
	public $show_in_rest;

	/**
	 * Whether to show labels for the fields
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
	 *
	 * @example array( 'id' => 2 ), // Only show on the "about" page
	 *
	 * @var     []
	 */
	public $show_on;

	/**
	 * To show or not based on the result
	 * of a function.
	 * Pass a function name here
	 *
	 * @var bool
	 */
	public $show_on_cb;

	/**
	 * if object_types is set to 'term',
	 * it is required to provide a the taxonomies property,
	 * which should be an array of Taxonomies.
	 *
	 * @example array( 'category', 'post_tag' ),
	 *
	 * @var     []
	 */
	public $taxonomies;

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
	 * @param array  $object_types - post type slugs, or 'user', 'term', 'comment', or 'options-page'
	 * @param        $title
	 * @param string $context      - 'normal', 'side', 'advanced', 'form_top', 'before_permalink', 'after_title',
	 *                             'after_editor'
	 */
	public function __construct( $id, array $object_types, $title, $context = 'normal' ) {
		$this->id = $id;
		$this->object_types = $object_types;
		$this->title = $title;
		$this->context = 'normal';
	}


	/**
	 *
	 *
	 * @return \CMB2
	 */
	public function get_box() {
		if( isset( $this->cmb ) ){
			return $this->cmb;
		}

		$args = $this->get_args();
		$this->cmb = new_cmb2_box( $args );

		return $this->cmb;

	}


	protected function get_args() {
		$args = [];
		foreach( get_object_vars( $this ) as $_var => $_value ){
			if( $_var == 'cmb' || !isset( $this->{$_var} ) ){
				continue;
			}
			$args[ $_var ] = $this->{$_var};
		}

		return $args;
	}


	public function add_field( Field $field ) {
		$box = $this->get_box();
		$box->add_field( $field->get_field_args() );
	}

}