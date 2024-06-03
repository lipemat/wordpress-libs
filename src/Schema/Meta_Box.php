<?php

namespace Lipe\Lib\Schema;

/**
 * The base meta box class. To extend this, implement the
 * render() and save() functions.
 *
 * The render() method will be called when the meta box needs to be printed
 * in the post editor.
 *
 * The save() method will be called when a post is being saved. No need to
 * worry about validating if the correct post type has been
 * submitted, nonces, and all that. They're already taken care of.
 *
 * @example    self::register( [%post_type%], %args% );
 *
 * @deprecated Will be removed in version 5. Use `Meta\Meta_Box` instead.
 */
abstract class Meta_Box {

	protected const NONCE_ACTION = 'lipe/lib/schema/meta_box_save_post';
	protected const NONCE_NAME   = 'lipe/lib/schema/meta_box_save_post_nonce';

	/**
	 * Store the registered meta box for later registering with WP.
	 *
	 * @var array<string, array<string, Meta_Box>>
	 */
	protected static array $registry = [];

	/**
	 * The id of the meta box.
	 *
	 * @var string
	 */
	public string $id;

	/**
	 * The title of the meta box.
	 *
	 * @var string
	 */
	public string $title;

	/**
	 * The context of the meta box.
	 *
	 * Determines where the meta box will display in the editor screen.
	 *
	 * @var 'advanced'|'normal'|'side'
	 */
	public string $context;

	/**
	 * The priority of the meta box.
	 *
	 * @var 'core'|'default'|'high'|'low'
	 */
	public string $priority;

	/**
	 * The following parameter is any additional arguments passed as $callback_args
	 * to add_meta_box, if/when applicable.
	 *
	 * We have our own Gutenberg/block-editor properties in this class so use those instead
	 * of this property if you are working with Gutenberg.
	 *
	 * @see Meta_Box::$display_when_gutenberg_active
	 * @see Meta_Box::$gutenberg_compatible
	 *
	 * More: https://wordpress.org/gutenberg/handbook/designers-developers/developers/backwards-compatibility/meta-box/
	 *
	 * @var mixed
	 */
	public $callback_args;

	/**
	 * This flag lets you set whether the meta box works in the block editor or not.
	 * Setting it to true signifies that you’ve confirmed that the meta box
	 * works in the block editor, setting it to false signifies that it does not.
	 *
	 * If set to false, WP will automatically fall back to the classic editor when
	 * this box is loaded.
	 *
	 * @see  Meta_Box::get_args()
	 * @see  Meta_Box::$display_when_gutenberg_active
	 *
	 * @link https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/
	 *
	 * @uses sets the `__block_editor_compatible_meta_box` meta box flag
	 *
	 * @var bool
	 */
	public $gutenberg_compatible = true;

	/**
	 * Set to false if you have converted this meta box fully to Gutenberg and
	 * you don't want the default meta box to display when gutenberg is active.
	 *
	 * When the classic editor is loaded this meta box will load no matter what
	 * this is set to.
	 *
	 * @see  Meta_Box::get_args()
	 * @see  Meta_Box::$gutenberg_compatible
	 *
	 * @link https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/
	 *
	 * @uses sets the `__back_compat_meta_box` meta box flag
	 *
	 * @var bool
	 */
	public $display_when_gutenberg_active = true;

	/**
	 * The post type this meta box will display on.
	 *
	 * @var string
	 */
	public string $post_type;


	/**
	 * Constructs the meta box.
	 *
	 * @see                      https://codex.wordpress.org/Function_Reference/add_meta_box for more info
	 *
	 * @todo                     Remove default arguments in version 5.
	 *
	 * @type string  $title         ( defaults to the id of the metabox built by the class ),
	 * @type string  $context       - 'normal', 'advanced', or 'side' ( defaults to 'advanced' )
	 * @type string  $priority      - 'high', 'core', 'default' or 'low' ( defaults to 'default' )
	 * @type mixed   $callback_args - will be assigned as $this->callback_args to the meta box class and can be
	 *                              retrieved via $this->get_callback_args()
	 *                              }
	 * @phpstan-param array{
	 *      id?: string,
	 *      title?: string,
	 *      context?: 'normal'|'advanced'|'side',
	 *      priority?: 'high'|'core'|'default'|'low',
	 *      callback_args?: mixed
	 *  }|array{-1}  $args
	 *
	 * @param string $post_type     The post type this meta box will display on.
	 * @param array  $args          Optional arguments to pass to the meta box class.
	 *
	 * @phpstan-ignore-next-line -- Keeping default value intact until version 5.
	 */
	final protected function __construct( string $post_type, array $args = [ - 1 ] ) {
		_deprecated_class( __CLASS__, '4.10.0', \Lipe\Lib\Meta\Meta_Box::class );

		if ( [ - 1 ] === $args ) {
			$args = [];
			_doing_it_wrong( __METHOD__, 'You must pass the `$args` to `Meta_Box::__construct()`. An empty array is acceptable.', '4.5.0' );
		}

		$this->post_type = $post_type;

		static::init_once();

		if ( isset( $args['id'] ) ) {
			$this->id = $args['id'];
		} else {
			$this->id = static::build_id( $this->post_type, \get_class( $this ) );
		}

		static::$registry[ $post_type ][ $this->id ] = $this;

		$args = wp_parse_args( $args, [
			'title'         => null,
			'context'       => 'advanced',
			'priority'      => 'default',
			'callback_args' => null,
		] );

		$this->title = $args['title'] ?? $this->id;
		$this->context = $args['context'];
		$this->priority = $args['priority'];
		if ( null !== $args['callback_args'] ) {
			$this->callback_args = $args['callback_args'];
		}

		add_action( 'add_meta_boxes_' . $this->post_type, [
			$this,
			'register_meta_box',
		], 10, 0 );
	}


