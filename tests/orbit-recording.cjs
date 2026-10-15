// Optional real tab-visibility check and a short browser recording. Local staging only.
const fs = require('fs'), path = require('path'), { execFileSync } = require('child_process'), { chromium } = require('playwright');
const root = path.resolve(__dirname, '..'), out = path.join(root, 'runtime/orbit');
const results = [], url = process.env.PPT_TEST_URL || 'http://127.0.0.1:8877/';
function check(test, pass, detail) { results.push({ test, pass: !!pass, detail }); console.log(test + ': ' + !!pass); if (!pass) throw Error(test); }
const state = p => p.evaluate(() => { const e = document.querySelector('.ppt-hero-art'); return { hidden: document.hidden, motion: e.dataset.motion, manual: e.dataset.manualPause, time: e.querySelector('svg').getCurrentTime() }; });
(async () => {
  let browser;
  try {
    browser = await chromium.launch({ channel: 'msedge', headless: false, args: ['--window-position=-2400,-2400'] });
    const context = await browser.newContext({ viewport: { width: 1440, height: 1000 }, reducedMotion: 'no-preference' });
    const p = await context.newPage(); await p.goto(url, { waitUntil: 'networkidle', timeout: 90000 }); await p.bringToFront(); await p.waitForTimeout(500);
    check('Real active browser tab runs ambient motion', !(await state(p)).hidden && (await state(p)).motion === 'running');
    const other = await context.newPage(); await other.goto('about:blank'); await other.bringToFront(); await p.waitForTimeout(500);
    const hidden = await state(p); await p.waitForTimeout(400);
    if (hidden.hidden) {
      check('Real background tab suspends SVG clock', hidden.motion === 'paused' && Math.abs((await state(p)).time - hidden.time) < .02, hidden);
      await p.bringToFront(); await p.waitForTimeout(500); check('Real tab return resumes ambient motion', !(await state(p)).hidden && (await state(p)).motion === 'running');
      await p.locator('.ppt-orb-motion-control').click(); await other.bringToFront(); await p.waitForTimeout(300); await p.bringToFront(); await p.waitForTimeout(300);
      check('Real tab return respects manual pause', (await state(p)).manual === 'true' && (await state(p)).motion === 'paused');
    } else {
      results.push({ test: 'Real background-tab suspension and return', status: 'unverified', detail: 'This automated Edge session kept the original page document.hidden=false after another tab was brought to front. The separate component suite verifies the visibilitychange handler with controlled hidden/visible values.' });
      console.log('Native background-tab visibility unavailable in this session; recorded as unverified.');
    }
    await context.close();
    const recording = await browser.newContext({ viewport: { width: 1440, height: 1000 }, reducedMotion: 'no-preference', recordVideo: { dir: out + '/raw-video', size: { width: 1440, height: 1000 } } });
    const rp = await recording.newPage(); await rp.goto(url, { waitUntil: 'networkidle', timeout: 90000 }); await rp.bringToFront();
    const orb = await rp.locator('.ppt-planet-orb').boundingBox();
    await rp.waitForTimeout(8000);
    await rp.mouse.move(orb.x + orb.width * .82, orb.y + orb.height * .25, { steps: 20 }); await rp.waitForTimeout(3500);
    await rp.mouse.move(50, 150, { steps: 20 }); await rp.waitForTimeout(1500);
    const button = rp.locator('.ppt-orb-motion-control'); await button.click(); await rp.waitForTimeout(3500); await button.click(); await rp.waitForTimeout(4500);
    const video = rp.video(); await recording.close(); const raw = await video.path();
    const ffmpegRoot = process.env.LOCALAPPDATA + '/ms-playwright';
    const ffmpegDir = fs.readdirSync(ffmpegRoot).find(x => x.startsWith('ffmpeg-'));
    if (!ffmpegDir) throw Error('Playwright FFmpeg unavailable; raw browser recording retained: ' + raw);
    const ffmpeg = path.join(ffmpegRoot, ffmpegDir, 'ffmpeg-win64.exe');
    execFileSync(ffmpeg, ['-y', '-sseof', '-20', '-i', raw, '-c:v', 'libvpx', '-b:v', '1100k', '-an', out + '/orbit-demo.webm'], { windowsHide: true, stdio: 'pipe', timeout: 120000 });
    check('20-second browser recording saved', fs.statSync(out + '/orbit-demo.webm').size > 10000);
  } catch (error) { results.push({ test: 'Native tab/recording suite completed', pass: false, detail: error.message }); process.exitCode = 1; }
  finally { if (browser) await browser.close(); fs.writeFileSync(out + '/native-tab-recording-results.json', JSON.stringify({ timestamp: new Date().toISOString(), results }, null, 2)); }
})();
