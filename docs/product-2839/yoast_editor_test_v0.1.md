# Product 2839 Yoast editor test

Proposal **bhcrafts-stg-2839-yoast-editor-v0.1**. Corrected save confirms all five synonym positions. Exact text differs by one trailing comma. Batch size one product.

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

## First editor save result

The [post-save snapshot](baseline/BHcrafts_Product_2839_Yoast_Editor_Save_2026-11-11.json) was generated 11 November 2026 at 05:58:54 UTC. The snapshot integrity checks pass. The title, meta description, primary phrase and four related phrases match the proposal exactly. Four of the five synonym slots match their expected positions.

| Saved synonym slot | Expected role | Saved value | Result |
| --- | --- | --- | --- |
| 1 | Primary | handcrafted cotton bag, cotton bag made by hand | Expected `cotton knit handbag, knitted cotton bag` |
| 2 | Related 1 | handcrafted cotton bag, cotton bag made by hand | Match |
| 3 | Related 2 | bag with doll appliqués, doll applique handbag | Match |
| 4 | Related 3 | knit bag with dolls, knitted doll handbag | Match |
| 5 | Related 4 | fair trade bag, fairly traded handbag | Match |

Yoast SEO and Premium 28.8 saved one WordPress metadata string per key. `_yoast_wpseo_focuskw`, `_yoast_wpseo_title` and `_yoast_wpseo_metadesc` contain plain strings. `_yoast_wpseo_focuskeywords` contains a JSON array of four ordered objects with `keyword` strings and integer `score` values. `_yoast_wpseo_keywordsynonyms` contains a JSON array of five strings, each with a comma and space between the synonyms. The duplicate in slots 1 and 2 leaves the primary and first related mapping unconfirmed. The snapshot alone cannot identify whether entry or editor behavior caused the duplicate. The scores are observed editor data outside the test proposal.

Compared with the pre-test export, the raw long and short descriptions, attributes, all recorded protected-field hashes, variation 2840, all eight attachment records, image assignments and artisan checks match. The product modification timestamp advanced. The exporter has read-only coverage. A staging backup and the editor reload have no separate verification record here.

Post-save snapshot SHA-256 `758ddf2b075bdecabc14436c9b496d3dee227b6ec8f37f7f8c0a1dc413d211a6`.

## Corrected editor save

The user supplied the [corrected export](baseline/BHcrafts_Product_2839_Yoast_Editor_Correction_2026-11-11.json) from 11 November 2026 at 07:52:57 Europe/Sarajevo. Within the five Yoast metadata records, only `_yoast_wpseo_keywordsynonyms` changed from the first save. All five synonym pairs now appear in distinct slots in the intended order. The title, meta description and all five keyphrases still match exactly.

| Saved synonym slot | Role | Saved value |
| --- | --- | --- |
| 1 | Primary | `cotton knit handbag, knitted cotton bag,` |
| 2 | Related 1 | `handcrafted cotton bag, cotton bag made by hand` |
| 3 | Related 2 | `bag with doll appliqués, doll applique handbag` |
| 4 | Related 3 | `knit bag with dolls, knitted doll handbag` |
| 5 | Related 4 | `fair trade bag, fairly traded handbag` |

The snapshot integrity check passes. The exact-text comparison below reports one difference because the primary field ends with an extra comma. This punctuation does not obscure the two intended synonyms or their slot. Preserve the comma in this evidence and in any before-value snapshot. Use the proposal text for a future approved write. This evidence completes the slot-mapping check. It does not require another manual export.

The recorded product fields match the original baseline apart from the modification timestamp. The variation, eight attachment records, image assignments and artisan checks also match. The corrected file SHA-256 is `5b77c7493d6ecf09cc26cafb88d9fe766645ede2c4407035688fa9e22f5ddffe`.

```bash
php -n tools/validate_snapshot.php docs/product-2839/baseline/BHcrafts_Product_2839_Yoast_Editor_Correction_2026-11-11.json --yoast-proposal docs/product-2839/review_v0.2.json
```

## Next adapter test

[Work Bridge 0.1.0](../../plugin/bhcrafts-seo-work-bridge/README.md) implements the first Yoast 28.8 write test. Its fixed proposal removes the primary synonym's trailing comma. The staging checklist covers preview, approval, write and exact read-back, editor reload and resave, rendered title and description, and rollback to the exact prior value. The other four Yoast writes remain for subsequent testing.
