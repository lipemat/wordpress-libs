<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

use Lipe\WP_Unit\Utils\PrivateAccess;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresMethod;

#[CoversClass( Lucide::class )]
#[RequiresMethod( \WP_Icons_Registry::class, 'get_instance' )]
final class LucideTest extends \WP_UnitTestCase {
	protected function tearDown(): void {
		if ( \WP_Icon_Collections_Registry::get_instance()->is_registered( 'lucide' ) ) {
			\WP_Icon_Collections_Registry::get_instance()->unregister( 'lucide' );
		}

		parent::tearDown();
	}


	public function test_cases_match_icon_map(): void {
		$icons = PrivateAccess::in()->get_private_property( Lucide::class, 'ICONS' );

		$this->assertCount( \count( $icons ), Lucide::cases(), 'Lucide enum cases should stay aligned with the embedded icon map.' );

		foreach ( Lucide::cases() as $case ) {
			$this->assertStringStartsWith( 'lucide/', $case->value, 'Lucide enum values should use the lucide/ namespace.' );
			$this->assertArrayHasKey( \str_replace( 'lucide/', '', $case->value ), $icons, 'Every Lucide enum value should resolve to embedded SVG markup.' );
		}
	}


	public function test_icon_renders_wrapped_svg_without_registration(): void {
		foreach ( Lucide::cases() as $icon ) {
			$icon_key = self::get_icon_key( $icon );
			$rendered = $icon->icon();

			$this->assertStringStartsWith( '<i', $rendered, $icon->value . ' should render as an <i> element.' );

			$svg = '<i class="lucide-icon icon-' . $icon_key . '">' . PrivateAccess::in()->call_private_method( $icon, 'get_svg' ) . '</i>';

			$this->assertEqualHTML( $svg, $icon->icon(), message: $icon->value . ' should be a proper <i><svg> icon.' );

			$this->assertStringEndsWith( '</i>', $rendered, $rendered . ' should render as an <i> element.' );
		}
	}


	public function test_icon_appends_optional_class_names(): void {
		foreach ( Lucide::cases() as $icon ) {
			$rendered = $icon->icon( 'custom-class another-class' );

			$this->assertStringStartsWith( '<i class="lucide-icon icon-' . self::get_icon_key( $icon ) . ' custom-class another-class">', $rendered, $icon->value . ' should append the icon class.' );
		}
	}


	public function test_register_registers_collection_and_icons(): void {
		Lucide::register();

		$collection = \WP_Icon_Collections_Registry::get_instance()->get_registered( 'lucide' );
		$this->assertSame( 'Lucide', $collection['label'], 'Lucide collection should use a readable label.' );

		foreach ( Lucide::cases() as $icon ) {
			$registered = \WP_Icons_Registry::get_instance()->get_registered_icon( $icon->value );

			$this->assertSame( $registered['label'], \ucwords( \str_replace( '-', ' ', \str_replace( 'lucide/', '', $icon->value ) ) ), $icon->value . ' label should match' );
		}
	}


	public function test_wp_get_icon_renders_registered_lucide_icon(): void {
		Lucide::register();

		foreach ( Lucide::cases() as $icon ) {
			$rendered = wp_get_icon( $icon->value );
			$icon_key = self::get_icon_key( $icon );

			$html = PrivateAccess::in()->call_private_method( $icon, 'get_svg' );
			$html = \str_replace( [ '<svg', '1em' ], [ '<svg aria-hidden="true" focusable="false"', '24' ], $html );

			$this->assertStringStartsWith( '<svg', $rendered, $icon->value . ' should render as an SVG element.' );
			$this->assertStringContainsString( 'class="lucide ' . $icon_key . ' ' . $icon_key . '-icon"', $rendered, $icon->value . ' should render with the expected class names.' );

			$this->assertStringContainsString( 'aria-hidden="true"', $rendered, $icon->value . ' should render with aria-hidden="true".' );

			$this->assertEqualHTML( $html, $rendered, message: $icon->value . ' should render the expected SVG markup.' );
		}
	}


	private static function get_icon_key( Lucide $icon ): string {
		return 'lucide-' . \str_replace( 'lucide/', '', $icon->value );
	}
}
