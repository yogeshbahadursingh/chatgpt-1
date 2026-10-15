// Local component regression checks. Does not change WordPress content or settings.
const fs = require('fs'), path = require('path'), { chromium } = require('playwright');
const root = path.resolve(__dirname, '..'), out = path.join(root, 'runtime/orbit');
const url = process.env.PPT_TEST_URL || 'http://127.0.0.1:8877/';
const results = [], errors = [], geometry = [];
fs.mkdirSync(out, { recursive: true });
function check(test, pass, detail) { results.push({ test, pass: !!pass, detail }); console.log(test + ': ' + !!pass); if (!pass) throw Error(test); }
const wait = (p, ms = 250) => p.waitForTimeout(ms);
const state = p => p.locator('.ppt-hero-art').evaluate(e => ({
  motion: e.dataset.motion, manual: e.dataset.manualPause,
  time: e.querySelector('svg').getCurrentTime(),
  animations: e.getAnimations({ subtree: true }).map(a => ({ name: a.animationName, time: a.currentTime, state: a.playState })),
  depth: [e.querySelector('.ppt-planet-orb').style.getPropertyValue('--ppt-depth-x'), e.querySelector('.ppt-planet-orb').style.getPropertyValue('--ppt-depth-y')],
  logo: e.querySelector('img').getBoundingClientRect().toJSON(),
  copy: document.querySelector('.ppt-lux-hero-copy').getBoundingClientRect().toJSON(),
  dots: [...e.querySelectorAll('.ppt-orbit-traveller')].map(d => { const m = d.getScreenCTM(); return [m.e, m.f]; })
}));
const frozen = (a, b) => Math.abs(a.time - b.time) < .02 && a.animations.every((x, i) => Math.abs(x.time - b.animations[i].time) < 2) && JSON.stringify(a.depth) === JSON.stringify(b.depth);
async function load(p) { p.setDefaultNavigationTimeout(90000); p.on('pageerror', e => errors.push(e.message)); p.on('console', m => { if (m.type() === 'error') errors.push(m.text()); }); await p.goto(url, { waitUntil: 'networkidle' }); }
(async () => {
  let browser;
  try {
    browser = await chromium.launch();
    const context = await browser.newContext({ viewport: { width: 1440, height: 1000 }, reducedMotion: 'no-preference' });
    await context.addInitScript(() => {
      window.orbitFrames = 0; window.orbitShifts = [];
      const raf = window.requestAnimationFrame;
      window.requestAnimationFrame = function (cb) { if ((new Error().stack || '').includes('hero-orb.js')) window.orbitFrames++; return raf.call(window, cb); };
      new PerformanceObserver(list => { for (const e of list.getEntries()) if (e.sources?.some(s => s.node?.closest?.('.ppt-hero-art'))) window.orbitShifts.push(e.value); }).observe({ type: 'layout-shift', buffered: true });
    });
    const p = await context.newPage(); await load(p);
    const art = p.locator('.ppt-hero-art'), button = p.locator('.ppt-orb-motion-control'), orb = p.locator('.ppt-planet-orb');
    await p.waitForFunction(() => document.querySelector('.ppt-hero-art').dataset.motion === 'running');
    await p.evaluate(() => { window.orbitShifts = []; });
    const a = await state(p); await wait(p, 700); const b = await state(p);
    check('Ambient motion advances with exactly three CSS animations and two native path motions', b.time > a.time + .5 && b.animations.length === 3 && await art.locator('animateMotion').count() === 2, b);
    check('Logo card and surrounding text remain stationary', JSON.stringify(a.logo) === JSON.stringify(b.logo) && JSON.stringify(a.copy) === JSON.stringify(b.copy));
    check('Decorations hidden from assistive technology and pointer hits', await art.locator('.ppt-orb-decoration').evaluate(e => e.getAttribute('aria-hidden') === 'true' && getComputedStyle(e).pointerEvents === 'none'));
    // Reach the real control through keyboard order rather than programmatic focus.
    await p.keyboard.press('Control+Home');
    let reached = false;
    for (let i = 0; i < 45; i++) { await p.keyboard.press('Tab'); if (await button.evaluate(e => e === document.activeElement)) { reached = true; break; } }
    check('Pause control reachable by keyboard with visible focus', reached && await button.evaluate(e => getComputedStyle(e).outlineStyle !== 'none'));
    await p.keyboard.press('Enter'); await wait(p); const paused = await state(p); await wait(p, 350);
    check('Enter pauses all ambient clocks', paused.manual === 'true' && frozen(paused, await state(p)));
    // Check path alignment across full cycles, including the wrap at each lap.
    const pathCheck = await art.evaluate(async e => {
      const svg = e.querySelector('svg'), travellers = [...e.querySelectorAll('.ppt-orbit-traveller')];
      let maxError = 0; const seams = [];
      for (const t of [0, .01, 3, 8, 16, 24, 31.99, 32, 32.01, 37.99, 38, 38.01, 48, 64, 76]) {
        svg.setCurrentTime(t); await new Promise(requestAnimationFrame);
        for (const d of travellers) {
          const ring = d.parentNode.querySelector('path'), duration = Number(d.dataset.duration);
          const expected = ring.getPointAtLength(((t % duration) / duration) * ring.getTotalLength());
          const matrix = d.parentNode.getScreenCTM().inverse().multiply(d.getScreenCTM());
          maxError = Math.max(maxError, Math.hypot(matrix.e - expected.x, matrix.f - expected.y));
        }
      }
      for (const d of travellers) {
        const duration = Number(d.dataset.duration); svg.setCurrentTime(duration - .001); await new Promise(requestAnimationFrame); const before = d.getScreenCTM();
        svg.setCurrentTime(duration + .001); await new Promise(requestAnimationFrame); const after = d.getScreenCTM();
        seams.push(Math.hypot(before.e - after.e, before.f - after.f));
      }
      svg.setCurrentTime(0); return { maxErrorSvgUnits: maxError, seamDisplacementsCssPx: seams };
    });
    check('Dots stay on their actual paths throughout 32s/38s laps', pathCheck.maxErrorSvgUnits < 1, pathCheck);
    check('Lap boundaries have no discontinuity', pathCheck.seamDisplacementsCssPx.every(x => x < 1), pathCheck);
    await button.press('Space'); await wait(p); check('Space resumes motion', (await state(p)).motion === 'running');
    const box = await orb.boundingBox();
    await p.mouse.move(box.x + box.width * .85, box.y + box.height * .25); await wait(p, 1000);
    const pointer = await state(p), distance = Math.hypot(...pointer.depth.map(parseFloat));
    check('Fine-pointer depth moves decorations within 8px', distance > 1 && distance <= 8.01, pointer.depth);
    check('Pointer cannot move the logo or hero copy', JSON.stringify(pointer.logo) === JSON.stringify(a.logo) && JSON.stringify(pointer.copy) === JSON.stringify(a.copy));
    // Keyboard click preserves the pointer position while toggling pause.
    await button.press('Enter'); await wait(p); const pointerPaused = await state(p);
    await p.mouse.move(box.x + 30, box.y + 30); await wait(p, 400);
    check('Pause also freezes pointer-driven depth', frozen(pointerPaused, await state(p)));
    await p.mouse.move(10, 10); await button.press('Enter'); await wait(p, 1500);
    check('Pointer leave returns gently to centre', (await state(p)).depth.every(x => Math.abs(parseFloat(x)) < .02));
    const frames = await p.evaluate(() => window.orbitFrames); await wait(p, 500);
    check('Pointer rAF stops after settling; no continuous JS render loop', frames === await p.evaluate(() => window.orbitFrames));
    check('Ambient motion, pointer depth and pause cause no component layout shifts', (await p.evaluate(() => window.orbitShifts)).length === 0, await p.evaluate(() => window.orbitShifts));
    await p.evaluate(() => window.scrollTo(0, document.body.scrollHeight)); await wait(p, 400); const offscreen = await state(p); await wait(p, 300);
    check('Offscreen motion suspends', offscreen.motion === 'paused' && frozen(offscreen, await state(p)));
    await p.evaluate(() => window.scrollTo(0, 0)); await wait(p, 400); check('Onscreen ambient motion resumes', (await state(p)).motion === 'running');
    await button.click(); await p.evaluate(() => window.scrollTo(0, document.body.scrollHeight)); await wait(p); await p.evaluate(() => window.scrollTo(0, 0)); await wait(p);
    check('Scrolling away/back preserves manual pause', (await state(p)).manual === 'true' && (await state(p)).motion === 'paused');
    await button.click();
    // Headless Chromium does not expose tab occlusion reliably. Exercise the real handler with a controlled visibility property.
    await p.evaluate(() => { Object.defineProperty(document, 'hidden', { configurable: true, get: () => true }); document.dispatchEvent(new Event('visibilitychange')); });
    await wait(p); const hidden = await state(p); await wait(p, 300); check('Visibility handler suspends clocks (simulated hidden tab)', hidden.motion === 'paused' && frozen(hidden, await state(p)));
    await p.evaluate(() => { delete document.hidden; document.dispatchEvent(new Event('visibilitychange')); }); await wait(p); check('Visibility handler resumes when visible', (await state(p)).motion === 'running');
    await button.click();
    await p.evaluate(() => { Object.defineProperty(document, 'hidden', { configurable: true, get: () => true }); document.dispatchEvent(new Event('visibilitychange')); delete document.hidden; document.dispatchEvent(new Event('visibilitychange')); });
    check('Visibility return preserves manual pause', (await state(p)).manual === 'true' && (await state(p)).motion === 'paused');
    await p.emulateMedia({ reducedMotion: 'reduce' }); await wait(p);
    const reduced = await state(p); await wait(p, 300);
    check('Live reduced-motion preference gives a complete static composition', reduced.animations.length === 0 && reduced.time === 0 && frozen(reduced, await state(p)) && await button.isDisabled());
    await p.screenshot({ path: out + '/reduced-motion.png' });
    await p.emulateMedia({ reducedMotion: 'no-preference' }); await wait(p); check('Reduced-motion toggle does not clear manual pause', (await state(p)).manual === 'true' && (await state(p)).motion === 'paused');
    await button.click();
    await p.addScriptTag({ url: await p.locator('script[src*="hero-orb.js"]').first().getAttribute('src') });
    check('Reinitialisation cannot duplicate native motion elements', await art.locator('animateMotion').count() === 2);
    await button.click(); check('Reinitialisation cannot duplicate button listeners', (await state(p)).manual === 'true'); await button.click();
    for (const width of [360, 390, 600, 768, 900, 1024, 1280, 1440, 1920]) {
      await p.setViewportSize({ width, height: 1000 }); await orb.evaluate(e => e.scrollIntoView({ block: 'center', behavior: 'instant' })); await wait(p, 250);
      const g = await art.evaluate(e => {
        const r = e.getBoundingClientRect(), img = e.querySelector('img'), i = img.getBoundingClientRect(), b = e.querySelector('button').getBoundingClientRect(), hero = e.closest('.ppt-lux-hero').getBoundingClientRect(), orb = e.querySelector('.ppt-planet-orb').getBoundingClientRect();
        return { width: innerWidth, overflow: document.documentElement.scrollWidth > innerWidth + 1, logoLoaded: img.complete && img.naturalWidth > 0, logoInsideViewport: i.left >= 0 && i.right <= innerWidth, squareSphere: Math.abs(orb.width - orb.height) < 1, buttonInsideHero: b.bottom <= hero.bottom + 1, buttonInsideViewport: b.left >= 0 && b.right <= innerWidth, art: r.toJSON(), logo: i.toJSON() };
      }); geometry.push(g);
      check('Responsive component at ' + width + 'px', !g.overflow && g.logoLoaded && g.logoInsideViewport && g.squareSphere && g.buttonInsideHero && g.buttonInsideViewport, g);
      if ([360, 768, 1440].includes(width)) await p.screenshot({ path: out + '/viewport-' + width + '.png' });
    }
    await p.setViewportSize({ width: 1440, height: 1000 }); await p.evaluate(() => scrollTo(0, 0)); await wait(p);
    const axePath = path.join(root, 'runtime/qa-deps/node_modules/axe-core/axe.min.js');
    await p.addScriptTag({ path: axePath });
    const a11y = await p.evaluate(async () => (await axe.run('.ppt-hero-art', { runOnly: { type: 'tag', values: ['wcag2a', 'wcag2aa', 'wcag21aa', 'wcag22aa'] } })).violations.map(v => ({ id: v.id, impact: v.impact })));
    check('Component automated accessibility scan', a11y.length === 0, a11y);
    const logoHref = await orb.locator('a').getAttribute('href'); await orb.locator('a').click(); await p.waitForURL(url); check('Logo home link remains clickable', logoHref === url);
    await p.locator('.ppt-lux-actions a[href="/about/"]').click(); await p.waitForURL('**/about/'); check('Adjacent About CTA works', await p.locator('main').isVisible());
    await p.goto(url, { waitUntil: 'networkidle' }); await p.locator('.ppt-lux-actions a[href="/research/"]').click(); await p.waitForURL('**/research/'); check('Adjacent Research CTA works', await p.locator('main').isVisible());
    const staticContext = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 1440, height: 1000 } });
    const sp = await staticContext.newPage(); await load(sp);
    check('No-JavaScript fallback retains logo, sphere, rings and dots', await sp.locator('.ppt-orb-surface').count() === 1 && await sp.locator('.ppt-orbit-path').count() === 2 && await sp.locator('.ppt-orbit-traveller[transform]').count() === 2 && await sp.locator('.ppt-planet-orb img').isVisible() && await sp.locator('animateMotion').count() === 0 && !(await sp.locator('.ppt-orb-motion-control').isVisible()));
    check('No-JavaScript fallback has no CSS motion', await sp.locator('.ppt-hero-art').evaluate(e => e.getAnimations({ subtree: true }).length === 0));
    await sp.screenshot({ path: out + '/no-javascript.png' }); await staticContext.close();
    const reducedContext = await browser.newContext({ reducedMotion: 'reduce', viewport: { width: 768, height: 1000 } }); const rp = await reducedContext.newPage(); await load(rp);
    check('Initial reduced-motion load is static', (await state(rp)).time === 0 && (await state(rp)).animations.length === 0); await reducedContext.close();
    const touchContext = await browser.newContext({ viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true }); const tp = await touchContext.newPage(); await load(tp); await tp.locator('.ppt-planet-orb').scrollIntoViewIfNeeded(); await wait(tp);
    const touchBox = await tp.locator('.ppt-planet-orb').boundingBox(), beforeScroll = await tp.evaluate(() => scrollY), client = await touchContext.newCDPSession(tp);
    await client.send('Input.dispatchTouchEvent', { type: 'touchStart', touchPoints: [{ x: touchBox.x + touchBox.width / 2, y: touchBox.y + touchBox.height / 2 }] });
    for (let n = 1; n <= 6; n++) { await client.send('Input.dispatchTouchEvent', { type: 'touchMove', touchPoints: [{ x: touchBox.x + touchBox.width / 2, y: touchBox.y + touchBox.height / 2 - n * 25 }] }); await wait(tp, 30); }
    await client.send('Input.dispatchTouchEvent', { type: 'touchEnd', touchPoints: [] }); await wait(tp, 300);
    check('Touch swipe over component scrolls naturally without pointer depth', await tp.evaluate(() => scrollY) > beforeScroll + 40 && (await state(tp)).depth.every(v => !v || parseFloat(v) === 0)); await touchContext.close();
    check('No browser console errors or unhandled exceptions', errors.length === 0, errors);
  } catch (error) { results.push({ test: 'Suite completed', pass: false, detail: error.stack }); process.exitCode = 1; }
  finally { if (browser) await browser.close(); fs.writeFileSync(out + '/test-results.json', JSON.stringify({ timestamp: new Date().toISOString(), url, results, geometry, errors, limits: ['Visibility transitions simulated in headless Chromium; native tab switching tested separately when available.', 'Emulated devices, not physical-device performance measurements.'] }, null, 2)); }
})();
