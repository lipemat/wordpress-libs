<?php

namespace Lipe\Lib\Taxonomy;

/**
 * @author Mat Lipe
 * @since  5.7.0
 *
 */
class Wp_List_CategoriesTest extends \WP_UnitTestCase {

	public function test_get_args(): void {
		$args = new Wp_List_Categories( [
			'order'  => 'ASC',
			'offset' => 4,
		] );

		$this->assertEquals( [
			'order'  => 'ASC',
			'offset' => 4,
		], $args->get_args(), 'Existing args are not being passed.' );

		$args->fields = 'all';
		$args->taxonomy = [ 'category', 'post_tag' ];
		$args->current_category = [ 1, 2, 3 ];
		$args->depth = 2;
		$args->echo = false;
		$args->feed = 'RSS Feed';
		$args->feed_image = 'https://example.com/feed.png';
		$args->feed_type = 'rss2';
		$args->hide_title_if_empty = true;
		$args->separator = ' | ';
		$args->show_count = true;
		$args->show_option_all = 'All Categories';
		$args->show_option_none = 'No Categories';
		$args->style = Wp_List_Categories::STYLE_LIST;
		$args->title_li = 'Category List';
		$args->use_desc_for_title = true;

		$args->meta_query()
		     ->in( 'meta-key', [ 4, 5, 6 ] )
		     ->advanced( 'NUMERIC' );
		$args->order = 'DESC';

		$this->assertEquals( [
			'order'               => 'DESC',
			'offset'              => 4,
			'fields'              => 'all',
			'taxonomy'            => [ 'category', 'post_tag' ],
			'current_category'    => [ 1, 2, 3 ],
			'depth'               => 2,
			'echo'                => false,
			'feed'                => 'RSS Feed',
			'feed_image'          => 'https://example.com/feed.png',
			'feed_type'           => 'rss2',
			'hide_title_if_empty' => true,
			'separator'           => ' | ',
			'show_count'          => true,
			'show_option_all'     => 'All Categories',
			'show_option_none'    => 'No Categories',
			'style'               => 'list',
			'title_li'            => 'Category List',
			'use_desc_for_title'  => true,
			'meta_query'          => [
				[
					'key'     => 'meta-key',
					'value'   => [ 4, 5, 6 ],
					'compare' => 'IN',
					'type'    => 'NUMERIC',
				],
			],
		], $args->get_args() );
	}


	public function test_style_constants(): void {
		$this->assertEquals( 'list', Wp_List_Categories::STYLE_LIST );
		$this->assertEquals( 'none', Wp_List_Categories::STYLE_NONE );
	}


	public function test_current_category_types(): void {
		$args = new Wp_List_Categories( [] );

		$args->current_category = 5;
		$this->assertEquals( [
			'current_category' => 5,
		], $args->get_args(), 'Single integer current_category not working.' );

		$args->current_category = [ 1, 2, 3 ];
		$this->assertEquals( [
			'current_category' => [ 1, 2, 3 ],
		], $args->get_args(), 'Array of integers current_category not working.' );
	}
}
