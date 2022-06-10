<?php
/**
 * @author Mat Lipe
 * @since  August, 2019
 *
 */

namespace Lipe\Project\Api;

use Lipe\Lib\Api\Api;

class ApiTest extends \WP_UnitTestCase {
	/**
	 * @var Api
	 */
	private $o;

	public function setUp() : void  {
		parent::setUp();
		$this->o = Api::in();
	}


	public function test_get_api_url() : void {
		$this->assertEquals( $this->o->get_root_url() . 'test/page/4/category/6/?' . Api::FORMAT . '=' . Api::FORMAT_ASSOC, $this->o->get_url( 'test', [
			'page'     => 4,
			'category' => 6,
		] ) );

		$this->assertEquals( $this->o->get_root_url() . 'test/page/4/category/6/', Api::in()->get_url( 'test', [
			'page',
			4,
			'category',
			6,
		] ) );

	}


	public function test_handle_request() : void {
		add_action( $this->o->get_action( __METHOD__ ), function ( $data ) {
			$this->assertSame( [
				'page'     => '4',
				'category' => '6',
			], $data );
		} );

		$_REQUEST[ Api::FORMAT ] = Api::FORMAT_ASSOC;
		$GLOBALS['wp']->set_query_var( Api::NAME, str_replace( $this->o->get_root_url(), '', $this->o->get_url( __METHOD__, [
			'page',
			4,
			'category',
			6,
		] ) ) );

		\call_private_method( $this->o, 'handle_request', [ $GLOBALS['wp'] ] );

		add_action( $this->o->get_action( __METHOD__ . 2 ), function ( $data ) {
			$this->assertSame( [
				'page',
				'4',
				'category',
				'6',
			], $data );
		} );

		unset( $_REQUEST[ Api::FORMAT ] );
		$GLOBALS['wp']->set_query_var( Api::NAME, str_replace( $this->o->get_root_url(), '', $this->o->get_url( __METHOD__ . 2 , [
			'page',
			'4',
			'category',
			'6',
		] ) ) );

		\call_private_method( $this->o, 'handle_request', [ $GLOBALS['wp'] ] );

	}
}
