<?php

namespace Lipe\Lib\CMB2;

/**
 * Field_Type
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types
 *
 * @package Lipe\Lib\CMB2
 */
class Field_Type {

	/**
	 * A large title (useful for breaking up sections of fields in metabox)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#title
	 */
	public $title;

	/**
	 * Standard text field (large).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text
	 */
	public $text;

	/**
	 * Small text field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_small
	 */
	public $text_small;

	/**
	 * Medium text field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_medium
	 */
	public $text_medium;

	/**
	 * Standard text field which enforces an email address..
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_email
	 */
	public $text_email;

	/**
	 * Standard text field which enforces a url.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_url
	 */
	public $text_url;

	/**
	 * Standard text field with dollar sign in front of it
	 * (useful to prevent users from adding a dollar sign to input). .
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_money
	 */
	public $text_money;

	/**
	 * Standard textarea.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#textarea
	 */
	public $textarea;

	/**
	 * Smaller textarea..
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#textarea_small
	 */
	public $textarea_small;

	/**
	 * Code textarea.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#textarea_code
	 */
	public $textarea_code;

	/**
	 * Time picker field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_time
	 */
	public $text_time;

	/**
	 * Timezone field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#select_timezone
	 */
	public $select_timezone;

	/**
	 * Date field. Stored and displayed according to the date_format.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_date
	 */
	public $text_date;

	/**
	 * Date field, stored as UNIX timestamp. Useful if you plan to query based on it (ex: events listing )
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_date_timestamp
	 */
	public $text_date_timestamp;

	/**
	 * Date and time field, stored as UNIX timestamp.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_datetime_timestamp
	 */
	public $text_datetime_timestamp;

	/**
	 * Date, time and timezone field, stored as serialized DateTime object.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_datetime_timestamp_timezone
	 */
	public $text_datetime_timestamp_timezone;

	/**
	 * Adds a hidden input type to the bottom of the CMB2 output.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#hidden
	 */
	public $hidden;

	/**
	 * A colorpicker field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#colorpicker
	 */
	public $colorpicker;

	/**
	 * Standard checkbox.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#checkbox
	 */
	public $checkbox;

	/**
	 * A field with multiple checkboxes (and multiple can be selected).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#multicheck-and-multicheck_inline
	 */
	public $multicheck;

	/**
	 * A field with multiple checkboxes (and multiple can be selected).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#multicheck-and-multicheck_inline
	 */
	public $multicheck_inline;

	/**
	 * Standard radio buttons.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#radio
	 */
	public $radio;

	/**
	 * Inline radio buttons.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#radio_inline
	 */
	public $radio_inline;

	/**
	 * Standard select dropdown.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#select
	 */
	public $select;

	/**
	 * Radio buttons pre-populated with taxonomy terms.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio
	 */
	public $taxonomy_radio;

	/**
	 * Inline radio buttons pre-populated with taxonomy terms.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio_inline
	 */
	public $taxonomy_radio_inline;

	/**
	 * A select field pre-populated with taxonomy terms.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_select
	 */
	public $taxonomy_select;

	/**
	 * A field with checkboxes with taxonomy terms, and multiple terms can be selected.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 */
	public $taxonomy_multicheck;

	/**
	 * Inline checkboxes with taxonomy terms.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck_inline
	 */
	public $taxonomy_multicheck_inline;

	/**
	 * A metabox with TinyMCE editor (same as WordPress' visual editor).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#wysiwyg
	 */
	public $wysiwyg;

	/**
	 * A file uploader.
	 *
	 * By default it will store the file url and allow either attachments or URLs.
	 * This field type will also store the attachment ID (useful for getting different image sizes).
	 * It will store it in $id . '_id', so if your field id is wiki_test_image
	 * the ID is stored in wiki_test_image_id.
	 * You can also limit it to only allowing attachments (can't manually type in a URL),
	 * which is also useful if you plan to use the attachment ID.
	 * The example shows its default values, with possible values commented inline.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 */
	public $file;

	/**
	 * A file uploader that allows you to add as many files as you want.
	 * Once added, files can be dragged and dropped to reorder.
	 *
	 * This is a repeatable field, and will store its data in an array,
	 * with the attachment ID as the array key and the attachment url as the value. Example:
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file_list
	 */
	public $file_list;

	/**
	 * Displays embedded media inline using WordPress' built-in oEmbed support.
	 *
	 * See codex.wordpress.org/Embeds for more info and for a list of embed services supported
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#oembed
	 */
	public $oembed;

	/**
	 * Hybrid field that supports adding other fields as a repeatable group.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#group
	 */
	public $group;


	public function __construct() {
		foreach( get_object_vars( $this ) as $_var => $_value ){
			$this->{$_var} = $_var;
		}
	}


	public function __call( $name, $arguments ) {
		return $this->{$name};
	}


	private static $instance;


	/**
	 *
	 * @static
	 *
	 * @return \Lipe\Lib\CMB2\Field_Type
	 */
	public static function types() {
		if( !is_a( self::$instance, __CLASS__ ) ){
			self::$instance = new self();
		}

		return self::$instance;
	}

}