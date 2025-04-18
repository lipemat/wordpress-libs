<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

/**
 * @author Mat Lipe
 * @since  June 2024
 *
 */
class StringsTest extends \WP_UnitTestCase {

	/**
	 * @dataProvider providePluralize
	 */
	public function test_pluralize( string $word, string $expected ): void {
		$this->assertSame( $expected, Strings::instance()->pluralize( $word ) );
	}


	public function test_unformat_money_value(): void {
		$utils = Strings::in();
		$this->assertSame( 0.0, $utils->unformat_money_value( 0 ) );
		$this->assertSame( 45.0, $utils->unformat_money_value( '45' ) );
		$this->assertSame( 45.0, $utils->unformat_money_value( '45.00' ) );
		$this->assertSame( 45.014, $utils->unformat_money_value( '45.014' ) );
		$this->assertSame( 45_014.0, $utils->unformat_money_value( '45,014.00' ) );
		$this->assertSame( 45.014, $utils->unformat_money_value( '45.014,00' ) );

		$backup = clone $GLOBALS['wp_locale'];
		$GLOBALS['wp_locale']->number_format['thousands_sep'] = '%';
		$GLOBALS['wp_locale']->number_format['decimal_point'] = '!';
		$this->assertSame( 45.014, $utils->unformat_money_value( '45!014' ) );
		$this->assertSame( 45_014.0, $utils->unformat_money_value( '45%014!00' ) );
		$GLOBALS['wp_locale'] = $backup;
	}


	public static function providePluralize(): array {
		return [
			[ 'dog', 'dogs' ],
			[ 'cat', 'cats' ],
			[ 'box', 'boxes' ],
			[ 'city', 'cities' ],
			[ 'baby', 'babies' ],
			[ 'toy', 'toys' ],
			[ 'mess', 'messes' ],
			[ 'buzz', 'buzzes' ],
			[ 'fox', 'foxes' ],
			[ 'bus', 'buses' ],
			[ 'tax', 'taxes' ],
			[ 'taxes', 'taxes' ],
			[ 'church', 'churches' ],
			[ 'churches', 'churches' ],
			[ 'box', 'boxes' ],
			[ 'boxes', 'boxes' ],
			[ 'cities', 'cities' ],
			[ 'baby', 'babies' ],
			[ 'babies', 'babies' ],
			[ 'mess', 'messes' ],
			[ 'messes', 'messes' ],
			[ 'buzz', 'buzzes' ],
			[ 'buzzes', 'buzzes' ],
			[ 'fox', 'foxes' ],
			[ 'foxes', 'foxes' ],
			[ 'bus', 'buses' ],
			[ 'buses', 'buses' ],
		];
	}
}
