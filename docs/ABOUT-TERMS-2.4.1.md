# About and Terms review candidate — 15 October 2026

Local WordPress preparation only. Production has not been changed. This is a bounded follow-up to 2.4.0, on `codex/ppt-about-terms`; the existing site design, currency, gateways and unrelated pages are preserved.

## Content and URLs

- About: existing page ID 5, `/about/`, updated locally with the supplied company introduction, foundation, five focus areas, working principles, company details and genuine `/work-with-us/` and `/contact/` links. The existing “Why we exist” paragraph is retained. The page template supplies its single H1. All body content uses native editable blocks.
- Terms: new **draft** page ID 336, title “Terms and Conditions”, reserved slug `terms-review`. Authenticated preview: `http://127.0.0.1:8877/?page_id=336&preview=true`. It contains the complete supplied text, 17 anchored sections, a contents list, review banner, effective-date/version fields and print styling. It is not a replacement public route. The eventual approved destination remains **existing page ID 21, `/terms/`**.
- Existing `/terms/` launch notice remains byte-for-byte intact, as do its existing footer links. It is explicitly a launch notice, not approved sales terms. No link to the review draft was added to menus, the footer or checkout.
- The actual checkout is page ID 32, native `woocommerce/checkout` Blocks. Initially `woocommerce_terms_page_id` was empty. Privacy is page ID 3, `/privacy-policy/`; its current launch notice omits verified operational details. This is a release blocker, not a complete privacy policy.
- Header/navigation overrides, logo, forest/teal/gold palette, typography and other page templates are preserved. Styling is scoped to `.ppt-about-document` and `.ppt-terms-document`.

IDs above belong to the isolated local database. Discover IDs on any other staging installation; never assume they match.

## Source handling and approval limits

Read `01-about-us.md`, `02-terms-and-conditions.md` and `PPThrive_About_Terms_Codex_Prompt.txt`. Their editorial HTML comments were excluded from page content. The source manifest records the two content-file hashes.

`03-owner-review-and-sources.md` was not available among the accessible attachments or matching files in Downloads/Documents/Desktop. The owner said it was attached earlier; no file with that name was located. This is **unresolved**, not a claim that the source notes were reviewed. No original company scans were opened or uploaded. No applicable AGENTS.md was found in the workspace, project or checked ancestor directories.

Identity is based on the supplied verified details, not an independent registry lookup: People and Planet Thrive Initiative Pvt. Ltd.; Nepal; registration 355000/81/82; incorporated 12 November 2024; PAN 621243194; Budhanilkantha Municipality, Ward No. 11, Kathmandu, Nepal. No former Ward 29 address, invented contact, accreditation, founder biography, partner, impact statistic, seal or certificate image was added.

The draft preserves the supplied statutory-rights, refund, open-licence, cancellation, liability and jurisdiction safeguards without representing legal approval. Its promises must be reconciled with actual operations before publication.

### Unresolved fields (12 occurrences, 10 unique)

| Field | Occurrences |
|---|---:|
| `{{APPROVED_EFFECTIVE_DATE}}` | 1 |
| `{{APPROVED_TERMS_VERSION}}` | 1 |
| `{{PUBLIC_SUPPORT_EMAIL}}` | 2 |
| `{{PUBLIC_SUPPORT_PHONE}}` | 2 |
| `{{VERIFIED_ECOMMERCE_LISTING_NUMBER}}` | 1 |
| `{{APPROVED_COMPLAINTS_PERSON_OR_UNIT}}` | 1 |
| `{{PUBLIC_COMPLAINTS_EMAIL}}` | 1 |
| `{{PUBLIC_COMPLAINTS_PHONE}}` | 1 |
| `{{APPROVED_COMPLAINTS_ADDRESS}}` | 1 |
| `{{VERIFIED_COMPLAINTS_ROUTE}}` | 1 |

The review page carries `_ppt_review_required` and `_ppt_terms_review_target`. While the review marker remains, PPT Core forces attempted publication/scheduling back to draft. Do not remove it until the owner/source, operational and legal reviews are complete. This guard is an editorial safeguard, not access control against an administrator intentionally bypassing it.

## Checkout preparation

PPT Core 2.4.1 adds an **inactive by default** acceptance module using WooCommerce's [Additional Checkout Fields API](https://developer.woocommerce.com/docs/block-development/extensible-blocks/cart-and-checkout-blocks/additional-checkout-fields/) and Store API checkout hooks. The field belongs to the order, is unchecked initially and requires affirmative acceptance. The existing native Terms block supplies the readable policy link. It is not assumed to record affirmative agreement by itself.

