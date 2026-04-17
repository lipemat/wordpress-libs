<?php
/** @noinspection ClassMethodNameMatchesFieldNameInspection */
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Field;

use Lipe\Lib\CMB2\Field;

/**
 *  These allow you to add arbitrary text/markup at different points in the field markup.
 *  These also accept a callback.
 *  The callback will receive `array $field_args` as the first argument,
 *  and the `CMB2_Field $field` object as the second argument.
 *
 * @link  https://github.com/CMB2/CMB2/wiki/Field-Parameters#before_display_wrap-before_display-after_display-after_display_wrap
 * @link  https://github.com/CMB2/CMB2/wiki/Field-Parameters#before-after-before_row-after_row-before_field-after_field
 *
 * @phpstan-type PARAM_CB string|(\Closure(array<string, mixed>, \CMB2_Field): (string|void) )
 *
 * @since 5.0.0
 */
trait Display {
	/**
	 * Bypass the CMB row rendering.
	 * You will be completely responsible for outputting that row's HTML.
	 * The callback function gets passed the field $args array, and the $field object.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_row_cb
	 * @link https://github.com/WebDevStudios/CMB2/issues/596#issuecomment-187941343
	 *
	 * @var \Closure|null
	 */
	protected(set) \Closure|null $render_row_cb;

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
	protected(set) bool $on_front;

	/**
	 * Order the field will display in.
	 *
	 * @var int
	 */
	protected(set) int $position = 0;

	/**
	 * Like the classes property, allows adding classes to the CMB2 wrapper,
	 * but takes a callback.
	 * That callback should return an array of classes.
	 * The callback gets passed the CMB2 properties array as the first argument,
	 * and the CMB2 cmb object as the second argument.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#classes_cb
	 *
	 * @var \Closure( array<string, mixed>, \CMB2_Field): string
	 */
	protected(set) \Closure $classes_cb;

	/**
	 * Display a message or any arbitrary text/markup before the field.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $before;

	/**
	 * Display a message or any arbitrary text/markup after the field.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $after;

	/**
	 * Display a message or any arbitrary text/markup before the field row.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $before_row;

	/**
	 * Display a message or any arbitrary text/markup after the field row.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $after_row;

	/**
	 * Display a message or any arbitrary text/markup before the field markup.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $before_field;

	/**
	 * Display a message or any arbitrary text/markup after the field markup.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $after_field;

	/**
	 * Display a message or any arbitrary text/markup before the field display markup.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $before_display_wrap;

	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $before_display;

	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $after_display;

	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @phpstan-var PARAM_CB
	 * @var \Closure|string
	 */
	protected(set) \Closure|string $after_display_wrap;

	/**
	 * Entirely replace the class to used to display the field (in admin columns, etc.)
	 *
	 * @var \CMB2_Field_Display
	 */
	protected(set) \CMB2_Field_Display $display_class;

	/**
	 * A custom callback to return the label for the field
	 *
	 * Part of cmb2 core but undocumented.
	 *
	 * @see \CMB2_Base::do_callback
	 *
	 * @var \Closure(string, \CMB2_Field): string
	 */
	protected(set) \Closure $label_cb;

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
	protected(set) array|string $classes;

	/**
	 * Whether to show labels for the fields.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#show_names
	 *
	 * Default true
	 *
	 * @var bool
	 */
	protected(set) bool $show_names;

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
	 * @phpstan-var \Closure( \CMB2_Field ): bool $func
	 * @var \Closure
	 */
	protected(set) \Closure $show_on_cb;

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
	protected(set) string $render_class;


