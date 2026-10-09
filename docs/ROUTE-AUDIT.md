# Route audit — 9 October 2026

Observed on the isolated clean database after ZIP installation. Routes are shown relative to the local site origin. Object IDs are local fixture IDs, not production IDs. Template names were captured using a QA-only response header. PASS below means HTTP 200 after redirects, with no PHP error marker or raw PPT shortcode. It does not imply every interaction on that page was tested. Functional commerce, keyboard and form results are recorded separately in QA-REPORT.md. Checkout redirects to Cart when the basket is empty; a populated browser checkout was also tested. Team/Partners have intentional empty states because no genuine records were supplied.

| Route | Content Type | WordPress Object | Template | HTTP/Functional Status | Notes |
|---|---|---|---|---|---|
| / | page | 84 — Home | block:people-planet-thrive//front-page | PASS HTTP 200 | Functional scope: QA report |
| /about/ | page | 85 — About | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /accessibility/ | page | 102 — Accessibility | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /articles/ | ppt_article | archive — Articles | people-planet-thrive/templates/archive-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-co-designing-neighbourhood-research-with-residents/ | ppt_article | 25 — Co-designing neighbourhood research with residents | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-community-priorities-in-climate-resilience-planning/ | ppt_article | 22 — Community priorities in climate resilience planning | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-digital-inclusion-beyond-access-to-devices/ | ppt_article | 28 — Digital inclusion beyond access to devices | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-education-as-a-foundation-for-sustainable-futures/ | ppt_article | 24 — Education as a foundation for sustainable futures | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-human-wellbeing-as-a-shared-research-question/ | ppt_article | 30 — Human wellbeing as a shared research question | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-local-adaptation-and-the-language-of-risk/ | ppt_article | 27 — Local adaptation and the language of risk | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-policy-learning-when-evidence-is-incomplete/ | ppt_article | 26 — Policy learning when evidence is incomplete | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-public-health-communication-across-unequal-information-environments/ | ppt_article | 23 — Public health communication across unequal information environments | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-responsible-technology-in-community-decision-making/ | ppt_article | 29 — Responsible technology in community decision-making | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /authors/ | ppt_author | archive — Authors | people-planet-thrive/templates/archive-ppt_author.php | PASS HTTP 200 | Functional scope: QA report |
| /authors/demo-demonstration-author-a/ | ppt_author | 10 — Demonstration Author A | people-planet-thrive/templates/single-ppt_author.php | PASS HTTP 200 | Functional scope: QA report |
| /authors/demo-demonstration-author-b/ | ppt_author | 12 — Demonstration Author B | people-planet-thrive/templates/single-ppt_author.php | PASS HTTP 200 | Functional scope: QA report |
| /authors/demo-demonstration-author-c/ | ppt_author | 14 — Demonstration Author C | people-planet-thrive/templates/single-ppt_author.php | PASS HTTP 200 | Functional scope: QA report |
| /careers/ | page | 89 — Careers | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /cart/ | page | 6 — Cart | block:people-planet-thrive//page-cart | PASS HTTP 200 | Functional scope: QA report |
| /checkout/ | page | 7 — Checkout | block:people-planet-thrive//page-cart | PASS HTTP 200 | Functional scope: QA report |
| /conflicts-of-interest/ | page | 99 — Conflicts of Interest | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /contact/ | page | 90 — Contact | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /corrections-retractions/ | page | 98 — Corrections & Retractions | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /demo-building-research-communities-that-last/ | post | 78 — Building Research Communities That Last | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-from-evidence-to-action/ | post | 76 — From Evidence to Action | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-knowledge-as-infrastructure-for-change/ | post | 83 — Knowledge as Infrastructure for Change | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-learning-for-a-sustainable-future/ | post | 80 — Learning for a Sustainable Future | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-making-research-accessible/ | post | 82 — Making Research Accessible | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-the-future-of-scholarly-publishing/ | post | 79 — The Future of Scholarly Publishing | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-what-makes-research-truly-impactful/ | post | 77 — What Makes Research Truly Impactful? | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-why-interdisciplinary-research-matters/ | post | 81 — Why Interdisciplinary Research Matters | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-why-knowledge-must-move-beyond-publication/ | post | 75 — Why Knowledge Must Move Beyond Publication | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /editorial-policies/ | page | 94 — Editorial Policies | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /events/ | ppt_event | archive — Events | people-planet-thrive/templates/archive-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /events/demo-community-research-exchange/ | ppt_event | 72 — Community Research Exchange | people-planet-thrive/templates/single-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /events/demo-knowledge-into-practice-forum/ | ppt_event | 71 — Knowledge into Practice Forum | people-planet-thrive/templates/single-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /events/demo-responsible-innovation-dialogue/ | ppt_event | 74 — Responsible Innovation Dialogue | people-planet-thrive/templates/single-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /events/demo-sustainable-learning-roundtable/ | ppt_event | 73 — Sustainable Learning Roundtable | people-planet-thrive/templates/single-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /for-authors/ | page | 92 — For Authors | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /insights/ | page | 104 — Insights | people-planet-thrive/templates/archive.php | PASS HTTP 200 | Functional scope: QA report |
| /journal-issue/demo-global-health-human-development-review-demonstration-issue-1/ | ppt_journal_issue | 21 — Global Health & Human Development Review — Demonstration Issue 1 | people-planet-thrive/templates/single-ppt_journal_issue.php | PASS HTTP 200 | Functional scope: QA report |
| /journal-issue/demo-journal-of-sustainable-communities-demonstration-issue-1/ | ppt_journal_issue | 19 — Journal of Sustainable Communities — Demonstration Issue 1 | people-planet-thrive/templates/single-ppt_journal_issue.php | PASS HTTP 200 | Functional scope: QA report |
| /journal-issue/demo-people-planet-review-demonstration-issue-1/ | ppt_journal_issue | 17 — People & Planet Review — Demonstration Issue 1 | people-planet-thrive/templates/single-ppt_journal_issue.php | PASS HTTP 200 | Functional scope: QA report |
| /journals/ | ppt_journal | archive — Journals | people-planet-thrive/templates/archive-ppt_journal.php | PASS HTTP 200 | Functional scope: QA report |
| /journals/demo-global-health-human-development-review/ | ppt_journal | 20 — Global Health & Human Development Review | people-planet-thrive/templates/single-ppt_journal.php | PASS HTTP 200 | Functional scope: QA report |
| /journals/demo-journal-of-sustainable-communities/ | ppt_journal | 18 — Journal of Sustainable Communities | people-planet-thrive/templates/single-ppt_journal.php | PASS HTTP 200 | Functional scope: QA report |
| /journals/demo-people-planet-review/ | ppt_journal | 16 — People & Planet Review | people-planet-thrive/templates/single-ppt_journal.php | PASS HTTP 200 | Functional scope: QA report |
| /leadership/ | page | 88 — Leadership | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /mission-vision/ | page | 86 — Mission & Vision | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /my-account/ | page | 8 — My account | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /open-access-policy/ | page | 97 — Open Access Policy | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /our-approach/ | page | 87 — Our Approach | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /partners/ | ppt_partner | archive — Partners | people-planet-thrive/templates/archive-ppt_partner.php | PASS HTTP 200 | Functional scope: QA report |
| /peer-review-policy/ | page | 96 — Peer Review Policy | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /privacy-policy/ | page | 3 — Privacy Policy | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /privacy-policy/ | page | required — Privacy Policy | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-a-practical-question-setting-workbook/ | product | 64 — A Practical Question-Setting Workbook — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-building-resilient-communities/ | product | 46 — Building Resilient Communities — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-community-evidence-a-research-framework/ | product | 56 — Community Evidence: A Research Framework — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-designing-accessible-public-dialogue/ | product | 62 — Designing Accessible Public Dialogue — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-evidence-to-action/ | product | 60 — Evidence to Action — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-inclusive-knowledge-systems/ | product | 58 — Inclusive Knowledge Systems — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-knowledge-into-action/ | product | 50 — Knowledge Into Action — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-learning-across-boundaries/ | product | 54 — Learning Across Boundaries — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-people-planet-progress/ | product | 44 — People, Planet & Progress — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-research-for-real-world-impact/ | product | 52 — Research for Real-World Impact — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-sustainable-futures/ | product | 48 — Sustainable Futures — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /publication-ethics/ | page | 95 — Publication Ethics | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /publications/ | ppt_publication | archive — Publications | people-planet-thrive/templates/archive-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-a-practical-question-setting-workbook/ | ppt_publication | 63 — A Practical Question-Setting Workbook | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-building-resilient-communities/ | ppt_publication | 45 — Building Resilient Communities | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-community-evidence-a-research-framework/ | ppt_publication | 55 — Community Evidence: A Research Framework | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-designing-accessible-public-dialogue/ | ppt_publication | 61 — Designing Accessible Public Dialogue | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-evidence-to-action/ | ppt_publication | 59 — Evidence to Action | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-inclusive-knowledge-systems/ | ppt_publication | 57 — Inclusive Knowledge Systems | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-knowledge-into-action/ | ppt_publication | 49 — Knowledge Into Action | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-learning-across-boundaries/ | ppt_publication | 53 — Learning Across Boundaries | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-people-planet-progress/ | ppt_publication | 43 — People, Planet & Progress | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-research-for-real-world-impact/ | ppt_publication | 51 — Research for Real-World Impact | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-sustainable-futures/ | ppt_publication | 47 — Sustainable Futures | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/ | ppt_research_area | archive — Research Areas | people-planet-thrive/templates/archive-ppt_research_area.php | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-climate-sustainability/ | ppt_research_area | 31 — Climate & Sustainability | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-communities-society/ | ppt_research_area | 37 — Communities & Society | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-education-human-development/ | ppt_research_area | 35 — Education & Human Development | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-health-wellbeing/ | ppt_research_area | 33 — Health & Wellbeing | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-policy-governance/ | ppt_research_area | 41 — Policy & Governance | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-technology-responsible-innovation/ | ppt_research_area | 39 — Technology & Responsible Innovation | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/ | ppt_research_project | archive — Research Projects | people-planet-thrive/templates/archive-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-community-climate-resilience-pathways/ | ppt_research_project | 32 — Community climate resilience pathways | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-community-knowledge-partnerships/ | ppt_research_project | 38 — Community knowledge partnerships | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-evidence-in-local-policy-decisions/ | ppt_research_project | 42 — Evidence in local policy decisions | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-learning-across-the-life-course/ | ppt_research_project | 36 — Learning across the life course | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-responsible-digital-participation/ | ppt_research_project | 40 — Responsible digital participation | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-understanding-everyday-wellbeing/ | ppt_research_project | 34 — Understanding everyday wellbeing | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research/ | page | 103 — Research | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /researchers/ | ppt_researcher | archive — Researchers | people-planet-thrive/templates/archive-ppt_researcher.php | PASS HTTP 200 | Functional scope: QA report |
| /researchers/demo-demonstration-researcher-a/ | ppt_researcher | 11 — Demonstration Researcher A | people-planet-thrive/templates/single-ppt_researcher.php | PASS HTTP 200 | Functional scope: QA report |
| /researchers/demo-demonstration-researcher-b/ | ppt_researcher | 13 — Demonstration Researcher B | people-planet-thrive/templates/single-ppt_researcher.php | PASS HTTP 200 | Functional scope: QA report |
| /researchers/demo-demonstration-researcher-c/ | ppt_researcher | 15 — Demonstration Researcher C | people-planet-thrive/templates/single-ppt_researcher.php | PASS HTTP 200 | Functional scope: QA report |
| /shop/ | page | 5 — Shop | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /shop/ | product | archive — Products | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /submit-manuscript/ | page | 93 — Submit Manuscript | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /team/ | ppt_team_member | archive — Team Members | people-planet-thrive/templates/archive-ppt_team_member.php | PASS HTTP 200 | Functional scope: QA report |
| /terms/ | page | 101 — Terms & Conditions | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /training/ | ppt_training | archive — Training | people-planet-thrive/templates/archive-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-academic-writing-publishing/ | ppt_training | 66 — Academic Writing & Publishing | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-community-research-engagement/ | ppt_training | 69 — Community Research & Engagement | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-evidence-based-policy-development/ | ppt_training | 68 — Evidence-Based Policy Development | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-research-methods-for-real-world-impact/ | ppt_training | 65 — Research Methods for Real-World Impact | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-responsible-ai-for-research/ | ppt_training | 70 — Responsible AI for Research | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-sustainability-leadership/ | ppt_training | 67 — Sustainability Leadership | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /work-with-us/ | page | 91 — Work With Us | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |

Additional negative route: /qa-no-such-route/ returned the branded HTTP 404. Header, homepage CTA and footer links were extracted and fetched: 34 distinct local destinations passed. The configured menu contains no submenu items; custom future submenus need their own check. External destinations and production URLs were not crawled.
