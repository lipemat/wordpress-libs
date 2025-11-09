<?php
declare( strict_types=1 );
/**
 * @author  mat
 * @since   2/21/2018
 */

namespace Lipe\Lib\Util;

use Lipe\Lib\Libs\Container;

class ActionsTest extends \WP_UnitTestCase {
	public function test_container_change(): void {
		$this->assertFalse( has_action( 'arb' ) );
		$this->assertFalse( has_action( 'wombat' ) );
		$this->assertFalse( has_action( 'varb' ) );
		$this->assertFalse( has_action( 'octo' ) );
		$this->assertInstanceOf( Actions::class, Actions::in() );

		Actions::instance()->add_action_all( [ 'arb', 'wombat' ], function() {
		} );
		$this->assertTrue( has_action( 'arb' ) );
		$this->assertTrue( has_action( 'wombat' ) );

		Container::instance()->set_service( Actions::class, new class extends Actions {
			public function add_action_all( array $actions, callable $callback, int $priority = 10 ): void {
				// do nothing.
			}
		} );
		Actions::in()->add_action_all( [ 'varb', 'octo' ], function() {
		} );
		$this->assertFalse( has_action( 'varb' ) );
		$this->assertFalse( has_action( 'octo' ) );
	}


	public function test_add_single_filter(): void {
		$callable = function( $o, $t, $tr ) {
			$this->assertEquals( 'three', $tr );

			return 'filtered';
		};
		Actions::in()->add_single_filter( 'sf', $callable, 8 );

		$this->assertEquals( 'filtered', apply_filters( 'sf', 'not filtered', 'two', 'three' ) );
		$this->assertEquals( 'not filtered', apply_filters( 'sf', 'not filtered' ) );
	}


	public function test_add_single_filter_repeated(): void {
		$count = 0;
		$callable = function( $o, $t, $tr ) use ( &$count ) {
			$count ++;
			$this->assertEquals( 'three', $tr );

			return 'filtered';
		};

		Actions::in()->add_single_filter( 'single-filter/repeat', $callable, 8 );
		Actions::in()->add_single_filter( 'single-filter/repeat', $callable, 8 );
		$this->assertEquals( 'filtered', apply_filters( 'single-filter/repeat', 'not filtered', 'two', 'three' ) );
		$this->assertSame( 1, $count );

		Actions::in()->add_single_filter( 'single-filter/repeat', $callable, 8 );
		Actions::in()->add_single_filter( 'single-filter/repeat', function( $o, $t, $tr ) use ( &$count ) {
			$count ++;
			$this->assertEquals( 'three', $tr );

			return 'seconary filtered';
		} );
		$this->assertEquals( 'seconary filtered', apply_filters( 'single-filter/repeat', 'not filtered', 'two', 'three' ) );
		$this->assertSame( 2, $count );
	}


	public function test_add_single_action(): void {
		$callable = function( $t, $tr ) {
			$this->assertEquals( 'three', $tr );
			static $been_here = false;
			if ( $been_here ) {
				$this->fail( 'Action was not removed' );
			}
			$been_here = true;
		};

		Actions::in()->add_single_action( 'sa', $callable, 5 );

		do_action( 'sa', 'two', 'three' );
		do_action( 'sa', 'two', 'three' );

		$this->assertTrue( true );
	}


	public function test_add_single_action_repeated(): void {
		$count = 0;
		$callable = function( $t, $tr ) use ( &$count ) {
			$count ++;
			$this->assertEquals( 'three', $tr );
		};

		Actions::in()->add_single_action( 'single-action/repeat', $callable, 5 );
		Actions::in()->add_single_action( 'single-action/repeat', $callable, 5 );
		do_action( 'single-action/repeat', 'two', 'three' );
		$this->assertSame( 1, $count );

		Actions::in()->add_single_action( 'single-action/repeat', $callable, 5 );
		Actions::in()->add_single_action( 'single-action/repeat', function( $t, $tr ) use ( &$count ) {
			$count ++;
			$this->assertEquals( 'three', $tr );
		} );
		do_action( 'single-action/repeat', 'two', 'three' );
		$this->assertSame( 2, $count );
	}


	public function test_remove_action_always(): void {
		$callable = function() {
			$this->fail( 'Action was not removed' );
		};
		Actions::in()->remove_action_always( 'arb', $callable, 4 );
		add_action( 'arb', $callable, 4 );
		add_action( 'arb', function() {
			$this->assertTrue( true );
		}, 5 );

		do_action( 'arb' );
	}


	public function test_remove_filter_always(): void {
		$callable = function() {
			$this->fail( 'Filter was not removed' );
		};
		Actions::in()->remove_filter_always( 'arb', $callable, 6 );

		add_filter( 'arb', $callable, 6 );

		add_filter( 'arb', function( $value ) {
			$this->assertNull( $value );

			return true;
		}, 7 );

		$this->assertTrue( apply_filters( 'arb', null ) );
	}


	public function test_add_filter_during(): void {
		$callable = function( $o, $t, $tr ) {
			$this->assertEquals( 'one', $o );
			$this->assertEquals( 'three', $tr );

			return 'filtered';
		};

		Actions::in()->add_filter_during( 'afd', $callable, 'beginning', 'end' );

		do_action( 'uninvolved' );
		$this->assertEquals( 'one', apply_filters( 'afd', 'one', 'two', 'three' ) );
		do_action( 'beginning' );
		$this->assertEquals( 'filtered', apply_filters( 'afd', 'one', 'two', 'three' ) );
		do_action( 'uninvolved' );
		$this->assertEquals( 'filtered', apply_filters( 'afd', 'one', 'two', 'three' ) );
		do_action( 'end' );
		$this->assertEquals( 'one', apply_filters( 'afd', 'one', 'two', 'three' ) );
	}


	public function test_add_looping_action(): void {
		$count = 0;
		Actions::in()->add_looping_action( 'tests_loop_back', function( ...$args ) use ( &$count ) {
			$count ++;
			$this->assertEquals( [ 'one', 'two', 'three' ], $args );
			do_action( 'tests_loop_back', 'one', 'two', 'three' );
		}, 14 );

		do_action( 'tests_loop_back', 'one', 'two', 'three' );
		$this->assertEquals( 1, $count );

		do_action( 'tests_loop_back', 'one', 'two', 'three' );
		$this->assertEquals( 2, $count );
	}


	public function test_add_looping_filter(): void {
		$count = 0;
		Actions::in()->add_looping_filter( 'tests_loop_back', function( ...$args ) use ( &$count ) {
			$count ++;
			$this->assertEquals( [ 'one', 'two', 'three' ], $args );
			apply_filters( 'tests_loop_back', 'one', 'two', 'three' );
			return $count;
		}, 14 );

		$returned = apply_filters( 'tests_loop_back', 'one', 'two', 'three' );
		$this->assertEquals( 1, $count );
		$this->assertEquals( 1, $returned );

		$returned = apply_filters( 'tests_loop_back', 'one', 'two', 'three' );
		$this->assertEquals( 2, $count );
		$this->assertEquals( 2, $returned );
	}
}
