<?php

namespace Lipe\Lib\Site;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * Interact with a single site on a multisite install.
 *
 * Gives quick access to the `blogmeta` table and any
 * other properties available in the `WP_Site` class.
 *
 * @requires WP version 5.1+
 *
 * @author Mat Lipe
 * @since  2.8.0
 *
 */
trait Site_Trait {
	use Mutator_Trait;

	/**
	 * @var int
	 */
	protected $site_id;

	/**
	 * @var \WP_Site
	 */
	protected $site;


	/**
	 * @param int|\WP_Site $site
	 *
	 */
	public function __construct( $site ) {
		if ( is_a( $site, \WP_Site::class ) ) {
			$this->site    = $site;
			$this->site_id = $this->site->site_id;
		} else {
			$this->site_id = $site;
		}
	}


	/**
	 * Ger the WP Site from the current context.
	 *
	 * @return null|\WP_Site
	 */
	public function get_site() : ?\WP_Site {
		if ( null === $this->site ) {
			$this->site = \get_site( $this->site_id );
		}

		return $this->site;
	}


	/**
	 * @return int
	 */
	public function get_id() : int {
		return (int) $this->site_id;
	}


	/**
	 * Get a value from the `blogmeta` table for this site.
	 *
	 * @param string     $key
	 * @param null|mixed $default
	 *
	 * @return mixed|null
	 */
	public function get_meta( string $key, $default = null ) {
		$value = \get_site_meta( $this->site_id, $key, true );
		if ( null !== $default && empty( $value ) ) {
			return $default;
		}

		return $value;
	}


	/**
	 * Update a value in the `blogmeta` table for this site.
	 *
	 * @param string $key
	 * @param  mixed $value
	 */
	public function update_meta( string $key, $value ) : void {
		\update_site_meta( $this->site_id, $key, $value );
	}


	/**
	 * Delete a value from the `blogmeta` table for this site.
	 *
	 * @param string $key
	 */
	public function delete_meta( string $key ) : void {
		\delete_site_meta( $this->site_id, $key );
	}


	/**
	 * @return string
	 */
	public function get_meta_type() : string {
		return 'blog';
	}


	/**
	 *
	 * @param int|\WP_Site $site
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $site ) {
		return new static( $site );
	}

}
