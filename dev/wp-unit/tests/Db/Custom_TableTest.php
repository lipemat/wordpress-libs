<?php
declare( strict_types=1 );

namespace Lipe\Lib\Db;

use Lipe\Lib\Util\Arrays;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @author Mat Lipe
 * @since  May 2024
 *
 */
class Custom_TableTest extends \WP_UnitTestCase {

	public function test_update(): void {
		$v = $this->db()->get( [ 'option_name' => 'start_of_week' ], 1 )[0];

		$result = $this->db()->update( $v['option_id'], [ 'option_value' => 'monday' ] );
		$this->assertTrue( $result );
		$this->assertSame( 'monday', $this->db()->get_by_id( $v['option_id'] )['option_value'] );
		$this->assertSame( 'monday', get_option( 'start_of_week' ) );
	}


	public function test_get_table(): void {
		global $wpdb;
		$this->assertSame( $wpdb->prefix . 'options', $this->db()->table() );

		$table = new class() implements Table {
			public function get_column_formats(): array {
				return [];
			}


			public function get_id_field(): string {
				return '';
			}


			public function get_table_base(): string {
				global $wpdb;
				return $wpdb->prefix . 'custom_table';
			}
		};

		$db = Custom_Table::factory( $table );
		$this->assertSame( $wpdb->prefix . 'custom_table', $db->table() );
	}


	public function test_get_one(): void {
		$this->assertNotNull( $this->db()->add( [
			'option_name'  => 'b_option',
			'option_value' => 'shared_value',
			'autoload'     => 'yes',
		] ) );
		add_option( 'a_option', 'shared_value', '', 'no' );

		$first = $this->db()->get_one( [
			'option_value' => 'shared_value',
		] );
		$this->assertSame( 'b_option', $first['option_name'] );
		$this->assertSame( 'shared_value', $first['option_value'] );

		$second = $this->db()->get_one( [
			'option_name' => 'b_option',
		] );
		$this->assertSame( 'b_option', $second['option_name'] );
		$this->assertSame( 'shared_value', $second['option_value'] );

		// More than 1 criterion.
		$specific = $this->db()->get_one( [
			'option_value' => 'shared_value',
			'autoload'     => \version_compare( $GLOBALS['wp_version'], '6.6', '>' ) ? 'off' : 'no',
		] );
		$this->assertSame( 'a_option', $specific['option_name'] );
		$this->assertSame( 'shared_value', $specific['option_value'] );

		// Ordered
		$ordered = $this->db()->get_one( [
			'option_value' => 'shared_value',
		], null, 'DESC' );
		$this->assertSame( 'a_option', $ordered['option_name'] );

		$ordered = $this->db()->get_one( [
			'option_value' => 'shared_value',
		], null, 'ASC' );
		$this->assertSame( 'b_option', $ordered['option_name'] );

		$ordered = $this->db()->get_one( [
			'option_value' => 'shared_value',
		], 'option_name', 'ASC' );
		$this->assertSame( 'a_option', $ordered['option_name'] );

		$ordered = $this->db()->get_one( [
			'option_value' => 'shared_value',
		], 'option_name', 'DESC' );
		$this->assertSame( 'b_option', $ordered['option_name'] );
	}


	#[DataProvider( 'provideSelectQuery' )]
	public function test_get_select_query( array $columns, array $where, ?int $count, ?string $order_by, string $order, ?int $offset, string $expected ): void {
		global $wpdb;
		$query = $this->db()->get_select_query( $columns, $where, $count, $order_by, $order, $offset );
		$this->assertSame( $expected, $query );

		$this->assertNotNull( $wpdb->get_results( $query ) );
	}


