# QA report — 2.3.2, 9 October 2026

**Latest theme: 2.3.4, with PPT Core 2.3.3.** The small-logo/navbar-name follow-up is recorded in [COMPACT-NAVBAR.md](COMPACT-NAVBAR.md).

**Logo release baseline: 2.3.3.** The report below remains the recorded 2.3.2 audit baseline. The subsequent logo-only release, package hashes and focused retest evidence are documented in [LOGO-UPDATE.md](LOGO-UPDATE.md); do not attribute this entire baseline matrix to a second run on 2.3.3.

**Local acceptance passed; production is unchanged and awaits explicit human approval.** The previous report’s 112-route crawl omitted shared taxonomies and did not establish complete journeys. This release adds those routes and targeted regressions. LIVE-AUDIT.md separately records live store 404s, disabled enquiries and external schema configuration issues.

The final ZIPs were installed onto a newly extracted WordPress 7.1.2 core and an empty `ppt_acceptance_232` database, using WooCommerce 11.1.2, PHP 8.0.30, Apache 2.4.58, MariaDB 10.4.32 and Playwright Chromium. The publicly observed site runs WordPress 7.1.3; that exact hosting/plugin combination was not reproduced. Setup created 21 editable pages before Woo activation and was repeated afterwards. All 149 source files match installed package files by SHA-256.

Mail and outbound WordPress HTTP were intercepted. Demo purchase protection was tested first with default production behavior. Local-only configuration then enabled sample checkout for commerce tests; it is excluded from packages. No real charge or external message was sent. Focused fixture suites ran against the same final source, with exact owned-record cleanup; the complete package then passed the clean-install acceptance matrix.

| Area | Result | Evidence and boundary |
|---|---|---|
| Setup/content/commerce lifecycle | PASS 14/14 | Idempotence, edited-content preservation, demo removal, stock and native download permissions. [Results](qa-evidence/integration-results.json) |
| Starter handling | PASS 3/3 | Exact plain/block defaults drafted; genuine copy preserved. [Results](qa-evidence/setup-repair-results.json) |
| Demo guard: production-default | PASS 27/27 | Product/variation, cart, classic/Store API checkout and order-payment guard assertions; temporary fixtures cleaned. [Results](qa-evidence/demo-commerce-production-default.json) |
| Demo guard: production-opt-in | PASS 27/27 | Product/variation, cart, classic/Store API checkout and order-payment guard assertions; temporary fixtures cleaned. [Results](qa-evidence/demo-commerce-production-opt-in.json) |
| Demo guard: staging-opt-in | PASS 27/27 | Product/variation, cart, classic/Store API checkout and order-payment guard assertions; temporary fixtures cleaned. [Results](qa-evidence/demo-commerce-staging-opt-in.json) |
| Demo guard HTTP | PASS 6/6 | No demo purchase form; direct basket and Store API additions rejected. [Results](qa-evidence/demo-commerce-browser-results.json) |
| Pagination and no-Woo catalogue | PASS 19/19 | Two pages with exact membership and persistent topic/status; five correct editorial format groups. [Results](qa-evidence/archive-journey-results.json) |
| Shared-taxonomy store visibility | PASS 44/44 | Store-only vs whole-site, hidden catalogue items, pagination, private preview and unchanged options. [Results](qa-evidence/store-visibility-results.json) |
| Secondary product visibility | PASS 20/20 | Related content, directories and search respect launch and Woo visibility settings. [Results](qa-evidence/collection-visibility-results.json) |
| Editorial product journeys | PASS 24/24 | Paid, free, preview, unavailable, private, hidden and missing linked products. [Results](qa-evidence/publication-cta-results.json) |
| Research filters | PASS 9/9 | Status aliases, empty results and combined topic/status. [Results](qa-evidence/research-filter-results.json) |
| Research editor | PASS 6/6 | Stored status displayed correctly without data rewrite. [Results](qa-evidence/research-editor-results.json) |
| Schema behavior | PASS 22/22 | Configured logo, breadcrumbs, format types, ISBN, schema ownership and safe JSON encoding. [Results](qa-evidence/schema-results.json) |
| Rendered JSON-LD | PASS 10/10 | Actual HTTP pages parse and emit expected types and nonempty breadcrumb destinations. [Results](qa-evidence/schema-http-results.json) |
| Mixed terms and journal submission | PASS 3/3 | HTTP 200/no PHP marker; term content and actual submission link/policies. [Results](qa-evidence/journey-repair-results.json) |
| Homepage precedence | PASS 4/4 | Latest-posts configuration retains hero; Insights and keyboard overlay work. [Results](qa-evidence/frontpage-repair-results.json) |
| Premium navigation | PASS 16/16 | Seven widths, keyboard/Escape/focus restore, sticky/simulated admin-bar offsets, no-JS and reduced motion. [Results](qa-evidence/navigation-premium-results.json) |
| Navigation/search/sitemap | PASS 38/38 | Observed internal links, native mini-cart, search and XML sitemap. [Results](qa-evidence/navigation-results.json) |
| Interactions and basket layouts | PASS 23/23 | Native keyboard, intro behavior, quantity-two basket and populated Cart/Checkout widths. [Results](qa-evidence/interaction-results.json) |
| Commerce/form HTTP | PASS 6/6 | Free checkout and authorized PDF; direct file 403; intercepted enquiry, invalid nonce and expected 404. [Results](qa-evidence/browser-commerce-results.json) |
| Anonymous actions/REST | PASS 3/3 | Setup/import denial and no paid-file URL in editorial publication REST. [Results](qa-evidence/security-results.json) |
| Demonstration content | PASS 74/74 | Nonempty records, topics, relationship targets, future events and no invented academic identifiers. [Results](qa-evidence/content-results.json) |
| Public routes | PASS 140/140 | Includes populated public taxonomies; response markers and observed template evidence. 138 distinct URLs; repeat entries verify page/archive aliases. [Results](qa-evidence/route-results.json) |
| Responsive page matrix | PASS 64/64 | Eight page types at eight widths 320–1920. [Results](qa-evidence/responsive-results.json) |
| Home/Insights visual regression | PASS 14/14 | Fourteen width observations; visible heading scale and no horizontal overflow, with desktop/mobile screenshot review. [Results](qa-evidence/screenshot-repair-results.json) |
| Automated accessibility | PASS 7/7 | Seven representative routes; WCAG-tagged axe checks only. Gradient/image contrast includes manual-review items. [Results](qa-evidence/accessibility-results.json) |
| PHP/package integrity | PASS | 101 PHP files linted; correct ZIP roots, source/package file counts and no runtime/configuration/secrets paths. [Integrity](qa-evidence/package-results.json) |

