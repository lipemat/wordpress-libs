<?php

namespace Lipe\Lib\ACF;

abstract class Group_Config_Abstract {

	/**
	 * group
	 *
	 * @var \Lipe\Lib\ACF\Group
	 */
	protected $group;

	/**
	 * key
	 *
	 * @var string
	 */
	protected $key;


	protected abstract function get_config();


	protected function add_field( $name, $label, array $args ) {
		$field = new Field( "{$this->key}_$name" );

		$default = [
			'name'  => $name,
			'label' => $label,
		];
		$args = wp_parse_args( $args, $default );

		$field->set_attributes( $args );
		$this->group->add_field( $field );
	}


	protected function add_tab( $label ) {
		$field = new Field( "{$this->key}_$label" );
		$field->set_attributes( [
			'label'        => $label,
			'name'         => $label,
			'type'         => 'tab',
			//'placement'    => 'left',
			'instructions' => '',
			//'endpoint' => true,
		] );
		$this->group->add_field( $field );
	}
}