	public function test_get_paginated(): void {
		$v = $this->db()->get();
		$this->assertNotEmpty( $v );

		$five = $this->db()->get_paginated( 2, 5 );
		$this->assertSame( \array_slice( $v, 5, 5 ), $five['items'] );
		$this->assertSame( \count( $v ), $five['total'] );
		$this->assertSame( (int) \ceil( \count( $v ) / 5 ), $five['total_pages'] );

		$ten = $this->db()->get_paginated( 9, 10 );
		$this->assertSame( \array_slice( $v, 8 * 10, 10 ), $ten['items'] );
		$this->assertSame( \count( $v ), $ten['total'] );
		$this->assertSame( (int) \ceil( \count( $v ) / 10 ), $ten['total_pages'] );

		// With where clauses.
		$where = $this->db()->get_paginated( 2, 5, [
			'option_name' => '%c%',
		] );
		$filtered = \array_filter( $v, fn( $row ) => \str_contains( $row['option_name'], 'c' ) );
		$this->assertSame( \array_slice( $filtered, 5, 5 ), $where['items'] );
		$this->assertSame( \count( $filtered ), $where['total'] );
		$this->assertSame( (int) \ceil( \count( $filtered ) / 5 ), $where['total_pages'] );

		// With order by.
		$where = $this->db()->get_paginated( 2, 5, [
			'option_name' => '%c%',
		], 'option_name', 'DESC' );
		$filtered = \array_filter( $v, fn( $row ) => \str_contains( $row['option_name'], 'c' ) );
		\usort( $filtered, fn( $a, $b ) => \strcmp( $b['option_name'], $a['option_name'] ) );
		$this->assertSame( \array_slice( $filtered, 5, 5 ), $where['items'] );
		$this->assertSame( \count( $filtered ), $where['total'] );
		$this->assertSame( (int) \ceil( \count( $filtered ) / 5 ), $where['total_pages'] );

		// Order by ASC
		\usort( $filtered, fn( $a, $b ) => \strcmp( $a['option_name'], $b['option_name'] ) );
		$where = $this->db()->get_paginated( 2, 5, [
			'option_name' => '%c%',
		], 'option_name' );
		$this->assertSame( \array_slice( $filtered, 5, 5 ), $where['items'] );
	}


	public function test_get(): void {
		$all = $this->db()->get();
		$this->assertNotEmpty( $all );

		// Single item.
		$single = $this->db()->get( [ 'option_name' => 'start_of_week' ], 1 );
		$this->assertCount( 1, $single );
		$this->assertSame( $single[0], Arrays::in()->find( $all, fn( $item ) => 'start_of_week' === $item['option_name'] ) );

		// Multiple items.
		$autoload = \version_compare( $GLOBALS['wp_version'], '6.6', '>' ) ? 'on' : 'yes';
		$multiple = $this->db()->get( [
			'option_name' => '%c%',
			'autoload'    => $autoload,
		], 5 );
		$this->assertCount( 5, $multiple );

		$filtered = \array_filter( $all, fn( $row ) => \str_contains( $row['option_name'], 'c' ) && $autoload === $row['autoload'] );
		$this->assertSame( \array_slice( $filtered, 0, 5 ), $multiple );

		// Order by name DESC
		$by_name = $this->db()->get( [
			'option_name' => '%c%',
			'autoload'    => $autoload,
		], 5, 'option_name', 'DESC' );
		\usort( $filtered, fn( $a, $b ) => \strcmp( $b['option_name'], $a['option_name'] ) );
		$this->assertSame( \array_slice( $filtered, 0, 5 ), $by_name );

		// Order by name ASC
		$asc = $this->db()->get( [
			'option_name' => '%c%',
			'autoload'    => $autoload,
		], 5, 'option_name', 'ASC' );
		\usort( $filtered, fn( $a, $b ) => \strcmp( $a['option_name'], $b['option_name'] ) );
		$this->assertSame( \array_slice( $filtered, 0, 5 ), $asc );
	}


