# Isolated QA harness

These tests create demo records and local test orders. Run only on a disposable WordPress database, never production.

The original working directory is ppt-wordpress/ within its parent workspace. JavaScript scripts run from that parent and expect Playwright installed there and Chromium available. accessibility.cjs additionally expects axe-core in ppt-wordpress/runtime/qa-deps/node_modules. The HTTP origin is 127.0.0.1:8877. PHP tests run using WP-CLI eval-file against runtime/reinstall/wordpress. Output JSON is written to runtime/. Adapt paths and origin together for another environment.

Prerequisites: install the release ZIPs, activate PPT Core and the theme, run PPT_Site_Setup::run() as an administrator, activate WooCommerce, rerun setup, then PPT_Demo_Importer::import_all() as an administrator. Set the local store to visible. Intercept wp_mail and external HTTP requests in a local-only mu-plugin before executing tests. Do not distribute that plugin or the database.

Order: integration.php (configures isolated GBP shipping/test bank transfer and creates commerce fixtures), routes.php, content.php; then crawl.cjs, browser-commerce.cjs, interactions.cjs, responsive.cjs, accessibility.cjs, navigation.cjs and performance-seo.cjs. Browser checkout completes a free order only; it makes no real payment.

The route audit's observed template header comes from a local-only mu-plugin using a late template_include filter; it is absent from release source. Runtime JSON contains local URLs and test order IDs and is intentionally excluded from Git. Summaries are published in docs/QA-REPORT.md and docs/ROUTE-AUDIT.md.
