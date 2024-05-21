<?php
declare( strict_types=1 );

namespace Lipe\Lib\Libs;

use Lipe\Lib\Libs\Scripts\ScriptHandles;
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
	 * Enqueue an internal JS file.
	 *
	 * @param ScriptHandles $script - Script to enqueue.
	 *
	 * @return void
	 */
	public function enqueue_script( ScriptHandles $script ): void {
		$dir = plugin_dir_url( \dirname( __DIR__ ) ) . 'js/dist/';
		if ( SCRIPT_DEBUG && $this->is_webpack_running() ) {
			$dir = set_url_scheme( 'https://starting-point.loc:3000/js/dist/' );
			wp_enqueue_script( 'lipe/lib/scripts/runtime', $dir . 'runtime.js', [], $this->get_version(), true );
		}

		wp_enqueue_script( $script->value, "{$dir}{$script->file()}.js", [], $this->get_version(), [
			'in_footer' => true,
		] );

		// Only localize the script if it has not already been localized, so the variables do not double up.
		if ( false === wp_scripts()->get_data( $script->value, 'data' ) ) {
			$localized = $script->js_config();
			foreach ( $localized as $name => $data ) {
				wp_localize_script( $script->value, $name, $data );
			}
		}
	}

	/**
	 * Is the current screen the block editor?
	 *
	 * @return bool
	 */
	public function is_block_editor(): bool {
		return \function_exists( 'get_current_screen' ) && null !== get_current_screen() && get_current_screen()->is_block_editor;
	}

	/**
	 * Get the version of wordpress-libs.
	 *
	 * @return string
	 */
	protected function get_version(): string {
		return \trim( (string) file_get_contents( \dirname( __DIR__, 2 ) . '/VERSION' ) );
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
}
