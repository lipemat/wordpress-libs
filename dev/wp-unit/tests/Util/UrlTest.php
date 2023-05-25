<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

/**
 * @author Mat Lipe
 * @since  May 2023
 *
 */
class UrlTest extends \WP_UnitTestCase {

	public function test_get_current_url() : void {
		$_SERVER['REQUEST_URI'] = '/login/?redirect_to=http://test.loc/feedback/consequatur-quia-iusto-omnis-enim-aut';
		$_SERVER['HTTP_HOST'] = 'test.loc';

		$this->assertEquals( 'http://test.loc/login/?redirect_to=http://test.loc/feedback/consequatur-quia-iusto-omnis-enim-aut', Url::in()->get_current_url() );
		$this->assertEquals( 'http://test.loc/login/', Url::in()->get_current_url( false ) );

		$_SERVER['HTTPS'] = 'on';
		$this->assertEquals( 'https://test.loc/login/', Url::in()->get_current_url( false ) );
	}
}
