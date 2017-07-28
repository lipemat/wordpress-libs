<?php

namespace Lipe\Lib\CMB2;


/**
 * Field_Type
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @link https://github.com/CMB2/CMB2/wiki/Field-Types
 *
 * @package Lipe\Lib\CMB2
 */
class Field_Type {
	public $title = 'title';

	public $text;

	public $text_small;

	public $text_medium;

	public $text_email;

	public $text_url;

	public $text_money;

	public $textarea;

	public $textarea_small;

	public $textarea_code;

	public $text_time;

	public $select_timezone;

	public $text_date;

	public $text_date_timestamp;

	public $text_datetime_timestamp;

	public $text_datetime_timestamp_timezone;

	public $hidden;

	public $colorpicker;

	public $radio;

	public $radio_inline;

	public $taxonomy_radio;

	public $taxonomy_radio_inline;

	public $select;

	public $taxonomy_select;

	public $checkbox;

	public $multicheck;

	public $multicheck_inline;

	public $taxonomy_multicheck;

	public $taxonomy_multicheck_inline;

	public $wysiwyg;

	public $file;

	public $file_list;

	public $oembed;

	public $group;

	public function __construct() {
		foreach( get_object_vars( $this ) as $_var => $_value ){
			$this->{$_var} = $_var;
		}
	}


	public static function types(){
		return new self();
	}

}