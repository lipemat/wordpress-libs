<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Box;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Libs\Scripts\ScriptHandles;
use Lipe\Lib\Libs\Scripts\StyleHandles;
use Lipe\Lib\Theme\Class_Names;
use Lipe\Lib\Traits\Singleton;
use Lipe\Lib\Util\Url;

/**
 * Support Tabs in meta boxes.
 *
 * @usage Assign and array of tabs to a box when registering it
 *        via the Lipe\Lib\CMB2\Box::add_tab() method.
 *        Then use the Lipe\Lib\CMB2\Field::tab() method to assign each field to a particular tab.
 *        Every field a box has must be assigned to a tab or none will display.
 */
class Tabs {
	use Singleton;

	public const TAB_FIELD = 'lipe/lib/cmb2/box/tabs/active-tab';

	/**
	 * Current CMB2 instance
	 *
	 * @var \CMB2
	 */
	protected \CMB2 $cmb;

	/**
	 * Do we have tabs?
	 *
	 * @var bool
	 */
	protected bool $has_tabs = false;

	/**
	 * Active Panel
	 *
	 * @var string
	 */
	protected string $active_panel = '';

	/**
	 * List of fields and their output.
	 *
	 * @var array<string, array<string>>
	 */
	protected array $fields_output = [];


	/**
	 * Called via self::init_once() from various entry points
	 *
	 * @return void
	 */
	protected function hook(): void {
		add_action( 'cmb2_before_form', [ $this, 'opening_div' ], 10, 4 );
		add_action( 'cmb2_after_form', [ $this, 'closing_div' ], 20, 0 );

		add_action( 'cmb2_before_form', [ $this, 'render_nav' ], 20, 4 );
		add_action( 'cmb2_after_form', [ $this, 'show_panels' ], 10, 4 );

		add_filter( 'cmb2_wrap_classes', [ $this, 'add_wrap_class' ] );
	}


	/**
	 * Main opening <div> for the tabs.
	 *
	 * @param string     $cmb_id      - The cmb2 box id.
	 * @param int|string $object_id   - The object id.
	 * @param string     $object_type - The object type.
	 * @param \CMB2      $cmb         - The cmb2 instance.
	 *
	 * @return void
	 */
	public function opening_div( string $cmb_id, int|string $object_id, string $object_type, \CMB2 $cmb ): void {
		if ( false === $cmb->prop( 'tabs' ) || [] === $cmb->prop( 'tabs' ) ) {
			return;
		}
		$this->cmb = $cmb;
		$this->has_tabs = true;

		$tab_style = $cmb->prop( 'tab_style' );
		$classes = new Class_Names( [
			'cmb-tabs',
			'clearfix',
			'cmb-tabs-' . $tab_style => null !== $tab_style,
		] );

		Scripts::in()->enqueue_script( ScriptHandles::ADMIN );
		Scripts::in()->enqueue_style( StyleHandles::TABS );

		?>
	<div class="<?= esc_attr( (string) $classes ) ?>">
		<input name="_wp_http_referer" value="<?= esc_url( Url::in()->get_current_url() ) ?>" type="hidden" />
		<?php
	}


	/**
	 * Close the main div wrap.
	 *
	 * @return void
	 */
	public function closing_div(): void {
		if ( ! $this->has_tabs ) {
			return;
		}
		echo '</div>';

		$this->has_tabs = false;
		$this->fields_output = [];
	}


	/**
	 * Render the tabs' navigation.
	 *
	 * @param string     $cmb_id      - The cmb2 box id.
	 * @param int|string $object_id   - The object id.
	 * @param string     $object_type - The object type.
	 * @param \CMB2      $cmb         - The cmb2 instance.
	 *
	 * @return void
	 */
	public function render_nav( string $cmb_id, int|string $object_id, string $object_type, \CMB2 $cmb ): void {
		$tabs = $cmb->prop( 'tabs' );

		if ( false !== $tabs ) {
			echo '<ul class="cmb-tab-nav" data-js="lipe/lib/cmb2/box/tabs">';

			//phpcs:ignore WordPress.Security.NonceVerification -- Using in a URL parameter to set the active tab.
			$active_nav = isset( $_REQUEST[ self::TAB_FIELD ] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST[ self::TAB_FIELD ] ) ) ) : \key( $tabs );

