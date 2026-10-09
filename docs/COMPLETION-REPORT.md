# Review handover — 2.3.2, 9 October 2026

**Current deliverables are 2.3.3:** see [LOGO-UPDATE.md](LOGO-UPDATE.md) for the owner-supplied artwork, focused retest and current package hashes, plus [PLUGIN-GUIDE.md](PLUGIN-GUIDE.md). The audit history and remaining production approval requirements below still apply.

The audit resumed from actual code and public live responses. It found defects outside the earlier test matrix and repaired them locally. **Production remains unchanged.** This release is prepared for human review and approved staging application; live launch still needs the environment-specific checks below.

## What changed

- Repaired mixed subject/publication taxonomy routes, research filters/pagination, and correct publication-format sections when WooCommerce is unavailable.
- Preserved editorial browsing during store-only Coming Soon; product visibility now applies to mixed archives, directories, related content, search and Publications sections.
- Protected fictional demo products from real transactions, with an explicit isolated-QA opt-in that cannot enable them in production.
- Corrected book/free/preview/unavailable product actions, native pricing, and journal submission/policy links.
- Preserved homepage template precedence, repaired untouched starter handling and restored missing typography/spacing tokens behind the reported Insights defects.
- Refined the editable native navigation with ivory/gold styling, integrated search, sticky behavior, keyboard/mobile overlay fixes, reduced-motion and no-JavaScript support. The approved hero/orb, intro and footer remain.
- Corrected configured-logo schema, archive breadcrumbs, publication types/ISBN and explicit SEO metadata ownership.

## Deliverables and evidence

- release/people-planet-thrive.zip and release/ppt-core.zip, both version 2.3.2.
- source/ with the theme and PPT Core; tests/ with reproducible acceptance/regression suites.
- LIVE-AUDIT.md: observed production responses and unresolved live configuration.
- FIX-LOG.md: defect, cause, change and regression mapping.
- ROUTE-AUDIT.md: installed-release template and response evidence, including populated public taxonomies.
- QA-REPORT.md and qa-evidence/: measured results, limitations, source/package hashes and report timestamps.
- SCREENSHOT-REPAIR.md plus desktop/mobile preview images.
- INSTALLATION.md and ADMIN-GUIDE.md: upgrade, content operations, protected downloads, demo rules, metadata ownership and rollback.

The final packages were installed on a newly extracted WordPress core and empty local database. All 149 installed source files match the release source by SHA-256. The expanded crawl records 140 successful responses across 138 distinct URLs; response success is separate from the functional tests in QA-REPORT.md. No production database, runtime configuration or test orders are shipped.

## Approval gate

Approve the two packages and navigation preview for application to a backed-up staging copy first. On that copy, verify the site's saved Site Editor overrides, activate/configure WooCommerce and its system pages, configure the real enquiry recipient/transport, correct the external SEO provider's empty organisation metadata, and replace/approve genuine content and product files. Test gateway sandbox paid/failed/refunded flows, shipping/taxes, customer emails and download protection on the actual hosting/CDN. These cannot be certified by public browsing or local mock mail.

The live audit currently reports Shop, Cart, Checkout and My Account as 404 and Contact as disabled. Local repairs do not change that state until applied. Follow INSTALLATION.md for the backup/application/rollback sequence. Obtain explicit production approval after the staging/operator checks; do not infer it from accepting a GitHub push or reviewing these ZIPs.
