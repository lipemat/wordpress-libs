<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Box;
use mocks\Post_Mock;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @author Mat Lipe
 * @since  August 2023
 *
 */
class Translate_Test extends \WP_UnitTestCase {
	protected function tearDown(): void {
		Repo::in()->clear_memoize_cache();
		parent::tearDown();
	}


	public function test_get_term_id_from_slug(): void {
		$category = self::factory()->category->create_and_get();

		$mock = new class() {
			use Translate;

			public function get_result( $value, $field = '_' ) {
				return $this->get_term_id_from_slug( $field, $value );
			}


			protected function get_registered( ?string $field_id ): ?Registered {
				if ( '_' !== $field_id ) {
					return null;
				}
				$box = new Box( 'test-translate', [ 'post' ], 'Translate test' );
				return Registered::factory( $box->field( $field_id, $field_id )->taxonomy_select( 'category' ) );
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


	public function test_multiple_group_fields(): void {
		$box = new Box( __METHOD__, [ 'post' ], 'Meal Data' );
		$items = $box->group( 'multiple/group/items', 'Items', 'Item {#}' );
		$items->repeatable();
		$items->field( __METHOD__ . 'servings', 'Servings' )
		      ->text_number();
		$manual = $box->group( 'multiple/group/manual', 'Manual Entry' );
		$manual->field( __METHOD__ . 'calories', 'Calories' )
		       ->text_number();
		do_action( 'cmb2_init' );
		$post = Post_Mock::factory( self::factory()->post->create_and_get() );

		$post['multiple/group/items'] = [
			[
				__METHOD__ . 'servings' => '1',
			],
			[
				__METHOD__ . 'servings' => '2',
			],
		];
		$post['multiple/group/manual'] = [
			[
				__METHOD__ . 'calories' => '100',
			],
		];

		$this->assertSame( [
			[
				__METHOD__ . 'servings' => '1',
			],
			[
				__METHOD__ . 'servings' => '2',
			],
		], $post->get_meta( 'multiple/group/items' ) );

		$this->assertSame( [
			[
				__METHOD__ . 'calories' => '100',
			],
		], $post->get_meta( 'multiple/group/manual' ) );

		foreach ( $post['multiple/group/items'] as $i => $item ) {
			$this->assertSame( (string) ( $i + 1 ), $item[ __METHOD__ . 'servings' ] );
		}

		$this->expectDoingItWrong( 'Lipe\Lib\Meta\Validation::warn_for_repeatable_group_sub_fields', 'Accessing sub-fields on repeatable groups will only read/update the first item. Use the group key instead. Lipe\Lib\Meta\Translate_Test::test_multiple_group_fieldsservings (This message was added in version 4.10.0.)' );

		$this->assertSame( '1', $post->get_meta( __METHOD__ . 'servings' ) );
		$this->assertSame( '100', $post->get_meta( __METHOD__ . 'calories' ) );
	}


	public function test_supports_taxonomy_relationship(): void {
		$get_field = fn( string $field ) => call_private_method( Repo::in(), 'get_registered', [ $field ] );
		$box = new Box( __METHOD__, [ 'post' ], 'Test Taxonomy Field' );
		$box->field( 'taxonomy/sr/1', 'SR 1' )
		    ->taxonomy_select( 'category' );
		$box->field( 'taxonomy/sr/2', 'SR 2' )
		    ->taxonomy_select( 'post_tag' )
		    ->store_terms_in_meta( true );
		do_action( 'cmb2_init' );

		$this->assertTrue( Repo::in()->supports_taxonomy_relationships( MetaType::POST, $get_field( 'taxonomy/sr/1' ) ) );
		$this->assertFalse( Repo::in()->supports_taxonomy_relationships( MetaType::COMMENT, $get_field( 'taxonomy/sr/1' ) ) );
		$this->assertFalse( Repo::in()->supports_taxonomy_relationships( MetaType::POST, $get_field( 'taxonomy/sr/2' ) ) );

		// Add a second taxonomy field.
		$srg = $box->group( 'taxonomy/sr/group', 'SR Group' );
		$srg->field( 'taxonomy/sr/group/1', 'SR Group 1' )
		    ->taxonomy_select( 'category' );
		$srg->field( 'taxonomy/sr/group/2', 'SR Group 2' )
		    ->taxonomy_select( 'post_tag' )
		    ->store_terms_in_meta( true );
		$this->expectDoingItWrong( 'Lipe\Lib\Meta\Validation::warn_for_conflicting_taxonomies', 'Fields: "taxonomy/sr/1, taxonomy/sr/group/1" are conflicting on the taxonomy: category for the object type: post. You may only have one taxonomy field per an object. (This message was added in version 4.10.0.)' );
		do_action( 'cmb2_init' );

		$this->assertTrue( Repo::in()->supports_taxonomy_relationships( MetaType::POST, $get_field( 'taxonomy/sr/1' ) ) );
		$this->assertTrue( Repo::in()->supports_taxonomy_relationships( MetaType::POST, $get_field( 'taxonomy/sr/group/1' ) ) );
		$this->assertFalse( Repo::in()->supports_taxonomy_relationships( MetaType::POST, $get_field( 'taxonomy/sr/group/2' ) ) );

		// Change one field to text.
		$box->field( 'taxonomy/sr/1', 'SR 1' )->text();
		do_action( 'cmb2_init' );
		$this->assertFalse( Repo::in()->supports_taxonomy_relationships( MetaType::POST, $get_field( 'taxonomy/sr/1' ) ) );
		$this->assertTrue( Repo::in()->supports_taxonomy_relationships( MetaType::POST, $get_field( 'taxonomy/sr/group/1' ) ) );
		$this->assertFalse( Repo::in()->supports_taxonomy_relationships( MetaType::tryFrom( 'options-page' ), $get_field( 'taxonomy/sr/group/1' ) ) );
	}


	#[DataProvider( 'provideCheckboxValues' )]
	public function test_checkbox_field( mixed $value, bool $expected ): void {
		$box = new Box( __METHOD__, [ 'post' ], 'Test Checkbox Field' );
		$box->field( 'meta/prefixed/cf', 'Test 2' )->checkbox();
		do_action( 'cmb2_init' );
		$post = Post_Mock::factory( self::factory()->post->create_and_get() );

		$post['meta/prefixed/cf'] = $value;
		$this->assertSame( $expected, $post->get_meta( 'meta/prefixed/cf' ) );
	}


	public static function provideCheckboxValues(): array {
		return [
			'on'       => [ 'on', true ],
			'off'      => [ 'off', false ],
			'one'      => [ 1, true ],
			'one_str'  => [ '1', true ],
			'zero'     => [ 0, false ],
			'blank'    => [ '', false ],
			'negative' => [ - 1, false ],
			'true'     => [ true, true ],
			'false'    => [ false, false ],
		];
	}
}
