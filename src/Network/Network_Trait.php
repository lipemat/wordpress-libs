<?php

namespace Lipe\Lib\Network;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * Interact with a single network on a multi-network install
 *, or a centralized place to store data for the entire network.
 *
 * Gives quick access to the `sitemeta` table and any
 * other properties available in the `WP_Network` class.
 *
 * @author   Mat Lipe
 * @since    2.19.0
 *
 * @property int    $id
 * @property int    $site_id
 * @property string $blog_id
 * @property string $cookie_domain
 * @property string $domain
 * @property string $site_name
 * @property string path
 *
 */
trait Network_Trait {
	use Mutator_Trait;

	/**
	 * @var int
	 */
	protected $network_id;

	/**
	 * @var \WP_Network
	 */
	protected $network;


	/**
	 * @param int|null|\WP_Network $network
	 *
	 */
	public function __construct( $network = null ) {
		if ( null === $network ) {
			$this->network_id  = get_current_network_id();
		} elseif ( is_a( $network, \WP_Network::class ) ) {
			$this->network = $network;
			$this->network_id = $this->network->id;
		} else {
			$this->network_id = $network;
		}
	}


	public function get_object() : ?\WP_Network {
		if ( null === $this->network ) {
			$this->network = get_network( $this->network_id );
		}

		return $this->network;
	}


	/**
	 * @return int
	 */
	public function get_id() : int {
		return (int) $this->network_id;
	}


	/**
	 * Get a value from the `sitemeta` table for this network.
	 *
	 * @param string     $key
	 * @param null|mixed $default
	 *
	 * @return mixed|null
	 */
	public function get_meta( string $key, $default = null ) {
		return get_network_option( $this->network_id, $key, $default );
	}


	/**
	 * Update a value in the `sitemeta` table for this network.
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public function update_meta( string $key, ...$value ) : void {
		if ( \is_callable( $value[0] ) ) {
			$value[0] = $value[0]( $this->get_meta( $key, $value[1] ?? null ) );
		}
		update_network_option( $this->network_id, $key, $value[0] );
	}


	/**
	 * Delete a value from the `sitemeta` table for this network.
	 *
	 * @param string $key
	 */
	public function delete_meta( string $key ) : void {
		delete_network_option( $this->network_id, $key );
	}


	/**
	 * @return string
	 */
	public function get_meta_type() : string {
		return 'site';
	}


	/**
	 *
	 * @param int|null|\WP_Network $network
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $network = null ) {
		return new static( $network );
	}

}
