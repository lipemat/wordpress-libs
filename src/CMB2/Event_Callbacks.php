<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Variation\Taxonomy;
use Lipe\Lib\Meta\Registered;
use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Taxonomy\Get_Terms;

/**
 * Event callback handling for CMB2 fields.
 *
 * Tap into native WP actions, so the callbacks will fire
 * if data is updated outside CMB2.
 *
 * - Subscribe to values being deleted via `delete_cb`.
 * - Subscribe to values being changed via `change_cb`.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @interal
 *
 * @phpstan-type DELETE_CB callable( int|string $object_id, string $key, mixed $previous, BoxType $type ): void
 * @phpstan-type CHANGE_CB callable( int|string $object_id, mixed $value, string $key, mixed $previous, BoxType $type): void
 */
class Event_Callbacks {
	public const TYPE_CHANGE = 'change';
	public const TYPE_DELETE = 'delete';

	/**
	 * An array containing <post type slugs>|'user'|'term'|'comment'|'options-page'.
	 *
	 * @see Box::$object_types
	 *
	 * @var string[]
	 */
	public readonly array $object_types;

	/**
	 * Box this field is registered on.
	 *
	 * @var Box
	 */
	protected readonly Box $box;

	/**
	 * The field variation we are working with.
	 *
	 * @var Field
	 */
	protected readonly Field $variation;

	/**
	 * Meta key
	 *
	 * @var string
	 */
	protected readonly string $key;

	/**
	 * Box type this field is registered on.
	 *
	 * Usually the box type corresponds to the meta type use for
	 * WP hooks, but it is not an exact match as box types are limited.
	 *
	 * @see Box::get_box_type
	 *
	 * @var BoxType
	 */
	protected readonly BoxType $box_type;

	/**
	 * Previous value before an update.
	 *
	 * @var mixed
	 */
	protected mixed $previous_value = null;


	/**
	 * Register callback events for this field.
	 *
	 * @phpstan-param static::TYPE_*      $cb_type
	 * @phpstan-param CHANGE_CB|DELETE_CB $callback
	 *
	 * @param Registered                  $field    - Field to register events for.
	 * @param callable                    $callback - Callback to run when the field changes or is deleted.
	 * @param string                      $cb_type  - Callback type, either 'change' or 'delete'.
	 */
	final protected function __construct(
		protected readonly Registered $field,
		protected $callback,
		string $cb_type,
	) {
		$this->box = $this->field->get_box();
		$this->variation = $this->field->variation;
		$this->box_type = $this->box->get_box_type();
		$this->key = $field->get_id();
		$this->object_types = $this->box->get_object_types();

		$this->register_hooks( $cb_type );
	}


	/**
	 * Register the required actions based on this field and its box.
	 *
	 * @phpstan-param static::TYPE_* $cb_type
	 *
	 * @param string                 $cb_type - Callback type, either 'change' or 'delete'.
	 *
	 * @return void
	 */
	protected function register_hooks( string $cb_type ): void {
		// Taxonomy fields added to a `post` object.
		if ( Repo::in()->supports_taxonomy_relationships( $this->box_type, $this->field ) ) {
			$this->track_previous_taxonomy_value();
			if ( static::TYPE_CHANGE === $cb_type ) {
				$this->taxonomy_change_hooks();
			} else {
				$this->taxonomy_delete_hooks();
			}
			// Option page fields.
		} elseif ( BoxType::OPTIONS === $this->box_type ) {
			if ( static::TYPE_CHANGE === $cb_type ) {
				$this->options_change_hooks();
			} else {
				$this->options_delete_hooks();
			}
			// Default: Standard meta fields.
		} else {
			$this->track_previous_meta_value();
			if ( static::TYPE_CHANGE === $cb_type ) {
				$this->meta_change_hooks();
			} else {
				$this->meta_delete_hooks();
			}
		}
	}


