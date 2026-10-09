# Route audit — 9 October 2026

Observed on the isolated clean database after ZIP installation. Routes are shown relative to the local site origin. Object IDs are local fixture IDs, not production IDs. Template names were captured using a QA-only response header. PASS below means HTTP 200 after redirects, with no PHP error marker or raw PPT shortcode. It does not imply every interaction on that page was tested. Functional commerce, keyboard and form results are recorded separately in QA-REPORT.md. Checkout redirects to Cart when the basket is empty; a populated browser checkout was also tested. Team/Partners have intentional empty states because no genuine records were supplied.

| Route | Content Type | WordPress Object | Template | HTTP/Functional Status | Notes |
|---|---|---|---|---|---|
| / | page | 4 — Home | block:people-planet-thrive//front-page | PASS HTTP 200 | Functional scope: QA report |
| /about/ | page | 5 — About | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /accessibility/ | page | 22 — Accessibility | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /article-type/concept-article/ | taxonomy:ppt_article_type | 21 — Concept article | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/ | ppt_article | archive — Articles | people-planet-thrive/templates/archive-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-co-designing-neighbourhood-research-with-residents/ | ppt_article | 50 — Co-designing neighbourhood research with residents | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-community-priorities-in-climate-resilience-planning/ | ppt_article | 47 — Community priorities in climate resilience planning | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-digital-inclusion-beyond-access-to-devices/ | ppt_article | 53 — Digital inclusion beyond access to devices | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-education-as-a-foundation-for-sustainable-futures/ | ppt_article | 49 — Education as a foundation for sustainable futures | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-human-wellbeing-as-a-shared-research-question/ | ppt_article | 55 — Human wellbeing as a shared research question | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-local-adaptation-and-the-language-of-risk/ | ppt_article | 52 — Local adaptation and the language of risk | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-policy-learning-when-evidence-is-incomplete/ | ppt_article | 51 — Policy learning when evidence is incomplete | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-public-health-communication-across-unequal-information-environments/ | ppt_article | 48 — Public health communication across unequal information environments | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /articles/demo-responsible-technology-in-community-decision-making/ | ppt_article | 54 — Responsible technology in community decision-making | people-planet-thrive/templates/single-ppt_article.php | PASS HTTP 200 | Functional scope: QA report |
| /authors/ | ppt_author | archive — Authors | people-planet-thrive/templates/archive-ppt_author.php | PASS HTTP 200 | Functional scope: QA report |
| /authors/demo-demonstration-author-a/ | ppt_author | 35 — Demonstration Author A | people-planet-thrive/templates/single-ppt_author.php | PASS HTTP 200 | Functional scope: QA report |
| /authors/demo-demonstration-author-b/ | ppt_author | 37 — Demonstration Author B | people-planet-thrive/templates/single-ppt_author.php | PASS HTTP 200 | Functional scope: QA report |
| /authors/demo-demonstration-author-c/ | ppt_author | 39 — Demonstration Author C | people-planet-thrive/templates/single-ppt_author.php | PASS HTTP 200 | Functional scope: QA report |
| /careers/ | page | 9 — Careers | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /cart/ | page | 31 — Cart | block:people-planet-thrive//page-cart | PASS HTTP 200 | Functional scope: QA report |
| /category/commentary/ | taxonomy:category | 39 — Commentary | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /category/interviews/ | taxonomy:category | 45 — Interviews | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /category/learning/ | taxonomy:category | 42 — Learning | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /category/news/ | taxonomy:category | 44 — News | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /category/policy/ | taxonomy:category | 38 — Policy | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /category/publishing/ | taxonomy:category | 41 — Publishing | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /category/research/ | taxonomy:category | 37 — Research | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /category/society/ | taxonomy:category | 40 — Society | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /category/sustainability/ | taxonomy:category | 43 — Sustainability | block:people-planet-thrive//archive | PASS HTTP 200 | Functional scope: QA report |
| /checkout/ | page | 32 — Checkout | block:people-planet-thrive//page-cart | PASS HTTP 200 | Functional scope: QA report |
| /conflicts-of-interest/ | page | 19 — Conflicts of Interest | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /contact/ | page | 10 — Contact | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /corrections-retractions/ | page | 18 — Corrections & Retractions | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /demo-building-research-communities-that-last/ | post | 103 — Building Research Communities That Last | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-from-evidence-to-action/ | post | 101 — From Evidence to Action | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-knowledge-as-infrastructure-for-change/ | post | 108 — Knowledge as Infrastructure for Change | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-learning-for-a-sustainable-future/ | post | 105 — Learning for a Sustainable Future | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-making-research-accessible/ | post | 107 — Making Research Accessible | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-the-future-of-scholarly-publishing/ | post | 104 — The Future of Scholarly Publishing | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-what-makes-research-truly-impactful/ | post | 102 — What Makes Research Truly Impactful? | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-why-interdisciplinary-research-matters/ | post | 106 — Why Interdisciplinary Research Matters | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /demo-why-knowledge-must-move-beyond-publication/ | post | 100 — Why Knowledge Must Move Beyond Publication | people-planet-thrive/templates/single.php | PASS HTTP 200 | Functional scope: QA report |
| /editorial-policies/ | page | 14 — Editorial Policies | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /events/ | ppt_event | archive — Events | people-planet-thrive/templates/archive-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /events/demo-community-research-exchange/ | ppt_event | 97 — Community Research Exchange | people-planet-thrive/templates/single-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /events/demo-knowledge-into-practice-forum/ | ppt_event | 96 — Knowledge into Practice Forum | people-planet-thrive/templates/single-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /events/demo-responsible-innovation-dialogue/ | ppt_event | 99 — Responsible Innovation Dialogue | people-planet-thrive/templates/single-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /events/demo-sustainable-learning-roundtable/ | ppt_event | 98 — Sustainable Learning Roundtable | people-planet-thrive/templates/single-ppt_event.php | PASS HTTP 200 | Functional scope: QA report |
| /for-authors/ | page | 12 — For Authors | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /insights/ | page | 24 — Insights | people-planet-thrive/templates/archive.php | PASS HTTP 200 | Functional scope: QA report |
| /journal-issue/demo-global-health-human-development-review-demonstration-issue-1/ | ppt_journal_issue | 46 — Global Health & Human Development Review — Demonstration Issue 1 | people-planet-thrive/templates/single-ppt_journal_issue.php | PASS HTTP 200 | Functional scope: QA report |
| /journal-issue/demo-journal-of-sustainable-communities-demonstration-issue-1/ | ppt_journal_issue | 44 — Journal of Sustainable Communities — Demonstration Issue 1 | people-planet-thrive/templates/single-ppt_journal_issue.php | PASS HTTP 200 | Functional scope: QA report |
| /journal-issue/demo-people-planet-review-demonstration-issue-1/ | ppt_journal_issue | 42 — People & Planet Review — Demonstration Issue 1 | people-planet-thrive/templates/single-ppt_journal_issue.php | PASS HTTP 200 | Functional scope: QA report |
| /journals/ | ppt_journal | archive — Journals | people-planet-thrive/templates/archive-ppt_journal.php | PASS HTTP 200 | Functional scope: QA report |
| /journals/demo-global-health-human-development-review/ | ppt_journal | 45 — Global Health & Human Development Review | people-planet-thrive/templates/single-ppt_journal.php | PASS HTTP 200 | Functional scope: QA report |
| /journals/demo-journal-of-sustainable-communities/ | ppt_journal | 43 — Journal of Sustainable Communities | people-planet-thrive/templates/single-ppt_journal.php | PASS HTTP 200 | Functional scope: QA report |
| /journals/demo-people-planet-review/ | ppt_journal | 41 — People & Planet Review | people-planet-thrive/templates/single-ppt_journal.php | PASS HTTP 200 | Functional scope: QA report |
| /leadership/ | page | 8 — Leadership | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /mission-vision/ | page | 6 — Mission & Vision | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /my-account/ | page | 33 — My account | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /open-access-policy/ | page | 17 — Open Access Policy | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /our-approach/ | page | 7 — Our Approach | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /partners/ | ppt_partner | archive — Partners | people-planet-thrive/templates/archive-ppt_partner.php | PASS HTTP 200 | Functional scope: QA report |
| /peer-review-policy/ | page | 16 — Peer Review Policy | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /privacy-policy/ | page | 3 — Privacy Policy | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /privacy-policy/ | page | required — Privacy Policy | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /product-category/books/ | taxonomy:product_cat | 26 — Books | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product-category/e-books/ | taxonomy:product_cat | 28 — E-books | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product-category/free-resources/ | taxonomy:product_cat | 34 — Free Resources | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product-category/policy-briefs/ | taxonomy:product_cat | 32 — Policy Briefs | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product-category/research-reports/ | taxonomy:product_cat | 30 — Research Reports | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-a-practical-question-setting-workbook/ | product | 89 — A Practical Question-Setting Workbook — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-building-resilient-communities/ | product | 71 — Building Resilient Communities — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-community-evidence-a-research-framework/ | product | 81 — Community Evidence: A Research Framework — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-designing-accessible-public-dialogue/ | product | 87 — Designing Accessible Public Dialogue — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-evidence-to-action/ | product | 85 — Evidence to Action — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-inclusive-knowledge-systems/ | product | 83 — Inclusive Knowledge Systems — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-knowledge-into-action/ | product | 75 — Knowledge Into Action — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-learning-across-boundaries/ | product | 79 — Learning Across Boundaries — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-people-planet-progress/ | product | 69 — People, Planet & Progress — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-research-for-real-world-impact/ | product | 77 — Research for Real-World Impact — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /product/demo-product-sustainable-futures/ | product | 73 — Sustainable Futures — Demo | people-planet-thrive/woocommerce/single-product.php | PASS HTTP 200 | Functional scope: QA report |
| /publication-ethics/ | page | 15 — Publication Ethics | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /publication-type/books/ | taxonomy:ppt_publication_type | 25 — Books | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /publication-type/e-books/ | taxonomy:ppt_publication_type | 27 — E-books | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /publication-type/free-resources/ | taxonomy:ppt_publication_type | 33 — Free Resources | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /publication-type/policy-briefs/ | taxonomy:ppt_publication_type | 31 — Policy Briefs | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /publication-type/research-reports/ | taxonomy:ppt_publication_type | 29 — Research Reports | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/ | ppt_publication | archive — Publications | people-planet-thrive/templates/archive-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-a-practical-question-setting-workbook/ | ppt_publication | 88 — A Practical Question-Setting Workbook | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-building-resilient-communities/ | ppt_publication | 70 — Building Resilient Communities | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-community-evidence-a-research-framework/ | ppt_publication | 80 — Community Evidence: A Research Framework | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-designing-accessible-public-dialogue/ | ppt_publication | 86 — Designing Accessible Public Dialogue | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-evidence-to-action/ | ppt_publication | 84 — Evidence to Action | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-inclusive-knowledge-systems/ | ppt_publication | 82 — Inclusive Knowledge Systems | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-knowledge-into-action/ | ppt_publication | 74 — Knowledge Into Action | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-learning-across-boundaries/ | ppt_publication | 78 — Learning Across Boundaries | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-people-planet-progress/ | ppt_publication | 68 — People, Planet & Progress | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-research-for-real-world-impact/ | ppt_publication | 76 — Research for Real-World Impact | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /publications/demo-sustainable-futures/ | ppt_publication | 72 — Sustainable Futures | people-planet-thrive/templates/single-ppt_publication.php | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/ | ppt_research_area | archive — Research Areas | people-planet-thrive/templates/archive-ppt_research_area.php | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-climate-sustainability/ | ppt_research_area | 56 — Climate & Sustainability | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-communities-society/ | ppt_research_area | 62 — Communities & Society | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-education-human-development/ | ppt_research_area | 60 — Education & Human Development | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-health-wellbeing/ | ppt_research_area | 58 — Health & Wellbeing | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-policy-governance/ | ppt_research_area | 66 — Policy & Governance | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-areas/demo-technology-responsible-innovation/ | ppt_research_area | 64 — Technology & Responsible Innovation | block:people-planet-thrive//single | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/ | ppt_research_project | archive — Research Projects | people-planet-thrive/templates/archive-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-community-climate-resilience-pathways/ | ppt_research_project | 57 — Community climate resilience pathways | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-community-knowledge-partnerships/ | ppt_research_project | 63 — Community knowledge partnerships | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-evidence-in-local-policy-decisions/ | ppt_research_project | 67 — Evidence in local policy decisions | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-learning-across-the-life-course/ | ppt_research_project | 61 — Learning across the life course | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-responsible-digital-participation/ | ppt_research_project | 65 — Responsible digital participation | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research-projects/demo-understanding-everyday-wellbeing/ | ppt_research_project | 59 — Understanding everyday wellbeing | people-planet-thrive/templates/single-ppt_research_project.php | PASS HTTP 200 | Functional scope: QA report |
| /research/ | page | 23 — Research | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /researchers/ | ppt_researcher | archive — Researchers | people-planet-thrive/templates/archive-ppt_researcher.php | PASS HTTP 200 | Functional scope: QA report |
| /researchers/demo-demonstration-researcher-a/ | ppt_researcher | 36 — Demonstration Researcher A | people-planet-thrive/templates/single-ppt_researcher.php | PASS HTTP 200 | Functional scope: QA report |
| /researchers/demo-demonstration-researcher-b/ | ppt_researcher | 38 — Demonstration Researcher B | people-planet-thrive/templates/single-ppt_researcher.php | PASS HTTP 200 | Functional scope: QA report |
| /researchers/demo-demonstration-researcher-c/ | ppt_researcher | 40 — Demonstration Researcher C | people-planet-thrive/templates/single-ppt_researcher.php | PASS HTTP 200 | Functional scope: QA report |
| /shop/ | page | 30 — Shop | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /shop/ | product | archive — Products | people-planet-thrive/woocommerce/archive-product.php | PASS HTTP 200 | Functional scope: QA report |
| /subject-area/climate-sustainability/ | taxonomy:ppt_subject_area | 18 — Climate &amp; Sustainability | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /subject-area/communities-society/ | taxonomy:ppt_subject_area | 22 — Communities &amp; Society | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /subject-area/education-human-development/ | taxonomy:ppt_subject_area | 20 — Education &amp; Human Development | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /subject-area/health-wellbeing/ | taxonomy:ppt_subject_area | 19 — Health &amp; Wellbeing | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /subject-area/policy-governance/ | taxonomy:ppt_subject_area | 24 — Policy &amp; Governance | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /subject-area/technology-responsible-innovation/ | taxonomy:ppt_subject_area | 23 — Technology &amp; Responsible Innovation | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /submit-manuscript/ | page | 13 — Submit Manuscript | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /team/ | ppt_team_member | archive — Team Members | people-planet-thrive/templates/archive-ppt_team_member.php | PASS HTTP 200 | Functional scope: QA report |
| /terms/ | page | 21 — Terms & Conditions | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |
| /training-type/course/ | taxonomy:ppt_training_type | 35 — Course | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /training-type/workshop/ | taxonomy:ppt_training_type | 36 — Workshop | people-planet-thrive/templates/taxonomy.php | PASS HTTP 200 | Functional scope: QA report |
| /training/ | ppt_training | archive — Training | people-planet-thrive/templates/archive-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-academic-writing-publishing/ | ppt_training | 91 — Academic Writing & Publishing | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-community-research-engagement/ | ppt_training | 94 — Community Research & Engagement | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-evidence-based-policy-development/ | ppt_training | 93 — Evidence-Based Policy Development | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-research-methods-for-real-world-impact/ | ppt_training | 90 — Research Methods for Real-World Impact | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-responsible-ai-for-research/ | ppt_training | 95 — Responsible AI for Research | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /training/demo-sustainability-leadership/ | ppt_training | 92 — Sustainability Leadership | people-planet-thrive/templates/single-ppt_training.php | PASS HTTP 200 | Functional scope: QA report |
| /work-with-us/ | page | 11 — Work With Us | block:people-planet-thrive//page | PASS HTTP 200 | Functional scope: QA report |

Additional negative route: /qa-no-such-route/ returned the branded HTTP 404. Header, homepage CTA and footer links were extracted and fetched: 34 distinct local destinations passed. The configured menu contains no submenu items; custom future submenus need their own check. External destinations and production URLs were not crawled.
