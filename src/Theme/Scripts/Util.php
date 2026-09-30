<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use Lipe\Lib\Container\Instance;

/**
 * Utility functions for working with manifest driven resources.
 *
 * @since    5.1.0
 */
class Util {
	use Instance;

	/**
	 * Detected ports keyed by the `.running` file they were read from.
	 *
	 * Cached to prevent reading for every file.
	 *
	 * @var array<string, int>
	 */
	protected array $ports = [];


	/**
	 * Is webpack currently running on this environment?
	 *
	 * - If SCRIPT_DEBUG is false, we always return false.
	 * - Not on a local environment is always false.
	 * - Check for the `.running` Webpack Dev file.
	 *
	 * @requires js-boilerplate:v9.2.0+
	 *
	 * @param ResourceHandles $handle - The handles to check.
	 *
	 * @return bool
	 */
	public function is_webpack_running( ResourceHandles $handle ): bool {
		if ( ! SCRIPT_DEBUG || 'local' !== wp_get_environment_type() ) {
			return false;
		}
		return \file_exists( $handle->dist_path() . '.running' );
	}


	/**
	 * Get the port a Node process (Webpack dev server, LiveReload, etc.) is
	 * running on for the provided handle.
	 *
	 * The port is read from the `.running` file generated within the handle's
	 * dist directory. Each Git worktree picks its own port, so the value is
	 * read rather than assumed. Falls back to `$default_port` when the handle
	 * is `null` or the `.running` file is missing or invalid.
	 *
	 * @requires js-boilerplate:v11.2.0+
	 * @requires postcss-boilerplate:v5.1.0+
	 *
	 * @param ResourceHandles|null $handle       - The handle to read the port for.
	 * @param int                  $default_port - Port to use when none can be resolved.
	 *
	 * @return int
	 */
	public function get_node_process_port( ?ResourceHandles $handle, int $default_port ): int {
		if ( null === $handle ) {
			return $default_port;
		}

		$file = $handle->dist_path() . '.running';
		if ( isset( $this->ports[ $file ] ) ) {
			return $this->ports[ $file ];
		}
		$this->ports[ $file ] = $default_port;

		if ( ! \is_readable( $file ) ) {
			return $this->ports[ $file ];
		}

		try {
			$data = (array) \json_decode( (string) \file_get_contents( $file ), true, 512, JSON_THROW_ON_ERROR );
		} catch ( \JsonException ) {
			return $this->ports[ $file ];
		}
		if ( isset( $data['port'] ) && \is_numeric( $data['port'] ) ) {
			$this->ports[ $file ] = (int) $data['port'];
		}
		return $this->ports[ $file ];
	}


	/**
	 * Get the URL a Node process (Webpack dev server, Vite, etc.) is serving
	 * the provided handle from.
	 *
	 * The Node process listens on the site's host using its own port, so any
	 * port already on the host is dropped. Sites served from a ported domain,
	 * like `https://localhost:9084`, would otherwise produce a URL holding
	 * two ports.
	 *
	 * @since 6.1.0
	 *
	 * @param ResourceHandles|null $handle       - The handle to read the port for.
	 * @param int                  $default_port - Port to use when none can be resolved.
	 * @param string               $path         - Path to append to the URL, including a leading slash.
	 *
	 * @return string
	 */
	public function get_node_process_url( ?ResourceHandles $handle, int $default_port, string $path = '' ): string {
		return set_url_scheme( '//' . $this->get_host() . ':' . $this->get_node_process_port( $handle, $default_port ) . $path );
	}


	/**
	 * Get a host name with any port removed.
	 *
	 * Local dev servers are commonly served from a ported domain, which makes
	 * `HTTP_HOST` hold something like `localhost:9084`. Anything appending its
	 * own port must work from the bare host name.
	 *
	 * @since 6.1.0
	 *
	 * @param string|null $host - Host to strip the port from. Defaults to the current request's host.
	 *
	 * @return string
	 */
	public function get_host( ?string $host = null ): string {
		$host = \trim( $host ?? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) ) );
		if ( '' === $host ) {
			return '';
		}
		$parsed = wp_parse_url( '//' . $host, PHP_URL_HOST );
		return \is_string( $parsed ) ? $parsed : $host;
	}


	/**
	 * Detect if we're working with a javascript resource.
	 *
	 * - Supports URL containing or not containing separate file names.
	 * - Supports URL containing or not a query string.
	 *
	 * @since 5.10.0
	 *
	 * @param ResourceHandles $handle - Handle to check.
	 *
	 * @return bool
	 */
	public function is_javascript_resource( ResourceHandles $handle ): bool {
		$file = $handle->file();
		if ( '' === $file ) {
			$file = $handle->dist_url();
		}
		$part = \strtok( $file, '?' );
		if ( false === $part ) {
			return false;
		}
		return \str_ends_with( $part, '.js' );
	}
}
