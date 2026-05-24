---
title: Modules
nav_order: 2
has_children: true
---

# Modules

WordPress Libs is organized as small, focused modules. Most modules provide fluent wrappers around WordPress APIs, while shared traits and utilities support consistent behavior across the package.

- [API](api/) — rewrite-endpoint API, route resolution, remote calls, and ZIP responses.
- [Args](args/) — reusable fluent-args and nested-clause building blocks.
- [Blocks](blocks/) — block registration, attributes, and `supports` builders.
- [CMB2](cmb2/) — meta box, field, group, options page, and variation wrappers for CMB2.
- [Comment](comment/) — comment object helpers and comment query/update builders.
- [Container](container/) — singleton container, factory, and hook bootstrap helpers.
- [Cron](cron/) — recurring and one-time cron orchestration.
- [Db](db/) — contracts and helpers for custom tables.
- [Libs](libs/) — internal asset handles for library-owned CSS and JS.
- [Menu](menu/) — `wp_nav_menu()` args and nav-menu-item wrappers.
- [Meta](meta/) — meta registration, translation, validation, and classic meta boxes.
- [Network](network/) — multisite network wrapper trait.
- [Post Type](post-type/) — custom post types, labels, capabilities, and admin-list integrations.
- [Query](query/) — query builders for posts plus date/meta/tax clauses.
- [REST API](rest-api/) — route registration, argument schema, and resource schema builders.
- [Settings](settings/) — `register_setting()` wrappers and settings page composition.
- [Site](site/) — multisite site wrapper trait.
- [Taxonomy](taxonomy/) — taxonomy registration, labels, admin menu/meta-box utilities, and term queries.
- [Theme](theme/) — resource loading, manifests, templates, CSS modules, and sidebar helpers.
- [Traits](traits/) — memoization, singleton, and version helpers.
- [User](user/) — user object helpers, user queries, updates, and login form args.
- [Util](util/) — arrays, cache, colors, cryptography, files, logging, strings, URLs, and version helpers.
