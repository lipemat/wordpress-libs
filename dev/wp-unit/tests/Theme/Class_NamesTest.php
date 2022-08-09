<?php

namespace Lipe\Lib\Theme;

/**
 * @author Mat Lipe
 * @since  January, 2019
 *
 */
class Class_NamesTest extends \WP_UnitTestCase {

	public function test_get_classes() : void {
		$o = new Class_Names( [
			'f' => false,
			't' => true,
			'u' => [
				'w' => true,
				'e' => false,
			],
			'x',
			7   => [
				'p',
				'q',
			],
			'm' => [
				5   => 'r',
				'o' => true,
				'v' => false,
			],
		] );
		$this->assertSame( [ 't', 'w', 'x', 'p', 'q', 'r', 'o' ], $o->get_classes() );
		$this->assertEquals( 't w x p q r o', (string) $o );

		$o = new Class_Names( 'a', [
			'b' => false,
			'c' => true,
			3   => 'd',
		],
			'e',
			[
				'f' => false,
				't' => true,
				'u' => [
					'w' => true,
					'e' => false,
				],
				'x',
				7   => [
					'p',
					'q',
				],
				'm' => [
					5   => 'r',
					'o' => true,
					'v' => false,
				],
			] );
		$this->assertSame( [ 'a', 'c', 'd', 'e', 't', 'w', 'x', 'p', 'q', 'r', 'o' ], $o->get_classes() );
		$this->assertEquals( 'a c d e t w x p q r o', (string) $o );

		$o = new Class_Names( [
			' ' => true,
			't' => false,
			'x',
			'u' => [
				' ',
			],
			'',
			7   => [
				// Classes requiring sanitization.
				'2p',
				'-q',
			],
		] );
		$this->assertSame( [ 'x', '_2p', '_-q' ], $o->get_classes() );
		$this->assertEquals( 'x _2p _-q', (string) $o );
	}
}
