# Project status: 11 November 2026

## Current result

The user supplied the 0.2.1 product snapshot, generated 10 November 2026 at 19:05:23 UTC / 20:05:23 Europe/Sarajevo. It verifies the fixed form exported on staging PHP 8.3.36. The snapshot, raw-content, eight attachment and five Yoast metadata checksums match.

In the original baseline, product 2839 had no saved primary phrase, SEO title or meta-description key, and the two Premium fields held empty strings. Variation 2840 has own image ID 0 and inherits the parent image on the frontend. The baseline directory and registry preserve the exact raw artisan block, image markup and CRLF descriptions.

Draft v0.2 includes actual before-values but remains held. Diagnostics 0.3.1 adds read-only Yoast field structure from the selected reference product 616 without phrase text, plus WordPress metadata registration evidence. Four PHP files and 78 isolated checks pass. The 0.3.1 staging export succeeded on 11 November at 06:40:11 Europe/Sarajevo. The product baseline matches the earlier export. Reference 616 shows four related-keyphrase objects with keyword and score fields, and a separate array with five synonym entries.

The [first editor save export](product-2839/baseline/BHcrafts_Product_2839_Yoast_Editor_Save_2026-11-11.json) verifies the saved title, description and five keyphrases. The first synonym slot duplicates the second. The other four slots match the expected values. The saved descriptions, recorded protected-field hashes, variation, attachment records and artisan checks match the pre-test export. Any future Yoast apply proposal needs a fresh baseline.

