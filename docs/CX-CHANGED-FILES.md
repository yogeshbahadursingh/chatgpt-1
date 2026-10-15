# Changed-file summary — 2.4.0

- Core enquiry handling, private records, privacy callbacks and frontend enhancement: new `includes/enquiries.php` and `assets/js/enquiries.js`; old email-only definitions removed from `platform.php`.
- Editable collaboration pattern and conservative migration: new core `includes/customer-experience.php`, page seeds and version metadata.
- Shared presentation: new theme `inc/customer-experience.php` and `assets/css/customer-experience.css`; page/footer/archive/detail templates use the common components. Saved header/navigation data is preserved.
- Honest content and recovery: training/event actions, demonstration metadata/schema, search zero results, contextual publication/research support, conditional contents and non-blocking animation.
- Accessibility/performance: inline link distinction, password target size, status contrast, removal of nonexistent font registrations.
- Release: both installable ZIPs and versioned sanitised evidence. Source line endings were normalised in three files during whitespace verification.

## Source files

- [source/people-planet-thrive/README.md](../source/people-planet-thrive/README.md)
- [source/people-planet-thrive/assets/css/customer-experience.css](../source/people-planet-thrive/assets/css/customer-experience.css)
- [source/people-planet-thrive/assets/fonts/README.md](../source/people-planet-thrive/assets/fonts/README.md)
- [source/people-planet-thrive/assets/js/brand-intro.js](../source/people-planet-thrive/assets/js/brand-intro.js)
- [source/people-planet-thrive/assets/js/header.js](../source/people-planet-thrive/assets/js/header.js)
- [source/people-planet-thrive/assets/js/table-of-contents.js](../source/people-planet-thrive/assets/js/table-of-contents.js)
- [source/people-planet-thrive/functions.php](../source/people-planet-thrive/functions.php)
- [source/people-planet-thrive/inc/completion.php](../source/people-planet-thrive/inc/completion.php)
- [source/people-planet-thrive/inc/customer-experience.php](../source/people-planet-thrive/inc/customer-experience.php)
- [source/people-planet-thrive/parts/footer.html](../source/people-planet-thrive/parts/footer.html)
- [source/people-planet-thrive/patterns/home-what-we-do.php](../source/people-planet-thrive/patterns/home-what-we-do.php)
- [source/people-planet-thrive/style.css](../source/people-planet-thrive/style.css)
- [source/people-planet-thrive/templates/archive-ppt_event.php](../source/people-planet-thrive/templates/archive-ppt_event.php)
- [source/people-planet-thrive/templates/archive-ppt_journal.php](../source/people-planet-thrive/templates/archive-ppt_journal.php)
- [source/people-planet-thrive/templates/archive-ppt_publication.php](../source/people-planet-thrive/templates/archive-ppt_publication.php)
- [source/people-planet-thrive/templates/archive-ppt_research_project.php](../source/people-planet-thrive/templates/archive-ppt_research_project.php)
- [source/people-planet-thrive/templates/archive-ppt_training.php](../source/people-planet-thrive/templates/archive-ppt_training.php)
- [source/people-planet-thrive/templates/front-page.html](../source/people-planet-thrive/templates/front-page.html)
- [source/people-planet-thrive/templates/page.html](../source/people-planet-thrive/templates/page.html)
- [source/people-planet-thrive/templates/search.html](../source/people-planet-thrive/templates/search.html)
- [source/people-planet-thrive/templates/single-ppt_event.php](../source/people-planet-thrive/templates/single-ppt_event.php)
- [source/people-planet-thrive/templates/single-ppt_research_project.php](../source/people-planet-thrive/templates/single-ppt_research_project.php)
- [source/people-planet-thrive/templates/single-ppt_researcher.php](../source/people-planet-thrive/templates/single-ppt_researcher.php)
- [source/people-planet-thrive/templates/single-ppt_training.php](../source/people-planet-thrive/templates/single-ppt_training.php)
- [source/people-planet-thrive/templates/single.php](../source/people-planet-thrive/templates/single.php)
- [source/people-planet-thrive/templates/taxonomy.php](../source/people-planet-thrive/templates/taxonomy.php)
- [source/people-planet-thrive/theme.json](../source/people-planet-thrive/theme.json)
- [source/ppt-core/README.md](../source/ppt-core/README.md)
- [source/ppt-core/assets/js/enquiries.js](../source/ppt-core/assets/js/enquiries.js)
- [source/ppt-core/includes/class-ppt-site-setup.php](../source/ppt-core/includes/class-ppt-site-setup.php)
- [source/ppt-core/includes/customer-experience.php](../source/ppt-core/includes/customer-experience.php)
- [source/ppt-core/includes/enquiries.php](../source/ppt-core/includes/enquiries.php)
- [source/ppt-core/includes/page-content.php](../source/ppt-core/includes/page-content.php)
- [source/ppt-core/includes/platform.php](../source/ppt-core/includes/platform.php)
- [source/ppt-core/ppt-core.php](../source/ppt-core/ppt-core.php)

## Verification and documentation

- [tests/cx-browser-fixtures.php](../tests/cx-browser-fixtures.php)
- [tests/cx-browser.cjs](../tests/cx-browser.cjs)
- [tests/cx-commerce.cjs](../tests/cx-commerce.cjs)
- [tests/cx-commerce.php](../tests/cx-commerce.php)
- [tests/cx-contents.cjs](../tests/cx-contents.cjs)
- [tests/cx-contents.php](../tests/cx-contents.php)
- [tests/cx-discovery.php](../tests/cx-discovery.php)
- [tests/cx-editability.cjs](../tests/cx-editability.cjs)
- [tests/cx-editability.php](../tests/cx-editability.php)
- [tests/cx-editor.cjs](../tests/cx-editor.cjs)
- [tests/cx-enquiries.php](../tests/cx-enquiries.php)
- [tests/cx-followup.cjs](../tests/cx-followup.cjs)
- [tests/cx-inventory.php](../tests/cx-inventory.php)
- [tests/cx-live-retest.cjs](../tests/cx-live-retest.cjs)
- [tests/cx-live.cjs](../tests/cx-live.cjs)
- [tests/cx-nav-auth.cjs](../tests/cx-nav-auth.cjs)
- [tests/cx-observe.cjs](../tests/cx-observe.cjs)
- [tests/cx-purchase.cjs](../tests/cx-purchase.cjs)
- [tests/cx-recovery.cjs](../tests/cx-recovery.cjs)
- [tests/cx-responsive.cjs](../tests/cx-responsive.cjs)
- [tests/cx-routes.cjs](../tests/cx-routes.cjs)
- [tests/cx-schema.cjs](../tests/cx-schema.cjs)
- [tests/cx-smoke.cjs](../tests/cx-smoke.cjs)

Current acceptance commands are in [tests/README.md](../tests/README.md). LIVE-AUDIT, FIX-LOG, ROUTE-AUDIT, QA-REPORT, INSTALLATION and COMPLETION-REPORT now identify current evidence separately from historical releases. The release handover, requirement matrix, route inventory and evidence directory contain limitations, before/after screenshots and deployment/rollback steps. Private runtime exports, sessions and database backups are not included.
