<?php

declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\Meta\Repo;
use mocks\Post_Mock;

/**
 * @requires function \CMB2_Bootstrap_2101::initiate
 *
 * @link     https://docs.phpunit.de/en/9.5/incomplete-and-skipped-tests.html#skipping-tests-using-requires
 */
class GroupTest extends \WP_Test_REST_TestCase {
	/**
	 * @var \WP_Post
	 */
	private $post;

	/**
	 * @var \WP_Term
	 */
	private $category;

	/**
	 * @var \WP_Term[]
	 */
	private $post_tags;

	private $attachment_id;


	public function setUp(): void {
		parent::setUp();

		$this->post = self::factory()->post->create_and_get();
		$this->category = self::factory()->category->create_and_get();
		$this->post_tags = self::factory()->tag->create_many( 3 );
		$this->attachment_id =
			self::factory()->attachment->create_upload_object( DIR_TEST_IMAGES . '/test-image.png' );
		$b = new Box( 'Y', [ 'post' ], 'Y' );
		$g = $b->group( 'G', 'G' );
		$g->field( 'C', 'Checkbox' )
		  ->checkbox();
		$g->field( 'T', 'Term' )
		  ->taxonomy_select( 'category' );
		$g->field( 'F', 'File' )
		  ->file();
		$g->field( 'TM', 'Term Multiple' )
		  ->taxonomy_multicheck( 'post_tag' );

		do_action( 'cmb2_init' );

		Repo::in()->clear_memoize_cache();
	}


	public function tearDown(): void {
		wp_delete_attachment( $this->attachment_id, true );

		parent::tearDown();
	}


	public function test_get_sub_field_data(): void {
		$object = Post_Mock::factory( $this->post );
		$object['G'] = [
			[
				'C'  => 'on',
				'F'  => $this->attachment_id,
				'T'  => $this->category->term_id,
				'TM' => $this->post_tags,
			],
		];

		$this->assertEquals( [
			'C'    => 'on',
			'F'    => wp_get_attachment_url( $this->attachment_id ),
			'F_id' => $this->attachment_id,
		], get_post_meta( $object->get_id(), 'G', true )[0] );

		$this->assertEquals( [
			'id'  => $this->attachment_id,
			'url' => wp_get_attachment_url( $this->attachment_id ),
		], $object->get_meta( 'G' )[0]['F'] );
		$this->assertEquals( array_map( 'get_term', $this->post_tags ), $object->get_meta( 'G' )[0]['TM'] );
		$this->assertEquals( $this->category->term_id, $object->get_meta( 'G' )[0]['T']->term_id );
		$this->assertTrue( $object->get_meta( 'G' )[0]['C'] );
	}


	public function test_set_sub_field_data(): void {
		$object = Post_Mock::factory( $this->post );
		$object['G'] = [
			[
				'C'  => 'on',
				'F'  => $this->attachment_id,
				'T'  => $this->category->term_id,
				'TM' => $this->post_tags,
			],
		];

		$this->assertEquals( [
			'C'    => 'on',
			'F'    => wp_get_attachment_url( $this->attachment_id ),
			'F_id' => $this->attachment_id,
		], get_post_meta( $object->get_id(), 'G', true )[0] );

		$this->assertEquals( [
			'id'  => $this->attachment_id,
			'url' => wp_get_attachment_url( $this->attachment_id ),
		], $object->get_meta( 'G' )[0]['F'] );
		$this->assertEqualSets( array_map( 'get_term', $this->post_tags ), $object->get_meta( 'G' )[0]['TM'] );
		$this->assertEquals( $this->category->term_id, $object->get_meta( 'G' )[0]['T']->term_id );
		$this->assertTrue( $object->get_meta( 'G' )[0]['C'] );
	}


	public function test_delete_sub_field_data(): void {
		$object = Post_Mock::factory( $this->post );
		$object->update_meta( 'G', [
			[
				'C'  => 'on',
				'F'  => $this->attachment_id,
				'T'  => $this->category->term_id,
				'TM' => $this->post_tags,
			],
		] );

		$this->assertEquals( [
			'id'  => $this->attachment_id,
			'url' => wp_get_attachment_url( $this->attachment_id ),
		], $object->get_meta( 'G' )[0]['F'] );
		$this->assertEquals( array_map( 'get_term', $this->post_tags ), $object->get_meta( 'G' )[0]['TM'] );
		$this->assertEquals( $this->category->term_id, $object->get_meta( 'G' )[0]['T']->term_id );
		$this->assertTrue( $object->get_meta( 'G' )[0]['C'] );

		$object->update_meta( 'G', [
			[
				'C' => 'on',
				'F' => $this->attachment_id,
				'T' => $this->category->term_id,
			],
			[
				'C' => 'on',
				'F' => $this->attachment_id,
			],
		] );

		$this->assertEmpty( $object->get_meta( 'G' )[0]['TM'] );

		$object->update_meta( 'G', [
			[
				'C' => 'on',
				'F' => $this->attachment_id,
			],
			[
				'F' => $this->attachment_id,
			],
		] );
		$this->assertNotEmpty( $object->get_meta( 'G' )[0]['C'] );
		$this->assertEmpty( $object->get_meta( 'G' )[0]['T'] );
		$this->assertNotEmpty( $object->get_meta( 'G' )[1]['F'] );
		$this->assertEmpty( $object->get_meta( 'G' )[1]['C'] );
	}


