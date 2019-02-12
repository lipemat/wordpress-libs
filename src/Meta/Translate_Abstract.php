<?php

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Field;

/**
 * Translate the fields into the correct data types.
 *
 * @author Mat Lipe
 * @since  2.5.0
 *
 */
abstract class Translate_Abstract {

	abstract protected function get_field( string $field_id ) : Field;


	/**
	 * Get a value from the standard WP meta api or the options api.
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 *
	 * @return mixed
	 */
	protected function get_meta_value( $object_id, string $key, string $meta_type ) {
		if ( 'option' === $meta_type ) {
			// CMB2 will pull a key from the option or network option automatically.
			return cmb2_options( $object_id )->get( $key, null );
		}

		return get_metadata( $meta_type, $object_id, $key, true );
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
		if ( 'option' === $meta_type ) {
			// CMB2 will save a key from the option or network option automatically.
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
		\delete_metadata( $meta_type, $object_id, $key );
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
			\delete_metadata( $meta_type, $object_id, $key );
		} else {
			$this->update_meta_value( $object_id, $key, 'on', $meta_type );
		}
	}


	/**
	 * CMB2 saves file fields as 2 separate meta keys.
	 * This returns an array of both of them.
	 *
	 * @param int|string $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return array|false
	 */
	public function get_file_field_value( $object_id, string $key, string $meta_type ) : ?array {
		$url = $this->get_meta_value( $object_id, $key, $meta_type );
		if ( ! empty( $url ) ) {
			return [
				'id'  => $this->get_meta_value( $object_id, "{$key}_id", $meta_type ),
				'url' => $url,
			];
		}

		return null;
	}


	/**
	 * CMB2 saves file fields as 2 separate meta keys.
	 * This deletes both of them.
	 *
	 * @param int|string $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return void
	 */
	public function delete_file_field_value( $object_id, string $key, string $meta_type ) : void {
		$this->delete_meta_value( $object_id, $key, $meta_type );
		$this->delete_meta_value( $object_id, "{$key}_id", $meta_type );
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
		$this->update_meta_value( $object_id, $key, \wp_get_attachment_url( $attachment_id ), $meta_type );
		$this->update_meta_value( $object_id, "{$key}_id", $attachment_id, $meta_type );
	}


	/**
	 * CMB2 saves taxonomy fields as terms or meta value for options.
	 * We pull from either here.
	 *
	 * @param string|int $object_id
	 * @param string     $field_id
	 * @param string     $meta_type
	 *
	 * @since 2.4.0 - Will return term objects from option fields
	 *
	 * @return \WP_Term[]
	 */
	public function get_taxonomy_field_value( $object_id, string $field_id, string $meta_type ) : array {
		$taxonomy = $this->get_field( $field_id )->taxonomy;
		if ( 'option' === $meta_type || 'user' === $meta_type ) {
			return array_map( function ( $slug ) use ( $taxonomy ) {
				return \get_term_by( 'slug', $slug, $taxonomy );
			}, (array) $this->get_meta_value( $object_id, $field_id, $meta_type ) );
		}

		return (array) get_the_terms( $object_id, $taxonomy );
	}


	/**
	 * CMB2 saves taxonomy fields as terms or meta value for options.
	 * We do the same here.
	 *
	 * @param        $object_id
	 * @param string $field_id
	 * @param array  $terms - Term ids, or term slugs
	 * @param string $meta_type
	 *
	 * @return void
	 */
	public function update_taxonomy_field_value( $object_id, string $field_id, array $terms, string $meta_type ) : void {
		$taxonomy = $this->get_field( $field_id )->taxonomy;
		if ( 'option' === $meta_type || 'user' === $meta_type ) {
			$this->update_meta_value( $object_id, $field_id, array_map( function ( $slug ) use ( $taxonomy ) {
				if ( is_numeric( $slug ) ) {
					return get_term( $slug, $taxonomy )->slug;
				}

				return $slug;
			}, $terms ), $meta_type );
		} else {
			wp_set_object_terms( $object_id, $terms, $taxonomy );
		}
	}


	/**
	 * CMB2 saves taxonomy fields as terms or meta value for options.
	 * We delete either this meta value or these assigned terms.
	 *
	 * Does not delete the actual terms, just the assignment of them.
	 *
	 * @param        $object_id
	 * @param string $field_id
	 * @param string $meta_type
	 *
	 * @return void
	 */
	public function delete_taxonomy_field_value( $object_id, string $field_id, string $meta_type ) : void {
		if ( 'option' === $meta_type || 'user' === $meta_type ) {
			$this->delete_meta_value( $object_id, $field_id, $meta_type );
		} else {
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
	 * @since 2.4.0
	 *
	 * @return \WP_Term|false
	 */
	public function get_taxonomy_singular_field_value( $object_id, string $field_id, string $meta_type ) {
		$terms = $this->get_taxonomy_field_value( $object_id, $field_id, $meta_type );

		return empty( $terms ) ? false : array_shift( $terms );

	}
}
