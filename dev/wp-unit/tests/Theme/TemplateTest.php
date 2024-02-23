<?php

namespace Lipe\Lib\Theme;

/**
 * @author Mat Lipe
 * @since  July 2022
 *
 */
class TemplateTest extends \WP_UnitTestCase {

	public function test_sanitize_css_class(): void {
		$valid = [
			'_first-',
			'second-_1234',
			'Ⓜnav__global-composes__fY',
		];
		foreach ( $valid as $class ) {
			$this->assertEquals( $class, Template::in()->sanitize_html_class( $class ) );
		}

		$invalid = [
			'-hyphen',
			'234_numbers',
			'--double',
			'2Ⓜnav__global',
		];
		foreach ( $invalid as $class ) {
			$this->assertEquals( "_{$class}", Template::in()->sanitize_html_class( $class ) );
		}

		$this->assertEquals( 'httptest.com', Template::in()->sanitize_html_class( urlencode( 'http:://test.com' ) ) );
	}


	/**
	 * @dataProvider providerEscAttr
	 */
	public function test_esc_attr( array $attr, string $expected ): void {
		$this->assertSame( $expected, Template::in()->esc_attr( $attr ) );
	}


	public function providerEscAttr(): array {
		return [
			'empty'  => [
				[],
				'',
			],
			'single' => [
				[
					'foo' => 'bar',
				],
				'foo="bar"',
			],
			'double' => [
				[
					'foo' => 'bar',
					'baz' => 'qux',
				],
				'foo="bar" baz="qux"',
			],
			'bool'   => [
				[
					'foo' => false,
					'baz' => true,
				],
				'foo="0" baz',
			],
			'array'  => [
				[
					'foo' => 'bar',
					'baz' => [ 'qux' ],
				],
				'foo="bar" baz="[&quot;qux&quot;]"',
			],
			'object' => [
				[
					'foo' => 'bar',
					'baz' => (object) [ 'qux' ],
				],
				'foo="bar" baz="{&quot;0&quot;:&quot;qux&quot;}"',
			],
		];
	}
}
