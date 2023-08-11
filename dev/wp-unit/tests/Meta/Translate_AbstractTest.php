<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Field;

/**
 * @author Mat Lipe
 * @since  August 2023
 *
 */
class Translate_AbstractTest extends \WP_UnitTestCase {
	public function test_get_term_id_from_slug() : void {
		$category = self::factory()->category->create_and_get();

		$mock = new class() extends Translate_Abstract {
			public function get_result( $value, $field = '_' ) {
				return $this->get_term_id_from_slug( $field, $value );
			}


			protected function get_field( string $field_id ) : ?Field {
				if ( '_' !== $field_id ) {
					return null;
				}
				$field = new Field( $field_id, $field_id );
				$field->taxonomy = 'category';
				return $field;
			}
		};

		$this->assertEquals( $category->term_id, $mock->get_result( $category->slug ) );
		$this->assertEquals( $category->term_id, $mock->get_result( $category->term_id ) );
		$this->assertEquals( $category->term_id, $mock->get_result( (string) $category->term_id ) );
		$this->assertNull( $mock->get_result( 'no-term' ) );
		$this->assertNull( $mock->get_result( $category->slug, 'no-field' ) );
	}
}
