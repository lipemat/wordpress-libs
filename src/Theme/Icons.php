<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

/**
 * Full list of @wordpress/icons available on the PHP side.
 *
 * @reauires WP 7.0+
 *
 * @author   Mat Lipe
 * @since    6.0.0
 */
enum Icons: string {
	case ADD_CARD                       = 'core/add-card';
	case ADD_SUBMENU                    = 'core/add-submenu';
	case ADD_TEMPLATE                   = 'core/add-template';
	case ALIGN_CENTER                   = 'core/align-center';
	case ALIGN_JUSTIFY                  = 'core/align-justify';
	case ALIGN_LEFT                     = 'core/align-left';
	case ALIGN_NONE                     = 'core/align-none';
	case ALIGN_RIGHT                    = 'core/align-right';
	case ARCHIVE                        = 'core/archive';
	case ARROW_DOWN                     = 'core/arrow-down';
	case ARROW_DOWN_LEFT                = 'core/arrow-down-left';
	case ARROW_DOWN_RIGHT               = 'core/arrow-down-right';
	case ARROW_LEFT                     = 'core/arrow-left';
	case ARROW_RIGHT                    = 'core/arrow-right';
	case ARROW_UP                       = 'core/arrow-up';
	case ARROW_UP_LEFT                  = 'core/arrow-up-left';
	case ARROW_UP_RIGHT                 = 'core/arrow-up-right';
	case ASPECT_RATIO                   = 'core/aspect-ratio';
	case AT_SYMBOL                      = 'core/at-symbol';
	case AUDIO                          = 'core/audio';
	case BACKGROUND                     = 'core/background';
	case BACKUP                         = 'core/backup';
	case BELL                           = 'core/bell';
	case BELL_UNREAD                    = 'core/bell-unread';
	case BLOCK_DEFAULT                  = 'core/block-default';
	case BLOCK_META                     = 'core/block-meta';
	case BLOCK_TABLE                    = 'core/block-table';
	case BORDER                         = 'core/border';
	case BOX                            = 'core/box';
	case BREADCRUMBS                    = 'core/breadcrumbs';
	case BRUSH                          = 'core/brush';
	case BUG                            = 'core/bug';
	case BUTTON                         = 'core/button';
	case BUTTONS                        = 'core/buttons';
	case CALENDAR                       = 'core/calendar';
	case CANCEL_CIRCLE_FILLED           = 'core/cancel-circle-filled';
	case CAPTION                        = 'core/caption';
	case CAPTURE_PHOTO                  = 'core/capture-photo';
	case CAPTURE_VIDEO                  = 'core/capture-video';
	case CART                           = 'core/cart';
	case CATEGORY                       = 'core/category';
	case CAUTION                        = 'core/caution';
	case CAUTION_FILLED                 = 'core/caution-filled';
	case CHART_BAR                      = 'core/chart-bar';
	case CHECK                          = 'core/check';
	case CHEVRON_DOWN                   = 'core/chevron-down';
	case CHEVRON_DOWN_SMALL             = 'core/chevron-down-small';
	case CHEVRON_LEFT                   = 'core/chevron-left';
	case CHEVRON_LEFT_SMALL             = 'core/chevron-left-small';
	case CHEVRON_RIGHT                  = 'core/chevron-right';
	case CHEVRON_RIGHT_SMALL            = 'core/chevron-right-small';
	case CHEVRON_UP                     = 'core/chevron-up';
	case CHEVRON_UP_DOWN                = 'core/chevron-up-down';
	case CHEVRON_UP_SMALL               = 'core/chevron-up-small';
	case CLASSIC                        = 'core/classic';
	case CLOSE                          = 'core/close';
	case CLOSE_SMALL                    = 'core/close-small';
	case CLOUD                          = 'core/cloud';
	case CLOUD_DOWNLOAD                 = 'core/cloud-download';
	case CLOUD_UPLOAD                   = 'core/cloud-upload';
	case CODE                           = 'core/code';
	case COG                            = 'core/cog';
	case COLOR                          = 'core/color';
	case COLUMN                         = 'core/column';
	case COLUMNS                        = 'core/columns';
	case COMMENT                        = 'core/comment';
	case COMMENT_AUTHOR_AVATAR          = 'core/comment-author-avatar';
	case COMMENT_AUTHOR_NAME            = 'core/comment-author-name';
	case COMMENT_CONTENT                = 'core/comment-content';
	case COMMENT_EDIT_LINK              = 'core/comment-edit-link';
	case COMMENT_REPLY_LINK             = 'core/comment-reply-link';
	case CONNECTION                     = 'core/connection';
	case COPY                           = 'core/copy';
	case COPY_SMALL                     = 'core/copy-small';
	case CORNER_ALL                     = 'core/corner-all';
	case CORNER_BOTTOM_LEFT             = 'core/corner-bottom-left';
	case CORNER_BOTTOM_RIGHT            = 'core/corner-bottom-right';
	case CORNER_TOP_LEFT                = 'core/corner-top-left';
	case CORNER_TOP_RIGHT               = 'core/corner-top-right';
	case COVER                          = 'core/cover';
	case CREATE                         = 'core/create';
	case CROP                           = 'core/crop';
	case CURRENCY_DOLLAR                = 'core/currency-dollar';
	case CURRENCY_EURO                  = 'core/currency-euro';
	case CURRENCY_POUND                 = 'core/currency-pound';
	case CUSTOM_LINK                    = 'core/custom-link';
	case CUSTOM_POST_TYPE               = 'core/custom-post-type';
	case DASHBOARD                      = 'core/dashboard';
	case DESKTOP                        = 'core/desktop';
	case DETAILS                        = 'core/details';
	case DOWNLOAD                       = 'core/download';
	case DRAFTS                         = 'core/drafts';
	case DRAG_HANDLE                    = 'core/drag-handle';
	case DRAWER_LEFT                    = 'core/drawer-left';
	case DRAWER_RIGHT                   = 'core/drawer-right';
	case ENVELOPE                       = 'core/envelope';
	case ERROR                          = 'core/error';
	case EXTERNAL                       = 'core/external';
	case FILE                           = 'core/file';
	case FILTER                         = 'core/filter';
	case FLIP_HORIZONTAL                = 'core/flip-horizontal';
	case FLIP_VERTICAL                  = 'core/flip-vertical';
	case FOOTER                         = 'core/footer';
	case FORMAT_BOLD                    = 'core/format-bold';
	case FORMAT_CAPITALIZE              = 'core/format-capitalize';
	case FORMAT_INDENT                  = 'core/format-indent';
	case FORMAT_INDENT_RTL              = 'core/format-indent-rtl';
	case FORMAT_ITALIC                  = 'core/format-italic';
	case FORMAT_LIST_BULLETS            = 'core/format-list-bullets';
	case FORMAT_LIST_BULLETS_RTL        = 'core/format-list-bullets-rtl';
	case FORMAT_LIST_NUMBERED           = 'core/format-list-numbered';
	case FORMAT_LIST_NUMBERED_RTL       = 'core/format-list-numbered-rtl';
	case FORMAT_LOWERCASE               = 'core/format-lowercase';
	case FORMAT_LTR                     = 'core/format-ltr';
	case FORMAT_OUTDENT                 = 'core/format-outdent';
	case FORMAT_OUTDENT_RTL             = 'core/format-outdent-rtl';
	case FORMAT_RTL                     = 'core/format-rtl';
	case FORMAT_STRIKETHROUGH           = 'core/format-strikethrough';
	case FORMAT_UNDERLINE               = 'core/format-underline';
	case FORMAT_UPPERCASE               = 'core/format-uppercase';
	case FULLSCREEN                     = 'core/fullscreen';
	case FUNNEL                         = 'core/funnel';
	case GALLERY                        = 'core/gallery';
	case GIFT                           = 'core/gift';
	case GLOBE                          = 'core/globe';
	case GRID                           = 'core/grid';
	case GROUP                          = 'core/group';
	case HANDLE                         = 'core/handle';
	case HEADER                         = 'core/header';
	case HEADING                        = 'core/heading';
	case HEADING_LEVEL_1                = 'core/heading-level-1';
	case HEADING_LEVEL_2                = 'core/heading-level-2';
	case HEADING_LEVEL_3                = 'core/heading-level-3';
	case HEADING_LEVEL_4                = 'core/heading-level-4';
	case HEADING_LEVEL_5                = 'core/heading-level-5';
	case HEADING_LEVEL_6                = 'core/heading-level-6';
	case HELP                           = 'core/help';
	case HELP_FILLED                    = 'core/help-filled';
	case HOME                           = 'core/home';
	case HOME_BUTTON                    = 'core/home-button';
	case HTML                           = 'core/html';
	case IMAGE                          = 'core/image';
	case INBOX                          = 'core/inbox';
	case INFO                           = 'core/info';
	case INSERT_AFTER                   = 'core/insert-after';
	case INSERT_BEFORE                  = 'core/insert-before';
	case INSTITUTION                    = 'core/institution';
	case JUSTIFY_BOTTOM                 = 'core/justify-bottom';
	case JUSTIFY_CENTER                 = 'core/justify-center';
	case JUSTIFY_CENTER_VERTICAL        = 'core/justify-center-vertical';
	case JUSTIFY_LEFT                   = 'core/justify-left';
	case JUSTIFY_RIGHT                  = 'core/justify-right';
	case JUSTIFY_SPACE_BETWEEN          = 'core/justify-space-between';
	case JUSTIFY_SPACE_BETWEEN_VERTICAL = 'core/justify-space-between-vertical';
	case JUSTIFY_STRETCH                = 'core/justify-stretch';
	case JUSTIFY_STRETCH_VERTICAL       = 'core/justify-stretch-vertical';
	case JUSTIFY_TOP                    = 'core/justify-top';
	case KEY                            = 'core/key';
	case KEYBOARD                       = 'core/keyboard';
	case KEYBOARD_CLOSE                 = 'core/keyboard-close';
	case KEYBOARD_RETURN                = 'core/keyboard-return';
	case LANGUAGE                       = 'core/language';
	case LAYOUT                         = 'core/layout';
	case LEVEL_UP                       = 'core/level-up';
	case LIFESAVER                      = 'core/lifesaver';
	case LINE_DASHED                    = 'core/line-dashed';
	case LINE_DOTTED                    = 'core/line-dotted';
	case LINE_SOLID                     = 'core/line-solid';
	case LINK                           = 'core/link';
	case LINK_OFF                       = 'core/link-off';
	case LIST                           = 'core/list';
	case LIST_ITEM                      = 'core/list-item';
	case LIST_VIEW                      = 'core/list-view';
	case LOCK                           = 'core/lock';
	case LOCK_OUTLINE                   = 'core/lock-outline';
	case LOCK_SMALL                     = 'core/lock-small';
	case LOGIN                          = 'core/login';
	case LOOP                           = 'core/loop';
	case MAP_MARKER                     = 'core/map-marker';
	case MATH                           = 'core/math';
	case MEDIA                          = 'core/media';
	case MEDIA_AND_TEXT                 = 'core/media-and-text';
	case MEGAPHONE                      = 'core/megaphone';
	case MENU                           = 'core/menu';
	case MOBILE                         = 'core/mobile';
	case MORE                           = 'core/more';
	case MORE_HORIZONTAL                = 'core/more-horizontal';
	case MORE_VERTICAL                  = 'core/more-vertical';
	case MOVE_TO                        = 'core/move-to';
	case NAVIGATION                     = 'core/navigation';
	case NEXT                           = 'core/next';
	case NOT_ALLOWED                    = 'core/not-allowed';
	case NOT_FOUND                      = 'core/not-found';
	case OFFLINE                        = 'core/offline';
	case OVERLAY_TEXT                   = 'core/overlay-text';
	case PAGE                           = 'core/page';
	case PAGE_BREAK                     = 'core/page-break';
	case PAGES                          = 'core/pages';
	case PARAGRAPH                      = 'core/paragraph';
	case PAYMENT                        = 'core/payment';
	case PENCIL                         = 'core/pencil';
	case PENDING                        = 'core/pending';
	case PEOPLE                         = 'core/people';
	case PERCENT                        = 'core/percent';
	case PIN                            = 'core/pin';
	case PIN_SMALL                      = 'core/pin-small';
	case PLUGINS                        = 'core/plugins';
	case PLUS                           = 'core/plus';
	case PLUS_CIRCLE                    = 'core/plus-circle';
	case PLUS_CIRCLE_FILLED             = 'core/plus-circle-filled';
	case POSITION_CENTER                = 'core/position-center';
	case POSITION_LEFT                  = 'core/position-left';
	case POSITION_RIGHT                 = 'core/position-right';
	case POST                           = 'core/post';
	case POST_AUTHOR                    = 'core/post-author';
	case POST_CATEGORIES                = 'core/post-categories';
	case POST_COMMENTS                  = 'core/post-comments';
	case POST_COMMENTS_COUNT            = 'core/post-comments-count';
	case POST_COMMENTS_FORM             = 'core/post-comments-form';
	case POST_CONTENT                   = 'core/post-content';
	case POST_DATE                      = 'core/post-date';
	case POST_EXCERPT                   = 'core/post-excerpt';
	case POST_FEATURED_IMAGE            = 'core/post-featured-image';
	case POST_LIST                      = 'core/post-list';
	case POST_TERMS                     = 'core/post-terms';
	case PREFORMATTED                   = 'core/preformatted';
	case PREVIOUS                       = 'core/previous';
	case PUBLISHED                      = 'core/published';
	case PULL_LEFT                      = 'core/pull-left';
	case PULL_RIGHT                     = 'core/pull-right';
	case PULLQUOTE                      = 'core/pullquote';
	case QUERY_PAGINATION               = 'core/query-pagination';
	case QUERY_PAGINATION_NEXT          = 'core/query-pagination-next';
	case QUERY_PAGINATION_NUMBERS       = 'core/query-pagination-numbers';
	case QUERY_PAGINATION_PREVIOUS      = 'core/query-pagination-previous';
	case QUOTE                          = 'core/quote';
	case RECEIPT                        = 'core/receipt';
	case REDO                           = 'core/redo';
	case REMOVE_BUG                     = 'core/remove-bug';
	case REMOVE_SUBMENU                 = 'core/remove-submenu';
	case REPLACE                        = 'core/replace';
	case RESET                          = 'core/reset';
	case RESIZE_CORNER_N_E              = 'core/resize-corner-n-e';
	case REUSABLE_BLOCK                 = 'core/reusable-block';
	case ROTATE_LEFT                    = 'core/rotate-left';
	case ROTATE_RIGHT                   = 'core/rotate-right';
	case ROW                            = 'core/row';
	case RSS                            = 'core/rss';
	case SCHEDULED                      = 'core/scheduled';
	case SEARCH                         = 'core/search';
	case SEEN                           = 'core/seen';
	case SEND                           = 'core/send';
	case SEPARATOR                      = 'core/separator';
	case SETTINGS                       = 'core/settings';
	case SHADOW                         = 'core/shadow';
	case SHARE                          = 'core/share';
	case SHIELD                         = 'core/shield';
	case SHIPPING                       = 'core/shipping';
	case SHORTCODE                      = 'core/shortcode';
	case SHUFFLE                        = 'core/shuffle';
	case SIDEBAR                        = 'core/sidebar';
	case SIDES_ALL                      = 'core/sides-all';
	case SIDES_AXIAL                    = 'core/sides-axial';
	case SIDES_BOTTOM                   = 'core/sides-bottom';
	case SIDES_HORIZONTAL               = 'core/sides-horizontal';
	case SIDES_LEFT                     = 'core/sides-left';
	case SIDES_RIGHT                    = 'core/sides-right';
	case SIDES_TOP                      = 'core/sides-top';
	case SIDES_VERTICAL                 = 'core/sides-vertical';
	case SITE_LOGO                      = 'core/site-logo';
	case SQUARE                         = 'core/square';
	case STACK                          = 'core/stack';
	case STAR_EMPTY                     = 'core/star-empty';
	case STAR_FILLED                    = 'core/star-filled';
	case STAR_HALF                      = 'core/star-half';
	case STORE                          = 'core/store';
	case STRETCH_FULL_WIDTH             = 'core/stretch-full-width';
	case STRETCH_WIDE                   = 'core/stretch-wide';
	case STYLES                         = 'core/styles';
	case SUBSCRIPT                      = 'core/subscript';
	case SUPERSCRIPT                    = 'core/superscript';
	case SWATCH                         = 'core/swatch';
	case SYMBOL                         = 'core/symbol';
	case SYMBOL_FILLED                  = 'core/symbol-filled';
	case TABLE                          = 'core/table';
	case TABLE_COLUMN_AFTER             = 'core/table-column-after';
	case TABLE_COLUMN_BEFORE            = 'core/table-column-before';
	case TABLE_COLUMN_DELETE            = 'core/table-column-delete';
	case TABLE_OF_CONTENTS              = 'core/table-of-contents';
	case TABLE_ROW_AFTER                = 'core/table-row-after';
	case TABLE_ROW_BEFORE               = 'core/table-row-before';
	case TABLE_ROW_DELETE               = 'core/table-row-delete';
	case TABLET                         = 'core/tablet';
	case TAG                            = 'core/tag';
	case TERM_COUNT                     = 'core/term-count';
	case TERM_DESCRIPTION               = 'core/term-description';
	case TERM_NAME                      = 'core/term-name';
	case TEXT_COLOR                     = 'core/text-color';
	case TEXT_HORIZONTAL                = 'core/text-horizontal';
	case TEXT_VERTICAL                  = 'core/text-vertical';
	case THUMBS_DOWN                    = 'core/thumbs-down';
	case THUMBS_UP                      = 'core/thumbs-up';
	case TIME_TO_READ                   = 'core/time-to-read';
	case TIP                            = 'core/tip';
	case TITLE                          = 'core/title';
	case TOOL                           = 'core/tool';
	case TRASH                          = 'core/trash';
	case TRENDING_DOWN                  = 'core/trending-down';
	case TRENDING_UP                    = 'core/trending-up';
	case TYPOGRAPHY                     = 'core/typography';
	case UNDO                           = 'core/undo';
	case UNGROUP                        = 'core/ungroup';
	case UNLOCK                         = 'core/unlock';
	case UNSEEN                         = 'core/unseen';
	case UPDATE                         = 'core/update';
	case UPLOAD                         = 'core/upload';
	case VERSE                          = 'core/verse';
	case VIDEO                          = 'core/video';
	case WIDGET                         = 'core/widget';
	case WORD_COUNT                     = 'core/word-count';
	case WORDPRESS                      = 'core/wordpress';


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
