# BHcrafts staging public-access check

Date: 10 November 2026, Europe/Sarajevo.

User-supplied target: https://stg-bhcraftsshop-affiliate.kinsta.cloud/

## Observed results

| Check | Result |
| --- | --- |
| Homepage | HTTP 200. Final URL remains on the staging host. |
| REST index | HTTP 200. Returned Home and Site URLs match the supplied staging host. |
| Search indexing directives | Homepage returns X-Robots-Tag: noindex, nofollow, nosnippet, noarchive and a noindex, nofollow robots meta tag. This records directives, not a search-engine index check. |
| Public product endpoint | HTTP 200. X-WP-Total reports 378 products. Only one record was sampled in this pass. |
| Public media endpoint | HTTP 200. X-WP-Total reports 2,439 media records. Only one ID was sampled. |
| Administrative products without credentials | HTTP 401, woocommerce_rest_cannot_view. No credentials were used. |
| API registration | wp/v2, wc/v3, wc/store/v1 and yoast/v1 are advertised. |
| Application Passwords | A staging authorization URL is advertised. Successful authenticated access has not been tested. |
| Theme asset hint | Several Flatsome chunk URLs report ver=3.20.11. An authenticated version report remains necessary. |

## Comparison with prior live discovery

The live public inventory reported 382 storefront products and 2,503 media records earlier on the same date. The staging responses report four fewer products and 64 fewer media records. These counts do not establish which records differ, the clone date, or whether the differences are intentional. No staging refresh, database push or synchronization was performed or requested.

These public checks preceded the user's installation and execution of diagnostics 0.1.0. The user later selected staging product 2839 for inspection and drafting. The cloud task has made no WordPress content or settings writes and has used no computer-use tools. Version 0.2.0 is prepared but has not been installed by the cloud task.

## Next dependency

An authenticated read-only environment report is needed to verify actual installed versions. The included diagnostics plugin provides a manual administrator export without asking for credentials in chat. It does not provide a persistent cloud connection.

A later integration still needs an approved secure connection method, separate staging/production credentials and exact approval enforcement. Do not send passwords or API keys in a chat message.

## Evidence URLs

All requests used GET:

- https://stg-bhcraftsshop-affiliate.kinsta.cloud/
- https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-json/
- https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-json/wc/store/v1/products?per_page=1
- https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-json/wc/v3/products?per_page=1&_fields=id
- https://stg-bhcraftsshop-affiliate.kinsta.cloud/wp-json/wp/v2/media?per_page=1&_fields=id
