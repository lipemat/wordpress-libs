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
			self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/test-image.png' );
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


	public function test_updating_repeable_group(): void {
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
			'g3'        => [
				[
					'first/things/last'   => '__last',
					'second/things/after' => '__after',
				],
			],
			't2'        => '__t2',
		], $result->data['meta'] );

		$group->field( 'first/things/last', '' )
		      ->text()
		      ->rest_group_short();
		do_action( 'cmb2_init' );
		$result = $this->get_response( '/wp/v2/posts/' . $post->get_id(), [], 'GET' );
		$this->assertSame( [
			'footnotes' => '',
			'g3'        => [
				[
					'last'                => '__last',
					'second/things/after' => '__after',
				],
			],
			't2'        => '__t2',
		], $result->data['meta'] );

		$group->field( 'second/things/after', '' )
		      ->text()
		      ->rest_group_short( 'customField' );
		do_action( 'cmb2_init' );
		$result = $this->get_response( '/wp/v2/posts/' . $post->get_id(), [], 'GET' );
		$this->assertSame( [
			'footnotes' => '',
			'g3'        => [
				[
					'last'        => '__last',
					'customField' => '__after',
				],
			],
			't2'        => '__t2',
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


	public function test_doing_short_group_wrong(): void {
		$box = new Box( 'rested', [ 'post' ], 'Rested Group' );
		$box->field( 'meta/prefixed/t2', 'Test 2' )
		    ->text()
		    ->rest_group_short();

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->show_in_rest();
		$group->field( 'first/things/last', '' )
		      ->text()
		      ->show_in_rest()
		      ->rest_group_short();

		$this->expectDoingItWrong( Field::class . '::rest_group_short', "Group short fields only apply to a group's child field. `meta/prefixed/t2` is not applicable. (This message was added in version 4.10.0.)" );
		$this->expectDoingItWrong( Field::class . '::show_in_rest', "Show in rest may only be added to whole group. Not a group's field. `first/things/last` is not applicable. (This message was added in version 2.19.0.)" );
	}


	public function test_sortable(): void {
		$box = new Box( 'sortable', [ 'post' ], 'Sortable Group' );
		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->field( 'first/things/last', '' )->text();
		do_action( 'cmb2_init' );

		$this->assertArrayNotHasKey( 'sortable', $group->options );

		$group = $box->group( 'group/prefixed/g3', 'Group 3', null, null, null, true );
		$this->assertTrue( $group->options['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3', null, null, null, false );
		$this->assertFalse( $group->options['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$this->assertArrayNotHasKey( 'sortable', $group->options );
		$group->repeatable( true );
		$this->assertTrue( $group->options['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3' );
		$group->repeatable( false );
		$this->assertFalse( $group->options['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3', null, null, null, false );
		$group->repeatable( true );
		$this->assertFalse( $group->options['sortable'] );

		$group = $box->group( 'group/prefixed/g3', 'Group 3', null, null, null, true );
		$group->repeatable( false );
		$this->assertTrue( $group->options['sortable'] );
	}


	public function test_sortable_rendered(): void {
		$box = new Box( 'sortable', [ 'post' ], 'Sortable Group' );

		$group = $box->group( 'group/prefixed/g5', 'Group 3', null, null, null, true );
		$group->repeatable( false );
		$this->assertTrue( $group->options['sortable'] );
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
		$this->assertFalse( $group->options['sortable'] );
		do_action( 'cmb2_init' );
		$rendered = get_echo( function() {
			cmb2_get_field( 'sortable', 'group/prefixed/g6' )->render_field();
		} );
		$this->assertStringContainsString( 'non-sortable', $rendered );
		$this->assertStringNotContainsString( ' sortable ', $rendered );
	}
}
