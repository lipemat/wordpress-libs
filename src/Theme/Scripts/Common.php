<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use Lipe\Lib\Theme\Resources;
use Lipe\Lib\Traits\Memoize;
use Lipe\Project\Theme\Handles;

/**
 * Common resource loading and configuration shared cross site.
 *
 * Scripts may be conditionally excluded, and their dependencies
 * using the `ResourceHandles` enum.
 *
 * @since    5.1.0
 *
 * @see      Handles - For configuring which scripts load.
 */
class Common {
	use Memoize;

	/**
	 * @todo Remove this constant in version 6.
	 * @deprecated
	 */
	public const CSS_ENUM_HANDLE = 'lipe/project/theme/css-enums';


	/**
	 * Instantiate the Common class with the required dependencies.
	 *
	 * @param ResourceHandles[] $handles - Array of resource handles.
	 * @param Config            $scripts - Scripts class which supports a `js_config` method.
	 */
	final protected function __construct(
		protected readonly array $handles,
		protected readonly Config $scripts,
	) {
	}


	/**
	 * Add the actions and filters for the class.
	 *
	 * @return Common
	 */
	public function init_once(): Common {
		return $this->static_once( function() {
			add_action( 'after_setup_theme', [ $this, 'load_css_enums' ] );
			add_action( 'after_setup_theme', [ $this, 'support_block_inline_styles' ] );
			add_action( 'init', [ $this, 'include_styles_in_editor' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ], 11 );
			add_action( 'enqueue_block_assets', [ $this, 'block_scripts' ], 11 );
			add_action( 'wp_enqueue_scripts', [ $this, 'theme_scripts' ], 11 );
			add_filter( 'wp_headers', [ $this, 'revision_header' ] );
			add_action( 'wp_head', [ $this, 'remove_scripts' ], - 1 );

			return $this;
		}, __METHOD__ );
	}


	/**
	 * Remove superfluous scripts added by WP core.
	 *
	 * @action wp_head -1 0
	 *
	 * @return void
	 */
	public function remove_scripts(): void {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		// WordPress 6.3 <=.
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		// WordPress 6.4+.
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );

