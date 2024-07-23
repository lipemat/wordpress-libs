<?php
declare( strict_types=1 );

namespace Lipe\Lib\Api;

/**
 * @author Mat Lipe
 * @since  July 2024
 *
 */
class Wp_RemoteTest extends \WP_UnitTestCase {
	public function test_mapped_properties(): void {
		$args = new Wp_Remote( [] );
		$args->user_agent = 'test';
		$this->assertSame( 'test', $args->get_args()['user-agent'] );
	}


	public function test_headers(): void {
		$args = new Wp_Remote( [] );
		$args->headers = [ 'Authorization' => 'Basic' ];
		$this->assertSame( [ 'Authorization' => 'Basic' ], $args->get_args()['headers'] );

		$args->header( 'Cookie', 'test' )
		     ->header( 'Authorization', 'Strict' );
		$this->assertSame( [
			'Authorization' => 'Strict',
			'Cookie'        => 'test',
		], $args->get_args()['headers'] );
	}
}
