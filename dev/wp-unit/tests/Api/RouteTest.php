<?php
declare( strict_types=1 );

namespace Lipe\Lib\Api;

/**
 * @author Mat Lipe
 * @since  January 2025
 *
 */
class RouteTest extends \WP_UnitTestCase {
	private const TEST_ROUTE = 'test-route';


	public function test_add(): void {
		remove_all_actions( 'init' );
		Route::init();

		$this->go_to( home_url( '/' . self::TEST_ROUTE ) );
		$this->assertFalse( Route::in()->is_current_route( self::TEST_ROUTE ) );

		Route::in()->add( self::TEST_ROUTE, [
			'title'    => 'Test Route',
			'template' => 'test-route.php',
		] );
		do_action( 'init' );

		$this->go_to( home_url( '/' . self::TEST_ROUTE ) );
		$this->assertFalse( Route::in()->is_current_route( self::TEST_ROUTE ) );

		do_action( 'wp_loaded' );
		$this->go_to( home_url( '/' . self::TEST_ROUTE ) );
		$this->assertTrue( Route::in()->is_current_route( self::TEST_ROUTE ) );

		$this->go_to( home_url( '/' . self::TEST_ROUTE . '/extra' ) );
		$this->assertTrue( Route::in()->is_current_route( self::TEST_ROUTE ) );

		$this->go_to( home_url( '/path-before/' . self::TEST_ROUTE . '/extra' ) );
		$this->assertFalse( Route::in()->is_current_route( self::TEST_ROUTE ) );
	}


	public function test_get_url_parameters(): void {
		$this->register_route();

		$this->go_to( home_url( '/' . self::TEST_ROUTE . '/extra/more/' ) );
		$this->assertTrue( Route::in()->is_current_route( self::TEST_ROUTE ) );
		$this->assertEquals( 'extra', Route::in()->get_url_parameter() );

		$this->go_to( home_url( '/' . self::TEST_ROUTE . '/another' ) );
		$this->assertTrue( Route::in()->is_current_route( self::TEST_ROUTE ) );
		$this->assertEquals( 'another', Route::in()->get_url_parameter() );

		$this->go_to( home_url( '/' . self::TEST_ROUTE ) );
		$this->assertTrue( Route::in()->is_current_route( self::TEST_ROUTE ) );
		$this->assertEquals( '', Route::in()->get_url_parameter() );
	}


	/**
	 * @link https://github.com/lipemat/wordpress-libs/pull/11
	 */
	public function test_conflicting_pages(): void {
		$page = self::factory()->post->create( [
			'post_title' => 'A Page with test in the slug',
			'post_type'  => 'page',
			'post_name'  => self::TEST_ROUTE . '-page',
		] );
		$this->register_route();

		$this->go_to( home_url( '/' . self::TEST_ROUTE . '-page' ) );
		$this->assertFalse( Route::in()->is_current_route( self::TEST_ROUTE ) );
		$this->assertNull( Route::in()->get_current_route() );

		$this->assertSame( self::TEST_ROUTE . '-page', get_query_var( 'name' ) );
		$this->assertSame( $page, get_the_ID() );

		$this->go_to( home_url( '/' . self::TEST_ROUTE ) );
		$this->assertTrue( Route::in()->is_current_route( self::TEST_ROUTE ) );
		$this->assertSame( [
			'title'    => 'Test Route',
			'template' => 'test-route.php',
		], Route::in()->get_current_route() );
	}


	private function register_route(): void {
		remove_all_actions( 'init' );
		Route::init();
		Route::in()->add( self::TEST_ROUTE, [
			'title'    => 'Test Route',
			'template' => 'test-route.php',
		] );
		do_action( 'init' );
		do_action( 'wp_loaded' );
	}
}
