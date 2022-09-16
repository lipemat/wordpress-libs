<?php

namespace Lipe\Lib\Theme;

/**
 * Pagination
 *
 * I expect you to have already sort the items before you
 * give them to me. I will generate a html list designed to
 * be used with ajax as well as the items for this current page.
 *
 * @author  Mat Lipe
 *
 */
class Pagination {

	private $per_page;

	private $items;

	/**
	 * wp_query
	 *
	 * @var \WP_Query|null
	 */
	private $wp_query;

	/**
	 * @var int
	 */
	private $page;


	/**
	 * Send me some items, and I'll create the pagination.
	 * If no wp_query is used I will split the list and return the items within that range
	 * If a wp_query is used, I will return the same items you sent me
	 *
	 * @param array      $items           - Either the full list of items, or this
	 *                                    page's posts when using a wp_query.
	 * @param ?\WP_Query $wp_query        - Send a wp_query to use that for handling
	 *                                    calculations instead of an independent list
	 * @param int        $per_page        - defaults to 10 (ignored if using a `$wp_query`).
	 */
	public function __construct( array $items, ?\WP_Query $wp_query = null, int $per_page = 10 ) {
		$this->items = $items;
		$this->wp_query = $wp_query;

		if ( $wp_query ) {
			$this->per_page = $wp_query->get( 'posts_per_page' );
			$page = $this->wp_query->is_paged() ? $wp_query->get( 'paged' ) : 1;
		} else {
			$this->per_page = $per_page;
			$page = empty( $_REQUEST['page'] ) ? 1 : sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ); //phpcs:ignore
		}
		// Certain areas of the admin pass page in url.
		if ( ! is_numeric( $page ) ) {
			$page = 1;
		}

		$this->page = (int) $page;
	}


	/**
	 * Returns the items that belong on the current
	 * page only
	 *
	 * @return array
	 */
	public function get_this_pages_items() : array {
		// wp_query already gave us this page's items in the first place.
		if ( $this->wp_query ) {
			return $this->items;
		}
		$page = $this->page;
		$bottom = ( $page - 1 ) * $this->per_page;

		return \array_slice( $this->items, $bottom, $this->per_page );
	}


	/**
	 * Generates the html for the pagination
	 * <a data-page="%page%">
	 *
	 * Let's do the numbers so that only 5 pages show at a time (<< < 1 2 3 4 5 .. 20 > >>) avoiding a long set of
	 * numbers]
	 *
	 * @return void
	 */
	public function render_pagination() : void {
		$page = $this->page;
		$total = $this->get_total_pages();

		if ( $total < 2 ) {
			return;
		}

		if ( $page < 3 ) {
			$bottom = 1;
		} elseif ( $page === $total ) {
			$bottom = max( 1, $page - 5 );
		} elseif ( $page + 3 > $total ) {
			$bottom = max( 1, $page - 4 );
		} else {
			$bottom = $page - 2;
		}

		if ( $page > ( $total - 3 ) ) {
			$top = $total - 1;
		} elseif ( ( $bottom + 4 ) > $total ) {
			$top = $total;
		} else {
			$top = $bottom + 4;
		}

		if ( $this->wp_query ) {
			$this->link_html( $page, $total, $top, $bottom );
		} else {
			$this->ajax_html( $page, $total, $top, $bottom );
		}
	}


	public function get_total_pages() {
		$count = $this->wp_query->found_posts ?? \count( $this->items );
		if ( 0 === $count ) {
			return 0;
		}

		return ceil( $count / $this->per_page );
	}


	/**
	 * Generates the HTML based on links /page/%number%.
	 * Used by standard wp queries.
	 *
	 * Used when we do have a `WP_Query`.
	 *
	 * @param int $page
	 * @param int $total
	 * @param int $top
	 * @param int $bottom
	 *
	 * @return void
	 */
	private function link_html( int $page, int $total, int $top, int $bottom ) : void {
		?>
		<ul class="navigation">
			<?php
			if ( 1 !== $page ) {
				?>
				<li>
					<a href="<?= esc_url( get_pagenum_link() ) ?>">
						<?= apply_filters( 'lipe/lib/theme/paginate_double_back', '&laquo' ) //phpcs:ignore ?>
					</a>
				</li>
				<li>
					<a href="<?= esc_url( get_pagenum_link( $page - 1 ) ) ?>">
						<?= apply_filters( 'lipe/lib/theme/paginate_back', '&lt' ) //phpcs:ignore ?>
					</a>
				</li>
				<?php
			}

			while ( $bottom <= $top ) {
				$class = '';
				if ( $bottom === $page ) {
					$class = ' class="current"';
				}
				?>
				<li>
					<a href="<?= esc_url( get_pagenum_link( $bottom ) ) ?>"<?= esc_attr( $class ) ?>>
						<?= (int) $bottom ?>
					</a>
				</li>
				<?php
				$bottom ++;
			}
			if ( $total > $top ) {
				?>
				<li> ...</li>
				<li>
					<a href="<?= esc_url( get_pagenum_link( $total ) ) ?>">
						<?= (int) $total ?>
					</a>
				</li>
				<?php
			}
			if ( $page !== $total ) {
				?>
				<li>
					<a href="<?= esc_url( get_pagenum_link( $page + 1 ) ) ?>">
						<?= apply_filters( 'lipe/lib/theme/paginate_next', '&gt;' ) //phpcs:ignore ?>
					</a>
				</li>
				<li>
					<a href="<?= esc_url( get_pagenum_link( $total ) ) ?>">
						<?= apply_filters( 'lipe/lib/theme/paginate_double_next', '&raquo;' ) //phpcs:ignore ?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<?php
	}


	/**
	 * Generate the ajax driven pagination
	 * Used when we don't have a wp_query
	 *
	 * @param int $page
	 * @param int $total
	 * @param int $top
	 * @param int $bottom
	 *
	 * @return void
	 */
	private function ajax_html( int $page, int $total, int $top, int $bottom ) : void {
		?>
		<ul class="pagination navigation">
			<?php
			if ( 1 !== $page ) {
				?>
				<li>
					<a data-page="1">
						<?= apply_filters( 'lipe/lib/theme/paginate_double_back', '&laquo' ) //phpcs:ignore  ?>
					</a>
				</li>
				<li>
					<a data-page="<?= (int) $page - 1 ?>">
						<?= apply_filters( 'lipe/lib/theme/paginate_back', '&lt' ) //phpcs:ignore ?>
					</a>
				</li>
				<?php
			}

			while ( $bottom <= $top ) {
				$class = '';
				if ( $bottom === $page ) {
					$class = ' class="current"';
				}
				?>
				<li>
					<a data-page="<?= (int) $bottom ?>"<?= esc_attr( $class ) ?>>
						<?= (int) $bottom ?>
					</a>
				</li>
				<?php
				$bottom ++;
			}

			if ( $total > $top ) {
				?>
				<li>
					...
				</li>
				<li>
					<a data-page="<?= (int) $total ?>">
						<?= (int) $total ?>
					</a>
				</li>
				<?php
			}

			if ( $page !== $total ) {
				?>
				<li>
					<a data-page="<?= (int) $page + 1 ?>">
						<?= apply_filters( 'lipe/lib/theme/paginate_next', '&gt;' ) //phpcs:ignore ?>
					</a>
				</li>
				<li>
					<a data-page="<?= (int) $total ?>">
						<?= apply_filters( 'lipe/lib/theme/paginate_double_next', '&raquo;' ) //phpcs:ignore ?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<?php
	}
}
