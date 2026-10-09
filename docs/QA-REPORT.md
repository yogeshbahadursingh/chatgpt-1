# QA report — current checkpoint, 9 October 2026

This is an interim report. Do not treat the presence of code or a successful HTTP response as proof of full functional completion.

| Check | Status | Evidence / limit |
|---|---|---|
| ZIP install: PPT Core, theme, activation and setup without WooCommerce | PASS | WP-CLI clean installation; 21 setup page IDs returned |
| WooCommerce activation and setup rerun | PASS | Separate clean database and package install |
| Repeat demo import | PASS | 74 records before and after |
| Setup idempotency and edited page preservation | PASS | Integration assertions |
| Demo removal | PASS | 73 unchanged records trashed, one edited record preserved; genuine page preserved |
| Physical product stock/shipping | PASS | Native product flags, quantity reduction and restoration |
| E-book virtual/downloadable configuration | PASS | Actual demonstration PDF assigned |
| Unpaid/completed order permissions | PASS | No unpaid permission; completed test order permission granted without a payment gateway |
| Free-resource browser checkout | PASS | Order received and authorised PDF response verified |
| Direct sample download URL | PASS | HTTP 403 on isolated Apache installation |
| Enquiry form and nonce rejection | PASS | Valid request accepted by intercepted mail; invalid nonce rejected |
| Branded missing route | PASS | HTTP 404 retained |
| Public route crawl | PASS | 112 responses, no PHP fatal/warning markers or raw PPT shortcodes; functional checks separate |
| Responsive layouts | FAIL | 320px homepage publication cards clip; duplicate H1 from WooCommerce coming-soon content on shop/product |
| Automated accessibility | FAIL | Five scanned routes have no violations after contrast fixes; product still has link-in-text-block and list findings |
| Full keyboard/screen-reader audit | NOT TESTABLE | Not yet completed at this checkpoint |
| Animation session/reduced-motion/no-JS checks | NOT TESTABLE | Source preserves sessionStorage and reduced motion; final browser assertions pending |
| External payment completion | NOT TESTABLE | No gateway credentials used |
| Real mail/newsletter delivery | NOT TESTABLE | Mail deliberately intercepted; newsletter links to configured external service |
| Production performance, HTTPS/CDN, download protection | NOT TESTABLE | No production server access/configuration verified |
| Final release acceptance | NOT TESTABLE | Remaining fixes and final package retests pending |

Local environment: WordPress 7.1.2, WooCommerce 11.1.2, PHP 8.0.30, Apache 2.4.58 and MariaDB 10.4.32. This records the test environment, not a recommendation for production runtime versions.

Known limitations: publication catalogue records and WooCommerce products are linked but edited separately; launch policies require operator-specific approval; no genuine academic identifiers, staff identities, partnerships, findings or credentials were supplied. Original backup archives and detailed runtime evidence remain local and are excluded from Git.
