<?php

namespace Lipe\Project\Util;

use Lipe\Lib\Util\Crypt;

class CryptTest extends \WP_UnitTestCase {

	public function test_encrypt() : void {
		$crypt = Crypt::factory( 'in AppContainer (created by HotExportedApp)' .
		                         'in HotExportedApp (created by ForwardRef)' .
		                         'in AppContainer (created by ForwardRef)' .
		                         'in ForwardRef (created by Context.Consumer)' .
		                         'in Route (at routes.tsx:25)' .
		                         'in Switch (at routes.tsx:24)' .
		                         'in Suspense (at routes.tsx:17)' .
		                         'in Router (created by BrowserRouter)' .
		                         'in BrowserRouter (at routes.tsx:16)' );

		$encrypted = $crypt->encrypt( 'Hello hi how are you? :)' );
		//Check for valid base64
		$this->assertMatchesRegularExpression( '/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $encrypted );

		$this->assertEquals( 'Hello hi how are you? :)', $crypt->decrypt( $encrypted ) );
	}
}
