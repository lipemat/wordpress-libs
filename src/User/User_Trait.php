<?php
declare( strict_types=1 );

namespace Lipe\Lib\User;

use Lipe\Lib\Libs\Container\Factory;
use Lipe\Lib\Meta\MetaType;
use Lipe\Lib\Meta\Mutator_Trait;

/**
 * Shared methods for interacting with the WordPress user object.
 *
 * @property string   $nickname
 * @property string   $description
 * @property string   $user_description
 * @property string   $first_name
 * @property string   $user_firstname
 * @property string   $last_name
 * @property string   $user_lastname
 * @property string   $user_login
 * @property string   $user_pass
 * @property string   $user_nicename
 * @property string   $user_email
 * @property string   $user_url
 * @property string   $user_registered
 * @property string   $user_activation_key
 * @property string   $user_status
 * @property int      $user_level
 * @property string   $display_name
 * @property string   $spam
 * @property string   $deleted
 * @property string   $locale
 * @property string   $rich_editing
 * @property string   $syntax_highlighting
 * @property string[] $roles
 *
 * @method bool[] get_role_caps()
 * @method void add_role( string $role )
 * @method void remove_role( string $role )
 * @method void set_role( string $role )
 * @method int level_reduction( int $max, string $item )
 * @method void update_user_level_from_caps()
 * @method void add_cap( string $cap, bool $grant = true )
 * @method void remove_cap( string $cap )
 * @method void remove_all_caps()
 * @method bool has_cap( string $cap, ...$args )
 * @method string translate_level_to_cap( int $level )
 * @method void for_site( int $site_id = '' )
 * @method int get_site_id()
 *
 * @template OPTIONS of array<string, mixed>
 */
trait User_Trait {
	/**
	 * @use Factory<array{int|\WP_User|null}>
	 */
	use Factory;

	/**
	 * @use Mutator_Trait<OPTIONS>
	 */
	use Mutator_Trait;

	/**
	 * User ID
	 *
	 * @var int
	 */
	protected int $user_id;

	/**
	 * User object
	 *
	 * @var ?\WP_User
	 */
	protected null|\WP_User $user;


	/**
	 * User_Trait constructor.
	 *
	 * @param \WP_User|int|null $user - User ID, WP_User object, or null for the current user.
	 */
	public function __construct( null|\WP_User|int $user = null ) {
		if ( null === $user ) {
			if ( is_user_logged_in() ) {
				$this->user_id = get_current_user_id();
			} else {
				_doing_it_wrong( __CLASS__, "You can't use the `User` object without a user id available.", '3.14.0' );
				$this->user_id = 0;
			}
		} elseif ( \is_a( $user, \WP_User::class ) ) {
			if ( $user->exists() ) {
				$this->user = $user;
			}
			$this->user_id = $user->ID;
		} else {
			$this->user_id = (int) $user;
		}
	}


	/**
	 * Get the user ID.
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->user_id;
	}


	/**
	 * Used to determine the type of meta to retrieve or update.
	 *
	 * @return MetaType
	 */
	public function get_meta_type(): MetaType {
		return MetaType::USER;
	}


	/**
	 * Get the user object.
	 *
	 * @return \WP_User|null
	 */
	public function get_object(): ?\WP_User {
		if ( ! isset( $this->user ) && 0 !== $this->user_id ) {
			$user = get_user_by( 'id', $this->user_id );
			if ( $user instanceof \WP_User && $user->exists() ) {
				$this->user = $user;
			} else {
				$this->user = null;
			}
		}

		return $this->user ?? null;
	}


	/**
	 * Does this user exist in the database?
	 *
	 * @return bool
	 */
	public function exists(): bool {
		return $this->get_object() instanceof \WP_User && $this->get_object()->exists();
	}


	/**
	 * Access to extended properties from WP_User which
	 * are not available on `WP_User::$data`.
	 *
	 * @see \WP_User::__get
	 * @see Mutator_Trait::__get
	 *
	 * @return list<string>
	 */
	protected function get_extended_properties(): array {
		return [
			'deleted',
			'description',
			'first_name',
			'last_name',
			'locale',
			'nickname',
			'rich_editing',
			'spam',
			'syntax_highlighting',
			'use_ssl',
			'user_description',
			'user_firstname',
			'user_lastname',
			'user_level',
		];
	}


	/**
	 * Get an instance of this class.
	 *
	 * @param \WP_User|int|null $user - User ID, WP_User object, or null for the current user.
	 *
	 * @return static
	 */
	public static function factory( null|\WP_User|int $user = null ): static {
		return static::createFactory( $user );
	}
}
