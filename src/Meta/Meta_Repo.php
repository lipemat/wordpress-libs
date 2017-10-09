<?php
namespace Lipe\Lib\Meta;

use Lipe\Lib\Traits\Singleton;

/**
 * Meta_Repo
 *
 * @author Mat Lipe
 * @since  7/27/2017
 *
 */
class Meta_Repo {
	use Singleton;

	protected $keys = [];

	protected $classes = [];

	public function register_keys( Meta_Class_Abstract $meta_class, array $keys ){
		$class_name = get_class( $meta_class );
		$this->classes[ $class_name ] = $meta_class;

		foreach( $keys as $_key ){
			$this->keys[ $_key ] = $class_name;
		}
	}

	public function get_meta( $id, $key ){
		if( !isset( $this->keys[ $key ] ) ){
			throw new \Exception("This meta key {$key} was not added to the repo. Did you add it to get_keys()" );
		}
		$class_name = $this->keys[ $key ];
		return $this->classes[ $class_name ]->get_meta( $id, $key );
	}
}