	public function test_updating_repeatable_group(): void {
		$b = new Box( 'Y', [ 'post' ], 'Y' );
		$g = $b->group( 'R', 'R' );
		$g->repeatable( true );
		$g->field( 'CX', 'Checkbox' )
		  ->checkbox();
		do_action( 'cmb2_init' );
		$object = Post_Mock::factory( $this->post );

		$object->update_meta( 'R', [
			[
				'CX' => 'on',
			],
			[
				'CX' => 'on',
			],
		] );
		$this->assertSame( [
			[
				'CX' => true,
			],
			[
				'CX' => true,
			],
		], $object->get_meta( 'R' ) );

		$object->update_meta( 'R', [
			[
				'CX' => 'on',
			],
		] );
		$this->assertSame( [
			[
				'CX' => true,
			],
		], $object->get_meta( 'R' ) );
	}


	public function test_rest_short_fields(): void {
		$box = new Box( 'rested', [ 'post' ], 'Rested Group' );
		$box->field( 'meta/prefixed/t2', 'Test 2' )
		    ->text();

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->show_in_rest();
		$group
			->field( 'first/things/last', '' )
			->text();
		$group
			->field( 'second/things/after', '' )
			->text();
		do_action( 'cmb2_init' );

		$post = Post_Mock::factory( self::factory()->post->create_and_get() );
		$post['group/prefixed/g3'] = [
			[
				'first/things/last'   => '__last',
				'second/things/after' => '__after',
			],
		];
		$post['meta/prefixed/t2'] = '__t2';
		$result = $this->get_response( '/wp/v2/posts/' . $post->get_id(), [], 'GET' );
		$this->assertSame( [
			'footnotes' => '',
			'g3'        => [
				[
					'first/things/last'   => '__last',
					'second/things/after' => '__after',
				],
			],
		], $result->data['meta'] );

		$box->field( 'meta/prefixed/t2', 'Test 2' )
		    ->text()
		    ->show_in_rest();
		do_action( 'cmb2_init' );
		$result = $this->get_response( '/wp/v2/posts/' . $post->get_id(), [], 'GET' );
		$this->assertSame( [
			'footnotes' => '',
			't2'        => '__t2',
			'g3'        => [
				[
					'first/things/last'   => '__last',
					'second/things/after' => '__after',
				],
			],
		], $result->data['meta'] );

		$group->field( 'first/things/last', '' )
		      ->text()
		      ->rest_short_name();
		do_action( 'cmb2_init' );
		$result = $this->get_response( '/wp/v2/posts/' . $post->get_id(), [], 'GET' );
		$this->assertSame( [
			'footnotes' => '',
			't2'        => '__t2',
			'g3'        => [
				[
					'last'                => '__last',
					'second/things/after' => '__after',
				],
			],
		], $result->data['meta'] );

		$group->field( 'second/things/after', '' )
		      ->text()
		      ->rest_short_name( 'customField' );
		do_action( 'cmb2_init' );
		$result = $this->get_response( '/wp/v2/posts/' . $post->get_id(), [], 'GET' );
		$this->assertSame( [
			'footnotes' => '',
			't2'        => '__t2',
			'g3'        => [
				[
					'last'        => '__last',
					'customField' => '__after',
				],
			],

		], $result->data['meta'] );

		wp_set_current_user( self::factory()->user->create( [
			'role' => 'administrator',
		] ) );
		$result = $this->get_response( '/wp/v2/posts/' . $post->get_id(), [
			'meta' => [
				'g3' => [
					[
						'last'        => '_changed_',
						'customField' => '_also-changed_',
					],
				],
			],
		] );
		$this->assertNotErrorResponse( $result );
		$this->assertSame( '_changed_', $post['first/things/last'] );
		$this->assertSame( '_also-changed_', $post['second/things/after'] );

		$post['group/prefixed/g3'] = [
			[
				'last'        => '_not_during_rest_',
				'customField' => '_not_during_rest_',
			],
		];
		$this->assertNull( $post['first/things/last'] );
		$this->assertNull( $post['second/things/after'] );
	}