			foreach ( $tabs as $key => $label ) {
				$class = "cmb-tab-$key";
				if ( $key === $active_nav ) {
					$class .= ' cmb-tab-active';
					$this->active_panel = $key;
				}

				printf(
					'<li class="%s" data-panel="%s"><a href="#"><span>%s</span></a></li>',
					esc_attr( $class ),
					esc_attr( $key ),
					esc_html( $label )
				);
			}

			echo '</ul>';
		}
	}


	/**
	 * Add classes to the cmb2-wrap div.
	 *
	 * @param array<string> $classes - Default css classes.
	 *
	 * @return array<string>
	 */
	public function add_wrap_class( array $classes ): array {
		if ( $this->has_tabs ) {
			$classes[] = 'cmb-tabs-panel';
			if ( [] !== $this->fields_output ) {
				$classes[] = 'cmb2-wrap-tabs';
			}
		}

		return \array_unique( $classes );
	}


	/**
	 * Replaces the render_field callback for a field, which as been
	 * assigned to a tab
	 *
	 * @see Field::tab()
	 *
	 * @param array<string, mixed> $field_args - The field args.
	 * @param \CMB2_Field          $field      - The field object.
	 *
	 * @return void
	 */
	public function render_field( array $field_args, \CMB2_Field $field ): void {
		ob_start();
		if ( isset( $field_args['tab_content_cb'] ) && \is_callable( $field_args['tab_content_cb'] ) ) {
			$field_args['tab_content_cb']( $field_args, $field );
		} elseif ( 'group' === $field_args['type'] ) {
			$this->cmb->render_group_callback( $field_args, $field );
		} else {
			$field->render_field_callback();
		}
		$output = (string) \ob_get_clean();
		echo $this->capture_fields( $output, $field_args ); //phpcs:ignore
	}


	/**
	 * Display the tab panels.
	 *
	 * @param string     $cmb_id      - The cmb2 box id.
	 * @param int|string $object_id   - The object id.
	 * @param string     $object_type - The object type.
	 * @param \CMB2      $cmb         - The cmb2 instance.
	 *
	 * @return void
	 */
	public function show_panels( string $cmb_id, int|string $object_id, string $object_type, \CMB2 $cmb ): void {
		if ( ! $this->has_tabs || [] === $this->fields_output ) {
			return;
		}

		echo '<div class="', esc_attr( $cmb->box_classes() ), '">
					<div id="cmb2-metabox-', sanitize_html_class( $cmb_id ), '" class="cmb2-metabox cmb-field-list">';

		foreach ( $this->fields_output as $tab => $fields ) {
			$active_panel = $this->active_panel === $tab ? 'show' : '';
			echo '<div class="' . esc_attr( $active_panel ) . ' cmb-tab-panel cmb2-metabox cmb-tab-panel-' . esc_attr( $tab ) . '">';
			echo implode( '', $fields ); //phpcs:ignore
			echo '</div>';
		}

		echo '</div></div>';
	}


	/**
	 * Capture the fields output.
	 *
	 * @param string               $output     - The field output.
	 * @param array<string, mixed> $field_args - The field args.
	 *
	 * @return string
	 */
	public function capture_fields( string $output, array $field_args ): string {
		if ( ! $this->has_tabs || ! isset( $field_args['tab'] ) ) {
			return $output;
		}

		$tab = (string) $field_args['tab'];
		if ( ! isset( $this->fields_output[ $tab ] ) ) {
			$this->fields_output[ $tab ] = [];
		}
		$this->fields_output[ $tab ][] = $output;
		return '';
	}
}
