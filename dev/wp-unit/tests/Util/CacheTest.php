<?php

namespace Lipe\Lib\Util;

use PHPUnit\Framework\Attributes\DataProvider;

class CacheTest extends \WP_UnitTestCase {

	private const GROUP_1 = 'group_1';
	private const GROUP_2 = 'group_2';

	private const KEY_1 = 'key_1';


	public function test_cache_groups(): void {
		Cache::in()->set( self::KEY_1, '#1', self::GROUP_1 );
		Cache::in()->set( self::KEY_1, '#2', self::GROUP_2 );
		$this->assertEquals( '#1', Cache::in()->get( self::KEY_1, self::GROUP_1 ), 'cache not storing' );
		$this->assertEquals( '#2', Cache::in()->get( self::KEY_1, self::GROUP_2 ), 'cache not storing' );

		Cache::in()->flush_group( self::GROUP_1 );
		$this->assertFalse( Cache::in()->get( self::KEY_1, self::GROUP_1 ), 'cache not flushing' );
		$this->assertEquals( '#2', Cache::in()->get( self::KEY_1, self::GROUP_2 ), 'cache not storing' );

		Cache::in()->set( self::KEY_1, null, self::GROUP_1 );
		$this->assertNotFalse( Cache::in()->get( self::KEY_1, self::GROUP_1 ), 'cache not storing empty values' );

		Cache::in()->set( self::KEY_1, '#1', self::GROUP_1 );
		$this->assertEquals( '#1', Cache::in()->get( self::KEY_1, self::GROUP_1 ), 'cache not storing' );

		//sleep so we can increment keys which are based on time
		sleep( 1 );
		wp_cache_flush();
		$this->assertFalse( Cache::in()->get( self::KEY_1, self::GROUP_1 ), 'cache not flushing' );
		$this->assertFalse( Cache::in()->get( self::KEY_1, self::GROUP_2 ), 'cache not flushing' );
	}


	public function test_array_keys(): void {
		$key = [ 'key' => 'value' ];
		Cache::in()->set( $key, '#1', self::GROUP_1 );
		$this->assertEquals( '#1', Cache::in()->get( $key, self::GROUP_1 ), 'cache not storing' );
		Cache::in()->flush_group( self::GROUP_1 );
		$this->assertFalse( Cache::in()->get( $key, self::GROUP_1 ), 'cache not flushing' );

		Cache::in()->set( $key, '#2', self::GROUP_1 );
		$this->assertEquals( '#2', Cache::in()->get( $key, self::GROUP_1 ), 'cache not storing' );
		Cache::in()->delete( $key, self::GROUP_1 );
		$this->assertFalse( Cache::in()->get( $key, self::GROUP_1 ), 'cache not deleting' );
	}


	public function test_object_keys(): void {
		$key = (object) [ 'object-something' => 'value' ];
		Cache::in()->set( $key, '#1', self::GROUP_1 );
		$this->assertEquals( '#1', Cache::in()->get( $key, self::GROUP_1 ), 'cache not storing' );
		Cache::in()->flush_group( self::GROUP_1 );
		$this->assertFalse( Cache::in()->get( $key, self::GROUP_1 ), 'cache not flushing' );

		$class = new class() implements \JsonSerializable {
			public function jsonSerialize(): array {
				return [ 'from-json-something' => 'value' ];
			}
		};
		$key = $class;
		Cache::in()->set( $key, '#1', self::GROUP_1 );
		$this->assertEquals( '#1', Cache::in()->get( $key, self::GROUP_1 ), 'cache not storing' );
		Cache::in()->flush_group( self::GROUP_1 );
		$this->assertFalse( Cache::in()->get( $key, self::GROUP_1 ), 'cache not flushing' );

		Cache::in()->set( $key, '#1', self::GROUP_1 );
		$this->assertEquals( '#1', Cache::in()->get( $key, self::GROUP_1 ), 'cache not storing' );
		Cache::in()->delete( $key, self::GROUP_1 );
		$this->assertFalse( Cache::in()->get( $key, self::GROUP_1 ), 'cache not deleting' );
	}


	#[DataProvider( 'provideFilterKey' )]
	public function test_filter_key( object|array|int|string $key, string|int $expected ): void {
		$this->assertSame( $expected, call_private_method( Cache::in(), 'filter_key', [ $key ] ) );
	}


	public static function provideFilterKey(): array {
		$class = new class() implements \JsonSerializable {
			public function jsonSerialize(): array {
				return [ 'from-json-something' => 'value' ];
			}
		};

		return [
			'string' => [
				'key'      => 'key',
				'expected' => 'key',
			],
			'array'  => [
				'key'      => [ 'key' => 'value' ],
				'expected' => '64fe95c2c6b326760b7baaef0b928232',
			],
			'object' => [
				'key'      => (object) [ 'key' => 'value' ],
				'expected' => '64fe95c2c6b326760b7baaef0b928232',
			],
			'int'    => [
				'key'      => 1,
				'expected' => 1,
			],
			'class'  => [
				'key'      => $class,
				'expected' => 'b323fd783bb0b9d76cc7b68264f3ccc0',
			],
		];
	}
}
