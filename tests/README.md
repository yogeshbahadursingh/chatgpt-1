# Isolated QA harness

These tests create demo records and local test orders. Run only on a disposable WordPress database, never production.

The original working directory is ppt-wordpress/ within its parent workspace. JavaScript scripts run from that parent and expect Playwright installed there and Chromium available. accessibility.cjs additionally expects axe-core in ppt-wordpress/runtime/qa-deps/node_modules. The HTTP origin is 127.0.0.1:8877. PHP tests run using WP-CLI eval-file against runtime/reinstall/wordpress. Output JSON is written to runtime/. Adapt paths and origin together for another environment.

Prerequisites: install the release ZIPs, activate PPT Core and the theme, run PPT_Site_Setup::run() as an administrator, activate WooCommerce, rerun setup, then PPT_Demo_Importer::import_all() as an administrator. Set the local store to visible. Intercept wp_mail and external HTTP requests in a local-only mu-plugin before executing tests. Do not distribute that plugin or the database.

Release 2.3.2 defaults demonstration products to preview-only. Run `demo-commerce.php` and `demo-commerce-browser.cjs` first with production/default configuration to check denial. The browser guard script runs from the ppt-wordpress directory; the other existing browser scripts run from its parent. For the integration/checkout tests only, set `WP_ENVIRONMENT_TYPE` to `local` and `PPT_ALLOW_DEMO_PURCHASES` to boolean true in the isolated wp-config.php. These settings must never reach production. The guard suite also checks a production opt-in remains denied and a staging opt-in is allowed using process-only WP-CLI bootstrap definitions.

Regression coverage added after the live audit: frontpage-repair, setup-repair, screenshot-repair, premium-navigation, journey-repair, research-filters/editor, archive-journeys (temporary pagination records and per-request Woo-disabled fallback), schema, publication actions, and shared-store visibility. Run mutating fixture suites sequentially and confirm cleanup before generating the route list. build-release.ps1 lints PHP, builds both package roots and records ZIP hashes. Historical patch/diagnostic scripts are not part of the acceptance suite.

Order: integration.php (configures isolated GBP shipping/test bank transfer and creates commerce fixtures), routes.php, content.php; then crawl.cjs, browser-commerce.cjs, interactions.cjs, responsive.cjs, accessibility.cjs, navigation.cjs and performance-seo.cjs. Browser checkout completes a free order only; it makes no real payment.

The route audit's observed template header comes from a local-only mu-plugin using a late template_include filter; it is absent from release source. Runtime JSON contains local URLs and test order IDs and is intentionally excluded from Git. Summaries are published in docs/QA-REPORT.md and docs/ROUTE-AUDIT.md.
