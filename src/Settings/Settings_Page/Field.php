<?php
/** @noinspection ClassMethodNameMatchesFieldNameInspection */
declare( strict_types=1 );

namespace Lipe\Lib\Settings\Settings_Page;

use Lipe\Lib\Settings\Register_Setting;
use Lipe\Lib\Settings\Settings_Page;

/**
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @link   https://developer.wordpress.org/reference/functions/add_settings_field/#parameters
 *
 * @phpstan-type FIELD_ARGS array{label_for?: string, class?: string}
 */
class Field {
	/**
	 * Help information to display below the field with `description` format.
	 *
	 * @var string
	 */
	public string $help;

	/**
	 * Render callback to render the field's input.
	 *
	 * @phpstan-var null|callable( Field $field, Settings_Page $settings, FIELD_ARGS $args ): void
	 * @var ?callable( Field $field, Settings_Page $settings, array $args ): void
	 */
	public $render_callback;

	/**
	 * Additional arguments supported by `add_settings_field`
	 *
	 * @phpstan-var FIELD_ARGS
	 * @var array
	 */
	public array $field_args;

	/**
	 * Additional arguments supported by `register_setting`.
	 *
	 * @notice Must be `readonly` because multiple methods may interact with
	 *         the same instance of `Register_Settings`.
	 *
	 * @var Register_Setting
	 */
	public readonly Register_Setting $settings_args;


	/**
	 * Build a new settings field to be returned by `Section::get_fields()`.
	 *
	 * @see Section::field()
	 *
	 * @param string $id    - Unique ID for this field.
	 * @param string $title - Title of the field.
	 */
	final protected function __construct(
		public readonly string $id,
		public readonly string $title,
	) {
		$this->settings_args = new Register_Setting();
	}


	/**
	 * Additional arguments supported by `add_settings_field`
	 *
	 * @phpstan-param FIELD_ARGS $field_args
	 *
	 * @param array              $field_args - Arguments to pass to `add_settings_field`.
	 *
	 * @return Field
	 */
	public function field_args( array $field_args ): Field {
		$this->field_args = $field_args;
		return $this;
	}


	/**
	 * Help information to display below the field with `description` format.
	 *
	 * @param string $help - Help text.
	 *
	 * @return Field
	 */
	public function help( string $help ): Field {
		$this->help = $help;
		return $this;
	}


	/**
	 * Render callback to render the field's input.
	 *
	 * @phpstan-param callable( Field $field, Settings_Page $settings, FIELD_ARGS $args ): void $callback
	 *
	 * @param callable                                                                          $callback - Callback to render the field.
	 *
	 * @return Field
	 */
	public function render_callback( callable $callback ): Field {
		$this->render_callback = $callback;
		return $this;
	}


	/**
	 * A callback to sanitize the field's value before saving.
	 *
	 * @phpstan-param callable( mixed $value, Field $field ): mixed $callback
	 *
	 * @param callable                                              $callback - Callback to sanitize the value.
	 *
	 * @return Field
	 */
	public function sanitize_callback( callable $callback ): Field {
		$this->settings_args->sanitize_callback = fn( mixed $value ) => $callback( $value, $this );
		return $this;
	}


	/**
	 * Additional arguments supported by `register_setting`
	 *
	 * @param Register_Setting $settings_args - Arguments to pass to `register_setting`.
	 *
	 * @return Field
	 */
	public function settings_args( Register_Setting $settings_args ): Field {
		$this->settings_args->merge( $settings_args );
		return $this;
	}


	/**
	 * Build a new settings field to be returned by `Section::get_fields()`.
	 *
	 * @see Section::field()
	 *
	 * @param string $id    - Unique ID for this field.
	 * @param string $title - Title of the field.
	 */
	public static function factory( string $id, string $title ): Field {
		return new Field( $id, $title );
	}
}
