# BHcrafts WooCommerce and Yoast SEO Work

Background development and review for bhcrafts.shop. Current installable diagnostics version: **0.2.1**.

The staging-only plugin collects read-only product evidence. The SEO writer is not implemented. No product or image metadata changes have been applied by this project.

## Start here

- [Governing project brief](BHcrafts_WooCommerce_SEO_Work_Brief.md)
- [Current status and next action](docs/STATUS.md)
- [Plugin setup instructions](plugin/bhcrafts-seo-diagnostics/README.md)
- [Plugin source](plugin/bhcrafts-seo-diagnostics/)
- [Corrected installable ZIP: 0.2.1](releases/BHcrafts_SEO_Staging_Diagnostics_0.2.1.zip)
- [Change history](CHANGELOG.md)

## Current action on staging

In staging WordPress, upload the 0.2.1 ZIP and choose **Replace current with uploaded**. Open **Tools > BHcrafts SEO Diagnostics > Download product 2839 snapshot**. Attach the downloaded JSON in the existing Work chat.

Version 0.2.1 fixes the unexpected-form-field error reported with 0.2.0. It accepts WordPress's default submit field while retaining the fixed product, staging-host, permission and nonce checks.

## Documents and evidence

| Artifact | Location |
| --- | --- |
| Complete project brief and screenshot transcription | [Project brief](BHcrafts_WooCommerce_SEO_Work_Brief.md) |
| Public discovery, 382-product inventory and integration plan | [Discovery report](docs/discovery/BHcrafts_SEO_ReadOnly_Discovery_and_Plan.md) |
| Administrator-supplied staging version report | [Staging diagnostics](docs/staging/BHcrafts_Staging_Diagnostics_2026-11-10.json) |
| First product inspection, copy, keyphrases and image metadata drafts | [Product 2839 report](docs/product-2839/BHcrafts_Product_2839_Inspection_and_Draft.md) |
| Exact draft values, source snapshots and shared references | [Machine-readable review](docs/product-2839/review.json) |
| Frozen inspection scope | [Selection manifest](docs/product-2839/selection_manifest.json) |
| Proposed product descriptions | [Long HTML](docs/product-2839/proposed_long_description.html), [short HTML](docs/product-2839/proposed_short_description.html) |
| Public Store API description before drafting | [Before HTML](docs/product-2839/current_long_description_store_api.html) |
| Review archive, including eight source photographs | [Complete review pack](artifacts/review/BHcrafts_Product_2839_Review_Pack_v0.1.zip) |
| Public staging access checks | [Staging check](plugin/bhcrafts-seo-diagnostics/STAGING_CHECK.md) |
| Exporter validation | [Validation record](plugin/bhcrafts-seo-diagnostics/VALIDATION.md) |

Older diagnostic ZIPs remain in releases for history. Use 0.2.1 for the next export.

## Scope and environment

Staging: https://stg-bhcraftsshop-affiliate.kinsta.cloud/

Selected inspection product: 2839, Knitted Bag with Three-Doll Applique. Observed variation: 2840. The administrator report records WordPress 7.1.4, WooCommerce 11.2.2, Yoast SEO and Premium 28.8, PHP 8.3.36 and Flatsome 3.20.11.

Cloud API authentication, raw product snapshot receipt, Premium storage/save compatibility, complete shared-media coverage and a production pilot remain open. The current draft is not an approved apply operation. Live writes require an exact proposal and human approval under the brief.

## Checks

```bash
php -n -l plugin/bhcrafts-seo-diagnostics/bhcrafts-seo-diagnostics.php
php -n -l plugin/bhcrafts-seo-diagnostics/includes/product-export.php
php -n plugin/bhcrafts-seo-diagnostics/tests/security-test.php
php -n plugin/bhcrafts-seo-diagnostics/tests/security-test.php export
```

Current result: 62 isolated checks passed, plus a valid UTF-8 JSON export using the standard WordPress form payload. These are fixture tests, not a full WordPress integration run.

The repository contains no deployment automation or production credentials. Work continues in the existing Work Cloud conversation.
