<?php

namespace Lipe\Lib\Meta;

/**
 * Meta interaction support for Object Traits which use the Meta Repo.
 *
 * Also provided \ArrayAccess modifiers if the class which uses this
 * implements \ArrayAccess.
 *
 * If you don't want array keys to be able to modify data, then simply
 * do not give not implement \ArrayAccess on the class and they will
 * not work
 *
 * All methods will manipulate data in the database directly.
 *
 * @author Mat Lipe
 * @since  2.5.0
 *
 */
trait Mutator_Trait {
	/**
	 * Get the object id.
	 *
	 * @example post_id, term_id, user_id, comment_id, site_id, <custom>
	 *
	 * @return mixed
	 */
	abstract public function get_id();


	/**
	 * Get the type of meta that is stored for this object.
	 *
	 * @example 'post','user','comment','term', 'blog', <custom>
	 *
	 * @return string
	 */
	abstract public function get_meta_type() : string;


	/**
	 * Get a value of this object's meta field
	 * using the meta repo to map the appropriate data type.
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public function get_meta( string $key, $default = null ) {
		$value = Repo::instance()->get_value( $this->get_id(), $key, $this->get_meta_type() );
		if ( null !== $default && empty( $value ) ) {
			return $default;
		}

		return $value;
	}


	/**
	 * Update a value of this object's meta field
	 * using the meta repo to map the appropriate data type.
	 *
	 * @param string $key
	 * @param mixed|callable $value - If a callable is passed it will be called with the
	 *                              previous value as the only argument.
	 *
	 * @since 2.12.0 (Support passing a callback as the second argument)
	 *
	 * @return void
	 */
	public function update_meta( string $key, $value ) : void {
		if ( \is_callable( $value ) ) {
			Repo::instance()->update_value( $this->get_id(), $key, $value( $this->get_meta( $key) ), $this->get_meta_type() );
		} else {
			Repo::instance()->update_value( $this->get_id(), $key, $value );
		}
	}


	/**
	 * Delete the value of this object's meta field
	 * using the meta repo to map the appropriate data type.
	 *
	 * @param string $key
	 *
	 * @return void
	 */
	public function delete_meta( string $key ) : void {
		Repo::instance()->delete_value( $this->get_id(), $key, $this->get_meta_type() );
	}


	public function offsetGet( $field_id ) {
		return $this->get_meta( $field_id );
	}


	/**
	 * @param $field_id
	 * @param mixed|callable $value - If a callable is passed it will be called with the
	 *                              previous value as the only argument.
	 *
	 * @since 2.12.0 (Support passing a callback as the second argument)
	 */
	public function offsetSet( $field_id, $value ) : void {
		$this->update_meta( $field_id, $value );
	}


	public function offsetUnset( $field_id ) : void {
		$this->delete_meta( $field_id );
	}


	public function offsetExists( $field_id ) : bool {
		return ! empty( $this->get_meta( $field_id ) );
	}


}
