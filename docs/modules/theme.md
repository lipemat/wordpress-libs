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
- `Lipe\Lib\Theme\Icons` (enum)
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

## `CSS_Modules`

Loads JSON class maps produced by CSS Modules.

### Key public methods

- `public function set_path(string $path, string $file_prepend = ''): void`
- `public function use_combined_file(string $filename): void`
- `public function styles(string $file): array`

### Example

```php
<?php
use Lipe\Lib\Theme\CSS_Modules;

CSS_Modules::in()->set_path(get_stylesheet_directory() . '/dist/css');
$styles = CSS_Modules::in()->styles('home/header');
```

## `Class_Names`

Collects and normalizes CSS class names, mirrored after the npm `classnames` package. Implements `\ArrayAccess` for conditionally toggling classes.

### Key public methods

- `public function __construct(...$classes)`
- `public function get_classes(): array`
- `public function push(string|\BackedEnum $class_name): void`
- `public function __toString()`
- `public function offsetExists($offset): bool`
- `public function offsetGet($offset): string`
- `public function offsetSet($offset, $value): void`
- `public function offsetUnset($offset): void`

### Example

```php
<?php
use Lipe\Lib\Theme\Class_Names;

$classes = new Class_Names('card', [
    'card--active'   => $is_active,
    'card--featured' => $is_featured,
]);

printf('<div class="%s">', esc_attr((string) $classes));
```

## `Dashicons`

Enum of every WordPress core dashicon plus a helper to render an icon tag.

### Key public methods

- `public function icon(string|\BackedEnum $class_name = ''): string`

### Example

```php
<?php
use Lipe\Lib\Theme\Dashicons;

echo Dashicons::ADMIN_HOME->icon('my-custom-class');
```

## `Icons`

Enum mapping to the WP 7.0+ `@wordpress/icons` registry plus helpers to render an icon tag or resolve its SVG URL.

### Key public methods

- `public function icon(string|\BackedEnum $class_name = ''): string`
- `public function svg_url(): string`

### Example

```php
<?php
use Lipe\Lib\Theme\Icons;

echo Icons::SEARCH->icon();
```

## `Register_Sidebar`

A fluent argument object for `register_sidebar()`.

### Key public methods

Inherited from `Lipe\Lib\Args\Args`:

- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\Theme\Register_Sidebar;

$args = new Register_Sidebar([]);
$args->name          = 'Footer Widgets';
$args->id            = 'footer-widgets';
$args->before_widget = '<li id="%1$s" class="widget %2$s">';
$args->after_widget  = '</li>';

register_sidebar($args->get_args());
```

## `Resources`

General-purpose theme resource helper for versions, hashes, body classes, and script `crossorigin`/`integrity` attributes.

### Key public methods

- `public function get_revision(): ?string`
- `public function get_content_hash(string $url): ?string`
- `public function get_file_modified_time(string $url): ?int`
- `public function get_site_root(): string`
- `public function live_reload(?string $domain = null, bool $admin_also = false, ?ResourceHandles $css_handle = null): void`
- `public function add_body_class(string|\BackedEnum $css_class): void`
- `public function crossorigin_javascript(string $handle, ?string $value = null): void`
- `public function integrity_javascript(string $handle, string $integrity): void`

### Example

```php
<?php
use Lipe\Lib\Theme\Resources;

Resources::in()->add_body_class('has-library-assets');
$revision = Resources::in()->get_revision();
```

## `Template`

Theme template helpers for attributes, template parts, and CSS class sanitization.

### Key public methods

- `public function esc_attr(array $attributes): string`
- `public function get_template_contents(string $slug, ?string $name = null, $args = []): string`
- `public function sanitize_html_class(string $css_class): string`

### Example

```php
<?php
use Lipe\Lib\Theme\Template;

echo '<div ' . Template::in()->esc_attr(['class' => 'card', 'data-id' => 42]) . '>';
```

## `Wp_Enqueue_Script`

A fluent `$args` object for `wp_enqueue_script()`.

### Key public methods

Inherited from `Lipe\Lib\Args\Args`:

- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\Theme\Wp_Enqueue_Script;

$args = new Wp_Enqueue_Script([]);
$args->strategy   = Wp_Enqueue_Script::STRATEGY_DEFER;
$args->in_footer  = true;

wp_enqueue_script('theme-app', get_stylesheet_directory_uri() . '/dist/app.js', [], '1.0.0', $args->get_args());
```

## `Wp_Enqueue_Script_Module`

A fluent `$args` object for `wp_enqueue_script_module()`.

### Key public methods

Inherited from `Lipe\Lib\Args\Args`:

- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

### Example

```php
<?php
use Lipe\Lib\Theme\Wp_Enqueue_Script_Module;

$args = new Wp_Enqueue_Script_Module([]);
$args->fetchpriority = Wp_Enqueue_Script_Module::FETCH_PRIORITY_HIGH;

wp_enqueue_script_module('theme-app', get_stylesheet_directory_uri() . '/dist/app.js', [], null, $args->get_args());
```

## `Scripts\Common`

Shared resource loading and configuration bootstrapping across the front end, admin, and block editor. Scripts may be conditionally excluded and their dependencies driven by a `ResourceHandles` enum.

### Key public methods

- `public function init_once(): static`
- `public function remove_scripts(): void`
- `public function include_styles_in_editor(): void`
- `public function support_block_inline_styles(): void`
- `public function admin_scripts(): void`
- `public function block_scripts(): void`
- `public function theme_scripts(): void`
- `public function revision_header(array $headers): array`
- `public function load_css_enums(): void`
- `public static function factory(array $handles, Config $scripts): static`

## `Scripts\Config`

Contract for supplying the browser-side `CORE_CONFIG` configuration.

### Methods

- `public function js_config(): array`

## `Scripts\Enqueue`

Registers or enqueues a script/style using its resource handle's manifest.

### Key public methods

- `public function enqueue(bool $in_footer = true): void`
- `public function register(): void`
- `public function get_file(bool $full_path = false): string`
- `public function get_version(): string`
- `public function get_integrity(): string`
- `public static function factory(ResourceHandles $handle): static`

### Example

```php
<?php
use Lipe\Lib\Theme\Scripts\Enqueue;

Enqueue::factory($handle)->enqueue();
```

## `Scripts\External_Manifest`

Manifest for external resources (CDN/UNPKG) loaded outside the build process. Has no manifest file and no internal version.

### Key public methods

- `public function __construct(ResourceHandles $handle)`
- `public function get_version(): string`
- `public function get_integrity(): string`
- `public function set_integrity(string $integrity): static`
- `public function get_url(): string`
- `public function get_file(bool $full_path = false): string`
- `public function enqueue(bool $in_footer = true): void`

## `Scripts\JS_Manifest`

Manifest handling for files produced by the js-boilerplate.

### Key public methods

- `public function __construct(ResourceHandles $handle)`
- `public function get_version(): string`
- `public function get_integrity(): string`
- `public function enqueue(bool $in_footer = true): void`
- `public function get_url(): string`
- `public function get_file(bool $full_path = false): string`

## `Scripts\Manifest`

Contract implemented by every resource manifest.

### Methods

- `public function __construct(ResourceHandles $handle)`
- `public function get_version(): string`
- `public function get_integrity(): string`
- `public function get_url(): string`
- `public function get_file(bool $full_path = false): string`
- `public function enqueue(bool $in_footer = true): void`

## `Scripts\PCSS_Manifest`

Manifest handling for CSS files produced by the postcss-boilerplate.

### Key public methods

- `public function __construct(ResourceHandles $handle)`
- `public function get_version(): string`
- `public function get_integrity(): string`
- `public function get_file(bool $full_path = false): string`
- `public function get_url(): string`
- `public function enqueue(bool $in_footer = true): void`

## `Scripts\ResourceHandles`

Contract implemented by a `BackedEnum` of theme resource handles.

### Methods

- `public function dependencies(): array`
- `public function file(): string`
- `public function handle(): string`
- `public function in_admin(): bool`
- `public function in_front_end(): bool`
- `public function is_block_asset(): bool`
- `public function in_editor(): bool`
- `public function is_inline(): bool`
- `public function with_js_config(): bool`
- `public function is_async(): bool`
- `public function is_defer(): bool`
- `public function dist_url(): string`
- `public function dist_path(): string`
- `public function get_manifest(): Manifest`

## `Scripts\Svelte_Manifest`

Manifest handling for Svelte-based JS module resources enqueued via `wp_enqueue_script_module()`.

### Key public methods

- `public function __construct(ResourceHandles $handle)`
- `public function get_version(): string`
- `public function get_integrity(): string`
- `public function get_url(): string`
- `public function enqueue(bool $in_footer = true): void`
- `public function get_file(bool $full_path = false): string`

## `Scripts\Util`

Utility helpers for detecting dev-server state and resource types.

### Key public methods

- `public function is_webpack_running(ResourceHandles $handle): bool`
- `public function get_node_process_port(?ResourceHandles $handle, int $default_port): int`
- `public function is_javascript_resource(ResourceHandles $handle): bool`