The [corrected export](product-2839/yoast_editor_test_v0.1.md#corrected-editor-save) confirms the primary synonym pair in the first slot and the four related pairs in order. The only exact-text difference from the proposal is a trailing comma in the primary synonyms. The baseline comparisons still pass for descriptions, protected-field hashes, variation, image records and artisan checks.

The administrator supplied the Work Bridge 0.1.0 apply receipt from 11 November 2026 at 08:50:47 Europe/Sarajevo. It matches the bundled proposal and reports a successful write and exact read-back of all five Yoast rows. The primary synonyms now read `cotton knit handbag, knitted cotton bag`. The administrator attested to the staging backup and outbound isolation. This record omits account identifiers and the private backup reference.

The [post-apply Diagnostics 0.3.1 export](product-2839/baseline/BHcrafts_Product_2839_Yoast_Post_Apply_2026-11-11.json) from 11 November 2026 at 09:31:21 Europe/Sarajevo verifies the receipt independently. The exact proposal comparison passes for the SEO title, meta description, five keyphrases and all synonym pairs. Only the synonym metadata row differs from the corrected pre-apply export. The full product record, captured protected-field hashes, variation, all eight attachment records and artisan preservation checks match.

The [post-resave export](product-2839/baseline/BHcrafts_Product_2839_Yoast_Post_Resave_2026-11-11.json) from 10:10:21 Europe/Sarajevo matches the exact proposal and all five saved Yoast rows, including the recorded related keyphrase scores. The product modification time advanced to 10:09:58. The remaining captured product fields, variation, eight attachments and artisan checks match the post-apply snapshot.

The [post-rollback export](product-2839/baseline/BHcrafts_Product_2839_Yoast_Post_Rollback_2026-11-11.json) from 10:15:29 Europe/Sarajevo confirms that the original synonym row was restored, including the trailing comma. All five Yoast rows match the corrected pre-apply baseline exactly. The synonyms row is the only captured content change since the resave. The product modification time and the captured product, variation, attachment and artisan records match the post-resave export. The strict apply comparator now flags only the restored comma, as expected.

The administrator supplied the staging product’s HTML head lines on 11 November 2026. The rendered title is `Knitted Bag with Three-Doll Applique - BHcrafts`. The rendered description starts `This unique handmade bag with its doll applique can be your ideal everyday bag.` Both match the pre-test storefront output. Both differ from the saved Yoast title and description. The robots tag is `noindex, nofollow`, consistent with the recorded WordPress `blog_public=0` and [Kinsta staging behavior](https://kinsta.com/docs/wordpress-hosting/staging-environment/#3-seo). The robots check passes. The storefront comparison confirms a mismatch between the current rendered and saved metadata.

The administrator supplied a screenshot of four Yoast notices. One flags the expected staging visibility setting. The other three report subscription activation or verification problems for Yoast SEO Premium, Yoast WooCommerce SEO and Yoast Local SEO. The administrator confirmed the Yoast license covers one URL, `bhcrafts.shop`. Keep the assignment on the live domain. The staging notices are consistent with that domain scope. They do not establish the cause of the storefront mismatch. See [Yoast subscription scope](https://yoast.com/help/yoast-subscriptions-faq/#what-are-different-domains-in-a-yoast-subscription).

The administrator repeated the Yoast head request after the rollback. The response reported `status: 404`, title `Page not found - BHcrafts`, no product meta description, and robots `noindex, follow`. The product page itself loads and its HTML showed `noindex, nofollow`. These values come from different responses. The API returned the Yoast 28.8 error-page metadata and site schema. This was a frontend metadata lookup, separate from subscription verification. See [Yoast's REST API status guidance](https://developer.yoast.com/customization/apis/rest-api/#why-does-the-api-return-a-404-status-for-an-existing-page).

In Yoast 28.8, the URL surface looks up a stored indexable by the exact permalink and hash. The product-ID path looks up the post object and can build a model when a row is missing. The public API response cannot distinguish a missing row from an old permalink or another lookup or presentation problem. Yoast disables new stored indexables by default outside production. See [the 28.8 URL surface](https://github.com/Yoast/wordpress-seo/blob/28.8/src/surfaces/meta-surface.php#L309-L342), [the 28.8 repository](https://github.com/Yoast/wordpress-seo/blob/28.8/src/repositories/indexable-repository.php#L181-L189), and [Yoast indexables guidance](https://developer.yoast.com/features/indexables/indexables-filters/#disabling-indexables-completely).

The [first staging indexable report](product-2839/baseline/BHcrafts_Yoast_Indexable_2839.json) at 11:48:47 Europe/Sarajevo found one row for product 2839. Its stored permalink equals the current staging permalink, but its hash `63:db0d112a7674b4ec88ad6862008d062a` exactly matches the equivalent live `bhcrafts.shop` URL. The staging permalink hashes to `89:8f4f7009daffbd9e477791a629563f18` under Yoast 28.8's algorithm. This row cannot satisfy the staging URL lookup. Its title and description are both `null`, while the saved WordPress Yoast fields still contain the approved text. Yoast's post presentation uses template values when the indexable has no title or description. The report explains the URL lookup failure and provides a credible explanation for the earlier rendered title. The rendered output still needs verification after repair. See [Yoast 28.8 permalink hash calculation](https://github.com/Yoast/wordpress-seo/blob/28.8/src/models/indexable.php#L174-L178) and [post presentation fallbacks](https://github.com/Yoast/wordpress-seo/blob/28.8/src/presentations/indexable-post-type-presentation.php#L147-L187).

## Completed

- Governing brief saved with all 17 sections, screenshot transcription and preservation requirements.
- Public live discovery: 382 storefront products, 33 categories and 2,503 public media records at the recorded check time.
- Staging URL verified. Public responses reported 378 products and 2,439 media records. The difference does not establish clone age.
- Diagnostics 0.1.0 executed by the user. The received report records the staging versions and environment identity.
- Product 2839 inspected, with eight unique images reviewed and a full content/SEO/image-metadata draft prepared.
- Public staging reference checks found gift-wrapping image 445 in 234 product arrays, discount image 357 in 231, and tag URL 577 in 367 product descriptions.
- Diagnostics 0.2.0 added a fixed-scope raw exporter. Its own form failed because the submit field was omitted from the request allowlist.
- Diagnostics 0.2.1 corrects the form bug and adds the relevant regression coverage.

- The 0.2.1 raw snapshot was received and validated. A preservation registry and updated draft v0.2 record actual before-values.
- The user selected Christmas Stocking Personalized. The staging Store API confirmed product ID 616, and the 0.3.1 exporter targets this reference.

## Next required step

Review the scoped staging repair below. The read-only report has completed its first staging run. The repair has not been applied.

## Proposed staging indexable repair

Repair only the existing derived Yoast row for post object 2839 on the designated Kinsta staging host. Use a fresh read to confirm exactly one row, the expected staging permalink, all three before-values and both saved source fields. Check for any conflicting row at the staging permalink and hash. Reject drift and require separate approval of the exact change. Retain the before-values as the rollback baseline.

| Derived field | Before | Proposed |
| --- | --- | --- |
| Permalink hash | `63:db0d112a7674b4ec88ad6862008d062a` | `89:8f4f7009daffbd9e477791a629563f18` |
| SEO title | `null` | Knitted Cotton Handbag with Doll Appliqué &#124; BHcrafts |
| Meta description | `null` | Choose a knitted cotton handbag with three doll appliqués and colorful striped handles. Available in black or green, handmade by BHcrafts women artisans. |

Verify the same row with the read-only report, retest the Yoast URL response and compare the rendered title and description on staging. Verify `noindex` and compare the protected product fields with the baseline. If rollback is approved, restore the exact three prior values only if the row still matches the applied state. Keep the repair scoped to the derived row, with product metadata, the current permalink, search visibility and the live subscription outside the write scope. Yoast's general post rebuild also touches related indexable data, so review the selected implementation's write footprint before applying it. See [the Yoast 28.8 builder](https://github.com/Yoast/wordpress-seo/blob/28.8/src/builders/indexable-builder.php#L328-L357).

## Still open

- Diagnose the staging storefront metadata mismatch and test writes to the remaining Yoast fields.
- Preserve the exact artisan block, tag identity, links and markup in a reviewed proposal.
- Complete authenticated sitewide shared-image checks, including variations, posts, pages, UX Blocks and settings.
- Verify backups, staging outbound isolation, protected fields and rollback for subsequent write types.
- Establish secure cloud access and a trusted human-approval mechanism before an automated apply route.
- Obtain exact staging test and production pilot approvals when concrete proposals exist.

Diagnostics 0.3.1 remains read-only. Work Bridge 0.1.0 implements the fixed staging test through WordPress admin. The full content draft remains pending review and apply.
