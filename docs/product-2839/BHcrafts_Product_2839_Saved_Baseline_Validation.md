# Product 2839: saved baseline validation and draft v0.2

Administrator export: 10 November 2026, 20:05:23 CET. Producer: diagnostics 0.2.1 on PHP 8.3.36.

## Export result

The standard-form fix worked on staging. The uploaded JSON has the expected schema, staging host, product ID, seven-image parent order, variation ID and eight attachment IDs. Its snapshot/content checksums, all eight attachment baselines and all five selected Yoast metadata checksums match. These checks establish internal consistency, not a digital signature or a cloud authenticated session.

The original uploaded bytes are retained in [the baseline JSON](baseline/BHcrafts_Product_2839_ReadOnly_Snapshot_2026-11-10.json). The product description preserves CRLF line endings. No shortcodes were executed and no site writes were performed by the exporter.

## Saved Yoast values

| Field alias | Stored state | Meaning for the draft |
| --- | --- | --- |
| _yoast_wpseo_focuskw | Key absent | No saved primary keyphrase in this field. |
| _yoast_wpseo_title | Key absent | The rendered title is a fallback/template output, not an explicit saved title. |
| _yoast_wpseo_metadesc | Key absent | The rendered description does not prove an explicit saved meta-description field. |
| _yoast_wpseo_keywordsynonyms | One existing empty string | Preserve present-versus-empty state for rollback. A nonempty encoding example is still needed. |
| _yoast_wpseo_focuskeywords | One existing empty string | The related-keyphrase JSON structure is not demonstrated by an empty value. |

The installed public WPSEO_Meta registry exposes focuskw, title and metadesc. It does not expose the two Premium field aliases through that public registry. This does not prove Premium lacks those fields. The saved key inventory proves the latter two keys exist, but their empty contents do not establish a valid write format.

All five proposed phrase/synonym entries remain in the [draft v0.2 JSON](review_v0.2.json). No adapter has written them or fabricated scores.

## Preserved artisan markup

The saved content confirms the exact heading and hang-tag attachment 577. It contains this malformed escaped fragment:

```html
&lt;style="padding-left: 120px"&gt;
```

The earlier public rendered output changed its quote appearance. The [preservation registry](preservation_registry_v0.2.json) now retains the actual raw artisan block, exact original image markup and their source hashes.

Draft v0.2 retains the raw image element's attributes exactly except for the explicitly proposed alt-text replacement. The master-paragraph replacement, removal of the malformed fragment, care revision and closing section remain proposed changes. The source block is not silently overwritten.

## Variation image correction

Variation 2840 has **own image ID 0** in edit context. The earlier frontend response displayed parent image 2841 as a fallback. This distinction matters: a future writer must preserve image inheritance and must not set 2841 as a new variation assignment.

The Color attribute has Black and Green options, variation=true and visible=false. These configuration values remain unchanged.

## Raw image fields

All eight saved title/caption/description/alt records are now available, including the literal apostrophes hidden by earlier rendered typography. They are embedded as before-values in draft v0.2. The five product photo records remain distinct from shared assets 445, 357 and 577. The previous public reference counts remain partial sitewide evidence, not clearance to update shared metadata.

## Next read-only evidence step

Diagnostics 0.3.0 adds actual WordPress post-meta registration details and a bounded structure-only sample for the two Premium candidates. It examines at most five published product candidates per key, checks administrator object permissions, masks text values and unknown field-name text, and exports only shape/source references. It does not include those reference products in the edit manifest.

This is needed because product 2839's related-keyphrase and synonym values are empty. It avoids filling the fields simply to guess their format. A structure sample still does not verify normal editor-save or indexing behavior. Writer compatibility stays false until those checks pass.

## Application status

Draft v0.2 is not approval-eligible for application. Remaining gates include Premium format/save behavior, full shared-image coverage, browser/layout checks, backups, outbound isolation, protected-field coverage and exact human approval. No product, variation, attachment or SEO value has been changed by this validation.
