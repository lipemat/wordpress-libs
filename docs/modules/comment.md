---
title: Comment
parent: Modules
nav_order: 5
---

# Comment

## Overview

The Comment module wraps comment objects and common comment operations. It includes an object trait for domain objects backed by `WP_Comment`, a fluent `get_comments()` builder, and an update/insert builder for persisting comments.

## Types in this module

- `Lipe\Lib\Comment\Comment_Trait`
- `Lipe\Lib\Comment\Get_Comments`
- `Lipe\Lib\Comment\Update_Comment`

## `Comment_Trait`

Shared behavior for classes that wrap a single WordPress comment and want meta access through the library's meta tools.

### Key public methods

- `public function get_object(): ?\WP_Comment`
- `public function get_id(): int`
- `public function get_meta_type(): MetaType`
- `public function get_comment_post(): ?\WP_Post`
- `public function exists(): bool`
- `public static function factory(int|\WP_Comment $comment): static`

## `Get_Comments`

Fluent query object for `get_comments()` with date and meta clause support.

### Key public methods

- `public function orderby(array|string $orderby, string $order = ''): void`
- `public function merge_query(\WP_Comment_Query $query): void`
- `public function get_light_args(): array`

### Example

```php
<?php
use Lipe\Lib\Comment\Get_Comments;

$query = new Get_Comments([]);
$query->post_id = 42;
$query->number = 10;

$comments = get_comments($query->get_args());
```

## `Update_Comment`

Fluent wrapper for `wp_insert_comment()` and `wp_update_comment()`.

This class is primarily property-driven through the shared args system; populate the fields WordPress expects, then pass `get_args()` into the core insert/update function.
