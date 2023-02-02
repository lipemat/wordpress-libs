<?php

namespace Lipe\Lib\Query\Clause;

//phpcs:disable Squiz.Commenting.FunctionComment.SpacingAfterParamType
use Lipe\Lib\Query\Args;

/**
 * Generate a `date_query` argument for a `WP_Query.
 *
 * @note Far too many possibilities to add methods the same
 * way we do for Date_Query and Tax_Query. Instead, we are using the properties
 * of this class.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @internal
 *
 * @phpstan-type COMPARE '='|'!='|'>'|'>='|'<'|'<='|'IN'|'NOT IN'|'BETWEEN'|'NOT BETWEEN'|''
 */
class Date_Query extends Clause_Abstract {
	/**
	 * Current clauses index in $this->clauses.
	 *
	 * @var int
	 */
	protected int $current_index = 0;


	/**
	 * Date to retrieve posts after (array version).
	 *
	 * @see Date_Query::after_string()
	 *
	 * @phpstan-param numeric-string $year
	 * @phpstan-param numeric-string $month
	 * @phpstan-param numeric-string $day
	 *
	 * @param ?string                $year
	 * @param ?string                $month
	 * @param ?string                $day
	 *
	 * @return $this
	 */
	public function after( string $year, ?string $month = null, ?string $day = null ) : Date_Query {
		$clause = \array_filter( \compact( 'year', 'month', 'day' ) );
		$this->update_current_clause( $clause, 'after' );
		return $this;
	}


	/**
	 * Date to retrieve posts after (string version).
	 *
	 * @see Date_Query::after()
	 *
	 * @param string $date - strtotime() compatible string.
	 *
	 * @return Date_Query
	 */
	public function after_string( string $date ) : Date_Query {
		$this->update_current_clause( $date, 'after' );
		return $this;
	}


	/**
	 * Date to retrieve posts before (array version).
	 *
	 * @see Date_Query::before_string()
	 *
	 * @phpstan-param numeric-string $year
	 * @phpstan-param numeric-string $month
	 * @phpstan-param numeric-string $day
	 *
	 * @param ?string                $year
	 * @param ?string                $month
	 * @param ?string                $day
	 *
	 * @return $this
	 */
	public function before( string $year, ?string $month = null, ?string $day = null ) : Date_Query {
		$clause = \array_filter( \compact( 'year', 'month', 'day' ) );
		$this->update_current_clause( $clause, 'before' );
		return $this;
	}


	/**
	 * Date to retrieve posts before (string version).
	 *
	 * @see Date_Query::before()
	 *
	 * @param string $date - strtotime() compatible string.
	 *
	 * @return Date_Query
	 */
	public function before_string( string $date ) : Date_Query {
		$this->update_current_clause( $date, 'before' );

		return $this;
	}


	/**
	 * Compare using a custom database column for the current clause.
	 *
	 * @see WP_Date_Query::validate_column()
	 * @see date_query_valid_columns filter
	 *
	 * @param string $column
	 *
	 * @return Date_Query
	 */
	public function column( string $column ) : Date_Query {
		$this->update_current_clause( $column, 'column' );
		return $this;
	}


	/**
	 * Compare operator for the current clause.
	 *
	 * @phpstan-param COMPARE $compare
	 *
	 * @param string          $compare
	 *
	 * @return Date_Query
	 */
	public function compare( string $compare ) : Date_Query {
		$this->update_current_clause( $compare, 'compare' );
		return $this;
	}


	/**
	 * Include results from dates specified in 'before' or 'after'
	 * in the current clause.
	 *
	 * Default false.
	 *
	 * @param bool $inclusive
	 *
	 * @return Date_Query
	 */
	public function inclusive( bool $inclusive = true ) : Date_Query {
		$this->update_current_clause( $inclusive, 'inclusive' );
		return $this;
	}


	/**
	 * The four-digit year number. Accepts any four-digit year,
	 * or an array of years if `$compare` supports it.
	 *
	 * @param int|int[] $year
	 *
	 * @return Date_Query
	 */
	public function year( $year ) : Date_Query {
		$this->update_current_clause( $year, 'year' );
		return $this;
	}


	/**
	 * The two-digit month number. Accept numbers 1-12, or an
	 * array of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<1,12>|array<int, int<1,12>> $month
	 *
	 * @param int|int[]                                $month
	 *
	 *
	 * @return Date_Query
	 */
	public function month( $month ) : Date_Query {
		$this->update_current_clause( $month, 'month' );
		return $this;
	}


