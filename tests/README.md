# Isolated QA harness

## Current 2.4.0 acceptance

Use the `cx-*` suites for current customer-experience behaviour. Run only one browser suite at a time. The older `content.php`, `schema.php`, `schema-http.cjs`, `interactions.cjs` and original `browser-commerce.cjs` expectations belong to 2.3.2: they assume future demonstration events, specialist schema on demos, a timed intro or the old enquiry redirect. They are retained as historical evidence and are **not** the 2.4.0 acceptance entry points.

1. Back up the isolated installation, install both final ZIPs, capture `cx-inventory.php` **before** applying the Experience Update, and generate `routes.php`. Do not overwrite the before inventory on a later verification run.
2. Run `cx-enquiries.php` and `cx-discovery.php` with WP-CLI. `cx-commerce.cjs` creates and removes its own products/orders; existing demo commerce fixtures and intercepted mail are prerequisites.
3. Run `cx-browser-fixtures.php` in its default prepare mode; then run `cx-browser.cjs` and `cx-editor.cjs` from the parent workspace. Always finish with `cx-browser-fixtures.php` using `PPT_CX_MODE=cleanup`. The private JSON/session file stays in ignored runtime. The frontend suite and editor suite are separate so authentication failures cannot mask visitor journey results.
4. Run `cx-purchase.cjs` (requires the isolated offline BACS method), `cx-editability.cjs`, `cx-contents.cjs`, `cx-nav-auth.cjs`, `premium-navigation.cjs`, `cx-routes.cjs`, `cx-responsive.cjs`, `cx-followup.cjs`, `cx-recovery.cjs`, `cx-schema.cjs`, `archive-journeys.cjs`, `research-filters.cjs` and `security.cjs`. Prepare read-only research-filter reference JSON with `research-filter-fixtures.php` first. Mutating fixture suites restore only their owned records or exact saved field values.
5. Run `cx-observe.cjs before` before editing and `cx-observe.cjs after` after the final candidate, without other active load tests. These are local lab observations, not field Core Web Vitals.
6. Run `build-release.ps1` and `verify-installed.ps1`. Publish an allowlist of sanitised JSON/screenshots to versioned docs evidence; never copy private session files, full override exports, mailboxes, configuration or the local database.

`cx-live.cjs` and `cx-live-retest.cjs` are separate read-only production observations. Do not repeatedly crawl an unhealthy host. The 2.4.0 live retest is already recorded; hosting logs/access are the next diagnostic step.

See the current QA report for initial failures, repairs, retest provenance and actual scope boundaries. Historical result files do not count as a new run.

## Historical 2.3.2 harness notes

These tests create demo records and local test orders. Run only on a disposable WordPress database, never production.

The original working directory is ppt-wordpress/ within its parent workspace. JavaScript scripts run from that parent and expect Playwright installed there and Chromium available. accessibility.cjs additionally expects axe-core in ppt-wordpress/runtime/qa-deps/node_modules. The HTTP origin is 127.0.0.1:8877. PHP tests run using WP-CLI eval-file against runtime/reinstall/wordpress. Output JSON is written to runtime/. Adapt paths and origin together for another environment.

Prerequisites: install the release ZIPs, activate PPT Core and the theme, run PPT_Site_Setup::run() as an administrator, activate WooCommerce, rerun setup, then PPT_Demo_Importer::import_all() as an administrator. Set the local store to visible. Intercept wp_mail and external HTTP requests in a local-only mu-plugin before executing tests. Do not distribute that plugin or the database.

Release 2.3.2 defaults demonstration products to preview-only. Run `demo-commerce.php` and `demo-commerce-browser.cjs` first with production/default configuration to check denial. The browser guard script runs from the ppt-wordpress directory; the other existing browser scripts run from its parent. For the integration/checkout tests only, set `WP_ENVIRONMENT_TYPE` to `local` and `PPT_ALLOW_DEMO_PURCHASES` to boolean true in the isolated wp-config.php. These settings must never reach production. The guard suite also checks a production opt-in remains denied and a staging opt-in is allowed using process-only WP-CLI bootstrap definitions.

Regression coverage added after the live audit: frontpage-repair, setup-repair, screenshot-repair, premium-navigation, journey-repair, research-filters/editor, archive-journeys (temporary pagination records and per-request Woo-disabled fallback), schema, publication actions, and shared-store visibility. Run mutating fixture suites sequentially and confirm cleanup before generating the route list. build-release.ps1 lints PHP, builds both package roots and records ZIP hashes. Historical patch/diagnostic scripts are not part of the acceptance suite.

Order: integration.php (configures isolated GBP shipping/test bank transfer and creates commerce fixtures), routes.php, content.php; then crawl.cjs, browser-commerce.cjs, interactions.cjs, responsive.cjs, accessibility.cjs, navigation.cjs and performance-seo.cjs. Browser checkout completes a free order only; it makes no real payment.

The route audit's observed template header comes from a local-only mu-plugin using a late template_include filter; it is absent from release source. Runtime JSON contains local URLs and test order IDs and is intentionally excluded from Git. Summaries are published in docs/QA-REPORT.md and docs/ROUTE-AUDIT.md.
