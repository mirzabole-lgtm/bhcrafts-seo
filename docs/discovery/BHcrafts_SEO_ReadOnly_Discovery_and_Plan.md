# BHcrafts SEO Work Bridge: Read-only discovery and implementation plan

Checked: 10 November 2026, 14:54 CET
Site: https://bhcrafts.shop/
Governing specification: BHcrafts_WooCommerce_SEO_Work_Brief.md, saved version 1.
Status: Public discovery completed. Authenticated discovery and staging validation remain open.

## 1. Results and immediate decisions

The live site answered background HTTPS GET requests. No desktop, browser control, login, product write, metadata write, installation, setting change, or media deletion formed part of this work. The checks used no WordPress credentials.

| Observation | Result | Meaning |
| --- | --- | --- |
| Public storefront product count | 382 | Four pages retrieved in ascending ID order, with 100 / 100 / 100 / 82 records. IDs are unique. This is a public inventory snapshot, not an approved content batch. |
| Product types | 229 simple, 152 variable, 1 pw-gift-card | Include variation coverage and explicitly exclude or separately design gift-card content handling for the pilot. |
| Public category records returned | 33 | Includes parent relationships. Category counts overlap and must not be summed as a unique product total. |
| Public media collection count | 2503 | Count from the response header. One record was sampled. The full Media Library was not downloaded. |
| Unique image IDs in public product image arrays | 1699 | Featured/gallery ordering is represented by the response arrays. Confirm exact roles through authenticated product records. |
| Image IDs shared across multiple public products | 166 | Two attachments each appear in 234 product image arrays. Shared metadata needs separate review. |
| Products exposing the artisan heading | 329 | The normalized rendered description contains “MORE INFORMATION ABOUT ARTISANS”. |
| Products containing the supplied master paragraph | 6 | Exact phrase comparison after removing HTML, decoding entities, and normalizing whitespace. This does not prove identical saved markup. |
| Artisan heading present, master text absent | 323 | Preserve the existing block and show its difference before proposing replacement. |
| Products without the detected artisan heading | 53 | Review manually. The phrase detector does not establish whether another artisan section exists. |
| Products with empty public image arrays | 2 | Two custom-order products. Do not assign arbitrary replacement images. |

Public Store API results are customer-facing data. They are not the authoritative complete list of all published, hidden, private, draft, or variation records. A later authenticated selection must resolve and freeze its own IDs.

## 2. Access and environment findings

| Check | Observed result | Remaining dependency |
| --- | --- | --- |
| Homepage | HTTP 200 | No authenticated access established. |
| REST index | HTTP 200, site URL https://bhcrafts.shop | Record and compare the designated staging identity separately. |
| Advertised namespaces | wp/v2, wc/v3, wc/store/v1, yoast/v1 | Registration alone does not verify authenticated access or write compatibility. |
| Application Passwords | Authorization endpoint advertised by the REST index | Requires a dedicated account, appropriate permissions, secure credential storage, and a successful authenticated request. No credentials were created or used. |
| Administrative product endpoint | HTTP 401, woocommerce_rest_cannot_view, when called without credentials | Expected authentication boundary. Do not treat it as a site fault. |
| Custom BHcrafts namespace | None containing “bhcrafts” appeared in the REST index | The proposed bridge is not evidenced as installed. Another plugin under an unrelated namespace was not ruled out. |
| WordPress connector search | A general WordPress connector was listed, uninstalled | Its listing does not establish WooCommerce raw-field access, media support, Premium field writes, or approval enforcement. No installation or connection was attempted. |
| Flatsome public asset hint | Several chunk URLs contain ver=3.20.11 | Asset hint only. Confirm the installed theme version through authenticated discovery. |
| WordPress, WooCommerce, Yoast SEO and Premium versions | Not verified | Capture exact installed versions on staging. Do not use remembered versions as current evidence. |
| Kinsta staging URL, freshness and backup | Not supplied or verified | The user needs to provide the staging URL. Do not derive a hostname from the live domain. |

There is no verified authenticated WordPress connection among the tools available to this task. Public background access works. No secure WordPress secret-entry connection was established, and no plain-text credential exchange is requested.

## 3. Preservation findings

This pass compared rendered descriptions only. It did not inspect editor raw content, execute shortcodes, verify responsive layout, inspect individual photographs, or identify the definitive hang-tag attachment.

The six normalized descriptions containing the supplied master paragraph belong to product IDs 806, 832, 9269, 10112, 10130, 10132. These are observations, not a pilot selection or publishing authorization.

The large number of other artisan sections makes preservation-first handling necessary. A shared paragraph must not be replaced across the catalog merely because it differs from the screenshot master. The staging reader should capture exact saved HTML/shortcodes, isolate the existing artisan block and tag image, hash the preserved block, and produce a side-by-side difference against the supplied master.

For an unparseable section, return a review issue and stop the affected proposal. For a missing section, propose the verified hang-tag block separately. Do not use a gallery image ID as proof of hang-tag identity.

Two products returned no public gallery images: IDs 9515 and 9844. Their IDs remain inventory observations. Any future content selection should handle them explicitly.

No visible image descriptions, alt text, captions, or image titles were drafted in this pass. Image inspection remains required before drafting metadata.

## 4. Field map for the bridge

This is a proposed neutral contract. It does not assert the presence of custom endpoints or verified Yoast internal keys.

| Neutral field | Read source | Approved write path | Verification |
| --- | --- | --- | --- |
| product.long_description | Authenticated WooCommerce description plus raw WordPress post content where needed | Content adapter, description only | Raw read-back, preserved-block hash, rendered product view |
| product.short_description | Authenticated WooCommerce short_description | Content adapter, short_description only | Exact stored value and product summary view |
| seo.primary.phrase | Installed Yoast Premium adapter | Version-verified Yoast adapter | Stored value, editor reload, later normal save |
| seo.primary.synonyms | Installed Yoast Premium adapter | Same adapter | Unicode/encoding round-trip and editor reload |
| seo.related[0..3].phrase | Installed Yoast Premium adapter | Same adapter, exactly four entries | All entries survive reload and normal editor save |
| seo.related[0..3].synonyms | Installed Yoast Premium adapter | Same adapter, one synonym list per entry | No lost entries or double encoding |
| seo.title | Installed Yoast adapter | Same adapter | Stored value and rendered SEO title |
| seo.meta_description | Installed Yoast adapter | Same adapter | Stored value and actual head output |
| attachment.alt_text | WordPress media API, authorized edit context | Attachment metadata adapter | Exact stored value and relevant rendered alt attributes |
| attachment.title | WordPress media title.raw in authorized edit context | Same adapter | Raw read-back, attachment ID unchanged |
| attachment.caption | WordPress media caption.raw in authorized edit context | Same adapter | Read-back, gallery/lightbox behavior retained |
| attachment.description | WordPress media description.raw in authorized edit context | Same adapter | Raw read-back and shared-reference review |

Yoast documents its standard REST API as read-only. Its head endpoint supports output verification, not Premium field updates. WordPress documents all four media metadata fields. WooCommerce documents the two description fields. The primary and four related phrase/synonym pairs still require inspection of the installed Premium version.

## 5. Concrete implementation order

1. Establish staging identity and authenticated read-only access. Record actual versions, site/environment fingerprint, supported content types, dedicated integration identity, route permissions, and backup reference. Keep production write mode disabled.
2. Build the read-only plugin slice. Add environment/capability reporting, selection resolution, product/media snapshots, parent/variation mapping, and explicit scan-coverage reporting. Do not register apply operations yet.
3. Build the preservation registry and proposal validator. Capture exact raw content, tag references, attachment order and protected fields. Validate every nested field against a closed schema. Hold shared-image conflicts and unparseable descriptions.
4. Inspect Yoast Premium on staging. Establish its installed field format and save lifecycle. Test all five phrase/synonym entries and title/description round-trips. Leave the adapter disabled for unverified versions.
5. Add review and approval enforcement. Canonicalize the proposal, bind its hash to environment, object IDs, exact fields, baseline values and shared effects. Store the approval as a separate human-authorized event. The automation identity must lack permission to issue its own approval. If a trusted human-approval mechanism is unavailable, keep apply disabled.
6. Add bounded apply jobs and rollback. Start with one product per job and explicitly approved attachments. Re-read baseline fields, reject stale values, snapshot absent-versus-empty state, apply allowlisted setters, verify, and record per-field outcomes. Read unknown timeout outcomes before retrying. Compensation must respect the approved operation and concurrent edits.
7. Prove the plugin on staging. Reject wrong environments, missing approvals, altered proposals, unknown fields and insufficient permissions. Test shared images, varied artisan markup, Premium encoding, interrupted jobs and field rollback. Compare protected fields without restoring old commercial data.
8. Prepare the first content pack after the user supplies product IDs or category scope. Show complete before/after copy, five phrase/synonym entries, SEO fields and visually reviewed image metadata. Do not promote this public inventory into an approved batch.

Suggested source layout:

```text
bhcrafts-seo-work-bridge/
  bhcrafts-seo-work-bridge.php
  src/Environment.php
  src/Rest/ReadController.php
  src/Selection/Resolver.php
  src/Snapshot/Service.php
  src/Preservation/Registry.php
  src/Proposal/Validator.php
  src/Approval/Service.php
  src/Adapter/WooContent.php
  src/Adapter/YoastPremium.php
  src/Adapter/AttachmentMetadata.php
  src/Media/ReferenceScanner.php
  src/Job/Runner.php
  src/Rollback/Service.php
  tests/
  docs/
```

This layout is a planning proposal. No source repository, plugin package, installation, or WordPress deployment was created in this pass.

## 6. Completion status and next input

Completed: live public connectivity check, REST registration check, anonymous administrative-access check, paginated public product inventory, public category inventory, gallery-reference comparison, rendered artisan-text comparison, and preliminary field/implementation map.

Still open: authenticated raw baselines, staging URL and access, exact installed versions, full variation mapping, complete sitewide image references, verified hang-tag identity, visual image review, Yoast storage compatibility, frozen optimization selection, secure credential setup, and trusted human approval registration.

The next required user input is the exact Kinsta staging URL. Passwords and API keys must stay out of the chat. After the URL is supplied, test its public identity and establish the available secure connection route before requesting any secret setup.

## 7. Evidence and official sources

Observed site endpoints, accessed with GET on the check date:

- https://bhcrafts.shop/
- https://bhcrafts.shop/wp-json/
- https://bhcrafts.shop/wp-json/wc/v3/products?per_page=1&_fields=id
- https://bhcrafts.shop/wp-json/wc/store/v1/products?per_page=1
- https://bhcrafts.shop/wp-json/wc/store/v1/products/categories?per_page=100
- https://bhcrafts.shop/wp-json/wp/v2/media?per_page=1&_fields=id,title,alt_text,caption,description,source_url,media_details

The complete public product inventory used the following query, for pages 1 through 4:

```text
https://bhcrafts.shop/wp-json/wc/store/v1/products?per_page=100&orderby=id&order=asc&page=PAGE&_fields=id,name,type,permalink,parent,categories,images,description,short_description
```

Official documentation checked during this pass:

