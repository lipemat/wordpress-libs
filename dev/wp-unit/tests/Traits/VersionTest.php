<?php
/**
 * @author Mat Lipe
 * @since  June, 2019
 *
 */

namespace Lipe\Lib\Traits;

use Lipe\Project\User\Roles\Limited_Editor;

class VersionTest extends \WP_UnitTestCase {

	public function test_run_for_version() : void {
		$t = new Limited_Editor();
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
	}
}
