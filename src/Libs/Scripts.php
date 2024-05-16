<?php
declare( strict_types=1 );

namespace Lipe\Lib\Libs;

use Lipe\Lib\Traits\Singleton;

/**
 * Internal class for managing styles for wordpress-libs
 *
 * @author Mat Lipe
 * @since  4.9.0
 *
 * @internal
 */
class Scripts {
	use Singleton;

	public const STYLE_CHECKBOX     = 'checkbox';
	public const STYLE_GROUP_LAYOUT = 'group-layout';

	protected const EDITOR_SCRIPT   = 'lipe/lib/libs/scripts/editor';
	protected const JS_DEPENDENCIES = [
		'wp-components',
		'wp-edit-post',
		'wp-i18n',
		'wp-data',
	];


	/**
	 * Enqueue an internal CSS file.
	 *
	 * @phpstan-param self::STYLE_* $file
	 *
	 * @param string                $file - Name of the file to enqueue.
	 *
	 * @return void
	 */
	public function enqueue_style( string $file ): void {
		$dir = trailingslashit( plugin_dir_url( \dirname( __DIR__ ) ) ) . 'css/';
		\wp_enqueue_style( 'lipe/lib/libs/styles/' . $file, $dir . $file . '.css', [], $this->get_version() );
	}


	/**
	 * Using the enqueue_block_assets hook assures styles are loaded:
	 * 1. In block editors.
	 * 2. In iframe block editors.
	 * 3. On the front-end.
	 * We skip #3 because we want the block styles to load on the front-end
	 * after the front-end.css file is loaded.
	 *
	 * @link   https://make.wordpress.org/core/2023/07/18/miscellaneous-editor-changes-in-wordpress-6-3/#post-editor-iframed
	 *
	 * @action enqueue_block_assets 11 0
	 */
	public function editor_scripts(): void {
		if ( ! is_admin() ) {
			return;
		}
		$dir = plugin_dir_url( \dirname( __DIR__ ) ) . 'js/dist/';
		if ( SCRIPT_DEBUG && $this->is_webpack_running() ) {
			$dir = set_url_scheme( 'https://' . sanitize_text_field( \wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) ) . ':3000/js/dist/' );
		}
		wp_enqueue_script( static::EDITOR_SCRIPT, "{$dir}admin.js", static::JS_DEPENDENCIES, $this->get_version(), true );
		wp_localize_script( static::EDITOR_SCRIPT, 'LIPE_LIBS_CONFIG', $this->js_config() );
	}


	/**
	 * Get the version of wordpress-libs.
	 *
	 * @return string
	 */
	protected function get_version(): string {
		return (string) file_get_contents( \dirname( __DIR__, 2 ) . '/VERSION' );
	}


	/**
	 * Is webpack currently running on this environment?
	 *
	 * - If SCRIPT_DEBUG is false, we always return false.
	 * - Not on a local environment is always false.
	 * - Check for the `.running` Webpack Dev file.
	 *
	 * @requires js-boilerplate:v9.2.0+
	 *
	 * @return bool
	 */
	protected function is_webpack_running(): bool {
		if ( ! SCRIPT_DEBUG || 'local' !== wp_get_environment_type() ) {
			return false;
		}
		return file_exists( plugin_dir_path( \dirname( __DIR__ ) ) . 'js/dist/.running' );
	}


	/**
	 * JS configuration passed to the admin script.
	 *
	 * @return array{
	 *     isGutenberg: bool,
	 * }
	 */
	protected function js_config(): array {
		return [
			'isGutenberg' => \function_exists( 'get_current_screen' ) && null !== get_current_screen() && get_current_screen()->is_block_editor,
		];
	}
}
