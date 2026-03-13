<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use mocks\ScriptHandles;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @author Mat Lipe
 * @since  March 2026
 *
 */
class UtilTest extends \WP_UnitTestCase {

	#[DataProvider( 'provideHandles' )]
	public function test_is_javascript_resource( ResourceHandles $handle, bool $is_js ): void {
		$this->assertSame( $is_js, Util::in()->is_javascript_resource( $handle ) );
	}


	public static function provideHandles(): array {
		return [
			'admin-js'      => [ 'handle' => ScriptHandles::ADMIN_JS, 'is_js' => true, ],
			'admin-js-css'  => [ 'handle' => ScriptHandles::ADMIN_JS_CSS, 'is_js' => false ],
			'admin-css'     => [ 'handle' => ScriptHandles::ADMIN_CSS, 'is_js' => false ],
			'master-js'     => [ 'handle' => ScriptHandles::MASTER_JS, 'is_js' => true ],
			'master-css'    => [ 'handle' => ScriptHandles::MASTER_CSS, 'is_js' => false ],
			'block-css'     => [ 'handle' => ScriptHandles::BLOCKS_CSS, 'is_js' => false ],
			'front-end-css' => [ 'handle' => ScriptHandles::FRONT_END_CSS, 'is_js' => false ],
			'font-awesome'  => [ 'handle' => ScriptHandles::FONT_AWESOME, 'is_js' => true ],
			'versioned-js'  => [ 'handle' => ScriptHandles::VERSIONED_JS, 'is_js' => true ],
			'versioned-css' => [ 'handle' => ScriptHandles::VERSIONED_CSS, 'is_js' => false ],
		];
	}
}
