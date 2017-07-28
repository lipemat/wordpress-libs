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


	/**
	 * Date field. Stored and displayed according to the date_format.
	 *
	 * @param string $date_format
	 * @param string $timezone_meta_key - to use the value of another timezone_select field
	 *                                  as the timezone
	 * @param [] $date_picker_options - overrides for jQuery UI Datepicker (see example)
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_date
	 *
	 * @return array
	 */
	public function text_date( $date_format = 'l jS \of F Y', $timezone_meta_key = '', $date_picker_options = [] ) {
		return $this->field_type_date( $this->text_date, $date_format, $timezone_meta_key, $date_picker_options );
	}


	/**
	 * Date and time field, stored as UNIX timestamp.
	 *
	 * @param string $date_format
	 * @param string $timezone_meta_key - to use the value of another timezone_select field
	 *                                  as the timezone
	 *
	 * @param [] $date_picker_options - overrides for jQuery UI Datepicker (see text_date example)
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_datetime_timestamp
	 *
	 * @return array
	 */
	public function text_date_timestamp( $date_format = 'l jS \of F Y', $timezone_meta_key = '', $date_picker_options = [] ) {
		return $this->field_type_date( $this->text_date_timestamp, $date_format, $timezone_meta_key . $date_picker_options );
	}


	/**
	 * Date, time and timezone field, stored as serialized DateTime object.
	 *
	 * @param string $date_format
	 * @param string $timezone_meta_key - to use the value of another timezone_select field
	 *                                  as the timezone
	 * @param [] $date_picker_options - overrides for jQuery UI Datepicker (see text_date example)
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_datetime_timestamp_timezone
	 *
	 * @return array
	 */
	public function text_datetime_timestamp_timezone( $date_format = 'l jS \of F Y', $timezone_meta_key = '', $date_picker_options = [] ) {
		return $this->field_type_date( $this->text_datetime_timestamp_timezone, $date_format, $timezone_meta_key, $date_picker_options );
	}


	/**
	 * A colorpicker field.
	 *
	 * The CMB2 colorpicker uses the built in WordPress colorpicker,
	 * Iris [automattic.github.io/Iris/] (http://automattic.github.io/Iris/)
	 *
	 * All of the default options in Iris are configurable within the CMB2 colorpicker field.
	 *
	 *
	 * [Default Iris Options] (http://automattic.github.io/Iris/#options):
	 *
	 * @param array $iris_options
	 *
	 * @return mixed
	 */
	public function colorpicker( $iris_options = [] ) {
		if( empty( $iris_options ) ){
			return $this->colorpicker;
		}

		return [
			'type'       => $this->colorpicker,
			'attributes' => [
				'data-colorpicker' => json_encode( $iris_options ),
			],
		];
	}


	/**
	 * A field with multiple checkboxes (and multiple can be selected)
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function()
	 * @param bool           $select_all          - display select all button or not
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#multicheck-and-multicheck_inline
	 *
	 * @return array
	 */
	public function multicheck( $options_or_callback, $select_all = true ) {
		$_args = $this->field_type_options( $this->multicheck, $options_or_callback );
		$_args[ 'select_all_button' ] = $select_all;

		return $_args;
	}


	/**
	 * A field with multiple checkboxes (and multiple can be selected)
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function()
	 * @param bool           $select_all          - display select all button or not
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#multicheck-and-multicheck_inline
	 *
	 * @return array
	 */
	public function multicheck_inline( $options_or_callback, $select_all = true ) {
		$_args = $this->field_type_options( $this->multicheck_inline, $options_or_callback );
		$_args[ 'select_all_button' ] = $select_all;

		return $_args;
	}


	/**
	 * Standard radio buttons.
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function()
	 * @param bool|string    $show_option_none    - disable or set the text of the option
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#radio
	 *
	 * @return array
	 */
	public function radio( $options_or_callback, $show_option_none = true ) {
		$_args = $this->field_type_options( $this->radio, $options_or_callback, $show_option_none );

		return $_args;
	}


	/**
	 * Inline radio buttons.
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function()
	 * @param bool|string    $show_option_none    - disable or set the text of the option
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#radio_inline
	 *
	 * @return array
	 */
	public function radio_inline( $options_or_callback, $show_option_none = true ) {
		$_args = $this->field_type_options( $this->radio_inline, $options_or_callback, $show_option_none );

		return $_args;
	}


	/**
	 * Standard select dropdown.
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function()
	 * @param bool|string    $show_option_none    - disable or set the text of the option
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#select
	 *
	 * @return array
	 */
	public function select( $options_or_callback, $show_option_none = true ) {
		$_args = $this->field_type_options( $this->select, $options_or_callback, $show_option_none );

		return $_args;
	}


	/**
	 * Radio buttons pre-populated with taxonomy terms
	 *
	 * @param string $taxonomy       - slug
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox (default true)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio
	 *
	 * @return array
	 */
	public function taxonomy_radio( $taxonomy, $no_terms_text = null, $remove_default = null ) {
		$_args = $this->field_type_taxonomy( $this->taxonomy_radio, $taxonomy, $no_terms_text, $remove_default );

		return $_args;

	}


	/**
	 * Inline radio buttons pre-populated with taxonomy terms
	 *
	 * @param string $taxonomy       - slug
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox (default true)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio_inline
	 *
	 * @return array
	 */
	public function taxonomy_radio_inline( $taxonomy, $no_terms_text = null, $remove_default = null ) {
		$_args = $this->field_type_taxonomy( $this->taxonomy_radio_inline, $taxonomy, $no_terms_text, $remove_default );

		return $_args;

	}


	/**
	 * A select field pre-populated with taxonomy terms
	 *
	 * @param string $taxonomy       - slug
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox (default true)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_select
	 *
	 * @return array
	 */
	public function taxonomy_select( $taxonomy, $no_terms_text = null, $remove_default = null ) {
		$_args = $this->field_type_taxonomy( $this->taxonomy_select, $taxonomy, $no_terms_text, $remove_default );

		return $_args;

	}


	/**
	 * A field with checkboxes with taxonomy terms, and multiple terms can be selected.
	 *
	 * @param string $taxonomy       - slug
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox (default true)
	 * @param bool   $select_all     - display the select all button
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 *
	 * @return array
	 */
	public function taxonomy_multicheck( $taxonomy, $no_terms_text = null, $remove_default = null, $select_all = true ) {
		$_args = $this->field_type_taxonomy( $this->taxonomy_multicheck, $taxonomy, $no_terms_text, $remove_default );
		$_args[ 'select_all_button' ] = $select_all;

		return $_args;

	}


	/**
	 * Inline checkboxes with taxonomy terms.
	 *
	 * @param string $taxonomy       - slug
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox (default true)
	 * @param bool   $select_all     - display the select all button
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck_inline
	 *
	 * @return array
	 */
	public function taxonomy_multicheck_inline( $taxonomy, $no_terms_text = null, $remove_default = null, $select_all = true ) {
		$_args = $this->field_type_taxonomy( $this->taxonomy_multicheck_inline, $taxonomy, $no_terms_text, $remove_default );
		$_args[ 'select_all_button' ] = $select_all;

		return $_args;

	}


	/**
	 * A metabox with TinyMCE editor (same as WordPress' visual editor).
	 *
	 * @param array $mce_options - standard WP mce options
	 *
	 * @see  \_WP_Editors::parse_settings()
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#wysiwyg
	 *
	 * @return array
	 */
	public function wysiwyg( $mce_options = [] ) {
		$_args = [
			'type' => $this->wysiwyg,
		];
		if( !empty( $mce_options ) ){
			$_args[ 'options' ] = $mce_options;
		}

		return $_args;
	}


	/**
	 * A file uploader.
	 *
	 * By default it will store the file url and allow either attachments or URLs.
	 * This field type will also store the attachment ID
	 * (useful for getting different image sizes).
	 * It will store it in $id . '_id', so if your field id is wiki_test_image
	 * the ID is stored in wiki_test_image_id.
	 * You can also limit it to only allowing attachments
	 * (can't manually type in a URL),
	 * which is also useful if you plan to use the attachment ID.
	 *
	 * @param string $button_text     - (default 'Add File' )
	 * @param string $file_mime_type  - (default all)
	 * @param bool   $show_text_input - (default false)
	 * @param string $preview_size    - (default full)
	 *
	 * @example file( 'Add Image', 'image', false );
	 * @example file( 'Add PDF', 'application/pdf', true );
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 *
	 * @return array
	 */
	public function file( $button_text = null, $file_mime_type = null, $show_text_input = null, $preview_size = null ) {
		$_args = $this->field_type_file( $this->file, $button_text, $file_mime_type, $show_text_input, $preview_size );

		return $_args;

	}


	/**
	 * A file uploader that allows you to add as many files as you want.
	 * Once added, files can be dragged and dropped to reorder.
	 * This is a repeatable field, and will store its data in an array,
	 * with the attachment ID as the array key and the attachment url as the value
	 *
	 * @param string $button_text      - (default 'Add File' )
	 * @param string $file_mime_type   - (default all)
	 * @param bool   $show_text_input  - (default false)
	 * @param string $preview_size     - (default full)
	 * @param string $remove_item_text - (default 'Remove' )
	 * @param string $file_text        - (default 'File' )
	 * @param string $download_text    - (default 'Download' )
	 *
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file_list
	 *
	 * @return array
	 */
	public function file_list( $button_text = null, $file_mime_type = null, $show_text_input = null, $preview_size = null, $remove_item_text = null, $file_text = null, $download_text = null ) {
		$_args = $this->field_type_file( $this->file_list, $button_text, $file_mime_type, $show_text_input, $preview_size, $remove_item_text, $file_text, $download_text );

		return $_args;
	}


	/**
	 * Hybrid field that supports adding other fields as a repeatable group.
	 *
	 * @param string $title - include a {#} to have replace with number
	 * @param string $add_button_text
	 * @param string $remove_button_text
	 * @param bool   $sortable
	 * @param bool   $closed
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#group
	 *
	 * @return array
	 */
	public function group( $title = null, $add_button_text = null, $remove_button_text = null, $sortable = true, $closed = false ) {
		$_args = [
			'type'    => $this->group,
			'options' => [
				'sortable' => $sortable,
				'closed'   => $closed,
			],
		];

		if( $title !== null ){
			$_args[ 'options' ][ 'group_title' ] = $title;
		}
		if( $add_button_text !== null ){
			$_args[ 'options' ][ 'add_button' ] = $add_button_text;
		}
		if( $remove_button_text !== null ){
			$_args[ 'options' ][ 'remove_button' ] = $remove_button_text;
		}

		return $_args;
	}

	/************ protected ***********************/

	/**
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file_list
	 *
	 * @param string $type
	 * @param string $button_text
	 * @param string $file_mime_type
	 * @param bool   $show_text_input
	 * @param string $preview_size
	 * @param string $remove_item_text
	 * @param string $file_text
	 * @param string $download_text
	 *
	 * @return array
	 */
	protected function field_type_file( $type, $button_text = null, $file_mime_type = null, $show_text_input = null, $preview_size = null, $remove_item_text = null, $file_text = null, $download_text = null ) {

		$_args = [
			'type' => $type,
		];

		if( $button_text !== null ){
			$_args[ 'text' ][ 'add_upload_file_text' ] = $button_text;
		}
		if( null !== $remove_item_text ){
			$_args[ 'text' ][ 'remove_image_text' ] = $remove_item_text;
			$_args[ 'text' ][ 'remove_item_text' ] = $remove_item_text;
		}
		if( null !== $file_text ){
			$_args[ 'text' ][ 'file_text' ] = $file_text;
		}
		if( null !== $download_text ){
			$_args[ 'text' ][ 'file_download_text' ] = $download_text;
		}
		if( null !== $file_mime_type ){
			$_args[ 'query_args' ] = [
				'type' => $file_mime_type,
			];
		}
		if( null !== $show_text_input ){
			$_args[ 'options' ] = [
				'url' => $show_text_input,
			];
		}
		if( null !== $preview_size ){
			$_args[ 'preview_size' ] = $preview_size;
		}

		return $_args;

	}


	/**
	 *
	 * @param string $type
	 * @param string $taxonomy       - slug
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox (default true)
	 *
	 * @return array
	 */
	protected function field_type_taxonomy( $type, $taxonomy, $no_terms_text = null, $remove_default = null ) {
		$_args = [
			'type'     => $type,
			'taxonomy' => $taxonomy,
		];
		if( null !== $remove_default ){
			$_args[ 'remove_default' ] = $remove_default;
		}
		if( null !== $no_terms_text ){
			$_args[ 'text' ][ 'no_terms_text' ] = $no_terms_text;
		}

		return $_args;

	}


	/**
	 *
	 * @param string         $type
	 * @param array|callable $options_or_callback - [ $key => $label ] || function()
	 * @param bool|string    $show_option_none
	 *
	 * @return array
	 */
	protected function field_type_options( $type, $options_or_callback, $show_option_none = null ) {
		if( is_callable( $options_or_callback ) ){
			$_args = [
				'type'       => $type,
				'options_cb' => $options_or_callback,
			];
		} else {
			$_args = [
				'type'    => $type,
				'options' => $options_or_callback,
			];
		}
		if( null !== $show_option_none ){
			$_args[ 'show_option_none' ] = $show_option_none;
		}

		return $_args;
	}


	/**
	 *
	 * @param string $type
	 * @param string $date_format
	 * @param string $timezone_meta_key
	 * @param array  $date_picker_options
	 *
	 * @return array
	 */
	protected function field_type_date( $type, $date_format = 'l jS \of F Y', $timezone_meta_key = '', $date_picker_options = [] ) {

		$_args = [
			'type'        => $type,
			'date_format' => $date_format,
		];
		if( !empty( $timezone_meta_key ) ){
			$_args[ 'timezone_meta_key' ] = $timezone_meta_key;
		}

		if( !empty( $date_picker_options ) ){
			$_args[ 'date_picker_options' ][ 'data-datepicker' ] = json_encode( $date_picker_options );
		}

		return $_args;

	}


	/********** static *******************/

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