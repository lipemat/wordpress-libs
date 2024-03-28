<?php
/**
 * @author Mat Lipe
 * @since  March, 2019
 *
 */

namespace Lipe\Lib\Traits;

class MemoizeTestTrait {
	use Memoize;

	public function heavy_memo( ...$args ) {
		return $this->memoize( function( ...$passed ) {
			return [ $passed[0], microtime( true ), $passed[1] ?? null ];
		}, __METHOD__, ...$args );
	}


	public function heavy_once( ...$args ) {
		return $this->once( function( ...$passed ) {
			return [ $passed[0], microtime( true ), $passed[1] ?? null ];
		}, __METHOD__, ...$args );
	}


	public function heavy_persistent( ...$args ) {
		return $this->persistent( function( ...$passed ) {
			return [ $passed[0], microtime( true ), $passed[1] ?? null ];
		}, __METHOD__, 0, ...$args );
	}


	public function get_key( string $identifier, array $args ): string {
		return $this->get_cache_key( $identifier, $args );
	}
}

class MemoizeTest extends \WP_UnitTestCase {
	/**
	 * @var MemoizeTestTrait
	 */
	private $trait;


	public function setUp(): void {
		$this->trait = new MemoizeTestTrait();

		parent::setUp();
	}


	public function test_memoize_method(): void {
		$first = $this->trait->heavy_memo( [ 'first' ] )[1];
		$this->assertEquals( [ 'first' ], $this->trait->heavy_memo( [ 'first' ] )[0] );
		$this->assertEquals( 'chair', $this->trait->heavy_memo( 'purse', 'chair' )[2] );

		$this->assertEquals( $first, $this->trait->heavy_memo( [ 'first' ] )[1] );
		$this->assertNotEquals( $first, $this->trait->heavy_memo( 'second' )[1] );
		$third = $this->trait->heavy_memo( [ 'third', 'one' ] )[1];
		$this->assertNotEquals( $first, $third );
		$this->assertEquals( $third, $this->trait->heavy_memo( [ 'third', 'one' ] )[1] );
		$this->assertEquals( $first, $this->trait->heavy_memo( [ 'first' ] )[1] );
	}


	public function test_memoize_with_clousures(): void {
		$closure_false = fn() => false;
		$closure_true = fn() => true;
		$closure_1 = $this->trait->heavy_memo( [ 'close', $closure_false ] )[1];
		$this->assertFalse( $this->trait->heavy_memo( [ 'close', $closure_false ] )[0][1]() );
		$closure_2 = $this->trait->heavy_memo( [ 'close', $closure_true ] )[1];
		$this->assertNotEquals( $closure_1, $closure_2 );
		$this->assertEquals( $closure_1, $this->trait->heavy_memo( [ 'close', $closure_false ] )[1] );
		$this->assertTrue( $this->trait->heavy_memo( [ 'close', $closure_true ] )[0][1]() );
		$this->assertEquals( $closure_2, $this->trait->heavy_memo( [ 'close', $closure_true ] )[1] );

		$closure_3 = $this->trait->heavy_memo( [ $closure_false ] )[1];
		$this->assertFalse( $this->trait->heavy_memo( [ $closure_false ] )[0][0]() );
		$this->assertEquals( $closure_3, $this->trait->heavy_memo( [ $closure_false ] )[1] );
		$closure_4 = $this->trait->heavy_memo( [ $closure_true ] )[1];
		$this->assertNotEquals( $closure_3, $closure_4 );
		$this->assertNotEquals( $closure_3, $this->trait->heavy_memo( [ $closure_true ] )[1] );
		$this->assertTrue( $this->trait->heavy_memo( [ $closure_true ] )[0][0]() );
		$this->assertNotEquals( $closure_3, $this->trait->heavy_memo( [ $closure_true ] )[1] );
	}


	public function test_once_method(): void {
		$first = $this->trait->heavy_once( 'purse', 'chair' );
		$this->assertEquals( 'chair', $first[2] );
		$this->assertEquals( $first, $this->trait->heavy_once( [ 'first' ] ) );
		$this->assertEquals( $first, $this->trait->heavy_once( 'second' ) );
		$third = $this->trait->heavy_once( [ 'third', 'one' ] );
		$this->assertEquals( $first, $third );

		$this->trait->clear_memoize_cache();
		$this->assertNotEquals( $first, $this->trait->heavy_once( [ 'first' ] ) );
	}