Opt-in configuration is the `ppt_terms_acceptance` option: `enabled`, `approved`, `page_id`, `version`, and SHA-256 of the exact approved `post_content`. The selected WooCommerce Terms page must be the same published, non-password-protected page with no unresolved placeholders or review marker. No production option is set by installing the plugin. The field ID is tied to policy content and version so a stale browser acceptance cannot silently accept a replacement policy. Changed, withdrawn or misconfigured approved terms cause the enabled Store API checkout to refuse processing. Classic shortcode checkout is explicitly blocked when this opt-in module is enabled; it has not been silently treated as equivalent.

WooCommerce stores the native order-level checkbox; the module separately stores `_ppt_terms_acceptance` with acceptance, version, page ID, URL, content hash, UTC timestamp and Store API source using Woo order CRUD. It preserves the first acceptance record on retries. It adds no customer identity fields or marketing opt-in. Keep immutable approved policy exports/revisions so the recorded hash can be resolved to its exact wording.

No immediate-digital-supply cancellation waiver has been invented or enabled. General acceptance never purports to supply that consent. Selling markets, supply timing, required separate wording and acknowledgement need legal/owner decisions; if a waiver is to be used, a separately validated and recorded consent flow is a release-blocking follow-up. Do not launch immediate digital supply relying on this general Terms checkbox.

For testing only, an explicitly labelled **local QA policy** temporarily occupied WooCommerce's Terms setting. It contained no unfinished customer terms and asserted no real legal approval. The test setting, policy and owned test orders/session are removed afterwards; the pre-task checkout configuration is restored. No real payment or email was sent. This verifies a technical mechanism, not the legal/operational readiness of the actual draft.

## Changed files and settings

- `content/about-terms/about.html`, `terms.html`, `source-manifest.json`: portable Gutenberg content and placeholder/source manifest. These review files are outside installable plugin/theme ZIPs; installing ZIPs does **not** overwrite site content.
- Theme: `assets/css/about-terms.css`, `inc/customer-experience.php`, version in `functions.php` and `style.css`. Adds scoped reading/print styles and avoids a duplicate automatic About CTA where the editable document already supplies one.
- Core: `includes/terms-acceptance.php`, include/version in `ppt-core.php`.
- Tests: content generator, explicit local preparation, inventory, fixture lifecycle, browser acceptance and server checks under `tests/about-terms-*` / `tests/prepare-about-terms-content.cjs`.
- Local database: About page content/title; new Terms draft and review metadata; saved revisions. No persistent checkout, currency, privacy or menu setting change.
- Theme/core packages: 2.4.1. See current integrity evidence for final hashes.

## Deployment gate and rollback

**No deployment is authorised by this handover.** Resolve source notes, all ten fields, privacy/complaints/fulfilment accuracy and owner/Nepal-qualified legal approval for the intended markets first. See TASKS.md. Review the layout and exact copy before requesting a separate deployment decision.

After explicit approval, rehearse on backed-up staging with its own real IDs. Install the candidate packages. Import `about.html` into the existing About page's code editor (or apply a reviewed revision), retaining its URL. Keep Terms as draft while completing fields and removing the review banner. Save the approved, dated/versioned policy snapshot; copy its approved native blocks into the **existing** `/terms/` page after backing up its current revision. Do not publish the temporary `/terms-review/` route as a second competing policy.

In staging, select the approved `/terms/` page at WooCommerce → Settings → Advanced → Page setup → Terms and conditions. Configure `ppt_terms_acceptance` with its real ID, explicit approved version and SHA-256 of saved content only after approval. Test Blocks, policy access, unchecked/checked/bypassed requests, order records and any separately required digital consent against the final wording/configuration. Rehearse a policy update because editing approved content invalidates its approval hash. Exclude Checkout, Cart, accounts and sessions from caches. Production remains behind a new approval gate after staging checks.

Local backup: `checkpoint/pre-about-terms-20261015/` holds pre-change source, ZIPs and `pages.json` containing exact page records, metadata and relevant options. Native WordPress revisions also preserve the prior copy. Never upload this checkpoint or runtime to the web root or GitHub.

To roll back the local candidate, restore About's saved title/content from `pages.json` (or its pre-change revision), trash only the owned review draft ID 336 after confirming its review-target metadata, reinstall the backed-up 2.4.0 ZIPs, and restore the saved options. Preserve later editorial changes before applying an old revision. Public Terms, privacy, checkout content and menus were not replaced and should not be needlessly rewritten. On a deployed store, close commerce for rollback rather than simply disabling mandatory acceptance while taking orders; preserve existing order acceptance evidence. Never restore an old whole database over later orders or enquiries.

## Actual test evidence

Final results and limits are recorded in `docs/qa-evidence/about-terms-2.4.1/` and QA-REPORT.md. Local browsers use Chromium; automated accessibility checks do not establish full WCAG conformance, physical-device coverage or legal compliance. Production behaviour has not been retested as part of this bounded task.
