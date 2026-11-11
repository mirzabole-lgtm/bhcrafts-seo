# Product 2839 Yoast editor test

Proposal **bhcrafts-stg-2839-yoast-editor-v0.1**. Review pending. Batch size one product.

Proposal values SHA-256 `886af01b918931b71d4b351fda84a4632ccba40ecb5535264d59bbb886b5f844`.

Use the [staging editor](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-admin/post.php?post=2839&action=edit) for Knitted Bag with Three-Doll Applique (2839). Take a recoverable staging backup before the test. Record its reference with the test result.

## Exact proposed fields

| Field | Saved baseline | Proposed value |
| --- | --- | --- |
| SEO title | Key absent | Knitted Cotton Handbag with Doll Appliqué &#124; BHcrafts |
| Meta description | Key absent | Choose a knitted cotton handbag with three doll appliqués and colorful striped handles. Available in black or green, handmade by BHcrafts women artisans. |

| Yoast entry | Saved baseline | Keyphrase | Synonyms |
| --- | --- | --- | --- |
| Primary | Key absent | knitted cotton handbag | cotton knit handbag, knitted cotton bag |
| Related 1 | Saved field is an empty string | handmade cotton bag | handcrafted cotton bag, cotton bag made by hand |
| Related 2 | Saved field is an empty string | doll appliqué bag | bag with doll appliqués, doll applique handbag |
| Related 3 | Saved field is an empty string | knitted handbag with dolls | knit bag with dolls, knitted doll handbag |
| Related 4 | Saved field is an empty string | fair trade handbag | fair trade bag, fairly traded handbag |

The shared synonym field currently stores one empty string. The proposed test covers only the listed Yoast editor fields. Image metadata and product descriptions are outside this proposal.

## Run and verify

1. Review the values and approve them before editing. Enter each pair of synonyms under its corresponding keyphrase in Yoast Premium and save the staging product.
2. Reopen the product editor and check all five keyphrases and their synonyms against the table.
3. In Tools → BHcrafts SEO Diagnostics, select Download product 2839 snapshot. Attach the new JSON and report any differences you see in the editor.

The returned snapshot will show the order and representation of the distinct synonym strings. Compare the product content, variation, attachment records and protected-field hashes with the original snapshot after the save. This editor test establishes evidence for the adapter. A later adapter test must verify its own write, editor reload, normal save and frontend output.

## Evidence

The [0.3.1 staging export](baseline/BHcrafts_Product_2839_ReadOnly_Snapshot_2026-11-11.json) was generated 11 November 2026 at 06:40:11 Europe/Sarajevo. Its snapshot, raw content, attachment and Yoast metadata checksums verify. The product, variation and attachment data match the previous export.

Product 616 has one saved row in each of five fields. The title, meta description and focus keyphrase are strings. Related keyphrases form a JSON array of four objects. Each object has a string `keyword` and integer `score`. Synonyms form a separate JSON array of five entries, with the first four observed as strings in the bounded export. The reference does not establish slot order or how Yoast generates scores. Let the editor generate its own scores.

Baseline snapshot SHA-256 `cc277e19412790e62b905df3b4a56ef1c185b6d45bde4237e85baa14ce55150b`. This export preserves the absent or empty field states for comparison and rollback review. Use the recorded staging backup if exact restoration is required.
