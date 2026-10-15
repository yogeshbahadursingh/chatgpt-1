# Customer experience requirements — release 2.4.0

Statuses describe the local candidate unless production is explicitly named. “Implemented and tested” is bounded by the cited checks; it does not assert a launch-ready business, WCAG conformance or live payment readiness. Current evidence is under `qa-evidence/cx-2.4.0/`.

| Requirement | Status | Evidence / remaining boundary |
|---|---|---|
| Existing WordPress/WooCommerce architecture and versions inspected | Implemented and tested | Local source, installation and inventory; 157 installed files match source. Production plugin inventory is blocked. |
| Development branch and recoverable local backup | Implemented and tested | Private checkpoint including 593,170-byte database export; `codex/ppt-customer-experience`. |
| Actual route/template/data inventory | Implemented and tested | 142 unique local routes with audience/task/source/template/HTTP/heading/actions; 171 public paths observed separately. |
| Saved template/navigation/global-style inspection and preservation | Implemented and tested | Local override export; header/navigation hashes unchanged; no local global-style override. Production export is blocked. |
| Public 403 reproduction | Implemented and tested | Independent requests initially reached Home/Insights/Work With Us with HTTP 200. Later live failures are recorded separately. |
| Production database/admin failures diagnosed and repaired | Blocked | Initial 14 public database-error responses and admin critical error; later server-level 404s. Hosting logs/access are needed. |
| Japanese retail/indexing security lead fully investigated | Blocked | Supplied retail URL initially branded 404; later server 404. Files/users/database/redirects/logs and Search Console remain inaccessible. No compromise conclusion. |
| SpeedyCache/CDN configuration and personalised cache isolation on production | Blocked | Local sensitive routes send private/no-store; production cache settings and authenticated variants cannot be inspected. |
| Shared layout, readable widths, fluid headings, cards and forms | Implemented and tested | 208 observations across 26 routes and eight widths; targeted retests after accessibility fixes. |
| Compact logo/name navigation, keyboard/touch, Escape/focus and sticky header | Implemented and tested | 16 navigation checks, touch open/close, authenticated toolbar checks and no-JavaScript menu access. |
| Footer proportions and duplicate Contact links | Implemented and tested | 144px logo, streamlined groups, desktop/mobile screenshots. |
| Work With Us six editable pathways, introduction and responsive columns | Implemented and tested | 64 valid native blocks; 3/2/1-column layout, distinct actions and native editor save reflected on frontend. |
| Learning opportunities and interest fallback distinct from proposing training | Implemented and tested | Learning action opens archive then selected interest form; training proposal has its own classification. |
| All six pathways submit and show truthful confirmation | Implemented and tested | Browser journeys plus seven private backend records including General; notifications accepted by intercepted transport. |
| Validation, retained data, error focus, submitting state and duplicate protection | Implemented and tested | 35 server checks and browser 422/data-retention/no-JavaScript/query-spoof checks. |
| Private staff access, CSRF/spam/rate protections and no uploads | Implemented and tested | Private non-REST CPT; custom capability; nonce/ticket/honeypot/rate checks; export/erase; staff interface tested. |
| Notification routing and persistence on mail failure | Implemented and tested | Captured configured-recipient messages; durable failed-notification record and authorised retry implementation. |
| Actual recipient inbox delivery and live retry | Blocked | Requires approved inbox, mail transport and live/staging delivery test. No delivery claim is made from wp_mail acceptance. |
| Approved privacy notice and operational retention | Blocked | Storage disclosure and verified privacy export/erasure implemented. Operator-specific privacy/retention policy still requires approval; existing policy copy preserved. |
| Next steps, FAQs and general enquiry route | Implemented and tested | Native editable blocks, specific and qualified copy, browser navigation. |
| Approved homepage direction and non-blocking animation | Implemented and tested | Existing identity preserved; entrance overlay removed; no-JavaScript and reduced-motion navigation checked. |
| Catalogue covers/title/format/access/author data and native pricing | Implemented and tested | Existing native fields and WooCommerce source retained; cards/detail routes and responsive checks. Genuine commercial content requires approval. |
| Print/digital/mixed carts and correct shipping | Implemented and tested | Native totals: print £12.50 + £4 shipping; digital £6 + £0; mixed £18.50 + £4 in local test settings. |
| Guest checkout and confirmation | Implemented and tested | Native browser checkout of a free protected resource plus physical and mixed baskets through local offline payment; no shipping-address fields for virtual-only basket. Paid offline orders remain on hold and have no download entitlement. |
| Paid order entitlement and protected download lifecycle | Implemented and tested | Simulated settled paid order; eligible PDF 200, expired/exhausted 403, revoked 404, direct file 403. This is local Apache, not production CDN proof. |
| Actual payment gateway success/decline/callback/refund | Blocked | No merchant sandbox configuration supplied. Native failed-order offline retry reuses the same order, but does not prove a real gateway integration. |
| Account errors and retained username | Implemented and tested | Native WooCommerce login failure tested; guest order/download flow tested. Owner's final account/registration policy remains to approve. |
| Journals, articles, author guidance and publishing route | Implemented and tested | Real routes and links; unsupported blanket claims removed; genuine journal/editorial credentials remain a content approval gate. |
| Research project/profile/status/team/output presentation | Implemented and tested | Existing fields and relationships preserved, relevant collaboration action, readable status contrast, route/width/accessibility checks. |
| Training/events dated, past, demo and undated states | Implemented and tested | Server state checks, interest journey, template checks; timezone follows configured WordPress setting. No real booking provider is claimed. |
| Insight readability and appropriately conditional contents | Implemented and tested | Short article omits contents; long article builds links, preserves IDs and moves focus below header; no-JavaScript reading works. |
| About/Contact/profiles/Careers/supporting pages | Implemented and tested | Existing route inventory and representative templates, contextual contact and honest availability; no invented people or vacancies. |
| Search public type labels, zero results and real 404 | Implemented and tested | 142-route audit, specific zero-results copy and retained query; private enquiries excluded; deliberate missing route returns 404. |
| Filters and pagination preserve state | Implemented and tested | Current research-filter and archive-journey regression suites; existing native queries retained. |
| Native pathway/publication/navigation edits update views | Implemented and tested | Native page editor plus publication title/author and saved-navigation changes; exact originals restored. |
| Repeatable conservative migration | Implemented and tested | Exact legacy fingerprint, revision/backup, migration marker, edited content preserved and repeat behaviour checked. |
| Demo indexing and supported structured data | Implemented and tested | Metadata-based opt-in sitemap exclusion tested, no demo scholarly/product claims; no production indexing change. |
| Approved genuine content replacing demonstrations | Blocked | Owner must approve content, adoption/drafting/removal and retained-order file obligations. No real content deleted. |
| Automated accessibility and responsive checks | Implemented and tested | Axe WCAG 2.2 tags plus keyboard, focus, touch, no-JavaScript and 320px reflow checks. Initial issues and retests retained. |
| Full WCAG 2.2 AA conformance, assistive-technology audit and browser zoom | Implemented but unverified | Automated checks and responsive reflow are not a complete manual conformance audit; native browser zoom/AT combinations not exhaustively tested. |
| Firefox/WebKit and other major engine coverage | Blocked | Only Chromium is installed in this environment. |
| Broken font references and asset diagnostics | Implemented and tested | Removed nonexistent fontFace files while preserving fallback stacks; fresh browser asset check and package validation. |
| Before/after representative performance observations | Implemented and tested | Seven local pages measured; after LCP 1.24–2.10s and CLS ≤0.000042 in this run. Machine/cache/server state confound strict attribution. |
| Field p75 LCP/INP/CLS targets | Blocked | No representative field dataset; no field INP or guaranteed score asserted. |
| ZIPs, changed files, screenshots, evidence, install/cache/rollback instructions | Implemented and tested | Current QA report, route data, package manifests and CUSTOMER-EXPERIENCE-2.4.0.md. |
| Production deployment/store visibility/indexing | Blocked | Explicit owner approval and external readiness gates remain. Production was not changed. |

The local candidate is reviewable. Production release remains blocked by hosting access/errors, content/privacy/merchant decisions and explicit deployment approval.
