<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\Meta\Registered;
use Lipe\Lib\Theme\Dashicons;

/**
 * CMB2 Option Page fluent interface.
 */
class Options_Page extends Box {

	/**
	 * Set to `network_admin_menu` to add the options page to the network admin menu.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#admin_menu_hook
	 *
	 * @example 'network_admin_menu'
	 *
	 * @var string
	 */
	public string $admin_menu_hook = 'admin_menu';

	/**
	 * Sent along to add_menu_page()/add_submenu_page()
	 * to define the capability required to view the options page.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#capability
	 *
	 * @example 'edit_posts'
	 *
	 * @var string
	 */
	public string $capability = 'manage_options';

	/**
	 * On settings pages (not options-general.php sub-pages), allows disabling
	 * of error displaying
	 *
	 * @notice  This only exists in example-functions.php and not in docs.
	 *          May require more testing.
	 *
	 * @var bool
	 */
	public bool $disable_settings_errors;

	/**
	 * Allows overriding the options page form output.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Box-Properties#display_cb
	 *
	 * @var callable
	 */
	public $display_cb;

	/**
	 * This parameter is for options-page meta boxes only,
	 * and is sent along to add_menu_page() to define the menu icon.
	 * Only applicable if parent_slug is left empty.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#icon_url
	 *
	 * @example 'dashicons-chart-pie'
	 * @see     Dashicons
	 *
	 * @var string
	 */
	public string $icon_url;

	/**
	 * Sent along to add_menu_page()/add_submenu_page() to define the menu title.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#menu_title
	 *
	 * @example 'Site Options
	 *
	 * @var string
	 */
	public string $menu_title;

	/**
	 * Allows specifying a custom callback for setting the
	 * error/success message on save.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#message_cb
	 *
	 * @example 'my_callback_function_to_display_messages( $cmb, $args )'
	 *
	 * @var callable
	 */
	public $message_cb;

	/**
	 * Sent along to add_submenu_page() to define the parent-menu item slug.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#parent_slug
	 *
	 * @example 'tools.php'
	 *
	 * @var string
	 */
	public string $parent_slug;

	/**
	 * Sent along to add_menu_page() to define the menu position.
	 * Only applicable if parent_slug is left empty.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#position
	 *
	 * @example 6
	 *
	 * @var int
	 */
	public int $position;

	/**
	 * Defines the text for the options page save button. defaults to 'Save'.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#save_button
	 *
	 * @example 'Save Settings'
	 *
	 * @internal
	 * @see     Options_Page::save_button();
	 *
	 * @var string
	 */
	public string $save_button;

	/**
	 * Defines the settings page slug. Defaults to $id.
	 *
	 * @example 'my_options_page_slug'
	 *
	 * @var string
	 */
	public string $option_key;

	/**
	 * Holds default values specified on individual fields
	 * for use with the get filter.
	 * CMB2 saves options as a single blob, so we use the
	 * filter to inject the default on retrieval.
	 *
	 * @var array<string, mixed>
	 */
	protected array $default_values = [];


	/**
	 * Options Page constructor.
	 *
	 * @param string      $id    - Options page id.
	 * @param string|null $title - Options page title.
	 */
	public function __construct( string $id, ?string $title ) {
		if ( ! isset( $this->option_key ) ) {
			$this->option_key = $id;
		}

		add_action( "cmb2_init_hookup_{$id}", [ $this, 'run_options_hookup_on_front_end' ] );

		parent::__construct( $id, [ BoxType::OPTIONS->value ], $title );
	}


	/**
	 * Is this a network level settings page?
	 *
	 * @param bool $is_network - Whether this is a network settings page.
	 *
	 * @return void
	 */
	public function network( bool $is_network = true ): void {
		if ( $is_network ) {
			$this->admin_menu_hook = 'network_admin_menu';
		} else {
			$this->admin_menu_hook = 'admin_menu';
		}
	}


	/**
	 * Set the icon for the options page.
	 * - Sent along to add_menu_page() to define the menu icon.
	 * - Only applicable if `parent_slug` is left empty.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#icon_url
	 *
	 * @param string|Dashicons $icon - The icon to use.
	 *
	 * @return void
	 */
	public function icon( string|Dashicons $icon ): void {
		$this->icon_url = $icon instanceof Dashicons ? $icon->value : $icon;
	}


	/**
	 * Specify the save button text.
	 * Set to `null` to create a read-only form which has no save button.
	 *
	 * @param null|string $text - The text to display on the save button.
	 *
	 * @return void
	 */
	public function save_button( ?string $text ): void {
		$this->save_button = $text ?? '';
		if ( null === $text ) {
			add_action( "cmb2_before_options-page_form_{$this->id}", function() {
				// Hide, so we never see it with FOUC. Remove, so we can't submit the form via enter.
				?>
				<style>
					[id="<?= esc_js( $this->id ) ?>"] .submit {
						display: none;
					}
				</style>
				<script>
					jQuery( function ( $ ) {
						$( '[id="<?= esc_js( $this->id ) ?>"] .submit' ).remove();
					} );
				</script>
				<?php
			} );
		}
	}


	/**
	 * Is this box for network settings?
	 *
	 * @interal
	 *
	 * @return bool
	 */
	public function is_network(): bool {
		return 'network_admin_menu' === $this->admin_menu_hook;
	}


	/**
	 * The options hookups translate options to sitemeta for the network
	 * options, among other things.
	 *
	 * The CMB2 plugin only runs these hookups in the admin because
	 * it expects direct calls to `get_site_option`. We mimic the admin
	 * functionality here, so we get the correct values when using the Repo.
	 *
	 * @param \CMB2 $cmb - The CMB2 object.
	 */
	public function run_options_hookup_on_front_end( \CMB2 $cmb ): void {
		if ( ! is_admin() ) {
			$hookup = new \CMB2_Hookup( $cmb );
			$hookup->options_page_hooks();
		}
	}


	/**
	 * Option pages are stored in one big blob which means we
	 * must implement logic to separate the fields when registering.
	 *
	 * Gives a universal place for amending the config.
	 *
	 * @param Registered           $registered - The registered field.
	 * @param array<string, mixed> $config     - The field config.
	 */
	public function register_meta_on_all_types( Registered $registered, array $config ): void {
		unset( $config['single'] );
		$config['label'] = $registered->variation->name;
		$config['description'] = "Lives under the `{$registered->get_box()->get_id()}` option.";

		if ( false !== $registered->get_show_in_rest() ) {
			$config = $this->translate_rest_keys( $registered, $config );
			add_filter( 'rest_pre_get_setting', function( $pre, $option ) use ( $registered, $config ) {
				if ( isset( $config['show_in_rest'] ) && $option === $config['show_in_rest']['name'] ) {
					return cmb2_options( $this->id )->get( $registered->get_id(), $registered->get_default( $registered->get_box()->get_id() ) ?? false );
				}
				return $pre;
			}, 9, 2 );
		}

		// Nothing to register.
		if ( 2 > \count( $config ) ) {
			return;
		}

		register_setting( 'options', $registered->get_id(), $config );
	}
}
