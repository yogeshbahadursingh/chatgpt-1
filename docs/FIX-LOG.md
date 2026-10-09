# Fix log — release 2.3.2, 9 October 2026

**2.3.3 follow-up:** supplied logo integrated through native Site Logo blocks in the header, existing hero position and footer. Setup imports once, preserves existing logo selections, and surfaces branding errors without blocking page/commerce repair. See [LOGO-UPDATE.md](LOGO-UPDATE.md) for current release verification and [PLUGIN-GUIDE.md](PLUGIN-GUIDE.md) for the requested plugin list.

All changes below are local source/package changes. Production remains at the approval gate. This log supersedes the older 2.3.0 completion claims where the live audit exposed missing coverage.

| Priority | Defect and root cause | Change | Regression evidence |
|---|---|---|---|
| P1 | Shared knowledge terms were treated as Woo product-only archives; editorial records caused a null-product fatal | Native Woo templates restricted to product-only taxonomy objects; mixed taxonomy template added; defensive product-loop guard | journey-repair; expanded routes/crawl |
| P1 | Product-only holding mode hid editorial subject/format archives | Narrow shared-taxonomy exclusion from store-only holding screen; query excludes products for blocked visitors; full-site and native store gates retained | shared-store visibility suite |
| P1 | Catalog-hidden products could enter mixed taxonomies | Query-level visibility exclusion preserves result counts and pagination | shared-store visibility suite |
| P1 | Search, directories and related lists could link to unavailable store products | Shared query-argument helper removes prelaunch products and applies context-appropriate catalogue/search visibility and out-of-stock rules before querying | collection-visibility; store-visibility and archive-journeys retest |
| P1 | Publications fallback reused latest titles in every format | Per-type taxonomy queries apply with or without Woo; previewing a closed store uses editorial records | archive-journeys; shared-store visibility |
| P1 | Research status spelling differed between importer/editor; bespoke query lost filters/pagination | Main-query status filter supports planning/planned, preserves topic restrictions and stable date/ID ordering; legacy editor values normalized on display | research-filters; research-editor; temporary two-page archive fixtures |
| P1 | Demo products could be bought as genuine goods | Default-deny demo product, variation, cart, checkout and order-payment guards; opt-in limited to nonproduction QA environments | demo-commerce environment matrix; browser Store API denial |
| P1 | Editorial publication CTA could point to missing/private/nonpurchasable products or mislabel free content | Resolve native product visibility and availability; meaningful view/free/purchase action, native currency/sale price | publication CTA fixtures |
| P1 | Journal submission fragment/policies incomplete | Real Submit Manuscript destination, author/policy links and saved policy rendering | journey-repair |
| P1 | Fresh latest-posts home was intercepted as Insights | Preserve front-page template precedence; admin setup/Reading notices | frontpage-repair |
| P2 | Untouched core starter survived; demo Insights retained Uncategorized | Recognize exact plain/block English starter; preserve edited content; assign owned unchanged demo categories correctly | setup-repair; integration/content |
| P2 | PHP layouts referenced undefined numeric font/spacing and colour tokens | Restore aliases; verify actual Insights heading/spacing and populated/empty states | screenshot-repair; responsive; accessibility |
| P2 | Fresh populated Insights author bylines relied on colour alone | Underline the author links without changing layout; repackaged and reinstalled the theme | Full seven-route axe retest and Insights screenshot/width checks |
| P2 | Header wrapped/disappeared and overlay was confined by backdrop-filter | Refined ivory/gold header, integrated search, one desktop row, responsive native menu, sticky shadow with admin offsets and reduced-motion behavior | premium-navigation; screenshot inspection; interactions |
| P2 | Theme schema referenced nonexistent logo; taxonomy crumbs blank; all publication formats called books | Configured logo only; queried-object breadcrumbs; format-specific type; correct ISBN metadata key; explicit standard-schema ownership filter | schema regression suite; performance-seo |

## Preservation and safeguards

The approved hero, orb, intro, page composition and footer remain. WordPress owns editable Pages/Posts/navigation; PPT Core owns specialist records/relationships; WooCommerce owns products, orders, stock and authorized downloads. Site Setup is repeatable and preserves existing editorial/custom template records. Demo lifecycle respects ownership/fingerprints and preserves edited or adopted records. Tests that create extra fixtures remove only their exact tagged records.

Local source and prior ZIPs were copied to `checkpoint/pre-live-audit-20261009`. Previous local databases and the pre-2.3.2 QA installation remain available. Runtime settings, credentials, intercepted mail and sample orders are excluded from release ZIPs and Git.

## Remaining human/production dependencies

Production store activation/system-page assignments, real recipient and mail delivery, external SEO-provider configuration, real gateway/shipping/tax/download-host checks, operator content/policies and saved Site Editor overrides cannot be completed through this public audit. These are explicit deployment/acceptance tasks in INSTALLATION.md, not silently marked PASS. No live deployment is authorized yet.
