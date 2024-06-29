<?php
//phpcs:disable WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid -- ArrayAccess methods are camelCase.
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

/**
 * Meta interaction support for Object Traits which use the Meta Repo.
 *
 * Also provided \ArrayAccess modifiers if the class which uses this
 * implements \ArrayAccess.
 *
 * If you don't want array keys to be able to modify data, then simply
 * do not give not implement \ArrayAccess on the class, and they will
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
	 * Get the type of meta used with this object.
	 *
	 * Used to determine the type of meta to retrieve or update.
	 *
	 * @phpstan-return Repo::META_*
	 *
	 * @example 'post','user','comment','term', 'blog', 'option'
	 *
	 * @return string
	 */
	abstract public function get_meta_type(): string;


	/**
	 * Access any property, which exists on the child Object.
	 *
	 * Extended properties may be accessed by providing a
	 * `get_extended_properties` method, which returns a list
	 * of additional properties.
	 *
	 * @param string $name - Property to retrieve.
	 *
	 * @throws \ErrorException - If `get_object` method is not available.
	 * @return mixed
	 */
	public function __get( string $name ) {
		if ( ! \method_exists( $this, 'get_object' ) ) {
			/* translators: {property name} */
			throw new \ErrorException( sprintf( esc_html__( 'Direct access to object properties is only available for objects with `get_object`:%s', 'lipe' ), __CLASS__ . ':' . esc_html( $name ) ) );
		}
		$object = $this->get_object();
		if ( null !== $object && ( \property_exists( $object, $name ) || ( \property_exists( $object, 'data' ) && \property_exists( $object->data, $name ) ) ) ) {
			return $object->{$name};
		}
		if ( \method_exists( $this, 'get_extended_properties' ) && \in_array( $name, $this->get_extended_properties(), true ) ) {
			return $object->{$name};
		}
		/* translators: {property name} */
		throw new \ErrorException( sprintf( esc_html__( 'Undefined property: %s', 'lipe' ), __CLASS__ . ':' . esc_html( $name ) ) );
	}


	/**
	 * Set value of any property, which exists on the child Object.
	 *
	 * @param string $name  - Property to set.
	 * @param mixed  $value - Value to set.
	 *
	 * @throws \ErrorException - If `get_object` method not available.
	 *
	 * @return void
	 */
	public function __set( string $name, $value ) {
		if ( ! \method_exists( $this, 'get_object' ) ) {
			/* translators: {property name} */
			throw new \ErrorException( sprintf( esc_html__( 'Direct access to object properties is only available for objects with `get_object`: %s', 'lipe' ), __CLASS__ . ':' . esc_html( $name ) ) );
		}
		$object = $this->get_object();
		if ( null !== $object && ( \property_exists( $object, $name ) || ( \property_exists( $object, 'data' ) && \property_exists( $object->data, $name ) ) ) ) {
			$object->{$name} = $value;
		}
	}


	/**
	 * Call any method, which exists on the child Object
	 *
	 * @param string $name      - Name of the method.
	 * @param array  $arguments - Passed arguments.
	 *
	 * @throws \ErrorException - If method does not exist.
	 *
	 * @return mixed
	 */
	public function __call( string $name, array $arguments ) {
		if ( ! \method_exists( $this, 'get_object' ) ) {
			/* translators: {property name} */
			throw new \ErrorException( sprintf( esc_html__( 'Direct access to object methods is only available for objects with `get_object`: %s', 'lipe' ), __CLASS__ . ':' . esc_html( $name ) ) );
		}
		$object = $this->get_object();
		if ( null !== $object && ( \method_exists( $object, $name ) ) ) {
			return $object->{$name}( ...$arguments );
		}
		/* translators: {property name} */
		throw new \ErrorException( sprintf( esc_html__( 'Method does not exist: %s', 'lipe' ), __CLASS__ . ':' . esc_html( $name ) ) );
	}


	/**
	 * Get a value of this object's meta field
	 * using the meta repo to map the appropriate data type.
	 *
	 * @param string     $key           - Meta key to retrieve.
	 * @param mixed|null $default_value - Default value to return if meta is empty.
	 *
	 * @return mixed
	 */
	public function get_meta( string $key, mixed $default_value = null ): mixed {
		Repo::in()->pre_update_field( $key );

		$value = Repo::in()->get_value( $this->get_id(), $key, $this->get_meta_type() );
		if ( null !== $default_value && empty( $value ) ) {
			return $default_value;
		}

		return $value;
	}


	/**
	 * Update a value of this object's meta field
	 * using the meta repo to map the appropriate data type.
	 *
	 * @param string         $key      - Meta key to update.
	 * @param mixed|callable ...$value - If a callable is passed it will be called with the
	 *                                 previous value as the only argument.
	 *                                 If a callable is passed with an additional argument,
	 *                                 it will be used as the default value for `$this->get_meta()`.
	 *
	 * @return void
	 */
	public function update_meta( string $key, ...$value ): void {
		Repo::in()->pre_update_field( $key );

		if ( \is_callable( $value[0] ) ) {
			$value[0] = $value[0]( $this->get_meta( $key, $value[1] ?? null ) );
		}
		Repo::instance()->update_value( $this->get_id(), $key, $value[0], $this->get_meta_type() );
	}


	/**
	 * Delete the value of this object's meta field
	 * using the meta repo to map the appropriate data type.
	 *
	 * @param string $key - Meta key to delete.
	 *
	 * @return void
	 */
	public function delete_meta( string $key ): void {
		Repo::in()->pre_update_field( $key );

		Repo::instance()->delete_value( $this->get_id(), $key, $this->get_meta_type() );
	}


	/**
	 * Get meta value by key.
	 *
	 * @param string $field_id - Meta key to retrieve.
	 *
	 * @return mixed
	 */
	public function offsetGet( $field_id ): mixed {
		return $this->get_meta( $field_id );
	}


	/**
	 * Update meta value by key.
	 *
	 * @param string         $field_id - Meta key to update.
	 * @param mixed|callable $value    - If a callable is passed it will be called with the
	 *                                 previous value as the only argument.
	 */
	public function offsetSet( $field_id, $value ): void {
		$this->update_meta( $field_id, $value );
	}


	/**
	 * Delete meta value by key.
	 *
	 * @param string $field_id - Meta key to delete.
	 */
	public function offsetUnset( $field_id ): void {
		$this->delete_meta( $field_id );
	}


	/**
	 * Check if meta value exists by key.
	 *
	 * @param string $field_id - Meta key to check.
	 *
	 * @return bool
	 */
	public function offsetExists( $field_id ): bool {
		return ! empty( $this->get_meta( $field_id ) );
	}
}
