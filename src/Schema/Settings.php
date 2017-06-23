<?php

namespace Lipe\Lib\Schema;

/**
 * Settings
 *
 * @todo integration new 4.7 register settings params
 * @link https://make.wordpress.org/core/2016/10/26/registering-your-settings-in-wordpress-4-7/
 *
 * Abstract starting point for a settings page
 * Retrieve option from proper location by using $this->get_option()
 *
 * Extend this with another class that does not have a __construct method or call parent::__construct()
 * Implement the abstract methods and set appropriate class vars. This will do the rest.
 *
 * To have a description for a section create a public method %section_slug%_description and
 * it will automatically be used
 *
 * To have a description for a field create a protected method %field_slug%_description and it will
 * automatically be called under the field output
 *
 * To sanitize a field create a "public" method named %field_slug%_sanitize and it wll automatically
 * receive the value to sanitize
 *
 * To override the default text field create a protected method with same name as option and
 * it will be passed the ( %value%, %field% ) as its argument.
 *
 * To run a method when the settings are saved create one named on_settings_save() and it
 * will be called automatically
 *
 *
 *
 */
abstract class Settings {

	/**
	 * Title
	 *
	 * Menu and Settings page title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Menu Title
	 *
	 * Menu item label ( defaults to $this->title )
	 *
	 * @var string
	 */
	protected $menu_title;

	/**
	 * Description
	 *
	 * Will display directly under the settings page's title
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Slug
	 *
	 * Settings slug
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * Namespace
	 *
	 * Auto namespace the options during rendering, saving, and retrieval
	 *
	 * @var bool
	 */
	protected $namespace = null;

	/**
	 * Parent menu Slug
	 *
	 * Where should we put this menu
	 *
	 * @uses leave blank for a top level menu
	 *
	 * @var string
	 */
	protected $parent_menu_slug = 'options-general.php';

	/**
	 * Menu Icon
	 *
	 * If you are creating a main level menu use an icon
	 *
	 * @var string Url
	 */
	protected $menu_icon;

	/**
	 * Menu Position
	 *
	 * If you would like specify a menu order
	 *
	 * @var int
	 */
	protected $menu_position;

	/**
	 * Capability
	 *
	 * What permission do I need to use this menu
	 *
	 * @var string
	 */
	protected $capability = 'manage_options';

	/**
	 * Network
	 *
	 * Network admin menu?
	 *
	 * @var bool
	 */
	protected $network = false;

	/**
	 * Settings
	 *
	 * Set me within your add_settings() method
	 *
	 * @var array
	 */
	protected $settings = [];

	/**
	 * defaults
	 *
	 * Hold default values if desired for options
	 * Can be set manually or by using $this->set_default( %field%, %value )
	 *
	 * @example array( %field% => %default_value% )
	 *
	 * @var array
	 */
	protected $defaults = [];

	/**
	 * tabs
	 *
	 * Put the settings sections into tabs
	 *
	 * @var bool
	 */
	protected $tabs = false;

	/**
	 * form_url
	 *
	 * The url the form submits
	 * Set automatically only adjust in extreme cases
	 *
	 * @var string
	 */
	protected $form_url;


	/**
	 * Construct
	 *
	 */
	public function __construct() {
		$this->add_settings();
		$this->set_vars();
		$this->fill_class_vars();
		$this->hook();

	}


	/**
	 * Add Settings
	 *
	 * Method used to set the settings
	 * Separate from set_vars to keep things cleaner
	 *
	 * @uses    $this->settings
	 *
	 *
	 * @example $this->add_setting_section( %slug%, %title% );
	 * @example $this->add_setting( %section%, %field_slug%, %field_title% );
	 *
	 * @example $this->settings = array(
	 *        'career-page' => array(
	 *            'title'    => 'Career Page',
	 *          'fields'    => array(
	 *                'career_heading_message' => 'Heading Message'
	 *
	 *            )
	 *        )
	 * );
	 *
	 */
	abstract protected function add_settings();


