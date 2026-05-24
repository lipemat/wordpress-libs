---
title: Network
parent: Modules
nav_order: 12
---

# Network

## Overview

The Network module provides a trait for wrapping a `WP_Network` object and reading or writing network-level metadata from the `sitemeta` table.

## Types in this module

- `Lipe\Lib\Network\Network_Trait`

## `Network_Trait`

Shared behavior for classes representing a multisite network.

### Key public methods

- `public function __construct($network = null)`
- `public function get_object(): ?\WP_Network`
- `public function get_id(): int`
- `public function get_meta(string $key, mixed $default_value = null)`
- `public function update_meta(string $key, ...$value): void`
- `public function delete_meta(string $key): void`
- `public function get_meta_type(): MetaType`
- `public function exists(): bool`
- `public static function factory(null|int|\WP_Network $network = null): static`

### Example

```php
<?php
use Lipe\Lib\Network\Network_Trait;

final class Current_Network {
    use Network_Trait;
}

$network = Current_Network::factory();
$network->update_meta('banner_text', 'Hello network');
```
