---
title: Db
parent: Modules
nav_order: 8
---

# Db

## Overview

The Db module focuses on custom database tables. `Table` defines the schema contract, and `Custom_Table` implements common CRUD operations on top of `wpdb`.

## Types in this module

- `Lipe\Lib\Db\Table` (interface)
- `Lipe\Lib\Db\Custom_Table`

## `Table`

Schema contract for a custom table.

### Methods

- `public function get_column_formats(): array`
- `public function get_id_field(): string`
- `public function get_table_base(): string`

## `Custom_Table`

High-level helper for reading and writing rows in a custom table.

### Key public methods

- `public function table(): string`
- `public function get(array $where = [], ?int $count = null, ?string $order_by = null, string $order = 'ASC'): array`
- `public function get_one(array $where = [], ?string $order_by = null, string $order = 'ASC'): ?array`
- `public function get_paginated(int $page, int $per_page, array $where = [], ?string $order_by = null, string $order = 'ASC'): array`
- `public function get_by_id(int $id): ?array`
- `public function add(array $columns): ?int`
- `public function delete(int $id): bool`
- `public function delete_where(array $where): bool|int`
- `public function update(int $id, array $columns): bool`
- `public function update_where(array $where, array $columns): bool|int`
- `public function replace(array $columns): int|bool`
- `public function get_select_query(array $columns, array $where, ?int $count = null, ?string $order_by = null, string $order = 'ASC', ?int $offset = null): string`
- `public function get_wpdb(): \wpdb`
- `public static function factory(Table $config): static`

### Example

```php
<?php
use Lipe\Lib\Db\Custom_Table;
use Lipe\Lib\Db\Table;

final class Book_Table implements Table {
    public function get_column_formats(): array { return ['ID' => '%d', 'title' => '%s']; }
    public function get_id_field(): string { return 'ID'; }
    public function get_table_base(): string { return 'acme_books'; }
}

$books = Custom_Table::factory(new Book_Table());
$books->add(['title' => 'Domain-Driven WordPress']);
```
