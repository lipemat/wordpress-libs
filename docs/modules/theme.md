---
title: Theme
parent: Modules
nav_order: 19
---

# Theme

## Overview

The Theme module contains helpers for front-end assets, manifest-driven script loading, CSS module classes, templates, sidebars, and small HTML utility types used by themes.

## Types in this module

- `Lipe\Lib\Theme\CSS_Modules`
- `Lipe\Lib\Theme\Class_Names`
- `Lipe\Lib\Theme\Dashicons` (enum)
- `Lipe\Lib\Theme\Register_Sidebar`
- `Lipe\Lib\Theme\Resources`
- `Lipe\Lib\Theme\Template`
- `Lipe\Lib\Theme\Wp_Enqueue_Script`
- `Lipe\Lib\Theme\Wp_Enqueue_Script_Module`
- `Lipe\Lib\Theme\Scripts\Common`
- `Lipe\Lib\Theme\Scripts\Config` (interface)
- `Lipe\Lib\Theme\Scripts\Enqueue`
- `Lipe\Lib\Theme\Scripts\External_Manifest`
- `Lipe\Lib\Theme\Scripts\JS_Manifest`
- `Lipe\Lib\Theme\Scripts\Manifest` (interface)
- `Lipe\Lib\Theme\Scripts\PCSS_Manifest`
- `Lipe\Lib\Theme\Scripts\ResourceHandles` (interface)
- `Lipe\Lib\Theme\Scripts\Svelte_Manifest`
- `Lipe\Lib\Theme\Scripts\Util`

## `Resources`

General-purpose theme resource helper for versions, hashes, body classes, integrity, and CDN-related behavior.

### Key public methods

- `public function get_revision(): ?string`
- `public function get_content_hash(string $url): ?string`
- `public function get_file_modified_time(string $url): ?int`
- `public function get_site_root(): string`
- `public function live_reload(?string $domain = null, bool $admin_also = false): void`
- `public function add_body_class(string|\BackedEnum $css_class): void`
- `public function crossorigin_javascript(string $handle, ?string $value = null): void`
- `public function integrity_javascript(string $handle, string $integrity): void`
- `public function use_cdn_for_resources(array $handles): void`
- `public function unpkg_integrity(string $handle, string $url): bool`

### Example

```php
<?php
use Lipe\Lib\Theme\Resources;

Resources::in()->add_body_class('has-library-assets');
$revision = Resources::in()->get_revision();
```

## `CSS_Modules`

Loads JSON class maps produced by CSS Modules.

### Key public methods

- `public function set_path(string $path, string $file_prepend = ''): void`
- `public function use_combined_file(string $filename): void`
- `public function styles(string $file): array`

## `Class_Names`

Collects and normalizes CSS class names.

### Key public methods

- `public function __construct(...$classes)`
- `public function get_classes(): array`
- `public function push(string|\BackedEnum $class_name): void`
- `public function __toString()`

## `Template`

Theme template helpers.

### Key public methods

- `public function esc_attr(array $attributes): string`
- `public function get_template_contents(string $slug, ?string $name = null, $args = []): string`
- `public function sanitize_html_class(string $css_class): string`

## Script arg objects and resource manifests

- `Wp_Enqueue_Script` is the args wrapper for `wp_enqueue_script()` and stores properties such as `strategy`, `in_footer`, and `fetchpriority`.
- `Wp_Enqueue_Script_Module` is the corresponding wrapper for `wp_enqueue_script_module()`.
- `Scripts\Common` centralizes shared theme asset bootstrapping and exposes `init_once()`, `remove_scripts()`, `include_styles_in_editor()`, `support_block_inline_styles()`, `admin_scripts()`, `block_scripts()`, `theme_scripts()`, `revision_header()`, `load_css_enums()`, and `factory()`.
- `Scripts\Enqueue` and the manifest classes (`External_Manifest`, `JS_Manifest`, `PCSS_Manifest`, `Svelte_Manifest`) know how to register or enqueue resources and expose methods such as `enqueue()`, `register()`, `get_file()`, `get_version()`, and `get_integrity()`.
- `Scripts\Manifest` and `Scripts\ResourceHandles` define the contracts those loaders depend on.
- `Scripts\Config` supplies `public function js_config(): array` for browser configuration.
- `Scripts\Util` adds helper methods such as `public function is_webpack_running(ResourceHandles $handle): bool` and `public function is_javascript_resource(ResourceHandles $handle): bool`.

## Additional theme helpers

- `Dashicons` enumerates core dashicon values and exposes `public function icon(string|\BackedEnum $class_name = ''): string`.
- `Register_Sidebar` is the fluent args wrapper for `register_sidebar()`.
