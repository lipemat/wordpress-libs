<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\Traits\Memoize;

/**
 * Translate the fields into the correct data types.
 */
abstract class Translate_Abstract {
	use Memoize;

	/**
	 * All fields that have been registered
	 *
	 * @var Field[]
	 */
	protected array $fields = [];

	/**
	 * Holds a list of fields
	 *
	 * @var array
	 */
	protected array $groups = [];

	/**
	 * Used internally to track, which group row are on.
	 *
	 * @var int
	 */
	protected int $group_row = 0;


	/**
	 * Get a field, which was registered with CMB2 by an id.
	 *
	 * @param ?string $field_id - The field id.
	 *
	 * @return null|Field
	 */
	abstract protected function get_field( ?string $field_id ): ?Field;


	/**
	 * Does this meta type and field support using object term taxonomy relationships?
	 *
	 * - Only `post` meta type is currently supported.
	 * - Only taxonomy type fields are supported.
	 *
	 * @phpstan-param Repo::META_*|string $meta_type
	 *
	 * @param string                      $meta_type - The meta type.
	 * @param Field                       $field     - The field to check for duplicate taxonomy fields.
	 *
	 * @return bool
	 */
	public function supports_taxonomy_relationships( string $meta_type, Field $field ): bool {
		if ( Repo::TYPE_TAXONOMY !== $field->data_type && Repo::TYPE_TAXONOMY_SINGULAR !== $field->data_type ) {
			return false;
		}

		return 'post' === $meta_type;
	}


	/**
	 * Get a value from the standard WP meta api or the options api.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return mixed
	 */
	protected function get_meta_value( int|string $object_id, string $key, string $meta_type ): mixed {
		$field = $this->get_field( $key );
		if ( null !== $field && null !== $field->group ) {
			$group = $this->get_meta_value( $object_id, $field->group, $meta_type );
			if ( '' === $group && null !== $field->default ) {
				return $field->default;
			}
			$value = $group[ $this->group_row ][ $key ] ?? null;
		} elseif ( Repo::META_OPTION === $meta_type ) {
			$value = cmb2_options( (string) $object_id )->get( $key, null );
		} else {
			$value = get_metadata( $meta_type, (int) $object_id, $key, true );
		}

		if ( null !== $field && null !== $field->escape_cb ) {
			$field = $field->get_cmb2_field( $object_id );
			if ( null !== $field ) {
				return $field->escaped_value( 'esc_attr', $value );
			}
		}

		return $value;
	}


	/**
	 * Update a value from the standard WP meta api or the options api.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param mixed                $value     - The meta value.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return bool|int
	 */
	protected function update_meta_value( int|string $object_id, string $key, mixed $value, string $meta_type ): bool|int {
		$field = $this->get_field( $key );
		if ( null !== $field ) {
			$cmb2_field = $field->get_cmb2_field( $object_id );
			if ( null !== $cmb2_field && null !== $field->sanitization_cb ) {
				$value = $cmb2_field->sanitization_cb( $value );
			}
			if ( null !== $field->group ) {
				return $this->update_group_sub_field_value( $object_id, $key, $value, $meta_type );
			}
		}

		if ( Repo::META_OPTION === $meta_type ) {
			// @phpstan-ignore-next-line -- CMB2 returned null prior to v2.10.1.15
			return (bool) cmb2_options( (string) $object_id )->update( $key, $value, true );
		}

		return update_metadata( $meta_type, (int) $object_id, $key, $value );
	}


	/**
	 * Update a meta key from the standard WP meta api or the options api.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return void
	 */
	protected function delete_meta_value( int|string $object_id, string $key, string $meta_type ): void {
		$field = $this->get_field( $key );
		if ( null !== $field && null !== $field->group ) {
			$group = $this->get_meta_value( $object_id, $field->group, $meta_type );
			$group[ $this->group_row ][ $key ] = null;
			$this->update_meta_value( $object_id, $field->group, $group, $meta_type );
			return;
		}

		if ( Repo::META_OPTION === $meta_type ) {
			cmb2_options( (string) $object_id )->remove( $key, true );
		} else {
			delete_metadata( $meta_type, (int) $object_id, $key );
		}
	}


	/**
	 * Get the boolean result from a CMB2 checkbox
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return bool
	 */
	protected function get_checkbox_field_value( int|string $object_id, string $key, string $meta_type ): bool {
		$value = $this->get_meta_value( $object_id, $key, $meta_type );

		return ( 'on' === $value );
	}


