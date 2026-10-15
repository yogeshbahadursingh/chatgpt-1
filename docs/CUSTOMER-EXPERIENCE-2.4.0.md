# Customer experience release 2.4.0 — 15 October 2026

This is a local review candidate for the existing WordPress site. It is not a production deployment or a store-launch approval. Theme and PPT Core are both version 2.4.0. See the current additions to LIVE-AUDIT.md, ROUTE-AUDIT.md and QA-REPORT.md; earlier evidence belongs to the versions explicitly named there.

## What changed

- Work With Us uses editable native blocks: a prominent introduction, six specific pathways, preparation guidance, next steps, FAQs and a contextual enquiry form. The learning pathway opens the training archive and offers an interest fallback. Proposing training and attending training are separate choices.
- Enquiries are validated on the server and stored as private, non-public WordPress records. A real saved reference precedes confirmation. Staff can review classification, context, consent time and notification status. Failed notifications remain visible and can be retried by an authorised administrator. Mail transport acceptance is not proof of inbox delivery.
- Forms retain entered values after recoverable validation/storage errors. They have persistent labels, error summaries, inline errors, a submitting state, duplicate protection, signed expiring tickets, a honeypot and rate limiting. Field names are prefixed to avoid WordPress route-query collisions. No upload or marketing subscription is added.
- Shared page layouts have a wider browsing area, readable text widths, clearer headings, status/empty states and relevant research/author next actions. The approved homepage direction and compact logo/name navigation remain. The footer logo is 144px and duplicated Contact links were removed.
- Catalogue cards expose available native author/format metadata and demonstration labels. WooCommerce remains the price, stock, cart, payment and protected-download authority. Product/order support links carry the correct enquiry context.
- Training/events distinguish demonstration, past and undated offerings from participation details. Event times include the site's configured timezone. No new LMS or booking provider is invented.
- Blanket unsupported peer-review claims were removed from theme copy. Short insights no longer get an unnecessary contents panel. Long-article contents preserve heading IDs, support reduced motion and move keyboard focus correctly.
- The blocking entrance overlay is removed while ambient homepage animation remains. Legacy unconnected newsletter forms can no longer claim a subscription succeeded.
- Demonstration records do not emit scholarly/product structured data as if they were real works. Optional demo noindex/native-sitemap exclusion is an explicit operator setting, off by default. Production indexing has not been changed.

## Data and editorial preservation

The private checkpoint is `checkpoint/pre-cx-20261015`: source, packages, uploads, MU plugins and a local database export. It is excluded from Git and release ZIPs. Development branch: `codex/ppt-customer-experience`.

Local saved Site Editor overrides were exported before changes: header ID 28 and navigation ID 27. No saved global-style override was present locally. Live overrides remain uninspected because the live administrator page returns a critical error. Never assume local overrides represent production.

Existing installations use **Tools → PPT Experience Update**. It upgrades only the exact unedited legacy Work With Us content/title, records a revision and backup metadata, and marks the completed migration. Repeating it preserves later editorial changes. A modified page requires a deliberate merge using the **PPT collaboration pathways and enquiry** block pattern. It does not reset navigation, templates, users, products, orders or settings.

## Deployment procedure — after explicit approval

1. Obtain hosting error logs and resolve the live database/admin failures before attempting an update. Back up production files and database, and prove restoration on staging. Export saved Site Editor templates, parts, navigation and global styles.
2. Install both supplied 2.4.0 ZIPs on staging first, keeping the existing theme/plugin folder names. Do not upload `runtime`, `checkpoint`, QA scripts, local configuration, the test database or mail interception MU plugins.
3. Compare saved overrides against the shipped templates. Preserve custom header/navigation content. Merge the page layout/footer changes manually where a saved override takes precedence; do not indiscriminately reset templates.
4. Preview and apply the conservative Experience Update to the unedited collaboration page, or merge the native pattern into a customised page. Review every pathway, policy link and service claim.
5. Approve an operator-specific privacy notice covering private enquiry storage, recipients, retention, access and deletion. Existing policy pages are deliberately not overwritten. Set the recipient and enable enquiries in Settings → PPT Platform only after approval and mail configuration. Use an authorised test inbox to verify actual delivery, including a deliberately failed notification and staff retry. The package's storage acknowledgement is not a replacement for the approved notice.
6. Enquiries are initially visible only to administrators with `manage_ppt_enquiries`. Grant that capability only to approved staff through an established role-management process. WordPress verified privacy export/erasure includes enquiry data. No automatic retention/deletion period is invented; set an approved operational retention policy and include backups/mailboxes in that policy.
7. Exclude enquiry pages (`/contact/`, `/work-with-us/`, `/submit-manuscript/`, `/careers/`), POST responses, receipt/context queries, Cart, Checkout, My Account and WooCommerce sessions/cookies from SpeedyCache/CDN full-page caching. Application responses send private/no-store headers; caches running before WordPress must be configured separately. Purge old HTML, CSS/JS/minification and CDN caches after installing. Retest anonymously and as an authorised user with separate sessions.
8. Review genuine products, editions, samples, bibliographic data, currency, tax, shipping, guest/account rules, terms/refunds, file licences and protected-download expiry/limits. Keep demo purchases blocked in production. Complete gateway sandbox success, decline/retry, callbacks, refund and account/download tests on the actual host before live trading.
9. Review all importer-tagged demonstrations through the existing conservative removal/adoption process. Do not infer demo status from slugs or delete files used by retained orders. Obtain approval before changing production indexing, sitemap ownership or store visibility. Inspect Search Console and server evidence for the retail-index lead separately.
10. Recheck the route and journey matrix, mobile/keyboard behaviour, real email delivery and server/CDN file protection on staging. Submit the staged result and outstanding decisions for approval before production installation or visibility changes.

## Rollback

Restore the previous theme/plugin ZIPs and purge caches. If the experience migration was applied, restore the saved page revision or `_ppt_cx_backup` content/title through an administrator-reviewed operation; remove the migration marker only if intentionally reverting that migration. Restore a saved template override only from its own export. Do not restore an old database over new orders, users or enquiries. Export and preserve new private enquiry records before rolling back PPT Core, because the old version will not display their custom post type. Use the full backup only within a coordinated recovery that accounts for newer transactions.

## Remaining human/external gates

- Hosting logs and authenticated production inventory: live `/wp-admin/` critical error and intermittent public database failures prevent a verified diagnosis.
- Production file/user/database/redirect audit and Search Console Security Issues, Manual Actions and URL Inspection. A branded 404 for the supplied retail URL is not proof of a clean installation or a compromise.
- Approved real content, journal/editorial claims, staff/organisation details, policy/retention wording and service availability.
- Actual inbox delivery, gateway credentials/sandbox callbacks, merchant tax/shipping/refund decisions and production protected-file/CDN behaviour.
- Firefox/WebKit and representative field performance data are unavailable in this environment. Chromium and local lab checks do not establish WCAG conformance or field Core Web Vitals.
- Explicit production deployment, indexing and store-opening approval.

## Final package manifests

See [package hashes](qa-evidence/cx-2.4.0/package-results.json) and [installed/source comparison](qa-evidence/cx-2.4.0/installed-source-results.json). Both packages were rebuilt after line-ending cleanup; this changed no runtime behaviour.

Current tests and scope boundaries: [QA report](QA-REPORT.md), [requirement matrix](CX-REQUIREMENTS.md), [route inventory](CX-ROUTES.md).
