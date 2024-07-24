<?php
/** @noinspection PhpInternalEntityUsedInspection */
declare( strict_types=1 );

namespace Lipe\Lib\Settings;

use Lipe\Lib\Settings\Settings_Page\Field;
use Lipe\Lib\Settings\Settings_Page\SectionArgs;
use Lipe\Lib\Settings\Settings_Page\Settings;
use mocks\Settings_Page_Mock;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @author Mat Lipe
 * @since  June 2024
 *a
 */
class Settings_PageTest extends \WP_UnitTestCase {
	public const NAME = 'testing/anon/mock-settings';


	protected function setUp(): void {
		parent::setUp();
		\WP_Screen::get( 'site' )->set_current_screen();
		wp_set_current_user( self::factory()->user->create( [
			'role' => 'administrator',
		] ) );
	}


	public function test_hook(): void {
		unset( $GLOBALS['current_screen'] );
		remove_all_actions( 'admin_menu' );
		remove_all_actions( 'network_admin_menu' );
		$this->assertFalse( has_action( 'admin_menu' ) );
		$actions_count = \count( $GLOBALS['wp_filter'] );

		Settings_Page::factory( new Settings_Page_Mock( false ) );
		$this->assertFalse( has_action( 'admin_menu' ) );

		\WP_Screen::get( 'site' )->set_current_screen();
		$settings = Settings_Page::factory( new Settings_Page_Mock( false ) );
		$settings->init();
		$this->assertSame( 10, has_action( 'admin_menu', [ $settings, 'register' ] ) );
		$this->assertCount( $actions_count + 1, $GLOBALS['wp_filter'] );

		$this->assertFalse( has_action( 'network_admin_menu' ) );
		$actions_count = \count( $GLOBALS['wp_filter'] );

		$network = Settings_Page::factory( new Settings_Page_Mock( true ) );
		$network->init();
		$this->assertSame( 10, has_action( 'network_admin_menu', [ $network, 'register' ] ) );
		$this->assertSame( 10, has_action( 'network_admin_edit_' . self::NAME, [ $network, 'save_network_settings' ] ) );
		$this->assertCount( $actions_count + 2, $GLOBALS['wp_filter'] );

		do_action( 'network_admin_menu' );
		$this->assertSame( 10, has_action( 'admin_page_' . self::NAME, [ $network, 'render' ] ) );
	}


	public function test_register(): void {
		global $menu, $submenu, $_registered_pages, $_parent_pages, $_wp_submenu_nopriv;
		$settings = Settings_Page::factory( new Settings_Page_Mock( false ) );
		$this->assertNull( $submenu );
		$this->assertNull( $_wp_submenu_nopriv );

		// Init has not been called.
		do_action( 'admin_menu' );
		$this->assertNull( $submenu );
		$this->assertNull( $_wp_submenu_nopriv );

		$settings->init();
		do_action( 'admin_menu' );
		$this->assertSame( [
			'options-general.php' => [
				0 => [
					0 => 'Mock Settings Page',
					1 => 'manage_options',
					2 => self::NAME,
					3 => 'Mock Settings Page',
				],
			],
		], $submenu );
		$this->assertSame( [
			'testing/anon/mock-settings' => 'options-general.php',
		], $_parent_pages );
		$this->assertSame( [
			'admin_page_' . self::NAME => true,
		], $_registered_pages );
		$this->assertSame( 10, has_action( 'admin_page_' . self::NAME, [ $settings, 'render' ] ) );

		// Parent level menu.
		$this->assertNull( $menu );
		$mocked = $this->mock_settings( false, [ 'get_parent_menu_slug' ] );
		$mocked->method( 'get_parent_menu_slug' )->willReturn( null );
		$settings = Settings_Page::factory( $mocked );
		$settings->init();
		do_action( 'admin_menu' );
		$this->assertSame( [
			4 => [
				0 => 'Mock Settings Page',
				1 => 'manage_options',
				2 => self::NAME,
				3 => 'Mock Settings Page',
				4 => 'menu-top toplevel_page_testing/anon/mock-settings',
				5 => 'toplevel_page_testing/anon/mock-settings',
				6 => 'dashicons-format-gallery',
			],
		], $menu );

		$this->assertSame( [
			'testing/anon/mock-settings' => false,
		], $_parent_pages );
		$this->assertSame( [
			'admin_page_' . self::NAME                 => true,
			'toplevel_page_testing/anon/mock-settings' => true,
		], $_registered_pages );
		$this->assertSame( 10, has_action( 'toplevel_page_' . self::NAME, [ $settings, 'render' ] ) );
	}


