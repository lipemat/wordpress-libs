<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Field;

/**
 * CMB2 field types.
 *
 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types
 */
enum Type: string {
	case CHECKBOX                         = 'checkbox';
	case COLOR_PICKER                     = 'colorpicker';
	case FILE                             = 'file';
	case FILE_LIST                        = 'file_list';
	case GROUP                            = 'group';
	case HIDDEN                           = 'hidden';
	case MULTI_CHECK                      = 'multicheck';
	case MULTI_CHECK_INLINE               = 'multicheck_inline';
	case OEMBED                           = 'oembed';
	case RADIO                            = 'radio';
	case RADIO_INLINE                     = 'radio_inline';
	case SELECT                           = 'select';
	case SELECT_TIMEZONE                  = 'select_timezone';
	case TAXONOMY_MULTICHECK              = 'taxonomy_multicheck';
	case TAXONOMY_MULTICHECK_HIERARCHICAL = 'taxonomy_multicheck_hierarchical';
	case TAXONOMY_MULTICHECK_INLINE       = 'taxonomy_multicheck_inline';
	case TAXONOMY_RADIO                   = 'taxonomy_radio';
	case TAXONOMY_RADIO_HIERARCHICAL      = 'taxonomy_radio_hierarchical';
	case TAXONOMY_RADIO_INLINE            = 'taxonomy_radio_inline';
	case TAXONOMY_SELECT                  = 'taxonomy_select';
	case TAXONOMY_SELECT_HIERARCHICAL     = 'taxonomy_select_hierarchical';
	case TERM_SELECT_2                    = 'lipe/lib/cmb2/field-types/term-select-2';
	case TEXT                             = 'text';
	case TEXT_AREA                        = 'textarea';
	case TEXT_AREA_CODE                   = 'textarea_code';
	case TEXT_AREA_SMALL                  = 'textarea_small';
	case TEXT_DATE                        = 'text_date';
	case TEXT_DATETIME_TIMESTAMP          = 'text_datetime_timestamp';
	case TEXT_DATETIME_TIMESTAMP_TZ       = 'text_date_timestamp_timezone';
	case TEXT_DATE_TIMESTAMP              = 'text_date_timestamp';
	case TEXT_EMAIL                       = 'text_email';
	case TEXT_MEDIUM                      = 'text_medium';
	case TEXT_MONEY                       = 'text_money';
	case TEXT_SMALL                       = 'text_small';
	case TEXT_TIME                        = 'text_time';
	case TEXT_URL                         = 'text_url';
	case TITLE                            = 'title';
	case WYSIWYG                          = 'wysiwyg';
}
