<?php

declare( strict_types=1 );

/**
 * @author Mat Lipe
 * @since  June, 2019
 *
 */

namespace Lipe\Lib\CMB2;

use Lipe\Lib\Meta\Repo;
use Lipe\Project\Post_Types\Post;
use mocks\Post_Mock;

class GroupTest extends \WP_UnitTestCase {
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


	public function setUp() : void {
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


	public function tearDown() : void {
		wp_delete_attachment( $this->attachment_id, true );

		parent::tearDown();
	}


	public function test_get_sub_field_data() : void {
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


	public function test_set_sub_field_data() : void {
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


	public function test_delete_sub_field_data() : void {
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
}
