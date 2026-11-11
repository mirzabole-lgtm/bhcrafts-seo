# Change history

## Work Bridge 0.1.2: staged indexable repair

- Preview and approve the exact permalink hash, title and description repair for staging product 2839.
- Update one existing derived row with baseline and collision checks. Verify read-back and provide a separate exact restore.
- Pass 86 Work Bridge fixture checks. The first staging database execution remains pending.

## Work Bridge 0.1.1: read-only Yoast indexable report

- Compare the stored Yoast indexable for staging product 2839 with its current permalink and saved metadata.
- Use a bounded SELECT behind the existing staging and administrator checks. The report does not refresh Yoast data.
- Preserve the 0.1.0 write and rollback proposal. Pass 61 Work Bridge fixture checks. The new report still needs its first staging run.

## Work Bridge 0.1.0: first Yoast staging write test

- Add a separate staging-only WordPress plugin for the exact product 2839 synonym correction and field-level restore.
- Bind approval to the fixed proposal, operation, environment, product and saved baseline. Export an approval and read-back receipt.
- Pass 39 isolated fixture checks. Kinsta staging execution remains pending.

## 11 November 2026: first staging editor save

- Preserve the product 2839 post-save export and document the primary synonym mismatch.
- Add an optional offline comparison of the title, meta description, keyphrases and synonyms against the proposed values.
- Preserve the corrected export confirming all five synonym positions and record the trailing comma as an exact-text difference.

## 0.3.1: selected Yoast reference

- Read field structure from the selected staging stocking (616) alongside the product 2839 baseline.
- Include the fourth related keyphrase entry in the structure report.
- PHP syntax, 78 fixture checks and the form export passed. Staging exports verified on 11 November 2026.

## 0.3.0: read-only Premium schema evidence

- Preserve and validate the successful administrator-exported 0.2.1 raw baseline.
- Add WordPress registered-meta descriptors and a bounded structure-only sample of existing published-product Premium fields.
- Exclude phrase/synonym text, scores, defaults and unknown field-key text from supplemental samples. Reference IDs are evidence only, not edit targets.
- Reject invalid UTF-8 before WordPress JSON sanitization.
- Correct the draft's variation-image interpretation: raw image ID 0 inherits parent image 2841.
- Validation: four PHP syntax checks, 76 isolated checks and standard-form JSON export pass. Real staging execution of 0.3.0 remains pending.

## 0.2.1: standard form regression fix

- Accept WordPress's default submit-button field in the fixed product export.
- Reject non-string values for every accepted form field.
- Test the full standard WordPress form payload and reject array-valued submit input.
- Retain staging-host, product identity, object permission, method, nonce and scope restrictions.
- Validation: syntax checks and 62 isolated checks pass. Standard form export produces valid UTF-8 JSON. Staging execution pending.

## 0.2.0: fixed-scope raw product export

- Add a manual administrator export for product 2839.
- Include saved descriptions, image metadata, relationships, selected protected-field hashes and installed Yoast evidence.
- Preserve absent versus empty values, duplicate metadata rows, Unicode and JSON strings.
- Validation initially passed 61 isolated checks, but missed the standard submit-button field. The user reported the resulting form rejection. Use 0.2.1 for the corrected export.

## 0.1.0: environment diagnostics

- Add a staging-host-restricted administrator environment report.
- Report selected WordPress, PHP, theme and WooCommerce/Yoast versions without credentials or commerce data.
- The user installed this release and supplied its administrator-generated JSON report.

All releases are diagnostics only. No content-writing adapter or production changes are included.
