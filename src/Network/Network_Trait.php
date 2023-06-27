<?php

namespace Lipe\Lib\Network;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * Interact with a single network on a multi-network install *, or a centralized place
 * to store data for the entire network.
 *
 * Gives quick access to the `sitemeta` table and any
 * other properties available in the `WP_Network` class.
 *
 * @property int    $id
 * @property string $blog_id
 * @property string $cookie_domain
 * @property string $domain
 * @property string $site_name
 * @property string $path
 */
trait Network_Trait {
	use Mutator_Trait;

	/**
	 * ID of this network.
	 *
	 * @var int
	 */
	protected int $network_id;

	/**
	 * Object of this network.
	 *
	 * @var \WP_Network
	 */
	protected $network;


	/**
	 * Construct this class with either the provided network or the current global network.
	 *
	 * @param int|null|\WP_Network $network - Network ID, object or null for the current network.
	 */
	public function __construct( $network = null ) {
		if ( null === $network ) {
			$this->network_id = get_current_network_id();
		} elseif ( is_a( $network, \WP_Network::class ) ) {
			$this->network = $network;
			$this->network_id = $this->network->id;
		} else {
			$this->network_id = (int) $network;
		}
	}


	/**
	 * Get the WP Network object.
	 *
	 * @return \WP_Network|null
	 */
	public function get_object() : ?\WP_Network {
		if ( null === $this->network ) {
			$this->network = get_network( $this->network_id );
		}

		return $this->network;
	}


	/**
	 * Get the network id.
	 *
	 * @return int
	 */
	public function get_id() : int {
		return $this->network_id;
	}


	/**
	 * Get a value from the `sitemeta` table for this network.
	 *
	 * @param string     $key     - Meta key.
	 * @param null|mixed $default - Default value if meta key is not set.
	 *
	 * @return mixed|false
	 */
	public function get_meta( string $key, $default = null ) {
		return get_network_option( $this->network_id, $key, $default );
	}


	/**
	 * Update a value in the `sitemeta` table for this network.
	 *
	 * @param string $key      - Meta key.
	 * @param mixed  ...$value - Value to set.
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
	 * @param string $key - Meta key.
	 */
	public function delete_meta( string $key ) : void {
		delete_network_option( $this->network_id, $key );
	}


	/**
	 * Used to determine the type of meta to retrieve or update.
	 *
	 * @return string
	 */
	public function get_meta_type() : string {
		return 'site';
	}


	/**
	 * Create an instance of this class.
	 *
	 * @param int|null|\WP_Network $network - Network ID, object or null for the current network.
	 *
	 * @return static
	 */
	public static function factory( $network = null ) {
		return new static( $network );
	}

}
