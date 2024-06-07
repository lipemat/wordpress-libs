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
 */
class Section {
	/**
	 * Additional arguments supported by `add_settings_section`
	 *
	 * @var SectionArgs
	 */
	public readonly SectionArgs $args;

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
	 * @param string $title - Title of the section. Use '' to hide the title.
	 */
	final protected function __construct(
		public readonly string $id,
		public readonly string $title,
	) {
		$this->args = new SectionArgs();
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
	 * HTML content to prepend to the section’s HTML output.
	 * Receives the section’s class name as %s.
	 *
	 * @param string $before_section - HTML content to prepend.
	 *
	 * @return Section
	 */
	public function before_section( string $before_section ): Section {
		$this->args->before_section = $before_section;
		return $this;
	}


	/**
	 * HTML content to append to the section’s HTML output.
	 *
	 * @param string $after_section - HTML content to append.
	 *
	 * @return Section
	 */
	public function after_section( string $after_section ): Section {
		$this->args->after_section = $after_section;
		return $this;
	}


	/**
	 * The class name to use for the section’s HTML container
	 * provided by `before_section`.
	 *
	 * @param string $section_class - Class name.
	 *
	 * @return Section
	 */
	public function section_class( string $section_class ): Section {
		$this->args->section_class = $section_class;
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
	 * @param string $title - Title of the section. Use '' to hide the title.
	 */
	public static function factory( string $id, string $title ): Section {
		return new Section( $id, $title );
	}
}
