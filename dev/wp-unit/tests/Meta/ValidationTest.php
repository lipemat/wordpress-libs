<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Box;
use mocks\Post_Mock;

/**
 * @author Mat Lipe
 * @since  May 2024
 *
 */
class ValidationTest extends \WP_UnitTestCase {
	public function warn_for_repeatable_group_sub_fields(): void {
		$box = new Box( __METHOD__, [ 'post' ], 'Test Repeatable Group Sub Fields' );
		$group = $box->group( 'group/repeatable/group', 'Group' );
		$group->field( 'group/repeatable/group/1', 'Field 1' )->text();
		do_action( 'cmb2_init' );

		$this->assertSame( '', Post_Mock::factory()['group/repeatable/group/1'] );

		$group->repeatable();
		do_action( 'cmb2_init' );
		$this->expectDoingItWrong( '\Lipe\Lib\Meta\Validation::warn_for_repeatable_group_sub_fields' );
	}


	public function test_warn_for_conflicting_taxonomies(): void {
		$box = new Box( __METHOD__, [ 'post' ], 'Test Taxonomy Field' );
		$box->field( 'taxonomy/sr/1', 'SR 1' )
		    ->taxonomy_select( 'category' );
		do_action( 'cmb2_init' );

		// Add a second taxonomy field.
		$srg = $box->group( 'taxonomy/sr/group', 'SR Group' );
		$srg->field( 'taxonomy/sr/group/1', 'SR Group 1' )
		    ->taxonomy_select( 'category' );

		$this->expectDoingItWrong( 'Lipe\Lib\Meta\Validation::warn_for_conflicting_taxonomies', 'Fields: "taxonomy/sr/1, taxonomy/sr/group/1" are conflicting on the taxonomy: category for object type: post. You may only have taxonomy field per an object. (This message was added in version 4.10.0.)' );
		do_action( 'cmb2_init' );

		// Change one field to text.
		add_action( 'doing_it_wrong_run', function() {
			throw new \Exception( 'Doing it wrong called!' );
		} );
		$box->field( 'taxonomy/sr/1', 'SR 1' )->text();
		do_action( 'cmb2_init' );
	}


	public function test_warn_for_conflicting_taxonomies_select_2(): void {
		$box = new Box( __METHOD__, [ 'post' ], 'Test Taxonomy Field' );
		$box->field( 'taxonomy/sr/1', 'SR 1' )
		    ->taxonomy_select( 'category' );
		do_action( 'cmb2_init' );

		// Select2 can turn off assign terms.
		$box->field( 'taxonomy/sr/6', 'SR 7' )
		    ->taxonomy_select_2( 'category', true );
		$this->expectDoingItWrong( 'Lipe\Lib\Meta\Validation::warn_for_conflicting_taxonomies', 'Fields: "taxonomy/sr/1, taxonomy/sr/6" are conflicting on the taxonomy: category for object type: post. You may only have taxonomy field per an object. (This message was added in version 4.10.0.)' );
		do_action( 'cmb2_init' );

		// Turn off assigning of terms.
		add_action( 'doing_it_wrong_run', function() {
			throw new \Exception( 'Doing it wrong called!' );
		} );
		$box->field( 'taxonomy/sr/6', 'SR 7' )
		    ->taxonomy_select_2( 'category', false );
		do_action( 'cmb2_init' );
	}
}
