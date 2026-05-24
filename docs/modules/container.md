---
title: Container
parent: Modules
nav_order: 6
---

# Container

## Overview

The Container module provides a tiny service container plus traits that make singleton-style instance lookup and WordPress hook initialization consistent across the library.

## Types in this module

- `Lipe\Lib\Container\Contain` (interface)
- `Lipe\Lib\Container\Container`
- `Lipe\Lib\Container\Factory` (trait)
- `Lipe\Lib\Container\Hooks` (trait)
- `Lipe\Lib\Container\Instance` (trait)

## `Contain`

Interface for dependency injection containers.

### Methods

- `public function __construct()`
- `public function get_service(string $id): ?object`
- `public function set_service(string $id, object $class_instance): void`
- `public function set_factory(string $id, \Closure $factory): void`
- `public function get_factory(string $id): ?\Closure`
- `public function set_initialized(string $id): void`
- `public function is_initialized(string $id): bool`
- `public static function reset(): void`
- `public static function instance(): static`

## `Container`

Stores services, factories, and per-class initialization state.

### Key public methods

- `public function __construct()`
- `public function get_service(string $id): ?object`
- `public function set_service(string $id, object $class_instance): void`
- `public function set_factory(string $id, \Closure $factory): void`
- `public function get_factory(string $id): ?\Closure`
- `public function set_initialized(string $id): void`
- `public function is_initialized(string $id): bool`
- `public static function reset(): void`
- `public static function instance(): static`

### Example

```php
<?php
use Lipe\Lib\Container\Container;

$container = Container::instance();
$container->set_service(stdClass::class, new stdClass());

$service = $container->get_service(stdClass::class);
```

## `Factory` trait

Trait used by object wrappers that should be constructed through a container-backed factory.

## `Hooks` trait

Provides standardized bootstrapping hooks.

### Key public methods

- `public static function init(): void`
- `public static function init_once(): void`

## `Instance` trait

Provides shared instance lookup helpers.

### Key public methods

- `public static function instance(): static`
- `public static function in(): static`
