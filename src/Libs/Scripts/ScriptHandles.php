<?php
declare( strict_types=1 );

namespace Lipe\Lib\Libs\Scripts;

use Lipe\Lib\CMB2\Box\Tabs;
use Lipe\Lib\Taxonomy\Meta_Box\Gutenberg_Box;

/**
 * Holder of script handles and their configurations.
 *
 * @author Mat Lipe
 * @since  4.10.0
 */
enum ScriptHandles: string {
	case ADMIN        = 'lipe/lib/scripts/admin';
	case BLOCK_EDITOR = 'lipe/lib/scripts/block-editor';


	/**
	 * Get the dependencies for this script.
	 *
	 * @return list<string>
	 */
	public function dependencies(): array {
		return match ( $this ) {
			self::ADMIN        => [
				'jquery',
			],
			self::BLOCK_EDITOR => [
				'react',
				'wp-components',
				'wp-core-data',
				'wp-data',
				'wp-edit-post',
				'wp-i18n',
				'wp-plugins',
			],
		};
	}


	/**
	 * JS configuration for this handle.
	 *
	 * Returns a list of JS variables, and their values to be localized.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function js_config(): array {
		return match ( $this ) {
			self::ADMIN        => [
				'LIPE_LIBS_ADMIN_CONFIG' => [
					'cmb2BoxTabs' => [
						'field' => Tabs::TAB_FIELD,
					],
				],
			],
			self::BLOCK_EDITOR => [
				'LIPE_LIBS_BLOCK_EDITOR_CONFIG' => [
					'taxonomyMetaBoxes' => Gutenberg_Box::get_boxes(),
				],
			],
		};
	}


	/**
	 * Get the file name for this script.
	 *
	 * @return string
	 */
	public function file(): string {
		return match ( $this ) {
			self::ADMIN        => 'admin',
			self::BLOCK_EDITOR => 'block-editor',
		};
	}
}