	/**
	 * Set Vars
	 *
	 * Use this method to set the necessary class vars
	 *
	 * @see This classes vars
	 *
	 * @return void
	 *
	 */
	abstract protected function set_vars();


	/**
	 * Fill Class Vars
	 *
	 * Did you forget something? Oh well, this will fix it
	 *
	 * @return void
	 */
	private function fill_class_vars() {

		if( empty( $this->title ) ){
			$this->title = __( 'Settings', 'lipe' );
		}

		if( empty( $this->slug ) ){
			$this->slug = strtolower( str_replace( '\\', '-', get_class( $this ) ) );
		}

		if( empty( $this->menu_title ) ){
			$this->menu_title = $this->title;
		}

		if( $this->network ){
			if( 'options-general.php' == $this->parent_menu_slug ){
				$this->parent_menu_slug = 'settings.php';
			}
		}

		if( $this->network ){
			$this->form_url = network_admin_url( 'edit.php?action=' . $this->slug );
		} else {
			$this->form_url = admin_url( 'options.php' );
		}

	}


	public function hook() {
		if( $this->network ){
			add_action( 'network_admin_menu', [ $this, 'register_settings_page' ], 10, 0 );
			add_action( 'network_admin_edit_' . $this->slug, [ $this, 'save_network_settings' ], 10, 0 );

		} else {
			add_action( 'admin_menu', [ $this, 'register_settings_page' ], 10, 0 );
			add_action( 'admin_action_update', [ $this, 'maybe_run_settings_save' ] );

		}

	}


	/**
	 * Call
	 *
	 */
	function __call( $name, $args ) {

	}


	/**
	 * maybe_run_settings_save
	 *
	 * Run a method when the settings are saved
	 * To use create a method title on_settings_saved() in the extending class
	 *
	 * @return void
	 */
	public function maybe_run_settings_save() {
		if( !empty( $_POST[ 'settings_page_slug' ] ) ){
			if( $_POST[ 'settings_page_slug' ] == $this->slug ){
				if( method_exists( $this, 'on_settings_save' ) ){
					$this->on_settings_save();
				}
			}
		}
	}


	/**
	 * set_default
	 *
	 * Set a default value for any field
	 *
	 * @param $field
	 * @param $value
	 *
	 * @return void
	 */
	public function set_default( $field, $value ) {
		$this->defaults[ $field ] = $value;
	}


	/**
	 * Save Network Settings
	 *
	 * Saves the settings if on a network page
	 * Uses update_site_option() instead of update_site_option
	 *
	 * @return void
	 */
	public function save_network_settings() {
		if( !isset( $_POST[ '_wpnonce' ] ) || !wp_verify_nonce( $_POST[ '_wpnonce' ], $this->slug . '-options' ) ){
			return;
		}

		if( method_exists( $this, 'on_settings_save' ) ){
			$this->on_settings_save();
		}

		foreach( $this->settings as $section => $params ){
			foreach( $params[ 'fields' ] as $field => $title ){
				$value = false;
				if( method_exists( $this, $field . "_sanitize" ) ){
					$value = $this->{$field . "_sanitize"}( $_POST[ $this->get_field_name( $field ) ] );

				} elseif( method_exists( $this, $this->get_field_name( $field ) . "_sanitize" ) ) {
					$value = $this->{$this->get_field_name( $field ) . "_sanitize"}( $_POST[ $this->get_field_name( $field ) ] );
				} else {
					if( isset( $_POST[ $this->get_field_name( $field ) ] ) ){
						$value = $_POST[ $this->get_field_name( $field ) ];
					}

				}
				update_site_option( $this->get_field_name( $field ), $value );
			}
		}

		if( strpos( $this->parent_menu_slug, '.php' ) === false ){
			$parent_url = network_admin_url( 'admin.php' );
		} else {
			$parent_url = network_admin_url( $this->parent_menu_slug );
		}
		$url = add_query_arg( [ 'page' => $this->slug, 'updated' => 'true' ], $parent_url );

		wp_redirect( $url );
		die();
	}


