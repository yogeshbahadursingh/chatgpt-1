const fs = require('fs');
const { chromium } = require('playwright');
let browser;

(async () => {
  browser = await chromium.launch();
  const page = await browser.newPage();
  const results = [];
  const origin = process.env.PPT_QA_ORIGIN || 'http://127.0.0.1:8877';
  const output = 'ppt-wordpress/runtime';
  page.setDefaultNavigationTimeout(90000);
  await page.goto(origin + '/', { waitUntil: 'domcontentloaded' });
  await page.waitForTimeout(2800);
  results.push({ test: 'Premium navigation stylesheet loads', pass: await page.locator('#ppt-navigation-premium-css').count() === 1 });
  for (const width of [320, 375, 768, 1280, 1366, 1440, 1920]) {
    await page.setViewportSize({ width, height: 920 });
    await page.waitForTimeout(150);
    const geometry = await page.locator('.ppt-premium-header').evaluate(header => ({
      overflow: document.documentElement.scrollWidth > innerWidth + 1,
      clipped: [...header.querySelectorAll('a,input,button')].filter(e => {
        const r = e.getBoundingClientRect();
        return r.width && r.height && (r.left < -1 || r.right > innerWidth + 1);
      }).map(e => e.getAttribute('aria-label') || e.textContent.trim()),
      height: header.offsetHeight
    }));
    results.push({ test: `Header fits ${width}px`, pass: !geometry.overflow && geometry.clipped.length === 0, ...geometry });
    if (width === 1366 || width === 375) await page.screenshot({ path: `${output}/navigation-premium-${width}.png` });
  }
  await page.setViewportSize({ width: 375, height: 920 });
  const open = page.locator('.ppt-main-nav .wp-block-navigation__responsive-container-open');
  await open.focus();
  await page.keyboard.press('Enter');
  const overlay = page.locator('.ppt-main-nav .wp-block-navigation__responsive-container.is-menu-open');
  results.push({ test: 'Mobile menu opens with keyboard', pass: await overlay.isVisible() });
  await page.waitForTimeout(300);
  results.push({ test: 'Mobile menu covers viewport and all links fit', pass: await overlay.evaluate(e => {
    const rect = e.getBoundingClientRect();
    return rect.width >= innerWidth && rect.height >= innerHeight && [...e.querySelectorAll('a')].every(a => a.getBoundingClientRect().right <= innerWidth);
  }) });
  await page.screenshot({ path: `${output}/navigation-premium-menu-375.png` });
  await page.keyboard.press('Escape');
  results.push({ test: 'Escape closes menu and restores focus', pass: await overlay.count() === 0 && await open.evaluate(e => document.activeElement === e) });
  await page.setViewportSize({ width: 1366, height: 920 });
  await page.evaluate(() => window.scrollTo(0, 700));
  await page.waitForTimeout(200);
  results.push({ test: 'Header stays visible on scroll', pass: await page.locator('.ppt-premium-header').evaluate(e => Math.abs(e.getBoundingClientRect().top) <= 1 && e.classList.contains('is-scrolled')) });
  await page.screenshot({ path: `${output}/navigation-premium-scrolled-1366.png` });
  // Exercise the same body class WordPress applies to signed-in administrators.
  await page.evaluate(() => document.body.classList.add('admin-bar'));
  results.push({ test: 'Desktop admin-bar offset is applied once', pass: await page.locator('.ppt-premium-header').evaluate(e => Math.abs(e.getBoundingClientRect().top - 32) <= 1) });
  await page.setViewportSize({ width: 375, height: 920 });
  results.push({ test: 'Mobile header has no stale admin-bar offset after scrolling', pass: await page.locator('.ppt-premium-header').evaluate(e => Math.abs(e.getBoundingClientRect().top) <= 1) });
  await page.evaluate(() => document.body.classList.remove('admin-bar'));
  const noJS = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 375, height: 920 } });
  const noJSPage = await noJS.newPage();
  await noJSPage.goto(origin + '/', { waitUntil: 'domcontentloaded' });
  results.push({ test: 'No-JavaScript mobile menu stays accessible', pass: await noJSPage.locator('.ppt-main-nav .wp-block-navigation-item__content').first().isVisible() });
  const reduced = await browser.newContext({ reducedMotion: 'reduce' });
  const reducedPage = await reduced.newPage();
  await reducedPage.goto(origin + '/', { waitUntil: 'domcontentloaded' });
  results.push({ test: 'Reduced motion disables header transitions', pass: await reducedPage.locator('.ppt-premium-header').evaluate(e => {
    const style = getComputedStyle(e);
    return style.transitionProperty === 'none' || style.transitionDuration.split(',').every(value => parseFloat(value) === 0);
  }) });
  fs.writeFileSync(`${output}/navigation-premium-results.json`, JSON.stringify(results, null, 2));
  console.log(JSON.stringify({ count: results.length, failures: results.filter(r => !r.pass) }));
  if (results.some(r => !r.pass)) process.exitCode = 1;
})().catch(error => { console.error(error); process.exitCode = 1; }).finally(async () => {
  if (browser) await browser.close();
});
