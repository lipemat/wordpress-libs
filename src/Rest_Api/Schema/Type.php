<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

/**
 * Proxy for mapping a field type to the corresponding class.
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 */
class Type {
	/**
	 * Arguments for the type of field.
	 *
	 * @var TypeRules
	 */
	protected TypeRules $type_args;

	/**
	 * Match exactly one type.
	 *
	 * @var Resource_Prop[]
	 */
	protected array $one_of;

	/**
	 * Match any of the types.
	 *
	 * @var Resource_Prop[]
	 */
	protected array $any_of;


	/**
	 * String types.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#strings
	 *
	 * @return StringType
	 */
	public function string(): StringType {
		$this->type_args = new StringType( [] );
		return $this->type_args;
	}


	/**
	 * Array types.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#arrays
	 *
	 * @return ArrayType
	 */
	public function array(): ArrayType {
		$this->type_args = new ArrayType( [] );
		return $this->type_args;
	}


	/**
	 * Object types.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#objects
	 *
	 * @return ObjectType
	 */
	public function object(): ObjectType {
		$this->type_args = new ObjectType( [] );
		return $this->type_args;
	}


	/**
	 * Number types.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#numbers
	 *
	 * @return NumberType
	 */
	public function number(): NumberType {
		$this->type_args = new NumberType( [] );
		return $this->type_args;
	}


	/**
	 * Integer types.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#numbers
	 *
	 * @return IntegerType
	 */
	public function integer(): IntegerType {
		$this->type_args = new IntegerType( [] );
		return $this->type_args;
	}


	/**
	 * Boolean types.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#primitive-types
	 *
	 * @return BooleanType
	 */
	public function boolean(): BooleanType {
		$this->type_args = new BooleanType( [] );
		return $this->type_args;
	}


	/**
	 * Null types.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#primitive-types
	 *
	 * @return NullType
	 */
	public function null(): NullType {
		$this->type_args = new NullType( [] );
		return $this->type_args;
	}


	/**
	 * Match exactly one type.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#type-agnostic-keywords
	 *
	 * @param Resource_Prop[] $types - The types to allow.
	 *
	 * @return static
	 */
	public function one_of( array $types ): static {
		$this->one_of = $types;
		return $this;
	}


	/**
	 * Match any of the types.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#type-agnostic-keywords
	 *
	 *
	 * @param Resource_Prop[] $types - The types to allow.
	 *
	 * @return static
	 */
	public function any_of( array $types ): static {
		$this->any_of = $types;
		return $this;
	}


	/**
	 * Get the arguments from the lower type class.
	 *
	 * @return array<string, mixed>
	 */
	public function get_args(): array {
		if ( isset( $this->any_of ) ) {
			return [
				'anyOf' => \array_map( fn( Resource_Prop $prop ) => $prop->get_args(), $this->any_of ),
			];
		}
		if ( isset( $this->one_of ) ) {
			return [
				'oneOf' => \array_map( fn( Resource_Prop $prop ) => $prop->get_args(), $this->one_of ),
			];
		}

		return $this->type_args->get_args();
	}
}
