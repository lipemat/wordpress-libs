---
title: Query
parent: Modules
nav_order: 14
---

# Query

## Overview

The Query module builds `WP_Query`, `get_posts()`, and reusable nested query clauses. It is one of the main consumers of the shared `Args` and `Clause` infrastructure.

## Types in this module

- `Lipe\Lib\Query\Get_Posts`
- `Lipe\Lib\Query\Query_Args`
- `Lipe\Lib\Query\Utils`
- `Lipe\Lib\Query\Clause\Date_Query`
- `Lipe\Lib\Query\Clause\Date_Query_Interface` (interface)
- `Lipe\Lib\Query\Clause\Date_Query_Trait` (trait)
- `Lipe\Lib\Query\Clause\Meta_Query`
- `Lipe\Lib\Query\Clause\Meta_Query_Interface` (interface)
- `Lipe\Lib\Query\Clause\Meta_Query_Trait` (trait)
- `Lipe\Lib\Query\Clause\Tax_Query`
- `Lipe\Lib\Query\Clause\Tax_Query_Interface` (interface)
- `Lipe\Lib\Query\Clause\Tax_Query_Trait` (trait)

## `Query_Args`

Primary fluent wrapper for building a `WP_Query` argument array.

### Key public methods

- `public function orderby(array|string $orderby, string $order = ''): void`
- `public function merge_query(\WP_Query $query): void`
- `public function get_light_args(): array`
- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

`Query_Args` also implements `Date_Query_Interface`, `Meta_Query_Interface`, and `Tax_Query_Interface`, adding the `date_query()`, `meta_query()`, and `tax_query()` factories documented below.

### Example

```php
<?php
use Lipe\Lib\Query\Query_Args;

$query = new Query_Args([]);
$query->post_type = 'book';
$query->posts_per_page = 12;
$query->orderby('menu_order', 'ASC');

$posts = new WP_Query($query->get_args());
```

## `Get_Posts`

Specialized `get_posts()` wrapper that extends `Query_Args` with aliases such as `numberposts`, `category`, `include`, and `exclude`.

## `Utils`

Singleton helper that returns the lightest possible `WP_Query` arguments by disabling found-row counting, term/meta cache priming, and limiting to published posts.

### Key public methods

- `public function get_light_query_args(array $args): array`

## `Date_Query`

Fluent builder for the nested `date_query` argument of a `WP_Query`. Obtained via `Query_Args::date_query()` rather than constructed directly.

### Key public methods

- `public function after(string $year, ?string $month = null, ?string $day = null): static`
- `public function after_string(string $date): static`
- `public function before(string $year, ?string $month = null, ?string $day = null): static`
- `public function before_string(string $date): static`
- `public function column(string $column): static`
- `public function compare(string $compare): static`
- `public function inclusive(bool $inclusive = true): static`
- `public function year(array|int $year): static`
- `public function month(array|int $month): static`
- `public function week(array|int $week): static`
- `public function day(array|int $day): static`
- `public function hour(array|int $hour): static`
- `public function minute(array|int $minute): static`
- `public function second(array|int $second): static`
- `public function dayofyear(array|int $dayofyear): static`
- `public function dayofweek(array|int $dayofweek): static`
- `public function dayofweek_iso(array|int $dayofweek_iso): static`
- `public function next_clause(): static`
- `public function flatten(ArgsRules $args_class): void`

Also inherits the nested-clause plumbing from `Args\Clause` (`__construct()`, `set_parent_clause()`, `relation()`, `nested_clause()`, `parent_clause()`, `set_is_flattended()`, `is_flattended()`) — see the [Args module](args.md).

### Example

```php
<?php
use Lipe\Lib\Query\Query_Args;

$query = new Query_Args([]);
$query->date_query()
      ->after('2020', '01', '01')
      ->before('2020', '12', '31')
      ->inclusive();

$posts = new WP_Query($query->get_args());
```

## `Date_Query_Interface` interface