		// Remove jquery-migrate.
		$jquery = wp_scripts()->query( 'jquery' );
		if ( ! $jquery instanceof \_WP_Dependency ) {
			return;
		}
		$jquery->deps = \array_diff( $jquery->deps, [ 'jquery-migrate' ] );
	}


	/**
	 * Include the front-end styles in Gutenberg.
	 * Styles are converted to `<style>` tags wrapped in `.editor-styles-wrapper`.
	 *
	 * @notice Must refresh browser to see changes.
	 *
	 * @action init 10 0
	 *
	 * @return void
	 */
	public function include_styles_in_editor(): void {
		foreach ( $this->handles as $resource ) {
			if ( ! $resource->in_editor() ) {
				continue;
			}
			add_theme_support( 'editor-styles' );
			$enum = Enqueue::factory( $resource );
			add_editor_style( $enum->get_file() );

			/**
			 * Use regular expression to strip out the sourcemap, otherwise the
			 * sources point to random files.
			 */
			add_filter( 'block_editor_settings_all', function( $settings ) use ( $enum ) {
				$settings['styles'] = \array_map( function( $style ) use ( $enum ) {
					if ( \array_key_exists( 'baseURL', $style ) && $enum->get_manifest()->get_url() === $style['baseURL'] ) {
						$style['css'] = \preg_replace( '/\/\*# sourceMap.*?\*\//', '', $style['css'] );
					}
					return $style;
				}, $settings['styles'] );
				return $settings;
			} );
		}
	}


	/**
	 * Use on demand block stylesheet loading.
	 *
	 * @link https://make.wordpress.org/core/2021/07/01/block-styles-loading-enhancements-in-wordpress-5-8/
	 * @link https://make.wordpress.org/core/2025/03/24/new-filter-should_load_block_assets_on_demand-in-6-8/
	 *
	 * @return void
	 */
	public function support_block_inline_styles(): void {
		$return_true = __return_true( ... );
		// Previous filter covers both WP core and custom blocks.
		add_filter( 'should_load_separate_core_block_assets', $return_true );

		// New WP 6.8 filters, separate for WP core and custom blocks.
		add_filter( 'should_load_separate_core_block_assets', $return_true );
		add_filter( 'should_load_block_assets_on_demand', $return_true );

		/**
		 * Use stylesheets instead of inline styles for WP core blocks when
		 * SCRIPT_DEBUG is true.
		 */
		if ( SCRIPT_DEBUG ) {
			add_filter( 'styles_inline_size_limit', __return_zero( ... ) );
		}
	}


	/**
	 * @action admin_enqueue_scripts 11 0
	 */
	public function admin_scripts(): void {
		foreach ( $this->handles as $resource ) {
			if ( ! $resource->in_admin() ) {
				continue;
			}

			Enqueue::factory( $resource )->enqueue();

			if ( $resource->with_js_config() ) {
				add_action( 'admin_print_footer_scripts', function() use ( $resource ) {
					wp_localize_script( $resource->handle(), 'CORE_CONFIG', $this->scripts->js_config() );
				}, 1 );
			}
		}
	}


	/**
	 * Using the enqueue_block_assets hook assures styles are loaded:
	 * 1. In block editors.
	 * 2. In iframe block editors.
	 * 3. On the front-end.
	 *
	 * @link   https://make.wordpress.org/core/2023/07/18/miscellaneous-editor-changes-in-wordpress-6-3/#post-editor-iframed
	 *
	 * @action enqueue_block_assets 11 0
	 */
	public function block_scripts(): void {
		foreach ( $this->handles as $resource ) {
			if ( ! $resource->is_block_asset() ) {
				continue;
			}
			Enqueue::factory( $resource )->enqueue();
		}
	}


	/**
	 * @action wp_enqueue_scripts 11 0
	 */
	public function theme_scripts(): void {
		foreach ( $this->handles as $resource ) {
			if ( ! $resource->in_front_end() ) {
				continue;
			}

			Enqueue::factory( $resource )->enqueue();

			if ( $resource->with_js_config() ) {
				add_action( 'wp_print_footer_scripts', function() use ( $resource ) {
					wp_localize_script( $resource->handle(), 'CORE_CONFIG', $this->scripts->js_config() );
				}, 1 );
			}
		}
	}


	/**
	 * Add a "Revision" header to the response, which matches
	 * the latest `.revision` file's Git version.
	 *
	 * @filter wp_headers 10 1
	 *
	 * @param array<string, string> $headers - Included headers.
	 *
	 * @return array<string, string>
	 */
	public function revision_header( array $headers ): array {
		$revision = Resources::in()->get_revision();
		if ( null !== $revision ) {
			$headers['Revision'] = $revision;
		}
		return $headers;
	}


	/**
	 * Load the CSS enums available in postcss-boilerplate version 4.9.0+.
	 *
	 * @action     init 10 0
	 *
	 * @return void
	 */
	public function load_css_enums(): void {
		// @phpstan-ignore classConstant.deprecated
		$enum = $this->handles[0]::tryFrom( self::CSS_ENUM_HANDLE );

		if ( null === $enum ) {
			if ( SCRIPT_DEBUG ) {
				require trailingslashit( get_stylesheet_directory() ) . 'css/module-enums.php';
			} else {
				require trailingslashit( get_stylesheet_directory() ) . 'css/dist/module-enums.min.inc';
			}
		} else {
			_deprecated_argument( __METHOD__, '5.7.0', 'Using the `CSS_ENUM_HANDLE`, constant is deprecated and will be removed in version 6.' );
			if ( SCRIPT_DEBUG ) {
				require get_stylesheet_directory() . '/css/' . $enum->file();
			} else {
				require $enum->dist_path() . $enum->file();
			}
		}
	}


	/**
	 * Instantiate the Common class with the required dependencies.
	 *
	 * @param ResourceHandles[] $handles - Array of resource handles.
	 * @param Config            $scripts - Scripts class which supports a `js_config` method.
	 */
	public static function factory( array $handles, Config $scripts ): static {
		return new static( $handles, $scripts );
	}
}