	public function test_get_action_url(): void {
		$standard = Settings_Page::factory( new Settings_Page_Mock( false ) );
		$this->assertSame( admin_url( 'options.php' ), call_private_method( $standard, 'get_action_url' ) );

		$html = get_echo( [ $standard, 'render' ] );
		$this->assertStringContainsString( 'action="' . admin_url( 'options.php' ) . '"', $html );

		$settings = new Settings_Page_Mock( true );
		$network = Settings_Page::factory( $settings );
		$this->assertSame( network_admin_url( 'edit.php?action=' . $settings->get_id() ), call_private_method( $network, 'get_action_url' ) );

		$html = get_echo( [ $network, 'render' ] );
		$this->assertStringContainsString( 'action="' . network_admin_url( 'edit.php?action=' . $settings->get_id() ) . '"', $html );
	}


	public function test_get_option(): void {
		$standard = Settings_Page::factory( new Settings_Page_Mock( false ) );
		$this->assertSame( 'default', $standard->get_option( 'test', 'default' ) );
		$this->assertNull( $standard->get_option( 'test' ) );
		update_site_option( 'test', 'value' );
		$this->assertSame( '', $standard->get_option( 'test', '' ) );
		$this->assertNull( $standard->get_option( 'test' ) );
		update_option( 'test', 'value' );
		$this->assertSame( 'value', $standard->get_option( 'test' ) );
		$this->assertSame( 'value', $standard->get_option( 'test', '' ) );
		update_option( 'test', [
			'one',
			'two',
		] );
		$this->assertSame( [
			'one',
			'two',
		], $standard->get_option( 'test' ) );

		delete_site_option( 'test' );
		$network = Settings_Page::factory( new Settings_Page_Mock( true ) );
		$this->assertSame( 'default', $network->get_option( 'test', 'default' ) );
		update_option( 'test', 'value' );
		$this->assertNull( $network->get_option( 'test' ) );
		$this->assertSame( '', $network->get_option( 'test', '' ) );
		update_site_option( 'test', 'value' );
		$this->assertSame( 'value', $network->get_option( 'test' ) );
		$this->assertSame( 'value', $network->get_option( 'test', '' ) );
		update_site_option( 'test', [
			'one',
			'two',
		] );
		$this->assertSame( [
			'one',
			'two',
		], $network->get_option( 'test' ) );
	}


	public function test_description(): void {
		$standard = Settings_Page::factory( new Settings_Page_Mock( false ) );

		$html = get_echo( [ $standard, 'render' ] );
		$this->assertStringContainsString( '<p class="description">', $html );
		$this->assertStringContainsString( 'Describe entire settings page', $html );

		$standard->init();
		do_action( 'admin_menu' );
		$full = get_echo( fn() => do_action( 'admin_page_' . self::NAME ) );
		$this->assertStringContainsString( '<p class="description">Describe entire settings page</p>', strip_ws_all( $full ) );

		$mocked = $this->mock_settings( false, [ 'get_description' ] );
		$mocked->method( 'get_description' )->willReturn( '' );
		$standard = Settings_Page::factory( $mocked );
		$html = get_echo( [ $standard, 'render' ] );
		$this->assertStringNotContainsString( '<p class="description">', $html );
		$this->assertStringNotContainsString( 'Describe entire settings page', $html );

		remove_all_actions( 'admin_page_' . self::NAME );
		remove_all_actions( 'admin_menu' );
		$standard->init();
		do_action( 'admin_menu' );
		$full = get_echo( fn() => do_action( 'admin_page_' . self::NAME ) );
		$this->assertStringNotContainsString( '<p class="description">', $full );
		$this->assertStringNotContainsString( 'Describe entire settings page', $full );
	}