	/**
	 * Either delete a meta key or set it to 'on' based on if the checkbox
	 * is checked or not.
	 *
	 * Any truthy value will be considered checked.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param bool|int|string      $checked   - Is the checkbox checked?.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return void
	 */
	protected function update_checkbox_field_value( int|string $object_id, string $key, bool|int|string $checked, string $meta_type ): void {
		if ( true === $checked || 'on' === $checked || '1' === $checked || 1 === $checked ) {
			$this->update_meta_value( $object_id, $key, 'on', $meta_type );
		} else {
			$this->delete_meta_value( $object_id, $key, $meta_type );
		}
	}


	/**
	 * CMB2 saves file fields as 2 separate meta keys.
	 * This returns an array of both.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return ?array
	 */
	protected function get_file_field_value( int|string $object_id, string $key, string $meta_type ): ?array {
		$url = $this->get_meta_value( $object_id, $key, $meta_type );
		if ( ! empty( $url ) ) {
			// Add the extra field so groups meta will be translated properly.
			if ( null !== $this->fields[ $key ]->group ) {
				$this->fields[ $key . '_id' ] = $this->fields[ $key ];
			}

			return [
				'id'  => $this->get_meta_value( $object_id, "{$key}_id", $meta_type ),
				'url' => $url,
			];
		}

		return null;
	}


	/**
	 * CMB2 saves file fields as 2 separate meta keys
	 * This saves both meta keys.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id     - The object id.
	 * @param string               $key           - The meta key.
	 * @param int                  $attachment_id - The attachment id.
	 * @param string               $meta_type     - The meta type.
	 *
	 * @return void
	 */
	protected function update_file_field_value( int|string $object_id, string $key, int $attachment_id, string $meta_type ): void {
		// Add the extra field so groups meta will be translated properly.
		if ( null !== $this->fields[ $key ]->group ) {
			$this->fields[ $key . '_id' ] = $this->fields[ $key ];
		}
		$this->update_meta_value( $object_id, $key, \wp_get_attachment_url( $attachment_id ), $meta_type );
		$this->update_meta_value( $object_id, "{$key}_id", $attachment_id, $meta_type );
	}


	/**
	 * CMB2 saves file fields as 2 separate meta keys.
	 * This deletes both.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return void
	 */
	protected function delete_file_field_value( int|string $object_id, string $key, string $meta_type ): void {
		// Add the extra field so groups meta will be translated properly.
		if ( null !== $this->fields[ $key ]->group ) {
			$this->fields[ $key . '_id' ] = $this->fields[ $key ];
		}
		$this->delete_meta_value( $object_id, $key, $meta_type );
		$this->delete_meta_value( $object_id, $key . '_id', $meta_type );
	}


	/**
	 * CMB2 saves a group's fields as an array of values to meta key.
	 * This return the array with all the group's fields translated to
	 * appropriate data types.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $group_id  - The group id.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return array
	 */
	protected function get_group_field_value( int|string $object_id, string $group_id, string $meta_type ): array {
		$values = [];

		$existing = $this->get_meta_value( $object_id, $group_id, $meta_type );
		if ( ! \is_array( $existing ) ) {
			return [];
		}
		foreach ( $existing as $_row => $_values ) {
			$this->group_row = $_row;
			foreach ( $this->get_group_fields( $group_id ) as $field ) {
				$values[ $_row ][ $field ] = Repo::in()->get_value( $object_id, $field, $meta_type );
			}
		}
		$this->group_row = 0;

		return $values;
	}


	/**
	 * Update all the field values within a group.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $group_id  - The group id.
	 * @param array                $values    - The values.
	 * @param string               $meta_type - The meta type.
	 */
	protected function update_group_field_values( int|string $object_id, string $group_id, array $values, string $meta_type ): void {
		$fields = $this->get_group_fields( $group_id );
		foreach ( $values as $_row => $_values ) {
			$this->group_row = $_row;
			foreach ( $fields as $field_id ) {
				if ( \array_key_exists( $field_id, $_values ) ) {
					Repo::in()->update_value( $object_id, $field_id, $_values[ $field_id ], $meta_type );
				} else {
					Repo::in()->delete_value( $object_id, $field_id, $meta_type );
				}
			}
		}

		// Delete rows which no longer exist.
		$existing = Repo::in()->get_value( $object_id, $group_id, $meta_type );
		foreach ( \array_diff_key( $existing, $values ) as $_row => $_values ) {
			$this->delete_group_row( $object_id, $group_id, $_row, $meta_type );
		}
		$this->group_row = 0;
	}