	/**
	 * Set the position of the field in the meta box.
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
	 * @phpstan-param PARAM_CB $after
	 *
	 * @param \Closure|string  $after - Callback or string to display after the field.
	 */
	public function after( string|\Closure $after ): static {
		$this->after = $after;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @phpstan-param PARAM_CB $after_display
	 *
	 * @param \Closure|string  $after_display - Callback or string to display before the field.
	 */
	public function after_display( \Closure|string $after_display ): static {
		$this->after_display = $after_display;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @phpstan-param PARAM_CB $after_display_wrap
	 *
	 * @param \Closure|string  $after_display_wrap - Callback or string to display after the field.
	 */
	public function after_display_wrap( \Closure|string $after_display_wrap ): static {
		$this->after_display_wrap = $after_display_wrap;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field.
	 *
	 * @phpstan-param PARAM_CB $after_field
	 *
	 * @param \Closure|string  $after_field - Callback or string to display after the field.
	 */
	public function after_field( \Closure|string $after_field ): static {
		$this->after_field = $after_field;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field row.
	 *
	 * @phpstan-param PARAM_CB $after_row
	 *
	 * @param \Closure|string  $after_row - Callback or string to display after the field.
	 */
	public function after_row( \Closure|string $after_row ): static {
		$this->after_row = $after_row;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup before the field.
	 *
	 * @phpstan-param PARAM_CB $before
	 *
	 * @param \Closure|string  $before - Callback or string to display before the field.
	 */
	public function before( \Closure|string $before ): static {
		$this->before = $before;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup after the field display markup.
	 *
	 * @phpstan-param PARAM_CB $before_display
	 *
	 * @param \Closure|string  $before_display - Callback or string to display before the field.
	 */
	public function before_display( \Closure|string $before_display ): static {
		$this->before_display = $before_display;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup before the field display markup.
	 *
	 * @phpstan-param PARAM_CB $before_display_wrap
	 *
	 * @param \Closure|string  $before_display_wrap - Callback or string to display after the field.
	 */
	public function before_display_wrap( \Closure|string $before_display_wrap ): static {
		$this->before_display_wrap = $before_display_wrap;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup before the field markup.
	 *
	 * @phpstan-param PARAM_CB $before_field
	 *
	 * @param \Closure|string  $before_field - Callback or string to display before the field.
	 */
	public function before_field( \Closure|string $before_field ): static {
		$this->before_field = $before_field;
		return $this;
	}


	/**
	 * Display a message or any arbitrary text/markup before the field row.
	 *
	 * @phpstan-param PARAM_CB $before_row
	 *
	 * @param \Closure|string  $before_row - Callback or string to display before the field.
	 */
	public function before_row( \Closure|string $before_row ): static {
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
	 * @param \Closure(string, \CMB2_Field): string $label_cb - Callback to return the label for the field.
	 */
	public function label_cb( \Closure $label_cb ): static {
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
	 * @phpstan-param \Closure( array<string, mixed>, \CMB2_Field): string $classes_cb
	 *
	 * @param \Closure                                                     $classes_cb - Callback to return the classes for the field.
	 */
	public function classes_cb( \Closure $classes_cb ): static {
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
	 * @phpstan-param \Closure( \CMB2_Field ): bool $func
	 *
	 * @formatter:off
	 * @param \Closure $func - The function to use for determining if the field should show.
	 * @formatter:on
	 *
	 * @return Field
	 */
	public function show_on_cb( \Closure $func ): Field {
		$this->show_on_cb = $func;

		return $this;
	}


	/**
	 * Bypass the CMB row rendering.
	 * You will be completely responsible for outputting that row's HTML.
	 * The callback function gets passed the field $args array, and the $field object.
	 *
	 * @link     https://github.com/CMB2/CMB2/wiki/Field-Parameters#render_row_cb
	 * @link     https://github.com/WebDevStudios/CMB2/issues/596#issuecomment-187941343
	 *
	 * @phpstan-param \Closure( array<string, mixed>, \CMB2_Field ): (void|\CMB2_Field) $render_row_cb
	 *
	 * @formatter:off
	 * @param \Closure|null $render_row_cb - Callback to render the row.
	 * @formatter:on
	 */
	public function render_row_cb( \Closure|null $render_row_cb ): static {
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
