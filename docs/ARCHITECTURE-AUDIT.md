# Architecture audit — supplied v2.2 archives

Checkpoint: ../checkpoint, originals preserved. No production database accessed.

Findings from actual code:
- Block theme with PHP CPT/page templates under templates/ and PHP parts under parts/; no template_include bridge and no root header/footer. Specialist templates are unreachable through normal hierarchy.
- Setup inserts empty content, omits research/insights routes, points Insights at Home, creates team/partners pages over CPT routes, and deletes defaults using title/slug alone.
- Block navigation is independent of the classic menu created by setup.
- Demo importer unconditionally inserts posts, has no stable keys, no WooCommerce products, fixed past event dates, and permanently deletes marked posts.
- Homepage preserves a premium composition but research/publications/training are static placeholders. Insights query is dynamic.
- Publication file URL appears in REST and templates even when linked to a paid product.
- Product override omits standard summary/tabs extension hooks; cart/checkout overrides require compatibility review.
- Meta boxes generally check nonce/capability; REST meta authorization only checks edit_posts, not the specific object. Schema JSON needs HTML-safe encoding.
- Footer/contact defaults contain unverified phone/address/legal identity. Newsletter UI has no delivery backend.
- Legacy patterns contain unsupported statistics and testimonials; must not seed those.
- Intro uses sessionStorage and reduced motion; resilience and visual checks remain pending.
- Version headers/constants disagree.

Plan: repair bootstrap and routing while retaining original premium markup/CSS; seed editable page content; make demo import keyed and reversible; integrate native WooCommerce; connect dynamic sections; test isolated install, then package and reinstall. All claims in final QA must cite actual test evidence. Existing local site is not the test target.
