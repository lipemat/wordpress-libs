<?php
declare( strict_types=1 );

namespace Lipe\Lib;

/**
 * @author Mat Lipe
 * @since  February 2026
 *
 */
class InitTest extends \WP_UnitTestCase {
	/**
	 * Confirm backward compatibility aliases are working as expected.
	 *
	 * @todo Remove in version 6.
	 */
	public function test_alias(): void {
		$this->assertTrue( \class_exists( CMB2\BoxType::class ) );
		$this->assertTrue( \class_exists( CMB2\Default_Callback::class ) );
		$this->assertTrue( \trait_exists( CMB2\Display::class ) );
		$this->assertTrue( \class_exists( CMB2\Event_Callbacks::class ) );
		$this->assertTrue( \class_exists( CMB2\Field_Type::class ) );

		$this->assertSame( CMB2\Box\BoxType::POST, CMB2\BoxType::POST );
		$this->assertTrue( \is_a( CMB2\Default_Callback::class, CMB2\Field\Default_Callback::class, true ) );
		$this->assertTrue( \is_a( CMB2\Display::class, CMB2\Field\Display::class, true ) );
		$this->assertTrue( \is_a( CMB2\Event_Callbacks::class, CMB2\Field\Event_Callbacks::class, true ) );
		$this->assertTrue( \is_a( CMB2\Field_Type::class, CMB2\Field\Field_Type::class, true ) );
	}
}
