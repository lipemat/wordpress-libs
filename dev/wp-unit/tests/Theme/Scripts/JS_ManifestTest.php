<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use mocks\ScriptHandles;

/**
 * @author Mat Lipe
 * @since  May 2026
 *
 */
class JS_ManifestTest extends \WP_UnitTestCase {
	protected function setUp(): void {
		parent::setUp();

		add_filter( 'stylesheet_directory', fn() => $this->getStylesheetDirectory() );
	}


	public function test_enqueue_inline(): void {
		$this->assertTrue( ScriptHandles::INLINE_JS->is_inline() );
		Enqueue::factory( ScriptHandles::INLINE_JS )->enqueue();

		$script = tests_get_echo( fn() => wp_scripts()->do_item( ScriptHandles::INLINE_JS->handle() ) );
		$this->assertStringContainsString( 'Inlined and ok with it', $script );
		$this->assertStringNotContainsString( 'src=', $script );
	}


	public function test_enqueue_inline_localized(): void {
		$this->assertTrue( ScriptHandles::INLINE_JS->is_inline() );
		Enqueue::factory( ScriptHandles::INLINE_JS )->enqueue();

		wp_localize_script( ScriptHandles::INLINE_JS->handle(), 'INLINED', [ 'munch' => 'before' ] );

		$script = tests_get_echo( fn() => wp_scripts()->do_item( ScriptHandles::INLINE_JS->handle() ) );
		$this->assertStringContainsString( 'Inlined and ok with it', $script );
		$this->assertStringContainsString( 'var INLINED = {"munch":"before"};', $script );
		$this->assertTrue( \strpos( $script, 'var INLINED = {"munch":"before"};' ) < \strpos( $script, 'Inlined and ok with it' ) );
	}


	public function test_enqueue_inline_script_after(): void {
		$this->assertTrue( ScriptHandles::INLINE_JS->is_inline() );
		Enqueue::factory( ScriptHandles::INLINE_JS )->enqueue();

		wp_add_inline_script( ScriptHandles::INLINE_JS->handle(), 'var AFTER = "after";', 'after' );

		$script = tests_get_echo( fn() => wp_scripts()->do_item( ScriptHandles::INLINE_JS->handle() ) );
		$this->assertStringContainsString( 'Inlined and ok with it', $script );
		$this->assertStringContainsString( 'var AFTER = "after";', $script );
		$this->assertTrue( \strpos( $script, 'var AFTER = "after";' ) > \strpos( $script, 'Inlined and ok with it' ) );
	}


	public function test_enqueue_inline_script_before(): void {
		$this->assertTrue( ScriptHandles::INLINE_JS->is_inline() );
		Enqueue::factory( ScriptHandles::INLINE_JS )->enqueue();

		wp_add_inline_script( ScriptHandles::INLINE_JS->handle(), 'var BEFORE = "before";', 'before' );

		$script = tests_get_echo( fn() => wp_scripts()->do_item( ScriptHandles::INLINE_JS->handle() ) );
		$this->assertStringContainsString( 'Inlined and ok with it', $script );
		$this->assertStringContainsString( 'var BEFORE = "before";', $script );
		$this->assertTrue( \strpos( $script, 'var BEFORE = "before";' ) < \strpos( $script, 'Inlined and ok with it' ) );
	}


	private function getStylesheetDirectory(): string {
		return \dirname( __DIR__, 3 ) . '/data/';
	}
}
