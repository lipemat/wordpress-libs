<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Group;

use Lipe\Lib\CMB2\Box;
use Lipe\Lib\CMB2\Group;
use Lipe\Lib\Libs\Scripts\ScriptHandles;
use Lipe\WP_Unit\Utils\PrivateAccess;

/**
 * @author Mat Lipe
 * @since  April 2026
 *
 */
class Max_RowsTest extends \WP_UnitTestCase {
	public function test_js_config(): void {
		$box = new Box( 'no-title', [ 'post' ], null );
		$box->group( 'mx', 'MX' )
		    ->repeatable( true )
		    ->max_rows( 2 );
		$box->group( 'mx2', 'MX2' )
		    ->repeatable( true )
		    ->max_rows( 7 );

		cmb2_get_metabox_form( $box->get_cmb2_box() );

		$script = wp_scripts()->query( ScriptHandles::ADMIN->value );
		$this->assertStringContainsString( 'var LIPE_LIBS_CMB2_GROUP_MAX_ROWS = [{"groupId":"mx","limit":2},{"groupId":"mx2","limit":7}];', $script->extra['data'] );
	}


	public function test_js_config_multiple_boxes(): void {
		$box = new Box( 'no-title', [ 'post' ], null );
		$box->group( 'mx', 'MX' )
		    ->repeatable( true )
		    ->max_rows( 2 );
		$box->group( 'mx2', 'MX2' )
		    ->repeatable( true )
		    ->max_rows( 7 );

		$box_2 = new Box( 'another', [ 'post' ], null );
		$box_2->group( 'mx3', 'MX3' )
		      ->repeatable( true )
		      ->max_rows( 10 );

		cmb2_get_metabox_form( $box->get_cmb2_box() );

		$script = wp_scripts()->query( ScriptHandles::ADMIN->value );
		$this->assertStringContainsString( 'var LIPE_LIBS_CMB2_GROUP_MAX_ROWS = [{"groupId":"mx","limit":2},{"groupId":"mx2","limit":7},{"groupId":"mx3","limit":10}];', $script->extra['data'] );
	}


	public function test_register(): void {
		$box = new Box( 'no-title', [ 'post' ], null );
		$box->group( 'mx', 'MX' )
		    ->repeatable( true );
		$box->field( 'text', 'TX' )
		    ->text();

		/** @var Group $group */
		$group = PrivateAccess::in()->get_private_property( $box, 'fields' )['mx'];

		cmb2_get_metabox_form( $box->get_cmb2_box() );
		$this->assertFalse( wp_script_is( ScriptHandles::ADMIN->value, 'enqueued' ) );

		$group->max_rows( 2 );
		cmb2_get_metabox_form( $box->get_cmb2_box() );
		$this->assertTrue( wp_script_is( ScriptHandles::ADMIN->value, 'enqueued' ) );
	}


	public function test_register_no_repeatable(): void {
		$box = new Box( 'no-title', [ 'post' ], null );
		$box->group( 'no-repeat', 'MX' )
		    ->repeatable( false )
		    ->max_rows( 2 );

		cmb2_get_metabox_form( $box->get_cmb2_box() );

		$this->assertFalse( wp_script_is( ScriptHandles::ADMIN->value, 'enqueued' ) );

		$script = wp_scripts()->query( ScriptHandles::ADMIN->value );
		$this->assertFalse( $script );
	}
}
