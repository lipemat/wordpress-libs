<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

/**
 * Full list of @wordpress/icons available on the PHP side.
 *
 * @link     https://wordpress.github.io/gutenberg/?path=/story/icons-icon--library
 *
 * @reauires WP 7.0+
 *
 * @author   Mat Lipe
 * @since    6.0.0
 */
enum Icons: string {
	case ARROW_DOWN          = 'core/arrow-down';
	case ARROW_DOWN_LEFT     = 'core/arrow-down-left';
	case ARROW_DOWN_RIGHT    = 'core/arrow-down-right';
	case ARROW_LEFT          = 'core/arrow-left';
	case ARROW_RIGHT         = 'core/arrow-right';
	case ARROW_UP            = 'core/arrow-up';
	case ARROW_UP_LEFT       = 'core/arrow-up-left';
	case ARROW_UP_RIGHT      = 'core/arrow-up-right';
	case AT_SYMBOL           = 'core/at-symbol';
	case AUDIO               = 'core/audio';
	case BELL                = 'core/bell';
	case BLOCK_DEFAULT       = 'core/block-default';
	case BLOCK_META          = 'core/block-meta';
	case BLOCK_TABLE         = 'core/block-table';
	case CALENDAR            = 'core/calendar';
	case CAPTURE_PHOTO       = 'core/capture-photo';
	case CAPTURE_VIDEO       = 'core/capture-video';
	case CART                = 'core/cart';
	case CATEGORY            = 'core/category';
	case CAUTION             = 'core/caution';
	case CHART_BAR           = 'core/chart-bar';
	case CHECK               = 'core/check';
	case CHEVRON_DOWN        = 'core/chevron-down';
	case CHEVRON_DOWN_SMALL  = 'core/chevron-down-small';
	case CHEVRON_LEFT        = 'core/chevron-left';
	case CHEVRON_LEFT_SMALL  = 'core/chevron-left-small';
	case CHEVRON_RIGHT       = 'core/chevron-right';
	case CHEVRON_RIGHT_SMALL = 'core/chevron-right-small';
	case CHEVRON_UP          = 'core/chevron-up';
	case CHEVRON_UP_DOWN     = 'core/chevron-up-down';
	case CHEVRON_UP_SMALL    = 'core/chevron-up-small';
	case COMMENT             = 'core/comment';
	case COVER               = 'core/cover';
	case CREATE              = 'core/create';
	case DESKTOP             = 'core/desktop';
	case DOWNLOAD            = 'core/download';
	case DRAWER_LEFT         = 'core/drawer-left';
	case DRAWER_RIGHT        = 'core/drawer-right';
	case ENVELOPE            = 'core/envelope';
	case ERROR               = 'core/error';
	case EXTERNAL            = 'core/external';
	case FILE                = 'core/file';
	case GALLERY             = 'core/gallery';
	case GROUP               = 'core/group';
	case HEADING             = 'core/heading';
	case HELP                = 'core/help';
	case HOME                = 'core/home';
	case IMAGE               = 'core/image';
	case INFO                = 'core/info';
	case KEY                 = 'core/key';
	case LANGUAGE            = 'core/language';
	case MAP_MARKER          = 'core/map-marker';
	case MENU                = 'core/menu';
	case MOBILE              = 'core/mobile';
	case MORE_HORIZONTAL     = 'core/more-horizontal';
	case MORE_VERTICAL       = 'core/more-vertical';
	case NEXT                = 'core/next';
	case PARAGRAPH           = 'core/paragraph';
	case PAYMENT             = 'core/payment';
	case PENCIL              = 'core/pencil';
	case PEOPLE              = 'core/people';
	case PLUS                = 'core/plus';
	case PLUS_CIRCLE         = 'core/plus-circle';
	case PREVIOUS            = 'core/previous';
	case PUBLISHED           = 'core/published';
	case QUOTE               = 'core/quote';
	case RECEIPT             = 'core/receipt';
	case RSS                 = 'core/rss';
	case SCHEDULED           = 'core/scheduled';
	case SEARCH              = 'core/search';
	case SETTINGS            = 'core/settings';
	case SHADOW              = 'core/shadow';
	case SHARE               = 'core/share';
	case SHIELD              = 'core/shield';
	case SHUFFLE             = 'core/shuffle';
	case STAR_EMPTY          = 'core/star-empty';
	case STAR_FILLED         = 'core/star-filled';
	case STAR_HALF           = 'core/star-half';
	case STORE               = 'core/store';
	case STYLES              = 'core/styles';
	case SYMBOL              = 'core/symbol';
	case SYMBOL_FILLED       = 'core/symbol-filled';
	case TABLE               = 'core/table';
	case TABLET              = 'core/tablet';
	case TAG                 = 'core/tag';
	case TIP                 = 'core/tip';
	case UPLOAD              = 'core/upload';
	case VERSE               = 'core/verse';


	/**
	 * Generate an HTML icon tag for the icon.
	 *
	 * @param string|\BackedEnum $class_name - Optional custom CSS class to add to the icon.
	 *
	 * @return string
	 */
	public function icon( string|\BackedEnum $class_name = '' ): string {
		$config = $this->get_icon_config();
		if ( null === $config ) {
			return '';
		}

		$classes = new Class_Names( [
			'wp-core-icon',
			'icon-' . \str_replace( '/', '-', $this->value ),
			$class_name,
		] );
		$svg = \str_replace( [ "\n", "\t" ], '', $config['content'] );

		return '<i class="' . $classes . '">' . $svg . '</i>';
	}


	/**
	 * Get the URL to the SVG file for the icon.
	 *
	 * @return string
	 */
	public function svg_url(): string {
		$config = $this->get_icon_config();
		if ( null === $config ) {
			return '';
		}

		return site_url( \str_replace( wp_normalize_path( ABSPATH ), '', wp_normalize_path( $config['path'] ) ) );
	}


	/**
	 * Get the registered icon data in a way which handles WP versions
	 * and missing icons gracefully.
	 *
	 * @return ?array{content: string, path: string}
	 */
	protected function get_icon_config(): ?array {
		if ( ! \class_exists( \WP_Icons_Registry::class ) ) {
			_doing_it_wrong( __METHOD__, esc_html( 'WP 7.0+ is required to use Icons.' ), '6.0.0' );
			return null;
		}

		$svg = \WP_Icons_Registry::get_instance()->get_registered_icon( $this->value );
		if ( null === $svg ) {
			_doing_it_wrong( __METHOD__, esc_html( "Icon {$this->value} not found." ), '6.0.0' );
		}
		return [
			'content' => $svg['content'] ?? '',
			'path'    => $svg['filePath'] ?? '',
		];
	}
}
