<?php

declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Field\Checkbox;
use Lipe\Lib\CMB2\Field\Term_Select_2;
use Lipe\Lib\CMB2\Field\True_False;
use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Util\Arrays;

/**
 * CMB2 field types.
 *
 * A fluent interface with callbacks for each possible field type.
 *
 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types
 */
class Field_Type {
	/**
	 * @var Field
	 */
	protected Field $field;


	/**
	 * @internal
	 *
	 * @param Field $field
	 */
	public function __construct( Field $field ) {
		$this->field = $field;
	}


	/**
	 * Set the field properties based on an array or args.
	 *
	 *
	 * @param array  $args      - [$key => $value].
	 * @param string $data_type - a type of data to return [Repo::DEFAULT, Repo::CHECKBOX, Repo::FILE, Repo::TAXONOMY ].
	 *
	 * @return Field
	 */
	protected function set( array $args, string $data_type ) : Field {
		if ( isset( $args['type'] ) ) {
			$this->field->set_type( $args['type'], $data_type );
			unset( $args['type'] );
		}
		foreach ( $args as $_key => $_value ) {
			$this->field->{$_key} = $_value;
		}

		return $this->field;
	}


	/**
	 * A large title (useful for breaking up sections of fields in metabox)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#title
	 */
	public function title() : Field {
		return $this->set( [ 'type' => 'title' ], Repo::DEFAULT );
	}


	/**
	 * True false switch like checkbox.
	 *
	 * Custom to WP-Libs.
	 *
	 * @return Field
	 */
	public function true_false() : Field {
		return $this->set( [
			'type'         => 'checkbox',
			'render_class' => True_False::class,
		], Repo::CHECKBOX );
	}


	/**
	 * Standard text field (large).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text
	 *
	 * @return Field
	 */
	public function text() : Field {
		return $this->set( [ 'type' => 'text' ], Repo::DEFAULT );
	}


	/**
	 * Small text field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_small
	 *
	 * @return Field
	 */
	public function text_small() : Field {
		return $this->set( [ 'type' => 'text_small' ], Repo::DEFAULT );
	}


	/**
	 * Medium text field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_medium
	 *
	 * @return Field
	 */
	public function text_medium() : Field {
		return $this->set( [ 'type' => 'text_medium' ], Repo::DEFAULT );
	}


	/**
	 * Standard text field which enforces an email address..
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_email
	 *
	 * @return Field
	 */
	public function text_email() : Field {
		return $this->set( [ 'type' => 'text_email' ], Repo::DEFAULT );
	}


	/**
	 * Standard text field, which enforces a url.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_url
	 *
	 * @param array|null $protocols - Specify the supported URL protocols.
	 *                              Defaults to return value of wp_allowed_protocols().
	 *
	 * @return Field
	 */
	public function text_url( ?array $protocols = null ) : Field {
		$this->field->attributes( [
			'type'  => 'url',
			'class' => 'cmb2-text-url regular-text',
		] );

		return $this->set( [
			'type'      => 'text_url',
			'protocols' => $protocols,
		], Repo::DEFAULT );
	}


	/**
	 * Standard text field with dollar sign in front of it
	 * (useful to prevent users from adding a dollar sign to input). .
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_money
	 *
	 * @return Field
	 */
	public function text_money() : Field {
		return $this->set( [ 'type' => 'text_money' ], Repo::DEFAULT );
	}


	/**
	 * HTML number field
	 * Custom to WP-Libs
	 *
	 * @link https://www.w3schools.com/tags/att_input_type_number.asp
	 *
	 * @param float      $step
	 * @param float|null $min
	 * @param float|null $max
	 *
	 * @return Field
	 */
	public function text_number( float $step = 1, ?float $min = null, ?float $max = null ) : Field {
		$attributes = [
			'type' => 'number',
			'step' => $step,
		];
		if ( null !== $min ) {
			$attributes['min'] = $min;
		}
		if ( null !== $max ) {
			$attributes['max'] = $max;
		}
		$this->field->attributes( $attributes );

		return $this->set( [ 'type' => 'text_small' ], Repo::DEFAULT );
	}


