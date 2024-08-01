<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy\Taxonomy;

use Lipe\Lib\Taxonomy\Taxonomy;
use Lipe\Lib\Theme\Dashicons;

/**
 * @author Mat Lipe
 * @since  June 2024
 *
 */
class MenuTest extends \WP_UnitTestCase {
	protected function setUp(): void {
		parent::setUp();
		wp_set_current_user( self::factory()->user->create( [
			'role' => 'administrator',
		] ) );
		remove_all_actions( 'admin_menu' );
	}


	public function test_show_in_menu(): void {
		global $submenu;
		$tax = new Taxonomy( 'test', [ 'post' ] );
		$this->assertNull( $tax->register_args->show_in_menu ?? null );
		$tax->show_in_menu();
		$this->assertTrue( $tax->register_args->show_in_menu );

		do_action( 'wp_loaded' );
		$this->assertTrue( get_taxonomy( 'test' )->show_in_menu );
		do_action( 'admin_menu' );
		$this->assertEmpty( $submenu );
	}


	public function test_sub_menu(): void {
		global $submenu, $menu;
		$tax = new Taxonomy( 'test-tax', [ 'post' ] );
		$this->assertNull( $tax->register_args->show_in_menu ?? null );
		$object = $tax->show_in_menu();
		$object->sub_menu( 'tools.php', 5 );
		$this->assertFalse( $tax->register_args->show_in_menu );
		do_action( 'wp_loaded' );
		do_action( 'admin_menu' );
		$this->assertEmpty( $menu );

		$this->assertSame( [
			'tools.php' => [
				[
					0 => 'Test Taxes',
					1 => 'manage_categories',
					2 => 'edit-tags.php?taxonomy=test-tax',
					3 => 'Test Taxes',
				],
			],
		], $submenu );

		$this->assertSame( 'xxxx', call_private_method( $object, 'set_current_menu', [ 'xxxx' ] ) );
		set_current_screen( 'edit-test-tax' );
		$this->assertSame( 'edit-test-tax', get_current_screen()->id );
		$this->assertSame( 'test-tax', get_current_screen()->taxonomy );
		$this->assertSame( 'tools.php', call_private_method( $object, 'set_current_menu', [ 'xxxx' ] ) );
		$this->assertSame( 'tools.php', apply_filters( 'parent_file', 'xxxx' ) );
	}


	public function test_sub_menu_position(): void {
		global $submenu;
		add_submenu_page( 'tools.php', 'Spacer', 'Spacer', 'exist', 'spacer' );
		$tax = new Taxonomy( 'test-tax', [ 'post' ] );
		$object = $tax->show_in_menu();
		$object->sub_menu( 'tools.php', 0 );

		do_action( 'wp_loaded' );
		do_action( 'admin_menu' );

		$this->assertSame( [
			'tools.php' => [
				[
					0 => 'Test Taxes',
					1 => 'manage_categories',
					2 => 'edit-tags.php?taxonomy=test-tax',
					3 => 'Test Taxes',
				],
				[
					0 => 'Spacer',
					1 => 'exist',
					2 => 'spacer',
					3 => 'Spacer',
				],
			],
		], $submenu );

		remove_all_actions( 'admin_menu' );
		$object->sub_menu( 'tools.php', 1 );
		do_action( 'admin_menu' );

		$this->assertSame( [
			'tools.php' => [
				[
					0 => 'Test Taxes',
					1 => 'manage_categories',
					2 => 'edit-tags.php?taxonomy=test-tax',
					3 => 'Test Taxes',
				],
				[
					0 => 'Test Taxes',
					1 => 'manage_categories',
					2 => 'edit-tags.php?taxonomy=test-tax',
					3 => 'Test Taxes',
				],
				[
					0 => 'Spacer',
					1 => 'exist',
					2 => 'spacer',
					3 => 'Spacer',
				],
			],
		], $submenu );
	}


