const fs = require('fs');
(async () => {
  const fixtures = JSON.parse(fs.readFileSync('ppt-wordpress/runtime/schema-http-fixtures.json'));
  const results = [];
  for (const fixture of fixtures) {
    if (new URL(fixture.route).hostname !== '127.0.0.1') throw new Error('Run schema QA against the isolated local installation.');
    const response = await fetch(fixture.route, { signal: AbortSignal.timeout(90000) });
    const html = await response.text();
    const schemas = [...html.matchAll(/<script[^>]*type=["']application\/ld\+json["'][^>]*>([\s\S]*?)<\/script>/gi)].map(match => JSON.parse(match[1]));
    const expected = schemas.find(schema => schema['@type'] === fixture.type);
    const breadcrumb = schemas.find(schema => schema['@type'] === 'BreadcrumbList');
    const items = breadcrumb?.itemListElement || [];
    results.push({
      route: fixture.route, label: fixture.label, type: fixture.type, status: response.status,
      pass: response.ok && !!expected && items.length >= 2 && items.every(item => item.name && item.item)
        && !schemas.some(schema => schema.logo?.url?.endsWith('/assets/images/logo.png'))
        && (fixture.type !== 'BreadcrumbList' || items.at(-1).name === fixture.label),
      emittedTypes: schemas.map(schema => schema['@type'])
    });
  }
  fs.writeFileSync('ppt-wordpress/runtime/schema-http-results.json', JSON.stringify(results, null, 2));
  console.log(JSON.stringify({ count: results.length, failures: results.filter(result => !result.pass) }));
  if (results.some(result => !result.pass)) process.exitCode = 1;
})().catch(error => { console.error(error); process.exitCode = 1; });