	/**
	 * Standard textarea.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#textarea
	 *
	 * @param int $rows - For small text areas use `textarea_small`.
	 *
	 * @return Field
	 */
	public function textarea( int $rows = null ) : Field {
		if ( null !== $rows ) {
			$this->field->attributes( [ 'rows' => $rows ] );
		}

		return $this->set( [
			'type' => 'textarea',
		], Repo::DEFAULT );
	}


	/**
	 * Smaller textarea..
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#textarea_small
	 *
	 * @return Field
	 */
	public function textarea_small() : Field {
		return $this->set( [ 'type' => 'textarea_small' ], Repo::DEFAULT );
	}


	/**
	 * Code textarea.
	 *
	 * The defaults are most likely what you want to use, but arguments are
	 * available for specialize fine-tuning
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#textarea_code
	 * @link    https://www.ibenic.com/wordpress-code-editor#file-code-editor-js
	 *
	 * @param bool    $disable_codemirror    - disable code mirror handling in favor or a basic textbox.
	 * @param ?string $language              - Language mode to use (example: php).
	 *
	 * @param array   $code_editor_arguments - The arguments are then passed to `wp.codeEditor.initialize` method.
	 *
	 * @return Field
	 * @link    https://codemirror.net/doc/manual.html#option_mode
	 * @link    https://codemirror.net/mode/
	 *
	 * @example textarea_code( false, 'javascript', [ 'codemirror' => [ 'lineNumbers' => false, 'theme' => 'cobalt' ] ]
	 *          );
	 *
	 *
	 */
	public function textarea_code( bool $disable_codemirror = false, ?string $language = null, array $code_editor_arguments = [] ) : Field {
		$set = [
			'type' => 'textarea_code',
		];
		if ( $disable_codemirror ) {
			$set['options'] = [
				'disable_codemirror' => true,
			];
		}
		if ( null !== $language ) {
			$code_editor_arguments = Arrays::in()->merge_recursive( $code_editor_arguments, [
				'codemirror' => [
					'mode' => $language,
				],
			] );
		}
		if ( ! empty( $code_editor_arguments ) ) {
			$this->field->attributes( [
				'data-codeeditor' => wp_json_encode( $code_editor_arguments ),
			] );
		}

		return $this->set( $set, Repo::DEFAULT );
	}


	/**
	 * Time picker field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_time
	 *
	 * @return Field
	 */
	public function text_time() : Field {
		return $this->set( [ 'type' => 'text_time' ], Repo::DEFAULT );
	}


	/**
	 * Timezone field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#select_timezone
	 *
	 * @return Field
	 */
	public function select_timezone() : Field {
		return $this->set( [ 'type' => 'select_timezone' ], Repo::DEFAULT );
	}


	/**
	 * Adds a hidden input type to the bottom of the CMB2 output.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#hidden
	 *
	 * @return Field
	 */
	public function hidden() : Field {
		return $this->set( [ 'type' => 'hidden' ], Repo::DEFAULT );
	}


	/**
	 * Shortcut for using the "file" field with type of image.
	 *
	 * By default, it will store the file url and allow either attachments or URLs.
	 * This field type will also store the attachment ID
	 * (useful for getting different image sizes).
	 * It will store it in $id . '_id', so if your field id is wiki_test_image
	 * the ID is stored in wiki_test_image_id.
	 * You can also limit it to only allowing attachments
	 * (can't manually type in a URL) by setting `$show_text_input` to false.
	 *
	 * @param string      $button_text     - (default 'Add Image' ).
	 * @param bool|null   $show_text_input - (default true) May not be turned off for required fields.
	 * @param string|null $preview_size    - (default full).
	 *
	 * @see     Field_Type::file()
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 *
	 * @return Field
	 */
	public function image( string $button_text = 'Add Image', ?bool $show_text_input = null, ?string $preview_size = null ) : Field {
		$_args = $this->field_type_file( 'file', $button_text, 'image', $show_text_input, $preview_size, null, null, null, 'Use Image' );

		return $this->set( $_args, Repo::FILE );
	}


