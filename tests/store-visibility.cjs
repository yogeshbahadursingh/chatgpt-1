// Request-scoped store/whole-site modes; creates and finally removes only owned local fixtures.
const fs=require('fs'),path=require('path'),crypto=require('crypto');
const {execFileSync}=require('child_process');
const {chromium}=require('playwright');
const runtime=path.resolve('ppt-wordpress/runtime'),token=crypto.randomBytes(12).toString('hex');
const muFile=path.join(runtime,`reinstall/wordpress/wp-content/mu-plugins/qa-store-${token}.php`);
const checks=[];let originalSettings;
const check=(name,pass,details={})=>checks.push({name,status:pass?'PASS':'FAIL',...details});
function fixtures(mode){return JSON.parse(execFileSync('C:/xampp/php/php.exe',[path.join(runtime,'wp-cli.phar'),'--path='+path.join(runtime,'reinstall/wordpress'),'eval-file',path.resolve('ppt-wordpress/tests/store-visibility-fixtures.php')],{encoding:'utf8',timeout:120000,env:{...process.env,PPT_QA_STORE_TOKEN:token,PPT_QA_STORE_MODE:mode}}));}
(async()=>{
 let browser;
 try{
  const fixture=fixtures('create');originalSettings=fixture.settings;
  const mu=`<?php
if(isset($_SERVER['HTTP_X_PPT_QA_STORE_MODE']) && isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1'),true)){
 $parts=explode(':',(string)$_SERVER['HTTP_X_PPT_QA_STORE_MODE'],2);$mode=$parts[1]??'';
 if(($parts[0]??'')==='${token}' && in_array($mode,array('live','store','site','manager','preview'),true)){
  add_filter('pre_option_woocommerce_coming_soon',function()use($mode){return $mode==='live'?'no':'yes';});
  add_filter('pre_option_woocommerce_store_pages_only',function()use($mode){return $mode==='site'?'no':'yes';});
  add_filter('pre_option_woocommerce_private_link',function()use($mode){return $mode==='preview'?'yes':'no';});
  if($mode==='preview')add_filter('pre_option_woocommerce_share_key',function(){return '${token}';});
  if($mode==='manager')add_action('plugins_loaded',function(){wp_set_current_user(1);},0);
  add_action('pre_get_posts',function($q){if($q->is_main_query()&&$q->is_tax(array('ppt_subject_area','ppt_publication_type'))){$q->set('posts_per_page',5);$q->set('orderby',array('date'=>'DESC','ID'=>'DESC'));}},100);
  add_action('template_redirect',function(){global $wp_query;header('X-PPT-QA-Prelaunch: '.(ppt_store_prelaunch_for_visitor()?'yes':'no'));header('X-PPT-QA-Found: '.$wp_query->found_posts);header('X-PPT-QA-Pages: '.$wp_query->max_num_pages);},99);
 }
}
`;
  fs.writeFileSync(muFile,mu,{flag:'wx'});
  browser=await chromium.launch({headless:true});const context=await browser.newContext({javaScriptEnabled:false});await context.route('**/*',r=>r.abort());const page=await context.newPage();
  async function visit(url,mode){const response=await fetch(url,{headers:{'X-PPT-QA-Store-Mode':`${token}:${mode}`},signal:AbortSignal.timeout(60000)});const html=await response.text();await page.setContent(html,{waitUntil:'domcontentloaded'});return{response,html,gated:await page.locator('meta[name="woo-coming-soon-page"]').count()>0};}
  for(const [taxonomy,base]of Object.entries(fixture.terms)){
   for(const mode of ['store','live']){
    const expected=[...fixture.editorial,...(mode==='live'?[fixture.products.visible]:[])];let url=base;const found=[];
    for(let n=1;n<=3;n++){
     const r=await visit(url,mode);const urls=await page.locator('main .ppt-pub-card h2 a').evaluateAll(nodes=>nodes.map(a=>a.getAttribute('href')));found.push(...urls);
     check(`${taxonomy} ${mode} page ${n} stays editorial-accessible`,r.response.status===200&&!r.gated&&!/Fatal error|Warning:|Parse error/.test(r.html)&&urls.length===(n<3?5:expected.length-10));
     check(`${taxonomy} ${mode} page ${n} query counts`,Number(r.response.headers.get('x-ppt-qa-found'))===expected.length&&Number(r.response.headers.get('x-ppt-qa-pages'))===3);
     if(n<3){url=await page.locator('.pagination a.next').getAttribute('href');if(!url)throw Error('Missing shared taxonomy next page');}
    }
    check(`${taxonomy} ${mode} exact membership and no repeats`,new Set(found).size===found.length&&JSON.stringify([...found].sort())===JSON.stringify([...expected].sort()),{actual:found.length,expected:expected.length});
    check(`${taxonomy} ${mode} hides catalog-hidden product`,!found.includes(fixture.products.hidden));
   }
   const whole=await visit(base,'site');check(`${taxonomy} whole-site remains gated`,whole.gated&&await page.locator('main .ppt-pub-card').count()===0);
  }
  for(const url of [fixture.shop,fixture.products.visible]){const r=await visit(url,'store');check(`${new URL(url).pathname} native store stays gated`,r.gated&&!r.html.includes('QA product visible</h1>'));}
  const editorial=await visit(fixture.editorial[0],'store');check('editorial single remains accessible in store-only mode',!editorial.gated&&await page.locator('h1').textContent()==='QA editorial 01');
  const publications=await visit(fixture.publications,'store');const cards=await page.locator('main section .ppt-pub-card>a').evaluateAll(nodes=>nodes.map(a=>a.getAttribute('href')));check('Publications uses editorial cards during store prelaunch',!publications.gated&&cards.length>0&&cards.every(url=>!url.includes('/product/')));
  const home=await visit(fixture.home,'site');check('whole-site mode protects homepage',home.gated);
  for(const mode of ['manager','preview']){const url=new URL(fixture.terms.ppt_publication_type);if(mode==='preview')url.searchParams.set('woo-share',token);const r=await visit(url,mode);check(`${mode} visitor may preview store`,!r.gated&&r.response.headers.get('x-ppt-qa-prelaunch')==='no'&&Number(r.response.headers.get('x-ppt-qa-found'))===15);}
  const invalid=new URL(fixture.terms.ppt_publication_type);invalid.searchParams.set('woo-share','invalid');const invalidPreview=await visit(invalid,'preview');check('invalid preview token does not reveal products',invalidPreview.response.headers.get('x-ppt-qa-prelaunch')==='yes'&&Number(invalidPreview.response.headers.get('x-ppt-qa-found'))===14);
 }finally{
  if(browser)await browser.close();if(fs.existsSync(muFile))fs.unlinkSync(muFile);const cleanup=fixtures('cleanup');
  check('owned visibility fixtures removed',cleanup.deleted.length===16&&cleanup.remaining.length===0&&cleanup.terms_removed,{deleted:cleanup.deleted.length});
  check('global store settings unchanged',JSON.stringify(cleanup.settings)===JSON.stringify(originalSettings));
  fs.writeFileSync(path.join(runtime,'store-visibility-results.json'),JSON.stringify({checks,cleanup:{deleted:cleanup.deleted.length,remaining:cleanup.remaining.length,terms_removed:cleanup.terms_removed,request_override_removed:!fs.existsSync(muFile)}},null,2));
 }
 console.log(JSON.stringify(checks,null,2));if(checks.some(c=>c.status==='FAIL'))process.exitCode=1;
})().catch(error=>{console.error(error);process.exitCode=1;});
