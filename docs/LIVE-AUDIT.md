# About / Terms scope note — 15 October 2026

This bounded follow-up changes only the local candidate. No production deployment or new live-host health claim was made. About and Terms preparation, approval blockers and actual local tests are recorded in [ABOUT-TERMS-2.4.1.md](ABOUT-TERMS-2.4.1.md). The hosting findings below remain unresolved.

---

# Current 2.4.0 candidate — public observations, 15 October 2026

**Production was not modified. The live site is not verified healthy.** The local candidate and the production observations are separate.

An initial read-only crawl of 171 actual linked/system paths returned 156 HTTP 200 responses, one branded 404 for the supplied retail URL, and 14 HTTP 500 database-error pages. Home, Insights and Work With Us were accessible independently; the earlier external-tool 403 was not reproduced. Public asset URLs indicated theme 2.3.4 and PPT Core 2.3.2, not an authenticated inventory. Store/Cart/Checkout showed the WooCommerce holding page; Checkout redirected to Cart. This supersedes the historical claim that those store endpoints were 404s in the earlier audit. Account rendered a real login page.

The actual browser initially displayed “There has been a critical error on this website” at /wp-admin/. A later low-frequency retest returned plain server-level 404 pages at Contact, an ebook taxonomy, a publication detail, /wp-admin/ and the supplied retail URL. This is changed observable behaviour, not proof the database issue was resolved. See [initial observations](qa-evidence/cx-2.4.0/live-results.json) and [later retest](qa-evidence/cx-2.4.0/live-retest.json). Hosting error/access logs were requested; no authenticated repair or production deployment was attempted.

The supplied /shop/items/R283838545/ lead did not resolve to retail content during the initial crawl. A search did not return matching indexed results at that time. That does not establish historical indexing or rule out compromise. Production files, users, database, redirects and Search Console Security Issues/Manual Actions/URL Inspection are still blocked. Preserve evidence and investigate through authorised hosting access.

Some live holding responses allowed a 60-second cache lifetime while Account was private/no-cache. Holding-page headers do not establish cache safety for real carts, orders or authenticated sessions. SpeedyCache/CDN configuration is uninspected. Local form/cart/checkout/account no-store behaviour and explicit deployment exclusions are documented in [the release handover](CUSTOMER-EXPERIENCE-2.4.0.md).

---

## Historical evidence below — versions as originally recorded

# Live website audit — 9 October 2026

Subsequent local release 2.3.3 adds the owner-supplied logo; see [LOGO-UPDATE.md](LOGO-UPDATE.md). This public audit remains unchanged and does not establish that the new packages are deployed.

Target: https://ppthrive.com/. This was a public, read-only audit. No administrator login, production files/database, settings, payments or messages were changed. Local source repairs are release 2.3.2; the live pages inspected still served PPT 2.3.0 assets. Local PASS results do not mean the live site is repaired.

The homepage link crawl fetched 127 discovered public paths: all returned HTTP 200, with no detected PHP fatal markers, raw PPT shortcodes or local development URLs. A separate system-route check found four critical 404s. Discovery-only crawling had missed those absent destinations, so it was not sufficient evidence of completion.

| URL / area | Observed issue | Priority | Root cause / confidence | Repair and verification state |
|---|---|---|---|---|
| /shop/, /cart/, /checkout/, /my-account/ | All four returned 404 | P1 | WooCommerce inactive or its setup/pages missing is an inference; public access cannot establish installed plugin state | Native Woo integration and setup provided locally. Production activation/configuration requires approval and administrator access. |
| /publications/ | The same latest editorial titles repeated in every format section | P1 | Confirmed fallback query omitted the publication-type constraint when WooCommerce was unavailable | Fixed both Woo and editorial section queries; automated fallback membership checks cover all five types. |
| /contact/ | Displays “Our enquiry service is being prepared”; no enquiry form | P1 | Enquiries disabled or recipient missing; actual mail configuration not accessible | Safe disabled state preserved. Local acceptance and nonce checks use intercepted mail. Operator must configure recipient and verify delivery. |
| /publications/demo-people-planet-progress/ | Editorial book has no working commercial journey on live site | P1 | Native store unavailable as above | Linked product validity, free/paid/preview labels and Woo transactions tested locally; real payment setup remains outside public audit. |
| Shared /publication-type/ and /subject-area/ routes with WooCommerce active | Reproduced locally: null-product fatal from routing mixed records into a Woo product loop | P1 | Narrowed template selection now distinguishes product-only and mixed taxonomies | Mixed knowledge template and expanded public taxonomy route coverage added. Store-only holding mode also requires editorial/product separation. |
| Research project status/topic filters | Locally reproduced: planned/planning mismatch and custom query bypass of topic/pagination | P1 | Status vocabulary and query architecture disagreed | Main query now preserves topic/status and native pagination; legacy records supported without rewriting them. |
| Journal submission | Locally reproduced: action pointed at an optional fragment; journal policies not rendered | P1 | Incomplete template journey | Action now reaches Submit Manuscript; configured policies and editorial links rendered. |
| Demonstration products | Prior package could permit fictional products to be purchased after store activation | P1 | Demonstration marker previously only labelled content | Production purchase guard added to product/cart/checkout/order-pay paths; genuine products retain native behavior. |
| Header / Insights screenshot | Wrapped navigation, undersized title, weak spacing; live header disappeared at inspected collapsed width | P2 | Missing CSS aliases and conflicting responsive rules; screenshot route itself was not supplied | Tokens repaired, compact ivory/gold sticky header refined, native overlay unclipped, keyboard/no-JS/reduced-motion checks added. |
| JSON-LD on editorial book | Two Organization entries; external entry has empty name; theme logo points to absent logo.png | P2 | Theme assumes logo asset; unknown live SEO provider also emits Organization | Theme emits configured logo only, supports explicit standard-schema ownership. External provider's empty details need admin configuration; exact provider not established. |
| /wp-sitemap.xml | Redirects to /sitemaps.xml, returns XML sitemap index | Observation | Live sitemap provider owns endpoint | Public response verified. Full search-engine indexing/SEO plugin compatibility not certified. |
| /robots.txt, /?s=climate, missing route | 200, 200, expected 404 respectively | Observation | Public response checks | Search result relevance and full crawler policy require separate review. |

## Evidence and limits

Local evidence files: `runtime/live-route-results.json`, `runtime/live-system-results.json`, and `runtime/live-home.html`; browser inspection covered Home, Publications, a book, Contact and the collapsed header. A book-page browser console inspection returned no errors; this is not a site-wide console certification. No live order or form was submitted. Hosting, CDN/cache, mail delivery, gateway callbacks, actual operator policies and saved Site Editor overrides remain unverified.

See FIX-LOG.md for the patch sequence, ROUTE-AUDIT.md for the expanded installed-release crawl, QA-REPORT.md for local functional results, and INSTALLATION.md for the approval-gated application and rollback procedure.