	/**
	 * Standard checkbox.
	 *
	 * @link          https://github.com/CMB2/CMB2/wiki/Field-Types#checkbox
	 *
	 * @phpstan-param 'compact'|'block' $layout
	 *
	 * @param string $layout - compact, block (cmb2 default is block).
	 *
	 * @return Field
	 */
	public function checkbox( string $layout = 'block' ) : Field {
		$_args = [
			'type' => 'checkbox',
		];
		if ( 'block' !== $layout ) {
			$_args['render_row_cb'] = [ Checkbox::in(), 'render_field_callback' ];
		}

		return $this->set( $_args, Repo::CHECKBOX );
	}


	/**
	 * Displays embedded media inline using WordPress' built-in oEmbed support.
	 *
	 * See codex.wordpress.org/Embeds for more info and for a list of embed services supported
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#oembed
	 *
	 * @return Field
	 */
	public function oembed() : Field {
		return $this->set( [ 'type' => 'oembed' ], Repo::DEFAULT );
	}


	/**
	 * Date field. Stored and displayed according to the date_format.
	 *
	 * @param string $date_format
	 * @param string $timezone_meta_key   - to use the value of another timezone_select field
	 *                                    as the timezone.
	 * @param array  $date_picker_options - overrides for jQuery UI Datepicker (see example).
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_date
	 *
	 * @return Field
	 */
	public function text_date( $date_format = 'm/d/Y', $timezone_meta_key = '', $date_picker_options = [] ) : Field {
		return $this->set( $this->field_type_date( 'text_date', $date_format, $timezone_meta_key, $date_picker_options ), Repo::DEFAULT );
	}


	/**
	 * Date field, stored as UNIX timestamp. Useful if you plan to query based on it.
	 *
	 * @param string $date_format
	 * @param string $timezone_meta_key   - to use the value of another timezone_select field
	 *                                    as the timezone.
	 *
	 * @param array  $date_picker_options - overrides for jQuery UI Datepicker (see text_date example).
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_date_timestamp
	 *
	 * @return Field
	 */
	public function text_date_timestamp( $date_format = 'm/d/Y', $timezone_meta_key = '', array $date_picker_options = [] ) : Field {
		return $this->set( $this->field_type_date( 'text_date_timestamp', $date_format, $timezone_meta_key, $date_picker_options ), Repo::DEFAULT );
	}


	/**
	 * Date and time field, stored as UNIX timestamp. Useful if you plan to query based on it.
	 *
	 * @param string $date_format
	 * @param string $timezone_meta_key   - to use the value of another timezone_select field
	 *                                    as the timezone.
	 *
	 * @param array  $date_picker_options - overrides for jQuery UI Datepicker (see text_date example).
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_datetime_timestamp
	 *
	 * @return Field
	 */
	public function text_datetime_timestamp( $date_format = 'm/d/Y', $timezone_meta_key = '', array $date_picker_options = [] ) : Field {
		return $this->set( $this->field_type_date( 'text_datetime_timestamp', $date_format, $timezone_meta_key, $date_picker_options ), Repo::DEFAULT );
	}


	/**
	 * Date, time and timezone field, stored as serialized DateTime object.
	 *
	 * @param string $date_format
	 * @param string $timezone_meta_key   - to use the value of another timezone_select field
	 *                                    as the timezone.
	 * @param array  $date_picker_options - overrides for jQuery UI Datepicker (see text_date example).
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_datetime_timestamp_timezone
	 *
	 * @return Field
	 */
	public function text_datetime_timestamp_timezone( $date_format = 'm/d/Y', $timezone_meta_key = '', $date_picker_options = [] ) : Field {
		return $this->set( $this->field_type_date( 'text_datetime_timestamp_timezone', $date_format, $timezone_meta_key, $date_picker_options ), Repo::DEFAULT );
	}


