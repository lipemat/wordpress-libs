<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

use Lipe\WP_Unit\Utils\PrivateAccess;
use PHPUnit\Framework\Attributes\RequiresMethod;

/**
 * @author Mat Lipe
 * @since  April 2026
 *
 */
#[RequiresMethod( \WP_Icons_Registry::class, 'get_instance' )]
class IconsTest extends \WP_UnitTestCase {
	protected function tearDown(): void {
		_wp_register_default_icons();

		parent::tearDown();
	}


	public function test_cases_up_to_date(): void {
		$icons = \WP_Icons_Registry::get_instance()->get_registered_icons();
		$this->assertCount( \count( $icons ), Icons::cases(), 'Icon cases are not up to date.' );
		foreach ( $icons as $icon ) {
			$this->assertNotNull( Icons::tryFrom( $icon['name'] ), \sprintf( 'Icon %s is not registered.', $icon['name'] ) );
		}
	}


	public function test_icon(): void {
		foreach ( Icons::cases() as $icon ) {
			$config = PrivateAccess::in()->call_private_method( $icon, 'get_icon_config' );
			$class = 'icon-' . \str_replace( '/', '-', $icon->value );

			$svg = \file_get_contents( $config['path'] );
			$svg = PrivateAccess::in()->call_private_method( \WP_Icons_Registry::get_instance(), 'sanitize_icon_content', [ $svg ] );

			$html = '<i class="wp-core-icon ' . $class . '">' . \str_replace( [ "\n", "\t" ], '', $svg ) . '</i>';

			$this->assertEqualHTML( $html, $icon->icon() );
		}
	}


	public function test_icon_not_found(): void {
		$this->expectDoingItWrong( 'Lipe\Lib\Theme\Icons::get_icon_config', 'Icon core/verse not found. (This message was added in version 6.0.0.)' );

		$all = PrivateAccess::in()->get_private_property( \WP_Icons_Registry::get_instance(), 'registered_icons' );
		unset( $all['core/verse'] );
		PrivateAccess::in()->set_private_property( \WP_Icons_Registry::get_instance(), 'registered_icons', $all );

		Icons::VERSE->icon();
	}


	public function test_svg_url(): void {
		foreach ( Icons::cases() as $icon ) {
			$config = PrivateAccess::in()->call_private_method( $icon, 'get_icon_config' );
			$this->assertNotEmpty( $config['path'], $icon->value . ' should have a valid path.' );

			$url = site_url( \str_replace( wp_normalize_path( ABSPATH ), '', wp_normalize_path( $config['path'] ) ) );
			$svg_url = $icon->svg_url();

			$this->assertStringStartsWith( 'http://wp-libs.loc/wp-includes/images/icon-library/', $svg_url );
			$this->assertSame( $url, $icon->svg_url() );
		}
	}
}
