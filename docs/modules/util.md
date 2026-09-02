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
- `public function add_filter_during(string $filter, callable $callback, string $start, string $end, int $priority = 10): void`
- `public function add_looping_action(string $action, callable $callback, int $priority = 10): void`
- `public function add_looping_filter(string $filter, callable $callback, int $priority = 10): void`

## `Arrays`

Array transformation helpers.

### Key public methods

- `public function chunk_to_associative(array $input_array): array`
- `public function clean(array $input_array, bool $preserve_keys = true): array`
- `public function map_recursive(callable $callback, array $input_array): array`
- `public function merge_recursive(array $args, array $defaults): array`
- `public function map_assoc(callable $callback, array $input_array): array`
- `public function recursive_unset(string $key, array $input_array): array`
- `public function flatten_assoc(callable $callback, array $input_array): array`
- `public function list_pluck(array $input_array, array $keys): array`

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
- `public function add_admin_bar_button(\WP_Admin_Bar $admin_bar): void`

## `Colors`

Convert colors between hexadecimal and rgb(a) notation.

### Key public methods

- `public function hex_to_rgba(string $color, float $transparency = 1.0): string`
- `public function rgba_to_hex(string $rgba): string`

### Example

```php
<?php
use Lipe\Lib\Util\Colors;

$rgba = Colors::in()->hex_to_rgba('#ff0000', 0.5);
// rgba(255,0,0,0.5)
```

## `Crypt`

Encrypts and decrypts strings using a custom key, compatible with JS encryption/decryption via `crypto-js`.

### Key public methods

- `public function __construct(string $key)`
- `public function decrypt(string $message): ?string`
- `public function encrypt(string $plaintext): ?string`
- `public static function is_encrypted(string $data): bool`
- `public static function factory(string $key): static`

### Example

```php
<?php
use Lipe\Lib\Util\Crypt;

$crypt = Crypt::factory('my-secret-key');
$encrypted = $crypt->encrypt('sensitive data');
$decrypted = $crypt->decrypt($encrypted);
```

## `Files`

Filesystem helpers backed by the WordPress filesystem API.

### Key public methods

- `public function copy_directory(string $source, string $destination): bool`
- `public function get_wp_filesystem(): \WP_Filesystem_Base`

## `Logger`

Main entry point for logging messages to all registered log handles.

### Key public methods

- `public function warn(string $message, array $context = []): void`
- `public function error(string $message, array $context = []): void`
- `public function notice(string $message, array $context = []): void`
- `public function debug(string $message, array $context = []): void`
- `public static function factory(string $id): static`

### Example

```php
<?php
use Lipe\Lib\Util\Logger;

Logger::factory('acme/books')->notice('Catalog synchronized', ['count' => 12]);
```

## `Strings`

String utilities.

### Key public methods

- `public function pluralize(string $word): string`
- `public function unformat_money_value(string|int|float $value): float`

## `Testing`

Utility class for testing purposes, including a test-safe `exit()` and error capture.

### Key public methods

- `public function exit(): void`
- `public function error_log(string $message): void`
- `public function is_wp_debug(): bool`

## `Url`

Url helpers.

### Key public methods

- `public function get_current_url(bool $with_query = true): string`
- `public function get_query_arg(string $url, string $key): array|string|null`

## `Versions`

Run callable based on a version or simply run an item only once.

### Key public methods

- `public function get_version(): string`
- `public function once(string $key, callable $callback, mixed $args = null): void`
- `public function add_update(float|string $version, callable $callback, mixed $args = null): void`

### Example

```php
<?php
use Lipe\Lib\Util\Versions;

Versions::in()->add_update('2.0', function( $args ) {
    // Run only when the stored version is below 2.0.
}, ['migrate' => true] );

Versions::in()->once('acme/seed-data', function() {
    // Run exactly once, ever.
} );
```

## `Error_Log`

Logs messages to the PHP error log. Implements `Logger\Handle`.

### Key public methods

- `public function provide_context(array $context): void`
- `public function log(string $id, Level $level, string $message): void`

## `Handle`

Contract for a Logger handle.

### Methods

- `public function log(string $id, Level $level, string $message): void`
- `public function provide_context(array $context): void`

## `Handles`

Registered handles for the Logger. Registers `query-monitor` and `error-log` handles by default, plus `testing` when `WP_TESTS_DIR` is defined.

### Key public methods

- `public function __construct()`
- `public function get_handles(): array`
- `public function register_handle(string $name, Handle $handle): void`
- `public function unregister_handle(string $name): void`

## `Level`

Enum of supported log severity levels: `Debug`, `Notice`, `Warning`, `Error`.

## `Query_Monitor`

Logs messages to the Query Monitor plugin. Implements `Logger\Handle`.

### Key public methods

- `public function provide_context(array $context): void`
- `public function log(string $id, Level $level, string $message): void`

## `Testing` (Logger\Testing)

Stores log messages during unit tests. Implements `Logger\Handle`.

### Key public methods

- `public function get_messages(bool $with_context = false): array`
- `public function provide_context(array $context): void`
- `public function log(string $id, Level $level, string $message): void`
