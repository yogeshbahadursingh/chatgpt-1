# Installation and production handover

These packages continue the supplied WordPress theme and PPT Core plugin. They are not a replacement CMS. Do not deploy the local test database, runtime directory, test orders, mail interception plugin or local configuration.

## Clean installation

1. Install WordPress on the intended host and configure HTTPS, the site title, administrator account and timezone. Back up any existing installation before proceeding.
2. In Plugins → Add New → Upload Plugin, upload `ppt-core.zip`, install and activate it.
3. In Appearance → Themes → Add New → Upload Theme, upload `people-planet-thrive.zip`, install and activate it.
4. Open Tools → PPT Site Setup and run Create / Repair Site. It seeds missing editable pages, a static Home, Insights as the posts page, and shared block navigation. Review Settings → Reading if the installation already had a front page; existing choices are preserved.
5. Install and activate WooCommerce. Run PPT Site Setup again to create its missing Shop, Cart, Checkout and My Account pages. Complete WooCommerce's business, currency, shipping, tax and payment configuration with genuine operator details.
6. On staging, use Tools → PPT Demo Content → Import. Confirm journals, research, publications, training, events and insights appear. The importer creates 3 journals, 3 issues, 9 articles, 3 fictional author profiles, 3 fictional researcher profiles, 6 areas, 6 projects, 11 editorial publications, 11 products, 6 programmes, 4 future event concepts and 9 insights. It does not invent real team members or partner organisations.
7. Use Appearance → Editor to edit Home's copy, header, navigation and footer. Upload a genuine site logo. Edit institutional and policy text in Pages. Configure recipient, public contact details, newsletter signup and social URL in Settings → PPT Platform.
8. Approve the privacy/terms/publishing policies and establish mail delivery before enabling enquiries. The seeded policy text is launch-stage content; it is not a final operator-specific legal policy. Test real mail delivery separately from form acceptance.
9. Add genuine products, covers and stock. For paid files configure WooCommerce's protected download method and verify direct file requests are denied by the production web server and any CDN. Test payment callbacks, paid and failed orders, refunds, accounts and permitted downloads using the gateway's sandbox.
10. Remove demo content before live trading. The removal action trashes unchanged demos and preserves edited/adopted records. Review retained records and sample files; never delete files still required by retained orders. Disable or remove all test payment settings and orders.
11. Test all public routes, mobile navigation, the contact form and commerce on staging. Inspect the supplied QA report for checks that were not possible locally. Keep the approved design and review the result before enabling live payments or inviting submissions.

## Updating an existing installation

Back up the database, uploads, current theme and plugin. Update PPT Core, then the theme, on staging first. Run Site Setup once. Existing pages, content, front-page selection and custom Site Editor header are preserved. A previously saved block template may override the packaged version; compare it in the Site Editor and selectively merge changes rather than deleting custom content. Existing conflicting `team` or `partners` Pages require manual review because those routes belong to CPT archives; this updater does not delete them automatically.

## URLs and hosting

Set WordPress Address and Site Address correctly. Run the host's normal WordPress migration procedure, including a serialized-data-safe URL replacement for saved content and media URLs. Object-backed navigation resolves current WordPress links. Root-relative theme block links support subdirectory installations. Save permalinks once after migration if the host requires rewrite regeneration.

Paid-download security depends on the real server configuration. Apache `.htaccess` rules do not protect files on Nginx or a misconfigured CDN. See [WooCommerce's download handling guide](https://woocommerce.com/document/digital-downloadable-product-handling/). Template selection follows [WordPress's template hierarchy](https://developer.wordpress.org/themes/templates/template-hierarchy/), with a narrow bridge for this theme's existing specialist PHP templates.

## What not to upload

Upload only the two release ZIPs. The `checkpoint`, `runtime` and `tests` directories are local development/QA materials. Runtime contains local database files, configuration and test data and must not be included in hosting uploads. Documentation can be retained separately by the administrator.

## Final launch sequence

After the staging checks above, back up production, upload PPT Core then the theme, run Site Setup once, verify Settings → Reading and the shared navigation, and clear page/CDN caches. Recheck enquiries, account access, one physical-product gateway sandbox order and one digital-product sandbox order. Confirm shipping/tax totals, paid/failed order behaviour, download authorization and direct-file denial. Approve all institutional/policy text and replace demonstration covers and records with genuine material. In WooCommerce → Settings → Site visibility, enable the live store only after the operator approves these checks. No production deployment has been performed as part of this delivery.