	public function test_position(): void {
		global $menu;
		$mocked = $this->mock_settings( false, [ 'get_parent_menu_slug' ] );
		$mocked->method( 'get_parent_menu_slug' )->willReturn( null );
		Settings_Page::factory( $mocked )->init();
		do_action( 'admin_menu' );

		$this->assertSame( [
			4 => [
				0 => 'Mock Settings Page',
				1 => 'manage_options',
				2 => self::NAME,
				3 => 'Mock Settings Page',
				4 => 'menu-top toplevel_page_testing/anon/mock-settings',
				5 => 'toplevel_page_testing/anon/mock-settings',
				6 => 'dashicons-format-gallery',
			],
		], $menu );

		$menu = [];
		remove_all_actions( 'admin_menu' );
		$mocked = $this->mock_settings( false, [ 'get_parent_menu_slug', 'get_position' ] );
		$mocked->method( 'get_parent_menu_slug' )->willReturn( null );
		$mocked->method( 'get_position' )->willReturn( 2 );
		Settings_Page::factory( $mocked )->init();
		do_action( 'admin_menu' );
		$this->assertSame( [
			2 => [
				0 => 'Mock Settings Page',
				1 => 'manage_options',
				2 => self::NAME,
				3 => 'Mock Settings Page',
				4 => 'menu-top toplevel_page_testing/anon/mock-settings',
				5 => 'toplevel_page_testing/anon/mock-settings',
				6 => 'dashicons-format-gallery',
			],
		], $menu );
	}


	/**
	 * @dataProvider provideIsSettingsPage
	 */
	public function test_is_setting_page( ?string $parent, bool $network ): void {
		$mocked = $this->mock_settings( $network, [ 'get_parent_menu_slug' ] );
		$mocked->method( 'get_parent_menu_slug' )->willReturn( $parent );
		$settings_page = Settings_Page::factory( $mocked );
		$settings_page->init();
		if ( $network ) {
			do_action( 'network_admin_menu' );
		} else {
			do_action( 'admin_menu' );
		}

		$this->assertFalse( $settings_page->is_settings_page() );
		$GLOBALS['hook_suffix'] = get_plugin_page_hook( $settings_page->settings->get_id(), $parent ?? '' );
		set_current_screen();
		$this->assertTrue( $settings_page->is_settings_page() );
	}


