# BHcrafts product 2839: read-only inspection and draft content pack

Checked: 10 November 2026, 15:31 CET
Draft: bhcrafts-stg-2839-draft-v0.1
Scope: Staging inspection and drafting. No staging or production content writes.
Product: [Knitted Bag with Three-Doll Applique](https://stg-bhcraftsshop-affiliate.kinsta.cloud/product/knit-handbag-with-dolls-applique/)

## 1. Inspection result

The supplied URL resolves to variable product **2839**, category **41: Bags, Purses & Wallets**. The rendered variation data exposes variation **2840**, with an empty Color attribute value and image **2841**. Black and Green appear as product options. Do not change this configuration or infer separate variation IDs for both colors.

All five product photographs, the two shared promotional images, and the embedded hang-tag photograph were downloaded and visually inspected. Image files were not edited, renamed on the site, regenerated or reassigned.

| Field | Observed evidence | Draft treatment |
| --- | --- | --- |
| Product name | Knitted Bag with Three-Doll Applique | Protected. Keep unchanged. |
| Material | Existing short description states 100% cotton | Use as a source-backed product fact. Composition was not inferred from photos. |
| Dimensions | Existing short description lists width 29 cm / 11.4 inches and height 46 cm / 18.1 inches | Retain listed values. Whether height includes handles and the internal dimensions remain unspecified. |
| Colors | Black and Green options, also visible in photographs | Retain options and assignments. |
| Visual design | Three raised doll appliqués, yarn hair, colorful outfits, flowers, dangling legs, striped handles | Use accurate image-specific descriptions. |
| Laptop fit | Existing short description claims laptop capacity | Omit from the new draft until internal dimensions or a suitable device size are confirmed. |
| Closure | A pink zipper pull is visible on the black version | Do not generalize closure details to all versions without confirmation. |
| Gift presentation | Existing long description states free recycled-paper wrapping and a customized postcard | Preserve as a listing-derived claim, subject to a fresh policy check before publication. |
| Certification link | Existing PDF URL includes 2014-16 | Preserve the existing link in the draft and flag its date. Do not describe it as a current certificate. |
| Personalization | Not established for this handbag | Add no name-embroidery, customization or made-to-order offer. The preserved brand paragraph remains visibly identified below. |

## 2. Current description and preservation issues

The long description contains Fair Trade and packaging text but little product-specific detail. It uses a Flatsome description accordion with ID **accordion-description-content**. The page has one H1.

The artisan image resolves to attachment **577**, source URL:

https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2020/10/artisan-handmade-tag.jpg

Its inline presentation uses a left-aligned image, a 120 px maximum width and margins. The embedded image has the hard-coded alt text **Tag**. Updating attachment metadata alone would not change this saved alt attribute.

The rendered description visibly contains the literal fragment `<style=”padding-left: 120px”>` before the artisan paragraph. This is escaped text rather than a valid style attribute. The draft proposes removing this fragment while retaining the actual image, its placement attributes and the uppercase artisan heading. This is a proposed description edit, not an applied repair.

### Existing artisan paragraph

> Lady whose name is written on the hang tag, made this product for you. Her knowledge, patience and love are knit into this product, which makes it unique and customs made. Helping one of hundreds of BHcrafts women producers to earn a living is added value to unique design and the best quality handmade product.

### Screenshot master proposed for review

> The woman named on the hang tag crafted this product especially for you. Additionally, with every stitch, she infused her knowledge, patience, and love, creating a truly unique and custom-made piece. By choosing this item, you support one of the hundreds of BHcrafts women artisans in earning a living, while enjoying its design and exceptional quality work.

These paragraphs differ. Replacing the existing paragraph requires visible review of this exact change. The master’s “custom-made” wording is preserved brand text. It must not be interpreted as a new customization service for the bag.

### Existing care paragraph

> Although all our products are made from the best quality materials we cannot guarantee they will not break unless you follow the care instructions. If you do, you will enjoy in this unique piece for a long time.

### Proposed product-specific care paragraph

> Care for the knitted fabric and doll details according to the product’s care guidance. Ask BHcrafts for any missing instructions before cleaning. Suitable care helps preserve the craftsmanship of your handmade cotton bag.

No washing temperature, drying method, machine-wash claim or warranty was inferred.

### Current long description from public Store API

This is the API-returned description, not an authenticated editor/raw-content baseline.

```html
<p>All BHcrafts products meet fair trade standards so we are proud to be guarantee Fair Trade Organization <a href="https://www.bhcrafts.org/pdf/WFTO_Certificate_2014-16.pdf" target="_blank" rel="noopener noreferrer">WFTO certificate</a></p>
<p>More details about our Fair Trade mission you may find at: <a href="https://www.bhcrafts.org" target="_blank" rel="noopener noreferrer">www.bhcrafts.org</a></p>
<p>Gift wrapping in eco friendly recycled paper and postcard with customized text is free of charge with any purchase.</p>
<p>Here you do not only buy you do &#8220;Shopping With Purpose&#8221;</p>
<p><strong>MORE INFORMATION ABOUT ARTISANS</strong><br />
<img style="margin: 5px 10px 0px 0px;max-width: 120px" src="https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2020/10/artisan-handmade-tag.jpg" alt="Tag" align="left" /> &lt;style=&#8221;padding-left: 120px&#8221;&gt; Lady whose name is written on the hang tag, made this product for you. Her knowledge, patience and love are knit into this product, which makes it unique and customs made. Helping one of hundreds of BHcrafts women producers to earn a living is added value to unique design and the best quality handmade product.<br />
Although all our products are made from the best quality materials we cannot guarantee they will not break unless you follow the care instructions. If you do, you will enjoy in this unique piece for a long time.</p>
```

## 3. Shared-image and variation safeguards

| Attachment | Role in this inspection | Detected public staging references | Treatment |
| --- | --- | --- | --- |
| 2841 | Featured photo and image assigned to observed variation 2840 | 1 product image array | Keep identity and assignments. Count does not rule out references outside public product arrays. |
| 2843 | Green doll detail | 1 product image array | Product-specific draft metadata. |
| 2844 | Black full view | 1 product image array | Product-specific draft metadata. |
| 2842 | Black doll detail | 1 product image array | Product-specific draft metadata. |
| 2845 | Black/green comparison | 1 product image array | The image is a comparison, not evidence of a two-bag bundle. |
| 445 | Gift-wrapping photograph | 234 product image arrays | Generic shared metadata. Hold for separate shared-effect approval. |
| 357 | Quantity discount graphic | 231 product image arrays | Describe the graphic accurately. Do not validate current cart rules from the image. |
| 577 | Embedded artisan tag | 367 product descriptions contain this URL | Generic artisan metadata. Do not invent a maker identity. Hold for separate shared-effect approval. |

The current parent image order is **2841, 2843, 2844, 2842, 2845, 445, 357**. Attachment 577 appears inside the description, outside that gallery sequence.

The reference pass covered 378 public staging products. It did not cover hidden/private products, all variation records, posts, pages, UX Blocks, templates, settings, custom tables or off-site use. Complete authenticated reference checks remain necessary before attachment writes. The machine-readable review includes every detected affected product ID and URL for the three shared attachments.

## 4. Proposed keyphrase package

These phrases are drafts based on product facts and image review. No search-volume or competition data is claimed. Stored Yoast focus phrases, synonyms and related phrases are unavailable without authenticated inspection. They must be read before preparing an apply-ready before/after comparison.

| Entry | Keyphrase | Synonyms | Intent |
| --- | --- | --- | --- |
| Primary | knitted cotton handbag | cotton knit handbag, knitted cotton bag | Product type and recorded material. |
| Related 1 | handmade cotton bag | handcrafted cotton bag, cotton bag made by hand | Material and handmade production. |
| Related 2 | doll appliqué bag | bag with doll appliqués, doll applique handbag | Distinctive decoration, including an unaccented spelling. |
| Related 3 | knitted handbag with dolls | knit bag with dolls, knitted doll handbag | Specific visual design. |
| Related 4 | fair trade handbag | fair trade bag, fairly traded handbag | BHcrafts Fair Trade context. Review overlap with other bags before applying. |

## 5. SEO title and meta description preview

| Field | Current rendered output | Proposed text |
| --- | --- | --- |
| SEO title | Knitted Bag with Three-Doll Applique - BHcrafts | Knitted Cotton Handbag with Doll Appliqué &#124; BHcrafts |
| Meta description | This unique handmade bag with its doll applique can be your ideal everyday bag. Made from 100% cotton, it is sure to withstand the daily stress of a busy lifestyle, and with its width of 29cm (11.4 inch) and a height of 46cm (18.1 inch), it can pack everything you may need for the day, including a laptop. | Choose a knitted cotton handbag with three doll appliqués and colorful striped handles. Available in black or green, handmade by BHcrafts women artisans. |

The current rendered meta description has 306 characters. The proposed title has 52 characters and the proposed meta description has 153. Counts are review aids. Fit in the installed Yoast preview remains untested.

The saved Yoast title/description fields might differ from these rendered outputs or use templates. The Yoast head API request for this staging URL returned HTTP 404 while the product page returned HTTP 200. No reindexing, editor save or settings change was attempted to alter this result.

## 6. Proposed short description

Current text:

> This unique handmade bag with its doll applique can be your ideal everyday bag. Made from 100% cotton, it is sure to withstand the daily stress of a busy lifestyle, and with its width of 29cm (11.4 inch) and a height of 46cm (18.1 inch), it can pack everything you may need for the day, including a laptop.

Proposed text, 53 words:

A knitted cotton handbag with three doll appliqués, colorful striped handles, and dangling doll legs. Made from 100% cotton, it is listed at 29 cm wide and 46 cm high. Choose a black or green background for an everyday bag with detailed handmade decoration. Created by BHcrafts women artisans in Bosnia and Herzegovina.

```html
<p>A knitted cotton handbag with three doll appliqués, colorful striped handles, and dangling doll legs. Made from 100% cotton, it is listed at 29 cm wide and 46 cm high. Choose a black or green background for an everyday bag with detailed handmade decoration. Created by BHcrafts women artisans in Bosnia and Herzegovina.</p>
```

## 7. Proposed complete long description

Draft length: approximately 310 words. This is a review draft, not a deployment payload. The exact saved editor markup must still be read and preservation-tested. The draft explicitly proposes the master-paragraph replacement, malformed-fragment removal, tag alt improvement, care paragraph revision and a product-appropriate closing section.

```html
<h2>Knitted cotton handbag with three doll appliqués</h2>
<p>Choose a knitted cotton handbag with colorful striped handles and three doll appliqués on the front. Made from 100% cotton, this BHcrafts design combines a knitted bag with detailed handmade decoration. Black and green versions give you two background colors for the doll design.</p>
<h2>Colorful details made by hand</h2>
<p>The three dolls have knitted outfits, yarn hair, smiling faces, and dangling legs. Flower details and bright stripes add color across the design. The full-view photographs show the bag’s proportions, while the close-ups reveal the doll outfits and knitted texture. The comparison photograph shows the black and green versions together.</p>
<h2>Product details</h2>
<ul>
<li>Material: 100% cotton.</li>
<li>Listed width: 29 cm (11.4 inches).</li>
<li>Listed height: 46 cm (18.1 inches).</li>
<li>Background colors: Black or Green.</li>
<li>Design: Three doll appliqués with colorful striped handles.</li>
</ul>
<p>Compare these listed measurements with the items you plan to carry. </p>
<h2>Carry handmade detail every day</h2>
<p>Choose your preferred color for everyday use, or give this handmade cotton bag as a gift. BHcrafts women artisans in Bosnia and Herzegovina bring their craft skills to the knitted fabric and decorative details.</p>
<p>Your purchase includes complimentary gift wrapping in recycled paper and a postcard with customized text. Read more about our Fair Trade mission at <a href="https://www.bhcrafts.org" target="_blank" rel="noopener noreferrer">www.bhcrafts.org</a> and view the <a href="https://www.bhcrafts.org/pdf/WFTO_Certificate_2014-16.pdf" target="_blank" rel="noopener noreferrer">WFTO certificate</a>.</p>
<p><strong>MORE INFORMATION ABOUT ARTISANS</strong><br />
<img style="margin: 5px 10px 0px 0px;max-width: 120px" src="https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2020/10/artisan-handmade-tag.jpg" alt="BHcrafts artisan hang tag with a handwritten maker field" align="left" /> The woman named on the hang tag crafted this product especially for you. Additionally, with every stitch, she infused her knowledge, patience, and love, creating a truly unique and custom-made piece. By choosing this item, you support one of the hundreds of BHcrafts women artisans in earning a living, while enjoying its design and exceptional quality work.<br />
Care for the knitted fabric and doll details according to the product’s care guidance. Ask BHcrafts for any missing instructions before cleaning. Suitable care helps preserve the craftsmanship of your handmade cotton bag.</p>
```

The image URL is staging-specific. A future production proposal must read the actual live description and attachment identity. Do not copy this staging URL into the live shop.

## 8. Image metadata proposals

All eight images were visually inspected. Current title, caption and description values below come from public **rendered** API fields, with generated attachment-image markup removed from the displayed description text. Their saved raw values remain unread. Current alt values are the API’s direct alt_text strings.

Captions are required. Keep the existing Flatsome caption-display setting and verify gallery/lightbox behavior during staging validation. No image binaries or assignments form part of these proposals.

### Attachment 2841: Green Knitted Cotton Handbag with Doll Appliqués | Full View

[View image](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2021/04/il_1140xn2467228434_lqp5.jpg)

Role: featured and variation image. Public staging reference count: 1.

| Field | Current public value | Proposed value |
| --- | --- | --- |
| Title | il_1140xN.2467228434_lqp5 | Green Knitted Cotton Handbag with Doll Appliqués &#124; Full View |
| Alt text | fair trade green knitted bag | Green knitted handbag held by its striped handles, with three doll appliqués and dangling legs |
| Caption | rainbow handle shoulder bag | Full view of the green bag with colorful handles and three doll appliqués. |
| Description | casual bag with doll applique | Front view of the green version of the knitted cotton handbag. A person holds the striped handles above three doll appliqués with knitted outfits, yarn hair, and dangling legs. |

Apply status: held pending raw-field baselines, complete reference coverage, preservation checks and explicit approval.

### Attachment 2843: Green Doll Appliqué Handbag | Front Detail

[View image](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2021/04/il_1140xn2467228784_fy0v.jpg)

Role: gallery position 1. Public staging reference count: 1.

| Field | Current public value | Proposed value |
| --- | --- | --- |
| Title | il_1140xN.2467228784_fy0v | Green Doll Appliqué Handbag &#124; Front Detail |
| Alt text | casual bag with doll applique | Close-up of three doll appliqués on a green knitted handbag, with yarn hair and flower details |
| Caption | fair trade green knitted bag | Close-up of the doll outfits, yarn hair, and flower details on the green bag. |
| Description | rainbow handle shoulder bag | Detail view of the three dolls on the green knitted bag. The photograph shows smiling faces, a green outfit, a striped outfit, a red outfit, yarn hair, and colorful flower details. |

Apply status: held pending raw-field baselines, complete reference coverage, preservation checks and explicit approval.

### Attachment 2844: Black Knitted Cotton Handbag with Doll Appliqués | Full View

[View image](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2021/04/il_1140xn2514906249_mp1w.jpg)

Role: gallery position 2. Public staging reference count: 1.

| Field | Current public value | Proposed value |
| --- | --- | --- |
| Title | il_1140xN.2514906249_mp1w | Black Knitted Cotton Handbag with Doll Appliqués &#124; Full View |
| Alt text | knit tote bag | Black knitted handbag with colorful striped handles, three doll appliqués, and dangling legs |
| Caption | fair trade black knitted bag | Full view of the black bag with striped handles and decorative dolls. |
| Description | eco friendly shoulder bag with applique | Front view of the black version of the knitted cotton handbag, held by a person. Three colorful doll appliqués extend down the bag, with cord-like legs and round knitted feet. |

Apply status: held pending raw-field baselines, complete reference coverage, preservation checks and explicit approval.

### Attachment 2842: Black Doll Appliqué Handbag | Front Detail

[View image](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2021/04/il_1140xn2467228766_2fyk.jpg)

Role: gallery position 3. Public staging reference count: 1.

| Field | Current public value | Proposed value |
| --- | --- | --- |
| Title | il_1140xN.2467228766_2fyk | Black Doll Appliqué Handbag &#124; Front Detail |
| Alt text | fair trade black knitted bag | Close-up of three doll appliqués on a black knitted handbag, with striped and flowered outfits |
| Caption | eco friendly shoulder bag with applique | Close-up of the handmade doll details against the black knitted fabric. |
| Description | knit tote bag | Close view of the dolls on the black knitted bag. The image highlights yarn hair, smiling faces, colorful knitted outfits, flower decorations, and the texture of the bag fabric. |

Apply status: held pending raw-field baselines, complete reference coverage, preservation checks and explicit approval.

### Attachment 2845: Doll Appliqué Knitted Handbag | Black and Green Comparison

[View image](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2021/04/il_1140xn2514906421_px7u.jpg)

Role: gallery position 4. Public staging reference count: 1.

| Field | Current public value | Proposed value |
| --- | --- | --- |
| Title | il_1140xN.2514906421_px7u | Doll Appliqué Knitted Handbag &#124; Black and Green Comparison |
| Alt text | knitted tote bag | Side-by-side photographs of black and green knitted handbags with striped handles and three doll appliqués |
| Caption | fair trade eco friendly shoulder bag | Black and green versions shown together for comparison. |
| Description | knit shoulder bag with doll applique | A two-panel comparison photograph shows the black bag on the left and the green bag on the right. Both versions have colorful striped handles and three doll appliqués. This comparison image does not indicate a two-bag bundle. |

Apply status: held pending raw-field baselines, complete reference coverage, preservation checks and explicit approval.

### Attachment 445: BHcrafts Gift Wrapping | Paper, Postcards and Flower Detail

[View image](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2020/10/eco-friendly-gift-wrapping.jpg)

Role: gallery position 5. Public staging reference count: 234.

| Field | Current public value | Proposed value |
| --- | --- | --- |
| Title | Eco-Friendly Gift Wrapping | BHcrafts Gift Wrapping &#124; Paper, Postcards and Flower Detail |
| Alt text | Eco-friendly gift wrapping with recycled paper and a customized postcard, free with any purchase. | Brown paper gift wrapping tied with raffia, decorated with two illustrated postcards and a red flower |
| Caption | Complimentary eco-friendly gift wrapping with recycled paper and a personalized postcard with every purchase. | Example of BHcrafts gift wrapping with postcards and a flower detail. |
| Description | Enhance your gift-giving experience with our complimentary eco-friendly gift wrapping, featuring recycled paper and a customized postcard, included free with every purchase. | A wrapped parcel in brown paper is tied with raffia and decorated with illustrated postcards and a red flower. This shared photograph illustrates BHcrafts gift presentation and does not show the handbag or establish the parcel’s contents. |

Apply status: held pending raw-field baselines, complete reference coverage, preservation checks and explicit approval.

### Attachment 357: BHcrafts Quantity Discount Chart

[View image](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2020/10/quantity-discount-offer.jpg)

Role: gallery position 6. Public staging reference count: 231.

| Field | Current public value | Proposed value |
| --- | --- | --- |
| Title | Quantity Discount Offer | BHcrafts Quantity Discount Chart |
| Alt text | Quantity discount chart offering up to 40% off for bulk purchases. | BHcrafts discount chart: 2 items 20%, 3 items 25%, 4 items 30%, 5 items 35%, and 6 items 40% off |
| Caption | Save up to 40% with our quantity discount on bulk purchases. | BHcrafts quantity discount graphic listing savings by item count. |
| Description | Take advantage of our quantity discount, offering up to 40% off when purchasing multiple items, making your holiday shopping more affordable. | The graphic lists 20% off 2 items, 25% off 3, 30% off 4, 35% off 5, and 40% off 6. It states the discount is calculated automatically in the shopping cart. BHcrafts and World Fair Trade Organization branding appear beside a decorative character. These are the graphic’s contents, not a live cart validation. |

Apply status: held pending raw-field baselines, complete reference coverage, preservation checks and explicit approval.

### Attachment 577: BHcrafts Artisan Hang Tag

[View image](https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-content/uploads/2020/10/artisan-handmade-tag.jpg)

Role: embedded artisan image. Public staging reference count: 367.

| Field | Current public value | Proposed value |
| --- | --- | --- |
| Title | Artisan Handmade Tag | BHcrafts Artisan Hang Tag |
| Alt text | Handmade tag with artisan's name, highlighting the unique craftsmanship behind the product. | BHcrafts artisan hang tag with a handwritten maker field, resting on knitted fabric |
| Caption | Each product comes with a handmade tag bearing the artisan’s name, emphasizing the unique craftsmanship. | The BHcrafts hang tag records the artisan behind a handmade item. |
| Description | Our products are accompanied by a handmade tag featuring the artisan’s name, underscoring the individual care and attention to detail invested in each piece. | A BHcrafts paper hang tag rests on knitted fabric. Its design includes the BHcrafts logo, a handmade-by field with handwriting, and the organization’s Bosnia and Herzegovina context. This shared brand image explains artisan identification. It does not identify the maker of this specific handbag. |

Apply status: held pending raw-field baselines, complete reference coverage, preservation checks and explicit approval.

## 9. Completion and next implementation work

Completed for this inspection: selected staging URL resolved to an exact ID, public description snapshots, visible attribute and variation observations, eight image inspections, tag attachment identification, public product reference checks, full content draft, five keyphrase/synonym entries, rendered SEO comparison and all four metadata proposals for all eight attachments.

Open: authenticated raw product/media baselines, saved Yoast values, installed Premium storage/save behavior, complete reference graph, protected-field snapshots, responsive layout/gallery validation, current gift policy and certificate-reference review, conflict detection and an operational approval mechanism.

The draft is not approval-eligible for application yet. Selecting this URL authorized inspection and preparation. It did not authorize a content write, metadata update or production pilot. No writes were made.

Next technical phase: build the narrow read-only bridge/export layer around this actual product and the recorded Yoast Premium 28.8 environment, then validate raw baselines and field representation before constructing any write adapter. Do not request or place credentials in chat. Keep all subsequent execution in the background.

## 10. Evidence and reproducibility

- Product record: https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-json/wc/store/v1/products?slug=knit-handbag-with-dolls-applique
- Product HTML: the user-supplied staging product URL.
- Gallery metadata: public WordPress media API for IDs 2841, 2843, 2844, 2842, 2845, 445 and 357.
- Tag identity: public media search matched the exact artisan-handmade-tag.jpg URL to ID 577.
- Shared references: four ascending-ID Store API pages covering 378 products at the check time.
- Yoast read attempt: /wp-json/yoast/v1/get_head with the staging product URL, HTTP 404.

The review JSON includes the proposal ID, frozen inspection IDs, source snapshots, attachment proposals, detected shared references, open limitations and a deterministic draft-content checksum. That checksum identifies a draft only. It is not human approval or an apply token.
