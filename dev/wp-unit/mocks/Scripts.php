<?php
declare( strict_types=1 );

namespace mocks;

use Lipe\Lib\Theme\Scripts\Config;

/**
 * Mock a Scripts class.
 *
 */
final class Scripts implements Config {
	public function js_config(): array {
		return [];
	}

}
