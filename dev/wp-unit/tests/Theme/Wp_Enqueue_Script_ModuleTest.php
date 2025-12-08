<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

/**
 * @author Mat Lipe
 * @since  December 2025
 *
 */
class Wp_Enqueue_Script_ModuleTest extends \WP_UnitTestCase {

	public function test_get_args(): void {
		$args = new Wp_Enqueue_Script_Module( [] );
		$this->assertSame( [], $args->get_args() );

		$args = new Wp_Enqueue_Script_Module( [] );
		$args->fetchpriority = Wp_Enqueue_Script::FETCH_PRIORITY_HIGH;
		$this->assertSame( [
			'fetchpriority' => 'high',
		], $args->get_args() );

		$args = new Wp_Enqueue_Script_Module( [
			'in_footer'     => true,
			'fetchpriority' => Wp_Enqueue_Script::FETCH_PRIORITY_LOW,
		] );
		$this->assertSame( [
			'in_footer'     => true,
			'fetchpriority' => 'low',
		], $args->get_args() );
	}
}
