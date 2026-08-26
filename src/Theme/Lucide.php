<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

/**
 * Lucide icon enum and registration helper.
 *
 * - May be used directly to render icons in templates.
 * - Call `Lucide::register()` to register the Lucide icon collection with WordPress for use in block editor contexts.
 *
 * @link   https://github.com/natewiebe13/php-lucide/blob/v1.0/resources/icons.php
 *
 *
 * @author Mat Lipe
 * @since  6.1.0
 */
enum Lucide: string {
	case A_ARROW_DOWN                       = 'lucide/a-arrow-down';
	case A_ARROW_UP                         = 'lucide/a-arrow-up';
	case A_LARGE_SMALL                      = 'lucide/a-large-small';
	case ACCESSIBILITY                      = 'lucide/accessibility';
	case ACTIVITY                           = 'lucide/activity';
	case AIR_VENT                           = 'lucide/air-vent';
	case AIRPLAY                            = 'lucide/airplay';
	case ALARM_CLOCK_CHECK                  = 'lucide/alarm-clock-check';
	case ALARM_CLOCK_MINUS                  = 'lucide/alarm-clock-minus';
	case ALARM_CLOCK_OFF                    = 'lucide/alarm-clock-off';
	case ALARM_CLOCK_PLUS                   = 'lucide/alarm-clock-plus';
	case ALARM_CLOCK                        = 'lucide/alarm-clock';
	case ALARM_SMOKE                        = 'lucide/alarm-smoke';
	case ALBUM                              = 'lucide/album';
	case ALIGN_CENTER_HORIZONTAL            = 'lucide/align-center-horizontal';
	case ALIGN_CENTER_VERTICAL              = 'lucide/align-center-vertical';
	case ALIGN_END_HORIZONTAL               = 'lucide/align-end-horizontal';
	case ALIGN_END_VERTICAL                 = 'lucide/align-end-vertical';
	case ALIGN_HORIZONTAL_DISTRIBUTE_CENTER = 'lucide/align-horizontal-distribute-center';
	case ALIGN_HORIZONTAL_DISTRIBUTE_END    = 'lucide/align-horizontal-distribute-end';
	case ALIGN_HORIZONTAL_DISTRIBUTE_START  = 'lucide/align-horizontal-distribute-start';
	case ALIGN_HORIZONTAL_JUSTIFY_CENTER    = 'lucide/align-horizontal-justify-center';
	case ALIGN_HORIZONTAL_JUSTIFY_END       = 'lucide/align-horizontal-justify-end';
	case ALIGN_HORIZONTAL_JUSTIFY_START     = 'lucide/align-horizontal-justify-start';
	case ALIGN_HORIZONTAL_SPACE_AROUND      = 'lucide/align-horizontal-space-around';
	case ALIGN_HORIZONTAL_SPACE_BETWEEN     = 'lucide/align-horizontal-space-between';
	case ALIGN_START_HORIZONTAL             = 'lucide/align-start-horizontal';
	case ALIGN_START_VERTICAL               = 'lucide/align-start-vertical';
	case ALIGN_VERTICAL_DISTRIBUTE_CENTER   = 'lucide/align-vertical-distribute-center';
	case ALIGN_VERTICAL_DISTRIBUTE_END      = 'lucide/align-vertical-distribute-end';
	case ALIGN_VERTICAL_DISTRIBUTE_START    = 'lucide/align-vertical-distribute-start';
	case ALIGN_VERTICAL_JUSTIFY_CENTER      = 'lucide/align-vertical-justify-center';
	case ALIGN_VERTICAL_JUSTIFY_END         = 'lucide/align-vertical-justify-end';
	case ALIGN_VERTICAL_JUSTIFY_START       = 'lucide/align-vertical-justify-start';
	case ALIGN_VERTICAL_SPACE_AROUND        = 'lucide/align-vertical-space-around';
	case ALIGN_VERTICAL_SPACE_BETWEEN       = 'lucide/align-vertical-space-between';
	case AMBULANCE                          = 'lucide/ambulance';
	case AMPERSAND                          = 'lucide/ampersand';
	case AMPERSANDS                         = 'lucide/ampersands';
	case AMPHORA                            = 'lucide/amphora';
	case ANCHOR                             = 'lucide/anchor';
	case ANGRY                              = 'lucide/angry';
	case ANNOYED                            = 'lucide/annoyed';
	case ANTENNA                            = 'lucide/antenna';
	case ANVIL                              = 'lucide/anvil';
	case APERTURE                           = 'lucide/aperture';
	case APP_WINDOW_MAC                     = 'lucide/app-window-mac';
	case APP_WINDOW                         = 'lucide/app-window';
	case APPLE                              = 'lucide/apple';
	case ARCHIVE_RESTORE                    = 'lucide/archive-restore';
	case ARCHIVE_X                          = 'lucide/archive-x';
	case ARCHIVE                            = 'lucide/archive';
	case ARMCHAIR                           = 'lucide/armchair';
	case ARROW_BIG_DOWN_DASH                = 'lucide/arrow-big-down-dash';
	case ARROW_BIG_DOWN                     = 'lucide/arrow-big-down';
	case ARROW_BIG_LEFT_DASH                = 'lucide/arrow-big-left-dash';
	case ARROW_BIG_LEFT                     = 'lucide/arrow-big-left';
	case ARROW_BIG_RIGHT_DASH               = 'lucide/arrow-big-right-dash';
	case ARROW_BIG_RIGHT                    = 'lucide/arrow-big-right';
	case ARROW_BIG_UP_DASH                  = 'lucide/arrow-big-up-dash';
	case ARROW_BIG_UP                       = 'lucide/arrow-big-up';
	case ARROW_DOWN_0_1                     = 'lucide/arrow-down-0-1';
	case ARROW_DOWN_1_0                     = 'lucide/arrow-down-1-0';
	case ARROW_DOWN_A_Z                     = 'lucide/arrow-down-a-z';
	case ARROW_DOWN_FROM_LINE               = 'lucide/arrow-down-from-line';
	case ARROW_DOWN_LEFT                    = 'lucide/arrow-down-left';
	case ARROW_DOWN_NARROW_WIDE             = 'lucide/arrow-down-narrow-wide';
	case ARROW_DOWN_RIGHT                   = 'lucide/arrow-down-right';
	case ARROW_DOWN_TO_DOT                  = 'lucide/arrow-down-to-dot';
	case ARROW_DOWN_TO_LINE                 = 'lucide/arrow-down-to-line';
	case ARROW_DOWN_UP                      = 'lucide/arrow-down-up';
	case ARROW_DOWN_WIDE_NARROW             = 'lucide/arrow-down-wide-narrow';
	case ARROW_DOWN_Z_A                     = 'lucide/arrow-down-z-a';
	case ARROW_DOWN                         = 'lucide/arrow-down';
	case ARROW_LEFT_FROM_LINE               = 'lucide/arrow-left-from-line';
	case ARROW_LEFT_RIGHT                   = 'lucide/arrow-left-right';
	case ARROW_LEFT_TO_LINE                 = 'lucide/arrow-left-to-line';
	case ARROW_LEFT                         = 'lucide/arrow-left';
	case ARROW_RIGHT_FROM_LINE              = 'lucide/arrow-right-from-line';
	case ARROW_RIGHT_LEFT                   = 'lucide/arrow-right-left';
	case ARROW_RIGHT_TO_LINE                = 'lucide/arrow-right-to-line';
	case ARROW_RIGHT                        = 'lucide/arrow-right';
	case ARROW_UP_0_1                       = 'lucide/arrow-up-0-1';
	case ARROW_UP_1_0                       = 'lucide/arrow-up-1-0';
	case ARROW_UP_A_Z                       = 'lucide/arrow-up-a-z';
	case ARROW_UP_DOWN                      = 'lucide/arrow-up-down';
	case ARROW_UP_FROM_DOT                  = 'lucide/arrow-up-from-dot';
	case ARROW_UP_FROM_LINE                 = 'lucide/arrow-up-from-line';
	case ARROW_UP_LEFT                      = 'lucide/arrow-up-left';
	case ARROW_UP_NARROW_WIDE               = 'lucide/arrow-up-narrow-wide';
	case ARROW_UP_RIGHT                     = 'lucide/arrow-up-right';
	case ARROW_UP_TO_LINE                   = 'lucide/arrow-up-to-line';
	case ARROW_UP_WIDE_NARROW               = 'lucide/arrow-up-wide-narrow';
	case ARROW_UP_Z_A                       = 'lucide/arrow-up-z-a';
	case ARROW_UP                           = 'lucide/arrow-up';
	case ARROWS_UP_FROM_LINE                = 'lucide/arrows-up-from-line';
	case ASTERISK                           = 'lucide/asterisk';
	case AT_SIGN                            = 'lucide/at-sign';
	case ATOM                               = 'lucide/atom';
	case AUDIO_LINES                        = 'lucide/audio-lines';
	case AUDIO_WAVEFORM                     = 'lucide/audio-waveform';
	case AWARD                              = 'lucide/award';
	case AXE                                = 'lucide/axe';
	case AXIS_3D                            = 'lucide/axis-3d';
	case BABY                               = 'lucide/baby';
	case BACKPACK                           = 'lucide/backpack';
	case BADGE_ALERT                        = 'lucide/badge-alert';
	case BADGE_CENT                         = 'lucide/badge-cent';
	case BADGE_CHECK                        = 'lucide/badge-check';
	case BADGE_DOLLAR_SIGN                  = 'lucide/badge-dollar-sign';
	case BADGE_EURO                         = 'lucide/badge-euro';
	case BADGE_INDIAN_RUPEE                 = 'lucide/badge-indian-rupee';
	case BADGE_INFO                         = 'lucide/badge-info';
	case BADGE_JAPANESE_YEN                 = 'lucide/badge-japanese-yen';
	case BADGE_MINUS                        = 'lucide/badge-minus';
	case BADGE_PERCENT                      = 'lucide/badge-percent';
	case BADGE_PLUS                         = 'lucide/badge-plus';
	case BADGE_POUND_STERLING               = 'lucide/badge-pound-sterling';
	case BADGE_QUESTION_MARK                = 'lucide/badge-question-mark';
	case BADGE_RUSSIAN_RUBLE                = 'lucide/badge-russian-ruble';
	case BADGE_SWISS_FRANC                  = 'lucide/badge-swiss-franc';
	case BADGE_TURKISH_LIRA                 = 'lucide/badge-turkish-lira';
	case BADGE_X                            = 'lucide/badge-x';
	case BADGE                              = 'lucide/badge';
	case BAGGAGE_CLAIM                      = 'lucide/baggage-claim';
	case BALLOON                            = 'lucide/balloon';
	case BAN                                = 'lucide/ban';
	case BANANA                             = 'lucide/banana';
	case BANDAGE                            = 'lucide/bandage';
	case BANKNOTE_ARROW_DOWN                = 'lucide/banknote-arrow-down';
	case BANKNOTE_ARROW_UP                  = 'lucide/banknote-arrow-up';
	case BANKNOTE_X                         = 'lucide/banknote-x';
	case BANKNOTE                           = 'lucide/banknote';
	case BARCODE                            = 'lucide/barcode';
	case BARREL                             = 'lucide/barrel';
	case BASELINE                           = 'lucide/baseline';
	case BATH                               = 'lucide/bath';
	case BATTERY_CHARGING                   = 'lucide/battery-charging';
	case BATTERY_FULL                       = 'lucide/battery-full';
	case BATTERY_LOW                        = 'lucide/battery-low';
	case BATTERY_MEDIUM                     = 'lucide/battery-medium';
	case BATTERY_PLUS                       = 'lucide/battery-plus';
	case BATTERY_WARNING                    = 'lucide/battery-warning';
	case BATTERY                            = 'lucide/battery';
	case BEAKER                             = 'lucide/beaker';
	case BEAN_OFF                           = 'lucide/bean-off';
	case BEAN                               = 'lucide/bean';
	case BED_DOUBLE                         = 'lucide/bed-double';
	case BED_SINGLE                         = 'lucide/bed-single';
	case BED                                = 'lucide/bed';
	case BEEF                               = 'lucide/beef';
	case BEER_OFF                           = 'lucide/beer-off';
	case BEER                               = 'lucide/beer';
	case BELL_DOT                           = 'lucide/bell-dot';
	case BELL_ELECTRIC                      = 'lucide/bell-electric';
	case BELL_MINUS                         = 'lucide/bell-minus';
	case BELL_OFF                           = 'lucide/bell-off';
	case BELL_PLUS                          = 'lucide/bell-plus';
	case BELL_RING                          = 'lucide/bell-ring';
	case BELL                               = 'lucide/bell';
	case BETWEEN_HORIZONTAL_END             = 'lucide/between-horizontal-end';
	case BETWEEN_HORIZONTAL_START           = 'lucide/between-horizontal-start';
	case BETWEEN_VERTICAL_END               = 'lucide/between-vertical-end';
	case BETWEEN_VERTICAL_START             = 'lucide/between-vertical-start';
	case BICEPS_FLEXED                      = 'lucide/biceps-flexed';
	case BIKE                               = 'lucide/bike';
	case BINARY                             = 'lucide/binary';
	case BINOCULARS                         = 'lucide/binoculars';
	case BIOHAZARD                          = 'lucide/biohazard';
	case BIRD                               = 'lucide/bird';
	case BIRDHOUSE                          = 'lucide/birdhouse';
	case BITCOIN                            = 'lucide/bitcoin';
	case BLEND                              = 'lucide/blend';
	case BLINDS                             = 'lucide/blinds';
	case BLOCKS                             = 'lucide/blocks';
	case BLUETOOTH_CONNECTED                = 'lucide/bluetooth-connected';
	case BLUETOOTH_OFF                      = 'lucide/bluetooth-off';
	case BLUETOOTH_SEARCHING                = 'lucide/bluetooth-searching';
	case BLUETOOTH                          = 'lucide/bluetooth';
	case BOLD                               = 'lucide/bold';
	case BOLT                               = 'lucide/bolt';
	case BOMB                               = 'lucide/bomb';
	case BONE                               = 'lucide/bone';
	case BOOK_A                             = 'lucide/book-a';
	case BOOK_ALERT                         = 'lucide/book-alert';
	case BOOK_AUDIO                         = 'lucide/book-audio';
	case BOOK_CHECK                         = 'lucide/book-check';
	case BOOK_COPY                          = 'lucide/book-copy';
	case BOOK_DASHED                        = 'lucide/book-dashed';
	case BOOK_DOWN                          = 'lucide/book-down';
	case BOOK_HEADPHONES                    = 'lucide/book-headphones';
	case BOOK_HEART                         = 'lucide/book-heart';
	case BOOK_IMAGE                         = 'lucide/book-image';
	case BOOK_KEY                           = 'lucide/book-key';
	case BOOK_LOCK                          = 'lucide/book-lock';
	case BOOK_MARKED                        = 'lucide/book-marked';
	case BOOK_MINUS                         = 'lucide/book-minus';
	case BOOK_OPEN_CHECK                    = 'lucide/book-open-check';
	case BOOK_OPEN_TEXT                     = 'lucide/book-open-text';
	case BOOK_OPEN                          = 'lucide/book-open';
	case BOOK_PLUS                          = 'lucide/book-plus';
	case BOOK_SEARCH                        = 'lucide/book-search';
	case BOOK_TEXT                          = 'lucide/book-text';
	case BOOK_TYPE                          = 'lucide/book-type';
	case BOOK_UP_2                          = 'lucide/book-up-2';
	case BOOK_UP                            = 'lucide/book-up';
	case BOOK_USER                          = 'lucide/book-user';
	case BOOK_X                             = 'lucide/book-x';
	case BOOK                               = 'lucide/book';
	case BOOKMARK_CHECK                     = 'lucide/bookmark-check';
	case BOOKMARK_MINUS                     = 'lucide/bookmark-minus';
	case BOOKMARK_PLUS                      = 'lucide/bookmark-plus';
	case BOOKMARK_X                         = 'lucide/bookmark-x';
	case BOOKMARK                           = 'lucide/bookmark';
	case BOOM_BOX                           = 'lucide/boom-box';
	case BOT_MESSAGE_SQUARE                 = 'lucide/bot-message-square';
	case BOT_OFF                            = 'lucide/bot-off';
	case BOT                                = 'lucide/bot';
	case BOTTLE_WINE                        = 'lucide/bottle-wine';
	case BOW_ARROW                          = 'lucide/bow-arrow';
	case BOX                                = 'lucide/box';
	case BOXES                              = 'lucide/boxes';
	case BRACES                             = 'lucide/braces';
	case BRACKETS                           = 'lucide/brackets';
	case BRAIN_CIRCUIT                      = 'lucide/brain-circuit';
	case BRAIN_COG                          = 'lucide/brain-cog';
	case BRAIN                              = 'lucide/brain';
	case BRICK_WALL_FIRE                    = 'lucide/brick-wall-fire';
	case BRICK_WALL_SHIELD                  = 'lucide/brick-wall-shield';
	case BRICK_WALL                         = 'lucide/brick-wall';
	case BRIEFCASE_BUSINESS                 = 'lucide/briefcase-business';
	case BRIEFCASE_CONVEYOR_BELT            = 'lucide/briefcase-conveyor-belt';
	case BRIEFCASE_MEDICAL                  = 'lucide/briefcase-medical';
	case BRIEFCASE                          = 'lucide/briefcase';
	case BRING_TO_FRONT                     = 'lucide/bring-to-front';
	case BRUSH_CLEANING                     = 'lucide/brush-cleaning';
	case BRUSH                              = 'lucide/brush';
	case BUBBLES                            = 'lucide/bubbles';
	case BUG_OFF                            = 'lucide/bug-off';
	case BUG_PLAY                           = 'lucide/bug-play';
	case BUG                                = 'lucide/bug';
	case BUILDING_2                         = 'lucide/building-2';
	case BUILDING                           = 'lucide/building';
	case BUS_FRONT                          = 'lucide/bus-front';
	case BUS                                = 'lucide/bus';
	case CABLE_CAR                          = 'lucide/cable-car';
	case CABLE                              = 'lucide/cable';
	case CAKE_SLICE                         = 'lucide/cake-slice';
	case CAKE                               = 'lucide/cake';
	case CALCULATOR                         = 'lucide/calculator';
	case CALENDAR_1                         = 'lucide/calendar-1';
	case CALENDAR_ARROW_DOWN                = 'lucide/calendar-arrow-down';
	case CALENDAR_ARROW_UP                  = 'lucide/calendar-arrow-up';
	case CALENDAR_CHECK_2                   = 'lucide/calendar-check-2';
	case CALENDAR_CHECK                     = 'lucide/calendar-check';
	case CALENDAR_CLOCK                     = 'lucide/calendar-clock';
	case CALENDAR_COG                       = 'lucide/calendar-cog';
	case CALENDAR_DAYS                      = 'lucide/calendar-days';
	case CALENDAR_FOLD                      = 'lucide/calendar-fold';
	case CALENDAR_HEART                     = 'lucide/calendar-heart';
	case CALENDAR_MINUS_2                   = 'lucide/calendar-minus-2';
	case CALENDAR_MINUS                     = 'lucide/calendar-minus';
	case CALENDAR_OFF                       = 'lucide/calendar-off';
	case CALENDAR_PLUS_2                    = 'lucide/calendar-plus-2';
	case CALENDAR_PLUS                      = 'lucide/calendar-plus';
	case CALENDAR_RANGE                     = 'lucide/calendar-range';
	case CALENDAR_SEARCH                    = 'lucide/calendar-search';
	case CALENDAR_SYNC                      = 'lucide/calendar-sync';
	case CALENDAR_X_2                       = 'lucide/calendar-x-2';
	case CALENDAR_X                         = 'lucide/calendar-x';
	case CALENDAR                           = 'lucide/calendar';
	case CALENDARS                          = 'lucide/calendars';
	case CAMERA_OFF                         = 'lucide/camera-off';
	case CAMERA                             = 'lucide/camera';
	case CANDY_CANE                         = 'lucide/candy-cane';
	case CANDY_OFF                          = 'lucide/candy-off';
	case CANDY                              = 'lucide/candy';
	case CANNABIS_OFF                       = 'lucide/cannabis-off';
	case CANNABIS                           = 'lucide/cannabis';
	case CAPTIONS_OFF                       = 'lucide/captions-off';
	case CAPTIONS                           = 'lucide/captions';
	case CAR_FRONT                          = 'lucide/car-front';
	case CAR_TAXI_FRONT                     = 'lucide/car-taxi-front';
	case CAR                                = 'lucide/car';
	case CARAVAN                            = 'lucide/caravan';
	case CARD_SIM                           = 'lucide/card-sim';
	case CARROT                             = 'lucide/carrot';
	case CASE_LOWER                         = 'lucide/case-lower';
	case CASE_SENSITIVE                     = 'lucide/case-sensitive';
	case CASE_UPPER                         = 'lucide/case-upper';
	case CASSETTE_TAPE                      = 'lucide/cassette-tape';
	case CAST                               = 'lucide/cast';
	case CASTLE                             = 'lucide/castle';
	case CAT                                = 'lucide/cat';
	case CCTV                               = 'lucide/cctv';
	case CHART_AREA                         = 'lucide/chart-area';
	case CHART_BAR_BIG                      = 'lucide/chart-bar-big';
	case CHART_BAR_DECREASING               = 'lucide/chart-bar-decreasing';
	case CHART_BAR_INCREASING               = 'lucide/chart-bar-increasing';
	case CHART_BAR_STACKED                  = 'lucide/chart-bar-stacked';
	case CHART_BAR                          = 'lucide/chart-bar';
	case CHART_CANDLESTICK                  = 'lucide/chart-candlestick';
	case CHART_COLUMN_BIG                   = 'lucide/chart-column-big';
	case CHART_COLUMN_DECREASING            = 'lucide/chart-column-decreasing';
	case CHART_COLUMN_INCREASING            = 'lucide/chart-column-increasing';
	case CHART_COLUMN_STACKED               = 'lucide/chart-column-stacked';
	case CHART_COLUMN                       = 'lucide/chart-column';
	case CHART_GANTT                        = 'lucide/chart-gantt';
	case CHART_LINE                         = 'lucide/chart-line';
	case CHART_NETWORK                      = 'lucide/chart-network';
	case CHART_NO_AXES_COLUMN_DECREASING    = 'lucide/chart-no-axes-column-decreasing';
	case CHART_NO_AXES_COLUMN_INCREASING    = 'lucide/chart-no-axes-column-increasing';
	case CHART_NO_AXES_COLUMN               = 'lucide/chart-no-axes-column';
	case CHART_NO_AXES_COMBINED             = 'lucide/chart-no-axes-combined';
	case CHART_NO_AXES_GANTT                = 'lucide/chart-no-axes-gantt';
	case CHART_PIE                          = 'lucide/chart-pie';
	case CHART_SCATTER                      = 'lucide/chart-scatter';
	case CHART_SPLINE                       = 'lucide/chart-spline';
	case CHECK_CHECK                        = 'lucide/check-check';
	case CHECK_LINE                         = 'lucide/check-line';
	case CHECK                              = 'lucide/check';
	case CHEF_HAT                           = 'lucide/chef-hat';
	case CHERRY                             = 'lucide/cherry';
	case CHESS_BISHOP                       = 'lucide/chess-bishop';
	case CHESS_KING                         = 'lucide/chess-king';
	case CHESS_KNIGHT                       = 'lucide/chess-knight';
	case CHESS_PAWN                         = 'lucide/chess-pawn';
	case CHESS_QUEEN                        = 'lucide/chess-queen';
	case CHESS_ROOK                         = 'lucide/chess-rook';
	case CHEVRON_DOWN                       = 'lucide/chevron-down';
	case CHEVRON_FIRST                      = 'lucide/chevron-first';
	case CHEVRON_LAST                       = 'lucide/chevron-last';
	case CHEVRON_LEFT                       = 'lucide/chevron-left';
	case CHEVRON_RIGHT                      = 'lucide/chevron-right';
	case CHEVRON_UP                         = 'lucide/chevron-up';
	case CHEVRONS_DOWN_UP                   = 'lucide/chevrons-down-up';
	case CHEVRONS_DOWN                      = 'lucide/chevrons-down';
	case CHEVRONS_LEFT_RIGHT_ELLIPSIS       = 'lucide/chevrons-left-right-ellipsis';
	case CHEVRONS_LEFT_RIGHT                = 'lucide/chevrons-left-right';
	case CHEVRONS_LEFT                      = 'lucide/chevrons-left';
	case CHEVRONS_RIGHT_LEFT                = 'lucide/chevrons-right-left';
	case CHEVRONS_RIGHT                     = 'lucide/chevrons-right';
	case CHEVRONS_UP_DOWN                   = 'lucide/chevrons-up-down';
	case CHEVRONS_UP                        = 'lucide/chevrons-up';
	case CHROMIUM                           = 'lucide/chromium';
	case CHURCH                             = 'lucide/church';
	case CIGARETTE_OFF                      = 'lucide/cigarette-off';
	case CIGARETTE                          = 'lucide/cigarette';
	case CIRCLE_ALERT                       = 'lucide/circle-alert';
	case CIRCLE_ARROW_DOWN                  = 'lucide/circle-arrow-down';
	case CIRCLE_ARROW_LEFT                  = 'lucide/circle-arrow-left';
	case CIRCLE_ARROW_OUT_DOWN_LEFT         = 'lucide/circle-arrow-out-down-left';
	case CIRCLE_ARROW_OUT_DOWN_RIGHT        = 'lucide/circle-arrow-out-down-right';
	case CIRCLE_ARROW_OUT_UP_LEFT           = 'lucide/circle-arrow-out-up-left';
	case CIRCLE_ARROW_OUT_UP_RIGHT          = 'lucide/circle-arrow-out-up-right';
	case CIRCLE_ARROW_RIGHT                 = 'lucide/circle-arrow-right';
	case CIRCLE_ARROW_UP                    = 'lucide/circle-arrow-up';
	case CIRCLE_CHECK_BIG                   = 'lucide/circle-check-big';
	case CIRCLE_CHECK                       = 'lucide/circle-check';
	case CIRCLE_CHEVRON_DOWN                = 'lucide/circle-chevron-down';
	case CIRCLE_CHEVRON_LEFT                = 'lucide/circle-chevron-left';
	case CIRCLE_CHEVRON_RIGHT               = 'lucide/circle-chevron-right';
	case CIRCLE_CHEVRON_UP                  = 'lucide/circle-chevron-up';
	case CIRCLE_DASHED                      = 'lucide/circle-dashed';
	case CIRCLE_DIVIDE                      = 'lucide/circle-divide';
	case CIRCLE_DOLLAR_SIGN                 = 'lucide/circle-dollar-sign';
	case CIRCLE_DOT_DASHED                  = 'lucide/circle-dot-dashed';
	case CIRCLE_DOT                         = 'lucide/circle-dot';
	case CIRCLE_ELLIPSIS                    = 'lucide/circle-ellipsis';
	case CIRCLE_EQUAL                       = 'lucide/circle-equal';
	case CIRCLE_FADING_ARROW_UP             = 'lucide/circle-fading-arrow-up';
	case CIRCLE_FADING_PLUS                 = 'lucide/circle-fading-plus';
	case CIRCLE_GAUGE                       = 'lucide/circle-gauge';
	case CIRCLE_MINUS                       = 'lucide/circle-minus';
	case CIRCLE_OFF                         = 'lucide/circle-off';
	case CIRCLE_PARKING_OFF                 = 'lucide/circle-parking-off';
	case CIRCLE_PARKING                     = 'lucide/circle-parking';
	case CIRCLE_PAUSE                       = 'lucide/circle-pause';
	case CIRCLE_PERCENT                     = 'lucide/circle-percent';
	case CIRCLE_PILE                        = 'lucide/circle-pile';
	case CIRCLE_PLAY                        = 'lucide/circle-play';
	case CIRCLE_PLUS                        = 'lucide/circle-plus';
	case CIRCLE_POUND_STERLING              = 'lucide/circle-pound-sterling';
	case CIRCLE_POWER                       = 'lucide/circle-power';
	case CIRCLE_QUESTION_MARK               = 'lucide/circle-question-mark';
	case CIRCLE_SLASH_2                     = 'lucide/circle-slash-2';
	case CIRCLE_SLASH                       = 'lucide/circle-slash';
	case CIRCLE_SMALL                       = 'lucide/circle-small';
	case CIRCLE_STAR                        = 'lucide/circle-star';
	case CIRCLE_STOP                        = 'lucide/circle-stop';
	case CIRCLE_USER_ROUND                  = 'lucide/circle-user-round';
	case CIRCLE_USER                        = 'lucide/circle-user';
	case CIRCLE_X                           = 'lucide/circle-x';
	case CIRCLE                             = 'lucide/circle';
	case CIRCUIT_BOARD                      = 'lucide/circuit-board';
	case CITRUS                             = 'lucide/citrus';
	case CLAPPERBOARD                       = 'lucide/clapperboard';
	case CLIPBOARD_CHECK                    = 'lucide/clipboard-check';
	case CLIPBOARD_CLOCK                    = 'lucide/clipboard-clock';
	case CLIPBOARD_COPY                     = 'lucide/clipboard-copy';
	case CLIPBOARD_LIST                     = 'lucide/clipboard-list';
	case CLIPBOARD_MINUS                    = 'lucide/clipboard-minus';
	case CLIPBOARD_PASTE                    = 'lucide/clipboard-paste';
	case CLIPBOARD_PEN_LINE                 = 'lucide/clipboard-pen-line';
	case CLIPBOARD_PEN                      = 'lucide/clipboard-pen';
	case CLIPBOARD_PLUS                     = 'lucide/clipboard-plus';
	case CLIPBOARD_TYPE                     = 'lucide/clipboard-type';
	case CLIPBOARD_X                        = 'lucide/clipboard-x';
	case CLIPBOARD                          = 'lucide/clipboard';
	case CLOCK_1                            = 'lucide/clock-1';
	case CLOCK_10                           = 'lucide/clock-10';
	case CLOCK_11                           = 'lucide/clock-11';
	case CLOCK_12                           = 'lucide/clock-12';
	case CLOCK_2                            = 'lucide/clock-2';
	case CLOCK_3                            = 'lucide/clock-3';
	case CLOCK_4                            = 'lucide/clock-4';
	case CLOCK_5                            = 'lucide/clock-5';
	case CLOCK_6                            = 'lucide/clock-6';
	case CLOCK_7                            = 'lucide/clock-7';
	case CLOCK_8                            = 'lucide/clock-8';
	case CLOCK_9                            = 'lucide/clock-9';
	case CLOCK_ALERT                        = 'lucide/clock-alert';
	case CLOCK_ARROW_DOWN                   = 'lucide/clock-arrow-down';
	case CLOCK_ARROW_UP                     = 'lucide/clock-arrow-up';
	case CLOCK_CHECK                        = 'lucide/clock-check';
	case CLOCK_FADING                       = 'lucide/clock-fading';
	case CLOCK_PLUS                         = 'lucide/clock-plus';
	case CLOCK                              = 'lucide/clock';
	case CLOSED_CAPTION                     = 'lucide/closed-caption';
	case CLOUD_ALERT                        = 'lucide/cloud-alert';
	case CLOUD_BACKUP                       = 'lucide/cloud-backup';
	case CLOUD_CHECK                        = 'lucide/cloud-check';
	case CLOUD_COG                          = 'lucide/cloud-cog';
	case CLOUD_DOWNLOAD                     = 'lucide/cloud-download';
	case CLOUD_DRIZZLE                      = 'lucide/cloud-drizzle';
	case CLOUD_FOG                          = 'lucide/cloud-fog';
	case CLOUD_HAIL                         = 'lucide/cloud-hail';
	case CLOUD_LIGHTNING                    = 'lucide/cloud-lightning';
	case CLOUD_MOON_RAIN                    = 'lucide/cloud-moon-rain';
	case CLOUD_MOON                         = 'lucide/cloud-moon';
	case CLOUD_OFF                          = 'lucide/cloud-off';
	case CLOUD_RAIN_WIND                    = 'lucide/cloud-rain-wind';
	case CLOUD_RAIN                         = 'lucide/cloud-rain';
	case CLOUD_SNOW                         = 'lucide/cloud-snow';
	case CLOUD_SUN_RAIN                     = 'lucide/cloud-sun-rain';
	case CLOUD_SUN                          = 'lucide/cloud-sun';
	case CLOUD_SYNC                         = 'lucide/cloud-sync';
	case CLOUD_UPLOAD                       = 'lucide/cloud-upload';
	case CLOUD                              = 'lucide/cloud';
	case CLOUDY                             = 'lucide/cloudy';
	case CLOVER                             = 'lucide/clover';
	case CLUB                               = 'lucide/club';
	case CODE_XML                           = 'lucide/code-xml';
	case CODE                               = 'lucide/code';
	case CODEPEN                            = 'lucide/codepen';
	case CODESANDBOX                        = 'lucide/codesandbox';
	case COFFEE                             = 'lucide/coffee';
	case COG                                = 'lucide/cog';
	case COINS                              = 'lucide/coins';
	case COLUMNS_2                          = 'lucide/columns-2';
	case COLUMNS_3_COG                      = 'lucide/columns-3-cog';
	case COLUMNS_3                          = 'lucide/columns-3';
	case COLUMNS_4                          = 'lucide/columns-4';
	case COMBINE                            = 'lucide/combine';
	case COMMAND                            = 'lucide/command';
	case COMPASS                            = 'lucide/compass';
	case COMPONENT                          = 'lucide/component';
	case COMPUTER                           = 'lucide/computer';
	case CONCIERGE_BELL                     = 'lucide/concierge-bell';
	case CONE                               = 'lucide/cone';
	case CONSTRUCTION                       = 'lucide/construction';
	case CONTACT_ROUND                      = 'lucide/contact-round';
	case CONTACT                            = 'lucide/contact';
	case CONTAINER                          = 'lucide/container';
	case CONTRAST                           = 'lucide/contrast';
	case COOKIE                             = 'lucide/cookie';
	case COOKING_POT                        = 'lucide/cooking-pot';
	case COPY_CHECK                         = 'lucide/copy-check';
	case COPY_MINUS                         = 'lucide/copy-minus';
	case COPY_PLUS                          = 'lucide/copy-plus';
	case COPY_SLASH                         = 'lucide/copy-slash';
	case COPY_X                             = 'lucide/copy-x';
	case COPY                               = 'lucide/copy';
	case COPYLEFT                           = 'lucide/copyleft';
	case COPYRIGHT                          = 'lucide/copyright';
	case CORNER_DOWN_LEFT                   = 'lucide/corner-down-left';
	case CORNER_DOWN_RIGHT                  = 'lucide/corner-down-right';
	case CORNER_LEFT_DOWN                   = 'lucide/corner-left-down';
	case CORNER_LEFT_UP                     = 'lucide/corner-left-up';
	case CORNER_RIGHT_DOWN                  = 'lucide/corner-right-down';
	case CORNER_RIGHT_UP                    = 'lucide/corner-right-up';
	case CORNER_UP_LEFT                     = 'lucide/corner-up-left';
	case CORNER_UP_RIGHT                    = 'lucide/corner-up-right';
	case CPU                                = 'lucide/cpu';
	case CREATIVE_COMMONS                   = 'lucide/creative-commons';
	case CREDIT_CARD                        = 'lucide/credit-card';
	case CROISSANT                          = 'lucide/croissant';
	case CROP                               = 'lucide/crop';
	case CROSS                              = 'lucide/cross';
	case CROSSHAIR                          = 'lucide/crosshair';
	case CROWN                              = 'lucide/crown';
	case CUBOID                             = 'lucide/cuboid';
	case CUP_SODA                           = 'lucide/cup-soda';
	case CURRENCY                           = 'lucide/currency';
	case CYLINDER                           = 'lucide/cylinder';
	case DAM                                = 'lucide/dam';
	case DATABASE_BACKUP                    = 'lucide/database-backup';
	case DATABASE_ZAP                       = 'lucide/database-zap';
	case DATABASE                           = 'lucide/database';
	case DECIMALS_ARROW_LEFT                = 'lucide/decimals-arrow-left';
	case DECIMALS_ARROW_RIGHT               = 'lucide/decimals-arrow-right';
	case DELETE                             = 'lucide/delete';
	case DESSERT                            = 'lucide/dessert';
	case DIAMETER                           = 'lucide/diameter';
	case DIAMOND_MINUS                      = 'lucide/diamond-minus';
	case DIAMOND_PERCENT                    = 'lucide/diamond-percent';
	case DIAMOND_PLUS                       = 'lucide/diamond-plus';
	case DIAMOND                            = 'lucide/diamond';
	case DICE_1                             = 'lucide/dice-1';
	case DICE_2                             = 'lucide/dice-2';
	case DICE_3                             = 'lucide/dice-3';
	case DICE_4                             = 'lucide/dice-4';
	case DICE_5                             = 'lucide/dice-5';
	case DICE_6                             = 'lucide/dice-6';
	case DICES                              = 'lucide/dices';
	case DIFF                               = 'lucide/diff';
	case DISC_2                             = 'lucide/disc-2';
	case DISC_3                             = 'lucide/disc-3';
	case DISC_ALBUM                         = 'lucide/disc-album';
	case DISC                               = 'lucide/disc';
	case DIVIDE                             = 'lucide/divide';
	case DNA_OFF                            = 'lucide/dna-off';
	case DNA                                = 'lucide/dna';
	case DOCK                               = 'lucide/dock';
	case DOG                                = 'lucide/dog';
	case DOLLAR_SIGN                        = 'lucide/dollar-sign';
	case DONUT                              = 'lucide/donut';
	case DOOR_CLOSED_LOCKED                 = 'lucide/door-closed-locked';
	case DOOR_CLOSED                        = 'lucide/door-closed';
	case DOOR_OPEN                          = 'lucide/door-open';
	case DOT                                = 'lucide/dot';
	case DOWNLOAD                           = 'lucide/download';
	case DRAFTING_COMPASS                   = 'lucide/drafting-compass';
	case DRAMA                              = 'lucide/drama';
	case DRIBBBLE                           = 'lucide/dribbble';
	case DRILL                              = 'lucide/drill';
	case DRONE                              = 'lucide/drone';
	case DROPLET_OFF                        = 'lucide/droplet-off';
	case DROPLET                            = 'lucide/droplet';
	case DROPLETS                           = 'lucide/droplets';
	case DRUM                               = 'lucide/drum';
	case DRUMSTICK                          = 'lucide/drumstick';
	case DUMBBELL                           = 'lucide/dumbbell';
	case EAR_OFF                            = 'lucide/ear-off';
	case EAR                                = 'lucide/ear';
	case EARTH_LOCK                         = 'lucide/earth-lock';
	case EARTH                              = 'lucide/earth';
	case ECLIPSE                            = 'lucide/eclipse';
	case EGG_FRIED                          = 'lucide/egg-fried';
	case EGG_OFF                            = 'lucide/egg-off';
	case EGG                                = 'lucide/egg';
	case ELLIPSIS_VERTICAL                  = 'lucide/ellipsis-vertical';
	case ELLIPSIS                           = 'lucide/ellipsis';
	case EQUAL_APPROXIMATELY                = 'lucide/equal-approximately';
	case EQUAL_NOT                          = 'lucide/equal-not';
	case EQUAL                              = 'lucide/equal';
	case ERASER                             = 'lucide/eraser';
	case ETHERNET_PORT                      = 'lucide/ethernet-port';
	case EURO                               = 'lucide/euro';
	case EV_CHARGER                         = 'lucide/ev-charger';
	case EXPAND                             = 'lucide/expand';
	case EXTERNAL_LINK                      = 'lucide/external-link';
	case EYE_CLOSED                         = 'lucide/eye-closed';
	case EYE_OFF                            = 'lucide/eye-off';
	case EYE                                = 'lucide/eye';
	case FACEBOOK                           = 'lucide/facebook';
	case FACTORY                            = 'lucide/factory';
	case FAN                                = 'lucide/fan';
	case FAST_FORWARD                       = 'lucide/fast-forward';
	case FEATHER                            = 'lucide/feather';
	case FENCE                              = 'lucide/fence';
	case FERRIS_WHEEL                       = 'lucide/ferris-wheel';
	case FIGMA                              = 'lucide/figma';
	case FILE_ARCHIVE                       = 'lucide/file-archive';
	case FILE_AXIS_3D                       = 'lucide/file-axis-3d';
	case FILE_BADGE                         = 'lucide/file-badge';
	case FILE_BOX                           = 'lucide/file-box';
	case FILE_BRACES_CORNER                 = 'lucide/file-braces-corner';
	case FILE_BRACES                        = 'lucide/file-braces';
	case FILE_CHART_COLUMN_INCREASING       = 'lucide/file-chart-column-increasing';
	case FILE_CHART_COLUMN                  = 'lucide/file-chart-column';
	case FILE_CHART_LINE                    = 'lucide/file-chart-line';
	case FILE_CHART_PIE                     = 'lucide/file-chart-pie';
	case FILE_CHECK_CORNER                  = 'lucide/file-check-corner';
	case FILE_CHECK                         = 'lucide/file-check';
	case FILE_CLOCK                         = 'lucide/file-clock';
	case FILE_CODE_CORNER                   = 'lucide/file-code-corner';
	case FILE_CODE                          = 'lucide/file-code';
	case FILE_COG                           = 'lucide/file-cog';
	case FILE_DIFF                          = 'lucide/file-diff';
	case FILE_DIGIT                         = 'lucide/file-digit';
	case FILE_DOWN                          = 'lucide/file-down';
	case FILE_EXCLAMATION_POINT             = 'lucide/file-exclamation-point';
	case FILE_HEADPHONE                     = 'lucide/file-headphone';
	case FILE_HEART                         = 'lucide/file-heart';
	case FILE_IMAGE                         = 'lucide/file-image';
	case FILE_INPUT                         = 'lucide/file-input';
	case FILE_KEY                           = 'lucide/file-key';
	case FILE_LOCK                          = 'lucide/file-lock';
	case FILE_MINUS_CORNER                  = 'lucide/file-minus-corner';
	case FILE_MINUS                         = 'lucide/file-minus';
	case FILE_MUSIC                         = 'lucide/file-music';
	case FILE_OUTPUT                        = 'lucide/file-output';
	case FILE_PEN_LINE                      = 'lucide/file-pen-line';
	case FILE_PEN                           = 'lucide/file-pen';
	case FILE_PLAY                          = 'lucide/file-play';
	case FILE_PLUS_CORNER                   = 'lucide/file-plus-corner';
	case FILE_PLUS                          = 'lucide/file-plus';
	case FILE_QUESTION_MARK                 = 'lucide/file-question-mark';
	case FILE_SCAN                          = 'lucide/file-scan';
	case FILE_SEARCH_CORNER                 = 'lucide/file-search-corner';
	case FILE_SEARCH                        = 'lucide/file-search';
	case FILE_SIGNAL                        = 'lucide/file-signal';
	case FILE_SLIDERS                       = 'lucide/file-sliders';
	case FILE_SPREADSHEET                   = 'lucide/file-spreadsheet';
	case FILE_STACK                         = 'lucide/file-stack';
	case FILE_SYMLINK                       = 'lucide/file-symlink';
	case FILE_TERMINAL                      = 'lucide/file-terminal';
	case FILE_TEXT                          = 'lucide/file-text';
	case FILE_TYPE_CORNER                   = 'lucide/file-type-corner';
	case FILE_TYPE                          = 'lucide/file-type';
	case FILE_UP                            = 'lucide/file-up';
	case FILE_USER                          = 'lucide/file-user';
	case FILE_VIDEO_CAMERA                  = 'lucide/file-video-camera';
	case FILE_VOLUME                        = 'lucide/file-volume';
	case FILE_X_CORNER                      = 'lucide/file-x-corner';
	case FILE_X                             = 'lucide/file-x';
	case FILE                               = 'lucide/file';
	case FILES                              = 'lucide/files';
	case FILM                               = 'lucide/film';
	case FINGERPRINT_PATTERN                = 'lucide/fingerprint-pattern';
	case FIRE_EXTINGUISHER                  = 'lucide/fire-extinguisher';
	case FISH_OFF                           = 'lucide/fish-off';
	case FISH_SYMBOL                        = 'lucide/fish-symbol';
	case FISH                               = 'lucide/fish';
	case FISHING_HOOK                       = 'lucide/fishing-hook';
	case FLAG_OFF                           = 'lucide/flag-off';
	case FLAG_TRIANGLE_LEFT                 = 'lucide/flag-triangle-left';
	case FLAG_TRIANGLE_RIGHT                = 'lucide/flag-triangle-right';
	case FLAG                               = 'lucide/flag';
	case FLAME_KINDLING                     = 'lucide/flame-kindling';
	case FLAME                              = 'lucide/flame';
	case FLASHLIGHT_OFF                     = 'lucide/flashlight-off';
	case FLASHLIGHT                         = 'lucide/flashlight';
	case FLASK_CONICAL_OFF                  = 'lucide/flask-conical-off';
	case FLASK_CONICAL                      = 'lucide/flask-conical';
	case FLASK_ROUND                        = 'lucide/flask-round';
	case FLIP_HORIZONTAL_2                  = 'lucide/flip-horizontal-2';
	case FLIP_HORIZONTAL                    = 'lucide/flip-horizontal';
	case FLIP_VERTICAL_2                    = 'lucide/flip-vertical-2';
	case FLIP_VERTICAL                      = 'lucide/flip-vertical';
	case FLOWER_2                           = 'lucide/flower-2';
	case FLOWER                             = 'lucide/flower';
	case FOCUS                              = 'lucide/focus';
	case FOLD_HORIZONTAL                    = 'lucide/fold-horizontal';
	case FOLD_VERTICAL                      = 'lucide/fold-vertical';
	case FOLDER_ARCHIVE                     = 'lucide/folder-archive';
	case FOLDER_CHECK                       = 'lucide/folder-check';
	case FOLDER_CLOCK                       = 'lucide/folder-clock';
	case FOLDER_CLOSED                      = 'lucide/folder-closed';
	case FOLDER_CODE                        = 'lucide/folder-code';
	case FOLDER_COG                         = 'lucide/folder-cog';
	case FOLDER_DOT                         = 'lucide/folder-dot';
	case FOLDER_DOWN                        = 'lucide/folder-down';
	case FOLDER_GIT_2                       = 'lucide/folder-git-2';
	case FOLDER_GIT                         = 'lucide/folder-git';
	case FOLDER_HEART                       = 'lucide/folder-heart';
	case FOLDER_INPUT                       = 'lucide/folder-input';
	case FOLDER_KANBAN                      = 'lucide/folder-kanban';
	case FOLDER_KEY                         = 'lucide/folder-key';
	case FOLDER_LOCK                        = 'lucide/folder-lock';
	case FOLDER_MINUS                       = 'lucide/folder-minus';
	case FOLDER_OPEN_DOT                    = 'lucide/folder-open-dot';
	case FOLDER_OPEN                        = 'lucide/folder-open';
	case FOLDER_OUTPUT                      = 'lucide/folder-output';
	case FOLDER_PEN                         = 'lucide/folder-pen';
	case FOLDER_PLUS                        = 'lucide/folder-plus';
	case FOLDER_ROOT                        = 'lucide/folder-root';
	case FOLDER_SEARCH_2                    = 'lucide/folder-search-2';
	case FOLDER_SEARCH                      = 'lucide/folder-search';
	case FOLDER_SYMLINK                     = 'lucide/folder-symlink';
	case FOLDER_SYNC                        = 'lucide/folder-sync';
	case FOLDER_TREE                        = 'lucide/folder-tree';
	case FOLDER_UP                          = 'lucide/folder-up';
	case FOLDER_X                           = 'lucide/folder-x';
	case FOLDER                             = 'lucide/folder';
	case FOLDERS                            = 'lucide/folders';
	case FOOTPRINTS                         = 'lucide/footprints';
	case FORKLIFT                           = 'lucide/forklift';
	case FORM                               = 'lucide/form';
	case FORWARD                            = 'lucide/forward';
	case FRAME                              = 'lucide/frame';
	case FRAMER                             = 'lucide/framer';
	case FROWN                              = 'lucide/frown';
	case FUEL                               = 'lucide/fuel';
	case FULLSCREEN                         = 'lucide/fullscreen';
	case FUNNEL_PLUS                        = 'lucide/funnel-plus';
	case FUNNEL_X                           = 'lucide/funnel-x';
	case FUNNEL                             = 'lucide/funnel';
	case GALLERY_HORIZONTAL_END             = 'lucide/gallery-horizontal-end';
	case GALLERY_HORIZONTAL                 = 'lucide/gallery-horizontal';
	case GALLERY_THUMBNAILS                 = 'lucide/gallery-thumbnails';
	case GALLERY_VERTICAL_END               = 'lucide/gallery-vertical-end';
	case GALLERY_VERTICAL                   = 'lucide/gallery-vertical';
	case GAMEPAD_2                          = 'lucide/gamepad-2';
	case GAMEPAD_DIRECTIONAL                = 'lucide/gamepad-directional';
	case GAMEPAD                            = 'lucide/gamepad';
	case GAUGE                              = 'lucide/gauge';
	case GAVEL                              = 'lucide/gavel';
	case GEM                                = 'lucide/gem';
	case GEORGIAN_LARI                      = 'lucide/georgian-lari';
	case GHOST                              = 'lucide/ghost';
	case GIFT                               = 'lucide/gift';
	case GIT_BRANCH_MINUS                   = 'lucide/git-branch-minus';
	case GIT_BRANCH_PLUS                    = 'lucide/git-branch-plus';
	case GIT_BRANCH                         = 'lucide/git-branch';
	case GIT_COMMIT_HORIZONTAL              = 'lucide/git-commit-horizontal';
	case GIT_COMMIT_VERTICAL                = 'lucide/git-commit-vertical';
	case GIT_COMPARE_ARROWS                 = 'lucide/git-compare-arrows';
	case GIT_COMPARE                        = 'lucide/git-compare';
	case GIT_FORK                           = 'lucide/git-fork';
	case GIT_GRAPH                          = 'lucide/git-graph';
	case GIT_MERGE                          = 'lucide/git-merge';
	case GIT_PULL_REQUEST_ARROW             = 'lucide/git-pull-request-arrow';
	case GIT_PULL_REQUEST_CLOSED            = 'lucide/git-pull-request-closed';
	case GIT_PULL_REQUEST_CREATE_ARROW      = 'lucide/git-pull-request-create-arrow';
	case GIT_PULL_REQUEST_CREATE            = 'lucide/git-pull-request-create';
	case GIT_PULL_REQUEST_DRAFT             = 'lucide/git-pull-request-draft';
	case GIT_PULL_REQUEST                   = 'lucide/git-pull-request';
	case GITHUB                             = 'lucide/github';
	case GITLAB                             = 'lucide/gitlab';
	case GLASS_WATER                        = 'lucide/glass-water';
	case GLASSES                            = 'lucide/glasses';
	case GLOBE_LOCK                         = 'lucide/globe-lock';
	case GLOBE_X                            = 'lucide/globe-x';
	case GLOBE                              = 'lucide/globe';
	case GOAL                               = 'lucide/goal';
	case GPU                                = 'lucide/gpu';
	case GRADUATION_CAP                     = 'lucide/graduation-cap';
	case GRAPE                              = 'lucide/grape';
	case GRID_2X2_CHECK                     = 'lucide/grid-2x2-check';
	case GRID_2X2_PLUS                      = 'lucide/grid-2x2-plus';
	case GRID_2X2_X                         = 'lucide/grid-2x2-x';
	case GRID_2X2                           = 'lucide/grid-2x2';
	case GRID_3X2                           = 'lucide/grid-3x2';
	case GRID_3X3                           = 'lucide/grid-3x3';
	case GRIP_HORIZONTAL                    = 'lucide/grip-horizontal';
	case GRIP_VERTICAL                      = 'lucide/grip-vertical';
	case GRIP                               = 'lucide/grip';
	case GROUP                              = 'lucide/group';
	case GUITAR                             = 'lucide/guitar';
	case HAM                                = 'lucide/ham';
	case HAMBURGER                          = 'lucide/hamburger';
	case HAMMER                             = 'lucide/hammer';
	case HAND_COINS                         = 'lucide/hand-coins';
	case HAND_FIST                          = 'lucide/hand-fist';
	case HAND_GRAB                          = 'lucide/hand-grab';
	case HAND_HEART                         = 'lucide/hand-heart';
	case HAND_HELPING                       = 'lucide/hand-helping';
	case HAND_METAL                         = 'lucide/hand-metal';
	case HAND_PLATTER                       = 'lucide/hand-platter';
	case HAND                               = 'lucide/hand';
	case HANDBAG                            = 'lucide/handbag';
	case HANDSHAKE                          = 'lucide/handshake';
	case HARD_DRIVE_DOWNLOAD                = 'lucide/hard-drive-download';
	case HARD_DRIVE_UPLOAD                  = 'lucide/hard-drive-upload';
	case HARD_DRIVE                         = 'lucide/hard-drive';
	case HARD_HAT                           = 'lucide/hard-hat';
	case HASH                               = 'lucide/hash';
	case HAT_GLASSES                        = 'lucide/hat-glasses';
	case HAZE                               = 'lucide/haze';
	case HD                                 = 'lucide/hd';
	case HDMI_PORT                          = 'lucide/hdmi-port';
	case HEADING_1                          = 'lucide/heading-1';
	case HEADING_2                          = 'lucide/heading-2';
	case HEADING_3                          = 'lucide/heading-3';
	case HEADING_4                          = 'lucide/heading-4';
	case HEADING_5                          = 'lucide/heading-5';
	case HEADING_6                          = 'lucide/heading-6';
	case HEADING                            = 'lucide/heading';
	case HEADPHONE_OFF                      = 'lucide/headphone-off';
	case HEADPHONES                         = 'lucide/headphones';
	case HEADSET                            = 'lucide/headset';
	case HEART_CRACK                        = 'lucide/heart-crack';
	case HEART_HANDSHAKE                    = 'lucide/heart-handshake';
	case HEART_MINUS                        = 'lucide/heart-minus';
	case HEART_OFF                          = 'lucide/heart-off';
	case HEART_PLUS                         = 'lucide/heart-plus';
	case HEART_PULSE                        = 'lucide/heart-pulse';
	case HEART                              = 'lucide/heart';
	case HEATER                             = 'lucide/heater';
	case HELICOPTER                         = 'lucide/helicopter';
	case HEXAGON                            = 'lucide/hexagon';
	case HIGHLIGHTER                        = 'lucide/highlighter';
	case HISTORY                            = 'lucide/history';
	case HOP_OFF                            = 'lucide/hop-off';
	case HOP                                = 'lucide/hop';
	case HOSPITAL                           = 'lucide/hospital';
	case HOTEL                              = 'lucide/hotel';
	case HOURGLASS                          = 'lucide/hourglass';
	case HOUSE_HEART                        = 'lucide/house-heart';
	case HOUSE_PLUG                         = 'lucide/house-plug';
	case HOUSE_PLUS                         = 'lucide/house-plus';
	case HOUSE_WIFI                         = 'lucide/house-wifi';
	case HOUSE                              = 'lucide/house';
	case ICE_CREAM_BOWL                     = 'lucide/ice-cream-bowl';
	case ICE_CREAM_CONE                     = 'lucide/ice-cream-cone';
	case ID_CARD_LANYARD                    = 'lucide/id-card-lanyard';
	case ID_CARD                            = 'lucide/id-card';
	case IMAGE_DOWN                         = 'lucide/image-down';
	case IMAGE_MINUS                        = 'lucide/image-minus';
	case IMAGE_OFF                          = 'lucide/image-off';
	case IMAGE_PLAY                         = 'lucide/image-play';
	case IMAGE_PLUS                         = 'lucide/image-plus';
	case IMAGE_UP                           = 'lucide/image-up';
	case IMAGE_UPSCALE                      = 'lucide/image-upscale';
	case IMAGE                              = 'lucide/image';
	case IMAGES                             = 'lucide/images';
	case IMPORT                             = 'lucide/import';
	case INBOX                              = 'lucide/inbox';
	case INDIAN_RUPEE                       = 'lucide/indian-rupee';
	case INFINITY                           = 'lucide/infinity';
	case INFO                               = 'lucide/info';
	case INSPECTION_PANEL                   = 'lucide/inspection-panel';
	case INSTAGRAM                          = 'lucide/instagram';
	case ITALIC                             = 'lucide/italic';
	case ITERATION_CCW                      = 'lucide/iteration-ccw';
	case ITERATION_CW                       = 'lucide/iteration-cw';
	case JAPANESE_YEN                       = 'lucide/japanese-yen';
	case JOYSTICK                           = 'lucide/joystick';
	case KANBAN                             = 'lucide/kanban';
	case KAYAK                              = 'lucide/kayak';
	case KEY_ROUND                          = 'lucide/key-round';
	case KEY_SQUARE                         = 'lucide/key-square';
	case KEY                                = 'lucide/key';
	case KEYBOARD_MUSIC                     = 'lucide/keyboard-music';
	case KEYBOARD_OFF                       = 'lucide/keyboard-off';
	case KEYBOARD                           = 'lucide/keyboard';
	case LAMP_CEILING                       = 'lucide/lamp-ceiling';
	case LAMP_DESK                          = 'lucide/lamp-desk';
	case LAMP_FLOOR                         = 'lucide/lamp-floor';
	case LAMP_WALL_DOWN                     = 'lucide/lamp-wall-down';
	case LAMP_WALL_UP                       = 'lucide/lamp-wall-up';
	case LAMP                               = 'lucide/lamp';
	case LAND_PLOT                          = 'lucide/land-plot';
	case LANDMARK                           = 'lucide/landmark';
	case LANGUAGES                          = 'lucide/languages';
	case LAPTOP_MINIMAL_CHECK               = 'lucide/laptop-minimal-check';
	case LAPTOP_MINIMAL                     = 'lucide/laptop-minimal';
	case LAPTOP                             = 'lucide/laptop';
	case LASSO_SELECT                       = 'lucide/lasso-select';
	case LASSO                              = 'lucide/lasso';
	case LAUGH                              = 'lucide/laugh';
	case LAYERS_2                           = 'lucide/layers-2';
	case LAYERS_PLUS                        = 'lucide/layers-plus';
	case LAYERS                             = 'lucide/layers';
	case LAYOUT_DASHBOARD                   = 'lucide/layout-dashboard';
	case LAYOUT_GRID                        = 'lucide/layout-grid';
	case LAYOUT_LIST                        = 'lucide/layout-list';
	case LAYOUT_PANEL_LEFT                  = 'lucide/layout-panel-left';
	case LAYOUT_PANEL_TOP                   = 'lucide/layout-panel-top';
	case LAYOUT_TEMPLATE                    = 'lucide/layout-template';
	case LEAF                               = 'lucide/leaf';
	case LEAFY_GREEN                        = 'lucide/leafy-green';
	case LECTERN                            = 'lucide/lectern';
	case LIBRARY_BIG                        = 'lucide/library-big';
	case LIBRARY                            = 'lucide/library';
	case LIFE_BUOY                          = 'lucide/life-buoy';
	case LIGATURE                           = 'lucide/ligature';
	case LIGHTBULB_OFF                      = 'lucide/lightbulb-off';
	case LIGHTBULB                          = 'lucide/lightbulb';
	case LINE_SQUIGGLE                      = 'lucide/line-squiggle';
	case LINK_2_OFF                         = 'lucide/link-2-off';
	case LINK_2                             = 'lucide/link-2';
	case LINK                               = 'lucide/link';
	case LINKEDIN                           = 'lucide/linkedin';
	case LIST_CHECK                         = 'lucide/list-check';
	case LIST_CHECKS                        = 'lucide/list-checks';
	case LIST_CHEVRONS_DOWN_UP              = 'lucide/list-chevrons-down-up';
	case LIST_CHEVRONS_UP_DOWN              = 'lucide/list-chevrons-up-down';
	case LIST_COLLAPSE                      = 'lucide/list-collapse';
	case LIST_END                           = 'lucide/list-end';
	case LIST_FILTER_PLUS                   = 'lucide/list-filter-plus';
	case LIST_FILTER                        = 'lucide/list-filter';
	case LIST_INDENT_DECREASE               = 'lucide/list-indent-decrease';
	case LIST_INDENT_INCREASE               = 'lucide/list-indent-increase';
	case LIST_MINUS                         = 'lucide/list-minus';
	case LIST_MUSIC                         = 'lucide/list-music';
	case LIST_ORDERED                       = 'lucide/list-ordered';
	case LIST_PLUS                          = 'lucide/list-plus';
	case LIST_RESTART                       = 'lucide/list-restart';
	case LIST_START                         = 'lucide/list-start';
	case LIST_TODO                          = 'lucide/list-todo';
	case LIST_TREE                          = 'lucide/list-tree';
	case LIST_VIDEO                         = 'lucide/list-video';
	case LIST_X                             = 'lucide/list-x';
	case LIST                               = 'lucide/list';
	case LOADER_CIRCLE                      = 'lucide/loader-circle';
	case LOADER_PINWHEEL                    = 'lucide/loader-pinwheel';
	case LOADER                             = 'lucide/loader';
	case LOCATE_FIXED                       = 'lucide/locate-fixed';
	case LOCATE_OFF                         = 'lucide/locate-off';
	case LOCATE                             = 'lucide/locate';
	case LOCK_KEYHOLE_OPEN                  = 'lucide/lock-keyhole-open';
	case LOCK_KEYHOLE                       = 'lucide/lock-keyhole';
	case LOCK_OPEN                          = 'lucide/lock-open';
	case LOCK                               = 'lucide/lock';
	case LOG_IN                             = 'lucide/log-in';
	case LOG_OUT                            = 'lucide/log-out';
	case LOGS                               = 'lucide/logs';
	case LOLLIPOP                           = 'lucide/lollipop';
	case LUGGAGE                            = 'lucide/luggage';
	case MAGNET                             = 'lucide/magnet';
	case MAIL_CHECK                         = 'lucide/mail-check';
	case MAIL_MINUS                         = 'lucide/mail-minus';
	case MAIL_OPEN                          = 'lucide/mail-open';
	case MAIL_PLUS                          = 'lucide/mail-plus';
	case MAIL_QUESTION_MARK                 = 'lucide/mail-question-mark';
	case MAIL_SEARCH                        = 'lucide/mail-search';
	case MAIL_WARNING                       = 'lucide/mail-warning';
	case MAIL_X                             = 'lucide/mail-x';
	case MAIL                               = 'lucide/mail';
	case MAILBOX                            = 'lucide/mailbox';
	case MAILS                              = 'lucide/mails';
	case MAP_MINUS                          = 'lucide/map-minus';
	case MAP_PIN_CHECK_INSIDE               = 'lucide/map-pin-check-inside';
	case MAP_PIN_CHECK                      = 'lucide/map-pin-check';
	case MAP_PIN_HOUSE                      = 'lucide/map-pin-house';
	case MAP_PIN_MINUS_INSIDE               = 'lucide/map-pin-minus-inside';
	case MAP_PIN_MINUS                      = 'lucide/map-pin-minus';
	case MAP_PIN_OFF                        = 'lucide/map-pin-off';
	case MAP_PIN_PEN                        = 'lucide/map-pin-pen';
	case MAP_PIN_PLUS_INSIDE                = 'lucide/map-pin-plus-inside';
	case MAP_PIN_PLUS                       = 'lucide/map-pin-plus';
	case MAP_PIN_X_INSIDE                   = 'lucide/map-pin-x-inside';
	case MAP_PIN_X                          = 'lucide/map-pin-x';
	case MAP_PIN                            = 'lucide/map-pin';
	case MAP_PINNED                         = 'lucide/map-pinned';
	case MAP_PLUS                           = 'lucide/map-plus';
	case MAP                                = 'lucide/map';
	case MARS_STROKE                        = 'lucide/mars-stroke';
	case MARS                               = 'lucide/mars';
	case MARTINI                            = 'lucide/martini';
	case MAXIMIZE_2                         = 'lucide/maximize-2';
	case MAXIMIZE                           = 'lucide/maximize';
	case MEDAL                              = 'lucide/medal';
	case MEGAPHONE_OFF                      = 'lucide/megaphone-off';
	case MEGAPHONE                          = 'lucide/megaphone';
	case MEH                                = 'lucide/meh';
	case MEMORY_STICK                       = 'lucide/memory-stick';
	case MENU                               = 'lucide/menu';
	case MERGE                              = 'lucide/merge';
	case MESSAGE_CIRCLE_CODE                = 'lucide/message-circle-code';
	case MESSAGE_CIRCLE_DASHED              = 'lucide/message-circle-dashed';
	case MESSAGE_CIRCLE_HEART               = 'lucide/message-circle-heart';
	case MESSAGE_CIRCLE_MORE                = 'lucide/message-circle-more';
	case MESSAGE_CIRCLE_OFF                 = 'lucide/message-circle-off';
	case MESSAGE_CIRCLE_PLUS                = 'lucide/message-circle-plus';
	case MESSAGE_CIRCLE_QUESTION_MARK       = 'lucide/message-circle-question-mark';
	case MESSAGE_CIRCLE_REPLY               = 'lucide/message-circle-reply';
	case MESSAGE_CIRCLE_WARNING             = 'lucide/message-circle-warning';
	case MESSAGE_CIRCLE_X                   = 'lucide/message-circle-x';
	case MESSAGE_CIRCLE                     = 'lucide/message-circle';
	case MESSAGE_SQUARE_CODE                = 'lucide/message-square-code';
	case MESSAGE_SQUARE_DASHED              = 'lucide/message-square-dashed';
	case MESSAGE_SQUARE_DIFF                = 'lucide/message-square-diff';
	case MESSAGE_SQUARE_DOT                 = 'lucide/message-square-dot';
	case MESSAGE_SQUARE_HEART               = 'lucide/message-square-heart';
	case MESSAGE_SQUARE_LOCK                = 'lucide/message-square-lock';
	case MESSAGE_SQUARE_MORE                = 'lucide/message-square-more';
	case MESSAGE_SQUARE_OFF                 = 'lucide/message-square-off';
	case MESSAGE_SQUARE_PLUS                = 'lucide/message-square-plus';
	case MESSAGE_SQUARE_QUOTE               = 'lucide/message-square-quote';
	case MESSAGE_SQUARE_REPLY               = 'lucide/message-square-reply';
	case MESSAGE_SQUARE_SHARE               = 'lucide/message-square-share';
	case MESSAGE_SQUARE_TEXT                = 'lucide/message-square-text';
	case MESSAGE_SQUARE_WARNING             = 'lucide/message-square-warning';
	case MESSAGE_SQUARE_X                   = 'lucide/message-square-x';
	case MESSAGE_SQUARE                     = 'lucide/message-square';
	case MESSAGES_SQUARE                    = 'lucide/messages-square';
	case MIC_OFF                            = 'lucide/mic-off';
	case MIC_VOCAL                          = 'lucide/mic-vocal';
	case MIC                                = 'lucide/mic';
	case MICROCHIP                          = 'lucide/microchip';
	case MICROSCOPE                         = 'lucide/microscope';
	case MICROWAVE                          = 'lucide/microwave';
	case MILESTONE                          = 'lucide/milestone';
	case MILK_OFF                           = 'lucide/milk-off';
	case MILK                               = 'lucide/milk';
	case MINIMIZE_2                         = 'lucide/minimize-2';
	case MINIMIZE                           = 'lucide/minimize';
	case MINUS                              = 'lucide/minus';
	case MONITOR_CHECK                      = 'lucide/monitor-check';
	case MONITOR_CLOUD                      = 'lucide/monitor-cloud';
	case MONITOR_COG                        = 'lucide/monitor-cog';
	case MONITOR_DOT                        = 'lucide/monitor-dot';
	case MONITOR_DOWN                       = 'lucide/monitor-down';
	case MONITOR_OFF                        = 'lucide/monitor-off';
	case MONITOR_PAUSE                      = 'lucide/monitor-pause';
	case MONITOR_PLAY                       = 'lucide/monitor-play';
	case MONITOR_SMARTPHONE                 = 'lucide/monitor-smartphone';
	case MONITOR_SPEAKER                    = 'lucide/monitor-speaker';
	case MONITOR_STOP                       = 'lucide/monitor-stop';
	case MONITOR_UP                         = 'lucide/monitor-up';
	case MONITOR_X                          = 'lucide/monitor-x';
	case MONITOR                            = 'lucide/monitor';
	case MOON_STAR                          = 'lucide/moon-star';
	case MOON                               = 'lucide/moon';
	case MOTORBIKE                          = 'lucide/motorbike';
	case MOUNTAIN_SNOW                      = 'lucide/mountain-snow';
	case MOUNTAIN                           = 'lucide/mountain';
	case MOUSE_OFF                          = 'lucide/mouse-off';
	case MOUSE_POINTER_2_OFF                = 'lucide/mouse-pointer-2-off';
	case MOUSE_POINTER_2                    = 'lucide/mouse-pointer-2';
	case MOUSE_POINTER_BAN                  = 'lucide/mouse-pointer-ban';
	case MOUSE_POINTER_CLICK                = 'lucide/mouse-pointer-click';
	case MOUSE_POINTER                      = 'lucide/mouse-pointer';
	case MOUSE                              = 'lucide/mouse';
	case MOVE_3D                            = 'lucide/move-3d';
	case MOVE_DIAGONAL_2                    = 'lucide/move-diagonal-2';
	case MOVE_DIAGONAL                      = 'lucide/move-diagonal';
	case MOVE_DOWN_LEFT                     = 'lucide/move-down-left';
	case MOVE_DOWN_RIGHT                    = 'lucide/move-down-right';
	case MOVE_DOWN                          = 'lucide/move-down';
	case MOVE_HORIZONTAL                    = 'lucide/move-horizontal';
	case MOVE_LEFT                          = 'lucide/move-left';
	case MOVE_RIGHT                         = 'lucide/move-right';
	case MOVE_UP_LEFT                       = 'lucide/move-up-left';
	case MOVE_UP_RIGHT                      = 'lucide/move-up-right';
	case MOVE_UP                            = 'lucide/move-up';
	case MOVE_VERTICAL                      = 'lucide/move-vertical';
	case MOVE                               = 'lucide/move';
	case MUSIC_2                            = 'lucide/music-2';
	case MUSIC_3                            = 'lucide/music-3';
	case MUSIC_4                            = 'lucide/music-4';
	case MUSIC                              = 'lucide/music';
	case NAVIGATION_2_OFF                   = 'lucide/navigation-2-off';
	case NAVIGATION_2                       = 'lucide/navigation-2';
	case NAVIGATION_OFF                     = 'lucide/navigation-off';
	case NAVIGATION                         = 'lucide/navigation';
	case NETWORK                            = 'lucide/network';
	case NEWSPAPER                          = 'lucide/newspaper';
	case NFC                                = 'lucide/nfc';
	case NON_BINARY                         = 'lucide/non-binary';
	case NOTEBOOK_PEN                       = 'lucide/notebook-pen';
	case NOTEBOOK_TABS                      = 'lucide/notebook-tabs';
	case NOTEBOOK_TEXT                      = 'lucide/notebook-text';
	case NOTEBOOK                           = 'lucide/notebook';
	case NOTEPAD_TEXT_DASHED                = 'lucide/notepad-text-dashed';
	case NOTEPAD_TEXT                       = 'lucide/notepad-text';
	case NUT_OFF                            = 'lucide/nut-off';
	case NUT                                = 'lucide/nut';
	case OCTAGON_ALERT                      = 'lucide/octagon-alert';
	case OCTAGON_MINUS                      = 'lucide/octagon-minus';
	case OCTAGON_PAUSE                      = 'lucide/octagon-pause';
	case OCTAGON_X                          = 'lucide/octagon-x';
	case OCTAGON                            = 'lucide/octagon';
	case OMEGA                              = 'lucide/omega';
	case OPTION                             = 'lucide/option';
	case ORBIT                              = 'lucide/orbit';
	case ORIGAMI                            = 'lucide/origami';
	case PACKAGE_2                          = 'lucide/package-2';
	case PACKAGE_CHECK                      = 'lucide/package-check';
	case PACKAGE_MINUS                      = 'lucide/package-minus';
	case PACKAGE_OPEN                       = 'lucide/package-open';
	case PACKAGE_PLUS                       = 'lucide/package-plus';
	case PACKAGE_SEARCH                     = 'lucide/package-search';
	case PACKAGE_X                          = 'lucide/package-x';
	case PACKAGE                            = 'lucide/package';
	case PAINT_BUCKET                       = 'lucide/paint-bucket';
	case PAINT_ROLLER                       = 'lucide/paint-roller';
	case PAINTBRUSH_VERTICAL                = 'lucide/paintbrush-vertical';
	case PAINTBRUSH                         = 'lucide/paintbrush';
	case PALETTE                            = 'lucide/palette';
	case PANDA                              = 'lucide/panda';
	case PANEL_BOTTOM_CLOSE                 = 'lucide/panel-bottom-close';
	case PANEL_BOTTOM_DASHED                = 'lucide/panel-bottom-dashed';
	case PANEL_BOTTOM_OPEN                  = 'lucide/panel-bottom-open';
	case PANEL_BOTTOM                       = 'lucide/panel-bottom';
	case PANEL_LEFT_CLOSE                   = 'lucide/panel-left-close';
	case PANEL_LEFT_DASHED                  = 'lucide/panel-left-dashed';
	case PANEL_LEFT_OPEN                    = 'lucide/panel-left-open';
	case PANEL_LEFT_RIGHT_DASHED            = 'lucide/panel-left-right-dashed';
	case PANEL_LEFT                         = 'lucide/panel-left';
	case PANEL_RIGHT_CLOSE                  = 'lucide/panel-right-close';
	case PANEL_RIGHT_DASHED                 = 'lucide/panel-right-dashed';
	case PANEL_RIGHT_OPEN                   = 'lucide/panel-right-open';
	case PANEL_RIGHT                        = 'lucide/panel-right';
	case PANEL_TOP_BOTTOM_DASHED            = 'lucide/panel-top-bottom-dashed';
	case PANEL_TOP_CLOSE                    = 'lucide/panel-top-close';
	case PANEL_TOP_DASHED                   = 'lucide/panel-top-dashed';
	case PANEL_TOP_OPEN                     = 'lucide/panel-top-open';
	case PANEL_TOP                          = 'lucide/panel-top';
	case PANELS_LEFT_BOTTOM                 = 'lucide/panels-left-bottom';
	case PANELS_RIGHT_BOTTOM                = 'lucide/panels-right-bottom';
	case PANELS_TOP_LEFT                    = 'lucide/panels-top-left';
	case PAPERCLIP                          = 'lucide/paperclip';
	case PARENTHESES                        = 'lucide/parentheses';
	case PARKING_METER                      = 'lucide/parking-meter';
	case PARTY_POPPER                       = 'lucide/party-popper';
	case PAUSE                              = 'lucide/pause';
	case PAW_PRINT                          = 'lucide/paw-print';
	case PC_CASE                            = 'lucide/pc-case';
	case PEN_LINE                           = 'lucide/pen-line';
	case PEN_OFF                            = 'lucide/pen-off';
	case PEN_TOOL                           = 'lucide/pen-tool';
	case PEN                                = 'lucide/pen';
	case PENCIL_LINE                        = 'lucide/pencil-line';
	case PENCIL_OFF                         = 'lucide/pencil-off';
	case PENCIL_RULER                       = 'lucide/pencil-ruler';
	case PENCIL                             = 'lucide/pencil';
	case PENTAGON                           = 'lucide/pentagon';
	case PERCENT                            = 'lucide/percent';
	case PERSON_STANDING                    = 'lucide/person-standing';
	case PHILIPPINE_PESO                    = 'lucide/philippine-peso';
	case PHONE_CALL                         = 'lucide/phone-call';
	case PHONE_FORWARDED                    = 'lucide/phone-forwarded';
	case PHONE_INCOMING                     = 'lucide/phone-incoming';
	case PHONE_MISSED                       = 'lucide/phone-missed';
	case PHONE_OFF                          = 'lucide/phone-off';
	case PHONE_OUTGOING                     = 'lucide/phone-outgoing';
	case PHONE                              = 'lucide/phone';
	case PI                                 = 'lucide/pi';
	case PIANO                              = 'lucide/piano';
	case PICKAXE                            = 'lucide/pickaxe';
	case PICTURE_IN_PICTURE_2               = 'lucide/picture-in-picture-2';
	case PICTURE_IN_PICTURE                 = 'lucide/picture-in-picture';
	case PIGGY_BANK                         = 'lucide/piggy-bank';
	case PILCROW_LEFT                       = 'lucide/pilcrow-left';
	case PILCROW_RIGHT                      = 'lucide/pilcrow-right';
	case PILCROW                            = 'lucide/pilcrow';
	case PILL_BOTTLE                        = 'lucide/pill-bottle';
	case PILL                               = 'lucide/pill';
	case PIN_OFF                            = 'lucide/pin-off';
	case PIN                                = 'lucide/pin';
	case PIPETTE                            = 'lucide/pipette';
	case PIZZA                              = 'lucide/pizza';
	case PLANE_LANDING                      = 'lucide/plane-landing';
	case PLANE_TAKEOFF                      = 'lucide/plane-takeoff';
	case PLANE                              = 'lucide/plane';
	case PLAY                               = 'lucide/play';
	case PLUG_2                             = 'lucide/plug-2';
	case PLUG_ZAP                           = 'lucide/plug-zap';
	case PLUG                               = 'lucide/plug';
	case PLUS                               = 'lucide/plus';
	case POCKET_KNIFE                       = 'lucide/pocket-knife';
	case POCKET                             = 'lucide/pocket';
	case PODCAST                            = 'lucide/podcast';
	case POINTER_OFF                        = 'lucide/pointer-off';
	case POINTER                            = 'lucide/pointer';
	case POPCORN                            = 'lucide/popcorn';
	case POPSICLE                           = 'lucide/popsicle';
	case POUND_STERLING                     = 'lucide/pound-sterling';
	case POWER_OFF                          = 'lucide/power-off';
	case POWER                              = 'lucide/power';
	case PRESENTATION                       = 'lucide/presentation';
	case PRINTER_CHECK                      = 'lucide/printer-check';
	case PRINTER_X                          = 'lucide/printer-x';
	case PRINTER                            = 'lucide/printer';
	case PROJECTOR                          = 'lucide/projector';
	case PROPORTIONS                        = 'lucide/proportions';
	case PUZZLE                             = 'lucide/puzzle';
	case PYRAMID                            = 'lucide/pyramid';
	case QR_CODE                            = 'lucide/qr-code';
	case QUOTE                              = 'lucide/quote';
	case RABBIT                             = 'lucide/rabbit';
	case RADAR                              = 'lucide/radar';
	case RADIATION                          = 'lucide/radiation';
	case RADICAL                            = 'lucide/radical';
	case RADIO_RECEIVER                     = 'lucide/radio-receiver';
	case RADIO_TOWER                        = 'lucide/radio-tower';
	case RADIO                              = 'lucide/radio';
	case RADIUS                             = 'lucide/radius';
	case RAIL_SYMBOL                        = 'lucide/rail-symbol';
	case RAINBOW                            = 'lucide/rainbow';
	case RAT                                = 'lucide/rat';
	case RATIO                              = 'lucide/ratio';
	case RECEIPT_CENT                       = 'lucide/receipt-cent';
	case RECEIPT_EURO                       = 'lucide/receipt-euro';
	case RECEIPT_INDIAN_RUPEE               = 'lucide/receipt-indian-rupee';
	case RECEIPT_JAPANESE_YEN               = 'lucide/receipt-japanese-yen';
	case RECEIPT_POUND_STERLING             = 'lucide/receipt-pound-sterling';
	case RECEIPT_RUSSIAN_RUBLE              = 'lucide/receipt-russian-ruble';
	case RECEIPT_SWISS_FRANC                = 'lucide/receipt-swiss-franc';
	case RECEIPT_TEXT                       = 'lucide/receipt-text';
	case RECEIPT_TURKISH_LIRA               = 'lucide/receipt-turkish-lira';
	case RECEIPT                            = 'lucide/receipt';
	case RECTANGLE_CIRCLE                   = 'lucide/rectangle-circle';
	case RECTANGLE_ELLIPSIS                 = 'lucide/rectangle-ellipsis';
	case RECTANGLE_GOGGLES                  = 'lucide/rectangle-goggles';
	case RECTANGLE_HORIZONTAL               = 'lucide/rectangle-horizontal';
	case RECTANGLE_VERTICAL                 = 'lucide/rectangle-vertical';
	case RECYCLE                            = 'lucide/recycle';
	case REDO_2                             = 'lucide/redo-2';
	case REDO_DOT                           = 'lucide/redo-dot';
	case REDO                               = 'lucide/redo';
	case REFRESH_CCW_DOT                    = 'lucide/refresh-ccw-dot';
	case REFRESH_CCW                        = 'lucide/refresh-ccw';
	case REFRESH_CW_OFF                     = 'lucide/refresh-cw-off';
	case REFRESH_CW                         = 'lucide/refresh-cw';
	case REFRIGERATOR                       = 'lucide/refrigerator';
	case REGEX                              = 'lucide/regex';
	case REMOVE_FORMATTING                  = 'lucide/remove-formatting';
	case REPEAT_1                           = 'lucide/repeat-1';
	case REPEAT_2                           = 'lucide/repeat-2';
	case REPEAT                             = 'lucide/repeat';
	case REPLACE_ALL                        = 'lucide/replace-all';
	case REPLACE                            = 'lucide/replace';
	case REPLY_ALL                          = 'lucide/reply-all';
	case REPLY                              = 'lucide/reply';
	case REWIND                             = 'lucide/rewind';
	case RIBBON                             = 'lucide/ribbon';
	case ROCKET                             = 'lucide/rocket';
	case ROCKING_CHAIR                      = 'lucide/rocking-chair';
	case ROLLER_COASTER                     = 'lucide/roller-coaster';
	case ROSE                               = 'lucide/rose';
	case ROTATE_3D                          = 'lucide/rotate-3d';
	case ROTATE_CCW_KEY                     = 'lucide/rotate-ccw-key';
	case ROTATE_CCW_SQUARE                  = 'lucide/rotate-ccw-square';
	case ROTATE_CCW                         = 'lucide/rotate-ccw';
	case ROTATE_CW_SQUARE                   = 'lucide/rotate-cw-square';
	case ROTATE_CW                          = 'lucide/rotate-cw';
	case ROUTE_OFF                          = 'lucide/route-off';
	case ROUTE                              = 'lucide/route';
	case ROUTER                             = 'lucide/router';
	case ROWS_2                             = 'lucide/rows-2';
	case ROWS_3                             = 'lucide/rows-3';
	case ROWS_4                             = 'lucide/rows-4';
	case RSS                                = 'lucide/rss';
	case RULER_DIMENSION_LINE               = 'lucide/ruler-dimension-line';
	case RULER                              = 'lucide/ruler';
	case RUSSIAN_RUBLE                      = 'lucide/russian-ruble';
	case SAILBOAT                           = 'lucide/sailboat';
	case SALAD                              = 'lucide/salad';
	case SANDWICH                           = 'lucide/sandwich';
	case SATELLITE_DISH                     = 'lucide/satellite-dish';
	case SATELLITE                          = 'lucide/satellite';
	case SAUDI_RIYAL                        = 'lucide/saudi-riyal';
	case SAVE_ALL                           = 'lucide/save-all';
	case SAVE_OFF                           = 'lucide/save-off';
	case SAVE                               = 'lucide/save';
	case SCALE_3D                           = 'lucide/scale-3d';
	case SCALE                              = 'lucide/scale';
	case SCALING                            = 'lucide/scaling';
	case SCAN_BARCODE                       = 'lucide/scan-barcode';
	case SCAN_EYE                           = 'lucide/scan-eye';
	case SCAN_FACE                          = 'lucide/scan-face';
	case SCAN_HEART                         = 'lucide/scan-heart';
	case SCAN_LINE                          = 'lucide/scan-line';
	case SCAN_QR_CODE                       = 'lucide/scan-qr-code';
	case SCAN_SEARCH                        = 'lucide/scan-search';
	case SCAN_TEXT                          = 'lucide/scan-text';
	case SCAN                               = 'lucide/scan';
	case SCHOOL                             = 'lucide/school';
	case SCISSORS_LINE_DASHED               = 'lucide/scissors-line-dashed';
	case SCISSORS                           = 'lucide/scissors';
	case SCOOTER                            = 'lucide/scooter';
	case SCREEN_SHARE_OFF                   = 'lucide/screen-share-off';
	case SCREEN_SHARE                       = 'lucide/screen-share';
	case SCROLL_TEXT                        = 'lucide/scroll-text';
	case SCROLL                             = 'lucide/scroll';
	case SEARCH_ALERT                       = 'lucide/search-alert';
	case SEARCH_CHECK                       = 'lucide/search-check';
	case SEARCH_CODE                        = 'lucide/search-code';
	case SEARCH_SLASH                       = 'lucide/search-slash';
	case SEARCH_X                           = 'lucide/search-x';
	case SEARCH                             = 'lucide/search';
	case SECTION                            = 'lucide/section';
	case SEND_HORIZONTAL                    = 'lucide/send-horizontal';
	case SEND_TO_BACK                       = 'lucide/send-to-back';
	case SEND                               = 'lucide/send';
	case SEPARATOR_HORIZONTAL               = 'lucide/separator-horizontal';
	case SEPARATOR_VERTICAL                 = 'lucide/separator-vertical';
	case SERVER_COG                         = 'lucide/server-cog';
	case SERVER_CRASH                       = 'lucide/server-crash';
	case SERVER_OFF                         = 'lucide/server-off';
	case SERVER                             = 'lucide/server';
	case SETTINGS_2                         = 'lucide/settings-2';
	case SETTINGS                           = 'lucide/settings';
	case SHAPES                             = 'lucide/shapes';
	case SHARE_2                            = 'lucide/share-2';
	case SHARE                              = 'lucide/share';
	case SHEET                              = 'lucide/sheet';
	case SHELL                              = 'lucide/shell';
	case SHIELD_ALERT                       = 'lucide/shield-alert';
	case SHIELD_BAN                         = 'lucide/shield-ban';
	case SHIELD_CHECK                       = 'lucide/shield-check';
	case SHIELD_ELLIPSIS                    = 'lucide/shield-ellipsis';
	case SHIELD_HALF                        = 'lucide/shield-half';
	case SHIELD_MINUS                       = 'lucide/shield-minus';
	case SHIELD_OFF                         = 'lucide/shield-off';
	case SHIELD_PLUS                        = 'lucide/shield-plus';
	case SHIELD_QUESTION_MARK               = 'lucide/shield-question-mark';
	case SHIELD_USER                        = 'lucide/shield-user';
	case SHIELD_X                           = 'lucide/shield-x';
	case SHIELD                             = 'lucide/shield';
	case SHIP_WHEEL                         = 'lucide/ship-wheel';
	case SHIP                               = 'lucide/ship';
	case SHIRT                              = 'lucide/shirt';
	case SHOPPING_BAG                       = 'lucide/shopping-bag';
	case SHOPPING_BASKET                    = 'lucide/shopping-basket';
	case SHOPPING_CART                      = 'lucide/shopping-cart';
	case SHOVEL                             = 'lucide/shovel';
	case SHOWER_HEAD                        = 'lucide/shower-head';
	case SHREDDER                           = 'lucide/shredder';
	case SHRIMP                             = 'lucide/shrimp';
	case SHRINK                             = 'lucide/shrink';
	case SHRUB                              = 'lucide/shrub';
	case SHUFFLE                            = 'lucide/shuffle';
	case SIGMA                              = 'lucide/sigma';
	case SIGNAL_HIGH                        = 'lucide/signal-high';
	case SIGNAL_LOW                         = 'lucide/signal-low';
	case SIGNAL_MEDIUM                      = 'lucide/signal-medium';
	case SIGNAL_ZERO                        = 'lucide/signal-zero';
	case SIGNAL                             = 'lucide/signal';
	case SIGNATURE                          = 'lucide/signature';
	case SIGNPOST_BIG                       = 'lucide/signpost-big';
	case SIGNPOST                           = 'lucide/signpost';
	case SIREN                              = 'lucide/siren';
	case SKIP_BACK                          = 'lucide/skip-back';
	case SKIP_FORWARD                       = 'lucide/skip-forward';
	case SKULL                              = 'lucide/skull';
	case SLACK                              = 'lucide/slack';
	case SLASH                              = 'lucide/slash';
	case SLICE                              = 'lucide/slice';
	case SLIDERS_HORIZONTAL                 = 'lucide/sliders-horizontal';
	case SLIDERS_VERTICAL                   = 'lucide/sliders-vertical';
	case SMARTPHONE_CHARGING                = 'lucide/smartphone-charging';
	case SMARTPHONE_NFC                     = 'lucide/smartphone-nfc';
	case SMARTPHONE                         = 'lucide/smartphone';
	case SMILE_PLUS                         = 'lucide/smile-plus';
	case SMILE                              = 'lucide/smile';
	case SNAIL                              = 'lucide/snail';
	case SNOWFLAKE                          = 'lucide/snowflake';
	case SOAP_DISPENSER_DROPLET             = 'lucide/soap-dispenser-droplet';
	case SOFA                               = 'lucide/sofa';
	case SOLAR_PANEL                        = 'lucide/solar-panel';
	case SOUP                               = 'lucide/soup';
	case SPACE                              = 'lucide/space';
	case SPADE                              = 'lucide/spade';
	case SPARKLE                            = 'lucide/sparkle';
	case SPARKLES                           = 'lucide/sparkles';
	case SPEAKER                            = 'lucide/speaker';
	case SPEECH                             = 'lucide/speech';
	case SPELL_CHECK_2                      = 'lucide/spell-check-2';
	case SPELL_CHECK                        = 'lucide/spell-check';
	case SPLINE_POINTER                     = 'lucide/spline-pointer';
	case SPLINE                             = 'lucide/spline';
	case SPLIT                              = 'lucide/split';
	case SPOOL                              = 'lucide/spool';
	case SPOTLIGHT                          = 'lucide/spotlight';
	case SPRAY_CAN                          = 'lucide/spray-can';
	case SPROUT                             = 'lucide/sprout';
	case SQUARE_ACTIVITY                    = 'lucide/square-activity';
	case SQUARE_ARROW_DOWN_LEFT             = 'lucide/square-arrow-down-left';
	case SQUARE_ARROW_DOWN_RIGHT            = 'lucide/square-arrow-down-right';
	case SQUARE_ARROW_DOWN                  = 'lucide/square-arrow-down';
	case SQUARE_ARROW_LEFT                  = 'lucide/square-arrow-left';
	case SQUARE_ARROW_OUT_DOWN_LEFT         = 'lucide/square-arrow-out-down-left';
	case SQUARE_ARROW_OUT_DOWN_RIGHT        = 'lucide/square-arrow-out-down-right';
	case SQUARE_ARROW_OUT_UP_LEFT           = 'lucide/square-arrow-out-up-left';
	case SQUARE_ARROW_OUT_UP_RIGHT          = 'lucide/square-arrow-out-up-right';
	case SQUARE_ARROW_RIGHT                 = 'lucide/square-arrow-right';
	case SQUARE_ARROW_UP_LEFT               = 'lucide/square-arrow-up-left';
	case SQUARE_ARROW_UP_RIGHT              = 'lucide/square-arrow-up-right';
	case SQUARE_ARROW_UP                    = 'lucide/square-arrow-up';
	case SQUARE_ASTERISK                    = 'lucide/square-asterisk';
	case SQUARE_BOTTOM_DASHED_SCISSORS      = 'lucide/square-bottom-dashed-scissors';
	case SQUARE_CHART_GANTT                 = 'lucide/square-chart-gantt';
	case SQUARE_CHECK_BIG                   = 'lucide/square-check-big';
	case SQUARE_CHECK                       = 'lucide/square-check';
	case SQUARE_CHEVRON_DOWN                = 'lucide/square-chevron-down';
	case SQUARE_CHEVRON_LEFT                = 'lucide/square-chevron-left';
	case SQUARE_CHEVRON_RIGHT               = 'lucide/square-chevron-right';
	case SQUARE_CHEVRON_UP                  = 'lucide/square-chevron-up';
	case SQUARE_CODE                        = 'lucide/square-code';
	case SQUARE_DASHED_BOTTOM_CODE          = 'lucide/square-dashed-bottom-code';
	case SQUARE_DASHED_BOTTOM               = 'lucide/square-dashed-bottom';
	case SQUARE_DASHED_KANBAN               = 'lucide/square-dashed-kanban';
	case SQUARE_DASHED_MOUSE_POINTER        = 'lucide/square-dashed-mouse-pointer';
	case SQUARE_DASHED_TOP_SOLID            = 'lucide/square-dashed-top-solid';
	case SQUARE_DASHED                      = 'lucide/square-dashed';
	case SQUARE_DIVIDE                      = 'lucide/square-divide';
	case SQUARE_DOT                         = 'lucide/square-dot';
	case SQUARE_EQUAL                       = 'lucide/square-equal';
	case SQUARE_FUNCTION                    = 'lucide/square-function';
	case SQUARE_KANBAN                      = 'lucide/square-kanban';
	case SQUARE_LIBRARY                     = 'lucide/square-library';
	case SQUARE_M                           = 'lucide/square-m';
	case SQUARE_MENU                        = 'lucide/square-menu';
	case SQUARE_MINUS                       = 'lucide/square-minus';
	case SQUARE_MOUSE_POINTER               = 'lucide/square-mouse-pointer';
	case SQUARE_PARKING_OFF                 = 'lucide/square-parking-off';
	case SQUARE_PARKING                     = 'lucide/square-parking';
	case SQUARE_PAUSE                       = 'lucide/square-pause';
	case SQUARE_PEN                         = 'lucide/square-pen';
	case SQUARE_PERCENT                     = 'lucide/square-percent';
	case SQUARE_PI                          = 'lucide/square-pi';
	case SQUARE_PILCROW                     = 'lucide/square-pilcrow';
	case SQUARE_PLAY                        = 'lucide/square-play';
	case SQUARE_PLUS                        = 'lucide/square-plus';
	case SQUARE_POWER                       = 'lucide/square-power';
	case SQUARE_RADICAL                     = 'lucide/square-radical';
	case SQUARE_ROUND_CORNER                = 'lucide/square-round-corner';
	case SQUARE_SCISSORS                    = 'lucide/square-scissors';
	case SQUARE_SIGMA                       = 'lucide/square-sigma';
	case SQUARE_SLASH                       = 'lucide/square-slash';
	case SQUARE_SPLIT_HORIZONTAL            = 'lucide/square-split-horizontal';
	case SQUARE_SPLIT_VERTICAL              = 'lucide/square-split-vertical';
	case SQUARE_SQUARE                      = 'lucide/square-square';
	case SQUARE_STACK                       = 'lucide/square-stack';
	case SQUARE_STAR                        = 'lucide/square-star';
	case SQUARE_STOP                        = 'lucide/square-stop';
	case SQUARE_TERMINAL                    = 'lucide/square-terminal';
	case SQUARE_USER_ROUND                  = 'lucide/square-user-round';
	case SQUARE_USER                        = 'lucide/square-user';
	case SQUARE_X                           = 'lucide/square-x';
	case SQUARE                             = 'lucide/square';
	case SQUARES_EXCLUDE                    = 'lucide/squares-exclude';
	case SQUARES_INTERSECT                  = 'lucide/squares-intersect';
	case SQUARES_SUBTRACT                   = 'lucide/squares-subtract';
	case SQUARES_UNITE                      = 'lucide/squares-unite';
	case SQUIRCLE_DASHED                    = 'lucide/squircle-dashed';
	case SQUIRCLE                           = 'lucide/squircle';
	case SQUIRREL                           = 'lucide/squirrel';
	case STAMP                              = 'lucide/stamp';
	case STAR_HALF                          = 'lucide/star-half';
	case STAR_OFF                           = 'lucide/star-off';
	case STAR                               = 'lucide/star';
	case STEP_BACK                          = 'lucide/step-back';
	case STEP_FORWARD                       = 'lucide/step-forward';
	case STETHOSCOPE                        = 'lucide/stethoscope';
	case STICKER                            = 'lucide/sticker';
	case STICKY_NOTE                        = 'lucide/sticky-note';
	case STONE                              = 'lucide/stone';
	case STORE                              = 'lucide/store';
	case STRETCH_HORIZONTAL                 = 'lucide/stretch-horizontal';
	case STRETCH_VERTICAL                   = 'lucide/stretch-vertical';
	case STRIKETHROUGH                      = 'lucide/strikethrough';
	case SUBSCRIPT                          = 'lucide/subscript';
	case SUN_DIM                            = 'lucide/sun-dim';
	case SUN_MEDIUM                         = 'lucide/sun-medium';
	case SUN_MOON                           = 'lucide/sun-moon';
	case SUN_SNOW                           = 'lucide/sun-snow';
	case SUN                                = 'lucide/sun';
	case SUNRISE                            = 'lucide/sunrise';
	case SUNSET                             = 'lucide/sunset';
	case SUPERSCRIPT                        = 'lucide/superscript';
	case SWATCH_BOOK                        = 'lucide/swatch-book';
	case SWISS_FRANC                        = 'lucide/swiss-franc';
	case SWITCH_CAMERA                      = 'lucide/switch-camera';
	case SWORD                              = 'lucide/sword';
	case SWORDS                             = 'lucide/swords';
	case SYRINGE                            = 'lucide/syringe';
	case TABLE_2                            = 'lucide/table-2';
	case TABLE_CELLS_MERGE                  = 'lucide/table-cells-merge';
	case TABLE_CELLS_SPLIT                  = 'lucide/table-cells-split';
	case TABLE_COLUMNS_SPLIT                = 'lucide/table-columns-split';
	case TABLE_OF_CONTENTS                  = 'lucide/table-of-contents';
	case TABLE_PROPERTIES                   = 'lucide/table-properties';
	case TABLE_ROWS_SPLIT                   = 'lucide/table-rows-split';
	case TABLE                              = 'lucide/table';
	case TABLET_SMARTPHONE                  = 'lucide/tablet-smartphone';
	case TABLET                             = 'lucide/tablet';
	case TABLETS                            = 'lucide/tablets';
	case TAG                                = 'lucide/tag';
	case TAGS                               = 'lucide/tags';
	case TALLY_1                            = 'lucide/tally-1';
	case TALLY_2                            = 'lucide/tally-2';
	case TALLY_3                            = 'lucide/tally-3';
	case TALLY_4                            = 'lucide/tally-4';
	case TALLY_5                            = 'lucide/tally-5';
	case TANGENT                            = 'lucide/tangent';
	case TARGET                             = 'lucide/target';
	case TELESCOPE                          = 'lucide/telescope';
	case TENT_TREE                          = 'lucide/tent-tree';
	case TENT                               = 'lucide/tent';
	case TERMINAL                           = 'lucide/terminal';
	case TEST_TUBE_DIAGONAL                 = 'lucide/test-tube-diagonal';
	case TEST_TUBE                          = 'lucide/test-tube';
	case TEST_TUBES                         = 'lucide/test-tubes';
	case TEXT_ALIGN_CENTER                  = 'lucide/text-align-center';
	case TEXT_ALIGN_END                     = 'lucide/text-align-end';
	case TEXT_ALIGN_JUSTIFY                 = 'lucide/text-align-justify';
	case TEXT_ALIGN_START                   = 'lucide/text-align-start';
	case TEXT_CURSOR_INPUT                  = 'lucide/text-cursor-input';
	case TEXT_CURSOR                        = 'lucide/text-cursor';
	case TEXT_INITIAL                       = 'lucide/text-initial';
	case TEXT_QUOTE                         = 'lucide/text-quote';
	case TEXT_SEARCH                        = 'lucide/text-search';
	case TEXT_SELECT                        = 'lucide/text-select';
	case TEXT_WRAP                          = 'lucide/text-wrap';
	case THEATER                            = 'lucide/theater';
	case THERMOMETER_SNOWFLAKE              = 'lucide/thermometer-snowflake';
	case THERMOMETER_SUN                    = 'lucide/thermometer-sun';
	case THERMOMETER                        = 'lucide/thermometer';
	case THUMBS_DOWN                        = 'lucide/thumbs-down';
	case THUMBS_UP                          = 'lucide/thumbs-up';
	case TICKET_CHECK                       = 'lucide/ticket-check';
	case TICKET_MINUS                       = 'lucide/ticket-minus';
	case TICKET_PERCENT                     = 'lucide/ticket-percent';
	case TICKET_PLUS                        = 'lucide/ticket-plus';
	case TICKET_SLASH                       = 'lucide/ticket-slash';
	case TICKET_X                           = 'lucide/ticket-x';
	case TICKET                             = 'lucide/ticket';
	case TICKETS_PLANE                      = 'lucide/tickets-plane';
	case TICKETS                            = 'lucide/tickets';
	case TIMER_OFF                          = 'lucide/timer-off';
	case TIMER_RESET                        = 'lucide/timer-reset';
	case TIMER                              = 'lucide/timer';
	case TOGGLE_LEFT                        = 'lucide/toggle-left';
	case TOGGLE_RIGHT                       = 'lucide/toggle-right';
	case TOILET                             = 'lucide/toilet';
	case TOOL_CASE                          = 'lucide/tool-case';
	case TOOLBOX                            = 'lucide/toolbox';
	case TORNADO                            = 'lucide/tornado';
	case TORUS                              = 'lucide/torus';
	case TOUCHPAD_OFF                       = 'lucide/touchpad-off';
	case TOUCHPAD                           = 'lucide/touchpad';
	case TOWER_CONTROL                      = 'lucide/tower-control';
	case TOY_BRICK                          = 'lucide/toy-brick';
	case TRACTOR                            = 'lucide/tractor';
	case TRAFFIC_CONE                       = 'lucide/traffic-cone';
	case TRAIN_FRONT_TUNNEL                 = 'lucide/train-front-tunnel';
	case TRAIN_FRONT                        = 'lucide/train-front';
	case TRAIN_TRACK                        = 'lucide/train-track';
	case TRAM_FRONT                         = 'lucide/tram-front';
	case TRANSGENDER                        = 'lucide/transgender';
	case TRASH_2                            = 'lucide/trash-2';
	case TRASH                              = 'lucide/trash';
	case TREE_DECIDUOUS                     = 'lucide/tree-deciduous';
	case TREE_PALM                          = 'lucide/tree-palm';
	case TREE_PINE                          = 'lucide/tree-pine';
	case TREES                              = 'lucide/trees';
	case TRELLO                             = 'lucide/trello';
	case TRENDING_DOWN                      = 'lucide/trending-down';
	case TRENDING_UP_DOWN                   = 'lucide/trending-up-down';
	case TRENDING_UP                        = 'lucide/trending-up';
	case TRIANGLE_ALERT                     = 'lucide/triangle-alert';
	case TRIANGLE_DASHED                    = 'lucide/triangle-dashed';
	case TRIANGLE_RIGHT                     = 'lucide/triangle-right';
	case TRIANGLE                           = 'lucide/triangle';
	case TROPHY                             = 'lucide/trophy';
	case TRUCK_ELECTRIC                     = 'lucide/truck-electric';
	case TRUCK                              = 'lucide/truck';
	case TURKISH_LIRA                       = 'lucide/turkish-lira';
	case TURNTABLE                          = 'lucide/turntable';
	case TURTLE                             = 'lucide/turtle';
	case TV_MINIMAL_PLAY                    = 'lucide/tv-minimal-play';
	case TV_MINIMAL                         = 'lucide/tv-minimal';
	case TV                                 = 'lucide/tv';
	case TWITCH                             = 'lucide/twitch';
	case TWITTER                            = 'lucide/twitter';
	case TYPE_OUTLINE                       = 'lucide/type-outline';
	case TYPE                               = 'lucide/type';
	case UMBRELLA_OFF                       = 'lucide/umbrella-off';
	case UMBRELLA                           = 'lucide/umbrella';
	case UNDERLINE                          = 'lucide/underline';
	case UNDO_2                             = 'lucide/undo-2';
	case UNDO_DOT                           = 'lucide/undo-dot';
	case UNDO                               = 'lucide/undo';
	case UNFOLD_HORIZONTAL                  = 'lucide/unfold-horizontal';
	case UNFOLD_VERTICAL                    = 'lucide/unfold-vertical';
	case UNGROUP                            = 'lucide/ungroup';
	case UNIVERSITY                         = 'lucide/university';
	case UNLINK_2                           = 'lucide/unlink-2';
	case UNLINK                             = 'lucide/unlink';
	case UNPLUG                             = 'lucide/unplug';
	case UPLOAD                             = 'lucide/upload';
	case USB                                = 'lucide/usb';
	case USER_CHECK                         = 'lucide/user-check';
	case USER_COG                           = 'lucide/user-cog';
	case USER_LOCK                          = 'lucide/user-lock';
	case USER_MINUS                         = 'lucide/user-minus';
	case USER_PEN                           = 'lucide/user-pen';
	case USER_PLUS                          = 'lucide/user-plus';
	case USER_ROUND_CHECK                   = 'lucide/user-round-check';
	case USER_ROUND_COG                     = 'lucide/user-round-cog';
	case USER_ROUND_MINUS                   = 'lucide/user-round-minus';
	case USER_ROUND_PEN                     = 'lucide/user-round-pen';
	case USER_ROUND_PLUS                    = 'lucide/user-round-plus';
	case USER_ROUND_SEARCH                  = 'lucide/user-round-search';
	case USER_ROUND_X                       = 'lucide/user-round-x';
	case USER_ROUND                         = 'lucide/user-round';
	case USER_SEARCH                        = 'lucide/user-search';
	case USER_STAR                          = 'lucide/user-star';
	case USER_X                             = 'lucide/user-x';
	case USER                               = 'lucide/user';
	case USERS_ROUND                        = 'lucide/users-round';
	case USERS                              = 'lucide/users';
	case UTENSILS_CROSSED                   = 'lucide/utensils-crossed';
	case UTENSILS                           = 'lucide/utensils';
	case UTILITY_POLE                       = 'lucide/utility-pole';
	case VAN                                = 'lucide/van';
	case VARIABLE                           = 'lucide/variable';
	case VAULT                              = 'lucide/vault';
	case VECTOR_SQUARE                      = 'lucide/vector-square';
	case VEGAN                              = 'lucide/vegan';
	case VENETIAN_MASK                      = 'lucide/venetian-mask';
	case VENUS_AND_MARS                     = 'lucide/venus-and-mars';
	case VENUS                              = 'lucide/venus';
	case VIBRATE_OFF                        = 'lucide/vibrate-off';
	case VIBRATE                            = 'lucide/vibrate';
	case VIDEO_OFF                          = 'lucide/video-off';
	case VIDEO                              = 'lucide/video';
	case VIDEOTAPE                          = 'lucide/videotape';
	case VIEW                               = 'lucide/view';
	case VOICEMAIL                          = 'lucide/voicemail';
	case VOLLEYBALL                         = 'lucide/volleyball';
	case VOLUME_1                           = 'lucide/volume-1';
	case VOLUME_2                           = 'lucide/volume-2';
	case VOLUME_OFF                         = 'lucide/volume-off';
	case VOLUME_X                           = 'lucide/volume-x';
	case VOLUME                             = 'lucide/volume';
	case VOTE                               = 'lucide/vote';
	case WALLET_CARDS                       = 'lucide/wallet-cards';
	case WALLET_MINIMAL                     = 'lucide/wallet-minimal';
	case WALLET                             = 'lucide/wallet';
	case WALLPAPER                          = 'lucide/wallpaper';
	case WAND_SPARKLES                      = 'lucide/wand-sparkles';
	case WAND                               = 'lucide/wand';
	case WAREHOUSE                          = 'lucide/warehouse';
	case WASHING_MACHINE                    = 'lucide/washing-machine';
	case WATCH                              = 'lucide/watch';
	case WAVES_ARROW_DOWN                   = 'lucide/waves-arrow-down';
	case WAVES_ARROW_UP                     = 'lucide/waves-arrow-up';
	case WAVES_LADDER                       = 'lucide/waves-ladder';
	case WAVES                              = 'lucide/waves';
	case WAYPOINTS                          = 'lucide/waypoints';
	case WEBCAM                             = 'lucide/webcam';
	case WEBHOOK_OFF                        = 'lucide/webhook-off';
	case WEBHOOK                            = 'lucide/webhook';
	case WEIGHT_TILDE                       = 'lucide/weight-tilde';
	case WEIGHT                             = 'lucide/weight';
	case WHEAT_OFF                          = 'lucide/wheat-off';
	case WHEAT                              = 'lucide/wheat';
	case WHOLE_WORD                         = 'lucide/whole-word';
	case WIFI_COG                           = 'lucide/wifi-cog';
	case WIFI_HIGH                          = 'lucide/wifi-high';
	case WIFI_LOW                           = 'lucide/wifi-low';
	case WIFI_OFF                           = 'lucide/wifi-off';
	case WIFI_PEN                           = 'lucide/wifi-pen';
	case WIFI_SYNC                          = 'lucide/wifi-sync';
	case WIFI_ZERO                          = 'lucide/wifi-zero';
	case WIFI                               = 'lucide/wifi';
	case WIND_ARROW_DOWN                    = 'lucide/wind-arrow-down';
	case WIND                               = 'lucide/wind';
	case WINE_OFF                           = 'lucide/wine-off';
	case WINE                               = 'lucide/wine';
	case WORKFLOW                           = 'lucide/workflow';
	case WORM                               = 'lucide/worm';
	case WRENCH                             = 'lucide/wrench';
	case X                                  = 'lucide/x';
	case YOUTUBE                            = 'lucide/youtube';
	case ZAP_OFF                            = 'lucide/zap-off';
	case ZAP                                = 'lucide/zap';
	case ZOOM_IN                            = 'lucide/zoom-in';
	case ZOOM_OUT                           = 'lucide/zoom-out';

	/** @var array<string, string> */
	protected const array ICONS = [
		'a-arrow-down'                       => '<path d="m14 12 4 4 4-4"></path><path d="M18 16V7"></path><path d="m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16"></path><path d="M3.304 13h6.392"></path>',
		'a-arrow-up'                         => '<path d="m14 11 4-4 4 4"></path><path d="M18 16V7"></path><path d="m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16"></path><path d="M3.304 13h6.392"></path>',
		'a-large-small'                      => '<path d="m15 16 2.536-7.328a1.02 1.02 1 0 1 1.928 0L22 16"></path><path d="M15.697 14h5.606"></path><path d="m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16"></path><path d="M3.304 13h6.392"></path>',
		'accessibility'                      => '<circle cx="16" cy="4" r="1"></circle><path d="m18 19 1-7-6 1"></path><path d="m5 8 3-3 5.5 3-2.36 3.5"></path><path d="M4.24 14.5a5 5 0 0 0 6.88 6"></path><path d="M13.76 17.5a5 5 0 0 0-6.88-6"></path>',
		'activity'                           => '<path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"></path>',
		'air-vent'                           => '<path d="M18 17.5a2.5 2.5 0 1 1-4 2.03V12"></path><path d="M6 12H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><path d="M6 8h12"></path><path d="M6.6 15.572A2 2 0 1 0 10 17v-5"></path>',
		'airplay'                            => '<path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><path d="m12 15 5 6H7Z"></path>',
		'alarm-clock-check'                  => '<circle cx="12" cy="13" r="8"></circle><path d="M5 3 2 6"></path><path d="m22 6-3-3"></path><path d="M6.38 18.7 4 21"></path><path d="M17.64 18.67 20 21"></path><path d="m9 13 2 2 4-4"></path>',
		'alarm-clock-minus'                  => '<circle cx="12" cy="13" r="8"></circle><path d="M5 3 2 6"></path><path d="m22 6-3-3"></path><path d="M6.38 18.7 4 21"></path><path d="M17.64 18.67 20 21"></path><path d="M9 13h6"></path>',
		'alarm-clock-off'                    => '<path d="M6.87 6.87a8 8 0 1 0 11.26 11.26"></path><path d="M19.9 14.25a8 8 0 0 0-9.15-9.15"></path><path d="m22 6-3-3"></path><path d="M6.26 18.67 4 21"></path><path d="m2 2 20 20"></path><path d="M4 4 2 6"></path>',
		'alarm-clock-plus'                   => '<circle cx="12" cy="13" r="8"></circle><path d="M5 3 2 6"></path><path d="m22 6-3-3"></path><path d="M6.38 18.7 4 21"></path><path d="M17.64 18.67 20 21"></path><path d="M12 10v6"></path><path d="M9 13h6"></path>',
		'alarm-clock'                        => '<circle cx="12" cy="13" r="8"></circle><path d="M12 9v4l2 2"></path><path d="M5 3 2 6"></path><path d="m22 6-3-3"></path><path d="M6.38 18.7 4 21"></path><path d="M17.64 18.67 20 21"></path>',
		'alarm-smoke'                        => '<path d="M11 21c0-2.5 2-2.5 2-5"></path><path d="M16 21c0-2.5 2-2.5 2-5"></path><path d="m19 8-.8 3a1.25 1.25 0 0 1-1.2 1H7a1.25 1.25 0 0 1-1.2-1L5 8"></path><path d="M21 3a1 1 0 0 1 1 1v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a1 1 0 0 1 1-1z"></path><path d="M6 21c0-2.5 2-2.5 2-5"></path>',
		'album'                              => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><polyline points="11 3 11 11 14 8 17 11 17 3"></polyline>',
		'align-center-horizontal'            => '<path d="M2 12h20"></path><path d="M10 16v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4"></path><path d="M10 8V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"></path><path d="M20 16v1a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-1"></path><path d="M14 8V7c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v1"></path>',
		'align-center-vertical'              => '<path d="M12 2v20"></path><path d="M8 10H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h4"></path><path d="M16 10h4a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-4"></path><path d="M8 20H7a2 2 0 0 1-2-2v-2c0-1.1.9-2 2-2h1"></path><path d="M16 14h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1"></path>',
		'align-end-horizontal'               => '<rect width="6" height="16" x="4" y="2" rx="2"></rect><rect width="6" height="9" x="14" y="9" rx="2"></rect><path d="M22 22H2"></path>',
		'align-end-vertical'                 => '<rect width="16" height="6" x="2" y="4" rx="2"></rect><rect width="9" height="6" x="9" y="14" rx="2"></rect><path d="M22 22V2"></path>',
		'align-horizontal-distribute-center' => '<rect width="6" height="14" x="4" y="5" rx="2"></rect><rect width="6" height="10" x="14" y="7" rx="2"></rect><path d="M17 22v-5"></path><path d="M17 7V2"></path><path d="M7 22v-3"></path><path d="M7 5V2"></path>',
		'align-horizontal-distribute-end'    => '<rect width="6" height="14" x="4" y="5" rx="2"></rect><rect width="6" height="10" x="14" y="7" rx="2"></rect><path d="M10 2v20"></path><path d="M20 2v20"></path>',
		'align-horizontal-distribute-start'  => '<rect width="6" height="14" x="4" y="5" rx="2"></rect><rect width="6" height="10" x="14" y="7" rx="2"></rect><path d="M4 2v20"></path><path d="M14 2v20"></path>',
		'align-horizontal-justify-center'    => '<rect width="6" height="14" x="2" y="5" rx="2"></rect><rect width="6" height="10" x="16" y="7" rx="2"></rect><path d="M12 2v20"></path>',
		'align-horizontal-justify-end'       => '<rect width="6" height="14" x="2" y="5" rx="2"></rect><rect width="6" height="10" x="12" y="7" rx="2"></rect><path d="M22 2v20"></path>',
		'align-horizontal-justify-start'     => '<rect width="6" height="14" x="6" y="5" rx="2"></rect><rect width="6" height="10" x="16" y="7" rx="2"></rect><path d="M2 2v20"></path>',
		'align-horizontal-space-around'      => '<rect width="6" height="10" x="9" y="7" rx="2"></rect><path d="M4 22V2"></path><path d="M20 22V2"></path>',
		'align-horizontal-space-between'     => '<rect width="6" height="14" x="3" y="5" rx="2"></rect><rect width="6" height="10" x="15" y="7" rx="2"></rect><path d="M3 2v20"></path><path d="M21 2v20"></path>',
		'align-start-horizontal'             => '<rect width="6" height="16" x="4" y="6" rx="2"></rect><rect width="6" height="9" x="14" y="6" rx="2"></rect><path d="M22 2H2"></path>',
		'align-start-vertical'               => '<rect width="9" height="6" x="6" y="14" rx="2"></rect><rect width="16" height="6" x="6" y="4" rx="2"></rect><path d="M2 2v20"></path>',
		'align-vertical-distribute-center'   => '<path d="M22 17h-3"></path><path d="M22 7h-5"></path><path d="M5 17H2"></path><path d="M7 7H2"></path><rect x="5" y="14" width="14" height="6" rx="2"></rect><rect x="7" y="4" width="10" height="6" rx="2"></rect>',
		'align-vertical-distribute-end'      => '<rect width="14" height="6" x="5" y="14" rx="2"></rect><rect width="10" height="6" x="7" y="4" rx="2"></rect><path d="M2 20h20"></path><path d="M2 10h20"></path>',
		'align-vertical-distribute-start'    => '<rect width="14" height="6" x="5" y="14" rx="2"></rect><rect width="10" height="6" x="7" y="4" rx="2"></rect><path d="M2 14h20"></path><path d="M2 4h20"></path>',
		'align-vertical-justify-center'      => '<rect width="14" height="6" x="5" y="16" rx="2"></rect><rect width="10" height="6" x="7" y="2" rx="2"></rect><path d="M2 12h20"></path>',
		'align-vertical-justify-end'         => '<rect width="14" height="6" x="5" y="12" rx="2"></rect><rect width="10" height="6" x="7" y="2" rx="2"></rect><path d="M2 22h20"></path>',
		'align-vertical-justify-start'       => '<rect width="14" height="6" x="5" y="16" rx="2"></rect><rect width="10" height="6" x="7" y="6" rx="2"></rect><path d="M2 2h20"></path>',
		'align-vertical-space-around'        => '<rect width="10" height="6" x="7" y="9" rx="2"></rect><path d="M22 20H2"></path><path d="M22 4H2"></path>',
		'align-vertical-space-between'       => '<rect width="14" height="6" x="5" y="15" rx="2"></rect><rect width="10" height="6" x="7" y="3" rx="2"></rect><path d="M2 21h20"></path><path d="M2 3h20"></path>',
		'ambulance'                          => '<path d="M10 10H6"></path><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"></path><path d="M8 8v4"></path><path d="M9 18h6"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle>',
		'ampersand'                          => '<path d="M16 12h3"></path><path d="M17.5 12a8 8 0 0 1-8 8A4.5 4.5 0 0 1 5 15.5c0-6 8-4 8-8.5a3 3 0 1 0-6 0c0 3 2.5 8.5 12 13"></path>',
		'ampersands'                         => '<path d="M10 17c-5-3-7-7-7-9a2 2 0 0 1 4 0c0 2.5-5 2.5-5 6 0 1.7 1.3 3 3 3 2.8 0 5-2.2 5-5"></path><path d="M22 17c-5-3-7-7-7-9a2 2 0 0 1 4 0c0 2.5-5 2.5-5 6 0 1.7 1.3 3 3 3 2.8 0 5-2.2 5-5"></path>',
		'amphora'                            => '<path d="M10 2v5.632c0 .424-.272.795-.653.982A6 6 0 0 0 6 14c.006 4 3 7 5 8"></path><path d="M10 5H8a2 2 0 0 0 0 4h.68"></path><path d="M14 2v5.632c0 .424.272.795.652.982A6 6 0 0 1 18 14c0 4-3 7-5 8"></path><path d="M14 5h2a2 2 0 0 1 0 4h-.68"></path><path d="M18 22H6"></path><path d="M9 2h6"></path>',
		'anchor'                             => '<path d="M12 6v16"></path><path d="m19 13 2-1a9 9 0 0 1-18 0l2 1"></path><path d="M9 11h6"></path><circle cx="12" cy="4" r="2"></circle>',
		'angry'                              => '<circle cx="12" cy="12" r="10"></circle><path d="M16 16s-1.5-2-4-2-4 2-4 2"></path><path d="M7.5 8 10 9"></path><path d="m14 9 2.5-1"></path><path d="M9 10h.01"></path><path d="M15 10h.01"></path>',
		'annoyed'                            => '<circle cx="12" cy="12" r="10"></circle><path d="M8 15h8"></path><path d="M8 9h2"></path><path d="M14 9h2"></path>',
		'antenna'                            => '<path d="M2 12 7 2"></path><path d="m7 12 5-10"></path><path d="m12 12 5-10"></path><path d="m17 12 5-10"></path><path d="M4.5 7h15"></path><path d="M12 16v6"></path>',
		'anvil'                              => '<path d="M7 10H6a4 4 0 0 1-4-4 1 1 0 0 1 1-1h4"></path><path d="M7 5a1 1 0 0 1 1-1h13a1 1 0 0 1 1 1 7 7 0 0 1-7 7H8a1 1 0 0 1-1-1z"></path><path d="M9 12v5"></path><path d="M15 12v5"></path><path d="M5 20a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3 1 1 0 0 1-1 1H6a1 1 0 0 1-1-1"></path>',
		'aperture'                           => '<circle cx="12" cy="12" r="10"></circle><path d="m14.31 8 5.74 9.94"></path><path d="M9.69 8h11.48"></path><path d="m7.38 12 5.74-9.94"></path><path d="M9.69 16 3.95 6.06"></path><path d="M14.31 16H2.83"></path><path d="m16.62 12-5.74 9.94"></path>',
		'app-window-mac'                     => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="M6 8h.01"></path><path d="M10 8h.01"></path><path d="M14 8h.01"></path>',
		'app-window'                         => '<rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M10 4v4"></path><path d="M2 8h20"></path><path d="M6 4v4"></path>',
		'apple'                              => '<path d="M12 6.528V3a1 1 0 0 1 1-1h0"></path><path d="M18.237 21A15 15 0 0 0 22 11a6 6 0 0 0-10-4.472A6 6 0 0 0 2 11a15.1 15.1 0 0 0 3.763 10 3 3 0 0 0 3.648.648 5.5 5.5 0 0 1 5.178 0A3 3 0 0 0 18.237 21"></path>',
		'archive-restore'                    => '<rect width="20" height="5" x="2" y="3" rx="1"></rect><path d="M4 8v11a2 2 0 0 0 2 2h2"></path><path d="M20 8v11a2 2 0 0 1-2 2h-2"></path><path d="m9 15 3-3 3 3"></path><path d="M12 12v9"></path>',
		'archive-x'                          => '<rect width="20" height="5" x="2" y="3" rx="1"></rect><path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"></path><path d="m9.5 17 5-5"></path><path d="m9.5 12 5 5"></path>',
		'archive'                            => '<rect width="20" height="5" x="2" y="3" rx="1"></rect><path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"></path><path d="M10 12h4"></path>',
		'armchair'                           => '<path d="M19 9V6a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v3"></path><path d="M3 16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V11a2 2 0 0 0-4 0z"></path><path d="M5 18v2"></path><path d="M19 18v2"></path>',
		'arrow-big-down-dash'                => '<path d="M15 11a1 1 0 0 0 1 1h2.939a1 1 0 0 1 .75 1.811l-6.835 6.836a1.207 1.207 0 0 1-1.707 0L4.31 13.81a1 1 0 0 1 .75-1.811H8a1 1 0 0 0 1-1V9a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1z"></path><path d="M9 4h6"></path>',
		'arrow-big-down'                     => '<path d="M15 11a1 1 0 0 0 1 1h2.939a1 1 0 0 1 .75 1.811l-6.835 6.836a1.207 1.207 0 0 1-1.707 0L4.31 13.81a1 1 0 0 1 .75-1.811H8a1 1 0 0 0 1-1V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1z"></path>',
		'arrow-big-left-dash'                => '<path d="M13 9a1 1 0 0 1-1-1V5.061a1 1 0 0 0-1.811-.75l-6.835 6.836a1.207 1.207 0 0 0 0 1.707l6.835 6.835a1 1 0 0 0 1.811-.75V16a1 1 0 0 1 1-1h2a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1z"></path><path d="M20 9v6"></path>',
		'arrow-big-left'                     => '<path d="M13 9a1 1 0 0 1-1-1V5.061a1 1 0 0 0-1.811-.75l-6.835 6.836a1.207 1.207 0 0 0 0 1.707l6.835 6.835a1 1 0 0 0 1.811-.75V16a1 1 0 0 1 1-1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1z"></path>',
		'arrow-big-right-dash'               => '<path d="M11 9a1 1 0 0 0 1-1V5.061a1 1 0 0 1 1.811-.75l6.836 6.836a1.207 1.207 0 0 1 0 1.707l-6.836 6.835a1 1 0 0 1-1.811-.75V16a1 1 0 0 0-1-1H9a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1z"></path><path d="M4 9v6"></path>',
		'arrow-big-right'                    => '<path d="M11 9a1 1 0 0 0 1-1V5.061a1 1 0 0 1 1.811-.75l6.836 6.836a1.207 1.207 0 0 1 0 1.707l-6.836 6.835a1 1 0 0 1-1.811-.75V16a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1z"></path>',
		'arrow-big-up-dash'                  => '<path d="M9 13a1 1 0 0 0-1-1H5.061a1 1 0 0 1-.75-1.811l6.836-6.835a1.207 1.207 0 0 1 1.707 0l6.835 6.835a1 1 0 0 1-.75 1.811H16a1 1 0 0 0-1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z"></path><path d="M9 20h6"></path>',
		'arrow-big-up'                       => '<path d="M9 13a1 1 0 0 0-1-1H5.061a1 1 0 0 1-.75-1.811l6.836-6.835a1.207 1.207 0 0 1 1.707 0l6.835 6.835a1 1 0 0 1-.75 1.811H16a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z"></path>',
		'arrow-down-0-1'                     => '<path d="m3 16 4 4 4-4"></path><path d="M7 20V4"></path><rect x="15" y="4" width="4" height="6" ry="2"></rect><path d="M17 20v-6h-2"></path><path d="M15 20h4"></path>',
		'arrow-down-1-0'                     => '<path d="m3 16 4 4 4-4"></path><path d="M7 20V4"></path><path d="M17 10V4h-2"></path><path d="M15 10h4"></path><rect x="15" y="14" width="4" height="6" ry="2"></rect>',
		'arrow-down-a-z'                     => '<path d="m3 16 4 4 4-4"></path><path d="M7 20V4"></path><path d="M20 8h-5"></path><path d="M15 10V6.5a2.5 2.5 0 0 1 5 0V10"></path><path d="M15 14h5l-5 6h5"></path>',
		'arrow-down-from-line'               => '<path d="M19 3H5"></path><path d="M12 21V7"></path><path d="m6 15 6 6 6-6"></path>',
		'arrow-down-left'                    => '<path d="M17 7 7 17"></path><path d="M17 17H7V7"></path>',
		'arrow-down-narrow-wide'             => '<path d="m3 16 4 4 4-4"></path><path d="M7 20V4"></path><path d="M11 4h4"></path><path d="M11 8h7"></path><path d="M11 12h10"></path>',
		'arrow-down-right'                   => '<path d="m7 7 10 10"></path><path d="M17 7v10H7"></path>',
		'arrow-down-to-dot'                  => '<path d="M12 2v14"></path><path d="m19 9-7 7-7-7"></path><circle cx="12" cy="21" r="1"></circle>',
		'arrow-down-to-line'                 => '<path d="M12 17V3"></path><path d="m6 11 6 6 6-6"></path><path d="M19 21H5"></path>',
		'arrow-down-up'                      => '<path d="m3 16 4 4 4-4"></path><path d="M7 20V4"></path><path d="m21 8-4-4-4 4"></path><path d="M17 4v16"></path>',
		'arrow-down-wide-narrow'             => '<path d="m3 16 4 4 4-4"></path><path d="M7 20V4"></path><path d="M11 4h10"></path><path d="M11 8h7"></path><path d="M11 12h4"></path>',
		'arrow-down-z-a'                     => '<path d="m3 16 4 4 4-4"></path><path d="M7 4v16"></path><path d="M15 4h5l-5 6h5"></path><path d="M15 20v-3.5a2.5 2.5 0 0 1 5 0V20"></path><path d="M20 18h-5"></path>',
		'arrow-down'                         => '<path d="M12 5v14"></path><path d="m19 12-7 7-7-7"></path>',
		'arrow-left-from-line'               => '<path d="m9 6-6 6 6 6"></path><path d="M3 12h14"></path><path d="M21 19V5"></path>',
		'arrow-left-right'                   => '<path d="M8 3 4 7l4 4"></path><path d="M4 7h16"></path><path d="m16 21 4-4-4-4"></path><path d="M20 17H4"></path>',
		'arrow-left-to-line'                 => '<path d="M3 19V5"></path><path d="m13 6-6 6 6 6"></path><path d="M7 12h14"></path>',
		'arrow-left'                         => '<path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path>',
		'arrow-right-from-line'              => '<path d="M3 5v14"></path><path d="M21 12H7"></path><path d="m15 18 6-6-6-6"></path>',
		'arrow-right-left'                   => '<path d="m16 3 4 4-4 4"></path><path d="M20 7H4"></path><path d="m8 21-4-4 4-4"></path><path d="M4 17h16"></path>',
		'arrow-right-to-line'                => '<path d="M17 12H3"></path><path d="m11 18 6-6-6-6"></path><path d="M21 5v14"></path>',
		'arrow-right'                        => '<path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>',
		'arrow-up-0-1'                       => '<path d="m3 8 4-4 4 4"></path><path d="M7 4v16"></path><rect x="15" y="4" width="4" height="6" ry="2"></rect><path d="M17 20v-6h-2"></path><path d="M15 20h4"></path>',
		'arrow-up-1-0'                       => '<path d="m3 8 4-4 4 4"></path><path d="M7 4v16"></path><path d="M17 10V4h-2"></path><path d="M15 10h4"></path><rect x="15" y="14" width="4" height="6" ry="2"></rect>',
		'arrow-up-a-z'                       => '<path d="m3 8 4-4 4 4"></path><path d="M7 4v16"></path><path d="M20 8h-5"></path><path d="M15 10V6.5a2.5 2.5 0 0 1 5 0V10"></path><path d="M15 14h5l-5 6h5"></path>',
		'arrow-up-down'                      => '<path d="m21 16-4 4-4-4"></path><path d="M17 20V4"></path><path d="m3 8 4-4 4 4"></path><path d="M7 4v16"></path>',
		'arrow-up-from-dot'                  => '<path d="m5 9 7-7 7 7"></path><path d="M12 16V2"></path><circle cx="12" cy="21" r="1"></circle>',
		'arrow-up-from-line'                 => '<path d="m18 9-6-6-6 6"></path><path d="M12 3v14"></path><path d="M5 21h14"></path>',
		'arrow-up-left'                      => '<path d="M7 17V7h10"></path><path d="M17 17 7 7"></path>',
		'arrow-up-narrow-wide'               => '<path d="m3 8 4-4 4 4"></path><path d="M7 4v16"></path><path d="M11 12h4"></path><path d="M11 16h7"></path><path d="M11 20h10"></path>',
		'arrow-up-right'                     => '<path d="M7 7h10v10"></path><path d="M7 17 17 7"></path>',
		'arrow-up-to-line'                   => '<path d="M5 3h14"></path><path d="m18 13-6-6-6 6"></path><path d="M12 7v14"></path>',
		'arrow-up-wide-narrow'               => '<path d="m3 8 4-4 4 4"></path><path d="M7 4v16"></path><path d="M11 12h10"></path><path d="M11 16h7"></path><path d="M11 20h4"></path>',
		'arrow-up-z-a'                       => '<path d="m3 8 4-4 4 4"></path><path d="M7 4v16"></path><path d="M15 4h5l-5 6h5"></path><path d="M15 20v-3.5a2.5 2.5 0 0 1 5 0V20"></path><path d="M20 18h-5"></path>',
		'arrow-up'                           => '<path d="m5 12 7-7 7 7"></path><path d="M12 19V5"></path>',
		'arrows-up-from-line'                => '<path d="m4 6 3-3 3 3"></path><path d="M7 17V3"></path><path d="m14 6 3-3 3 3"></path><path d="M17 17V3"></path><path d="M4 21h16"></path>',
		'asterisk'                           => '<path d="M12 6v12"></path><path d="M17.196 9 6.804 15"></path><path d="m6.804 9 10.392 6"></path>',
		'at-sign'                            => '<circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"></path>',
		'atom'                               => '<circle cx="12" cy="12" r="1"></circle><path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path><path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>',
		'audio-lines'                        => '<path d="M2 10v3"></path><path d="M6 6v11"></path><path d="M10 3v18"></path><path d="M14 8v7"></path><path d="M18 5v13"></path><path d="M22 10v3"></path>',
		'audio-waveform'                     => '<path d="M2 13a2 2 0 0 0 2-2V7a2 2 0 0 1 4 0v13a2 2 0 0 0 4 0V4a2 2 0 0 1 4 0v13a2 2 0 0 0 4 0v-4a2 2 0 0 1 2-2"></path>',
		'award'                              => '<path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle>',
		'axe'                                => '<path d="m14 12-8.381 8.38a1 1 0 0 1-3.001-3L11 9"></path><path d="M15 15.5a.5.5 0 0 0 .5.5A6.5 6.5 0 0 0 22 9.5a.5.5 0 0 0-.5-.5h-1.672a2 2 0 0 1-1.414-.586l-5.062-5.062a1.205 1.205 0 0 0-1.704 0L9.352 5.648a1.205 1.205 0 0 0 0 1.704l5.062 5.062A2 2 0 0 1 15 13.828z"></path>',
		'axis-3d'                            => '<path d="M13.5 10.5 15 9"></path><path d="M4 4v15a1 1 0 0 0 1 1h15"></path><path d="M4.293 19.707 6 18"></path><path d="m9 15 1.5-1.5"></path>',
		'baby'                               => '<path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"></path><path d="M15 12h.01"></path><path d="M19.38 6.813A9 9 0 0 1 20.8 10.2a2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"></path><path d="M9 12h.01"></path>',
		'backpack'                           => '<path d="M4 10a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path><path d="M8 10h8"></path><path d="M8 18h8"></path><path d="M8 22v-6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6"></path><path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>',
		'badge-alert'                        => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line>',
		'badge-cent'                         => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="M12 7v10"></path><path d="M15.4 10a4 4 0 1 0 0 4"></path>',
		'badge-check'                        => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="m9 12 2 2 4-4"></path>',
		'badge-dollar-sign'                  => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path><path d="M12 18V6"></path>',
		'badge-euro'                         => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="M7 12h5"></path><path d="M15 9.4a4 4 0 1 0 0 5.2"></path>',
		'badge-indian-rupee'                 => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="M8 8h8"></path><path d="M8 12h8"></path><path d="m13 17-5-1h1a4 4 0 0 0 0-8"></path>',
		'badge-info'                         => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><line x1="12" x2="12" y1="16" y2="12"></line><line x1="12" x2="12.01" y1="8" y2="8"></line>',
		'badge-japanese-yen'                 => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="m9 8 3 3v7"></path><path d="m12 11 3-3"></path><path d="M9 12h6"></path><path d="M9 16h6"></path>',
		'badge-minus'                        => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><line x1="8" x2="16" y1="12" y2="12"></line>',
		'badge-percent'                      => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="m15 9-6 6"></path><path d="M9 9h.01"></path><path d="M15 15h.01"></path>',
		'badge-plus'                         => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><line x1="12" x2="12" y1="8" y2="16"></line><line x1="8" x2="16" y1="12" y2="12"></line>',
		'badge-pound-sterling'               => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="M8 12h4"></path><path d="M10 16V9.5a2.5 2.5 0 0 1 5 0"></path><path d="M8 16h7"></path>',
		'badge-question-mark'                => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" x2="12.01" y1="17" y2="17"></line>',
		'badge-russian-ruble'                => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="M9 16h5"></path><path d="M9 12h5a2 2 0 1 0 0-4h-3v9"></path>',
		'badge-swiss-franc'                  => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="M11 17V8h4"></path><path d="M11 12h3"></path><path d="M9 16h4"></path>',
		'badge-turkish-lira'                 => '<path d="M11 7v10a5 5 0 0 0 5-5"></path><path d="m15 8-6 3"></path><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76"></path>',
		'badge-x'                            => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><line x1="15" x2="9" y1="9" y2="15"></line><line x1="9" x2="15" y1="9" y2="15"></line>',
		'badge'                              => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path>',
		'baggage-claim'                      => '<path d="M22 18H6a2 2 0 0 1-2-2V7a2 2 0 0 0-2-2"></path><path d="M17 14V4a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v10"></path><rect width="13" height="8" x="8" y="6" rx="1"></rect><circle cx="18" cy="20" r="2"></circle><circle cx="9" cy="20" r="2"></circle>',
		'balloon'                            => '<path d="M12 16v1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v1"></path><path d="M12 6a2 2 0 0 1 2 2"></path><path d="M18 8c0 4-3.5 8-6 8s-6-4-6-8a6 6 0 0 1 12 0"></path>',
		'ban'                                => '<path d="M4.929 4.929 19.07 19.071"></path><circle cx="12" cy="12" r="10"></circle>',
		'banana'                             => '<path d="M4 13c3.5-2 8-2 10 2a5.5 5.5 0 0 1 8 5"></path><path d="M5.15 17.89c5.52-1.52 8.65-6.89 7-12C11.55 4 11.5 2 13 2c3.22 0 5 5.5 5 8 0 6.5-4.2 12-10.49 12C5.11 22 2 22 2 20c0-1.5 1.14-1.55 3.15-2.11Z"></path>',
		'bandage'                            => '<path d="M10 10.01h.01"></path><path d="M10 14.01h.01"></path><path d="M14 10.01h.01"></path><path d="M14 14.01h.01"></path><path d="M18 6v11.5"></path><path d="M6 6v12"></path><rect x="2" y="6" width="20" height="12" rx="2"></rect>',
		'banknote-arrow-down'                => '<path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5"></path><path d="m16 19 3 3 3-3"></path><path d="M18 12h.01"></path><path d="M19 16v6"></path><path d="M6 12h.01"></path><circle cx="12" cy="12" r="2"></circle>',
		'banknote-arrow-up'                  => '<path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5"></path><path d="M18 12h.01"></path><path d="M19 22v-6"></path><path d="m22 19-3-3-3 3"></path><path d="M6 12h.01"></path><circle cx="12" cy="12" r="2"></circle>',
		'banknote-x'                         => '<path d="M13 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5"></path><path d="m17 17 5 5"></path><path d="M18 12h.01"></path><path d="m22 17-5 5"></path><path d="M6 12h.01"></path><circle cx="12" cy="12" r="2"></circle>',
		'banknote'                           => '<rect width="20" height="12" x="2" y="6" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path>',
		'barcode'                            => '<path d="M3 5v14"></path><path d="M8 5v14"></path><path d="M12 5v14"></path><path d="M17 5v14"></path><path d="M21 5v14"></path>',
		'barrel'                             => '<path d="M10 3a41 41 0 0 0 0 18"></path><path d="M14 3a41 41 0 0 1 0 18"></path><path d="M17 3a2 2 0 0 1 1.68.92 15.25 15.25 0 0 1 0 16.16A2 2 0 0 1 17 21H7a2 2 0 0 1-1.68-.92 15.25 15.25 0 0 1 0-16.16A2 2 0 0 1 7 3z"></path><path d="M3.84 17h16.32"></path><path d="M3.84 7h16.32"></path>',
		'baseline'                           => '<path d="M4 20h16"></path><path d="m6 16 6-12 6 12"></path><path d="M8 12h8"></path>',
		'bath'                               => '<path d="M10 4 8 6"></path><path d="M17 19v2"></path><path d="M2 12h20"></path><path d="M7 19v2"></path><path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"></path>',
		'battery-charging'                   => '<path d="m11 7-3 5h4l-3 5"></path><path d="M14.856 6H16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.935"></path><path d="M22 14v-4"></path><path d="M5.14 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2.936"></path>',
		'battery-full'                       => '<path d="M10 10v4"></path><path d="M14 10v4"></path><path d="M22 14v-4"></path><path d="M6 10v4"></path><rect x="2" y="6" width="16" height="12" rx="2"></rect>',
		'battery-low'                        => '<path d="M22 14v-4"></path><path d="M6 14v-4"></path><rect x="2" y="6" width="16" height="12" rx="2"></rect>',
		'battery-medium'                     => '<path d="M10 14v-4"></path><path d="M22 14v-4"></path><path d="M6 14v-4"></path><rect x="2" y="6" width="16" height="12" rx="2"></rect>',
		'battery-plus'                       => '<path d="M10 9v6"></path><path d="M12.543 6H16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-3.605"></path><path d="M22 14v-4"></path><path d="M7 12h6"></path><path d="M7.606 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3.606"></path>',
		'battery-warning'                    => '<path d="M10 17h.01"></path><path d="M10 7v6"></path><path d="M14 6h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2"></path><path d="M22 14v-4"></path><path d="M6 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2"></path>',
		'battery'                            => '<path d="M 22 14 L 22 10"></path><rect x="2" y="6" width="16" height="12" rx="2"></rect>',
		'beaker'                             => '<path d="M4.5 3h15"></path><path d="M6 3v16a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V3"></path><path d="M6 14h12"></path>',
		'bean-off'                           => '<path d="M9 9c-.64.64-1.521.954-2.402 1.165A6 6 0 0 0 8 22a13.96 13.96 0 0 0 9.9-4.1"></path><path d="M10.75 5.093A6 6 0 0 1 22 8c0 2.411-.61 4.68-1.683 6.66"></path><path d="M5.341 10.62a4 4 0 0 0 6.487 1.208M10.62 5.341a4.015 4.015 0 0 1 2.039 2.04"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'bean'                               => '<path d="M10.165 6.598C9.954 7.478 9.64 8.36 9 9c-.64.64-1.521.954-2.402 1.165A6 6 0 0 0 8 22c7.732 0 14-6.268 14-14a6 6 0 0 0-11.835-1.402Z"></path><path d="M5.341 10.62a4 4 0 1 0 5.279-5.28"></path>',
		'bed-double'                         => '<path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"></path><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"></path><path d="M12 4v6"></path><path d="M2 18h20"></path>',
		'bed-single'                         => '<path d="M3 20v-8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8"></path><path d="M5 10V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4"></path><path d="M3 18h18"></path>',
		'bed'                                => '<path d="M2 4v16"></path><path d="M2 8h18a2 2 0 0 1 2 2v10"></path><path d="M2 17h20"></path><path d="M6 8v9"></path>',
		'beef'                               => '<path d="M16.4 13.7A6.5 6.5 0 1 0 6.28 6.6c-1.1 3.13-.78 3.9-3.18 6.08A3 3 0 0 0 5 18c4 0 8.4-1.8 11.4-4.3"></path><path d="m18.5 6 2.19 4.5a6.48 6.48 0 0 1-2.29 7.2C15.4 20.2 11 22 7 22a3 3 0 0 1-2.68-1.66L2.4 16.5"></path><circle cx="12.5" cy="8.5" r="2.5"></circle>',
		'beer-off'                           => '<path d="M13 13v5"></path><path d="M17 11.47V8"></path><path d="M17 11h1a3 3 0 0 1 2.745 4.211"></path><path d="m2 2 20 20"></path><path d="M5 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3"></path><path d="M7.536 7.535C6.766 7.649 6.154 8 5.5 8a2.5 2.5 0 0 1-1.768-4.268"></path><path d="M8.727 3.204C9.306 2.767 9.885 2 11 2c1.56 0 2 1.5 3 1.5s1.72-.5 2.5-.5a1 1 0 1 1 0 5c-.78 0-1.5-.5-2.5-.5a3.149 3.149 0 0 0-.842.12"></path><path d="M9 14.6V18"></path>',
		'beer'                               => '<path d="M17 11h1a3 3 0 0 1 0 6h-1"></path><path d="M9 12v6"></path><path d="M13 12v6"></path><path d="M14 7.5c-1 0-1.44.5-3 .5s-2-.5-3-.5-1.72.5-2.5.5a2.5 2.5 0 0 1 0-5c.78 0 1.57.5 2.5.5S9.44 2 11 2s2 1.5 3 1.5 1.72-.5 2.5-.5a2.5 2.5 0 0 1 0 5c-.78 0-1.5-.5-2.5-.5Z"></path><path d="M5 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8"></path>',
		'bell-dot'                           => '<path d="M10.268 21a2 2 0 0 0 3.464 0"></path><path d="M13.916 2.314A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.74 7.327A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673 9 9 0 0 1-.585-.665"></path><circle cx="18" cy="8" r="3"></circle>',
		'bell-electric'                      => '<path d="M18.518 17.347A7 7 0 0 1 14 19"></path><path d="M18.8 4A11 11 0 0 1 20 9"></path><path d="M9 9h.01"></path><circle cx="20" cy="16" r="2"></circle><circle cx="9" cy="9" r="7"></circle><rect x="4" y="16" width="10" height="6" rx="2"></rect>',
		'bell-minus'                         => '<path d="M10.268 21a2 2 0 0 0 3.464 0"></path><path d="M15 8h6"></path><path d="M16.243 3.757A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673A9.4 9.4 0 0 1 18.667 12"></path>',
		'bell-off'                           => '<path d="M10.268 21a2 2 0 0 0 3.464 0"></path><path d="M17 17H4a1 1 0 0 1-.74-1.673C4.59 13.956 6 12.499 6 8a6 6 0 0 1 .258-1.742"></path><path d="m2 2 20 20"></path><path d="M8.668 3.01A6 6 0 0 1 18 8c0 2.687.77 4.653 1.707 6.05"></path>',
		'bell-plus'                          => '<path d="M10.268 21a2 2 0 0 0 3.464 0"></path><path d="M15 8h6"></path><path d="M18 5v6"></path><path d="M20.002 14.464a9 9 0 0 0 .738.863A1 1 0 0 1 20 17H4a1 1 0 0 1-.74-1.673C4.59 13.956 6 12.499 6 8a6 6 0 0 1 8.75-5.332"></path>',
		'bell-ring'                          => '<path d="M10.268 21a2 2 0 0 0 3.464 0"></path><path d="M22 8c0-2.3-.8-4.3-2-6"></path><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"></path><path d="M4 2C2.8 3.7 2 5.7 2 8"></path>',
		'bell'                               => '<path d="M10.268 21a2 2 0 0 0 3.464 0"></path><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"></path>',
		'between-horizontal-end'             => '<rect width="13" height="7" x="3" y="3" rx="1"></rect><path d="m22 15-3-3 3-3"></path><rect width="13" height="7" x="3" y="14" rx="1"></rect>',
		'between-horizontal-start'           => '<rect width="13" height="7" x="8" y="3" rx="1"></rect><path d="m2 9 3 3-3 3"></path><rect width="13" height="7" x="8" y="14" rx="1"></rect>',
		'between-vertical-end'               => '<rect width="7" height="13" x="3" y="3" rx="1"></rect><path d="m9 22 3-3 3 3"></path><rect width="7" height="13" x="14" y="3" rx="1"></rect>',
		'between-vertical-start'             => '<rect width="7" height="13" x="3" y="8" rx="1"></rect><path d="m15 2-3 3-3-3"></path><rect width="7" height="13" x="14" y="8" rx="1"></rect>',
		'biceps-flexed'                      => '<path d="M12.409 13.017A5 5 0 0 1 22 15c0 3.866-4 7-9 7-4.077 0-8.153-.82-10.371-2.462-.426-.316-.631-.832-.62-1.362C2.118 12.723 2.627 2 10 2a3 3 0 0 1 3 3 2 2 0 0 1-2 2c-1.105 0-1.64-.444-2-1"></path><path d="M15 14a5 5 0 0 0-7.584 2"></path><path d="M9.964 6.825C8.019 7.977 9.5 13 8 15"></path>',
		'bike'                               => '<circle cx="18.5" cy="17.5" r="3.5"></circle><circle cx="5.5" cy="17.5" r="3.5"></circle><circle cx="15" cy="5" r="1"></circle><path d="M12 17.5V14l-3-3 4-3 2 3h2"></path>',
		'binary'                             => '<rect x="14" y="14" width="4" height="6" rx="2"></rect><rect x="6" y="4" width="4" height="6" rx="2"></rect><path d="M6 20h4"></path><path d="M14 10h4"></path><path d="M6 14h2v6"></path><path d="M14 4h2v6"></path>',
		'binoculars'                         => '<path d="M10 10h4"></path><path d="M19 7V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3"></path><path d="M20 21a2 2 0 0 0 2-2v-3.851c0-1.39-2-2.962-2-4.829V8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2z"></path><path d="M 22 16 L 2 16"></path><path d="M4 21a2 2 0 0 1-2-2v-3.851c0-1.39 2-2.962 2-4.829V8a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v11a2 2 0 0 1-2 2z"></path><path d="M9 7V4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v3"></path>',
		'biohazard'                          => '<circle cx="12" cy="11.9" r="2"></circle><path d="M6.7 3.4c-.9 2.5 0 5.2 2.2 6.7C6.5 9 3.7 9.6 2 11.6"></path><path d="m8.9 10.1 1.4.8"></path><path d="M17.3 3.4c.9 2.5 0 5.2-2.2 6.7 2.4-1.2 5.2-.6 6.9 1.5"></path><path d="m15.1 10.1-1.4.8"></path><path d="M16.7 20.8c-2.6-.4-4.6-2.6-4.7-5.3-.2 2.6-2.1 4.8-4.7 5.2"></path><path d="M12 13.9v1.6"></path><path d="M13.5 5.4c-1-.2-2-.2-3 0"></path><path d="M17 16.4c.7-.7 1.2-1.6 1.5-2.5"></path><path d="M5.5 13.9c.3.9.8 1.8 1.5 2.5"></path>',
		'bird'                               => '<path d="M16 7h.01"></path><path d="M3.4 18H12a8 8 0 0 0 8-8V7a4 4 0 0 0-7.28-2.3L2 20"></path><path d="m20 7 2 .5-2 .5"></path><path d="M10 18v3"></path><path d="M14 17.75V21"></path><path d="M7 18a6 6 0 0 0 3.84-10.61"></path>',
		'birdhouse'                          => '<path d="M12 18v4"></path><path d="m17 18 1.956-11.468"></path><path d="m3 8 7.82-5.615a2 2 0 0 1 2.36 0L21 8"></path><path d="M4 18h16"></path><path d="M7 18 5.044 6.532"></path><circle cx="12" cy="10" r="2"></circle>',
		'bitcoin'                            => '<path d="M11.767 19.089c4.924.868 6.14-6.025 1.216-6.894m-1.216 6.894L5.86 18.047m5.908 1.042-.347 1.97m1.563-8.864c4.924.869 6.14-6.025 1.215-6.893m-1.215 6.893-3.94-.694m5.155-6.2L8.29 4.26m5.908 1.042.348-1.97M7.48 20.364l3.126-17.727"></path>',
		'blend'                              => '<circle cx="9" cy="9" r="7"></circle><circle cx="15" cy="15" r="7"></circle>',
		'blinds'                             => '<path d="M3 3h18"></path><path d="M20 7H8"></path><path d="M20 11H8"></path><path d="M10 19h10"></path><path d="M8 15h12"></path><path d="M4 3v14"></path><circle cx="4" cy="19" r="2"></circle>',
		'blocks'                             => '<path d="M10 22V7a1 1 0 0 0-1-1H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5a1 1 0 0 0-1-1H2"></path><rect x="14" y="2" width="8" height="8" rx="1"></rect>',
		'bluetooth-connected'                => '<path d="m7 7 10 10-5 5V2l5 5L7 17"></path><line x1="18" x2="21" y1="12" y2="12"></line><line x1="3" x2="6" y1="12" y2="12"></line>',
		'bluetooth-off'                      => '<path d="m17 17-5 5V12l-5 5"></path><path d="m2 2 20 20"></path><path d="M14.5 9.5 17 7l-5-5v4.5"></path>',
		'bluetooth-searching'                => '<path d="m7 7 10 10-5 5V2l5 5L7 17"></path><path d="M20.83 14.83a4 4 0 0 0 0-5.66"></path><path d="M18 12h.01"></path>',
		'bluetooth'                          => '<path d="m7 7 10 10-5 5V2l5 5L7 17"></path>',
		'bold'                               => '<path d="M6 12h9a4 4 0 0 1 0 8H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h7a4 4 0 0 1 0 8"></path>',
		'bolt'                               => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><circle cx="12" cy="12" r="4"></circle>',
		'bomb'                               => '<circle cx="11" cy="13" r="9"></circle><path d="M14.35 4.65 16.3 2.7a2.41 2.41 0 0 1 3.4 0l1.6 1.6a2.4 2.4 0 0 1 0 3.4l-1.95 1.95"></path><path d="m22 2-1.5 1.5"></path>',
		'bone'                               => '<path d="M17 10c.7-.7 1.69 0 2.5 0a2.5 2.5 0 1 0 0-5 .5.5 0 0 1-.5-.5 2.5 2.5 0 1 0-5 0c0 .81.7 1.8 0 2.5l-7 7c-.7.7-1.69 0-2.5 0a2.5 2.5 0 0 0 0 5c.28 0 .5.22.5.5a2.5 2.5 0 1 0 5 0c0-.81-.7-1.8 0-2.5Z"></path>',
		'book-a'                             => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="m8 13 4-7 4 7"></path><path d="M9.1 11h5.7"></path>',
		'book-alert'                         => '<path d="M12 13h.01"></path><path d="M12 6v3"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path>',
		'book-audio'                         => '<path d="M12 6v7"></path><path d="M16 8v3"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M8 8v3"></path>',
		'book-check'                         => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="m9 9.5 2 2 4-4"></path>',
		'book-copy'                          => '<path d="M5 7a2 2 0 0 0-2 2v11"></path><path d="M5.803 18H5a2 2 0 0 0 0 4h9.5a.5.5 0 0 0 .5-.5V21"></path><path d="M9 15V4a2 2 0 0 1 2-2h9.5a.5.5 0 0 1 .5.5v14a.5.5 0 0 1-.5.5H11a2 2 0 0 1 0-4h10"></path>',
		'book-dashed'                        => '<path d="M12 17h1.5"></path><path d="M12 22h1.5"></path><path d="M12 2h1.5"></path><path d="M17.5 22H19a1 1 0 0 0 1-1"></path><path d="M17.5 2H19a1 1 0 0 1 1 1v1.5"></path><path d="M20 14v3h-2.5"></path><path d="M20 8.5V10"></path><path d="M4 10V8.5"></path><path d="M4 19.5V14"></path><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H8"></path><path d="M8 22H6.5a1 1 0 0 1 0-5H8"></path>',
		'book-down'                          => '<path d="M12 13V7"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="m9 10 3 3 3-3"></path>',
		'book-headphones'                    => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M8 12v-2a4 4 0 0 1 8 0v2"></path><circle cx="15" cy="12" r="1"></circle><circle cx="9" cy="12" r="1"></circle>',
		'book-heart'                         => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M8.62 9.8A2.25 2.25 0 1 1 12 6.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a.998.998 0 0 1-1.507 0z"></path>',
		'book-image'                         => '<path d="m20 13.7-2.1-2.1a2 2 0 0 0-2.8 0L9.7 17"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><circle cx="10" cy="8" r="2"></circle>',
		'book-key'                           => '<path d="m19 3 1 1"></path><path d="m20 2-4.5 4.5"></path><path d="M20 7.898V21a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2h7.844"></path><circle cx="14" cy="8" r="2"></circle>',
		'book-lock'                          => '<path d="M18 6V4a2 2 0 1 0-4 0v2"></path><path d="M20 15v6a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H10"></path><rect x="12" y="6" width="8" height="5" rx="1"></rect>',
		'book-marked'                        => '<path d="M10 2v8l3-3 3 3V2"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path>',
		'book-minus'                         => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M9 10h6"></path>',
		'book-open-check'                    => '<path d="M12 21V7"></path><path d="m16 12 2 2 4-4"></path><path d="M22 6V4a1 1 0 0 0-1-1h-5a4 4 0 0 0-4 4 4 4 0 0 0-4-4H3a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h6a3 3 0 0 1 3 3 3 3 0 0 1 3-3h6a1 1 0 0 0 1-1v-1.3"></path>',
		'book-open-text'                     => '<path d="M12 7v14"></path><path d="M16 12h2"></path><path d="M16 8h2"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path><path d="M6 12h2"></path><path d="M6 8h2"></path>',
		'book-open'                          => '<path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path>',
		'book-plus'                          => '<path d="M12 7v6"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M9 10h6"></path>',
		'book-search'                        => '<path d="M11 22H5.5a1 1 0 0 1 0-5h4.501"></path><path d="m21 22-1.879-1.878"></path><path d="M3 19.5v-15A2.5 2.5 0 0 1 5.5 2H18a1 1 0 0 1 1 1v8"></path><circle cx="17" cy="18" r="3"></circle>',
		'book-text'                          => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M8 11h8"></path><path d="M8 7h6"></path>',
		'book-type'                          => '<path d="M10 13h4"></path><path d="M12 6v7"></path><path d="M16 8V6H8v2"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path>',
		'book-up-2'                          => '<path d="M12 13V7"></path><path d="M18 2h1a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2"></path><path d="m9 10 3-3 3 3"></path><path d="m9 5 3-3 3 3"></path>',
		'book-up'                            => '<path d="M12 13V7"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="m9 10 3-3 3 3"></path>',
		'book-user'                          => '<path d="M15 13a3 3 0 1 0-6 0"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><circle cx="12" cy="8" r="2"></circle>',
		'book-x'                             => '<path d="m14.5 7-5 5"></path><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path><path d="m9.5 7 5 5"></path>',
		'book'                               => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path>',
		'bookmark-check'                     => '<path d="M17 3a2 2 0 0 1 2 2v15a1 1 0 0 1-1.496.868l-4.512-2.578a2 2 0 0 0-1.984 0l-4.512 2.578A1 1 0 0 1 5 20V5a2 2 0 0 1 2-2z"></path><path d="m9 10 2 2 4-4"></path>',
		'bookmark-minus'                     => '<path d="M15 10H9"></path><path d="M17 3a2 2 0 0 1 2 2v15a1 1 0 0 1-1.496.868l-4.512-2.578a2 2 0 0 0-1.984 0l-4.512 2.578A1 1 0 0 1 5 20V5a2 2 0 0 1 2-2z"></path>',
		'bookmark-plus'                      => '<path d="M12 7v6"></path><path d="M15 10H9"></path><path d="M17 3a2 2 0 0 1 2 2v15a1 1 0 0 1-1.496.868l-4.512-2.578a2 2 0 0 0-1.984 0l-4.512 2.578A1 1 0 0 1 5 20V5a2 2 0 0 1 2-2z"></path>',
		'bookmark-x'                         => '<path d="m14.5 7.5-5 5"></path><path d="M17 3a2 2 0 0 1 2 2v15a1 1 0 0 1-1.496.868l-4.512-2.578a2 2 0 0 0-1.984 0l-4.512 2.578A1 1 0 0 1 5 20V5a2 2 0 0 1 2-2z"></path><path d="m9.5 7.5 5 5"></path>',
		'bookmark'                           => '<path d="M17 3a2 2 0 0 1 2 2v15a1 1 0 0 1-1.496.868l-4.512-2.578a2 2 0 0 0-1.984 0l-4.512 2.578A1 1 0 0 1 5 20V5a2 2 0 0 1 2-2z"></path>',
		'boom-box'                           => '<path d="M4 9V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"></path><path d="M8 8v1"></path><path d="M12 8v1"></path><path d="M16 8v1"></path><rect width="20" height="12" x="2" y="9" rx="2"></rect><circle cx="8" cy="15" r="2"></circle><circle cx="16" cy="15" r="2"></circle>',
		'bot-message-square'                 => '<path d="M12 6V2H8"></path><path d="M15 11v2"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="M20 16a2 2 0 0 1-2 2H8.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 4 20.286V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2z"></path><path d="M9 11v2"></path>',
		'bot-off'                            => '<path d="M13.67 8H18a2 2 0 0 1 2 2v4.33"></path><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M22 22 2 2"></path><path d="M8 8H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 1.414-.586"></path><path d="M9 13v2"></path><path d="M9.67 4H12v2.33"></path>',
		'bot'                                => '<path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path>',
		'bottle-wine'                        => '<path d="M10 3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a6 6 0 0 0 1.2 3.6l.6.8A6 6 0 0 1 17 13v8a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-8a6 6 0 0 1 1.2-3.6l.6-.8A6 6 0 0 0 10 5z"></path><path d="M17 13h-4a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h4"></path>',
		'bow-arrow'                          => '<path d="M17 3h4v4"></path><path d="M18.575 11.082a13 13 0 0 1 1.048 9.027 1.17 1.17 0 0 1-1.914.597L14 17"></path><path d="M7 10 3.29 6.29a1.17 1.17 0 0 1 .6-1.91 13 13 0 0 1 9.03 1.05"></path><path d="M7 14a1.7 1.7 0 0 0-1.207.5l-2.646 2.646A.5.5 0 0 0 3.5 18H5a1 1 0 0 1 1 1v1.5a.5.5 0 0 0 .854.354L9.5 18.207A1.7 1.7 0 0 0 10 17v-2a1 1 0 0 0-1-1z"></path><path d="M9.707 14.293 21 3"></path>',
		'box'                                => '<path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path>',
		'boxes'                              => '<path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"></path><path d="m7 16.5-4.74-2.85"></path><path d="m7 16.5 5-3"></path><path d="M7 16.5v5.17"></path><path d="M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"></path><path d="m17 16.5-5-3"></path><path d="m17 16.5 4.74-2.85"></path><path d="M17 16.5v5.17"></path><path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"></path><path d="M12 8 7.26 5.15"></path><path d="m12 8 4.74-2.85"></path><path d="M12 13.5V8"></path>',
		'braces'                             => '<path d="M8 3H7a2 2 0 0 0-2 2v5a2 2 0 0 1-2 2 2 2 0 0 1 2 2v5c0 1.1.9 2 2 2h1"></path><path d="M16 21h1a2 2 0 0 0 2-2v-5c0-1.1.9-2 2-2a2 2 0 0 1-2-2V5a2 2 0 0 0-2-2h-1"></path>',
		'brackets'                           => '<path d="M16 3h3a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-3"></path><path d="M8 21H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h3"></path>',
		'brain-circuit'                      => '<path d="M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z"></path><path d="M9 13a4.5 4.5 0 0 0 3-4"></path><path d="M6.003 5.125A3 3 0 0 0 6.401 6.5"></path><path d="M3.477 10.896a4 4 0 0 1 .585-.396"></path><path d="M6 18a4 4 0 0 1-1.967-.516"></path><path d="M12 13h4"></path><path d="M12 18h6a2 2 0 0 1 2 2v1"></path><path d="M12 8h8"></path><path d="M16 8V5a2 2 0 0 1 2-2"></path><circle cx="16" cy="13" r=".5"></circle><circle cx="18" cy="3" r=".5"></circle><circle cx="20" cy="21" r=".5"></circle><circle cx="20" cy="8" r=".5"></circle>',
		'brain-cog'                          => '<path d="m10.852 14.772-.383.923"></path><path d="m10.852 9.228-.383-.923"></path><path d="m13.148 14.772.382.924"></path><path d="m13.531 8.305-.383.923"></path><path d="m14.772 10.852.923-.383"></path><path d="m14.772 13.148.923.383"></path><path d="M17.598 6.5A3 3 0 1 0 12 5a3 3 0 0 0-5.63-1.446 3 3 0 0 0-.368 1.571 4 4 0 0 0-2.525 5.771"></path><path d="M17.998 5.125a4 4 0 0 1 2.525 5.771"></path><path d="M19.505 10.294a4 4 0 0 1-1.5 7.706"></path><path d="M4.032 17.483A4 4 0 0 0 11.464 20c.18-.311.892-.311 1.072 0a4 4 0 0 0 7.432-2.516"></path><path d="M4.5 10.291A4 4 0 0 0 6 18"></path><path d="M6.002 5.125a3 3 0 0 0 .4 1.375"></path><path d="m9.228 10.852-.923-.383"></path><path d="m9.228 13.148-.923.383"></path><circle cx="12" cy="12" r="3"></circle>',
		'brain'                              => '<path d="M12 18V5"></path><path d="M15 13a4.17 4.17 0 0 1-3-4 4.17 4.17 0 0 1-3 4"></path><path d="M17.598 6.5A3 3 0 1 0 12 5a3 3 0 1 0-5.598 1.5"></path><path d="M17.997 5.125a4 4 0 0 1 2.526 5.77"></path><path d="M18 18a4 4 0 0 0 2-7.464"></path><path d="M19.967 17.483A4 4 0 1 1 12 18a4 4 0 1 1-7.967-.517"></path><path d="M6 18a4 4 0 0 1-2-7.464"></path><path d="M6.003 5.125a4 4 0 0 0-2.526 5.77"></path>',
		'brick-wall-fire'                    => '<path d="M16 3v2.107"></path><path d="M17 9c1 3 2.5 3.5 3.5 4.5A5 5 0 0 1 22 17a5 5 0 0 1-10 0c0-.3 0-.6.1-.9a2 2 0 1 0 3.3-2C13 11.5 16 9 17 9"></path><path d="M21 8.274V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.938"></path><path d="M3 15h5.253"></path><path d="M3 9h8.228"></path><path d="M8 15v6"></path><path d="M8 3v6"></path>',
		'brick-wall-shield'                  => '<path d="M12 9v1.258"></path><path d="M16 3v5.46"></path><path d="M21 9.118V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h5.75"></path><path d="M22 17.5c0 2.499-1.75 3.749-3.83 4.474a.5.5 0 0 1-.335-.005c-2.085-.72-3.835-1.97-3.835-4.47V14a.5.5 0 0 1 .5-.499c1 0 2.25-.6 3.12-1.36a.6.6 0 0 1 .76-.001c.875.765 2.12 1.36 3.12 1.36a.5.5 0 0 1 .5.5z"></path><path d="M3 15h7"></path><path d="M3 9h12.142"></path><path d="M8 15v6"></path><path d="M8 3v6"></path>',
		'brick-wall'                         => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M12 9v6"></path><path d="M16 15v6"></path><path d="M16 3v6"></path><path d="M3 15h18"></path><path d="M3 9h18"></path><path d="M8 15v6"></path><path d="M8 3v6"></path>',
		'briefcase-business'                 => '<path d="M12 12h.01"></path><path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path><path d="M22 13a18.15 18.15 0 0 1-20 0"></path><rect width="20" height="14" x="2" y="6" rx="2"></rect>',
		'briefcase-conveyor-belt'            => '<path d="M10 20v2"></path><path d="M14 20v2"></path><path d="M18 20v2"></path><path d="M21 20H3"></path><path d="M6 20v2"></path><path d="M8 16V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v12"></path><rect x="4" y="6" width="16" height="10" rx="2"></rect>',
		'briefcase-medical'                  => '<path d="M12 11v4"></path><path d="M14 13h-4"></path><path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path><path d="M18 6v14"></path><path d="M6 6v14"></path><rect width="20" height="14" x="2" y="6" rx="2"></rect>',
		'briefcase'                          => '<path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path><rect width="20" height="14" x="2" y="6" rx="2"></rect>',
		'bring-to-front'                     => '<rect x="8" y="8" width="8" height="8" rx="2"></rect><path d="M4 10a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2"></path><path d="M14 20a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2"></path>',
		'brush-cleaning'                     => '<path d="m16 22-1-4"></path><path d="M19 14a1 1 0 0 0 1-1v-1a2 2 0 0 0-2-2h-3a1 1 0 0 1-1-1V4a2 2 0 0 0-4 0v5a1 1 0 0 1-1 1H6a2 2 0 0 0-2 2v1a1 1 0 0 0 1 1"></path><path d="M19 14H5l-1.973 6.767A1 1 0 0 0 4 22h16a1 1 0 0 0 .973-1.233z"></path><path d="m8 22 1-4"></path>',
		'brush'                              => '<path d="m11 10 3 3"></path><path d="M6.5 21A3.5 3.5 0 1 0 3 17.5a2.62 2.62 0 0 1-.708 1.792A1 1 0 0 0 3 21z"></path><path d="M9.969 17.031 21.378 5.624a1 1 0 0 0-3.002-3.002L6.967 14.031"></path>',
		'bubbles'                            => '<path d="M7.001 15.085A1.5 1.5 0 0 1 9 16.5"></path><circle cx="18.5" cy="8.5" r="3.5"></circle><circle cx="7.5" cy="16.5" r="5.5"></circle><circle cx="7.5" cy="4.5" r="2.5"></circle>',
		'bug-off'                            => '<path d="M12 20v-8"></path><path d="M14.12 3.88 16 2"></path><path d="M15 7.13V6a3 3 0 0 0-5.14-2.1L8 2"></path><path d="M18 12.34V11a4 4 0 0 0-4-4h-1.3"></path><path d="m2 2 20 20"></path><path d="M21 5a4 4 0 0 1-3.55 3.97"></path><path d="M22 13h-3.34"></path><path d="M3 21a4 4 0 0 1 3.81-4"></path><path d="M6 13H2"></path><path d="M7.7 7.7A4 4 0 0 0 6 11v3a6 6 0 0 0 11.13 3.13"></path>',
		'bug-play'                           => '<path d="M10 19.655A6 6 0 0 1 6 14v-3a4 4 0 0 1 4-4h4a4 4 0 0 1 4 3.97"></path><path d="M14 15.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997a1 1 0 0 1-1.517-.86z"></path><path d="M14.12 3.88 16 2"></path><path d="M21 5a4 4 0 0 1-3.55 3.97"></path><path d="M3 21a4 4 0 0 1 3.81-4"></path><path d="M3 5a4 4 0 0 0 3.55 3.97"></path><path d="M6 13H2"></path><path d="m8 2 1.88 1.88"></path><path d="M9 7.13V6a3 3 0 1 1 6 0v1.13"></path>',
		'bug'                                => '<path d="M12 20v-9"></path><path d="M14 7a4 4 0 0 1 4 4v3a6 6 0 0 1-12 0v-3a4 4 0 0 1 4-4z"></path><path d="M14.12 3.88 16 2"></path><path d="M21 21a4 4 0 0 0-3.81-4"></path><path d="M21 5a4 4 0 0 1-3.55 3.97"></path><path d="M22 13h-4"></path><path d="M3 21a4 4 0 0 1 3.81-4"></path><path d="M3 5a4 4 0 0 0 3.55 3.97"></path><path d="M6 13H2"></path><path d="m8 2 1.88 1.88"></path><path d="M9 7.13V6a3 3 0 1 1 6 0v1.13"></path>',
		'building-2'                         => '<path d="M10 12h4"></path><path d="M10 8h4"></path><path d="M14 21v-3a2 2 0 0 0-4 0v3"></path><path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"></path><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"></path>',
		'building'                           => '<path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M12 6h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M16 6h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path><path d="M8 6h.01"></path><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"></path><rect x="4" y="2" width="16" height="20" rx="2"></rect>',
		'bus-front'                          => '<path d="M4 6 2 7"></path><path d="M10 6h4"></path><path d="m22 7-2-1"></path><rect width="16" height="16" x="4" y="3" rx="2"></rect><path d="M4 11h16"></path><path d="M8 15h.01"></path><path d="M16 15h.01"></path><path d="M6 19v2"></path><path d="M18 21v-2"></path>',
		'bus'                                => '<path d="M8 6v6"></path><path d="M15 6v6"></path><path d="M2 12h19.6"></path><path d="M18 18h3s.5-1.7.8-2.8c.1-.4.2-.8.2-1.2 0-.4-.1-.8-.2-1.2l-1.4-5C20.1 6.8 19.1 6 18 6H4a2 2 0 0 0-2 2v10h3"></path><circle cx="7" cy="18" r="2"></circle><path d="M9 18h5"></path><circle cx="16" cy="18" r="2"></circle>',
		'cable-car'                          => '<path d="M10 3h.01"></path><path d="M14 2h.01"></path><path d="m2 9 20-5"></path><path d="M12 12V6.5"></path><rect width="16" height="10" x="4" y="12" rx="3"></rect><path d="M9 12v5"></path><path d="M15 12v5"></path><path d="M4 17h16"></path>',
		'cable'                              => '<path d="M17 19a1 1 0 0 1-1-1v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a1 1 0 0 1-1 1z"></path><path d="M17 21v-2"></path><path d="M19 14V6.5a1 1 0 0 0-7 0v11a1 1 0 0 1-7 0V10"></path><path d="M21 21v-2"></path><path d="M3 5V3"></path><path d="M4 10a2 2 0 0 1-2-2V6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a2 2 0 0 1-2 2z"></path><path d="M7 5V3"></path>',
		'cake-slice'                         => '<path d="M16 13H3"></path><path d="M16 17H3"></path><path d="m7.2 7.9-3.388 2.5A2 2 0 0 0 3 12.01V20a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-8.654c0-2-2.44-6.026-6.44-8.026a1 1 0 0 0-1.082.057L10.4 5.6"></path><circle cx="9" cy="7" r="2"></circle>',
		'cake'                               => '<path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"></path><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"></path><path d="M2 21h20"></path><path d="M7 8v3"></path><path d="M12 8v3"></path><path d="M17 8v3"></path><path d="M7 4h.01"></path><path d="M12 4h.01"></path><path d="M17 4h.01"></path>',
		'calculator'                         => '<rect width="16" height="20" x="4" y="2" rx="2"></rect><line x1="8" x2="16" y1="6" y2="6"></line><line x1="16" x2="16" y1="14" y2="18"></line><path d="M16 10h.01"></path><path d="M12 10h.01"></path><path d="M8 10h.01"></path><path d="M12 14h.01"></path><path d="M8 14h.01"></path><path d="M12 18h.01"></path><path d="M8 18h.01"></path>',
		'calendar-1'                         => '<path d="M11 14h1v4"></path><path d="M16 2v4"></path><path d="M3 10h18"></path><path d="M8 2v4"></path><rect x="3" y="4" width="18" height="18" rx="2"></rect>',
		'calendar-arrow-down'                => '<path d="m14 18 4 4 4-4"></path><path d="M16 2v4"></path><path d="M18 14v8"></path><path d="M21 11.354V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7.343"></path><path d="M3 10h18"></path><path d="M8 2v4"></path>',
		'calendar-arrow-up'                  => '<path d="m14 18 4-4 4 4"></path><path d="M16 2v4"></path><path d="M18 22v-8"></path><path d="M21 11.343V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h9"></path><path d="M3 10h18"></path><path d="M8 2v4"></path>',
		'calendar-check-2'                   => '<path d="M8 2v4"></path><path d="M16 2v4"></path><path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"></path><path d="M3 10h18"></path><path d="m16 20 2 2 4-4"></path>',
		'calendar-check'                     => '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="m9 16 2 2 4-4"></path>',
		'calendar-clock'                     => '<path d="M16 14v2.2l1.6 1"></path><path d="M16 2v4"></path><path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"></path><path d="M3 10h5"></path><path d="M8 2v4"></path><circle cx="16" cy="16" r="6"></circle>',
		'calendar-cog'                       => '<path d="m15.228 16.852-.923-.383"></path><path d="m15.228 19.148-.923.383"></path><path d="M16 2v4"></path><path d="m16.47 14.305.382.923"></path><path d="m16.852 20.772-.383.924"></path><path d="m19.148 15.228.383-.923"></path><path d="m19.53 21.696-.382-.924"></path><path d="m20.772 16.852.924-.383"></path><path d="m20.772 19.148.924.383"></path><path d="M21 10.592V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6"></path><path d="M3 10h18"></path><path d="M8 2v4"></path><circle cx="18" cy="18" r="3"></circle>',
		'calendar-days'                      => '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M8 14h.01"></path><path d="M12 14h.01"></path><path d="M16 14h.01"></path><path d="M8 18h.01"></path><path d="M12 18h.01"></path><path d="M16 18h.01"></path>',
		'calendar-fold'                      => '<path d="M3 20a2 2 0 0 0 2 2h10a2.4 2.4 0 0 0 1.706-.706l3.588-3.588A2.4 2.4 0 0 0 21 16V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"></path><path d="M15 22v-5a1 1 0 0 1 1-1h5"></path><path d="M8 2v4"></path><path d="M16 2v4"></path><path d="M3 10h18"></path>',
		'calendar-heart'                     => '<path d="M12.127 22H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5.125"></path><path d="M14.62 18.8A2.25 2.25 0 1 1 18 15.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a.998.998 0 0 1-1.507 0z"></path><path d="M16 2v4"></path><path d="M3 10h18"></path><path d="M8 2v4"></path>',
		'calendar-minus-2'                   => '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M10 16h4"></path>',
		'calendar-minus'                     => '<path d="M16 19h6"></path><path d="M16 2v4"></path><path d="M21 15V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8.5"></path><path d="M3 10h18"></path><path d="M8 2v4"></path>',
		'calendar-off'                       => '<path d="M4.2 4.2A2 2 0 0 0 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 1.82-1.18"></path><path d="M21 15.5V6a2 2 0 0 0-2-2H9.5"></path><path d="M16 2v4"></path><path d="M3 10h7"></path><path d="M21 10h-5.5"></path><path d="m2 2 20 20"></path>',
		'calendar-plus-2'                    => '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M10 16h4"></path><path d="M12 14v4"></path>',
		'calendar-plus'                      => '<path d="M16 19h6"></path><path d="M16 2v4"></path><path d="M19 16v6"></path><path d="M21 12.598V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8.5"></path><path d="M3 10h18"></path><path d="M8 2v4"></path>',
		'calendar-range'                     => '<rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M16 2v4"></path><path d="M3 10h18"></path><path d="M8 2v4"></path><path d="M17 14h-6"></path><path d="M13 18H7"></path><path d="M7 14h.01"></path><path d="M17 18h.01"></path>',
		'calendar-search'                    => '<path d="M16 2v4"></path><path d="M21 11.75V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7.25"></path><path d="m22 22-1.875-1.875"></path><path d="M3 10h18"></path><path d="M8 2v4"></path><circle cx="18" cy="18" r="3"></circle>',
		'calendar-sync'                      => '<path d="M11 10v4h4"></path><path d="m11 14 1.535-1.605a5 5 0 0 1 8 1.5"></path><path d="M16 2v4"></path><path d="m21 18-1.535 1.605a5 5 0 0 1-8-1.5"></path><path d="M21 22v-4h-4"></path><path d="M21 8.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4.3"></path><path d="M3 10h4"></path><path d="M8 2v4"></path>',
		'calendar-x-2'                       => '<path d="M8 2v4"></path><path d="M16 2v4"></path><path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"></path><path d="M3 10h18"></path><path d="m17 22 5-5"></path><path d="m17 17 5 5"></path>',
		'calendar-x'                         => '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="m14 14-4 4"></path><path d="m10 14 4 4"></path>',
		'calendar'                           => '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path>',
		'calendars'                          => '<path d="M12 2v2"></path><path d="M15.726 21.01A2 2 0 0 1 14 22H4a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2"></path><path d="M18 2v2"></path><path d="M2 13h2"></path><path d="M8 8h14"></path><rect x="8" y="3" width="14" height="14" rx="2"></rect>',
		'camera-off'                         => '<path d="M14.564 14.558a3 3 0 1 1-4.122-4.121"></path><path d="m2 2 20 20"></path><path d="M20 20H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 .819-.175"></path><path d="M9.695 4.024A2 2 0 0 1 10.004 4h3.993a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v7.344"></path>',
		'camera'                             => '<path d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z"></path><circle cx="12" cy="13" r="3"></circle>',
		'candy-cane'                         => '<path d="M5.7 21a2 2 0 0 1-3.5-2l8.6-14a6 6 0 0 1 10.4 6 2 2 0 1 1-3.464-2 2 2 0 1 0-3.464-2Z"></path><path d="M17.75 7 15 2.1"></path><path d="M10.9 4.8 13 9"></path><path d="m7.9 9.7 2 4.4"></path><path d="M4.9 14.7 7 18.9"></path>',
		'candy-off'                          => '<path d="M10 10v7.9"></path><path d="M11.802 6.145a5 5 0 0 1 6.053 6.053"></path><path d="M14 6.1v2.243"></path><path d="m15.5 15.571-.964.964a5 5 0 0 1-7.071 0 5 5 0 0 1 0-7.07l.964-.965"></path><path d="M16 7V3a1 1 0 0 1 1.707-.707 2.5 2.5 0 0 0 2.152.717 1 1 0 0 1 1.131 1.131 2.5 2.5 0 0 0 .717 2.152A1 1 0 0 1 21 8h-4"></path><path d="m2 2 20 20"></path><path d="M8 17v4a1 1 0 0 1-1.707.707 2.5 2.5 0 0 0-2.152-.717 1 1 0 0 1-1.131-1.131 2.5 2.5 0 0 0-.717-2.152A1 1 0 0 1 3 16h4"></path>',
		'candy'                              => '<path d="M10 7v10.9"></path><path d="M14 6.1V17"></path><path d="M16 7V3a1 1 0 0 1 1.707-.707 2.5 2.5 0 0 0 2.152.717 1 1 0 0 1 1.131 1.131 2.5 2.5 0 0 0 .717 2.152A1 1 0 0 1 21 8h-4"></path><path d="M16.536 7.465a5 5 0 0 0-7.072 0l-2 2a5 5 0 0 0 0 7.07 5 5 0 0 0 7.072 0l2-2a5 5 0 0 0 0-7.07"></path><path d="M8 17v4a1 1 0 0 1-1.707.707 2.5 2.5 0 0 0-2.152-.717 1 1 0 0 1-1.131-1.131 2.5 2.5 0 0 0-.717-2.152A1 1 0 0 1 3 16h4"></path>',
		'cannabis-off'                       => '<path d="M12 22v-4c1.5 1.5 3.5 3 6 3 0-1.5-.5-3.5-2-5"></path><path d="M13.988 8.327C13.902 6.054 13.365 3.82 12 2a9.3 9.3 0 0 0-1.445 2.9"></path><path d="M17.375 11.725C18.882 10.53 21 7.841 21 6c-2.324 0-5.08 1.296-6.662 2.684"></path><path d="m2 2 20 20"></path><path d="M21.024 15.378A15 15 0 0 0 22 15c-.426-1.279-2.67-2.557-4.25-2.907"></path><path d="M6.995 6.992C5.714 6.4 4.29 6 3 6c0 2 2.5 5 4 6-1.5 0-4.5 1.5-5 3 3.5 1.5 6 1 6 1-1.5 1.5-2 3.5-2 5 2.5 0 4.5-1.5 6-3"></path>',
		'cannabis'                           => '<path d="M12 22v-4"></path><path d="M7 12c-1.5 0-4.5 1.5-5 3 3.5 1.5 6 1 6 1-1.5 1.5-2 3.5-2 5 2.5 0 4.5-1.5 6-3 1.5 1.5 3.5 3 6 3 0-1.5-.5-3.5-2-5 0 0 2.5.5 6-1-.5-1.5-3.5-3-5-3 1.5-1 4-4 4-6-2.5 0-5.5 1.5-7 3 0-2.5-.5-5-2-7-1.5 2-2 4.5-2 7-1.5-1.5-4.5-3-7-3 0 2 2.5 5 4 6"></path>',
		'captions-off'                       => '<path d="M10.5 5H19a2 2 0 0 1 2 2v8.5"></path><path d="M17 11h-.5"></path><path d="M19 19H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2"></path><path d="m2 2 20 20"></path><path d="M7 11h4"></path><path d="M7 15h2.5"></path>',
		'captions'                           => '<rect width="18" height="14" x="3" y="5" rx="2" ry="2"></rect><path d="M7 15h4M15 15h2M7 11h2M13 11h4"></path>',
		'car-front'                          => '<path d="m21 8-2 2-1.5-3.7A2 2 0 0 0 15.646 5H8.4a2 2 0 0 0-1.903 1.257L5 10 3 8"></path><path d="M7 14h.01"></path><path d="M17 14h.01"></path><rect width="18" height="8" x="3" y="10" rx="2"></rect><path d="M5 18v2"></path><path d="M19 18v2"></path>',
		'car-taxi-front'                     => '<path d="M10 2h4"></path><path d="m21 8-2 2-1.5-3.7A2 2 0 0 0 15.646 5H8.4a2 2 0 0 0-1.903 1.257L5 10 3 8"></path><path d="M7 14h.01"></path><path d="M17 14h.01"></path><rect width="18" height="8" x="3" y="10" rx="2"></rect><path d="M5 18v2"></path><path d="M19 18v2"></path>',
		'car'                                => '<path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path><circle cx="7" cy="17" r="2"></circle><path d="M9 17h6"></path><circle cx="17" cy="17" r="2"></circle>',
		'caravan'                            => '<path d="M18 19V9a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v8a2 2 0 0 0 2 2h2"></path><path d="M2 9h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2"></path><path d="M22 17v1a1 1 0 0 1-1 1H10v-9a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v9"></path><circle cx="8" cy="19" r="2"></circle>',
		'card-sim'                           => '<path d="M12 14v4"></path><path d="M14.172 2a2 2 0 0 1 1.414.586l3.828 3.828A2 2 0 0 1 20 7.828V20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"></path><path d="M8 14h8"></path><rect x="8" y="10" width="8" height="8" rx="1"></rect>',
		'carrot'                             => '<path d="M2.27 21.7s9.87-3.5 12.73-6.36a4.5 4.5 0 0 0-6.36-6.37C5.77 11.84 2.27 21.7 2.27 21.7zM8.64 14l-2.05-2.04M15.34 15l-2.46-2.46"></path><path d="M22 9s-1.33-2-3.5-2C16.86 7 15 9 15 9s1.33 2 3.5 2S22 9 22 9z"></path><path d="M15 2s-2 1.33-2 3.5S15 9 15 9s2-1.84 2-3.5C17 3.33 15 2 15 2z"></path>',
		'case-lower'                         => '<path d="M10 9v7"></path><path d="M14 6v10"></path><circle cx="17.5" cy="12.5" r="3.5"></circle><circle cx="6.5" cy="12.5" r="3.5"></circle>',
		'case-sensitive'                     => '<path d="m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16"></path><path d="M22 9v7"></path><path d="M3.304 13h6.392"></path><circle cx="18.5" cy="12.5" r="3.5"></circle>',
		'case-upper'                         => '<path d="M15 11h4.5a1 1 0 0 1 0 5h-4a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h3a1 1 0 0 1 0 5"></path><path d="m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16"></path><path d="M3.304 13h6.392"></path>',
		'cassette-tape'                      => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><circle cx="8" cy="10" r="2"></circle><path d="M8 12h8"></path><circle cx="16" cy="10" r="2"></circle><path d="m6 20 .7-2.9A1.4 1.4 0 0 1 8.1 16h7.8a1.4 1.4 0 0 1 1.4 1l.7 3"></path>',
		'cast'                               => '<path d="M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path><path d="M2 12a9 9 0 0 1 8 8"></path><path d="M2 16a5 5 0 0 1 4 4"></path><line x1="2" x2="2.01" y1="20" y2="20"></line>',
		'castle'                             => '<path d="M10 5V3"></path><path d="M14 5V3"></path><path d="M15 21v-3a3 3 0 0 0-6 0v3"></path><path d="M18 3v8"></path><path d="M18 5H6"></path><path d="M22 11H2"></path><path d="M22 9v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9"></path><path d="M6 3v8"></path>',
		'cat'                                => '<path d="M12 5c.67 0 1.35.09 2 .26 1.78-2 5.03-2.84 6.42-2.26 1.4.58-.42 7-.42 7 .57 1.07 1 2.24 1 3.44C21 17.9 16.97 21 12 21s-9-3-9-7.56c0-1.25.5-2.4 1-3.44 0 0-1.89-6.42-.5-7 1.39-.58 4.72.23 6.5 2.23A9.04 9.04 0 0 1 12 5Z"></path><path d="M8 14v.5"></path><path d="M16 14v.5"></path><path d="M11.25 16.25h1.5L12 17l-.75-.75Z"></path>',
		'cctv'                               => '<path d="M16.75 12h3.632a1 1 0 0 1 .894 1.447l-2.034 4.069a1 1 0 0 1-1.708.134l-2.124-2.97"></path><path d="M17.106 9.053a1 1 0 0 1 .447 1.341l-3.106 6.211a1 1 0 0 1-1.342.447L3.61 12.3a2.92 2.92 0 0 1-1.3-3.91L3.69 5.6a2.92 2.92 0 0 1 3.92-1.3z"></path><path d="M2 19h3.76a2 2 0 0 0 1.8-1.1L9 15"></path><path d="M2 21v-4"></path><path d="M7 9h.01"></path>',
		'chart-area'                         => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M7 11.207a.5.5 0 0 1 .146-.353l2-2a.5.5 0 0 1 .708 0l3.292 3.292a.5.5 0 0 0 .708 0l4.292-4.292a.5.5 0 0 1 .854.353V16a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1z"></path>',
		'chart-bar-big'                      => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><rect x="7" y="13" width="9" height="4" rx="1"></rect><rect x="7" y="5" width="12" height="4" rx="1"></rect>',
		'chart-bar-decreasing'               => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M7 11h8"></path><path d="M7 16h3"></path><path d="M7 6h12"></path>',
		'chart-bar-increasing'               => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M7 11h8"></path><path d="M7 16h12"></path><path d="M7 6h3"></path>',
		'chart-bar-stacked'                  => '<path d="M11 13v4"></path><path d="M15 5v4"></path><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><rect x="7" y="13" width="9" height="4" rx="1"></rect><rect x="7" y="5" width="12" height="4" rx="1"></rect>',
		'chart-bar'                          => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M7 16h8"></path><path d="M7 11h12"></path><path d="M7 6h3"></path>',
		'chart-candlestick'                  => '<path d="M9 5v4"></path><rect width="4" height="6" x="7" y="9" rx="1"></rect><path d="M9 15v2"></path><path d="M17 3v2"></path><rect width="4" height="8" x="15" y="5" rx="1"></rect><path d="M17 13v3"></path><path d="M3 3v16a2 2 0 0 0 2 2h16"></path>',
		'chart-column-big'                   => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><rect x="15" y="5" width="4" height="12" rx="1"></rect><rect x="7" y="8" width="4" height="9" rx="1"></rect>',
		'chart-column-decreasing'            => '<path d="M13 17V9"></path><path d="M18 17v-3"></path><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M8 17V5"></path>',
		'chart-column-increasing'            => '<path d="M13 17V9"></path><path d="M18 17V5"></path><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M8 17v-3"></path>',
		'chart-column-stacked'               => '<path d="M11 13H7"></path><path d="M19 9h-4"></path><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><rect x="15" y="5" width="4" height="12" rx="1"></rect><rect x="7" y="8" width="4" height="9" rx="1"></rect>',
		'chart-column'                       => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path>',
		'chart-gantt'                        => '<path d="M10 6h8"></path><path d="M12 16h6"></path><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M8 11h7"></path>',
		'chart-line'                         => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="m19 9-5 5-4-4-3 3"></path>',
		'chart-network'                      => '<path d="m13.11 7.664 1.78 2.672"></path><path d="m14.162 12.788-3.324 1.424"></path><path d="m20 4-6.06 1.515"></path><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><circle cx="12" cy="6" r="2"></circle><circle cx="16" cy="12" r="2"></circle><circle cx="9" cy="15" r="2"></circle>',
		'chart-no-axes-column-decreasing'    => '<path d="M5 21V3"></path><path d="M12 21V9"></path><path d="M19 21v-6"></path>',
		'chart-no-axes-column-increasing'    => '<path d="M5 21v-6"></path><path d="M12 21V9"></path><path d="M19 21V3"></path>',
		'chart-no-axes-column'               => '<path d="M5 21v-6"></path><path d="M12 21V3"></path><path d="M19 21V9"></path>',
		'chart-no-axes-combined'             => '<path d="M12 16v5"></path><path d="M16 14v7"></path><path d="M20 10v11"></path><path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15"></path><path d="M4 18v3"></path><path d="M8 14v7"></path>',
		'chart-no-axes-gantt'                => '<path d="M6 5h12"></path><path d="M4 12h10"></path><path d="M12 19h8"></path>',
		'chart-pie'                          => '<path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z"></path><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>',
		'chart-scatter'                      => '<circle cx="7.5" cy="7.5" r=".5" fill="currentColor"></circle><circle cx="18.5" cy="5.5" r=".5" fill="currentColor"></circle><circle cx="11.5" cy="11.5" r=".5" fill="currentColor"></circle><circle cx="7.5" cy="16.5" r=".5" fill="currentColor"></circle><circle cx="17.5" cy="14.5" r=".5" fill="currentColor"></circle><path d="M3 3v16a2 2 0 0 0 2 2h16"></path>',
		'chart-spline'                       => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M7 16c.5-2 1.5-7 4-7 2 0 2 3 4 3 2.5 0 4.5-5 5-7"></path>',
		'check-check'                        => '<path d="M18 6 7 17l-5-5"></path><path d="m22 10-7.5 7.5L13 16"></path>',
		'check-line'                         => '<path d="M20 4L9 15"></path><path d="M21 19L3 19"></path><path d="M9 15L4 10"></path>',
		'check'                              => '<path d="M20 6 9 17l-5-5"></path>',
		'chef-hat'                           => '<path d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"></path><path d="M6 17h12"></path>',
		'cherry'                             => '<path d="M2 17a5 5 0 0 0 10 0c0-2.76-2.5-5-5-3-2.5-2-5 .24-5 3Z"></path><path d="M12 17a5 5 0 0 0 10 0c0-2.76-2.5-5-5-3-2.5-2-5 .24-5 3Z"></path><path d="M7 14c3.22-2.91 4.29-8.75 5-12 1.66 2.38 4.94 9 5 12"></path><path d="M22 9c-4.29 0-7.14-2.33-10-7 5.71 0 10 4.67 10 7Z"></path>',
		'chess-bishop'                       => '<path d="M5 20a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z"></path><path d="M15 18c1.5-.615 3-2.461 3-4.923C18 8.769 14.5 4.462 12 2 9.5 4.462 6 8.77 6 13.077 6 15.539 7.5 17.385 9 18"></path><path d="m16 7-2.5 2.5"></path><path d="M9 2h6"></path>',
		'chess-king'                         => '<path d="M4 20a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1z"></path><path d="m6.7 18-1-1C4.35 15.682 3 14.09 3 12a5 5 0 0 1 4.95-5c1.584 0 2.7.455 4.05 1.818C13.35 7.455 14.466 7 16.05 7A5 5 0 0 1 21 12c0 2.082-1.359 3.673-2.7 5l-1 1"></path><path d="M10 4h4"></path><path d="M12 2v6.818"></path>',
		'chess-knight'                       => '<path d="M5 20a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z"></path><path d="M16.5 18c1-2 2.5-5 2.5-9a7 7 0 0 0-7-7H6.635a1 1 0 0 0-.768 1.64L7 5l-2.32 5.802a2 2 0 0 0 .95 2.526l2.87 1.456"></path><path d="m15 5 1.425-1.425"></path><path d="m17 8 1.53-1.53"></path><path d="M9.713 12.185 7 18"></path>',
		'chess-pawn'                         => '<path d="M5 20a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z"></path><path d="m14.5 10 1.5 8"></path><path d="M7 10h10"></path><path d="m8 18 1.5-8"></path><circle cx="12" cy="6" r="4"></circle>',
		'chess-queen'                        => '<path d="M4 20a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1z"></path><path d="m12.474 5.943 1.567 5.34a1 1 0 0 0 1.75.328l2.616-3.402"></path><path d="m20 9-3 9"></path><path d="m5.594 8.209 2.615 3.403a1 1 0 0 0 1.75-.329l1.567-5.34"></path><path d="M7 18 4 9"></path><circle cx="12" cy="4" r="2"></circle><circle cx="20" cy="7" r="2"></circle><circle cx="4" cy="7" r="2"></circle>',
		'chess-rook'                         => '<path d="M5 20a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z"></path><path d="M10 2v2"></path><path d="M14 2v2"></path><path d="m17 18-1-9"></path><path d="M6 2v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2"></path><path d="M6 4h12"></path><path d="m7 18 1-9"></path>',
		'chevron-down'                       => '<path d="m6 9 6 6 6-6"></path>',
		'chevron-first'                      => '<path d="m17 18-6-6 6-6"></path><path d="M7 6v12"></path>',
		'chevron-last'                       => '<path d="m7 18 6-6-6-6"></path><path d="M17 6v12"></path>',
		'chevron-left'                       => '<path d="m15 18-6-6 6-6"></path>',
		'chevron-right'                      => '<path d="m9 18 6-6-6-6"></path>',
		'chevron-up'                         => '<path d="m18 15-6-6-6 6"></path>',
		'chevrons-down-up'                   => '<path d="m7 20 5-5 5 5"></path><path d="m7 4 5 5 5-5"></path>',
		'chevrons-down'                      => '<path d="m7 6 5 5 5-5"></path><path d="m7 13 5 5 5-5"></path>',
		'chevrons-left-right-ellipsis'       => '<path d="M12 12h.01"></path><path d="M16 12h.01"></path><path d="m17 7 5 5-5 5"></path><path d="m7 7-5 5 5 5"></path><path d="M8 12h.01"></path>',
		'chevrons-left-right'                => '<path d="m9 7-5 5 5 5"></path><path d="m15 7 5 5-5 5"></path>',
		'chevrons-left'                      => '<path d="m11 17-5-5 5-5"></path><path d="m18 17-5-5 5-5"></path>',
		'chevrons-right-left'                => '<path d="m20 17-5-5 5-5"></path><path d="m4 17 5-5-5-5"></path>',
		'chevrons-right'                     => '<path d="m6 17 5-5-5-5"></path><path d="m13 17 5-5-5-5"></path>',
		'chevrons-up-down'                   => '<path d="m7 15 5 5 5-5"></path><path d="m7 9 5-5 5 5"></path>',
		'chevrons-up'                        => '<path d="m17 11-5-5-5 5"></path><path d="m17 18-5-5-5 5"></path>',
		'chromium'                           => '<path d="M10.88 21.94 15.46 14"></path><path d="M21.17 8H12"></path><path d="M3.95 6.06 8.54 14"></path><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle>',
		'church'                             => '<path d="M10 9h4"></path><path d="M12 7v5"></path><path d="M14 21v-3a2 2 0 0 0-4 0v3"></path><path d="m18 9 3.52 2.147a1 1 0 0 1 .48.854V19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-6.999a1 1 0 0 1 .48-.854L6 9"></path><path d="M6 21V7a1 1 0 0 1 .376-.782l5-3.999a1 1 0 0 1 1.249.001l5 4A1 1 0 0 1 18 7v14"></path>',
		'cigarette-off'                      => '<path d="M12 12H3a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h13"></path><path d="M18 8c0-2.5-2-2.5-2-5"></path><path d="m2 2 20 20"></path><path d="M21 12a1 1 0 0 1 1 1v2a1 1 0 0 1-.5.866"></path><path d="M22 8c0-2.5-2-2.5-2-5"></path><path d="M7 12v4"></path>',
		'cigarette'                          => '<path d="M17 12H3a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14"></path><path d="M18 8c0-2.5-2-2.5-2-5"></path><path d="M21 16a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"></path><path d="M22 8c0-2.5-2-2.5-2-5"></path><path d="M7 12v4"></path>',
		'circle-alert'                       => '<circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line>',
		'circle-arrow-down'                  => '<circle cx="12" cy="12" r="10"></circle><path d="M12 8v8"></path><path d="m8 12 4 4 4-4"></path>',
		'circle-arrow-left'                  => '<circle cx="12" cy="12" r="10"></circle><path d="m12 8-4 4 4 4"></path><path d="M16 12H8"></path>',
		'circle-arrow-out-down-left'         => '<path d="M2 12a10 10 0 1 1 10 10"></path><path d="m2 22 10-10"></path><path d="M8 22H2v-6"></path>',
		'circle-arrow-out-down-right'        => '<path d="M12 22a10 10 0 1 1 10-10"></path><path d="M22 22 12 12"></path><path d="M22 16v6h-6"></path>',
		'circle-arrow-out-up-left'           => '<path d="M2 8V2h6"></path><path d="m2 2 10 10"></path><path d="M12 2A10 10 0 1 1 2 12"></path>',
		'circle-arrow-out-up-right'          => '<path d="M22 12A10 10 0 1 1 12 2"></path><path d="M22 2 12 12"></path><path d="M16 2h6v6"></path>',
		'circle-arrow-right'                 => '<circle cx="12" cy="12" r="10"></circle><path d="m12 16 4-4-4-4"></path><path d="M8 12h8"></path>',
		'circle-arrow-up'                    => '<circle cx="12" cy="12" r="10"></circle><path d="m16 12-4-4-4 4"></path><path d="M12 16V8"></path>',
		'circle-check-big'                   => '<path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path>',
		'circle-check'                       => '<circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path>',
		'circle-chevron-down'                => '<circle cx="12" cy="12" r="10"></circle><path d="m16 10-4 4-4-4"></path>',
		'circle-chevron-left'                => '<circle cx="12" cy="12" r="10"></circle><path d="m14 16-4-4 4-4"></path>',
		'circle-chevron-right'               => '<circle cx="12" cy="12" r="10"></circle><path d="m10 8 4 4-4 4"></path>',
		'circle-chevron-up'                  => '<circle cx="12" cy="12" r="10"></circle><path d="m8 14 4-4 4 4"></path>',
		'circle-dashed'                      => '<path d="M10.1 2.182a10 10 0 0 1 3.8 0"></path><path d="M13.9 21.818a10 10 0 0 1-3.8 0"></path><path d="M17.609 3.721a10 10 0 0 1 2.69 2.7"></path><path d="M2.182 13.9a10 10 0 0 1 0-3.8"></path><path d="M20.279 17.609a10 10 0 0 1-2.7 2.69"></path><path d="M21.818 10.1a10 10 0 0 1 0 3.8"></path><path d="M3.721 6.391a10 10 0 0 1 2.7-2.69"></path><path d="M6.391 20.279a10 10 0 0 1-2.69-2.7"></path>',
		'circle-divide'                      => '<line x1="8" x2="16" y1="12" y2="12"></line><line x1="12" x2="12" y1="16" y2="16"></line><line x1="12" x2="12" y1="8" y2="8"></line><circle cx="12" cy="12" r="10"></circle>',
		'circle-dollar-sign'                 => '<circle cx="12" cy="12" r="10"></circle><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path><path d="M12 18V6"></path>',
		'circle-dot-dashed'                  => '<path d="M10.1 2.18a9.93 9.93 0 0 1 3.8 0"></path><path d="M17.6 3.71a9.95 9.95 0 0 1 2.69 2.7"></path><path d="M21.82 10.1a9.93 9.93 0 0 1 0 3.8"></path><path d="M20.29 17.6a9.95 9.95 0 0 1-2.7 2.69"></path><path d="M13.9 21.82a9.94 9.94 0 0 1-3.8 0"></path><path d="M6.4 20.29a9.95 9.95 0 0 1-2.69-2.7"></path><path d="M2.18 13.9a9.93 9.93 0 0 1 0-3.8"></path><path d="M3.71 6.4a9.95 9.95 0 0 1 2.7-2.69"></path><circle cx="12" cy="12" r="1"></circle>',
		'circle-dot'                         => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="1"></circle>',
		'circle-ellipsis'                    => '<circle cx="12" cy="12" r="10"></circle><path d="M17 12h.01"></path><path d="M12 12h.01"></path><path d="M7 12h.01"></path>',
		'circle-equal'                       => '<path d="M7 10h10"></path><path d="M7 14h10"></path><circle cx="12" cy="12" r="10"></circle>',
		'circle-fading-arrow-up'             => '<path d="M12 2a10 10 0 0 1 7.38 16.75"></path><path d="m16 12-4-4-4 4"></path><path d="M12 16V8"></path><path d="M2.5 8.875a10 10 0 0 0-.5 3"></path><path d="M2.83 16a10 10 0 0 0 2.43 3.4"></path><path d="M4.636 5.235a10 10 0 0 1 .891-.857"></path><path d="M8.644 21.42a10 10 0 0 0 7.631-.38"></path>',
		'circle-fading-plus'                 => '<path d="M12 2a10 10 0 0 1 7.38 16.75"></path><path d="M12 8v8"></path><path d="M16 12H8"></path><path d="M2.5 8.875a10 10 0 0 0-.5 3"></path><path d="M2.83 16a10 10 0 0 0 2.43 3.4"></path><path d="M4.636 5.235a10 10 0 0 1 .891-.857"></path><path d="M8.644 21.42a10 10 0 0 0 7.631-.38"></path>',
		'circle-gauge'                       => '<path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path><circle cx="12" cy="12" r="2"></circle><path d="M13.4 10.6 19 5"></path>',
		'circle-minus'                       => '<circle cx="12" cy="12" r="10"></circle><path d="M8 12h8"></path>',
		'circle-off'                         => '<path d="m2 2 20 20"></path><path d="M8.35 2.69A10 10 0 0 1 21.3 15.65"></path><path d="M19.08 19.08A10 10 0 1 1 4.92 4.92"></path>',
		'circle-parking-off'                 => '<path d="M12.656 7H13a3 3 0 0 1 2.984 3.307"></path><path d="M13 13H9"></path><path d="M19.071 19.071A1 1 0 0 1 4.93 4.93"></path><path d="m2 2 20 20"></path><path d="M8.357 2.687a10 10 0 0 1 12.956 12.956"></path><path d="M9 17V9"></path>',
		'circle-parking'                     => '<circle cx="12" cy="12" r="10"></circle><path d="M9 17V7h4a3 3 0 0 1 0 6H9"></path>',
		'circle-pause'                       => '<circle cx="12" cy="12" r="10"></circle><line x1="10" x2="10" y1="15" y2="9"></line><line x1="14" x2="14" y1="15" y2="9"></line>',
		'circle-percent'                     => '<circle cx="12" cy="12" r="10"></circle><path d="m15 9-6 6"></path><path d="M9 9h.01"></path><path d="M15 15h.01"></path>',
		'circle-pile'                        => '<circle cx="12" cy="19" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="16" cy="12" r="2"></circle><circle cx="20" cy="19" r="2"></circle><circle cx="4" cy="19" r="2"></circle><circle cx="8" cy="12" r="2"></circle>',
		'circle-play'                        => '<path d="M9 9.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997A1 1 0 0 1 9 14.996z"></path><circle cx="12" cy="12" r="10"></circle>',
		'circle-plus'                        => '<circle cx="12" cy="12" r="10"></circle><path d="M8 12h8"></path><path d="M12 8v8"></path>',
		'circle-pound-sterling'              => '<path d="M10 16V9.5a1 1 0 0 1 5 0"></path><path d="M8 12h4"></path><path d="M8 16h7"></path><circle cx="12" cy="12" r="10"></circle>',
		'circle-power'                       => '<path d="M12 7v4"></path><path d="M7.998 9.003a5 5 0 1 0 8-.005"></path><circle cx="12" cy="12" r="10"></circle>',
		'circle-question-mark'               => '<circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path>',
		'circle-slash-2'                     => '<path d="M22 2 2 22"></path><circle cx="12" cy="12" r="10"></circle>',
		'circle-slash'                       => '<circle cx="12" cy="12" r="10"></circle><line x1="9" x2="15" y1="15" y2="9"></line>',
		'circle-small'                       => '<circle cx="12" cy="12" r="6"></circle>',
		'circle-star'                        => '<path d="M11.051 7.616a1 1 0 0 1 1.909.024l.737 1.452a1 1 0 0 0 .737.535l1.634.256a1 1 0 0 1 .588 1.806l-1.172 1.168a1 1 0 0 0-.282.866l.259 1.613a1 1 0 0 1-1.541 1.134l-1.465-.75a1 1 0 0 0-.912 0l-1.465.75a1 1 0 0 1-1.539-1.133l.258-1.613a1 1 0 0 0-.282-.867l-1.156-1.152a1 1 0 0 1 .572-1.822l1.633-.256a1 1 0 0 0 .737-.535z"></path><circle cx="12" cy="12" r="10"></circle>',
		'circle-stop'                        => '<circle cx="12" cy="12" r="10"></circle><rect x="9" y="9" width="6" height="6" rx="1"></rect>',
		'circle-user-round'                  => '<path d="M18 20a6 6 0 0 0-12 0"></path><circle cx="12" cy="10" r="4"></circle><circle cx="12" cy="12" r="10"></circle>',
		'circle-user'                        => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="10" r="3"></circle><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>',
		'circle-x'                           => '<circle cx="12" cy="12" r="10"></circle><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path>',
		'circle'                             => '<circle cx="12" cy="12" r="10"></circle>',
		'circuit-board'                      => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M11 9h4a2 2 0 0 0 2-2V3"></path><circle cx="9" cy="9" r="2"></circle><path d="M7 21v-4a2 2 0 0 1 2-2h4"></path><circle cx="15" cy="15" r="2"></circle>',
		'citrus'                             => '<path d="M21.66 17.67a1.08 1.08 0 0 1-.04 1.6A12 12 0 0 1 4.73 2.38a1.1 1.1 0 0 1 1.61-.04z"></path><path d="M19.65 15.66A8 8 0 0 1 8.35 4.34"></path><path d="m14 10-5.5 5.5"></path><path d="M14 17.85V10H6.15"></path>',
		'clapperboard'                       => '<path d="M20.2 6 3 11l-.9-2.4c-.3-1.1.3-2.2 1.3-2.5l13.5-4c1.1-.3 2.2.3 2.5 1.3Z"></path><path d="m6.2 5.3 3.1 3.9"></path><path d="m12.4 3.4 3.1 4"></path><path d="M3 11h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"></path>',
		'clipboard-check'                    => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="m9 14 2 2 4-4"></path>',
		'clipboard-clock'                    => '<path d="M16 14v2.2l1.6 1"></path><path d="M16 4h2a2 2 0 0 1 2 2v.832"></path><path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h2"></path><circle cx="16" cy="16" r="6"></circle><rect x="8" y="2" width="8" height="4" rx="1"></rect>',
		'clipboard-copy'                     => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"></path><path d="M16 4h2a2 2 0 0 1 2 2v4"></path><path d="M21 14H11"></path><path d="m15 10-4 4 4 4"></path>',
		'clipboard-list'                     => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="M12 11h4"></path><path d="M12 16h4"></path><path d="M8 11h.01"></path><path d="M8 16h.01"></path>',
		'clipboard-minus'                    => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="M9 14h6"></path>',
		'clipboard-paste'                    => '<path d="M11 14h10"></path><path d="M16 4h2a2 2 0 0 1 2 2v1.344"></path><path d="m17 18 4-4-4-4"></path><path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 1.793-1.113"></path><rect x="8" y="2" width="8" height="4" rx="1"></rect>',
		'clipboard-pen-line'                 => '<rect width="8" height="4" x="8" y="2" rx="1"></rect><path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.5"></path><path d="M16 4h2a2 2 0 0 1 1.73 1"></path><path d="M8 18h1"></path><path d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path>',
		'clipboard-pen'                      => '<rect width="8" height="4" x="8" y="2" rx="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5"></path><path d="M4 13.5V6a2 2 0 0 1 2-2h2"></path><path d="M13.378 15.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path>',
		'clipboard-plus'                     => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="M9 14h6"></path><path d="M12 17v-6"></path>',
		'clipboard-type'                     => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="M9 12v-1h6v1"></path><path d="M11 17h2"></path><path d="M12 11v6"></path>',
		'clipboard-x'                        => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="m15 11-6 6"></path><path d="m9 11 6 6"></path>',
		'clipboard'                          => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>',
		'clock-1'                            => '<path d="M12 6v6l2-4"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-10'                           => '<path d="M12 6v6l-4-2"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-11'                           => '<path d="M12 6v6l-2-4"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-12'                           => '<path d="M12 6v6"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-2'                            => '<path d="M12 6v6l4-2"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-3'                            => '<path d="M12 6v6h4"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-4'                            => '<path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-5'                            => '<path d="M12 6v6l2 4"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-6'                            => '<path d="M12 6v10"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-7'                            => '<path d="M12 6v6l-2 4"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-8'                            => '<path d="M12 6v6l-4 2"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-9'                            => '<path d="M12 6v6H8"></path><circle cx="12" cy="12" r="10"></circle>',
		'clock-alert'                        => '<path d="M12 6v6l4 2"></path><path d="M20 12v5"></path><path d="M20 21h.01"></path><path d="M21.25 8.2A10 10 0 1 0 16 21.16"></path>',
		'clock-arrow-down'                   => '<path d="M12 6v6l2 1"></path><path d="M12.337 21.994a10 10 0 1 1 9.588-8.767"></path><path d="m14 18 4 4 4-4"></path><path d="M18 14v8"></path>',
		'clock-arrow-up'                     => '<path d="M12 6v6l1.56.78"></path><path d="M13.227 21.925a10 10 0 1 1 8.767-9.588"></path><path d="m14 18 4-4 4 4"></path><path d="M18 22v-8"></path>',
		'clock-check'                        => '<path d="M12 6v6l4 2"></path><path d="M22 12a10 10 0 1 0-11 9.95"></path><path d="m22 16-5.5 5.5L14 19"></path>',
		'clock-fading'                       => '<path d="M12 2a10 10 0 0 1 7.38 16.75"></path><path d="M12 6v6l4 2"></path><path d="M2.5 8.875a10 10 0 0 0-.5 3"></path><path d="M2.83 16a10 10 0 0 0 2.43 3.4"></path><path d="M4.636 5.235a10 10 0 0 1 .891-.857"></path><path d="M8.644 21.42a10 10 0 0 0 7.631-.38"></path>',
		'clock-plus'                         => '<path d="M12 6v6l3.644 1.822"></path><path d="M16 19h6"></path><path d="M19 16v6"></path><path d="M21.92 13.267a10 10 0 1 0-8.653 8.653"></path>',
		'clock'                              => '<path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle>',
		'closed-caption'                     => '<path d="M10 9.17a3 3 0 1 0 0 5.66"></path><path d="M17 9.17a3 3 0 1 0 0 5.66"></path><rect x="2" y="5" width="20" height="14" rx="2"></rect>',
		'cloud-alert'                        => '<path d="M12 12v4"></path><path d="M12 20h.01"></path><path d="M17 18h.5a1 1 0 0 0 0-9h-1.79A7 7 0 1 0 7 17.708"></path>',
		'cloud-backup'                       => '<path d="M21 15.251A4.5 4.5 0 0 0 17.5 8h-1.79A7 7 0 1 0 3 13.607"></path><path d="M7 11v4h4"></path><path d="M8 19a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5 4.82 4.82 0 0 0-3.41 1.41L7 15"></path>',
		'cloud-check'                        => '<path d="m17 15-5.5 5.5L9 18"></path><path d="M5 17.743A7 7 0 1 1 15.71 10h1.79a4.5 4.5 0 0 1 1.5 8.742"></path>',
		'cloud-cog'                          => '<path d="m10.852 19.772-.383.924"></path><path d="m13.148 14.228.383-.923"></path><path d="M13.148 19.772a3 3 0 1 0-2.296-5.544l-.383-.923"></path><path d="m13.53 20.696-.382-.924a3 3 0 1 1-2.296-5.544"></path><path d="m14.772 15.852.923-.383"></path><path d="m14.772 18.148.923.383"></path><path d="M4.2 15.1a7 7 0 1 1 9.93-9.858A7 7 0 0 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.2"></path><path d="m9.228 15.852-.923-.383"></path><path d="m9.228 18.148-.923.383"></path>',
		'cloud-download'                     => '<path d="M12 13v8l-4-4"></path><path d="m12 21 4-4"></path><path d="M4.393 15.269A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.436 8.284"></path>',
		'cloud-drizzle'                      => '<path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="M8 19v1"></path><path d="M8 14v1"></path><path d="M16 19v1"></path><path d="M16 14v1"></path><path d="M12 21v1"></path><path d="M12 16v1"></path>',
		'cloud-fog'                          => '<path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="M16 17H7"></path><path d="M17 21H9"></path>',
		'cloud-hail'                         => '<path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="M16 14v2"></path><path d="M8 14v2"></path><path d="M16 20h.01"></path><path d="M8 20h.01"></path><path d="M12 16v2"></path><path d="M12 22h.01"></path>',
		'cloud-lightning'                    => '<path d="M6 16.326A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 .5 8.973"></path><path d="m13 12-3 5h4l-3 5"></path>',
		'cloud-moon-rain'                    => '<path d="M11 20v2"></path><path d="M18.376 14.512a6 6 0 0 0 3.461-4.127c.148-.625-.659-.97-1.248-.714a4 4 0 0 1-5.259-5.26c.255-.589-.09-1.395-.716-1.248a6 6 0 0 0-4.594 5.36"></path><path d="M3 20a5 5 0 1 1 8.9-4H13a3 3 0 0 1 2 5.24"></path><path d="M7 19v2"></path>',
		'cloud-moon'                         => '<path d="M13 16a3 3 0 0 1 0 6H7a5 5 0 1 1 4.9-6z"></path><path d="M18.376 14.512a6 6 0 0 0 3.461-4.127c.148-.625-.659-.97-1.248-.714a4 4 0 0 1-5.259-5.26c.255-.589-.09-1.395-.716-1.248a6 6 0 0 0-4.594 5.36"></path>',
		'cloud-off'                          => '<path d="M10.94 5.274A7 7 0 0 1 15.71 10h1.79a4.5 4.5 0 0 1 4.222 6.057"></path><path d="M18.796 18.81A4.5 4.5 0 0 1 17.5 19H9A7 7 0 0 1 5.79 5.78"></path><path d="m2 2 20 20"></path>',
		'cloud-rain-wind'                    => '<path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="m9.2 22 3-7"></path><path d="m9 13-3 7"></path><path d="m17 13-3 7"></path>',
		'cloud-rain'                         => '<path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="M16 14v6"></path><path d="M8 14v6"></path><path d="M12 16v6"></path>',
		'cloud-snow'                         => '<path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="M8 15h.01"></path><path d="M8 19h.01"></path><path d="M12 17h.01"></path><path d="M12 21h.01"></path><path d="M16 15h.01"></path><path d="M16 19h.01"></path>',
		'cloud-sun-rain'                     => '<path d="M12 2v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="M20 12h2"></path><path d="m19.07 4.93-1.41 1.41"></path><path d="M15.947 12.65a4 4 0 0 0-5.925-4.128"></path><path d="M3 20a5 5 0 1 1 8.9-4H13a3 3 0 0 1 2 5.24"></path><path d="M11 20v2"></path><path d="M7 19v2"></path>',
		'cloud-sun'                          => '<path d="M12 2v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="M20 12h2"></path><path d="m19.07 4.93-1.41 1.41"></path><path d="M15.947 12.65a4 4 0 0 0-5.925-4.128"></path><path d="M13 22H7a5 5 0 1 1 4.9-6H13a3 3 0 0 1 0 6Z"></path>',
		'cloud-sync'                         => '<path d="m17 18-1.535 1.605a5 5 0 0 1-8-1.5"></path><path d="M17 22v-4h-4"></path><path d="M20.996 15.251A4.5 4.5 0 0 0 17.495 8h-1.79a7 7 0 1 0-12.709 5.607"></path><path d="M7 10v4h4"></path><path d="m7 14 1.535-1.605a5 5 0 0 1 8 1.5"></path>',
		'cloud-upload'                       => '<path d="M12 13v8"></path><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="m8 17 4-4 4 4"></path>',
		'cloud'                              => '<path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"></path>',
		'cloudy'                             => '<path d="M17.5 12a1 1 0 1 1 0 9H9.006a7 7 0 1 1 6.702-9z"></path><path d="M21.832 9A3 3 0 0 0 19 7h-2.207a5.5 5.5 0 0 0-10.72.61"></path>',
		'clover'                             => '<path d="M16.17 7.83 2 22"></path><path d="M4.02 12a2.827 2.827 0 1 1 3.81-4.17A2.827 2.827 0 1 1 12 4.02a2.827 2.827 0 1 1 4.17 3.81A2.827 2.827 0 1 1 19.98 12a2.827 2.827 0 1 1-3.81 4.17A2.827 2.827 0 1 1 12 19.98a2.827 2.827 0 1 1-4.17-3.81A1 1 0 1 1 4 12"></path><path d="m7.83 7.83 8.34 8.34"></path>',
		'club'                               => '<path d="M17.28 9.05a5.5 5.5 0 1 0-10.56 0A5.5 5.5 0 1 0 12 17.66a5.5 5.5 0 1 0 5.28-8.6Z"></path><path d="M12 17.66L12 22"></path>',
		'code-xml'                           => '<path d="m18 16 4-4-4-4"></path><path d="m6 8-4 4 4 4"></path><path d="m14.5 4-5 16"></path>',
		'code'                               => '<path d="m16 18 6-6-6-6"></path><path d="m8 6-6 6 6 6"></path>',
		'codepen'                            => '<polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"></polygon><line x1="12" x2="12" y1="22" y2="15.5"></line><polyline points="22 8.5 12 15.5 2 8.5"></polyline><polyline points="2 15.5 12 8.5 22 15.5"></polyline><line x1="12" x2="12" y1="2" y2="8.5"></line>',
		'codesandbox'                        => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="7.5 4.21 12 6.81 16.5 4.21"></polyline><polyline points="7.5 19.79 7.5 14.6 3 12"></polyline><polyline points="21 12 16.5 14.6 16.5 19.79"></polyline><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" x2="12" y1="22.08" y2="12"></line>',
		'coffee'                             => '<path d="M10 2v2"></path><path d="M14 2v2"></path><path d="M16 8a1 1 0 0 1 1 1v8a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V9a1 1 0 0 1 1-1h14a4 4 0 1 1 0 8h-1"></path><path d="M6 2v2"></path>',
		'cog'                                => '<path d="M11 10.27 7 3.34"></path><path d="m11 13.73-4 6.93"></path><path d="M12 22v-2"></path><path d="M12 2v2"></path><path d="M14 12h8"></path><path d="m17 20.66-1-1.73"></path><path d="m17 3.34-1 1.73"></path><path d="M2 12h2"></path><path d="m20.66 17-1.73-1"></path><path d="m20.66 7-1.73 1"></path><path d="m3.34 17 1.73-1"></path><path d="m3.34 7 1.73 1"></path><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="12" r="8"></circle>',
		'coins'                              => '<circle cx="8" cy="8" r="6"></circle><path d="M18.09 10.37A6 6 0 1 1 10.34 18"></path><path d="M7 6h1v4"></path><path d="m16.71 13.88.7.71-2.82 2.82"></path>',
		'columns-2'                          => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M12 3v18"></path>',
		'columns-3-cog'                      => '<path d="M10.5 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5.5"></path><path d="m14.3 19.6 1-.4"></path><path d="M15 3v7.5"></path><path d="m15.2 16.9-.9-.3"></path><path d="m16.6 21.7.3-.9"></path><path d="m16.8 15.3-.4-1"></path><path d="m19.1 15.2.3-.9"></path><path d="m19.6 21.7-.4-1"></path><path d="m20.7 16.8 1-.4"></path><path d="m21.7 19.4-.9-.3"></path><path d="M9 3v18"></path><circle cx="18" cy="18" r="3"></circle>',
		'columns-3'                          => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 3v18"></path><path d="M15 3v18"></path>',
		'columns-4'                          => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7.5 3v18"></path><path d="M12 3v18"></path><path d="M16.5 3v18"></path>',
		'combine'                            => '<path d="M14 3a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1"></path><path d="M19 3a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1"></path><path d="m7 15 3 3"></path><path d="m7 21 3-3H5a2 2 0 0 1-2-2v-2"></path><rect x="14" y="14" width="7" height="7" rx="1"></rect><rect x="3" y="3" width="7" height="7" rx="1"></rect>',
		'command'                            => '<path d="M15 6v12a3 3 0 1 0 3-3H6a3 3 0 1 0 3 3V6a3 3 0 1 0-3 3h12a3 3 0 1 0-3-3"></path>',
		'compass'                            => '<path d="m16.24 7.76-1.804 5.411a2 2 0 0 1-1.265 1.265L7.76 16.24l1.804-5.411a2 2 0 0 1 1.265-1.265z"></path><circle cx="12" cy="12" r="10"></circle>',
		'component'                          => '<path d="M15.536 11.293a1 1 0 0 0 0 1.414l2.376 2.377a1 1 0 0 0 1.414 0l2.377-2.377a1 1 0 0 0 0-1.414l-2.377-2.377a1 1 0 0 0-1.414 0z"></path><path d="M2.297 11.293a1 1 0 0 0 0 1.414l2.377 2.377a1 1 0 0 0 1.414 0l2.377-2.377a1 1 0 0 0 0-1.414L6.088 8.916a1 1 0 0 0-1.414 0z"></path><path d="M8.916 17.912a1 1 0 0 0 0 1.415l2.377 2.376a1 1 0 0 0 1.414 0l2.377-2.376a1 1 0 0 0 0-1.415l-2.377-2.376a1 1 0 0 0-1.414 0z"></path><path d="M8.916 4.674a1 1 0 0 0 0 1.414l2.377 2.376a1 1 0 0 0 1.414 0l2.377-2.376a1 1 0 0 0 0-1.414l-2.377-2.377a1 1 0 0 0-1.414 0z"></path>',
		'computer'                           => '<rect width="14" height="8" x="5" y="2" rx="2"></rect><rect width="20" height="8" x="2" y="14" rx="2"></rect><path d="M6 18h2"></path><path d="M12 18h6"></path>',
		'concierge-bell'                     => '<path d="M3 20a1 1 0 0 1-1-1v-1a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1Z"></path><path d="M20 16a8 8 0 1 0-16 0"></path><path d="M12 4v4"></path><path d="M10 4h4"></path>',
		'cone'                               => '<path d="m20.9 18.55-8-15.98a1 1 0 0 0-1.8 0l-8 15.98"></path><ellipse cx="12" cy="19" rx="9" ry="3"></ellipse>',
		'construction'                       => '<rect x="2" y="6" width="20" height="8" rx="1"></rect><path d="M17 14v7"></path><path d="M7 14v7"></path><path d="M17 3v3"></path><path d="M7 3v3"></path><path d="M10 14 2.3 6.3"></path><path d="m14 6 7.7 7.7"></path><path d="m8 6 8 8"></path>',
		'contact-round'                      => '<path d="M16 2v2"></path><path d="M17.915 22a6 6 0 0 0-12 0"></path><path d="M8 2v2"></path><circle cx="12" cy="12" r="4"></circle><rect x="3" y="4" width="18" height="18" rx="2"></rect>',
		'contact'                            => '<path d="M16 2v2"></path><path d="M7 22v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"></path><path d="M8 2v2"></path><circle cx="12" cy="11" r="3"></circle><rect x="3" y="4" width="18" height="18" rx="2"></rect>',
		'container'                          => '<path d="M22 7.7c0-.6-.4-1.2-.8-1.5l-6.3-3.9a1.72 1.72 0 0 0-1.7 0l-10.3 6c-.5.2-.9.8-.9 1.4v6.6c0 .5.4 1.2.8 1.5l6.3 3.9a1.72 1.72 0 0 0 1.7 0l10.3-6c.5-.3.9-1 .9-1.5Z"></path><path d="M10 21.9V14L2.1 9.1"></path><path d="m10 14 11.9-6.9"></path><path d="M14 19.8v-8.1"></path><path d="M18 17.5V9.4"></path>',
		'contrast'                           => '<circle cx="12" cy="12" r="10"></circle><path d="M12 18a6 6 0 0 0 0-12v12z"></path>',
		'cookie'                             => '<path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"></path><path d="M8.5 8.5v.01"></path><path d="M16 15.5v.01"></path><path d="M12 12v.01"></path><path d="M11 17v.01"></path><path d="M7 14v.01"></path>',
		'cooking-pot'                        => '<path d="M2 12h20"></path><path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"></path><path d="m4 8 16-4"></path><path d="m8.86 6.78-.45-1.81a2 2 0 0 1 1.45-2.43l1.94-.48a2 2 0 0 1 2.43 1.46l.45 1.8"></path>',
		'copy-check'                         => '<path d="m12 15 2 2 4-4"></path><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>',
		'copy-minus'                         => '<line x1="12" x2="18" y1="15" y2="15"></line><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>',
		'copy-plus'                          => '<line x1="15" x2="15" y1="12" y2="18"></line><line x1="12" x2="18" y1="15" y2="15"></line><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>',
		'copy-slash'                         => '<line x1="12" x2="18" y1="18" y2="12"></line><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>',
		'copy-x'                             => '<line x1="12" x2="18" y1="12" y2="18"></line><line x1="12" x2="18" y1="18" y2="12"></line><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>',
		'copy'                               => '<rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>',
		'copyleft'                           => '<circle cx="12" cy="12" r="10"></circle><path d="M9.17 14.83a4 4 0 1 0 0-5.66"></path>',
		'copyright'                          => '<circle cx="12" cy="12" r="10"></circle><path d="M14.83 14.83a4 4 0 1 1 0-5.66"></path>',
		'corner-down-left'                   => '<path d="M20 4v7a4 4 0 0 1-4 4H4"></path><path d="m9 10-5 5 5 5"></path>',
		'corner-down-right'                  => '<path d="m15 10 5 5-5 5"></path><path d="M4 4v7a4 4 0 0 0 4 4h12"></path>',
		'corner-left-down'                   => '<path d="m14 15-5 5-5-5"></path><path d="M20 4h-7a4 4 0 0 0-4 4v12"></path>',
		'corner-left-up'                     => '<path d="M14 9 9 4 4 9"></path><path d="M20 20h-7a4 4 0 0 1-4-4V4"></path>',
		'corner-right-down'                  => '<path d="m10 15 5 5 5-5"></path><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>',
		'corner-right-up'                    => '<path d="m10 9 5-5 5 5"></path><path d="M4 20h7a4 4 0 0 0 4-4V4"></path>',
		'corner-up-left'                     => '<path d="M20 20v-7a4 4 0 0 0-4-4H4"></path><path d="M9 14 4 9l5-5"></path>',
		'corner-up-right'                    => '<path d="m15 14 5-5-5-5"></path><path d="M4 20v-7a4 4 0 0 1 4-4h12"></path>',
		'cpu'                                => '<path d="M12 20v2"></path><path d="M12 2v2"></path><path d="M17 20v2"></path><path d="M17 2v2"></path><path d="M2 12h2"></path><path d="M2 17h2"></path><path d="M2 7h2"></path><path d="M20 12h2"></path><path d="M20 17h2"></path><path d="M20 7h2"></path><path d="M7 20v2"></path><path d="M7 2v2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect>',
		'creative-commons'                   => '<circle cx="12" cy="12" r="10"></circle><path d="M10 9.3a2.8 2.8 0 0 0-3.5 1 3.1 3.1 0 0 0 0 3.4 2.7 2.7 0 0 0 3.5 1"></path><path d="M17 9.3a2.8 2.8 0 0 0-3.5 1 3.1 3.1 0 0 0 0 3.4 2.7 2.7 0 0 0 3.5 1"></path>',
		'credit-card'                        => '<rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line>',
		'croissant'                          => '<path d="M10.2 18H4.774a1.5 1.5 0 0 1-1.352-.97 11 11 0 0 1 .132-6.487"></path><path d="M18 10.2V4.774a1.5 1.5 0 0 0-.97-1.352 11 11 0 0 0-6.486.132"></path><path d="M18 5a4 3 0 0 1 4 3 2 2 0 0 1-2 2 10 10 0 0 0-5.139 1.42"></path><path d="M5 18a3 4 0 0 0 3 4 2 2 0 0 0 2-2 10 10 0 0 1 1.42-5.14"></path><path d="M8.709 2.554a10 10 0 0 0-6.155 6.155 1.5 1.5 0 0 0 .676 1.626l9.807 5.42a2 2 0 0 0 2.718-2.718l-5.42-9.807a1.5 1.5 0 0 0-1.626-.676"></path>',
		'crop'                               => '<path d="M6 2v14a2 2 0 0 0 2 2h14"></path><path d="M18 22V8a2 2 0 0 0-2-2H2"></path>',
		'cross'                              => '<path d="M4 9a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4a1 1 0 0 1 1 1v4a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-4a1 1 0 0 1 1-1h4a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-4a1 1 0 0 1-1-1V4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4a1 1 0 0 1-1 1z"></path>',
		'crosshair'                          => '<circle cx="12" cy="12" r="10"></circle><line x1="22" x2="18" y1="12" y2="12"></line><line x1="6" x2="2" y1="12" y2="12"></line><line x1="12" x2="12" y1="6" y2="2"></line><line x1="12" x2="12" y1="22" y2="18"></line>',
		'crown'                              => '<path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"></path><path d="M5 21h14"></path>',
		'cuboid'                             => '<path d="m21.12 6.4-6.05-4.06a2 2 0 0 0-2.17-.05L2.95 8.41a2 2 0 0 0-.95 1.7v5.82a2 2 0 0 0 .88 1.66l6.05 4.07a2 2 0 0 0 2.17.05l9.95-6.12a2 2 0 0 0 .95-1.7V8.06a2 2 0 0 0-.88-1.66Z"></path><path d="M10 22v-8L2.25 9.15"></path><path d="m10 14 11.77-6.87"></path>',
		'cup-soda'                           => '<path d="m6 8 1.75 12.28a2 2 0 0 0 2 1.72h4.54a2 2 0 0 0 2-1.72L18 8"></path><path d="M5 8h14"></path><path d="M7 15a6.47 6.47 0 0 1 5 0 6.47 6.47 0 0 0 5 0"></path><path d="m12 8 1-6h2"></path>',
		'currency'                           => '<circle cx="12" cy="12" r="8"></circle><line x1="3" x2="6" y1="3" y2="6"></line><line x1="21" x2="18" y1="3" y2="6"></line><line x1="3" x2="6" y1="21" y2="18"></line><line x1="21" x2="18" y1="21" y2="18"></line>',
		'cylinder'                           => '<ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5v14a9 3 0 0 0 18 0V5"></path>',
		'dam'                                => '<path d="M11 11.31c1.17.56 1.54 1.69 3.5 1.69 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="M11.75 18c.35.5 1.45 1 2.75 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="M2 10h4"></path><path d="M2 14h4"></path><path d="M2 18h4"></path><path d="M2 6h4"></path><path d="M7 3a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1L10 4a1 1 0 0 0-1-1z"></path>',
		'database-backup'                    => '<ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 12a9 3 0 0 0 5 2.69"></path><path d="M21 9.3V5"></path><path d="M3 5v14a9 3 0 0 0 6.47 2.88"></path><path d="M12 12v4h4"></path><path d="M13 20a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L12 16"></path>',
		'database-zap'                       => '<ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5V19A9 3 0 0 0 15 21.84"></path><path d="M21 5V8"></path><path d="M21 12L18 17H22L19 22"></path><path d="M3 12A9 3 0 0 0 14.59 14.87"></path>',
		'database'                           => '<ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5V19A9 3 0 0 0 21 19V5"></path><path d="M3 12A9 3 0 0 0 21 12"></path>',
		'decimals-arrow-left'                => '<path d="m13 21-3-3 3-3"></path><path d="M20 18H10"></path><path d="M3 11h.01"></path><rect x="6" y="3" width="5" height="8" rx="2.5"></rect>',
		'decimals-arrow-right'               => '<path d="M10 18h10"></path><path d="m17 21 3-3-3-3"></path><path d="M3 11h.01"></path><rect x="15" y="3" width="5" height="8" rx="2.5"></rect><rect x="6" y="3" width="5" height="8" rx="2.5"></rect>',
		'delete'                             => '<path d="M10 5a2 2 0 0 0-1.344.519l-6.328 5.74a1 1 0 0 0 0 1.481l6.328 5.741A2 2 0 0 0 10 19h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2z"></path><path d="m12 9 6 6"></path><path d="m18 9-6 6"></path>',
		'dessert'                            => '<path d="M10.162 3.167A10 10 0 0 0 2 13a2 2 0 0 0 4 0v-1a2 2 0 0 1 4 0v4a2 2 0 0 0 4 0v-4a2 2 0 0 1 4 0v1a2 2 0 0 0 4-.006 10 10 0 0 0-8.161-9.826"></path><path d="M20.804 14.869a9 9 0 0 1-17.608 0"></path><circle cx="12" cy="4" r="2"></circle>',
		'diameter'                           => '<circle cx="19" cy="19" r="2"></circle><circle cx="5" cy="5" r="2"></circle><path d="M6.48 3.66a10 10 0 0 1 13.86 13.86"></path><path d="m6.41 6.41 11.18 11.18"></path><path d="M3.66 6.48a10 10 0 0 0 13.86 13.86"></path>',
		'diamond-minus'                      => '<path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41L13.7 2.71a2.41 2.41 0 0 0-3.41 0z"></path><path d="M8 12h8"></path>',
		'diamond-percent'                    => '<path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41L13.7 2.71a2.41 2.41 0 0 0-3.41 0Z"></path><path d="M9.2 9.2h.01"></path><path d="m14.5 9.5-5 5"></path><path d="M14.7 14.8h.01"></path>',
		'diamond-plus'                       => '<path d="M12 8v8"></path><path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41L13.7 2.71a2.41 2.41 0 0 0-3.41 0z"></path><path d="M8 12h8"></path>',
		'diamond'                            => '<path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41l-7.59-7.59a2.41 2.41 0 0 0-3.41 0Z"></path>',
		'dice-1'                             => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="M12 12h.01"></path>',
		'dice-2'                             => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="M15 9h.01"></path><path d="M9 15h.01"></path>',
		'dice-3'                             => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="M16 8h.01"></path><path d="M12 12h.01"></path><path d="M8 16h.01"></path>',
		'dice-4'                             => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="M16 8h.01"></path><path d="M8 8h.01"></path><path d="M8 16h.01"></path><path d="M16 16h.01"></path>',
		'dice-5'                             => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="M16 8h.01"></path><path d="M8 8h.01"></path><path d="M8 16h.01"></path><path d="M16 16h.01"></path><path d="M12 12h.01"></path>',
		'dice-6'                             => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="M16 8h.01"></path><path d="M16 12h.01"></path><path d="M16 16h.01"></path><path d="M8 8h.01"></path><path d="M8 12h.01"></path><path d="M8 16h.01"></path>',
		'dices'                              => '<rect width="12" height="12" x="2" y="10" rx="2" ry="2"></rect><path d="m17.92 14 3.5-3.5a2.24 2.24 0 0 0 0-3l-5-4.92a2.24 2.24 0 0 0-3 0L10 6"></path><path d="M6 18h.01"></path><path d="M10 14h.01"></path><path d="M15 6h.01"></path><path d="M18 9h.01"></path>',
		'diff'                               => '<path d="M12 3v14"></path><path d="M5 10h14"></path><path d="M5 21h14"></path>',
		'disc-2'                             => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><path d="M12 12h.01"></path>',
		'disc-3'                             => '<circle cx="12" cy="12" r="10"></circle><path d="M6 12c0-1.7.7-3.2 1.8-4.2"></path><circle cx="12" cy="12" r="2"></circle><path d="M18 12c0 1.7-.7 3.2-1.8 4.2"></path>',
		'disc-album'                         => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="12" cy="12" r="5"></circle><path d="M12 12h.01"></path>',
		'disc'                               => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="2"></circle>',
		'divide'                             => '<circle cx="12" cy="6" r="1"></circle><line x1="5" x2="19" y1="12" y2="12"></line><circle cx="12" cy="18" r="1"></circle>',
		'dna-off'                            => '<path d="M15 2c-1.35 1.5-2.092 3-2.5 4.5L14 8"></path><path d="m17 6-2.891-2.891"></path><path d="M2 15c3.333-3 6.667-3 10-3"></path><path d="m2 2 20 20"></path><path d="m20 9 .891.891"></path><path d="M22 9c-1.5 1.35-3 2.092-4.5 2.5l-1-1"></path><path d="M3.109 14.109 4 15"></path><path d="m6.5 12.5 1 1"></path><path d="m7 18 2.891 2.891"></path><path d="M9 22c1.35-1.5 2.092-3 2.5-4.5L10 16"></path>',
		'dna'                                => '<path d="m10 16 1.5 1.5"></path><path d="m14 8-1.5-1.5"></path><path d="M15 2c-1.798 1.998-2.518 3.995-2.807 5.993"></path><path d="m16.5 10.5 1 1"></path><path d="m17 6-2.891-2.891"></path><path d="M2 15c6.667-6 13.333 0 20-6"></path><path d="m20 9 .891.891"></path><path d="M3.109 14.109 4 15"></path><path d="m6.5 12.5 1 1"></path><path d="m7 18 2.891 2.891"></path><path d="M9 22c1.798-1.998 2.518-3.995 2.807-5.993"></path>',
		'dock'                               => '<path d="M2 8h20"></path><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="M6 16h12"></path>',
		'dog'                                => '<path d="M11.25 16.25h1.5L12 17z"></path><path d="M16 14v.5"></path><path d="M4.42 11.247A13.152 13.152 0 0 0 4 14.556C4 18.728 7.582 21 12 21s8-2.272 8-6.444a11.702 11.702 0 0 0-.493-3.309"></path><path d="M8 14v.5"></path><path d="M8.5 8.5c-.384 1.05-1.083 2.028-2.344 2.5-1.931.722-3.576-.297-3.656-1-.113-.994 1.177-6.53 4-7 1.923-.321 3.651.845 3.651 2.235A7.497 7.497 0 0 1 14 5.277c0-1.39 1.844-2.598 3.767-2.277 2.823.47 4.113 6.006 4 7-.08.703-1.725 1.722-3.656 1-1.261-.472-1.855-1.45-2.239-2.5"></path>',
		'dollar-sign'                        => '<line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>',
		'donut'                              => '<path d="M20.5 10a2.5 2.5 0 0 1-2.4-3H18a2.95 2.95 0 0 1-2.6-4.4 10 10 0 1 0 6.3 7.1c-.3.2-.8.3-1.2.3"></path><circle cx="12" cy="12" r="3"></circle>',
		'door-closed-locked'                 => '<path d="M10 12h.01"></path><path d="M18 9V6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14"></path><path d="M2 20h8"></path><path d="M20 17v-2a2 2 0 1 0-4 0v2"></path><rect x="14" y="17" width="8" height="5" rx="1"></rect>',
		'door-closed'                        => '<path d="M10 12h.01"></path><path d="M18 20V6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14"></path><path d="M2 20h20"></path>',
		'door-open'                          => '<path d="M11 20H2"></path><path d="M11 4.562v16.157a1 1 0 0 0 1.242.97L19 20V5.562a2 2 0 0 0-1.515-1.94l-4-1A2 2 0 0 0 11 4.561z"></path><path d="M11 4H8a2 2 0 0 0-2 2v14"></path><path d="M14 12h.01"></path><path d="M22 20h-3"></path>',
		'dot'                                => '<circle cx="12.1" cy="12.1" r="1"></circle>',
		'download'                           => '<path d="M12 15V3"></path><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><path d="m7 10 5 5 5-5"></path>',
		'drafting-compass'                   => '<path d="m12.99 6.74 1.93 3.44"></path><path d="M19.136 12a10 10 0 0 1-14.271 0"></path><path d="m21 21-2.16-3.84"></path><path d="m3 21 8.02-14.26"></path><circle cx="12" cy="5" r="2"></circle>',
		'drama'                              => '<path d="M10 11h.01"></path><path d="M14 6h.01"></path><path d="M18 6h.01"></path><path d="M6.5 13.1h.01"></path><path d="M22 5c0 9-4 12-6 12s-6-3-6-12c0-2 2-3 6-3s6 1 6 3"></path><path d="M17.4 9.9c-.8.8-2 .8-2.8 0"></path><path d="M10.1 7.1C9 7.2 7.7 7.7 6 8.6c-3.5 2-4.7 3.9-3.7 5.6 4.5 7.8 9.5 8.4 11.2 7.4.9-.5 1.9-2.1 1.9-4.7"></path><path d="M9.1 16.5c.3-1.1 1.4-1.7 2.4-1.4"></path>',
		'dribbble'                           => '<circle cx="12" cy="12" r="10"></circle><path d="M19.13 5.09C15.22 9.14 10 10.44 2.25 10.94"></path><path d="M21.75 12.84c-6.62-1.41-12.14 1-16.38 6.32"></path><path d="M8.56 2.75c4.37 6 6 9.42 8 17.72"></path>',
		'drill'                              => '<path d="M10 18a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H5a3 3 0 0 1-3-3 1 1 0 0 1 1-1z"></path><path d="M13 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1l-.81 3.242a1 1 0 0 1-.97.758H8"></path><path d="M14 4h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3"></path><path d="M18 6h4"></path><path d="m5 10-2 8"></path><path d="m7 18 2-8"></path>',
		'drone'                              => '<path d="M10 10 7 7"></path><path d="m10 14-3 3"></path><path d="m14 10 3-3"></path><path d="m14 14 3 3"></path><path d="M14.205 4.139a4 4 0 1 1 5.439 5.863"></path><path d="M19.637 14a4 4 0 1 1-5.432 5.868"></path><path d="M4.367 10a4 4 0 1 1 5.438-5.862"></path><path d="M9.795 19.862a4 4 0 1 1-5.429-5.873"></path><rect x="10" y="8" width="4" height="8" rx="1"></rect>',
		'droplet-off'                        => '<path d="M18.715 13.186C18.29 11.858 17.384 10.607 16 9.5c-2-1.6-3.5-4-4-6.5a10.7 10.7 0 0 1-.884 2.586"></path><path d="m2 2 20 20"></path><path d="M8.795 8.797A11 11 0 0 1 8 9.5C6 11.1 5 13 5 15a7 7 0 0 0 13.222 3.208"></path>',
		'droplet'                            => '<path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"></path>',
		'droplets'                           => '<path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z"></path><path d="M12.56 6.6A10.97 10.97 0 0 0 14 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 0 1-11.91 4.97"></path>',
		'drum'                               => '<path d="m2 2 8 8"></path><path d="m22 2-8 8"></path><ellipse cx="12" cy="9" rx="10" ry="5"></ellipse><path d="M7 13.4v7.9"></path><path d="M12 14v8"></path><path d="M17 13.4v7.9"></path><path d="M2 9v8a10 5 0 0 0 20 0V9"></path>',
		'drumstick'                          => '<path d="M15.4 15.63a7.875 6 135 1 1 6.23-6.23 4.5 3.43 135 0 0-6.23 6.23"></path><path d="m8.29 12.71-2.6 2.6a2.5 2.5 0 1 0-1.65 4.65A2.5 2.5 0 1 0 8.7 18.3l2.59-2.59"></path>',
		'dumbbell'                           => '<path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"></path><path d="m2.5 21.5 1.4-1.4"></path><path d="m20.1 3.9 1.4-1.4"></path><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"></path><path d="m9.6 14.4 4.8-4.8"></path>',
		'ear-off'                            => '<path d="M6 18.5a3.5 3.5 0 1 0 7 0c0-1.57.92-2.52 2.04-3.46"></path><path d="M6 8.5c0-.75.13-1.47.36-2.14"></path><path d="M8.8 3.15A6.5 6.5 0 0 1 19 8.5c0 1.63-.44 2.81-1.09 3.76"></path><path d="M12.5 6A2.5 2.5 0 0 1 15 8.5M10 13a2 2 0 0 0 1.82-1.18"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'ear'                                => '<path d="M6 8.5a6.5 6.5 0 1 1 13 0c0 6-6 6-6 10a3.5 3.5 0 1 1-7 0"></path><path d="M15 8.5a2.5 2.5 0 0 0-5 0v1a2 2 0 1 1 0 4"></path>',
		'earth-lock'                         => '<path d="M7 3.34V5a3 3 0 0 0 3 3"></path><path d="M11 21.95V18a2 2 0 0 0-2-2 2 2 0 0 1-2-2v-1a2 2 0 0 0-2-2H2.05"></path><path d="M21.54 15H17a2 2 0 0 0-2 2v4.54"></path><path d="M12 2a10 10 0 1 0 9.54 13"></path><path d="M20 6V4a2 2 0 1 0-4 0v2"></path><rect width="8" height="5" x="14" y="6" rx="1"></rect>',
		'earth'                              => '<path d="M21.54 15H17a2 2 0 0 0-2 2v4.54"></path><path d="M7 3.34V5a3 3 0 0 0 3 3a2 2 0 0 1 2 2c0 1.1.9 2 2 2a2 2 0 0 0 2-2c0-1.1.9-2 2-2h3.17"></path><path d="M11 21.95V18a2 2 0 0 0-2-2a2 2 0 0 1-2-2v-1a2 2 0 0 0-2-2H2.05"></path><circle cx="12" cy="12" r="10"></circle>',
		'eclipse'                            => '<circle cx="12" cy="12" r="10"></circle><path d="M12 2a7 7 0 1 0 10 10"></path>',
		'egg-fried'                          => '<circle cx="11.5" cy="12.5" r="3.5"></circle><path d="M3 8c0-3.5 2.5-6 6.5-6 5 0 4.83 3 7.5 5s5 2 5 6c0 4.5-2.5 6.5-7 6.5-2.5 0-2.5 2.5-6 2.5s-7-2-7-5.5c0-3 1.5-3 1.5-5C3.5 10 3 9 3 8Z"></path>',
		'egg-off'                            => '<path d="m2 2 20 20"></path><path d="M20 14.347V14c0-6-4-12-8-12-1.078 0-2.157.436-3.157 1.19"></path><path d="M6.206 6.21C4.871 8.4 4 11.2 4 14a8 8 0 0 0 14.568 4.568"></path>',
		'egg'                                => '<path d="M12 2C8 2 4 8 4 14a8 8 0 0 0 16 0c0-6-4-12-8-12"></path>',
		'ellipsis-vertical'                  => '<circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>',
		'ellipsis'                           => '<circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle>',
		'equal-approximately'                => '<path d="M5 15a6.5 6.5 0 0 1 7 0 6.5 6.5 0 0 0 7 0"></path><path d="M5 9a6.5 6.5 0 0 1 7 0 6.5 6.5 0 0 0 7 0"></path>',
		'equal-not'                          => '<line x1="5" x2="19" y1="9" y2="9"></line><line x1="5" x2="19" y1="15" y2="15"></line><line x1="19" x2="5" y1="5" y2="19"></line>',
		'equal'                              => '<line x1="5" x2="19" y1="9" y2="9"></line><line x1="5" x2="19" y1="15" y2="15"></line>',
		'eraser'                             => '<path d="M21 21H8a2 2 0 0 1-1.42-.587l-3.994-3.999a2 2 0 0 1 0-2.828l10-10a2 2 0 0 1 2.829 0l5.999 6a2 2 0 0 1 0 2.828L12.834 21"></path><path d="m5.082 11.09 8.828 8.828"></path>',
		'ethernet-port'                      => '<path d="m15 20 3-3h2a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2l3 3z"></path><path d="M6 8v1"></path><path d="M10 8v1"></path><path d="M14 8v1"></path><path d="M18 8v1"></path>',
		'euro'                               => '<path d="M4 10h12"></path><path d="M4 14h9"></path><path d="M19 6a7.7 7.7 0 0 0-5.2-2A7.9 7.9 0 0 0 6 12c0 4.4 3.5 8 7.8 8 2 0 3.8-.8 5.2-2"></path>',
		'ev-charger'                         => '<path d="M14 13h2a2 2 0 0 1 2 2v2a2 2 0 0 0 4 0v-6.998a2 2 0 0 0-.59-1.42L18 5"></path><path d="M14 21V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v16"></path><path d="M2 21h13"></path><path d="M3 7h11"></path><path d="m9 11-2 3h3l-2 3"></path>',
		'expand'                             => '<path d="m15 15 6 6"></path><path d="m15 9 6-6"></path><path d="M21 16v5h-5"></path><path d="M21 8V3h-5"></path><path d="M3 16v5h5"></path><path d="m3 21 6-6"></path><path d="M3 8V3h5"></path><path d="M9 9 3 3"></path>',
		'external-link'                      => '<path d="M15 3h6v6"></path><path d="M10 14 21 3"></path><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>',
		'eye-closed'                         => '<path d="m15 18-.722-3.25"></path><path d="M2 8a10.645 10.645 0 0 0 20 0"></path><path d="m20 15-1.726-2.05"></path><path d="m4 15 1.726-2.05"></path><path d="m9 18 .722-3.25"></path>',
		'eye-off'                            => '<path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"></path><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"></path><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"></path><path d="m2 2 20 20"></path>',
		'eye'                                => '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle>',
		'facebook'                           => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>',
		'factory'                            => '<path d="M12 16h.01"></path><path d="M16 16h.01"></path><path d="M3 19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5a.5.5 0 0 0-.769-.422l-4.462 2.844A.5.5 0 0 1 15 10.5v-2a.5.5 0 0 0-.769-.422L9.77 10.922A.5.5 0 0 1 9 10.5V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"></path><path d="M8 16h.01"></path>',
		'fan'                                => '<path d="M10.827 16.379a6.082 6.082 0 0 1-8.618-7.002l5.412 1.45a6.082 6.082 0 0 1 7.002-8.618l-1.45 5.412a6.082 6.082 0 0 1 8.618 7.002l-5.412-1.45a6.082 6.082 0 0 1-7.002 8.618l1.45-5.412Z"></path><path d="M12 12v.01"></path>',
		'fast-forward'                       => '<path d="M12 6a2 2 0 0 1 3.414-1.414l6 6a2 2 0 0 1 0 2.828l-6 6A2 2 0 0 1 12 18z"></path><path d="M2 6a2 2 0 0 1 3.414-1.414l6 6a2 2 0 0 1 0 2.828l-6 6A2 2 0 0 1 2 18z"></path>',
		'feather'                            => '<path d="M12.67 19a2 2 0 0 0 1.416-.588l6.154-6.172a6 6 0 0 0-8.49-8.49L5.586 9.914A2 2 0 0 0 5 11.328V18a1 1 0 0 0 1 1z"></path><path d="M16 8 2 22"></path><path d="M17.5 15H9"></path>',
		'fence'                              => '<path d="M4 3 2 5v15c0 .6.4 1 1 1h2c.6 0 1-.4 1-1V5Z"></path><path d="M6 8h4"></path><path d="M6 18h4"></path><path d="m12 3-2 2v15c0 .6.4 1 1 1h2c.6 0 1-.4 1-1V5Z"></path><path d="M14 8h4"></path><path d="M14 18h4"></path><path d="m20 3-2 2v15c0 .6.4 1 1 1h2c.6 0 1-.4 1-1V5Z"></path>',
		'ferris-wheel'                       => '<circle cx="12" cy="12" r="2"></circle><path d="M12 2v4"></path><path d="m6.8 15-3.5 2"></path><path d="m20.7 7-3.5 2"></path><path d="M6.8 9 3.3 7"></path><path d="m20.7 17-3.5-2"></path><path d="m9 22 3-8 3 8"></path><path d="M8 22h8"></path><path d="M18 18.7a9 9 0 1 0-12 0"></path>',
		'figma'                              => '<path d="M5 5.5A3.5 3.5 0 0 1 8.5 2H12v7H8.5A3.5 3.5 0 0 1 5 5.5z"></path><path d="M12 2h3.5a3.5 3.5 0 1 1 0 7H12V2z"></path><path d="M12 12.5a3.5 3.5 0 1 1 7 0 3.5 3.5 0 1 1-7 0z"></path><path d="M5 19.5A3.5 3.5 0 0 1 8.5 16H12v3.5a3.5 3.5 0 1 1-7 0z"></path><path d="M5 12.5A3.5 3.5 0 0 1 8.5 9H12v7H8.5A3.5 3.5 0 0 1 5 12.5z"></path>',
		'file-archive'                       => '<path d="M13.659 22H18a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v11.5"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M8 12v-1"></path><path d="M8 18v-2"></path><path d="M8 7V6"></path><circle cx="8" cy="20" r="2"></circle>',
		'file-axis-3d'                       => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m8 18 4-4"></path><path d="M8 10v8h8"></path>',
		'file-badge'                         => '<path d="M13 22h5a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v3.3"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m7.69 16.479 1.29 4.88a.5.5 0 0 1-.698.591l-1.843-.849a1 1 0 0 0-.879.001l-1.846.85a.5.5 0 0 1-.692-.593l1.29-4.88"></path><circle cx="6" cy="14" r="3"></circle>',
		'file-box'                           => '<path d="M14.5 22H18a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v3.8"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M11.7 14.2 7 17l-4.7-2.8"></path><path d="M3 13.1a2 2 0 0 0-.999 1.76v3.24a2 2 0 0 0 .969 1.78L6 21.7a2 2 0 0 0 2.03.01L11 19.9a2 2 0 0 0 1-1.76V14.9a2 2 0 0 0-.97-1.78L8 11.3a2 2 0 0 0-2.03-.01z"></path><path d="M7 17v5"></path>',
		'file-braces-corner'                 => '<path d="M14 22h4a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v6"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M5 14a1 1 0 0 0-1 1v2a1 1 0 0 1-1 1 1 1 0 0 1 1 1v2a1 1 0 0 0 1 1"></path><path d="M9 22a1 1 0 0 0 1-1v-2a1 1 0 0 1 1-1 1 1 0 0 1-1-1v-2a1 1 0 0 0-1-1"></path>',
		'file-braces'                        => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M10 12a1 1 0 0 0-1 1v1a1 1 0 0 1-1 1 1 1 0 0 1 1 1v1a1 1 0 0 0 1 1"></path><path d="M14 18a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1 1 1 0 0 1-1-1v-1a1 1 0 0 0-1-1"></path>',
		'file-chart-column-increasing'       => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M8 18v-2"></path><path d="M12 18v-4"></path><path d="M16 18v-6"></path>',
		'file-chart-column'                  => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M8 18v-1"></path><path d="M12 18v-6"></path><path d="M16 18v-3"></path>',
		'file-chart-line'                    => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m16 13-3.5 3.5-2-2L8 17"></path>',
		'file-chart-pie'                     => '<path d="M15.941 22H18a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.704l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v3.512"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M4.017 11.512a6 6 0 1 0 8.466 8.475"></path><path d="M9 16a1 1 0 0 1-1-1v-4c0-.552.45-1.008.995-.917a6 6 0 0 1 4.922 4.922c.091.544-.365.995-.917.995z"></path>',
		'file-check-corner'                  => '<path d="M10.5 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v6"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m14 20 2 2 4-4"></path>',
		'file-check'                         => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m9 15 2 2 4-4"></path>',
		'file-clock'                         => '<path d="M16 22h2a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v2.85"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M8 14v2.2l1.6 1"></path><circle cx="8" cy="16" r="6"></circle>',
		'file-code-corner'                   => '<path d="M4 12.15V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2h-3.35"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m5 16-3 3 3 3"></path><path d="m9 22 3-3-3-3"></path>',
		'file-code'                          => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M10 12.5 8 15l2 2.5"></path><path d="m14 12.5 2 2.5-2 2.5"></path>',
		'file-cog'                           => '<path d="M13.85 22H18a2 2 0 0 0 2-2V8a2 2 0 0 0-.586-1.414l-4-4A2 2 0 0 0 14 2H6a2 2 0 0 0-2 2v6.6"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m3.305 19.53.923-.382"></path><path d="m4.228 16.852-.924-.383"></path><path d="m5.852 15.228-.383-.923"></path><path d="m5.852 20.772-.383.924"></path><path d="m8.148 15.228.383-.923"></path><path d="m8.53 21.696-.382-.924"></path><path d="m9.773 16.852.922-.383"></path><path d="m9.773 19.148.922.383"></path><circle cx="7" cy="18" r="3"></circle>',
		'file-diff'                          => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M9 10h6"></path><path d="M12 13V7"></path><path d="M9 17h6"></path>',
		'file-digit'                         => '<path d="M4 12V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M10 16h2v6"></path><path d="M10 22h4"></path><rect x="2" y="16" width="4" height="6" rx="2"></rect>',
		'file-down'                          => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M12 18v-6"></path><path d="m9 15 3 3 3-3"></path>',
		'file-exclamation-point'             => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path>',
		'file-headphone'                     => '<path d="M4 6.835V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2h-.343"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M2 19a2 2 0 0 1 4 0v1a2 2 0 0 1-4 0v-4a6 6 0 0 1 12 0v4a2 2 0 0 1-4 0v-1a2 2 0 0 1 4 0"></path>',
		'file-heart'                         => '<path d="M13 22h5a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v7"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M3.62 18.8A2.25 2.25 0 1 1 7 15.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a1 1 0 0 1-1.507 0z"></path>',
		'file-image'                         => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><circle cx="10" cy="12" r="2"></circle><path d="m20 17-1.296-1.296a2.41 2.41 0 0 0-3.408 0L9 22"></path>',
		'file-input'                         => '<path d="M4 11V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M2 15h10"></path><path d="m9 18 3-3-3-3"></path>',
		'file-key'                           => '<path d="M10.65 22H18a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v10.1"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m10 15 1 1"></path><path d="m11 14-4.586 4.586"></path><circle cx="5" cy="20" r="2"></circle>',
		'file-lock'                          => '<path d="M4 9.8V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2h-3"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M9 17v-2a2 2 0 0 0-4 0v2"></path><rect width="8" height="5" x="3" y="17" rx="1"></rect>',
		'file-minus-corner'                  => '<path d="M20 14V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M14 18h6"></path>',
		'file-minus'                         => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M9 15h6"></path>',
		'file-music'                         => '<path d="M11.65 22H18a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v10.35"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M8 20v-7l3 1.474"></path><circle cx="6" cy="20" r="2"></circle>',
		'file-output'                        => '<path d="M4.226 20.925A2 2 0 0 0 6 22h12a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v3.127"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m5 11-3 3"></path><path d="m5 17-3-3h10"></path>',
		'file-pen-line'                      => '<path d="m18.226 5.226-2.52-2.52A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.351"></path><path d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path><path d="M8 18h1"></path>',
		'file-pen'                           => '<path d="M12.659 22H18a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v9.34"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M10.378 12.622a1 1 0 0 1 3 3.003L8.36 20.637a2 2 0 0 1-.854.506l-2.867.837a.5.5 0 0 1-.62-.62l.836-2.869a2 2 0 0 1 .506-.853z"></path>',
		'file-play'                          => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M15.033 13.44a.647.647 0 0 1 0 1.12l-4.065 2.352a.645.645 0 0 1-.968-.56v-4.704a.645.645 0 0 1 .967-.56z"></path>',
		'file-plus-corner'                   => '<path d="M11.35 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5.35"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M14 19h6"></path><path d="M17 16v6"></path>',
		'file-plus'                          => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M9 15h6"></path><path d="M12 18v-6"></path>',
		'file-question-mark'                 => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M12 17h.01"></path><path d="M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"></path>',
		'file-scan'                          => '<path d="M20 10V8a2.4 2.4 0 0 0-.706-1.704l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h4.35"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M16 14a2 2 0 0 0-2 2"></path><path d="M16 22a2 2 0 0 1-2-2"></path><path d="M20 14a2 2 0 0 1 2 2"></path><path d="M20 22a2 2 0 0 0 2-2"></path>',
		'file-search-corner'                 => '<path d="M11.1 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.589 3.588A2.4 2.4 0 0 1 20 8v3.25"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m21 22-2.88-2.88"></path><circle cx="16" cy="17" r="3"></circle>',
		'file-search'                        => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><circle cx="11.5" cy="14.5" r="2.5"></circle><path d="M13.3 16.3 15 18"></path>',
		'file-signal'                        => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M8 15h.01"></path><path d="M11.5 13.5a2.5 2.5 0 0 1 0 3"></path><path d="M15 12a5 5 0 0 1 0 6"></path>',
		'file-sliders'                       => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M8 12h8"></path><path d="M10 11v2"></path><path d="M8 17h8"></path><path d="M14 16v2"></path>',
		'file-spreadsheet'                   => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M8 13h2"></path><path d="M14 13h2"></path><path d="M8 17h2"></path><path d="M14 17h2"></path>',
		'file-stack'                         => '<path d="M11 21a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1"></path><path d="M16 16a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1"></path><path d="M21 6a2 2 0 0 0-.586-1.414l-2-2A2 2 0 0 0 17 2h-3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1z"></path>',
		'file-symlink'                       => '<path d="M4 11V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h7"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m10 18 3-3-3-3"></path>',
		'file-terminal'                      => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m8 16 2-2-2-2"></path><path d="M12 18h4"></path>',
		'file-text'                          => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path>',
		'file-type-corner'                   => '<path d="M12 22h6a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v6"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M3 16v-1.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5V16"></path><path d="M6 22h2"></path><path d="M7 14v8"></path>',
		'file-type'                          => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M11 18h2"></path><path d="M12 12v6"></path><path d="M9 13v-.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v.5"></path>',
		'file-up'                            => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M12 12v6"></path><path d="m15 15-3-3-3 3"></path>',
		'file-user'                          => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M16 22a4 4 0 0 0-8 0"></path><circle cx="12" cy="15" r="3"></circle>',
		'file-video-camera'                  => '<path d="M4 12V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m10 17.843 3.033-1.755a.64.64 0 0 1 .967.56v4.704a.65.65 0 0 1-.967.56L10 20.157"></path><rect width="7" height="6" x="3" y="16" rx="1"></rect>',
		'file-volume'                        => '<path d="M4 11.55V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2h-1.95"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M12 15a5 5 0 0 1 0 6"></path><path d="M8 14.502a.5.5 0 0 0-.826-.381l-1.893 1.631a1 1 0 0 1-.651.243H3.5a.5.5 0 0 0-.5.501v3.006a.5.5 0 0 0 .5.501h1.129a1 1 0 0 1 .652.243l1.893 1.633a.5.5 0 0 0 .826-.38z"></path>',
		'file-x-corner'                      => '<path d="M11 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m15 17 5 5"></path><path d="m20 17-5 5"></path>',
		'file-x'                             => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="m14.5 12.5-5 5"></path><path d="m9.5 12.5 5 5"></path>',
		'file'                               => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path>',
		'files'                              => '<path d="M15 2h-4a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8"></path><path d="M16.706 2.706A2.4 2.4 0 0 0 15 2v5a1 1 0 0 0 1 1h5a2.4 2.4 0 0 0-.706-1.706z"></path><path d="M5 7a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h8a2 2 0 0 0 1.732-1"></path>',
		'film'                               => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7 3v18"></path><path d="M3 7.5h4"></path><path d="M3 12h18"></path><path d="M3 16.5h4"></path><path d="M17 3v18"></path><path d="M17 7.5h4"></path><path d="M17 16.5h4"></path>',
		'fingerprint-pattern'                => '<path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"></path><path d="M14 13.12c0 2.38 0 6.38-1 8.88"></path><path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"></path><path d="M2 12a10 10 0 0 1 18-6"></path><path d="M2 16h.01"></path><path d="M21.8 16c.2-2 .131-5.354 0-6"></path><path d="M5 19.5C5.5 18 6 15 6 12a6 6 0 0 1 .34-2"></path><path d="M8.65 22c.21-.66.45-1.32.57-2"></path><path d="M9 6.8a6 6 0 0 1 9 5.2v2"></path>',
		'fire-extinguisher'                  => '<path d="M15 6.5V3a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3.5"></path><path d="M9 18h8"></path><path d="M18 3h-3"></path><path d="M11 3a6 6 0 0 0-6 6v11"></path><path d="M5 13h4"></path><path d="M17 10a4 4 0 0 0-8 0v10a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2Z"></path>',
		'fish-off'                           => '<path d="M18 12.47v.03m0-.5v.47m-.475 5.056A6.744 6.744 0 0 1 15 18c-3.56 0-7.56-2.53-8.5-6 .348-1.28 1.114-2.433 2.121-3.38m3.444-2.088A8.802 8.802 0 0 1 15 6c3.56 0 6.06 2.54 7 6-.309 1.14-.786 2.177-1.413 3.058"></path><path d="M7 10.67C7 8 5.58 5.97 2.73 5.5c-1 1.5-1 5 .23 6.5-1.24 1.5-1.24 5-.23 6.5C5.58 18.03 7 16 7 13.33m7.48-4.372A9.77 9.77 0 0 1 16 6.07m0 11.86a9.77 9.77 0 0 1-1.728-3.618"></path><path d="m16.01 17.93-.23 1.4A2 2 0 0 1 13.8 21H9.5a5.96 5.96 0 0 0 1.49-3.98M8.53 3h5.27a2 2 0 0 1 1.98 1.67l.23 1.4M2 2l20 20"></path>',
		'fish-symbol'                        => '<path d="M2 16s9-15 20-4C11 23 2 8 2 8"></path>',
		'fish'                               => '<path d="M6.5 12c.94-3.46 4.94-6 8.5-6 3.56 0 6.06 2.54 7 6-.94 3.47-3.44 6-7 6s-7.56-2.53-8.5-6Z"></path><path d="M18 12v.5"></path><path d="M16 17.93a9.77 9.77 0 0 1 0-11.86"></path><path d="M7 10.67C7 8 5.58 5.97 2.73 5.5c-1 1.5-1 5 .23 6.5-1.24 1.5-1.24 5-.23 6.5C5.58 18.03 7 16 7 13.33"></path><path d="M10.46 7.26C10.2 5.88 9.17 4.24 8 3h5.8a2 2 0 0 1 1.98 1.67l.23 1.4"></path><path d="m16.01 17.93-.23 1.4A2 2 0 0 1 13.8 21H9.5a5.96 5.96 0 0 0 1.49-3.98"></path>',
		'fishing-hook'                       => '<path d="m17.586 11.414-5.93 5.93a1 1 0 0 1-8-8l3.137-3.137a.707.707 0 0 1 1.207.5V10"></path><path d="M20.414 8.586 22 7"></path><circle cx="19" cy="10" r="2"></circle>',
		'flag-off'                           => '<path d="M16 16c-3 0-5-2-8-2a6 6 0 0 0-4 1.528"></path><path d="m2 2 20 20"></path><path d="M4 22V4"></path><path d="M7.656 2H8c3 0 5 2 7.333 2q2 0 3.067-.8A1 1 0 0 1 20 4v10.347"></path>',
		'flag-triangle-left'                 => '<path d="M18 22V2.8a.8.8 0 0 0-1.17-.71L5.45 7.78a.8.8 0 0 0 0 1.44L18 15.5"></path>',
		'flag-triangle-right'                => '<path d="M6 22V2.8a.8.8 0 0 1 1.17-.71l11.38 5.69a.8.8 0 0 1 0 1.44L6 15.5"></path>',
		'flag'                               => '<path d="M4 22V4a1 1 0 0 1 .4-.8A6 6 0 0 1 8 2c3 0 5 2 7.333 2q2 0 3.067-.8A1 1 0 0 1 20 4v10a1 1 0 0 1-.4.8A6 6 0 0 1 16 16c-3 0-5-2-8-2a6 6 0 0 0-4 1.528"></path>',
		'flame-kindling'                     => '<path d="M12 2c1 3 2.5 3.5 3.5 4.5A5 5 0 0 1 17 10a5 5 0 1 1-10 0c0-.3 0-.6.1-.9a2 2 0 1 0 3.3-2C8 4.5 11 2 12 2Z"></path><path d="m5 22 14-4"></path><path d="m5 18 14 4"></path>',
		'flame'                              => '<path d="M12 3q1 4 4 6.5t3 5.5a1 1 0 0 1-14 0 5 5 0 0 1 1-3 1 1 0 0 0 5 0c0-2-1.5-3-1.5-5q0-2 2.5-4"></path>',
		'flashlight-off'                     => '<path d="M11.652 6H18"></path><path d="M12 13v1"></path><path d="M16 16v4a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-8a4 4 0 0 0-.8-2.4l-.6-.8A3 3 0 0 1 6 7V6"></path><path d="m2 2 20 20"></path><path d="M7.649 2H17a1 1 0 0 1 1 1v4a3 3 0 0 1-.6 1.8l-.6.8a4 4 0 0 0-.55 1.007"></path>',
		'flashlight'                         => '<path d="M12 13v1"></path><path d="M17 2a1 1 0 0 1 1 1v4a3 3 0 0 1-.6 1.8l-.6.8A4 4 0 0 0 16 12v8a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2v-8a4 4 0 0 0-.8-2.4l-.6-.8A3 3 0 0 1 6 7V3a1 1 0 0 1 1-1z"></path><path d="M6 6h12"></path>',
		'flask-conical-off'                  => '<path d="M10 2v2.343"></path><path d="M14 2v6.343"></path><path d="m2 2 20 20"></path><path d="M20 20a2 2 0 0 1-2 2H6a2 2 0 0 1-1.755-2.96l5.227-9.563"></path><path d="M6.453 15H15"></path><path d="M8.5 2h7"></path>',
		'flask-conical'                      => '<path d="M14 2v6a2 2 0 0 0 .245.96l5.51 10.08A2 2 0 0 1 18 22H6a2 2 0 0 1-1.755-2.96l5.51-10.08A2 2 0 0 0 10 8V2"></path><path d="M6.453 15h11.094"></path><path d="M8.5 2h7"></path>',
		'flask-round'                        => '<path d="M10 2v6.292a7 7 0 1 0 4 0V2"></path><path d="M5 15h14"></path><path d="M8.5 2h7"></path>',
		'flip-horizontal-2'                  => '<path d="m3 7 5 5-5 5V7"></path><path d="m21 7-5 5 5 5V7"></path><path d="M12 20v2"></path><path d="M12 14v2"></path><path d="M12 8v2"></path><path d="M12 2v2"></path>',
		'flip-horizontal'                    => '<path d="M8 3H5a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h3"></path><path d="M16 3h3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-3"></path><path d="M12 20v2"></path><path d="M12 14v2"></path><path d="M12 8v2"></path><path d="M12 2v2"></path>',
		'flip-vertical-2'                    => '<path d="m17 3-5 5-5-5h10"></path><path d="m17 21-5-5-5 5h10"></path><path d="M4 12H2"></path><path d="M10 12H8"></path><path d="M16 12h-2"></path><path d="M22 12h-2"></path>',
		'flip-vertical'                      => '<path d="M21 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3"></path><path d="M21 16v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3"></path><path d="M4 12H2"></path><path d="M10 12H8"></path><path d="M16 12h-2"></path><path d="M22 12h-2"></path>',
		'flower-2'                           => '<path d="M12 5a3 3 0 1 1 3 3m-3-3a3 3 0 1 0-3 3m3-3v1M9 8a3 3 0 1 0 3 3M9 8h1m5 0a3 3 0 1 1-3 3m3-3h-1m-2 3v-1"></path><circle cx="12" cy="8" r="2"></circle><path d="M12 10v12"></path><path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z"></path><path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z"></path>',
		'flower'                             => '<circle cx="12" cy="12" r="3"></circle><path d="M12 16.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 1 1 12 7.5a4.5 4.5 0 1 1 4.5 4.5 4.5 4.5 0 1 1-4.5 4.5"></path><path d="M12 7.5V9"></path><path d="M7.5 12H9"></path><path d="M16.5 12H15"></path><path d="M12 16.5V15"></path><path d="m8 8 1.88 1.88"></path><path d="M14.12 9.88 16 8"></path><path d="m8 16 1.88-1.88"></path><path d="M14.12 14.12 16 16"></path>',
		'focus'                              => '<circle cx="12" cy="12" r="3"></circle><path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>',
		'fold-horizontal'                    => '<path d="M2 12h6"></path><path d="M22 12h-6"></path><path d="M12 2v2"></path><path d="M12 8v2"></path><path d="M12 14v2"></path><path d="M12 20v2"></path><path d="m19 9-3 3 3 3"></path><path d="m5 15 3-3-3-3"></path>',
		'fold-vertical'                      => '<path d="M12 22v-6"></path><path d="M12 8V2"></path><path d="M4 12H2"></path><path d="M10 12H8"></path><path d="M16 12h-2"></path><path d="M22 12h-2"></path><path d="m15 19-3-3-3 3"></path><path d="m15 5-3 3-3-3"></path>',
		'folder-archive'                     => '<circle cx="15" cy="19" r="2"></circle><path d="M20.9 19.8A2 2 0 0 0 22 18V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h5.1"></path><path d="M15 11v-1"></path><path d="M15 17v-2"></path>',
		'folder-check'                       => '<path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path><path d="m9 13 2 2 4-4"></path>',
		'folder-clock'                       => '<path d="M16 14v2.2l1.6 1"></path><path d="M7 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2"></path><circle cx="16" cy="16" r="6"></circle>',
		'folder-closed'                      => '<path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path><path d="M2 10h20"></path>',
		'folder-code'                        => '<path d="M10 10.5 8 13l2 2.5"></path><path d="m14 10.5 2 2.5-2 2.5"></path><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2z"></path>',
		'folder-cog'                         => '<path d="M10.3 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.98a2 2 0 0 1 1.69.9l.66 1.2A2 2 0 0 0 12 6h8a2 2 0 0 1 2 2v3.3"></path><path d="m14.305 19.53.923-.382"></path><path d="m15.228 16.852-.923-.383"></path><path d="m16.852 15.228-.383-.923"></path><path d="m16.852 20.772-.383.924"></path><path d="m19.148 15.228.383-.923"></path><path d="m19.53 21.696-.382-.924"></path><path d="m20.772 16.852.924-.383"></path><path d="m20.772 19.148.924.383"></path><circle cx="18" cy="18" r="3"></circle>',
		'folder-dot'                         => '<path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"></path><circle cx="12" cy="13" r="1"></circle>',
		'folder-down'                        => '<path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path><path d="M12 10v6"></path><path d="m15 13-3 3-3-3"></path>',
		'folder-git-2'                       => '<path d="M18 19a5 5 0 0 1-5-5v8"></path><path d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5"></path><circle cx="13" cy="12" r="2"></circle><circle cx="20" cy="19" r="2"></circle>',
		'folder-git'                         => '<circle cx="12" cy="13" r="2"></circle><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path><path d="M14 13h3"></path><path d="M7 13h3"></path>',
		'folder-heart'                       => '<path d="M10.638 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v3.417"></path><path d="M14.62 18.8A2.25 2.25 0 1 1 18 15.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a.998.998 0 0 1-1.507 0z"></path>',
		'folder-input'                       => '<path d="M2 9V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-1"></path><path d="M2 13h10"></path><path d="m9 16 3-3-3-3"></path>',
		'folder-kanban'                      => '<path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"></path><path d="M8 10v4"></path><path d="M12 10v2"></path><path d="M16 10v6"></path>',
		'folder-key'                         => '<circle cx="16" cy="20" r="2"></circle><path d="M10 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v2"></path><path d="m22 14-4.5 4.5"></path><path d="m21 15 1 1"></path>',
		'folder-lock'                        => '<rect width="8" height="5" x="14" y="17" rx="1"></rect><path d="M10 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v2.5"></path><path d="M20 17v-2a2 2 0 1 0-4 0v2"></path>',
		'folder-minus'                       => '<path d="M9 13h6"></path><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>',
		'folder-open-dot'                    => '<path d="m6 14 1.45-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.55 6a2 2 0 0 1-1.94 1.5H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 0 1 1.66.9l.82 1.2a2 2 0 0 0 1.66.9H18a2 2 0 0 1 2 2v2"></path><circle cx="14" cy="15" r="1"></circle>',
		'folder-open'                        => '<path d="m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2"></path>',
		'folder-output'                      => '<path d="M2 7.5V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-1.5"></path><path d="M2 13h10"></path><path d="m5 10-3 3 3 3"></path>',
		'folder-pen'                         => '<path d="M2 11.5V5a2 2 0 0 1 2-2h3.9c.7 0 1.3.3 1.7.9l.8 1.2c.4.6 1 .9 1.7.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-9.5"></path><path d="M11.378 13.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path>',
		'folder-plus'                        => '<path d="M12 10v6"></path><path d="M9 13h6"></path><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>',
		'folder-root'                        => '<path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"></path><circle cx="12" cy="13" r="2"></circle><path d="M12 15v5"></path>',
		'folder-search-2'                    => '<circle cx="11.5" cy="12.5" r="2.5"></circle><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path><path d="M13.3 14.3 15 16"></path>',
		'folder-search'                      => '<path d="M10.7 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v4.1"></path><path d="m21 21-1.9-1.9"></path><circle cx="17" cy="17" r="3"></circle>',
		'folder-symlink'                     => '<path d="M2 9.35V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h7"></path><path d="m8 16 3-3-3-3"></path>',
		'folder-sync'                        => '<path d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v.5"></path><path d="M12 10v4h4"></path><path d="m12 14 1.535-1.605a5 5 0 0 1 8 1.5"></path><path d="M22 22v-4h-4"></path><path d="m22 18-1.535 1.605a5 5 0 0 1-8-1.5"></path>',
		'folder-tree'                        => '<path d="M20 10a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1h-2.5a1 1 0 0 1-.8-.4l-.9-1.2A1 1 0 0 0 15 3h-2a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1Z"></path><path d="M20 21a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-2.9a1 1 0 0 1-.88-.55l-.42-.85a1 1 0 0 0-.92-.6H13a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1Z"></path><path d="M3 5a2 2 0 0 0 2 2h3"></path><path d="M3 3v13a2 2 0 0 0 2 2h3"></path>',
		'folder-up'                          => '<path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path><path d="M12 10v6"></path><path d="m9 13 3-3 3 3"></path>',
		'folder-x'                           => '<path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path><path d="m9.5 10.5 5 5"></path><path d="m14.5 10.5-5 5"></path>',
		'folder'                             => '<path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>',
		'folders'                            => '<path d="M20 5a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2.5a1.5 1.5 0 0 1 1.2.6l.6.8a1.5 1.5 0 0 0 1.2.6z"></path><path d="M3 8.268a2 2 0 0 0-1 1.738V19a2 2 0 0 0 2 2h11a2 2 0 0 0 1.732-1"></path>',
		'footprints'                         => '<path d="M4 16v-2.38C4 11.5 2.97 10.5 3 8c.03-2.72 1.49-6 4.5-6C9.37 2 10 3.8 10 5.5c0 3.11-2 5.66-2 8.68V16a2 2 0 1 1-4 0Z"></path><path d="M20 20v-2.38c0-2.12 1.03-3.12 1-5.62-.03-2.72-1.49-6-4.5-6C14.63 6 14 7.8 14 9.5c0 3.11 2 5.66 2 8.68V20a2 2 0 1 0 4 0Z"></path><path d="M16 17h4"></path><path d="M4 13h4"></path>',
		'forklift'                           => '<path d="M12 12H5a2 2 0 0 0-2 2v5"></path><circle cx="13" cy="19" r="2"></circle><circle cx="5" cy="19" r="2"></circle><path d="M8 19h3m5-17v17h6M6 12V7c0-1.1.9-2 2-2h3l5 5"></path>',
		'form'                               => '<path d="M4 14h6"></path><path d="M4 2h10"></path><rect x="4" y="18" width="16" height="4" rx="1"></rect><rect x="4" y="6" width="16" height="4" rx="1"></rect>',
		'forward'                            => '<path d="m15 17 5-5-5-5"></path><path d="M4 18v-2a4 4 0 0 1 4-4h12"></path>',
		'frame'                              => '<line x1="22" x2="2" y1="6" y2="6"></line><line x1="22" x2="2" y1="18" y2="18"></line><line x1="6" x2="6" y1="2" y2="22"></line><line x1="18" x2="18" y1="2" y2="22"></line>',
		'framer'                             => '<path d="M5 16V9h14V2H5l14 14h-7m-7 0 7 7v-7m-7 0h7"></path>',
		'frown'                              => '<circle cx="12" cy="12" r="10"></circle><path d="M16 16s-1.5-2-4-2-4 2-4 2"></path><line x1="9" x2="9.01" y1="9" y2="9"></line><line x1="15" x2="15.01" y1="9" y2="9"></line>',
		'fuel'                               => '<path d="M14 13h2a2 2 0 0 1 2 2v2a2 2 0 0 0 4 0v-6.998a2 2 0 0 0-.59-1.42L18 5"></path><path d="M14 21V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v16"></path><path d="M2 21h13"></path><path d="M3 9h11"></path>',
		'fullscreen'                         => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><rect width="10" height="8" x="7" y="8" rx="1"></rect>',
		'funnel-plus'                        => '<path d="M13.354 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14v6a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341l1.218-1.348"></path><path d="M16 6h6"></path><path d="M19 3v6"></path>',
		'funnel-x'                           => '<path d="M12.531 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14v6a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341l.427-.473"></path><path d="m16.5 3.5 5 5"></path><path d="m21.5 3.5-5 5"></path>',
		'funnel'                             => '<path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"></path>',
		'gallery-horizontal-end'             => '<path d="M2 7v10"></path><path d="M6 5v14"></path><rect width="12" height="18" x="10" y="3" rx="2"></rect>',
		'gallery-horizontal'                 => '<path d="M2 3v18"></path><rect width="12" height="18" x="6" y="3" rx="2"></rect><path d="M22 3v18"></path>',
		'gallery-thumbnails'                 => '<rect width="18" height="14" x="3" y="3" rx="2"></rect><path d="M4 21h1"></path><path d="M9 21h1"></path><path d="M14 21h1"></path><path d="M19 21h1"></path>',
		'gallery-vertical-end'               => '<path d="M7 2h10"></path><path d="M5 6h14"></path><rect width="18" height="12" x="3" y="10" rx="2"></rect>',
		'gallery-vertical'                   => '<path d="M3 2h18"></path><rect width="18" height="12" x="3" y="6" rx="2"></rect><path d="M3 22h18"></path>',
		'gamepad-2'                          => '<line x1="6" x2="10" y1="11" y2="11"></line><line x1="8" x2="8" y1="9" y2="13"></line><line x1="15" x2="15.01" y1="12" y2="12"></line><line x1="18" x2="18.01" y1="10" y2="10"></line><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"></path>',
		'gamepad-directional'                => '<path d="M11.146 15.854a1.207 1.207 0 0 1 1.708 0l1.56 1.56A2 2 0 0 1 15 18.828V21a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-2.172a2 2 0 0 1 .586-1.414z"></path><path d="M18.828 15a2 2 0 0 1-1.414-.586l-1.56-1.56a1.207 1.207 0 0 1 0-1.708l1.56-1.56A2 2 0 0 1 18.828 9H21a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1z"></path><path d="M6.586 14.414A2 2 0 0 1 5.172 15H3a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1h2.172a2 2 0 0 1 1.414.586l1.56 1.56a1.207 1.207 0 0 1 0 1.708z"></path><path d="M9 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2.172a2 2 0 0 1-.586 1.414l-1.56 1.56a1.207 1.207 0 0 1-1.708 0l-1.56-1.56A2 2 0 0 1 9 5.172z"></path>',
		'gamepad'                            => '<line x1="6" x2="10" y1="12" y2="12"></line><line x1="8" x2="8" y1="10" y2="14"></line><line x1="15" x2="15.01" y1="13" y2="13"></line><line x1="18" x2="18.01" y1="11" y2="11"></line><rect width="20" height="12" x="2" y="6" rx="2"></rect>',
		'gauge'                              => '<path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path>',
		'gavel'                              => '<path d="m14 13-8.381 8.38a1 1 0 0 1-3.001-3l8.384-8.381"></path><path d="m16 16 6-6"></path><path d="m21.5 10.5-8-8"></path><path d="m8 8 6-6"></path><path d="m8.5 7.5 8 8"></path>',
		'gem'                                => '<path d="M10.5 3 8 9l4 13 4-13-2.5-6"></path><path d="M17 3a2 2 0 0 1 1.6.8l3 4a2 2 0 0 1 .013 2.382l-7.99 10.986a2 2 0 0 1-3.247 0l-7.99-10.986A2 2 0 0 1 2.4 7.8l2.998-3.997A2 2 0 0 1 7 3z"></path><path d="M2 9h20"></path>',
		'georgian-lari'                      => '<path d="M11.5 21a7.5 7.5 0 1 1 7.35-9"></path><path d="M13 12V3"></path><path d="M4 21h16"></path><path d="M9 12V3"></path>',
		'ghost'                              => '<path d="M9 10h.01"></path><path d="M15 10h.01"></path><path d="M12 2a8 8 0 0 0-8 8v12l3-3 2.5 2.5L12 19l2.5 2.5L17 19l3 3V10a8 8 0 0 0-8-8z"></path>',
		'gift'                               => '<rect x="3" y="8" width="18" height="4" rx="1"></rect><path d="M12 8v13"></path><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>',
		'git-branch-minus'                   => '<path d="M15 6a9 9 0 0 0-9 9V3"></path><path d="M21 18h-6"></path><circle cx="18" cy="6" r="3"></circle><circle cx="6" cy="18" r="3"></circle>',
		'git-branch-plus'                    => '<path d="M6 3v12"></path><path d="M18 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path><path d="M6 21a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path><path d="M15 6a9 9 0 0 0-9 9"></path><path d="M18 15v6"></path><path d="M21 18h-6"></path>',
		'git-branch'                         => '<line x1="6" x2="6" y1="3" y2="15"></line><circle cx="18" cy="6" r="3"></circle><circle cx="6" cy="18" r="3"></circle><path d="M18 9a9 9 0 0 1-9 9"></path>',
		'git-commit-horizontal'              => '<circle cx="12" cy="12" r="3"></circle><line x1="3" x2="9" y1="12" y2="12"></line><line x1="15" x2="21" y1="12" y2="12"></line>',
		'git-commit-vertical'                => '<path d="M12 3v6"></path><circle cx="12" cy="12" r="3"></circle><path d="M12 15v6"></path>',
		'git-compare-arrows'                 => '<circle cx="5" cy="6" r="3"></circle><path d="M12 6h5a2 2 0 0 1 2 2v7"></path><path d="m15 9-3-3 3-3"></path><circle cx="19" cy="18" r="3"></circle><path d="M12 18H7a2 2 0 0 1-2-2V9"></path><path d="m9 15 3 3-3 3"></path>',
		'git-compare'                        => '<circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M13 6h3a2 2 0 0 1 2 2v7"></path><path d="M11 18H8a2 2 0 0 1-2-2V9"></path>',
		'git-fork'                           => '<circle cx="12" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><circle cx="18" cy="6" r="3"></circle><path d="M18 9v2c0 .6-.4 1-1 1H7c-.6 0-1-.4-1-1V9"></path><path d="M12 12v3"></path>',
		'git-graph'                          => '<circle cx="5" cy="6" r="3"></circle><path d="M5 9v6"></path><circle cx="5" cy="18" r="3"></circle><path d="M12 3v18"></path><circle cx="19" cy="6" r="3"></circle><path d="M16 15.7A9 9 0 0 0 19 9"></path>',
		'git-merge'                          => '<circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M6 21V9a9 9 0 0 0 9 9"></path>',
		'git-pull-request-arrow'             => '<circle cx="5" cy="6" r="3"></circle><path d="M5 9v12"></path><circle cx="19" cy="18" r="3"></circle><path d="m15 9-3-3 3-3"></path><path d="M12 6h5a2 2 0 0 1 2 2v7"></path>',
		'git-pull-request-closed'            => '<circle cx="6" cy="6" r="3"></circle><path d="M6 9v12"></path><path d="m21 3-6 6"></path><path d="m21 9-6-6"></path><path d="M18 11.5V15"></path><circle cx="18" cy="18" r="3"></circle>',
		'git-pull-request-create-arrow'      => '<circle cx="5" cy="6" r="3"></circle><path d="M5 9v12"></path><path d="m15 9-3-3 3-3"></path><path d="M12 6h5a2 2 0 0 1 2 2v3"></path><path d="M19 15v6"></path><path d="M22 18h-6"></path>',
		'git-pull-request-create'            => '<circle cx="6" cy="6" r="3"></circle><path d="M6 9v12"></path><path d="M13 6h3a2 2 0 0 1 2 2v3"></path><path d="M18 15v6"></path><path d="M21 18h-6"></path>',
		'git-pull-request-draft'             => '<circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M18 6V5"></path><path d="M18 11v-1"></path><line x1="6" x2="6" y1="9" y2="21"></line>',
		'git-pull-request'                   => '<circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M13 6h3a2 2 0 0 1 2 2v7"></path><line x1="6" x2="6" y1="9" y2="21"></line>',
		'github'                             => '<path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path><path d="M9 18c-4.51 2-5-2-7-2"></path>',
		'gitlab'                             => '<path d="m22 13.29-3.33-10a.42.42 0 0 0-.14-.18.38.38 0 0 0-.22-.11.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18l-2.26 6.67H8.32L6.1 3.26a.42.42 0 0 0-.1-.18.38.38 0 0 0-.26-.08.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18L2 13.29a.74.74 0 0 0 .27.83L12 21l9.69-6.88a.71.71 0 0 0 .31-.83Z"></path>',
		'glass-water'                        => '<path d="M5.116 4.104A1 1 0 0 1 6.11 3h11.78a1 1 0 0 1 .994 1.105L17.19 20.21A2 2 0 0 1 15.2 22H8.8a2 2 0 0 1-2-1.79z"></path><path d="M6 12a5 5 0 0 1 6 0 5 5 0 0 0 6 0"></path>',
		'glasses'                            => '<circle cx="6" cy="15" r="4"></circle><circle cx="18" cy="15" r="4"></circle><path d="M14 15a2 2 0 0 0-2-2 2 2 0 0 0-2 2"></path><path d="M2.5 13 5 7c.7-1.3 1.4-2 3-2"></path><path d="M21.5 13 19 7c-.7-1.3-1.5-2-3-2"></path>',
		'globe-lock'                         => '<path d="M15.686 15A14.5 14.5 0 0 1 12 22a14.5 14.5 0 0 1 0-20 10 10 0 1 0 9.542 13"></path><path d="M2 12h8.5"></path><path d="M20 6V4a2 2 0 1 0-4 0v2"></path><rect width="8" height="5" x="14" y="6" rx="1"></rect>',
		'globe-x'                            => '<path d="m16 3 5 5"></path><path d="M2 12h20A10 10 0 1 1 12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 4-10"></path><path d="m21 3-5 5"></path>',
		'globe'                              => '<circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path>',
		'goal'                               => '<path d="M12 13V2l8 4-8 4"></path><path d="M20.561 10.222a9 9 0 1 1-12.55-5.29"></path><path d="M8.002 9.997a5 5 0 1 0 8.9 2.02"></path>',
		'gpu'                                => '<path d="M2 21V3"></path><path d="M2 5h18a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2.26"></path><path d="M7 17v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3"></path><circle cx="16" cy="11" r="2"></circle><circle cx="8" cy="11" r="2"></circle>',
		'graduation-cap'                     => '<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>',
		'grape'                              => '<path d="M22 5V2l-5.89 5.89"></path><circle cx="16.6" cy="15.89" r="3"></circle><circle cx="8.11" cy="7.4" r="3"></circle><circle cx="12.35" cy="11.65" r="3"></circle><circle cx="13.91" cy="5.85" r="3"></circle><circle cx="18.15" cy="10.09" r="3"></circle><circle cx="6.56" cy="13.2" r="3"></circle><circle cx="10.8" cy="17.44" r="3"></circle><circle cx="5" cy="19" r="3"></circle>',
		'grid-2x2-check'                     => '<path d="M12 3v17a1 1 0 0 1-1 1H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1H3"></path><path d="m16 19 2 2 4-4"></path>',
		'grid-2x2-plus'                      => '<path d="M12 3v17a1 1 0 0 1-1 1H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1H3"></path><path d="M16 19h6"></path><path d="M19 22v-6"></path>',
		'grid-2x2-x'                         => '<path d="M12 3v17a1 1 0 0 1-1 1H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1H3"></path><path d="m16 16 5 5"></path><path d="m16 21 5-5"></path>',
		'grid-2x2'                           => '<path d="M12 3v18"></path><path d="M3 12h18"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'grid-3x2'                           => '<path d="M15 3v18"></path><path d="M3 12h18"></path><path d="M9 3v18"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'grid-3x3'                           => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M3 15h18"></path><path d="M9 3v18"></path><path d="M15 3v18"></path>',
		'grip-horizontal'                    => '<circle cx="12" cy="9" r="1"></circle><circle cx="19" cy="9" r="1"></circle><circle cx="5" cy="9" r="1"></circle><circle cx="12" cy="15" r="1"></circle><circle cx="19" cy="15" r="1"></circle><circle cx="5" cy="15" r="1"></circle>',
		'grip-vertical'                      => '<circle cx="9" cy="12" r="1"></circle><circle cx="9" cy="5" r="1"></circle><circle cx="9" cy="19" r="1"></circle><circle cx="15" cy="12" r="1"></circle><circle cx="15" cy="5" r="1"></circle><circle cx="15" cy="19" r="1"></circle>',
		'grip'                               => '<circle cx="12" cy="5" r="1"></circle><circle cx="19" cy="5" r="1"></circle><circle cx="5" cy="5" r="1"></circle><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle><circle cx="12" cy="19" r="1"></circle><circle cx="19" cy="19" r="1"></circle><circle cx="5" cy="19" r="1"></circle>',
		'group'                              => '<path d="M3 7V5c0-1.1.9-2 2-2h2"></path><path d="M17 3h2c1.1 0 2 .9 2 2v2"></path><path d="M21 17v2c0 1.1-.9 2-2 2h-2"></path><path d="M7 21H5c-1.1 0-2-.9-2-2v-2"></path><rect width="7" height="5" x="7" y="7" rx="1"></rect><rect width="7" height="5" x="10" y="12" rx="1"></rect>',
		'guitar'                             => '<path d="m11.9 12.1 4.514-4.514"></path><path d="M20.1 2.3a1 1 0 0 0-1.4 0l-1.114 1.114A2 2 0 0 0 17 4.828v1.344a2 2 0 0 1-.586 1.414A2 2 0 0 1 17.828 7h1.344a2 2 0 0 0 1.414-.586L21.7 5.3a1 1 0 0 0 0-1.4z"></path><path d="m6 16 2 2"></path><path d="M8.23 9.85A3 3 0 0 1 11 8a5 5 0 0 1 5 5 3 3 0 0 1-1.85 2.77l-.92.38A2 2 0 0 0 12 18a4 4 0 0 1-4 4 6 6 0 0 1-6-6 4 4 0 0 1 4-4 2 2 0 0 0 1.85-1.23z"></path>',
		'ham'                                => '<path d="M13.144 21.144A7.274 10.445 45 1 0 2.856 10.856"></path><path d="M13.144 21.144A7.274 4.365 45 0 0 2.856 10.856a7.274 4.365 45 0 0 10.288 10.288"></path><path d="M16.565 10.435 18.6 8.4a2.501 2.501 0 1 0 1.65-4.65 2.5 2.5 0 1 0-4.66 1.66l-2.024 2.025"></path><path d="m8.5 16.5-1-1"></path>',
		'hamburger'                          => '<path d="M12 16H4a2 2 0 1 1 0-4h16a2 2 0 1 1 0 4h-4.25"></path><path d="M5 12a2 2 0 0 1-2-2 9 7 0 0 1 18 0 2 2 0 0 1-2 2"></path><path d="M5 16a2 2 0 0 0-2 2 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 2 2 0 0 0-2-2q0 0 0 0"></path><path d="m6.67 12 6.13 4.6a2 2 0 0 0 2.8-.4l3.15-4.2"></path>',
		'hammer'                             => '<path d="m15 12-9.373 9.373a1 1 0 0 1-3.001-3L12 9"></path><path d="m18 15 4-4"></path><path d="m21.5 11.5-1.914-1.914A2 2 0 0 1 19 8.172v-.344a2 2 0 0 0-.586-1.414l-1.657-1.657A6 6 0 0 0 12.516 3H9l1.243 1.243A6 6 0 0 1 12 8.485V10l2 2h1.172a2 2 0 0 1 1.414.586L18.5 14.5"></path>',
		'hand-coins'                         => '<path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"></path><path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"></path><path d="m2 16 6 6"></path><circle cx="16" cy="9" r="2.9"></circle><circle cx="6" cy="5" r="3"></circle>',
		'hand-fist'                          => '<path d="M12.035 17.012a3 3 0 0 0-3-3l-.311-.002a.72.72 0 0 1-.505-1.229l1.195-1.195A2 2 0 0 1 10.828 11H12a2 2 0 0 0 0-4H9.243a3 3 0 0 0-2.122.879l-2.707 2.707A4.83 4.83 0 0 0 3 14a8 8 0 0 0 8 8h2a8 8 0 0 0 8-8V7a2 2 0 1 0-4 0v2a2 2 0 1 0 4 0"></path><path d="M13.888 9.662A2 2 0 0 0 17 8V5A2 2 0 1 0 13 5"></path><path d="M9 5A2 2 0 1 0 5 5V10"></path><path d="M9 7V4A2 2 0 1 1 13 4V7.268"></path>',
		'hand-grab'                          => '<path d="M18 11.5V9a2 2 0 0 0-2-2a2 2 0 0 0-2 2v1.4"></path><path d="M14 10V8a2 2 0 0 0-2-2a2 2 0 0 0-2 2v2"></path><path d="M10 9.9V9a2 2 0 0 0-2-2a2 2 0 0 0-2 2v5"></path><path d="M6 14a2 2 0 0 0-2-2a2 2 0 0 0-2 2"></path><path d="M18 11a2 2 0 1 1 4 0v3a8 8 0 0 1-8 8h-4a8 8 0 0 1-8-8 2 2 0 1 1 4 0"></path>',
		'hand-heart'                         => '<path d="M11 14h2a2 2 0 0 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 16"></path><path d="m14.45 13.39 5.05-4.694C20.196 8 21 6.85 21 5.75a2.75 2.75 0 0 0-4.797-1.837.276.276 0 0 1-.406 0A2.75 2.75 0 0 0 11 5.75c0 1.2.802 2.248 1.5 2.946L16 11.95"></path><path d="m2 15 6 6"></path><path d="m7 20 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a1 1 0 0 0-2.75-2.91"></path>',
		'hand-helping'                       => '<path d="M11 12h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 14"></path><path d="m7 18 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"></path><path d="m2 13 6 6"></path>',
		'hand-metal'                         => '<path d="M18 12.5V10a2 2 0 0 0-2-2a2 2 0 0 0-2 2v1.4"></path><path d="M14 11V9a2 2 0 1 0-4 0v2"></path><path d="M10 10.5V5a2 2 0 1 0-4 0v9"></path><path d="m7 15-1.76-1.76a2 2 0 0 0-2.83 2.82l3.6 3.6C7.5 21.14 9.2 22 12 22h2a8 8 0 0 0 8-8V7a2 2 0 1 0-4 0v5"></path>',
		'hand-platter'                       => '<path d="M12 3V2"></path><path d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5"></path><path d="M2 14h12a2 2 0 0 1 0 4h-2"></path><path d="M4 10h16"></path><path d="M5 10a7 7 0 0 1 14 0"></path><path d="M5 14v6a1 1 0 0 1-1 1H2"></path>',
		'hand'                               => '<path d="M18 11V6a2 2 0 0 0-2-2a2 2 0 0 0-2 2"></path><path d="M14 10V4a2 2 0 0 0-2-2a2 2 0 0 0-2 2v2"></path><path d="M10 10.5V6a2 2 0 0 0-2-2a2 2 0 0 0-2 2v8"></path><path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"></path>',
		'handbag'                            => '<path d="M2.048 18.566A2 2 0 0 0 4 21h16a2 2 0 0 0 1.952-2.434l-2-9A2 2 0 0 0 18 8H6a2 2 0 0 0-1.952 1.566z"></path><path d="M8 11V6a4 4 0 0 1 8 0v5"></path>',
		'handshake'                          => '<path d="m11 17 2 2a1 1 0 1 0 3-3"></path><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4"></path><path d="m21 3 1 11h-2"></path><path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"></path><path d="M3 4h8"></path>',
		'hard-drive-download'                => '<path d="M12 2v8"></path><path d="m16 6-4 4-4-4"></path><rect width="20" height="8" x="2" y="14" rx="2"></rect><path d="M6 18h.01"></path><path d="M10 18h.01"></path>',
		'hard-drive-upload'                  => '<path d="m16 6-4-4-4 4"></path><path d="M12 2v8"></path><rect width="20" height="8" x="2" y="14" rx="2"></rect><path d="M6 18h.01"></path><path d="M10 18h.01"></path>',
		'hard-drive'                         => '<line x1="22" x2="2" y1="12" y2="12"></line><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" x2="6.01" y1="16" y2="16"></line><line x1="10" x2="10.01" y1="16" y2="16"></line>',
		'hard-hat'                           => '<path d="M10 10V5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5"></path><path d="M14 6a6 6 0 0 1 6 6v3"></path><path d="M4 15v-3a6 6 0 0 1 6-6"></path><rect x="2" y="15" width="20" height="4" rx="1"></rect>',
		'hash'                               => '<line x1="4" x2="20" y1="9" y2="9"></line><line x1="4" x2="20" y1="15" y2="15"></line><line x1="10" x2="8" y1="3" y2="21"></line><line x1="16" x2="14" y1="3" y2="21"></line>',
		'hat-glasses'                        => '<path d="M14 18a2 2 0 0 0-4 0"></path><path d="m19 11-2.11-6.657a2 2 0 0 0-2.752-1.148l-1.276.61A2 2 0 0 1 12 4H8.5a2 2 0 0 0-1.925 1.456L5 11"></path><path d="M2 11h20"></path><circle cx="17" cy="18" r="3"></circle><circle cx="7" cy="18" r="3"></circle>',
		'haze'                               => '<path d="m5.2 6.2 1.4 1.4"></path><path d="M2 13h2"></path><path d="M20 13h2"></path><path d="m17.4 7.6 1.4-1.4"></path><path d="M22 17H2"></path><path d="M22 21H2"></path><path d="M16 13a4 4 0 0 0-8 0"></path><path d="M12 5V2.5"></path>',
		'hd'                                 => '<path d="M10 12H6"></path><path d="M10 15V9"></path><path d="M14 14.5a.5.5 0 0 0 .5.5h1a2.5 2.5 0 0 0 2.5-2.5v-1A2.5 2.5 0 0 0 15.5 9h-1a.5.5 0 0 0-.5.5z"></path><path d="M6 15V9"></path><rect x="2" y="5" width="20" height="14" rx="2"></rect>',
		'hdmi-port'                          => '<path d="M22 9a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h1l2 2h12l2-2h1a1 1 0 0 0 1-1Z"></path><path d="M7.5 12h9"></path>',
		'heading-1'                          => '<path d="M4 12h8"></path><path d="M4 18V6"></path><path d="M12 18V6"></path><path d="m17 12 3-2v8"></path>',
		'heading-2'                          => '<path d="M4 12h8"></path><path d="M4 18V6"></path><path d="M12 18V6"></path><path d="M21 18h-4c0-4 4-3 4-6 0-1.5-2-2.5-4-1"></path>',
		'heading-3'                          => '<path d="M4 12h8"></path><path d="M4 18V6"></path><path d="M12 18V6"></path><path d="M17.5 10.5c1.7-1 3.5 0 3.5 1.5a2 2 0 0 1-2 2"></path><path d="M17 17.5c2 1.5 4 .3 4-1.5a2 2 0 0 0-2-2"></path>',
		'heading-4'                          => '<path d="M12 18V6"></path><path d="M17 10v3a1 1 0 0 0 1 1h3"></path><path d="M21 10v8"></path><path d="M4 12h8"></path><path d="M4 18V6"></path>',
		'heading-5'                          => '<path d="M4 12h8"></path><path d="M4 18V6"></path><path d="M12 18V6"></path><path d="M17 13v-3h4"></path><path d="M17 17.7c.4.2.8.3 1.3.3 1.5 0 2.7-1.1 2.7-2.5S19.8 13 18.3 13H17"></path>',
		'heading-6'                          => '<path d="M4 12h8"></path><path d="M4 18V6"></path><path d="M12 18V6"></path><circle cx="19" cy="16" r="2"></circle><path d="M20 10c-2 2-3 3.5-3 6"></path>',
		'heading'                            => '<path d="M6 12h12"></path><path d="M6 20V4"></path><path d="M18 20V4"></path>',
		'headphone-off'                      => '<path d="M21 14h-1.343"></path><path d="M9.128 3.47A9 9 0 0 1 21 12v3.343"></path><path d="m2 2 20 20"></path><path d="M20.414 20.414A2 2 0 0 1 19 21h-1a2 2 0 0 1-2-2v-3"></path><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 2.636-6.364"></path>',
		'headphones'                         => '<path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"></path>',
		'headset'                            => '<path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z"></path><path d="M21 16v2a4 4 0 0 1-4 4h-5"></path>',
		'heart-crack'                        => '<path d="M12.409 5.824c-.702.792-1.15 1.496-1.415 2.166l2.153 2.156a.5.5 0 0 1 0 .707l-2.293 2.293a.5.5 0 0 0 0 .707L12 15"></path><path d="M13.508 20.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5a5.5 5.5 0 0 1 9.591-3.677.6.6 0 0 0 .818.001A5.5 5.5 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5z"></path>',
		'heart-handshake'                    => '<path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.052 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"></path>',
		'heart-minus'                        => '<path d="m14.876 18.99-1.368 1.323a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5a5.2 5.2 0 0 1-.244 1.572"></path><path d="M15 15h6"></path>',
		'heart-off'                          => '<path d="M10.5 4.893a5.5 5.5 0 0 1 1.091.931.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 1.872-1.002 3.356-2.187 4.655"></path><path d="m16.967 16.967-3.459 3.346a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5a5.5 5.5 0 0 1 2.747-4.761"></path><path d="m2 2 20 20"></path>',
		'heart-plus'                         => '<path d="m14.479 19.374-.971.939a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5a5.2 5.2 0 0 1-.219 1.49"></path><path d="M15 15h6"></path><path d="M18 12v6"></path>',
		'heart-pulse'                        => '<path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path><path d="M3.22 13H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27"></path>',
		'heart'                              => '<path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path>',
		'heater'                             => '<path d="M11 8c2-3-2-3 0-6"></path><path d="M15.5 8c2-3-2-3 0-6"></path><path d="M6 10h.01"></path><path d="M6 14h.01"></path><path d="M10 16v-4"></path><path d="M14 16v-4"></path><path d="M18 16v-4"></path><path d="M20 6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3"></path><path d="M5 20v2"></path><path d="M19 20v2"></path>',
		'helicopter'                         => '<path d="M11 17v4"></path><path d="M14 3v8a2 2 0 0 0 2 2h5.865"></path><path d="M17 17v4"></path><path d="M18 17a4 4 0 0 0 4-4 8 6 0 0 0-8-6 6 5 0 0 0-6 5v3a2 2 0 0 0 2 2z"></path><path d="M2 10v5"></path><path d="M6 3h16"></path><path d="M7 21h14"></path><path d="M8 13H2"></path>',
		'hexagon'                            => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>',
		'highlighter'                        => '<path d="m9 11-6 6v3h9l3-3"></path><path d="m22 12-4.6 4.6a2 2 0 0 1-2.8 0l-5.2-5.2a2 2 0 0 1 0-2.8L14 4"></path>',
		'history'                            => '<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><path d="M12 7v5l4 2"></path>',
		'hop-off'                            => '<path d="M10.82 16.12c1.69.6 3.91.79 5.18.85.28.01.53-.09.7-.27"></path><path d="M11.14 20.57c.52.24 2.44 1.12 4.08 1.37.46.06.86-.25.9-.71.12-1.52-.3-3.43-.5-4.28"></path><path d="M16.13 21.05c1.65.63 3.68.84 4.87.91a.9.9 0 0 0 .7-.26"></path><path d="M17.99 5.52a20.83 20.83 0 0 1 3.15 4.5.8.8 0 0 1-.68 1.13c-1.17.1-2.5.02-3.9-.25"></path><path d="M20.57 11.14c.24.52 1.12 2.44 1.37 4.08.04.3-.08.59-.31.75"></path><path d="M4.93 4.93a10 10 0 0 0-.67 13.4c.35.43.96.4 1.17-.12.69-1.71 1.07-5.07 1.07-6.71 1.34.45 3.1.9 4.88.62a.85.85 0 0 0 .48-.24"></path><path d="M5.52 17.99c1.05.95 2.91 2.42 4.5 3.15a.8.8 0 0 0 1.13-.68c.2-2.34-.33-5.3-1.57-8.28"></path><path d="M8.35 2.68a10 10 0 0 1 9.98 1.58c.43.35.4.96-.12 1.17-1.5.6-4.3.98-6.07 1.05"></path><path d="m2 2 20 20"></path>',
		'hop'                                => '<path d="M10.82 16.12c1.69.6 3.91.79 5.18.85.55.03 1-.42.97-.97-.06-1.27-.26-3.5-.85-5.18"></path><path d="M11.5 6.5c1.64 0 5-.38 6.71-1.07.52-.2.55-.82.12-1.17A10 10 0 0 0 4.26 18.33c.35.43.96.4 1.17-.12.69-1.71 1.07-5.07 1.07-6.71 1.34.45 3.1.9 4.88.62a.88.88 0 0 0 .73-.74c.3-2.14-.15-3.5-.61-4.88"></path><path d="M15.62 16.95c.2.85.62 2.76.5 4.28a.77.77 0 0 1-.9.7 16.64 16.64 0 0 1-4.08-1.36"></path><path d="M16.13 21.05c1.65.63 3.68.84 4.87.91a.9.9 0 0 0 .96-.96 17.68 17.68 0 0 0-.9-4.87"></path><path d="M16.94 15.62c.86.2 2.77.62 4.29.5a.77.77 0 0 0 .7-.9 16.64 16.64 0 0 0-1.36-4.08"></path><path d="M17.99 5.52a20.82 20.82 0 0 1 3.15 4.5.8.8 0 0 1-.68 1.13c-2.33.2-5.3-.32-8.27-1.57"></path><path d="M4.93 4.93 3 3a.7.7 0 0 1 0-1"></path><path d="M9.58 12.18c1.24 2.98 1.77 5.95 1.57 8.28a.8.8 0 0 1-1.13.68 20.82 20.82 0 0 1-4.5-3.15"></path>',
		'hospital'                           => '<path d="M12 7v4"></path><path d="M14 21v-3a2 2 0 0 0-4 0v3"></path><path d="M14 9h-4"></path><path d="M18 11h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h2"></path><path d="M18 21V5a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16"></path>',
		'hotel'                              => '<path d="M10 22v-6.57"></path><path d="M12 11h.01"></path><path d="M12 7h.01"></path><path d="M14 15.43V22"></path><path d="M15 16a5 5 0 0 0-6 0"></path><path d="M16 11h.01"></path><path d="M16 7h.01"></path><path d="M8 11h.01"></path><path d="M8 7h.01"></path><rect x="4" y="2" width="16" height="20" rx="2"></rect>',
		'hourglass'                          => '<path d="M5 22h14"></path><path d="M5 2h14"></path><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"></path><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"></path>',
		'house-heart'                        => '<path d="M8.62 13.8A2.25 2.25 0 1 1 12 10.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a.998.998 0 0 1-1.507 0z"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>',
		'house-plug'                         => '<path d="M10 12V8.964"></path><path d="M14 12V8.964"></path><path d="M15 12a1 1 0 0 1 1 1v2a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-2a1 1 0 0 1 1-1z"></path><path d="M8.5 21H5a2 2 0 0 1-2-2v-9a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-2"></path>',
		'house-plus'                         => '<path d="M12.35 21H5a2 2 0 0 1-2-2v-9a2 2 0 0 1 .71-1.53l7-6a2 2 0 0 1 2.58 0l7 6A2 2 0 0 1 21 10v2.35"></path><path d="M14.8 12.4A1 1 0 0 0 14 12h-4a1 1 0 0 0-1 1v8"></path><path d="M15 18h6"></path><path d="M18 15v6"></path>',
		'house-wifi'                         => '<path d="M9.5 13.866a4 4 0 0 1 5 .01"></path><path d="M12 17h.01"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><path d="M7 10.754a8 8 0 0 1 10 0"></path>',
		'house'                              => '<path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>',
		'ice-cream-bowl'                     => '<path d="M12 17c5 0 8-2.69 8-6H4c0 3.31 3 6 8 6m-4 4h8m-4-3v3M5.14 11a3.5 3.5 0 1 1 6.71 0"></path><path d="M12.14 11a3.5 3.5 0 1 1 6.71 0"></path><path d="M15.5 6.5a3.5 3.5 0 1 0-7 0"></path>',
		'ice-cream-cone'                     => '<path d="m7 11 4.08 10.35a1 1 0 0 0 1.84 0L17 11"></path><path d="M17 7A5 5 0 0 0 7 7"></path><path d="M17 7a2 2 0 0 1 0 4H7a2 2 0 0 1 0-4"></path>',
		'id-card-lanyard'                    => '<path d="M13.5 8h-3"></path><path d="m15 2-1 2h3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h3"></path><path d="M16.899 22A5 5 0 0 0 7.1 22"></path><path d="m9 2 3 6"></path><circle cx="12" cy="15" r="3"></circle>',
		'id-card'                            => '<path d="M16 10h2"></path><path d="M16 14h2"></path><path d="M6.17 15a3 3 0 0 1 5.66 0"></path><circle cx="9" cy="11" r="2"></circle><rect x="2" y="5" width="20" height="14" rx="2"></rect>',
		'image-down'                         => '<path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21"></path><path d="m14 19 3 3v-5.5"></path><path d="m17 22 3-3"></path><circle cx="9" cy="9" r="2"></circle>',
		'image-minus'                        => '<path d="M21 9v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path><line x1="16" x2="22" y1="5" y2="5"></line><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>',
		'image-off'                          => '<line x1="2" x2="22" y1="2" y2="22"></line><path d="M10.41 10.41a2 2 0 1 1-2.83-2.83"></path><line x1="13.5" x2="6" y1="13.5" y2="21"></line><line x1="18" x2="21" y1="12" y2="15"></line><path d="M3.59 3.59A1.99 1.99 0 0 0 3 5v14a2 2 0 0 0 2 2h14c.55 0 1.052-.22 1.41-.59"></path><path d="M21 15V5a2 2 0 0 0-2-2H9"></path>',
		'image-play'                         => '<path d="M15 15.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997a1 1 0 0 1-1.517-.86z"></path><path d="M21 12.17V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6"></path><path d="m6 21 5-5"></path><circle cx="9" cy="9" r="2"></circle>',
		'image-plus'                         => '<path d="M16 5h6"></path><path d="M19 2v6"></path><path d="M21 11.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7.5"></path><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path><circle cx="9" cy="9" r="2"></circle>',
		'image-up'                           => '<path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21"></path><path d="m14 19.5 3-3 3 3"></path><path d="M17 22v-5.5"></path><circle cx="9" cy="9" r="2"></circle>',
		'image-upscale'                      => '<path d="M16 3h5v5"></path><path d="M17 21h2a2 2 0 0 0 2-2"></path><path d="M21 12v3"></path><path d="m21 3-5 5"></path><path d="M3 7V5a2 2 0 0 1 2-2"></path><path d="m5 21 4.144-4.144a1.21 1.21 0 0 1 1.712 0L13 19"></path><path d="M9 3h3"></path><rect x="3" y="11" width="10" height="10" rx="1"></rect>',
		'image'                              => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>',
		'images'                             => '<path d="m22 11-1.296-1.296a2.4 2.4 0 0 0-3.408 0L11 16"></path><path d="M4 8a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2"></path><circle cx="13" cy="7" r="1" fill="currentColor"></circle><rect x="8" y="2" width="14" height="14" rx="2"></rect>',
		'import'                             => '<path d="M12 3v12"></path><path d="m8 11 4 4 4-4"></path><path d="M8 5H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-4"></path>',
		'inbox'                              => '<polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>',
		'indian-rupee'                       => '<path d="M6 3h12"></path><path d="M6 8h12"></path><path d="m6 13 8.5 8"></path><path d="M6 13h3"></path><path d="M9 13c6.667 0 6.667-10 0-10"></path>',
		'infinity'                           => '<path d="M6 16c5 0 7-8 12-8a4 4 0 0 1 0 8c-5 0-7-8-12-8a4 4 0 1 0 0 8"></path>',
		'info'                               => '<circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path>',
		'inspection-panel'                   => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7 7h.01"></path><path d="M17 7h.01"></path><path d="M7 17h.01"></path><path d="M17 17h.01"></path>',
		'instagram'                          => '<rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>',
		'italic'                             => '<line x1="19" x2="10" y1="4" y2="4"></line><line x1="14" x2="5" y1="20" y2="20"></line><line x1="15" x2="9" y1="4" y2="20"></line>',
		'iteration-ccw'                      => '<path d="m16 14 4 4-4 4"></path><path d="M20 10a8 8 0 1 0-8 8h8"></path>',
		'iteration-cw'                       => '<path d="M4 10a8 8 0 1 1 8 8H4"></path><path d="m8 22-4-4 4-4"></path>',
		'japanese-yen'                       => '<path d="M12 9.5V21m0-11.5L6 3m6 6.5L18 3"></path><path d="M6 15h12"></path><path d="M6 11h12"></path>',
		'joystick'                           => '<path d="M21 17a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2Z"></path><path d="M6 15v-2"></path><path d="M12 15V9"></path><circle cx="12" cy="6" r="3"></circle>',
		'kanban'                             => '<path d="M5 3v14"></path><path d="M12 3v8"></path><path d="M19 3v18"></path>',
		'kayak'                              => '<path d="M18 17a1 1 0 0 0-1 1v1a2 2 0 1 0 2-2z"></path><path d="M20.97 3.61a.45.45 0 0 0-.58-.58C10.2 6.6 6.6 10.2 3.03 20.39a.45.45 0 0 0 .58.58C13.8 17.4 17.4 13.8 20.97 3.61"></path><path d="m6.707 6.707 10.586 10.586"></path><path d="M7 5a2 2 0 1 0-2 2h1a1 1 0 0 0 1-1z"></path>',
		'key-round'                          => '<path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>',
		'key-square'                         => '<path d="M12.4 2.7a2.5 2.5 0 0 1 3.4 0l5.5 5.5a2.5 2.5 0 0 1 0 3.4l-3.7 3.7a2.5 2.5 0 0 1-3.4 0L8.7 9.8a2.5 2.5 0 0 1 0-3.4z"></path><path d="m14 7 3 3"></path><path d="m9.4 10.6-6.814 6.814A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814"></path>',
		'key'                                => '<path d="m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4"></path><path d="m21 2-9.6 9.6"></path><circle cx="7.5" cy="15.5" r="5.5"></circle>',
		'keyboard-music'                     => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="M6 8h4"></path><path d="M14 8h.01"></path><path d="M18 8h.01"></path><path d="M2 12h20"></path><path d="M6 12v4"></path><path d="M10 12v4"></path><path d="M14 12v4"></path><path d="M18 12v4"></path>',
		'keyboard-off'                       => '<path d="M 20 4 A2 2 0 0 1 22 6"></path><path d="M 22 6 L 22 16.41"></path><path d="M 7 16 L 16 16"></path><path d="M 9.69 4 L 20 4"></path><path d="M14 8h.01"></path><path d="M18 8h.01"></path><path d="m2 2 20 20"></path><path d="M20 20H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2"></path><path d="M6 8h.01"></path><path d="M8 12h.01"></path>',
		'keyboard'                           => '<path d="M10 8h.01"></path><path d="M12 12h.01"></path><path d="M14 8h.01"></path><path d="M16 12h.01"></path><path d="M18 8h.01"></path><path d="M6 8h.01"></path><path d="M7 16h10"></path><path d="M8 12h.01"></path><rect width="20" height="16" x="2" y="4" rx="2"></rect>',
		'lamp-ceiling'                       => '<path d="M12 2v5"></path><path d="M14.829 15.998a3 3 0 1 1-5.658 0"></path><path d="M20.92 14.606A1 1 0 0 1 20 16H4a1 1 0 0 1-.92-1.394l3-7A1 1 0 0 1 7 7h10a1 1 0 0 1 .92.606z"></path>',
		'lamp-desk'                          => '<path d="M10.293 2.293a1 1 0 0 1 1.414 0l2.5 2.5 5.994 1.227a1 1 0 0 1 .506 1.687l-7 7a1 1 0 0 1-1.687-.506l-1.227-5.994-2.5-2.5a1 1 0 0 1 0-1.414z"></path><path d="m14.207 4.793-3.414 3.414"></path><path d="M3 20a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"></path><path d="m9.086 6.5-4.793 4.793a1 1 0 0 0-.18 1.17L7 18"></path>',
		'lamp-floor'                         => '<path d="M12 10v12"></path><path d="M17.929 7.629A1 1 0 0 1 17 9H7a1 1 0 0 1-.928-1.371l2-5A1 1 0 0 1 9 2h6a1 1 0 0 1 .928.629z"></path><path d="M9 22h6"></path>',
		'lamp-wall-down'                     => '<path d="M19.929 18.629A1 1 0 0 1 19 20H9a1 1 0 0 1-.928-1.371l2-5A1 1 0 0 1 11 13h6a1 1 0 0 1 .928.629z"></path><path d="M6 3a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"></path><path d="M8 6h4a2 2 0 0 1 2 2v5"></path>',
		'lamp-wall-up'                       => '<path d="M19.929 9.629A1 1 0 0 1 19 11H9a1 1 0 0 1-.928-1.371l2-5A1 1 0 0 1 11 4h6a1 1 0 0 1 .928.629z"></path><path d="M6 15a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1z"></path><path d="M8 18h4a2 2 0 0 0 2-2v-5"></path>',
		'lamp'                               => '<path d="M12 12v6"></path><path d="M4.077 10.615A1 1 0 0 0 5 12h14a1 1 0 0 0 .923-1.385l-3.077-7.384A2 2 0 0 0 15 2H9a2 2 0 0 0-1.846 1.23Z"></path><path d="M8 20a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1z"></path>',
		'land-plot'                          => '<path d="m12 8 6-3-6-3v10"></path><path d="m8 11.99-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12"></path><path d="m6.49 12.85 11.02 6.3"></path><path d="M17.51 12.85 6.5 19.15"></path>',
		'landmark'                           => '<path d="M10 18v-7"></path><path d="M11.12 2.198a2 2 0 0 1 1.76.006l7.866 3.847c.476.233.31.949-.22.949H3.474c-.53 0-.695-.716-.22-.949z"></path><path d="M14 18v-7"></path><path d="M18 18v-7"></path><path d="M3 22h18"></path><path d="M6 18v-7"></path>',
		'languages'                          => '<path d="m5 8 6 6"></path><path d="m4 14 6-6 2-3"></path><path d="M2 5h12"></path><path d="M7 2h1"></path><path d="m22 22-5-10-5 10"></path><path d="M14 18h6"></path>',
		'laptop-minimal-check'               => '<path d="M2 20h20"></path><path d="m9 10 2 2 4-4"></path><rect x="3" y="4" width="18" height="12" rx="2"></rect>',
		'laptop-minimal'                     => '<rect width="18" height="12" x="3" y="4" rx="2" ry="2"></rect><line x1="2" x2="22" y1="20" y2="20"></line>',
		'laptop'                             => '<path d="M18 5a2 2 0 0 1 2 2v8.526a2 2 0 0 0 .212.897l1.068 2.127a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45l1.068-2.127A2 2 0 0 0 4 15.526V7a2 2 0 0 1 2-2z"></path><path d="M20.054 15.987H3.946"></path>',
		'lasso-select'                       => '<path d="M7 22a5 5 0 0 1-2-4"></path><path d="M7 16.93c.96.43 1.96.74 2.99.91"></path><path d="M3.34 14A6.8 6.8 0 0 1 2 10c0-4.42 4.48-8 10-8s10 3.58 10 8a7.19 7.19 0 0 1-.33 2"></path><path d="M5 18a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path><path d="M14.33 22h-.09a.35.35 0 0 1-.24-.32v-10a.34.34 0 0 1 .33-.34c.08 0 .15.03.21.08l7.34 6a.33.33 0 0 1-.21.59h-4.49l-2.57 3.85a.35.35 0 0 1-.28.14z"></path>',
		'lasso'                              => '<path d="M3.704 14.467a10 8 0 1 1 3.115 2.375"></path><path d="M7 22a5 5 0 0 1-2-3.994"></path><circle cx="5" cy="16" r="2"></circle>',
		'laugh'                              => '<circle cx="12" cy="12" r="10"></circle><path d="M18 13a6 6 0 0 1-6 5 6 6 0 0 1-6-5h12Z"></path><line x1="9" x2="9.01" y1="9" y2="9"></line><line x1="15" x2="15.01" y1="9" y2="9"></line>',
		'layers-2'                           => '<path d="M13 13.74a2 2 0 0 1-2 0L2.5 8.87a1 1 0 0 1 0-1.74L11 2.26a2 2 0 0 1 2 0l8.5 4.87a1 1 0 0 1 0 1.74z"></path><path d="m20 14.285 1.5.845a1 1 0 0 1 0 1.74L13 21.74a2 2 0 0 1-2 0l-8.5-4.87a1 1 0 0 1 0-1.74l1.5-.845"></path>',
		'layers-plus'                        => '<path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 .83.18 2 2 0 0 0 .83-.18l8.58-3.9a1 1 0 0 0 0-1.831z"></path><path d="M16 17h6"></path><path d="M19 14v6"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 .825.178"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l2.116-.962"></path>',
		'layers'                             => '<path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>',
		'layout-dashboard'                   => '<rect width="7" height="9" x="3" y="3" rx="1"></rect><rect width="7" height="5" x="14" y="3" rx="1"></rect><rect width="7" height="9" x="14" y="12" rx="1"></rect><rect width="7" height="5" x="3" y="16" rx="1"></rect>',
		'layout-grid'                        => '<rect width="7" height="7" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="14" rx="1"></rect><rect width="7" height="7" x="3" y="14" rx="1"></rect>',
		'layout-list'                        => '<rect width="7" height="7" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="3" y="14" rx="1"></rect><path d="M14 4h7"></path><path d="M14 9h7"></path><path d="M14 15h7"></path><path d="M14 20h7"></path>',
		'layout-panel-left'                  => '<rect width="7" height="18" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="14" rx="1"></rect>',
		'layout-panel-top'                   => '<rect width="18" height="7" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="3" y="14" rx="1"></rect><rect width="7" height="7" x="14" y="14" rx="1"></rect>',
		'layout-template'                    => '<rect width="18" height="7" x="3" y="3" rx="1"></rect><rect width="9" height="7" x="3" y="14" rx="1"></rect><rect width="5" height="7" x="16" y="14" rx="1"></rect>',
		'leaf'                               => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>',
		'leafy-green'                        => '<path d="M2 22c1.25-.987 2.27-1.975 3.9-2.2a5.56 5.56 0 0 1 3.8 1.5 4 4 0 0 0 6.187-2.353 3.5 3.5 0 0 0 3.69-5.116A3.5 3.5 0 0 0 20.95 8 3.5 3.5 0 1 0 16 3.05a3.5 3.5 0 0 0-5.831 1.373 3.5 3.5 0 0 0-5.116 3.69 4 4 0 0 0-2.348 6.155C3.499 15.42 4.409 16.712 4.2 18.1 3.926 19.743 3.014 20.732 2 22"></path><path d="M2 22 17 7"></path>',
		'lectern'                            => '<path d="M16 12h3a2 2 0 0 0 1.902-1.38l1.056-3.333A1 1 0 0 0 21 6H3a1 1 0 0 0-.958 1.287l1.056 3.334A2 2 0 0 0 5 12h3"></path><path d="M18 6V3a1 1 0 0 0-1-1h-3"></path><rect width="8" height="12" x="8" y="10" rx="1"></rect>',
		'library-big'                        => '<rect width="8" height="18" x="3" y="3" rx="1"></rect><path d="M7 3v18"></path><path d="M20.4 18.9c.2.5-.1 1.1-.6 1.3l-1.9.7c-.5.2-1.1-.1-1.3-.6L11.1 5.1c-.2-.5.1-1.1.6-1.3l1.9-.7c.5-.2 1.1.1 1.3.6Z"></path>',
		'library'                            => '<path d="m16 6 4 14"></path><path d="M12 6v14"></path><path d="M8 8v12"></path><path d="M4 4v16"></path>',
		'life-buoy'                          => '<circle cx="12" cy="12" r="10"></circle><path d="m4.93 4.93 4.24 4.24"></path><path d="m14.83 9.17 4.24-4.24"></path><path d="m14.83 14.83 4.24 4.24"></path><path d="m9.17 14.83-4.24 4.24"></path><circle cx="12" cy="12" r="4"></circle>',
		'ligature'                           => '<path d="M14 12h2v8"></path><path d="M14 20h4"></path><path d="M6 12h4"></path><path d="M6 20h4"></path><path d="M8 20V8a4 4 0 0 1 7.464-2"></path>',
		'lightbulb-off'                      => '<path d="M16.8 11.2c.8-.9 1.2-2 1.2-3.2a6 6 0 0 0-9.3-5"></path><path d="m2 2 20 20"></path><path d="M6.3 6.3a4.67 4.67 0 0 0 1.2 5.2c.7.7 1.3 1.5 1.5 2.5"></path><path d="M9 18h6"></path><path d="M10 22h4"></path>',
		'lightbulb'                          => '<path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"></path><path d="M9 18h6"></path><path d="M10 22h4"></path>',
		'line-squiggle'                      => '<path d="M7 3.5c5-2 7 2.5 3 4C1.5 10 2 15 5 16c5 2 9-10 14-7s.5 13.5-4 12c-5-2.5.5-11 6-2"></path>',
		'link-2-off'                         => '<path d="M9 17H7A5 5 0 0 1 7 7"></path><path d="M15 7h2a5 5 0 0 1 4 8"></path><line x1="8" x2="12" y1="12" y2="12"></line><line x1="2" x2="22" y1="2" y2="22"></line>',
		'link-2'                             => '<path d="M9 17H7A5 5 0 0 1 7 7h2"></path><path d="M15 7h2a5 5 0 1 1 0 10h-2"></path><line x1="8" x2="16" y1="12" y2="12"></line>',
		'link'                               => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>',
		'linkedin'                           => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle>',
		'list-check'                         => '<path d="M16 5H3"></path><path d="M16 12H3"></path><path d="M11 19H3"></path><path d="m15 18 2 2 4-4"></path>',
		'list-checks'                        => '<path d="M13 5h8"></path><path d="M13 12h8"></path><path d="M13 19h8"></path><path d="m3 17 2 2 4-4"></path><path d="m3 7 2 2 4-4"></path>',
		'list-chevrons-down-up'              => '<path d="M3 5h8"></path><path d="M3 12h8"></path><path d="M3 19h8"></path><path d="m15 5 3 3 3-3"></path><path d="m15 19 3-3 3 3"></path>',
		'list-chevrons-up-down'              => '<path d="M3 5h8"></path><path d="M3 12h8"></path><path d="M3 19h8"></path><path d="m15 8 3-3 3 3"></path><path d="m15 16 3 3 3-3"></path>',
		'list-collapse'                      => '<path d="M10 5h11"></path><path d="M10 12h11"></path><path d="M10 19h11"></path><path d="m3 10 3-3-3-3"></path><path d="m3 20 3-3-3-3"></path>',
		'list-end'                           => '<path d="M16 5H3"></path><path d="M16 12H3"></path><path d="M9 19H3"></path><path d="m16 16-3 3 3 3"></path><path d="M21 5v12a2 2 0 0 1-2 2h-6"></path>',
		'list-filter-plus'                   => '<path d="M12 5H2"></path><path d="M6 12h12"></path><path d="M9 19h6"></path><path d="M16 5h6"></path><path d="M19 8V2"></path>',
		'list-filter'                        => '<path d="M2 5h20"></path><path d="M6 12h12"></path><path d="M9 19h6"></path>',
		'list-indent-decrease'               => '<path d="M21 5H11"></path><path d="M21 12H11"></path><path d="M21 19H11"></path><path d="m7 8-4 4 4 4"></path>',
		'list-indent-increase'               => '<path d="M21 5H11"></path><path d="M21 12H11"></path><path d="M21 19H11"></path><path d="m3 8 4 4-4 4"></path>',
		'list-minus'                         => '<path d="M16 5H3"></path><path d="M11 12H3"></path><path d="M16 19H3"></path><path d="M21 12h-6"></path>',
		'list-music'                         => '<path d="M16 5H3"></path><path d="M11 12H3"></path><path d="M11 19H3"></path><path d="M21 16V5"></path><circle cx="18" cy="16" r="3"></circle>',
		'list-ordered'                       => '<path d="M11 5h10"></path><path d="M11 12h10"></path><path d="M11 19h10"></path><path d="M4 4h1v5"></path><path d="M4 9h2"></path><path d="M6.5 20H3.4c0-1 2.6-1.925 2.6-3.5a1.5 1.5 0 0 0-2.6-1.02"></path>',
		'list-plus'                          => '<path d="M16 5H3"></path><path d="M11 12H3"></path><path d="M16 19H3"></path><path d="M18 9v6"></path><path d="M21 12h-6"></path>',
		'list-restart'                       => '<path d="M21 5H3"></path><path d="M7 12H3"></path><path d="M7 19H3"></path><path d="M12 18a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L11 14"></path><path d="M11 10v4h4"></path>',
		'list-start'                         => '<path d="M3 5h6"></path><path d="M3 12h13"></path><path d="M3 19h13"></path><path d="m16 8-3-3 3-3"></path><path d="M21 19V7a2 2 0 0 0-2-2h-6"></path>',
		'list-todo'                          => '<path d="M13 5h8"></path><path d="M13 12h8"></path><path d="M13 19h8"></path><path d="m3 17 2 2 4-4"></path><rect x="3" y="4" width="6" height="6" rx="1"></rect>',
		'list-tree'                          => '<path d="M8 5h13"></path><path d="M13 12h8"></path><path d="M13 19h8"></path><path d="M3 10a2 2 0 0 0 2 2h3"></path><path d="M3 5v12a2 2 0 0 0 2 2h3"></path>',
		'list-video'                         => '<path d="M21 5H3"></path><path d="M10 12H3"></path><path d="M10 19H3"></path><path d="M15 12.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997a1 1 0 0 1-1.517-.86z"></path>',
		'list-x'                             => '<path d="M16 5H3"></path><path d="M11 12H3"></path><path d="M16 19H3"></path><path d="m15.5 9.5 5 5"></path><path d="m20.5 9.5-5 5"></path>',
		'list'                               => '<path d="M3 5h.01"></path><path d="M3 12h.01"></path><path d="M3 19h.01"></path><path d="M8 5h13"></path><path d="M8 12h13"></path><path d="M8 19h13"></path>',
		'loader-circle'                      => '<path d="M21 12a9 9 0 1 1-6.219-8.56"></path>',
		'loader-pinwheel'                    => '<path d="M22 12a1 1 0 0 1-10 0 1 1 0 0 0-10 0"></path><path d="M7 20.7a1 1 0 1 1 5-8.7 1 1 0 1 0 5-8.6"></path><path d="M7 3.3a1 1 0 1 1 5 8.6 1 1 0 1 0 5 8.6"></path><circle cx="12" cy="12" r="10"></circle>',
		'loader'                             => '<path d="M12 2v4"></path><path d="m16.2 7.8 2.9-2.9"></path><path d="M18 12h4"></path><path d="m16.2 16.2 2.9 2.9"></path><path d="M12 18v4"></path><path d="m4.9 19.1 2.9-2.9"></path><path d="M2 12h4"></path><path d="m4.9 4.9 2.9 2.9"></path>',
		'locate-fixed'                       => '<line x1="2" x2="5" y1="12" y2="12"></line><line x1="19" x2="22" y1="12" y2="12"></line><line x1="12" x2="12" y1="2" y2="5"></line><line x1="12" x2="12" y1="19" y2="22"></line><circle cx="12" cy="12" r="7"></circle><circle cx="12" cy="12" r="3"></circle>',
		'locate-off'                         => '<path d="M12 19v3"></path><path d="M12 2v3"></path><path d="M18.89 13.24a7 7 0 0 0-8.13-8.13"></path><path d="M19 12h3"></path><path d="M2 12h3"></path><path d="m2 2 20 20"></path><path d="M7.05 7.05a7 7 0 0 0 9.9 9.9"></path>',
		'locate'                             => '<line x1="2" x2="5" y1="12" y2="12"></line><line x1="19" x2="22" y1="12" y2="12"></line><line x1="12" x2="12" y1="2" y2="5"></line><line x1="12" x2="12" y1="19" y2="22"></line><circle cx="12" cy="12" r="7"></circle>',
		'lock-keyhole-open'                  => '<circle cx="12" cy="16" r="1"></circle><rect width="18" height="12" x="3" y="10" rx="2"></rect><path d="M7 10V7a5 5 0 0 1 9.33-2.5"></path>',
		'lock-keyhole'                       => '<circle cx="12" cy="16" r="1"></circle><rect x="3" y="10" width="18" height="12" rx="2"></rect><path d="M7 10V7a5 5 0 0 1 10 0v3"></path>',
		'lock-open'                          => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path>',
		'lock'                               => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>',
		'log-in'                             => '<path d="m10 17 5-5-5-5"></path><path d="M15 12H3"></path><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>',
		'log-out'                            => '<path d="m16 17 5-5-5-5"></path><path d="M21 12H9"></path><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>',
		'logs'                               => '<path d="M3 5h1"></path><path d="M3 12h1"></path><path d="M3 19h1"></path><path d="M8 5h1"></path><path d="M8 12h1"></path><path d="M8 19h1"></path><path d="M13 5h8"></path><path d="M13 12h8"></path><path d="M13 19h8"></path>',
		'lollipop'                           => '<circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path><path d="M11 11a2 2 0 0 0 4 0 4 4 0 0 0-8 0 6 6 0 0 0 12 0"></path>',
		'luggage'                            => '<path d="M6 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2"></path><path d="M8 18V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v14"></path><path d="M10 20h4"></path><circle cx="16" cy="20" r="2"></circle><circle cx="8" cy="20" r="2"></circle>',
		'magnet'                             => '<path d="m12 15 4 4"></path><path d="M2.352 10.648a1.205 1.205 0 0 0 0 1.704l2.296 2.296a1.205 1.205 0 0 0 1.704 0l6.029-6.029a1 1 0 1 1 3 3l-6.029 6.029a1.205 1.205 0 0 0 0 1.704l2.296 2.296a1.205 1.205 0 0 0 1.704 0l6.365-6.367A1 1 0 0 0 8.716 4.282z"></path><path d="m5 8 4 4"></path>',
		'mail-check'                         => '<path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"></path><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path><path d="m16 19 2 2 4-4"></path>',
		'mail-minus'                         => '<path d="M22 15V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"></path><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path><path d="M16 19h6"></path>',
		'mail-open'                          => '<path d="M21.2 8.4c.5.38.8.97.8 1.6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 .8-1.6l8-6a2 2 0 0 1 2.4 0l8 6Z"></path><path d="m22 10-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 10"></path>',
		'mail-plus'                          => '<path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"></path><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path><path d="M19 16v6"></path><path d="M16 19h6"></path>',
		'mail-question-mark'                 => '<path d="M22 10.5V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12.5"></path><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path><path d="M18 15.28c.2-.4.5-.8.9-1a2.1 2.1 0 0 1 2.6.4c.3.4.5.8.5 1.3 0 1.3-2 2-2 2"></path><path d="M20 22v.01"></path>',
		'mail-search'                        => '<path d="M22 12.5V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h7.5"></path><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path><path d="M18 21a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"></path><circle cx="18" cy="18" r="3"></circle><path d="m22 22-1.5-1.5"></path>',
		'mail-warning'                       => '<path d="M22 10.5V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12.5"></path><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path><path d="M20 14v4"></path><path d="M20 22v.01"></path>',
		'mail-x'                             => '<path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h9"></path><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path><path d="m17 17 4 4"></path><path d="m21 17-4 4"></path>',
		'mail'                               => '<path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect>',
		'mailbox'                            => '<path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9.5C2 7 4 5 6.5 5H18c2.2 0 4 1.8 4 4v8Z"></path><polyline points="15,9 18,9 18,11"></polyline><path d="M6.5 5C9 5 11 7 11 9.5V17a2 2 0 0 1-2 2"></path><line x1="6" x2="7" y1="10" y2="10"></line>',
		'mails'                              => '<path d="M17 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 1-1.732"></path><path d="m22 5.5-6.419 4.179a2 2 0 0 1-2.162 0L7 5.5"></path><rect x="7" y="3" width="15" height="12" rx="2"></rect>',
		'map-minus'                          => '<path d="m11 19-1.106-.552a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0l4.212 2.106a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619V14"></path><path d="M15 5.764V14"></path><path d="M21 18h-6"></path><path d="M9 3.236v15"></path>',
		'map-pin-check-inside'               => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><path d="m9 10 2 2 4-4"></path>',
		'map-pin-check'                      => '<path d="M19.43 12.935c.357-.967.57-1.955.57-2.935a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 1.202 0 32.197 32.197 0 0 0 .813-.728"></path><circle cx="12" cy="10" r="3"></circle><path d="m16 18 2 2 4-4"></path>',
		'map-pin-house'                      => '<path d="M15 22a1 1 0 0 1-1-1v-4a1 1 0 0 1 .445-.832l3-2a1 1 0 0 1 1.11 0l3 2A1 1 0 0 1 22 17v4a1 1 0 0 1-1 1z"></path><path d="M18 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 .601.2"></path><path d="M18 22v-3"></path><circle cx="10" cy="10" r="3"></circle>',
		'map-pin-minus-inside'               => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><path d="M9 10h6"></path>',
		'map-pin-minus'                      => '<path d="M18.977 14C19.6 12.701 20 11.343 20 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 1.202 0 32 32 0 0 0 .824-.738"></path><circle cx="12" cy="10" r="3"></circle><path d="M16 18h6"></path>',
		'map-pin-off'                        => '<path d="M12.75 7.09a3 3 0 0 1 2.16 2.16"></path><path d="M17.072 17.072c-1.634 2.17-3.527 3.912-4.471 4.727a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 1.432-4.568"></path><path d="m2 2 20 20"></path><path d="M8.475 2.818A8 8 0 0 1 20 10c0 1.183-.31 2.377-.81 3.533"></path><path d="M9.13 9.13a3 3 0 0 0 3.74 3.74"></path>',
		'map-pin-pen'                        => '<path d="M17.97 9.304A8 8 0 0 0 2 10c0 4.69 4.887 9.562 7.022 11.468"></path><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path><circle cx="10" cy="10" r="3"></circle>',
		'map-pin-plus-inside'                => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><path d="M12 7v6"></path><path d="M9 10h6"></path>',
		'map-pin-plus'                       => '<path d="M19.914 11.105A7.298 7.298 0 0 0 20 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 1.202 0 32 32 0 0 0 .824-.738"></path><circle cx="12" cy="10" r="3"></circle><path d="M16 18h6"></path><path d="M19 15v6"></path>',
		'map-pin-x-inside'                   => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><path d="m14.5 7.5-5 5"></path><path d="m9.5 7.5 5 5"></path>',
		'map-pin-x'                          => '<path d="M19.752 11.901A7.78 7.78 0 0 0 20 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 1.202 0 19 19 0 0 0 .09-.077"></path><circle cx="12" cy="10" r="3"></circle><path d="m21.5 15.5-5 5"></path><path d="m21.5 20.5-5-5"></path>',
		'map-pin'                            => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle>',
		'map-pinned'                         => '<path d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0"></path><circle cx="12" cy="8" r="2"></circle><path d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712"></path>',
		'map-plus'                           => '<path d="m11 19-1.106-.552a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0l4.212 2.106a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619V12"></path><path d="M15 5.764V12"></path><path d="M18 15v6"></path><path d="M21 18h-6"></path><path d="M9 3.236v15"></path>',
		'map'                                => '<path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"></path><path d="M15 5.764v15"></path><path d="M9 3.236v15"></path>',
		'mars-stroke'                        => '<path d="m14 6 4 4"></path><path d="M17 3h4v4"></path><path d="m21 3-7.75 7.75"></path><circle cx="9" cy="15" r="6"></circle>',
		'mars'                               => '<path d="M16 3h5v5"></path><path d="m21 3-6.75 6.75"></path><circle cx="10" cy="14" r="6"></circle>',
		'martini'                            => '<path d="M8 22h8"></path><path d="M12 11v11"></path><path d="m19 3-7 8-7-8Z"></path>',
		'maximize-2'                         => '<path d="M15 3h6v6"></path><path d="m21 3-7 7"></path><path d="m3 21 7-7"></path><path d="M9 21H3v-6"></path>',
		'maximize'                           => '<path d="M8 3H5a2 2 0 0 0-2 2v3"></path><path d="M21 8V5a2 2 0 0 0-2-2h-3"></path><path d="M3 16v3a2 2 0 0 0 2 2h3"></path><path d="M16 21h3a2 2 0 0 0 2-2v-3"></path>',
		'medal'                              => '<path d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15"></path><path d="M11 12 5.12 2.2"></path><path d="m13 12 5.88-9.8"></path><path d="M8 7h8"></path><circle cx="12" cy="17" r="5"></circle><path d="M12 18v-2h-.5"></path>',
		'megaphone-off'                      => '<path d="M11.636 6A13 13 0 0 0 19.4 3.2 1 1 0 0 1 21 4v11.344"></path><path d="M14.378 14.357A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1"></path><path d="m2 2 20 20"></path><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"></path><path d="M8 8v6"></path>',
		'megaphone'                          => '<path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"></path><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"></path><path d="M8 6v8"></path>',
		'meh'                                => '<circle cx="12" cy="12" r="10"></circle><line x1="8" x2="16" y1="15" y2="15"></line><line x1="9" x2="9.01" y1="9" y2="9"></line><line x1="15" x2="15.01" y1="9" y2="9"></line>',
		'memory-stick'                       => '<path d="M12 12v-2"></path><path d="M12 18v-2"></path><path d="M16 12v-2"></path><path d="M16 18v-2"></path><path d="M2 11h1.5"></path><path d="M20 18v-2"></path><path d="M20.5 11H22"></path><path d="M4 18v-2"></path><path d="M8 12v-2"></path><path d="M8 18v-2"></path><rect x="2" y="6" width="20" height="10" rx="2"></rect>',
		'menu'                               => '<path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path>',
		'merge'                              => '<path d="m8 6 4-4 4 4"></path><path d="M12 2v10.3a4 4 0 0 1-1.172 2.872L4 22"></path><path d="m20 22-5-5"></path>',
		'message-circle-code'                => '<path d="m10 9-3 3 3 3"></path><path d="m14 15 3-3-3-3"></path><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path>',
		'message-circle-dashed'              => '<path d="M10.1 2.182a10 10 0 0 1 3.8 0"></path><path d="M13.9 21.818a10 10 0 0 1-3.8 0"></path><path d="M17.609 3.72a10 10 0 0 1 2.69 2.7"></path><path d="M2.182 13.9a10 10 0 0 1 0-3.8"></path><path d="M20.28 17.61a10 10 0 0 1-2.7 2.69"></path><path d="M21.818 10.1a10 10 0 0 1 0 3.8"></path><path d="M3.721 6.391a10 10 0 0 1 2.7-2.69"></path><path d="m6.163 21.117-2.906.85a1 1 0 0 1-1.236-1.169l.965-2.98"></path>',
		'message-circle-heart'               => '<path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path><path d="M7.828 13.07A3 3 0 0 1 12 8.764a3 3 0 0 1 5.004 2.224 3 3 0 0 1-.832 2.083l-3.447 3.62a1 1 0 0 1-1.45-.001z"></path>',
		'message-circle-more'                => '<path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path><path d="M8 12h.01"></path><path d="M12 12h.01"></path><path d="M16 12h.01"></path>',
		'message-circle-off'                 => '<path d="m2 2 20 20"></path><path d="M4.93 4.929a10 10 0 0 0-1.938 11.412 2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 0 0 11.302-1.989"></path><path d="M8.35 2.69A10 10 0 0 1 21.3 15.65"></path>',
		'message-circle-plus'                => '<path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path><path d="M8 12h8"></path><path d="M12 8v8"></path>',
		'message-circle-question-mark'       => '<path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path>',
		'message-circle-reply'               => '<path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path><path d="m10 15-3-3 3-3"></path><path d="M7 12h8a2 2 0 0 1 2 2v1"></path>',
		'message-circle-warning'             => '<path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path>',
		'message-circle-x'                   => '<path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path>',
		'message-circle'                     => '<path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path>',
		'message-square-code'                => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="m10 8-3 3 3 3"></path><path d="m14 14 3-3-3-3"></path>',
		'message-square-dashed'              => '<path d="M14 3h2"></path><path d="M16 19h-2"></path><path d="M2 12v-2"></path><path d="M2 16v5.286a.71.71 0 0 0 1.212.502l1.149-1.149"></path><path d="M20 19a2 2 0 0 0 2-2v-1"></path><path d="M22 10v2"></path><path d="M22 6V5a2 2 0 0 0-2-2"></path><path d="M4 3a2 2 0 0 0-2 2v1"></path><path d="M8 19h2"></path><path d="M8 3h2"></path>',
		'message-square-diff'                => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="M10 15h4"></path><path d="M10 9h4"></path><path d="M12 7v4"></path>',
		'message-square-dot'                 => '<path d="M12.7 3H4a2 2 0 0 0-2 2v16.286a.71.71 0 0 0 1.212.502l2.202-2.202A2 2 0 0 1 6.828 19H20a2 2 0 0 0 2-2v-4.7"></path><circle cx="19" cy="6" r="3"></circle>',
		'message-square-heart'               => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="M7.5 9.5c0 .687.265 1.383.697 1.844l3.009 3.264a1.14 1.14 0 0 0 .407.314 1 1 0 0 0 .783-.004 1.14 1.14 0 0 0 .398-.31l3.008-3.264A2.77 2.77 0 0 0 16.5 9.5 2.5 2.5 0 0 0 12 8a2.5 2.5 0 0 0-4.5 1.5"></path>',
		'message-square-lock'                => '<path d="M22 8.5V5a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v16.286a.71.71 0 0 0 1.212.502l2.202-2.202A2 2 0 0 1 6.828 19H10"></path><path d="M20 15v-2a2 2 0 0 0-4 0v2"></path><rect x="14" y="15" width="8" height="5" rx="1"></rect>',
		'message-square-more'                => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="M12 11h.01"></path><path d="M16 11h.01"></path><path d="M8 11h.01"></path>',
		'message-square-off'                 => '<path d="M19 19H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.7.7 0 0 1 2 21.286V5a2 2 0 0 1 1.184-1.826"></path><path d="m2 2 20 20"></path><path d="M8.656 3H20a2 2 0 0 1 2 2v11.344"></path>',
		'message-square-plus'                => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="M12 8v6"></path><path d="M9 11h6"></path>',
		'message-square-quote'               => '<path d="M14 14a2 2 0 0 0 2-2V8h-2"></path><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="M8 14a2 2 0 0 0 2-2V8H8"></path>',
		'message-square-reply'               => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="m10 8-3 3 3 3"></path><path d="M17 14v-1a2 2 0 0 0-2-2H7"></path>',
		'message-square-share'               => '<path d="M12 3H4a2 2 0 0 0-2 2v16.286a.71.71 0 0 0 1.212.502l2.202-2.202A2 2 0 0 1 6.828 19H20a2 2 0 0 0 2-2v-4"></path><path d="M16 3h6v6"></path><path d="m16 9 6-6"></path>',
		'message-square-text'                => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="M7 11h10"></path><path d="M7 15h6"></path><path d="M7 7h8"></path>',
		'message-square-warning'             => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="M12 15h.01"></path><path d="M12 7v4"></path>',
		'message-square-x'                   => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="m14.5 8.5-5 5"></path><path d="m9.5 8.5 5 5"></path>',
		'message-square'                     => '<path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path>',
		'messages-square'                    => '<path d="M16 10a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 14.286V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path><path d="M20 9a2 2 0 0 1 2 2v10.286a.71.71 0 0 1-1.212.502l-2.202-2.202A2 2 0 0 0 17.172 19H10a2 2 0 0 1-2-2v-1"></path>',
		'mic-off'                            => '<path d="M12 19v3"></path><path d="M15 9.34V5a3 3 0 0 0-5.68-1.33"></path><path d="M16.95 16.95A7 7 0 0 1 5 12v-2"></path><path d="M18.89 13.23A7 7 0 0 0 19 12v-2"></path><path d="m2 2 20 20"></path><path d="M9 9v3a3 3 0 0 0 5.12 2.12"></path>',
		'mic-vocal'                          => '<path d="m11 7.601-5.994 8.19a1 1 0 0 0 .1 1.298l.817.818a1 1 0 0 0 1.314.087L15.09 12"></path><path d="M16.5 21.174C15.5 20.5 14.372 20 13 20c-2.058 0-3.928 2.356-6 2-2.072-.356-2.775-3.369-1.5-4.5"></path><circle cx="16" cy="7" r="5"></circle>',
		'mic'                                => '<path d="M12 19v3"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><rect x="9" y="2" width="6" height="13" rx="3"></rect>',
		'microchip'                          => '<path d="M10 12h4"></path><path d="M10 17h4"></path><path d="M10 7h4"></path><path d="M18 12h2"></path><path d="M18 18h2"></path><path d="M18 6h2"></path><path d="M4 12h2"></path><path d="M4 18h2"></path><path d="M4 6h2"></path><rect x="6" y="2" width="12" height="20" rx="2"></rect>',
		'microscope'                         => '<path d="M6 18h8"></path><path d="M3 22h18"></path><path d="M14 22a7 7 0 1 0 0-14h-1"></path><path d="M9 14h2"></path><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"></path><path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"></path>',
		'microwave'                          => '<rect width="20" height="15" x="2" y="4" rx="2"></rect><rect width="8" height="7" x="6" y="8" rx="1"></rect><path d="M18 8v7"></path><path d="M6 19v2"></path><path d="M18 19v2"></path>',
		'milestone'                          => '<path d="M12 13v8"></path><path d="M12 3v3"></path><path d="M4 6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h13a2 2 0 0 0 1.152-.365l3.424-2.317a1 1 0 0 0 0-1.635l-3.424-2.318A2 2 0 0 0 17 6z"></path>',
		'milk-off'                           => '<path d="M8 2h8"></path><path d="M9 2v1.343M15 2v2.789a4 4 0 0 0 .672 2.219l.656.984a4 4 0 0 1 .672 2.22v1.131M7.8 7.8l-.128.192A4 4 0 0 0 7 10.212V20a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-3"></path><path d="M7 15a6.47 6.47 0 0 1 5 0 6.472 6.472 0 0 0 3.435.435"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'milk'                               => '<path d="M8 2h8"></path><path d="M9 2v2.789a4 4 0 0 1-.672 2.219l-.656.984A4 4 0 0 0 7 10.212V20a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-9.789a4 4 0 0 0-.672-2.219l-.656-.984A4 4 0 0 1 15 4.788V2"></path><path d="M7 15a6.472 6.472 0 0 1 5 0 6.47 6.47 0 0 0 5 0"></path>',
		'minimize-2'                         => '<path d="m14 10 7-7"></path><path d="M20 10h-6V4"></path><path d="m3 21 7-7"></path><path d="M4 14h6v6"></path>',
		'minimize'                           => '<path d="M8 3v3a2 2 0 0 1-2 2H3"></path><path d="M21 8h-3a2 2 0 0 1-2-2V3"></path><path d="M3 16h3a2 2 0 0 1 2 2v3"></path><path d="M16 21v-3a2 2 0 0 1 2-2h3"></path>',
		'minus'                              => '<path d="M5 12h14"></path>',
		'monitor-check'                      => '<path d="m9 10 2 2 4-4"></path><rect width="20" height="14" x="2" y="3" rx="2"></rect><path d="M12 17v4"></path><path d="M8 21h8"></path>',
		'monitor-cloud'                      => '<path d="M11 13a3 3 0 1 1 2.83-4H14a2 2 0 0 1 0 4z"></path><path d="M12 17v4"></path><path d="M8 21h8"></path><rect x="2" y="3" width="20" height="14" rx="2"></rect>',
		'monitor-cog'                        => '<path d="M12 17v4"></path><path d="m14.305 7.53.923-.382"></path><path d="m15.228 4.852-.923-.383"></path><path d="m16.852 3.228-.383-.924"></path><path d="m16.852 8.772-.383.923"></path><path d="m19.148 3.228.383-.924"></path><path d="m19.53 9.696-.382-.924"></path><path d="m20.772 4.852.924-.383"></path><path d="m20.772 7.148.924.383"></path><path d="M22 13v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path><path d="M8 21h8"></path><circle cx="18" cy="6" r="3"></circle>',
		'monitor-dot'                        => '<path d="M12 17v4"></path><path d="M22 12.307V15a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h8.693"></path><path d="M8 21h8"></path><circle cx="19" cy="6" r="3"></circle>',
		'monitor-down'                       => '<path d="M12 13V7"></path><path d="m15 10-3 3-3-3"></path><rect width="20" height="14" x="2" y="3" rx="2"></rect><path d="M12 17v4"></path><path d="M8 21h8"></path>',
		'monitor-off'                        => '<path d="M12 17v4"></path><path d="M17 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 1.184-1.826"></path><path d="m2 2 20 20"></path><path d="M8 21h8"></path><path d="M8.656 3H20a2 2 0 0 1 2 2v10a2 2 0 0 1-.293 1.042"></path>',
		'monitor-pause'                      => '<path d="M10 13V7"></path><path d="M14 13V7"></path><rect width="20" height="14" x="2" y="3" rx="2"></rect><path d="M12 17v4"></path><path d="M8 21h8"></path>',
		'monitor-play'                       => '<path d="M15.033 9.44a.647.647 0 0 1 0 1.12l-4.065 2.352a.645.645 0 0 1-.968-.56V7.648a.645.645 0 0 1 .967-.56z"></path><path d="M12 17v4"></path><path d="M8 21h8"></path><rect x="2" y="3" width="20" height="14" rx="2"></rect>',
		'monitor-smartphone'                 => '<path d="M18 8V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8"></path><path d="M10 19v-3.96 3.15"></path><path d="M7 19h5"></path><rect width="6" height="10" x="16" y="12" rx="2"></rect>',
		'monitor-speaker'                    => '<path d="M5.5 20H8"></path><path d="M17 9h.01"></path><rect width="10" height="16" x="12" y="4" rx="2"></rect><path d="M8 6H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4"></path><circle cx="17" cy="15" r="1"></circle>',
		'monitor-stop'                       => '<path d="M12 17v4"></path><path d="M8 21h8"></path><rect x="2" y="3" width="20" height="14" rx="2"></rect><rect x="9" y="7" width="6" height="6" rx="1"></rect>',
		'monitor-up'                         => '<path d="m9 10 3-3 3 3"></path><path d="M12 13V7"></path><rect width="20" height="14" x="2" y="3" rx="2"></rect><path d="M12 17v4"></path><path d="M8 21h8"></path>',
		'monitor-x'                          => '<path d="m14.5 12.5-5-5"></path><path d="m9.5 12.5 5-5"></path><rect width="20" height="14" x="2" y="3" rx="2"></rect><path d="M12 17v4"></path><path d="M8 21h8"></path>',
		'monitor'                            => '<rect width="20" height="14" x="2" y="3" rx="2"></rect><line x1="8" x2="16" y1="21" y2="21"></line><line x1="12" x2="12" y1="17" y2="21"></line>',
		'moon-star'                          => '<path d="M18 5h4"></path><path d="M20 3v4"></path><path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"></path>',
		'moon'                               => '<path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"></path>',
		'motorbike'                          => '<path d="m18 14-1-3"></path><path d="m3 9 6 2a2 2 0 0 1 2-2h2a2 2 0 0 1 1.99 1.81"></path><path d="M8 17h3a1 1 0 0 0 1-1 6 6 0 0 1 6-6 1 1 0 0 0 1-1v-.75A5 5 0 0 0 17 5"></path><circle cx="19" cy="17" r="3"></circle><circle cx="5" cy="17" r="3"></circle>',
		'mountain-snow'                      => '<path d="m8 3 4 8 5-5 5 15H2L8 3z"></path><path d="M4.14 15.08c2.62-1.57 5.24-1.43 7.86.42 2.74 1.94 5.49 2 8.23.19"></path>',
		'mountain'                           => '<path d="m8 3 4 8 5-5 5 15H2L8 3z"></path>',
		'mouse-off'                          => '<path d="M12 6v.343"></path><path d="M18.218 18.218A7 7 0 0 1 5 15V9a7 7 0 0 1 .782-3.218"></path><path d="M19 13.343V9A7 7 0 0 0 8.56 2.902"></path><path d="M22 22 2 2"></path>',
		'mouse-pointer-2-off'                => '<path d="m15.55 8.45 5.138 2.087a.5.5 0 0 1-.063.947l-6.124 1.58a2 2 0 0 0-1.438 1.435l-1.579 6.126a.5.5 0 0 1-.947.063L8.45 15.551"></path><path d="M22 2 2 22"></path><path d="m6.816 11.528-2.779-6.84a.495.495 0 0 1 .651-.651l6.84 2.779"></path>',
		'mouse-pointer-2'                    => '<path d="M4.037 4.688a.495.495 0 0 1 .651-.651l16 6.5a.5.5 0 0 1-.063.947l-6.124 1.58a2 2 0 0 0-1.438 1.435l-1.579 6.126a.5.5 0 0 1-.947.063z"></path>',
		'mouse-pointer-ban'                  => '<path d="M2.034 2.681a.498.498 0 0 1 .647-.647l9 3.5a.5.5 0 0 1-.033.944L8.204 7.545a1 1 0 0 0-.66.66l-1.066 3.443a.5.5 0 0 1-.944.033z"></path><circle cx="16" cy="16" r="6"></circle><path d="m11.8 11.8 8.4 8.4"></path>',
		'mouse-pointer-click'                => '<path d="M14 4.1 12 6"></path><path d="m5.1 8-2.9-.8"></path><path d="m6 12-1.9 2"></path><path d="M7.2 2.2 8 5.1"></path><path d="M9.037 9.69a.498.498 0 0 1 .653-.653l11 4.5a.5.5 0 0 1-.074.949l-4.349 1.041a1 1 0 0 0-.74.739l-1.04 4.35a.5.5 0 0 1-.95.074z"></path>',
		'mouse-pointer'                      => '<path d="M12.586 12.586 19 19"></path><path d="M3.688 3.037a.497.497 0 0 0-.651.651l6.5 15.999a.501.501 0 0 0 .947-.062l1.569-6.083a2 2 0 0 1 1.448-1.479l6.124-1.579a.5.5 0 0 0 .063-.947z"></path>',
		'mouse'                              => '<rect x="5" y="2" width="14" height="20" rx="7"></rect><path d="M12 6v4"></path>',
		'move-3d'                            => '<path d="M5 3v16h16"></path><path d="m5 19 6-6"></path><path d="m2 6 3-3 3 3"></path><path d="m18 16 3 3-3 3"></path>',
		'move-diagonal-2'                    => '<path d="M19 13v6h-6"></path><path d="M5 11V5h6"></path><path d="m5 5 14 14"></path>',
		'move-diagonal'                      => '<path d="M11 19H5v-6"></path><path d="M13 5h6v6"></path><path d="M19 5 5 19"></path>',
		'move-down-left'                     => '<path d="M11 19H5V13"></path><path d="M19 5L5 19"></path>',
		'move-down-right'                    => '<path d="M19 13V19H13"></path><path d="M5 5L19 19"></path>',
		'move-down'                          => '<path d="M8 18L12 22L16 18"></path><path d="M12 2V22"></path>',
		'move-horizontal'                    => '<path d="m18 8 4 4-4 4"></path><path d="M2 12h20"></path><path d="m6 8-4 4 4 4"></path>',
		'move-left'                          => '<path d="M6 8L2 12L6 16"></path><path d="M2 12H22"></path>',
		'move-right'                         => '<path d="M18 8L22 12L18 16"></path><path d="M2 12H22"></path>',
		'move-up-left'                       => '<path d="M5 11V5H11"></path><path d="M5 5L19 19"></path>',
		'move-up-right'                      => '<path d="M13 5H19V11"></path><path d="M19 5L5 19"></path>',
		'move-up'                            => '<path d="M8 6L12 2L16 6"></path><path d="M12 2V22"></path>',
		'move-vertical'                      => '<path d="M12 2v20"></path><path d="m8 18 4 4 4-4"></path><path d="m8 6 4-4 4 4"></path>',
		'move'                               => '<path d="M12 2v20"></path><path d="m15 19-3 3-3-3"></path><path d="m19 9 3 3-3 3"></path><path d="M2 12h20"></path><path d="m5 9-3 3 3 3"></path><path d="m9 5 3-3 3 3"></path>',
		'music-2'                            => '<circle cx="8" cy="18" r="4"></circle><path d="M12 18V2l7 4"></path>',
		'music-3'                            => '<circle cx="12" cy="18" r="4"></circle><path d="M16 18V2"></path>',
		'music-4'                            => '<path d="M9 18V5l12-2v13"></path><path d="m9 9 12-2"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle>',
		'music'                              => '<path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle>',
		'navigation-2-off'                   => '<path d="M9.31 9.31 5 21l7-4 7 4-1.17-3.17"></path><path d="M14.53 8.88 12 2l-1.17 3.17"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'navigation-2'                       => '<polygon points="12 2 19 21 12 17 5 21 12 2"></polygon>',
		'navigation-off'                     => '<path d="M8.43 8.43 3 11l8 2 2 8 2.57-5.43"></path><path d="M17.39 11.73 22 2l-9.73 4.61"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'navigation'                         => '<polygon points="3 11 22 2 13 21 11 13 3 11"></polygon>',
		'network'                            => '<rect x="16" y="16" width="6" height="6" rx="1"></rect><rect x="2" y="16" width="6" height="6" rx="1"></rect><rect x="9" y="2" width="6" height="6" rx="1"></rect><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"></path><path d="M12 12V8"></path>',
		'newspaper'                          => '<path d="M15 18h-5"></path><path d="M18 14h-8"></path><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"></path><rect width="8" height="4" x="10" y="6" rx="1"></rect>',
		'nfc'                                => '<path d="M6 8.32a7.43 7.43 0 0 1 0 7.36"></path><path d="M9.46 6.21a11.76 11.76 0 0 1 0 11.58"></path><path d="M12.91 4.1a15.91 15.91 0 0 1 .01 15.8"></path><path d="M16.37 2a20.16 20.16 0 0 1 0 20"></path>',
		'non-binary'                         => '<path d="M12 2v10"></path><path d="m8.5 4 7 4"></path><path d="m8.5 8 7-4"></path><circle cx="12" cy="17" r="5"></circle>',
		'notebook-pen'                       => '<path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4"></path><path d="M2 6h4"></path><path d="M2 10h4"></path><path d="M2 14h4"></path><path d="M2 18h4"></path><path d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path>',
		'notebook-tabs'                      => '<path d="M2 6h4"></path><path d="M2 10h4"></path><path d="M2 14h4"></path><path d="M2 18h4"></path><rect width="16" height="20" x="4" y="2" rx="2"></rect><path d="M15 2v20"></path><path d="M15 7h5"></path><path d="M15 12h5"></path><path d="M15 17h5"></path>',
		'notebook-text'                      => '<path d="M2 6h4"></path><path d="M2 10h4"></path><path d="M2 14h4"></path><path d="M2 18h4"></path><rect width="16" height="20" x="4" y="2" rx="2"></rect><path d="M9.5 8h5"></path><path d="M9.5 12H16"></path><path d="M9.5 16H14"></path>',
		'notebook'                           => '<path d="M2 6h4"></path><path d="M2 10h4"></path><path d="M2 14h4"></path><path d="M2 18h4"></path><rect width="16" height="20" x="4" y="2" rx="2"></rect><path d="M16 2v20"></path>',
		'notepad-text-dashed'                => '<path d="M8 2v4"></path><path d="M12 2v4"></path><path d="M16 2v4"></path><path d="M16 4h2a2 2 0 0 1 2 2v2"></path><path d="M20 12v2"></path><path d="M20 18v2a2 2 0 0 1-2 2h-1"></path><path d="M13 22h-2"></path><path d="M7 22H6a2 2 0 0 1-2-2v-2"></path><path d="M4 14v-2"></path><path d="M4 8V6a2 2 0 0 1 2-2h2"></path><path d="M8 10h6"></path><path d="M8 14h8"></path><path d="M8 18h5"></path>',
		'notepad-text'                       => '<path d="M8 2v4"></path><path d="M12 2v4"></path><path d="M16 2v4"></path><rect width="16" height="18" x="4" y="4" rx="2"></rect><path d="M8 10h6"></path><path d="M8 14h8"></path><path d="M8 18h5"></path>',
		'nut-off'                            => '<path d="M12 4V2"></path><path d="M5 10v4a7.004 7.004 0 0 0 5.277 6.787c.412.104.802.292 1.102.592L12 22l.621-.621c.3-.3.69-.488 1.102-.592a7.01 7.01 0 0 0 4.125-2.939"></path><path d="M19 10v3.343"></path><path d="M12 12c-1.349-.573-1.905-1.005-2.5-2-.546.902-1.048 1.353-2.5 2-1.018-.644-1.46-1.08-2-2-1.028.71-1.69.918-3 1 1.081-1.048 1.757-2.03 2-3 .194-.776.84-1.551 1.79-2.21m11.654 5.997c.887-.457 1.28-.891 1.556-1.787 1.032.916 1.683 1.157 3 1-1.297-1.036-1.758-2.03-2-3-.5-2-4-4-8-4-.74 0-1.461.068-2.15.192"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'nut'                                => '<path d="M12 4V2"></path><path d="M5 10v4a7.004 7.004 0 0 0 5.277 6.787c.412.104.802.292 1.102.592L12 22l.621-.621c.3-.3.69-.488 1.102-.592A7.003 7.003 0 0 0 19 14v-4"></path><path d="M12 4C8 4 4.5 6 4 8c-.243.97-.919 1.952-2 3 1.31-.082 1.972-.29 3-1 .54.92.982 1.356 2 2 1.452-.647 1.954-1.098 2.5-2 .595.995 1.151 1.427 2.5 2 1.31-.621 1.862-1.058 2.5-2 .629.977 1.162 1.423 2.5 2 1.209-.548 1.68-.967 2-2 1.032.916 1.683 1.157 3 1-1.297-1.036-1.758-2.03-2-3-.5-2-4-4-8-4Z"></path>',
		'octagon-alert'                      => '<path d="M12 16h.01"></path><path d="M12 8v4"></path><path d="M15.312 2a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586l-4.688-4.688A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2z"></path>',
		'octagon-minus'                      => '<path d="M2.586 16.726A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2h6.624a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586z"></path><path d="M8 12h8"></path>',
		'octagon-pause'                      => '<path d="M10 15V9"></path><path d="M14 15V9"></path><path d="M2.586 16.726A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2h6.624a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586z"></path>',
		'octagon-x'                          => '<path d="m15 9-6 6"></path><path d="M2.586 16.726A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2h6.624a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586z"></path><path d="m9 9 6 6"></path>',
		'octagon'                            => '<path d="M2.586 16.726A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2h6.624a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586z"></path>',
		'omega'                              => '<path d="M3 20h4.5a.5.5 0 0 0 .5-.5v-.282a.52.52 0 0 0-.247-.437 8 8 0 1 1 8.494-.001.52.52 0 0 0-.247.438v.282a.5.5 0 0 0 .5.5H21"></path>',
		'option'                             => '<path d="M3 3h6l6 18h6"></path><path d="M14 3h7"></path>',
		'orbit'                              => '<path d="M20.341 6.484A10 10 0 0 1 10.266 21.85"></path><path d="M3.659 17.516A10 10 0 0 1 13.74 2.152"></path><circle cx="12" cy="12" r="3"></circle><circle cx="19" cy="5" r="2"></circle><circle cx="5" cy="19" r="2"></circle>',
		'origami'                            => '<path d="M12 12V4a1 1 0 0 1 1-1h6.297a1 1 0 0 1 .651 1.759l-4.696 4.025"></path><path d="m12 21-7.414-7.414A2 2 0 0 1 4 12.172V6.415a1.002 1.002 0 0 1 1.707-.707L20 20.009"></path><path d="m12.214 3.381 8.414 14.966a1 1 0 0 1-.167 1.199l-1.168 1.163a1 1 0 0 1-.706.291H6.351a1 1 0 0 1-.625-.219L3.25 18.8a1 1 0 0 1 .631-1.781l4.165.027"></path>',
		'package-2'                          => '<path d="M12 3v6"></path><path d="M16.76 3a2 2 0 0 1 1.8 1.1l2.23 4.479a2 2 0 0 1 .21.891V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.472a2 2 0 0 1 .211-.894L5.45 4.1A2 2 0 0 1 7.24 3z"></path><path d="M3.054 9.013h17.893"></path>',
		'package-check'                      => '<path d="m16 16 2 2 4-4"></path><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"></path><path d="m7.5 4.27 9 5.15"></path><polyline points="3.29 7 12 12 20.71 7"></polyline><line x1="12" x2="12" y1="22" y2="12"></line>',
		'package-minus'                      => '<path d="M16 16h6"></path><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"></path><path d="m7.5 4.27 9 5.15"></path><polyline points="3.29 7 12 12 20.71 7"></polyline><line x1="12" x2="12" y1="22" y2="12"></line>',
		'package-open'                       => '<path d="M12 22v-9"></path><path d="M15.17 2.21a1.67 1.67 0 0 1 1.63 0L21 4.57a1.93 1.93 0 0 1 0 3.36L8.82 14.79a1.655 1.655 0 0 1-1.64 0L3 12.43a1.93 1.93 0 0 1 0-3.36z"></path><path d="M20 13v3.87a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13"></path><path d="M21 12.43a1.93 1.93 0 0 0 0-3.36L8.83 2.2a1.64 1.64 0 0 0-1.63 0L3 4.57a1.93 1.93 0 0 0 0 3.36l12.18 6.86a1.636 1.636 0 0 0 1.63 0z"></path>',
		'package-plus'                       => '<path d="M16 16h6"></path><path d="M19 13v6"></path><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"></path><path d="m7.5 4.27 9 5.15"></path><polyline points="3.29 7 12 12 20.71 7"></polyline><line x1="12" x2="12" y1="22" y2="12"></line>',
		'package-search'                     => '<path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"></path><path d="m7.5 4.27 9 5.15"></path><polyline points="3.29 7 12 12 20.71 7"></polyline><line x1="12" x2="12" y1="22" y2="12"></line><circle cx="18.5" cy="15.5" r="2.5"></circle><path d="M20.27 17.27 22 19"></path>',
		'package-x'                          => '<path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"></path><path d="m7.5 4.27 9 5.15"></path><polyline points="3.29 7 12 12 20.71 7"></polyline><line x1="12" x2="12" y1="22" y2="12"></line><path d="m17 13 5 5m-5 0 5-5"></path>',
		'package'                            => '<path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path><path d="M12 22V12"></path><polyline points="3.29 7 12 12 20.71 7"></polyline><path d="m7.5 4.27 9 5.15"></path>',
		'paint-bucket'                       => '<path d="M11 7 6 2"></path><path d="M18.992 12H2.041"></path><path d="M21.145 18.38A3.34 3.34 0 0 1 20 16.5a3.3 3.3 0 0 1-1.145 1.88c-.575.46-.855 1.02-.855 1.595A2 2 0 0 0 20 22a2 2 0 0 0 2-2.025c0-.58-.285-1.13-.855-1.595"></path><path d="m8.5 4.5 2.148-2.148a1.205 1.205 0 0 1 1.704 0l7.296 7.296a1.205 1.205 0 0 1 0 1.704l-7.592 7.592a3.615 3.615 0 0 1-5.112 0l-3.888-3.888a3.615 3.615 0 0 1 0-5.112L5.67 7.33"></path>',
		'paint-roller'                       => '<rect width="16" height="6" x="2" y="2" rx="2"></rect><path d="M10 16v-2a2 2 0 0 1 2-2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect width="4" height="6" x="8" y="16" rx="1"></rect>',
		'paintbrush-vertical'                => '<path d="M10 2v2"></path><path d="M14 2v4"></path><path d="M17 2a1 1 0 0 1 1 1v9H6V3a1 1 0 0 1 1-1z"></path><path d="M6 12a1 1 0 0 0-1 1v1a2 2 0 0 0 2 2h2a1 1 0 0 1 1 1v2.9a2 2 0 1 0 4 0V17a1 1 0 0 1 1-1h2a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1"></path>',
		'paintbrush'                         => '<path d="m14.622 17.897-10.68-2.913"></path><path d="M18.376 2.622a1 1 0 1 1 3.002 3.002L17.36 9.643a.5.5 0 0 0 0 .707l.944.944a2.41 2.41 0 0 1 0 3.408l-.944.944a.5.5 0 0 1-.707 0L8.354 7.348a.5.5 0 0 1 0-.707l.944-.944a2.41 2.41 0 0 1 3.408 0l.944.944a.5.5 0 0 0 .707 0z"></path><path d="M9 8c-1.804 2.71-3.97 3.46-6.583 3.948a.507.507 0 0 0-.302.819l7.32 8.883a1 1 0 0 0 1.185.204C12.735 20.405 16 16.792 16 15"></path>',
		'palette'                            => '<path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z"></path><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>',
		'panda'                              => '<path d="M11.25 17.25h1.5L12 18z"></path><path d="m15 12 2 2"></path><path d="M18 6.5a.5.5 0 0 0-.5-.5"></path><path d="M20.69 9.67a4.5 4.5 0 1 0-7.04-5.5 8.35 8.35 0 0 0-3.3 0 4.5 4.5 0 1 0-7.04 5.5C2.49 11.2 2 12.88 2 14.5 2 19.47 6.48 22 12 22s10-2.53 10-7.5c0-1.62-.48-3.3-1.3-4.83"></path><path d="M6 6.5a.495.495 0 0 1 .5-.5"></path><path d="m9 12-2 2"></path>',
		'panel-bottom-close'                 => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 15h18"></path><path d="m15 8-3 3-3-3"></path>',
		'panel-bottom-dashed'                => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M14 15h1"></path><path d="M19 15h2"></path><path d="M3 15h2"></path><path d="M9 15h1"></path>',
		'panel-bottom-open'                  => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 15h18"></path><path d="m9 10 3-3 3 3"></path>',
		'panel-bottom'                       => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 15h18"></path>',
		'panel-left-close'                   => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 3v18"></path><path d="m16 15-3-3 3-3"></path>',
		'panel-left-dashed'                  => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 14v1"></path><path d="M9 19v2"></path><path d="M9 3v2"></path><path d="M9 9v1"></path>',
		'panel-left-open'                    => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 3v18"></path><path d="m14 9 3 3-3 3"></path>',
		'panel-left-right-dashed'            => '<path d="M15 10V9"></path><path d="M15 15v-1"></path><path d="M15 21v-2"></path><path d="M15 5V3"></path><path d="M9 10V9"></path><path d="M9 15v-1"></path><path d="M9 21v-2"></path><path d="M9 5V3"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'panel-left'                         => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 3v18"></path>',
		'panel-right-close'                  => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M15 3v18"></path><path d="m8 9 3 3-3 3"></path>',
		'panel-right-dashed'                 => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M15 14v1"></path><path d="M15 19v2"></path><path d="M15 3v2"></path><path d="M15 9v1"></path>',
		'panel-right-open'                   => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M15 3v18"></path><path d="m10 15-3-3 3-3"></path>',
		'panel-right'                        => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M15 3v18"></path>',
		'panel-top-bottom-dashed'            => '<path d="M14 15h1"></path><path d="M14 9h1"></path><path d="M19 15h2"></path><path d="M19 9h2"></path><path d="M3 15h2"></path><path d="M3 9h2"></path><path d="M9 15h1"></path><path d="M9 9h1"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'panel-top-close'                    => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="m9 16 3-3 3 3"></path>',
		'panel-top-dashed'                   => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M14 9h1"></path><path d="M19 9h2"></path><path d="M3 9h2"></path><path d="M9 9h1"></path>',
		'panel-top-open'                     => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="m15 14-3 3-3-3"></path>',
		'panel-top'                          => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path>',
		'panels-left-bottom'                 => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 3v18"></path><path d="M9 15h12"></path>',
		'panels-right-bottom'                => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 15h12"></path><path d="M15 3v18"></path>',
		'panels-top-left'                    => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M9 21V9"></path>',
		'paperclip'                          => '<path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551"></path>',
		'parentheses'                        => '<path d="M8 21s-4-3-4-9 4-9 4-9"></path><path d="M16 3s4 3 4 9-4 9-4 9"></path>',
		'parking-meter'                      => '<path d="M11 15h2"></path><path d="M12 12v3"></path><path d="M12 19v3"></path><path d="M15.282 19a1 1 0 0 0 .948-.68l2.37-6.988a7 7 0 1 0-13.2 0l2.37 6.988a1 1 0 0 0 .948.68z"></path><path d="M9 9a3 3 0 1 1 6 0"></path>',
		'party-popper'                       => '<path d="M5.8 11.3 2 22l10.7-3.79"></path><path d="M4 3h.01"></path><path d="M22 8h.01"></path><path d="M15 2h.01"></path><path d="M22 20h.01"></path><path d="m22 2-2.24.75a2.9 2.9 0 0 0-1.96 3.12c.1.86-.57 1.63-1.45 1.63h-.38c-.86 0-1.6.6-1.76 1.44L14 10"></path><path d="m22 13-.82-.33c-.86-.34-1.82.2-1.98 1.11c-.11.7-.72 1.22-1.43 1.22H17"></path><path d="m11 2 .33.82c.34.86-.2 1.82-1.11 1.98C9.52 4.9 9 5.52 9 6.23V7"></path><path d="M11 13c1.93 1.93 2.83 4.17 2 5-.83.83-3.07-.07-5-2-1.93-1.93-2.83-4.17-2-5 .83-.83 3.07.07 5 2Z"></path>',
		'pause'                              => '<rect x="14" y="3" width="5" height="18" rx="1"></rect><rect x="5" y="3" width="5" height="18" rx="1"></rect>',
		'paw-print'                          => '<circle cx="11" cy="4" r="2"></circle><circle cx="18" cy="8" r="2"></circle><circle cx="20" cy="16" r="2"></circle><path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"></path>',
		'pc-case'                            => '<rect width="14" height="20" x="5" y="2" rx="2"></rect><path d="M15 14h.01"></path><path d="M9 6h6"></path><path d="M9 10h6"></path>',
		'pen-line'                           => '<path d="M13 21h8"></path><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>',
		'pen-off'                            => '<path d="m10 10-6.157 6.162a2 2 0 0 0-.5.833l-1.322 4.36a.5.5 0 0 0 .622.624l4.358-1.323a2 2 0 0 0 .83-.5L14 13.982"></path><path d="m12.829 7.172 4.359-4.346a1 1 0 1 1 3.986 3.986l-4.353 4.353"></path><path d="m2 2 20 20"></path>',
		'pen-tool'                           => '<path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"></path><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"></path><path d="m2.3 2.3 7.286 7.286"></path><circle cx="11" cy="11" r="2"></circle>',
		'pen'                                => '<path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>',
		'pencil-line'                        => '<path d="M13 21h8"></path><path d="m15 5 4 4"></path><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>',
		'pencil-off'                         => '<path d="m10 10-6.157 6.162a2 2 0 0 0-.5.833l-1.322 4.36a.5.5 0 0 0 .622.624l4.358-1.323a2 2 0 0 0 .83-.5L14 13.982"></path><path d="m12.829 7.172 4.359-4.346a1 1 0 1 1 3.986 3.986l-4.353 4.353"></path><path d="m15 5 4 4"></path><path d="m2 2 20 20"></path>',
		'pencil-ruler'                       => '<path d="M13 7 8.7 2.7a2.41 2.41 0 0 0-3.4 0L2.7 5.3a2.41 2.41 0 0 0 0 3.4L7 13"></path><path d="m8 6 2-2"></path><path d="m18 16 2-2"></path><path d="m17 11 4.3 4.3c.94.94.94 2.46 0 3.4l-2.6 2.6c-.94.94-2.46.94-3.4 0L11 17"></path><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path><path d="m15 5 4 4"></path>',
		'pencil'                             => '<path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path><path d="m15 5 4 4"></path>',
		'pentagon'                           => '<path d="M10.83 2.38a2 2 0 0 1 2.34 0l8 5.74a2 2 0 0 1 .73 2.25l-3.04 9.26a2 2 0 0 1-1.9 1.37H7.04a2 2 0 0 1-1.9-1.37L2.1 10.37a2 2 0 0 1 .73-2.25z"></path>',
		'percent'                            => '<line x1="19" x2="5" y1="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle>',
		'person-standing'                    => '<circle cx="12" cy="5" r="1"></circle><path d="m9 20 3-6 3 6"></path><path d="m6 8 6 2 6-2"></path><path d="M12 10v4"></path>',
		'philippine-peso'                    => '<path d="M20 11H4"></path><path d="M20 7H4"></path><path d="M7 21V4a1 1 0 0 1 1-1h4a1 1 0 0 1 0 12H7"></path>',
		'phone-call'                         => '<path d="M13 2a9 9 0 0 1 9 9"></path><path d="M13 6a5 5 0 0 1 5 5"></path><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>',
		'phone-forwarded'                    => '<path d="M14 6h8"></path><path d="m18 2 4 4-4 4"></path><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>',
		'phone-incoming'                     => '<path d="M16 2v6h6"></path><path d="m22 2-6 6"></path><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>',
		'phone-missed'                       => '<path d="m16 2 6 6"></path><path d="m22 2-6 6"></path><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>',
		'phone-off'                          => '<path d="M10.1 13.9a14 14 0 0 0 3.732 2.668 1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2 18 18 0 0 1-12.728-5.272"></path><path d="M22 2 2 22"></path><path d="M4.76 13.582A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 .244.473"></path>',
		'phone-outgoing'                     => '<path d="m16 8 6-6"></path><path d="M22 8V2h-6"></path><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>',
		'phone'                              => '<path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>',
		'pi'                                 => '<line x1="9" x2="9" y1="4" y2="20"></line><path d="M4 7c0-1.7 1.3-3 3-3h13"></path><path d="M18 20c-1.7 0-3-1.3-3-3V4"></path>',
		'piano'                              => '<path d="M18.5 8c-1.4 0-2.6-.8-3.2-2A6.87 6.87 0 0 0 2 9v11a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-8.5C22 9.6 20.4 8 18.5 8"></path><path d="M2 14h20"></path><path d="M6 14v4"></path><path d="M10 14v4"></path><path d="M14 14v4"></path><path d="M18 14v4"></path>',
		'pickaxe'                            => '<path d="m14 13-8.381 8.38a1 1 0 0 1-3.001-3L11 9.999"></path><path d="M15.973 4.027A13 13 0 0 0 5.902 2.373c-1.398.342-1.092 2.158.277 2.601a19.9 19.9 0 0 1 5.822 3.024"></path><path d="M16.001 11.999a19.9 19.9 0 0 1 3.024 5.824c.444 1.369 2.26 1.676 2.603.278A13 13 0 0 0 20 8.069"></path><path d="M18.352 3.352a1.205 1.205 0 0 0-1.704 0l-5.296 5.296a1.205 1.205 0 0 0 0 1.704l2.296 2.296a1.205 1.205 0 0 0 1.704 0l5.296-5.296a1.205 1.205 0 0 0 0-1.704z"></path>',
		'picture-in-picture-2'               => '<path d="M21 9V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h4"></path><rect width="10" height="7" x="12" y="13" rx="2"></rect>',
		'picture-in-picture'                 => '<path d="M2 10h6V4"></path><path d="m2 4 6 6"></path><path d="M21 10V7a2 2 0 0 0-2-2h-7"></path><path d="M3 14v2a2 2 0 0 0 2 2h3"></path><rect x="12" y="14" width="10" height="7" rx="1"></rect>',
		'piggy-bank'                         => '<path d="M11 17h3v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a3.16 3.16 0 0 0 2-2h1a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-1a5 5 0 0 0-2-4V3a4 4 0 0 0-3.2 1.6l-.3.4H11a6 6 0 0 0-6 6v1a5 5 0 0 0 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1z"></path><path d="M16 10h.01"></path><path d="M2 8v1a2 2 0 0 0 2 2h1"></path>',
		'pilcrow-left'                       => '<path d="M14 3v11"></path><path d="M14 9h-3a3 3 0 0 1 0-6h9"></path><path d="M18 3v11"></path><path d="M22 18H2l4-4"></path><path d="m6 22-4-4"></path>',
		'pilcrow-right'                      => '<path d="M10 3v11"></path><path d="M10 9H7a1 1 0 0 1 0-6h8"></path><path d="M14 3v11"></path><path d="m18 14 4 4H2"></path><path d="m22 18-4 4"></path>',
		'pilcrow'                            => '<path d="M13 4v16"></path><path d="M17 4v16"></path><path d="M19 4H9.5a4.5 4.5 0 0 0 0 9H13"></path>',
		'pill-bottle'                        => '<path d="M18 11h-4a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h4"></path><path d="M6 7v13a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7"></path><rect width="16" height="5" x="4" y="2" rx="1"></rect>',
		'pill'                               => '<path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path><path d="m8.5 8.5 7 7"></path>',
		'pin-off'                            => '<path d="M12 17v5"></path><path d="M15 9.34V7a1 1 0 0 1 1-1 2 2 0 0 0 0-4H7.89"></path><path d="m2 2 20 20"></path><path d="M9 9v1.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24V16a1 1 0 0 0 1 1h11"></path>',
		'pin'                                => '<path d="M12 17v5"></path><path d="M9 10.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24V16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V7a1 1 0 0 1 1-1 2 2 0 0 0 0-4H8a2 2 0 0 0 0 4 1 1 0 0 1 1 1z"></path>',
		'pipette'                            => '<path d="m12 9-8.414 8.414A2 2 0 0 0 3 18.828v1.344a2 2 0 0 1-.586 1.414A2 2 0 0 1 3.828 21h1.344a2 2 0 0 0 1.414-.586L15 12"></path><path d="m18 9 .4.4a1 1 0 1 1-3 3l-3.8-3.8a1 1 0 1 1 3-3l.4.4 3.4-3.4a1 1 0 1 1 3 3z"></path><path d="m2 22 .414-.414"></path>',
		'pizza'                              => '<path d="m12 14-1 1"></path><path d="m13.75 18.25-1.25 1.42"></path><path d="M17.775 5.654a15.68 15.68 0 0 0-12.121 12.12"></path><path d="M18.8 9.3a1 1 0 0 0 2.1 7.7"></path><path d="M21.964 20.732a1 1 0 0 1-1.232 1.232l-18-5a1 1 0 0 1-.695-1.232A19.68 19.68 0 0 1 15.732 2.037a1 1 0 0 1 1.232.695z"></path>',
		'plane-landing'                      => '<path d="M2 22h20"></path><path d="M3.77 10.77 2 9l2-4.5 1.1.55c.55.28.9.84.9 1.45s.35 1.17.9 1.45L8 8.5l3-6 1.05.53a2 2 0 0 1 1.09 1.52l.72 5.4a2 2 0 0 0 1.09 1.52l4.4 2.2c.42.22.78.55 1.01.96l.6 1.03c.49.88-.06 1.98-1.06 2.1l-1.18.15c-.47.06-.95-.02-1.37-.24L4.29 11.15a2 2 0 0 1-.52-.38Z"></path>',
		'plane-takeoff'                      => '<path d="M2 22h20"></path><path d="M6.36 17.4 4 17l-2-4 1.1-.55a2 2 0 0 1 1.8 0l.17.1a2 2 0 0 0 1.8 0L8 12 5 6l.9-.45a2 2 0 0 1 2.09.2l4.02 3a2 2 0 0 0 2.1.2l4.19-2.06a2.41 2.41 0 0 1 1.73-.17L21 7a1.4 1.4 0 0 1 .87 1.99l-.38.76c-.23.46-.6.84-1.07 1.08L7.58 17.2a2 2 0 0 1-1.22.18Z"></path>',
		'plane'                              => '<path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"></path>',
		'play'                               => '<path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>',
		'plug-2'                             => '<path d="M9 2v6"></path><path d="M15 2v6"></path><path d="M12 17v5"></path><path d="M5 8h14"></path><path d="M6 11V8h12v3a6 6 0 1 1-12 0Z"></path>',
		'plug-zap'                           => '<path d="M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z"></path><path d="m2 22 3-3"></path><path d="M7.5 13.5 10 11"></path><path d="M10.5 16.5 13 14"></path><path d="m18 3-4 4h6l-4 4"></path>',
		'plug'                               => '<path d="M12 22v-5"></path><path d="M15 8V2"></path><path d="M17 8a1 1 0 0 1 1 1v4a4 4 0 0 1-4 4h-4a4 4 0 0 1-4-4V9a1 1 0 0 1 1-1z"></path><path d="M9 8V2"></path>',
		'plus'                               => '<path d="M5 12h14"></path><path d="M12 5v14"></path>',
		'pocket-knife'                       => '<path d="M3 2v1c0 1 2 1 2 2S3 6 3 7s2 1 2 2-2 1-2 2 2 1 2 2"></path><path d="M18 6h.01"></path><path d="M6 18h.01"></path><path d="M20.83 8.83a4 4 0 0 0-5.66-5.66l-12 12a4 4 0 1 0 5.66 5.66Z"></path><path d="M18 11.66V22a4 4 0 0 0 4-4V6"></path>',
		'pocket'                             => '<path d="M20 3a2 2 0 0 1 2 2v6a1 1 0 0 1-20 0V5a2 2 0 0 1 2-2z"></path><path d="m8 10 4 4 4-4"></path>',
		'podcast'                            => '<path d="M13 17a1 1 0 1 0-2 0l.5 4.5a0.5 0.5 0 0 0 1 0z" fill="currentColor"></path><path d="M16.85 18.58a9 9 0 1 0-9.7 0"></path><path d="M8 14a5 5 0 1 1 8 0"></path><circle cx="12" cy="11" r="1" fill="currentColor"></circle>',
		'pointer-off'                        => '<path d="M10 4.5V4a2 2 0 0 0-2.41-1.957"></path><path d="M13.9 8.4a2 2 0 0 0-1.26-1.295"></path><path d="M21.7 16.2A8 8 0 0 0 22 14v-3a2 2 0 1 0-4 0v-1a2 2 0 0 0-3.63-1.158"></path><path d="m7 15-1.8-1.8a2 2 0 0 0-2.79 2.86L6 19.7a7.74 7.74 0 0 0 6 2.3h2a8 8 0 0 0 5.657-2.343"></path><path d="M6 6v8"></path><path d="m2 2 20 20"></path>',
		'pointer'                            => '<path d="M22 14a8 8 0 0 1-8 8"></path><path d="M18 11v-1a2 2 0 0 0-2-2a2 2 0 0 0-2 2"></path><path d="M14 10V9a2 2 0 0 0-2-2a2 2 0 0 0-2 2v1"></path><path d="M10 9.5V4a2 2 0 0 0-2-2a2 2 0 0 0-2 2v10"></path><path d="M18 11a2 2 0 1 1 4 0v3a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"></path>',
		'popcorn'                            => '<path d="M18 8a2 2 0 0 0 0-4 2 2 0 0 0-4 0 2 2 0 0 0-4 0 2 2 0 0 0-4 0 2 2 0 0 0 0 4"></path><path d="M10 22 9 8"></path><path d="m14 22 1-14"></path><path d="M20 8c.5 0 .9.4.8 1l-2.6 12c-.1.5-.7 1-1.2 1H7c-.6 0-1.1-.4-1.2-1L3.2 9c-.1-.6.3-1 .8-1Z"></path>',
		'popsicle'                           => '<path d="M18.6 14.4c.8-.8.8-2 0-2.8l-8.1-8.1a4.95 4.95 0 1 0-7.1 7.1l8.1 8.1c.9.7 2.1.7 2.9-.1Z"></path><path d="m22 22-5.5-5.5"></path>',
		'pound-sterling'                     => '<path d="M18 7c0-5.333-8-5.333-8 0"></path><path d="M10 7v14"></path><path d="M6 21h12"></path><path d="M6 13h10"></path>',
		'power-off'                          => '<path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path><path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path><path d="M12 2v4"></path><path d="m2 2 20 20"></path>',
		'power'                              => '<path d="M12 2v10"></path><path d="M18.4 6.6a9 9 0 1 1-12.77.04"></path>',
		'presentation'                       => '<path d="M2 3h20"></path><path d="M21 3v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V3"></path><path d="m7 21 5-5 5 5"></path>',
		'printer-check'                      => '<path d="M13.5 22H7a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v.5"></path><path d="m16 19 2 2 4-4"></path><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v2"></path><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"></path>',
		'printer-x'                          => '<path d="M12.531 22H7a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h6.377"></path><path d="m16.5 16.5 5 5"></path><path d="m16.5 21.5 5-5"></path><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1.5"></path><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"></path>',
		'printer'                            => '<path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"></path><rect x="6" y="14" width="12" height="8" rx="1"></rect>',
		'projector'                          => '<path d="M5 7 3 5"></path><path d="M9 6V3"></path><path d="m13 7 2-2"></path><circle cx="9" cy="13" r="3"></circle><path d="M11.83 12H20a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h2.17"></path><path d="M16 16h2"></path>',
		'proportions'                        => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="M12 9v11"></path><path d="M2 9h13a2 2 0 0 1 2 2v9"></path>',
		'puzzle'                             => '<path d="M15.39 4.39a1 1 0 0 0 1.68-.474 2.5 2.5 0 1 1 3.014 3.015 1 1 0 0 0-.474 1.68l1.683 1.682a2.414 2.414 0 0 1 0 3.414L19.61 15.39a1 1 0 0 1-1.68-.474 2.5 2.5 0 1 0-3.014 3.015 1 1 0 0 1 .474 1.68l-1.683 1.682a2.414 2.414 0 0 1-3.414 0L8.61 19.61a1 1 0 0 0-1.68.474 2.5 2.5 0 1 1-3.014-3.015 1 1 0 0 0 .474-1.68l-1.683-1.682a2.414 2.414 0 0 1 0-3.414L4.39 8.61a1 1 0 0 1 1.68.474 2.5 2.5 0 1 0 3.014-3.015 1 1 0 0 1-.474-1.68l1.683-1.682a2.414 2.414 0 0 1 3.414 0z"></path>',
		'pyramid'                            => '<path d="M2.5 16.88a1 1 0 0 1-.32-1.43l9-13.02a1 1 0 0 1 1.64 0l9 13.01a1 1 0 0 1-.32 1.44l-8.51 4.86a2 2 0 0 1-1.98 0Z"></path><path d="M12 2v20"></path>',
		'qr-code'                            => '<rect width="5" height="5" x="3" y="3" rx="1"></rect><rect width="5" height="5" x="16" y="3" rx="1"></rect><rect width="5" height="5" x="3" y="16" rx="1"></rect><path d="M21 16h-3a2 2 0 0 0-2 2v3"></path><path d="M21 21v.01"></path><path d="M12 7v3a2 2 0 0 1-2 2H7"></path><path d="M3 12h.01"></path><path d="M12 3h.01"></path><path d="M12 16v.01"></path><path d="M16 12h1"></path><path d="M21 12v.01"></path><path d="M12 21v-1"></path>',
		'quote'                              => '<path d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"></path><path d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"></path>',
		'rabbit'                             => '<path d="M13 16a3 3 0 0 1 2.24 5"></path><path d="M18 12h.01"></path><path d="M18 21h-8a4 4 0 0 1-4-4 7 7 0 0 1 7-7h.2L9.6 6.4a1 1 0 1 1 2.8-2.8L15.8 7h.2c3.3 0 6 2.7 6 6v1a2 2 0 0 1-2 2h-1a3 3 0 0 0-3 3"></path><path d="M20 8.54V4a2 2 0 1 0-4 0v3"></path><path d="M7.612 12.524a3 3 0 1 0-1.6 4.3"></path>',
		'radar'                              => '<path d="M19.07 4.93A10 10 0 0 0 6.99 3.34"></path><path d="M4 6h.01"></path><path d="M2.29 9.62A10 10 0 1 0 21.31 8.35"></path><path d="M16.24 7.76A6 6 0 1 0 8.23 16.67"></path><path d="M12 18h.01"></path><path d="M17.99 11.66A6 6 0 0 1 15.77 16.67"></path><circle cx="12" cy="12" r="2"></circle><path d="m13.41 10.59 5.66-5.66"></path>',
		'radiation'                          => '<path d="M12 12h.01"></path><path d="M14 15.4641a4 4 0 0 1-4 0L7.52786 19.74597 A 1 1 0 0 0 7.99303 21.16211 10 10 0 0 0 16.00697 21.16211 1 1 0 0 0 16.47214 19.74597z"></path><path d="M16 12a4 4 0 0 0-2-3.464l2.472-4.282a1 1 0 0 1 1.46-.305 10 10 0 0 1 4.006 6.94A1 1 0 0 1 21 12z"></path><path d="M8 12a4 4 0 0 1 2-3.464L7.528 4.254a1 1 0 0 0-1.46-.305 10 10 0 0 0-4.006 6.94A1 1 0 0 0 3 12z"></path>',
		'radical'                            => '<path d="M3 12h3.28a1 1 0 0 1 .948.684l2.298 7.934a.5.5 0 0 0 .96-.044L13.82 4.771A1 1 0 0 1 14.792 4H21"></path>',
		'radio-receiver'                     => '<path d="M5 16v2"></path><path d="M19 16v2"></path><rect width="20" height="8" x="2" y="8" rx="2"></rect><path d="M18 12h.01"></path>',
		'radio-tower'                        => '<path d="M4.9 16.1C1 12.2 1 5.8 4.9 1.9"></path><path d="M7.8 4.7a6.14 6.14 0 0 0-.8 7.5"></path><circle cx="12" cy="9" r="2"></circle><path d="M16.2 4.8c2 2 2.26 5.11.8 7.47"></path><path d="M19.1 1.9a9.96 9.96 0 0 1 0 14.1"></path><path d="M9.5 18h5"></path><path d="m8 22 4-11 4 11"></path>',
		'radio'                              => '<path d="M16.247 7.761a6 6 0 0 1 0 8.478"></path><path d="M19.075 4.933a10 10 0 0 1 0 14.134"></path><path d="M4.925 19.067a10 10 0 0 1 0-14.134"></path><path d="M7.753 16.239a6 6 0 0 1 0-8.478"></path><circle cx="12" cy="12" r="2"></circle>',
		'radius'                             => '<path d="M20.34 17.52a10 10 0 1 0-2.82 2.82"></path><circle cx="19" cy="19" r="2"></circle><path d="m13.41 13.41 4.18 4.18"></path><circle cx="12" cy="12" r="2"></circle>',
		'rail-symbol'                        => '<path d="M5 15h14"></path><path d="M5 9h14"></path><path d="m14 20-5-5 6-6-5-5"></path>',
		'rainbow'                            => '<path d="M22 17a10 10 0 0 0-20 0"></path><path d="M6 17a6 6 0 0 1 12 0"></path><path d="M10 17a2 2 0 0 1 4 0"></path>',
		'rat'                                => '<path d="M13 22H4a2 2 0 0 1 0-4h12"></path><path d="M13.236 18a3 3 0 0 0-2.2-5"></path><path d="M16 9h.01"></path><path d="M16.82 3.94a3 3 0 1 1 3.237 4.868l1.815 2.587a1.5 1.5 0 0 1-1.5 2.1l-2.872-.453a3 3 0 0 0-3.5 3"></path><path d="M17 4.988a3 3 0 1 0-5.2 2.052A7 7 0 0 0 4 14.015 4 4 0 0 0 8 18"></path>',
		'ratio'                              => '<rect width="12" height="20" x="6" y="2" rx="2"></rect><rect width="20" height="12" x="2" y="6" rx="2"></rect>',
		'receipt-cent'                       => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M12 6.5v11"></path><path d="M15 9.4a4 4 0 1 0 0 5.2"></path>',
		'receipt-euro'                       => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M8 12h5"></path><path d="M16 9.5a4 4 0 1 0 0 5.2"></path>',
		'receipt-indian-rupee'               => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M8 7h8"></path><path d="M12 17.5 8 15h1a4 4 0 0 0 0-8"></path><path d="M8 11h8"></path>',
		'receipt-japanese-yen'               => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="m12 10 3-3"></path><path d="m9 7 3 3v7.5"></path><path d="M9 11h6"></path><path d="M9 15h6"></path>',
		'receipt-pound-sterling'             => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M8 13h5"></path><path d="M10 17V9.5a2.5 2.5 0 0 1 5 0"></path><path d="M8 17h7"></path>',
		'receipt-russian-ruble'              => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M8 15h5"></path><path d="M8 11h5a2 2 0 1 0 0-4h-3v10"></path>',
		'receipt-swiss-franc'                => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M10 17V7h5"></path><path d="M10 11h4"></path><path d="M8 15h5"></path>',
		'receipt-text'                       => '<path d="M13 16H8"></path><path d="M14 8H8"></path><path d="M16 12H8"></path><path d="M4 3a1 1 0 0 1 1-1 1.3 1.3 0 0 1 .7.2l.933.6a1.3 1.3 0 0 0 1.4 0l.934-.6a1.3 1.3 0 0 1 1.4 0l.933.6a1.3 1.3 0 0 0 1.4 0l.933-.6a1.3 1.3 0 0 1 1.4 0l.934.6a1.3 1.3 0 0 0 1.4 0l.933-.6A1.3 1.3 0 0 1 19 2a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1 1.3 1.3 0 0 1-.7-.2l-.933-.6a1.3 1.3 0 0 0-1.4 0l-.934.6a1.3 1.3 0 0 1-1.4 0l-.933-.6a1.3 1.3 0 0 0-1.4 0l-.933.6a1.3 1.3 0 0 1-1.4 0l-.934-.6a1.3 1.3 0 0 0-1.4 0l-.933.6a1.3 1.3 0 0 1-.7.2 1 1 0 0 1-1-1z"></path>',
		'receipt-turkish-lira'               => '<path d="M10 6.5v11a5.5 5.5 0 0 0 5.5-5.5"></path><path d="m14 8-6 3"></path><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1z"></path>',
		'receipt'                            => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path><path d="M12 17.5v-11"></path>',
		'rectangle-circle'                   => '<path d="M14 4v16H3a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"></path><circle cx="14" cy="12" r="8"></circle>',
		'rectangle-ellipsis'                 => '<rect width="20" height="12" x="2" y="6" rx="2"></rect><path d="M12 12h.01"></path><path d="M17 12h.01"></path><path d="M7 12h.01"></path>',
		'rectangle-goggles'                  => '<path d="M20 6a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-4a2 2 0 0 1-1.6-.8l-1.6-2.13a1 1 0 0 0-1.6 0L9.6 17.2A2 2 0 0 1 8 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"></path>',
		'rectangle-horizontal'               => '<rect width="20" height="12" x="2" y="6" rx="2"></rect>',
		'rectangle-vertical'                 => '<rect width="12" height="20" x="6" y="2" rx="2"></rect>',
		'recycle'                            => '<path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"></path><path d="M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12"></path><path d="m14 16-3 3 3 3"></path><path d="M8.293 13.596 7.196 9.5 3.1 10.598"></path><path d="m9.344 5.811 1.093-1.892A1.83 1.83 0 0 1 11.985 3a1.784 1.784 0 0 1 1.546.888l3.943 6.843"></path><path d="m13.378 9.633 4.096 1.098 1.097-4.096"></path>',
		'redo-2'                             => '<path d="m15 14 5-5-5-5"></path><path d="M20 9H9.5A5.5 5.5 0 0 0 4 14.5A5.5 5.5 0 0 0 9.5 20H13"></path>',
		'redo-dot'                           => '<circle cx="12" cy="17" r="1"></circle><path d="M21 7v6h-6"></path><path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3l3 2.7"></path>',
		'redo'                               => '<path d="M21 7v6h-6"></path><path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3l3 2.7"></path>',
		'refresh-ccw-dot'                    => '<path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path><path d="M16 16h5v5"></path><circle cx="12" cy="12" r="1"></circle>',
		'refresh-ccw'                        => '<path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path><path d="M16 16h5v5"></path>',
		'refresh-cw-off'                     => '<path d="M21 8L18.74 5.74A9.75 9.75 0 0 0 12 3C11 3 10.03 3.16 9.13 3.47"></path><path d="M8 16H3v5"></path><path d="M3 12C3 9.51 4 7.26 5.64 5.64"></path><path d="m3 16 2.26 2.26A9.75 9.75 0 0 0 12 21c2.49 0 4.74-1 6.36-2.64"></path><path d="M21 12c0 1-.16 1.97-.47 2.87"></path><path d="M21 3v5h-5"></path><path d="M22 22 2 2"></path>',
		'refresh-cw'                         => '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path>',
		'refrigerator'                       => '<path d="M5 6a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6Z"></path><path d="M5 10h14"></path><path d="M15 7v6"></path>',
		'regex'                              => '<path d="M17 3v10"></path><path d="m12.67 5.5 8.66 5"></path><path d="m12.67 10.5 8.66-5"></path><path d="M9 17a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2z"></path>',
		'remove-formatting'                  => '<path d="M4 7V4h16v3"></path><path d="M5 20h6"></path><path d="M13 4 8 20"></path><path d="m15 15 5 5"></path><path d="m20 15-5 5"></path>',
		'repeat-1'                           => '<path d="m17 2 4 4-4 4"></path><path d="M3 11v-1a4 4 0 0 1 4-4h14"></path><path d="m7 22-4-4 4-4"></path><path d="M21 13v1a4 4 0 0 1-4 4H3"></path><path d="M11 10h1v4"></path>',
		'repeat-2'                           => '<path d="m2 9 3-3 3 3"></path><path d="M13 18H7a2 2 0 0 1-2-2V6"></path><path d="m22 15-3 3-3-3"></path><path d="M11 6h6a2 2 0 0 1 2 2v10"></path>',
		'repeat'                             => '<path d="m17 2 4 4-4 4"></path><path d="M3 11v-1a4 4 0 0 1 4-4h14"></path><path d="m7 22-4-4 4-4"></path><path d="M21 13v1a4 4 0 0 1-4 4H3"></path>',
		'replace-all'                        => '<path d="M14 14a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1"></path><path d="M14 4a1 1 0 0 1 1-1"></path><path d="M15 10a1 1 0 0 1-1-1"></path><path d="M19 14a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1"></path><path d="M21 4a1 1 0 0 0-1-1"></path><path d="M21 9a1 1 0 0 1-1 1"></path><path d="m3 7 3 3 3-3"></path><path d="M6 10V5a2 2 0 0 1 2-2h2"></path><rect x="3" y="14" width="7" height="7" rx="1"></rect>',
		'replace'                            => '<path d="M14 4a1 1 0 0 1 1-1"></path><path d="M15 10a1 1 0 0 1-1-1"></path><path d="M21 4a1 1 0 0 0-1-1"></path><path d="M21 9a1 1 0 0 1-1 1"></path><path d="m3 7 3 3 3-3"></path><path d="M6 10V5a2 2 0 0 1 2-2h2"></path><rect x="3" y="14" width="7" height="7" rx="1"></rect>',
		'reply-all'                          => '<path d="m12 17-5-5 5-5"></path><path d="M22 18v-2a4 4 0 0 0-4-4H7"></path><path d="m7 17-5-5 5-5"></path>',
		'reply'                              => '<path d="M20 18v-2a4 4 0 0 0-4-4H4"></path><path d="m9 17-5-5 5-5"></path>',
		'rewind'                             => '<path d="M12 6a2 2 0 0 0-3.414-1.414l-6 6a2 2 0 0 0 0 2.828l6 6A2 2 0 0 0 12 18z"></path><path d="M22 6a2 2 0 0 0-3.414-1.414l-6 6a2 2 0 0 0 0 2.828l6 6A2 2 0 0 0 22 18z"></path>',
		'ribbon'                             => '<path d="M12 11.22C11 9.997 10 9 10 8a2 2 0 0 1 4 0c0 1-.998 2.002-2.01 3.22"></path><path d="m12 18 2.57-3.5"></path><path d="M6.243 9.016a7 7 0 0 1 11.507-.009"></path><path d="M9.35 14.53 12 11.22"></path><path d="M9.35 14.53C7.728 12.246 6 10.221 6 7a6 5 0 0 1 12 0c-.005 3.22-1.778 5.235-3.43 7.5l3.557 4.527a1 1 0 0 1-.203 1.43l-1.894 1.36a1 1 0 0 1-1.384-.215L12 18l-2.679 3.593a1 1 0 0 1-1.39.213l-1.865-1.353a1 1 0 0 1-.203-1.422z"></path>',
		'rocket'                             => '<path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>',
		'rocking-chair'                      => '<polyline points="3.5 2 6.5 12.5 18 12.5"></polyline><line x1="9.5" x2="5.5" y1="12.5" y2="20"></line><line x1="15" x2="18.5" y1="12.5" y2="20"></line><path d="M2.75 18a13 13 0 0 0 18.5 0"></path>',
		'roller-coaster'                     => '<path d="M6 19V5"></path><path d="M10 19V6.8"></path><path d="M14 19v-7.8"></path><path d="M18 5v4"></path><path d="M18 19v-6"></path><path d="M22 19V9"></path><path d="M2 19V9a4 4 0 0 1 4-4c2 0 4 1.33 6 4s4 4 6 4a4 4 0 1 0-3-6.65"></path>',
		'rose'                               => '<path d="M17 10h-1a4 4 0 1 1 4-4v.534"></path><path d="M17 6h1a4 4 0 0 1 1.42 7.74l-2.29.87a6 6 0 0 1-5.339-10.68l2.069-1.31"></path><path d="M4.5 17c2.8-.5 4.4 0 5.5.8s1.8 2.2 2.3 3.7c-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2"></path><path d="M9.77 12C4 15 2 22 2 22"></path><circle cx="17" cy="8" r="2"></circle>',
		'rotate-3d'                          => '<path d="M16.466 7.5C15.643 4.237 13.952 2 12 2 9.239 2 7 6.477 7 12s2.239 10 5 10c.342 0 .677-.069 1-.2"></path><path d="m15.194 13.707 3.814 1.86-1.86 3.814"></path><path d="M19 15.57c-1.804.885-4.274 1.43-7 1.43-5.523 0-10-2.239-10-5s4.477-5 10-5c4.838 0 8.873 1.718 9.8 4"></path>',
		'rotate-ccw-key'                     => '<path d="m14.5 9.5 1 1"></path><path d="m15.5 8.5-4 4"></path><path d="M3 12a9 9 0 1 0 9-9 9.74 9.74 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path><circle cx="10" cy="14" r="2"></circle>',
		'rotate-ccw-square'                  => '<path d="M20 9V7a2 2 0 0 0-2-2h-6"></path><path d="m15 2-3 3 3 3"></path><path d="M20 13v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2"></path>',
		'rotate-ccw'                         => '<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path>',
		'rotate-cw-square'                   => '<path d="M12 5H6a2 2 0 0 0-2 2v3"></path><path d="m9 8 3-3-3-3"></path><path d="M4 14v4a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path>',
		'rotate-cw'                          => '<path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path>',
		'route-off'                          => '<circle cx="6" cy="19" r="3"></circle><path d="M9 19h8.5c.4 0 .9-.1 1.3-.2"></path><path d="M5.2 5.2A3.5 3.53 0 0 0 6.5 12H12"></path><path d="m2 2 20 20"></path><path d="M21 15.3a3.5 3.5 0 0 0-3.3-3.3"></path><path d="M15 5h-4.3"></path><circle cx="18" cy="5" r="3"></circle>',
		'route'                              => '<circle cx="6" cy="19" r="3"></circle><path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"></path><circle cx="18" cy="5" r="3"></circle>',
		'router'                             => '<rect width="20" height="8" x="2" y="14" rx="2"></rect><path d="M6.01 18H6"></path><path d="M10.01 18H10"></path><path d="M15 10v4"></path><path d="M17.84 7.17a4 4 0 0 0-5.66 0"></path><path d="M20.66 4.34a8 8 0 0 0-11.31 0"></path>',
		'rows-2'                             => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 12h18"></path>',
		'rows-3'                             => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M21 9H3"></path><path d="M21 15H3"></path>',
		'rows-4'                             => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M21 7.5H3"></path><path d="M21 12H3"></path><path d="M21 16.5H3"></path>',
		'rss'                                => '<path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>',
		'ruler-dimension-line'               => '<path d="M10 15v-3"></path><path d="M14 15v-3"></path><path d="M18 15v-3"></path><path d="M2 8V4"></path><path d="M22 6H2"></path><path d="M22 8V4"></path><path d="M6 15v-3"></path><rect x="2" y="12" width="20" height="8" rx="2"></rect>',
		'ruler'                              => '<path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"></path><path d="m14.5 12.5 2-2"></path><path d="m11.5 9.5 2-2"></path><path d="m8.5 6.5 2-2"></path><path d="m17.5 15.5 2-2"></path>',
		'russian-ruble'                      => '<path d="M6 11h8a4 4 0 0 0 0-8H9v18"></path><path d="M6 15h8"></path>',
		'sailboat'                           => '<path d="M10 2v15"></path><path d="M7 22a4 4 0 0 1-4-4 1 1 0 0 1 1-1h16a1 1 0 0 1 1 1 4 4 0 0 1-4 4z"></path><path d="M9.159 2.46a1 1 0 0 1 1.521-.193l9.977 8.98A1 1 0 0 1 20 13H4a1 1 0 0 1-.824-1.567z"></path>',
		'salad'                              => '<path d="M7 21h10"></path><path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"></path><path d="M11.38 12a2.4 2.4 0 0 1-.4-4.77 2.4 2.4 0 0 1 3.2-2.77 2.4 2.4 0 0 1 3.47-.63 2.4 2.4 0 0 1 3.37 3.37 2.4 2.4 0 0 1-1.1 3.7 2.51 2.51 0 0 1 .03 1.1"></path><path d="m13 12 4-4"></path><path d="M10.9 7.25A3.99 3.99 0 0 0 4 10c0 .73.2 1.41.54 2"></path>',
		'sandwich'                           => '<path d="m2.37 11.223 8.372-6.777a2 2 0 0 1 2.516 0l8.371 6.777"></path><path d="M21 15a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-5.25"></path><path d="M3 15a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h9"></path><path d="m6.67 15 6.13 4.6a2 2 0 0 0 2.8-.4l3.15-4.2"></path><rect width="20" height="4" x="2" y="11" rx="1"></rect>',
		'satellite-dish'                     => '<path d="M4 10a7.31 7.31 0 0 0 10 10Z"></path><path d="m9 15 3-3"></path><path d="M17 13a6 6 0 0 0-6-6"></path><path d="M21 13A10 10 0 0 0 11 3"></path>',
		'satellite'                          => '<path d="m13.5 6.5-3.148-3.148a1.205 1.205 0 0 0-1.704 0L6.352 5.648a1.205 1.205 0 0 0 0 1.704L9.5 10.5"></path><path d="M16.5 7.5 19 5"></path><path d="m17.5 10.5 3.148 3.148a1.205 1.205 0 0 1 0 1.704l-2.296 2.296a1.205 1.205 0 0 1-1.704 0L13.5 14.5"></path><path d="M9 21a6 6 0 0 0-6-6"></path><path d="M9.352 10.648a1.205 1.205 0 0 0 0 1.704l2.296 2.296a1.205 1.205 0 0 0 1.704 0l4.296-4.296a1.205 1.205 0 0 0 0-1.704l-2.296-2.296a1.205 1.205 0 0 0-1.704 0z"></path>',
		'saudi-riyal'                        => '<path d="m20 19.5-5.5 1.2"></path><path d="M14.5 4v11.22a1 1 0 0 0 1.242.97L20 15.2"></path><path d="m2.978 19.351 5.549-1.363A2 2 0 0 0 10 16V2"></path><path d="M20 10 4 13.5"></path>',
		'save-all'                           => '<path d="M10 2v3a1 1 0 0 0 1 1h5"></path><path d="M18 18v-6a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6"></path><path d="M18 22H4a2 2 0 0 1-2-2V6"></path><path d="M8 18a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9.172a2 2 0 0 1 1.414.586l2.828 2.828A2 2 0 0 1 22 6.828V16a2 2 0 0 1-2.01 2z"></path>',
		'save-off'                           => '<path d="M13 13H8a1 1 0 0 0-1 1v7"></path><path d="M14 8h1"></path><path d="M17 21v-4"></path><path d="m2 2 20 20"></path><path d="M20.41 20.41A2 2 0 0 1 19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 .59-1.41"></path><path d="M29.5 11.5s5 5 4 5"></path><path d="M9 3h6.2a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V15"></path>',
		'save'                               => '<path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path><path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path><path d="M7 3v4a1 1 0 0 0 1 1h7"></path>',
		'scale-3d'                           => '<path d="M5 7v11a1 1 0 0 0 1 1h11"></path><path d="M5.293 18.707 11 13"></path><circle cx="19" cy="19" r="2"></circle><circle cx="5" cy="5" r="2"></circle>',
		'scale'                              => '<path d="M12 3v18"></path><path d="m19 8 3 8a5 5 0 0 1-6 0zV7"></path><path d="M3 7h1a17 17 0 0 0 8-2 17 17 0 0 0 8 2h1"></path><path d="m5 8 3 8a5 5 0 0 1-6 0zV7"></path><path d="M7 21h10"></path>',
		'scaling'                            => '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M14 15H9v-5"></path><path d="M16 3h5v5"></path><path d="M21 3 9 15"></path>',
		'scan-barcode'                       => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><path d="M8 7v10"></path><path d="M12 7v10"></path><path d="M17 7v10"></path>',
		'scan-eye'                           => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><circle cx="12" cy="12" r="1"></circle><path d="M18.944 12.33a1 1 0 0 0 0-.66 7.5 7.5 0 0 0-13.888 0 1 1 0 0 0 0 .66 7.5 7.5 0 0 0 13.888 0"></path>',
		'scan-face'                          => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><path d="M9 9h.01"></path><path d="M15 9h.01"></path>',
		'scan-heart'                         => '<path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><path d="M7.828 13.07A3 3 0 0 1 12 8.764a3 3 0 0 1 4.172 4.306l-3.447 3.62a1 1 0 0 1-1.449 0z"></path>',
		'scan-line'                          => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><path d="M7 12h10"></path>',
		'scan-qr-code'                       => '<path d="M17 12v4a1 1 0 0 1-1 1h-4"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M17 8V7"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M7 17h.01"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><rect x="7" y="7" width="5" height="5" rx="1"></rect>',
		'scan-search'                        => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><circle cx="12" cy="12" r="3"></circle><path d="m16 16-1.9-1.9"></path>',
		'scan-text'                          => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><path d="M7 8h8"></path><path d="M7 12h10"></path><path d="M7 16h6"></path>',
		'scan'                               => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>',
		'school'                             => '<path d="M14 21v-3a2 2 0 0 0-4 0v3"></path><path d="M18 5v16"></path><path d="m4 6 7.106-3.79a2 2 0 0 1 1.788 0L20 6"></path><path d="m6 11-3.52 2.147a1 1 0 0 0-.48.854V19a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a1 1 0 0 0-.48-.853L18 11"></path><path d="M6 5v16"></path><circle cx="12" cy="9" r="2"></circle>',
		'scissors-line-dashed'               => '<path d="M5.42 9.42 8 12"></path><circle cx="4" cy="8" r="2"></circle><path d="m14 6-8.58 8.58"></path><circle cx="4" cy="16" r="2"></circle><path d="M10.8 14.8 14 18"></path><path d="M16 12h-2"></path><path d="M22 12h-2"></path>',
		'scissors'                           => '<circle cx="6" cy="6" r="3"></circle><path d="M8.12 8.12 12 12"></path><path d="M20 4 8.12 15.88"></path><circle cx="6" cy="18" r="3"></circle><path d="M14.8 14.8 20 20"></path>',
		'scooter'                            => '<path d="M21 4h-3.5l2 11.05"></path><path d="M6.95 17h5.142c.523 0 .95-.406 1.063-.916a6.5 6.5 0 0 1 5.345-5.009"></path><circle cx="19.5" cy="17.5" r="2.5"></circle><circle cx="4.5" cy="17.5" r="2.5"></circle>',
		'screen-share-off'                   => '<path d="M13 3H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-3"></path><path d="M8 21h8"></path><path d="M12 17v4"></path><path d="m22 3-5 5"></path><path d="m17 3 5 5"></path>',
		'screen-share'                       => '<path d="M13 3H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-3"></path><path d="M8 21h8"></path><path d="M12 17v4"></path><path d="m17 8 5-5"></path><path d="M17 3h5v5"></path>',
		'scroll-text'                        => '<path d="M15 12h-5"></path><path d="M15 8h-5"></path><path d="M19 17V5a2 2 0 0 0-2-2H4"></path><path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3"></path>',
		'scroll'                             => '<path d="M19 17V5a2 2 0 0 0-2-2H4"></path><path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3"></path>',
		'search-alert'                       => '<circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path><path d="M11 7v4"></path><path d="M11 15h.01"></path>',
		'search-check'                       => '<path d="m8 11 2 2 4-4"></path><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path>',
		'search-code'                        => '<path d="m13 13.5 2-2.5-2-2.5"></path><path d="m21 21-4.3-4.3"></path><path d="M9 8.5 7 11l2 2.5"></path><circle cx="11" cy="11" r="8"></circle>',
		'search-slash'                       => '<path d="m13.5 8.5-5 5"></path><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path>',
		'search-x'                           => '<path d="m13.5 8.5-5 5"></path><path d="m8.5 8.5 5 5"></path><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path>',
		'search'                             => '<path d="m21 21-4.34-4.34"></path><circle cx="11" cy="11" r="8"></circle>',
		'section'                            => '<path d="M16 5a4 3 0 0 0-8 0c0 4 8 3 8 7a4 3 0 0 1-8 0"></path><path d="M8 19a4 3 0 0 0 8 0c0-4-8-3-8-7a4 3 0 0 1 8 0"></path>',
		'send-horizontal'                    => '<path d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z"></path><path d="M6 12h16"></path>',
		'send-to-back'                       => '<rect x="14" y="14" width="8" height="8" rx="2"></rect><rect x="2" y="2" width="8" height="8" rx="2"></rect><path d="M7 14v1a2 2 0 0 0 2 2h1"></path><path d="M14 7h1a2 2 0 0 1 2 2v1"></path>',
		'send'                               => '<path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"></path><path d="m21.854 2.147-10.94 10.939"></path>',
		'separator-horizontal'               => '<path d="m16 16-4 4-4-4"></path><path d="M3 12h18"></path><path d="m8 8 4-4 4 4"></path>',
		'separator-vertical'                 => '<path d="M12 3v18"></path><path d="m16 16 4-4-4-4"></path><path d="m8 8-4 4 4 4"></path>',
		'server-cog'                         => '<path d="m10.852 14.772-.383.923"></path><path d="M13.148 14.772a3 3 0 1 0-2.296-5.544l-.383-.923"></path><path d="m13.148 9.228.383-.923"></path><path d="m13.53 15.696-.382-.924a3 3 0 1 1-2.296-5.544"></path><path d="m14.772 10.852.923-.383"></path><path d="m14.772 13.148.923.383"></path><path d="M4.5 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-.5"></path><path d="M4.5 14H4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-.5"></path><path d="M6 18h.01"></path><path d="M6 6h.01"></path><path d="m9.228 10.852-.923-.383"></path><path d="m9.228 13.148-.923.383"></path>',
		'server-crash'                       => '<path d="M6 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2"></path><path d="M6 14H4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2"></path><path d="M6 6h.01"></path><path d="M6 18h.01"></path><path d="m13 6-4 6h6l-4 6"></path>',
		'server-off'                         => '<path d="M7 2h13a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-5"></path><path d="M10 10 2.5 2.5C2 2 2 2.5 2 5v3a2 2 0 0 0 2 2h6z"></path><path d="M22 17v-1a2 2 0 0 0-2-2h-1"></path><path d="M4 14a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16.5l1-.5.5.5-8-8H4z"></path><path d="M6 18h.01"></path><path d="m2 2 20 20"></path>',
		'server'                             => '<rect width="20" height="8" x="2" y="2" rx="2" ry="2"></rect><rect width="20" height="8" x="2" y="14" rx="2" ry="2"></rect><line x1="6" x2="6.01" y1="6" y2="6"></line><line x1="6" x2="6.01" y1="18" y2="18"></line>',
		'settings-2'                         => '<path d="M14 17H5"></path><path d="M19 7h-9"></path><circle cx="17" cy="17" r="3"></circle><circle cx="7" cy="7" r="3"></circle>',
		'settings'                           => '<path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"></path><circle cx="12" cy="12" r="3"></circle>',
		'shapes'                             => '<path d="M8.3 10a.7.7 0 0 1-.626-1.079L11.4 3a.7.7 0 0 1 1.198-.043L16.3 8.9a.7.7 0 0 1-.572 1.1Z"></path><rect x="3" y="14" width="7" height="7" rx="1"></rect><circle cx="17.5" cy="17.5" r="3.5"></circle>',
		'share-2'                            => '<circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>',
		'share'                              => '<path d="M12 2v13"></path><path d="m16 6-4-4-4 4"></path><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>',
		'sheet'                              => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><line x1="3" x2="21" y1="9" y2="9"></line><line x1="3" x2="21" y1="15" y2="15"></line><line x1="9" x2="9" y1="9" y2="21"></line><line x1="15" x2="15" y1="9" y2="21"></line>',
		'shell'                              => '<path d="M14 11a2 2 0 1 1-4 0 4 4 0 0 1 8 0 6 6 0 0 1-12 0 8 8 0 0 1 16 0 10 10 0 1 1-20 0 11.93 11.93 0 0 1 2.42-7.22 2 2 0 1 1 3.16 2.44"></path>',
		'shield-alert'                       => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path>',
		'shield-ban'                         => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m4.243 5.21 14.39 12.472"></path>',
		'shield-check'                       => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path>',
		'shield-ellipsis'                    => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M8 12h.01"></path><path d="M12 12h.01"></path><path d="M16 12h.01"></path>',
		'shield-half'                        => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M12 22V2"></path>',
		'shield-minus'                       => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M9 12h6"></path>',
		'shield-off'                         => '<path d="m2 2 20 20"></path><path d="M5 5a1 1 0 0 0-1 1v7c0 5 3.5 7.5 7.67 8.94a1 1 0 0 0 .67.01c2.35-.82 4.48-1.97 5.9-3.71"></path><path d="M9.309 3.652A12.252 12.252 0 0 0 11.24 2.28a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1v7a9.784 9.784 0 0 1-.08 1.264"></path>',
		'shield-plus'                        => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M9 12h6"></path><path d="M12 9v6"></path>',
		'shield-question-mark'               => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path>',
		'shield-user'                        => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M6.376 18.91a6 6 0 0 1 11.249.003"></path><circle cx="12" cy="11" r="4"></circle>',
		'shield-x'                           => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m14.5 9.5-5 5"></path><path d="m9.5 9.5 5 5"></path>',
		'shield'                             => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>',
		'ship-wheel'                         => '<circle cx="12" cy="12" r="8"></circle><path d="M12 2v7.5"></path><path d="m19 5-5.23 5.23"></path><path d="M22 12h-7.5"></path><path d="m19 19-5.23-5.23"></path><path d="M12 14.5V22"></path><path d="M10.23 13.77 5 19"></path><path d="M9.5 12H2"></path><path d="M10.23 10.23 5 5"></path><circle cx="12" cy="12" r="2.5"></circle>',
		'ship'                               => '<path d="M12 10.189V14"></path><path d="M12 2v3"></path><path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"></path><path d="M19.38 20A11.6 11.6 0 0 0 21 14l-8.188-3.639a2 2 0 0 0-1.624 0L3 14a11.6 11.6 0 0 0 2.81 7.76"></path><path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1s1.2 1 2.5 1c2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path>',
		'shirt'                              => '<path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path>',
		'shopping-bag'                       => '<path d="M16 10a4 4 0 0 1-8 0"></path><path d="M3.103 6.034h17.794"></path><path d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z"></path>',
		'shopping-basket'                    => '<path d="m15 11-1 9"></path><path d="m19 11-4-7"></path><path d="M2 11h20"></path><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"></path><path d="M4.5 15.5h15"></path><path d="m5 11 4-7"></path><path d="m9 11 1 9"></path>',
		'shopping-cart'                      => '<circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>',
		'shovel'                             => '<path d="M21.56 4.56a1.5 1.5 0 0 1 0 2.122l-.47.47a3 3 0 0 1-4.212-.03 3 3 0 0 1 0-4.243l.44-.44a1.5 1.5 0 0 1 2.121 0z"></path><path d="M3 22a1 1 0 0 1-1-1v-3.586a1 1 0 0 1 .293-.707l3.355-3.355a1.205 1.205 0 0 1 1.704 0l3.296 3.296a1.205 1.205 0 0 1 0 1.704l-3.355 3.355a1 1 0 0 1-.707.293z"></path><path d="m9 15 7.879-7.878"></path>',
		'shower-head'                        => '<path d="m4 4 2.5 2.5"></path><path d="M13.5 6.5a4.95 4.95 0 0 0-7 7"></path><path d="M15 5 5 15"></path><path d="M14 17v.01"></path><path d="M10 16v.01"></path><path d="M13 13v.01"></path><path d="M16 10v.01"></path><path d="M11 20v.01"></path><path d="M17 14v.01"></path><path d="M20 11v.01"></path>',
		'shredder'                           => '<path d="M4 13V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M10 22v-5"></path><path d="M14 19v-2"></path><path d="M18 20v-3"></path><path d="M2 13h20"></path><path d="M6 20v-3"></path>',
		'shrimp'                             => '<path d="M11 12h.01"></path><path d="M13 22c.5-.5 1.12-1 2.5-1-1.38 0-2-.5-2.5-1"></path><path d="M14 2a3.28 3.28 0 0 1-3.227 1.798l-6.17-.561A2.387 2.387 0 1 0 4.387 8H15.5a1 1 0 0 1 0 13 1 1 0 0 0 0-5H12a7 7 0 0 1-7-7V8"></path><path d="M14 8a8.5 8.5 0 0 1 0 8"></path><path d="M16 16c2 0 4.5-4 4-6"></path>',
		'shrink'                             => '<path d="m15 15 6 6m-6-6v4.8m0-4.8h4.8"></path><path d="M9 19.8V15m0 0H4.2M9 15l-6 6"></path><path d="M15 4.2V9m0 0h4.8M15 9l6-6"></path><path d="M9 4.2V9m0 0H4.2M9 9 3 3"></path>',
		'shrub'                              => '<path d="M12 22v-5.172a2 2 0 0 0-.586-1.414L9.5 13.5"></path><path d="M14.5 14.5 12 17"></path><path d="M17 8.8A6 6 0 0 1 13.8 20H10A6.5 6.5 0 0 1 7 8a5 5 0 0 1 10 0z"></path>',
		'shuffle'                            => '<path d="m18 14 4 4-4 4"></path><path d="m18 2 4 4-4 4"></path><path d="M2 18h1.973a4 4 0 0 0 3.3-1.7l5.454-8.6a4 4 0 0 1 3.3-1.7H22"></path><path d="M2 6h1.972a4 4 0 0 1 3.6 2.2"></path><path d="M22 18h-6.041a4 4 0 0 1-3.3-1.8l-.359-.45"></path>',
		'sigma'                              => '<path d="M18 7V5a1 1 0 0 0-1-1H6.5a.5.5 0 0 0-.4.8l4.5 6a2 2 0 0 1 0 2.4l-4.5 6a.5.5 0 0 0 .4.8H17a1 1 0 0 0 1-1v-2"></path>',
		'signal-high'                        => '<path d="M2 20h.01"></path><path d="M7 20v-4"></path><path d="M12 20v-8"></path><path d="M17 20V8"></path>',
		'signal-low'                         => '<path d="M2 20h.01"></path><path d="M7 20v-4"></path>',
		'signal-medium'                      => '<path d="M2 20h.01"></path><path d="M7 20v-4"></path><path d="M12 20v-8"></path>',
		'signal-zero'                        => '<path d="M2 20h.01"></path>',
		'signal'                             => '<path d="M2 20h.01"></path><path d="M7 20v-4"></path><path d="M12 20v-8"></path><path d="M17 20V8"></path><path d="M22 4v16"></path>',
		'signature'                          => '<path d="m21 17-2.156-1.868A.5.5 0 0 0 18 15.5v.5a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1c0-2.545-3.991-3.97-8.5-4a1 1 0 0 0 0 5c4.153 0 4.745-11.295 5.708-13.5a2.5 2.5 0 1 1 3.31 3.284"></path><path d="M3 21h18"></path>',
		'signpost-big'                       => '<path d="M10 9H4L2 7l2-2h6"></path><path d="M14 5h6l2 2-2 2h-6"></path><path d="M10 22V4a2 2 0 1 1 4 0v18"></path><path d="M8 22h8"></path>',
		'signpost'                           => '<path d="M12 13v8"></path><path d="M12 3v3"></path><path d="M18 6a2 2 0 0 1 1.387.56l2.307 2.22a1 1 0 0 1 0 1.44l-2.307 2.22A2 2 0 0 1 18 13H6a2 2 0 0 1-1.387-.56l-2.306-2.22a1 1 0 0 1 0-1.44l2.306-2.22A2 2 0 0 1 6 6z"></path>',
		'siren'                              => '<path d="M7 18v-6a5 5 0 1 1 10 0v6"></path><path d="M5 21a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2z"></path><path d="M21 12h1"></path><path d="M18.5 4.5 18 5"></path><path d="M2 12h1"></path><path d="M12 2v1"></path><path d="m4.929 4.929.707.707"></path><path d="M12 12v6"></path>',
		'skip-back'                          => '<path d="M17.971 4.285A2 2 0 0 1 21 6v12a2 2 0 0 1-3.029 1.715l-9.997-5.998a2 2 0 0 1-.003-3.432z"></path><path d="M3 20V4"></path>',
		'skip-forward'                       => '<path d="M21 4v16"></path><path d="M6.029 4.285A2 2 0 0 0 3 6v12a2 2 0 0 0 3.029 1.715l9.997-5.998a2 2 0 0 0 .003-3.432z"></path>',
		'skull'                              => '<path d="m12.5 17-.5-1-.5 1h1z"></path><path d="M15 22a1 1 0 0 0 1-1v-1a2 2 0 0 0 1.56-3.25 8 8 0 1 0-11.12 0A2 2 0 0 0 8 20v1a1 1 0 0 0 1 1z"></path><circle cx="15" cy="12" r="1"></circle><circle cx="9" cy="12" r="1"></circle>',
		'slack'                              => '<rect width="3" height="8" x="13" y="2" rx="1.5"></rect><path d="M19 8.5V10h1.5A1.5 1.5 0 1 0 19 8.5"></path><rect width="3" height="8" x="8" y="14" rx="1.5"></rect><path d="M5 15.5V14H3.5A1.5 1.5 0 1 0 5 15.5"></path><rect width="8" height="3" x="14" y="13" rx="1.5"></rect><path d="M15.5 19H14v1.5a1.5 1.5 0 1 0 1.5-1.5"></path><rect width="8" height="3" x="2" y="8" rx="1.5"></rect><path d="M8.5 5H10V3.5A1.5 1.5 0 1 0 8.5 5"></path>',
		'slash'                              => '<path d="M22 2 2 22"></path>',
		'slice'                              => '<path d="M11 16.586V19a1 1 0 0 1-1 1H2L18.37 3.63a1 1 0 1 1 3 3l-9.663 9.663a1 1 0 0 1-1.414 0L8 14"></path>',
		'sliders-horizontal'                 => '<path d="M10 5H3"></path><path d="M12 19H3"></path><path d="M14 3v4"></path><path d="M16 17v4"></path><path d="M21 12h-9"></path><path d="M21 19h-5"></path><path d="M21 5h-7"></path><path d="M8 10v4"></path><path d="M8 12H3"></path>',
		'sliders-vertical'                   => '<path d="M10 8h4"></path><path d="M12 21v-9"></path><path d="M12 8V3"></path><path d="M17 16h4"></path><path d="M19 12V3"></path><path d="M19 21v-5"></path><path d="M3 14h4"></path><path d="M5 10V3"></path><path d="M5 21v-7"></path>',
		'smartphone-charging'                => '<rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><path d="M12.667 8 10 12h4l-2.667 4"></path>',
		'smartphone-nfc'                     => '<rect width="7" height="12" x="2" y="6" rx="1"></rect><path d="M13 8.32a7.43 7.43 0 0 1 0 7.36"></path><path d="M16.46 6.21a11.76 11.76 0 0 1 0 11.58"></path><path d="M19.91 4.1a15.91 15.91 0 0 1 .01 15.8"></path>',
		'smartphone'                         => '<rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><path d="M12 18h.01"></path>',
		'smile-plus'                         => '<path d="M22 11v1a10 10 0 1 1-9-10"></path><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" x2="9.01" y1="9" y2="9"></line><line x1="15" x2="15.01" y1="9" y2="9"></line><path d="M16 5h6"></path><path d="M19 2v6"></path>',
		'smile'                              => '<circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" x2="9.01" y1="9" y2="9"></line><line x1="15" x2="15.01" y1="9" y2="9"></line>',
		'snail'                              => '<path d="M2 13a6 6 0 1 0 12 0 4 4 0 1 0-8 0 2 2 0 0 0 4 0"></path><circle cx="10" cy="13" r="8"></circle><path d="M2 21h12c4.4 0 8-3.6 8-8V7a2 2 0 1 0-4 0v6"></path><path d="M18 3 19.1 5.2"></path><path d="M22 3 20.9 5.2"></path>',
		'snowflake'                          => '<path d="m10 20-1.25-2.5L6 18"></path><path d="M10 4 8.75 6.5 6 6"></path><path d="m14 20 1.25-2.5L18 18"></path><path d="m14 4 1.25 2.5L18 6"></path><path d="m17 21-3-6h-4"></path><path d="m17 3-3 6 1.5 3"></path><path d="M2 12h6.5L10 9"></path><path d="m20 10-1.5 2 1.5 2"></path><path d="M22 12h-6.5L14 15"></path><path d="m4 10 1.5 2L4 14"></path><path d="m7 21 3-6-1.5-3"></path><path d="m7 3 3 6h4"></path>',
		'soap-dispenser-droplet'             => '<path d="M10.5 2v4"></path><path d="M14 2H7a2 2 0 0 0-2 2"></path><path d="M19.29 14.76A6.67 6.67 0 0 1 17 11a6.6 6.6 0 0 1-2.29 3.76c-1.15.92-1.71 2.04-1.71 3.19 0 2.22 1.8 4.05 4 4.05s4-1.83 4-4.05c0-1.16-.57-2.26-1.71-3.19"></path><path d="M9.607 21H6a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h7V7a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"></path>',
		'sofa'                               => '<path d="M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3"></path><path d="M2 16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v1.5a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5V11a2 2 0 0 0-4 0z"></path><path d="M4 18v2"></path><path d="M20 18v2"></path><path d="M12 4v9"></path>',
		'solar-panel'                        => '<path d="M11 2h2"></path><path d="m14.28 14-4.56 8"></path><path d="m21 22-1.558-4H4.558"></path><path d="M3 10v2"></path><path d="M6.245 15.04A2 2 0 0 1 8 14h12a1 1 0 0 1 .864 1.505l-3.11 5.457A2 2 0 0 1 16 22H4a1 1 0 0 1-.863-1.506z"></path><path d="M7 2a4 4 0 0 1-4 4"></path><path d="m8.66 7.66 1.41 1.41"></path>',
		'soup'                               => '<path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"></path><path d="M7 21h10"></path><path d="M19.5 12 22 6"></path><path d="M16.25 3c.27.1.8.53.75 1.36-.06.83-.93 1.2-1 2.02-.05.78.34 1.24.73 1.62"></path><path d="M11.25 3c.27.1.8.53.74 1.36-.05.83-.93 1.2-.98 2.02-.06.78.33 1.24.72 1.62"></path><path d="M6.25 3c.27.1.8.53.75 1.36-.06.83-.93 1.2-1 2.02-.05.78.34 1.24.74 1.62"></path>',
		'space'                              => '<path d="M22 17v1c0 .5-.5 1-1 1H3c-.5 0-1-.5-1-1v-1"></path>',
		'spade'                              => '<path d="M12 18v4"></path><path d="M2 14.499a5.5 5.5 0 0 0 9.591 3.675.6.6 0 0 1 .818.001A5.5 5.5 0 0 0 22 14.5c0-2.29-1.5-4-3-5.5l-5.492-5.312a2 2 0 0 0-3-.02L5 8.999c-1.5 1.5-3 3.2-3 5.5"></path>',
		'sparkle'                            => '<path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>',
		'sparkles'                           => '<path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle>',
		'speaker'                            => '<rect width="16" height="20" x="4" y="2" rx="2"></rect><path d="M12 6h.01"></path><circle cx="12" cy="14" r="4"></circle><path d="M12 14h.01"></path>',
		'speech'                             => '<path d="M8.8 20v-4.1l1.9.2a2.3 2.3 0 0 0 2.164-2.1V8.3A5.37 5.37 0 0 0 2 8.25c0 2.8.656 3.054 1 4.55a5.77 5.77 0 0 1 .029 2.758L2 20"></path><path d="M19.8 17.8a7.5 7.5 0 0 0 .003-10.603"></path><path d="M17 15a3.5 3.5 0 0 0-.025-4.975"></path>',
		'spell-check-2'                      => '<path d="m6 16 6-12 6 12"></path><path d="M8 12h8"></path><path d="M4 21c1.1 0 1.1-1 2.3-1s1.1 1 2.3 1c1.1 0 1.1-1 2.3-1 1.1 0 1.1 1 2.3 1 1.1 0 1.1-1 2.3-1 1.1 0 1.1 1 2.3 1 1.1 0 1.1-1 2.3-1"></path>',
		'spell-check'                        => '<path d="m6 16 6-12 6 12"></path><path d="M8 12h8"></path><path d="m16 20 2 2 4-4"></path>',
		'spline-pointer'                     => '<path d="M12.034 12.681a.498.498 0 0 1 .647-.647l9 3.5a.5.5 0 0 1-.033.943l-3.444 1.068a1 1 0 0 0-.66.66l-1.067 3.443a.5.5 0 0 1-.943.033z"></path><path d="M5 17A12 12 0 0 1 17 5"></path><circle cx="19" cy="5" r="2"></circle><circle cx="5" cy="19" r="2"></circle>',
		'spline'                             => '<circle cx="19" cy="5" r="2"></circle><circle cx="5" cy="19" r="2"></circle><path d="M5 17A12 12 0 0 1 17 5"></path>',
		'split'                              => '<path d="M16 3h5v5"></path><path d="M8 3H3v5"></path><path d="M12 22v-8.3a4 4 0 0 0-1.172-2.872L3 3"></path><path d="m15 9 6-6"></path>',
		'spool'                              => '<path d="M17 13.44 4.442 17.082A2 2 0 0 0 4.982 21H19a2 2 0 0 0 .558-3.921l-1.115-.32A2 2 0 0 1 17 14.837V7.66"></path><path d="m7 10.56 12.558-3.642A2 2 0 0 0 19.018 3H5a2 2 0 0 0-.558 3.921l1.115.32A2 2 0 0 1 7 9.163v7.178"></path>',
		'spotlight'                          => '<path d="M15.295 19.562 16 22"></path><path d="m17 16 3.758 2.098"></path><path d="m19 12.5 3.026-.598"></path><path d="M7.61 6.3a3 3 0 0 0-3.92 1.3l-1.38 2.79a3 3 0 0 0 1.3 3.91l6.89 3.597a1 1 0 0 0 1.342-.447l3.106-6.211a1 1 0 0 0-.447-1.341z"></path><path d="M8 9V2"></path>',
		'spray-can'                          => '<path d="M3 3h.01"></path><path d="M7 5h.01"></path><path d="M11 7h.01"></path><path d="M3 7h.01"></path><path d="M7 9h.01"></path><path d="M3 11h.01"></path><rect width="4" height="4" x="15" y="5"></rect><path d="m19 9 2 2v10c0 .6-.4 1-1 1h-6c-.6 0-1-.4-1-1V11l2-2"></path><path d="m13 14 8-2"></path><path d="m13 19 8-2"></path>',
		'sprout'                             => '<path d="M14 9.536V7a4 4 0 0 1 4-4h1.5a.5.5 0 0 1 .5.5V5a4 4 0 0 1-4 4 4 4 0 0 0-4 4c0 2 1 3 1 5a5 5 0 0 1-1 3"></path><path d="M4 9a5 5 0 0 1 8 4 5 5 0 0 1-8-4"></path><path d="M5 21h14"></path>',
		'square-activity'                    => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M17 12h-2l-2 5-2-10-2 5H7"></path>',
		'square-arrow-down-left'             => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m16 8-8 8"></path><path d="M16 16H8V8"></path>',
		'square-arrow-down-right'            => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m8 8 8 8"></path><path d="M16 8v8H8"></path>',
		'square-arrow-down'                  => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M12 8v8"></path><path d="m8 12 4 4 4-4"></path>',
		'square-arrow-left'                  => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m12 8-4 4 4 4"></path><path d="M16 12H8"></path>',
		'square-arrow-out-down-left'         => '<path d="M13 21h6a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"></path><path d="m3 21 9-9"></path><path d="M9 21H3v-6"></path>',
		'square-arrow-out-down-right'        => '<path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6"></path><path d="m21 21-9-9"></path><path d="M21 15v6h-6"></path>',
		'square-arrow-out-up-left'           => '<path d="M13 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6"></path><path d="m3 3 9 9"></path><path d="M3 9V3h6"></path>',
		'square-arrow-out-up-right'          => '<path d="M21 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6"></path><path d="m21 3-9 9"></path><path d="M15 3h6v6"></path>',
		'square-arrow-right'                 => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M8 12h8"></path><path d="m12 16 4-4-4-4"></path>',
		'square-arrow-up-left'               => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M8 16V8h8"></path><path d="M16 16 8 8"></path>',
		'square-arrow-up-right'              => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M8 8h8v8"></path><path d="m8 16 8-8"></path>',
		'square-arrow-up'                    => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m16 12-4-4-4 4"></path><path d="M12 16V8"></path>',
		'square-asterisk'                    => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M12 8v8"></path><path d="m8.5 14 7-4"></path><path d="m8.5 10 7 4"></path>',
		'square-bottom-dashed-scissors'      => '<line x1="5" y1="3" x2="19" y2="3"></line><line x1="3" y1="5" x2="3" y2="19"></line><line x1="21" y1="5" x2="21" y2="19"></line><line x1="9" y1="21" x2="10" y2="21"></line><line x1="14" y1="21" x2="15" y2="21"></line><path d="M 3 5 A2 2 0 0 1 5 3"></path><path d="M 19 3 A2 2 0 0 1 21 5"></path><path d="M 5 21 A2 2 0 0 1 3 19"></path><path d="M 21 19 A2 2 0 0 1 19 21"></path><circle cx="8.5" cy="8.5" r="1.5"></circle><line x1="9.56066" y1="9.56066" x2="12" y2="12"></line><line x1="17" y1="17" x2="14.82" y2="14.82"></line><circle cx="8.5" cy="15.5" r="1.5"></circle><line x1="9.56066" y1="14.43934" x2="17" y2="7"></line>',
		'square-chart-gantt'                 => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 8h7"></path><path d="M8 12h6"></path><path d="M11 16h5"></path>',
		'square-check-big'                   => '<path d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344"></path><path d="m9 11 3 3L22 4"></path>',
		'square-check'                       => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m9 12 2 2 4-4"></path>',
		'square-chevron-down'                => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m16 10-4 4-4-4"></path>',
		'square-chevron-left'                => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m14 16-4-4 4-4"></path>',
		'square-chevron-right'               => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m10 8 4 4-4 4"></path>',
		'square-chevron-up'                  => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m8 14 4-4 4 4"></path>',
		'square-code'                        => '<path d="m10 9-3 3 3 3"></path><path d="m14 15 3-3-3-3"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'square-dashed-bottom-code'          => '<path d="M10 9.5 8 12l2 2.5"></path><path d="M14 21h1"></path><path d="m14 9.5 2 2.5-2 2.5"></path><path d="M5 21a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2"></path><path d="M9 21h1"></path>',
		'square-dashed-bottom'               => '<path d="M5 21a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2"></path><path d="M9 21h1"></path><path d="M14 21h1"></path>',
		'square-dashed-kanban'               => '<path d="M8 7v7"></path><path d="M12 7v4"></path><path d="M16 7v9"></path><path d="M5 3a2 2 0 0 0-2 2"></path><path d="M9 3h1"></path><path d="M14 3h1"></path><path d="M19 3a2 2 0 0 1 2 2"></path><path d="M21 9v1"></path><path d="M21 14v1"></path><path d="M21 19a2 2 0 0 1-2 2"></path><path d="M14 21h1"></path><path d="M9 21h1"></path><path d="M5 21a2 2 0 0 1-2-2"></path><path d="M3 14v1"></path><path d="M3 9v1"></path>',
		'square-dashed-mouse-pointer'        => '<path d="M12.034 12.681a.498.498 0 0 1 .647-.647l9 3.5a.5.5 0 0 1-.033.943l-3.444 1.068a1 1 0 0 0-.66.66l-1.067 3.443a.5.5 0 0 1-.943.033z"></path><path d="M5 3a2 2 0 0 0-2 2"></path><path d="M19 3a2 2 0 0 1 2 2"></path><path d="M5 21a2 2 0 0 1-2-2"></path><path d="M9 3h1"></path><path d="M9 21h2"></path><path d="M14 3h1"></path><path d="M3 9v1"></path><path d="M21 9v2"></path><path d="M3 14v1"></path>',
		'square-dashed-top-solid'            => '<path d="M14 21h1"></path><path d="M21 14v1"></path><path d="M21 19a2 2 0 0 1-2 2"></path><path d="M21 9v1"></path><path d="M3 14v1"></path><path d="M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"></path><path d="M3 9v1"></path><path d="M5 21a2 2 0 0 1-2-2"></path><path d="M9 21h1"></path>',
		'square-dashed'                      => '<path d="M5 3a2 2 0 0 0-2 2"></path><path d="M19 3a2 2 0 0 1 2 2"></path><path d="M21 19a2 2 0 0 1-2 2"></path><path d="M5 21a2 2 0 0 1-2-2"></path><path d="M9 3h1"></path><path d="M9 21h1"></path><path d="M14 3h1"></path><path d="M14 21h1"></path><path d="M3 9v1"></path><path d="M21 9v1"></path><path d="M3 14v1"></path><path d="M21 14v1"></path>',
		'square-divide'                      => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><line x1="8" x2="16" y1="12" y2="12"></line><line x1="12" x2="12" y1="16" y2="16"></line><line x1="12" x2="12" y1="8" y2="8"></line>',
		'square-dot'                         => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="12" cy="12" r="1"></circle>',
		'square-equal'                       => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7 10h10"></path><path d="M7 14h10"></path>',
		'square-function'                    => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="M9 17c2 0 2.8-1 2.8-2.8V10c0-2 1-3.3 3.2-3"></path><path d="M9 11.2h5.7"></path>',
		'square-kanban'                      => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M8 7v7"></path><path d="M12 7v4"></path><path d="M16 7v9"></path>',
		'square-library'                     => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7 7v10"></path><path d="M11 7v10"></path><path d="m15 7 2 10"></path>',
		'square-m'                           => '<path d="M8 16V8.5a.5.5 0 0 1 .9-.3l2.7 3.599a.5.5 0 0 0 .8 0l2.7-3.6a.5.5 0 0 1 .9.3V16"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'square-menu'                        => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7 8h10"></path><path d="M7 12h10"></path><path d="M7 16h10"></path>',
		'square-minus'                       => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M8 12h8"></path>',
		'square-mouse-pointer'               => '<path d="M12.034 12.681a.498.498 0 0 1 .647-.647l9 3.5a.5.5 0 0 1-.033.943l-3.444 1.068a1 1 0 0 0-.66.66l-1.067 3.443a.5.5 0 0 1-.943.033z"></path><path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6"></path>',
		'square-parking-off'                 => '<path d="M3.6 3.6A2 2 0 0 1 5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-.59 1.41"></path><path d="M3 8.7V19a2 2 0 0 0 2 2h10.3"></path><path d="m2 2 20 20"></path><path d="M13 13a3 3 0 1 0 0-6H9v2"></path><path d="M9 17v-2.3"></path>',
		'square-parking'                     => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 17V7h4a3 3 0 0 1 0 6H9"></path>',
		'square-pause'                       => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><line x1="10" x2="10" y1="15" y2="9"></line><line x1="14" x2="14" y1="15" y2="9"></line>',
		'square-pen'                         => '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>',
		'square-percent'                     => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m15 9-6 6"></path><path d="M9 9h.01"></path><path d="M15 15h.01"></path>',
		'square-pi'                          => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7 7h10"></path><path d="M10 7v10"></path><path d="M16 17a2 2 0 0 1-2-2V7"></path>',
		'square-pilcrow'                     => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M12 12H9.5a2.5 2.5 0 0 1 0-5H17"></path><path d="M12 7v10"></path><path d="M16 7v10"></path>',
		'square-play'                        => '<rect x="3" y="3" width="18" height="18" rx="2"></rect><path d="M9 9.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997A1 1 0 0 1 9 14.996z"></path>',
		'square-plus'                        => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M8 12h8"></path><path d="M12 8v8"></path>',
		'square-power'                       => '<path d="M12 7v4"></path><path d="M7.998 9.003a5 5 0 1 0 8-.005"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'square-radical'                     => '<path d="M7 12h2l2 5 2-10h4"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'square-round-corner'                => '<path d="M21 11a8 8 0 0 0-8-8"></path><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>',
		'square-scissors'                    => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><line x1="9.56066" y1="9.56066" x2="12" y2="12"></line><line x1="17" y1="17" x2="14.82" y2="14.82"></line><circle cx="8.5" cy="15.5" r="1.5"></circle><line x1="9.56066" y1="14.43934" x2="17" y2="7"></line>',
		'square-sigma'                       => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M16 8.9V7H8l4 5-4 5h8v-1.9"></path>',
		'square-slash'                       => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><line x1="9" x2="15" y1="15" y2="9"></line>',
		'square-split-horizontal'            => '<path d="M8 19H5c-1 0-2-1-2-2V7c0-1 1-2 2-2h3"></path><path d="M16 5h3c1 0 2 1 2 2v10c0 1-1 2-2 2h-3"></path><line x1="12" x2="12" y1="4" y2="20"></line>',
		'square-split-vertical'              => '<path d="M5 8V5c0-1 1-2 2-2h10c1 0 2 1 2 2v3"></path><path d="M19 16v3c0 1-1 2-2 2H7c-1 0-2-1-2-2v-3"></path><line x1="4" x2="20" y1="12" y2="12"></line>',
		'square-square'                      => '<rect x="3" y="3" width="18" height="18" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect>',
		'square-stack'                       => '<path d="M4 10c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2"></path><path d="M10 16c-1.1 0-2-.9-2-2v-4c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2"></path><rect width="8" height="8" x="14" y="14" rx="2"></rect>',
		'square-star'                        => '<path d="M11.035 7.69a1 1 0 0 1 1.909.024l.737 1.452a1 1 0 0 0 .737.535l1.634.256a1 1 0 0 1 .588 1.806l-1.172 1.168a1 1 0 0 0-.282.866l.259 1.613a1 1 0 0 1-1.541 1.134l-1.465-.75a1 1 0 0 0-.912 0l-1.465.75a1 1 0 0 1-1.539-1.133l.258-1.613a1 1 0 0 0-.282-.866l-1.156-1.153a1 1 0 0 1 .572-1.822l1.633-.256a1 1 0 0 0 .737-.535z"></path><rect x="3" y="3" width="18" height="18" rx="2"></rect>',
		'square-stop'                        => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><rect x="9" y="9" width="6" height="6" rx="1"></rect>',
		'square-terminal'                    => '<path d="m7 11 2-2-2-2"></path><path d="M11 13h4"></path><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>',
		'square-user-round'                  => '<path d="M18 21a6 6 0 0 0-12 0"></path><circle cx="12" cy="11" r="4"></circle><rect width="18" height="18" x="3" y="3" rx="2"></rect>',
		'square-user'                        => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="12" cy="10" r="3"></circle><path d="M7 21v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"></path>',
		'square-x'                           => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path>',
		'square'                             => '<rect width="18" height="18" x="3" y="3" rx="2"></rect>',
		'squares-exclude'                    => '<path d="M16 12v2a2 2 0 0 1-2 2H9a1 1 0 0 0-1 1v3a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2h0"></path><path d="M4 16a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v3a1 1 0 0 1-1 1h-5a2 2 0 0 0-2 2v2"></path>',
		'squares-intersect'                  => '<path d="M10 22a2 2 0 0 1-2-2"></path><path d="M14 2a2 2 0 0 1 2 2"></path><path d="M16 22h-2"></path><path d="M2 10V8"></path><path d="M2 4a2 2 0 0 1 2-2"></path><path d="M20 8a2 2 0 0 1 2 2"></path><path d="M22 14v2"></path><path d="M22 20a2 2 0 0 1-2 2"></path><path d="M4 16a2 2 0 0 1-2-2"></path><path d="M8 10a2 2 0 0 1 2-2h5a1 1 0 0 1 1 1v5a2 2 0 0 1-2 2H9a1 1 0 0 1-1-1z"></path><path d="M8 2h2"></path>',
		'squares-subtract'                   => '<path d="M10 22a2 2 0 0 1-2-2"></path><path d="M16 22h-2"></path><path d="M16 4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-5a2 2 0 0 1 2-2h5a1 1 0 0 0 1-1z"></path><path d="M20 8a2 2 0 0 1 2 2"></path><path d="M22 14v2"></path><path d="M22 20a2 2 0 0 1-2 2"></path>',
		'squares-unite'                      => '<path d="M4 16a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v3a1 1 0 0 0 1 1h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2v-3a1 1 0 0 0-1-1z"></path>',
		'squircle-dashed'                    => '<path d="M13.77 3.043a34 34 0 0 0-3.54 0"></path><path d="M13.771 20.956a33 33 0 0 1-3.541.001"></path><path d="M20.18 17.74c-.51 1.15-1.29 1.93-2.439 2.44"></path><path d="M20.18 6.259c-.51-1.148-1.291-1.929-2.44-2.438"></path><path d="M20.957 10.23a33 33 0 0 1 0 3.54"></path><path d="M3.043 10.23a34 34 0 0 0 .001 3.541"></path><path d="M6.26 20.179c-1.15-.508-1.93-1.29-2.44-2.438"></path><path d="M6.26 3.82c-1.149.51-1.93 1.291-2.44 2.44"></path>',
		'squircle'                           => '<path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9-9-1.8-9-9 1.8-9 9-9"></path>',
		'squirrel'                           => '<path d="M15.236 22a3 3 0 0 0-2.2-5"></path><path d="M16 20a3 3 0 0 1 3-3h1a2 2 0 0 0 2-2v-2a4 4 0 0 0-4-4V4"></path><path d="M18 13h.01"></path><path d="M18 6a4 4 0 0 0-4 4 7 7 0 0 0-7 7c0-5 4-5 4-10.5a4.5 4.5 0 1 0-9 0 2.5 2.5 0 0 0 5 0C7 10 3 11 3 17c0 2.8 2.2 5 5 5h10"></path>',
		'stamp'                              => '<path d="M14 13V8.5C14 7 15 7 15 5a3 3 0 0 0-6 0c0 2 1 2 1 3.5V13"></path><path d="M20 15.5a2.5 2.5 0 0 0-2.5-2.5h-11A2.5 2.5 0 0 0 4 15.5V17a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1z"></path><path d="M5 22h14"></path>',
		'star-half'                          => '<path d="M12 18.338a2.1 2.1 0 0 0-.987.244L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16l2.309-4.679A.53.53 0 0 1 12 2"></path>',
		'star-off'                           => '<path d="m10.344 4.688 1.181-2.393a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.237 3.152"></path><path d="m17.945 17.945.43 2.505a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a8 8 0 0 0 .4-.099"></path><path d="m2 2 20 20"></path>',
		'star'                               => '<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path>',
		'step-back'                          => '<path d="M13.971 4.285A2 2 0 0 1 17 6v12a2 2 0 0 1-3.029 1.715l-9.997-5.998a2 2 0 0 1-.003-3.432z"></path><path d="M21 20V4"></path>',
		'step-forward'                       => '<path d="M10.029 4.285A2 2 0 0 0 7 6v12a2 2 0 0 0 3.029 1.715l9.997-5.998a2 2 0 0 0 .003-3.432z"></path><path d="M3 4v16"></path>',
		'stethoscope'                        => '<path d="M11 2v2"></path><path d="M5 2v2"></path><path d="M5 3H4a2 2 0 0 0-2 2v4a6 6 0 0 0 12 0V5a2 2 0 0 0-2-2h-1"></path><path d="M8 15a6 6 0 0 0 12 0v-3"></path><circle cx="20" cy="10" r="2"></circle>',
		'sticker'                            => '<path d="M21 9a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 15 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z"></path><path d="M15 3v5a1 1 0 0 0 1 1h5"></path><path d="M8 13h.01"></path><path d="M16 13h.01"></path><path d="M10 16s.8 1 2 1c1.3 0 2-1 2-1"></path>',
		'sticky-note'                        => '<path d="M21 9a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 15 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z"></path><path d="M15 3v5a1 1 0 0 0 1 1h5"></path>',
		'stone'                              => '<path d="M11.264 2.205A4 4 0 0 0 6.42 4.211l-4 8a4 4 0 0 0 1.359 5.117l6 4a4 4 0 0 0 4.438 0l6-4a4 4 0 0 0 1.576-4.592l-2-6a4 4 0 0 0-2.53-2.53z"></path><path d="M11.99 22 14 12l7.822 3.184"></path><path d="M14 12 8.47 2.302"></path>',
		'store'                              => '<path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5"></path><path d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244"></path><path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05"></path>',
		'stretch-horizontal'                 => '<rect width="20" height="6" x="2" y="4" rx="2"></rect><rect width="20" height="6" x="2" y="14" rx="2"></rect>',
		'stretch-vertical'                   => '<rect width="6" height="20" x="4" y="2" rx="2"></rect><rect width="6" height="20" x="14" y="2" rx="2"></rect>',
		'strikethrough'                      => '<path d="M16 4H9a3 3 0 0 0-2.83 4"></path><path d="M14 12a4 4 0 0 1 0 8H6"></path><line x1="4" x2="20" y1="12" y2="12"></line>',
		'subscript'                          => '<path d="m4 5 8 8"></path><path d="m12 5-8 8"></path><path d="M20 19h-4c0-1.5.44-2 1.5-2.5S20 15.33 20 14c0-.47-.17-.93-.48-1.29a2.11 2.11 0 0 0-2.62-.44c-.42.24-.74.62-.9 1.07"></path>',
		'sun-dim'                            => '<circle cx="12" cy="12" r="4"></circle><path d="M12 4h.01"></path><path d="M20 12h.01"></path><path d="M12 20h.01"></path><path d="M4 12h.01"></path><path d="M17.657 6.343h.01"></path><path d="M17.657 17.657h.01"></path><path d="M6.343 17.657h.01"></path><path d="M6.343 6.343h.01"></path>',
		'sun-medium'                         => '<circle cx="12" cy="12" r="4"></circle><path d="M12 3v1"></path><path d="M12 20v1"></path><path d="M3 12h1"></path><path d="M20 12h1"></path><path d="m18.364 5.636-.707.707"></path><path d="m6.343 17.657-.707.707"></path><path d="m5.636 5.636.707.707"></path><path d="m17.657 17.657.707.707"></path>',
		'sun-moon'                           => '<path d="M12 2v2"></path><path d="M14.837 16.385a6 6 0 1 1-7.223-7.222c.624-.147.97.66.715 1.248a4 4 0 0 0 5.26 5.259c.589-.255 1.396.09 1.248.715"></path><path d="M16 12a4 4 0 0 0-4-4"></path><path d="m19 5-1.256 1.256"></path><path d="M20 12h2"></path>',
		'sun-snow'                           => '<path d="M10 21v-1"></path><path d="M10 4V3"></path><path d="M10 9a3 3 0 0 0 0 6"></path><path d="m14 20 1.25-2.5L18 18"></path><path d="m14 4 1.25 2.5L18 6"></path><path d="m17 21-3-6 1.5-3H22"></path><path d="m17 3-3 6 1.5 3"></path><path d="M2 12h1"></path><path d="m20 10-1.5 2 1.5 2"></path><path d="m3.64 18.36.7-.7"></path><path d="m4.34 6.34-.7-.7"></path>',
		'sun'                                => '<circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path>',
		'sunrise'                            => '<path d="M12 2v8"></path><path d="m4.93 10.93 1.41 1.41"></path><path d="M2 18h2"></path><path d="M20 18h2"></path><path d="m19.07 10.93-1.41 1.41"></path><path d="M22 22H2"></path><path d="m8 6 4-4 4 4"></path><path d="M16 18a4 4 0 0 0-8 0"></path>',
		'sunset'                             => '<path d="M12 10V2"></path><path d="m4.93 10.93 1.41 1.41"></path><path d="M2 18h2"></path><path d="M20 18h2"></path><path d="m19.07 10.93-1.41 1.41"></path><path d="M22 22H2"></path><path d="m16 6-4 4-4-4"></path><path d="M16 18a4 4 0 0 0-8 0"></path>',
		'superscript'                        => '<path d="m4 19 8-8"></path><path d="m12 19-8-8"></path><path d="M20 12h-4c0-1.5.442-2 1.5-2.5S20 8.334 20 7.002c0-.472-.17-.93-.484-1.29a2.105 2.105 0 0 0-2.617-.436c-.42.239-.738.614-.899 1.06"></path>',
		'swatch-book'                        => '<path d="M11 17a4 4 0 0 1-8 0V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2Z"></path><path d="M16.7 13H19a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H7"></path><path d="M 7 17h.01"></path><path d="m11 8 2.3-2.3a2.4 2.4 0 0 1 3.404.004L18.6 7.6a2.4 2.4 0 0 1 .026 3.434L9.9 19.8"></path>',
		'swiss-franc'                        => '<path d="M10 21V3h8"></path><path d="M6 16h9"></path><path d="M10 9.5h7"></path>',
		'switch-camera'                      => '<path d="M11 19H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h5"></path><path d="M13 5h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-5"></path><circle cx="12" cy="12" r="3"></circle><path d="m18 22-3-3 3-3"></path><path d="m6 2 3 3-3 3"></path>',
		'sword'                              => '<path d="m11 19-6-6"></path><path d="m5 21-2-2"></path><path d="m8 16-4 4"></path><path d="M9.5 17.5 21 6V3h-3L6.5 14.5"></path>',
		'swords'                             => '<polyline points="14.5 17.5 3 6 3 3 6 3 17.5 14.5"></polyline><line x1="13" x2="19" y1="19" y2="13"></line><line x1="16" x2="20" y1="16" y2="20"></line><line x1="19" x2="21" y1="21" y2="19"></line><polyline points="14.5 6.5 18 3 21 3 21 6 17.5 9.5"></polyline><line x1="5" x2="9" y1="14" y2="18"></line><line x1="7" x2="4" y1="17" y2="20"></line><line x1="3" x2="5" y1="19" y2="21"></line>',
		'syringe'                            => '<path d="m18 2 4 4"></path><path d="m17 7 3-3"></path><path d="M19 9 8.7 19.3c-1 1-2.5 1-3.4 0l-.6-.6c-1-1-1-2.5 0-3.4L15 5"></path><path d="m9 11 4 4"></path><path d="m5 19-3 3"></path><path d="m14 4 6 6"></path>',
		'table-2'                            => '<path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"></path>',
		'table-cells-merge'                  => '<path d="M12 21v-6"></path><path d="M12 9V3"></path><path d="M3 15h18"></path><path d="M3 9h18"></path><rect width="18" height="18" x="3" y="3" rx="2"></rect>',
		'table-cells-split'                  => '<path d="M12 15V9"></path><path d="M3 15h18"></path><path d="M3 9h18"></path><rect width="18" height="18" x="3" y="3" rx="2"></rect>',
		'table-columns-split'                => '<path d="M14 14v2"></path><path d="M14 20v2"></path><path d="M14 2v2"></path><path d="M14 8v2"></path><path d="M2 15h8"></path><path d="M2 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H2"></path><path d="M2 9h8"></path><path d="M22 15h-4"></path><path d="M22 3h-2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h2"></path><path d="M22 9h-4"></path><path d="M5 3v18"></path>',
		'table-of-contents'                  => '<path d="M16 5H3"></path><path d="M16 12H3"></path><path d="M16 19H3"></path><path d="M21 5h.01"></path><path d="M21 12h.01"></path><path d="M21 19h.01"></path>',
		'table-properties'                   => '<path d="M15 3v18"></path><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M21 9H3"></path><path d="M21 15H3"></path>',
		'table-rows-split'                   => '<path d="M14 10h2"></path><path d="M15 22v-8"></path><path d="M15 2v4"></path><path d="M2 10h2"></path><path d="M20 10h2"></path><path d="M3 19h18"></path><path d="M3 22v-6a2 2 135 0 1 2-2h14a2 2 45 0 1 2 2v6"></path><path d="M3 2v2a2 2 45 0 0 2 2h14a2 2 135 0 0 2-2V2"></path><path d="M8 10h2"></path><path d="M9 22v-8"></path><path d="M9 2v4"></path>',
		'table'                              => '<path d="M12 3v18"></path><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M3 15h18"></path>',
		'tablet-smartphone'                  => '<rect width="10" height="14" x="3" y="8" rx="2"></rect><path d="M5 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2h-2.4"></path><path d="M8 18h.01"></path>',
		'tablet'                             => '<rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><line x1="12" x2="12.01" y1="18" y2="18"></line>',
		'tablets'                            => '<circle cx="7" cy="7" r="5"></circle><circle cx="17" cy="17" r="5"></circle><path d="M12 17h10"></path><path d="m3.46 10.54 7.08-7.08"></path>',
		'tag'                                => '<path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"></path><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"></circle>',
		'tags'                               => '<path d="M13.172 2a2 2 0 0 1 1.414.586l6.71 6.71a2.4 2.4 0 0 1 0 3.408l-4.592 4.592a2.4 2.4 0 0 1-3.408 0l-6.71-6.71A2 2 0 0 1 6 9.172V3a1 1 0 0 1 1-1z"></path><path d="M2 7v6.172a2 2 0 0 0 .586 1.414l6.71 6.71a2.4 2.4 0 0 0 3.191.193"></path><circle cx="10.5" cy="6.5" r=".5" fill="currentColor"></circle>',
		'tally-1'                            => '<path d="M4 4v16"></path>',
		'tally-2'                            => '<path d="M4 4v16"></path><path d="M9 4v16"></path>',
		'tally-3'                            => '<path d="M4 4v16"></path><path d="M9 4v16"></path><path d="M14 4v16"></path>',
		'tally-4'                            => '<path d="M4 4v16"></path><path d="M9 4v16"></path><path d="M14 4v16"></path><path d="M19 4v16"></path>',
		'tally-5'                            => '<path d="M4 4v16"></path><path d="M9 4v16"></path><path d="M14 4v16"></path><path d="M19 4v16"></path><path d="M22 6 2 18"></path>',
		'tangent'                            => '<circle cx="17" cy="4" r="2"></circle><path d="M15.59 5.41 5.41 15.59"></path><circle cx="4" cy="17" r="2"></circle><path d="M12 22s-4-9-1.5-11.5S22 12 22 12"></path>',
		'target'                             => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle>',
		'telescope'                          => '<path d="m10.065 12.493-6.18 1.318a.934.934 0 0 1-1.108-.702l-.537-2.15a1.07 1.07 0 0 1 .691-1.265l13.504-4.44"></path><path d="m13.56 11.747 4.332-.924"></path><path d="m16 21-3.105-6.21"></path><path d="M16.485 5.94a2 2 0 0 1 1.455-2.425l1.09-.272a1 1 0 0 1 1.212.727l1.515 6.06a1 1 0 0 1-.727 1.213l-1.09.272a2 2 0 0 1-2.425-1.455z"></path><path d="m6.158 8.633 1.114 4.456"></path><path d="m8 21 3.105-6.21"></path><circle cx="12" cy="13" r="2"></circle>',
		'tent-tree'                          => '<circle cx="4" cy="4" r="2"></circle><path d="m14 5 3-3 3 3"></path><path d="m14 10 3-3 3 3"></path><path d="M17 14V2"></path><path d="M17 14H7l-5 8h20Z"></path><path d="M8 14v8"></path><path d="m9 14 5 8"></path>',
		'tent'                               => '<path d="M3.5 21 14 3"></path><path d="M20.5 21 10 3"></path><path d="M15.5 21 12 15l-3.5 6"></path><path d="M2 21h20"></path>',
		'terminal'                           => '<path d="M12 19h8"></path><path d="m4 17 6-6-6-6"></path>',
		'test-tube-diagonal'                 => '<path d="M21 7 6.82 21.18a2.83 2.83 0 0 1-3.99-.01a2.83 2.83 0 0 1 0-4L17 3"></path><path d="m16 2 6 6"></path><path d="M12 16H4"></path>',
		'test-tube'                          => '<path d="M14.5 2v17.5c0 1.4-1.1 2.5-2.5 2.5c-1.4 0-2.5-1.1-2.5-2.5V2"></path><path d="M8.5 2h7"></path><path d="M14.5 16h-5"></path>',
		'test-tubes'                         => '<path d="M9 2v17.5A2.5 2.5 0 0 1 6.5 22A2.5 2.5 0 0 1 4 19.5V2"></path><path d="M20 2v17.5a2.5 2.5 0 0 1-2.5 2.5a2.5 2.5 0 0 1-2.5-2.5V2"></path><path d="M3 2h7"></path><path d="M14 2h7"></path><path d="M9 16H4"></path><path d="M20 16h-5"></path>',
		'text-align-center'                  => '<path d="M21 5H3"></path><path d="M17 12H7"></path><path d="M19 19H5"></path>',
		'text-align-end'                     => '<path d="M21 5H3"></path><path d="M21 12H9"></path><path d="M21 19H7"></path>',
		'text-align-justify'                 => '<path d="M3 5h18"></path><path d="M3 12h18"></path><path d="M3 19h18"></path>',
		'text-align-start'                   => '<path d="M21 5H3"></path><path d="M15 12H3"></path><path d="M17 19H3"></path>',
		'text-cursor-input'                  => '<path d="M12 20h-1a2 2 0 0 1-2-2 2 2 0 0 1-2 2H6"></path><path d="M13 8h7a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-7"></path><path d="M5 16H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h1"></path><path d="M6 4h1a2 2 0 0 1 2 2 2 2 0 0 1 2-2h1"></path><path d="M9 6v12"></path>',
		'text-cursor'                        => '<path d="M17 22h-1a4 4 0 0 1-4-4V6a4 4 0 0 1 4-4h1"></path><path d="M7 22h1a4 4 0 0 0 4-4v-1"></path><path d="M7 2h1a4 4 0 0 1 4 4v1"></path>',
		'text-initial'                       => '<path d="M15 5h6"></path><path d="M15 12h6"></path><path d="M3 19h18"></path><path d="m3 12 3.553-7.724a.5.5 0 0 1 .894 0L11 12"></path><path d="M3.92 10h6.16"></path>',
		'text-quote'                         => '<path d="M17 5H3"></path><path d="M21 12H8"></path><path d="M21 19H8"></path><path d="M3 12v7"></path>',
		'text-search'                        => '<path d="M21 5H3"></path><path d="M10 12H3"></path><path d="M10 19H3"></path><circle cx="17" cy="15" r="3"></circle><path d="m21 19-1.9-1.9"></path>',
		'text-select'                        => '<path d="M14 21h1"></path><path d="M14 3h1"></path><path d="M19 3a2 2 0 0 1 2 2"></path><path d="M21 14v1"></path><path d="M21 19a2 2 0 0 1-2 2"></path><path d="M21 9v1"></path><path d="M3 14v1"></path><path d="M3 9v1"></path><path d="M5 21a2 2 0 0 1-2-2"></path><path d="M5 3a2 2 0 0 0-2 2"></path><path d="M7 12h10"></path><path d="M7 16h6"></path><path d="M7 8h8"></path><path d="M9 21h1"></path><path d="M9 3h1"></path>',
		'text-wrap'                          => '<path d="m16 16-3 3 3 3"></path><path d="M3 12h14.5a1 1 0 0 1 0 7H13"></path><path d="M3 19h6"></path><path d="M3 5h18"></path>',
		'theater'                            => '<path d="M2 10s3-3 3-8"></path><path d="M22 10s-3-3-3-8"></path><path d="M10 2c0 4.4-3.6 8-8 8"></path><path d="M14 2c0 4.4 3.6 8 8 8"></path><path d="M2 10s2 2 2 5"></path><path d="M22 10s-2 2-2 5"></path><path d="M8 15h8"></path><path d="M2 22v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1"></path><path d="M14 22v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1"></path>',
		'thermometer-snowflake'              => '<path d="m10 20-1.25-2.5L6 18"></path><path d="M10 4 8.75 6.5 6 6"></path><path d="M10.585 15H10"></path><path d="M2 12h6.5L10 9"></path><path d="M20 14.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0z"></path><path d="m4 10 1.5 2L4 14"></path><path d="m7 21 3-6-1.5-3"></path><path d="m7 3 3 6h2"></path>',
		'thermometer-sun'                    => '<path d="M12 2v2"></path><path d="M12 8a4 4 0 0 0-1.645 7.647"></path><path d="M2 12h2"></path><path d="M20 14.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0z"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m6.34 17.66-1.41 1.41"></path>',
		'thermometer'                        => '<path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"></path>',
		'thumbs-down'                        => '<path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z"></path><path d="M17 14V2"></path>',
		'thumbs-up'                          => '<path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"></path><path d="M7 10v12"></path>',
		'ticket-check'                       => '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="m9 12 2 2 4-4"></path>',
		'ticket-minus'                       => '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M9 12h6"></path>',
		'ticket-percent'                     => '<path d="M2 9a3 3 0 1 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 1 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M9 9h.01"></path><path d="m15 9-6 6"></path><path d="M15 15h.01"></path>',
		'ticket-plus'                        => '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M9 12h6"></path><path d="M12 9v6"></path>',
		'ticket-slash'                       => '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="m9.5 14.5 5-5"></path>',
		'ticket-x'                           => '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="m9.5 14.5 5-5"></path><path d="m9.5 9.5 5 5"></path>',
		'ticket'                             => '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path>',
		'tickets-plane'                      => '<path d="M10.5 17h1.227a2 2 0 0 0 1.345-.52L18 12"></path><path d="m12 13.5 3.794.506"></path><path d="m3.173 8.18 11-5a2 2 0 0 1 2.647.993L18.56 8"></path><path d="M6 10V8"></path><path d="M6 14v1"></path><path d="M6 19v2"></path><rect x="2" y="8" width="20" height="13" rx="2"></rect>',
		'tickets'                            => '<path d="m3.173 8.18 11-5a2 2 0 0 1 2.647.993L18.56 8"></path><path d="M6 10V8"></path><path d="M6 14v1"></path><path d="M6 19v2"></path><rect x="2" y="8" width="20" height="13" rx="2"></rect>',
		'timer-off'                          => '<path d="M10 2h4"></path><path d="M4.6 11a8 8 0 0 0 1.7 8.7 8 8 0 0 0 8.7 1.7"></path><path d="M7.4 7.4a8 8 0 0 1 10.3 1 8 8 0 0 1 .9 10.2"></path><path d="m2 2 20 20"></path><path d="M12 12v-2"></path>',
		'timer-reset'                        => '<path d="M10 2h4"></path><path d="M12 14v-4"></path><path d="M4 13a8 8 0 0 1 8-7 8 8 0 1 1-5.3 14L4 17.6"></path><path d="M9 17H4v5"></path>',
		'timer'                              => '<line x1="10" x2="14" y1="2" y2="2"></line><line x1="12" x2="15" y1="14" y2="11"></line><circle cx="12" cy="14" r="8"></circle>',
		'toggle-left'                        => '<circle cx="9" cy="12" r="3"></circle><rect width="20" height="14" x="2" y="5" rx="7"></rect>',
		'toggle-right'                       => '<circle cx="15" cy="12" r="3"></circle><rect width="20" height="14" x="2" y="5" rx="7"></rect>',
		'toilet'                             => '<path d="M7 12h13a1 1 0 0 1 1 1 5 5 0 0 1-5 5h-.598a.5.5 0 0 0-.424.765l1.544 2.47a.5.5 0 0 1-.424.765H5.402a.5.5 0 0 1-.424-.765L7 18"></path><path d="M8 18a5 5 0 0 1-5-5V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8"></path>',
		'tool-case'                          => '<path d="M10 15h4"></path><path d="m14.817 10.995-.971-1.45 1.034-1.232a2 2 0 0 0-2.025-3.238l-1.82.364L9.91 3.885a2 2 0 0 0-3.625.748L6.141 6.55l-1.725.426a2 2 0 0 0-.19 3.756l.657.27"></path><path d="m18.822 10.995 2.26-5.38a1 1 0 0 0-.557-1.318L16.954 2.9a1 1 0 0 0-1.281.533l-.924 2.122"></path><path d="M4 12.006A1 1 0 0 1 4.994 11H19a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path>',
		'toolbox'                            => '<path d="M16 12v4"></path><path d="M16 6a2 2 0 0 1 1.414.586l4 4A2 2 0 0 1 22 12v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 .586-1.414l4-4A2 2 0 0 1 8 6z"></path><path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path><path d="M2 14h20"></path><path d="M8 12v4"></path>',
		'tornado'                            => '<path d="M21 4H3"></path><path d="M18 8H6"></path><path d="M19 12H9"></path><path d="M16 16h-6"></path><path d="M11 20H9"></path>',
		'torus'                              => '<ellipse cx="12" cy="11" rx="3" ry="2"></ellipse><ellipse cx="12" cy="12.5" rx="10" ry="8.5"></ellipse>',
		'touchpad-off'                       => '<path d="M12 20v-6"></path><path d="M19.656 14H22"></path><path d="M2 14h12"></path><path d="m2 2 20 20"></path><path d="M20 20H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2"></path><path d="M9.656 4H20a2 2 0 0 1 2 2v10.344"></path>',
		'touchpad'                           => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="M2 14h20"></path><path d="M12 20v-6"></path>',
		'tower-control'                      => '<path d="M18.2 12.27 20 6H4l1.8 6.27a1 1 0 0 0 .95.73h10.5a1 1 0 0 0 .96-.73Z"></path><path d="M8 13v9"></path><path d="M16 22v-9"></path><path d="m9 6 1 7"></path><path d="m15 6-1 7"></path><path d="M12 6V2"></path><path d="M13 2h-2"></path>',
		'toy-brick'                          => '<rect width="18" height="12" x="3" y="8" rx="1"></rect><path d="M10 8V5c0-.6-.4-1-1-1H6a1 1 0 0 0-1 1v3"></path><path d="M19 8V5c0-.6-.4-1-1-1h-3a1 1 0 0 0-1 1v3"></path>',
		'tractor'                            => '<path d="m10 11 11 .9a1 1 0 0 1 .8 1.1l-.665 4.158a1 1 0 0 1-.988.842H20"></path><path d="M16 18h-5"></path><path d="M18 5a1 1 0 0 0-1 1v5.573"></path><path d="M3 4h8.129a1 1 0 0 1 .99.863L13 11.246"></path><path d="M4 11V4"></path><path d="M7 15h.01"></path><path d="M8 10.1V4"></path><circle cx="18" cy="18" r="2"></circle><circle cx="7" cy="15" r="5"></circle>',
		'traffic-cone'                       => '<path d="M16.05 10.966a5 2.5 0 0 1-8.1 0"></path><path d="m16.923 14.049 4.48 2.04a1 1 0 0 1 .001 1.831l-8.574 3.9a2 2 0 0 1-1.66 0l-8.574-3.91a1 1 0 0 1 0-1.83l4.484-2.04"></path><path d="M16.949 14.14a5 2.5 0 1 1-9.9 0L10.063 3.5a2 2 0 0 1 3.874 0z"></path><path d="M9.194 6.57a5 2.5 0 0 0 5.61 0"></path>',
		'train-front-tunnel'                 => '<path d="M2 22V12a10 10 0 1 1 20 0v10"></path><path d="M15 6.8v1.4a3 2.8 0 1 1-6 0V6.8"></path><path d="M10 15h.01"></path><path d="M14 15h.01"></path><path d="M10 19a4 4 0 0 1-4-4v-3a6 6 0 1 1 12 0v3a4 4 0 0 1-4 4Z"></path><path d="m9 19-2 3"></path><path d="m15 19 2 3"></path>',
		'train-front'                        => '<path d="M8 3.1V7a4 4 0 0 0 8 0V3.1"></path><path d="m9 15-1-1"></path><path d="m15 15 1-1"></path><path d="M9 19c-2.8 0-5-2.2-5-5v-4a8 8 0 0 1 16 0v4c0 2.8-2.2 5-5 5Z"></path><path d="m8 19-2 3"></path><path d="m16 19 2 3"></path>',
		'train-track'                        => '<path d="M2 17 17 2"></path><path d="m2 14 8 8"></path><path d="m5 11 8 8"></path><path d="m8 8 8 8"></path><path d="m11 5 8 8"></path><path d="m14 2 8 8"></path><path d="M7 22 22 7"></path>',
		'tram-front'                         => '<rect width="16" height="16" x="4" y="3" rx="2"></rect><path d="M4 11h16"></path><path d="M12 3v8"></path><path d="m8 19-2 3"></path><path d="m18 22-2-3"></path><path d="M8 15h.01"></path><path d="M16 15h.01"></path>',
		'transgender'                        => '<path d="M12 16v6"></path><path d="M14 20h-4"></path><path d="M18 2h4v4"></path><path d="m2 2 7.17 7.17"></path><path d="M2 5.355V2h3.357"></path><path d="m22 2-7.17 7.17"></path><path d="M8 5 5 8"></path><circle cx="12" cy="12" r="4"></circle>',
		'trash-2'                            => '<path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path><path d="M3 6h18"></path><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>',
		'trash'                              => '<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path><path d="M3 6h18"></path><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>',
		'tree-deciduous'                     => '<path d="M8 19a4 4 0 0 1-2.24-7.32A3.5 3.5 0 0 1 9 6.03V6a3 3 0 1 1 6 0v.04a3.5 3.5 0 0 1 3.24 5.65A4 4 0 0 1 16 19Z"></path><path d="M12 19v3"></path>',
		'tree-palm'                          => '<path d="M13 8c0-2.76-2.46-5-5.5-5S2 5.24 2 8h2l1-1 1 1h4"></path><path d="M13 7.14A5.82 5.82 0 0 1 16.5 6c3.04 0 5.5 2.24 5.5 5h-3l-1-1-1 1h-3"></path><path d="M5.89 9.71c-2.15 2.15-2.3 5.47-.35 7.43l4.24-4.25.7-.7.71-.71 2.12-2.12c-1.95-1.96-5.27-1.8-7.42.35"></path><path d="M11 15.5c.5 2.5-.17 4.5-1 6.5h4c2-5.5-.5-12-1-14"></path>',
		'tree-pine'                          => '<path d="m17 14 3 3.3a1 1 0 0 1-.7 1.7H4.7a1 1 0 0 1-.7-1.7L7 14h-.3a1 1 0 0 1-.7-1.7L9 9h-.2A1 1 0 0 1 8 7.3L12 3l4 4.3a1 1 0 0 1-.8 1.7H15l3 3.3a1 1 0 0 1-.7 1.7H17Z"></path><path d="M12 22v-3"></path>',
		'trees'                              => '<path d="M10 10v.2A3 3 0 0 1 8.9 16H5a3 3 0 0 1-1-5.8V10a3 3 0 0 1 6 0Z"></path><path d="M7 16v6"></path><path d="M13 19v3"></path><path d="M12 19h8.3a1 1 0 0 0 .7-1.7L18 14h.3a1 1 0 0 0 .7-1.7L16 9h.2a1 1 0 0 0 .8-1.7L13 3l-1.4 1.5"></path>',
		'trello'                             => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><rect width="3" height="9" x="7" y="7"></rect><rect width="3" height="5" x="14" y="7"></rect>',
		'trending-down'                      => '<path d="M16 17h6v-6"></path><path d="m22 17-8.5-8.5-5 5L2 7"></path>',
		'trending-up-down'                   => '<path d="M14.828 14.828 21 21"></path><path d="M21 16v5h-5"></path><path d="m21 3-9 9-4-4-6 6"></path><path d="M21 8V3h-5"></path>',
		'trending-up'                        => '<path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path>',
		'triangle-alert'                     => '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path>',
		'triangle-dashed'                    => '<path d="M10.17 4.193a2 2 0 0 1 3.666.013"></path><path d="M14 21h2"></path><path d="m15.874 7.743 1 1.732"></path><path d="m18.849 12.952 1 1.732"></path><path d="M21.824 18.18a2 2 0 0 1-1.835 2.824"></path><path d="M4.024 21a2 2 0 0 1-1.839-2.839"></path><path d="m5.136 12.952-1 1.732"></path><path d="M8 21h2"></path><path d="m8.102 7.743-1 1.732"></path>',
		'triangle-right'                     => '<path d="M22 18a2 2 0 0 1-2 2H3c-1.1 0-1.3-.6-.4-1.3L20.4 4.3c.9-.7 1.6-.4 1.6.7Z"></path>',
		'triangle'                           => '<path d="M13.73 4a2 2 0 0 0-3.46 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>',
		'trophy'                             => '<path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"></path><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"></path><path d="M18 9h1.5a1 1 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"></path><path d="M6 9H4.5a1 1 0 0 1 0-5H6"></path>',
		'truck-electric'                     => '<path d="M14 19V7a2 2 0 0 0-2-2H9"></path><path d="M15 19H9"></path><path d="M19 19h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62L18.3 9.38a1 1 0 0 0-.78-.38H14"></path><path d="M2 13v5a1 1 0 0 0 1 1h2"></path><path d="M4 3 2.15 5.15a.495.495 0 0 0 .35.86h2.15a.47.47 0 0 1 .35.86L3 9.02"></path><circle cx="17" cy="19" r="2"></circle><circle cx="7" cy="19" r="2"></circle>',
		'truck'                              => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M15 18H9"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle>',
		'turkish-lira'                       => '<path d="M15 4 5 9"></path><path d="m15 8.5-10 5"></path><path d="M18 12a9 9 0 0 1-9 9V3"></path>',
		'turntable'                          => '<path d="M10 12.01h.01"></path><path d="M18 8v4a8 8 0 0 1-1.07 4"></path><circle cx="10" cy="12" r="4"></circle><rect x="2" y="4" width="20" height="16" rx="2"></rect>',
		'turtle'                             => '<path d="m12 10 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a8 8 0 1 0-16 0v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3l2-4h4Z"></path><path d="M4.82 7.9 8 10"></path><path d="M15.18 7.9 12 10"></path><path d="M16.93 10H20a2 2 0 0 1 0 4H2"></path>',
		'tv-minimal-play'                    => '<path d="M15.033 9.44a.647.647 0 0 1 0 1.12l-4.065 2.352a.645.645 0 0 1-.968-.56V7.648a.645.645 0 0 1 .967-.56z"></path><path d="M7 21h10"></path><rect width="20" height="14" x="2" y="3" rx="2"></rect>',
		'tv-minimal'                         => '<path d="M7 21h10"></path><rect width="20" height="14" x="2" y="3" rx="2"></rect>',
		'tv'                                 => '<path d="m17 2-5 5-5-5"></path><rect width="20" height="15" x="2" y="7" rx="2"></rect>',
		'twitch'                             => '<path d="M21 2H3v16h5v4l4-4h5l4-4V2zm-10 9V7m5 4V7"></path>',
		'twitter'                            => '<path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>',
		'type-outline'                       => '<path d="M14 16.5a.5.5 0 0 0 .5.5h.5a2 2 0 0 1 0 4H9a2 2 0 0 1 0-4h.5a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5V8a2 2 0 0 1-4 0V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v3a2 2 0 0 1-4 0v-.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5Z"></path>',
		'type'                               => '<path d="M12 4v16"></path><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path><path d="M9 20h6"></path>',
		'umbrella-off'                       => '<path d="M12 13v7a2 2 0 0 0 4 0"></path><path d="M12 2v2"></path><path d="M18.656 13h2.336a1 1 0 0 0 .97-1.274 10.284 10.284 0 0 0-12.07-7.51"></path><path d="m2 2 20 20"></path><path d="M5.961 5.957a10.28 10.28 0 0 0-3.922 5.769A1 1 0 0 0 3 13h10"></path>',
		'umbrella'                           => '<path d="M12 13v7a2 2 0 0 0 4 0"></path><path d="M12 2v2"></path><path d="M20.992 13a1 1 0 0 0 .97-1.274 10.284 10.284 0 0 0-19.923 0A1 1 0 0 0 3 13z"></path>',
		'underline'                          => '<path d="M6 4v6a6 6 0 0 0 12 0V4"></path><line x1="4" x2="20" y1="20" y2="20"></line>',
		'undo-2'                             => '<path d="M9 14 4 9l5-5"></path><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11"></path>',
		'undo-dot'                           => '<path d="M21 17a9 9 0 0 0-15-6.7L3 13"></path><path d="M3 7v6h6"></path><circle cx="12" cy="17" r="1"></circle>',
		'undo'                               => '<path d="M3 7v6h6"></path><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"></path>',
		'unfold-horizontal'                  => '<path d="M16 12h6"></path><path d="M8 12H2"></path><path d="M12 2v2"></path><path d="M12 8v2"></path><path d="M12 14v2"></path><path d="M12 20v2"></path><path d="m19 15 3-3-3-3"></path><path d="m5 9-3 3 3 3"></path>',
		'unfold-vertical'                    => '<path d="M12 22v-6"></path><path d="M12 8V2"></path><path d="M4 12H2"></path><path d="M10 12H8"></path><path d="M16 12h-2"></path><path d="M22 12h-2"></path><path d="m15 19-3 3-3-3"></path><path d="m15 5-3-3-3 3"></path>',
		'ungroup'                            => '<rect width="8" height="6" x="5" y="4" rx="1"></rect><rect width="8" height="6" x="11" y="14" rx="1"></rect>',
		'university'                         => '<path d="M14 21v-3a2 2 0 0 0-4 0v3"></path><path d="M18 12h.01"></path><path d="M18 16h.01"></path><path d="M22 7a1 1 0 0 0-1-1h-2a2 2 0 0 1-1.143-.359L13.143 2.36a2 2 0 0 0-2.286-.001L6.143 5.64A2 2 0 0 1 5 6H3a1 1 0 0 0-1 1v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2z"></path><path d="M6 12h.01"></path><path d="M6 16h.01"></path><circle cx="12" cy="10" r="2"></circle>',
		'unlink-2'                           => '<path d="M15 7h2a5 5 0 0 1 0 10h-2m-6 0H7A5 5 0 0 1 7 7h2"></path>',
		'unlink'                             => '<path d="m18.84 12.25 1.72-1.71h-.02a5.004 5.004 0 0 0-.12-7.07 5.006 5.006 0 0 0-6.95 0l-1.72 1.71"></path><path d="m5.17 11.75-1.71 1.71a5.004 5.004 0 0 0 .12 7.07 5.006 5.006 0 0 0 6.95 0l1.71-1.71"></path><line x1="8" x2="8" y1="2" y2="5"></line><line x1="2" x2="5" y1="8" y2="8"></line><line x1="16" x2="16" y1="19" y2="22"></line><line x1="19" x2="22" y1="16" y2="16"></line>',
		'unplug'                             => '<path d="m19 5 3-3"></path><path d="m2 22 3-3"></path><path d="M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z"></path><path d="M7.5 13.5 10 11"></path><path d="M10.5 16.5 13 14"></path><path d="m12 6 6 6 2.3-2.3a2.4 2.4 0 0 0 0-3.4l-2.6-2.6a2.4 2.4 0 0 0-3.4 0Z"></path>',
		'upload'                             => '<path d="M12 3v12"></path><path d="m17 8-5-5-5 5"></path><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>',
		'usb'                                => '<circle cx="10" cy="7" r="1"></circle><circle cx="4" cy="20" r="1"></circle><path d="M4.7 19.3 19 5"></path><path d="m21 3-3 1 2 2Z"></path><path d="M9.26 7.68 5 12l2 5"></path><path d="m10 14 5 2 3.5-3.5"></path><path d="m18 12 1-1 1 1-1 1Z"></path>',
		'user-check'                         => '<path d="m16 11 2 2 4-4"></path><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle>',
		'user-cog'                           => '<path d="M10 15H6a4 4 0 0 0-4 4v2"></path><path d="m14.305 16.53.923-.382"></path><path d="m15.228 13.852-.923-.383"></path><path d="m16.852 12.228-.383-.923"></path><path d="m16.852 17.772-.383.924"></path><path d="m19.148 12.228.383-.923"></path><path d="m19.53 18.696-.382-.924"></path><path d="m20.772 13.852.924-.383"></path><path d="m20.772 16.148.924.383"></path><circle cx="18" cy="15" r="3"></circle><circle cx="9" cy="7" r="4"></circle>',
		'user-lock'                          => '<circle cx="10" cy="7" r="4"></circle><path d="M10.3 15H7a4 4 0 0 0-4 4v2"></path><path d="M15 15.5V14a2 2 0 0 1 4 0v1.5"></path><rect width="8" height="5" x="13" y="16" rx=".899"></rect>',
		'user-minus'                         => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="22" x2="16" y1="11" y2="11"></line>',
		'user-pen'                           => '<path d="M11.5 15H7a4 4 0 0 0-4 4v2"></path><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path><circle cx="10" cy="7" r="4"></circle>',
		'user-plus'                          => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" x2="19" y1="8" y2="14"></line><line x1="22" x2="16" y1="11" y2="11"></line>',
		'user-round-check'                   => '<path d="M2 21a8 8 0 0 1 13.292-6"></path><circle cx="10" cy="8" r="5"></circle><path d="m16 19 2 2 4-4"></path>',
		'user-round-cog'                     => '<path d="m14.305 19.53.923-.382"></path><path d="m15.228 16.852-.923-.383"></path><path d="m16.852 15.228-.383-.923"></path><path d="m16.852 20.772-.383.924"></path><path d="m19.148 15.228.383-.923"></path><path d="m19.53 21.696-.382-.924"></path><path d="M2 21a8 8 0 0 1 10.434-7.62"></path><path d="m20.772 16.852.924-.383"></path><path d="m20.772 19.148.924.383"></path><circle cx="10" cy="8" r="5"></circle><circle cx="18" cy="18" r="3"></circle>',
		'user-round-minus'                   => '<path d="M2 21a8 8 0 0 1 13.292-6"></path><circle cx="10" cy="8" r="5"></circle><path d="M22 19h-6"></path>',
		'user-round-pen'                     => '<path d="M2 21a8 8 0 0 1 10.821-7.487"></path><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path><circle cx="10" cy="8" r="5"></circle>',
		'user-round-plus'                    => '<path d="M2 21a8 8 0 0 1 13.292-6"></path><circle cx="10" cy="8" r="5"></circle><path d="M19 16v6"></path><path d="M22 19h-6"></path>',
		'user-round-search'                  => '<circle cx="10" cy="8" r="5"></circle><path d="M2 21a8 8 0 0 1 10.434-7.62"></path><circle cx="18" cy="18" r="3"></circle><path d="m22 22-1.9-1.9"></path>',
		'user-round-x'                       => '<path d="M2 21a8 8 0 0 1 11.873-7"></path><circle cx="10" cy="8" r="5"></circle><path d="m17 17 5 5"></path><path d="m22 17-5 5"></path>',
		'user-round'                         => '<circle cx="12" cy="8" r="5"></circle><path d="M20 21a8 8 0 0 0-16 0"></path>',
		'user-search'                        => '<circle cx="10" cy="7" r="4"></circle><path d="M10.3 15H7a4 4 0 0 0-4 4v2"></path><circle cx="17" cy="17" r="3"></circle><path d="m21 21-1.9-1.9"></path>',
		'user-star'                          => '<path d="M16.051 12.616a1 1 0 0 1 1.909.024l.737 1.452a1 1 0 0 0 .737.535l1.634.256a1 1 0 0 1 .588 1.806l-1.172 1.168a1 1 0 0 0-.282.866l.259 1.613a1 1 0 0 1-1.541 1.134l-1.465-.75a1 1 0 0 0-.912 0l-1.465.75a1 1 0 0 1-1.539-1.133l.258-1.613a1 1 0 0 0-.282-.866l-1.156-1.153a1 1 0 0 1 .572-1.822l1.633-.256a1 1 0 0 0 .737-.535z"></path><path d="M8 15H7a4 4 0 0 0-4 4v2"></path><circle cx="10" cy="7" r="4"></circle>',
		'user-x'                             => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="17" x2="22" y1="8" y2="13"></line><line x1="22" x2="17" y1="8" y2="13"></line>',
		'user'                               => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>',
		'users-round'                        => '<path d="M18 21a8 8 0 0 0-16 0"></path><circle cx="10" cy="8" r="5"></circle><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"></path>',
		'users'                              => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle>',
		'utensils-crossed'                   => '<path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"></path><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"></path><path d="m2.1 21.8 6.4-6.3"></path><path d="m19 5-7 7"></path>',
		'utensils'                           => '<path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path><path d="M7 2v20"></path><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"></path>',
		'utility-pole'                       => '<path d="M12 2v20"></path><path d="M2 5h20"></path><path d="M3 3v2"></path><path d="M7 3v2"></path><path d="M17 3v2"></path><path d="M21 3v2"></path><path d="m19 5-7 7-7-7"></path>',
		'van'                                => '<path d="M13 6v5a1 1 0 0 0 1 1h6.102a1 1 0 0 1 .712.298l.898.91a1 1 0 0 1 .288.702V17a1 1 0 0 1-1 1h-3"></path><path d="M5 18H3a1 1 0 0 1-1-1V8a2 2 0 0 1 2-2h12c1.1 0 2.1.8 2.4 1.8l1.176 4.2"></path><path d="M9 18h5"></path><circle cx="16" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle>',
		'variable'                           => '<path d="M8 21s-4-3-4-9 4-9 4-9"></path><path d="M16 3s4 3 4 9-4 9-4 9"></path><line x1="15" x2="9" y1="9" y2="15"></line><line x1="9" x2="15" y1="9" y2="15"></line>',
		'vault'                              => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"></circle><path d="m7.9 7.9 2.7 2.7"></path><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle><path d="m13.4 10.6 2.7-2.7"></path><circle cx="7.5" cy="16.5" r=".5" fill="currentColor"></circle><path d="m7.9 16.1 2.7-2.7"></path><circle cx="16.5" cy="16.5" r=".5" fill="currentColor"></circle><path d="m13.4 13.4 2.7 2.7"></path><circle cx="12" cy="12" r="2"></circle>',
		'vector-square'                      => '<path d="M19.5 7a24 24 0 0 1 0 10"></path><path d="M4.5 7a24 24 0 0 0 0 10"></path><path d="M7 19.5a24 24 0 0 0 10 0"></path><path d="M7 4.5a24 24 0 0 1 10 0"></path><rect x="17" y="17" width="5" height="5" rx="1"></rect><rect x="17" y="2" width="5" height="5" rx="1"></rect><rect x="2" y="17" width="5" height="5" rx="1"></rect><rect x="2" y="2" width="5" height="5" rx="1"></rect>',
		'vegan'                              => '<path d="M16 8q6 0 6-6-6 0-6 6"></path><path d="M17.41 3.59a10 10 0 1 0 3 3"></path><path d="M2 2a26.6 26.6 0 0 1 10 20c.9-6.82 1.5-9.5 4-14"></path>',
		'venetian-mask'                      => '<path d="M18 11c-1.5 0-2.5.5-3 2"></path><path d="M4 6a2 2 0 0 0-2 2v4a5 5 0 0 0 5 5 8 8 0 0 1 5 2 8 8 0 0 1 5-2 5 5 0 0 0 5-5V8a2 2 0 0 0-2-2h-3a8 8 0 0 0-5 2 8 8 0 0 0-5-2z"></path><path d="M6 11c1.5 0 2.5.5 3 2"></path>',
		'venus-and-mars'                     => '<path d="M10 20h4"></path><path d="M12 16v6"></path><path d="M17 2h4v4"></path><path d="m21 2-5.46 5.46"></path><circle cx="12" cy="11" r="5"></circle>',
		'venus'                              => '<path d="M12 15v7"></path><path d="M9 19h6"></path><circle cx="12" cy="9" r="6"></circle>',
		'vibrate-off'                        => '<path d="m2 8 2 2-2 2 2 2-2 2"></path><path d="m22 8-2 2 2 2-2 2 2 2"></path><path d="M8 8v10c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2"></path><path d="M16 10.34V6c0-.55-.45-1-1-1h-4.34"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'vibrate'                            => '<path d="m2 8 2 2-2 2 2 2-2 2"></path><path d="m22 8-2 2 2 2-2 2 2 2"></path><rect width="8" height="14" x="8" y="5" rx="1"></rect>',
		'video-off'                          => '<path d="M10.66 6H14a2 2 0 0 1 2 2v2.5l5.248-3.062A.5.5 0 0 1 22 7.87v8.196"></path><path d="M16 16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2"></path><path d="m2 2 20 20"></path>',
		'video'                              => '<path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect>',
		'videotape'                          => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="M2 8h20"></path><circle cx="8" cy="14" r="2"></circle><path d="M8 12h8"></path><circle cx="16" cy="14" r="2"></circle>',
		'view'                               => '<path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2"></path><path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2"></path><circle cx="12" cy="12" r="1"></circle><path d="M18.944 12.33a1 1 0 0 0 0-.66 7.5 7.5 0 0 0-13.888 0 1 1 0 0 0 0 .66 7.5 7.5 0 0 0 13.888 0"></path>',
		'voicemail'                          => '<circle cx="6" cy="12" r="4"></circle><circle cx="18" cy="12" r="4"></circle><line x1="6" x2="18" y1="16" y2="16"></line>',
		'volleyball'                         => '<path d="M11.1 7.1a16.55 16.55 0 0 1 10.9 4"></path><path d="M12 12a12.6 12.6 0 0 1-8.7 5"></path><path d="M16.8 13.6a16.55 16.55 0 0 1-9 7.5"></path><path d="M20.7 17a12.8 12.8 0 0 0-8.7-5 13.3 13.3 0 0 1 0-10"></path><path d="M6.3 3.8a16.55 16.55 0 0 0 1.9 11.5"></path><circle cx="12" cy="12" r="10"></circle>',
		'volume-1'                           => '<path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"></path><path d="M16 9a5 5 0 0 1 0 6"></path>',
		'volume-2'                           => '<path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"></path><path d="M16 9a5 5 0 0 1 0 6"></path><path d="M19.364 18.364a9 9 0 0 0 0-12.728"></path>',
		'volume-off'                         => '<path d="M16 9a5 5 0 0 1 .95 2.293"></path><path d="M19.364 5.636a9 9 0 0 1 1.889 9.96"></path><path d="m2 2 20 20"></path><path d="m7 7-.587.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298V11"></path><path d="M9.828 4.172A.686.686 0 0 1 11 4.657v.686"></path>',
		'volume-x'                           => '<path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"></path><line x1="22" x2="16" y1="9" y2="15"></line><line x1="16" x2="22" y1="9" y2="15"></line>',
		'volume'                             => '<path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"></path>',
		'vote'                               => '<path d="m9 12 2 2 4-4"></path><path d="M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z"></path><path d="M22 19H2"></path>',
		'wallet-cards'                       => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"></path><path d="M3 11h3c.8 0 1.6.3 2.1.9l1.1.9c1.6 1.6 4.1 1.6 5.7 0l1.1-.9c.5-.5 1.3-.9 2.1-.9H21"></path>',
		'wallet-minimal'                     => '<path d="M17 14h.01"></path><path d="M7 7h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14"></path>',
		'wallet'                             => '<path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"></path><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"></path>',
		'wallpaper'                          => '<path d="M12 17v4"></path><path d="M8 21h8"></path><path d="m9 17 6.1-6.1a2 2 0 0 1 2.81.01L22 15"></path><circle cx="8" cy="9" r="2"></circle><rect x="2" y="3" width="20" height="14" rx="2"></rect>',
		'wand-sparkles'                      => '<path d="m21.64 3.64-1.28-1.28a1.21 1.21 0 0 0-1.72 0L2.36 18.64a1.21 1.21 0 0 0 0 1.72l1.28 1.28a1.2 1.2 0 0 0 1.72 0L21.64 5.36a1.2 1.2 0 0 0 0-1.72"></path><path d="m14 7 3 3"></path><path d="M5 6v4"></path><path d="M19 14v4"></path><path d="M10 2v2"></path><path d="M7 8H3"></path><path d="M21 16h-4"></path><path d="M11 3H9"></path>',
		'wand'                               => '<path d="M15 4V2"></path><path d="M15 16v-2"></path><path d="M8 9h2"></path><path d="M20 9h2"></path><path d="M17.8 11.8 19 13"></path><path d="M15 9h.01"></path><path d="M17.8 6.2 19 5"></path><path d="m3 21 9-9"></path><path d="M12.2 6.2 11 5"></path>',
		'warehouse'                          => '<path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path><path d="M6 13h12"></path><path d="M6 17h12"></path>',
		'washing-machine'                    => '<path d="M3 6h3"></path><path d="M17 6h.01"></path><rect width="18" height="20" x="3" y="2" rx="2"></rect><circle cx="12" cy="13" r="5"></circle><path d="M12 18a2.5 2.5 0 0 0 0-5 2.5 2.5 0 0 1 0-5"></path>',
		'watch'                              => '<path d="M12 10v2.2l1.6 1"></path><path d="m16.13 7.66-.81-4.05a2 2 0 0 0-2-1.61h-2.68a2 2 0 0 0-2 1.61l-.78 4.05"></path><path d="m7.88 16.36.8 4a2 2 0 0 0 2 1.61h2.72a2 2 0 0 0 2-1.61l.81-4.05"></path><circle cx="12" cy="12" r="6"></circle>',
		'waves-arrow-down'                   => '<path d="M12 10L12 2"></path><path d="M16 6L12 10L8 6"></path><path d="M2 15C2.6 15.5 3.2 16 4.5 16C7 16 7 14 9.5 14C12.1 14 11.9 16 14.5 16C17 16 17 14 19.5 14C20.8 14 21.4 14.5 22 15"></path><path d="M2 21C2.6 21.5 3.2 22 4.5 22C7 22 7 20 9.5 20C12.1 20 11.9 22 14.5 22C17 22 17 20 19.5 20C20.8 20 21.4 20.5 22 21"></path>',
		'waves-arrow-up'                     => '<path d="M12 2v8"></path><path d="M2 15c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="m8 6 4-4 4 4"></path>',
		'waves-ladder'                       => '<path d="M19 5a2 2 0 0 0-2 2v11"></path><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="M7 13h10"></path><path d="M7 9h10"></path><path d="M9 5a2 2 0 0 0-2 2v11"></path>',
		'waves'                              => '<path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path>',
		'waypoints'                          => '<path d="m10.586 5.414-5.172 5.172"></path><path d="m18.586 13.414-5.172 5.172"></path><path d="M6 12h12"></path><circle cx="12" cy="20" r="2"></circle><circle cx="12" cy="4" r="2"></circle><circle cx="20" cy="12" r="2"></circle><circle cx="4" cy="12" r="2"></circle>',
		'webcam'                             => '<circle cx="12" cy="10" r="8"></circle><circle cx="12" cy="10" r="3"></circle><path d="M7 22h10"></path><path d="M12 22v-4"></path>',
		'webhook-off'                        => '<path d="M17 17h-5c-1.09-.02-1.94.92-2.5 1.9A3 3 0 1 1 2.57 15"></path><path d="M9 3.4a4 4 0 0 1 6.52.66"></path><path d="m6 17 3.1-5.8a2.5 2.5 0 0 0 .057-2.05"></path><path d="M20.3 20.3a4 4 0 0 1-2.3.7"></path><path d="M18.6 13a4 4 0 0 1 3.357 3.414"></path><path d="m12 6 .6 1"></path><path d="m2 2 20 20"></path>',
		'webhook'                            => '<path d="M18 16.98h-5.99c-1.1 0-1.95.94-2.48 1.9A4 4 0 0 1 2 17c.01-.7.2-1.4.57-2"></path><path d="m6 17 3.13-5.78c.53-.97.1-2.18-.5-3.1a4 4 0 1 1 6.89-4.06"></path><path d="m12 6 3.13 5.73C15.66 12.7 16.9 13 18 13a4 4 0 0 1 0 8"></path>',
		'weight-tilde'                       => '<path d="M6.5 8a2 2 0 0 0-1.906 1.46L2.1 18.5A2 2 0 0 0 4 21h16a2 2 0 0 0 1.925-2.54L19.4 9.5A2 2 0 0 0 17.48 8z"></path><path d="M7.999 15a2.5 2.5 0 0 1 4 0 2.5 2.5 0 0 0 4 0"></path><circle cx="12" cy="5" r="3"></circle>',
		'weight'                             => '<circle cx="12" cy="5" r="3"></circle><path d="M6.5 8a2 2 0 0 0-1.905 1.46L2.1 18.5A2 2 0 0 0 4 21h16a2 2 0 0 0 1.925-2.54L19.4 9.5A2 2 0 0 0 17.48 8Z"></path>',
		'wheat-off'                          => '<path d="m2 22 10-10"></path><path d="m16 8-1.17 1.17"></path><path d="M3.47 12.53 5 11l1.53 1.53a3.5 3.5 0 0 1 0 4.94L5 19l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z"></path><path d="m8 8-.53.53a3.5 3.5 0 0 0 0 4.94L9 15l1.53-1.53c.55-.55.88-1.25.98-1.97"></path><path d="M10.91 5.26c.15-.26.34-.51.56-.73L13 3l1.53 1.53a3.5 3.5 0 0 1 .28 4.62"></path><path d="M20 2h2v2a4 4 0 0 1-4 4h-2V6a4 4 0 0 1 4-4Z"></path><path d="M11.47 17.47 13 19l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L5 19l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z"></path><path d="m16 16-.53.53a3.5 3.5 0 0 1-4.94 0L9 15l1.53-1.53a3.49 3.49 0 0 1 1.97-.98"></path><path d="M18.74 13.09c.26-.15.51-.34.73-.56L21 11l-1.53-1.53a3.5 3.5 0 0 0-4.62-.28"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'wheat'                              => '<path d="M2 22 16 8"></path><path d="M3.47 12.53 5 11l1.53 1.53a3.5 3.5 0 0 1 0 4.94L5 19l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z"></path><path d="M7.47 8.53 9 7l1.53 1.53a3.5 3.5 0 0 1 0 4.94L9 15l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z"></path><path d="M11.47 4.53 13 3l1.53 1.53a3.5 3.5 0 0 1 0 4.94L13 11l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z"></path><path d="M20 2h2v2a4 4 0 0 1-4 4h-2V6a4 4 0 0 1 4-4Z"></path><path d="M11.47 17.47 13 19l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L5 19l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z"></path><path d="M15.47 13.47 17 15l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L9 15l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z"></path><path d="M19.47 9.47 21 11l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L13 11l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z"></path>',
		'whole-word'                         => '<circle cx="7" cy="12" r="3"></circle><path d="M10 9v6"></path><circle cx="17" cy="12" r="3"></circle><path d="M14 7v8"></path><path d="M22 17v1c0 .5-.5 1-1 1H3c-.5 0-1-.5-1-1v-1"></path>',
		'wifi-cog'                           => '<path d="m14.305 19.53.923-.382"></path><path d="m15.228 16.852-.923-.383"></path><path d="m16.852 15.228-.383-.923"></path><path d="m16.852 20.772-.383.924"></path><path d="m19.148 15.228.383-.923"></path><path d="m19.53 21.696-.382-.924"></path><path d="M2 7.82a15 15 0 0 1 20 0"></path><path d="m20.772 16.852.924-.383"></path><path d="m20.772 19.148.924.383"></path><path d="M5 11.858a10 10 0 0 1 11.5-1.785"></path><path d="M8.5 15.429a5 5 0 0 1 2.413-1.31"></path><circle cx="18" cy="18" r="3"></circle>',
		'wifi-high'                          => '<path d="M12 20h.01"></path><path d="M5 12.859a10 10 0 0 1 14 0"></path><path d="M8.5 16.429a5 5 0 0 1 7 0"></path>',
		'wifi-low'                           => '<path d="M12 20h.01"></path><path d="M8.5 16.429a5 5 0 0 1 7 0"></path>',
		'wifi-off'                           => '<path d="M12 20h.01"></path><path d="M8.5 16.429a5 5 0 0 1 7 0"></path><path d="M5 12.859a10 10 0 0 1 5.17-2.69"></path><path d="M19 12.859a10 10 0 0 0-2.007-1.523"></path><path d="M2 8.82a15 15 0 0 1 4.177-2.643"></path><path d="M22 8.82a15 15 0 0 0-11.288-3.764"></path><path d="m2 2 20 20"></path>',
		'wifi-pen'                           => '<path d="M2 8.82a15 15 0 0 1 20 0"></path><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"></path><path d="M5 12.859a10 10 0 0 1 10.5-2.222"></path><path d="M8.5 16.429a5 5 0 0 1 3-1.406"></path>',
		'wifi-sync'                          => '<path d="M11.965 10.105v4L13.5 12.5a5 5 0 0 1 8 1.5"></path><path d="M11.965 14.105h4"></path><path d="M17.965 18.105h4L20.43 19.71a5 5 0 0 1-8-1.5"></path><path d="M2 8.82a15 15 0 0 1 20 0"></path><path d="M21.965 22.105v-4"></path><path d="M5 12.86a10 10 0 0 1 3-2.032"></path><path d="M8.5 16.429h.01"></path>',
		'wifi-zero'                          => '<path d="M12 20h.01"></path>',
		'wifi'                               => '<path d="M12 20h.01"></path><path d="M2 8.82a15 15 0 0 1 20 0"></path><path d="M5 12.859a10 10 0 0 1 14 0"></path><path d="M8.5 16.429a5 5 0 0 1 7 0"></path>',
		'wind-arrow-down'                    => '<path d="M10 2v8"></path><path d="M12.8 21.6A2 2 0 1 0 14 18H2"></path><path d="M17.5 10a2.5 2.5 0 1 1 2 4H2"></path><path d="m6 6 4 4 4-4"></path>',
		'wind'                               => '<path d="M12.8 19.6A2 2 0 1 0 14 16H2"></path><path d="M17.5 8a2.5 2.5 0 1 1 2 4H2"></path><path d="M9.8 4.4A2 2 0 1 1 11 8H2"></path>',
		'wine-off'                           => '<path d="M8 22h8"></path><path d="M7 10h3m7 0h-1.343"></path><path d="M12 15v7"></path><path d="M7.307 7.307A12.33 12.33 0 0 0 7 10a5 5 0 0 0 7.391 4.391M8.638 2.981C8.75 2.668 8.872 2.34 9 2h6c1.5 4 2 6 2 8 0 .407-.05.809-.145 1.198"></path><line x1="2" x2="22" y1="2" y2="22"></line>',
		'wine'                               => '<path d="M8 22h8"></path><path d="M7 10h10"></path><path d="M12 15v7"></path><path d="M12 15a5 5 0 0 0 5-5c0-2-.5-4-2-8H9c-1.5 4-2 6-2 8a5 5 0 0 0 5 5Z"></path>',
		'workflow'                           => '<rect width="8" height="8" x="3" y="3" rx="2"></rect><path d="M7 11v4a2 2 0 0 0 2 2h4"></path><rect width="8" height="8" x="13" y="13" rx="2"></rect>',
		'worm'                               => '<path d="m19 12-1.5 3"></path><path d="M19.63 18.81 22 20"></path><path d="M6.47 8.23a1.68 1.68 0 0 1 2.44 1.93l-.64 2.08a6.76 6.76 0 0 0 10.16 7.67l.42-.27a1 1 0 1 0-2.73-4.21l-.42.27a1.76 1.76 0 0 1-2.63-1.99l.64-2.08A6.66 6.66 0 0 0 3.94 3.9l-.7.4a1 1 0 1 0 2.55 4.34z"></path>',
		'wrench'                             => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z"></path>',
		'x'                                  => '<path d="M18 6 6 18"></path><path d="m6 6 12 12"></path>',
		'youtube'                            => '<path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"></path><path d="m10 15 5-3-5-3z"></path>',
		'zap-off'                            => '<path d="M10.513 4.856 13.12 2.17a.5.5 0 0 1 .86.46l-1.377 4.317"></path><path d="M15.656 10H20a1 1 0 0 1 .78 1.63l-1.72 1.773"></path><path d="M16.273 16.273 10.88 21.83a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14H4a1 1 0 0 1-.78-1.63l4.507-4.643"></path><path d="m2 2 20 20"></path>',
		'zap'                                => '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>',
		'zoom-in'                            => '<circle cx="11" cy="11" r="8"></circle><line x1="21" x2="16.65" y1="21" y2="16.65"></line><line x1="11" x2="11" y1="8" y2="14"></line><line x1="8" x2="14" y1="11" y2="11"></line>',
		'zoom-out'                           => '<circle cx="11" cy="11" r="8"></circle><line x1="21" x2="16.65" y1="21" y2="16.65"></line><line x1="8" x2="14" y1="11" y2="11"></line>',
	];


	/**
	 * Generate an HTML icon tag for the icon.
	 *
	 * @param string|\BackedEnum $class_name - Optional custom CSS class to add to the icon.
	 *
	 * @return string
	 */
	public function icon( string|\BackedEnum $class_name = '' ): string {
		$icon_key = \str_replace( 'lucide/', '', $this->value );
		if ( ! isset( self::ICONS[ $icon_key ] ) ) {
			_doing_it_wrong( __METHOD__, esc_html( "Icon {$this->value} not found." ), '6.1.0' );
			return '';
		}

		$icon_class = \str_replace( '/', '-', $this->value );
		$classes = new Class_Names( [
			'lucide-icon',
			'icon-' . $icon_class,
			$class_name,
		] );

		return '<i class="' . $classes . '">' . $this->get_svg() . '</i>';
	}


	/**
	 * Get the SVG markup for the icon.
	 *
	 * @return string
	 */
	protected function get_svg(): string {
		$icon_key = \str_replace( 'lucide/', '', $this->value );
		if ( ! isset( self::ICONS[ $icon_key ] ) ) {
			_doing_it_wrong( __METHOD__, esc_html( "Icon {$this->value} not found." ), '6.1.0' );
			return '';
		}

		$icon_class = \str_replace( '/', '-', $this->value );
		$attributes = [
			'xmlns'           => 'http://www.w3.org/2000/svg',
			'class'           => new Class_Names( [
				'lucide',
				$icon_class,
				$icon_class . '-icon',
			] ),
			'viewBox'         => '0 0 24 24',
			'width'           => '1em',
			'height'          => '1em',
			'fill'            => 'none',
			'stroke'          => 'currentColor',
			'stroke-width'    => '2',
			'stroke-linecap'  => 'round',
			'stroke-linejoin' => 'round',
		];

		return '<svg ' . Template::in()->esc_attr( $attributes ) . '>' . self::ICONS[ $icon_key ] . '</svg>';
	}


	/**
	 * Register the Lucide icon collection and its icons with WordPress.
	 *
	 * Not required to use this enum directly, but allows for the icons
	 * to be used in the WordPress block editor.
	 *
	 * @return void
	 */
	public static function register(): void {
		if ( ! \function_exists( 'wp_register_icon_collection' ) || ! \function_exists( 'wp_register_icon' ) ) {
			_doing_it_wrong( __METHOD__, esc_html( 'WP 7.1+ is required to use Lucide icon registration.' ), '6.1.0' );
			return;
		}

		wp_register_icon_collection( 'lucide', [
			'label'       => __( 'Lucide', 'lipe' ),
			'description' => __( 'Lucide icon collection.', 'lipe' ),
		] );

		foreach ( self::cases() as $icon ) {
			$label = \ucwords( \str_replace( '-', ' ', \str_replace( 'lucide/', '', $icon->value ) ) );

			wp_register_icon( $icon->value, [
				'label'   => $label,
				'content' => $icon->get_svg(),
			] );
		}
	}
}
