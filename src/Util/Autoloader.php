<?php

namespace Lipe\Lib\Util;

/**
 * Autoloader
 *
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


	public static function add( $prefix, $path ) {
		$instance = self::get_loader();
		$instance->addPrefix( $prefix, $path );
	}


	/**
	 * get_loader
	 *
	 * @static
	 *
	 * @return \Lipe\Lib\Util\Autoloader
	 */
	private static function get_loader() {
		if ( empty( self::$instance ) ) {
			self::$instance = new Autoloader();
			self::$instance->register( true );
		}

		return self::$instance;
	}


	/**
	 * Registers this instance as an autoloader.
	 *
	 * @param bool $prepend
	 */
	public function register( $prepend = false ) {
		spl_autoload_register( [ $this, 'loadClass' ], true, $prepend );
	}


	/**
	 * @param string $prefix
	 * @param string $baseDir
	 */
	public function addPrefix( $prefix, $baseDir ) {
		$prefix = trim( $prefix, '\\' ) . '\\';
		$baseDir = rtrim( $baseDir, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;
		$this->prefixes[] = [ $prefix, $baseDir ];
	}


	/**
	 * @param string $class
	 *
	 * @return bool
	 */
	public function loadClass( $class ) {
		$file = $this->findFile( $class );
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
	public function findFile( $class ) {
		$class = ltrim( $class, '\\' );

		foreach ( $this->prefixes as $current ) {
			list( $currentPrefix, $currentBaseDir ) = $current;
			if ( 0 === strpos( $class, $currentPrefix ) ) {
				$classWithoutPrefix = substr( $class, strlen( $currentPrefix ) );
				$file = $currentBaseDir . str_replace( '\\', DIRECTORY_SEPARATOR, $classWithoutPrefix ) . '.php';
				if ( file_exists( $file ) ) {
					return $file;
				}
			}
		}
	}


	/**
	 * Removes this instance from the registered autoloaders.
	 */
	public function unregister() {
		spl_autoload_unregister( [ $this, 'loadClass' ] );
	}

} 