<?php

namespace Lipe\Project\Util;

use Lipe\Lib\Util\Crypt;
use PHPUnit\Framework\Attributes\DataProvider;

class CryptTest extends \WP_UnitTestCase {

	public function test_encrypt(): void {
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


	#[DataProvider( 'provideIsEncrypted' )]
	public function test_is_encrypted( string $data, bool $encrypted ): void {
		$this->assertSame( $encrypted, Crypt::is_encrypted( $data ) );
	}


	public static function provideIsEncrypted(): array {
		$crypt = Crypt::factory( 'very secret key' );
		$encrypted = $crypt->encrypt( 'Hello hi how are you? :)' );
		$array = json_decode( \base64_decode( $encrypted, true ), true );
		unset( $array['iv'] );

		return [
			'basic string'         => [ 'Hello hi how are you? :)', false ],
			'encrypted'            => [ $encrypted, true ],
			'empty string'         => [ '', false ],
			'base64'               => [ base64_encode( 'Hello hi how are you? :)' ), false ],
			'encrypted and string' => [ $encrypted . 'extra', false ],
			'missing key'          => [ base64_encode( (string) wp_json_encode( $array ) ), false ],
		];
	}
}
