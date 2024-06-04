<?php
declare( strict_types=1 );

namespace Lipe\Lib\Settings\Settings_Page;

/**
 * A section of fields on a settings page.
 *
 * @link   https://developer.wordpress.org/reference/functions/add_settings_section/
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @phpstan-type SECTION_ARGS array{
 *     before_section: string,
 *     after_section: string,
 *     section_class: string,
 * }
 */
class Section {
	/**
	 * Additional arguments supported by `add_settings_section`
	 *
	 * @phpstan-var \Partial<SECTION_ARGS>
	 * @var array
	 */
	public array $args;

	/**
	 * Description for the section.
	 *
	 * @var string
	 */
	protected string $description;

	/**
	 * Fields in this section.
	 *
	 * @var Field[]
	 */
	protected array $fields = [];


	/**
	 * Build a new settings section to be returned by `Settings::get_sections()`.
	 *
	 * @see Settings::get_sections()
	 *
	 * @param string $id    - Unique ID for this section.
	 * @param string $title - Title of the section.
	 */
	final protected function __construct(
		public readonly string $id,
		public readonly string $title,
	) {
	}


	/**
	 * Add a field to this section.
	 *
	 * Use to chain the `Field` instead of the `Section`.
	 *
	 * @see Section::add_field()
	 *
	 * @param string $id    - Unique ID for this field.
	 * @param string $title - Title of the field.
	 *
	 * @return Field
	 */
	public function field( string $id, string $title ): Field {
		$field = Field::factory( $id, $title );
		$this->fields[] = $field;

		return $field;
	}


	/**
	 * Manually add a Field to this section.
	 *
	 * Used to change the `Section` instead of the `Field`.
	 *
	 * @see Section::field()
	 *
	 * @param Field $field - Field to add to the section.
	 *
	 * @return Section
	 */
	public function add_field( Field $field ): Section {
		$this->fields[] = $field;
		return $this;
	}


	/**
	 * Additional arguments supported by `add_settings_section`
	 *
	 * Passing a `section_class` will add a class to the section
	 * if the `before_section` includes a `sprintf` placeholder `%s`.
	 *
	 * @phpstan-param \Partial<SECTION_ARGS> $args
	 *
	 * @param array                          $args - Additional arguments.
	 *
	 * @return Section
	 */
	public function args( array $args ): Section {
		$this->args = $args;
		return $this;
	}


	/**
	 * Description for the section.
	 *
	 * @param string $description - Description.
	 *
	 * @return Section
	 */
	public function description( string $description ): Section {
		$this->description = $description;
		return $this;
	}


	/**
	 * Get the fields for this section.
	 *
	 * @interal
	 *
	 * @return Field[]
	 */
	public function get_fields(): array {
		return $this->fields;
	}


	/**
	 * Optionally render a description if one is set.
	 *
	 * @interal
	 *
	 * @return void
	 */
	public function render_description(): void {
		if ( isset( $this->description ) ) {
			echo '<p>' . wp_kses_post( $this->description ) . '</p>';
		}
	}


	/**
	 * Build a new settings section to be returned by `Settings::get_sections()`.
	 *
	 * @see Settings::get_sections()
	 *
	 * @param string $id    - Unique ID for this section.
	 * @param string $title - Title of the section.
	 */
	public static function factory( string $id, string $title ): Section {
		return new Section( $id, $title );
	}
}
