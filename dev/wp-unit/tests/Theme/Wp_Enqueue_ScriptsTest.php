<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

/**
 * @author Mat Lipe
 * @since  April 2024
 *
 */
class Wp_Enqueue_ScriptsTest extends \WP_UnitTestCase {

	public function test_args(): void {
		$args = new Wp_Enqueue_Script( [] );
		$args->strategy = 'defer';
		$args->in_footer = true;
		$this->assertSame( [
			'strategy'  => 'defer',
			'in_footer' => true,
		], $args->get_args() );

		$args->strategy = 'async';
		$args->in_footer = false;
		$this->assertSame( [
			'strategy'  => 'async',
			'in_footer' => false,
		], $args->get_args() );

		$args = new Wp_Enqueue_Script( [
			'strategy'  => 'defer',
			'in_footer' => true,
		] );
		$this->assertSame( [
			'strategy'  => 'defer',
			'in_footer' => true,
		], $args->get_args() );

		$args = new Wp_Enqueue_Script( [] );
		$args->in_footer = true;
		$this->assertSame( [
			'in_footer' => true,
		], $args->get_args() );
	}
}