	/**
	 * Hooks required to track a change event for a taxonomy value.
	 *
	 * @return void
	 */
	public function taxonomy_change_hooks(): void {
		add_action( 'set_object_terms', function( ...$args ) {
			[ $object_id, $terms, $tt_ids, $taxonomy, $append, $old_tt_ids ] = $args;
			if ( ! $this->variation instanceof Taxonomy || $this->variation->get_taxonomy() !== $taxonomy ) {
				return;
			}
			if ( $tt_ids === $old_tt_ids ) {
				return;
			}

			if ( \in_array( get_post_type( $object_id ), $this->object_types, true ) ) {
				// Already run during `deleted_term_relationship`.
				// Same logic used within `wp_set_object_terms`.
				if ( ! $append && \count( \array_diff( $old_tt_ids, $tt_ids ) ) > 0 ) {
					return;
				}
				$this->previous_value = $old_tt_ids;
				$this->fire_change_callback( $object_id, $terms );
			}
		}, 10, 6 );

		// If a previously existing term is removed from this item, it has changed.
		add_action( 'deleted_term_relationships', function( ...$args ) {
			if ( ! $this->variation instanceof Taxonomy ) {
				return;
			}
			[ $object_id, $tt_ids, $taxonomy ] = $args;
			if ( $tt_ids === $this->previous_value || $this->variation->get_taxonomy() !== $taxonomy ) {
				return;
			}
			if ( \in_array( get_post_type( $object_id ), $this->object_types, true ) ) {
				$this->fire_change_callback( $object_id, wp_get_object_terms( $object_id, $taxonomy, [
					'fields' => Get_Terms::FIELD_IDS,
				] ) );
			}
		}, 10, 3 );
	}


	/**
	 * Hooks required to track a change event for a taxonomy value.
	 *
	 * @return void
	 */
	protected function taxonomy_delete_hooks(): void {
		add_action( 'deleted_term_relationships', function( ...$args ) {
			if ( ! $this->variation instanceof Taxonomy ) {
				return;
			}
			[ $object_id, $tt_ids, $taxonomy ] = $args;
			if ( $tt_ids === $this->previous_value || $this->variation->get_taxonomy() !== $taxonomy ) {
				return;
			}
			if ( \in_array( get_post_type( $object_id ), $this->object_types, true ) ) {
				$this->fire_delete_callback( $object_id );
			}
		}, 10, 6 );
	}


	/**
	 * Track the previous taxonomy terms before the terms are updated.
	 *
	 * Used to provide the `previous_value` as an argument to the callbacks.
	 *
	 * @return void
	 */
	protected function track_previous_taxonomy_value(): void {
		add_action( 'delete_term_relationships', function( ...$args ) {
			if ( ! $this->variation instanceof Taxonomy ) {
				return;
			}
			[ $object_id, $tt_ids, $taxonomy ] = $args;
			if ( $this->variation->get_taxonomy() !== $taxonomy ) {
				return;
			}
			if ( \in_array( get_post_type( $object_id ), $this->object_types, true ) ) {
				$this->previous_value = wp_get_object_terms( $object_id, $taxonomy, [
					'fields' => Get_Terms::FIELD_TT_IDS,
				] );
			}
		}, 10, 3 );
	}


	/**
	 * Hooks required to track a change event for an options page value.
	 *
	 * @see \CMB2_Options_Hookup::hooks
	 *
	 * @return void
	 */
	public function options_change_hooks(): void {
		$action = "update_option_{$this->box->get_id()}";
		// Network level.
		if ( \method_exists( $this->box, 'is_network' ) && $this->box->is_network() ) {
			$action = "update_site_option_{$this->box->get_id()}";
		}

		add_action( $action, function( ...$args ) {
			[ $old_value, $value ] = $args;
			$this->previous_value = $old_value[ $this->key ] ?? null;
			// Values is removed.
			if ( ! isset( $value[ $this->key ] ) && null !== $this->previous_value ) {
				$this->fire_change_callback( $this->box->get_id(), null );
			}

			// Value is changed.
			if ( isset( $value[ $this->key ] ) && $value[ $this->key ] !== $this->previous_value ) {
				$this->fire_change_callback( $this->box->get_id(), $value[ $this->key ] );
			}
		}, 10, 2 );

		$action = "add_option_{$this->box->get_id()}";
		// Network level.
		if ( \method_exists( $this->box, 'is_network' ) && $this->box->is_network() ) {
			$action = "add_site_option_{$this->box->get_id()}";
		}

		add_action( $action, function( $option, $value ) {
			$this->previous_value = null;
			if ( isset( $value[ $this->key ] ) ) {
				$this->fire_change_callback( $this->box->get_id(), null );
			}
		}, 10, 2 );
	}


