<?php

namespace Lipe\Lib\Theme;

use mocks\Class_Names_Enum_Mock;

/**
 * @author Mat Lipe
 * @since  January, 2019
 *
 */
class Class_NamesTest extends \WP_UnitTestCase {

	public function test_get_classes(): void {
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


	public function test_array_access(): void {
		$o = new Class_Names( [
			'f' => false,
			't' => true,
			'u' => [
				'2p' => true,
				'e'  => false,
			],
		] );

		$this->assertTrue( isset( $o['t'] ) );
		$this->assertFalse( isset( $o['f'] ) );
		$this->assertFalse( isset( $o['u'] ) );
		$this->assertTrue( isset( $o['2p'] ) );
		$this->assertFalse( isset( $o['e'] ) );

		$this->assertSame( 't', $o['t'] );
		$this->assertSame( '', $o['f'] );
		$this->assertSame( '', $o['u'] );
		$this->assertSame( '_2p', $o['2p'] );
		$this->assertSame( '', $o['e'] );

		$o['t'] = false;
		$this->assertSame( '', $o['t'] );
		$this->assertFalse( isset( $o['t'] ) );
		$this->assertSame( '_2p', $o['2p'] );

		unset( $o['2p'] );
		$this->assertFalse( isset( $o['2p'] ) );
		$this->assertSame( '', $o['2p'] );
	}


	public function test_backed_enum(): void {
		$o = new Class_Names( Class_Names_Enum_Mock::F, [
			Class_Names_Enum_Mock::T->value => false,
			Class_Names_Enum_Mock::S,
			3                               => [
				Class_Names_Enum_Mock::P2->value => true,
			],
			'v'                             => [
				'h' => Class_Names_Enum_Mock::M,
				'i' => Class_Names_Enum_Mock::L,
			],
		] );
		$this->assertSame( [ 'first', 'second', '_2p', 'middle', 'last' ], $o->get_classes() );

		$this->assertSame( '_2p', $o[ Class_Names_Enum_Mock::P2 ] );
		$this->assertSame( 'middle', $o[ Class_Names_Enum_Mock::M ] );

		unset( $o[ Class_Names_Enum_Mock::M ] );
		$this->assertFalse( isset( $o[ Class_Names_Enum_Mock::M ] ) );
		$this->assertSame( 'last', $o[ Class_Names_Enum_Mock::L ] );
		$this->assertSame( '', $o[ Class_Names_Enum_Mock::M ] );

		$o[ Class_Names_Enum_Mock::M ] = true;
		$this->assertSame( 'middle', $o[ Class_Names_Enum_Mock::M ] );
		$this->assertTrue( isset( $o[ Class_Names_Enum_Mock::M ] ) );

		$o[ Class_Names_Enum_Mock::M ] = false;
		$this->assertSame( '', $o[ Class_Names_Enum_Mock::M ] );
		$this->assertFalse( isset( $o[ Class_Names_Enum_Mock::M ] ) );
	}
}
