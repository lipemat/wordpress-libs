---
title: Args
parent: Modules
nav_order: 2
---

# Args

## Overview

The Args module supplies the reusable fluent-argument system used by most builders in the library. It includes interfaces for argument objects, nested clause support for query sub-structures, and small helpers for reflecting public properties into finished arrays.

## Types in this module

- `Lipe\Lib\Args\Args` (trait)
- `Lipe\Lib\Args\ArgsRules` (interface)
- `Lipe\Lib\Args\Clause` (trait)
- `Lipe\Lib\Args\ClauseRules` (interface)
- `Lipe\Lib\Args\Utils`

## `Args` trait

Shared implementation used by fluent wrappers such as query builders, block builders, and menu/settings argument objects.

### Key public methods

- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

## `ArgsRules` interface

Contract implemented by argument objects that can be initialized from arrays and converted back into finished arguments.

### Methods

- `public function __construct(array $existing)`
- `public function get_args(): array`
- `public function merge(ArgsRules $overrides): void`

## `Clause` trait

Adds nested clause support for complex query objects such as `meta_query`, `tax_query`, and `date_query`.

### Key public methods

- `public function __construct()`
- `public function set_parent_clause(ClauseRules $parent_clause): void`
- `public function relation(string $relation = 'AND'): ClauseRules`
- `public function nested_clause(string $relation = 'AND'): ClauseRules`
- `public function parent_clause(): ClauseRules`
- `public function set_is_flattended(bool $is_flattended): void`
- `public function is_flattended(): bool`

## `ClauseRules` interface

Defines the required behavior for nested clause objects.

### Methods

- `public function __construct()`
- `public function set_parent_clause(ClauseRules $parent_clause): void`
- `public function flatten(ArgsRules $args_class): void`
- `public function relation(string $relation = 'AND'): ClauseRules`
- `public function nested_clause(string $relation = 'AND'): ClauseRules`
- `public function parent_clause(): ClauseRules`

## `Utils`

Utility helper for converting public object properties into arrays.

### Key public methods

- `public function get_public_object_vars(object $this_object): array`

### Example

```php
<?php
use Lipe\Lib\Query\Query_Args;

$query = new Query_Args([]);
$query->post_type = 'book';
$query->posts_per_page = 10;

$args = $query->get_args();
```

Most end-user code will interact with the Args module indirectly through classes such as `Query_Args`, `Register_Rest_Route`, `Wp_Nav_Menu`, or `Register_Setting`.