Contract for argument objects that expose a `date_query()` factory.

### Methods

- `public function date_query(): Date_Query`

## `Date_Query_Trait` trait

Adds the `date_query()` factory (and its backing `$date_query` property) to a fluent args class.

### Key public methods

- `public function date_query(): Date_Query`

## `Meta_Query`

Fluent builder for the nested `meta_query` argument of a `WP_Query`, `Get_Terms`, and similar. Obtained via `meta_query()` rather than constructed directly.

### Key public methods

- `public function equals($key, string $value): static`
- `public function not_equals($key, string $value): static`
- `public function greater_than($key, string $value): static`
- `public function greater_than_or_equal($key, string $value): static`
- `public function less_than($key, string $value): static`
- `public function less_than_or_equal($key, string $value): static`
- `public function like($key, string $value): static`
- `public function not_like($key, string $value): static`
- `public function in($key, array $values): static`
- `public function not_in($key, array $values): static`
- `public function between($key, array $values): static`
- `public function not_between($key, array $values): static`
- `public function exists($key): static`
- `public function not_exists($key): static`
- `public function advanced(string $type = '', string $compare_key = '', string $type_key = ''): static`
- `public function flatten(ArgsRules $args_class): void`

Also inherits the nested-clause plumbing from `Args\Clause` (`__construct()`, `set_parent_clause()`, `relation()`, `nested_clause()`, `parent_clause()`, `set_is_flattended()`, `is_flattended()`) — see the [Args module](args.md).

### Example

```php
<?php
use Lipe\Lib\Query\Query_Args;

$query = new Query_Args([]);
$query->meta_query()->equals('featured', '1');

$posts = new WP_Query($query->get_args());
```

## `Meta_Query_Interface` interface

Contract for argument objects that expose a `meta_query()` factory.

### Methods

- `public function meta_query(): Meta_Query`

## `Meta_Query_Trait` trait

Adds the `meta_query()` factory, its backing `$meta_query` property, and the top-level `$meta_key`, `$meta_value`, `$meta_compare`, `$meta_compare_key`, `$meta_type`, and `$meta_type_key` properties to a fluent args class.

### Key public methods

- `public function meta_query(): Meta_Query`

## `Tax_Query`

Fluent builder for the nested `tax_query` argument of a `WP_Query`. Obtained via `Query_Args::tax_query()` rather than constructed directly.

### Key public methods

- `public function and(array $terms, string $taxonomy, bool $children = true, string $field = 'term_id'): static`
- `public function in(array $terms, string $taxonomy, bool $children = true, string $field = 'term_id'): static`
- `public function not_in(array $terms, string $taxonomy, bool $children = true, string $field = 'term_id'): static`
- `public function exists(string $taxonomy): static`
- `public function not_exists(string $taxonomy): static`
- `public function flatten(ArgsRules $args_class): void`

Also inherits the nested-clause plumbing from `Args\Clause` (`__construct()`, `set_parent_clause()`, `relation()`, `nested_clause()`, `parent_clause()`, `set_is_flattended()`, `is_flattended()`) — see the [Args module](args.md).

### Example

```php
<?php
use Lipe\Lib\Query\Query_Args;

$query = new Query_Args([]);
$query->tax_query()->in(['fiction'], 'genre', false, 'slug');

$posts = new WP_Query($query->get_args());
```

## `Tax_Query_Interface` interface

Contract for argument objects that expose a `tax_query()` factory.

### Methods

- `public function tax_query(): Tax_Query`

## `Tax_Query_Trait` trait

Adds the `tax_query()` factory, its backing `$tax_query` property, and the classic category/tag properties (`$cat`, `$category__and`, `$category__in`, `$category__not_in`, `$category_name`, `$tag`, `$tag__and`, `$tag__in`, `$tag__not_in`, `$tag_id`, `$tag_slug__and`, `$tag_slug__in`) to a fluent args class.

### Key public methods

- `public function tax_query(): Tax_Query`
