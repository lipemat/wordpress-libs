<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Post_Type\Post_List_Column\Filter;

require_once ABSPATH . 'wp-admin/includes/class-wp-posts-list-table.php';

/**
 * @author Mat Lipe
 * @since  November 2024
 *
 */
class Post_List_FilterTest extends \WP_UnitTestCase {

	/**
	 * @dataProvider providePostTypes
	 */
	public function test_maybe_filter_query( string $type, bool $included ): void {
		$screen = \WP_Screen::get( 'post' );
		$screen->post_type = $type;

		// Not in the admin.
		$query = new \WP_Query();
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// In the admin.
		$screen->set_current_screen();

		// Not on the edit screen.
		$this->getFilterMock();
		$query = new \WP_Query();
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// On the edit screen.
		$this->getFilterMock();
		do_action( 'load-edit.php' );
		$query = new \WP_Query();
		// No filter selected
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// No post type provided to query.
		$_REQUEST['test-filter-column'] = 'one';
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		// No nonce provided
		$query->query_vars['post_type'] = $type;
		do_action( 'parse_query', $query );
		$this->assertArrayNotHasKey( 'slug', $query->query_vars );

		$nonce = get_private_property( Post_List_Filter::class, 'NONCE' );
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
	public function test_render_filter( string $type, bool $included ): void {
		$screen = \WP_Screen::get( 'post' );
		$screen->post_type = $type;
		$echo = fn() => get_echo( function() use ( $screen ) {
			$table = new \WP_Posts_List_Table( [ 'screen' => $screen ] );
			$table->extra_tablenav( 'top' );
		} );

		// Not in the admin.
		$this->assertStringNotContainsString( 'Showing All', $echo() );

		// In the admin.
		$screen->set_current_screen();

		$this->getFilterMock();
		// Not on the edit screen.
		$this->assertStringNotContainsString( 'Showing All', $echo() );

		do_action( 'load-edit.php' );
		if ( $included ) {
			$this->assertStringContainsString( 'Showing All', $echo() );
		} else {
			$this->assertStringNotContainsString( 'Showing All', $echo() );
		}
	}


	private function getFilterMock(): Filter {
		$mock = new class() implements Filter {
			public function get_post_types(): array {
				return [ 'post', 'another' ];
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
		new Post_List_Filter( $mock, 'test-filter-column' );
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