	/**
	 * A color picker field.
	 *
	 * The CMB2 color picker uses the built-in WordPress color picker,
	 * Iris [automattic.github.io/Iris/] (http://automattic.github.io/Iris/)
	 *
	 * All of the default options in Iris are configurable within the CMB2 color picker field.
	 *
	 *
	 * [Default Iris Options] (http://automattic.github.io/Iris/#options):
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#colorpicker
	 *
	 * @param array $iris_options
	 * @param bool  $transparency - to enable transparency.
	 *
	 * @return Field
	 *
	 */
	public function colorpicker( array $iris_options = [], bool $transparency = false ) : Field {
		$_args = [ 'type' => 'colorpicker' ];
		if ( ! empty( $iris_options ) ) {
			$this->field->attributes( [ 'data-colorpicker' => wp_json_encode( $iris_options ) ] );
		}
		if ( $transparency ) {
			$_args['options'] = [
				'alpha' => true,
			];
		}

		return $this->set( $_args, Repo::DEFAULT );
	}


	/**
	 * A field with multiple checkboxes (and multiple can be selected)
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function().
	 * @param bool           $select_all          - display select all button or not.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#multicheck-and-multicheck_inline
	 *
	 * @return Field
	 */
	public function multicheck( $options_or_callback, $select_all = true ) : Field {
		$_args = $this->field_type_options( 'multicheck', $options_or_callback );
		$_args['select_all_button'] = $select_all;

		return $this->set( $_args, Repo::DEFAULT );
	}


	/**
	 * A field with multiple checkboxes (and multiple can be selected)
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function().
	 * @param bool           $select_all          - display select all button or not.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#multicheck-and-multicheck_inline
	 *
	 * @return Field
	 */
	public function multicheck_inline( $options_or_callback, $select_all = true ) : Field {
		$_args = $this->field_type_options( 'multicheck_inline', $options_or_callback );
		$_args['select_all_button'] = $select_all;

		return $this->set( $_args, Repo::DEFAULT );
	}


	/**
	 * Standard radio buttons.
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function().
	 * @param bool|string    $show_option_none    - disable or set the text of the option.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#radio
	 *
	 * @return Field
	 */
	public function radio( $options_or_callback, $show_option_none = true ) : Field {
		$_args = $this->field_type_options( 'radio', $options_or_callback, $show_option_none );

		return $this->set( $_args, Repo::DEFAULT );
	}


	/**
	 * Inline radio buttons.
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function().
	 * @param bool|string    $show_option_none    - disable or set the text of the option.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#radio_inline
	 *
	 * @return Field
	 */
	public function radio_inline( $options_or_callback, $show_option_none = true ) : Field {
		$_args = $this->field_type_options( 'radio_inline', $options_or_callback, $show_option_none );

		return $this->set( $_args, Repo::DEFAULT );
	}


	/**
	 * Standard select dropdown.
	 *
	 * @param array|callable $options_or_callback - [ $key => $label ] || function().
	 * @param bool|string    $show_option_none    - disable or set the text of the option.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#select
	 *
	 * @return Field
	 */
	public function select( $options_or_callback, $show_option_none = true ) : Field {
		$_args = $this->field_type_options( 'select', $options_or_callback, $show_option_none );

		return $this->set( $_args, Repo::DEFAULT );
	}


	/**
	 * Radio buttons pre-populated with taxonomy terms
	 *
	 * @param string $taxonomy       - slug.
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio
	 *
	 * @return Field
	 */
	public function taxonomy_radio( $taxonomy, $no_terms_text = null, $remove_default = null ) : Field {
		$_args = $this->field_type_taxonomy( 'taxonomy_radio', $taxonomy, $no_terms_text, $remove_default );

		return $this->set( $_args, Repo::TAXONOMY_SINGULAR );
	}


	/**
	 * Hierarchical radio buttons pre-populated with taxonomy terms
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio
	 *
	 * @param string $taxonomy       - slug.
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox.
	 *
	 * @return Field
	 */
	public function taxonomy_radio_hierarchical( $taxonomy, $no_terms_text = null, $remove_default = null ) : Field {
		$_args = $this->field_type_taxonomy( 'taxonomy_radio_hierarchical', $taxonomy, $no_terms_text, $remove_default );

		return $this->set( $_args, Repo::TAXONOMY_SINGULAR );
	}


