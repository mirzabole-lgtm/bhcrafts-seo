# BHcrafts SEO Staging Diagnostics 0.3.1

Prepared 11 November 2026, Europe/Sarajevo.

This update retains the environment report and adds a fixed-scope, administrator-only raw snapshot for the selected handbag. It contains no content writer, public REST endpoint or cloud credentials.

## Update on staging

Target: https://stg-bhcraftsshop-affiliate.kinsta.cloud/

1. In staging WordPress, open Plugins > Add New Plugin > Upload Plugin.
2. Upload BHcrafts_SEO_Staging_Diagnostics_0.3.1.zip.
3. When WordPress identifies the existing diagnostics plugin, choose Replace current with uploaded. The folder and plugin basename are unchanged from 0.1.0.
4. Confirm BHcrafts SEO Staging Diagnostics is active. Open Tools > BHcrafts SEO Diagnostics.
5. Select Download product 2839 snapshot.
6. Attach BHcrafts_Product_2839_ReadOnly_Snapshot.json in the existing Work chat. Attach the file rather than pasting a long JSON document.

The environment-report button remains available. For the next step, use the new product snapshot button.

The cloud task has not installed this update. Installation requires a staging administrator because an authenticated cloud connection has not been established. Installing or replacing the plugin changes its files and activation state on staging. The export itself performs no explicit product, attachment or settings update.

## New in 0.3.1

The user supplied a successful 0.2.1 snapshot for product 2839 on PHP 8.3.36. Its saved primary phrase, title and description keys are absent. The Premium synonym and related-keyphrase candidates contain empty strings, so this record does not demonstrate their nonempty encoding.

The download includes WordPress post-meta registration details and the saved field structure from Christmas Stocking Personalized (616), the reference product selected by the user. It checks the reference ID, slug, publication status and administrator's object permission before reading five fixed Yoast fields. The report records field presence, row count and data types, including up to four entries in a list. It redacts phrase and synonym values and scores.

The structure summary has limits on depth, array examples and node count. Empty, inaccessible or malformed samples are labelled. The report does not claim completeness, current writer compatibility or normal editor-save verification. It adds no writes or endpoints. Invalid UTF-8 is rejected before WordPress JSON encoding can sanitize it.

## Fix in 0.2.1

WordPress adds a default submit field through submit_button(). Version 0.2.0 rejected that field and blocked its own download form. Version 0.2.1 allows only that additional standard field and requires all form values to be strings. Arbitrary product IDs, metadata keys, URLs, query inputs and array values remain rejected. The product export regression now includes the complete standard WordPress form payload.

## Fixed scope

- Both Home and Site URLs must use HTTPS on stg-bhcraftsshop-affiliate.kinsta.cloud. Live, mixed-domain, HTTP and credential-bearing URLs are rejected.
- Product ID 2839 must still be a WooCommerce variable product with slug knit-handbag-with-dolls-applique.
- The administrator needs manage_options and object-level edit_post permission for the selected product, variations and attachments.
- The request is POST-only, with its own nonce and a closed form-field allowlist. A caller cannot select another product ID, metadata key or URL.
- The inspected eight attachments are included. Any current gallery/variation images associated with this product are also recorded, with strict limits and explicit assignment-drift indicators.
- Limits: 25 variations, 30 attachment IDs, 1,024 saved metadata key names, 32 selected Yoast content candidates, 1 MiB per string and 8 MiB per JSON download. Oversized or unsupported records produce an error rather than silent truncation.

## Snapshot contents

- The original environment/version report, with its limited scope labelled.
- Product ID, slug, status, type, modification marker and exact saved post_content/post_excerpt.
- Attribute options, observed variation IDs, variation descriptions, image assignments and gallery order.
- Exact saved attachment title, caption and description, plus alt metadata with its existence flag and all returned WordPress values.
- Hashes for selected protected properties. Commercial values are not exported as restorable snapshots. No restore operation exists.
- Artisan tag identity/path checks and raw-description evidence for the uppercase heading and tag filename.
- Installed public WPSEO_Meta registry field names and selected definitions, when available, plus a basename and hash for its loaded source file. No vendor source code or absolute server path is exported.
- Saved Yoast vendor metadata key names. Values are read only for the five content aliases title, metadesc, focuskw, keywordsynonyms and focuskeywords when found in the installed registry or saved key inventory. These are inspection candidates, not a verified Premium write contract. Unknown aliases are named without their values so the adapter requires explicit review.

Only selected Yoast content values are collected. Canonical, robots, social and score values are excluded. Non-Yoast metadata values, orders, customer data, user records, passwords, API keys and arbitrary settings are excluded.

## Exact-value semantics

Raw product and attachment content comes from saved WordPress post fields, without executing shortcodes or applying the_content. Metadata values come from the normal WordPress metadata API. WordPress performs its documented native type conversions and unserialization. The report labels this distinction and does not claim byte-for-byte database storage.

Each selected metadata record distinguishes an absent key from a present empty string. Duplicate rows and native arrays are retained. JSON strings are not decoded and rewritten. Objects, resources, invalid UTF-8 and oversized values are rejected. Snapshot hashes identify observed values. They do not provide human approval or eliminate the need for fresh reads before any future write.

The report is a bounded observation, not a database transaction. It does not prove completeness of protected fields, full media usage, editor behavior or the site's current backup status.

## Remaining work after export

Inspect the actual returned Yoast fields and related-keyphrase representation. Compare saved raw HTML against the public content draft, isolate the artisan block, and review the shared-image effects. Then build and test a version-specific adapter on staging under a concrete approved test proposal.

A successful export does not establish cloud API authentication, validate Yoast normal-save/indexation behavior or authorize applying draft v0.1. No SEO scores are set or fabricated.

## Validation

All four PHP files passed syntax checks with PHP 8.4.27. Seventy-eight isolated checks passed. The real product-download handler returned valid UTF-8 JSON in a fixture test, with product 2839, eight images, an absent meta-description key, a present empty title, unchanged Premium JSON and no unrelated secret or commercial sentinel values.

These tests use controlled fixtures. Version 0.2.1 successfully exported on the user's PHP 8.3.36 staging runtime. The new 0.3.1 schema-evidence addition still needs execution there. The PHP 7.4 minimum reflects the syntax used, not a separate tested runtime.

The CLI-only test file is included for review:

```bash
php -n tests/security-test.php
php -n tests/security-test.php export
```

## Official implementation references

- https://developer.wordpress.org/reference/functions/get_post_meta/
- https://developer.wordpress.org/reference/functions/metadata_exists/
- https://developer.wordpress.org/reference/functions/current_user_can/
- https://developer.wordpress.org/reference/functions/check_admin_referer/
- https://developer.wordpress.org/reference/hooks/admin_post_action/
- https://raw.githubusercontent.com/Yoast/wordpress-seo/28.8/inc/class-wpseo-meta.php

The official Yoast SEO 28.8 source confirms its public prefix/field registry and registration mechanism. The export inspects the actual installed registry rather than assuming the installed Premium data layout matches public base-plugin source.

- https://developer.wordpress.org/reference/functions/get_registered_meta_keys/
- https://developer.wordpress.org/reference/functions/wp_json_encode/
