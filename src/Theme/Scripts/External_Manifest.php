<?php
//phpcs:disable WordPress.WP.EnqueuedResourceParameters.MissingVersion
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use Lipe\Lib\Theme\Resources;
use Lipe\Lib\Theme\Wp_Enqueue_Script;

/**
 * Manifest handling for external resources loaded outside
 * of the resource build process.
 *
 * Think UNPKG or Font Awesome.
 *
 * - No manifest file.
 * - No internal version.
 *
 * @author Mat Lipe
 * @since  5.10.0
 *
 */
class External_Manifest implements Manifest {

	/**
	 * The integrity hash for the resource.
	 *
	 * @var string
	 */
	protected string $integrity = '';


	/**
	 * Instantiate the Manifest.
	 *
	 * @param ResourceHandles $handle - Current handle from within the theme.
	 */
	public function __construct(
		protected readonly ResourceHandles $handle,
	) {
	}


	/**
	 * External resources manage their own versions so browser caching
	 * may be use cross site.
	 *
	 * @return ''
	 */
	public function get_version(): string {
		return '';
	}


	/**
	 * Get the integrity hash for the resource.
	 *
	 * @see static::set_integrity()
	 *
	 * @return string
	 */
	public function get_integrity(): string {
		return $this->integrity;
	}


	/**
	 * Set the integrity hash for the resource.
	 *
	 * Support chaining for simple returns.
	 *
	 * @example `return new External_Manifest( $handle )->set_integrity( $integrity );`
	 *
	 * @param string $integrity - The integrity hash.
	 *
	 * @return $this
	 */
	public function set_integrity( string $integrity ): static {
		$this->integrity = $integrity;
		return $this;
	}


	/**
	 * Get the external resource URL.
	 *
	 * @return string
	 */
	public function get_url(): string {
		$file = $this->handle->file();
		if ( '' !== $file ) {
			return trailingslashit( $this->handle->dist_url() ) . $file;
		}
		return $this->handle->dist_url();
	}


	/**
	 * Goes not have a local path so return an empty string.
	 *
	 * @param bool $full_path - Does not apply to this type of resource.
	 *
	 * @return string
	 */
	public function get_file( bool $full_path = false ): string {
		return '';
	}


	/**
	 * Enqueue the current script or style with WP_Scripts.
	 *
	 * @param bool $in_footer - Load a JS script in the footer. Does not apply to CSS.
	 *
	 * @return void
	 */
	public function enqueue( bool $in_footer = true ): void {
		if ( $this->handle->is_inline() ) {
			_doing_it_wrong( __METHOD__, 'External resources cannot be rendered inline.', '5.10.0' );
		}

		if ( Util::in()->is_javascript_resource( $this->handle ) ) {
			$args = new Wp_Enqueue_Script( [] );
			$args->in_footer = $in_footer;

			if ( $this->handle->is_defer() ) {
				$args->strategy = Wp_Enqueue_Script::STRATEGY_DEFER;
			} elseif ( $this->handle->is_async() ) {
				$args->strategy = Wp_Enqueue_Script::STRATEGY_ASYNC;
			}

			wp_enqueue_script( $this->handle->handle(), $this->get_url(), $this->handle->dependencies(), null, $args->get_args() );

			if ( ! SCRIPT_DEBUG ) {
				Resources::in()->integrity_javascript( $this->handle->handle(), $this->get_integrity() );
			}
		} else {
			wp_enqueue_style( $this->handle->handle(), $this->get_url(), $this->handle->dependencies(), null );
		}
	}
}
