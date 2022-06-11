<?php
namespace Lipe\Lib\Traits;

/**
 * @author Mat Lipe
 * @since  June, 2019
 *
 */
class VT_ {
	use Version;
}

class VersionTest extends \WP_UnitTestCase {

	public function test_run_for_version() : void {
		$t = new VT_();
		\call_private_method( $t, 'run_for_version', [
			function( $o, $t, $th ) {
				$this->assertEquals( 'one', $o );
				$this->assertEquals( 'two', $t );
				$this->assertEquals( 'three', $th );
			},
			'1.0.0',
			'one',
			'two',
			'three',
		] );

		$outside = \call_private_method( $t, 'run_for_version', [ '__return_true', '1.0.0' ] );
		$this->assertNull( $outside );
		$outside = \call_private_method( $t, 'run_for_version', [ '__return_true', '1.0.1' ] );
		$this->assertTrue( $outside );

		$this->expectExceptionMessage( 'You may not use the Version Trait with anonymous classes, you will have to implement what you need within your anonymous class.' );
		$this->expectException( 'BadMethodCallException' );
		$f = new class() {
			use Version;
		};
		\call_private_method( $f, 'run_for_version', [ '__return_true', '1.0.0' ] );
	}
}