	/**
	 * Update a single field within a group.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @internal
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param mixed                $value     - The value.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return bool|int
	 */
	protected function update_group_sub_field_value( int|string $object_id, string $key, mixed $value, string $meta_type ): bool|int {
		$field = $this->get_field( $key );
		if ( null === $field || null === $field->group ) {
			return false;
		}

		$group = $this->get_meta_value( $object_id, $field->group, $meta_type );
		if ( ! \is_array( $group ) ) {
			$group = [];
		}
		$group[ $this->group_row ][ $key ] = $value;

		return $this->update_meta_value( $object_id, $field->group, $group, $meta_type );
	}


	/**
	 * Delete a row from a group.
	 *
	 * We must loop through the individual files to trigger any hooks
	 * and/or remove taxonomy relationships.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @internal
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $group_id  - The meta key.
	 * @param int                  $row       - The row index in the group.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return bool|int
	 */
	protected function delete_group_row( int|string $object_id, string $group_id, int $row, string $meta_type ): bool|int {
		$this->group_row = $row;
		foreach ( $this->get_group_fields( $group_id ) as $field ) {
			Repo::in()->delete_value( $object_id, $field, $meta_type );
		}
		$group = $this->get_meta_value( $object_id, $group_id, $meta_type );
		if ( ! \is_array( $group ) ) {
			$group = [];
		}
		unset( $group[ $row ] );
		return $this->update_meta_value( $object_id, $group_id, $group, $meta_type );
	}


	/**
	 * Get all the fields assigned to this group.
	 *
	 * @internal
	 *
	 * @param string $group - The group id.
	 *
	 * @return string[]
	 */
	protected function get_group_fields( string $group ): array {
		$groups = $this->once( function() {
			$groups = [];
			\array_map( function( Field $field ) use ( &$groups ) {
				if ( null !== $field->group ) {
					$groups[ $field->group ][] = $field->get_id();
				}
			}, $this->fields );
			return $groups;
		}, __METHOD__ );

		return $groups[ $group ] ?? [];
	}


	/**
	 * CMB2 saves taxonomy fields as terms or meta value for options.
	 * We pull from either here.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $field_id  - The field id.
	 * @param string               $meta_type - The meta type.
	 *
	 * @throws \RuntimeException -- If we received a WP_Error.
	 *
	 * @return \WP_Term[]
	 */
	protected function get_taxonomy_field_value( int|string $object_id, string $field_id, string $meta_type ): array {
		$field = $this->get_field( $field_id );
		if ( null === $field ) {
			return [];
		}
		$taxonomy = $field->taxonomy;
		if ( ! $this->supports_taxonomy_relationships( $meta_type, $field ) ) {
			return $this->maybe_use_main_blog( $field_id, function() use ( $object_id, $field_id, $meta_type ) {
				$meta_value = (array) $this->get_meta_value( $object_id, $field_id, $meta_type );

				return \array_filter( \array_map( function( $term_id ) use ( $field_id ) {
					$value = $this->get_term_id_from_slug( $field_id, $term_id );
					if ( null !== $value ) {
						return get_term( $value );
					}
					return false;
				}, $meta_value ) );
			} );
		}
		$terms = get_the_terms( (int) $object_id, $taxonomy );
		if ( is_wp_error( $terms ) ) {
			throw new \RuntimeException( esc_html( $terms->get_error_message() ) );
		}
		if ( false === $terms ) {
			return [];
		}

		return \array_filter( $terms );
	}


