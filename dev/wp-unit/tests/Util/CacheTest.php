<?php

namespace Lipe\Lib\Util;

class CacheTest extends \WP_UnitTestCase {

	private const GROUP_1 = 'group_1';
	private const GROUP_2 = 'group_2';

	private const KEY_1 = 'key_1';

	public function test_cache_groups() {
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
		sleep(1 );
		wp_cache_flush();
		$this->assertFalse( Cache::in()->get( self::KEY_1, self::GROUP_1 ), 'cache not flushing' );
		$this->assertFalse( Cache::in()->get( self::KEY_1, self::GROUP_2 ), 'cache not flushing' );

	}
}
