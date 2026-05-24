---
title: Site
parent: Modules
nav_order: 17
---

# Site

## Overview

The Site module provides a trait for wrapping a `WP_Site` object on multisite installations.

## Types in this module

- `Lipe\Lib\Site\Site_Trait`

## `Site_Trait`

Shared behavior for classes representing a single site.

### Key public methods

- `public function get_object(): ?\WP_Site`
- `public function get_id(): int`
- `public function get_meta_type(): MetaType`
- `public function exists(): bool`
- `public static function factory(null|int|\WP_Site $site = null): static`

### Example

```php
<?php
use Lipe\Lib\Site\Site_Trait;

final class Current_Site {
    use Site_Trait;
}

$site = Current_Site::factory(get_current_blog_id());
```
