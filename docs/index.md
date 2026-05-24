---
title: Home
layout: home
nav_order: 1
---

# WordPress Libs

A WordPress library for supporting a core plugin and theme.

## Installation

```bash
composer require lipemat/wordpress-libs
```

- PHP: `>=8.2.0`
- Namespace root: `Lipe\Lib\`
- Autoload entrypoint: `vendor/autoload.php`

## Basic usage

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Lipe\Lib\Api\Api;
use Lipe\Lib\Post_Type\Post_Type;

Api::init_once();

$books = new Post_Type('book');
$books->labels('Book', 'Books');
```

## Getting started

1. Install the package with Composer.
2. Pick the module that matches the WordPress API you are wrapping.
3. Instantiate the fluent builder or call the provided singleton/container helpers.
4. Register your objects on the appropriate WordPress hooks.
5. Reuse the shared traits (`Singleton`, `Memoize`, object traits, and args traits) across your own library code.

## Module overview

| Module | Summary |
| --- | --- |
| [API](modules/api/) | Rewrite-endpoint API helpers, route handling, remote requests, and ZIP delivery. |
| [Args](modules/args/) | Shared fluent argument and nested clause infrastructure used across the library. |
| [Blocks](modules/blocks/) | Block registration helpers plus attribute and support builders. |
| [CMB2](modules/cmb2/) | Fluent CMB2 box, field, group, and variation wrappers. |
| [Comment](modules/comment/) | Comment object traits plus comment query and update builders. |
| [Container](modules/container/) | Lightweight container, factory, and hook initialization helpers. |
| [Cron](modules/cron/) | Interfaces and runners for recurring and one-time cron jobs. |
| [Db](modules/db/) | Typed contracts and helpers for custom database tables. |
| [Libs](modules/libs/) | Internal script/style handles for wordpress-libs assets. |
| [Menu](modules/menu/) | Navigation menu args and menu-item wrappers. |
| [Meta](modules/meta/) | Meta registration, translation, validation, and classic meta boxes. |
| [Network](modules/network/) | Multisite network object trait with centralized meta access. |
| [Post Type](modules/post-type/) | Custom post type registration, labels, capabilities, and admin columns. |
| [Query](modules/query/) | `WP_Query`, `get_posts`, and nested date/meta/tax query builders. |
| [REST API](modules/rest-api/) | Route, schema, and initial-data helpers for REST integrations. |
| [Settings](modules/settings/) | Settings registration and settings-page composition utilities. |
| [Site](modules/site/) | Multisite site object trait helpers. |
| [Taxonomy](modules/taxonomy/) | Taxonomy registration, labels, capabilities, and custom taxonomy meta boxes. |
| [Theme](modules/theme/) | Theme resources, script manifests, CSS modules, templates, and sidebars. |
| [Traits](modules/traits/) | Reusable singleton, memoization, and versioned migration traits. |
| [User](modules/user/) | User object traits plus user query, update, and login form builders. |
| [Util](modules/util/) | General utility helpers for arrays, cache, cryptography, logging, URLs, and versions. |

For detailed module docs, start at [Modules](modules/).
