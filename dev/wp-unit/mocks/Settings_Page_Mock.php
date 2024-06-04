<?php
declare( strict_types=1 );

namespace mocks;

use Lipe\Lib\Settings\Settings_Page;
use Lipe\Lib\Settings\Settings_Page\Field;
use Lipe\Lib\Settings\Settings_Page\Section;
use Lipe\Lib\Settings\Settings_Page\Settings;
use Lipe\Lib\Settings\Settings_PageTest;

/**
 * @author Mat Lipe
 * @since  June 2024
 *
 */
class Settings_Page_Mock implements Settings {
	protected array $construct_sections;


	public function __construct(
		private readonly bool $is_network
	) {
		$third = Section::factory( 'third/section', 'Third Section' );
		$third->field( 'third_field', 'Third Field' )
		      ->help( 'This is a help message' );

		$this->construct_sections = [
			Section::factory( 'first/section', 'First Section' )
			       ->add_field( Field::factory( 'first/section/first', 'First a First' ) )
			       ->add_field( Field::factory( 'first/section/second', 'First Second' ) ),
			Section::factory( 'second/section', 'Second Section' )
			       ->add_field( Field::factory( 'second/section/first', 'Second First' ) )
			       ->add_field( Field::factory( 'second/section/second', 'Second a Second' ) ),
			$third,
		];
	}


	public function get_id(): string {
		return Settings_PageTest::NAME;
	}


	public function get_title(): string {
		return 'Mock Settings Page';
	}


	public function get_parent_menu_slug(): ?string {
		return 'options-general.php';
	}


	public function get_description(): string {
		return 'Describe entire settings page';
	}


	public function get_capability(): string {
		return 'manage_options';
	}


	public function get_icon(): string {
		return 'dashicons-format-gallery';
	}


	public function get_position(): int {
		return 4;
	}


	public function get_sections(): array {
		return $this->construct_sections;
	}


	public function is_network(): bool {
		return $this->is_network;
	}
}