	public function test_sortable(): void {
		$box = new Box( 'sortable', [ 'post' ], 'Sortable Group' );
		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->field( 'first/things/last', '' )->text();
		do_action( 'cmb2_init' );

		$this->assertArrayNotHasKey( 'sortable', get_private_property( $group, 'options' ) );

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->sortable();
		$this->assertTrue( get_private_property( $group, 'options' )['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->sortable( false );
		$this->assertFalse( get_private_property( $group, 'options' )['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$this->assertArrayNotHasKey( 'sortable', get_private_property( $group, 'options' ) );
		$group->repeatable();
		$this->assertTrue( get_private_property( $group, 'options' )['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->repeatable( false );
		$this->assertFalse( get_private_property( $group, 'options' )['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->sortable( false );
		$group->repeatable();
		$this->assertFalse( get_private_property( $group, 'options' )['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->sortable();
		$group->repeatable( false );
		$this->assertTrue( get_private_property( $group, 'options' )['sortable'] );
	}


	public function test_sortable_rendered(): void {
		$box = new Box( 'sortable', [ 'post' ], 'Sortable Group' );

		$group = $box->group( 'group/prefixed/g5', 'Group 3' );
		$group->sortable();
		$group->repeatable( false );
		$this->assertTrue( get_private_property( $group, 'options' )['sortable'] );
		$group->field( 'group/prefixed/g5/first', '' )->text();

		do_action( 'cmb2_init' );
		$rendered = get_echo( function() {
			cmb2_get_field( 'sortable', 'group/prefixed/g5' )->render_field();
		} );
		$this->assertStringContainsString( 'sortable', $rendered );
		$this->assertStringNotContainsString( 'non-sortable', $rendered );

		$group = $box->group( 'group/prefixed/g6', 'Group 3' );
		$group->field( 'group/prefixed/g6/first', '' )->text();
		$group->repeatable( false );
		$this->assertFalse( get_private_property( $group, 'options' )['sortable'] );
		do_action( 'cmb2_init' );
		$rendered = get_echo( function() {
			cmb2_get_field( 'sortable', 'group/prefixed/g6' )->render_field();
		} );
		$this->assertStringContainsString( 'non-sortable', $rendered );
		$this->assertStringNotContainsString( ' sortable ', $rendered );
	}


	public function test_repeatable_group_access(): void {
		$box = new Box( 'repeatable', [ 'post' ], 'Repeatable Group' );
		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->repeatable( true );
		$group->field( 'first/things/last', '' )->text();
		$group->field( 'second/things/after', '' )->text();
		do_action( 'cmb2_init' );

		$post = Post_Mock::factory( self::factory()->post->create_and_get() );
		$post['group/prefixed/g3'] = [
			[
				'first/things/last'   => '__last',
				'second/things/after' => '__after',
			],
			[
				'first/things/last'   => '__last2',
				'second/things/after' => '__after2',
			],
		];

		$this->assertSame( '__last', $post['group/prefixed/g3'][0]['first/things/last'] );
		$this->assertSame( '__after', $post['group/prefixed/g3'][0]['second/things/after'] );
		$this->expectDoingItWrong( 'Lipe\Lib\Meta\Validation::warn_for_repeatable_group_sub_fields', 'Accessing sub-fields on repeatable groups will only read/update the first item. Use the group key instead. second/things/after (This message was added in version 4.10.0.)' );
		$this->assertSame( '__after', $post['second/things/after'] );
	}


	public function test_repeatable_with_unsupported_field(): void {
		$box = new Box( 'repeatable', [ 'page' ], 'Repeatable Group' );
		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->repeatable();
		$group->field( 'ruf/first', '' )->taxonomy_select( 'category' );

		$catch = false;
		try {
			do_action( 'cmb2_init' );
		} catch ( \LogicException $e ) {
			$catch = true;
			$this->assertSame( 'Taxonomy fields are not supported by repeating groups. ruf/first', $e->getMessage() );
		} finally {
			$this->assertTrue( $catch );
		}

		$group->repeatable( false );
		do_action( 'cmb2_init' );

		$this->expectDoingItWrong( 'Lipe\Lib\Meta\Validation::warn_for_conflicting_taxonomies', 'Fields: "ruf/first, ruf/last" are conflicting on the taxonomy: category for object type: page. You may only have taxonomy field per an object. (This message was added in version 4.10.0.)' );
		$group->field( 'ruf/last', '' )->taxonomy_select_hierarchical( 'category' );
		do_action( 'cmb2_init' );

		$group->repeatable( true );
		$catch = false;
		try {
			do_action( 'cmb2_init' );
		} catch ( \LogicException $e ) {
			$catch = true;
			$this->assertSame( 'Taxonomy fields are not supported by repeating groups. ruf/first', $e->getMessage() );
		} finally {
			$this->assertTrue( $catch );
		}
	}
}
