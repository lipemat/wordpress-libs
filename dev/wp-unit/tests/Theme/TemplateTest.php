<?php

namespace Lipe\Lib\Theme;

/**
 * @author Mat Lipe
 * @since  July 2022
 *
 */
class TemplateTest extends \WP_UnitTestCase {

	public function test_sanitize_css_class() : void {
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
}
