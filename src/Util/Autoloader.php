<?php

namespace Lipe\Lib\Util;

/**
 * Autoload class files from namespaced folders
 *
 * load a namespaced folder from root dir
 *
 * @example load a namespaced folder from root dir
 *          Autoloader::add( "Products\\", __DIR__ . '/Products' );
 *
 */
class Autoloader {
	/**
	 * instance
	 *
	 * @var Autoloader
	 */
	private static $instance;

	/**
	 * @var array
	 */
	private $prefixes = [];


	public static function add( $prefix, $path ) : void {
		$instance = self::get_loader();
		$instance->addPrefix( $prefix, $path );
	}


	/**
	 * @static
	 *
	 * @return Autoloader
	 */
	private static function get_loader() : Autoloader {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->register( true );
		}

		return self::$instance;
	}


	/**
	 * Registers this instance as an autoloader.
	 *
	 * @param bool $prepend
	 */
	public function register( $prepend = false ) : void {
		/** @phpstan-ignore-next-line */
		spl_autoload_register( [ $this, 'loadClass' ], true, $prepend );
	}


	/**
	 * @param string $prefix
	 * @param string $base_directory
	 */
	public function addPrefix( string $prefix, string $base_directory ) : void {
		$prefix = trim( $prefix, '\\' ) . '\\';
		$base_directory = rtrim( $base_directory, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;
		$this->prefixes[] = [ $prefix, $base_directory ];
	}


	/**
	 * @param string $class
	 *
	 * @return bool
	 */
	public function loadClass( string $class ) : bool {
		$file = $this->find_file( $class );
		if ( null !== $file ) {
			require $file;

			return true;
		}

		return false;
	}


	/**
	 * @param string $class
	 *
	 * @return string|null
	 */
	public function find_file( string $class ) : ?string {
		$class = ltrim( $class, '\\' );

		foreach ( $this->prefixes as $current ) {
			[ $prefix, $base_dir ] = $current;
			if ( 0 === strpos( $class, $prefix ) ) {
				$name = substr( $class, \strlen( $prefix ) );
				$file = $base_dir . str_replace( '\\', DIRECTORY_SEPARATOR, $name ) . '.php';
				if ( file_exists( $file ) ) {
					return $file;
				}
			}
		}
		return null;
	}


	/**
	 * Removes this instance from the registered autoloader.
	 */
	public function unregister() : void {
		spl_autoload_unregister( [ $this, 'loadClass' ] );
	}

}
