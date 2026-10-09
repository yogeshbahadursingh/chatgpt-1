// HTTP regression check against default-deny local QA; never targets production.
const { chromium } = require('playwright');
const fs = require('fs');
const base = 'http://127.0.0.1:8877';
(async () => {
  const browser = await chromium.launch({headless:true});
  const page = await browser.newPage();
  const checks = [];
  const check = (test, pass, detail = '') => checks.push({test, status:pass?'PASS':'FAIL', detail});
  try {
    const response = await page.goto(base + '/product/demo-product-people-planet-progress/', {waitUntil:'networkidle'});
    check('Demo product remains viewable', response.status() === 200);
    check('Demo product explains purchase restriction', await page.locator('.ppt-demo-notice').filter({hasText:'Purchases are disabled'}).count() > 0);
    check('Demo product has no purchase form', await page.locator('form.cart').count() === 0);
    const products = await page.request.get(base + '/wp-json/wc/store/v1/products?slug=demo-product-people-planet-progress');
    const list = await products.json();
    const product = list[0];
    check('Store API advertises demo as not purchasable', product?.is_purchasable === false);
    if (product) {
      await page.goto(base + '/?add-to-cart=' + product.id, {waitUntil:'networkidle'});
      const cart = await page.request.get(base + '/wp-json/wc/store/v1/cart');
      const cartBody = await cart.json();
      check('Direct add-to-cart URL leaves basket empty', cartBody.items?.length === 0);
      const add = await page.request.post(base + '/wp-json/wc/store/v1/cart/add-item', {
        headers:{Nonce:cart.headers().nonce}, data:{id:product.id, quantity:1}
      });
      const addBody = await add.json();
      check('Store API add-item rejects demo', add.status() === 400 && addBody.code === 'woocommerce_rest_product_not_purchasable', `${add.status()} ${addBody.code}`);
    }
  } finally {
    await browser.close();
    fs.writeFileSync('runtime/demo-commerce-browser-results.json', JSON.stringify(checks,null,2));
    console.log(JSON.stringify(checks,null,2));
  }
  if (checks.some(x=>x.status==='FAIL')) process.exitCode=1;
})().catch(error=>{console.error(error);process.exitCode=1;});
