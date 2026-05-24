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
- `Lipe\Lib\Query\Clause\Date_Query_Interface`
- `Lipe\Lib\Query\Clause\Date_Query_Trait`
- `Lipe\Lib\Query\Clause\Meta_Query`
- `Lipe\Lib\Query\Clause\Meta_Query_Interface`
- `Lipe\Lib\Query\Clause\Meta_Query_Trait`
- `Lipe\Lib\Query\Clause\Tax_Query`
- `Lipe\Lib\Query\Clause\Tax_Query_Interface`
- `Lipe\Lib\Query\Clause\Tax_Query_Trait`

## `Query_Args`

Primary fluent wrapper for building a `WP_Query` argument array.

### Key public methods

- `public function orderby(array|string $orderby, string $order = ''): void`
- `public function merge_query(\WP_Query $query): void`
- `public function get_light_args(): array`
- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

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

## Clause builders

### `Date_Query`

Builds a nested `date_query` structure.

Key methods:

- `public function after(string $year, ?string $month = null, ?string $day = null): Date_Query`
- `public function before(string $year, ?string $month = null, ?string $day = null): Date_Query`
- `public function compare(string $compare): Date_Query`
- `public function inclusive(bool $inclusive = true): Date_Query`
- `public function next_clause(): Date_Query`
- `public function flatten(ArgsRules $args_class): void`

### `Meta_Query`

Builds `meta_query` clauses.

Key methods:

- `public function equals($key, string $value): Meta_Query`
- `public function like($key, string $value): Meta_Query`
- `public function in($key, array $values): Meta_Query`
- `public function exists($key): Meta_Query`
- `public function advanced(string $type = '', string $compare_key = '', string $type_key = ''): Meta_Query`
- `public function flatten(ArgsRules $args_class): void`

### `Tax_Query`

Builds `tax_query` clauses.

Key methods:

- `public function and(array $terms, string $taxonomy, bool $children = true, string $field = 'term_id'): Tax_Query`
- `public function in(array $terms, string $taxonomy, bool $children = true, string $field = 'term_id'): Tax_Query`
- `public function not_in(array $terms, string $taxonomy, bool $children = true, string $field = 'term_id'): Tax_Query`
- `public function exists(string $taxonomy): Tax_Query`
- `public function flatten(ArgsRules $args_class): void`

## Query traits and helpers

- `Date_Query_Interface`, `Meta_Query_Interface`, and `Tax_Query_Interface` expose the `date_query()`, `meta_query()`, and `tax_query()` factories.
- `Date_Query_Trait`, `Meta_Query_Trait`, and `Tax_Query_Trait` add those factories to consuming query classes.
- `Utils` exposes `public function get_light_query_args(array $args): array` for aggressively minimizing a query.