	/**
	 * CMB2 saves taxonomy fields as terms or meta value for options.
	 * We do the same here.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $key       - The meta key.
	 * @param int[]                $terms     - Term ids.
	 * @param string               $meta_type - The meta type.
	 * @param bool                 $singular  - Is the meta of type singular.
	 *
	 * @return void
	 */
	protected function update_taxonomy_field_value( int|string $object_id, string $key, array $terms, string $meta_type, bool $singular = false ): void {
		$field = $this->get_field( $key );
		if ( null === $field ) {
			return;
		}
		if ( null !== $field->sanitization_cb ) {
			$cmb2_field = $field->get_cmb2_field( $object_id );
			if ( null !== $cmb2_field ) {
				$terms = $cmb2_field->sanitization_cb( $terms );
			}
		}

		// Stored as term relationship.
		if ( $this->supports_taxonomy_relationships( $meta_type, $field ) ) {
			$terms = \array_map( function( $term ) {
				// Term ids are perceived as term slug when strings.
				return is_numeric( $term ) ? (int) $term : $term;
			}, $terms );
			wp_set_object_terms( (int) $object_id, $terms, $field->taxonomy );
			return;
		}

		// Store in meta.
		$terms = \array_map( function( $value ) use ( $key ) {
			return $this->get_term_id_from_slug( $key, $value );
		}, $terms );

		if ( $singular ) {
			$value = \reset( $terms );
			if ( false !== $value ) {
				$this->update_meta_value( $object_id, $key, $value, $meta_type );
			} else {
				$this->delete_meta_value( $object_id, $key, $meta_type );
			}
		} else {
			$this->update_meta_value( $object_id, $key, $terms, $meta_type );
		}
	}


	/**
	 * CMB2 saves taxonomy fields as terms or meta value for options.
	 * We delete either this meta value, or these assigned terms.
	 *
	 * Does not delete the actual terms, just the assignment of them.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $field_id  - The field id.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return void
	 */
	protected function delete_taxonomy_field_value( int|string $object_id, string $field_id, string $meta_type ): void {
		$field = $this->get_field( $field_id );
		if ( $field instanceof Field && $this->supports_taxonomy_relationships( $meta_type, $field ) ) {
			$taxonomy = $field->taxonomy;
			wp_delete_object_term_relationships( (int) $object_id, $taxonomy );
		} else {
			$this->delete_meta_value( $object_id, $field_id, $meta_type );
		}
	}


	/**
	 * Retrieve a single term from a taxonomy field that allows
	 * selecting only a single term.
	 *
	 * @phpstan-param Repo::META_* $meta_type
	 *
	 * @param int|string           $object_id - The object id.
	 * @param string               $field_id  - The field id.
	 * @param string               $meta_type - The meta type.
	 *
	 * @return \WP_Term|false
	 */
	protected function get_taxonomy_singular_field_value( int|string $object_id, string $field_id, string $meta_type ): \WP_Term|bool {
		try {
			$terms = $this->get_taxonomy_field_value( $object_id, $field_id, $meta_type );
		} catch ( \RuntimeException ) {
			return false;
		}

		return [] === $terms ? false : \reset( $terms );
	}


	/**
	 * Term values used to be stored as 'slug'.
	 *
	 * This method translates a possible slug to a term id.
	 * If a number is passed, the int value of the number is returned.
	 *
	 * @param string     $key   - The field key.
	 * @param int|string $value - The term value.
	 *
	 * @return int|null
	 */
	protected function get_term_id_from_slug( string $key, int|string $value ): ?int {
		if ( ! is_numeric( $value ) ) {
			$field = $this->get_field( $key );
			if ( null === $field ) {
				return null;
			}
			$term = get_term_by( 'slug', $value, $field->taxonomy );
			if ( false !== $term && \is_a( $term, \WP_Term::class ) ) {
				return $term->term_id;
			}
			return null;
		}

		return (int) $value;
	}


	/**
	 * Certain values types are retrieve and stored from main blog when
	 * using network settings.
	 *
	 * When using categories in network settings, the categories are retrieved
	 * and saved relative to the main blog.
	 *
	 * If we are working with a network setting, we switch to main blog before
	 * retrieval, otherwise we use the standard retrieval.
	 *
	 * @param string   $field_id - The field id.
	 * @param callable $callback - Any callback.
	 *
	 * @throws \RuntimeException -- If the field does not exist.
	 *
	 * @return mixed;
	 */
	protected function maybe_use_main_blog( string $field_id, callable $callback ): mixed {
		$field = $this->get_field( $field_id );
		if ( null === $field ) {
			throw new \RuntimeException( esc_html( "Field with id `{$field_id}` does not exist." ) );
		}
		$box = $field->get_box();
		$is_network = null !== $box && \method_exists( $box, 'is_network' ) && $box->is_network();
		if ( $is_network ) {
			switch_to_blog( get_main_site_id() );
		}
		$result = $callback();
		if ( $is_network ) {
			restore_current_blog();
		}
		return $result;
	}
}
