<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Box;
use Lipe\Lib\CMB2\Field;
use mocks\Post_Mock;

/**
 * @author Mat Lipe
 * @since  August 2023
 *
 */
class Translate_AbstractTest extends \WP_UnitTestCase {
	public function test_get_term_id_from_slug(): void {
		$category = self::factory()->category->create_and_get();

		$mock = new class() extends Translate_Abstract {
			public function get_result( $value, $field = '_' ) {
				return $this->get_term_id_from_slug( $field, $value );
			}


			protected function get_field( string $field_id ): ?Field {
				if ( '_' !== $field_id ) {
					return null;
				}
				$field = new Field( $field_id, $field_id, null );
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


	public function test_delete_meta_value(): void {
		$box = new Box( __METHOD__, [ 'post' ], 'Test Delete Meta Value' );
		$box->field( 'meta/prefixed/dmv', 'Test 2' )->text();

		$group = $box->group( 'group/prefixed/dmv', 'Group 3' );
		$group->field( 'group/prefixed/dmv/first', '' )->text();
		$group->field( 'group/prefixed/dmv/second', '' )->text();
		do_action( 'cmb2_init' );
		$post = Post_Mock::factory( self::factory()->post->create_and_get() );

		$post['group/prefixed/dmv'] = [
			[
				'group/prefixed/dmv/first'  => 'value1',
				'group/prefixed/dmv/second' => 'value2',
			],
		];
		$post['meta/prefixed/dmv'] = 'value3';

		unset( $post['group/prefixed/dmv/first'] );
		$this->assertSame( [
			[
				'group/prefixed/dmv/first'  => null,
				'group/prefixed/dmv/second' => 'value2',
			],
		], $post->get_meta( 'group/prefixed/dmv' ) );

		unset( $post['group/prefixed/dmv'] );
		$this->assertSame( [], $post->get_meta( 'group/prefixed/dmv' ) );

		$this->assertSame( 'value3', $post->get_meta( 'meta/prefixed/dmv' ) );
		unset( $post['meta/prefixed/dmv'] );
		$this->assertSame( '', $post->get_meta( 'meta/prefixed/dmv' ) );
	}
}
