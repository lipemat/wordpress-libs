<?php
declare( strict_types=1 );

namespace Lipe\Lib\Site;

use Lipe\Lib\Meta\MetaType;
use Lipe\Lib\Meta\Mutator_Trait;
use Lipe\Lib\Meta\Repo;

/**
 * Interact with a single site on a multisite installation.
 *
 * Gives quick access to the `blogmeta` table and any
 * other properties available in the `WP_Site` class.
 *
 * @property int    $id
 * @property int    $network_id
 * @property string $archived
 * @property string $deleted
 * @property string $domain
 * @property string $lang_id
 * @property string $last_updated
 * @property string $mature
 * @property string $path
 * @property string $public
 * @property string $registered
 * @property string $site_id
 * @property string $spam
 * @property string $blogname
 * @property string $home
 * @property int    $post_count
 * @property string $siteurl
 *
 * @template OPTIONS of array<string, mixed>
 */
trait Site_Trait {
	/**
	 * @use Mutator_Trait<OPTIONS>
	 */
	use Mutator_Trait;

	/**
	 * Site ID.
	 *
	 * @var int
	 */
	protected $blog_id;

	/**
	 * Site object.
	 *
	 * @var \WP_Site
	 */
	protected $site;


	/**
	 * Construct this class with either site object or site ID.
	 *
	 * @param int|null|\WP_Site $site - Site object, ID, or null for current site..
	 */
	public function __construct( $site = null ) {
		if ( null === $site ) {
			$this->blog_id = \get_current_blog_id();
		} elseif ( is_a( $site, \WP_Site::class ) ) {
			$this->site = $site;
			$this->blog_id = (int) $this->site->blog_id;
		} else {
			$this->blog_id = (int) $site;
		}
	}


	/**
	 * Get the site object.
	 *
	 * @return \WP_Site|null
	 */
	public function get_object(): ?\WP_Site {
		if ( null === $this->site ) {
			$this->site = \get_site( $this->blog_id );
		}

		return $this->site;
	}


	/**
	 * Get the site ID.
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->blog_id;
	}


	/**
	 * Used to determine the type of meta to retrieve or update.
	 *
	 * @return MetaType
	 */
	public function get_meta_type(): MetaType {
		return MetaType::BLOG;
	}


	/**
	 * Access to extended properties from WP_Site.
	 *
	 * @see \WP_Site::__get
	 * @see Mutator_Trait::__get
	 *
	 * @return array
	 */
	protected function get_extended_properties(): array {
		return [
			'id',
			'network_id',
			'blogname',
			'siteurl',
			'post_count',
			'home',
		];
	}


	/**
	 * Create a new instance of this class.
	 *
	 * @param int|\WP_Site|null $site - Site object, ID, or null for current site..
	 *
	 * @return static
	 */
	public static function factory( null|int|\WP_Site $site = null ): static {
		return new static( $site );
	}
}