	/**
	 * Get Field Name
	 *
	 * Return a field with the namespace prepended to the name
	 * Will check if we have a namespace and if already appended
	 *
	 * @param string $field - possibly non namespaced field
	 *
	 * @return string
	 */
	protected function get_field_name( $field ) {
		if( empty( $this->namespace ) ){
			return $field;
		}

		if( strpos( $field, $this->namespace ) !== false ){
			return $field;
		}

		return $this->namespace . '_' . $field;
	}


	/**
	 * Register Settings Page
	 *
	 * Build the settings page using the options framework
	 *
	 * @uses $this->settings
	 *
	 * @return void
	 *
	 */
	public function register_settings_page() {

		if( !empty( $this->parent_menu_slug ) ){
			add_submenu_page(
				$this->parent_menu_slug,
				$this->title,
				$this->menu_title,
				$this->capability,
				$this->slug,
				[ $this, 'display_settings_page' ]
			);
		} else {
			add_menu_page(
				$this->title,
				$this->menu_title,
				$this->capability,
				$this->slug,
				[ $this, 'display_settings_page' ],
				$this->menu_icon,
				$this->menu_position
			);
		}

		foreach( $this->settings as $section => $params ){
			add_settings_section(
				$section,
				$params[ 'title' ],
				[ $this, $section . '_description' ],
				$this->slug
			);

			foreach( $params[ 'fields' ] as $field => $title ){
				add_settings_field(
					$this->get_field_name( $field ),
					$title,
					[ $this, 'field' ],
					$this->slug,
					$section,
					$field
				);

				if( !$this->network ){
					if( method_exists( $this, $field . "_sanitize" ) ){
						register_setting( $this->slug, $this->get_field_name( $field ), [
							$this,
							$field . '_sanitize',
						] );
					} elseif( method_exists( $this, $this->get_field_name( $field ) . "_sanitize" ) ) {
						register_setting( $this->slug, $this->get_field_name( $field ), [
							$this,
							$this->get_field_name( $field ) . '_sanitize',
						] );
					} else {
						register_setting( $this->slug, $this->get_field_name( $field ) );
					}
				}

			}
		}

	}


	/**
	 * Field
	 *
	 * Will call a method matching the field name if exists
	 * Otherwise outputs a standard text field
	 *
	 * @param array  $item
	 * @param string $field
	 *
	 * @return void
	 *
	 */
	public function field( $field ) {

		$field = $this->get_field_name( $field );

		$value = $this->get_option( $field );

		if( method_exists( $this, $field ) ){
			$this->{$field}( $value, $field );

		} elseif( method_exists( $this, $this->get_non_namespaced_field( $field ) ) ) {
			$this->{$this->get_non_namespaced_field( $field )}( $value, $field );

		} else {
			printf( '<input type="text" name="%1$s" value="%2$s" class="regular-text" />', esc_attr( $field ), esc_attr( $value ) );
		}

		if( method_exists( $this, $this->get_non_namespaced_field( $field ) . '_description' ) ){
			?>
            <p class="description">
				<?php $this->{$this->get_non_namespaced_field( $field ) . '_description'}( $value ); ?>
            </p>
			<?php
		}

	}


	/**
	 * Get Option
	 *
	 * Get a site option or regular depending if we are network or not
	 * Will return the default value for this field if set and the option
	 * has not been set
	 *
	 * @param string $field
	 *
	 * @return mixed|void
	 */
	public function get_option( $field ) {
		$field = $this->get_field_name( $field );
		if( $this->network ){
			$option = get_site_option( $field, null );
		} else {
			$option = get_option( $field, null );
		}

		if( $option === null ){
			if( !empty( $this->defaults[ $field ] ) ){
				return $this->defaults[ $field ];
			} else {
				$non_namespaced = $this->get_non_namespaced_field( $field );
				if( !empty( $this->defaults[ $non_namespaced ] ) ){
					return $this->defaults[ $non_namespaced ];
				}
			}
		}

		return $option;
	}


