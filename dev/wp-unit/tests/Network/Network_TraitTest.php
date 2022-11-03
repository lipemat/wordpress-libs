<?php

namespace Lipe\Project\Network;

use Lipe\Lib\Network\Network_Trait;

/**
 * @author Mat Lipe
 * @since  August 2020
 *
 */
class Network_TraitTest extends \WP_UnitTestCase {

	public function test_interactions() : void {
		if ( \function_exists( 'wpe_oc_staging_delete' ) ) {
			$this->markTestSkipped( 'We cannot test network options on WPE due to cache clearing issues.' );
		}

		$class = new class( 1 ) implements \ArrayAccess {
			use Network_Trait;
		};
		$o = $class::factory( 1 );
		$o['nx1'] = [ 'out' ];
		$this->assertEquals( [ 'out' ], get_network_option( 1, 'nx1' ) );
		$this->assertEquals( [ 'out' ], $o['nx1'] );
		$o->update_meta( 'nx1', function( $old ) {
			$old[] = 'extra';
			return $old;
		} );
		$this->assertEquals( [ 'out', 'extra' ], get_network_option( 1, 'nx1' ) );
		$this->assertEquals( [ 'out', 'extra' ], $o['nx1'] );

		unset( $o['nx1'] );
		$this->assertEquals( false, get_network_option( 1, 'nx1' ) );
		$this->assertEquals( false, $o['nx1'] );
		$this->assertEquals( 'zoop', $o->get_meta( 'nx1', 'zoop' ) );

		$o->update_meta( 'nx1', function ( $old ) {
			$this->assertEquals( 'defaulted-x', $old );
			return 'back-again';
		}, 'defaulted-x' );
		$this->assertEquals( 'back-again', $o->get_meta( 'nx1', 'zoop' ) );
	}
}