- [WooCommerce Store API](https://developer.woocommerce.com/docs/apis/store-api/): customer-facing public API, separate from administrative product management.
- [WooCommerce product API](https://developer.woocommerce.com/docs/apis/rest-api/v3/products): product fields and administrative read/write surface.
- [WordPress media API](https://developer.wordpress.org/rest-api/reference/media/): title, alt text, caption and description.
- [WordPress Application Passwords](https://developer.wordpress.org/advanced-administration/security/application-passwords/): revocable credentials tied to a WordPress user.
- [Yoast REST API](https://developer.yoast.com/customization/apis/rest-api/): read-only output, with no POST/PUT update support.

## Appendix A. Public category inventory

These are category records returned by the storefront API. Descendant inclusion is not resolved for any optimization batch.

| ID | Name | Slug | Parent ID | Reported count |
| --- | --- | --- | --- | --- |
| 232 | Accessories | accessories | 0 | 5 |
| 455 | All Christmas Stockings | all-christmas-stockings | 47 | 77 |
| 241 | Autumn/Winter | headwear-winter | 129 | 25 |
| 242 | Autumn/Winter | shawls-and-scarfs-winter | 126 | 9 |
| 41 | Bags, Purses & Wallets | bags | 0 | 9 |
| 256 | Best sellers | best-sellers-christmas-stockings | 47 | 8 |
| 450 | Black & White | black-white | 47 | 4 |
| 255 | Bundles & Outlet | outlet_christmas-stockings | 47 | 22 |
| 15 | Custom orders | custom-orders | 0 | 1 |
| 88 | Footwear | footwear | 0 | 11 |
| 143 | Gift Card | gift-card | 0 | 1 |
| 94 | Gloves and Mittens | gloves-and-mittens | 0 | 14 |
| 129 | Headwear | headwear | 0 | 62 |
| 271 | Holiday decor & ornaments | holiday-decor-ornaments | 47 | 27 |
| 47 | Holiday Spirit :) | holiday-spirit | 0 | 106 |
| 135 | Jackets and Coats | jackets-and-coats | 0 | 3 |
| 454 | Kids | kids | 0 | 14 |
| 444 | Limited Edition | limited-edition | 47 | 6 |
| 254 | New arrivals | new-arrivals-christmas-stockings | 47 | 11 |
| 259 | New Spring Collection | new-spring-collection | 0 | 54 |
| 419 | Personalized | personalized-christmas-stockings | 47 | 22 |
| 237 | Pets | pets | 0 | 5 |
| 126 | Shawls, Scarfs and Collars | shawls-and-scarfs | 0 | 23 |
| 243 | Spring/Summer | shawls-and-scarfs-summer | 126 | 15 |
| 240 | Spring/Summer | headwear-summer | 129 | 38 |
| 258 | Stockings for pets | stockings-for-pets-christmas | 47 | 4 |
| 449 | Stripes & Colors | stripes-colors | 47 | 8 |
| 132 | Sweaters | sweaters | 0 | 1 |
| 257 | Timeless | timeless-christmas-stockings | 47 | 11 |
| 152 | Tops | tops | 0 | 9 |
| 23 | Toys | toys | 0 | 53 |
| 448 | Traditional | traditional-christmas-stockings | 47 | 20 |
| 453 | Wholesale | wholesale | 0 | 24 |

## Appendix B. Public product inventory

This inventory records only storefront discovery. It does not select products for editing. “Master match” means normalized rendered-text containment, not an approved raw-content preservation baseline. The image IDs retain response order, without asserting variation coverage.

| ID | Product | Type | Image IDs | Artisan heading | Master match |
| --- | --- | --- | --- | --- | --- |
| 59 | [Personalized Christmas Stocking with Gingerbread Man](https://bhcrafts.shop/product/personalized-christmas-stocking-with-gingerbread-man/) | simple | 60, 61, 62, 358, 446, 445 | No | No |
| 64 | [Personalized Christmas Stockings Rudolph Reindeer](https://bhcrafts.shop/product/personalized-christmas-stockings-rudolph-reindeer/) | simple | 65, 66, 358, 534, 446, 445 | No | No |
| 67 | [Crocheted Christmas Stockings Personalized](https://bhcrafts.shop/product/crocheted-christmas-stockings-personalized/) | variable | 68, 69, 358, 534, 446, 445 | No | No |
| 71 | [Personalized Christmas Stockings with Snowmen Applique](https://bhcrafts.shop/product/personalized-christmas-stockings-with-snowmen-applique/) | simple | 72, 73, 358, 445, 534, 446 | No | No |
| 80 | [Hand Knit Christmas Tree Skirt](https://bhcrafts.shop/product/hand-knit-christmas-tree-skirt/) | simple | 81, 83, 82, 84, 85, 86, 87, 88, 358, 445 | No | No |
| 89 | [Unique Hand Knit Christmas Advent Calendar](https://bhcrafts.shop/product/unique-hand-knit-christmas-advent-calendar/) | simple | 90, 91, 357, 445 | No | No |
| 593 | [Personalized Christmas Stockings for Dogs](https://bhcrafts.shop/product/personalized-christmas-stockings-for-dogs/) | variable | 594, 386, 387, 389, 3260, 3259, 3258, 3257, 358, 446, 534, 445 | No | No |
| 595 | [Personalized Christmas Stockings With Elf](https://bhcrafts.shop/product/personalized-christmas-stockings-with-elf/) | simple | 507, 508, 358, 446, 445 | No | No |
| 596 | [Striped Christmas Stockings](https://bhcrafts.shop/product/striped-christmas-stockings/) | simple | 8865, 8864, 8863, 8866, 358 | No | No |
| 604 | [Christmas Stockings Stripes & Hearts](https://bhcrafts.shop/product/christmas-stockings-stripes-hearts/) | simple | 8840, 8842, 8839, 8841, 358 | No | No |
| 609 | [Personalized Christmas Stocking Hand Knit](https://bhcrafts.shop/product/personalized-christmas-stocking-hand-knit/) | variable | 8857, 8855, 8856, 8858, 358, 446, 534 | No | No |
| 616 | [Christmas Stocking – Personalized](https://bhcrafts.shop/product/christmas-stocking-personalized/) | variable | 8833, 8832, 8834, 8835, 358, 446, 534 | No | No |
| 619 | [Personalized Christmas Stocking – Multicolor](https://bhcrafts.shop/product/personalized-christmas-stocking-multicolor/) | variable | 8824, 8825, 8826, 8827, 358, 446, 534 | No | No |
| 622 | [Personalized Christmas Stockings with Snowmen](https://bhcrafts.shop/product/personalized-christmas-stockings-snowmen/) | simple | 495, 625, 624, 623, 358, 446, 445 | No | No |
| 629 | [Personalized Christmas Stockings with Christmas Tree](https://bhcrafts.shop/product/personalized-christmas-stockings-christmas-tree/) | simple | 496, 627, 628, 358, 446, 445 | Yes | No |
| 630 | [Personalized Christmas Stockings with Snowball](https://bhcrafts.shop/product/personalized-christmas-stockings-snowball/) | simple | 631, 378, 380, 379, 376, 358, 446, 445 | Yes | No |
| 633 | [Christmas Stocking Traditional Pattern – Personalized](https://bhcrafts.shop/product/christmas-stocking-traditional-pattern-personalized/) | variable | 9138, 8851, 8852, 8854, 358, 534, 446 | Yes | No |
| 642 | [Jacquard Knit Holiday Stocking](https://bhcrafts.shop/product/jacquard-knit-holiday-stocking/) | simple | 8848, 8847, 8849, 8850, 358 | Yes | No |
| 643 | [Santa Claus Personalized Christmas Stocking](https://bhcrafts.shop/product/santa-claus-personalized-christmas-stocking/) | simple | 431, 430, 429, 432, 358, 446, 534, 445 | Yes | No |
| 645 | [Jacquard Knit Christmas Stocking – Red & White](https://bhcrafts.shop/product/jacquard-knit-christmas-stocking-red-white/) | simple | 8821, 8820, 8822, 8823, 358 | Yes | No |
| 646 | [Personalized Christmas Stockings Fishbone](https://bhcrafts.shop/product/personalized-christmas-stockings-fishbone/) | variable | 8810, 8809, 8808, 8811, 358, 446, 534 | Yes | No |
| 649 | [Personalized Christmas Stocking Red – Traditional Pattern](https://bhcrafts.shop/product/personalized-christmas-stocking-red/) | variable | 8812, 8813, 8814, 8815, 358, 534, 446 | Yes | No |
| 652 | [Personalized Christmas Stocking Traditional Pattern – Multicolor](https://bhcrafts.shop/product/personalized-christmas-stocking-traditional/) | variable | 8829, 8828, 8830, 8831, 8918, 358, 534, 446 | Yes | No |
| 655 | [Personalized Christmas Stocking with Village Holiday Scene](https://bhcrafts.shop/product/personalized-christmas-stocking-with-village-holiday-scene/) | variable | 428, 426, 427, 358, 534, 446, 445 | Yes | No |
| 658 | [Jacquard Hand Knit Christmas Stockings](https://bhcrafts.shop/product/jacquard-hand-knit-christmas-stockings/) | simple | 494, 358, 445 | No | No |
| 662 | [Personalized Green Christmas Stocking – Traditional Pattern](https://bhcrafts.shop/product/personalized-green-christmas-stocking-traditional-pattern/) | variable | 8861, 8859, 8860, 8862, 8919, 358, 534, 446 | Yes | No |
| 669 | [Fair Trade Crocheted Christmas Stocking – Green or Red](https://bhcrafts.shop/product/fair-trade-crocheted-christmas-stocking-green-or-red/) | simple | 506, 500, 499, 498, 497, 358, 445 | Yes | No |
| 714 | [Fair Trade Crochet Christmas Tree](https://bhcrafts.shop/product/fair-trade-crochet-christmas-tree/) | variable | 6156, 6161, 6164, 6163, 6162, 6160, 6159, 6158, 6157, 357, 445 | Yes | No |
| 791 | [Slipper Socks Made by Women Artisans](https://bhcrafts.shop/product/hand-knit-slipper-socks/) | variable | 762, 758, 761, 760, 357 | Yes | No |
| 806 | [Hand-knitted wool slippers](https://bhcrafts.shop/product/hand-knitted-wool-slippers/) | variable | 745, 746, 744, 742, 748, 357 | Yes | Yes |
| 819 | [Hand-knit wool slipper socks](https://bhcrafts.shop/product/hand-knit-wool-slipper-socks/) | variable | 753, 749, 757, 750, 357, 445 | Yes | No |
| 832 | [Slipper Socks Made by Women Artisans](https://bhcrafts.shop/product/slipper-socks-made-by-women-artisans/) | variable | 740, 733, 739, 735, 738, 357 | Yes | Yes |
| 845 | [Kids Slipper Socks and Baby Booties](https://bhcrafts.shop/product/slipper-socks-12/) | variable | 941, 944, 943, 942, 940, 357, 445 | Yes | No |
| 858 | [Slipper Socks – Short Black](https://bhcrafts.shop/product/slipper-socks-06/) | variable | 770, 774, 771, 775, 773, 772, 357, 445 | Yes | No |
| 868 | [Slipper Socks – White Mid-Length](https://bhcrafts.shop/product/slipper-socks-08/) | variable | 768, 764, 767, 766, 765, 769, 763, 357, 445 | Yes | No |
| 880 | [Slipper Socks – Long Black](https://bhcrafts.shop/product/slipper-socks-09/) | variable | 787, 790, 789, 788, 357, 445 | Yes | No |
| 885 | [Slipper Socks – Long Black](https://bhcrafts.shop/product/slipper-socks-10/) | variable | 731, 732, 730, 357, 445 | Yes | No |
| 890 | [Slipper Socks – Long Black](https://bhcrafts.shop/product/slipper-socks-11/) | variable | 727, 729, 728, 357, 445 | Yes | No |
| 945 | [Slipper Socks – Short Black](https://bhcrafts.shop/product/slipper-socks-05/) | variable | 777, 776, 778, 780, 779, 357, 445 | Yes | No |
| 988 | [Slipper Socks with Leather Sole](https://bhcrafts.shop/product/slipper-socks-14/) | variable | 977, 981, 980, 979, 978, 357, 445 | Yes | No |
| 1004 | [Slipper Socks with Leather Sole](https://bhcrafts.shop/product/slipper-socks-15/) | variable | 1053, 1055, 1057, 1061, 1062, 1058, 1060, 1059, 1056, 1054, 357, 445 | Yes | No |
| 1192 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-01/) | variable | 1253, 1256, 1253, 1254, 1255, 357, 445 | Yes | No |
| 1261 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-02/) | variable | 1257, 1260, 1259, 1258, 357, 445 | Yes | No |
| 1270 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-03/) | variable | 1251, 1252, 1250, 1249, 357, 445 | Yes | No |
| 1279 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-04/) | variable | 1245, 1248, 1247, 1246, 357, 445 | Yes | No |
| 1288 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-05/) | variable | 1242, 1244, 1243, 1242, 357, 445 | Yes | No |
| 1297 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-06/) | variable | 1230, 1240, 1231, 1229, 357, 445 | Yes | No |
| 1306 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-07/) | variable | 1226, 1228, 1227, 1225, 357, 445 | Yes | No |
| 1372 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-10/) | variable | 1362, 1355, 1361, 1381, 357, 445 | Yes | No |
| 1382 | [Fingerless Gloves with Flaps](https://bhcrafts.shop/product/mittens-02/) | variable | 1357, 1358, 1391, 1516, 1356, 1359, 1514, 357, 445 | Yes | No |
| 1537 | [BHcrafts meaningful gift card](https://bhcrafts.shop/product/bhcrafts-meaningful-gift-card/) | pw-gift-card | 1547 | No | No |
| 2056 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-with-traditional-patterns-11/) | variable | 1364, 1363, 1371, 1365, 1370, 1367, 1369, 1366, 1368, 357, 445 | Yes | No |
| 2242 | [Patchwork Bolero](https://bhcrafts.shop/product/patchwork-bolero/) | variable | 2192, 2194, 2193, 2191, 357, 445 | Yes | No |
| 2324 | [Soft toy Owl](https://bhcrafts.shop/product/soft-toy-owl/) | simple | 2280, 2281, 357, 445 | Yes | No |
| 2325 | [Ducks](https://bhcrafts.shop/product/soft-toys-duckies/) | variable | 2346, 2345, 357, 445 | Yes | No |
| 2336 | [Crochet Chicken](https://bhcrafts.shop/product/crochet-toys-chicken/) | simple | 5520, 5522, 5523, 5521, 2322, 2321, 2323, 357, 445 | Yes | No |
| 2341 | [Brundo the Crochet Teddy Bear](https://bhcrafts.shop/product/crochet-teddy-bear-brundo/) | variable | 2335, 2334, 2333, 2332, 2331, 2330, 2329, 2328, 2327, 357, 445 | Yes | No |
| 2347 | [Crochet Cat](https://bhcrafts.shop/product/crochet-soft-toy-cat/) | variable | 2351, 357, 445 | Yes | No |
| 2355 | [Curious Giraffes](https://bhcrafts.shop/product/crochet-soft-toy-giraffe/) | variable | 1694, 1822, 1821, 1820, 1701, 1700, 1699, 1698, 1697, 1695, 357, 445 | Yes | No |
| 2362 | [Crochet Elephants](https://bhcrafts.shop/product/crochet-soft-toy-elephants/) | variable | 2300, 2305, 2304, 2303, 2302, 2301, 1838, 1837, 1836, 1835, 1834, 1831, 357, 445 | Yes | No |
| 2375 | [Crochet Monkeys](https://bhcrafts.shop/product/crochet-soft-toy-monkeys/) | variable | 1846, 1845, 1844, 1843, 357, 445 | Yes | No |
| 2378 | [Crochet cat](https://bhcrafts.shop/product/crochet-soft-toy-cat-2/) | simple | 1847, 1849, 1848, 357, 445 | Yes | No |
| 2379 | [The Frog](https://bhcrafts.shop/product/crochet-soft-toy-frog/) | variable | 5546, 5545, 5547, 5548, 5549, 1853, 1852, 1854, 1850, 357, 445 | Yes | No |
| 2481 | [Knitted doll Ema](https://bhcrafts.shop/product/ema-huggy-doll/) | variable | 2309 | Yes | No |
| 2554 | [Soft Toy – Cat](https://bhcrafts.shop/product/soft-toy-cat/) | variable | 5528, 5529, 5532, 5531, 5533, 5530, 357, 445 | Yes | No |
| 2568 | [Crochet Aliens](https://bhcrafts.shop/product/crochet-soft-toy-alien/) | variable | 1859, 1860, 1861, 1858, 445, 357 | Yes | No |
| 2573 | [Crochet Airplane](https://bhcrafts.shop/product/airplane-crochet-soft-toy/) | simple | 1862, 1863, 1866, 1864, 445, 357 | Yes | No |
| 2595 | [Crocheted Colorful Bunny](https://bhcrafts.shop/product/crochet-bunny-toy/) | variable | 2318, 2319, 2320, 445, 357 | Yes | No |
| 2596 | [Knitted Soft Doll](https://bhcrafts.shop/product/knitted-soft-doll/) | variable | 2309, 2310, 2311, 2312, 2313, 2272, 2273, 2274, 2275, 445, 357 | Yes | No |
| 2602 | [Curious Giraffes](https://bhcrafts.shop/product/amigurumi-giraffe-soft-toy/) | variable | 1705, 1702, 1703, 1707, 1709, 445, 357 | Yes | No |
| 2606 | [Milica – The Doll in a Trendy “Tasla” Dress and Hat](https://bhcrafts.shop/product/knitted-stuffed-crazy-doll/) | simple | 1682, 1680, 1679, 1686, 445, 357 | Yes | No |
| 2608 | [Munevera & Izabela – Best-Chick-Friends!](https://bhcrafts.shop/product/chicken-amigurumi-toy/) | variable | 2610, 2611, 2612, 445, 357 | Yes | No |
| 2614 | [Knitted Teddy Bear](https://bhcrafts.shop/product/knitted-teddy-bear-toy/) | variable | 2619, 445, 357 | Yes | No |
| 2620 | [Hana & Sara – Keep Them Together or Choose One!](https://bhcrafts.shop/product/crochet-stuffed-doll/) | variable | 2626, 2623, 2622, 2624, 2625, 445, 357 | Yes | No |
| 2627 | [Soft Toy – Teddy Bear](https://bhcrafts.shop/product/soft-toy-teddy-bear/) | variable | 2288, 2289, 2290, 445, 357 | Yes | No |
| 2637 | [Pocket-Sized Winter Teddy Bear](https://bhcrafts.shop/product/teddy-bear-infant-toy/) | variable | 2642, 2643, 445, 357 | Yes | No |
| 2645 | [Teddy Bear Couple “Daria & Mario”](https://bhcrafts.shop/product/stuffed-animal-toy-teddy-bear/) | variable | 2647, 445, 357 | Yes | No |
| 2650 | [Married Teddy Bear Couple “Džafko & Hanumica” – Sold as a Set](https://bhcrafts.shop/product/amigurumi-teddy-bear/) | variable | 2654, 445, 357 | Yes | No |
| 2655 | [Crocheted Teddy Bears to Brighten Your Home!](https://bhcrafts.shop/product/crochet-teddy-bear/) | variable | 1689, 1688, 1690, 1692, 1693, 445, 357 | Yes | No |
| 2659 | [Pocket-Sized Summer Teddy Bear](https://bhcrafts.shop/product/colorful-teddy-bear-toy/) | variable | 2661, 2664, 2662, 2665, 2663, 445, 357 | Yes | No |
| 2679 | [Dolls Pipi and Dipi](https://bhcrafts.shop/product/crochet-stuffed-toys/) | variable | 2291, 2292, 2293, 2294, 2295, 2296, 2297, 2298, 2299, 445, 357 | Yes | No |
| 2687 | [Cica – The Perfect Gift for Preschool Girls](https://bhcrafts.shop/product/crochet-stuffed-dolls/) | variable | 2276, 2277, 2278, 2279, 1734, 1735, 1736, 445, 357 | Yes | No |
| 2696 | [Knitted doll Alica](https://bhcrafts.shop/product/amigurumi-stuffed-doll/) | simple | 2251, 2252, 2253, 2254, 445, 357 | Yes | No |
| 2698 | [Small Crochet Bunny](https://bhcrafts.shop/product/bunny-rabbit-stuffed-animal-toy/) | variable | 2282, 2283, 2284, 2285, 2286, 2287, 445, 357 | Yes | No |
| 2701 | [Crocheted Cat](https://bhcrafts.shop/product/crochet-cat-toy/) | variable | 1737, 1738, 1739, 1740, 1741, 1742, 1743, 1744, 445, 357 | Yes | No |
| 2704 | [Knitted Toy – Clown Momo](https://bhcrafts.shop/product/clown-amigurumi-doll/) | simple | 1732, 1730, 1731, 445, 357 | Yes | No |
| 2706 | [Crocheted doll “Zukići”](https://bhcrafts.shop/product/crochet-soft-dolls/) | variable | 1725, 1724, 1723, 1722, 1721, 1720, 1719, 445, 357 | Yes | No |
| 2709 | [Crocheted lion](https://bhcrafts.shop/product/crochet-lion-toy/) | simple | 2307, 2308, 2306, 445, 357 | Yes | No |
| 2716 | [Skiing Winter Beanie](https://bhcrafts.shop/product/skiing-winter-beanie/) | simple | 1531, 1532, 1533, 445, 357 | Yes | No |
| 2761 | [Knitted beanie made in a traditional pattern](https://bhcrafts.shop/product/knitted-beanie-made-in-traditional-pattern/) | variable | 3577, 3632, 3631, 3576, 1508, 1510, 1511, 445, 357 | Yes | No |
| 2798 | [Jacquard Knit Hat](https://bhcrafts.shop/product/jacquard-knit-hat/) | simple | 3641, 3640, 3642, 1495, 1496, 445, 357 | Yes | No |
| 2819 | [Traditional Pattern Hat with Ear Flaps](https://bhcrafts.shop/product/traditional-pattern-hat-with-ear-flaps/) | simple | 3554, 3553, 3552, 3556, 3555, 1506, 1505, 1507, 445, 357 | Yes | No |
| 2820 | [Traditional Pattern Beanie](https://bhcrafts.shop/product/traditional-pattern-beanie/) | variable | 1498, 1499, 1500, 1501, 1502, 1503, 445, 357 | Yes | No |
| 2822 | [Jacquard Knit Beanie](https://bhcrafts.shop/product/jacquard-knit-beanie/) | simple | 1492, 1493, 1494, 445, 357 | Yes | No |
| 2824 | [Winter hat with long earflaps](https://bhcrafts.shop/product/winter-stylish-hat/) | variable | 3581, 3582, 3580, 357, 445 | Yes | No |
| 2829 | [Knitted Shoulder Bag with Doll Applique](https://bhcrafts.shop/product/knit-shoulder-bag-with-doll-applique/) | variable | 2832, 2835, 2836, 2833, 2831, 2837, 2834, 2838, 445, 357 | Yes | No |
| 2839 | [Knitted Bag with Three-Doll Applique](https://bhcrafts.shop/product/knit-handbag-with-dolls-applique/) | variable | 2841, 2843, 2844, 2842, 2845, 445, 357 | Yes | No |
| 2850 | [Knitted Tote Bag with a Doll Applique](https://bhcrafts.shop/product/knit-handbag-with-doll-applique/) | variable | 2855, 2852, 2854, 2853, 445, 357 | Yes | No |
| 2900 | [Crochet Starfish Jacket](https://bhcrafts.shop/product/crochet-boho-jacket/) | variable | 2906, 2902, 2903, 2905, 2904, 357, 445 | Yes | No |
| 2924 | [Jacquard Scarf](https://bhcrafts.shop/product/jacquard-scarf/) | variable | 2931, 2925, 2926, 2927, 2928, 2929, 2930, 357, 445 | Yes | No |
| 2938 | [Traditional Pattern Knit Scarf](https://bhcrafts.shop/product/traditional-pattern-knit-scarf/) | variable | 2939, 357, 445 | Yes | No |
| 2941 | [Starfish wrap/scarf](https://bhcrafts.shop/product/wrap-shawl/) | variable | 4030, 5808, 5805, 4033, 5806, 5807, 5799, 5800, 5801, 5802, 5803, 5804, 5809, 5810, 5811, 5812, 5817, 5818, 5819, 5820, 5822, 5823, 5825, 5826, 5827, 5828, 5829, 5830, 357, 445 | Yes | No |
| 2958 | [Traditional Pattern Circle Scarf](https://bhcrafts.shop/product/traditional-pattern-circle-scarf/) | simple | 2960, 2961, 2962, 357, 445 | Yes | No |
| 2963 | [Jacquard Circle Scarf](https://bhcrafts.shop/product/jacquard-circle-scarf/) | simple | 2964, 2966, 2965, 357, 445 | Yes | No |
| 2970 | [Monochrome Circle Scarf](https://bhcrafts.shop/product/rainbow-colors-circle-scarf/) | simple | 2975, 2976, 357, 445 | Yes | No |
| 2977 | [Rainbow Colors Circle Scarf](https://bhcrafts.shop/product/rainbow-colors-circle-scarf-2/) | simple | 2971, 2973, 2972, 357, 445 | Yes | No |
| 2978 | [Traditional Jacquard Circle Scarf](https://bhcrafts.shop/product/traditional-jacquard-circle-scarf/) | simple | 2980, 2981, 2979, 357, 445 | Yes | No |
| 2982 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-with-traditional-patterns/) | variable | 2984, 357, 445 | Yes | No |
| 2985 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-with-traditional-patterns-2/) | variable | 2990, 2988, 2987, 2989, 357, 445 | Yes | No |
| 2991 | [Gloves with Traditional Patterns](https://bhcrafts.shop/product/gloves-with-traditional-patterns-3/) | variable | 2995, 2994, 2993, 2996, 357, 445 | Yes | No |
| 3022 | [Winter Sports Beanie](https://bhcrafts.shop/product/winter-sports-beanie/) | simple | 3025, 3024, 3023, 445, 357 | Yes | No |
| 3026 | [Jacquard Beanie](https://bhcrafts.shop/product/jacquard-beanie/) | simple | 3028, 3027, 445, 357 | Yes | No |
| 3029 | [Traditional Pattern Beanie](https://bhcrafts.shop/product/traditional-pattern-beanie-2/) | simple | 3032, 3031, 3030, 445, 357 | Yes | No |
| 3033 | [Traditional Pattern Winter Hat](https://bhcrafts.shop/product/traditional-pattern-winter-hat/) | simple | 3034, 3036, 3035, 445, 357 | Yes | No |
| 3037 | [Unisex Jacquard Winter Hat](https://bhcrafts.shop/product/unisex-jacquard-winter-hat/) | simple | 3038, 3039, 3040, 445, 357 | Yes | No |
| 3041 | [Knit Wool Jacquard Beanie](https://bhcrafts.shop/product/knit-wool-jacquard-beanie/) | simple | 3042, 3043, 3044, 445, 357 | Yes | No |
| 3054 | [Crochet Starfish Wrap](https://bhcrafts.shop/product/crochet-wrap-shawl/) | variable | 3069, 3064, 3066, 3067, 3063, 3068, 3061, 3062, 3065, 357, 445 | Yes | No |
| 3083 | [Knit Wool Jacquard Collar](https://bhcrafts.shop/product/knit-wool-jacquard-collar/) | simple | 3042, 3043, 3044, 445, 357 | Yes | No |
| 3084 | [Unisex Jacquard Winter Circle Scarf](https://bhcrafts.shop/product/unisex-jacquard-winter-circle-scarf/) | simple | 3038, 3039, 3040, 445, 357 | Yes | No |
| 3086 | [Traditional Pattern Winter Circle Scarf](https://bhcrafts.shop/product/traditional-pattern-winter-circle-scarf/) | simple | 3034, 3036, 3035, 445, 357 | Yes | No |
| 3087 | [Traditional Pattern Circle Scarf](https://bhcrafts.shop/product/traditional-pattern-circle-scarf-2/) | simple | 3032, 3031, 3030, 445, 357 | Yes | No |
| 3088 | [Jacquard Circle Scarf](https://bhcrafts.shop/product/jacquard-circle-scarf-2/) | simple | 3028, 3027, 445, 357 | Yes | No |
| 3089 | [Winter Sports Scarf](https://bhcrafts.shop/product/winter-sports-scarf/) | simple | 3025, 3024, 3023, 445, 357 | Yes | No |
| 3162 | [Bundle of Christmas Tree Skirt and Two Christmas Stockings](https://bhcrafts.shop/product/bundle-of-christmas-tree-skirt-and-two-christmas-stockings/) | simple | 8444, 8446, 8447, 8448, 8445, 358 | Yes | No |
| 3175 | [Personalized Crochet Christmas Stockings](https://bhcrafts.shop/product/personalized-crochet-christmas-stockings/) | variable | 3168, 3169, 3170, 358, 445 | Yes | No |
| 3217 | [Crochet necklaces with wooden beads](https://bhcrafts.shop/product/necklace/) | variable | 3216, 3278, 3280, 3279, 3281, 3282, 3284, 3283, 3285, 358, 445 | Yes | No |
| 3246 | [Personalized Christmas Stockings – Stripes and Hearts](https://bhcrafts.shop/product/personalized-christmas-stockings-stripes-and-hearts/) | variable | 8836, 8838, 8839, 8837, 358, 534 | Yes | No |
| 3247 | [Jacquard Knit Personalized Christmas Stocking](https://bhcrafts.shop/product/jacquard-knit-personalized-christmas-stocking/) | variable | 8844, 8843, 8845, 8846, 358, 534 | Yes | No |
| 3248 | [Personalized Christmas Stocking With Mrs. Santa Claus Applique](https://bhcrafts.shop/product/personalized-christmas-stocking-with-mrs-santa-claus-applique/) | simple | 3263, 3265, 3264, 358, 446, 534, 445 | Yes | No |
| 3295 | [Crochet string necklace with wooden beads](https://bhcrafts.shop/product/necklace-with-strings/) | variable | 3289, 3302, 3287, 3304, 3303, 3290, 3286, 3288, 3277, 358, 445 | Yes | No |
| 3314 | [Handmade Crochet Snowman Holiday Decor](https://bhcrafts.shop/product/handmade-crochet-snowman-holiday-decor/) | variable | 6169, 6177, 6176, 6175, 6174, 6173, 6172, 6171, 6170, 357, 445 | Yes | No |
| 3326 | [Personalized Jacquard Knit Christmas Stocking – Red](https://bhcrafts.shop/product/personalized-jacquard-knit-christmas-stocking-red/) | variable | 8818, 8819, 8816, 8817, 358, 534 | Yes | No |
| 3449 | [Dog Sweater with Custom Name and Applique](https://bhcrafts.shop/product/dog-sweater-with-custom-name-and-applique/) | variable | 3482, 3455, 3456, 3457, 3461, 3462, 3460, 3463, 3459, 357, 445 | Yes | No |
| 3639 | [Jacquard Knit Beanie with Earflaps](https://bhcrafts.shop/product/jacquard-knit-beanie-with-earflaps/) | simple | 3561, 3562, 3560, 3563, 445, 357 | Yes | No |
| 3643 | [Hat Made Combining Several Traditional Patterns](https://bhcrafts.shop/product/hat-made-combining-several-traditional-patterns/) | simple | 3559, 3557, 3558, 445, 357 | Yes | No |
| 3645 | [Hat with Long Earflaps](https://bhcrafts.shop/product/hat-with-long-earflaps/) | variable | 3571, 3648, 3573, 3574, 3575, 3566, 3572, 3569, 357, 445 | Yes | No |
| 3649 | [Knitted headbands](https://bhcrafts.shop/product/knit-headband/) | variable | 3584, 3583, 3651, 357, 445 | Yes | No |
| 3653 | [Knit Wool Jacquard Hat](https://bhcrafts.shop/product/knit-wool-jacquard-hat/) | simple | 3587, 3586, 3585, 357, 445 | Yes | No |
| 3654 | [Crazy Hat](https://bhcrafts.shop/product/urban-fashion-crazy-style-hat/) | simple | 3590, 3588, 3589, 445, 357 | Yes | No |
| 3702 | [Slipper Socks with Leather Sole](https://bhcrafts.shop/product/slipper-socks-with-leather-sole/) | variable | 3688, 3689, 3690, 3692, 3691, 357, 445 | Yes | No |
| 3705 | [Slipper Socks with Leather Sole](https://bhcrafts.shop/product/slipper-socks-with-leather-sole-2/) | variable | 3693, 3694, 3695, 3697, 3696, 357, 445 | Yes | No |
| 3707 | [Slipper Socks with Leather Sole](https://bhcrafts.shop/product/slipper-socks-with-leather-sole-3/) | variable | 3698, 3699, 3700, 3701, 357, 445 | Yes | No |
| 3728 | [Felted Slipper Socks with Leather Sole](https://bhcrafts.shop/product/felted-slipper-socks-with-leather-sole-2/) | variable | 4424, 4428, 4427, 4426, 4425, 357, 445 | Yes | No |
| 3730 | [Felted Slipper Socks with Leather Sole](https://bhcrafts.shop/product/felted-slipper-socks-with-leather-sole-3/) | variable | 4437, 4438, 4442, 4441, 4440, 4439, 4436, 357, 445 | Yes | No |
| 3790 | [Felted Slipper Socks with Leather Sole](https://bhcrafts.shop/product/felted-slipper-socks-with-leather-sole-4/) | variable | 4429, 4435, 4432, 4434, 4433, 4431, 4430, 357, 445 | Yes | No |
| 3858 | [Personalized Christmas Stocking for Dogs](https://bhcrafts.shop/product/personalized-christmas-stocking-for-dogs/) | variable | 3840, 3818, 3816, 3820, 3819, 3815, 358, 534, 446, 445 | Yes | No |
| 3863 | [Christmas Stocking with Cable Knit Pattern](https://bhcrafts.shop/product/christmas-stocking-with-cable-knit-pattern/) | simple | 3864, 3795, 3796, 3794, 3797, 3792, 358, 445 | Yes | No |
| 3867 | [Patchwork Style Christmas Stocking with Christmas emojis](https://bhcrafts.shop/product/patchwork-style-stocking-with-christmas-emojis/) | simple | 8804, 8800, 8805, 8806, 358, 446, 534 | Yes | No |
| 3869 | [Personalized Christmas Stocking – Christmas Emojis – Patchwork Style](https://bhcrafts.shop/product/personalized-christmas-stocking-christmas-emojis-patchwork-style/) | variable | 8801, 8802, 8803, 8807, 358, 534, 446 | Yes | No |
| 4195 | [Crochet colorful hat “Star” – bright colors](https://bhcrafts.shop/product/crochet-colorful-hat-star-bright-colors/) | simple | 4966, 4967, 4969, 4968, 4965, 4964, 4963, 4962, 357, 445 | Yes | No |
| 4196 | [Crochet colorful hat (Starfish)](https://bhcrafts.shop/product/crochet-colorful-hat-starfish-2/) | simple | 4976, 4980, 4979, 4978, 4977, 4975, 4974, 4962, 357, 445 | Yes | No |
| 4197 | [Crochet colorful hat – bright colors](https://bhcrafts.shop/product/crochet-colorful-hat-bright-colors/) | simple | 4959, 4960, 4958, 4957, 4956, 4955, 4954, 357, 445 | Yes | No |
| 4198 | [Crochet colorful hat (Starfish)](https://bhcrafts.shop/product/crochet-colorful-hat-starfish/) | simple | 4972, 4973, 4971, 4970, 4962, 357, 445 | Yes | No |
| 4228 | [Star Bolero](https://bhcrafts.shop/product/star-bolero/) | variable | 4233, 4238, 4240, 4246, 4249, 4258, 4254, 4252, 4245, 4241, 357, 445 | Yes | No |
| 4614 | [Fair Trade Handknitted Christmas Stocking](https://bhcrafts.shop/product/fair-trade-handknitted-christmas-stocking/) | simple | 4620, 4662, 4663, 4661, 4658, 358, 445 | Yes | No |
| 4665 | [Personalized Christmas Stocking – Traditional](https://bhcrafts.shop/product/personalized-christmas-stocking-traditional-pattern/) | variable | 4627, 4636, 4637, 4638, 4639, 358, 534, 446, 445 | Yes | No |
| 4668 | [Fair Trade Christmas Stocking with Traditional Design](https://bhcrafts.shop/product/fair-trade-christmas-stocking-with-traditional-design/) | simple | 4623, 4646, 4650, 4647, 4648, 4649, 358, 445 | Yes | No |
| 4669 | [Red Christmas Stocking Snowflakes “Timeless”](https://bhcrafts.shop/product/red-christmas-stocking-snowflakes-timeless/) | simple | 4625, 4641, 4642, 4644, 4645, 358, 445 | Yes | No |
| 4671 | [Personalized Christmas Stocking – Sophisticated Look](https://bhcrafts.shop/product/personalized-christmas-stocking-sophisticated-look/) | variable | 4630, 4632, 4631, 4635, 358, 534, 446, 445 | Yes | No |
| 4688 | [Personalized Christmas Stocking with Bold Geometric Design](https://bhcrafts.shop/product/personalized-christmas-stocking-with-bold-geometric-design/) | variable | 7517, 7516, 4713, 4712, 4711, 4710, 4709, 358, 534, 446, 445 | Yes | No |
| 4714 | [Personalized Christmas Stocking with Folk Art](https://bhcrafts.shop/product/personalized-christmas-stocking-with-folk-art/) | variable | 4691, 4716, 4706, 4705, 4704, 4703, 358, 534, 446, 445 | Yes | No |
| 4717 | [Colorful Christmas stockings for cats](https://bhcrafts.shop/product/colorful-christmas-stockings-for-cats/) | variable | 4692, 4701, 4702, 4700, 4699, 4698, 358, 534, 446, 445 | Yes | No |
| 4719 | [Christmas Stocking With Dogtooth Pattern – Add Custom Name](https://bhcrafts.shop/product/christmas-stocking-dogtooth/) | variable | 4693, 4694, 4697, 4696, 4695, 358, 534, 446, 445 | Yes | No |
| 4734 | [Collar](https://bhcrafts.shop/product/collar/) | simple | 5114, 5115, 5110, 5112, 5113, 5111, 357, 445 | Yes | No |
| 4754 | [Collar](https://bhcrafts.shop/product/collar-2/) | simple | 5135, 5132, 5133, 5134, 357, 445 | Yes | No |
| 4986 | [Crocheted headscarf (Starfish)](https://bhcrafts.shop/product/crocheted-headscarf-starfish/) | simple | 4836, 4840, 4839, 4838, 4843, 4841, 357, 445 | Yes | No |
| 4987 | [Crocheted headscarf (Starfish)](https://bhcrafts.shop/product/crocheted-headscarf-starfish-2/) | simple | 4831, 4832, 4835, 4833, 4834, 4843, 4841, 357, 445 | Yes | No |
| 4988 | [Crocheted headscarf (Starfish)](https://bhcrafts.shop/product/crocheted-headscarf-starfish-3/) | simple | 4825, 4827, 4828, 4829, 4830, 4843, 4841, 357, 445 | Yes | No |
| 4989 | [Crocheted headscarf (Starfish)](https://bhcrafts.shop/product/crocheted-headscarf-starfish-4/) | simple | 4820, 4824, 4822, 4821, 4843, 4841, 357, 445 | Yes | No |
| 4991 | [Crocheted headband (Starfish)](https://bhcrafts.shop/product/crocheted-headband-starfish/) | simple | 4847, 4848, 4846, 4845, 4844, 357, 445 | Yes | No |
| 4992 | [Crocheted headband (Starfish)](https://bhcrafts.shop/product/crocheted-headband-starfish-2/) | simple | 4852, 4849, 4853, 4850, 4851, 4845, 4844, 357, 445 | Yes | No |
| 4993 | [Crocheted headband (Starfish)](https://bhcrafts.shop/product/crocheted-headband-starfish-3/) | simple | 4856, 4857, 4855, 4854, 4845, 4844, 357, 445 | Yes | No |
| 4994 | [Crocheted headband (Starfish)](https://bhcrafts.shop/product/crocheted-headband-starfish-4/) | simple | 4860, 4863, 4862, 4861, 4859, 4858, 4845, 4844, 357, 445 | Yes | No |
| 4995 | [Crocheted headscarf (Patchwork)](https://bhcrafts.shop/product/crocheted-headscarf-patchwork/) | simple | 4794, 4791, 4793, 4787, 4782, 4781, 357, 445 | Yes | No |
| 4996 | [Crocheted hat (Patchwork)](https://bhcrafts.shop/product/crocheted-hat-patchwork/) | simple | 4803, 4798, 4802, 4799, 4797, 4796, 357, 445 | Yes | No |
| 4997 | [Crocheted hat (Patchwork)](https://bhcrafts.shop/product/crocheted-hat-patchwork-2/) | simple | 4919, 4922, 4921, 4920, 4915, 4914, 357, 445 | Yes | No |
| 4998 | [Crochet bracelets](https://bhcrafts.shop/product/crochet-bracelets/) | variable | 4868, 4864, 4867, 4866, 4865, 357, 445 | Yes | No |
| 4999 | [Crocheted scarf (Starfish)](https://bhcrafts.shop/product/crocheted-scarf-starfish/) | simple | 4888, 4889, 4886, 4885, 357, 445 | Yes | No |
| 5002 | [Crocheted scarf (Circles)](https://bhcrafts.shop/product/crocheted-scarf-circles/) | simple | 4902, 4903, 4901, 4890, 357, 445 | Yes | No |
| 5003 | [Crocheted scarf (Circles)](https://bhcrafts.shop/product/crocheted-scarf-circles-2/) | simple | 4899, 4900, 4898, 4897, 4896, 4895, 4890, 357, 445 | Yes | No |
| 5004 | [Crocheted scarf (Circles)](https://bhcrafts.shop/product/crocheted-scarf-circles-3/) | simple | 4893, 4892, 4891, 4894, 4890, 357, 445 | Yes | No |
| 5005 | [Crocheted scarf (Patchwork)](https://bhcrafts.shop/product/crocheted-scarf-patchwork/) | simple | 4872, 4875, 4874, 4873, 4871, 4870, 357, 445 | Yes | No |
| 5006 | [Crocheted scarf (Patchwork)](https://bhcrafts.shop/product/crocheted-scarf-patchwork-2/) | simple | 4876, 4880, 4879, 4878, 4877, 4870, 357, 445 | Yes | No |
| 5007 | [Crocheted scarf (Circles II)](https://bhcrafts.shop/product/crocheted-scarf-circles-ii/) | simple | 4884, 4882, 4883, 4881, 357, 445 | Yes | No |
| 5008 | [Crocheted scarf (Network – Flowers)](https://bhcrafts.shop/product/crocheted-scarf-network-flowers/) | simple | 4907, 4908, 4906, 4905, 4904, 4909, 357, 445 | Yes | No |
| 5009 | [Crocheted scarf (Network – Flowers)](https://bhcrafts.shop/product/crocheted-scarf-network-flowers-2/) | simple | 4913, 4911, 4912, 4910, 4909, 357, 445 | Yes | No |
| 5010 | [Crocheted headscarf (Circles)](https://bhcrafts.shop/product/crocheted-headscarf-circles/) | variable | 4814, 4819, 4818, 4817, 4816, 4815, 357, 445 | Yes | No |
| 5011 | [Crocheted headscarf (Patchwork)](https://bhcrafts.shop/product/crocheted-headscarf-patchwork-2/) | simple | 4805, 4806, 4808, 4807, 4809, 357, 445 | Yes | No |
| 5012 | [Crocheted headscarf (Patchwork)](https://bhcrafts.shop/product/crocheted-headscarf-patchwork-3/) | simple | 4813, 4812, 4811, 4810, 357, 445 | Yes | No |
| 5020 | [Colorful crochet hat](https://bhcrafts.shop/product/colorful-crochet-hat/) | simple | 4933, 4929, 4932, 4931, 4930, 357, 445 | Yes | No |
| 5021 | [Crochet hat](https://bhcrafts.shop/product/crochet-hat/) | simple | 4947, 4944, 4946, 4948, 357, 445 | Yes | No |
| 5022 | [Crochet hat](https://bhcrafts.shop/product/crochet-hat-2/) | simple | 4934, 4935, 4937, 4936, 4948, 357, 445 | Yes | No |
| 5023 | [Crochet hat](https://bhcrafts.shop/product/crochet-hat-3/) | simple | 4942, 4939, 4941, 4948, 357, 445 | Yes | No |
| 5024 | [Crochet hat](https://bhcrafts.shop/product/crochet-hat-4/) | simple | 4952, 4951, 4950, 4949, 357, 445 | Yes | No |
| 5025 | [Colorful striped crochet hat](https://bhcrafts.shop/product/colorful-striped-crochet-hat/) | simple | 4927, 4928, 4926, 4925, 357, 445 | Yes | No |
| 5140 | [Crocheted headband](https://bhcrafts.shop/product/crocheted-headband/) | simple | 5065, 5076, 5067, 357, 445 | Yes | No |
| 5141 | [Crochet hat](https://bhcrafts.shop/product/crochet-hat-5/) | simple | 5108, 5107, 357, 445 | Yes | No |
| 5142 | [Crochet hat](https://bhcrafts.shop/product/crochet-hat-6/) | simple | 5042, 5047, 5081, 357, 445 | Yes | No |
| 5143 | [Crochet hat with details](https://bhcrafts.shop/product/crochet-hat-with-details/) | simple | 5034, 5037, 5035, 357, 445 | Yes | No |
| 5144 | [Necklace](https://bhcrafts.shop/product/necklace-2/) | simple | 5088, 5091, 5089, 5087, 5092, 358, 445 | Yes | No |
| 5149 | [Collar](https://bhcrafts.shop/product/collar-3/) | simple | 5126, 5127, 5131, 5128, 357, 445 | Yes | No |
| 5419 | [Pillow/Toy/Best Friend](https://bhcrafts.shop/product/pillow-toy-best-friend/) | simple | 5372, 5370, 5371, 5369, 5368, 5367, 5366, 445, 357 | Yes | No |
| 5420 | [Everyone Loves Turtles!](https://bhcrafts.shop/product/turtle-toy/) | simple | 5374, 5377, 5376, 5375, 5373, 445, 357 | Yes | No |
| 5421 | [Dejan the Monkey](https://bhcrafts.shop/product/monkey-dejan/) | simple | 5382, 5384, 5383, 5381, 5380, 5379, 5378, 445, 357 | Yes | No |
| 5422 | [“Radica” – Is She Dejan’s Girlfriend?](https://bhcrafts.shop/product/monkey-radica/) | simple | 5389, 5390, 5391, 5389, 5388, 5387, 5386, 5385, 357, 445 | Yes | No |
| 5425 | [Teddy Bear “Hajro” – A Fun Way to Learn Colors!](https://bhcrafts.shop/product/teddy-bear-hajro/) | simple | 5392, 5398, 5397, 5396, 5395, 5394, 5393, 357, 445 | Yes | No |
| 5426 | [“Risto” the Rabbit](https://bhcrafts.shop/product/bunny-risto/) | simple | 5410, 5414, 5413, 5412, 5411, 357, 445 | Yes | No |
| 5458 | [Curious Giraffes](https://bhcrafts.shop/product/colorful-giraffes/) | variable | 5402, 5401, 5400, 5399, 5403, 357, 445 | Yes | No |
| 5461 | [Elephants with “Elephant Memory”](https://bhcrafts.shop/product/colorful-elephants/) | variable | 5406, 5405, 5404, 5408, 5409, 5407, 357, 445 | Yes | No |
| 5465 | [Personalized Dolls – Dragica](https://bhcrafts.shop/product/personalized-dolls-dragica/) | simple | 5429, 5432, 5428, 5427, 5431, 357, 445 | Yes | No |
| 5467 | [Personalized Dolls – Dženi](https://bhcrafts.shop/product/personalized-dolls-dzeni/) | simple | 5436, 5437, 5435, 5434, 5433, 5431, 357, 445 | Yes | No |
| 5470 | [Personalized Dolls – Kleca](https://bhcrafts.shop/product/personalized-dolls-kleca/) | simple | 5443, 5448, 5447, 5446, 5445, 5444, 5431, 357, 445 | Yes | No |
| 5473 | [Personalized Dolls – Ena](https://bhcrafts.shop/product/personalized-dolls-ena/) | simple | 5439, 5438, 5442, 5441, 5440, 5431, 357, 445 | Yes | No |
| 5476 | [Personalized Dolls – Una](https://bhcrafts.shop/product/personalized-dolls-una/) | simple | 5449, 5453, 5456, 5455, 5451, 5452, 5450, 5454, 5431, 357, 445 | Yes | No |
| 5555 | [Knitted Toy – Clown Momo](https://bhcrafts.shop/product/knitted-toy-clown-momo/) | simple | 5554, 5550, 5552, 5553, 5551, 357, 445 | Yes | No |
| 5556 | [Sandra the Doll](https://bhcrafts.shop/product/sandra-the-doll/) | simple | 5538, 5539, 5540, 5543, 5544, 5542, 5541, 357, 445 | Yes | No |
| 5557 | [Chubby bunny Buca](https://bhcrafts.shop/product/chubby-bunny-buca/) | simple | 5518, 5517, 5519, 5516, 5515, 5514, 5513, 357, 445 | Yes | No |
| 5581 | [Hand Crocheted Boho Bag](https://bhcrafts.shop/product/hand-crocheted-boho-bag/) | variable | 5595, 5596, 5593, 5594, 5592, 5591, 5590, 5597, 5599, 5589, 5588, 5587, 5586, 5672, 357 | Yes | No |
| 5600 | [Bag “envelope”](https://bhcrafts.shop/product/bag-envelope/) | simple | 5606, 5604, 5601, 5602, 5603, 5605, 5607, 5608, 5609, 357, 445 | Yes | No |
| 5651 | [What once was a kilim is now a purse/bag](https://bhcrafts.shop/product/what-once-was-a-kilim-is-now-a-purse-bag-2/) | variable | 5643, 5644, 5642, 5641, 5640, 5639, 5638, 5637, 5636, 5635, 5634, 5633, 357, 445 | Yes | No |
| 5657 | [What once was a kilim is now a purse/bag](https://bhcrafts.shop/product/what-once-was-a-kilim-is-now-a-purse-bag-3/) | variable | 5629, 5630, 5631, 5632, 357, 445 | Yes | No |
| 5670 | [Striped shoulder bag](https://bhcrafts.shop/product/striped-shoulder-bag/) | simple | 5663, 5665, 5669, 5668, 5667, 5666, 5664, 357, 445 | Yes | No |
| 5741 | [Striped shoulder bag – Torbičak](https://bhcrafts.shop/product/striped-shoulder-bag-torbicak/) | variable | 5686, 5673, 5685, 5684, 5683, 5682, 5681, 5680, 5679, 5678, 5677, 5676, 5675, 5674, 357, 445 | Yes | No |
| 5747 | [Bag “envelope”](https://bhcrafts.shop/product/bag-envelope-2/) | simple | 5687, 5689, 5693, 5690, 5691, 5694, 5692, 5688, 357, 445 | Yes | No |
| 5749 | [Patchwork Bag](https://bhcrafts.shop/product/patchwork-bag/) | variable | 5761, 5762, 5763, 5760, 5759, 5758, 5757, 5756, 5755, 357, 445 | Yes | No |
| 5778 | [Knitted-crocheted vest/jacket](https://bhcrafts.shop/product/knitted-crocheted-vest-jacket/) | simple | 5777, 5772, 5771, 5776, 5775, 5774, 5773, 5770, 5769, 5768, 5767, 445, 357 | Yes | No |
| 5840 | [Black & White Jacket](https://bhcrafts.shop/product/black-white-jacket/) | simple | 5836, 5833, 5832, 5834, 357, 445 | Yes | No |
| 5843 | [Sweater – remake](https://bhcrafts.shop/product/sweater-remake/) | simple | 5839, 5835, 5838, 5837, 357, 445 | Yes | No |
| 5870 | [Crocheted headscarf](https://bhcrafts.shop/product/crocheted-headscarf/) | variable | 5734, 5730, 5739, 5738, 5737, 5736, 5735, 5733, 5732, 5731, 5729, 5728, 5727, 5726, 5725, 5724, 357, 445 | Yes | No |
| 5873 | [Crocheted headband (Circle)](https://bhcrafts.shop/product/crocheted-headband-circle/) | variable | 5863, 5695, 5856, 5851, 5866, 5865, 5864, 5862, 5861, 5860, 5859, 5858, 5857, 5855, 5854, 5853, 5852, 5699, 5698, 5697, 5696, 5868, 5867, 357, 445 | Yes | No |
| 5875 | [Crocheted headband](https://bhcrafts.shop/product/crocheted-headband-2/) | variable | 5719, 5714, 5706, 5702, 5723, 5722, 5721, 5720, 5718, 5717, 5716, 5715, 5713, 5712, 5711, 5710, 5709, 5708, 5707, 5705, 5704, 5703, 5701, 5700, 357, 445 | Yes | No |
| 6066 | [Christmas Stocking With All Christmas Symbols](https://bhcrafts.shop/product/christmas-stocking-with-all-christmas-symbols/) | simple | 6048, 6049, 6050, 6051, 6052, 358, 445 | Yes | No |
| 6069 | [Christmas stocking – Snowflakes and Reindeers](https://bhcrafts.shop/product/christmas-stocking-traditional-with-snowflakes-and-reindeers/) | simple | 6059, 6061, 6062, 6060, 6054, 358, 445 | Yes | No |
| 6071 | [Christmas Stocking with Colorful Floral Pattern](https://bhcrafts.shop/product/christmas-stocking-colorful/) | simple | 6032, 6033, 6034, 6035, 6036, 6037, 6039, 6038, 358, 445 | Yes | No |
| 6072 | [Christmas stocking – Reindeers](https://bhcrafts.shop/product/christmas-stocking-reindeers/) | simple | 6040, 6043, 6044, 6045, 6042, 6046, 358, 445 | Yes | No |
| 6107 | [Christmas stocking with Christmas trees](https://bhcrafts.shop/product/christmas-stocking-with-christmas-trees/) | simple | 6139, 6138, 6137, 6136, 6121, 358, 445 | Yes | No |
| 6190 | [Handmade Christmas Stocking with Snowflakes](https://bhcrafts.shop/product/handmade-christmas-stocking-with-snowflakes/) | simple | 6114, 6111, 6112, 6113, 6115, 358, 445 | Yes | No |
| 6192 | [Fair Trade Handmade Christmas Stocking – Sustainable Knit Holiday Décor](https://bhcrafts.shop/product/fair-trade-handmade-christmas-stocking-sustainable-knit-holiday-decor/) | simple | 6306, 6310, 6307, 6311, 6308, 6309, 358, 445 | Yes | No |
| 6193 | [Handmade Boho Style Christmas Stocking](https://bhcrafts.shop/product/handmade-boho-style-christmas-stocking/) | simple | 6132, 6127, 6128, 6130, 6131, 6129, 6117, 358, 445 | Yes | No |
| 6194 | [Handmade Christmas Stocking – Holiday Tree & Pom-Pom Design](https://bhcrafts.shop/product/handmade-christmas-stocking-holiday-tree-pom-pom-design/) | simple | 6140, 6141, 6143, 6142, 6118, 358, 445 | Yes | No |
| 6196 | [Christmas Stocking – Reindeer & Santa](https://bhcrafts.shop/product/christmas-stocking-reindeer-santa/) | simple | 6148, 6125, 6124, 6123, 6126, 6119, 358, 445 | Yes | No |
| 6198 | [Colorful Reindeer Christmas Stocking](https://bhcrafts.shop/product/colorful-reindeer-christmas-stocking/) | simple | 6144, 6145, 6146, 6147, 6120, 358, 445 | Yes | No |
| 6215 | [Colorful Knitted Christmas Stocking – Snowmen, Trees & Bells Design](https://bhcrafts.shop/product/colorful-knitted-christmas-stocking-snowmen-trees-bells-design/) | simple | 6268, 6271, 6269, 6270, 6272, 358, 445 | Yes | No |
| 6216 | [Mini Knit Mitten Christmas Ornament Set](https://bhcrafts.shop/product/mini-knit-mitten-christmas-ornament-set/) | variable | 6166, 6165, 6168, 6167, 357, 445 | Yes | No |
| 6222 | [Mini Knit Slipper Socks Christmas Ornament Set](https://bhcrafts.shop/product/mini-knit-slipper-socks-christmas-ornament-set/) | variable | 6187, 6189, 6185, 6188, 6186, 357, 445 | Yes | No |
| 6225 | [Mini Christmas Stockings Ornament Set](https://bhcrafts.shop/product/mini-christmas-stockings-ornament-set/) | variable | 6178, 6180, 6184, 6183, 6182, 6181, 357, 445 | Yes | No |
| 6229 | [Handmade Crochet Gingerbread Man Christmas Ornaments Set](https://bhcrafts.shop/product/handmade-crochet-gingerbread-man-christmas-tree-ornament-set/) | variable | 6210, 6205, 357, 445 | Yes | No |
| 6233 | [Hand Crocheted Angel Christmas Ornament set](https://bhcrafts.shop/product/hand-crocheted-angel-christmas-ornament-set/) | variable | 6206, 6207, 6205, 357, 445 | Yes | No |
| 6236 | [Hand-Crocheted Santa Face Christmas Ornaments Set](https://bhcrafts.shop/product/hand-crocheted-santa-face-christmas-ornaments-set/) | variable | 6209, 6208, 6205, 357, 445 | Yes | No |
| 6239 | [Hand-Crocheted Snowman Christmas Ornaments Set](https://bhcrafts.shop/product/hand-crocheted-snowman-christmas-ornaments-set/) | variable | 6211, 6212, 6205, 357, 445 | Yes | No |
| 6243 | [Hand-Crocheted Red Jingle Bell Christmas Ornaments Set](https://bhcrafts.shop/product/hand-crocheted-red-jingle-bell-christmas-ornaments-set/) | variable | 6213, 6214, 6205, 357, 445 | Yes | No |
| 6246 | [Handmade Assorted Christmas Ornament Set of 8](https://bhcrafts.shop/product/handmade-assorted-christmas-ornament-set-of-8/) | variable | 6205, 6213, 6214, 6212, 6211, 6210, 6208, 6207, 6187, 6180, 6168, 6166, 357, 445 | Yes | No |
| 6274 | [Hand-Knitted Christmas Stocking with Reindeer, Tree & Bell](https://bhcrafts.shop/product/hand-knitted-christmas-stocking-with-reindeer-tree-bell/) | simple | 6276, 6279, 6277, 6278, 6275, 358, 445 | Yes | No |
| 6281 | [Hand Knit Christmas Stocking – Vintage Holiday Design](https://bhcrafts.shop/product/hand-knit-christmas-stocking-vintage-holiday-design/) | simple | 6282, 6284, 6285, 6283, 6286, 358, 445 | Yes | No |
| 6297 | [Christmas Stocking with Festive Trees – Yellow, Green & Red](https://bhcrafts.shop/product/christmas-stocking-with-festive-trees-yellow-green-red/) | simple | 6299, 6300, 6303, 6302, 6301, 6304, 358, 445 | Yes | No |
| 6452 | [Handmade Christmas stocking – Sustainable Knit Holiday Décor](https://bhcrafts.shop/product/handmade-christmas-stocking-sustainable-knit-holiday-decor/) | simple | 6263, 6266, 6264, 6265, 6267, 358, 445 | Yes | No |
| 6889 | [Fair-Trade Christmas Stocking with Chevron Pattern – Yellow](https://bhcrafts.shop/product/fair-trade-christmas-stocking-with-chevron-pattern-yellow/) | simple | 6881, 6882, 6885, 6884, 6880, 358, 445 | Yes | No |
| 7405 | [Knitted Personalized Christmas Stocking for Cats](https://bhcrafts.shop/product/knitted-personalized-christmas-stocking-for-cat/) | variable | 366, 370, 369, 368, 365, 358, 445 | Yes | No |
| 7426 | [Bundle of 5 Hand-Knit Christmas Stockings](https://bhcrafts.shop/product/bundle-of-5-hand-knit-christmas-stockings/) | simple | 8629, 6697 | Yes | No |
| 7428 | [Bundle of 5 Handmade Christmas Stockings](https://bhcrafts.shop/product/bundle-of-5-handmade-christmas-stockings/) | simple | 8931, 8934, 8935, 8936, 8932, 8933, 358 | Yes | No |
| 7430 | [Bulk of 5 Handmade Christmas Stockings](https://bhcrafts.shop/product/bulk-of-5-handmade-christmas-stockings/) | simple | 9483, 3811, 3815, 365, 386, 4701, 358 | Yes | No |
| 7499 | [Handmade Jacquard Christmas Stocking](https://bhcrafts.shop/product/handmade-jacquard-christmas-stocking/) | simple | 7467, 7468, 7466, 7464, 358 | Yes | No |
| 7510 | [Blue Handmade Holiday Stocking with Snowflakes](https://bhcrafts.shop/product/blue-handmade-holiday-stocking-with-snowflakes/) | simple | 7473, 7472, 7471, 7470, 358 | Yes | No |
| 7512 | [Hand-knit Holiday Stockings – Colorful Geometric Style](https://bhcrafts.shop/product/hand-knit-holiday-stockings-colorful-geometric-style/) | simple | 7475, 7477, 7476, 7474, 358 | Yes | No |
| 7514 | [Colorful Striped Christmas Tree Stockings](https://bhcrafts.shop/product/colorful-striped-christmas-tree-stockings/) | simple | 7479, 7481, 7480, 7478, 358 | Yes | No |
| 7518 | [Hand-Knit Colorful Striped Christmas Stocking](https://bhcrafts.shop/product/hand-knit-colorful-striped-christmas-stocking/) | simple | 7483, 7485, 7484, 7482, 358 | Yes | No |
| 7520 | [Hand-Knit Christmas Stocking with Reindeer](https://bhcrafts.shop/product/hand-knit-christmas-stocking-with-reindeer/) | simple | 7487, 7489, 7488, 7486, 358 | Yes | No |
| 7522 | [Christmas Stocking Hand-Knit – Festive Multicolor](https://bhcrafts.shop/product/christmas-stocking-hand-knit-festive-multicolor/) | simple | 7491, 7492, 7493, 7490, 358 | Yes | No |
| 7524 | [Custom order – Handcrafted Christmas Stocking – Chevron Style](https://bhcrafts.shop/product/handcrafted-christmas-stocking-chevron-style/) | simple | 7495, 7497, 7496, 7523, 358 | Yes | No |
| 7528 | [Handmade Holiday Stocking with Colorful Pom-Poms](https://bhcrafts.shop/product/handmade-holiday-stocking-with-colorful-pom-poms/) | simple | 7537, 7539, 7538, 7527, 358 | Yes | No |
| 7580 | [Bundle of 5 White Hand-Knit Christmas Stockings](https://bhcrafts.shop/product/bundle-of-5-white-hand-knit-christmas-stockings/) | simple | 9846, 9121, 6132, 6139, 6140, 6299, 358 | Yes | No |
| 7587 | [Bundle of 5 Snowflake Handmade Christmas Stockings](https://bhcrafts.shop/product/bundle-of-5-red-handmade-christmas-stockings/) | simple | 9484, 6115, 7470, 4641, 9117, 6054, 358 | Yes | No |
| 7635 | [Artisan-Made Hand-Knit Christmas Tree Skirt](https://bhcrafts.shop/product/artisan-made-hand-knit-christmas-tree-skirt/) | simple | 7626, 7629, 7628, 7627, 358 | Yes | No |
| 7689 | [Artisan-Made Crocheted Christmas Blanket](https://bhcrafts.shop/product/artisan-made-crocheted-christmas-blanket/) | simple | 7631, 7630, 7632, 7634, 7633, 358 | Yes | No |
| 7795 | [Custom order – 3 Christmas stockings](https://bhcrafts.shop/product/custom-order-h/) | simple | 8537 | No | No |
| 8152 | [Hand-Knitted Pillow Case with Christmas trees](https://bhcrafts.shop/product/hand-knitted-pillow-case-with-christmas-trees/) | simple | 8154, 8156, 8157, 8158, 8155, 8159, 358 | Yes | No |
| 8168 | [Fair Trade Artisans Made Pillow Cover](https://bhcrafts.shop/product/fair-trade-artisans-made-pillow-cover/) | simple | 8160, 8164, 8161, 8162, 8163, 358 | Yes | No |
| 8196 | [Custom order – pullover blue x10 – 50% advance](https://bhcrafts.shop/product/custom-order-pullover-blue-x10-50-advance/) | simple | 9428 | No | No |
| 8268 | [Bundle of 3 Handmade Christmas Stockings with Festive Appliques](https://bhcrafts.shop/product/bundle-of-3-handmade-christmas-stockings-with-festive-appliques/) | simple | 8591, 8441, 8592, 8443, 358 | Yes | No |
| 8269 | [Handmade Christmas Stockings Set of Two with Girl Doll Appliqués](https://bhcrafts.shop/product/handmade-christmas-stockings-set-of-two-with-girl-doll-appliques/) | simple | 8237, 8238, 8239, 358 | Yes | No |
| 8281 | [Handcrafted Christmas Stockings Set of Two](https://bhcrafts.shop/product/handcrafted-christmas-stockings-set-of-two/) | simple | 8417, 7416, 6880, 358 | Yes | No |
| 8283 | [Christmas Stockings – Mr. and Mrs. Santa Claus Set](https://bhcrafts.shop/product/christmas-stockings-mr-and-mrs-santa-claus-set/) | simple | 8426, 8428, 8427, 358 | Yes | No |
| 8296 | [Artisan Handmade Christmas Stockings Set of Two](https://bhcrafts.shop/product/artisan-handmade-christmas-stockings-set-of-two/) | simple | 8418, 8420, 8419, 358 | Yes | No |
| 8297 | [Handmade Christmas Stockings Set of two for Dogs](https://bhcrafts.shop/product/handmade-christmas-stockings-set-of-two-for-dogs/) | simple | 8252, 8253, 8254, 358 | Yes | No |
| 8305 | [Crocheted Christmas Stockings Bundle of Two](https://bhcrafts.shop/product/crocheted-christmas-stockings-bundle-of-two/) | simple | 8425, 8423, 8424, 358 | Yes | No |
| 8430 | [Handmade Christmas Stockings Set of 3 for Cats](https://bhcrafts.shop/product/handmade-christmas-stockings-set-of-3-for-cats/) | simple | 8431, 8432, 8434, 8433, 358 | Yes | No |
| 8439 | [Crocheted Christmas Stockings Bundle of Two + Wine Bottle Sleeve](https://bhcrafts.shop/product/crocheted-christmas-stockings-bundle-of-two-wine-bottle-sleeve/) | simple | 8436, 8437, 8423, 8438, 358 | Yes | No |
| 8460 | [Handmade Christmas Stockings Set of Two](https://bhcrafts.shop/product/handmade-christmas-stockings-set-of-two/) | simple | 358 | Yes | No |
| 8465 | [Crocheted Christmas Stockings Bulk of Two](https://bhcrafts.shop/product/crocheted-christmas-stockings-bulk-of-two/) | simple | 8464, 8463, 8424, 358 | Yes | No |
| 8469 | [Set of Pillowcase and Christmas Tree](https://bhcrafts.shop/product/set-of-pillowcase-and-christmas-tree/) | simple | 8466, 8467, 8468, 8156, 8158, 358 | Yes | No |
| 8788 | [Wholesale Christmas Stocking – Model 05](https://bhcrafts.shop/product/wholesale-christmas-stocking-model-05/) | simple | 8862, 8861, 8860, 8859 | Yes | No |
| 8797 | [Wholesale Holiday Stocking – Model 06](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-06/) | simple | 8831, 8829, 8828, 8830 | Yes | No |
| 8877 | [Wholesale Festive Stocking – Model 07](https://bhcrafts.shop/product/wholesale-festive-stocking-model-07/) | simple | 8835, 8833, 8832, 8834 | Yes | No |
| 8879 | [Wholesale Christmas Stocking – Model 08](https://bhcrafts.shop/product/wholesale-christmas-stocking-model-08/) | simple | 8858, 8857, 8855, 8856 | Yes | No |
| 8885 | [Wholesale Holiday Stocking – Model 09](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-09/) | simple | 8827, 8824, 8825, 8826 | Yes | No |
| 8886 | [Wholesale Festive Stocking – Model 10](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-10/) | simple | 8811, 8810, 8809, 8808 | Yes | No |
| 8894 | [Wholesale Christmas Stocking – Model 11](https://bhcrafts.shop/product/wholesale-christmas-stocking-model-11/) | simple | 8854, 8851, 8852 | Yes | No |
| 8895 | [Wholesale Festive Stocking – Model 12](https://bhcrafts.shop/product/wholesale-festive-stocking-model-12/) | simple | 8815, 8812, 8813, 8814 | Yes | No |
| 8896 | [Wholesale Holiday Stocking – Model 14](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-14/) | simple | 8866, 8865, 8863, 8864 | Yes | No |
| 8897 | [Wholesale Christmas Stocking – Model 15](https://bhcrafts.shop/product/wholesale-christmas-stocking-model-15/) | simple | 8841, 8840, 8842, 8839 | Yes | No |
| 8898 | [Wholesale Holiday Stocking – Model 15-1](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-15-1/) | simple | 8837, 8836, 8838, 8839 | Yes | No |
| 8899 | [Wholesale Festive Stocking – Model 16](https://bhcrafts.shop/product/wholesale-festive-stocking-model-16/) | simple | 8850, 8848, 8847, 8849 | Yes | No |
| 8900 | [Wholesale Christmas Stocking – Model 16-1](https://bhcrafts.shop/product/wholesale-christmas-stocking-model-16-1/) | simple | 8846, 8844, 8843, 8845 | Yes | No |
| 8901 | [Wholesale Holiday Stocking – Model 17](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-17/) | simple | 8823, 8821, 8820, 8822 | Yes | No |
| 8902 | [Wholesale Festive Stocking – Model 17-1](https://bhcrafts.shop/product/wholesale-festive-stocking-model-17-1/) | simple | 8817, 8818, 8819, 8816 | Yes | No |
| 8903 | [Wholesale Christmas Stocking – Model 45](https://bhcrafts.shop/product/wholesale-christmas-stocking-model-45/) | simple | 4641, 4625, 4645, 4644, 4642 | Yes | No |
| 8904 | [Wholesale Holiday Stocking – Model 57](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-57/) | simple | 6115, 6114, 6108, 6112 | Yes | No |
| 8905 | [Wholesale Festive Stocking – Model 58](https://bhcrafts.shop/product/wholesale-festive-stocking-model-58/) | simple | 6309, 6306, 6310, 6308 | Yes | No |
| 8906 | [Wholesale Christmas Stocking – Model 58-1](https://bhcrafts.shop/product/wholesale-christmas-stocking-model-58-1/) | simple | 6267, 6263, 6266, 6264 | Yes | No |
| 8908 | [Wholesale Holiday Stocking – Model 61](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-61/) | simple | 6119, 6148, 6123, 6122 | Yes | No |
| 8909 | [Wholesale Festive Stocking – Model 66](https://bhcrafts.shop/product/wholesale-festive-stocking-model-66/) | simple | 6304, 6299, 6300, 6302 | Yes | No |
| 8910 | [Wholesale Christmas Stocking – Model 69](https://bhcrafts.shop/product/wholesale-christmas-stocking-model-69/) | simple | 7470, 7473, 7472, 7471 | Yes | No |
| 8911 | [Wholesale Holiday Stocking – Model 71](https://bhcrafts.shop/product/wholesale-holiday-stocking-model-71/) | simple | 7478, 7479, 7481, 7480 | Yes | No |
| 8912 | [Wholesale Festive Stocking – Model 73](https://bhcrafts.shop/product/wholesale-festive-stocking-model-73/) | simple | 7486, 7487, 7489, 7488 | Yes | No |
| 8923 | [Personalized Striped Christmas Stockings](https://bhcrafts.shop/product/personalized-striped-christmas-stockings/) | variable | 8924, 8925, 8926, 8927, 358, 446, 534 | No | No |
| 8975 | [Hand Crocheted Linen Hat with Circles](https://bhcrafts.shop/product/hand-crocheted-linen-hat-with-circles/) | simple | 8943, 8946, 8945, 8942, 8944, 357 | No | No |
| 8976 | [Hand Crocheted Linen Hat with Starfish](https://bhcrafts.shop/product/hand-crocheted-linen-hat-with-starfish/) | simple | 8952, 8953, 8954, 8955, 8956, 357 | No | No |
| 8978 | [Handmade Wool Hat and Gloves with Colorful Pompoms](https://bhcrafts.shop/product/handmade-wool-hat-and-gloves-with-colorful-pompoms/) | variable | 8957, 8959, 8960, 8958, 8962, 8961, 8965, 8964, 8963, 357 | No | No |
| 8982 | [Hand Crocheted Linen Hat](https://bhcrafts.shop/product/hand-crocheted-linen-hat/) | variable | 8949, 8951, 8948, 8947, 8950, 357 | No | No |
| 8988 | [Handmade Wool Hat and Gloves with Pompoms](https://bhcrafts.shop/product/handmade-wool-hat-and-gloves-with-pompoms/) | variable | 8992, 8993, 8994, 8995, 8997, 8996, 357 | No | No |
| 8998 | [Hand Knit Wool Hat with Earflaps](https://bhcrafts.shop/product/hand-knit-wool-hat-with-earflaps/) | simple | 8972, 8973, 8971, 8974, 357 | No | No |
| 9017 | [Hand-Knit Wool Hat and Gloves with Embroidered Flowers](https://bhcrafts.shop/product/hand-knit-wool-hat-and-gloves-with-embroidered-flowers/) | variable | 9011, 9012, 9014, 9013, 9008, 9007, 9015, 9016, 9006, 9009, 9010, 357 | No | No |
| 9022 | [Hand Knit Wool Hat – Honeycomb](https://bhcrafts.shop/product/hand-knit-wool-hat-honeycomb/) | simple | 9004, 9005, 9003, 9002, 357 | No | No |
| 9023 | [Slipper Socks with Leather Sole – Short Black](https://bhcrafts.shop/product/slipper-socks-with-leather-sole-short-black/) | variable | 8967, 8969, 8970, 8968, 357 | Yes | No |
| 9034 | [Handmade Crochet Christmas Wreath for Hanging](https://bhcrafts.shop/product/handmade-crochet-christmas-wreath-for-hanging/) | simple | 9031, 9032, 9033, 357 | Yes | No |
| 9035 | [Handmade Crochet Christmas Wreath for Hanging Red](https://bhcrafts.shop/product/handmade-crochet-christmas-wreath-for-hanging-red/) | simple | 9029, 9030, 357 | Yes | No |
| 9048 | [Handmade Christmas Balls – Ornament Set](https://bhcrafts.shop/product/handmade-christmas-balls-ornament-set/) | variable | 9037, 9036, 357 | Yes | No |
| 9053 | [Felted Christmas Balls – Ornament Set](https://bhcrafts.shop/product/felted-christmas-balls-ornament-set/) | variable | 9040, 9041, 357 | Yes | No |
| 9059 | [Crocheted Christmas Apple – Ornament Set](https://bhcrafts.shop/product/crocheted-christmas-apple-ornament-set/) | variable | 9043, 9042, 357 | Yes | No |
| 9063 | [Crocheted Christmas Ornament Set – Holiday House](https://bhcrafts.shop/product/crocheted-christmas-ornament-set-holiday-house/) | variable | 9039, 9038, 357 | Yes | No |
| 9066 | [Christmas Ornament Set – Holiday Tree](https://bhcrafts.shop/product/christmas-ornament-set-holiday-tree/) | variable | 9047, 9046, 357 | Yes | No |
| 9069 | [Christmas Table Decor – Snowman](https://bhcrafts.shop/product/christmas-table-decor-snowman/) | simple | 9072, 9075, 9074, 9073, 357 | Yes | No |
| 9076 | [Christmas Table Decor – Holiday Tree](https://bhcrafts.shop/product/christmas-table-decor-holiday-tree/) | simple | 9078, 9080, 9079, 357 | Yes | No |
| 9135 | [Handcrafted Holiday Stocking With Snowflakes](https://bhcrafts.shop/product/handcrafted-holiday-stocking-with-snowflakes/) | simple | 9089, 9092, 9090, 9091, 9088, 358 | Yes | No |
| 9136 | [Handmade Christmas Stocking With Big Snowflakes](https://bhcrafts.shop/product/handmade-christmas-stocking-with-big-snowflakes/) | simple | 9096, 9095, 9094, 9093, 9097, 358 | Yes | No |
| 9137 | [Artisan Made Christmas Holiday Stocking – Traditional](https://bhcrafts.shop/product/artisan-made-christmas-holiday-stocking-traditional/) | simple | 9109, 9112, 9111, 9110, 9108, 358 | Yes | No |
| 9142 | [Christmas Stocking – Artisans Made](https://bhcrafts.shop/product/christmas-stocking-artisans-made/) | simple | 9098, 9099, 9101, 9100, 9102, 358 | Yes | No |
| 9143 | [Christmas Stocking – Artisans Handmade](https://bhcrafts.shop/product/christmas-stocking-artisans-handmade/) | simple | 9104, 9105, 9107, 9106, 9103, 358 | Yes | No |
| 9144 | [Christmas Stocking With Christmas Tree Design](https://bhcrafts.shop/product/christmas-stocking-with-christmas-tree-design/) | simple | 9121, 9120, 9119, 9118, 9122, 358 | Yes | No |
| 9145 | [Handmade Red Christmas Stocking With Snowflakes](https://bhcrafts.shop/product/red-christmas-stocking-with-snowflakes/) | simple | 9113, 9114, 9115, 9116, 9117, 358 | Yes | No |
| 9147 | [Black and White Christmas Stocking](https://bhcrafts.shop/product/black-and-white-christmas-stocking/) | simple | 9149, 9150, 9152, 9151, 9148, 358 | Yes | No |
| 9153 | [Red Traditional Christmas Stocking](https://bhcrafts.shop/product/red-traditional-christmas-stocking/) | simple | 9154, 9155, 9156, 9157, 358 | Yes | No |
| 9159 | [Christmas Stocking with Colorful Stripes](https://bhcrafts.shop/product/christmas-stocking-with-colorful-stripes/) | simple | 9131, 9129, 9130, 9132, 358 | Yes | No |
| 9167 | [Holiday Stocking with Stripes & Colorful Pom-Poms](https://bhcrafts.shop/product/holiday-stocking-with-stripes-colorful-pom-poms/) | simple | 9123, 9127, 9124, 9126, 9125, 358 | Yes | No |
| 9173 | [Hand Crocheted Hat with Starfish](https://bhcrafts.shop/product/hand-crocheted-hat-with-starfish/) | simple | 9172, 9171, 9170, 9169, 357 | No | No |
| 9179 | [Hand Crocheted Linen Hat – Patchwork](https://bhcrafts.shop/product/hand-crocheted-linen-hat-patchwork/) | simple | 9176, 9175, 9178, 9177, 357 | No | No |
| 9184 | [Hand Crocheted Stylish French Beret](https://bhcrafts.shop/product/hand-crocheted-stylish-french-beret/) | simple | 9180, 9182, 9181, 9183, 357 | No | No |
| 9234 | [Knitted Girls Dress with Matching Purse](https://bhcrafts.shop/product/knitted-girls-dress-with-matching-purse/) | variable | 9185, 9186, 9187, 9191, 9190, 9189, 9188, 357 | No | No |
| 9242 | [Handmade Kids French Beret](https://bhcrafts.shop/product/handmade-kids-french-beret/) | variable | 9198, 9199, 9201, 9200, 9202, 357 | No | No |
| 9244 | [Hand crocheted Patchwork Kids Hat](https://bhcrafts.shop/product/hand-crocheted-kids-hat/) | variable | 9210, 9208, 9211, 9209, 357 | No | No |
| 9247 | [Hand crocheted Colorful Kids Hat](https://bhcrafts.shop/product/hand-crocheted-colorful-kids-hat/) | variable | 9205, 9203, 9204, 9207, 9206, 357 | No | No |
| 9249 | [Girls Dress with Matching Cap “Tasla”](https://bhcrafts.shop/product/girls-dress-with-matching-cap-pipi/) | variable | 9212, 357 | No | No |
| 9259 | [Boys Sweater with Matching Cap – Cars](https://bhcrafts.shop/product/boys-sweater-with-matching-cap-cars/) | variable | 9217, 9218, 9216, 357 | No | No |
| 9269 | [Hand-Crocheted Cotton Baby Booties](https://bhcrafts.shop/product/hand-crocheted-cotton-baby-booties/) | variable | 9226, 9228, 9225, 9230, 9229, 9227, 357 | Yes | Yes |
| 9276 | [Handmade purse and/or wallet](https://bhcrafts.shop/product/handmade-purse-and-or-wallet/) | variable | 9220, 9222, 9224, 9223, 9221, 357 | No | No |
| 9307 | [Set of 5 Handmade Christmas Stockings](https://bhcrafts.shop/product/set-of-5-handmade-christmas-stockings/) | simple | 9302, 9124, 9157, 9097, 9132, 7464, 358 | Yes | No |
| 9308 | [Handmade Crochet Sheep Soft Toy](https://bhcrafts.shop/product/handmade-crochet-sheep-soft-toy/) | variable | 9298, 9300, 9299, 9301, 357 | Yes | No |
| 9311 | [Hand Knit Girl’s Cotton Hat](https://bhcrafts.shop/product/hand-knit-cotton-hat/) | variable | 9288, 9289, 9287, 9286, 9285, 9284, 357 | No | No |
| 9342 | [Women Summer Crochet Blouse Starfish](https://bhcrafts.shop/product/women-summer-crochet-blouse-starfish/) | simple | 9361, 9365, 9364, 9363, 9362, 357 | No | No |
| 9344 | [Handmade Crochet Net Blouse for Women](https://bhcrafts.shop/product/handmade-crochet-net-blouse-for-women/) | simple | 9337, 9339, 9338, 9336, 9340, 9335, 9334, 357 | No | No |
| 9345 | [Women Summer Crochet Blouse](https://bhcrafts.shop/product/women-summer-crochet-blouse-2/) | simple | 9330, 9333, 9332, 9331, 357 | No | No |
| 9346 | [Handmade Knitted Christmas Tree Skirt](https://bhcrafts.shop/product/handmade-knitted-christmas-tree-skirt/) | simple | 9347, 9351, 9352, 9348, 9350, 9349, 358 | Yes | No |
| 9382 | [Women Summer Handmade Blouse](https://bhcrafts.shop/product/women-summer-handmade-blouse/) | simple | 9369, 9367, 9368, 9366, 357 | No | No |
| 9384 | [Hand Crochet Net Blouse for Women](https://bhcrafts.shop/product/hand-crochet-net-blouse-for-women/) | simple | 9371, 9373, 9372, 9370, 357 | No | No |
| 9385 | [Women Summer Crochet Blouse](https://bhcrafts.shop/product/women-summer-crochet-blouse/) | simple | 9325, 9328, 9329, 9327, 9326, 357 | No | No |
| 9386 | [Handmade Christmas Tree Skirt with Snowmen and Reindeer](https://bhcrafts.shop/product/handmade-christmas-tree-skirt-with-snowmen-and-reindeer/) | simple | 9357, 9360, 9358, 9359, 9356, 358 | Yes | No |
| 9412 | [Hand Knit Boy’s Cotton Hat](https://bhcrafts.shop/product/hand-knit-boys-cotton-hat/) | variable | 9407, 9411, 9408, 9409, 9410, 357 | No | No |
| 9415 | [Hand Knitted Girl’s Colorful Kids Hat](https://bhcrafts.shop/product/hand-knitted-girls-colorful-kids-hat/) | variable | 9389, 9390, 9396, 9395, 9394, 9393, 9392, 9391, 357 | No | No |
| 9417 | [Hand Knitted Boy’s Colorful Kids Hat](https://bhcrafts.shop/product/hand-knitted-boys-colorful-kids-hat/) | variable | 9403, 9403, 9402, 9406, 9404, 357 | No | No |
| 9419 | [Hand Knitted Babies Colorful Hat](https://bhcrafts.shop/product/hand-knitted-babies-colorful-hat/) | variable | 9397, 9400, 9401, 9399, 9398, 357 | No | No |
| 9436 | [Custom order – Rachael](https://bhcrafts.shop/product/custom-order-rachael/) | simple | 9510, 4623, 9504, 9505, 9506, 9507 | No | No |
| 9491 | [Bundle of 5 Christmas Stockings – Snowmen](https://bhcrafts.shop/product/bundle-of-5-christmas-stockings-snowmen/) | simple | 9489, 624, 623, 358 | Yes | No |
| 9515 | [Custom order – Jes MaHarry](https://bhcrafts.shop/product/custom-order-jes-maharry/) | simple | None returned | No | No |
| 9544 | [Custom order – Oso&Me – 30% Advance](https://bhcrafts.shop/product/custom-order-osome-50-advance/) | simple | 8817, 8858, 8862, 8811 | No | No |
| 9785 | [Custom order – Oso&Me – rest of the payments](https://bhcrafts.shop/product/custom-order-osome/) | simple | 8817, 8858, 8862, 8811 | No | No |
| 9844 | [Custom order](https://bhcrafts.shop/product/custom-order-sw/) | simple | None returned | No | No |
| 10005 | [Hand-Knitted Christmas Stockings, set of 5 + Recycled Coffee Bag Tote](https://bhcrafts.shop/product/hand-knitted-christmas-stockings-set-of-5/) | simple | 10006, 4716, 9157, 4631, 7474, 4646, 358 | Yes | No |
| 10022 | [Handmade Christmas Stockings on Sale – Set of 5 + Jute Tote](https://bhcrafts.shop/product/handmade-christmas-stockings-on-sale-set-of-5-jute-tote/) | simple | 10021, 4716, 9157, 4631, 7474, 4646, 358 | Yes | No |
| 10112 | [Long Slipper Socks – Hand-Knitted Bosnian Wool Socks](https://bhcrafts.shop/product/long-slipper-socks-hand-knitted-bosnian-wool-socks/) | variable | 10120, 10118, 10119, 10121, 357 | Yes | Yes |
| 10130 | [Long Slipper Socks – Handmade Bosnian Wool Socks](https://bhcrafts.shop/product/long-slipper-socks-handmade-bosnian-wool-socks/) | variable | 10125, 10124, 10122, 10123, 357 | Yes | Yes |
| 10132 | [Long Slipper Socks – Handcrafted Bosnian Wool Socks](https://bhcrafts.shop/product/long-slipper-socks-handcrafted-bosnian-wool-socks/) | variable | 10126, 10129, 10127, 10128, 357 | Yes | Yes |
| 10360 | [Set of 5 Hand-Knit Christmas Stockings + Jute Tote](https://bhcrafts.shop/product/set-of-5-hand-knit-christmas-stockings-jute-tote/) | simple | 10363, 9121, 627, 6139, 6140, 6299, 358 | Yes | No |

## Appendix C. Shared gallery attachment references

Coverage is limited to product image arrays returned by the public Store API. It excludes embedded description images unless they also appear in those arrays, variation-specific images not returned with parents, private/hidden products, posts, pages, UX Blocks, options, custom tables and off-site use. No attachment below is cleared for editing, deletion or duplication.

| Attachment ID | Distinct public products | Referencing product IDs |
| --- | --- | --- |
| 357 | 234 | 89, 714, 791, 806, 819, 832, 845, 858, 868, 880, 885, 890, 945, 988, 1004, 1192, 1261, 1270, 1279, 1288, 1297, 1306, 1372, 1382, 2056, 2242, 2324, 2325, 2336, 2341, 2347, 2355, 2362, 2375, 2378, 2379, 2554, 2568, 2573, 2595, 2596, 2602, 2606, 2608, 2614, 2620, 2627, 2637, 2645, 2650, 2655, 2659, 2679, 2687, 2696, 2698, 2701, 2704, 2706, 2709, 2716, 2761, 2798, 2819, 2820, 2822, 2824, 2829, 2839, 2850, 2900, 2924, 2938, 2941, 2958, 2963, 2970, 2977, 2978, 2982, 2985, 2991, 3022, 3026, 3029, 3033, 3037, 3041, 3054, 3083, 3084, 3086, 3087, 3088, 3089, 3314, 3449, 3639, 3643, 3645, 3649, 3653, 3654, 3702, 3705, 3707, 3728, 3730, 3790, 4195, 4196, 4197, 4198, 4228, 4734, 4754, 4986, 4987, 4988, 4989, 4991, 4992, 4993, 4994, 4995, 4996, 4997, 4998, 4999, 5002, 5003, 5004, 5005, 5006, 5007, 5008, 5009, 5010, 5011, 5012, 5020, 5021, 5022, 5023, 5024, 5025, 5140, 5141, 5142, 5143, 5149, 5419, 5420, 5421, 5422, 5425, 5426, 5458, 5461, 5465, 5467, 5470, 5473, 5476, 5555, 5556, 5557, 5581, 5600, 5651, 5657, 5670, 5741, 5747, 5749, 5778, 5840, 5843, 5870, 5873, 5875, 6216, 6222, 6225, 6229, 6233, 6236, 6239, 6243, 6246, 8975, 8976, 8978, 8982, 8988, 8998, 9017, 9022, 9023, 9034, 9035, 9048, 9053, 9059, 9063, 9066, 9069, 9076, 9173, 9179, 9184, 9234, 9242, 9244, 9247, 9249, 9259, 9269, 9276, 9308, 9311, 9342, 9344, 9345, 9382, 9384, 9385, 9412, 9415, 9417, 9419, 10112, 10130, 10132 |
| 445 | 234 | 59, 64, 67, 71, 80, 89, 593, 595, 622, 629, 630, 643, 655, 658, 669, 714, 819, 845, 858, 868, 880, 885, 890, 945, 988, 1004, 1192, 1261, 1270, 1279, 1288, 1297, 1306, 1372, 1382, 2056, 2242, 2324, 2325, 2336, 2341, 2347, 2355, 2362, 2375, 2378, 2379, 2554, 2568, 2573, 2595, 2596, 2602, 2606, 2608, 2614, 2620, 2627, 2637, 2645, 2650, 2655, 2659, 2679, 2687, 2696, 2698, 2701, 2704, 2706, 2709, 2716, 2761, 2798, 2819, 2820, 2822, 2824, 2829, 2839, 2850, 2900, 2924, 2938, 2941, 2958, 2963, 2970, 2977, 2978, 2982, 2985, 2991, 3022, 3026, 3029, 3033, 3037, 3041, 3054, 3083, 3084, 3086, 3087, 3088, 3089, 3175, 3217, 3248, 3295, 3314, 3449, 3639, 3643, 3645, 3649, 3653, 3654, 3702, 3705, 3707, 3728, 3730, 3790, 3858, 3863, 4195, 4196, 4197, 4198, 4228, 4614, 4665, 4668, 4669, 4671, 4688, 4714, 4717, 4719, 4734, 4754, 4986, 4987, 4988, 4989, 4991, 4992, 4993, 4994, 4995, 4996, 4997, 4998, 4999, 5002, 5003, 5004, 5005, 5006, 5007, 5008, 5009, 5010, 5011, 5012, 5020, 5021, 5022, 5023, 5024, 5025, 5140, 5141, 5142, 5143, 5144, 5149, 5419, 5420, 5421, 5422, 5425, 5426, 5458, 5461, 5465, 5467, 5470, 5473, 5476, 5555, 5556, 5557, 5600, 5651, 5657, 5670, 5741, 5747, 5749, 5778, 5840, 5843, 5870, 5873, 5875, 6066, 6069, 6071, 6072, 6107, 6190, 6192, 6193, 6194, 6196, 6198, 6215, 6216, 6222, 6225, 6229, 6233, 6236, 6239, 6243, 6246, 6274, 6281, 6297, 6452, 6889, 7405 |
| 358 | 114 | 59, 64, 67, 71, 80, 593, 595, 596, 604, 609, 616, 619, 622, 629, 630, 633, 642, 643, 645, 646, 649, 652, 655, 658, 662, 669, 3162, 3175, 3217, 3246, 3247, 3248, 3295, 3326, 3858, 3863, 3867, 3869, 4614, 4665, 4668, 4669, 4671, 4688, 4714, 4717, 4719, 5144, 6066, 6069, 6071, 6072, 6107, 6190, 6192, 6193, 6194, 6196, 6198, 6215, 6274, 6281, 6297, 6452, 6889, 7405, 7428, 7430, 7499, 7510, 7512, 7514, 7518, 7520, 7522, 7524, 7528, 7580, 7587, 7635, 7689, 8152, 8168, 8268, 8269, 8281, 8283, 8296, 8297, 8305, 8430, 8439, 8460, 8465, 8469, 8923, 9135, 9136, 9137, 9142, 9143, 9144, 9145, 9147, 9153, 9159, 9167, 9307, 9346, 9386, 9491, 10005, 10022, 10360 |
| 446 | 30 | 59, 64, 67, 71, 593, 595, 609, 616, 619, 622, 629, 630, 633, 643, 646, 649, 652, 655, 662, 3248, 3858, 3867, 3869, 4665, 4671, 4688, 4714, 4717, 4719, 8923 |
| 534 | 28 | 64, 67, 71, 593, 609, 616, 619, 633, 643, 646, 649, 652, 655, 662, 3246, 3247, 3248, 3326, 3858, 3867, 3869, 4665, 4671, 4688, 4714, 4717, 4719, 8923 |
| 6205 | 6 | 6229, 6233, 6236, 6239, 6243, 6246 |
| 5431 | 5 | 5465, 5467, 5470, 5473, 5476 |
| 4841 | 4 | 4986, 4987, 4988, 4989 |
| 4843 | 4 | 4986, 4987, 4988, 4989 |
| 4844 | 4 | 4991, 4992, 4993, 4994 |
| 4845 | 4 | 4991, 4992, 4993, 4994 |
| 6299 | 4 | 6297, 7580, 8909, 10360 |
| 8811 | 4 | 646, 8886, 9544, 9785 |
| 8817 | 4 | 3326, 8902, 9544, 9785 |
| 8839 | 4 | 604, 3246, 8897, 8898 |
| 8858 | 4 | 609, 8879, 9544, 9785 |
| 8862 | 4 | 662, 8788, 9544, 9785 |
| 9157 | 4 | 9153, 9307, 10005, 10022 |
| 4631 | 3 | 4671, 10005, 10022 |
| 4641 | 3 | 4669, 7587, 8903 |
| 4646 | 3 | 4668, 10005, 10022 |
| 4716 | 3 | 4714, 10005, 10022 |
| 4890 | 3 | 5002, 5003, 5004 |
| 4948 | 3 | 5021, 5022, 5023 |
| 4962 | 3 | 4195, 4196, 4198 |
| 6115 | 3 | 6190, 7587, 8904 |
| 6139 | 3 | 6107, 7580, 10360 |
| 6140 | 3 | 6194, 7580, 10360 |
| 7470 | 3 | 7510, 7587, 8910 |
| 7474 | 3 | 7512, 10005, 10022 |
| 9121 | 3 | 7580, 9144, 10360 |
| 365 | 2 | 7405, 7430 |
| 386 | 2 | 593, 7430 |
| 623 | 2 | 622, 9491 |
| 624 | 2 | 622, 9491 |
| 627 | 2 | 629, 10360 |
| 2309 | 2 | 2481, 2596 |
| 3023 | 2 | 3022, 3089 |
| 3024 | 2 | 3022, 3089 |
| 3025 | 2 | 3022, 3089 |
| 3027 | 2 | 3026, 3088 |
| 3028 | 2 | 3026, 3088 |
| 3030 | 2 | 3029, 3087 |
| 3031 | 2 | 3029, 3087 |
| 3032 | 2 | 3029, 3087 |
| 3034 | 2 | 3033, 3086 |
| 3035 | 2 | 3033, 3086 |
| 3036 | 2 | 3033, 3086 |
| 3038 | 2 | 3037, 3084 |
| 3039 | 2 | 3037, 3084 |
| 3040 | 2 | 3037, 3084 |
| 3042 | 2 | 3041, 3083 |
| 3043 | 2 | 3041, 3083 |
| 3044 | 2 | 3041, 3083 |
| 3815 | 2 | 3858, 7430 |
| 4623 | 2 | 4668, 9436 |
| 4625 | 2 | 4669, 8903 |
| 4642 | 2 | 4669, 8903 |
| 4644 | 2 | 4669, 8903 |
| 4645 | 2 | 4669, 8903 |
| 4701 | 2 | 4717, 7430 |
| 4870 | 2 | 5005, 5006 |
| 4909 | 2 | 5008, 5009 |
| 6054 | 2 | 6069, 7587 |
| 6112 | 2 | 6190, 8904 |
| 6114 | 2 | 6190, 8904 |
| 6119 | 2 | 6196, 8908 |
| 6123 | 2 | 6196, 8908 |
| 6132 | 2 | 6193, 7580 |
| 6148 | 2 | 6196, 8908 |
| 6166 | 2 | 6216, 6246 |
| 6168 | 2 | 6216, 6246 |
| 6180 | 2 | 6225, 6246 |
| 6187 | 2 | 6222, 6246 |
| 6207 | 2 | 6233, 6246 |
| 6208 | 2 | 6236, 6246 |
| 6210 | 2 | 6229, 6246 |
| 6211 | 2 | 6239, 6246 |
| 6212 | 2 | 6239, 6246 |
| 6213 | 2 | 6243, 6246 |
| 6214 | 2 | 6243, 6246 |
| 6263 | 2 | 6452, 8906 |
| 6264 | 2 | 6452, 8906 |
| 6266 | 2 | 6452, 8906 |
| 6267 | 2 | 6452, 8906 |
| 6300 | 2 | 6297, 8909 |
| 6302 | 2 | 6297, 8909 |
| 6304 | 2 | 6297, 8909 |
| 6306 | 2 | 6192, 8905 |
| 6308 | 2 | 6192, 8905 |
| 6309 | 2 | 6192, 8905 |
| 6310 | 2 | 6192, 8905 |
| 6880 | 2 | 6889, 8281 |
| 7464 | 2 | 7499, 9307 |
| 7471 | 2 | 7510, 8910 |
| 7472 | 2 | 7510, 8910 |
| 7473 | 2 | 7510, 8910 |
| 7478 | 2 | 7514, 8911 |
| 7479 | 2 | 7514, 8911 |
| 7480 | 2 | 7514, 8911 |
| 7481 | 2 | 7514, 8911 |
| 7486 | 2 | 7520, 8912 |
| 7487 | 2 | 7520, 8912 |
| 7488 | 2 | 7520, 8912 |
| 7489 | 2 | 7520, 8912 |
| 8156 | 2 | 8152, 8469 |
| 8158 | 2 | 8152, 8469 |
| 8423 | 2 | 8305, 8439 |
| 8424 | 2 | 8305, 8465 |
| 8808 | 2 | 646, 8886 |
| 8809 | 2 | 646, 8886 |
| 8810 | 2 | 646, 8886 |
| 8812 | 2 | 649, 8895 |
| 8813 | 2 | 649, 8895 |
| 8814 | 2 | 649, 8895 |
| 8815 | 2 | 649, 8895 |
| 8816 | 2 | 3326, 8902 |
| 8818 | 2 | 3326, 8902 |
| 8819 | 2 | 3326, 8902 |
| 8820 | 2 | 645, 8901 |
| 8821 | 2 | 645, 8901 |
| 8822 | 2 | 645, 8901 |
| 8823 | 2 | 645, 8901 |
| 8824 | 2 | 619, 8885 |
| 8825 | 2 | 619, 8885 |
| 8826 | 2 | 619, 8885 |
| 8827 | 2 | 619, 8885 |
| 8828 | 2 | 652, 8797 |
| 8829 | 2 | 652, 8797 |
| 8830 | 2 | 652, 8797 |
| 8831 | 2 | 652, 8797 |
| 8832 | 2 | 616, 8877 |
| 8833 | 2 | 616, 8877 |
| 8834 | 2 | 616, 8877 |
| 8835 | 2 | 616, 8877 |
| 8836 | 2 | 3246, 8898 |
| 8837 | 2 | 3246, 8898 |
| 8838 | 2 | 3246, 8898 |
| 8840 | 2 | 604, 8897 |
| 8841 | 2 | 604, 8897 |
| 8842 | 2 | 604, 8897 |
| 8843 | 2 | 3247, 8900 |
| 8844 | 2 | 3247, 8900 |
| 8845 | 2 | 3247, 8900 |
| 8846 | 2 | 3247, 8900 |
| 8847 | 2 | 642, 8899 |
| 8848 | 2 | 642, 8899 |
| 8849 | 2 | 642, 8899 |
| 8850 | 2 | 642, 8899 |
| 8851 | 2 | 633, 8894 |
| 8852 | 2 | 633, 8894 |
| 8854 | 2 | 633, 8894 |
| 8855 | 2 | 609, 8879 |
| 8856 | 2 | 609, 8879 |
| 8857 | 2 | 609, 8879 |
| 8859 | 2 | 662, 8788 |
| 8860 | 2 | 662, 8788 |
| 8861 | 2 | 662, 8788 |
| 8863 | 2 | 596, 8896 |
| 8864 | 2 | 596, 8896 |
| 8865 | 2 | 596, 8896 |
| 8866 | 2 | 596, 8896 |
| 9097 | 2 | 9136, 9307 |
| 9117 | 2 | 7587, 9145 |
| 9124 | 2 | 9167, 9307 |
| 9132 | 2 | 9159, 9307 |
