---
title: Menu
parent: Modules
nav_order: 10
---

# Menu

## Overview

The Menu module provides a fluent argument object for `wp_nav_menu()` and a trait for working with nav menu item posts returned by WordPress.

## Types in this module

- `Lipe\Lib\Menu\Menu_Item_Trait`
- `Lipe\Lib\Menu\Wp_Nav_Menu`

## `Menu_Item_Trait`

Shared wrapper behavior for `nav_menu_item` posts.

### Key public methods

- `public function get_object(): ?\WP_Post`
- `public function exists(): bool`
- `public static function factory(int|\WP_Post $post): static`

## `Wp_Nav_Menu`

A fluent argument object for `wp_nav_menu()`.

### Key public methods

Inherited from `Lipe\Lib\Args\Args`:

- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\Menu\Wp_Nav_Menu;

$args = new Wp_Nav_Menu([]);
$args->theme_location = 'primary';
$args->container = 'nav';
$args->menu_class = 'site-nav';

wp_nav_menu($args->get_args());
```