	public function test_delete_where(): void {
		$id_1 = $this->db()->add( [
			'option_name'  => 'first-option',
			'option_value' => 'shared_value',
			'autoload'     => 'no',
		] );
		$id_2 = $this->db()->add( [
			'option_name'  => 'second-option',
			'option_value' => 'shared_value',
			'autoload'     => 'yes',
		] );
		$this->assertSame( 'shared_value', get_option( 'first-option' ) );
		$this->assertSame( 'shared_value', get_option( 'second-option' ) );

		$this->assertSame( [
			[
				'option_id'    => $id_1,
				'option_name'  => 'first-option',
				'option_value' => 'shared_value',
				'autoload'     => 'no',
			],
			[
				'option_id'    => $id_2,
				'option_name'  => 'second-option',
				'option_value' => 'shared_value',
				'autoload'     => 'yes',
			],
		], $this->db()->get( [
			'option_value' => 'shared_value',
		] ) );

		$this->assertSame( 2, $this->db()->delete_where( [
			'option_value' => 'shared_value',
		] ) );
		$this->assertEmpty( $this->db()->get( [
			'option_value' => 'shared_value',
		] ) );

		if ( wp_cache_supports( 'flush_group' ) ) {
			wp_cache_flush_group( 'options' );
		} else {
			wp_cache_flush();
		}
		$this->assertFalse( get_option( 'first-option' ) );
		$this->assertFalse( get_option( 'second-option' ) );
	}


	public function test_get_by_id(): void {
		$v = $this->db()->get();
		$this->assertNotEmpty( $v );

		$first = $this->db()->get_by_id( $v[0]['option_id'] );
		$this->assertSame( $v[0], $first );

		$last = $this->db()->get_by_id( $v[ \count( $v ) - 1 ]['option_id'] );
		$this->assertSame( $v[ \count( $v ) - 1 ], $last );
	}


	public function test_delete(): void {
		$all = $this->db()->get();
		$this->assertNotEmpty( $all );

		$first = $all[0];
		$this->assertSame( maybe_unserialize( $first['option_value'] ), get_option( $first['option_name'] ) );
		$this->assertSame( $first, $this->db()->get_by_id( $first['option_id'] ) );
		$this->assertTrue( $this->db()->delete( $first['option_id'] ) );
		$this->assertNull( $this->db()->get_by_id( $first['option_id'] ) );

		$last = $all[ \count( $all ) - 1 ];
		$this->assertSame( maybe_unserialize( $last['option_value'] ), get_option( $last['option_name'] ) );
		$this->assertSame( $last, $this->db()->get_by_id( $last['option_id'] ) );
		$this->assertTrue( $this->db()->delete( $last['option_id'] ) );
		$this->assertEmpty( $this->db()->get_by_id( $last['option_id'] ) );

		if ( wp_cache_supports( 'flush_group' ) ) {
			wp_cache_flush_group( 'options' );
		} else {
			wp_cache_flush();
		}
		$this->assertFalse( get_option( $first['option_name'] ) );
		$this->assertFalse( get_option( $last['option_name'] ) );
	}


	public function test_replace(): void {
		$v = $this->db()->get_paginated( 1, 5 );
		$this->assertCount( 5, $v['items'] );

		// Create a new item because the id does not exist.
		$this->assertSame( 1, $this->db()->replace( [
			'option_name'  => 'new_option',
			'option_value' => 'new_value',
			'autoload'     => 'yes',
		] ) );
		$this->assertSame( 'new_value', $this->db()->get_one( [
			'option_name' => 'new_option',
		] )['option_value'] );
		$after = $this->db()->get_paginated( 1, 5 );
		$this->assertSame( $v['total'] + 1, $after['total'] );

		// Replace an existing item.
		$third = $after['items'][3];
		$this->assertSame( 2, $this->db()->replace( [
			'option_id'    => $third['option_id'],
			'option_name'  => 'replaced-option',
			'option_value' => 'actually-replaced',
			'autoload'     => 'no',
		] ) );
		$by_name = $this->db()->get_one( [
			'option_name' => 'replaced-option',
		] );
		$this->assertSame( 'actually-replaced', $by_name['option_value'] );
		$this->assertSame( $by_name, $this->db()->get_by_id( $third['option_id'] ) );
		$this->assertSame( get_option( 'replaced-option' ), 'actually-replaced' );
		$after_replace = $this->db()->get_paginated( 1, 5 );
		$this->assertSame( $after['total'], $after_replace['total'] );
	}


