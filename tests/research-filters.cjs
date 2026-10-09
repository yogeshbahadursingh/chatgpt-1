// Read-only. Build fixtures with WP-CLI eval-file research-filter-fixtures.php first.
const fs = require('fs');
const {chromium} = require('playwright');
const fixture = JSON.parse(fs.readFileSync('ppt-wordpress/runtime/research-filter-fixtures.json', 'utf8').replace(/^\uFEFF/,''));
const results = [];
const normalize = value => value === 'planned' ? 'planning' : value;
const topic = fixture.projects.flatMap(p => p.topics)[0];
const scenarios = [
  {name:'all', params:{}},
  {name:'planning includes legacy planned records', params:{status:'planning'}},
  {name:'legacy planned query alias', params:{status:'planned'}},
  {name:'active', params:{status:'active'}},
  {name:'completed', params:{status:'completed'}},
  {name:'on hold', params:{status:'on-hold'}},
  {name:'missing topic stays empty', params:{ppt_topic:2147483647}},
];
if (topic) scenarios.push({name:'topic', params:{ppt_topic:topic}}, {name:'combined planning and topic', params:{status:'planning',ppt_topic:topic}});
(async () => {
  const browser = await chromium.launch({headless:true});
  const context = await browser.newContext({javaScriptEnabled:false});
  await context.route('**/*', route => route.abort());
  const page = await context.newPage();
  try {
    for (const scenario of scenarios) {
      const expected = fixture.projects.filter(p => (!scenario.params.status || normalize(p.status) === normalize(scenario.params.status)) && (!scenario.params.ppt_topic || p.topics.includes(Number(scenario.params.ppt_topic))));
      const url = new URL(fixture.base);
      for (const [key,value] of Object.entries(scenario.params)) url.searchParams.set(key,String(value));
      const response = await fetch(url, {signal:AbortSignal.timeout(30000)});
      const html = await response.text();
      await page.setContent(html, {waitUntil:'domcontentloaded'});
      const actual = await page.locator('.ppt-project-card h2 a').evaluateAll(nodes => nodes.map(n => n.getAttribute('href')));
      const expectedUrls = expected.slice(0,12).map(p => p.url);
      const activeFilter = await page.locator('main a[aria-current="page"]').textContent();
      const issues = [];
      if (response.status !== 200) issues.push(`HTTP ${response.status}`);
      if (/Fatal error|Warning:|Parse error/.test(html)) issues.push('PHP error');
      if (JSON.stringify(actual) !== JSON.stringify(expectedUrls)) issues.push('result URLs differ from stored records');
      if (!actual.length && !(await page.locator('main').innerText()).includes('New work is being prepared')) issues.push('missing empty state');
      if (normalize(scenario.params.status) === 'planning' && activeFilter !== 'Planning') issues.push('planning is not identified as selected');
      if (scenario.params.ppt_topic) {
        const filters = await page.locator('main a[aria-current="page"]').locator('..').locator('a').evaluateAll(nodes => nodes.map(n => n.getAttribute('href')));
        if (filters.some(href => new URL(href).searchParams.get('ppt_topic') !== String(scenario.params.ppt_topic))) issues.push('status links drop topic');
      }
      results.push({name:scenario.name,status:issues.length?'FAIL':'PASS',expected:expectedUrls.length,actual:actual.length,issues});
    }
  } finally {
    await browser.close();
    fs.writeFileSync('ppt-wordpress/runtime/research-filter-results.json',JSON.stringify({checks:results,pagination:fixture.projects.length>12?'Additional pages need a separate browser check':'NOT TESTABLE: this read-only fixture has fewer than 13 published projects'},null,2));
  }
  console.log(JSON.stringify(results,null,2));
  if (results.some(r => r.status === 'FAIL')) process.exitCode = 1;
})().catch(error => { console.error(error); process.exitCode = 1; });
