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
 * @author   Mat Lipe
 * @since    2.8.0
 *
 * @property int    $id
 * @property int    $network_id
 * @property string $blogname
 * @property string $siteurl
 * @property int    $post_count
 * @property string $home
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
	 * @param int|null|\WP_Site $site
	 *
	 */
	public function __construct( $site = null ) {
		if ( null === $site ) {
			$this->site_id = \get_current_blog_id();
		} elseif ( is_a( $site, \WP_Site::class ) ) {
			$this->site = $site;
			$this->site_id = $this->site->site_id;
		} else {
			$this->site_id = $site;
		}
	}


	/**
	 * @deprecated In favor of $this->get_object()
	 */
	public function get_site() : ?\WP_Site {
		return $this->get_object();
	}


	public function get_object() : ?\WP_Site {
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
	 * @return string
	 */
	public function get_meta_type() : string {
		return 'blog';
	}


	/**
	 *
	 * @param int|null|\WP_Site $site
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $site = null ) {
		return new static( $site );
	}

}