	/**
	 * Render the meta box contents.
	 *
	 * @param \WP_Post $post - The post being edited.
	 *
	 * @return void
	 */
	abstract public function render( \WP_Post $post ): void;


	/**
	 * Save the meta box field values.
	 *
	 * @param int      $post_id The ID of the post being saved.
	 * @param \WP_Post $post    The post being saved.
	 *
	 * @return void
	 */
	abstract protected function save( int $post_id, \WP_Post $post ): void;


	/**
	 * Register the meta box for its post type
	 *
	 * @action 'add_meta_boxes_' . $post_type
	 * @return void
	 */
	public function register_meta_box(): void {
		add_meta_box( $this->get_id(), $this->get_title(), [
			$this,
			'render',
		], $this->post_type, $this->get_context(), $this->get_priority(), $this->get_callback_args() );
	}


	/**
	 * Return the ID of the meta box
	 *
	 * @return string
	 */
	public function get_id(): string {
		return $this->id;
	}


	/**
	 * Return the translated title of the meta box
	 *
	 * @return string
	 */
	public function get_title(): string {
		return $this->title;
	}


	/**
	 * Return the context in which to display the meta box
	 *
	 * @return 'advanced'|'normal'|'side'
	 */
	public function get_context(): string {
		return $this->context;
	}


	/**
	 * Return the priority in which to display the meta box
	 *
	 * @return 'core'|'default'|'high'|'low'
	 */
	public function get_priority(): string {
		return $this->priority;
	}


	/**
	 * Return arguments to pass to the meta box
	 *
	 * @return array
	 */
	protected function get_callback_args(): array {
		if ( ! isset( $this->callback_args['__block_editor_compatible_meta_box'] ) ) {
			$this->callback_args['__block_editor_compatible_meta_box'] = $this->gutenberg_compatible;
		}

		if ( ! isset( $this->callback_args['__back_compat_meta_box'] ) ) {
			// Notice we use the opposite here.
			$this->callback_args['__back_compat_meta_box'] = ! $this->display_when_gutenberg_active;
		}

		return $this->callback_args;
	}


	/**
	 * Set the arguments to pass to the meta box.
	 *
	 * @param array|null $args - The arguments to pass to the meta box.
	 *
	 * @return void
	 */
	public function set_callback_args( ?array $args ): void {
		$this->callback_args = $args;
	}


	/**
	 * Retrieve an array of key value pairs of the posts meta fields
	 *
	 * @param int          $post_id - The post ID to retrieve the meta for.
	 * @param string|array $fields  - The meta fields to retrieve.
	 *
	 * @return array
	 */
	public function get_values( int $post_id, $fields ): array {
		$meta = [];

		foreach ( (array) $fields as $this_field ) {
			$meta[ $this_field ] = get_post_meta( $post_id, $this_field, true );
		}

		return $meta;
	}


	/**
	 * Actions and filters.
	 *
	 * @return void
	 */
	protected static function hook(): void {
		add_action( 'post_submitbox_misc_actions', [
			__CLASS__,
			'display_nonce',
		] );
		add_action( 'save_post', [
			__CLASS__,
			'save_meta_boxes',
		], 10, 2 );
	}


	/**
	 * Build a unique id for the meta box.
	 *
	 * @param string       $post_type  The post type this meta box will display on.
	 * @param class-string $class_name The name of the meta box class.
	 *
	 * @return string A unique identifier for this meta box.
	 */
	protected static function build_id( string $post_type, string $class_name ): string {
		static $append = 0;
		$id = $post_type . '-' . $class_name;
		$appended = $id . ( $append ? '-' . $append : '' );
		if ( isset( static::$registry[ $post_type ][ $appended ] ) ) {
			++ $append;
		}
		$id .= ( $append ? '-' . $append : '' );

		return $id;
	}


