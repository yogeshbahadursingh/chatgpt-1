# About / Terms 2.4.1 — local review candidate, 15 October 2026

**Production unchanged; Terms remain draft.** 40 page/editor assertions, 21 block-checkout assertions and 19 server/content checks passed. Page geometry covered 360, 600, 768, 900, 1024, 1200 and 1440px (14 observations); populated checkout covered 360/768/1024/1440px. Both documents passed scoped WCAG-tagged axe scans with zero violations. Native block validation and real editor-save/frontend checks passed for both pages. These are local Chromium results, not legal approval or all-browser/WCAG certification.

Actual Store API requests rejected false, missing and stale acceptance, and a changed approval hash. Physical and digital offline orders reached confirmation with the exact version/hash/UTC acceptance record; both remained on hold, with no paid-download entitlement. Owned test orders/policy/session were removed and prior checkout settings restored. The first positive checkout run exposed WooCommerce checkbox-value normalisation; this was fixed and the checkout suite rerun successfully. The initial diagnostic is retained, not counted as a completed checkout pass.

The full Terms text and all 12 placeholder occurrences are preserved. Anonymous draft access and public REST were denied; publication was forced back to draft while the review marker remained. Existing /terms/, privacy, checkout content, header and navigation were preserved. Print CSS and mobile/desktop screenshots were visually inspected. All 106 source PHP files linted and all 159 installed package files match source.

**Blocked:** missing accessible owner/source notes, ten unresolved fields, owner/legal approval, operational complaints/privacy/fulfilment verification, and any required separate immediate-digital-supply consent. No real gateway, customer email, refund or production test is represented. See [handover and rollback](ABOUT-TERMS-2.4.1.md), [evidence](qa-evidence/about-terms-2.4.1/summary.json) and [remaining tasks](../TASKS.md).

---

# Current 2.4.0 fixes — 15 October 2026

1. Replaced the legacy Work With Us text stack with a native block journey and six distinct actions; added conservative explicit migration with editorial preservation.
2. Replaced email-only acceptance with private enquiry persistence, truthful references, configured staff notification status, validation retention, duplicate/rate/ticket protection and native privacy export/erasure. Browser testing found and fixed the WordPress reserved-name POST collision by prefixing form field names.
3. Added shared page/layout/form/status components, relevant research and author actions, product/order support and a proportionate footer while preserving saved header/navigation hashes.
4. Removed unsupported blanket peer-review wording; labelled demonstrations; made past/undated/demo opportunities use honest interest actions. Event times identify the configured timezone.
5. Removed the blocking entrance overlay and fake legacy newsletter success. Added conditional long-article contents with stable anchors, reduced-motion scrolling and keyboard focus.
6. Fixed accessibility defects found in actual rendered pages: underlined inline enquiry/privacy links, a 44px password toggle, and darker planning badges on project/archive/profile templates. Fresh affected-route scans passed.
7. Removed 11 nonexistent fontFace declarations, retaining the already-rendered fallback stacks. Fresh asset requests passed; no new external font service was introduced.
8. Made empty search results explicit while retaining the query. Verified protected WooCommerce entitlements, offline failed-order retry, native editing, filters and pagination with owned local fixtures. Fixed test-fixture double-granting before verifying expiry/exhaustion/revocation.

Implementation and limitations: [release handover](CUSTOMER-EXPERIENCE-2.4.0.md), [requirement statuses](CX-REQUIREMENTS.md), [current QA](QA-REPORT.md). No production code/content/orders/users/settings changed.

---

## Historical evidence below — versions as originally recorded

# Fix log — release 2.3.2, 9 October 2026

**Theme 2.3.4 follow-up:** smaller navbar logo (64px desktop / 48px mobile) with the editable site name beside it, per owner feedback. See [COMPACT-NAVBAR.md](COMPACT-NAVBAR.md). PPT Core remains 2.3.3.

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
