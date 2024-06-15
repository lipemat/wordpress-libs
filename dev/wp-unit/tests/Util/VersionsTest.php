<?php

namespace Lipe\Lib\Util;

class VersionsTest extends \WP_UnitTestCase {

	protected const KEY = 'versions/test/callable';

	public $run = 0;


	public function testOnce() {
		Versions::in()->once( self::KEY, function() {
			$this->run ++;
		} );
		call_private_method( Versions::in(), 'run_updates' );

		$this->assertEquals( 1, $this->run );

		Versions::in()->once( self::KEY, function() {
			$this->run ++;
		} );
		call_private_method( Versions::in(), 'run_updates' );

		$this->assertEquals( 1, $this->run );
	}


	public function testRun_updates(): void {
		$version = (float) Versions::in()->get_version();
		Versions::in()->add_update( $version + 1, function() {
			$this->run ++;
		} );
		call_private_method( Versions::in(), 'run_updates' );
		$this->assertEquals( 1, $this->run );

		Versions::in()->add_update( $version + 1, function() {
			$this->run ++;
		} );
		call_private_method( Versions::in(), 'run_updates' );
		$this->assertEquals( 1, $this->run );

		Versions::in()->add_update( $version - 1, function() {
			$this->run ++;
		} );
		call_private_method( Versions::in(), 'run_updates' );
		$this->assertEquals( 1, $this->run );
	}


	public function test_order(): void {
		$version = (float) Versions::in()->get_version();
		$this->run = 10;

		Versions::in()->add_update( $version + 1, function() {
			return $this->run *= 3;
		} );
		Versions::in()->add_update( "{$version}.2", function() {
			return $this->run /= 2;
		} );
		Versions::in()->add_update( "{$version}.1", function() {
			return $this->run += 2;
		} );
		call_private_method( Versions::in(), 'run_updates' );

		$this->assertEquals( 18, $this->run );
	}
}
