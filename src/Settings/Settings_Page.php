<?php
declare( strict_types=1 );

namespace Lipe\Lib\Settings;

use Lipe\Lib\Settings\Settings_Page\Settings;

/**
 * Register and render a settings page using the WordPress settings API.
 *
 * @link   https://developer.wordpress.org/plugins/settings/custom-settings-page/
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 */
class Settings_Page {
	// Menu positions (see add_menu_page docs for more details).
	public const POSITION_DASHBOARD  = 2;
	public const POSITION_POSTS      = 5;
	public const POSITION_MEDIA      = 10;
	public const POSITION_PAGES      = 20;
	public const POSITION_COMMENTS   = 25;
	public const POSITION_APPEARANCE = 60;
	public const POSITION_PLUGINS    = 65;
	public const POSITION_USERS      = 70;
	public const POSITION_TOOLS      = 75;
	public const POSITION_SETTINGS   = 80;
	// Network Menu positions.
	public const POSITION_NETWORK_DASHBOARD = 2;
	public const POSITION_NETWORK_SITES     = 5;
	public const POSITION_NETWORK_USERS     = 10;
	public const POSITION_NETWORK_THEMES    = 15;
	public const POSITION_NETWORK_PLUGINS   = 20;
	public const POSITION_NETWORK_SETTINGS  = 25;
	public const POSITION_NETWORK_UPDATES   = 30;


	/**
	 * Build a new settings page and call the hooks.
	 *
	 * @param Settings $settings - Setting configuration.
	 */
	final protected function __construct(
		public readonly Settings $settings,
	) {
	}


	/**
	 * Hook into the WP settings API.
	 *
	 * @return void
	 */
	public function init(): void {
		if ( ! is_admin() ) {
			return;
		}
		if ( $this->settings->is_network() ) {
			add_action( 'network_admin_menu', [ $this, 'register' ], 10, 0 );
			add_action( 'network_admin_edit_' . $this->settings->get_id(), [ $this, 'save_network_settings' ], 10, 0 );
		} else {
			add_action( 'admin_menu', [ $this, 'register' ], 10, 0 );
		}
	}