	/**
	 * The week number of the year. Accept numbers 0-53, or an
	 * array of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<0,53>|array<int, int<0,53>> $week
	 *
	 * @param int|int[]                                $week
	 *
	 * @return Date_Query
	 */
	public function week( $week ) : Date_Query {
		$this->update_current_clause( $week, 'week' );
		return $this;
	}


	/**
	 * The day of the month. Accept numbers 1-31, or an array
	 * of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<1,31>|array<int, int<1,31>> $day
	 *
	 * @param int|int[]                                $day
	 *
	 */
	public function day( $day ) : Date_Query {
		$this->update_current_clause( $day, 'day' );
		return $this;
	}


	/**
	 * The hour of the day. Accept numbers 0-23, or an array
	 * of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<1,23>|array<int, int<1,23>> $hour
	 *
	 * @param int|int[]                                $hour
	 *
	 * @return Date_Query
	 */
	public function hour( $hour ) : Date_Query {
		$this->update_current_clause( $hour, 'hour' );
		return $this;
	}


	/**
	 * The minute of the hour. Accept numbers 0-59, or an array
	 * of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<0,59>|array<int, int<0,59>> $minute
	 *
	 * @param int|int[]                                $minute
	 *
	 * @return Date_Query
	 */
	public function minute( $minute ) : Date_Query {
		$this->update_current_clause( $minute, 'minute' );
		return $this;
	}


	/**
	 * The second of the minute. Accept numbers 0-59, or an
	 * array of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<0,59>|array<int, int<0,59>> $second
	 *
	 * @param int|int[]                                $second
	 *
	 * @return Date_Query
	 */
	public function second( $second ) : Date_Query {
		$this->update_current_clause( $second, 'second' );
		return $this;
	}


	/**
	 * The day number of the year. Accept numbers 1-366, or an
	 * array of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<1,366>|array<int, int<1,366>> $dayofyear
	 *
	 * @param int|int[]                                  $dayofyear
	 *
	 * @return Date_Query
	 */
	public function dayofyear( $dayofyear ) : Date_Query {
		$this->update_current_clause( $dayofyear, 'dayofyear' );
		return $this;
	}


	/**
	 * The day number of the week. Accept numbers 1-7 (1 is
	 * Sunday), or an array of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<1,7>|array<int, int<1,7>> $dayofweek
	 *
	 * @param int|int[]                              $dayofweek
	 *
	 * @return Date_Query
	 */
	public function dayofweek( $dayofweek ) : Date_Query {
		$this->update_current_clause( $dayofweek, 'dayofweek' );
		return $this;
	}


	/**
	 * The day number of the week (ISO). Accept numbers 1-7
	 * (1 is Monday), or an array of valid numbers if `$compare` supports it.
	 *
	 * @phpstan-param  int<1,7>|array<int, int<1,7>> $dayofweek_iso
	 *
	 * @param int|int[]                              $dayofweek_iso
	 *
	 * @return Date_Query
	 */
	public function dayofweek_iso( $dayofweek_iso ) : Date_Query {
		$this->update_current_clause( $dayofweek_iso, 'dayofweek_iso' );
		return $this;
	}


	/**
	 * Generate another clause for the date query.
	 *
	 * @see Date_QueryTest::test_next_clause() for example of the resulting array.
	 *
	 * @notice Do not use with a single taxonomy array.
	 *
	 * @return Date_Query
	 */
	public function next_clause() : Date_Query {
		if ( empty( $this->clauses['relation'] ) ) {
			$this->relation();
		}
		$this->clauses[] = [];
		$this->current_index = \array_key_last( $this->clauses );

		return $this;
	}


	/**
	 * Flatten the finished clauses into the date_query.
	 *
	 * @param Args|mixed $args_class - Args class, which supports properties this method will assign.
	 *
	 * @return void
	 */
	public function flatten( $args_class ) : void {
		$this->extract_nested( $this->clauses, $this );
		$args_class->date_query = $this->clauses;
	}


	/**
	 * Updates the current date_query clause.
	 *
	 * Date queries support sets of query clauses on multiple levels.
	 * This updates the current clause only.
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_query/#date-parameters
	 *
	 *
	 * @param string|int|bool|array<string|int|bool> $value
	 * @param string                                 $key
	 *
	 * @return void
	 */
	protected function update_current_clause( $value, string $key ) : void {
		if ( empty( $this->clauses[ $this->current_index ] ) ) {
			$this->clauses[ $this->current_index ] = [];
		}
		$this->clauses[ $this->current_index ] = \array_merge( $this->clauses[ $this->current_index ], [
			$key => $value,
		] );
	}
}
