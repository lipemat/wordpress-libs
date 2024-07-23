<?php
declare( strict_types=1 );

namespace Lipe\Lib\User;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for the `wp_login_form` function in WordPress.
 *
 * @author Mat Lipe
 * @since  4.1.0
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_login_form/#parameters
 */
class Wp_Login_Form implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 *  Whether to display the login form or return the form HTML code.
	 *
	 * @default true ( echo ).
	 *
	 * @var bool
	 */
	public bool $echo;

	/**
	 * URL to redirect to.
	 *
	 * Must be absolute, as in "https://example.com/mypage/".
	 *
	 * @default is to redirect back to the request URI.
	 *
	 * @var string
	 */
	public string $redirect;

	/**
	 * ID attribute value for the form.
	 *
	 * @default 'loginform'.
	 *
	 * @var string
	 */
	public string $form_id;

	/**
	 * Label for the username or email address field.
	 *
	 * @default 'Username or Email Address'.
	 *
	 * @var string
	 */
	public string $label_username;

	/**
	 * Label for the password field.
	 *
	 * @default 'Password'.
	 *
	 * @var string
	 */
	public string $label_password;

	/**
	 * Label for the remember field.
	 *
	 * @default 'Remember Me'.
	 *
	 * @var string
	 */
	public string $label_remember;

	/**
	 * Label for the submit button.
	 *
	 * @default 'Log In'.
	 *
	 * @var string
	 */
	public string $label_log_in;

	/**
	 * ID attribute value for the username field.
	 *
	 * @default 'user_login'.
	 *
	 * @var string
	 */
	public string $id_username;

	/**
	 * ID attribute value for the password field.
	 *
	 * @default 'user_pass'.
	 *
	 * @var string
	 */
	public string $id_password;

	/**
	 * ID attribute value for the remember field.
	 *
	 * @default 'rememberme'.
	 *
	 * @var string
	 */
	public string $id_remember;

	/**
	 * ID attribute value for the submit button.
	 *
	 * @default 'wp-submit'.
	 *
	 * @var string
	 */
	public string $id_submit;

	/**
	 * Whether to display the "rememberme" checkbox in the form.
	 *
	 * @var bool
	 */
	public bool $remember;

	/**
	 * Add `required` attribute to the username field.
	 *
	 * @var bool
	 */
	public bool $required_username;

	/**
	 * Add `required` attribute to the password field.
	 *
	 * @var bool
	 */
	public bool $required_password;

	/**
	 * Default value for the username field.
	 *
	 * @default empty.
	 *
	 * @var string
	 */
	public string $value_username;

	/**
	 * Whether the "Remember Me" checkbox should be checked by default.
	 *
	 * @default false ( unchecked ).
	 *
	 * @var bool
	 */
	public bool $value_remember;
}
