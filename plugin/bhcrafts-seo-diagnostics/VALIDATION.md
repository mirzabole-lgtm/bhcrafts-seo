# Validation record: 0.2.1

Date: 10 November 2026.
Execution: Background cloud PHP CLI 8.4.27, isolated WordPress/WooCommerce fixtures.

- Main plugin, product export and CLI test files: syntax passed.
- Policy/value checks: 62 passed.
- Product export handler: valid UTF-8 JSON, expected fixed product and image scope, no stderr.
- Absent versus empty Yoast values: retained distinctly.
- Duplicate metadata rows, Unicode, apostrophes and JSON string contents: retained.
- Wrong staging host, mixed Home/Site domains, HTTP, user-info URLs and unexpected ports: rejected.
- Missing administrator or object capability: rejected for product, variation and image.
- Wrong HTTP method, invalid nonce, environment-report nonce, query parameters and extra form fields: rejected.
- Reused product ID with a different slug/type, unrelated variation and excessive variation count: rejected.
- Unrelated metadata values and private registry defaults: excluded.
- Protected commercial values: represented only by selected-property hashes.
- Object metadata, unexpected scalar API output and oversized fields: rejected.
- Missing attachment: explicit preservation hold, with no substitute image.
- No plugin calls to content/option writers, deletion functions, remote HTTP, arbitrary shortcode execution, REST-route registration or activation jobs.

No actual WordPress site, product, media record, Yoast editor or staging plugin state was changed during these cloud tests. Real staging execution and save/indexation validation remain pending.

Regression: the authorized download test submits action, _wpnonce, _wp_http_referer and WordPress’s default submit field. Valid product JSON is returned. An array-valued submit field is rejected.