	/**
	 * Inline radio buttons pre-populated with taxonomy terms
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio_inline
	 *
	 * @param string $taxonomy       - slug.
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox.
	 *
	 * @return Field
	 */
	public function taxonomy_radio_inline( $taxonomy, $no_terms_text = null, $remove_default = null ) : Field {
		$_args = $this->field_type_taxonomy( 'taxonomy_radio_inline', $taxonomy, $no_terms_text, $remove_default );

		return $this->set( $_args, Repo::TAXONOMY_SINGULAR );
	}


	/**
	 * A select field pre-populated with taxonomy terms.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_select
	 *
	 * @param string $taxonomy       - slug.
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox.
	 *
	 * @return Field
	 */
	public function taxonomy_select( $taxonomy, $no_terms_text = null, $remove_default = null ) : Field {
		$_args = $this->field_type_taxonomy( 'taxonomy_select', $taxonomy, $no_terms_text, $remove_default );

		return $this->set( $_args, Repo::TAXONOMY_SINGULAR );
	}


	/**
	 * A select field pre-populated with taxonomy terms and displayed hierarchical.
	 *
	 * @todo Add link once docs become available.
	 *
	 * @param string $taxonomy       - slug.
	 * @param null   $no_terms_text
	 * @param null   $remove_default - remove default WP terms metabox.
	 *
	 *
	 * @return Field
	 */
	public function taxonomy_select_hierarchical( string $taxonomy, $no_terms_text = null, $remove_default = null ) : Field {
		$_args = $this->field_type_taxonomy( 'taxonomy_select_hierarchical', $taxonomy, $no_terms_text, $remove_default );

		return $this->set( $_args, Repo::TAXONOMY_SINGULAR );
	}


	/**
	 * A custom field, which exists only within Lipe\Lib
	 *
	 * Select 2 term selector.
	 *
	 * @param string $taxonomy         - slug.
	 * @param bool   $create_new_terms - allow creating new terms.
	 * @param bool   $save_as_terms    - append the terms to the object as well as storing them in meta (default to
	 *                                 false ).
	 * @param string $no_terms_text
	 * @param bool   $remove_default   - remove default WP terms metabox.
	 *
	 * @see Term_Select_2
	 *
	 * @return Field
	 */
	public function taxonomy_select_2( $taxonomy, $create_new_terms = false, $save_as_terms = false, $no_terms_text = null, $remove_default = null ) : Field {
		Term_Select_2::init_once();

		$_args = $this->field_type_taxonomy( Term_Select_2::NAME, $taxonomy, $no_terms_text, $remove_default );
		$_args[ Term_Select_2::SAVE_AS_TERMS ] = $save_as_terms;
		$_args[ Term_Select_2::CREATE_NEW_TERMS ] = $create_new_terms;

		return $this->set( $_args, Repo::TAXONOMY );
	}


	/**
	 * A field with checkboxes with taxonomy terms, and multiple terms can be selected.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 *
	 * @param string $taxonomy       - slug.
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox.
	 * @param bool   $select_all     - display the select all button.
	 *
	 * @return Field
	 */
	public function taxonomy_multicheck( $taxonomy, $no_terms_text = null, $remove_default = null, $select_all = true ) : Field {
		$_args = $this->field_type_taxonomy( 'taxonomy_multicheck', $taxonomy, $no_terms_text, $remove_default );
		$_args['select_all_button'] = $select_all;

		return $this->set( $_args, Repo::TAXONOMY );
	}


	/**
	 * Hierarchical checkboxes with taxonomy terms, and multiple terms can be selected.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck_hierarchical
	 *
	 * @param string $taxonomy       - slug.
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox.
	 * @param bool   $select_all     - display the select all button.
	 *
	 * @return Field
	 */
	public function taxonomy_multicheck_hierarchical( $taxonomy, $no_terms_text = null, $remove_default = null, $select_all = true ) : Field {
		$_args = $this->field_type_taxonomy( 'taxonomy_multicheck_hierarchical', $taxonomy, $no_terms_text, $remove_default );
		$_args['select_all_button'] = $select_all;

		return $this->set( $_args, Repo::TAXONOMY );
	}