	public function test_persistent_method(): void {
		$first = $this->trait->heavy_persistent( [ 'purse' ] )[1];
		$this->assertEquals( [ 'purse' ], $this->trait->heavy_persistent( [ 'purse' ] )[0] );
		$this->assertEquals( 'chair', $this->trait->heavy_persistent( 'purse', 'chair' )[2] );

		$this->assertEquals( $first, $this->trait->heavy_persistent( [ 'purse' ] )[1] );
		$this->assertNotEquals( $first, $this->trait->heavy_persistent( 'second' )[1] );
		$third = $this->trait->heavy_persistent( [ 'third', 'one' ] )[1];
		$this->assertNotEquals( $first, $third );
		$this->assertEquals( $third, $this->trait->heavy_persistent( [ 'third', 'one' ] )[1] );
		$this->assertEquals( [ 'third', 'one' ], $this->trait->heavy_persistent( [ 'third', 'one' ] )[0] );
		$this->assertEquals( $first, $this->trait->heavy_persistent( [ 'purse' ] )[1] );

		$this->trait->clear_memoize_cache();
		$this->assertNotEquals( $third, $this->trait->heavy_persistent( [ 'third', 'one' ] )[1] );
		$this->assertNotEquals( $first, $this->trait->heavy_persistent( [ 'purse' ] )[1] );

		$first = $this->trait->heavy_persistent( [ 'purse' ] )[1];
		$this->assertEquals( $first, $this->trait->heavy_persistent( [ 'purse' ] )[1] );

		\wp_cache_flush();
		$this->assertNotEquals( $first, $this->trait->heavy_persistent( [ 'purse' ] )[1] );

		$other = new class {
			use Memoize;

			public function heavy_persistent( ...$args ) {
				return $this->persistent( function( ...$passed ) {
					return [ $passed[0], microtime( true ), $passed[1] ?? null ];
				}, 'heavy_persistent', 0, ...$args );
			}
		};
		$second = $other->heavy_persistent( [] );
		$this->trait->clear_memoize_cache();
		$this->assertEquals( $second, $other->heavy_persistent( [] ), 'Caches are being cleared on other classes.' );
	}


	public function test_clear_single_item(): void {
		$once = $this->trait->heavy_once( 'purse', 'chair' );
		$mem = $this->trait->heavy_memo( [ 'first' ] );
		$persist = $this->trait->heavy_persistent( [ 'persist' ] );
		$this->assertEquals( $persist, $this->trait->heavy_persistent( [ 'persist' ] ) );
		$this->assertEquals( $mem, $this->trait->heavy_memo( [ 'first' ] ) );
		$this->assertEquals( $once, $this->trait->heavy_once( [ 'not-related' ] ) );

		// Clear a once item.
		$this->trait->clear_single_item( MemoizeTestTrait::class . '::heavy_once', [ 'purse', 'chair' ] );
		$this->assertTrue( $this->trait->heavy_once( true )[0] );
		$this->assertEquals( $persist, $this->trait->heavy_persistent( [ 'persist' ] ) );
		$this->assertEquals( $mem, $this->trait->heavy_memo( [ 'first' ] ) );

		// Clear a persistent item.
		$this->trait->clear_single_item( MemoizeTestTrait::class . '::heavy_persistent', [ 'persist' ] );
		$new_persist = $this->trait->heavy_persistent( [ 'persist' ] );
		$this->assertNotEquals( $persist, $new_persist );
		$this->assertTrue( $this->trait->heavy_once( false )[0] );
		$this->assertEquals( $mem, $this->trait->heavy_memo( [ 'first' ] ) );

		// Clear a memoize item.
		$this->trait->clear_single_item( MemoizeTestTrait::class . '::heavy_memoize', [ 'first' ] );
		$this->assertEquals( $new_persist, $this->trait->heavy_persistent( [ 'persist' ] ) );
		$this->assertTrue( $this->trait->heavy_once( false )[0] );
		$this->assertTrue( true, $this->trait->heavy_memo( true )[0] );
	}


	public function test_get_cache_key(): void {
		$this->assertEquals( 'www', $this->trait->get_key( 'www', [] ) );
		$this->assertEquals( 'www', $this->trait->get_key( 'www', [ [] ] ) );

		$HASH = fn( $identifier, $args ) => \hash( 'fnv1a64', wp_json_encode( [ $args, $identifier ] ) );

		$this->assertEquals( $HASH( 'www', [ [], [] ] ), $this->trait->get_key( 'www', [ [], [] ] ) );
		$this->assertEquals( $HASH( 'www', [ [], 'random' ] ), $this->trait->get_key( 'www', [ [], 'random' ] ) );
		$this->assertEquals( $HASH( 'www', [ 34, 'random' ] ), $this->trait->get_key( 'www', [ 34, 'random' ] ) );
	}
}
