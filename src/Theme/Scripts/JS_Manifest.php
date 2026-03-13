<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use Lipe\Lib\Theme\Resources;
use Lipe\Lib\Theme\Wp_Enqueue_Script;

/**
 * Manifest handling for files from the js-boilerplate.
 *
 * @requires js-boilerplate:v9.2.0+
 *
 * @since    5.1.0
 */
class JS_Manifest implements Manifest {
	/**
	 * @todo Remove this constant in version 6.
	 * @deprecated
	 */
	public const HANDLE = 'lipe/project/theme/scripts/js-manifest';

	/**
	 * Cache of the manifest file.
	 *
	 * @var array<string,string>
	 */
	protected static $manifest = [];


	/**
	 * Instantiate the JS manifest.
	 *
	 * @param ResourceHandles $handle - Current handle from within the JS boilerplate.
	 */
	public function __construct(
		protected readonly ResourceHandles $handle
	) {
	}


	/**
	 * Get a version of the resource from the `hash` in
	 * the manifest file.
	 *
	 * If the hash does not exist, fallback to the root
	 * .revision file.
	 *
	 * @return string
	 */
	public function get_version(): string {
		$manifest = $this->get_json();
		if ( \array_key_exists( $this->handle->file(), $manifest ) ) {
			return $manifest[ $this->handle->file() ]['hash'];
		}
		return (string) Resources::in()->get_revision();
	}


	/**
	 * The integrity of the resource from the `integrity` in
	 * the manifest file.
	 *
	 * @return string
	 */
	public function get_integrity(): string {
		$manifest = $this->get_json();
		if ( \array_key_exists( $this->handle->file(), $manifest ) ) {
			return $manifest[ $this->handle->file() ]['integrity'];
		}
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
		if ( Util::in()->is_javascript_resource( $this->handle ) ) {
			$args = new Wp_Enqueue_Script( [] );
			$args->in_footer = $in_footer;

			if ( $this->handle->is_defer() ) {
				$args->strategy = Wp_Enqueue_Script::STRATEGY_DEFER;
			} elseif ( $this->handle->is_async() ) {
				$args->strategy = Wp_Enqueue_Script::STRATEGY_ASYNC;
			}

			wp_enqueue_script( $this->handle->handle(), $this->get_url(), $this->handle->dependencies(), $this->get_version(), $args->get_args() );

			if ( ! SCRIPT_DEBUG ) {
				Resources::in()->integrity_javascript( $this->handle->handle(), $this->get_integrity() );
				/**
				 * Load the contents of the JS file inline.
				 */
				$registered = wp_scripts()->query( $this->handle->handle() );
				if ( $registered instanceof \_WP_Dependency && $this->handle->is_inline() ) {
					$registered->src = false;
					$registered->extra['data'] = \file_get_contents( $this->get_file( true ) );
				}
			}
		} else {
			/**
			 * Webpack uses `style-loader` during development, so we only load a "JS" based CSS file if Webpack is not running.
			 */
			if ( ! Util::in()->is_webpack_running( $this->handle ) ) {
				wp_enqueue_style( $this->handle->handle(), $this->get_url(), $this->handle->dependencies(), $this->get_version() );
			}

			if ( ! SCRIPT_DEBUG && $this->handle->is_inline() ) {
				/**
				 * Allow WP Core to inline the stylesheet if under 20k.
				 *
				 * @see    wp_maybe_inline_styles
				 */
				wp_style_add_data( $this->handle->handle(), 'path', $this->get_file( true ) );
			}
		}
	}


	/**
	 * Get the URL of this .js file based on:
	 * - SCRIPT_DEBUG
	 * - Webpack running.
	 *
	 * @return string
	 */
	public function get_url(): string {
		// Use webpack on all requests except Legacy Widget iframes.
		if ( SCRIPT_DEBUG && Util::in()->is_webpack_running( $this->handle ) && 0 === \preg_match( '/\/wp-json.*?widget-types./', \trim( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) ) ) ) {
			return set_url_scheme( 'https://' . \trim( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) ) ) . ':3000/js/dist/' . $this->handle->file() );
		}

		$file = $this->handle->file();
		if ( '' !== $file ) {
			return trailingslashit( $this->handle->dist_url() ) . $file;
		}
		return $this->handle->dist_url();
	}


	/**
	 * Return the path of the file relative to the theme.
	 *
	 * @param bool $full_path - Include a full path to the file.
	 *
	 * @return string
	 */
	public function get_file( bool $full_path = false ): string {
		$file = $this->handle->file();
		$path = $this->handle->dist_path();
		if ( '' !== $file ) {
			$path = trailingslashit( $path );
		}
		if ( $full_path ) {
			return $path . $file;
		}

		$path = \str_replace( trailingslashit( get_stylesheet_directory() ), '', $path );
		return "{$path}{$file}";
	}


	/**
	 * @throws \RuntimeException -- If the manifest file is not available.
	 * @return array<string,array{hash:string, integrity:string}>
	 */
	protected function get_json(): array {
		if ( [] === static::$manifest ) {
			try {
				static::$manifest = (array) \json_decode( (string) \file_get_contents( $this->handle->dist_path() . 'manifest.json' ), true, 512, JSON_THROW_ON_ERROR );
			} catch ( \JsonException ) {
				throw new \RuntimeException( 'The JS manifest.json file is not available. You probably need to run `yarn dist`!' );
			}
		}
		return static::$manifest;
	}
}
