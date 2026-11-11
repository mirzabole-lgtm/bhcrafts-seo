# BHcrafts SEO Work Bridge 0.1.2

This staging add-on reports the stored Yoast indexable and contains the fixed-proposal repair and synonym test for product 2839, Knitted Bag with Three-Doll Applique. It requires WordPress 6.2 or later, the existing BHcrafts SEO Staging Diagnostics 0.3.1 plugin, and active Yoast SEO and Yoast SEO Premium 28.8.

## Repair the staging indexable

1. Upload [Work Bridge 0.1.2](../../releases/BHcrafts_SEO_Work_Bridge_0.1.2.zip) through **Plugins → Add New Plugin → Upload Plugin** on Kinsta staging. Choose **Replace current with uploaded** and keep Diagnostics 0.3.1 active.
2. In **Tools → BHcrafts Yoast Staging Test**, review the **Staging indexable repair** preview. Confirm a recoverable staging backup and outbound integration isolation. Enter the backup reference and select **Approve and repair staging indexable** if you approve the displayed changes. Keep the downloaded receipt private because it includes the administrator ID and backup reference.
3. Download a fresh **Yoast indexable report** and attach it for independent comparison. Recheck the [Yoast head response](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-json/yoast/v1/get_head?url=https%3A%2F%2Fstg-bhcraftsshop-affiliate.kinsta.cloud%2Fproduct%2Fknit-handbag-with-dolls-applique%2F) and [staging product page](https://stg-bhcraftsshop-affiliate.kinsta.cloud/product/knit-handbag-with-dolls-applique/). Verify the title, meta description and `noindex` directive. Export a fresh Diagnostics product snapshot to compare protected product fields.

The [exact repair proposal](../../docs/STATUS.md#proposed-staging-indexable-repair) is `bhcrafts-stg-2839-yoast-indexable-repair-v0.1` with SHA-256 `a79d7d7dd0030e9636f8db39b7779853bd0153f83d4d12e73ecc15d7c0170e4c`. The guarded update assigns only `permalink_hash`, `title` and `description` on the existing derived row. It rechecks the exact baseline, current permalink, source metadata and conflicts. If the receipt calls for review or the request times out, download the report to see the actual saved state before deciding what to do next.

**Approve and restore original indexable** is the separate rollback. It restores the exact previous hash and the two database nulls when the row still matches the applied state. Use it only for an approved rollback.

## Download the read-only indexable report

1. On Kinsta staging, upload [Work Bridge 0.1.2](../../releases/BHcrafts_SEO_Work_Bridge_0.1.2.zip) through **Plugins → Add New Plugin → Upload Plugin** if you are running an older version. Keep Diagnostics 0.3.1 active.
2. Open **Tools → BHcrafts Yoast Staging Test** and select **Download Yoast indexable report**. Attach `BHcrafts_Yoast_Indexable_2839.json` for review.

The report runs one bounded SELECT for post object 2839 using the current WordPress table prefix. It compares the stored permalink, permalink hash, title and description with the current permalink and saved Yoast fields. A failed query, missing record, single match by product ID, or multiple rows each have their own status. The report does not rebuild Yoast data or change product metadata. The existing write and restore buttons are separate from this report.

## Exact proposal

Proposal ID `bhcrafts-stg-2839-yoast-synonym-test-v0.1`. SHA-256 `51894bdd9415e611dc4984cdf56389395aaa0b075e2866fe22407f9fa894d60d`. The hash covers the exact bundled JSON proposal, including site, product, original metadata rows and the proposed value.

| Field | Before | Proposed |
| --- | --- | --- |
| Primary focus keyphrase synonyms | `cotton knit handbag, knitted cotton bag,` | `cotton knit handbag, knitted cotton bag` |

The action writes one existing `_yoast_wpseo_keywordsynonyms` row. The JSON keeps the four related synonym strings exactly as saved. The other four Yoast fields and raw product descriptions must match the [corrected staging export](../../docs/product-2839/baseline/BHcrafts_Product_2839_Yoast_Editor_Correction_2026-11-11.json) before apply. Prices, variations, descriptions, media and score fields are outside the write scope. Rollback restores the original synonym string only when the current row still matches the test result.

## Run on Kinsta staging

1. In MyKinsta, select the `affiliate` staging environment. Confirm outbound integrations are isolated and create a manual backup. Verify the restore point exists. Use its short backup note or reference in the test form. See [Kinsta backup instructions](https://kinsta.com/docs/wordpress-hosting/wordpress-backups-and-disaster-recovery/wordpress-backups/#create-a-manual-wordpress-backup).
2. On the [staging site](https://stg-bhcraftsshop-affiliate.kinsta.cloud/), download a fresh product 2839 snapshot with **Tools → BHcrafts SEO Diagnostics**. Keep it for the before-and-after comparison. Close any other editor tabs for this product during the test.
3. Install and activate [BHcrafts SEO Work Bridge 0.1.2](../../releases/BHcrafts_SEO_Work_Bridge_0.1.2.zip) alongside Diagnostics 0.3.1. Open **Tools → BHcrafts Yoast Staging Test**. Review the exact before-and-after values. Opening the preview does not write product metadata.
4. Enter the verified backup reference, confirm staging isolation, and select **Approve and remove trailing comma** if you approve the displayed change. Save the downloaded JSON receipt privately. It includes the approver’s WordPress user ID and the backup reference. If the result calls for review or the request times out, export a fresh snapshot before taking further action.
5. Immediately export another product 2839 snapshot. Run the exact-text comparison below with that file. Compare the captured product descriptions, protected-field hashes, variation, attachments and artisan evidence to the fresh baseline.
6. Reopen the [product editor](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-admin/post.php?post=2839&action=edit). Verify all five keyphrases and synonym pairs plus the SEO title and meta description. Save through the normal editor and export again. Record any change to the stored scores separately. Check the rendered title and description on the [staging product page](https://stg-bhcraftsshop-affiliate.kinsta.cloud/product/knit-handbag-with-dolls-applique/) and confirm the page remains noindex. This test does not change the title or description, so their rendered values provide a regression check.
7. Return to **Tools → BHcrafts Yoast Staging Test**. Review the reverse diff, then approve the restore to test field-level rollback. Save the receipt and export a final diagnostics snapshot. Verify the original synonym string, including its trailing comma. Deactivate the add-on once the test ends.

```bash
php -n tools/validate_snapshot.php /path/to/post-apply-snapshot.json --yoast-proposal docs/product-2839/review_v0.2.json
```

The exact comparison should pass after apply and after a successful editor resave. After restore, snapshot integrity should pass and the proposal comparison should again flag only the original trailing comma. Share the read-only diagnostics exports for comparison. Keep receipts with account identifiers in private records.

## Validation and scope

The add-on checks both site URLs, WordPress staging mode, search visibility, active plugins, exact Yoast versions, product identity and administrator permissions. Approval uses a POST form and a nonce tied to the operation and proposal hash. The write uses WordPress's previous-value guard and verifies all five rows immediately afterward. If another process removed the row, the add-on blocks reinsertion. The operation accepts no field names, new field values, product IDs or URLs from the browser.

The 86 Work Bridge fixture checks cover the report and repair forms, authorization, fixed query scope, missing or stale rows, a destination conflict, and exact read-back and rollback. The synonym test passed on staging with 0.1.0 and the report ran on staging with 0.1.1. The new repair still needs its first staging database run. Programmatic writes for the other four saved Yoast fields are later steps. See the [WordPress metadata API](https://developer.wordpress.org/reference/functions/update_post_meta/) and the [Yoast REST API scope](https://developer.yoast.com/customization/apis/rest-api/#can-i-use-this-api-to-update-data).