	public function test_render(): void {
		$standard = Settings_Page::factory( new Settings_Page_Mock( false ) );

		$html = get_echo( [ $standard, 'render' ] );
		$this->assertStringContainsString( '<h1>Mock Settings Page</h1>', $html );
		$this->assertStringContainsString( '<form method="post" action="' . admin_url( 'options.php' ) . '">', $html );
		$this->assertStringContainsString( '<input type="hidden" name="action" value="update" />', $html );
		$this->assertStringContainsString( "<input type='hidden' name='option_page' value='" . self::NAME . "' />", $html );
		$this->assertStringContainsString( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />', $html );

		$standard->init();
		do_action( 'admin_menu' );
		$full = get_echo( fn() => do_action( 'admin_page_' . self::NAME ) );
		$this->assertSame( $html, $full );

		remove_all_actions( 'admin_page_' . self::NAME );
		$network = Settings_Page::factory( new Settings_Page_Mock( true ) );
		$html = get_echo( [ $network, 'render' ] );
		$this->assertStringContainsString( '<form method="post" action="' . network_admin_url( 'edit.php?action=' . self::NAME ) . '">', $html );
		$this->assertStringContainsString( '<input type="hidden" name="action" value="update" />', $html );
		$this->assertStringContainsString( "<input type='hidden' name='option_page' value='" . self::NAME . "' />", $html );
		$this->assertStringContainsString( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />', $html );

		$network->init();
		do_action( 'network_admin_menu' );
		$full = get_echo( fn() => do_action( 'admin_page_' . self::NAME ) );
		$this->assertSame( $html, $full );
	}


	public function test_render_field(): void {
		$standard = Settings_Page::factory( new Settings_Page_Mock( false ) );
		$standard->init();
		do_action( 'admin_menu' );
		$full = get_echo( fn() => do_action( 'admin_page_' . self::NAME ) );
		$this->assertStringContainsString( '<input type="text" name="first/section/first" value="" class="regular-text" />', $full );
		$this->assertStringContainsString( '<input type="text" name="first/section/second" value="" class="regular-text" />', $full );
		$this->assertStringContainsString( '<input type="text" name="second/section/first" value="" class="regular-text" />', $full );
		$this->assertStringContainsString( '<input type="text" name="second/section/second" value="" class="regular-text" />', $full );

		$standard->settings->get_sections()[0]->get_fields()[0]->render_callback( function( Field $field ): void {
			echo '<input type="url" name="' . $field->id . '" value="custom" class="custom" />';
		} );
		$full = get_echo( fn() => do_action( 'admin_page_' . self::NAME ) );
		$this->assertStringContainsString( '<input type="url" name="first/section/first" value="custom" class="custom" />', $full );
		$this->assertStringNotContainsString( '<input type="text" name="first/section/first" value="" class="regular-text" />', $full );
		$this->assertStringContainsString( '<input type="text" name="first/section/second" value="" class="regular-text" />', $full );
		$this->assertStringContainsString( '<input type="text" name="second/section/first" value="" class="regular-text" />', $full );
		$this->assertStringContainsString( '<input type="text" name="second/section/second" value="" class="regular-text" />', $full );

		$field = $standard->settings->get_sections()[0]->get_fields()[1];
		$html = get_echo( fn() => $field->render( $standard ) );
		$this->assertSame( '<input type="text" name="first/section/second" value="" class="regular-text" />', $html );

		$field->help( 'This is a help message' );
		$html = get_echo( fn() => $field->render( $standard ) );
		$this->assertStringContainsString( '<input type="text" name="first/section/second" value="" class="regular-text" />', $html );
		$this->assertStringContainsString( '<p class="description help">This is a help message</p>', strip_ws_all( $html ) );

		$field->render_callback( function( Field $field, Settings_Page $settings ): void {
			?>
			<input
				type="url"
				class="<?= $field->args->class ?>"
				name="<?= $field->id ?>"
				value="<?= wp_json_encode( $field->args ) ?>"
				settings="<?= $settings->settings->get_id() ?>"
			/>
			<?php
		} );
		$field->class( 'more-text' );
		$field->label_for( 'no-label' );
		$html = get_echo( fn() => $field->render( $standard ) );
		$this->assertSame( '<input type="url" class="more-text" name="first/section/second" value="{"label_for":"no-label","class":"more-text"}" settings="testing/anon/mock-settings" /><p class="description help">This is a help message</p>', strip_ws_all( $html ) );
		$this->assertSame( 'This is a help message', get_private_property( $field, 'help' ) );
	}


	public function test_icon(): void {
		global $menu;
		$mocked = $this->mock_settings( false, [ 'get_parent_menu_slug', 'get_icon' ] );
		$mocked->method( 'get_parent_menu_slug' )->willReturn( null );
		$mocked->method( 'get_icon' )->willReturn( 'dashicons-format-gallery' );
		Settings_Page::factory( $mocked )->init();
		do_action( 'admin_menu' );

		$this->assertSame( [
			4 => [
				0 => 'Mock Settings Page',
				1 => 'manage_options',
				2 => self::NAME,
				3 => 'Mock Settings Page',
				4 => 'menu-top toplevel_page_testing/anon/mock-settings',
				5 => 'toplevel_page_testing/anon/mock-settings',
				6 => 'dashicons-format-gallery',
			],
		], $menu );

		$html = get_echo( function() {
			require_once ABSPATH . 'wp-admin/menu-header.php';
		} );
		$this->assertStringContainsString( "<a href='admin.php?page=testing/anon/mock-settings' class=\"wp-first-item wp-not-current-submenu menu-top toplevel_page_testing/anon/mock-settings\" ><div class=\"wp-menu-arrow\"><div></div></div><div class='wp-menu-image dashicons-before dashicons-format-gallery' aria-hidden='true'><br /></div><div class='wp-menu-name'>Mock Settings Page</div></a>", $html );
	}


	public function test_capability(): void {
		global $submenu, $_wp_submenu_nopriv;
		wp_set_current_user( 0 );
		$mocked = $this->mock_settings( false, [ 'get_capability' ] );
		$mocked->method( 'get_capability' )->willReturn( 'manage_options' );
		Settings_Page::factory( $mocked )->init();

		$this->assertNull( $submenu );
		$this->assertNull( $_wp_submenu_nopriv );

		do_action( 'admin_menu' );
		$this->assertSame( [
			'options-general.php' =>
				[
					self::NAME => true,
				],
		], $_wp_submenu_nopriv );

		wp_set_current_user( self::factory()->user->create( [
			'role' => 'editor',
		] ) );
		do_action( 'admin_menu' );
		$this->assertNull( $submenu );

		// Change capability to edit_posts.
		$mocked = $this->mock_settings( false, [ 'get_capability' ] );
		$mocked->method( 'get_capability' )->willReturn( 'edit_posts' );
		Settings_Page::factory( $mocked )->init();
		do_action( 'admin_menu' );

		$this->assertSame( [
			'options-general.php' => [
				0 => [
					0 => 'Mock Settings Page',
					1 => 'edit_posts',
					2 => self::NAME,
					3 => 'Mock Settings Page',
				],
			],
		], $submenu );
	}


	public function test_save_network_settings(): void {
		$settings = $this->mock_settings( true, [ 'get_parent_menu_slug' ] );
		$settings->method( 'get_parent_menu_slug' )->willReturn( 'settings.php' );
		$network = Settings_Page::factory( $settings );
		$redirected = '';
		add_filter( 'wp_redirect', function( $url ) use ( &$redirected ) {
			$redirected = $url;
			return false;
		}, 999 );

		$_POST['first/section/first'] = 'one';
		$_POST['first/section/second'] = 'two';
		$_POST['second/section/first'] = 'three';
		$_POST['second/section/second'] = 'four';

		$network->save_network_settings();
		$this->assertFalse( get_site_option( 'first/section/first' ) );
		$this->assertFalse( get_site_option( 'first/section/second' ) );
		$this->assertFalse( get_site_option( 'second/section/first' ) );
		$this->assertFalse( get_site_option( 'second/section/second' ) );

		$nonce_fields = get_echo( fn() => settings_fields( $settings->get_id() ) );
		preg_match( '/<input[^>]+name="_wpnonce"[^>]+value="([^"]*)"/', $nonce_fields, $nonce );

		$_POST['_wpnonce'] = $nonce[1];
		$network->save_network_settings();

		$this->assertSame( network_admin_url( 'settings.php?page=' . $settings->get_id() . '&settings-updated=true' ), $redirected );
		$this->assertSame( 'one', get_site_option( 'first/section/first' ) );
		$this->assertSame( 'two', get_site_option( 'first/section/second' ) );
		$this->assertSame( 'three', get_site_option( 'second/section/first' ) );
		$this->assertSame( 'four', get_site_option( 'second/section/second' ) );

		$settings = $this->mock_settings( true, [ 'get_parent_menu_slug' ] );
		$settings->method( 'get_parent_menu_slug' )->willReturn( null );
		$network = Settings_Page::factory( $settings );
		$network->save_network_settings();
		$this->assertSame( network_admin_url( 'admin.php?page=' . $settings->get_id() . '&settings-updated=true' ), $redirected );

		$_POST['first/section/first'] = [ 'one', 'more' ];
		$_POST['second/section/second'] = [ 'keyed' => 'four' ];
		$network->save_network_settings();
		$this->assertSame( [ 'one', 'more' ], get_site_option( 'first/section/first' ) );
		$this->assertSame( 'two', get_site_option( 'first/section/second' ) );
		$this->assertSame( 'three', get_site_option( 'second/section/first' ) );
		$this->assertSame( [ 'keyed' => 'four' ], get_site_option( 'second/section/second' ) );

		$this->assertSame( [ 'one', 'more' ], $network->get_option( 'first/section/first' ) );
		$this->assertSame( 'two', $network->get_option( 'first/section/second' ) );
		$this->assertSame( 'three', $network->get_option( 'second/section/first' ) );
		$this->assertSame( [ 'keyed' => 'four' ], $network->get_option( 'second/section/second' ) );
	}


	public function test_display_status_messages(): void {
		$mock = Settings_Page::factory( new Settings_Page_Mock( false ) );
		get_echo( [ $mock, 'render' ] );
		$this->assertEmpty( get_echo( fn() => call_private_method( $mock, 'display_status_messages' ) ) );

		$_GET['settings-updated'] = 'true';
		get_echo( [ $mock, 'render' ] );
		$this->assertSame( "<div id='setting-error-testing/anon/mock-settings' class='notice notice-success settings-error is-dismissible'> <p><strong>Settings Saved</strong></p></div> <div id='setting-error-testing/anon/mock-settings' class='notice notice-success settings-error is-dismissible'> <p><strong>Settings Saved</strong></p></div>", strip_ws_all( get_echo( fn() => call_private_method( $mock, 'display_status_messages' ) ) ) );
	}


	public function test_section_extras(): void {
		$mock = Settings_Page::factory( new Settings_Page_Mock( false ) );
		$mock->settings->get_sections()[0]->args->merge( new SectionArgs( [
			'before_section' => '<div>before',
			'after_section'  => 'after</div>',
			'section_class'  => 'section-class',
		] ) );
		$mock->register();
		$html = get_echo( [ $mock, 'render' ] );
		$this->assertStringContainsString( '<div>before<h2>First Section</h2>', $html );
		$this->assertStringContainsString( 'after</div><h2>Second Section</h2>', $html );
		$this->assertStringNotContainsString( 'section-class', $html );

		$mock->settings->get_sections()[0]->args->merge( new SectionArgs( [
			'before_section' => '<div class="%s">before',
			'after_section'  => 'after</div>',
			'section_class'  => 'section-class',
		] ) );
		$mock->register();
		$html = get_echo( [ $mock, 'render' ] );
		$this->assertStringContainsString( '<div class="section-class">before<h2>First Section</h2>', $html );
		$this->assertStringContainsString( 'after</div><h2>Second Section</h2>', $html );
		$this->assertStringContainsString( 'section-class', $html );
	}


	/**
	 * @noinspection PhpVoidFunctionResultUsedInspection
	 *
	 * @dataProvider provideFieldExtras
	 */
	public function test_field_extras( array $args, string $expected ): void {
		$mock = Settings_Page::factory( new Settings_Page_Mock( false ) );
		$field = $mock->settings->get_sections()[0]->get_fields()[0];
		foreach ( $args as $key => $value ) {
			$field->$key( $value );
		}
		$mock->register();
		$html = get_echo( [ $mock, 'render' ] );
		$this->assertStringContainsString( $expected, strip_ws_all( $html ) );
	}


	/**
	 * @param bool  $is_network
	 * @param array $methods_to_mock
	 *
	 * @return Settings|MockObject
	 */
	private function mock_settings( bool $is_network, array $methods_to_mock ): Settings|MockObject {
		return $this->getMockBuilder( Settings_Page_Mock::class )
		            ->setConstructorArgs( [ $is_network ] )
		            ->onlyMethods( $methods_to_mock )
		            ->getMock();
	}


	public static function provideFieldExtras(): array {
		return [
			'default'             => [
				'args'     => [],
				'expected' => '<tr><th scope="row">First a First</th><td><input type="text" name="first/section/first" value="" class="regular-text" /></td></tr>',
			],
			'class-only'          => [
				'args'     => [
					'class' => 'field-class',
				],
				'expected' => '<tr class="field-class"><th scope="row">First a First</th><td><input type="text" name="first/section/first" value="" class="regular-text" /></td></tr>',
			],
			'label-for-only'      => [
				'args'     => [
					'label_for' => 'you-of-course',
				],
				'expected' => '<tr><th scope="row"><label for="you-of-course">First a First</label></th><td><input type="text" name="first/section/first" value="" class="regular-text" /></td></tr>',
			],
			'class-and-label-for' => [
				'args'     => [
					'label_for' => 'you-of-course',
					'class'     => 'field-class',
				],
				'expected' => '<tr class="field-class"><th scope="row"><label for="you-of-course">First a First</label></th><td><input type="text" name="first/section/first" value="" class="regular-text" /></td></tr>',
			],
		];
	}


	public static function provideIsSettingsPage(): array {
		return [
			'top-level'   => [
				'parent'  => null,
				'network' => false,
			],
			'sub-menu'    => [
				'parent'  => 'plugins.php',
				'network' => false,
			],
			'network'     => [
				'parent'  => null,
				'network' => true,
			],
			'network-sub' => [
				'parent'  => 'themes.php',
				'network' => true,
			],
		];
	}
}
