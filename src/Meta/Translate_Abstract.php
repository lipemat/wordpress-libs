<?php

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\Traits\Memoize;

/**
 * Translate the fields into the correct data types.
 *
 */
abstract class Translate_Abstract {
	use Memoize;

	/**
	 * All fields that have been registered
	 *
	 * @var Field[]
	 */
	protected $fields = [];

	/**
	 * Holds a list of fields
	 *
	 * @var array
	 */
	protected $groups = [];

	/**
	 * Used internally to track which group row are on.
	 *
	 * @var int
	 */
	protected $group_row = 0;


	/**
	 * Get a field which was registered with CMB2 by id.
	 *
	 * @param string $field_id
	 *
	 * @return null|Field
	 */
	abstract protected function get_field( string $field_id ) : ?Field;


	/**
	 * Get a value from the standard WP meta api or the options api.
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return mixed
	 */
	protected function get_meta_value( $object_id, string $key, string $meta_type ) {
		$field = $this->get_field( $key );
		if ( null !== $field && null !== $field->group ) {
			$group = $this->get_meta_value( $object_id, $field->group, $meta_type );
			$value = $group[ $this->group_row ][ $key ] ?? null;
		} elseif ( 'option' === $meta_type ) {
			$value = cmb2_options( $object_id )->get( $key, null );
		} else {
			$value = get_metadata( $meta_type, $object_id, $key, true );
		}

		if ( null !== $field && null !== $field->escape_cb ) {
			return $field->get_cmb2_field()->escaped_value( 'esc_attr', $value );
		}

		return $value;
	}


	/**
	 * Update a value from the standard WP meta api or the options api.
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param mixed      $value
	 * @param string     $meta_type
	 *
	 * @return bool|int
	 */
	protected function update_meta_value( $object_id, string $key, $value, string $meta_type ) {
		$field = $this->get_field( $key );
		if ( null !== $field ) {
			$cmb2_field = $field->get_cmb2_field();
			if ( null !== $cmb2_field ) {
				$cmb2_field->object_id( $object_id ); // Store object id for later use.
				if ( null !== $field->sanitization_cb ) {
					$value = $cmb2_field->sanitization_cb( $value );
				}
			}
			if ( null !== $field->group ) {
				return $this->update_group_sub_field_value( $object_id, $key, $value, $meta_type );
			}
		}

		if ( 'option' === $meta_type ) {
			$this->handle_update_callback( $object_id, $key, $value, $meta_type );

			return cmb2_options( $object_id )->update( $key, $value, true );
		}

		return update_metadata( $meta_type, $object_id, $key, $value );
	}


	/**
	 * Update a meta key from the standard WP meta api or the options api.
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	protected function delete_meta_value( $object_id, string $key, string $meta_type ) : void {
		$field = $this->get_field( $key );
		if ( null !== $field && null !== $field->group ) {
			$group = $this->get_meta_value( $object_id, $field->group, $meta_type );
			$group[ $this->group_row ][ $key ] = null;
			$this->update_meta_value( $object_id, $key, $group, $meta_type );
		}

		if ( 'option' === $meta_type ) {
			$this->handle_delete_callback( $object_id, $key, $meta_type );

			cmb2_options( $object_id )->remove( $key, true );
		} else {
			delete_metadata( $meta_type, $object_id, $key );
		}
	}


	/**
	 * Get the boolean result from a CMB2 checkbox
	 *
	 * @param int|string $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return bool
	 */
	public function get_checkbox_field_value( $object_id, string $key, string $meta_type ) : bool {
		$value = $this->get_meta_value( $object_id, $key, $meta_type );

		return ( 'on' === $value );
	}


