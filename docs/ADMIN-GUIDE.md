# Administrator guide — People & Planet Thrive 2.3.2

## First installation
Follow INSTALLATION.md. Pages and template parts are editable WordPress records; commercial products, orders and download permissions belong to WooCommerce.

## Journals and articles
In Journals, add a title, description, excerpt and cover. Use Journal Details for aims/scope, editorial information, policies, author guidance and a current issue ID. Leave ISSN/eISSN blank unless assigned. Create a Journal Issue, set its journal ID, volume and issue number, then select it as the journal's current issue. Add Articles with an abstract, keywords, journal/issue IDs, author IDs, publication details and references. Only use genuine DOIs. Article PDFs are public scholarly resources; do not use these fields for paid files.

Add Authors as separate profiles, with consented biography, affiliation and optional genuine identifiers. Copy a record ID from its editor URL (`post=123`). Comma-separated author IDs control article authorship.

## Research
Add Research Areas, Researchers and Research Projects. In the project metadata choose status, lead/area IDs, team IDs, timeline, methods and outputs. Use content headings for objectives, overview and limitations. Do not present proposed work as completed research. Shared Subject Areas connect research to articles, books, training and insights.

## Books and e-books
Create Products in WooCommerce. Use Simple product for one format or Variable product for paperback/hardback variants. Enter real price, tax status, SKU, stock and shipping dimensions/weight through WooCommerce. Add a cover and a useful short description. The Publication details panel provides subtitle, author, genuine ISBN, publication date, edition, page count, language, format, contents, author biography, licence and a public sample URL.

For an e-book, enable Virtual and Downloadable. Upload PDF/EPUB through the product's downloadable-files field, set download limits/expiry as appropriate, and set a price (zero for a free resource). Do not paste paid files into the public sample field, article PDF field, publication file URL or an ordinary public Media Library link.

Choose Books, E-books, Research Reports, Policy Briefs or Free Resources in Publication Types. Products populate the Publications landing sections. Add an editorial Publication record for the same title and link it to the WooCommerce product ID; this record provides the scholarly catalogue entry and purchase link. The two records have distinct purposes; update editorial content and commercial fields in the appropriate record. Products created manually are not automatically mirrored into Publications.

Set featured products with WooCommerce's star for the Publications landing feature. Use the PPT featuring checkbox on editorial Publications, Research Projects and Training for their homepage slots; latest records are used when none are featured.

## Download protection and orders
Under WooCommerce → Settings → Products → Downloadable products choose Force downloads or a correctly configured X-Accel-Redirect/X-Sendfile method. Verify Approved download directories. Protect `woocommerce_uploads` against direct web requests on the production web server; Apache rules alone do not configure Nginx or a CDN. A random filename is not access control. Test a signed-in buyer, an unpaid order, expired/exhausted links and direct file requests on production staging.

WooCommerce grants permissions according to order/payment state. Orders show downloadable product permissions, with controls to grant/revoke access. Customers access authorised files through order emails and My Account → Downloads. Never mark a real order completed merely to test it.

## Training and events
Use Training for courses, workshops, webinars and professional development. Enter audience, level, delivery mode, duration, learning outcomes and registration destination. Trainer credentials and accreditation must be verified before publication. Use Events for dated opportunities, with start/end dates, location or virtual access details and registration links. Demo dates are illustrative future dates calculated at first import, not confirmed schedules.

## Insights
Use Posts with categories, featured image, excerpt and content. The Insights page is the posts index. Categories such as Research, Policy, Learning, Publishing and News are editable in Posts → Categories. Add shared Subject Areas and related IDs when appropriate.

## Related content
Use Subject Areas consistently across content types. The PPT featuring and related content panel accepts explicit comma-separated IDs; these take priority over automatic topic matches. Public related lists show published records only. Use the existing specialised relationship fields for journal/issue, author, lead researcher and product connections.

## Pages, navigation and footer
Edit institutional and policy copy in Pages. Home's approved composition, shared header and footer are in Appearance → Editor. Edit the PPT Primary navigation record through the header Navigation block. Site Setup creates the referenced header only when no custom header exists, preserving later edits. The theme resolves navigation object links at render time.

Footer text and link groups are editable in the Site Editor. Settings → PPT Platform provides public contact address, newsletter signup URL and social profile URL. The newsletter link connects to your chosen service; this package does not operate a mailing-list backend.

## Enquiries
Configure a recipient in Settings → PPT Platform, approve privacy information, configure mail delivery, then enable enquiries. Contact and manuscript/careers pages render the form. Work With Us links preselect the relevant category. Required fields, nonce validation, a honeypot and short rate limit apply. A successful response means WordPress accepted the mail request, not that the recipient received it. Test delivery and spam handling using your production mail service.

## Demo content
Tools → PPT Demo Content offers Import and Remove. Stable internal keys make reimport idempotent. Demo content is visibly labelled and internally tagged `_ppt_demo_content=1`. Prices, profiles, events, publications and PDFs are demonstrations, not commercial or academic claims.

Tagged demo products cannot be bought in production, including through direct basket URLs, Store API, saved baskets or order-payment routes. They remain readable previews. The opt-in described in INSTALLATION.md permits isolated QA commerce only; genuine products retain WooCommerce behavior. Adopt a demo as genuine content only after replacing its fictional text, sample files, cover, pricing and rights information with approved material.

Removal moves unchanged importer-owned records to Trash. Edited content and adopted records are preserved. To retain a demo record as genuine work, update it accurately and select “Keep this record as genuine content”. Reimport will not overwrite or duplicate it. Records in Trash are not silently restored; use WordPress Trash → Restore when desired. Download files are retained to avoid destroying permissions or files associated with retained orders. Remove obsolete sample files manually only after checking orders and retention needs.

## Structured data ownership

Set a genuine site logo; when none exists, the theme omits its schema logo. Books/e-books emit Book, research reports emit Report, and other publication formats emit CreativeWork. The editor's ISBN field is used only for books. Known SEO integrations suppress the theme's Organization/BreadcrumbList. For another provider, an administrator's integration plugin can use `add_filter('ppt_standard_schema_owned_by_seo', '__return_true');`. This leaves specialist scholarly/publication schema in place; the existing `ppt_schema_output` filter can coordinate that separately. Inspect the rendered JSON-LD after configuring the provider. The live audit's external empty Organization entry requires correction in its actual owner, which could not be identified through authenticated settings in this audit.

## Safe maintenance
Back up database, uploads, theme and plugin before updates. Site Setup never overwrites existing editorial pages (except the exact untouched WordPress draft privacy starter). Exact unedited English Hello World and Sample Page defaults are moved to Draft, not deleted; other locales or modified starters require administrator review. Existing custom templates can override packaged block layouts; review them in the Site Editor during upgrades. Test plugin/theme updates on staging before production.
