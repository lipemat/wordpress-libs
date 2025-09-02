<?php
declare( strict_types=1 );

namespace mocks;

use Lipe\Lib\Theme\Scripts\Common;
use Lipe\Lib\Theme\Scripts\Enqueue;
use Lipe\Lib\Theme\Scripts\JS_Manifest;
use Lipe\Lib\Theme\Scripts\PCSS_Manifest;
use Lipe\Lib\Theme\Scripts\ResourceHandles;
use Lipe\Lib\Theme\Scripts\Util;

/**
 * Mock a common site setup of enums for testing.
 *
 * @notice Intentially changed the names of some things to test versitiltiy.
 */
enum ScriptHandles: string implements ResourceHandles {
	private const CSS_DIST_PATH = 'css-dist/';
	private const JS_DIST_PATH  = 'js-dist/';

	// Core handles.
	case ADMIN_CSS     = 'lipe/project/theme/admin/css';
	case ADMIN_JS      = 'lipe/project/theme/admin/js';
	case ADMIN_JS_CSS  = 'lipe-project/theme-admin-js-css';
	case BLOCKS_CSS    = 'lipe-project/theme-blocks-css';
	case FRONT_END_CSS = 'lipe/project/theme/front-end/css';
	case MASTER_CSS    = 'lipe/project/theme/master/css';
	case MASTER_JS     = 'lipe/project/theme/master/js';

	// Utility handles.
	case CSS_ENUMS = Common::CSS_ENUM_HANDLE;
	case RUNNING   = Util::RUNNING_HANDLE;


	/**
	 * @return list<string>
	 */
	public function dependencies(): array {
		return match ( $this ) {
			self::ADMIN_JS  => [
				'react',
				'react-dom',
			],

			self::MASTER_JS => [
				'react-dom',
				/**
				 * Optional scripts, which should be removed from enqueue
				 * if they are not used.
				 *
				 * If only used in a particular area, enqueue them there
				 * instead of the entire site.
				 */
				'wp-api-fetch', // Used by @lipemat/js-boilerplate-gutenberg for `wpapi` requests.
				'wp-html-entities', // Used by Search component to decode HTML via `decodeEntities`.
			],
			default         => [],
		};
	}


	/**
	 * @phpstan-return Enqueue::BOILER_*
	 */
	public function boilerplate(): string {
		return match ( $this ) {
			self::ADMIN_CSS,
			self::BLOCKS_CSS,
			self::MASTER_CSS,
			self::CSS_ENUMS,
			self::FRONT_END_CSS => Enqueue::BOILER_PCSS,

			self::ADMIN_JS,
			self::ADMIN_JS_CSS,
			self::MASTER_JS,
			self::RUNNING       => Enqueue::BOILER_JS,
		};
	}


	public function file(): string {
		return match ( $this ) {
			self::ADMIN_CSS,
			self::ADMIN_JS_CSS  => 'admin.css',

			self::ADMIN_JS      => 'admin.js',
			self::BLOCKS_CSS    => 'blocks.css',
			self::FRONT_END_CSS => 'front-end.css',
			self::MASTER_CSS    => 'master.css',
			self::MASTER_JS     => 'master.js',

			self::CSS_ENUMS     => SCRIPT_DEBUG ? 'module-enums.php' : 'module-enums.min.inc',
			self::RUNNING       => '.running'
		};
	}


	public function in_admin(): bool {
		return match ( $this ) {
			self::ADMIN_CSS,
			self::ADMIN_JS,
			self::ADMIN_JS_CSS => true,

			default            => false,
		};
	}


	public function in_front_end(): bool {
		return match ( $this ) {
			self::FRONT_END_CSS,
			self::MASTER_JS,
			self::MASTER_CSS,
			self::BLOCKS_CSS => true,

			default          => false,
		};
	}


	public function is_block_asset(): bool {
		return match ( $this ) {
			self::BLOCKS_CSS => true,

			default          => false,
		};
	}


	public function in_editor(): bool {
		return match ( $this ) {
			self::FRONT_END_CSS => true,

			default             => false,
		};
	}


	public function is_inline(): bool {
		return match ( $this ) {
			self::BLOCKS_CSS => true,

			default          => false,
		};
	}


	public function with_js_config(): bool {
		return match ( $this ) {
			self::ADMIN_JS,
			self::MASTER_JS => true,

			default         => false,
		};
	}


	public function handle(): string {
		return $this->value;
	}


	public function is_async(): bool {
		return match ( $this ) {
			self::MASTER_JS => true,

			default         => false,
		};
	}


	public function is_defer(): bool {
		return false;
	}


	public function get_manifest(): PCSS_Manifest|JS_Manifest {
		if ( Enqueue::BOILER_PCSS === $this->boilerplate() ) {
			return new PCSS_Manifest( $this );
		}
		return new JS_Manifest( $this );
	}


	public function dist_url(): string {
		$path = trailingslashit( get_stylesheet_directory_uri() );
		if ( Enqueue::BOILER_PCSS === $this->boilerplate() ) {
			return trailingslashit( $path . self::CSS_DIST_PATH );
		}
		return trailingslashit( $path . self::JS_DIST_PATH );
	}


	public function dist_path(): string {
		if ( Enqueue::BOILER_PCSS === $this->boilerplate() ) {
			return \dirname( __DIR__ ) . '/data/' . self::CSS_DIST_PATH;
		}
		return \dirname( __DIR__ ) . '/data/' . self::JS_DIST_PATH;
	}
}
