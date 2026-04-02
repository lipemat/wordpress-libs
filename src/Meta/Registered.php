<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\CMB2\Field\Type;
use Lipe\Lib\CMB2\Group;

/**
 * Represents a registered field.
 *
 * Instead of cluttering the `Field` class with a bunch of methods not used
 * when registering a field, we interact with the field through this class.
 *
 * @author Mat Lipe
 * @since  5.0.0
 *
 * @phpstan-type ESC_CB \Closure( mixed $value, array<string, mixed>, ?\CMB2_Field ): mixed
 */
readonly class Registered {
	/**
	 * Build the Registered object.
	 *
	 * @param Field $variation - The field variation we are working with.
	 */
	final protected function __construct(
		public Field $variation
	) {
	}


	/**
	 * Get the box this field belongs to.
	 *
	 * @return \Lipe\Lib\CMB2\Box
	 */
	public function get_box(): \Lipe\Lib\CMB2\Box {
		return $this->variation->box;
	}


	/**
	 * Retrieve the CMB2 version of this field.
	 *
	 * @param int|string $object_id - The object id to pass on to CMB2.
	 *
	 * @return ?\CMB2_Field
	 */
	public function get_cmb2_field( int|string $object_id = 0 ): ?\CMB2_Field {
		if ( null !== $this->get_group() ) {
			$box = $this->get_box()->get_cmb2_box();
			$group = cmb2_get_field( $this->get_box()->get_id(), $this->get_group()->id, $object_id, $this->get_box()->get_box_type()->value );
			$field = $box->get_field( $this->get_config(), $group );
			if ( false === $field ) {
				return null;
			}
			$field->object_id( $object_id );
			return $field;
		}

		return cmb2_get_field( $this->get_box()->get_id(), $this->get_id(), $object_id, $this->get_box()->get_box_type()->value );
	}


	/**
	 * Get the data type of the field.
	 *
	 * @see Field::$data_type
	 *
	 * @return DataType
	 */
	public function get_data_type(): DataType {
		return $this->variation->data_type;
	}


	/**
	 * Get the default value for the field.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#default
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Parameters#default_cb
	 * @see    Field::default()
	 *
	 * @notice Will not use the `default_cb` if no object_id is passed.
	 *
	 * @param null|int|string $object_id - The object id to pass on to the default callback if available.
	 *
	 * @return mixed
	 */
	public function get_default( null|int|string $object_id = null ): mixed {
		if ( isset( $this->variation->default ) ) {
			return $this->variation->default;
		}
		if ( null !== $object_id && isset( $this->variation->default_cb ) && null !== $this->get_cmb2_field( $object_id ) ) {
			return \call_user_func( $this->variation->default_cb, $this->get_config(), $this->get_cmb2_field( $object_id ) );
		}
		return null;
	}


	/**
	 * Get the fields long description if one has been provided.
	 *
	 * @return string
	 */
	public function get_description(): string {
		return $this->variation->desc;
	}


	/**
	 * Get the escape callback used internally with CMB2.
	 *
	 * @see Field::$escape_cb
	 *
	 * @return ?callable
	 */
	public function get_escape_cb(): ?callable {
		return $this->variation->escape_cb ?? null;
	}


	/**
	 * Get the group this field is assigned to if available.
	 *
	 * @return ?Group
	 */
	public function get_group(): ?Group {
		return $this->variation->group;
	}


	/**
	 * The data key. If using for posts, will be the post-meta key.
	 * If using for an options page, will be the array key.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#id
	 *
	 * @example 'lipe/project/meta/category-fields/caption',
	 *
	 * @return string
	 */
	public function get_id(): string {
		return $this->variation->id;
	}


	/**
	 * Get the sanitization callback used with `register_meta`.
	 *
	 * @see Field::$meta_sanitizer
	 * @see self::get_sanitization_cb()
	 *
	 * @phpstan-return ESC_CB|null
	 * @return  ?callable
	 */
	public function get_meta_sanitizer(): ?callable {
		return $this->variation->meta_sanitizer ?? null;
	}


	/**
	 * Get the short name of a field for use in the REST API.
	 *
	 * @see Field::$rest_short_name
	 *
	 * @return string
	 */
	public function get_rest_short_name(): string {
		$short_name = $this->variation->rest_short_name ?? false;
		if ( \is_string( $short_name ) ) {
			return $short_name;
		}
		$name = \explode( '/', $this->get_id() );
		return \end( $name );
	}


	/**
	 * Get the sanitization callback used internally with CMB2.
	 *
	 * @see self::get_meta_sanitizer()
	 * @see Field::$sanitization_cb
	 *
	 * @return ?callable
	 */
	public function get_sanitization_cb(): ?callable {
		return $this->variation->sanitization_cb ?? null;
	}


	/**
	 * Get the show_in_rest value for the field.
	 *
	 * @see Field::$show_in_rest
	 *
	 * @phpstan-return  \WP_REST_Server::*|bool
	 * @return string|bool
	 */
	public function get_show_in_rest(): string|bool {
		return $this->variation->show_in_rest ?? false;
	}


	/**
	 * Get a value from the configured `text` array.
	 *
	 * @see Field::$text
	 *
	 * @param string $key - Potential key in the text array.
	 *
	 * @return string|null
	 */
	public function get_text( string $key ): ?string {
		return $this->variation->text[ $key ] ?? null;
	}


	/**
	 * Get the type of the field.
	 *
	 * @see Field::$type
	 *
	 * @return Type
	 */
	public function get_type(): Type {
		return $this->variation->type;
	}


	/**
	 * Does this field have a custom REST short name?
	 *
	 * @see Field::$rest_short_name
	 *
	 * @return bool
	 */
	public function has_rest_short_name(): bool {
		$short_name = $this->variation->rest_short_name ?? false;
		return false !== $short_name;
	}


	/**
	 * Is this field allowed to be registered with meta?
	 *
	 * @return bool
	 */
	public function is_allowed_to_register_meta(): bool {
		return \in_array( $this->get_data_type(), [ DataType::CHECKBOX, DataType::DEFAULT, DataType::FILE ], true );
	}


	/**
	 * Should the field be added to the GET endpoint?
	 *
	 * If we register the meta, it will be available for all methods
	 * so if a method other than `ALLMETHODS` is specified, we
	 * can't add it to the REST api via meta.
	 *
	 * @return bool
	 */
	public function is_public_rest_data(): bool {
		$shown = $this->get_show_in_rest();
		return false !== $shown && ( true === $shown || \WP_REST_Server::ALLMETHODS === $shown );
	}


	/**
	 * Is this field repeatable?
	 *
	 * @see Field::$repeatable
	 *
	 * @return bool
	 */
	public function is_repeatable(): bool {
		if ( \CMB2_Utils::does_not_support_repeating( $this->variation->type->value ) ) {
			return false;
		}
		return $this->variation->repeatable;
	}


	/**
	 * Does this field return a value of array type?
	 *
	 * @return bool
	 */
	public function is_using_array_data(): bool {
		return $this->is_repeatable() || Type::MULTI_CHECK === $this->get_type() || Type::MULTI_CHECK_INLINE === $this->get_type();
	}


	/**
	 * Does this field return a value of object type?
	 *
	 * @return bool
	 */
	public function is_using_object_data(): bool {
		return ! $this->is_repeatable() && Type::FILE_LIST === $this->get_type();
	}


	/**
	 * Get the field's configuration.
	 *
	 * @return array<string, mixed>
	 */
	public function get_config(): array {
		return $this->variation->get_field_args();
	}


	/**
	 * Build a Registered object from a field.
	 *
	 * @param Field $variation - The field to build the object from.
	 *
	 * @return static
	 */
	public static function factory( Field $variation ): static {
		return new static( $variation );
	}
}
