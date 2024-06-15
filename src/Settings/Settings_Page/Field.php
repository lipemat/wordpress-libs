<?php
/** @noinspection ClassMethodNameMatchesFieldNameInspection */
declare( strict_types=1 );

namespace Lipe\Lib\Settings\Settings_Page;

use Lipe\Lib\Settings\Register_Setting;
use Lipe\Lib\Settings\Settings_Page;

/**
 * Arguments for a field in a settings page.
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @link   https://developer.wordpress.org/reference/functions/add_settings_field/#parameters
 **/
class Field {
	/**
	 * Additional arguments supported by `add_settings_field`.
	 *
	 * @var FieldArgs
	 */
	public readonly FieldArgs $args;

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
	 * Render callback to render the field's input.
	 *
	 * @phpstan-var null|callable( Field $field, Settings_Page $settings ): void
	 * @var ?callable( Field $field, Settings_Page $settings, array $args ): void
	 */
	protected $render_callback;

	/**
	 * Help information to display below the field with `description` format.
	 *
	 * @var string
	 */
	protected string $help;


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
		$this->settings_args = new Register_Setting( [] );
		$this->args = new FieldArgs( [] );
	}


	/**
	 * When supplied, the setting title will be wrapped
	 * in a `<label>` element, its `for` attribute populated
	 * with this value.
	 *
	 * @param string $label_for - ID of the input element.
	 *
	 * @return Field
	 */
	public function label_for( string $label_for ): Field {
		$this->args->label_for = $label_for;
		return $this;
	}


	/**
	 * CSS Class to be added to the `<tr>` element when the
	 * field is output.
	 *
	 * @param string $css_class - CSS class to add.
	 *
	 * @return Field
	 */
	public function class( string $css_class ): Field {
		$this->args->class = $css_class;
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
	 * @phpstan-param callable( Field $field, Settings_Page $settings ): void $callback
	 *
	 * @param callable                                                        $callback - Callback to render the field.
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
	 * Render this field using the `render_callback`, or the default input.
	 *
	 * @param Settings_Page $settings - The settings page object.
	 *
	 * @return void
	 */
	public function render( Settings_Page $settings ): void {
		if ( \is_callable( $this->render_callback ) ) {
			\call_user_func( $this->render_callback, $this, $settings );
		} else {
			$value = $settings->get_option( $this->id, '' );
			printf( '<input type="text" name="%1$s" value="%2$s" class="regular-text" />', esc_attr( $this->id ), esc_attr( $value ) );
		}

		if ( isset( $this->help ) ) {
			?>
			<p class="description help">
				<?= wp_kses_post( $this->help ) ?>
			</p>
			<?php
		}
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