	/**
	 * Hooks required to track a delete event for an options page value.
	 *
	 * @see \CMB2_Options_Hookup::hooks
	 *
	 * @return void
	 */
	public function options_delete_hooks(): void {
		$action = "update_option_{$this->box->get_id()}";
		// Network level box.
		if ( \method_exists( $this->box, 'is_network' ) && $this->box->is_network() ) {
			$action = "update_site_option_{$this->box->get_id()}";
		}
		add_action( $action, function( ...$args ) {
			[ $old_value, $value ] = $args;
			$this->previous_value = $old_value[ $this->key ] ?? null;
			if ( ! isset( $value[ $this->key ] ) && isset( $old_value[ $this->key ] ) ) {
				$this->fire_delete_callback( $this->box->get_id() );
			}
		}, 10, 2 );
	}


	/**
	 * Hooks required to track a change event for a meta value.
	 *
	 * @return void
	 */
	public function meta_change_hooks(): void {
		add_action( "added_{$this->box_type->value}_meta", function( ...$args ) {
			[ $meta_id, $object_id, $key, $value ] = $args;
			if ( $this->key === $key ) {
				$this->fire_change_callback( $object_id, $value );
			}
		}, 10, 4 );
		add_action( "updated_{$this->box_type->value}_meta", function( ...$args ) {
			[ $meta_id, $object_id, $key, $value ] = $args;
			if ( $this->key === $key && $value !== $this->previous_value ) {
				$this->fire_change_callback( $object_id, $value );
			}
		}, 10, 4 );

		// If the value previously existed and is now deleted, it has changed.
		add_action( "deleted_{$this->box_type->value}_meta", function( ...$args ) {
			[ $meta_id, $object_id, $key, $value ] = $args;
			if ( $this->key === $key && null !== $this->previous_value ) {
				$this->fire_change_callback( $object_id, $value );
			}
		}, 10, 4 );
	}


	/**
	 * Hooks required to track a delete event for a meta value.
	 *
	 * @return void
	 */
	protected function meta_delete_hooks(): void {
		add_action( "deleted_{$this->box_type->value}_meta", function( ...$args ) {
			[ $meta_id, $object_id, $key, $value ] = $args;
			if ( $this->key === $key && null !== $this->previous_value ) {
				$this->fire_delete_callback( $object_id );
			}
		}, 10, 4 );
	}


	/**
	 * Track the previous meta value before the meta is updated.
	 *
	 * Used to provide the `previous_value` as an argument to the callbacks.
	 *
	 * @return void
	 */
	protected function track_previous_meta_value(): void {
		add_action( "update_{$this->box_type->value}_meta", function( ...$args ) {
			[ $meta_id, $object_id, $key ] = $args;
			if ( $this->key === $key ) {
				$this->previous_value = get_metadata_raw( $this->box_type->value, $object_id, $this->key, true );
			}
		}, 10, 3 );
		add_action( "delete_{$this->box_type->value}_meta", function( ...$args ) {
			[ $meta_ids, $object_id, $key ] = $args;
			if ( $this->key === $key ) {
				$this->previous_value = get_metadata_raw( $this->box_type->value, $object_id, $this->key, true );
			}
		}, 10, 3 );
	}


	/**
	 * Call the field's `change_cb` callback.
	 *
	 * @param int|string $object_id - ID of the object, or the options page.
	 * @param mixed      $value     - The new value.
	 *
	 * @return void
	 */
	public function fire_change_callback( int|string $object_id, mixed $value ): void {
		\call_user_func(
			$this->callback,
			$object_id,
			$value,
			$this->key,
			$this->previous_value,
			$this->box_type
		);
	}


	/**
	 * Call the field's `delete_cb` callback.
	 *
	 * @param int|string $object_id - Id of the object or the options page.
	 *
	 * @return void
	 */
	public function fire_delete_callback( int|string $object_id ): void {
		\call_user_func(
			$this->callback,
			$object_id,
			$this->key,
			$this->previous_value,
			$this->box_type
		);
	}


	/**
	 * Create a Event_Callbacks instance from a field and callback.
	 *
	 * @phpstan-param static::TYPE_*      $cb_type
	 * @phpstan-param CHANGE_CB|DELETE_CB $callback
	 *
	 * @param Field                       $field    - Field to register events for.
	 * @param callable                    $callback - Callback to run when the field changes or is deleted.
	 * @param string                      $cb_type  - Callback type, either 'change' or 'delete'.
	 *
	 * @return static
	 */
	public static function factory( Field $field, callable $callback, string $cb_type ): static {
		return new static( Registered::factory( $field ), $callback, $cb_type );
	}
}
