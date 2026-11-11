# BHcrafts WooCommerce + Yoast SEO Premium — Work Brief

**File:** BHcrafts_WooCommerce_SEO_Work_Brief.md  
**Prepared:** 10 November 2026 · Europe/Sarajevo  
**Website:** https://bhcrafts.shop/  
**Working environment:** ChatGPT Work Cloud, with background execution  
**Source repository:** https://github.com/mirzabole-lgtm/bhcrafts-seo  
**Current stage:** Staging title and description apply and storefront output verified. Editor resave and rollback pending. No live product changes authorized.  
**Source conversation:** [Connect ChatGPT WooCommerce](https://chatgpt.com/c/6af0b60e-e7f0-83eb-a17f-58a0d05e52a8)

## 1. Project mandate and immediate next steps

Continue the BHcrafts WooCommerce and Yoast SEO Premium optimization project in **ChatGPT Work Cloud**. Keep this Markdown file available there as the governing project brief. Work Cloud is the user's main place for content preparation, selection, review, approvals, and ongoing operations. Codex may be used to build and test the WordPress integration, while using the same controlled API and approval rules.

The user wants all work to happen in the background. Do not control their Windows desktop, foreground browser, or local applications. Use cloud files, connected services, APIs, and background development tools. Do not silently fall back to local computer control if cloud access is unavailable.

Start with this brief and the phases below. Prepare reviewable work before requesting approval for consequential steps. **Do not modify live products, live image metadata, or live site settings without explicit approval of the concrete proposed changes. Do not delete media automatically.**

### Implementation phases

| Phase | Work | Reviewable result / exit condition |
| --- | --- | --- |
| 0 — Establish the project | Save this file in Work Cloud; retain source evidence; confirm constraints and outstanding access details. | Downloadable Markdown brief and a clear list of genuine dependencies. |
| 1 — Read-only discovery | Inspect the approved site's versions, API access, product/category inventory, existing content, image relationships, Yoast fields, and Kinsta staging setup. | Inventory, field map, preserved-content registry, and frozen candidate product list. |
| 2 — Build the integration | Use Codex for a versioned BHcrafts WordPress plugin, narrow API/tool adapter, previews, approval enforcement, logs, backups, and rollback. No production activation yet. | Source repository, installable plugin ZIP, API specification, meaningful tests, and setup guide. |
| 3 — Prove it on Kinsta staging | Install on the designated staging environment when access and authorization are established; test all write types, failures, shared images, protected fields, and rollback. | Staging validation report and reproducible rollback evidence. |
| 4 — Prepare the first content pack | Select a small representative set; inspect every selected image; propose keyphrases, descriptions, SEO fields, and image metadata. | Before/after previews with exact product and attachment IDs, facts, and preserved artisan sections. |
| 5 — Approved live pilot | After explicit production approval and backup, deploy the tested plugin and apply only the approved pilot changes. | Read-back and storefront verification; protected-field comparison; change log. |
| 6 — Controlled rollout | Resolve IDs/categories/all-published into frozen batches; draft, approve, apply, and verify each batch. | Complete approved content packs and recoverable batch history. |
| 7 — Unused-media audit | Run the read-only audit, first validating detection on staging, then inventorying the approved live scope. | Evidence-based report for human review; no deletions, moves, or file cleanup. |

Independent read-only work and drafting can continue while another phase awaits an access detail or approval. Selection of a category or all published products is permission to define the scope; it is not approval to publish changes.

## 2. Objectives and deliverables

1. Improve useful, accurate product content while preserving BHcrafts' artisan story and the facts of each handmade item.
2. Prepare a complete SEO/content package for every selected product: long description, short description, one primary Yoast focus keyphrase with synonyms, four related keyphrases with their own synonyms, SEO title, and meta description.
3. Prepare all four WordPress metadata fields for every featured and gallery image: alt text, image title, caption, and image description. Include variation images in the inventory and handle any proposed metadata edits explicitly.
4. Relate image metadata naturally to the approved keyphrase plan without inventing visible details or repeating keywords mechanically.
5. Preserve image assets, product identity, pricing, SKU, inventory, variation configuration, and existing presentation behavior.
6. Provide authenticated WordPress/WooCommerce integration plus a custom, tested Yoast Premium write integration.
7. Support previews, scoped approvals, small batches, resumable processing, audit logs, conflict detection, and field-level rollback.
8. Identify media with no detected references across the site, including Flatsome and site settings, without assuming that "Unattached" means unused.

A successful brief is not evidence that integrations are connected or that product optimization has already been applied. Record those milestones separately.

## 3. Evidence, inherited decisions, and source limits

### Confirmed project decisions

- Site stack: WordPress, WooCommerce, Flatsome/UX Builder, Yoast SEO Premium, and Kinsta hosting/staging, as described in the source project.
- Products must be selectable by explicit product IDs, one or more categories, or all published products.
- Long and short descriptions, Yoast focus/related keyphrases and synonyms, SEO titles/meta descriptions, and all image metadata are in scope.
- Captions are required even though the user has disabled Flatsome's caption display. This later clarification overrides the earlier suggestion to omit captions to avoid visible text.
- The artisan hang-tag image and its meaning must be preserved.
- Shared attachments require review before metadata changes.
- Read-only media scanning and review precede any potential cleanup. No automatic deletion.
- Work Cloud is the requested main environment. The user has explicitly rejected use of their PC for interactive work.

### Source coverage

The history tool recovered the later project messages about captions, gallery metadata, media auditing, and Work/Codex roles. It did not expose the earliest source turns or their original attachments. On 10 November 2026, the user supplied a fresh screenshot in this chat and instructed that it replace the plan for manually entering preserved text. Its transcription and visual rules are captured below.

Do not claim to have recovered unseen historical requirements. If the original conversation later becomes fully available, reconcile any additional constraints with the user's current instructions and record material differences.

The new screenshot's source filename is **ChatGPT Image Nov 10, 2026, 02_15_26 PM.jpg**. Its local source path was provided in the current chat. Cloud work must rely on the transcription below unless the original image is separately available in the cloud; a local Windows path does not make an attachment cloud-accessible.

## 4. Screenshot-derived artisan and description rules

### 4.1 Verbatim reference transcription

Line wrapping has been normalized. The screenshot shows the following text, capitalization, and section order.

**Heading: Bring Home Handmade Comfort**

> Choose long wool slipper socks made with care, skill, and purpose. Enjoy the warmth of natural fibers and the beauty of authentic Bosnian craftsmanship.

> Add a pair to your winter wardrobe or give someone a thoughtful handmade gift.

**Heading: MORE INFORMATION ABOUT ARTISANS**

> The woman named on the hang tag crafted this product especially for you. Additionally, with every stitch, she infused her knowledge, patience, and love, creating a truly unique and custom-made piece. By choosing this item, you support one of the hundreds of BHcrafts women artisans in earning a living, while enjoying its design and exceptional quality work.

> We craft all our products from the finest materials, but not taking care of them may cause them to break. By following them, you’ll enjoy these fair-trade soft chunky hand-knit wool slipper socks, which are carefully made by women artisans, for years to come.

### 4.2 Visual structure to preserve

- A closing comfort/gifting section precedes the artisan section.
- The artisan heading is visually prominent and uppercase.
- A photograph of a BHcrafts hang tag sits on the left, with the artisan text beside it. Preserve the actual existing image, its identity, placement, and relevant link/markup when updating a product.
- The screenshot's red underlines mark the closing call to action and the product-specific phrase near the end. Treat them as annotations, not instructions to introduce red underlines on the website.
- Do not transcribe tiny hang-tag print that is not reliably readable. Do not replace the source hang-tag asset with a crop of this screenshot.
- Preserve the layout using the site's existing HTML, shortcodes, blocks, and styles. On mobile, the existing layout may stack; verify readability and image placement without redesigning the product page.

### 4.3 What stays fixed and what can be adapted

| Element | Rule |
| --- | --- |
| "MORE INFORMATION ABOUT ARTISANS" heading | Preserve the wording and the section. |
| First artisan paragraph beginning "The woman named on the hang tag..." | Use the exact reference wording above as the default preserved master paragraph. Do not rewrite it for keywords. Flag factual inconsistencies for review rather than silently changing it. |
| Hang-tag image and explanation | Preserve the image and the link between the maker named on the tag and the handmade item. Do not invent a maker's identity. |
| Closing comfort/gifting section | Preserve its role and meaning; propose product-appropriate heading, benefit copy, and call to action when slipper-sock wording would not fit. |
| Final quality/care paragraph | Preserve its craftsmanship, care, and longevity message. Adapt the product-specific phrase to the actual product and approved keyphrase; show the complete proposed paragraph for review. |
| "long wool slipper socks" / "fair-trade soft chunky hand-knit wool slipper socks" | These describe the screenshot's product, not every item in the shop. Do not copy them onto stockings, toys, or other products. Use only verified materials, techniques, and claims. |
| Awkward source wording such as "By following them" | Keep the verbatim reference in this brief. Any editorial correction in product copy must appear visibly in the proposal; do not present an improved sentence as a verbatim screenshot quote. |

The first artisan paragraph may be reused across products as intentionally preserved brand content. Distinct product copy should surround it. It is not necessary to make every artisan paragraph unique.

### 4.4 Preservation implementation

Before changing a long description:

1. Capture its exact raw content, rendered view, embedded image IDs/URLs, and shortcode/block structure.
2. Identify the existing artisan section, hang-tag image, related links, and closing call to action. Store the original block and a checksum in a preservation registry.
3. If a product contains a different existing artisan paragraph, show the difference against the screenshot master. Do not silently overwrite it under a blanket preservation rule.
4. Retain the original artisan content and layout while drafting the product-specific sections.
5. If the section is missing, propose adding the screenshot-based block using a verified existing hang-tag attachment; do not attach an arbitrary substitute.
6. Show preservation checks in the review pack. Stop that product's write if the required section is missing, unexpectedly changed, or cannot be parsed safely.

The screenshot establishes copy requirements. It does not authorize publishing, prove every product's composition, or establish that every product is custom-made, wool, fair-trade certified, or produced using the same technique.

## 5. Product scope and selection

### Selection modes

| Mode | Required input and resolution |
| --- | --- |
| Product IDs | Validate the supplied positive integer IDs against the selected environment. Return product name, status, URL, and type; report missing IDs. Do not substitute a different product. |
| Categories | Resolve names/slugs to category IDs; display the matches and whether descendants are included. For multiple categories, default to a documented union, deduplicate products, and freeze the resolved ID list. |
| All published products | Query all pages of products with published status, use deterministic ordering, deduplicate, and save the complete ID manifest and count. Exclude other statuses unless explicitly selected. |

Do not infer the first production target from an example in the prior conversation or from an open browser page. No live product IDs or categories have been approved in this brief.

Freeze selections at proposal time so that newly published or recategorized products cannot silently join an approved batch. Save the original query, inclusion/exclusion choices, category tree handling, resolved IDs, timestamp, and environment identity.

Variable products require a parent/variation relationship map. Parent descriptions are the default content target. Variation images are included in usage/shared-image checks; variation description changes require a separately shown proposal. Preserve variations, attributes, defaults, and commercial data.

Use a small representative pilot before expanding: for example, a simple product, a variable product, a product using shared media, and a page with the artisan/hang-tag layout. These are suggested test cases, not authorization to choose particular live products.

## 6. Required content package for every selected product

### 6.1 Fact and evidence record

Capture the current name, URL, categories, product type, approved attributes/specifications, raw long and short descriptions, existing Yoast values, featured/gallery/variation attachment IDs, and source modification markers.

Maintain separate columns for:

- Verified product facts from the product record or user.
- Details visibly confirmed in each photograph.
- Preserved brand/artisan content.
- Unsupported, conflicting, or missing claims needing review.

Do not infer fiber composition, exact dimensions, care instructions, certifications, origin, availability, personalization, bundle contents, included accessories, or maker identity from appearance alone. An accessory in a styled photograph is not automatically included in the sale.

### 6.2 Long description

Deliver a complete WooCommerce long description, not only an outline or SEO suggestions. It should:

- Open with useful, product-specific copy and a natural use of the primary keyphrase or a close form.
- Explain the item's verified design, materials, making technique, intended use, and distinctive details.
- Include accurate specifications, personalization options, care guidance, or practical details where the sources support them.
- Use clear paragraphs and useful subheadings compatible with the existing theme. Avoid adding another H1.
- Preserve meaningful links, required artisan sections, hang-tag image, and relevant existing markup.
- Retain the screenshot's closing benefit/gifting and artisan/care functions with product-appropriate wording.
- Avoid invented claims, excessive sales language, filler, or keyword repetition.

No fixed historical word count was recovered. A practical starting range is roughly 300–600 words where the available facts support it; this is a proposed working default, not a requirement to pad copy or shorten substantial useful content.

### 6.3 Short description

Deliver a separate WooCommerce short description that quickly identifies the item, its verified distinguishing features, and its value to the shopper. Use concise prose or a short list compatible with the current product summary area.

A proposed starting range is approximately 40–90 words, adjusted to the product. Include a natural keyphrase where useful. Do not repeat the entire artisan block in the short description unless specifically approved, and do not put volatile prices or stock quantities into descriptive copy.

### 6.4 Yoast Premium keyphrase package

For each product supply **five keyphrase entries**:

| Entry | Required content |
| --- | --- |
| Primary focus keyphrase | One phrase matching the product and shopper intent, with a separate list of relevant synonyms. |
| Related keyphrase 1 | A distinct relevant phrase, with its own synonyms. |
| Related keyphrase 2 | A distinct relevant phrase, with its own synonyms. |
| Related keyphrase 3 | A distinct relevant phrase, with its own synonyms. |
| Related keyphrase 4 | A distinct relevant phrase, with its own synonyms. |

Yoast describes support for the main focus keyphrase plus up to four related phrases. This project requests all four related entries. See [Yoast related keyphrases](https://yoast.com/features/seo-analysis/related-keyphrases/).

Use meaningful synonyms and close forms, not unrelated keywords. Prefer a few useful synonyms for each entry rather than a forced quota. Flag an entry if no accurate synonym is available. Explain the intent briefly, check overlap with other products, and use the phrases naturally in copy. Do not invent search-volume or competition figures.

Persist the phrases and their synonyms into the actual Yoast Premium fields through the tested adapter. A spreadsheet, a custom field with a similar name, or an API success response alone does not prove the Yoast UI is populated.

### 6.5 SEO title and meta description

Supply a unique proposed SEO title and meta description with a before/after comparison. Put the main product meaning early and use a keyphrase naturally. Include BHcrafts branding where useful without duplication.

Use the installed Yoast snippet preview and actual rendered output to judge fit. Character counts may be included as review aids; they are not hard search-engine display guarantees. Avoid unsupported offers, delivery promises, or claims. Google may display a different snippet; do not promise a particular search result or ranking.

The SEO title is an SEO field. It does not authorize changing the WooCommerce product name, slug, permalink, canonical, or redirects.

## 7. Metadata for every product image

Inventory the featured image, each gallery image in order, and variation images. Inspect the actual photographs before writing metadata. Give each unique attachment one consistent proposed metadata record and list every selected product/role referencing it.

WordPress exposes attachment title, alt text, caption, and description through the media API. Read edit-context raw values where authorized and use the exact approved strings for writes and read-back. See [WordPress media API](https://developer.wordpress.org/rest-api/reference/media/).

| Field | Content rule |
| --- | --- |
| Alt text | Describe the image's relevant visible subject, design, colors, angle, or detail. Include a suitable keyphrase/synonym only when natural and accurate. Accessibility takes priority. |
| Image title | A clear attachment title identifying the product or general subject and the image's particular view. This is metadata, not the filename. |
| Caption | A short, useful, image-specific sentence. Populate it even though Flatsome caption display is disabled. |
| Image description | A fuller accurate explanation of the image and relevant verified product context, with appropriate related phrases where useful. |

Do not paste the full keyphrase list into alt text. Do not claim that every image depicts the same angle or reuse the same caption across genuinely different photographs. When the same image file is reused, metadata belongs to the shared attachment rather than separately to each gallery placement.

The hang-tag image must describe the tag and its artisan meaning; do not relabel it as a photograph of a stocking or slipper. A generic shared brand image should retain generic accurate metadata.

If an image cannot be inspected, mark it "metadata pending visual review" rather than guessing. Include the issue in the product's completeness status.

### Shared-image safeguards

1. Build an attachment-to-reference map across all products and variations, posts, pages, UX Blocks, reusable blocks, and relevant settings—not only the selected batch.
2. Show all discovered affected locations before proposing a shared attachment update.
3. Use neutral, truthful metadata for an attachment shared by unlike products.
4. If selected products imply conflicting metadata, hold the attachment for separate review. Never let the last processed product overwrite another product's metadata.
5. Do not duplicate, replace, detach, re-upload, or reorder images as a workaround.
6. Approve shared attachment changes explicitly, including their broader effect outside the selected product set.
7. Inspect embedded alt attributes in existing content as well as Media Library values. Updating a shared attachment may not update a hard-coded alt attribute already saved in a page.

### Image assets and presentation safeguards

Preserve original files, filenames, URLs, attachment IDs, image ordering, featured/gallery/variation assignments, dimensions, crops, generated sizes, and existing optimization/WebP behavior. No renaming or regeneration is part of this project.

Populate captions in the Media Library while preserving the user's current Flatsome display setting. Verify that the product gallery and lightbox still behave as intended. Captions may appear in other locations; include those locations in the review when relevant. Do not change global caption settings as part of an attachment update.

## 8. Immutable fields and allowed writes

The integration must enforce a server-side allowlist, not rely on an agent's promise to avoid fields.

### Allowed only after approval

- WooCommerce long description and short description.
- The approved Yoast focus keyphrase, its synonyms, four related keyphrases and synonyms, SEO title, and meta description.
- Approved attachment alt text, attachment title, caption, and description.

### Protected fields

Never write or restore these as part of an SEO update:

- Product/variation IDs, parent relationships, type, product name, slug, URL, and publication status.
- SKU and other product identifiers.
- Regular/sale prices, sale schedules, taxes, discounts, currency, and commercial rules.
- Stock quantities/status, stock-management settings, backorders, reservations, and sold-individually settings.
- Featured/gallery/variation image assignments and order; image binaries, filenames, paths, URLs, sizes, optimization files, and attachment identity.
- Categories, tags, brands, attributes, variation options/defaults, weight, dimensions, shipping settings, downloads, and purchase configuration.
- Orders, customers, payments, reviews, affiliate data, checkout settings, and unrelated metadata.
- Canonicals, robots directives, schema settings, redirects, social metadata, global Yoast settings, theme settings, cache configuration, and plugin updates.

Changes outside the allowlist require a separate concrete proposal and explicit scope authorization. Reject unknown fields rather than passing them through.

Snapshot protected fields to detect accidental writes, but never restore them from an old SEO snapshot. Live inventory can legitimately change because of sales; distinguish those changes from integration writes using logs and fresh reads.

## 9. Approval and execution workflow

Use this lifecycle:

**Selected → Read-only snapshot → Draft → Validation → Review → Explicit approval → Apply → Read-back verification → Completed / Failed / Rolled back**

Each review pack must show:

- Environment/domain and exact frozen product IDs, names, and links.
- Exact fields to change with current and proposed values.
- The complete long and short descriptions, with the preserved artisan section visible.
- All five Yoast keyphrase entries with synonyms, plus SEO title and meta description.
- Each attachment ID, thumbnail/link, image role, current/proposed metadata, shared references, and conflicts.
- Unsupported claims, missing data, skipped records, and completeness status.
- Protected-field summary, rollback snapshot reference, proposal version/hash, and batch size.

Approval is bound to the environment, selected IDs, attachment IDs, field set, exact proposal version/hash, and shared-image effects. A request to draft, connect, select a category, or optimize all products does not authorize arbitrary production writes.

Example approval wording, only after the real pack exists:

> Approve proposal [real proposal ID/version] for the listed products and attachments on [real environment], limited to the displayed description, Yoast, and image-metadata changes.

Any material edit after approval requires a revised preview and renewed approval of the changed proposal. Staging acceptance does not constitute production approval.

Before applying, re-read the target fields and check the approved baseline. If a human or another process has changed them, pause the affected record and regenerate its comparison. Reject stale proposals instead of overwriting newer content.

Record the approval evidence, actor, timestamp, proposal hash, baseline values, changed fields, result, and verification. Never let an agent self-approve a production proposal. Approval must be enforced by the integration's workflow, with staging and production kept distinct.

## 10. WordPress and WooCommerce API integration

### Intended architecture

**Work Cloud → approved authenticated connector/tool adapter → BHcrafts WordPress plugin → WordPress/WooCommerce/Yoast adapters**

Both Work and any Codex development workflow use the same controlled API. Do not build separate uncontrolled writers.

Use WooCommerce REST API v3 for product/category/variation reads and the standard WordPress REST media API for attachment reads. WooCommerce documents description and short_description product fields; see [WooCommerce products API](https://developer.woocommerce.com/docs/apis/rest-api/v3/products).

For production automation, route permitted writes through the custom approval-aware plugin. Do not give the content workflow a generic unrestricted product-update or database tool. The plugin can call WordPress/WooCommerce APIs internally for the approved fields.

### Authentication and connection setup

- Confirm the actual live and staging URLs before using credentials.
- Use HTTPS and dedicated, revocable credentials stored in the cloud's approved secret/connection facility; never include them in this brief, chat messages, source control, URLs, or logs.
- WordPress Application Passwords can authenticate REST requests as a dedicated user. Their authority follows that user's capabilities; they are not field-scoped by themselves. See [WordPress Application Passwords](https://developer.wordpress.org/advanced-administration/security/application-passwords/).
- WooCommerce consumer keys are an alternative for WooCommerce endpoints. Start with read-only access for discovery. Do not assume they also authenticate core media or custom routes without testing. See [WooCommerce authentication](https://developer.woocommerce.com/docs/apis/rest-api/authentication).
- A WooCommerce key alone does not provide a Yoast Premium write API.
- Restrict the integration role and custom route permissions; broad core product/media write access would bypass the intended field restrictions. Verify and block alternate write paths for the automation principal where necessary.
- Keep staging and production connections, secrets, approval scopes, and environment fingerprints separate. Prevent production credentials from being used in staging.
- Use a Work-compatible connector/MCP/tool bridge only if available and verified. Record the actual connection method; do not claim that a standard WooCommerce connection has been established merely because credentials exist.
- Do not ask for credentials in plain chat. If a required secret facility or connection is unavailable, state the specific access dependency and continue independent drafting/build preparation.

### Proposed custom API contract

The names below are a design proposal, not endpoints that already exist:

| Operation | Purpose |
| --- | --- |
| Capabilities / environment | Return environment identity, versions, supported fields, permissions, and read-only/write-disabled state. |
| Product selection / snapshot | Resolve selection and return sanitized content, facts, attachment relationships, and baseline markers. |
| Preview proposal | Validate the allowlisted changes and return complete diffs without writing products or media. |
| Approval registration | Bind a verified human approval to the proposal/version and exact environment; the automation caller cannot forge this. |
| Apply approved proposal | Apply only approved fields and IDs with conflict checks, idempotency, snapshots, and bounded batches. |
| Job / change status | Report per-record progress, actual writes, failures, verification, and safe resume information. |
| Restore approved content fields | Produce/review a rollback diff, then restore only eligible fields using conflict checks and proper authorization. |
| Media-usage audit | Run a read-only resumable scan and return evidence and coverage gaps. |

Every custom REST route needs authentication, a permission callback, object-level capability checks, strict schemas, validation, sanitization, and bounded payloads. Use WordPress REST conventions; see [WordPress routes and endpoints](https://developer.wordpress.org/rest-api/extending-the-rest-api/routes-and-endpoints/).

No arbitrary SQL, arbitrary metadata writes, shell execution, file deletion, unrestricted settings export, or arbitrary remote URL fetch tool belongs in the content integration. The media scanner may inspect relevant server-side values, but return usage evidence rather than credentials or unrelated settings.

Use pagination, explicit timeouts, small batches, rate limiting, and bounded retry/backoff. A timed-out write has an unknown outcome until read-back or job status proves what happened; do not blindly repeat it.

## 11. Custom Yoast SEO Premium write integration

Yoast's standard REST API is **read-only** and does not support POST/PUT updates. Its head output can help verify rendered titles/descriptions, but it is not the product-field writer. See [Yoast REST API documentation](https://developer.yoast.com/customization/apis/rest-api/).

Build a narrow server-side Yoast adapter inside the BHcrafts plugin:

1. Detect and record the installed WordPress, WooCommerce, Yoast SEO, and Yoast Premium versions.
2. Inspect the installed Premium field registration and save behavior on staging. Do not guess the current representation of related keyphrases or synonyms.
3. Map the neutral proposal fields—primary phrase, primary synonyms, four related phrase/synonym pairs, title, meta description—to the verified installed storage/API.
4. Prefer an appropriate supported programmatic interface where the installed version provides one. Otherwise isolate any necessary version-specific metadata handling behind a tested adapter.
5. Do not expose all protected Yoast metadata via unrestricted REST meta registration. Do not use an arbitrary meta_data payload as the write interface.
6. Preserve existing unrelated Yoast data. Handle encoding, Unicode, apostrophes, arrays/JSON/serialization, empty values, and field deletion explicitly. Do not double-encode Premium values.
7. Use the normal supported save/indexation lifecycle established for the installed version. Verify stored values, the Yoast editor UI, and actual frontend output.
8. If the compatibility contract cannot be established, disable Yoast writes and report the unsupported version. Do not silently fall back to title/description-only optimization.

The exact internal meta keys and Premium JSON layout are implementation details to verify on staging, not a stable public API contract promised by this brief.

Acceptance requires the primary keyphrase and synonyms plus all four related keyphrases and their synonyms to appear correctly in Yoast Premium, survive reload and a later normal editor save, and round-trip through the adapter without loss.

Do not set SEO/readability scores to a fabricated passing value. A write/read-back success does not prove that browser-based Yoast analysis has rerun. Record genuine analysis results when available; never promise all indicators will become green.

## 12. Codex plugin build strategy

Build a dedicated, versioned BHcrafts plugin rather than a loose set of live Code Snippets or parent-theme edits. Suggested working name: **BHcrafts SEO Work Bridge**.

Keep the project brief and approved content workflow in Work Cloud. Use Codex for source development and tests if available; creating another Codex chat/repository or connecting a new service is a later concrete step, not something this brief claims has happened.

### Components

- Environment/capability detection and read-only discovery.
- Product selection and snapshot service.
- Preserved-content registry and safe HTML/Flatsome handling.
- Proposal validation, complete before/after previews, and immutable field enforcement.
- Human approval binding, conflict detection, and scoped apply operations.
- WordPress/WooCommerce content writer and version-aware Yoast Premium adapter.
- Shared-attachment metadata guard and reference graph.
- Per-field snapshots, append-only change history, and rollback service.
- Read-only media scanner with scope/coverage reporting.
- Small background jobs with status, cancellation between records, idempotency, and resume support.

### Build outputs

- Source in the user-approved repository https://github.com/mirzabole-lgtm/bhcrafts-seo, with no secrets or private customer/order exports.
- Installable versioned ZIP and checksums.
- Documented setup, capabilities, API/tool schemas, staging/live separation, failure behavior, and rollback.
- Meaningful automated tests for authorization, allowlists, stale proposals, encoding, Yoast field round-trip, shared-image conflicts, retries, partial failures, and rollback.
- A staging acceptance report and a small approved example content pack.

Use WordPress hooks and WooCommerce data APIs appropriately. Do not replace Flatsome templates or edit WordPress/WooCommerce/Yoast vendor code. Avoid unrelated dependency, theme, or plugin upgrades.

Deactivation must stop new jobs and writes without erasing content, backups, or audit records. Uninstall must not silently delete project history or product/media data.

## 13. Kinsta staging, deployment, and rollback

The user designated https://stg-bhcraftsshop-affiliate.kinsta.cloud/ as the Kinsta staging environment on 10 November 2026. Background public GET requests verified its Home/Site URLs, HTTP 200 responses, and noindex directives. Authenticated access, freshness, outbound-integration isolation, and backup status remain to be confirmed. The public API reports 378 storefront products and 2,439 media records; these counts do not establish a full authenticated inventory or the clone date.

The user supplied the diagnostics plugin's administrator-exported JSON on 10 November 2026. Its generation time is 14:15:50 UTC / 15:15:50 Europe/Sarajevo. It reports WordPress 7.1.4, PHP 8.3.36, WooCommerce 11.2.2, Yoast SEO 28.8, Yoast SEO Premium 28.8, and Flatsome 3.20.11. WooCommerce and both Yoast plugins report active. It identifies a single-site staging environment, matching Home/Site URLs, blog_public="0", and Application Password availability. These are administrator-exported findings, not results of an authenticated cloud API session. The pasted report is retained as BHcrafts_Staging_Diagnostics_2026-11-10.json.

### Staging preparation

- Confirm the environment and take a recoverable backup before testing.
- Use a current-enough copy to exercise representative product content, Flatsome markup, galleries, shared images, variations, and installed Yoast Premium behavior.
- Use separate test credentials. Keep staging isolated from real payment capture, customer emails, feeds, and other outbound production integrations.
- Keep staging out of search indexing and verify that any staging-only settings cannot be promoted to production accidentally.
- Record all relevant versions and environment differences.

Kinsta documents separate staging environments and backup facilities. See [Kinsta staging](https://kinsta.com/docs/wordpress-hosting/staging-environment/) and [Kinsta backups](https://kinsta.com/docs/wordpress-hosting/wordpress-backups-and-disaster-recovery/wordpress-backups/).

### Required staging checks

- A dry run makes no product or attachment changes.
- Unauthenticated callers, insufficient roles, unknown fields, unapproved proposals, and wrong-environment approvals are rejected.
- Each selection mode resolves complete, deduplicated, frozen manifests.
- The artisan master paragraph, hang-tag asset, relevant links, shortcode/block structure, and responsive layout survive.
- Long/short descriptions display correctly on desktop and mobile without duplicate H1s or broken UX Builder content.
- All five Yoast phrase/synonym entries and title/meta description round-trip and survive a normal editor save.
- Every selected gallery image has a metadata proposal or an explicit unresolved status.
- Shared attachments update only once with explicit approval, or are held for conflict review.
- Captions are populated while Flatsome's existing display behavior is retained.
- Prices, SKU, image assignments/binaries, stock configuration, variations, and other protected fields are untouched by the writer.
- Partial failures, network timeouts, retries, interrupted jobs, concurrent edits, and rollback behave safely.
- Product gallery, lightbox, variation selection, add-to-cart, cart, and checkout pass an appropriate smoke check. Use test transactions only where needed; do not place a real paid order.

### Production deployment

Deploy only the tested plugin files and exact approved content changes. **Do not push the entire staging database to the live shop** to publish SEO work: that could overwrite newer orders, inventory, settings, or other edits.

Before the live pilot, record the tested plugin version, explicit production approval, fresh backup reference, exact product/attachment proposal, and baseline values. Verify the connection domain and read-only/write mode.

Use a small pilot, verify it, then expand through separately approved bounded batches. Clear only necessary relevant caches after approved writes when required for verification. Do not redesign caching or optimization settings.

### Rollback

Maintain a before-value snapshot for each changed field, including whether a Yoast field was originally absent rather than merely empty. Store attachment snapshots separately because shared media affects multiple pages.

Provide two levels:

1. **Field-level rollback:** show the rollback diff; restore only the fields changed by the job. Restore automatically as compensation for a failed job only when that behavior was included in the approved operation and the current value still matches the job's written value. Otherwise require review.
2. **Disaster recovery:** retain a Kinsta backup reference and tested recovery procedure. A full production restore can discard newer commerce activity and requires a separately considered recovery decision.

Do not roll back prices, stock, orders, customer data, image assignments, or unrelated metadata from an SEO snapshot. A legitimate sale after a content update must remain intact.

## 14. Read-only unused-media audit

### Governing rule

**No detected reference is not proof that an image is safe to delete. "Unattached" is not a usage verdict.** Keep the audit separate from product optimization and from any future deletion workflow.

The initial integration must offer no automatic delete, trash, detach, rename, move, thumbnail cleanup, or WebP cleanup action.

### Mandatory scan scope

| Source | References to inspect |
| --- | --- |
| WooCommerce products | Featured images, gallery IDs/order, long/short descriptions, custom tabs/fields, and metadata storing image IDs or URLs. |
| Product variations | Variation image IDs, parent relationships, variation descriptions, and relevant extension fields. |
| Categories and other product taxonomies | Category thumbnails and relevant term metadata. |
| WordPress posts and pages | Featured images, HTML img/src/srcset, links, galleries, captions, blocks, shortcodes, and CSS/background URLs. |
| Flatsome UX Builder | Image/banner/slider/background shortcode attributes; embedded IDs/URLs; nested UX Block references; builder-specific metadata. |
| UX Blocks and reusable content | Flatsome blocks post type, WordPress reusable/synced blocks, templates, template parts, and registered custom content types that may contain media. |
| Site appearance/settings | Site logo, site icon, headers, footers, widgets, theme mods/options, menus where relevant, background images, sliders, and selected plugin settings. |
| Custom fields and plugin data | Serialized arrays, JSON values, known media fields, custom option tables, custom tables when applicable, and supported plugin integrations. |
| Frontend output | Crawl representative published pages and dynamic views to supplement stored-reference analysis; record URLs and actual image references. |
| Files and derived assets | Read-only file inventory where authorized; map originals, scaled files, thumbnails, srcset sizes, ShortPixel/WebP/AVIF variants, and CDN/cache URL forms back to attachments. |

Audit all relevant statuses, including drafts, private/scheduled content, trash, and revisions, with clear labels. Such references can preserve future or recoverable content even if they are not on a published page.

A public REST crawl alone cannot prove complete coverage of options, protected metadata, custom tables, or filesystem files. The authenticated server-side scanner must report which sources it could and could not inspect.

### Detection rules

- Build a directed reference graph linking attachment/file → storage location or referring object → published/root context where known.
- Recursively follow UX Block/reusable block/template references with cycle protection.
- Preserve references found inside currently unreferenced reusable content and report their context separately.
- Parse structured IDs and URLs rather than treating every matching integer as an attachment reference.
- Normalize approved local/CDN URL variants, URL encoding, relative paths, srcset, CSS URLs, and generated-size filenames without conflating different attachments.
- Use safe deserialization/JSON parsing and known field adapters. Do not execute stored content or arbitrary shortcodes merely to scan them.
- Supplement with a bounded frontend crawl, including dynamic product/variation displays where feasible.
- Record unknown formats, inaccessible data sources, external sites, email campaigns, downloadable catalogs, social posts, and other off-site use as coverage limitations.
- Re-scan close to any later cleanup review; the site's usage can change after the report.

### Report classifications

| Status | Meaning | Default recommendation |
| --- | --- | --- |
| In Use | A concrete reference was detected in content, media assignments, reusable content, or settings. | Keep; show evidence. |
| Possibly Unused | Usage is ambiguous, a source could not be scanned, or a potential/dynamic/external reference needs review. | Hold and inspect manually. |
| No Reference Found | No reference was detected within the documented completed scan scope. | Candidate for human review only; never an automatic deletion instruction. |

For each attachment include thumbnail/preview, attachment ID, filename, URL/path, MIME type, upload date, original byte size, derived-file footprint when measurable, parent association, detected references, source object IDs/URLs, evidence location/type, confidence, scan timestamp, coverage gaps, and recommended action.

List **duplicate candidates**, **orphan files with no attachment record**, **generated thumbnails**, and **optimized WebP/AVIF derivatives** in separate sections. A duplicate-looking image can still be used; a generated image variant can be essential to an in-use original. Do not add their sizes together as reclaimable storage without verification.

If cleanup is considered later, prepare a named candidate list, fresh usage check, backup/recovery plan, and separate explicit approval. This brief authorizes the report, not deletion.

## 15. Data artifacts and verification records

Keep the following cloud-accessible and versioned:

| Artifact | Purpose |
| --- | --- |
| This Markdown brief | Governing requirements, decisions, source transcription, phases, and open dependencies. |
| Environment / capability report | Exact domains, versions, supported fields, authentication method, and access limits; no secrets. |
| Product manifest | Frozen selection, IDs, names, status/type, selection rule, and exclusions. |
| Product/attachment baseline | Original allowed-field values, protected-field checksums, source timestamps, and raw markup. |
| Preserved-content registry | Artisan block, hang-tag attachment identity, original layout, and preservation checks. |
| SEO/content proposals | Complete copy, five phrase/synonym entries, SEO title/meta description, and per-image metadata. |
| Approval register | Human approval evidence tied to exact environment, IDs, fields, version/hash, and shared effects. |
| Apply/verification log | Actual changed fields, statuses, read-back results, failures, retries, and resume cursor. |
| Rollback snapshots | Field-level prior values, absent-versus-empty state, and corresponding job/proposal references. |
| Media audit report | Usage graph/evidence, classifications, file groupings, scan coverage, and review candidates. |

Use UTF-8, preserve Unicode and intentional paragraph breaks, and avoid placing secrets or customer/order data in exported reports. If CSV is used for review, protect against spreadsheet formula interpretation. Durable job state must live server-side or in an approved cloud store, not solely in a chat's memory.

## 16. Completion criteria and outstanding dependencies

### Brief / cloud handoff

- [x] This exact named Markdown file is saved and downloadable in ChatGPT Work Cloud.
- [x] User-supplied screenshot text and layout rules are transcribed above.
- [x] Caption clarification, shared-image safeguards, immutable fields, approval requirements, and no-delete rule are recorded.
- [x] Clear build, staging, approval, rollout, and audit phases are defined.
- [x] No live product, attachment metadata, settings, or media cleanup changes are authorized by creating this brief.
- [x] Background/cloud-only preference is recorded; no further local desktop control is permitted.

### Cloud status — 10 November 2026

Created and verified this UTF-8 Markdown file in ChatGPT Work Cloud. Verification confirmed a nonempty file, all 17 required sections, the supplied screenshot transcription, constraints, and official source links. This status records file creation and verification only.

### Staging discovery status — 10 November 2026

The supplied staging URL has been verified through public read-only requests. Its administrative product API returns HTTP 401 without credentials. No authenticated cloud connection or cloud-executed product/attachment write has occurred. The user has since run the diagnostics plugin, as recorded below; the cloud task did not install or activate it.

A staging-host-restricted diagnostics package, BHcrafts_SEO_Staging_Diagnostics_0.1.0.zip, was prepared in Work Cloud. It provides an administrator-only manual JSON export of selected environment versions and access-availability flags. PHP syntax checks, 27 isolated policy checks, and an authorized JSON-export fixture passed. The user subsequently supplied administrator-generated output from staging, evidencing execution of the diagnostics plugin there. The package includes a read-only staging check report and source. It does not implement the SEO content writer or verify Yoast Premium field storage.

The received diagnostics explicitly left raw product reads, visual image inspection, Yoast Premium storage compatibility, a write adapter, outbound-integration isolation, and backup verification uncompleted. No authenticated cloud WordPress connection has been established. The user subsequently selected a staging product for read-only inspection, as recorded below. This selection does not authorize publishing.

### First product inspection and draft — 10 November 2026

The user selected https://stg-bhcraftsshop-affiliate.kinsta.cloud/product/knit-handbag-with-dolls-applique/. It resolves to variable product 2839, Knitted Bag with Three-Doll Applique, in category 41. The public rendered variation data exposes variation 2840 with image 2841 and an empty Color attribute value. Black and Green are visible options. No variation configuration changes are proposed.

The frozen staging inspection manifest records parent image order 2841, 2843, 2844, 2842, 2845, 445, 357 and embedded artisan attachment 577. All eight unique images were downloaded and visually inspected without editing. A read-only pass across 378 public staging products detected attachment 445 in 234 product image arrays, attachment 357 in 231, and the artisan-tag URL in 367 descriptions. Full authenticated sitewide and variation coverage remains pending.

The current artisan paragraph differs from the screenshot master. The description also contains the literal escaped fragment <style=”padding-left: 120px”>. Both are shown explicitly in the inspection report. The draft proposes the master paragraph, fragment removal, a descriptive embedded-tag alt attribute, and product-specific closing/care copy while retaining the existing tag asset and its placement. None of these changes has been applied.

Draft bhcrafts-stg-2839-draft-v0.1 includes complete long and short descriptions, a primary keyphrase with synonyms, four related phrases with individual synonyms, SEO title/meta description, and all four metadata proposals for all eight attachments. The report is BHcrafts_Product_2839_Inspection_and_Draft.md. The durable evidence/content pack is BHcrafts_Product_2839_Review_Pack_v0.1.zip, containing a machine-readable review, selection manifest, before/proposed HTML, image references, source photographs and checksums.

This draft is not approval-eligible for application. Saved raw product/media fields and saved Yoast values remain unavailable. The Yoast head API returned HTTP 404 for this staging product while its HTML returned HTTP 200; no reindexing or settings changes were attempted. Before writes, verify the installed Yoast Premium representation, current raw baselines, full shared-image effects, protected fields, exact approved proposal and rollback. The dated certificate link, gift-wrapping policy and dimension interpretation are also flagged for review. No staging or live product/attachment writes occurred.

### Read-only product export prepared — 10 November 2026

The user instructed continuation after the product 2839 inspection. BHcrafts_SEO_Staging_Diagnostics_0.2.0.zip updates the existing diagnostics plugin, keeping the same folder/basename and Tools page. It adds a fixed-scope administrator export, Download product 2839 snapshot, producing BHcrafts_Product_2839_ReadOnly_Snapshot.json. This update has been built in Work Cloud but not installed by the cloud task.

The export restricts Home/Site URLs to the designated staging host, validates product ID 2839 and its expected slug/type, checks administrator and object permissions, requires a separate POST nonce, rejects unexpected form/query inputs, and bounds variations, attachments and payload sizes. It reads saved product/attachment text, variation/image relationships, selected protected-field hashes, artisan evidence and selected installed Yoast registry/metadata evidence. It preserves Unicode, absent-versus-empty fields, duplicate metadata rows and native JSON strings. No arbitrary ID/key/URL input, content writer, public REST endpoint, remote HTTP request, activation job or deletion function is present.

The five Yoast value-read aliases are inspection candidates, not a promised Premium storage contract. Unknown installed field names are listed without their values for further adapter review. Scores, canonical/social/robots values, credentials, orders, customers and unrelated metadata values are excluded. Normal WordPress metadata API type conversion is identified explicitly; the export does not claim raw database-byte capture. A manual snapshot does not establish a cloud API connection or complete sitewide media usage coverage.

All three PHP files passed PHP 8.4.27 syntax checks. Sixty-one isolated policy/value checks and an authorized UTF-8 JSON download fixture passed. Real execution on the staging PHP 8.3.36 runtime, installed Premium field interpretation, normal editor-save/indexation behavior and future write compatibility remain pending. The ZIP contains source, CLI-only tests, setup instructions, validation notes and checksums. The next required action is for a staging administrator to replace diagnostics 0.1.0 with this update, download the product snapshot, and attach that JSON here without entering credentials in chat.

### GitHub handoff and form fix — 10 November 2026

The user selected https://github.com/mirzabole-lgtm/bhcrafts-seo for plugin source and all SEO project documents and briefs. The repository contains the current source, tests, versioned release ZIPs, discovery report, administrator environment report, product 2839 inspection/draft, machine-readable review, selection manifest, before/proposed HTML and complete review archive. The README indexes these artifacts. Unrelated BHcrafts projects, scratch dependencies and private account/credential data are outside this handoff.

The user reported “Unexpected form field. Product scope is fixed.” in diagnostics 0.2.0. The cause was omission of WordPress submit_button()’s standard submit field from the request allowlist. Corrected release 0.2.1 allows this single additional standard field and rejects non-string values. Product, environment, nonce, unknown-field and query restrictions remain in force. The regression uses the complete standard form payload and produces valid product JSON. Sixty-two isolated checks and all PHP syntax checks pass. Real execution of this corrected version on staging remains pending.

Use releases/BHcrafts_SEO_Staging_Diagnostics_0.2.1.zip to replace the existing diagnostics plugin on staging, then download the product 2839 snapshot. Older ZIPs remain historical artifacts. The GitHub handoff does not install the update, establish authenticated cloud access, verify Yoast write compatibility, or approve content/metadata changes. The user also asked about another PC; continuing requires the same ChatGPT account and workspace, without moving to another chat.

### Saved product baseline received — 10 November 2026

The user attached a successful diagnostics 0.2.1 snapshot, generated at 19:05:23 UTC / 20:05:23 Europe/Sarajevo, from staging PHP 8.3.36. The original file bytes are preserved in docs/product-2839/baseline/BHcrafts_Product_2839_ReadOnly_Snapshot_2026-11-10.json. Its overall checksum, raw-content checksum, all eight attachment baselines and all five selected Yoast metadata checksums verify. These are internal-consistency checks, not a digital signature or an authenticated cloud session.

The actual saved primary keyphrase, SEO title and meta-description keys are absent. The Premium candidate keys _yoast_wpseo_keywordsynonyms and _yoast_wpseo_focuskeywords each exist as one empty string. No nonempty related-keyphrase representation is established by this record. The actual WPSEO_Meta registry exposes the three base content fields but not these Premium candidates through that registry.

Raw descriptions preserve CRLF and the exact escaped malformed fragment. A new preservation_registry_v0.2.json retains the original artisan block and tag markup. Draft review_v0.2.json now includes actual saved before-values and keeps all writes held. It preserves the raw tag image element’s attributes except for the explicitly proposed alt replacement. The master-paragraph replacement and other description changes remain visibly proposed.

Variation 2840 has own image ID 0. Earlier frontend image 2841 was inherited from the parent. Future writes must preserve this inheritance and must not assign 2841 to the variation. Parent image order and eight expected attachments match the inspection manifest.

Diagnostics 0.3.0 adds actual WordPress post-meta registration descriptors and structure-only samples for the two fixed Premium candidates from at most five published product candidates per key. It rechecks object permissions and publication status, omits phrase/synonym text and numeric scores, masks unknown field-name text, and leaves source IDs outside the edit manifest. It adds no writer or public endpoint. Invalid UTF-8 is rejected explicitly before JSON sanitization. Four PHP syntax checks, 76 isolated checks and an authorized standard-form export fixture pass. New 0.3.0 execution and normal editor-save/write compatibility remain unverified.

On 11 November 2026, the user selected Christmas Stocking Personalized as a populated Yoast reference. The staging Store API confirmed product 616. Diagnostics 0.3.1 reads the structure of its five saved Yoast fields and covers up to four related entries. Install the 0.3.1 ZIP on staging and use the same product 2839 snapshot button. The received 0.3.1 export verifies the target baseline and confirms four related-keyphrase objects with keyword and score fields. It also shows a separate five-entry synonym array. The reference export masks phrase values and shows four of the five synonym element types, so slot order requires the prepared product 2839 editor test. See docs/product-2839/yoast_editor_test_v0.1.md.

The next product 2839 export verified the first manual editor save. The title, meta description and all five keyphrases match. The first synonym slot repeats the value in the second slot. The remaining four slots match their proposed positions. The raw descriptions, recorded protected-field hashes, variation, image records and artisan checks match the pre-test export. The [editor test result](docs/product-2839/yoast_editor_test_v0.1.md#first-editor-save-result) records the exact saved values and the primary synonym check. Adapter writes, frontend verification and rollback still need staging tests.

The [corrected editor export](docs/product-2839/yoast_editor_test_v0.1.md#corrected-editor-save) confirms five distinct synonym slots in Yoast Premium 28.8, with the primary pair first and the four related pairs in phrase order. The primary pair contains one extra trailing comma, which remains in the exact stored evidence. The title, meta description and all five keyphrases still match the proposal. The raw descriptions, variation, attachment records and recorded protected fields still match the baseline.

[Work Bridge 0.1.0](plugin/bhcrafts-seo-work-bridge/README.md) packages the first Yoast staging write test for product 2839. The fixed proposal removes one trailing comma from the primary synonym slot. An authorized staging administrator reviews the exact diff and approves apply and rollback separately. The 39 isolated fixture checks passed. On 11 November 2026 at 08:50:47 Europe/Sarajevo, the supplied apply receipt reports exact read-back of the proposed synonym value and verifies all five Yoast rows. The [independent post-apply export](docs/product-2839/baseline/BHcrafts_Product_2839_Yoast_Post_Apply_2026-11-11.json) at 09:31:21 confirms the exact proposal and shows no changes to the captured product, variation, attachment and artisan records. The [post-resave export](docs/product-2839/baseline/BHcrafts_Product_2839_Yoast_Post_Resave_2026-11-11.json) at 10:10:21 confirms all five Yoast rows survived the normal editor save. The product modification time advanced while the other captured product fields, variation, attachments and artisan checks still match. The [post-rollback export](docs/product-2839/baseline/BHcrafts_Product_2839_Yoast_Post_Rollback_2026-11-11.json) at 10:15:29 verifies restoration of the exact original synonym string. All five Yoast rows again match the corrected pre-apply export. The captured non-Yoast records match the post-resave export.

The [storefront check](docs/STATUS.md#current-result) confirms `noindex, nofollow` in the administrator-supplied page source. The original rendered title and meta description differed from the saved Yoast values. The administrator confirmed the single-URL Yoast license covers `bhcrafts.shop`, consistent with the staging subscription notices. Keep the license on the live domain. The administrator's Yoast head response returned status 404 and an error-page title for the product URL. The [read-only indexable report](docs/product-2839/baseline/BHcrafts_Yoast_Indexable_2839.json) found one row with the current staging permalink, the hash for the equivalent live URL and null title and description. [Work Bridge 0.1.2](plugin/bhcrafts-seo-work-bridge/README.md#repair-the-staging-indexable) packages the three-field repair and its separately approved rollback. The 86 fixture checks passed. On 11 November 2026 at 12:19:41 Europe/Sarajevo, the administrator's repair receipt confirmed exact read-back for the one affected row. Independent checks returned HTTP 200 from Yoast and the staging storefront, with the exact approved title and meta description and staging `noindex` intact. The [authenticated post-repair product snapshot](docs/product-2839/baseline/BHcrafts_Product_2839_Yoast_Post_Repair_2026-11-11.json) confirms the captured product, variation, image, artisan and saved Yoast records match the pre-repair baseline. Use this evidence for the [draft staging title and description test](docs/STATUS.md#draft-staging-title-and-description-test).

The [Work Bridge 0.1.3 title and description test](docs/STATUS.md#draft-staging-title-and-description-test) ran on staging product 2839 on 11 November 2026 at 12:47:43 Europe/Sarajevo. The supplied receipt and independent Yoast head and storefront checks confirm the two saved values and rendered metadata match the proposal. Staging `noindex` remains active. All 23 compared public product fields match the post-repair public capture. The authenticated protected-field comparison, normal editor resave and separate rollback remain pending for this test.

### Before integration testing or live optimization

- [x] Confirm the actual Kinsta staging URL through public read-only checks: https://stg-bhcraftsshop-affiliate.kinsta.cloud/.
- [x] Obtain the administrator-exported staging diagnostics report and record its reported versions and environment identity.
- [ ] Establish authenticated read-only staging access from Work Cloud; the manual report does not establish this connection.
- [x] Record current staging WordPress/WooCommerce/Flatsome/Yoast SEO and Premium versions from the supplied administrator report.
- [x] Receive and validate the fixed-scope product 2839 raw snapshot; inspect saved markup, all eight attachment records and current installed Yoast evidence.
- [x] Obtain nonempty Premium structural evidence from selected reference 616 using diagnostics 0.3.1.
- [ ] Verify Yoast Premium 28.8 storage format, compatible write behavior, save lifecycle, and all five phrase/synonym round-trips on staging.
- [ ] Establish a secure cloud-compatible connection with separate staging/live credentials.
- [ ] Identify the existing hang-tag attachment(s), preserved blocks, and any existing product-specific deviations.
- [x] Freeze the first staging inspection/drafting manifest for product 2839, observed variation 2840 and the eight listed attachments. This is not production selection or publishing approval.
- [ ] Confirm the separate production pilot target and freeze its live manifest before preparing a production approval pack.
- [ ] Build the narrow integration and prove its security, field restrictions, Yoast round-trip, shared-media handling, and rollback on staging.
- [ ] Produce complete content proposals for review.
- [ ] Obtain explicit approval of the exact production pilot before any live changes.
- [ ] Verify pilot results before expanding.
- [ ] Complete the read-only media audit with transparent coverage; perform no deletion.

These are operational dependencies, not reasons to stop useful brief writing, local-to-cloud text transfer, source development preparation, or independent read-only planning.

## 17. Work Cloud continuation instruction

Use this file as the project specification. Begin with background read-only discovery where approved access exists and prepare a concrete integration plan. Keep the user in Work Cloud for review and decisions.

Preserve the screenshot-derived artisan master paragraph and hang-tag presentation. Adapt product-specific wording only in visible proposals. Prepare all required descriptions, five keyphrase/synonym entries, SEO fields, and per-image metadata. Do not modify live products or attachments until the exact changes are explicitly approved. Keep media auditing read-only and never delete automatically.

If a cloud connection, source asset, product selection, or staging detail is missing, state the precise dependency and continue work that does not depend on it. Do not use the user's PC or interactive local browser as a fallback.