	public function test_parent_menu(): void {
		global $submenu, $menu;
		$tax = new Taxonomy( 'test-tax', [ 'post' ] );
		$this->assertNull( $tax->register_args->show_in_menu ?? null );
		$object = $tax->show_in_menu();
		$object->parent_menu();
		$this->assertFalse( $tax->register_args->show_in_menu );
		do_action( 'admin_menu' );

		$this->assertEmpty( $submenu );
		$this->assertSame( [
			[
				0 => 'Test Taxes',
				1 => 'manage_categories',
				2 => 'edit-tags.php?taxonomy=test-tax',
				3 => 'Test Taxes',
				4 => 'menu-top toplevel_page_edit-tags?taxonomy=test-tax',
				5 => 'toplevel_page_edit-tags?taxonomy=test-tax',
				6 => 'dashicons-category',
			],
		], $menu );

		$this->assertSame( 'xxxx', call_private_method( $object, 'set_current_menu', [ 'xxxx' ] ) );
		set_current_screen( 'edit-test-tax' );
		$this->assertSame( 'edit-test-tax', get_current_screen()->id );
		$this->assertSame( 'test-tax', get_current_screen()->taxonomy );
		$this->assertSame( 'edit-tags.php?taxonomy=test-tax', call_private_method( $object, 'set_current_menu', [ 'xxxx' ] ) );
		$this->assertSame( 'edit-tags.php?taxonomy=test-tax', apply_filters( 'parent_file', 'xxxx' ) );
	}


	public function test_parent_menu_position(): void {
		global $menu;
		add_menu_page( 'Spacer', 'Spacer', 'exist', 'spacer', position: 5 );
		$tax = new Taxonomy( 'test-tax', [ 'post' ] );
		$object = $tax->show_in_menu();
		$object->parent_menu( position: 5 );

		do_action( 'admin_menu' );

		$this->assertSame( [
			5         => [
				0 => 'Spacer',
				1 => 'exist',
				2 => 'spacer',
				3 => 'Spacer',
				4 => 'menu-top menu-icon-generic toplevel_page_spacer',
				5 => 'toplevel_page_spacer',
				6 => 'dashicons-admin-generic',
			],
			'5.14174' => [
				0 => 'Test Taxes',
				1 => 'manage_categories',
				2 => 'edit-tags.php?taxonomy=test-tax',
				3 => 'Test Taxes',
				4 => 'menu-top toplevel_page_edit-tags?taxonomy=test-tax',
				5 => 'toplevel_page_edit-tags?taxonomy=test-tax',
				6 => 'dashicons-category',
			],
		], $menu );

		remove_all_actions( 'admin_menu' );
		$object->parent_menu( Dashicons::MEGAPHONE, 2 );
		do_action( 'admin_menu' );

		$this->assertSame( [
			5         => [
				0 => 'Spacer',
				1 => 'exist',
				2 => 'spacer',
				3 => 'Spacer',
				4 => 'menu-top menu-icon-generic toplevel_page_spacer',
				5 => 'toplevel_page_spacer',
				6 => 'dashicons-admin-generic',
			],
			'5.14174' => [
				0 => 'Test Taxes',
				1 => 'manage_categories',
				2 => 'edit-tags.php?taxonomy=test-tax',
				3 => 'Test Taxes',
				4 => 'menu-top toplevel_page_edit-tags?taxonomy=test-tax',
				5 => 'toplevel_page_edit-tags?taxonomy=test-tax',
				6 => 'dashicons-category',
			],
			2         => [
				0 => 'Test Taxes',
				1 => 'manage_categories',
				2 => 'edit-tags.php?taxonomy=test-tax',
				3 => 'Test Taxes',
				4 => 'menu-top toplevel_page_edit-tags?taxonomy=test-tax',
				5 => 'toplevel_page_edit-tags?taxonomy=test-tax',
				6 => 'dashicons-megaphone',
			],
		], $menu );
	}
}
