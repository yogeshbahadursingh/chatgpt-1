// Creates/deletes only uniquely tagged local fixtures. Requires the isolated QA installation.
const fs = require('fs');
const path = require('path');
const crypto = require('crypto');
const {execFileSync} = require('child_process');
const {chromium} = require('playwright');
const token = crypto.randomBytes(12).toString('hex');
const runtime = path.resolve('ppt-wordpress/runtime');
const muDirectory = path.join(runtime,'reinstall/wordpress/wp-content/mu-plugins');
const muFile = path.join(muDirectory,`qa-archive-${token}.php`);
const checks = [];
let cleanup;
function fixtures(mode) {
  return JSON.parse(execFileSync('C:/xampp/php/php.exe', [path.join(runtime,'wp-cli.phar'),'--path='+path.join(runtime,'reinstall/wordpress'),'eval-file',path.resolve('ppt-wordpress/tests/archive-journey-fixtures.php')], {encoding:'utf8',timeout:120000,env:{...process.env,PPT_QA_ARCHIVE_TOKEN:token,PPT_QA_ARCHIVE_MODE:mode}}));
}
function check(name,passed,details={}) {checks.push({name,status:passed?'PASS':'FAIL',...details});}
(async () => {
  let browser;
  try {
    const fixture = fixtures('create');
    browser = await chromium.launch({headless:true});
    const context = await browser.newContext({javaScriptEnabled:false});
    await context.route('**/*',route=>route.abort());
    const page = await context.newPage();
    async function visit(url,headers={}) {
      const response = await fetch(url,{headers,signal:AbortSignal.timeout(60000)});
      const html = await response.text();
      await page.setContent(html,{waitUntil:'domcontentloaded'});
      return {response,html};
    }
    for (const status of ['', 'planning']) {
      const expected = fixture.projects.filter(p=>!status||['planned','planning'].includes(p.status)).map(p=>p.url);
      const first = new URL(fixture.base);first.searchParams.set('ppt_topic',fixture.topic);if(status)first.searchParams.set('status',status);
      const seen=[];let url=first.href;
      for (let number=1;number<=2;number++) {
        const {response,html}=await visit(url);
        const urls=await page.locator('.ppt-project-card h2 a').evaluateAll(nodes=>nodes.map(n=>n.getAttribute('href')));
        check(`${status||'all'} topic page ${number} exact membership`, response.status===200&&!/Fatal error|Warning:|Parse error/.test(html)&&JSON.stringify(urls)===JSON.stringify(expected.slice((number-1)*12,number*12)),{expected:expected.slice((number-1)*12,number*12).length,actual:urls.length});
        seen.push(...urls);
        const pagination=await page.locator('.pagination a').evaluateAll(nodes=>nodes.map(n=>n.getAttribute('href')));
        check(`${status||'all'} page ${number} preserves filters`,pagination.length>0&&pagination.every(href=>{const link=new URL(href);return link.searchParams.get('ppt_topic')===String(fixture.topic)&&(!status||link.searchParams.get('status')===status);}));
        if(number===1){url=await page.locator('.pagination a.next').getAttribute('href');if(!url)throw Error('Missing next-page link');}
      }
      check(`${status||'all'} pages complete with no repeated projects`,seen.length===expected.length&&new Set(seen).size===seen.length&&JSON.stringify(seen)===JSON.stringify(expected));
    }
    // This exact-header override applies only to our request and never changes active_plugins.
    const mu=`<?php\nif(isset($_SERVER['HTTP_X_PPT_QA_NO_WOO']) && hash_equals('${token}',(string)$_SERVER['HTTP_X_PPT_QA_NO_WOO']) && isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1'),true)){add_filter('option_active_plugins',function($plugins){return array_values(array_diff($plugins,array('woocommerce/woocommerce.php')));});add_action('send_headers',function(){header('X-PPT-QA-Commerce: '.(function_exists('wc_get_products')?'enabled':'disabled'));});}\n`;
    fs.writeFileSync(muFile,mu,{flag:'wx'});
    const fallback=await visit(fixture.publications_url,{'X-PPT-QA-No-Woo':token});
    check('publications without WooCommerce renders',fallback.response.status===200&&fallback.response.headers.get('x-ppt-qa-commerce')==='disabled'&&!/Fatal error|Warning:|Parse error/.test(fallback.html));
    const groups=await page.locator('main section').evaluateAll(sections=>sections.map(section=>({heading:section.querySelector('h2')?.textContent,urls:[...section.querySelectorAll('.ppt-pub-card > a')].map(a=>a.getAttribute('href'))})));
    const formatGroups=['Books','E-books','Research Reports','Policy Briefs','Free Resources'];
    const allFormatUrls=[];
    for(const heading of formatGroups){const group=groups.find(g=>g.heading===heading);const eligible=fixture.publications.filter(p=>p.types.includes(heading)).map(p=>p.url);const urls=group?.urls||[];check(`no-Woo ${heading} contains its editorial type`,urls.length===Math.min(3,eligible.length)&&urls.every(url=>eligible.includes(url)),{expected:Math.min(3,eligible.length),actual:urls.length});allFormatUrls.push(...urls);}
    check('no-Woo format sections do not repeat the same cards',new Set(allFormatUrls).size===allFormatUrls.length);
    const normal=await visit(fixture.publications_url);
    check('ordinary requests still use WooCommerce',normal.response.status===200&&normal.response.headers.get('x-ppt-qa-commerce')===null&&(await page.locator('main section .ppt-pub-card > a').first().getAttribute('href')).includes('/product/'));
  } finally {
    if(browser)await browser.close();
    if(fs.existsSync(muFile))fs.unlinkSync(muFile);
    cleanup=fixtures('cleanup');
    check('temporary fixtures removed',cleanup.remaining.length===0&&cleanup.term_removed,{deleted:cleanup.deleted.length});
    fs.writeFileSync(path.join(runtime,'archive-journey-results.json'),JSON.stringify({checks,cleanup:{deleted:cleanup.deleted.length,remaining:cleanup.remaining.length,term_removed:cleanup.term_removed,request_override_removed:!fs.existsSync(muFile)}},null,2));
  }
  console.log(JSON.stringify(checks,null,2));
  if(checks.some(c=>c.status==='FAIL'))process.exitCode=1;
})().catch(error=>{console.error(error);process.exitCode=1;});
