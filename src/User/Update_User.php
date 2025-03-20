<?php

declare( strict_types=1 );

namespace Lipe\Lib\User;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for `wp_insert_user` and `wp_update_user`.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @see    wp_insert_user()
 * @see    wp_update_user()
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_insert_user/
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Update_User implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * User ID. If supplied, the user will be updated.
	 *
	 * @var int
	 */
	public int $ID;

	/**
	 * The plain-text user password.
	 *
	 * @var string
	 */
	public string $user_pass;

	/**
	 * The user's login username.
	 *
	 * @var string
	 */
	public string $user_login;

	/**
	 * The URL-friendly username.
	 *
	 * @var string
	 */
	public string $user_nicename;

	/**
	 * The user URL.
	 *
	 * @var string
	 */
	public string $user_url;

	/**
	 * The user email address.
	 *
	 * @var string
	 */
	public string $user_email;

	/**
	 * The user's display name.
	 *
	 * Default is the user's username.
	 *
	 * @var string
	 */
	public string $display_name;

	/**
	 * The user's nickname.
	 *
	 * Default is the user's username.
	 *
	 * @var string
	 */
	public string $nickname;

	/**
	 * The user's first name. For new users, will be used to build the first part of the user's display name if
	 * `$display_name` is not specified.
	 *
	 * @var string
	 */
	public string $first_name;

	/**
	 * The user's last name. For new users, will be used to build the second part of the user's display name if
	 * `$display_name` is not specified.
	 *
	 * @var string
	 */
	public string $last_name;

	/**
	 * The user's biographical description.
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * Whether to enable the rich-editor for the user. Accepts 'true' or 'false' as a string literal, not boolean.
	 *
	 * Default 'true'.
	 *
	 * @phpstan-var 'true'|'false'
	 *
	 * @var string
	 */
	public string $rich_editing;

	/**
	 * Whether to enable the rich code editor for the user. Accepts 'true' or 'false' as a string literal, not boolean.
	 *
	 * Default 'true'.
	 *
	 * @phpstan-var 'true'|'false'
	 *
	 * @var string
	 */
	public string $syntax_highlighting;

	/**
	 * Whether to enable comment moderation keyboard shortcuts for the user. Accepts 'true' or 'false' as a string
	 * literal, not boolean.
	 *
	 * Default 'false'.
	 *
	 * @phpstan-var 'true'|'false'
	 *
	 * @var string
	 */
	public string $comment_shortcuts;

	/**
	 * Admin color scheme for the user.
	 *
	 * Default 'fresh'.
	 *
	 * @var string
	 */
	public string $admin_color;

	/**
	 * Whether the user should always access the admin over https.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $use_ssl;

	/**
	 * Date the user registered. Format is 'Y-m-d H:i:s'.
	 *
	 * @var string
	 */
	public string $user_registered;

	/**
	 * Password reset key.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $user_activation_key;

	/**
	 * Multisite only. Whether the user is marked as spam.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $spam;

	/**
	 * Whether to display the Admin Bar for the user on the site's front end. Accepts 'true' or 'false' as a string
	 * literal, not boolean.
	 *
	 * Default 'true'.
	 *
	 * @phpstan-var 'true'|'false'
	 *
	 * @var string
	 */
	public string $show_admin_bar_front;

	/**
	 * User's role.
	 *
	 * @var string
	 */
	public string $role;

	/**
	 * User's locale.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $locale;

	/**
	 * Array of user meta values keyed by their meta key.
	 *
	 * Default empty.
	 *
	 * @var array<string,mixed>
	 */
	public array $meta_input;
}