	/**
	 * Inline checkboxes with taxonomy terms.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck_inline
	 *
	 * @param string $taxonomy       - slug.
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox.
	 * @param bool   $select_all     - display the select all button.
	 *
	 * @return Field
	 */
	public function taxonomy_multicheck_inline( $taxonomy, $no_terms_text = null, $remove_default = null, $select_all = true ) : Field {
		$_args = $this->field_type_taxonomy( 'taxonomy_multicheck_inline', $taxonomy, $no_terms_text, $remove_default );
		$_args['select_all_button'] = $select_all;

		return $this->set( $_args, Repo::TAXONOMY );
	}


	/**
	 * A metabox with TinyMCE editor (same as WordPress' visual editor).
	 *
	 * @param array $mce_options - standard WP mce options.
	 *
	 * @see  \_WP_Editors::parse_settings()
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#wysiwyg
	 *
	 * @return Field
	 */
	public function wysiwyg( array $mce_options = [] ) : Field {
		$_args = [
			'type' => 'wysiwyg',
		];
		if ( ! empty( $mce_options ) ) {
			$_args['options'] = $mce_options;
		}

		return $this->set( $_args, Repo::DEFAULT );
	}


	/**
	 * A file uploader.
	 *
	 * By default, it will store the file url and allow either attachments or URLs.
	 * This field type will also store the attachment ID
	 * (useful for getting different image sizes).
	 * It will store it in $id . '_id', so if your field id is wiki_test_image
	 * the ID is stored in wiki_test_image_id.
	 * You can also limit it to only allowing attachments
	 * (can't manually type in a URL), also useful if you plan to use the attachment ID.
	 *
	 * @param string $button_text     - (default 'Add File' ).
	 * @param string $file_mime_type  - (default all).
	 * @param bool   $show_text_input - (default true) May not be turned off for required fields.
	 * @param string $preview_size    - (default full).
	 * @param string $select_text     - Media manager button label (default: Use this file).
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 *
	 * @example file( 'Add PDF', 'application/pdf', true );
	 *
	 * @example file( 'Add Image', 'image', false );
	 *
	 * @return Field
	 */
	public function file( $button_text = null, $file_mime_type = null, $show_text_input = null, $preview_size = null, $select_text = null ) : Field {
		$_args = $this->field_type_file( 'file', $button_text, $file_mime_type, $show_text_input, $preview_size, null, null, null, $select_text );

		return $this->set( $_args, Repo::FILE );
	}


	/**
	 * A file uploader that allows you to add as many files as you want.
	 * Once added, files can be dragged and dropped to reorder.
	 * This is a repeatable field, and will store its data in an array,
	 * with the attachment ID as the array key, and the attachment url as the value.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file_list
	 *
	 * @param string $button_text      - (default 'Add File').
	 * @param string $file_mime_type   - (default all).
	 * @param string $preview_size     - (default full).
	 * @param string $remove_item_text - (default 'Remove').
	 * @param string $file_text        - (default 'File').
	 * @param string $download_text    - (default 'Download').
	 * @param string $select_text      - (default 'Use these files').
	 *
	 * @return Field
	 */
	public function file_list( $button_text = null, $file_mime_type = null, $preview_size = null, $remove_item_text = null, $file_text = null, $download_text = null, $select_text = null ) : Field {
		$_args = $this->field_type_file( 'file_list', $button_text, $file_mime_type, null, $preview_size, $remove_item_text, $file_text, $download_text, $select_text );

		return $this->set( $_args, Repo::DEFAULT );
	}