	public function test_add(): void {
		$this->assertNull( $this->db()->get_one( [
			'option_name' => 'new_option',
		] ) );
		$id = $this->db()->add( [
			'option_name'  => 'new_option',
			'option_value' => 'new_value',
			'autoload'     => 'yes',
		] );
		$this->assertNotNull( $id );
		$this->assertSame( 'new_value', $this->db()->get_one( [
			'option_name' => 'new_option',
		] )['option_value'] );
		$this->assertSame( 'new_value', get_option( 'new_option' ) );
	}


	public function test_sort_columns_date(): void {
		$table = new class() implements Table {
			public function get_column_formats(): array {
				return [
					'ID'   => '%i',
					'date' => '%s',
					'time' => '%s',
				];
			}


			public function get_id_field(): string {
				return 'ID';
			}


			public function get_table_base(): string {
				return 'custom_table';
			}
		};

		$db = Custom_Table::factory( $table );
		$this->assertSame( [
			'ID'   => 5,
			'time' => null,
		], call_private_method( $db, 'sort_columns', [ [ 'ID' => 5 ] ] ) );

		$this->assertSame( [
			'ID'   => null,
			'date' => '2024-05-01',
			'time' => '43:00:00',
		], call_private_method( $db, 'sort_columns', [
			[
				'date' => '2024-05-01',
				'time' => '43:00:00',
			],
		] ) );
	}


	#[DataProvider( 'provideSortColumns' )]
	public function test_sort_columns( array $columns, array $expected ): void {
		$this->assertSame( $expected, call_private_method( $this->db(), 'sort_columns', [ $columns ] ) );
	}


	#[DataProvider( 'provideFormats' )]
	public function test_get_formats( array $columns, array $expected ): void {
		$this->assertSame( $expected, call_private_method( $this->db(), 'get_formats', [ $columns ] ) );
	}


	public function test_update_where(): void {
		$this->assertNotNull( $this->db()->add( [
			'option_name'  => 'test_option',
			'option_value' => 'test_value',
			'autoload'     => 'yes',
		] ) );
		add_option( 'test_option_2', 'test_value' );

		$this->assertSame( 'test_value', $this->db()->get_one( [
			'option_name' => 'test_option',
		] )['option_value'] );
		$this->assertSame( 'test_value', $this->db()->get_one( [
			'option_name' => 'test_option_2',
		] )['option_value'] );

		$result = $this->db()->update_where( [
			'option_value' => 'test_value',
		], [
			'option_value' => 'new_value',
		] );
		$this->assertSame( 2, $result );
		$this->assertSame( 'new_value', $this->db()->get_one( [
			'option_name' => 'test_option',
		] )['option_value'] );
		$this->assertSame( 'new_value', $this->db()->get_one( [
			'option_name' => 'test_option_2',
		] )['option_value'] );

		if ( wp_cache_supports( 'flush_group' ) ) {
			wp_cache_flush_group( 'options' );
		} else {
			wp_cache_flush();
		}
		$this->assertSame( 'new_value', get_option( 'test_option' ) );
		$this->assertSame( 'new_value', get_option( 'test_option_2' ) );
	}


