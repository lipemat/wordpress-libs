<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Field;

use PHPUnit\Framework\Attributes\RequiresMethod;

/**
 * @author Mat Lipe
 * @since  March 2026
 *
 */
#[RequiresMethod( \CMB2_Bootstrap_2101::class, 'initiate' )]
class TypeTest extends \WP_UnitTestCase {
	public function test_types(): void {
		$external = [ Type::GROUP, Type::TERM_SELECT_2 ];

		foreach ( Type::cases() as $case ) {
			if ( \in_array( $case, $external, true ) ) {
				continue;
			}

			$this->assertTrue( method_exists( \CMB2_Types::class, $case->value ), "Method `{$case->value}` does not exist in CMB2_Types." );
		}
	}
}
