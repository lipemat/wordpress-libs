<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Field\Checkbox;
use Lipe\Lib\CMB2\Field\Term_Select_2;
use Lipe\Lib\CMB2\Field\Term_Select_2\Select_2_Field;
use Lipe\Lib\CMB2\Field\True_False;
use Lipe\Lib\CMB2\Field\Type;
use Lipe\Lib\CMB2\Variation\Date;
use Lipe\Lib\CMB2\Variation\File;
use Lipe\Lib\CMB2\Variation\Options;
use Lipe\Lib\CMB2\Variation\Taxonomy;
use Lipe\Lib\CMB2\Variation\Text;
use Lipe\Lib\CMB2\Variation\TextUrl;
use Lipe\Lib\CMB2\Variation\Wysiwyg;
use Lipe\Lib\Meta\DataType;
use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Util\Arrays;

/**
 * CMB2 field types.
 *
 * A fluent interface complete with callbacks for each possible field type.
 *
 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types
 *
 * @phpstan-import-type OPTIONS_CALLBACK from Options
 * @phpstan-import-type MCE_OPTIONS from Wysiwyg
 */
class Field_Type {
	/**
	 * Field_Type constructor.
	 *
	 * @param Field $field - The field to set properties on.
	 * @param Box   $box   - The box the field belongs to.
	 */
	final protected function __construct(
		protected Field $field,
		protected readonly Box $box
	) {
	}


	/**
	 * A large title (useful for breaking up sections of fields in metabox)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#title
	 */
	public function title(): Field {
		return $this->field->set_args( Type::TITLE, [], DataType::DEFAULT );
	}


	/**
	 * True false switch like checkbox.
	 *
	 * Custom to WP-Libs.
	 *
	 * @return Field
	 */
	public function true_false(): Field {
		$this->field = Variation\Checkbox::from( $this->field, $this->box );
		return $this->field->set_args( Type::CHECKBOX, [
			'render_class' => True_False::class,
		], DataType::CHECKBOX );
	}


	/**
	 * True false switch like checkbox.
	 *
	 * @alias Field_Type::true_false
	 *
	 * @return Field
	 */
	public function toggle(): Field {
		return $this->true_false();
	}


