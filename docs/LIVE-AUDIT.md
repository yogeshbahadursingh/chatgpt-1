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