	public function test_format_values(): void {
		global $wpdb;
		$raw = $this->db()->get( [], 10 );
		foreach ( $raw as $row ) {
			$this->assertIsInt( $row['option_id'] );
			$this->assertIsString( $row['option_name'] );
			$this->assertIsString( $row['option_value'] );
			$this->assertThat( $row['autoload'], $this->logicalOr(
				$this->equalTo( 'yes' ),
				$this->equalTo( 'no' ),
				$this->equalTo( 'auto' ),
				$this->equalTo( 'on' ),
				$this->equalTo( 'off' ),
			) );
		}

		$table = new class() implements Table {
			public function get_column_formats(): array {
				return [
					'int_field'    => '%d',
					'string_field' => '%s',
					'maybe_empty'  => '%s',
					'float_field'  => '%f',
				];
			}


			public function get_id_field(): string {
				return 'int_field';
			}


			public function get_table_base(): string {
				return 'custom_table';
			}
		};
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( "CREATE TABLE `{$wpdb->prefix}custom_table` (
			`int_field` INT(11) auto_increment primary key,
			`string_field` VARCHAR(255) NOT NULL,
            `maybe_empty` VARCHAR(255) NULL DEFAULT '',
			`float_field` FLOAT NOT NULL
		)" );
		$db = Custom_Table::factory( $table );
		$this->assertNotNull( $db->add( [
			'string_field' => 'test',
			'float_field'  => 1.1,
		] ) );

		$raw = $db->get_by_id( 1 );
		$this->assertIsInt( $raw['int_field'] );
		$this->assertIsString( $raw['string_field'] );
		$this->assertNull( $raw['maybe_empty'] );
		$this->assertIsFloat( $raw['float_field'] );
	}


	private function db(): Custom_Table {
		$table = new class() implements Table {
			public function get_column_formats(): array {
				return [
					'option_id'    => '%d',
					'option_name'  => '%s',
					'option_value' => '%s',
					'autoload'     => '%s',
				];
			}


			public function get_id_field(): string {
				return 'option_id';
			}


			public function get_table_base(): string {
				return 'options';
			}
		};
		return Custom_Table::factory( $table );
	}


	public static function provideSortColumns(): array {
		return [
			'empty' => [
				'columns'  => [],
				'expected' => [
					'option_id'    => null,
					'option_name'  => null,
					'option_value' => null,
					'autoload'     => null,
				],
			],
			'one'   => [
				'columns'  => [ 'option_id' => 5 ],
				'expected' => [
					'option_id'    => 5,
					'option_name'  => null,
					'option_value' => null,
					'autoload'     => null,
				],
			],
			'many'  => [
				'columns'  => [
					'option_id'    => 6,
					'option_name'  => 'another',
					'option_value' => 'does not matter',
					'autoload'     => false,
				],
				'expected' => [
					'option_id'    => 6,
					'option_name'  => 'another',
					'option_value' => 'does not matter',
					'autoload'     => false,
				],
			],
		];
	}


	public static function provideFormats(): array {
		return [
			'empty' => [
				'columns'  => [],
				'expected' => [],
			],
			'one'   => [
				'columns'  => [ 'option_id' => 5 ],
				'expected' => [ 'option_id' => '%d' ],
			],
			'many'  => [
				'columns'  => [
					'option_id'    => 6,
					'option_name'  => 'another',
					'option_value' => 'does not matter',
					'autoload'     => false,
				],
				'expected' => [
					'option_id'    => '%d',
					'option_name'  => '%s',
					'option_value' => '%s',
					'autoload'     => '%s',
				],
			],
		];
	}


