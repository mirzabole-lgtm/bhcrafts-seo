# BHcrafts WooCommerce and Yoast SEO Work

Background development and review for bhcrafts.shop. Current installable diagnostics version: **0.3.1**.

The diagnostics plugin collects read-only product evidence. Work Bridge provides separate staging diagnostics and exact, administrator-approved write tests for product 2839.

## Start here

- [Governing project brief](BHcrafts_WooCommerce_SEO_Work_Brief.md)
- [Current status and next action](docs/STATUS.md)
- [Plugin setup instructions](plugin/bhcrafts-seo-diagnostics/README.md)
- [Plugin source](plugin/bhcrafts-seo-diagnostics/)
- [Current installable ZIP: 0.3.1](releases/BHcrafts_SEO_Staging_Diagnostics_0.3.1.zip)
- [Yoast staging test ZIP: Work Bridge 0.1.2](releases/BHcrafts_SEO_Work_Bridge_0.1.2.zip)
- [Change history](CHANGELOG.md)

## Current action on staging

The staging snapshots confirm apply, editor resave and rollback for the synonym field on product 2839. The Work Bridge 0.1.2 repair corrected the derived row. The Yoast head API and storefront now show the approved title and description, and staging remains `noindex`. See the [verification and remaining checks](docs/STATUS.md#current-result).

## Documents and evidence

| Artifact | Location |
| --- | --- |
| Complete project brief and screenshot transcription | [Project brief](BHcrafts_WooCommerce_SEO_Work_Brief.md) |
| Public discovery, 382-product inventory and integration plan | [Discovery report](docs/discovery/BHcrafts_SEO_ReadOnly_Discovery_and_Plan.md) |
| Administrator-supplied staging version report | [Staging diagnostics](docs/staging/BHcrafts_Staging_Diagnostics_2026-11-10.json) |
| First product inspection, copy, keyphrases and image metadata drafts | [Product 2839 report](docs/product-2839/BHcrafts_Product_2839_Inspection_and_Draft.md) |
| Updated raw-baseline draft and shared references | [Draft v0.2](docs/product-2839/review_v0.2.json), [historical v0.1](docs/product-2839/review.json) |
| Saved raw baseline and Yoast findings | [Baseline validation](docs/product-2839/BHcrafts_Product_2839_Saved_Baseline_Validation.md), [original JSON](docs/product-2839/baseline/BHcrafts_Product_2839_ReadOnly_Snapshot_2026-11-10.json) |
| Yoast editor test and saved values | [Corrected comparison](docs/product-2839/yoast_editor_test_v0.1.md#corrected-editor-save), [corrected snapshot](docs/product-2839/baseline/BHcrafts_Product_2839_Yoast_Editor_Correction_2026-11-11.json) |
| Artisan preservation registry | [Exact raw block and image markup](docs/product-2839/preservation_registry_v0.2.json) |
| Frozen inspection scope | [Selection manifest](docs/product-2839/selection_manifest.json) |
| Proposed product descriptions | [Long HTML](docs/product-2839/proposed_long_description.html), [short HTML](docs/product-2839/proposed_short_description.html) |
| Public Store API description before drafting | [Before HTML](docs/product-2839/current_long_description_store_api.html) |
| Review archive, including eight source photographs | [Complete review pack](artifacts/review/BHcrafts_Product_2839_Review_Pack_v0.1.zip) |
| Public staging access checks | [Staging check](plugin/bhcrafts-seo-diagnostics/STAGING_CHECK.md) |
| Exporter validation | [Validation record](plugin/bhcrafts-seo-diagnostics/VALIDATION.md) |

Older diagnostic ZIPs remain in releases for history. Use 0.3.1 for the next export.

## Scope and environment

Staging: https://stg-bhcraftsshop-affiliate.kinsta.cloud/

Selected inspection product: 2839, Knitted Bag with Three-Doll Applique. Observed variation: 2840. The administrator report records WordPress 7.1.4, WooCommerce 11.2.2, Yoast SEO and Premium 28.8, PHP 8.3.36 and Flatsome 3.20.11.

Cloud API authentication, the complete Premium round-trip, sitewide shared-media coverage and a production pilot remain open. Live writes require an exact proposal and human approval under the brief.

## Checks

```bash
php -n -l plugin/bhcrafts-seo-diagnostics/bhcrafts-seo-diagnostics.php
php -n -l plugin/bhcrafts-seo-diagnostics/includes/product-export.php
php -n -l plugin/bhcrafts-seo-diagnostics/includes/premium-evidence.php
php -n plugin/bhcrafts-seo-diagnostics/tests/security-test.php
php -n plugin/bhcrafts-seo-diagnostics/tests/security-test.php export
php -n tools/validate_snapshot.php docs/product-2839/baseline/BHcrafts_Product_2839_ReadOnly_Snapshot_2026-11-10.json
php -n plugin/bhcrafts-seo-work-bridge/tests/staging-test.php
```

Current result: 78 diagnostics and 86 Work Bridge fixture checks passed, plus a valid UTF-8 JSON export using the standard WordPress form payload. The read-only report and the derived indexable repair ran on staging. The repair receipt, public API and rendered HTML all match the repair proposal.

The repository contains no deployment automation or production credentials. Work continues in the existing Work Cloud conversation.
