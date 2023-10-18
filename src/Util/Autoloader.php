<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Autoload class files from namespaced folders
 *
 * Load a namespaced folder from a specified directory.
 *
 * @example load a namespaced folder from root dir
 *          Autoloader::add( "Products\\", __DIR__ . '/Products' );
 */
class Autoloader {
	use Singleton;

	/**
	 * Map of registered namespaces and their path.
	 *
	 * Stored as `[ [<namespace>, <path>] ]` to allow the same namespace to be
	 * registered multiple times with different paths.
	 *
	 * @var array<array<string>>
	 */
	protected array $namespaces = [];


	/**
	 * Registers the autoloader on the first construct.
	 */
	public function __construct() {
		$this->register();
	}


	/**
	 * Add a namespace to the shared autoloader.
	 *
	 * @param string $name_space - Namespace classes belong to.
	 * @param string $path       - Path of the classes.
	 *
	 * @return void
	 */
	public static function add( string $name_space, string $path ): void {
		static::instance()->add_namespace( $name_space, $path );
	}


	/**
	 * Registers this instance as an autoloader.
	 *
	 * @param bool $prepend - Add the autoloader to beginning of stack.
	 *
	 * @return void
	 */
	public function register( bool $prepend = true ): void {
		spl_autoload_register( [ $this, 'maybe_load_class' ], true, $prepend );
	}


	/**
	 * Removes this instance from the registered autoloader.
	 */
	public function unregister(): void {
		spl_autoload_unregister( [ $this, 'maybe_load_class' ] );
	}


	/**
	 * Add a namespace to the autoloader lookup.
	 *
	 * @param string $name_space - Namespace classes belong to.
	 * @param string $path       - Path of the classes.
	 *
	 * @return void
	 */
	protected function add_namespace( string $name_space, string $path ): void {
		$name_space = trim( $name_space, '\\' ) . '\\';
		$path = rtrim( $path, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;
		$this->namespaces[] = [ $name_space, $path ];
	}


	/**
	 * Load a class if its namespace is registered, and the
	 * class file is found.
	 *
	 * @param string $class_name - Name of the class to attempt to load.
	 *
	 * @return bool
	 */
	protected function maybe_load_class( string $class_name ): bool {
		$file = $this->find_file( $class_name );
		if ( null !== $file ) {
			require $file;

			return true;
		}

		return false;
	}


	/**
	 * Look through the registered namespaces and path to
	 * see if we have a class file we can load.
	 *
	 * @param string $class_name - Name of the class we are looking for.
	 *
	 * @return ?string
	 */
	protected function find_file( string $class_name ): ?string {
		$class_name = \ltrim( $class_name, '\\' );

		foreach ( $this->namespaces as $current ) {
			[ $prefix, $base_dir ] = $current;

			if ( \str_starts_with( $class_name, $prefix ) ) {
				$name = \substr( $class_name, \strlen( $prefix ) );
				$file = $base_dir . \str_replace( '\\', DIRECTORY_SEPARATOR, $name ) . '.php';

				if ( \file_exists( $file ) ) {
					return $file;
				}
			}
		}

		return null;
	}
}
