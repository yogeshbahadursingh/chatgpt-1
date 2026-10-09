# Completion handover — 2.3.0, 9 October 2026

1. **Repairs:** connected specialist templates, preserved approved homepage/chrome, repaired setup/navigation, made content dynamic, integrated native WooCommerce, secured demo removal and downloads, and fixed responsive/accessibility defects.
2. **Pages:** setup manages 21 records: Home, About, Mission & Vision, Our Approach, Leadership, Careers, Contact, Work With Us, For Authors, Submit Manuscript, Editorial Policies, Publication Ethics, Peer Review Policy, Open Access Policy, Corrections & Retractions, Conflicts of Interest, Privacy Policy, Terms & Conditions, Accessibility, Research and Insights. Team and Partners use CPT archives; WooCommerce owns its system pages.
3. **Content types:** journals, issues, articles, authors, research areas, research projects, researchers, publications, training, events, team and partners; native posts provide Insights and WooCommerce provides products. See ROUTE-AUDIT.md for observed template/HTTP results.
4. **Demo content:** 74 tagged records, including 3 journals, 3 issues, 9 articles, 3 fictional authors, 3 fictional researchers, 6 research areas, 6 projects, 11 editorial publications, 11 products, 6 training programmes, 4 future events and 9 Insights posts.
5. **Books/files:** 3 physical books, 3 e-books, 2 reports, 2 policy briefs and 1 free resource. The eight digital products contain actual demonstration PDFs. No real ISBN/ISSN/DOI is invented.
6. **Commerce:** native product, cart, checkout, account, order, stock and download functions. Free-order checkout and authorized download tested; paid permission transitions tested on manually completed local orders, without a real payment.
7. **Navigation:** editable shared block navigation, portable object URLs, search, contextual enquiries and footer destinations; local link checks documented.
8. **Routes:** 112 generated entries crawled, covering public records and archives; HTTP checks are distinct from functional/browser evidence.
9. **Animation:** original intro/orb retained; session, reduced-motion and no-JavaScript checks in QA report.
10. **Responsive:** eight requested widths, 320 through 1920; representative page matrix plus populated cart/checkout checks.
11. **Accessibility:** keyboard mobile menu, no-JavaScript navigation, focus styling, contrast/list repairs and axe scans. This is not a full manual screen-reader or WCAG certification.
12. **Security:** capability/nonce gates, specific-object REST authorization, escaped output, protected paid-file metadata, WooCommerce permissions and local direct-file denial. Production download protection still requires hosting checks.
13. **NOT TESTABLE:** external payment completion/callbacks/refunds, real mail and newsletter delivery, real production server/CDN/HTTPS behaviour, field performance, assistive-technology coverage and operator-specific policies/data.
14. **Limitations:** catalogue Publications and WooCommerce Products are linked but edited separately; demo identities/covers/prices are illustrative; existing Site Editor customizations override packaged parts. URL migration or any editorial change may cause demo removal to retain records for manual review.
15. **Theme:** release/people-planet-thrive.zip, extracting to people-planet-thrive/.
16. **Plugin:** release/ppt-core.zip, extracting to ppt-core/.
17. **Production steps:** follow INSTALLATION.md exactly: back up; upload/activate plugin then theme; run Tools → PPT Site Setup; configure WooCommerce and rerun setup; replace demos and approve copy; configure mail, taxes/shipping/gateway and protected downloads; test on staging; obtain operator approval before enabling live store visibility. No production deployment is included in this delivery.

Use QA-REPORT.md for final test statuses and scope. The operator review gate is the final step; no redesign is proposed.