## Performance and visual review

Desktop at 1366px and mobile at 375px header screenshots were inspected. The approved hero/orb, intro and footer composition remain. The menu overlay fills the viewport; the desktop menu stays on one row and the mobile header retains search/account/cart. Responsive assertions cover geometry and control clipping, not all aspects of visual quality.

- /: 38 observed resources, 620,102 transferred bytes; 1 H1; 0 broken images.
- /publications/: 37 observed resources, 632,587 transferred bytes; 1 H1; 0 broken images.
- /product/demo-product-people-planet-progress/: 37 observed resources, 624,713 transferred bytes; 1 H1; 0 broken images.

Home and Product expose native canonical links. The local Publications archive has no custom canonical tag; the chosen SEO provider must supply/verify archive canonicals and social metadata where required. No full SEO-plugin combination or search-indexing certification is claimed.

These are isolated resource observations with remote origins blocked, not Core Web Vitals or production speed scores. No full load test, field performance or all-browser certification was performed.

## Remaining approval and hosting checks

- **Live repair application:** activate/configure WooCommerce, repair its four page assignments, verify Reading/Site Editor overrides and purge page/hosting/CDN caches only after approval.
- **Mail:** configure an approved recipient and transport; verify actual receipt. Local form acceptance is not delivery proof.
- **Real commerce:** gateway sandbox paid/failed/cancelled/refunded orders, callbacks, real shipping/tax rules, customer emails and account recovery remain NOT TESTABLE without operator configuration. Local unpaid/completed order permissions are narrower evidence.
- **Downloads:** verify direct denial and authorized delivery on the real web server/CDN, HTTPS, expiry and exhausted links. Local Apache 403 does not configure Nginx/CDN.
- **Editorial/SEO:** replace or remove fictional demos, approve organisation/policies/product rights and files, configure the external SEO provider’s real Organization details and verify one intended metadata owner.
- **Accessibility:** manual screen readers, physical mobile devices, non-Chromium browsers and incomplete image/gradient contrast require human review. Zero automated violations is not WCAG conformance.

## Package hashes

- people-planet-thrive.zip: SHA-256 `87ca66b1e7b39ecd7a6b99e6cff80bab37d78f2e6cb92d366de969e9cfdeeefc` (127 files; 170148 bytes).
- ppt-core.zip: SHA-256 `28f6ba74dbe4e6d48adbf92afb95cb0be09a03e68009956376f33a51745bbeef` (22 files; 46590 bytes).

The machine-readable evidence and timestamps are in [qa-evidence/manifest.json](qa-evidence/manifest.json). Runtime databases, test orders, logs, configuration and preview credentials remain local. See INSTALLATION.md for backup, application and rollback.

The first concurrent browser acceptance attempt exhausted local test-host capacity and produced timeouts/partial results. Those runs were not accepted; remaining suites were rerun with one test browser at a time. Final results above are the completed reruns. No product-code changes or relaxed assertions were used to make those timeouts pass.

The sequential accessibility run independently found an Insights author-link defect. Its [pre-fix results](qa-evidence/accessibility-before-byline-fix.json) are retained. The byline links were underlined, all seven axe routes passed, and the theme was repackaged/reinstalled with 149/149 source-file hashes matching. The final change was limited to that link decoration; Insights width/screenshots were rechecked in the final screenshot matrix. Earlier clean-install commerce/routing/responsive evidence remains applicable to the unchanged code paths.
