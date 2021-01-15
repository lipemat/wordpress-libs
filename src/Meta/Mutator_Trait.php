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
	 * Access any property which exists on the child Object.
	 *
	 * Extended properties may be accessed by providing a
	 * `get_extended_properties` method which returns a list
	 * of additional properties.
	 *
	 * @param string $property - Property to retrieve.
	 *
	 * @throws \ErrorException
	 * @return mixed
	 */
	public function __get( string $property ) {
		if ( ! \method_exists( $this, 'get_object' ) ) {
			throw new \ErrorException( 'Direct access to object properties is only available for objects with `get_object`: ' . __CLASS__ . ":{$property}" );
		}
		$object = $this->get_object();
		if ( null !== $object && ( \property_exists( $object, $property ) || ( \property_exists( $object, 'data' ) && \property_exists( $object->data, $property ) ) ) ) {
			return $object->{$property};
		}
		if ( \method_exists( $this, 'get_extended_properties' ) && \in_array( $property, $this->get_extended_properties(), true ) ) {
			return $object->{$property};
		}

		throw new \ErrorException( 'Undefined property: ' . __CLASS__ . ":{$property}" );
	}


	/**
	 * Call any method which exists on the child Object
	 *
	 * @param string $name - Name of the method.
	 * @param array $arguments - Passed arguments
	 *
	 * @throws \ErrorException
	 * @return mixed
	 */
	public function __call( $name, $arguments ) {
		if ( ! \method_exists( $this, 'get_object' ) ) {
			throw new \ErrorException( 'Direct access to object methods is only available for objects with `get_object`: ' . __CLASS__ . ":{$name}" );
		}
		$object = $this->get_object();
		if ( null !== $object && ( \method_exists( $object, $name ) ) ) {
			return $object->{$name}( ...$arguments );
		}
		throw new \ErrorException( 'Method does not exist: ' . __CLASS__ . ":{$name}" );
	}


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
	 * @param string         $key
	 * @param mixed|callable $value - If a callable is passed it will be called with the
	 *                              previous value as the only argument.
	 * @param mixed                 If a callable is passed with an additional argument,
	 *                              it be be used as the default value for `$this->get_meta()`.
	 *
	 * @return void
	 */
	public function update_meta( string $key, ...$value ) : void {
		if ( \is_callable( $value[0] ) ) {
			$value[0] = $value[0]( $this->get_meta( $key, $value[1] ?? null ) );
		}
		Repo::instance()->update_value( $this->get_id(), $key, $value[0], $this->get_meta_type() );
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
	 * @param                $field_id
	 * @param mixed|callable $value - If a callable is passed it will be called with the
	 *                              previous value as the only argument.
	 *
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
