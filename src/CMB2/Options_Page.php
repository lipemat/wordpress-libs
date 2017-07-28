<?php

namespace Lipe\Lib\CMB2;

/**
 * Options_Page
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Lib\CMB2
 */
class Options_Page extends Box {

	/**
	 * This parameter is for options-page metaboxes only and defaults to 'admin_menu',
	 * to register your options-page at the network level:
	 *
	 * @example 'network_admin_menu'
	 *
	 * @var string
	 */
	public $admin_menu_hook = 'admin_menu';

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_menu_page()/add_submenu_page()
	 * to define the capability required to view the options page.
	 *
	 * @example 'edit_posts'
	 *
	 * @var string
	 */
	public $capability = 'manage_options';

	/**
	 * This parameter is for options-page metaboxes only
	 * and allows overriding the options page form output.
	 *
	 * @example 'my_callback_function_to_display_output'
	 *
	 * @var callable
	 */
	public $display_cb = 'cmb2_metabox_form';

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_menu_page() to define the menu icon.
	 * Only applicable if parent_slug is left empty.
	 *
	 * @example 'dashicons-chart-pie'
	 *
	 * @var string
	 */
	public $icon_url;

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_menu_page()/add_submenu_page() to define the menu title.
	 *
	 * @example 'Site Options
	 *
	 * @var string
	 */
	public $menu_title;

	/**
	 * This parameter is for options-page metaboxes only,
	 * Specify if network settings or not
	 *
	 * @var bool
	 */
	public $network = false;

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_submenu_page() to define the parent-menu item slug.
	 *
	 * @exampl 'tools.php'
	 * @var string
	 */
	public $parent_slug;

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_menu_page() to define the menu position.
	 * Only applicable if parent_slug is left empty.
	 *
	 * @example 1
	 *
	 * @var int
	 */
	public $position;

	/**
	 * This parameter is for options-page metaboxes only and
	 * defines the text for the options page save button. defaults to 'Save'.
	 *
	 * @example 'Save Settings'
	 *
	 * @var string
	 */
	public $save_button;


	/**
	 * Options Page constructor.
	 *
	 * @param  string $id
	 * @param  string $title
	 */
	public function __construct( $id, $title ) {
		$this->show_on = [
			'key'   => 'options-page',
			'value' => [ $this->id ],
		];
		parent::__construct( $id, [ 'options-page' ], $title );

		add_action( $this->admin_menu_hook, [ $this, 'add_options_page' ] );
	}


	public function add_options_page() {
		$this->menu_title = empty( $this->menu_title ) ? $this->title : $this->menu_title;

		if( !isset( $this->parent_slug ) ){
			$options_page = add_menu_page( $this->title, $this->menu_title, $this->capability, $this->id, [
				$this,
				'admin_page_display',
			], $this->icon_url, $this->position );
		} else {
			$options_page = add_submenu_page( $this->parent_slug, $this->title, $this->menu_title, $this->capability, $this->id, [
				$this,
				'admin_page_display',
			] );
		}

		add_action( "admin_print_styles-{$options_page}", [ 'CMB2_hookup', 'enqueue_cmb_css' ] );
		add_action( "cmb2_save_options-page_fields_{$this->id}", [ $this, 'notices' ], 10, 2 );

	}


	public function notices( $object_id, $updated ) {
		if( $object_id !== $this->id || !$updated ){
			return;
		}
		add_settings_error( $this->id . '-notices', '', __( 'Settings updated.', 'myprefix' ), 'updated' );
		settings_errors( $this->id . '-notices' );
	}


	public function admin_page_display() {
		?>
        <div class="wrap cmb2-options-page <?php echo $this->id; ?>">
            <h2><?= esc_html( get_admin_page_title() ); ?></h2>
			<?php call_user_func_array( $this->display_cb, [ $this->id, $this->id, $this->get_args() ] ); ?>
        </div>
		<?php
	}
}