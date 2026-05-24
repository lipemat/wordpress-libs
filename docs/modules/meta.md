---
title: Meta
parent: Modules
nav_order: 11
---

# Meta

## Overview

The Meta module ties together field registration, meta translation, validation, and classic meta box registration. It is the bridge between fluent field builders such as CMB2 fields and the storage/retrieval layer used by object traits.

## Types in this module

- `Lipe\Lib\Meta\Box` (interface)
- `Lipe\Lib\Meta\DataType` (enum)
- `Lipe\Lib\Meta\MetaType` (enum)
- `Lipe\Lib\Meta\Meta_Box`
- `Lipe\Lib\Meta\Mutator_Trait`
- `Lipe\Lib\Meta\Register_Meta`
- `Lipe\Lib\Meta\Repo`
- `Lipe\Lib\Meta\Translate` (trait)
- `Lipe\Lib\Meta\Validation`

## `Box`

Contract for classic WordPress meta boxes.

### Methods

- `public function get_title(): string`
- `public function get_id(): string`
- `public function get_priority(): string`
- `public function get_context(): string`
- `public function get_post_types(): array`
- `public function is_classic_editor_fallback(): bool`
- `public function save(\WP_Post $post): void`
- `public function render(\WP_Post $post): void`

## `Meta_Box`

Registers a classic meta box with WordPress and handles nonce rendering and saves.

### Key public methods

- `public function __construct(protected Box $box,)`
- `public function render_nonce(\WP_Post $post): void`
- `public function save(int $post_id, \WP_Post $post): void`
- `public function register(\WP_Post $post): void`

## `Register_Meta`

Fluent wrapper around `register_meta()`, `register_post_meta()`, and `register_term_meta()`.

### Key public methods

- `public function show_in_rest(?string $name = null, ?Resource_Schema $schema = null, ?callable $prepare_callback = null): static`
- `public function __construct(array $existing)`
- `public function merge(ArgsRules $overrides): void`
- `public function get_args(): array`

## `Repo`

Central repository used to register fields and read/write values according to field data type.

### Key public methods

- `public function register_field(Field $field): Registered`
- `public function validate_fields(): void`
- `public function pre_update_field(string $key): void`
- `public function pre_get_field(string $key): void`
- `public function get_value(int|string $object_id, string $field_id, MetaType $meta_type = MetaType::POST): mixed`
- `public function update_value(int|string $object_id, string $field_id, mixed $value, MetaType $meta_type = MetaType::POST): void`
- `public function delete_value(int|string $object_id, string $field_id, MetaType $meta_type): void`

### Example

```php
<?php
use Lipe\Lib\Meta\MetaType;
use Lipe\Lib\Meta\Repo;

$value = Repo::in()->get_value(42, 'isbn', MetaType::POST);
```

## `Registered`

Readonly value object returned by `Repo::register_field()` representing a CMB2 field after it has been registered. Provides typed accessors for the field's configuration without polluting the `Field` builder with read-only helpers.

### Key public methods

- `public static function factory(Field $variation): static`
- `public function are_revisions_enabled(): bool`
- `public function get_box(): \Lipe\Lib\CMB2\Box`
- `public function get_cmb2_field(int|string $object_id = 0): ?\CMB2_Field`
- `public function get_config(): array`
- `public function get_data_type(): DataType`
- `public function get_default(null|int|string $object_id = null): mixed`
- `public function get_description(): ?string`
- `public function get_escape_cb(): ?callable`
- `public function get_group(): ?\Lipe\Lib\CMB2\Group`
- `public function get_id(): string`
- `public function get_meta_sanitizer(): ?callable`
- `public function get_position(): int`
- `public function get_rest_short_name(): string`
- `public function get_sanitization_cb(): ?callable`
- `public function get_show_in_rest(): string|bool`
- `public function get_text(string $key): ?string`
- `public function get_type(): \Lipe\Lib\CMB2\Field\Type`
- `public function has_rest_short_name(): bool`
- `public function is_allowed_to_register_meta(): bool`
- `public function is_public_rest_data(): bool`
- `public function is_repeatable(): bool`
- `public function is_using_array_data(): bool`
- `public function is_using_object_data(): bool`

## `Mutator_Trait`


- `DataType` and `MetaType` enumerate supported storage shapes and WordPress meta object types.
- `Validation` exposes `public function warn_for_repeatable_group_sub_fields(string $field_id, ?Registered $registered): void` and `public function warn_for_conflicting_taxonomies(array $registered): void`.
- `Translate` contains the conversion logic that maps stored values back to the correct runtime shape.
