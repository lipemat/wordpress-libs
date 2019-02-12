<?php

namespace Lipe\Lib\Meta;

/**
 * Meta interaction support for Object Traits which use the Meta Repo.
 * Also provided Arrayacesss modifiers.
 *
 * @author Mat Lipe
 * @since  2.5.0
 *
 */
trait Mutator_Trait {
	abstract public function get_id();


	abstract public function get_meta_type() : string;


	public function offsetGet( string $field_id ) {
		return $this->get_meta( $field_id );
	}


	public function offsetSet( string $field_id, $value ) : void {
		$this->update_meta( $field_id, $value );
	}


	public function offsetUnset( string $field_id ) : void {
	}


	public function offsetExists( string $field_id ) : bool {
		return ! empty( $this->get_meta( $field_id ) );
	}


	/**
	 * Get a value of this post's meta field
	 * using the meta repo to map the appropriate data type.
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key, $default = null ) {
		$value = Repo::instance()->get_value( $this->get_id(), $key, $this->get_meta_type() );
		if ( null !== $default && empty( $value ) ) {
			return $default;
		}

		return $value;
	}


	/**
	 * Update a value of this post's meta field
	 * using the meta repo to map the appropriate data type.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 *
	 * @return void
	 */
	public function update_meta( string $key, $value ) : void {
		Repo::instance()->update_value( $this->get_id(), $key, $value, $this->get_meta_type() );
	}


}
