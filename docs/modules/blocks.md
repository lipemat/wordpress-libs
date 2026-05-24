---
title: Blocks
parent: Modules
nav_order: 3
---

# Blocks

## Overview

The Blocks module wraps block registration and block-style registration with fluent builders for attributes and `supports`. It is designed for server-side configuration of Gutenberg blocks.

## Types in this module

- `Lipe\Lib\Blocks\Attributes`
- `Lipe\Lib\Blocks\Register_Block`
- `Lipe\Lib\Blocks\Register_Block_Style`
- `Lipe\Lib\Blocks\Args\Prop`
- `Lipe\Lib\Blocks\Args\Source`
- `Lipe\Lib\Blocks\Args\Supports`

Classes using `Lipe\Lib\Args\Args` also expose `public function __construct(array $existing)`, `public function merge(ArgsRules $overrides): void`, and `public function get_args(): array`.

## `Attributes`

Builds the `attributes` array for `register_block_type()`.

### Key public methods

- `public function prop(string $name): Prop`
- `public function get_args(): array`

## `Register_Block`

Fluent wrapper around `register_block_type()`.

### Key public methods

- `public function supports(): Supports`

### Example

```php
<?php
use Lipe\Lib\Blocks\Register_Block;

$block = new Register_Block([]);
$block->name = 'acme/book-card';
$block->attributes = (new Lipe\Lib\Blocks\Attributes([]))->get_args();
$block->supports()->align(['wide', 'full']);

register_block_type($block->name, $block->get_args());
```

## `Register_Block_Style`

Fluent wrapper around `register_block_style()`.

This class is property-driven through the shared args system and is useful for setting values such as style `name`, `label`, and `inline_style` before calling `get_args()`.

## `Prop`

Represents a single block attribute definition.

### Key public methods

- `public function type(string $type): static`
- `public function enum(array $values): static`
- `public function default(mixed $value): static`
- `public function role(string $role): static`
- `public function source(): Source`

## `Source`

Configures how an attribute is sourced from markup or meta.

### Key public methods

- `public function __construct(protected Prop $prop)`
- `public function attribute(string $selector, string $attribute): Prop`
- `public function text(string $selector): Prop`
- `public function html(string $selector): Prop`
- `public function query(string $selector, array $query): Prop`
- `public function meta(string $key): Prop`

## `Supports`

Builds the `supports` configuration for a block.

This builder is property-driven via `Args`; use it to set support flags before calling `get_args()`.
