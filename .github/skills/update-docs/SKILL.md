---
name: update-docs
description: Update the Jekyll module documentation in `docs/modules/` based on changes to source files in `src/`.
---

@version 1.0.0

## Purpose

The `docs/` directory contains a Just the Docs Jekyll site published to GitHub Pages. Each top-level directory in `src/` is documented by a single Markdown file at `docs/modules/<slug>.md`. This skill keeps those docs in sync with the PHP source.

## Change Detection

Use git history as the source of truth — do not introduce a marker file.

1. For each candidate module, compare the last-commit timestamp of the doc file against the last-commit timestamp of its source directory:
    - Doc timestamp: `git log -1 --format=%ct -- docs/modules/<slug>.md`
    - Source timestamp: `git log -1 --format=%ct -- src/<SourceDir>/`
2. Regenerate the doc when the source timestamp is greater than the doc timestamp.
3. Skip the module when the doc timestamp is greater than or equal to the source timestamp.
4. Trigger a full rebuild of every module doc when any of these are true:
    - The user explicitly requests "regenerate all" or "full rebuild".
    - `docs/_config.yml` was modified more recently than every module doc.
    - `docs/index.md` was modified more recently than every module doc.
    - The doc template in this skill has been revised since the last run.

## Slug ↔ Source Directory Map

Slugs are kebab-case; source directories are Pascal_Snake_Case. Apply this rule:
- Lowercase the source directory, replace `_` with `-` to derive the slug.
- Acronyms keep their casing in the source dir (e.g., `CMB2`, `Rest_Api`).

Authoritative map for the current source tree:

| Slug        | Source Directory |
|-------------|------------------|
| `api`       | `src/Api/`       |
| `args`      | `src/Args/`      |
| `blocks`    | `src/Blocks/`    |
| `cmb2`      | `src/CMB2/`      |
| `comment`   | `src/Comment/`   |
| `container` | `src/Container/` |
| `cron`      | `src/Cron/`      |
| `db`        | `src/Db/`        |
| `libs`      | `src/Libs/`      |
| `menu`      | `src/Menu/`      |
| `meta`      | `src/Meta/`      |
| `network`   | `src/Network/`   |
| `post-type` | `src/Post_Type/` |
| `query`     | `src/Query/`     |
| `rest-api`  | `src/Rest_Api/`  |
| `settings`  | `src/Settings/`  |
| `site`      | `src/Site/`      |
| `taxonomy`  | `src/Taxonomy/`  |
| `theme`     | `src/Theme/`     |
| `traits`    | `src/Traits/`    |
| `user`      | `src/User/`      |
| `util`      | `src/Util/`      |

## Doc Template

Every `docs/modules/<slug>.md` must follow this structure exactly:

````markdown
---
title: <Module Title>
parent: Modules
nav_order: <integer>
---

# <Module Title>

## Overview

<One short paragraph describing what the module wraps and when to reach for it.>

## Types in this module

- `Lipe\Lib\<Namespace>\<ClassOrTrait>`
- ...

## `<ClassOrTrait>`

<Optional one-line summary of the class.>

### Key public methods

- <Optional one-line summary of the method.>
- `public function <name>(<args>): <return>`
- ...

### Example

```php
<?php
use Lipe\Lib\<Namespace>\<ClassOrTrait>;

// realistic minimal usage
```
````

Authoring rules:
- Only document `public` methods. Skip `protected` and `private`.
- Include constructor signatures when the class is instantiated directly by callers.
- Reproduce return types and parameter types from the source verbatim (including nullable, union, and intersection types).
- Use `Lipe\Lib\…` fully-qualified names in the `Types in this module` list; use `use` imports in code examples.
- Examples must compile against the public API; never invent methods.
- `nav_order` is assigned alphabetically by `title`, starting at 1 and incrementing by 1 — renumber siblings only when adding a new module.

## Sub-Directory Roll-Up

When a source module contains subdirectories (e.g., `src/Args/Clause/`, `src/Util/Cache/`), roll the public classes from those subdirectories into the **same** parent module doc:
- Add their fully-qualified names to the parent's `## Types in this module` list.
- Give each subdirectory class its own `` ## `<ClassName>` `` section in the parent doc.
- Do not create child Just the Docs pages or a nested `has_children` hierarchy.

## New Module Handling

When a directory exists under `src/` with no matching `docs/modules/<slug>.md`:
1. Create `docs/modules/<slug>.md` using the doc template above.
2. Insert a new bullet into `docs/modules/index.md` in alphabetical order:
    - Format: `- [<Title>](<slug>/) — <one-line summary matching the new doc's Overview>.`
3. Insert a new row into the module table in `docs/index.md` in alphabetical order:
    - Format: `| [<Title>](modules/<slug>/) | <one-line summary>. |`
4. Re-number `nav_order` across `docs/modules/*.md` so values remain contiguous and alphabetical.

## Removed Module Handling

When a `docs/modules/<slug>.md` exists with no matching `src/` directory:
1. Delete the orphan doc file.
2. Remove its bullet from `docs/modules/index.md`.
3. Remove its row from `docs/index.md`.
4. Re-number remaining `nav_order` values.

## Link Consistency Rules

- `docs/index.md` links use the form `modules/<slug>/` (trailing slash, no `.md`).
- `docs/modules/index.md` links use the form `<slug>/` (trailing slash, no `.md`).
- These rely on `permalink: pretty` in `docs/_config.yml` — do not change that setting.

## Procedure

1. Determine the working set:
    - Read every directory under `src/`.
    - For each, compute the slug and apply the Change Detection rules above.
    - Produce the list of slugs requiring regeneration plus any new or removed modules.
2. For each slug requiring regeneration:
    - Read every `.php` file under `src/<SourceDir>/` recursively.
    - Extract public method signatures from each class or trait.
    - Compose the doc file from the template, preserving any manual prose in `## Overview` and `### Example` sections from the prior version when the public API has not meaningfully changed.
3. Apply New Module Handling and Removed Module Handling as needed.
4. Run a final pass to verify Link Consistency Rules.
5. Report the regenerated slugs, the skipped slugs, and any index updates so the user can review before committing.