	/**
	 * Register the settings page with WordPress.
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_menu_page/
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function register(): void {
		if ( null === $this->settings->get_parent_menu_slug() ) {
			add_menu_page(
				$this->settings->get_title(),
				$this->settings->get_title(),
				$this->settings->get_capability(),
				$this->settings->get_id(),
				[ $this, 'render' ],
				$this->settings->get_icon(),
				$this->settings->get_position()
			);
		} else {
			add_submenu_page(
				$this->settings->get_parent_menu_slug(),
				$this->settings->get_title(),
				$this->settings->get_title(),
				$this->settings->get_capability(),
				$this->settings->get_id(),
				[ $this, 'render' ]
			);
		}

		foreach ( $this->settings->get_sections() as $section ) {
			add_settings_section(
				$section->id,
				$section->title,
				[ $section, 'render_description' ],
				$this->settings->get_id(),
				$section->args->get_args()
			);
			foreach ( $section->get_fields() as $field ) {
				$callback = function() use ( $field ) {
					$field->render( $this );
				};

				add_settings_field(
					$field->id,
					$field->title,
					$callback,
					$this->settings->get_id(),
					$section->id,
					$field->args->get_args()
				);

				register_setting( $this->settings->get_id(), $field->id, $field->settings_args->get_args() );
			}
		}
	}


	/**
	 * Network settings don't have an endpoint to automatically save the settings
	 * like options.php does. For network settings we need to manually save
	 * the settings.
	 *
	 * @return void
	 */
	public function save_network_settings(): void {
		if ( ! isset( $_POST['_wpnonce'] ) || false === wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), $this->settings->get_id() . '-options' ) ) {
			return;
		}

		if ( ! current_user_can( $this->settings->get_capability() ) ) {
			return;
		}

		foreach ( $this->settings->get_sections() as $section ) {
			foreach ( $section->get_fields() as $field ) {
				$value = null;
				if ( isset( $_POST[ $field->id ] ) ) {
					if ( \is_array( $_POST[ $field->id ] ) ) {
						$value = \array_map( 'sanitize_text_field', \wp_unslash( $_POST[ $field->id ] ) );
					} else {
						$value = \trim( sanitize_text_field( \wp_unslash( $_POST[ $field->id ] ) ) );
					}
				}
				update_site_option( $field->id, $value );
			}
		}

		$parent_slug = $this->settings->get_parent_menu_slug();
		if ( null !== $parent_slug && \str_contains( $parent_slug, '.php' ) ) {
			$parent_url = network_admin_url( $parent_slug );
		} else {
			$parent_url = network_admin_url( 'admin.php' );
		}
		$url = add_query_arg( [
			'page'             => $this->settings->get_id(),
			'settings-updated' => 'true',
		], $parent_url );

		if ( wp_safe_redirect( $url ) ) {
			die();
		}
	}


	/**
	 * Render the settings page.
	 *
	 * @interal
	 *
	 * @return void
	 */
	public function render(): void {
		if ( ! current_user_can( $this->settings->get_capability() ) ) {
			return;
		}
		$this->display_status_messages();
		?>
		<div class="wrap">
			<h1><?= esc_html( $this->settings->get_title() ) ?></h1>
			<?php
			if ( '' !== $this->settings->get_description() ) {
				?>
				<p class="description">
					<?= wp_kses_post( $this->settings->get_description() ) ?>
				</p>
				<?php
			}
			?>
			<form method="post" action="<?= esc_url( $this->get_action_url() ) ?>">
				<?php
				settings_fields( $this->settings->get_id() );
				do_settings_sections( $this->settings->get_id() );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}


	/**
	 * Are we currently viewing this settings page?
	 *
	 * @return bool
	 */
	public function is_settings_page(): bool {
		if ( ! \function_exists( 'get_current_screen' ) ) {
			return false;
		}
		$screen = get_current_screen();
		if ( ! $screen instanceof \WP_Screen ) {
			return false;
		}
		$hook = get_plugin_page_hook( $this->settings->get_id(), $this->settings->get_parent_menu_slug() ?? '' );
		if ( null === $hook ) {
			return false;
		}

		return $hook === $screen->id;
	}


	/**
	 * Register and display status messages when settings are updated.
	 *
	 * @return void
	 */
	protected function display_status_messages(): void {
		// options-general.php includes the "wp-admin/options-head.php" file already outputting messages.
		if ( 'options-general.php' === $this->settings->get_parent_menu_slug() ) {
			return;
		}

		// phpcs:ignore WordPress.Security.NonceVerification -- Redirect coming from WP core.
		if ( isset( $_GET['settings-updated'] ) && 'true' === $_GET['settings-updated'] ) {
			add_settings_error( $this->settings->get_id(), $this->settings->get_id(), __( 'Settings Saved.', 'lipe' ), 'updated' );
		}

		settings_errors( $this->settings->get_id() );
	}


	/**
	 * Get the URL for the form action.
	 *
	 * - Network: Network admin URL with the action query string.
	 * - Single Site: Options API endpoint which automatically saves the settings.
	 *
	 *
	 * @return string
	 */
	protected function get_action_url(): string {
		if ( $this->settings->is_network() ) {
			return network_admin_url( 'edit.php?action=' . $this->settings->get_id() );
		}

		return admin_url( 'options.php' );
	}


	/**
	 * Get a site option or regular depending on if we are a network or not.
	 *
	 * @param string $field         - The field key.
	 * @param mixed  $default_value - The default value to return if the option is not set.
	 *
	 * @return mixed
	 */
	public function get_option( string $field, mixed $default_value = null ): mixed {
		if ( $this->settings->is_network() ) {
			return get_site_option( $field, $default_value );
		}

		return get_option( $field, $default_value );
	}


	/**
	 * Build a new settings page and call the hooks.
	 *
	 * @param Settings $settings - Setting configuration.
	 */
	public static function factory( Settings $settings ): Settings_Page {
		return new static( $settings );
	}
}