	/**
	 * A hybrid field that supports adding other fields as a repeatable group.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#group
	 *
	 * @param string|null $title                 - include a {#} to have replaced with number.
	 * @param string|null $add_button_text
	 * @param string|null $remove_button_text
	 * @param bool        $sortable
	 * @param bool        $closed
	 * @param string|null $remove_confirm        - A message to display when a user attempts
	 *                                           to delete a group.
	 *                                           (Defaults to null/false for no confirmation).
	 *
	 * @return Field
	 */
	public function group( ?string $title = null, ?string $add_button_text = null, ?string $remove_button_text = null, bool $sortable = true, bool $closed = false, ?string $remove_confirm = null ) : Field {
		$_args = [
			'type'    => 'group',
			'options' => [
				'sortable' => $sortable,
				'closed'   => $closed,
			],
		];

		if ( null !== $title ) {
			$_args['options']['group_title'] = $title;
		}
		if ( null !== $add_button_text ) {
			$_args['options']['add_button'] = $add_button_text;
		}
		if ( null !== $remove_button_text ) {
			$_args['options']['remove_button'] = $remove_button_text;
		}
		if ( ! empty( $remove_confirm ) ) {
			$_args['options']['remove_confirm'] = $remove_confirm;
		}

		return $this->set( $_args, Repo::GROUP );
	}


	/**
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file_list
	 *
	 * @phpstan-param 'file'|'file_list' $type
	 *
	 * @param string $type
	 * @param string $button_text
	 * @param string $file_mime_type
	 * @param bool   $show_text_input
	 * @param string $preview_size
	 * @param string $remove_item_text
	 * @param string $file_text
	 * @param string $download_text
	 * @param string $select_text - Text on the button in the media manager (default: Use this file).
	 *
	 * @return array
	 */
	protected function field_type_file( $type, $button_text = null, $file_mime_type = null, $show_text_input = null, $preview_size = null, $remove_item_text = null, $file_text = null, $download_text = null, $select_text = null ) : array {
		$_args = [
			'type' => $type,
		];

		if ( null !== $button_text ) {
			$_args['text']['add_upload_file_text'] = $button_text;
		}
		if ( null !== $remove_item_text ) {
			$_args['text']['remove_image_text'] = $remove_item_text;
			$_args['text']['remove_item_text'] = $remove_item_text;
		}
		if ( null !== $file_text ) {
			$_args['text']['file_text'] = $file_text;
		}
		if ( null !== $download_text ) {
			$_args['text']['file_download_text'] = $download_text;
		}
		if ( null !== $file_mime_type ) {
			$_args['query_args'] = [
				'type' => $file_mime_type,
			];
		}
		if ( null !== $select_text ) {
			$_args['text']['add_upload_media_label'] = $select_text;
		}
		if ( null !== $show_text_input ) {
			$_args['options'] = [
				'url' => $show_text_input,
			];
		}
		if ( null !== $preview_size ) {
			$_args['preview_size'] = $preview_size;
		}

		return $_args;
	}


	/**
	 * @param string $type
	 * @param string $taxonomy       - slug.
	 * @param string $no_terms_text
	 * @param bool   $remove_default - remove default WP terms metabox.
	 *
	 * @return array
	 */
	protected function field_type_taxonomy( string $type, string $taxonomy, $no_terms_text = null, $remove_default = null ) : array {
		$_args = [
			'type'     => $type,
			'taxonomy' => $taxonomy,
		];
		if ( null !== $remove_default ) {
			$_args['remove_default'] = $remove_default;
		}
		if ( null !== $no_terms_text ) {
			$_args['text']['no_terms_text'] = $no_terms_text;
		}

		return $_args;
	}


	/**
	 * @param string         $type
	 * @param array|callable $options_or_callback - [ $key => $label ] || function().
	 * @param bool|string    $show_option_none
	 *
	 * @return array
	 */
	protected function field_type_options( string $type, $options_or_callback, $show_option_none = null ) : array {
		if ( \is_callable( $options_or_callback ) ) {
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
		if ( null !== $show_option_none ) {
			$_args['show_option_none'] = $show_option_none;
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
	protected function field_type_date( $type, $date_format = 'm/d/Y', $timezone_meta_key = '', $date_picker_options = [] ) : array {
		$_args = [
			'type'        => $type,
			'date_format' => $date_format,
		];
		if ( ! empty( $timezone_meta_key ) ) {
			$_args['timezone_meta_key'] = $timezone_meta_key;
		}

		if ( ! empty( $date_picker_options ) ) {
			$_args['date_picker_options']['data-datepicker'] = wp_json_encode( $date_picker_options );
		}

		return $_args;
	}

}
