<?php
/** @noinspection ClassMethodNameMatchesFieldNameInspection */
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

/**
 *  These allow you to add arbitrary text/markup at different points in the field markup.
 *  These also accept a callback.
 *  The callback will receive $field_args as the first argument,
 *  and the CMB2_Field $field object as the second argument.
 *
 * @link  https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_display_wrap-before_display-after_display-after_display_wrap
 *
 * @since 5.0.0
 */
trait Display {
	/**
	 * Display a message or any arbitrary text/markup before the field.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $before;

	/**
	 * Display a message or any arbitrary text/markup after the field.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $after;

	/**
	 * Display a message or any arbitrary text/markup before the field row.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $before_row;

	/**
	 * Display a message or any arbitrary text/markup after the field row.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $after_row;

	/**
	 * Display a message or any arbitrary text/markup before the field markup.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $before_field;

	/**
	 * Display a message or any arbitrary text/markup after the field markup.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $after_field;

	/**
	 * Display a message or any arbitrary text/markup before the field display markup.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $before_display_wrap;

	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $before_display;

	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $after_display;

	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @var callable(array<string, mixed>, \CMB2_Field): void|string
	 */
	protected $after_display_wrap;

	/**
	 * Entirely replace the class to used to display the field (in admin columns, etc.)
	 *
	 * @var \CMB2_Field_Display
	 */
	protected \CMB2_Field_Display $display_class;

	/**
	 * A custom callback to return the label for the field
	 *
	 * Part of cmb2 core but undocumented.
	 *
	 * @see \CMB2_Base::do_callback
	 *
	 * @var callable(string, \CMB2_Field): string
	 */
	protected $label_cb;

	/**
	 * This property allows you to optionally add classes to the CMB2 wrapper.
	 * This property can take a string, or array.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#classes
	 *
	 * @example 'additional-class'
	 * @example array('additional-class', 'another-class'),
	 *
	 * @var array<string>|string
	 */
	protected array|string $classes;

	/**
	 * Like the classes property, allows adding classes to the CMB2 wrapper,
	 * but takes a callback.
	 * That callback should return an array of classes.
	 * The callback gets passed the CMB2 properties array as the first argument,
	 * and the CMB2 cmb object as the second argument.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#classes_cb
	 *
	 * @var callable( array<string, mixed>, \CMB2_Field): string
	 */
	protected $classes_cb;

	/**
	 * Whether to show labels for the fields.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_names
	 *
	 * Default  true
	 *
	 * @var bool
	 */
	protected bool $show_names;

	/**
	 * To show this field or not based on the result of a function.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_on_cb
	 * @example should_i_show($field){ return bool}
	 *
	 * @see     Field::show_on_cb
	 *
	 * @interal
	 *
	 * @phpstan-var callable( \CMB2_Field ): bool $func
	 * @var callable
	 */
	protected $show_on_cb;

	/**
	 * Allows overriding the default CMB2_Type_Base class used when rendering the field.
	 * This provides interesting object-oriented ways to override default CMB2 behavior
	 * by subclassing the default class and overriding methods.
	 * For best results, your class should extend the class it is overriding.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_class
	 *
	 * @var string
	 */
	protected string $render_class;

	/**
	 * Bypass the CMB row rendering.
	 * You will be completely responsible for outputting that row's HTML.
	 * The callback function gets passed the field $args array, and the $field object.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_row_cb
	 * @link https://github.com/WebDevStudios/CMB2/issues/596#issuecomment-187941343
	 *
	 * @var callable|null
	 */
	protected $render_row_cb;

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
	protected bool $on_front;

	/**
	 * Order the field will display in.
	 *
	 * @var int
	 */
	protected int $position = 0;