	public static function provideSelectQuery(): array {
		global $wpdb;

		return [
			'empty'             => [
				'columns'  => [],
				'where'    => [],
				'count'    => null,
				'order_by' => null,
				'order'    => 'ASC',
				'offset'   => null,
				'expected' => "SELECT * FROM `{$wpdb->options}`",
			],
			'columns'           => [
				'columns'  => [ 'option_name', 'option_value' ],
				'where'    => [],
				'count'    => null,
				'order_by' => null,
				'order'    => 'ASC',
				'offset'   => null,
				'expected' => "SELECT `option_name`, `option_value` FROM `{$wpdb->options}`",
			],
			'where'             => [
				'columns'  => [],
				'where'    => [ 'option_name' => 'test' ],
				'count'    => null,
				'order_by' => null,
				'order'    => 'ASC',
				'offset'   => null,
				'expected' => "SELECT * FROM `{$wpdb->options}` WHERE `option_name` = 'test'",
			],
			'columns and where' => [
				'columns'  => [ 'option_name', 'option_value' ],
				'where'    => [ 'option_name' => 'test' ],
				'count'    => null,
				'order_by' => null,
				'order'    => 'ASC',
				'offset'   => null,
				'expected' => "SELECT `option_name`, `option_value` FROM `{$wpdb->options}` WHERE `option_name` = 'test'",
			],
			'count'             => [
				'columns'  => [],
				'where'    => [],
				'count'    => 10,
				'order_by' => null,
				'order'    => 'ASC',
				'offset'   => null,
				'expected' => "SELECT * FROM `{$wpdb->options}` LIMIT 10",
			],
			'order and by ASC'  => [
				'columns'  => [],
				'where'    => [],
				'count'    => null,
				'order_by' => 'option_name',
				'order'    => 'ASC',
				'offset'   => null,
				'expected' => "SELECT * FROM `{$wpdb->options}` ORDER BY `option_name`",
			],
			'order and by DESC' => [
				'columns'  => [],
				'where'    => [],
				'count'    => null,
				'order_by' => 'option_name',
				'order'    => 'DESC',
				'offset'   => null,
				'expected' => "SELECT * FROM `{$wpdb->options}` ORDER BY `option_name` DESC",
			],
			'order'             => [
				'columns'  => [],
				'where'    => [],
				'count'    => null,
				'order_by' => null,
				'order'    => 'DESC',
				'offset'   => null,
				'expected' => "SELECT * FROM `{$wpdb->options}` ORDER BY `option_id` DESC",
			],
			'order by'          => [
				'columns'  => [],
				'where'    => [],
				'count'    => null,
				'order_by' => 'option_name',
				'order'    => 'ASC',
				'offset'   => null,
				'expected' => "SELECT * FROM `{$wpdb->options}` ORDER BY `option_name`",
			],
			'offset'            => [
				'columns'  => [],
				'where'    => [],
				'count'    => null,
				'order_by' => null,
				'order'    => 'ASC',
				'offset'   => 10,
				'expected' => "SELECT * FROM `{$wpdb->options}` LIMIT 1000000 OFFSET 10",
			],
			'where and offset'  => [
				'columns'  => [],
				'where'    => [ 'option_name' => 'test' ],
				'count'    => null,
				'order_by' => null,
				'order'    => 'ASC',
				'offset'   => 100,
				'expected' => "SELECT * FROM `{$wpdb->options}` WHERE `option_name` = 'test' LIMIT 1000000 OFFSET 100",
			],
			'everything'        => [
				'columns'  => [ 'option_name', 'option_value' ],
				'where'    => [ 'option_name' => 'test' ],
				'count'    => 10,
				'order_by' => 'option_name',
				'order'    => 'DESC',
				'offset'   => 100,
				'expected' => "SELECT `option_name`, `option_value` FROM `{$wpdb->options}` WHERE `option_name` = 'test' ORDER BY `option_name` DESC LIMIT 10 OFFSET 100",
			],
			'like query'        => [
				'columns'  => [],
				'where'    => [ 'option_name' => '%c%', 'option_value' => 'non like' ],
				'count'    => 1,
				'order_by' => null,
				'order'    => 'ASC',
				'offset'   => 20,
				'expected' => "SELECT * FROM `{$wpdb->options}` WHERE `option_name` LIKE '" . $wpdb->prepare( '%c%' ) . "' AND `option_value` = 'non like' LIMIT 1 OFFSET 20",
			],
		];
	}
}
