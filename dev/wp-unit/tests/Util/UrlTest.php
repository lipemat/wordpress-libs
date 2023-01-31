<?php

namespace Lipe\Lib\Util;

/**
 * @author Mat Lipe
 * @since  January 2023
 *
 */
class UrlTest extends \WP_UnitTestCase {

	public function test_get_blog_pagenum_link() : void {
		global $wp_rewrite;
		$page = self::factory()->post->create_and_get( [
			'post_title' => 'Blog',
			'post_type'  => 'page',
		] );

		// No blog page set.
		$this->assertEquals( get_pagenum_link( 4 ), Url::in()->get_blog_pagenum_link( 4 ) );

		// Non existent page set.
		update_option( 'page_for_posts', 99999 );
		$this->assertEquals( get_pagenum_link( 4 ), Url::in()->get_blog_pagenum_link( 4 ) );

		// No permalinks.
		update_option( 'page_for_posts', $page->ID );
		$this->assertEquals( add_query_arg( [ 'paged' => 4 ], get_permalink( $page ) ), Url::in()->get_blog_pagenum_link( 4 ) );

		// With permalinks.
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		$this->assertEquals( user_trailingslashit( get_permalink( $page ) . $wp_rewrite->pagination_base . '/' . 4 ), Url::in()->get_blog_pagenum_link( 4 ) );

		// Page 1.
		$this->assertEquals( get_permalink( $page ), Url::in()->get_blog_pagenum_link( 1 ) );
	}
}
