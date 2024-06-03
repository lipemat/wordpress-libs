<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

/**
 *
 *
 * @author Mat Lipe
 * @since  4.10.0
 */
interface Box {
	/**
	 * Get the title of the meta box.
	 *
	 * @return string
	 */
	public function get_title(): string;


	/**
	 * Get the ID of the meta box.
	 *
	 * @return string
	 */
	public function get_id(): string;


	/**
	 * The priority within the context where the meta box should show.
	 *
	 * @phpstan-return Meta_Box::PRIORITY_*
	 * @return string
	 */
	public function get_priority(): string;


	/**
	 * The context on the page where the meta box should be shown.
	 *
	 * @phpstan-return Meta_Box::CONTEXT_*
	 * @return string
	 */
	public function get_context(): string;


	/**
	 * Get a list of post types this meta box should be registered for.
	 *
	 * @return string[]
	 */
	public function get_post_types(): array;


	/**
	 * Has this meta box been converted to a Gutenberg panel, and the class
	 * meta box is only being used as a fallback for the classic editor?
	 *
	 * - If true the meta box will only be loaded in the classic editor.
	 * - If false the meta box will be loaded in both the classic and if `is_gutenberg_compatible` will also be loaded in the block editor.
	 *
	 * Sets the `__back_compat_meta_box` meta box flag
	 *
	 * @see  Box::is_gutenberg_compatible()
	 *
	 * @link https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/
	 *
	 * @return bool
	 */
	public function is_classic_editor_fallback(): bool;


	/**
	 * Save the meta box field values.
	 *
	 * @param \WP_Post $post The post being saved.
	 *
	 * @return void
	 */
	public function save( \WP_Post $post ): void;


	/**
	 * Render the meta box contents.
	 *
	 * @param \WP_Post $post - The post being edited.
	 *
	 * @return void
	 */
	public function render( \WP_Post $post ): void;
}
