# People & Planet Thrive — WordPress production completion

Continuation of the supplied premium WordPress theme and PPT Core plugin. The approved homepage design remains the basis of the implementation.

- `source/people-planet-thrive`: theme
- `source/ppt-core`: plugin
- `release/`: installable ZIP snapshots
- `docs/`: architecture audit, installation and administrator guides
- `tests/`: local WordPress/Playwright QA scripts

## Current status

Work in progress; not yet approved for production. A clean ZIP installation and 14 integration checks passed. A crawl of 112 generated public routes returned HTTP 200 without PHP errors or raw PPT shortcodes. Free-resource browser checkout and authorised PDF retrieval passed; direct sample file access returned HTTP 403. Enquiry acceptance was tested using an intercepted local mail transport, not real delivery.

Remaining work includes 320px homepage card clipping, WooCommerce coming-soon/template interaction, product-list semantics, final accessibility and keyboard retests, final package verification and QA documentation. Live payment gateways, production mail, production server/CDN download protection and final operator policy content have not been verified. Consult `docs/QA-REPORT.md` for evidence and limitations.

No local database, WordPress configuration, credentials, test runtime, uploads or original backup ZIPs are included. Runtime paths in test scripts refer to an isolated local QA installation that must be provisioned separately.