	/**
	 * Get Non Namespaced Field
	 *
	 * Remove the namespace if exists from a field and return the value
	 *
	 * @param string $field - possibly namespaced field
	 *
	 * @return string
	 */
	protected function get_non_namespaced_field( $field ) {
		if( empty( $this->namespace ) ){
			return $field;
		}

		return str_replace( $this->namespace . '_', '', $field );
	}


	/**
	 * Display Settings Page
	 *
	 * Outputs the settings page
	 *
	 * @return void
	 */
	public function display_settings_page() {
		?>
        <div class="wrap">
            <h2><?php echo $this->title; ?></h2>
			<?php
			if( !empty( $this->description ) ){
				?>
                <p class="description">
					<?php echo $this->description; ?>
                </p>
				<?php
			}

			if( $this->tabs ){
				$this->tabbed_form();

			} else {
				?>
                <form action="<?php echo $this->form_url; ?>" method="post">
					<?php
					settings_fields( $this->slug );
					do_settings_sections( $this->slug );
					submit_button();
					?>
                    <input type="hidden" name="settings_page_slug" value="<?php echo esc_attr( $this->slug ); ?>"/>
                </form>
				<?php
			}
			?>
        </div>
		<?php

	}


	/**
	 * tabbed_form
	 *
	 * Generate a settings page with the settings sections placed into tabs
	 * Set $this->tabs to true and it will happen automatically
	 *
	 * @uses $this->settings
	 * @uses $this->tabs
	 *
	 * @return void
	 */
	private function tabbed_form() {
		reset( $this->settings );

		$tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : key( $this->settings );

		?>
        <h2 class="nav-tab-wrapper">
			<?php
			foreach( $this->settings as $section => $params ){
				printf( '<a id="nav-%s" href="%s" class="nav-tab%s">%s</a>',
					$section,
					add_query_arg( 'tab', $section ),
					$tab == $section ? ' nav-tab-active' : '',
					$params[ 'title' ]
				);
			}
			?>
        </h2>

        <form action="<?php echo $this->form_url; ?>" method="post">
			<?php
			settings_fields( $this->slug );

			foreach( $this->settings as $section => $params ){
				printf( '<div class="tab-content" id="tab-%s" %s>',
					$section,
					$section != $tab ? 'style="display:none;"' : ''
				);

				?>
                <h3><?php echo $params[ 'title' ]; ?></h3>

				<?php
				$func = $section . '_description';
				$this->{$func}();
				?>

                <table class="form-table">
					<?php
					do_settings_fields( $this->slug, $section );
					?>
                </table>
				<?php

				submit_button();

				?>
                </div>
				<?php
			}
			?>
        </form>
        <script type="text/javascript">
			jQuery( 'a.nav-tab' ).click( function( e ){
				e.preventDefault();
				var id = e.target.id.substr( 4 );
				jQuery( 'div.tab-content' ).hide();
				jQuery( 'div#tab-' + id ).show();
				jQuery( 'a.nav-tab-active' ).removeClass( 'nav-tab-active' );
				jQuery( e.target ).addClass( 'nav-tab-active' );
			} );
        </script>
		<?php

	}


	/**
	 * add_setting_section
	 *
	 * If you prefer the use the method approach vs the set class var approach
	 * Use this method to create or update a section of settings
	 *
	 * @param string $slug
	 * @param string $title
	 *
	 * @uses $this->settings ( may be set independently )
	 * @see  $this->add_setting()
	 *
	 * @return void
	 */
	protected function add_setting_section( $slug, $title ) {
		$this->settings[ $slug ][ 'title' ] = $title;
		if( empty( $this->settings[ $slug ][ 'fields' ] ) ){
			$this->settings[ $slug ][ 'fields' ] = [];
		}

	}


	/**
	 * add_setting
	 *
	 * If you prefer to use the method approach vs the set class var approach
	 * Use this method to add a single setting to a section
	 *
	 * @param string $section
	 * @param string $field
	 * @param string $label
	 *
	 * @uses $this->settings ( may be set independently )
	 * @see  $this->add_settings_section()
	 *
	 * @return void
	 */
	protected function add_setting( $section, $field, $label ) {
		$this->settings[ $section ][ 'fields' ][ $field ] = $label;
	}

}