	/**
	 * Either delete a meta key or set it to 'on' based on if the checkbox
	 * is checked or not.
	 *
	 * Any truthy value will be considered checked.
	 *
	 * @param int|string $object_id
	 * @param string     $key
	 * @param bool|int   $checked
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	public function update_checkbox_field_value( $object_id, string $key, $checked, string $meta_type ) : void {
		if ( empty( $checked ) ) {
			$this->delete_meta_value( $object_id, $key, $meta_type );
		} else {
			$this->update_meta_value( $object_id, $key, 'on', $meta_type );
		}
	}


	/**
	 * CMB2 saves file fields as 2 separate meta keys.
	 * This returns an array of both.
	 *
	 * @param int|string $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return ?array
	 */
	public function get_file_field_value( $object_id, string $key, string $meta_type ) : ?array {
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
	 * @param int|string $object_id
	 * @param string     $key
	 * @param int        $attachment_id
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	public function update_file_field_value( $object_id, string $key, int $attachment_id, string $meta_type ) : void {
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
	 * @param int|string $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	public function delete_file_field_value( $object_id, string $key, string $meta_type ) : void {
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
	 * @param int|string $object_id
	 * @param string     $group_id
	 * @param string     $meta_type
	 *
	 * @return array
	 */
	public function get_group_field_value( $object_id, string $group_id, string $meta_type ) : array {
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

		return $values;
	}


	/**
	 * Update all the field values within a group.
	 *
	 * @param int|string $object_id
	 * @param string     $group_id
	 * @param array      $values
	 * @param string     $meta_type
	 */
	public function update_group_field_values( $object_id, string $group_id, array $values, string $meta_type ) : void {
		foreach ( $values as $_row => $_values ) {
			$this->group_row = $_row;
			foreach ( $this->get_group_fields( $group_id ) as $field ) {
				if ( \array_key_exists( $field, $_values ) ) {
					Repo::in()->update_value( $object_id, $field, $_values[ $field ], $meta_type );
				} else {
					Repo::in()->delete_value( $object_id, $field, $meta_type );
				}
			}
		}
	}


	/**
	 * Update a single field within a group.
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param mixed      $value
	 * @param string     $meta_type
	 *
	 * @internal
	 *
	 * @return bool|int
	 */
	protected function update_group_sub_field_value( $object_id, string $key, $value, string $meta_type ) {
		$group = $this->get_meta_value( $object_id, $this->fields[ $key ]->group, $meta_type );
		if ( ! \is_array( $group ) ) {
			$group = [];
		}
		$group[ $this->group_row ][ $key ] = $value;

		return $this->update_meta_value( $object_id, $this->fields[ $key ]->group, $group, $meta_type );
	}


	/**
	 * Get all the fields assigned to this group.
	 *
	 * @param string $group - The group id.
	 *
	 * @internal
	 *
	 * @return string[]
	 */
	protected function get_group_fields( string $group ) : array {
		$groups = $this->once( function() {
			$groups = [];
			array_map( function( Field $field ) use ( &$groups ) {
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
	 * @param string|int $object_id
	 * @param string     $field_id
	 * @param string     $meta_type
	 *
	 * @return \WP_Term[]
	 */
	public function get_taxonomy_field_value( $object_id, string $field_id, string $meta_type ) : array {
		$taxonomy = $this->get_field( $field_id )->taxonomy;
		if ( 'post' !== $meta_type ) {
			return $this->maybe_use_main_blog( $field_id, function() use ( $object_id, $field_id, $taxonomy, $meta_type ) {
				return \array_filter( \array_map( function( $term_id ) use ( $taxonomy ) {
					// Legacy options used term slug.
					if ( ! is_numeric( $term_id ) ) {
						return get_term_by( 'slug', $term_id, $taxonomy );
					}
					return get_term( $term_id, $taxonomy );
				}, (array) $this->get_meta_value( $object_id, $field_id, $meta_type ) ) );
			} );
		}

		return \array_filter( (array) get_the_terms( $object_id, $taxonomy ) );
	}


	/**
	 * CMB2 saves taxonomy fields as terms or meta value for options.
	 * We do the same here.
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param int[]      $terms - Term ids.
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	public function update_taxonomy_field_value( $object_id, string $key, array $terms, string $meta_type ) : void {
		$field = $this->get_field( $key );
		if ( null !== $field ) {
			if ( null !== $field->sanitization_cb ) {
				$terms = $field->get_cmb2_field()->sanitization_cb( $terms );
			}

			if ( 'post' !== $meta_type ) {
				$this->update_meta_value( $object_id, $key, array_map( function( $term_id ) use ( $field ) {
					// Legacy options used term slug.
					if ( ! is_numeric( $term_id ) ) {
						return get_term_by( 'slug', $term_id, $field->taxonomy )->term_id;
					}

					return $term_id;
				}, $terms ), $meta_type );
			} else {
				$this->handle_update_callback( $object_id, $key, $terms, $meta_type );
				$terms = \array_map( function( $term ) {
					// Term ids are perceived as term slug when strings.
					return is_numeric( $term ) ? (int) $term : $term;
				}, $terms );
				wp_set_object_terms( $object_id, $terms, $field->taxonomy );
			}
		}
	}


	/**
	 * CMB2 saves taxonomy fields as terms or meta value for options.
	 * We delete either this meta value or these assigned terms.
	 *
	 * Does not delete the actual terms, just the assignment of them.
	 *
	 * @param string|int $object_id
	 * @param string     $field_id
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	public function delete_taxonomy_field_value( $object_id, string $field_id, string $meta_type ) : void {
		if ( 'post' !== $meta_type ) {
			$this->delete_meta_value( $object_id, $field_id, $meta_type );
		} else {
			$this->handle_delete_callback( $object_id, $field_id, $meta_type );
			$taxonomy = $this->get_field( $field_id )->taxonomy;
			wp_delete_object_term_relationships( $object_id, $taxonomy );
		}
	}


	/**
	 * Retrieve a single term from a taxonomy field that allows
	 * selecting only a single term.
	 *
	 * @param string|int $object_id
	 * @param string     $field_id
	 * @param string     $meta_type
	 *
	 * @return \WP_Term|false
	 */
	public function get_taxonomy_singular_field_value( $object_id, string $field_id, string $meta_type ) {
		$terms = $this->get_taxonomy_field_value( $object_id, $field_id, $meta_type );

		return empty( $terms ) ? false : array_shift( $terms );
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
	 * @param string   $field_id
	 * @param callable $callback - Any callback.
	 *
	 * @return mixed;
	 */
	protected function maybe_use_main_blog( string $field_id, callable $callback ) {
		$is_network = 'network_admin_menu' === cmb2_get_metabox( $this->get_field( $field_id )->box_id )->meta_box['admin_menu_hook']; // @phpstan-ignore-line
		if ( $is_network ) {
			switch_to_blog( get_main_site_id() );
		}
		$result = $callback();
		if ( $is_network ) {
			restore_current_blog();
		}
		return $result;
	}


	/**
	 * If a delete callback exists, call it.
	 *
	 * We mimic the same arguments as the cmb2 filter as the `delete_cb`
	 * will also be called when saving an empty value to meta in the admin.
	 *
	 * @see   "cmb2_override_{$a['field_id']}_meta_remove"
	 *
	 * @see   Field::delete_cb
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	public function handle_delete_callback( $object_id, string $key, string $meta_type ) : void {
		$field = $this->get_field( $key );
		if ( null === $field ) {
			return;
		}
		$cmb2_field = $field->get_cmb2_field();
		if ( null !== $field->delete_cb && null !== $cmb2_field ) {
			\call_user_func( $field->delete_cb, $object_id, $key );
		}
	}


	/**
	 * If an update callback exists, call it.
	 *
	 * We mimic the same arguments as the cmb2 filter as the `update_cb`.
	 *
	 * @see   "cmb2_override_{$a['field_id']}_meta_update"
	 *
	 * @see   Field::update_cb
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param mixed      $value
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	public function handle_update_callback( $object_id, string $key, $value, string $meta_type ) : void {
		$field = $this->get_field( $key );
		if ( null === $field ) {
			return;
		}
		$cmb2_field = $field->get_cmb2_field();
		if ( null !== $field->update_cb && null !== $cmb2_field ) {
			\call_user_func( $field->update_cb, $object_id, $value, $key, $meta_type );
		}
	}
}