	/**
	 * Make sure this is a save_post where we actually want to update the meta.
	 *
	 * @param int      $post_id - The ID of the post being saved.
	 * @param \WP_Post $post    - The post being saved.
	 *
	 * @return bool
	 */
	protected static function should_meta_boxes_be_saved( int $post_id, \WP_Post $post ): bool {
		// make sure this is a valid submission.
		if ( ! isset( $_POST[ static::NONCE_NAME ] ) || false === wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ static::NONCE_NAME ] ) ), static::NONCE_ACTION ) ) {
			return false;
		}

		// don't do anything on autosave, auto-draft, bulk edit, or quick edit.
		if ( 'auto-draft' === $post->post_status || isset( $_GET['bulk_edit'] ) || false !== wp_is_post_autosave( $post_id ) || wp_doing_ajax() || false !== wp_is_post_revision( $post_id ) ) {
			return false;
		}

		return true;
	}


	/**
	 * Special init handler for this class to prevent
	 * things from being registered twice.
	 *
	 * We don't use Singleton as it could accidentally cause issue
	 * if a user calls `init`.
	 *
	 * @static
	 *
	 * @return void
	 */
	protected static function init_once(): void {
		static $is_init = false;
		if ( ! $is_init ) {
			static::hook();
			$is_init = true;
		}
	}


	/**
	 * Put our nonce in the Publishing box, so we can share it
	 * across all meta boxes.
	 *
	 * @return void
	 */
	public static function display_nonce(): void {
		if ( ! empty( static::$registry[ (string) get_post_type() ] ) ) {
			wp_nonce_field( static::NONCE_ACTION, static::NONCE_NAME );
		}
	}


	/**
	 * Save the meta boxes for this post type
	 *
	 * @param int      $post_id The ID of the post being saved.
	 * @param \WP_Post $post    The post being saved.
	 *
	 * @return void
	 */
	public static function save_meta_boxes( int $post_id, \WP_Post $post ): void {
		if ( ! static::should_meta_boxes_be_saved( $post_id, $post ) ) {
			return;
		}
		if ( empty( static::$registry[ $post->post_type ] ) ) {
			return;
		}
		remove_action( 'save_post', [ __CLASS__, 'save_meta_boxes' ] );

		foreach ( static::$registry[ $post->post_type ] as $meta_box ) {
			$meta_box->save( $post_id, $post );
		}
	}


	/**
	 * Get the metabox with the given ID.
	 *
	 * @param string $post_type - The post type this meta box will display on.
	 * @param string $id        - The ID of the meta box to get.
	 *
	 * @return Meta_Box|null
	 */
	public static function get_meta_box_by_id( string $post_type, string $id ): ?Meta_Box {
		return static::$registry[ $post_type ][ $id ] ?? null;
	}


	/**
	 * Whether a meta box with the given class has been registered for the given post type.
	 *
	 * @param string       $post_type  - The post type this meta box will display on.
	 * @param class-string $class_name - The name of the meta box class.
	 *
	 * @return bool
	 */
	public static function has_meta_box( string $post_type, string $class_name ): bool {
		return null !== static::get_meta_box( $post_type, $class_name );
	}


	/**
	 * Get a metabox of the given class for the post type.
	 *
	 * If more than one metabox of the same class registered
	 * with the same post type, the first to register will be returned.
	 *
	 * @param string       $post_type  - The post type this meta box will display on.
	 * @param class-string $class_name - The name of the meta box class.
	 *
	 * @return Meta_Box|null
	 */
	public static function get_meta_box( string $post_type, string $class_name ): ?Meta_Box {
		if ( ! isset( static::$registry[ $post_type ] ) ) {
			return null;
		}
		foreach ( static::$registry[ $post_type ] as $meta_box ) {
			if ( \get_class( $meta_box ) === $class_name ) {
				return $meta_box;
			}
		}

		return null;
	}


	/**
	 * Registers a meta box class.
	 *
	 * @see   https://codex.wordpress.org/Function_Reference/add_meta_box for more info
	 *
	 * @param string|array|null $post_type - null will add it to all post types.
	 * @param array             $args      {.
	 *
	 * @type string             $title     ( defaults to the id of the metabox built by the class ),
	 * @type string             $context   - 'normal', 'advanced', or 'side' ( defaults to 'advanced' )
	 * @type string             $priority  - 'high', 'core', 'default' or 'low' ( defaults to 'default' )
	 * @type [] $callback_args - will be assigned as $this->callback_args
	 *                                     can be retrieved via $this->get_callback_args().
	 *                                     }
	 * @return static|static[]
	 */
	public static function register( $post_type = null, array $args = [] ) {
		$class = [];
		if ( null === $post_type ) {
			foreach ( get_post_types() as $_post_type ) {
				$class[] = new static( $_post_type, $args );
			}
		} elseif ( \is_array( $post_type ) ) {
			foreach ( $post_type as $_post_type ) {
				$class[] = new static( $_post_type, $args );
			}
		} else {
			$class = new static( $post_type, $args );
		}

		return $class;
	}
}
