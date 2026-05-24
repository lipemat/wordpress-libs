---
title: Util
parent: Modules
nav_order: 22
---

# Util

## Overview

The Util module gathers the library's general-purpose helpers: actions, arrays, autoloading, cache, colors, cryptography, files, logging, strings, testing, URLs, and version orchestration.

## Types in this module

- `Lipe\Lib\Util\Actions`
- `Lipe\Lib\Util\Arrays`
- `Lipe\Lib\Util\Autoloader`
- `Lipe\Lib\Util\Cache`
- `Lipe\Lib\Util\Colors`
- `Lipe\Lib\Util\Crypt`
- `Lipe\Lib\Util\Files`
- `Lipe\Lib\Util\Logger`
- `Lipe\Lib\Util\Strings`
- `Lipe\Lib\Util\Testing`
- `Lipe\Lib\Util\Url`
- `Lipe\Lib\Util\Versions`
- `Lipe\Lib\Util\Logger\Error_Log`
- `Lipe\Lib\Util\Logger\Handle` (interface)
- `Lipe\Lib\Util\Logger\Handles`
- `Lipe\Lib\Util\Logger\Level` (enum)
- `Lipe\Lib\Util\Logger\Query_Monitor`
- `Lipe\Lib\Util\Logger\Testing`
- `Lipe\Lib\Util\Logger\WithContext` (interface)

## `Actions`

Helper methods for advanced action/filter registration patterns.

### Key public methods

- `public function add_filter_as_action(string $filter, callable $callback, int $priority = 10): void`
- `public function add_action_all(array $actions, callable $callback, int $priority = 10): void`
- `public function add_filter_all(array $filters, callable $callback, int $priority = 10): void`
- `public function add_single_filter(string $filter, callable $callback, int $priority = 10): void`
- `public function add_single_action(string $action, callable $callback, int $priority = 10): void`
- `public function remove_action_always(string $action, callable $callback, int $priority = 10): void`
- `public function remove_filter_always(string $filter, callable $callback, int $priority = 10): void`

## `Arrays`

Array transformation helpers.

### Key public methods

- `public function chunk_to_associative(array $input_array): array`
- `public function clean(array $input_array, bool $preserve_keys = true): array`
- `public function map_recursive(callable $callback, array $input_array): array`
- `public function merge_recursive(array $args, array $defaults): array`
- `public function map_assoc(callable $callback, array $input_array): array`
- `public function find(array $items, callable $callback)`
- `public function find_index(array $items, callable $callback)`

## `Autoloader`

Simple namespace-to-path autoloader.

### Key public methods

- `public function __construct()`
- `public static function add(string $name_space, string $path): void`
- `public function register(bool $prepend = true): void`
- `public function unregister(): void`
- `public function maybe_load_class(string $class_name): void`

## `Cache`

Object-cache helper with support for complex keys and group flushing.

### Key public methods

- `public function hook(): void`
- `public function set(object|array|int|string $key, mixed $value, string $group = self::DEFAULT_GROUP, int $expire_in_seconds = 0): bool`
- `public function get(object|array|int|string $key, string $group = self::DEFAULT_GROUP): mixed`
- `public function delete(object|array|int|string $key, string $group = self::DEFAULT_GROUP): bool`
- `public function flush_group(string $group = self::DEFAULT_GROUP): void`
- `public function flush_runtime_cache(): void`

## Other utility classes

- `Colors` converts between `hex` and `rgba` via `hex_to_rgba()` and `rgba_to_hex()`.
- `Crypt` encrypts and decrypts strings via `encrypt()`, `decrypt()`, `is_encrypted()`, and `factory()`.
- `Files` exposes `copy_directory()` and `get_wp_filesystem()`.
- `Strings` provides `pluralize()` and `unformat_money_value()`.
- `Testing` wraps test-only behaviors such as `exit()`, `error_log()`, and `is_wp_debug()`.
- `Url` provides `get_current_url()` and `get_query_arg()`.
- `Versions` coordinates one-time and versioned updates through `get_version()`, `once()`, and `add_update()`.

## Logging subsystem

- `Logger` is the main entry point and exposes `warn()`, `error()`, `notice()`, `debug()`, and `factory()`.
- `Logger\Handle` defines `public function log(string $id, Level $level, string $message): void`.
- `Logger\WithContext` adds `public function provide_context(array $context): void`.
- `Logger\Handles` stores named log handles via `get_handles()`, `register_handle()`, and `unregister_handle()`.
- `Logger\Error_Log`, `Logger\Query_Monitor`, and `Logger\Testing` are concrete handle implementations.
- `Logger\Level` is the enum of supported log levels.

### Example

```php
<?php
use Lipe\Lib\Util\Logger;

Logger::factory('acme/books')->notice('Catalog synchronized', ['count' => 12]);
```
