<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

/**
 * Register a standard post meta box using WordPress API.
 *
 * @author Mat Lipe
 * @since  4.10.0
 */
class Meta_Box {
	public const CONTEXT_ADVANCED = 'advanced';
	public const CONTEXT_NORMAL   = 'normal';
	public const CONTEXT_SIDE     = 'side';

	public const PRIORITY_CORE    = 'core';
	public const PRIORITY_DEFAULT = 'default';
	public const PRIORITY_HIGH    = 'high';
	public const PRIORITY_LOW     = 'low';


	/**
	 * Create the instance and call the hook method.
	 *
	 * @param Box $box - The box to register.
	 */
	public function __construct(
		protected Box $box,
	) {
		$this->hook();
	}


	/**
	 * Actions to hook up the meta box.
	 *
	 * @return void
	 */
	protected function hook(): void {
		if ( ! is_admin() ) {
			return;
		}
		foreach ( $this->box->get_post_types() as $post_type ) {
			add_action( 'add_meta_boxes_' . $post_type, [ $this, 'register' ] );
			add_action( 'save_post_' . $post_type, [ $this, 'save' ], 10, 2 );
		}

		add_action( 'post_submitbox_misc_actions', [ $this, 'render_nonce' ] );
	}


	/**
	 * Render the nonce field to be used for validation during saving.
	 *
	 * @interal
	 *
	 * @param \WP_Post $post - The post being edited.
	 *
	 * @return void
	 */
	public function render_nonce( \WP_Post $post ): void {
		if ( ! \in_array( $post->post_type, $this->box->get_post_types(), true ) ) {
			return;
		}
		wp_nonce_field( $this->box->get_id(), $this->box->get_id() );
	}


	/**
	 * Save the meta box data.
	 *
	 * @interal
	 *
	 * @param int      $post_id - The ID of the post being saved.
	 * @param \WP_Post $post    - The post object being saved.
	 *
	 * @return void
	 */
	public function save( int $post_id, \WP_Post $post ): void {
		$nonce = $this->box->get_id();
		if ( ! isset( $_POST[ $nonce ] ) || false === wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $nonce ] ) ), $nonce ) ) {
			return;
		}
		if ( ! \in_array( $post->post_type, $this->box->get_post_types(), true ) ) {
			return;
		}

		// Don't do anything on an autosave, auto-draft, bulk edit or quick edit.
		if ( 'auto-draft' === $post->post_status || isset( $_GET['bulk_edit'] ) || false !== wp_is_post_autosave( $post_id ) || wp_doing_ajax() || false !== wp_is_post_revision( $post_id ) ) {
			return;
		}

		$this->box->save( $post );
	}


	/**
	 * Register the meta box with the WP meta box API.
	 *
	 * @interal
	 *
	 * @param \WP_Post $post - The post being edited.
	 *
	 * @return void
	 */
	public function register( \WP_Post $post ): void {
		add_meta_box(
			$this->box->get_id(),
			$this->box->get_title(),
			[ $this->box, 'render' ],
			$post->post_type,
			$this->box->get_context(),
			$this->box->get_priority(),
			$this->get_callback_args()
		);
	}


	/**
	 * Get the arguments to pass to the meta box callback.
	 *
	 * @link https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/
	 *
	 * @return array{__block_editor_compatible_meta_box: bool, __back_compat_meta_box: bool}
	 */
	protected function get_callback_args(): array {
		return [
			'__block_editor_compatible_meta_box' => true,
			'__back_compat_meta_box'             => $this->box->is_classic_editor_fallback(),
		];
	}
}
