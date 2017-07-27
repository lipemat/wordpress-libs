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
	public $title;

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


	/**
	 * Get whatever type is set to true
	 *
	 * @throws \Exception
	 *
	 * @return int|string
	 */
	public function get_type() {
		foreach( get_object_vars( $this ) as $_var => $_value ){
			if( isset( $_value ) ){
				return $_var;
			}
		}
		throw new \Exception( "You must set a type to true in the class" );
	}

}