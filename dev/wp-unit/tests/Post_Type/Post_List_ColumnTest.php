<?php
declare( strict_types=1 );

namespace Lipe\Lip\Post_Type;

use Lipe\Lib\Post_Type\Post_List_Column;
use Lipe\Lib\Post_Type\Post_List_Column\Filter;
use Lipe\Lib\Post_Type\Post_List_Column\ListColumn;

require_once ABSPATH . 'wp-admin/includes/class-wp-posts-list-table.php';

/**
 * @author Mat Lipe
 * @since  May 2024
 *
 */
class Post_List_ColumnTest extends \WP_UnitTestCase {
	/**
	 * @dataProvider providePostTypes
	 */
	public function test_render_filter( string $type, bool $included ): void {
		[ $mock, $screen ] = $this->getMock();
		$screen->post_type = $type;
		$echo = fn() => get_echo( function() use ( $screen ) {
			$table = new \WP_Posts_List_Table( [ 'screen' => $screen ] );
			$table->extra_tablenav( 'top' );
		} );

		// Not in the admin.
		$this->assertStringNotContainsString( 'Showing All', $echo() );

		// In the admin.
		$screen->set_current_screen();

		// Not a filter mock.
		Post_List_Column::factory( $mock );
		do_action( 'load-edit.php' );
		$this->assertStringNotContainsString( 'Showing All', $echo() );

		Post_List_Column::factory( $this->getFilterMock() );
		// Not on the edit screen.
		$this->assertStringNotContainsString( 'Showing All', $echo() );

		do_action( 'load-edit.php' );
		if ( $included ) {
			$this->assertStringContainsString( 'Showing All', $echo() );
		} else {
			$this->assertStringNotContainsString( 'Showing All', $echo() );
		}
	}


	/**
	 * @dataProvider providePostTypes
	 */
	public function test_maybe_filter_query( string $type, bool $included ): void {
		[ $mock, $screen ] = $this->getMock();
		$screen->post_type = $type;

		// Not in the admin.
		$query = new \WP_Query();
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// In the admin.
		$screen->set_current_screen();

		// Not a filter mock.
		Post_List_Column::factory( $mock );
		$query = new \WP_Query();
		do_action( 'load-edit.php' );
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// Not on the edit screen.
		Post_List_Column::factory( $this->getFilterMock() );
		$query = new \WP_Query();
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// On the edit screen.
		Post_List_Column::factory( $this->getFilterMock() );
		do_action( 'load-edit.php' );
		$query = new \WP_Query();
		// No filter selected
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// No post type provided to query.
		$_REQUEST['test-filter-column-label'] = 'one';
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// No nonce provided
		$query->query_vars['post_type'] = $type;
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		$nonce = get_private_property( Post_List_Column::class, 'NONCE' );
		$_REQUEST[ $nonce ] = wp_create_nonce( $nonce );
		do_action( 'parse_query', $query );
		if ( $included ) {
			$this->assertSame( 'one', $query->query_vars['slug'] );
		} else {
			$this->assertArrayNotHasKey( 'slug', $query->query_vars );
		}
	}


	/**
	 * @dataProvider providePostTypes
	 */
	public function test_add_column( string $type, bool $included ): void {
		[ $mock, $screen ] = $this->getMock();
		$screen->post_type = $type;

		// Not in the admin.
		$table = new \WP_Posts_List_Table( [ 'screen' => $screen ] );
		$this->assertArrayNotHasKey( 'test-column-label', $table->get_columns() );

		// In the admin.
		$screen->set_current_screen();
		Post_List_Column::factory( $mock );
		if ( $included ) {
			$this->assertSame( $table->get_columns()['test-column-label'], 'Test Column Label' );
		} else {
			$this->assertArrayNotHasKey( 'test-column-label', $table->get_columns() );
		}
	}


	/**
	 * @dataProvider providePostTypes
	 */
	public function test_maybe_render_column( string $type, bool $included ): void {
		[ $mock, $screen ] = $this->getMock();
		// Not in the admin.
		$output = get_echo( function() use ( $type ) {
			do_action( 'manage_' . $type . '_posts_custom_column', 'test-column-label', 1 );
		} );
		$this->assertEmpty( $output );

		// In the admin from this point forward.
		$screen->set_current_screen();
		Post_List_Column::factory( $mock );

		$output = get_echo( function() use ( $type ) {
			do_action( 'manage_' . $type . '_posts_custom_column', 'test-column-label', 1 );
		} );
		if ( $included ) {
			$this->assertSame( 'Post_List_ColumnTest::render', $output );
		} else {
			$this->assertEmpty( $output );
		}

		$output = get_echo( function() use ( $type ) {
			do_action( 'manage_' . $type . '_posts_custom_column', 'title', 1 );
		} );
		$this->assertEmpty( $output );
	}


	public function test_factory(): void {
		[ $mock, $screen ] = $this->getMock();
		$column = Post_List_Column::factory( $mock );
		$this->assertSame( 'test-column-label', get_private_property( $column, 'column_slug' ) );
		$this->assertFalse( has_filter( 'manage_post_posts_columns', [ $column, 'add_column' ] ) );

		$screen->set_current_screen();
		$column = Post_List_Column::factory( $mock );
		$this->assertSame( 10, has_filter( 'manage_post_posts_columns', [ $column, 'add_column' ] ) );
	}


	private function getMock(): array {
		$mock = new class() implements ListColumn {
			public function get_post_types(): array {
				return [ 'post', 'another' ];
			}


			public function get_column_position(): int {
				return 1;
			}


			public function get_column_label(): string {
				return 'Test Column Label';
			}


			public function render( int $post_id ): void {
				echo 'Post_List_ColumnTest::render';
			}
		};
		Post_List_Column::factory( $mock );
		$screen = \WP_Screen::get( 'post' );
		return [ $mock, $screen ];
	}


	private function getFilterMock(): ListColumn {
		$mock = new class() implements ListColumn, Filter {
			public function get_post_types(): array {
				return [ 'post', 'another' ];
			}


			public function get_column_position(): int {
				return 1;
			}


			public function get_column_label(): string {
				return 'Test Filter Column Label';
			}


			public function render( int $post_id ): void {
				echo 'Post_List_FilterTest::render';
			}


			public function get_show_all_label(): string {
				return 'Showing All';
			}


			public function get_options(): array {
				return [
					'one' => 'One',
					'two' => 'Two',
				];
			}


			public function filter_query( string $value, \WP_Query $query ): void {
				$query->set( 'slug', $value );
			}
		};
		Post_List_Column::factory( $mock );
		return $mock;
	}


	public static function providePostTypes(): array {
		return [
			'post'    => [ 'type' => 'post', 'included' => true ],
			'another' => [ 'type' => 'another', 'included' => true ],
			'page'    => [ 'type' => 'page', 'included' => false ],
		];
	}
}
