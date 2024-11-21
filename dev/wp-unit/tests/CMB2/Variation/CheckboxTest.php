<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

use Lipe\Lib\CMB2\Box;
use Lipe\Lib\Meta\Registered;

/**
 * @author Mat Lipe
 * @since  July 2024
 *
 */
class CheckboxTest extends \WP_UnitTestCase {

	public function test_default_invalid(): void {
		$box = new Box( 'checkbox-text/default', [ 'post' ], 'Test Box' );

		$this->expectException( \LogicException::class );
		$this->expectExceptionMessage( 'Checkboxes do not support standard default values. checker. See https://github.com/CMB2/CMB2/wiki/Tips-&-Tricks#setting-a-default-value-for-a-checkbox' );

		$box->field( 'checker', 'Checker' )
		    ->checkbox()
		    ->default( 'on' );
	}


	public function test_default(): void {
		$box = new Box( 'checkbox-text/default', [ 'post' ], 'Test Box' );
		$field = $box->field( 'checker', 'Checker' )
		             ->checkbox()
			->default_cb( fn( array $args, \CMB2_Field $field ) => isset( $_GET['post'] ) ? '' : true );

		$this->assertInstanceOf( Checkbox::class, $field );

		do_action( 'cmb2_init' );
		$this->assertTrue( Registered::factory( $field )->get_default( 1 ) );
		$_GET['post'] = 1;
		$this->assertSame( '', Registered::factory( $field )->get_default( 1 ) );

		$this->assertNull( Registered::factory( $field )->get_default() );
	}
}