	/**
	 * Set the position of the field in the meta box
	 *
	 * @param int $position - The position of the field.
	 *
	 * @default 1
	 *
	 * @return Field
	 */
	public function position( int $position = 1 ): Field {
		$this->position = $position;

		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $after - Callback or string to display after the field.
	 */
	public function after( callable|string $after ): static {
		$this->after = $after;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $after_display - Callback or string to display before the field.
	 */
	public function after_display( callable|string $after_display ): static {
		$this->after_display = $after_display;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $after_display_wrap - Callback or string to display after the field.
	 */
	public function after_display_wrap( callable|string $after_display_wrap ): static {
		$this->after_display_wrap = $after_display_wrap;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $after_field - Callback or string to display after the field.
	 */
	public function after_field( callable|string $after_field ): static {
		$this->after_field = $after_field;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field row.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $after_row - Callback or string to display after the field.
	 */
	public function after_row( callable|string $after_row ): static {
		$this->after_row = $after_row;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup before the field.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $before - Callback or string to display before the field.
	 */
	public function before( callable|string $before ): static {
		$this->before = $before;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $before_display - Callback or string to display before the field.
	 */
	public function before_display( callable|string $before_display ): static {
		$this->before_display = $before_display;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup before the field display markup.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $before_display_wrap - Callback or string to display after the field.
	 */
	public function before_display_wrap( callable|string $before_display_wrap ): static {
		$this->before_display_wrap = $before_display_wrap;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup before the field markup.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $before_field - Callback or string to display before the field.
	 */
	public function before_field( callable|string $before_field ): static {
		$this->before_field = $before_field;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup before the field row.
	 *
	 * @param callable(array<string, mixed>, \CMB2_Field): void|string $before_row - Callback or string to display before the field.
	 */
	public function before_row( callable|string $before_row ): static {
		$this->before_row = $before_row;
		return $this;
	}


	/**
	 * A custom callback to return the label for the field
	 *
	 * Part of cmb2 core but undocumented.
	 *
	 * @see \CMB2_Base::do_callback
	 *
	 * @param callable(string, \CMB2_Field): string $label_cb - Callback to return the label for the field.
	 */
	public function label_cb( callable $label_cb ): static {
		$this->label_cb = $label_cb;
		return $this;
	}


	/**
	 * If you're planning on using your metabox fields on the front-end as well (user-facing),
	 * then you can specify that certain fields do not get displayed there
	 * by setting this parameter to false.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#on_front
	 *
	 * @param bool $on_front - Whether to show the field on the front end.
	 */
	public function on_front( bool $on_front ): static {
		$this->on_front = $on_front;
		return $this;
	}


	/**
	 * This property allows you to optionally add classes to the CMB2 wrapper.
	 * This property can take a string, or array.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#classes
	 * @example 'additional-class'
	 *          array('additional-class', 'another-class'),
	 *
	 * @param string|string[] $classes - Classes to add to the CMB2 wrapper.
	 *
	 */
	public function classes( array|string $classes ): static {
		$this->classes = $classes;
		return $this;
	}


	/**
	 * Like the classes property, allows adding classes to the CMB2 wrapper,
	 * but takes a callback.
	 * That callback should return an array of classes.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#classes_cb
	 *
	 * @phpstan-param callable( array<string, mixed>, \CMB2_Field): string $classes_cb
	 *
	 * @param callable                                                     $classes_cb - Callback to return the classes for the field.
	 */
	public function classes_cb( callable $classes_cb ): static {
		$this->classes_cb = $classes_cb;
		return $this;
	}


	/**
	 * Entirely replace the class to used to display the field (in admin columns, etc.)
	 *
	 * @param \CMB2_Field_Display $display_class - The display class to use.
	 */
	public function display_class( \CMB2_Field_Display $display_class ): static {
		$this->display_class = $display_class;
		return $this;
	}


	/**
	 * Whether to show labels for the fields.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_names
	 *
	 * @default true
	 *
	 * @param bool $show_names - Whether to show the field labels.
	 */
	public function show_names( bool $show_names ): static {
		$this->show_names = $show_names;
		return $this;
	}


	/**
	 * To show this field or not based on the result of a function.
	 *
	 * @link     https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_on_cb
	 * @example  should_i_show($field){ return bool}
	 *
	 * @phpstan-param callable( \CMB2_Field ): bool $func
	 *
	 * @formatter:off
	 * @param callable $func - The function to use for determining if the field should show.
	 * @formatter:on
	 *
	 * @return Field
	 */
	public function show_on_cb( callable $func ): Field {
		$this->show_on_cb = $func;

		return $this;
	}


	/**
	 * Bypass the CMB row rendering.
	 * You will be completely responsible for outputting that row's HTML.
	 * The callback function gets passed the field $args array, and the $field object.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_row_cb
	 * @link https://github.com/WebDevStudios/CMB2/issues/596#issuecomment-187941343
	 *
	 * @phpstan-param callable( array<string, mixed>, \CMB2_Field ): void $render_row_cb
	 *
	 * @param callable                                                    $render_row_cb - Callback to render the row.
	 */
	public function render_row_cb( callable $render_row_cb ): static {
		$this->render_row_cb = $render_row_cb;
		return $this;
	}


	/**
	 * Allows overriding the default CMB2_Type_Base class used when rendering the field.
	 * This provides interesting object-oriented ways to override default CMB2 behavior
	 * by subclassing the default class and overriding methods.
	 * For best results, your class should extend the class it is overriding.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_class
	 *
	 * @phpstan-param class-string<\CMB2_Type_Base> $render_class
	 *
	 * @param string                                $render_class - Class to use when rendering the field.
	 *
	 * @return static
	 */
	public function render_class( string $render_class ): static {
		$this->render_class = $render_class;
		return $this;
	}
}
