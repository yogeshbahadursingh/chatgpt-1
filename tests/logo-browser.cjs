const fs = require('fs');
const crypto = require('crypto');
const { chromium } = require('playwright');
let browser;
(async () => {
  const origin = process.env.PPT_QA_ORIGIN || 'http://127.0.0.1:8877';
  const out = 'ppt-wordpress/runtime';
  const results = [];
  browser = await chromium.launch();
  const page = await browser.newPage({ reducedMotion: 'reduce' });
  page.setDefaultNavigationTimeout(90000);
  await page.goto(origin, { waitUntil: 'domcontentloaded' });
  await page.locator('.ppt-brand-lockup img.custom-logo').waitFor();
  for (const width of [320, 375, 768, 1280, 1366, 1440, 1920]) {
    await page.setViewportSize({ width, height: 1000 });
    await page.waitForTimeout(200);
    const geometry = await page.evaluate(() => ({
      overflow: document.documentElement.scrollWidth > innerWidth + 1,
      logos: [...document.querySelectorAll('.ppt-brand-lockup img.custom-logo,.ppt-planet-orb img.custom-logo,.ppt-footer-brand img.custom-logo')].map(img => {
        const r = img.getBoundingClientRect();
        return { alt: img.alt, loaded: img.complete && img.naturalWidth > 0, width: r.width, height: r.height, fits: r.left >= -1 && r.right <= innerWidth + 1, href: img.closest('a')?.href, source: img.currentSrc };
      }),
      brandTitleVisible: getComputedStyle(document.querySelector('.ppt-brand-lockup > .wp-block-group')).display !== 'none' && document.querySelector('.ppt-brand-title').getBoundingClientRect().width > 0
    }));
    results.push({ test: `Compact logo and visible name at ${width}px`, pass: !geometry.overflow && geometry.brandTitleVisible && geometry.logos.length === 3 && geometry.logos[0].width <= (width <= 782 ? 48 : 64) && geometry.logos.every(i => i.loaded && i.alt === 'People & Planet Thrive' && i.fits && Math.abs(i.width / i.height - 1.5) < .035 && i.href === origin + '/'), ...geometry });
    if ([375, 1366].includes(width)) {
      await page.screenshot({ path: `${out}/logo-home-${width}.png` });
      await page.locator('.ppt-premium-footer').scrollIntoViewIfNeeded();
      await page.waitForTimeout(1000);
      await page.locator('.ppt-premium-footer').screenshot({ path: `${out}/logo-footer-${width}.png` });
      await page.evaluate(() => window.scrollTo(0, 0));
    }
  }
  for (const route of ['/', '/insights/']) {
    await page.goto(origin + route, { waitUntil: 'domcontentloaded' });
    await page.waitForTimeout(1500);
    await page.addScriptTag({ path: out + '/qa-deps/node_modules/axe-core/axe.min.js' });
    const report = await page.evaluate(() => axe.run(document, { runOnly: { type: 'tag', values: ['wcag2a','wcag2aa','wcag21aa','wcag22aa'] } }));
    results.push({ test: `Accessibility ${route}`, pass: report.violations.length === 0, violations: report.violations, incomplete: report.incomplete.map(i => i.id) });
  }
  const schemas = await page.locator('script[type="application/ld+json"]').allTextContents();
  const entities = schemas.flatMap(s => { const v = JSON.parse(s); return v['@graph'] || [v]; });
  const organization = entities.find(v => v['@type'] === 'Organization');
  const logoURL = typeof organization?.logo === 'string' ? organization.logo : organization?.logo?.url;
  const response = logoURL ? await page.request.get(logoURL) : null;
  results.push({ test: 'Organization logo resolves to the configured artwork', pass: !!response?.ok() && logoURL.includes('people-planet-thrive-logo'), logoURL });
  const servedHash = response?.ok() ? crypto.createHash('sha256').update(await response.body()).digest('hex') : null;
  const sourceHash = crypto.createHash('sha256').update(fs.readFileSync('ppt-wordpress/source/people-planet-thrive/assets/images/people-planet-thrive-logo.png')).digest('hex');
  results.push({ test: 'HTTP original image is byte-for-byte the supplied artwork', pass: servedHash === sourceHash, servedHash, sourceHash });
  fs.writeFileSync(out + '/logo-browser-results.json', JSON.stringify(results, null, 2));
  console.log(JSON.stringify({ count: results.length, failures: results.filter(r => !r.pass) }, null, 2));
  if (results.some(r => !r.pass)) process.exitCode = 1;
})().catch(e => { console.error(e); process.exitCode = 1; }).finally(async () => { if (browser) await browser.close(); });
