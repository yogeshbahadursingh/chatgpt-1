# QA report — 2.3.0, 9 October 2026

This report records observed local checks, not production certification. The final packages were installed through WP-CLI ZIP installation on a fresh database. The last theme-only change underlined article breadcrumbs and was repackaged, reinstalled and accessibility-retested. No production database or site was modified.

Environment: WordPress 7.1.2, WooCommerce 11.1.2, PHP 8.0.30, Apache 2.4.58, MariaDB 10.4.32, Playwright Chromium and axe-core. These are recorded test versions, not a hosting recommendation. Mail and outbound WordPress HTTP were intercepted. Browser scans blocked remote origins where specified by their scripts.

| Area | Status | Evidence and boundary |
|---|---|---|
| Clean ZIP installation | PASS | New local database; plugin/theme ZIP installation and activation. Setup returned 21 page IDs without WooCommerce; repeated after Woo activation. Final source matched installed package files. |
| Setup and demo lifecycle | PASS | 14/14 integration checks: repeat import 74/74, repeat setup, edited-page preservation, demo removal, stock and download permissions. |
| Homepage | PASS | Dynamic collections, retained original composition/orb/intro; browser rendering and responsive matrix. |
| Navigation | PASS | 34 distinct header/homepage/footer destinations fetched; mobile keyboard Enter/Escape and no-JavaScript links checked. No submenu was configured. |
| Core Pages | PASS | Nonempty editable setup content and successful routes. Team/Partners remain intentional empty archives. Policy accuracy still requires operator review. |
| Journals and articles | PASS, limited | Demo metadata/relationships inspected; all generated single/archive routes rendered. Representative article included in axe scan. No real scholarly identifiers or editorial approval inferred. |
| Research | PASS, limited | Areas/projects/researchers queried and linked; demo relationships inspected; routes and representative landing-page layout tested. Findings are explicitly demonstration concepts. |
| Publications | PASS | Dynamic product/topic/author/catalogue sections rendered; responsive and axe checks. Catalogue entries and products are edited separately. |
| Physical books | PASS | Native stock/shipping flags, quantity-two browser basket, £48 subtotal, stock decrement/restoration. No paid gateway order. |
| E-books/free resources | PASS | Virtual/downloadable flags and actual PDFs; unpaid permissions absent, manually completed order permissions granted; free browser checkout and authorized PDF response. |
| WooCommerce | PASS, local scope | 6/6 browser commerce/form/404 checks. Direct sample URL denied with HTTP 403. Shop/product/account routes rendered. Native transaction templates retained. |
| Store visibility | PASS | Earlier explicit coming-soon test hid products; live visibility enabled only in local QA to exercise commerce. |
| Training and events | PASS, limited | Six programmes and four future concepts inspected; all generated routes and representative Training layout tested. Enrolment uses configured URLs/contextual enquiries, not an LMS. |
| Insights | PASS, limited | Nine editable posts, archive and singles rendered; categories and related content use WordPress records. |
| Search/filter foundations | PASS, limited | Browser search returned relevant content; shared topics and archive query wiring reviewed. Exhaustive combinations and relevance ranking are not certified. |
| Demo content | PASS | 74 records inspected for nonempty original prose, topics, relationship targets, future events and absence of invented identifiers; zero findings. |
| Public routes | PASS | 112 HTTP responses; no PHP error markers or raw PPT shortcodes. Actual templates listed in ROUTE-AUDIT.md. HTTP checks do not certify all interactions. |
| Responsive | PASS | 56 page/width checks across Home, Publications, Research, Training, Contact, Shop and Product; eight widths 320, 375, 430, 768, 1024, 1280, 1440, 1920. Populated cart/checkout checked at the same widths. No visible control clipping or horizontal overflow in those checks. |
| Keyboard and animation | PASS | 23/23 checks including mobile menu, session intro, reduced motion, no-JavaScript content/navigation, basket and checkout layouts. |
| Automated accessibility | PASS, scoped | 6 representative routes; 0 reported WCAG-tagged axe violations. Contrast on gradients/images has incomplete items requiring human review. This is not a WCAG conformance claim. |
| 404 | PASS | Missing route retained HTTP 404 and branded recovery message. |
| PHP and packaging | PASS | 97 PHP files linted. ZIP roots are people-planet-thrive/ and ppt-core/; 127 and 21 entries respectively; no runtime, credentials, caches or backups packaged. |

## Performance and SEO observations

Local resource inventory: Home 40 resources / 633,189 transferred bytes; Publications 43 / 647,889; physical Product 42 / 639,715. External browser origins were blocked in this measurement. No broken images were observed on those three pages. Custom homepage/orb/intro and specialist styles are conditionally loaded; no new animation framework was added. WooCommerce mini-cart/account integration contributes global assets. These figures are diagnostic payload observations, not Core Web Vitals or production speed scores; global commerce payload and real-device performance should be monitored after launch.

All three pages had a nonempty title and one H1; JSON-LD parsed successfully. Home and Product had native canonical links, Product included WooCommerce Product schema, and the core XML sitemap responded successfully in the navigation test. The Publications archive relies on normal WordPress/SEO-plugin canonical handling; no custom canonical was emitted there. Open Graph and SEO-plugin combinations were not tested. Gradient/image contrast remains a manual review item.

## Security and safe operation

Anonymous setup and demo-import requests both returned HTTP 400; a publication REST response contained no protected download URL. Custom-code review checked capability/nonce gates, sanitization/escaping, specific-object REST authorization, JSON encoding, file metadata and keyed demo ownership. Form invalid-nonce rejection, order download permissions and Apache direct-file denial were tested. This is a focused application review, not a penetration test. Production upload protection, HTTPS, CDN caching and real authentication policies remain NOT TESTABLE here.

Demo removal preserves records whose editorial fingerprint changed. A local URL correction changed 19 fingerprints and conservatively retained those records; the test-only baseline was re-established before rerunning the removal test, which then trashed 73 unchanged demos and retained the intentionally edited record. Do not reset fingerprints on real content to force deletion. Existing database backups and originals remain local.

## NOT TESTABLE / operator checks

- External payment authorization, gateway callbacks, paid/failed/refunded order flows and gateway email integration: no credentials used.
- Real enquiry/newsletter delivery: accepted mail was deliberately intercepted; newsletter points to the operator's configured service.
- Production server/CDN download denial, caching, HTTPS, shipping/tax configuration and field performance: no production deployment/access exercised.
- Manual screen-reader review, physical mobile devices, non-Chromium browser matrix and complete WCAG 2.2 AA conformance: not covered by these automated local checks.
- Genuine operator policies, staff/partners, academic identifiers, product files/prices and editorial accuracy: require supplied/approved information.
- Common SEO-plugin combinations, variable-product combinations, every optional filter and full load testing: not exhaustively exercised.

## Known limitations

Editorial Publications and WooCommerce Products are linked but separately maintained. Demonstration files, profiles, covers, dates and prices must be reviewed/removed before live trading. Saved Site Editor templates override packaged templates and need selective review during upgrades. Legacy named page templates now render editable content; inactive PHP chrome fragments remain for compatibility. No real team/partner claims were seeded. The final human/operator review gate is still required before launch.

## Package integrity

- people-planet-thrive.zip — SHA-256 `e0b68d2b0610a1ae72963f713ca5f01835626a398130dd397f1a50d290cfe9dc`
- ppt-core.zip — SHA-256 `50626b25747c2aef34248391cb73465ea0d3d0f13bc62bcc039586f97bda6652`
