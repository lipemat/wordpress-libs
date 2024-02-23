<?php
declare( strict_types=1 );

namespace Lipe\Lib\Blocks;

/**
 * @author Mat Lipe
 * @since  February 2024
 *
 */
class Register_BlockTest extends \WP_UnitTestCase {

	public function test_supports(): void {
		$args = new Register_Block( [] );
		$args->supports = [ 'align' ];
		$this->assertEquals( [ 'align' ], $args->get_args()['supports'] );

		$args->supports()->html = false;
		$args->supports()->align = true;
		$this->assertSame( [
			'align' => true,
			'html'  => false,
		], $args->get_args()['supports'] );

		$args->supports()->layout = [
			'allowSizingOnChildren' => true,
			'default'               => [
				'type' => 'grid',
			],
		];
		$this->assertSame( [
			'align'  => true,
			'html'   => false,
			'layout' => [
				'allowSizingOnChildren' => true,
				'default'               => [
					'type' => 'grid',
				],
			],
		], $args->get_args()['supports'] );
	}
}
