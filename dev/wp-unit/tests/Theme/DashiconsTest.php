<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

/**
 * @author Mat Lipe
 * @since  June 2024
 *
 */
class DashiconsTest extends \WP_UnitTestCase {

	public function test_icon(): void {
		$this->assertSame( '<i class="dashicons dashicons-admin-appearance"></i>', Dashicons::ADMIN_APPEARANCE->icon() );
		$this->assertSame( '<i class="dashicons dashicons-admin-links"></i>', Dashicons::ADMIN_LINKS->icon() );
		$this->assertSame( '<i class="dashicons dashicons-admin-plugins"></i>', Dashicons::ADMIN_PLUGINS->icon() );
	}
}
