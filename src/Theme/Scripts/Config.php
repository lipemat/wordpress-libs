<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

interface Config {
	/**
	 * Configuration passed to the browser via `CORE_CONFIG`.
	 *
	 * @return array<string, mixed>
	 */
	public function js_config(): array;
}
