# Project status: 10 November 2026

## Current result

Diagnostics 0.2.1 is prepared for staging. It fixes the error “Unexpected form field. Product scope is fixed.” by accepting WordPress submit_button()'s standard submit field. Non-string values and unrecognized fields still fail. The request cannot choose another product, metadata key or URL.

All PHP syntax checks and 62 isolated checks pass. The authorized export regression submits action, _wpnonce, _wp_http_referer and submit, then verifies valid JSON for product 2839 and eight images. Real execution of the corrected release on staging remains pending.

## Completed

- Governing brief saved with all 17 sections, screenshot transcription and preservation requirements.
- Public live discovery: 382 storefront products, 33 categories and 2,503 public media records at the recorded check time.
- Staging URL verified. Public responses reported 378 products and 2,439 media records. The difference does not establish clone age.
- Diagnostics 0.1.0 executed by the user. The received report records the staging versions and environment identity.
- Product 2839 inspected, with eight unique images reviewed and a full content/SEO/image-metadata draft prepared.
- Public staging reference checks found gift-wrapping image 445 in 234 product arrays, discount image 357 in 231, and tag URL 577 in 367 product descriptions.
- Diagnostics 0.2.0 added a fixed-scope raw exporter. Its own form failed because the submit field was omitted from the request allowlist.
- Diagnostics 0.2.1 corrects the form bug and adds the relevant regression coverage.

## Next required step

Replace the staging diagnostics plugin with releases/BHcrafts_SEO_Staging_Diagnostics_0.2.1.zip. Use Tools > BHcrafts SEO Diagnostics > Download product 2839 snapshot. Attach BHcrafts_Product_2839_ReadOnly_Snapshot.json to the existing chat.

This manual administrator action remains necessary because no authenticated cloud WordPress connection has been established. No password or API key belongs in a chat message or this repository.

## Still open

- Read actual saved product/attachment fields from the administrator export.
- Establish actual Yoast Premium 28.8 field representation and normal editor-save/indexation behavior.
- Preserve the exact artisan block, tag identity, links and markup in a reviewed proposal.
- Complete authenticated sitewide shared-image checks, including variations, posts, pages, UX Blocks and settings.
- Verify backups, staging outbound isolation, protected fields and rollback.
- Establish secure cloud access and a trusted human-approval mechanism before an automated apply route.
- Obtain exact staging test and production pilot approvals when concrete proposals exist.

The current plugin has no content writer, restore operation, public REST route, media deletion or remote HTTP function. The content draft has not been applied.
