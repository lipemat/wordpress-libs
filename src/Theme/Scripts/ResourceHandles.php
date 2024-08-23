<?php
//phpcs:disable PHPCompatibility.Interfaces.InternalInterfaces.backedenumFound
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

/**
 * Enum rules for managing resources.
 *
 * @since    5.1.0
 */
interface ResourceHandles extends \BackedEnum {

	/**
	 * @return list<string>
	 */
	public function dependencies(): array;


	/**
	 * @phpstan-return Enqueue::BOILER_*
	 *
	 * @return string
	 */
	public function boilerplate(): string;


	/**
	 * The resource file.
	 *
	 * Switching to the minfied version is handled automatically
	 * by `Manifest` and `PCSS_Manifest`.
	 *
	 * @see PCSS_Manifest::get_version()
	 * @see Enqueue::__construct()
	 *
	 * @return string
	 */
	public function file(): string;


	/**
	 * The handle used to register the script with WP.
	 *
	 * Also used to call `ResourceHandles::from()`.
	 *
	 * @return string
	 */
	public function handle(): string;


	/**
	 * Should this resource be enqueued in the admin?
	 *
	 * @return bool
	 */
	public function in_admin(): bool;


	/**
	 * Should this resource be enqueued in the front end?
	 *
	 * @return bool
	 */
	public function in_front_end(): bool;


	/**
	 * Should this resource be enqueued using `enqueue_block_assets` hook?
	 *
	 * @return bool
	 */
	public function is_block_asset(): bool;


	/**
	 * Should this resource be included in the editor?
	 *
	 * @return bool
	 */
	public function in_editor(): bool;


	/**
	 * Should this resource be rendered inline if it is small enough?
	 *
	 * @return bool
	 */
	public function is_inline(): bool;


	/**
	 * Does this resource need to be localized with a JS config?
	 *
	 * @return bool
	 */
	public function with_js_config(): bool;


	/**
	 * Should this resource be enqueued async?
	 *
	 * @return bool
	 */
	public function is_async(): bool;


	/**
	 * Should this resource be enqueued defer?
	 *
	 * @return bool
	 */
	public function is_defer(): bool;


	/**
	 * The URL to the "dist" directory for the resource.
	 *
	 * @return string
	 */
	public function dist_url(): string;


	/**
	 * The path to the "dist" directory for the resource.
	 *
	 * @return string
	 */
	public function dist_path(): string;
}
