<?php

namespace Lipe\Lib\Schema;

/**
 * @author Mat Lipe
 * @since  May 2021
 *
 */
class DbTest extends \WP_UnitTestCase {
	public const COLUMNS = [
		'option_id'    => '%i',
		'option_name'  => '%s',
		'option_value' => '%s',
		'autoload'     => '%s',
	];


	private function mock_db(): Db {
		return new class extends Db {
			public const NAME    = 'options';
			public const COLUMNS = DbTest::COLUMNS;


			protected function create_table(): void {
			}


			protected function update_required(): bool {
				return false;
			}
		};
	}


	/**
	 * @dataProvider columns_data_provider
	 */
	public function test_get_paginated( $columns, $expected, $multiple ): void {
		global $wpdb;
		$results = $this->mock_db()->get_paginated( $columns, 3, 10, [
			// Arbitrary where to assure the WHERE is working.
			'option_name' => '%c%',
		] );
		$this->assertCount( 10, $results['items'] );
		if ( $multiple ) {
			if ( \is_array( $columns ) ) {
				$columns = implode( ',', $columns );
			}
			$this->assertEquals( $wpdb->get_row( "SELECT {$columns} from {$wpdb->options} WHERE `option_name` LIKE '%c%' LIMIT 20, 1" ), $results['items'][0] );
		} else {
			$this->assertEquals( $wpdb->get_var( "SELECT {$columns} from {$wpdb->options} WHERE `option_name` LIKE '%c%' LIMIT 20, 1" ), $results['items'][0] );
		}

		\array_walk( $results['items'], function( $item ) use ( $expected, $multiple ) {
			if ( $multiple ) {
				foreach ( $expected as $column ) {
					$this->assertTrue( property_exists( $item, $column ) );
				}
				$this->assertSameSize( $expected, (array) $item );
			} else {
				$this->assertIsString( $item );
			}
		} );

		$raw_count = (int) $wpdb->get_var( "SELECT count(*) FROM {$wpdb->options} WHERE `option_name` LIKE '%c%'" );
		$this->assertEquals( $raw_count, $results['total'] );
		$this->assertEquals( ceil( $raw_count / 10 ), $results['total_pages'] );
	}


	public static function columns_data_provider(): array {
		return [
			[ '*', array_keys( self::COLUMNS ), true ],
			[ 'option_name', [ 'option_name' ], false ],
			[ 'option_value,autoload', [ 'option_value', 'autoload' ], true ],
			[ [ 'option_name', 'option_value' ], [ 'option_name', 'option_value' ], true ],
		];
	}
}
