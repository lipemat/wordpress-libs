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