	/**
	 * Standard text field (large).
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text
	 *
	 * @return Text
	 */
	public function text(): Text {
		$this->field = Text::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT, [], DataType::DEFAULT );
	}


	/**
	 * Small text field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_small
	 *
	 * @return Text
	 */
	public function text_small(): Text {
		$this->field = Text::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_SMALL, [], DataType::DEFAULT );
	}


	/**
	 * Medium text field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_medium
	 *
	 * @return Text
	 */
	public function text_medium(): Text {
		$this->field = Text::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_MEDIUM, [], DataType::DEFAULT );
	}


	/**
	 * Standard text field which enforces an email address..
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_email
	 *
	 * @return Text
	 */
	public function text_email(): Text {
		$this->field = Text::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_EMAIL, [], DataType::DEFAULT );
	}


	/**
	 * Standard text field, which enforces a url.
	 *
	 * @link     https://github.com/CMB2/CMB2/wiki/Field-Types#text_url
	 *
	 * @formatter:off
	 * @phpstan-param array<'http'|'https'|'ftp'|'ftps'|'mailto'|'news'|'irc'|'gopher'|'nntp'|'feed'|'telnet'> $protocols
	 *
	 * @param ?string[] $protocols  - Specify the supported URL protocols.
	 *                              Defaults to return value of `wp_allowed_protocols`.
	 * @formatter:on
	 *
	 * @return TextUrl
	 */
	public function text_url( ?array $protocols = null ): TextUrl {
		$this->field = TextUrl::from( $this->field, $this->box );
		$this->field->attributes( [
			'type'  => 'url',
			'class' => 'cmb2-text-url regular-text',
		] );

		return $this->field->set_args( Type::TEXT_URL, [
			'protocols' => $protocols,
		], DataType::DEFAULT );
	}


	/**
	 * Standard text field with dollar sign in front of it
	 * (useful to prevent users from adding a dollar sign to input). .
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_money
	 *
	 * @return Text
	 */
	public function text_money(): Text {
		$this->field = Text::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_MONEY, [], DataType::DEFAULT );
	}


	/**
	 * HTML number field
	 * Custom to WP-Libs
	 *
	 * @link https://www.w3schools.com/tags/att_input_type_number.asp
	 *
	 * @param float      $step - The input's number intervals.
	 * @param float|null $min  - The minimum value of the input.
	 * @param float|null $max  - The maximum value of the input.
	 *
	 * @return Text
	 */
	public function text_number( float $step = 1, ?float $min = null, ?float $max = null ): Text {
		$this->field = Text::from( $this->field, $this->box );
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

		return $this->field->set_args( Type::TEXT_SMALL, [], DataType::DEFAULT );
	}


	/**
	 * Standard textarea.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#textarea
	 *
	 * @param int|null $rows - For small text areas use `textarea_small`.
	 *
	 * @return Text
	 */
	public function textarea( ?int $rows = null ): Text {
		$this->field = Text::from( $this->field, $this->box );
		if ( null !== $rows ) {
			$this->field->attributes( [ 'rows' => $rows ] );
		}

		return $this->field->set_args( Type::TEXT_AREA, [], DataType::DEFAULT );
	}


	/**
	 * Smaller textarea..
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#textarea_small
	 *
	 * @return Text
	 */
	public function textarea_small(): Text {
		$this->field = Text::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_AREA_SMALL, [], DataType::DEFAULT );
	}


	/**
	 * Code textarea.
	 *
	 * The defaults are most likely what you want to use, but arguments are
	 * available for specialize fine-tuning
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#textarea_code
	 * @link    https://codemirror.net/doc/manual.html#option_mode
	 * @link    https://codemirror.net/mode/
	 *
	 * @example textarea_code( false, 'javascript', [ 'codemirror' => [ 'lineNumbers' => false, 'theme' => 'cobalt' ] ]);
	 *
	 * @phpstan-param array{
	 *     codemirror?: array<string, mixed>,
	 * }              $code_editor_arguments
	 *
	 * @param bool    $disable_codemirror    - disable code mirror handling in favor or a basic textbox.
	 * @param ?string $language              - Language mode to use (example: php).
	 * @param array   $code_editor_arguments - The arguments are then passed to `wp.codeEditor.initialize` method.
	 *
	 * @return Field
	 */
	public function textarea_code( bool $disable_codemirror = false, ?string $language = null, array $code_editor_arguments = [] ): Field {
		$set = [];
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
		if ( [] !== $code_editor_arguments ) {
			$this->field->attributes( [
				'data-codeeditor' => (string) wp_json_encode( $code_editor_arguments ),
			] );
		}

		return $this->field->set_args( Type::TEXT_AREA_CODE, $set, DataType::DEFAULT );
	}


	/**
	 * Time picker field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#text_time
	 *
	 * @return Field
	 */
	public function text_time(): Field {
		return $this->field->set_args( Type::TEXT_TIME, [], DataType::DEFAULT );
	}


	/**
	 * Timezone field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#select_timezone
	 *
	 * @return Field
	 */
	public function select_timezone(): Field {
		return $this->field->set_args( Type::SELECT_TIMEZONE, [], DataType::DEFAULT );
	}


	/**
	 * Adds a hidden input type to the bottom of the CMB2 output.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#hidden
	 *
	 * @return Field
	 */
	public function hidden(): Field {
		return $this->field->set_args( Type::HIDDEN, [], DataType::DEFAULT );
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
	 * @see     Field_Type::file()
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 *
	 * @param string      $button_text     - (default 'Add Image' ).
	 * @param bool|null   $show_text_input - (default true) May not be turned off for required fields.
	 * @param string|null $preview_size    - (default full).
	 *
	 * @return File
	 */
	public function image( string $button_text = 'Add Image', ?bool $show_text_input = null, ?string $preview_size = null ): File {
		$this->field = File::from( $this->field, $this->box );
		$_args = $this->field->file_args( $button_text, 'image', $show_text_input, $preview_size, null, null, null, 'Use Image' );

		return $this->field->set_args( Type::FILE, $_args, DataType::FILE );
	}


	/**
	 * Standard checkbox.
	 *
	 * @link          https://github.com/CMB2/CMB2/wiki/Field-Types#checkbox
	 *
	 * @phpstan-param 'compact'|'block' $layout
	 *
	 * @param string                    $layout - compact, block (cmb2 default is block).
	 *
	 * @return Field
	 */
	public function checkbox( string $layout = 'block' ): Field {
		$this->field = Variation\Checkbox::from( $this->field, $this->box );
		$_args = [];
		if ( 'block' !== $layout ) {
			$_args['render_row_cb'] = [ Checkbox::in(), 'render_field_callback' ];
		}

		return $this->field->set_args( Type::CHECKBOX, $_args, DataType::CHECKBOX );
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
	public function oembed(): Field {
		return $this->field->set_args( Type::OEMBED, [], DataType::DEFAULT );
	}


	/**
	 * Date field. Stored and displayed according to the date_format.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_date
	 *
	 * @param string               $date_format         - PHP date format string.
	 * @param string               $timezone_meta_key   - To use the value of another timezone_select field
	 *                                                  as the timezone.
	 * @param array<string, mixed> $date_picker_options - Overrides for jQuery UI Datepicker (see example).
	 *
	 * @return Date
	 */
	public function text_date( string $date_format = 'm/d/Y', string $timezone_meta_key = '', array $date_picker_options = [] ): Date {
		$this->field = Date::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_DATE, $this->field->date_args( $date_format, $timezone_meta_key, $date_picker_options ), DataType::DEFAULT );
	}


	/**
	 * Date field, stored as UNIX timestamp. Useful if you plan to query based on it.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_date_timestamp
	 *
	 * @param string               $date_format         - PHP date format string.
	 * @param string               $timezone_meta_key   - To use the value of another timezone_select field
	 *                                                  as the timezone.
	 * @param array<string, mixed> $date_picker_options - Overrides for jQuery UI Datepicker (see text_date example).
	 * @param array<string, mixed> $time_picker_options - Overrides for jQuery UI Timepicker.
	 *
	 * @return Date
	 */
	public function text_date_timestamp( string $date_format = 'm/d/Y', string $timezone_meta_key = '', array $date_picker_options = [], array $time_picker_options = [] ): Date {
		$this->field = Date::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_DATE_TIMESTAMP, $this->field->date_args( $date_format, $timezone_meta_key, $date_picker_options, $time_picker_options ), DataType::DEFAULT );
	}


	/**
	 * Date and time field, stored as UNIX timestamp. Useful if you plan to query based on it.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_datetime_timestamp
	 *
	 * @param string               $date_format         - PHP date format string.
	 * @param string               $timezone_meta_key   - To use the value of another timezone_select field
	 *                                                  as the timezone.
	 * @param array<string, mixed> $date_picker_options - Overrides for jQuery UI Datepicker (see text_date example).
	 * @param array<string, mixed> $time_picker_options - Overrides for jQuery UI Timepicker.
	 *
	 * @return Date
	 */
	public function text_datetime_timestamp( string $date_format = 'm/d/Y', string $timezone_meta_key = '', array $date_picker_options = [], array $time_picker_options = [] ): Date {
		$this->field = Date::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_DATETIME_TIMESTAMP, $this->field->date_args( $date_format, $timezone_meta_key, $date_picker_options, $time_picker_options ), DataType::DEFAULT );
	}


	/**
	 * Date, time and timezone field, stored as serialized DateTime object.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Types#text_datetime_timestamp_timezone
	 *
	 * @param string               $date_format         - PHP date format string.
	 * @param string               $timezone_meta_key   - To use the value of another timezone_select field
	 *                                                  as the timezone.
	 * @param array<string, mixed> $date_picker_options - Overrides for jQuery UI Datepicker (see text_date example).
	 * @param array<string, mixed> $time_picker_options - Overrides for jQuery UI Timepicker.
	 *
	 * @return Date
	 */
	public function text_datetime_timestamp_timezone( string $date_format = 'm/d/Y', string $timezone_meta_key = '', array $date_picker_options = [], array $time_picker_options = [] ): Date {
		$this->field = Date::from( $this->field, $this->box );
		return $this->field->set_args( Type::TEXT_DATETIME_TIMESTAMP_TZ, $this->field->date_args( $date_format, $timezone_meta_key, $date_picker_options, $time_picker_options ), DataType::DEFAULT );
	}


	/**
	 * A color picker field.
	 *
	 * The CMB2 color picker uses the built-in WordPress color picker,
	 * Iris [automattic.github.io/Iris/] (http://automattic.github.io/Iris/)
	 *
	 * All the default options in Iris are configurable within the CMB2 color picker field.
	 *
	 *
	 * [Default Iris Options] (http://automattic.github.io/Iris/#options):
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#colorpicker
	 *
	 * @phpstan-param array{
	 *     color?: bool,
	 *     mode?: string,
	 *     controls?: array{
	 *         horiz?: string,
	 *         vert?: string,
	 *         strip?: string,
	 *     },
	 *     hide?: bool,
	 *     border?: bool,
	 *     target?: bool,
	 *     width?: int,
	 *     palettes?: bool,
	 * }            $iris_options
	 *
	 * @param array $iris_options - Array of options to pass to Iris.
	 * @param bool  $transparency - to enable transparency.
	 *
	 * @return Field
	 */
	public function colorpicker( array $iris_options = [], bool $transparency = false ): Field {
		$_args = [];
		if ( [] !== $iris_options ) {
			$this->field->attributes( [ 'data-colorpicker' => (string) wp_json_encode( $iris_options ) ] );
		}
		if ( $transparency ) {
			$_args['options'] = [
				'alpha' => true,
			];
		}

		return $this->field->set_args( Type::COLOR_PICKER, $_args, DataType::DEFAULT );
	}


	/**
	 * A field with multiple checkboxes (and multiple can be selected)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#multicheck-and-multicheck_inline
	 *
	 * @phpstan-param OPTIONS_CALLBACK $options_or_callback
	 *
	 * @param array|callable           $options_or_callback - [ $key => $label ] || function().
	 * @param bool                     $select_all          - display select all button or not.
	 *
	 * @return Options
	 */
	public function multicheck( callable|array $options_or_callback, bool $select_all = true ): Options {
		$this->field = Options::from( $this->field, $this->box );
		$_args = $this->field->option_args( $options_or_callback );
		$_args['select_all_button'] = $select_all;

		return $this->field->set_args( Type::MULTI_CHECK, $_args, DataType::DEFAULT );
	}


	/**
	 * A field with multiple checkboxes (and multiple can be selected)
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#multicheck-and-multicheck_inline
	 *
	 * @phpstan-param OPTIONS_CALLBACK $options_or_callback
	 *
	 * @param array|callable           $options_or_callback - [ $key => $label ] || function().
	 * @param bool                     $select_all          - display select all button or not.
	 *
	 * @return Options
	 */
	public function multicheck_inline( callable|array $options_or_callback, bool $select_all = true ): Options {
		$this->field = Options::from( $this->field, $this->box );
		$_args = $this->field->option_args( $options_or_callback );
		$_args['select_all_button'] = $select_all;

		return $this->field->set_args( Type::MULTI_CHECK_INLINE, $_args, DataType::DEFAULT );
	}


	/**
	 * Standard radio buttons.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#radio
	 *
	 * @phpstan-param OPTIONS_CALLBACK $options_or_callback
	 *
	 * @param array|callable           $options_or_callback - [ $key => $label ] || function().
	 * @param bool|string              $show_option_none    - disable or set the text of the option.
	 *
	 * @return Options
	 */
	public function radio( callable|array $options_or_callback, bool|string $show_option_none = true ): Options {
		$this->field = Options::from( $this->field, $this->box );
		$_args = $this->field->option_args( $options_or_callback, $show_option_none );

		return $this->field->set_args( Type::RADIO, $_args, DataType::DEFAULT );
	}


	/**
	 * Inline radio buttons.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#radio_inline
	 *
	 * @phpstan-param OPTIONS_CALLBACK $options_or_callback
	 *
	 * @param callable|array           $options_or_callback - [ $key => $label ] || function().
	 * @param bool|string              $show_option_none    - disable or set the text of the option.
	 *
	 * @return Options
	 */
	public function radio_inline( callable|array $options_or_callback, bool|string $show_option_none = true ): Options {
		$this->field = Options::from( $this->field, $this->box );
		$_args = $this->field->option_args( $options_or_callback, $show_option_none );

		return $this->field->set_args( Type::RADIO_INLINE, $_args, DataType::DEFAULT );
	}


	/**
	 * Standard select dropdown.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#select
	 *
	 * @phpstan-param OPTIONS_CALLBACK $options_or_callback
	 *
	 * @param array|callable           $options_or_callback - [ $key => $label ] || function().
	 * @param bool|string              $show_option_none    - disable or set the text of the option.
	 *
	 * @return Options
	 */
	public function select( array|callable $options_or_callback, bool|string $show_option_none = true ): Options {
		$this->field = Options::from( $this->field, $this->box );
		$_args = $this->field->option_args( $options_or_callback, $show_option_none );

		return $this->field->set_args( Type::SELECT, $_args, DataType::DEFAULT );
	}


	/**
	 * Radio buttons pre-populated with taxonomy terms
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio
	 *
	 * @param string      $taxonomy       - slug.
	 * @param string|null $no_terms_text  - text to display if no terms are found.
	 * @param bool|null   $remove_default - remove default WP terms metabox.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_radio( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );

		return $this->field->set_args( Type::TAXONOMY_RADIO, $_args, DataType::TAXONOMY_SINGULAR );
	}


	/**
	 * Hierarchical radio buttons pre-populated with taxonomy terms
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio
	 *
	 * @param string      $taxonomy       - slug.
	 * @param string|null $no_terms_text  - text to display if no terms are found.
	 * @param bool|null   $remove_default - remove default WP terms metabox.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_radio_hierarchical( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );

		return $this->field->set_args( Type::TAXONOMY_RADIO_HIERARCHICAL, $_args, DataType::TAXONOMY_SINGULAR );
	}


	/**
	 * Inline radio buttons pre-populated with taxonomy terms
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_radio_inline
	 *
	 * @param string      $taxonomy       - slug.
	 * @param string|null $no_terms_text  - text to display if no terms are found.
	 * @param bool|null   $remove_default - remove default WP terms metabox.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_radio_inline( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );

		return $this->field->set_args( Type::TAXONOMY_RADIO_INLINE, $_args, DataType::TAXONOMY_SINGULAR );
	}


	/**
	 * A select field pre-populated with taxonomy terms.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_select
	 *
	 * @param string      $taxonomy       - slug.
	 * @param string|null $no_terms_text  - text to display if no terms are found.
	 * @param bool|null   $remove_default - remove default WP terms metabox.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_select( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );

		return $this->field->set_args( Type::TAXONOMY_SELECT, $_args, DataType::TAXONOMY_SINGULAR );
	}


	/**
	 * A select field pre-populated with taxonomy terms and displayed hierarchical.
	 *
	 * @param string      $taxonomy       - slug.
	 * @param string|null $no_terms_text  - text to display if no terms are found.
	 * @param bool|null   $remove_default - remove default WP terms metabox.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_select_hierarchical( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );

		return $this->field->set_args( Type::TAXONOMY_SELECT_HIERARCHICAL, $_args, DataType::TAXONOMY_SINGULAR );
	}


	/**
	 * A custom field, which exists only within Lipe\Lib
	 *
	 * Select 2 term selector.
	 *
	 * @see Term_Select_2
	 *
	 * @param string  $taxonomy       - slug.
	 * @param bool    $assign_terms   - append the terms to the object as well as storing them in meta (default to false).
	 * @param ?string $no_terms_text  - text to display if no terms are found.
	 * @param ?bool   $remove_default - remove default WP terms metabox.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_select_2( string $taxonomy, bool $assign_terms = false, ?string $no_terms_text = null, ?bool $remove_default = null ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );
		$field = $this->field->set_args( Type::TERM_SELECT_2, $_args, DataType::TAXONOMY );
		Select_2_Field::factory( $field, $taxonomy, $assign_terms );
		return $field;
	}


	/**
	 * A field with checkboxes with taxonomy terms, and multiple terms can be selected.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 *
	 * @param string      $taxonomy       - slug.
	 * @param string|null $no_terms_text  - text to display if no terms are found.
	 * @param bool|null   $remove_default - remove default WP terms metabox.
	 * @param bool        $select_all     - display the select all button.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_multicheck( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null, bool $select_all = true ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );
		$_args['select_all_button'] = $select_all;

		return $this->field->set_args( Type::TAXONOMY_MULTICHECK, $_args, DataType::TAXONOMY );
	}


	/**
	 * Hierarchical checkboxes with taxonomy terms, and multiple terms can be selected.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck_hierarchical
	 *
	 * @param string      $taxonomy       - slug.
	 * @param string|null $no_terms_text  - text to display if no terms are found.
	 * @param bool|null   $remove_default - remove default WP terms metabox.
	 * @param bool        $select_all     - display the select all button.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_multicheck_hierarchical( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null, bool $select_all = true ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );
		$_args['select_all_button'] = $select_all;

		return $this->field->set_args( Type::TAXONOMY_MULTICHECK_HIERARCHICAL, $_args, DataType::TAXONOMY );
	}


	/**
	 * Inline checkboxes with taxonomy terms.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck_inline
	 *
	 * @param string      $taxonomy       - slug.
	 * @param string|null $no_terms_text  - text to display if no terms are found.
	 * @param bool|null   $remove_default - remove default WP terms metabox.
	 * @param bool        $select_all     - display the select all button.
	 *
	 * @return Taxonomy
	 */
	public function taxonomy_multicheck_inline( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null, bool $select_all = true ): Taxonomy {
		$this->field = Taxonomy::from( $this->field, $this->box );
		$_args = $this->field->taxonomy_args( $taxonomy, $no_terms_text, $remove_default );
		$_args['select_all_button'] = $select_all;

		return $this->field->set_args( Type::TAXONOMY_MULTICHECK_INLINE, $_args, DataType::TAXONOMY );
	}


	/**
	 * A metabox with TinyMCE editor (same as WordPress' visual editor).
	 *
	 * @see  \_WP_Editors::parse_settings()
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#wysiwyg
	 *
	 * @phpstan-param MCE_OPTIONS $mce_options
	 *
	 * @param array               $mce_options - Standard WP mce options.
	 *
	 * @return Wysiwyg
	 */
	public function wysiwyg( array $mce_options = [] ): Wysiwyg {
		$_args = [];
		if ( [] !== $mce_options ) {
			$_args['options'] = $mce_options;
		}
		$this->field = Wysiwyg::from( $this->field, $this->box );

		return $this->field->set_args( Type::WYSIWYG, $_args, DataType::DEFAULT );
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
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 *
	 * @example file('Add PDF', 'application/pdf', true);
	 *
	 * @example file( 'Add Image', 'image', false );
	 *
	 * @param string|null $button_text     - (default 'Add File' ).
	 * @param string|null $file_mime_type  - (default all).
	 * @param bool|null   $show_text_input - (default true) May not be turned off for required fields.
	 * @param string|null $preview_size    - (default full).
	 * @param string|null $select_text     - Media manager button label (default: Use this file).
	 *
	 * @return File
	 */
	public function file( ?string $button_text = null, ?string $file_mime_type = null, ?bool $show_text_input = null, ?string $preview_size = null, ?string $select_text = null ): File {
		$this->field = File::from( $this->field, $this->box );
		$_args = $this->field->file_args( $button_text, $file_mime_type, $show_text_input, $preview_size, null, null, null, $select_text );

		return $this->field->set_args( Type::FILE, $_args, DataType::FILE );
	}


	/**
	 * A file uploader that allows you to add as many files as you want.
	 * Once added, files can be dragged and dropped to reorder.
	 * This is a repeatable field, and will store its data in an array,
	 * with the attachment ID as the array key, and the attachment url as the value.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file_list
	 *
	 * @param string|null $button_text      - (default 'Add File').
	 * @param string|null $file_mime_type   - (default all).
	 * @param string|null $preview_size     - (default full).
	 * @param string|null $remove_item_text - (default 'Remove').
	 * @param string|null $file_text        - (default 'File').
	 * @param string|null $download_text    - (default 'Download').
	 * @param string|null $select_text      - (default 'Use these files').
	 *
	 * @return Field
	 */
	public function file_list( ?string $button_text = null, ?string $file_mime_type = null, ?string $preview_size = null, ?string $remove_item_text = null, ?string $file_text = null, ?string $download_text = null, ?string $select_text = null ): Field {
		$this->field = File::from( $this->field, $this->box );
		$_args = $this->field->file_args( $button_text, $file_mime_type, null, $preview_size, $remove_item_text, $file_text, $download_text, $select_text );

		return $this->field->set_args( Type::FILE_LIST, $_args, DataType::DEFAULT );
	}


	/**
	 * A hybrid field that supports adding other fields as a repeatable group.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#group
	 *
	 * @interal
	 *
	 * @param ?string $title - Include a {#} to have replaced with number.
	 *
	 * @return Field
	 */
	public function group( ?string $title = null ): Field {
		$_args = [];
		if ( null !== $title ) {
			$_args['options']['group_title'] = $title;
		}

		return $this->field->set_args( Type::GROUP, $_args, DataType::GROUP );
	}


	/**
	 * Create a new field type instance.
	 *
	 * @param Field $field - Field instance.
	 * @param Box   $box   - Box the field belongs to.
	 *
	 * @return Field_Type
	 */
	public static function factory( Field $field, Box $box ): Field_Type {
		return new Field_Type( $field, $box );
	}
}
