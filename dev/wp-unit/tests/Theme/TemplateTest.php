<?php

namespace Lipe\Lib\Theme;

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @author Mat Lipe
 * @since  July 2022
 *
 */
class TemplateTest extends \WP_UnitTestCase {

	#[DataProvider( 'provideCssClassNames' )]
	public function test_sanitize_css_class( string $value, string $expected ): void {
		$this->assertSame( $expected, Template::in()->sanitize_html_class( $value ) );
	}


	#[DataProvider( 'providerEscAttr' )]
	public function test_esc_attr( array $attr, string $expected ): void {
		$this->assertSame( $expected, Template::in()->esc_attr( $attr ) );
	}


	public static function provideCssClassNames(): array {
		return [
			'quote'                       => [
				'value'    => "quotes-test'",
				'expected' => 'quotes-test\\\'',
			],
			'double quote'                => [
				'value'    => 'quotes-test"',
				'expected' => 'quotes-test\\"',
			],
			'quote wrap'                  => [
				'value'    => "'quotes-test'",
				'expected' => '\\\'quotes-test\\\'',
			],
			'double quote wrap'           => [
				'value'    => '"quotes-test"',
				'expected' => '\\"quotes-test\\"',
			],
			'hyphen'                      => [
				'value'    => '-hyphen',
				'expected' => '_-hyphen',
			],
			'leading number'              => [
				'value'    => '234_numbers',
				'expected' => '_234_numbers',
			],
			'double hyphen'               => [
				'value'    => '--double',
				'expected' => '_--double',
			],
			'leading number with unicode' => [
				'value'    => '2Ⓜnav__global',
				'expected' => '_2Ⓜnav__global',
			],
			'url encoded'                 => [
				'value'    => urlencode( 'http:://test.com' ),
				'expected' => 'httptest.com',
			],
			'underscore'                  => [
				'value'    => '_first-',
				'expected' => '_first-',
			],
			'underscore with numbers'     => [
				'value'    => 'second-_1234',
				'expected' => 'second-_1234',
			],
			'unicode'                     => [
				'value'    => 'Ⓜnav__global-composes__fY',
				'expected' => 'Ⓜnav__global-composes__fY',
			],
		];
	}


	public static function providerEscAttr(): array {
		return [
			'empty'       => [
				[],
				'',
			],
			'single'      => [
				[
					'foo' => 'bar',
				],
				'foo="bar"',
			],
			'double'      => [
				[
					'foo' => 'bar',
					'baz' => 'qux',
				],
				'foo="bar" baz="qux"',
			],
			'bool'        => [
				[
					'foo' => false,
					'baz' => true,
				],
				'foo="0" baz',
			],
			'array'       => [
				[
					'foo' => 'bar',
					'baz' => [ 'qux' ],
				],
				'foo="bar" baz="[&quot;qux&quot;]"',
			],
			'object'      => [
				[
					'foo' => 'bar',
					'baz' => (object) [ 'qux' ],
				],
				'foo="bar" baz="{&quot;0&quot;:&quot;qux&quot;}"',
			],
			'HTML in key' => [
				[
					'break/&gt;'   => 'bar',
					'<h1>tag</h1>' => ' spaced ',
				],
				'break/&gt;="bar" &lt;h1&gt;tag&lt;/h1&gt;="spaced"',
			],
			'Class Names' => [
				[
					'class' => new Class_Names( [ 'foo', 'bar' ] ),
				],
				'class="foo bar"',
			],
		];
	}
}
