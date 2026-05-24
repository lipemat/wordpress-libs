---
title: Settings
parent: Modules
nav_order: 16
---

# Settings

## Overview

The Settings module wraps `register_setting()` and the WordPress settings page APIs. It lets you define sections and fields as objects, then render or save a complete settings screen.

## Types in this module

- `Lipe\Lib\Settings\Register_Setting`
- `Lipe\Lib\Settings\Settings_Page`
- `Lipe\Lib\Settings\Settings_Trait`
- `Lipe\Lib\Settings\Settings_Page\Field`
- `Lipe\Lib\Settings\Settings_Page\FieldArgs`
- `Lipe\Lib\Settings\Settings_Page\Section`
- `Lipe\Lib\Settings\Settings_Page\SectionArgs`
- `Lipe\Lib\Settings\Settings_Page\Settings` (interface)

## `Register_Setting`

Fluent wrapper for `register_setting()`.

### Key public methods

Inherited from `Lipe\Lib\Args\Args`:

- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

This class exposes WordPress setting properties such as `type`, `description`, `label`, `sanitize_callback`, `show_in_rest`, and `default`.

## `Settings_Page`

Registers, renders, and saves a composed settings page.

### Key public methods

- `public function init(): void`
- `public function register(): void`
- `public function save_network_settings(): void`
- `public function render(): void`
- `public function is_settings_page(): bool`
- `public function get_option(string $field, mixed $default_value = null): mixed`
- `public static function factory(Settings $settings): Settings_Page`

### Example

```php
<?php
use Lipe\Lib\Settings\Settings_Page;
use Lipe\Lib\Settings\Settings_Page\Section;

$general = Section::factory('general', 'General');
$general->field('api_key', 'API Key');
```

## `Settings_Trait`

Trait for CMB2-backed settings pages that want `get_option()` and `update_option()` routed through the meta repository.

### Key public methods

- `public function get_id(): string`
- `public function get_meta_type(): MetaType`
- `public function get_option(string $key, mixed $default_value = null)`
- `public function update_option(string $key, mixed $value, mixed $callback_default = null): void`

## `Field`

Represents one settings field inside a section.

### Key public methods

- `public function label_for(string $label_for): Field`
- `public function class(string $css_class): Field`
- `public function help(string $help): Field`
- `public function render_callback(callable $callback): Field`
- `public function sanitize_callback(callable $callback): Field`
- `public function settings_args(Register_Setting $settings_args): Field`
- `public function render(Settings_Page $settings): void`
- `public static function factory(string $id, string $title): Field`

## `Section`

Container for a group of settings fields.

### Key public methods

- `public function field(string $id, string $title): Field`
- `public function add_field(Field $field): Section`
- `public function before_section(string $before_section): Section`
- `public function after_section(string $after_section): Section`
- `public function section_class(string $section_class): Section`
- `public function description(string $description): Section`
- `public function get_fields(): array`
- `public function render_description(): void`
- `public static function factory(string $id, string $title): Section`

## Supporting types

- `FieldArgs` and `SectionArgs` are fluent wrappers for `add_settings_field()` and `add_settings_section()`-specific extra arguments.
- `Settings` is the contract implemented by page-definition objects and includes `get_id()`, `get_title()`, `get_sections()`, `is_network()`, `get_parent_menu_slug()`, `get_description()`, `get_capability()`, `get_icon()`, and `get_position()`.
