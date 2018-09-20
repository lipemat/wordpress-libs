<?php

namespace Lipe\Project\Rest_Api;

use Lipe\Lib\Rest_Api\Post_Abstract;

/**
 * Post
 *
 * @link    http://flashback.loc/wp-json/wp/v2/product/
 *
 *
 * @example wp-json/wp/v2/product/?product_cat=60
 *
 * @example wp-json/wp/v2/product/?product_to_vendor=356
 *
 * @package WSWD\Rest_Api
 */
class Woo_Product extends Post_Abstract {
	const POST_TYPE = 'product';

	protected $taxonomies = [
		'product_cat',
	];

	protected $allowed_meta_keys = [];

	protected $related = [
		'product_to_vendor',
	];


	public function hook() : void {
		parent::hook();
		add_filter( 'woocommerce_register_post_type_product', [ $this, 'allow_object_in_rest' ], 10 );
		add_filter( 'woocommerce_taxonomy_args_product_cat', [ $this, 'allow_object_in_rest' ], 10 );
	}


	public function allow_object_in_rest( $args ) {
		$args['show_in_rest'] = true;

		return $args;
	}

}
