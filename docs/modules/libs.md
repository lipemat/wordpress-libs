---
title: Libs
parent: Modules
nav_order: 9
---

# Libs

## Overview

The Libs module contains the internal CSS and JavaScript handles used by wordpress-libs itself. These types are primarily useful when you need to enqueue the library's own bundled assets.

## Types in this module

- `Lipe\Lib\Libs\Scripts`
- `Lipe\Lib\Libs\Scripts\ScriptHandles` (enum)
- `Lipe\Lib\Libs\Scripts\StyleHandles` (enum)

## `Scripts`

Enqueues internal stylesheet and script assets.

### Key public methods

- `public function enqueue_style(StyleHandles $style): void`
- `public function enqueue_script(ScriptHandles $script): void`
- `public function is_block_editor(): bool`

### Example

```php
<?php
use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Libs\Scripts\StyleHandles;

Scripts::in()->enqueue_style(StyleHandles::META_BOXES);
```

## `ScriptHandles`

Enum of known script handles plus metadata helpers.

### Key public methods

- `public function dependencies(): array`
- `public function js_config(): array`
- `public function file(): string`

## `StyleHandles`

Enum of known stylesheet handles.

### Key public methods

- `public function file(): string`
