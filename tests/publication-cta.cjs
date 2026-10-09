// Local HTTP test. Creates only owned temporary fixtures; cleans them in finally.
const fs = require('fs');
const {execFileSync} = require('child_process');
const {chromium} = require('playwright');
const cli = action => execFileSync('C:/xampp/php/php.exe', ['runtime/wp-cli.phar','--path=runtime/reinstall/wordpress','eval-file','tests/publication-cta-fixtures.php',action], {encoding:'utf8'});
(async()=>{
  let browser;
  const checks=[];
  const check=(test,pass,detail='')=>checks.push({test,status:pass?'PASS':'FAIL',detail});
  try {
    cli('create');
    const fixtures=JSON.parse(fs.readFileSync('runtime/publication-cta-fixtures.json','utf8'));
    browser=await chromium.launch({headless:true});
    const page=await browser.newPage();
    for(const [name,f] of Object.entries(fixtures.cases)) {
      const response=await page.goto(f.url,{waitUntil:'domcontentloaded'});
      check(`${name}: editorial route renders`,response.status()===200);
      const links=await page.locator('main a.wp-block-button__link').evaluateAll(nodes=>nodes.map(a=>({text:a.textContent.trim(),url:a.href})));
      const text=await page.locator('main').innerText();
      const expected={paid:'Purchase',free:'Get free resource',demo:'Preview demonstration',unavailable:'View product details'}[name];
      check(`${name}: accurate product destination and CTA`, expected ? links.some(a=>a.text===expected&&a.url===f.product_url) : links.length===0, JSON.stringify(links));
      check(`${name}: stale editorial price is not displayed`,!text.includes('$999'));
      if(name==='paid') {
        check('Paid product uses Woo sale price and currency',await page.locator('main .woocommerce-Price-amount').filter({hasText:'9.00'}).count()>0);
      }
      if(name==='free') check('Free product uses Woo zero price',await page.locator('main .woocommerce-Price-amount').filter({hasText:'0.00'}).count()>0);
      if(name==='demo') {
        await page.goto(f.product_url,{waitUntil:'domcontentloaded'});
        check('Demo destination is a preview with checkout unavailable',await page.locator('.ppt-demo-notice').filter({hasText:'Purchases are disabled'}).count()>0&&await page.locator('form.cart').count()===0);
      }
    }
  } finally {
    if(browser) await browser.close();
    console.log(cli('cleanup'));
    fs.writeFileSync('runtime/publication-cta-results.json',JSON.stringify(checks,null,2));
    console.log(JSON.stringify(checks,null,2));
  }
  if(checks.some(c=>c.status==='FAIL')) process.exitCode=1;
})().catch(e=>{console.error(e);process.exitCode=1;});
