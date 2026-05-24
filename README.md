# WordPress Libs

<p>
  <a href="https://github.com/lipemat/wordpress-libs/releases/latest">
    <img alt="Version" src="https://img.shields.io/packagist/v/lipemat/wordpress-libs.svg?label=version" />
  </a>
  <img alt="WordPress" src="https://img.shields.io/badge/wordpress->=6.6.0-green.svg">
  <img alt="PHP" src="https://img.shields.io/packagist/php-v/lipemat/wordpress-libs.svg?color=brown" />
  <img alt="License" src="https://img.shields.io/packagist/l/lipemat/wordpress-libs.svg">
</p>

WordPress library which supports a core plugin and theme.

## Documentation

Full module documentation is published at **[lipemat.github.io/wordpress-libs](https://lipemat.github.io/wordpress-libs/)**.

Browse the [Modules index](https://lipemat.github.io/wordpress-libs/modules/) for a complete list of fluent builders, traits, and helpers, including:

- [API](https://lipemat.github.io/wordpress-libs/modules/api/) — rewrite endpoints, route resolution, remote requests, and ZIP responses.
- [Args](https://lipemat.github.io/wordpress-libs/modules/args/) — reusable fluent-args and nested-clause building blocks.
- [Blocks](https://lipemat.github.io/wordpress-libs/modules/blocks/) — block registration, attributes, and `supports` builders.
- [CMB2](https://lipemat.github.io/wordpress-libs/modules/cmb2/) — meta box, field, group, options page, and variation wrappers for CMB2.
- [Comment](https://lipemat.github.io/wordpress-libs/modules/comment/) — comment object helpers and comment query/update builders.
- [Container](https://lipemat.github.io/wordpress-libs/modules/container/) — singleton container, factory, and hook bootstrap helpers.
- [Cron](https://lipemat.github.io/wordpress-libs/modules/cron/) — recurring and one-time cron orchestration.
- [Db](https://lipemat.github.io/wordpress-libs/modules/db/) — contracts and helpers for custom tables.
- [Libs](https://lipemat.github.io/wordpress-libs/modules/libs/) — internal asset handles for library-owned CSS and JS.
- [Menu](https://lipemat.github.io/wordpress-libs/modules/menu/) — `wp_nav_menu()` args and nav-menu-item wrappers.
- [Meta](https://lipemat.github.io/wordpress-libs/modules/meta/) — meta registration, translation, validation, and classic meta boxes.
- [Network](https://lipemat.github.io/wordpress-libs/modules/network/) — multisite network wrapper trait.
- [Post Type](https://lipemat.github.io/wordpress-libs/modules/post-type/) — custom post types, labels, capabilities, and admin-list integrations.
- [Query](https://lipemat.github.io/wordpress-libs/modules/query/) — query builders for posts plus date/meta/tax clauses.
- [REST API](https://lipemat.github.io/wordpress-libs/modules/rest-api/) — route registration, argument schema, and resource schema builders.
- [Settings](https://lipemat.github.io/wordpress-libs/modules/settings/) — `register_setting()` wrappers and settings page composition.
- [Site](https://lipemat.github.io/wordpress-libs/modules/site/) — multisite site wrapper trait.
- [Taxonomy](https://lipemat.github.io/wordpress-libs/modules/taxonomy/) — taxonomy registration, labels, admin menu/meta-box utilities, and term queries.
- [Theme](https://lipemat.github.io/wordpress-libs/modules/theme/) — resource loading, manifests, templates, CSS modules, and sidebar helpers.
- [Traits](https://lipemat.github.io/wordpress-libs/modules/traits/) — memoization, singleton, and version helpers.
- [User](https://lipemat.github.io/wordpress-libs/modules/user/) — user object helpers, user queries, updates, and login form args.
- [Util](https://lipemat.github.io/wordpress-libs/modules/util/) — arrays, cache, colors, cryptography, files, logging, strings, URLs, and version helpers.

## Installation
``` sh 
composer require lipemat/wordpress-libs
```
### Usage

``` php
require __DIR__ . '/vendor/autoload.php'
```

## Changelog

Found in [releases](https://github.com/lipemat/wordpress-libs/releases) (non exhaustive)
