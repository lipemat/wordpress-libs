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
		PrivateAccess::in()->set_private_property( \WP_Icons_Registry::get_instance(), 'instance', null );
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
		$this->assertSame( '<i class="wp-core-icon icon-core-chevron-up"><svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24"><path d="M6.5 12.4L12 8l5.5 4.4-.9 1.2L12 10l-4.5 3.6-1-1.2z" /></svg></i>', Icons::CHEVRON_UP->icon() );
		$this->assertSame( '<i class="wp-core-icon icon-core-verse"><svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24"><path d="M17.8 2l-.9.3c-.1 0-3.6 1-5.2 2.1C10 5.5 9.3 6.5 8.9 7.1c-.6.9-1.7 4.7-1.7 6.3l-.9 2.3c-.2.4 0 .8.4 1 .1 0 .2.1.3.1.3 0 .6-.2.7-.5l.6-1.5c.3 0 .7-.1 1.2-.2.7-.1 1.4-.3 2.2-.5.8-.2 1.6-.5 2.4-.8.7-.3 1.4-.7 1.9-1.2s.8-1.2 1-1.9c.2-.7.3-1.6.4-2.4.1-.8.1-1.7.2-2.5 0-.8.1-1.5.2-2.1V2zm-1.9 5.6c-.1.8-.2 1.5-.3 2.1-.2.6-.4 1-.6 1.3-.3.3-.8.6-1.4.9-.7.3-1.4.5-2.2.8-.6.2-1.3.3-1.8.4L15 7.5c.3-.3.6-.7 1-1.1 0 .4 0 .8-.1 1.2zM6 20h8v-1.5H6V20z" /></svg></i>', Icons::VERSE->icon() );
		$this->assertSame( '<i class="wp-core-icon icon-core-tip"><svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24"><path d="M12 15.8c-3.7 0-6.8-3-6.8-6.8s3-6.8 6.8-6.8c3.7 0 6.8 3 6.8 6.8s-3.1 6.8-6.8 6.8zm0-12C9.1 3.8 6.8 6.1 6.8 9s2.4 5.2 5.2 5.2c2.9 0 5.2-2.4 5.2-5.2S14.9 3.8 12 3.8zM8 17.5h8V19H8zM10 20.5h4V22h-4z" /></svg></i>', Icons::TIP->icon() );
	}


	public function test_icon_not_found(): void {
		$this->expectDoingItWrong( 'Lipe\Lib\Theme\Icons::get_icon_config', 'Icon core/verse not found. (This message was added in version 6.0.0.)' );
		$all = PrivateAccess::in()->get_private_property( \WP_Icons_Registry::get_instance(), 'registered_icons' );
		unset( $all['core/verse'] );
		PrivateAccess::in()->set_private_property( \WP_Icons_Registry::get_instance(), 'registered_icons', $all );
		Icons::VERSE->icon();
	}


	public function test_svg_url(): void {
		$this->assertSame( 'http://wp-libs.loc/wp-includes/images/icon-library/verse.svg', Icons::VERSE->svg_url() );
	}
}
