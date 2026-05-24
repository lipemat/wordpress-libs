---
title: Traits
parent: Modules
nav_order: 20
---

# Traits

## Overview

The Traits module contains the most reusable cross-cutting helpers in the library: memoization, singleton lifecycle management, and version-based one-time migrations.

## Types in this module

- `Lipe\Lib\Traits\Memoize`
- `Lipe\Lib\Traits\Singleton`
- `Lipe\Lib\Traits\Version`

## `Memoize`

Caches method results in memory and, when needed, persistent object cache storage.

### Key public methods

- `public function persistent(callable $callback, string $identifier, $expire = 0, ...$args): mixed`
- `public function once(callable $callback, string $identifier, ...$args): mixed`
- `public function memoize(callable $callback, string $identifier, ...$args): mixed`
- `public function static_once(callable $callback, string $identifier, ...$args): mixed`
- `public function clear_single_item(string $identifier, ...$args): bool`
- `public function clear_memoize_cache(): void`

### Example

```php
<?php
use Lipe\Lib\Traits\Memoize;

final class Expensive_Service {
    use Memoize;

    public function ids(): array {
        return $this->once(fn () => [1, 2, 3], __METHOD__);
    }
}
```

## `Singleton`

Provides the common `init`, `init_once`, `instance`, and `in` accessors used throughout the package.

### Key public methods

- `public static function init(): void`
- `public static function init_once(): void`
- `public static function in(): static`
- `public static function instance(): static`

## `Version`

Tracks per-class versions so migrations or setup callbacks only run once per version.

`Version` exposes protected helpers in source, centered around `run_for_version()`, and is used internally by classes such as `Api` to trigger one-time upgrade work.
